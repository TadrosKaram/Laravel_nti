<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    // Optional: define table name if not pluralized automatically
    // protected $table = 'doctors';

    // Optional: define hidden fields (e.g., password)
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
