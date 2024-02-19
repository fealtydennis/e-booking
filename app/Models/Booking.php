<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenAdmin\Admin\Form;


class Booking extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::creating(function ($model){
            self::storeData($model);

        });
        static::updating(function ($model){
            self::storeData($model);
        });

        static::created(function($model){

            $booking_agent= new BookingAgent();
            $booking_agent->booking_id=$model->id;
            $booking_agent->save();
        });
        static::saving(function ($model){
//            $startDate = Carbon::createFromFormat('Y-m-d','start_date');
//            $endDate = Carbon::createFromFormat('Y-m-d','end_date');
            $startDate = $model->start_date;
            $endDate = $model->end_date;

               $totalDays = strtotime($endDate) - strtotime($startDate);

               $model->total_days = $totalDays/(60*60*24);
//            return $totalDays/60*60*24;
//            dd($totalDays/(60*60*24));
        });

        static::addGlobalScope('owned', function (Builder $query){
            $user = auth()->user();

                if (!$user->isAdministrator()){
                    $employee = $user->employee;
                    if ($employee){
                        $query->whereIn('employee_id', [$employee->id, $employee->approver_id]);
                    }else{
                        $query->whereNull('id');
                    }
                }
            });
        }

    public static function storeData(Booking $model)
    {
        $departureId1 = $model->departure_id_1;
        $departureId2 = $model->departure_id_2;
        $departureId3 = $model->departure_id_3;
        //destination
        $destinationId1 = $model->destination_id_1;
        $destinationId2 = $model->destination_id_2;
        $destinationId3 = $model->destination_id_3;

        // Check which departure_id has a value and set the corresponding value to the new departure_id field
        if (!is_null($departureId1)) {
            $model->departure_id = $departureId1;
        }
        if (!is_null($departureId2)) {
            $model->departure_id = $departureId2;
        }
        if (!is_null($departureId3)) {
            $model->departure_id = $departureId3;
        }
        if (!is_null($destinationId1)) {
            $model->destination_id = $destinationId1;
        }

        if (!is_null($destinationId2)) {
            $model->destination_id = $destinationId2;
        }

        if (!is_null($destinationId3)) {
            $model->destination_id = $destinationId3;
        }

        unset($model->departure_id_1);
        unset($model->departure_id_2);
        unset($model->departure_id_3);
        unset($model->destination_id_1);
        unset($model->destination_id_2);
        unset($model->destination_id_3);

    }



    public function destination():belongsTo
    {
        return $this->belongsTo(Destination::class, 'departure_id');
    }
    public function Employee():belongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function user():belongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
    public function travel_purpose():belongsTo
    {
        return $this->belongsTo(TravelPurpose::class);
    }
    public function routeNotificationFor($driver, $notification = null)
    {
        return $this->id;
    }
    public function company():belongsTo
    {
        return $this->belongsTo(Company::class, 'invoice_company_id');
    }
}
