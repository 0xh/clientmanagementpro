<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClientRegistrationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $tenant;

    public $client;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tenant, $client)
    {
        $this->tenant = $tenant;
        $this->client = $client;
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
                    ->subject('Welcome '. $this->client->name . ' to Client Management Pro!')
                    ->greeting('Hi! ' .$this->client->name)
                    ->line('You Account Has Been Provided By: '. $this->tenant->name)
                    ->line('You Can View All Your Project Progress At Your Back Office')
                    ->line('Your Account Details:')
                    ->line('username: ' . $this->client->email)
                    ->action('Login', url('/'))
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
