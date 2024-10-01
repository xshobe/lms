<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LoanAccountsDetailsModel extends Model
{
    public $table='loan_approved';
    public $timestamps=false;
    
    public function CreatedBy()
    {
    	return $this->belongsTo('App\Models\UserModel','created_by'); // this matches the Eloquent model
    } 

    public function Loan()
    {
    	return $this->belongsTo('App\Models\LoanDetailsModel','loan_id'); // this matches the Eloquent model
    }
}
