<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    /**
     * The application instance.
     *
     * @var \App\Models\Application
     */

    public $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("[{$this->application->unique_id}] Application is {$this->application->status->name}")
            ->markdown('mail.applications.status', ['application' => $this->application]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => "{$this->application->unique_id} is {$this->application->status->name}",
            'description'   => "Application status is <b>{$this->application->status->name}</b>.",
            'link' => route('application.view', $this->application->id)
        ];
    }
}
