<?php

namespace App\Admin\Actions;

use App\Models\Employee;
use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Form extends RowAction
{
    public $name = 'action';

    public $icon = 'icon-action';

    public function handle(Model $model, $request)
    {
        // $model ...
        $model->employee_id = $request->get('employee_id');
        return $this->response()->success('Success message.')->refresh();
    }
    public function form()
    {
        $this->select('employee_id', 'Employee Name')->options(Employee::all()->pluck('name','id'));
    }

}
