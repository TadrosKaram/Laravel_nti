<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Employee extends Model implements AuthenticatableContract
{
    use Authenticatable;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'gender',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
