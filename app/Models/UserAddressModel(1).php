<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddressModel extends Model
{   
	use SoftDeletes;
	protected $dates=['deleted_at'];
    public $table='user_address';
    public $timestamps=false;
}
