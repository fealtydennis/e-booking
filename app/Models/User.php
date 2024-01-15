<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenAdmin\Admin\Auth\Database\Administrator;

class User extends Administrator
{
    use Notifiable;

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function routeNotificationFor($driver, $notification = null)
    {
        return $this->username;
    }

}
