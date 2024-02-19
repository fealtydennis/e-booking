<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class BookingAgent extends Model
{


    protected $table = 'booking_agents';


    public function destination():belongsTo
    {
        return $this->belongsTo(Destination::class, 'departure_id');
    }
    public function employee():belongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function booking():belongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function paymentMode():belongsTo
    {
        return $this->belongsTo(PaymentMode::class);
    }
}
