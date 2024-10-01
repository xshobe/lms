<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RoleMasterModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public $table = 'role_master';

    public function privileges()
    {
        return $this->hasOne('App\Models\AdminPrivilegesModel', 'role_id'); // this matches the Eloquent model
    }
}
