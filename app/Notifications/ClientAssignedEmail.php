<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClientAssignedEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $project;

    public $tenant;
    
    public $client;


    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project,$client,$tenant)
    {
        $this->project = $project;
        $this->client = $client;
        $this->tenant = $tenant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                ->subject('View The Progress Of Your Project: '. $this->project->name)
                ->greeting('Hi! '. $this->client->name . '.')
                ->line('A New Project has Been Assigned To You By: '. $this->tenant->name)
                ->line('Click The Button Below To View The Progress Of This Project.')
                ->action($this->project->name, url('/client/dashboard/clients/'.$this->project->id))
                ->line('We Dont Send Any Password in Email')
                ->line('Or Ask For Your Password For Security Purposes.')
                ->line('You may Reset Password using The Username Above')
                ->line('Click The Link Below To Reset Password:')
                ->line(url('/client/password/reset'));
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
            //
        ];
    }
}
