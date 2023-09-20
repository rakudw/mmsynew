<?php

namespace App\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\IncompleteApplicationEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\IncompleteApplicationNotification;

class IncompleteApplicationListener implements ShouldQueue
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
     * @param  \App\Events\IncompleteApplicationEvent  $event
     * @return void
     */
    public function handle(IncompleteApplicationEvent $event)
    {
        $this->getUser()->notify(new IncompleteApplicationNotification($event->application));
    }

    public function getUser():User
    {
        return auth()->user();
    }
}
