<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LoanDetailsModel extends Model
{
    public $table='loan_master';
    public $incrementing=false;
    public $loan_types=array();
    public $classification_name=array();
    public $loan_classification=array();
    public $loan_cl_period=array();

    public function getVars()
    {
        // Pre-load available loan categories
        if ($all_loan_types = LoanCategoriesModel::all())
        {
            foreach ($all_loan_types as $value)
            {
                $this->loan_types[$value->id] = $value->title;
            }
        }
        
        // Pre-load available loan classifications
        if ($all_classification = LoanClassificationMasterModel::all())
        {
            foreach ($all_classification as $value)
            {
                $this->classification_name[$value->id] = $value->title;
            }
        }
        
        // Pre-load available loan classifications with their range of amount
        if ($loan_classification = LoanClassificationModel::all())
        {
            foreach ($loan_classification as $value)
            {
                $this->loan_classification[$value->id] = $value->min." to ".$value->max ;
                $this->loan_cl_period[$value->id] = $value->period;
            }
        }
    }

    public function Customer()
    {
        return $this->belongsTo('App\Models\CustomersMasterModel','customer_id');
    }

    public function customerSalaryLevel()
    {
        return $this->belongsTo('App\Models\SalaryLevelModel','salary_level_id');
    } 

    public function Loancat() 
    {
    	return $this->belongsTo('App\Models\LoanCategoriesModel','loan_cat_id');
    } 

    public function CreatedBy() 
    {
    	return $this->belongsTo('App\Models\UserModel','created_by');
    } 

    public function ApprovedBy()
    {
    	return $this->belongsTo('App\Models\UserModel','approved_by');
    }

    public function LoanAccount()
    {
    	return $this->hasOne('App\Models\LoanAccountsDetailsModel','loan_id');
    }

    public function LoanActivity()
    {
    	return $this->hasMany('App\Models\LoanActivityLogModel','loan_id')->orderBy("id","DESC");
    }

    public function LoanRepaymentPeriod()
    {
        return $this->belongsTo('App\Models\LoanClassificationModel','classification_range_id');
    }

    public function LoanPaymentLog()
    {
    	return $this->hasMany('App\Models\LoanPaymentLogModel','loan_id');
    }

    public function getPaymentLog($loan_id)
    {
        return \App\Models\LoanPaymentLogModel::where('loan_id', '=', $loan_id)->get();
    }

    public function getTransactionLog($loan_id)
    {
        return \App\Models\LoanTransactionLogModel::where('loan_id', '=', $loan_id)->get();
    }
}
