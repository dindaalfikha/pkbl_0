<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUnit extends Authenticatable
{
    protected $table = 'admin_units';
    protected $guarded = [];

    protected $hidden = [
        'password'
    ];
}
