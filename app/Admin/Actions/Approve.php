<?php

namespace App\Admin\Actions;

use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Approve extends RowAction
{
    public $name = 'approve';

    public $icon = 'icon-check-circle';

    public function handle(Model $model)
    {
        // $model ...
        $model->status = 'Approved';
        $model->save();

        return $this->response()->success('Success message.')->refresh();
    }

    public function dialog()
    {
        $this->question('Are you sure to Approve this row?', 'This will Approve all the booking', ['icon'=>'question','confirmButtonText'=>'Yes']);
    }

}
