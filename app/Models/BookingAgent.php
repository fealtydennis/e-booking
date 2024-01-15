<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class BookingAgent extends Model
{


    protected $table = 'booking_agents';


    public function destination():belongsTo
    {
        return $this->belongsTo(Destination::class);
    }


}
