<?php

namespace App\Policies;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Application $application)
    {
        return $user->roles()->count() >= 1 ?: $user->id === $application->created_by;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    public function submit(User $user, Application $application) {
        if(!$application->id) {
            return false;
        }
        if(in_array($application->application_status, [ApplicationStatusEnum::INCOMPLETE, ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT])) {
            return $application->created_by == $user->id || $application->getData('owner', 'mobile') == $user->mobile || $application->getData('owner', 'email') == $user->email;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Application $application)
    {
        if(!$application->id || $user->isSuperAdmin() || $application->application_status == ApplicationStatusEnum::INCOMPLETE) {
            return true;
        }

        if($user->isApplicant() && $application->application_status == ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT) {
            return true;
        }
        if($user->isGm())
        {
            if($application->application_status == ApplicationStatusEnum::LOAN_REJECTED || $application->application_status == ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE || $application->application_status == ApplicationStatusEnum::LOAN_DISBURSED || $application->application_status == ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST || $application->application_status == ApplicationStatusEnum::SUBSIDY_60_RELEASED){
                return true;
            }
        }
        // if($user->isEO())
        // {
        //     if($application->application_status == ApplicationStatusEnum::SUBSIDY_60_RELEASED){
        //         return true;
        //     }
        // }

        if($user->canScheduleMeeting() && $application->application_status == ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE) {
            return true;
        }

        return Application::pendingApplications()->forCurrentUser()->where('id', $application->id)->count() > 0;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Application $application)
    {
        return $user->id === $application->created_by && ($application->status_id <= ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Application $application)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Application $application)
    {
        //
    }
}
