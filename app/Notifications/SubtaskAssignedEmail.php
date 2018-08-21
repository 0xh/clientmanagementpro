<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class SubtaskAssignedEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $subtask;

    public $tenant;

    public $employee;

     /* Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subtask,$tenant,$employee)
    {
        $this->subtask = $subtask;
        $this->tenant = $tenant;
        $this->employee = $employee;
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
                    ->subject('A New Task Has Been Assigned To You by: ' .$this->tenant->name)
                    ->greeting('Good Day! '. $this->employee->name . '.')
                    ->line('Your New Task:')
                    ->line('Task Name: '.$this->subtask->name)
                    ->line('Due Date: '.Carbon::parse($this->subtask->due_date)->format('Y-m-d'))
                    ->action('View Your Task', url('/team/dashboard/jobs/'.$this->subtask->task_id));
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
