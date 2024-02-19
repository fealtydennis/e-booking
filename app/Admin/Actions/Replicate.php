<?php

namespace App\Admin\Actions;

use App\Models\Employee;
use http\Env\Request;
use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Request;

class Replicate extends RowAction
{
    public $name = 'copy';

    public $icon = 'icon-copy';
    public function authorize($user, $model)
    {
        if (!$user->isBookingAgent()){
            return false;
        }else{
            return true;
        }

    }

    public function handle(Model $model, \Illuminate\Http\Request $request)
    {
        // $model ...

        $model->replicate()->save();

        return $this->response()->success('Success message.')->refresh();
    }


    public function dialog()
    {
        $this->question('Are you sure to copy this row?', 'This will copy all the data into a new entry',['icon'=>'question','confirmButtonText'=>'Yes']);
    }

}

