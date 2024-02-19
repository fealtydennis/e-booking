<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;


class Destination extends Model
{


    use Notifiable;

    public function travel_mode():belongsTo
    {
        return $this->belongsTo(TravelMode::class);
    }
}
