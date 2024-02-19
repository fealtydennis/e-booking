<?php

namespace App\Notifications;

use App\Models\Destination;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use OpenAdmin\Admin\Form;

class BookingNotification extends Notification
{
    use Queueable;
    public $form;

    /**
     * Create a new notification instance.
     */
    public function __construct(Form $form)
    {
        //
        $this->form=$form;
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
        $approve=User::select('name')->get();
//        $employee=Employee::where('id', $this->form->input('employee_id'))->first();
        if($this->form->input('employee_id')){
            $employee = Employee::where('id',$this->form->input('employee_id'))->first();
        }else{
            $employee = Employee::where('user_id',auth()->user()->id)->first();
        }
        $departure=Destination::where('id', $this->form->input('departure_id_1'))->orWhere('id', $this->form->input('departure_id_2'))->orWhere('id', $this->form->input('departure_id_3'))->first();
        $destination=Destination::where('id', $this->form->input('destination_id_1'))->orWhere('id', $this->form->input('destination_id_2'))->orWhere('id', $this->form->input('destination_id_3'))->first();
        return (new MailMessage)
                    ->line('Hello '. $notifiable->name)
                    ->line('A new travel request awaits your approval. The requester details are:')
                    ->line('Employee Name: '. $employee->first_name .' '. $employee->last_name)
                    ->line('Travel Reason: '. $this->form->input('reason'))
                    ->line('Departure Location: '. $departure->name)
                    ->line('Destination Location: '. $destination->name)
                    ->line('Start Date: '. $this->form->start_date)
                    ->line('End Date: '. $this->form->end_date)
                    ->line('Kindly click on the button below to approve/decline the Booking')
                    ->action('View Booking', url('/e-bookings'))
                    ->line('Thank you for using our application!')

        ->cc(['victor.onyango@team11degrees', 'gilbert.muia@team11degrees.com']);



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
