<?php

namespace App\Admin\Actions;

use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Decline extends RowAction
{
    public $name = 'decline';

    public $icon = 'icon-times-circle';

    public function handle(Model $model)
    {
        // $model ...
        $model->status = 'Declined';
        $model->save();


        return $this->response()->success('Success message.')->refresh();
    }
    public function dialog()
    {
        $this->question('Are you sure to Decline this Booking?', 'This will Decline all the booking', ['icon'=>'question','confirmButtonText'=>'Yes']);
    }


}
