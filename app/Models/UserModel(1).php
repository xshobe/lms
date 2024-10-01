<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
	use SoftDeletes;
	protected $dates=['deleted_at'];
	protected $primaryKey='user_id';
    public $table='admin_users';
    public $roles=array();

    public function getVars()
    {
        if ($roles = RoleMasterModel::all())
        {
    		foreach ($roles as $value)
            {
    			$this->roles[$value->id]=$value->role_name;
    		}
    	}
    }

    public function Address()
    {
        return $this->hasOne('App\Models\UserAddressModel','user_reg_id');
    }

    public function Role()
    {
        return $this->belongsTo('App\Models\RoleMasterModel','role_id');
    }
}
