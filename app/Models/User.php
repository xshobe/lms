<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $table = 'admin_users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getVars()
    {
        if ($roles = RoleMasterModel::all()) {
            foreach ($roles as $value) {
                $this->roles[$value->id] = $value->role_name;
            }
        }
    }

    public function Address()
    {
        return $this->hasOne('App\Models\UserAddressModel', 'user_reg_id');
    }

    public function Role()
    {
        return $this->belongsTo('App\Models\RoleMasterModel', 'role_id');
    }

    // Override required, otherwise existing Authentication system will not match credentials
    // public function getAuthPassword()
    // {
    //     return $this->Password;
    // }

    // // Override required, otherwise existing Authentication system will not match credentials
    // public function getRememberToken()
    // {
    //     return $this->RememberToken;
    // }
}
