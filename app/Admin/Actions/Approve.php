<?php

namespace App\Admin\Actions;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\ApprovalNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Approve extends RowAction
{
    use Notifiable;

    public $name = 'approve';

    public $icon = 'icon-check-circle';

    public function name()
    {
        return __('admin.approve');
    }

    public function authorize($user, $model)
    {
        if (!$user->isApprover()){
            return false;
        }else{
            return true;
        }

    }

    public function handle(Model $model)
    {
        // $model ...
        $model->status = 'Approved';
        $model->save();
        $user = auth()->user();
//        $approver = User::where('id',$employee->approver_id)->first();
        $employee = Employee::where('id',$model->employee_id)->first();
        $user = User::where('id', $employee->user_id)->first();

        Notification::sendNow($user, new ApprovalNotification());

        return $this->response()->success('Success message.')->refresh();

    }


    public function dialog()
    {
        $this->question('Are you sure to Approve this row?', 'This will Approve all the booking', ['icon'=>'question','confirmButtonText'=>'Yes']);
    }

//$form->saved(function (Form $form) {
//    $user = auth()->user();
//    Notification::sendNow($user, new BookingNotification($form));
////
//});
}
