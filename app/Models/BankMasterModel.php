<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankMasterModel extends Model
{
    use SoftDeletes;
	protected $dates=['deleted_at'];
	public $table='banks';
	public $timestamps=false;
}
