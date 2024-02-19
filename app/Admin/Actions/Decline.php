<?php

namespace App\Admin\Actions;


use App\Models\Employee;
use App\Models\User;
use App\Notifications\DeclineNotification;
use Illuminate\Support\Facades\Notification;
use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Decline extends RowAction
{
    public $name = 'decline';

    public $icon = 'icon-times-circle';
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
        $model->status = 'Declined';
        $model->save();

        $employee = Employee::where('id',$model->employee_id)->first();
        $user = User::where('id', $employee->user_id)->first();

        Notification::sendNow($user, new DeclineNotification());
        return $this->response()->success('Success message.')->refresh();
    }
    public function dialog()
    {
        $this->question('Are you sure to Decline this Booking?', 'This will Decline all the booking', ['icon'=>'question','confirmButtonText'=>'Yes']);
    }


}
