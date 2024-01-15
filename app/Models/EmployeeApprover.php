<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EmployeeApprover extends Model
{


    protected $table = 'employee_approvers';

    public function employee():belongsTo
    {
        return $this->belongsTo(Employee::class);
    }



}
