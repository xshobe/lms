<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Frontuser extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'customers_master';
    protected $fillable = [
        'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
