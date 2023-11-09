<?php

namespace App\Helpers;

use App\Enums\ApplicationStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Application;
use App\Models\User;
use App\Models\Enum;
use App\Models\Form;
use Illuminate\Support\Facades\DB;
use App\Models\FormDesign;

class ApplicationHelper extends BaseHelper
{

    /**
     * Get the applications belonging to the logged in user.
     *
     * @return \App\Models\Application[]
     */
    public static function getApplications() {
        // get applications created by the current user
        $applications = Application::where('created_by', auth()->id());
        // get applications with email/phone of the current user
        if(auth()->user()->email) {
            $applications->union(Application::where('data->owner->email', auth()->user()->email));
        }
        if(auth()->user()->mobile) {
            $applications->union(Application::where('data->owner->mobile', auth()->user()->mobile));
        }
        return $applications->get();
    }

    public static function save(Application $application, Form $form, FormDesign $formDesign, object $data) {
        if($application->id > 0) {
            $dataJson = is_string($application->data) ? json_decode($application->data) : $application->data;
            $dataJson->{$formDesign->slug} = $data;
            $updateData = ['data' => $dataJson];
            if ($formDesign->order == 0) {
                if (isset($data->name)) {
                    $updateData['name'] = $data->name;
                }
                foreach(['district_id', 'constituency_id', 'tehsil_id', 'tehsil_id'] as $column) {
                    if(property_exists($data, $column)) {
                        $updateData['region_id'] = $data->$column;
                        break;
                    }
                }
            }
            $application->update($updateData);
        } else {
            $regionId = null;

            foreach (['district_id', 'constituency_id', 'tehsil_id', 'tehsil_id'] as $column) {
                if (property_exists($data, $column)) {
                    $regionId = $data->$column;
                    break;
                }
            }
            $application->fill([
                'name' => $data->name,
                'form_id' => $form->id,
                'data' => (object)[$formDesign->slug => $data],
                'region_id' => $regionId,
                'status_id' => Enum::where([
                    'type' => 'APPLICATION_STATUS',
                    'name' => 'Incomplete'
                ])->value('id')
            ]);
            $application->save();
        }
        return $application;
    }

    public static function getApplicationActions(Application $application):array {
        $actions = [];
        $currentUser = self::currentUser();
        $roles = $currentUser->roles()->select('roles.id', 'name')->get();
        foreach($roles as $role) {
            switch($role->name) {
                case RoleEnum::NODAL_DIC->name:
                    switch ($application->application_status) {
                        case ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER:
                            $actions[ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id()] = 'Send to Bank for Viability and Feasibility Comments';
                            $actions[ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT->id()] = 'Revert back to the Applicant';
                            break;
                        case ApplicationStatusEnum::LOAN_REJECTED:
                            $actions[ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id()] = 'Send to Bank for Loan Disbursement';
                            $actions[ApplicationStatusEnum::REJECTED_AT_DISTRICT_INDUSTRIES_CENTER->id()] = 'Reject the Application';
                            break;
                    }
                    break;
                case RoleEnum::GM_DIC->name:
                    switch ($application->application_status) {
                        case ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST:
                            $actions[ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id()] = 'Send to Nodal Bank for 60% Subsidy Release';
                            $actions[ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id()] = 'Revert Back to the Bank';
                            break;
                        case ApplicationStatusEnum::PENDING_40_SUBSIDY_REQUEST:
                            $actions[ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id()] = 'Send to Nodal Bank for 40% Subsidy Release';
                            break;
                        case ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE:
                            $actions[ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id()] = 'Send to Bank for Loan Disbursement';
                            $actions[ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id()] = 'Reject the Application';
                            break;
                    }
                    break;
                case RoleEnum::EO_DIC->name:
                    switch ($application->application_status) {
                        case ApplicationStatusEnum::SUBSIDY_60_RELEASED:
                            $actions[ApplicationStatusEnum::PENDING_40_SUBSIDY_REQUEST->id()] = 'Send to DIC for 40% Subsidy Request';
                            break;
                    }
                    break;
                case RoleEnum::BANK_MANAGER->name:
                    switch ($application->application_status) {
                        case ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS:
                            $actions[ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id()] = 'Comment on Viability and Feasibility';
                            break;
                        case ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT:
                            $actions[ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id()] = 'Sanction & Disburse the Loan';
                            $actions[ApplicationStatusEnum::LOAN_REJECTED->id()] = 'Reject the Loan';
                            break;
                    }
                    break;
                case RoleEnum::NODAL_BANK->name:
                    switch ($application->application_status) {
                        case ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE:
                            $actions[ApplicationStatusEnum::SUBSIDY_60_RELEASED->id()] = 'Release 60% Subsidy';
                            // $actions[ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id()] = 'Revert Back To DIC';
                            break;
                        case ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE:
                            $actions[ApplicationStatusEnum::SUBSIDY_40_RELEASED->id()] = 'Release 40% Subsidy';
                            break;
                    }
                    break;
            }
        }
        if($application->created_by == $currentUser->id || $application->data->owner->email == $currentUser->email || $application->data->owner->mobile == $currentUser->mobile) {
            if($application->status_id == ApplicationStatusEnum::LOAN_DISBURSED->id() && !$application->getData('subsidy', 'amount40')) {
                $actions[ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id()] = 'Request for 40% Subsidy Release';
            }
            if($application->status_id < ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id()) {
                $actions[ApplicationStatusEnum::WITHDRAWN->id()] = 'Withdraw';
            }
        }

        return $actions;
    }
    public static function getBranchEmail($branchId) {
        $userId = DB::table('user_roles')
        ->select('user_id')
        ->where('role_id', 5)
        ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(metadata, '$.bank_branch_ids'))) LIKE ?", ['%' . strtolower($branchId) . '%'])
        ->get()->map(function ($result) {
            return $result->user_id;
        })->all();
        if($userId){
            $emails =  User::select('email')->whereIn('id',$userId)->get()->toArray();
           return $emails;
        }else{
            return [];
        }
    }
}