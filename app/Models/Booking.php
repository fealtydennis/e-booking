<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Booking extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('owned', function (Builder $query){
            $user = auth()->user();

            if (!$user->isAdministrator()){
                $employee = $user->employee;
                if ($employee){
                    $query->where('employee_id', $employee->id);
                }else{
                    $query->whereNull('id');
                }
            }
        });
    }

    public function destination():belongsTo
    {
        return $this->belongsTo(Destination::class);
    }
    public function Employee():belongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function user():belongsTo
    {
        return$this->belongsTo(User::class);
    }

}
