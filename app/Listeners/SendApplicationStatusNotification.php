<?php

namespace App\Listeners;

use App\Enums\ApplicationStatusEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\Events\ApplicationStatusEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ApplicationStatusNotification;

class SendApplicationStatusNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ApplicationStatusEvent  $event
     * @return void
     */
    public function handle(ApplicationStatusEvent $event)
    {
        $user = User::find($event->application->applicant->id);
        $user->notify(new ApplicationStatusNotification($event->application));

        // If application is @DLC Notify GM, Managers and EOs
        if(in_array($event->application->status->id, [ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER->id()])) {
            $userIds = DB::table('user_roles')->select('user_id')
                ->whereIn('role_id', [RoleEnum::NODAL_DIC->value])
                ->whereJsonContains('metadata->district_ids', $event->application->getData('enterprise', 'district_id'))->get()
                ->map(function ($result) {
                    return $result->user_id;
                })->all();

            $dicNodals = User::whereIn('id', $userIds)->get();
            Notification::send($dicNodals, new ApplicationStatusNotification($event->application));
        } // Check if application is pending/waiting for bank approval. Notify RO/Manager/Nodal
        // If application is @DLC Notify GM, Managers and EOs
        if(in_array($event->application->status->id, [ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id()])) {
            $userIds = DB::table('user_roles')->select('user_id')
                ->whereIn('role_id', [RoleEnum::GM_DIC->value])
                ->whereJsonContains('metadata->district_ids', $event->application->getData('enterprise', 'district_id'))->get()
                ->map(function ($result) {
                    return $result->user_id;
                })->all();

            $gms = User::whereIn('id', $userIds)->get();
            Notification::send($gms, new ApplicationStatusNotification($event->application));
        } // Check if application is pending/waiting for bank approval. Notify RO/Manager/Nodal
        if (in_array($event->application->status->id, [ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS, ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT])) {
            $bankManagerIds = DB::table('user_roles')->select('user_id')
                ->whereIn('role_id', [4,6,7])
                ->whereJsonContains('metadata->bank_branch_ids', $event->application->getData('finance', 'bank_branch_id'))->get()
                ->map(function ($result) {
                    return $result->user_id;
                })->all();

            $bankers = User::whereIn('id', $bankManagerIds)->get();
            Notification::send($bankers, new ApplicationStatusNotification($event->application));
        }
    }
}
