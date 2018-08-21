<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegistrationWelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $tenant;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tenant)
    {
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
                    ->subject('Welcome To Client Management Pro.')
                    ->greeting('Hi! '. $this->tenant->name)
                    ->line('You Have Successfully Created An Account.')
                    ->line('Your Account Details:')
                    ->line('username: '. $this->tenant->email)
                    ->action('Login', url('/login'))
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
