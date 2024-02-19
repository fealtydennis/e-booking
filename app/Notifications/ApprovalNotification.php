<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;


class ApprovalNotification extends Notification
{
    use Queueable;

//
    private Model $model;


    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
//        $this->model=$model;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
//        $status = Booking::where('status')->first();
        return (new MailMessage)
            ->subject('Your Travel has been Approved')
                    ->line('Hello ' .$notifiable->name)
                    ->line( 'Your Travel has been Approved')
                    ->action('View Your Travel', url('/e-bookings/bookings/id'))
                    ->line('Thank you for using our application!')

        ->cc(['victor.onyango@team11degrees.com', 'gilbert.muia@team11degrees.com']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
