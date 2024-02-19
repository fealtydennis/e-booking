<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Employee extends Model
{
    use SoftDeletes;
    use Notifiable;

    public function gender():belongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function id_type():belongsTo
    {
        return $this->belongsTo(IdType::class);
    }

    public function department():belongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation():belongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function user():belongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }


}
