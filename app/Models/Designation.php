<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Designation extends Model
{



    public function department(): belongsTo
    {
        return $this->belongsTo(Department::class);
    }



}
