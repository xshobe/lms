<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomersMasterModel extends Model
{
    use SoftDeletes;
	protected $dates = ['deleted_at'];
    public $table = 'customers_master';
    public $customer_types = array();
    public $banks = array();
    public $SalaryLevel = array();
    public $tpf_number_array = array();

	public function get_vars()
    {
        // Pre-load available customer types
        if ($customerTypes = CustomerTypeMasterModel::all())
        {
            foreach ($customerTypes as $value)
            {
                $this->customer_types[$value->id] = $value->name;
            }
        }

        // Pre-load available banks applied for customer
        if ($banks = BankMasterModel::all())
        {
            foreach ($banks as $value)
            {
                $this->banks[$value->id] = $value->bank_name;
            }
        }

        // Pre-load available customer salary levels
        if ($salaryLevel = SalaryLevelModel::all())
        {
            foreach ($salaryLevel as $value)
            {
                $this->SalaryLevel[$value->id] = $value->salary_from.'-'.$value->salary_to;
            }
        }
    }

    public function getTpfNumberList()
    {
        if ($tpf_list = CustomersMasterModel::where('status', '=', 1)->get())
        {
            $i = 0;
            foreach ($tpf_list as $value)
            {
                $this->tpf_number_array[$i]['tpf'] = $value->tpf_number;
                $i++;
            }
        }
    }

    public function salary_level()
    {
        return $this->belongsTo('App\Models\SalaryLevelModel','salary_level');
    }

    public function LoanDetails()
    {
        return $this->hasMany('App\Models\LoanDetailsModel','customer_id');
    }
	
	public function getCustomerLoanDetails($customer_id, $type = 'all')
    {
        switch ($type)
        {
            case 'all':
                $result=\App\Models\LoanDetailsModel::leftJoin('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
                    ->where('loan_master.customer_id', '=', $customer_id)->get();
                break;

            case 'approved_loans':
                $result=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
                    ->where('loan_master.customer_id', '=', $customer_id)
                    ->where('loan_master.scheme_id', '=', '1')
                    ->whereIn('loan_master.status', [1, 3])->get();
                break;

            case 'approved_advances':
                $result=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
                    ->where('loan_master.customer_id', '=', $customer_id)
                    ->where('loan_master.scheme_id', '=', '2')
                    ->whereIn('loan_master.status', [1, 3])->get();
                break;
            
            default:
                $result=false;
                break;
        }

        return $result;
	}

    public function getTotalLoanAmt($history)
    {
        $amt = 0;
        foreach ($history as $val) {
            if ($val->status == '3')
                $amt += $val->amount_approved;
        }
        return $amt;
    }

    public function getTotalPaidAmt($history)
    {
        $amt = 0;
        foreach ($history as $val) {
            if ($val->status == '3')
                $amt += $val->amount_paid;
        }
        return $amt;
    }

    public function getTotalAmtToPay($history)
    {
        $amt = 0;
        foreach ($history as $val) {
            if ($val->status == '3')
                $amt += $val->amount_to_pay;
        }
        return $amt;
    }

    // public function calculateLoanAmt($history)
    // {
    //     $amt_requested=$amt_approved=$amt_paid=$amt_to_pay=$tot_interest=$tot_fee=0;
    //     foreach ($history as $val)
    //     {
    //         $amt_requested += $val->amount_requested;
    //         $amt_approved += $val->amount_approved;
    //         $amt_paid += $val->amount_paid;
    //         $amt_to_pay += $val->amount_to_pay;
    //         $tot_interest += $val->total_interest;
    //         $tot_fee += $val->loan_fee;
    //     }
        
    //     return array(
    //         'amt_requested'=>numberFormat($amt_requested),
    //         'amt_approved'=>numberFormat($amt_approved),
    //         'amt_paid'=>numberFormat($amt_paid),
    //         'amt_to_pay'=>numberFormat($amt_to_pay),
    //         'tot_interest'=>numberFormat($tot_interest),
    //         'tot_fee'=>numberFormat($tot_fee)
    //     );
    // }

    public function calculateLoanAmt($loanHistory, $advanceHistory)
    {
        $loan_amt_requested=$loan_amt_approved=$loan_amt_paid=$loan_amt_to_pay=$loan_tot_interest=$loan_tot_fee=0;
        $advance_amt_requested=$advance_amt_approved=$advance_amt_paid=$advance_amt_to_pay=$advance_tot_interest=$advance_tot_fee=0;
        $tot_amt_requested=$tot_amt_approved=$tot_amt_paid=$tot_amt_to_pay=$tot_interest=$tot_fee=0;
        
        foreach ($loanHistory as $val)
        {
            $loan_amt_requested += $val->amount_requested;
            $loan_amt_approved += $val->amount_approved;
            $loan_amt_paid += $val->amount_paid;
            $loan_amt_to_pay += $val->amount_to_pay;
            $loan_tot_interest += $val->total_interest;
            $loan_tot_fee += $val->loan_fee;

            // Calculate over all loan information
            $tot_amt_requested += $val->amount_requested;
            $tot_amt_approved += $val->amount_approved;
            $tot_amt_paid += $val->amount_paid;
            $tot_amt_to_pay += $val->amount_to_pay;
            $tot_interest += $val->total_interest;
            $tot_fee += $val->loan_fee;
        }
        
        $result['creditLoan'] = array(
            'amt_requested'=>numberFormat($loan_amt_requested),
            'amt_approved'=>numberFormat($loan_amt_approved),
            'amt_paid'=>numberFormat($loan_amt_paid),
            'amt_to_pay'=>numberFormat($loan_amt_to_pay),
            'tot_interest'=>numberFormat($loan_tot_interest),
            'tot_fee'=>numberFormat($loan_tot_fee)
        );

        foreach ($advanceHistory as $val)
        {
            $advance_amt_requested += $val->amount_requested;
            $advance_amt_approved += $val->amount_approved;
            $advance_amt_paid += $val->amount_paid;
            $advance_amt_to_pay += $val->amount_to_pay;
            $advance_tot_interest += $val->total_interest;
            $advance_tot_fee += $val->loan_fee;

            // Calculate over all loan information
            $tot_amt_requested += $val->amount_requested;
            $tot_amt_approved += $val->amount_approved;
            $tot_amt_paid += $val->amount_paid;
            $tot_amt_to_pay += $val->amount_to_pay;
            $tot_interest += $val->total_interest;
            $tot_fee += $val->loan_fee;
        }
        
        $result['advanceLoan'] = array(
            'amt_requested'=>numberFormat($advance_amt_requested),
            'amt_approved'=>numberFormat($advance_amt_approved),
            'amt_paid'=>numberFormat($advance_amt_paid),
            'amt_to_pay'=>numberFormat($advance_amt_to_pay),
            'tot_interest'=>numberFormat($advance_tot_interest),
            'tot_fee'=>numberFormat($advance_tot_fee)
        );

        $result['allLoanInfo'] = array(
            'amt_requested'=>numberFormat($tot_amt_requested),
            'amt_approved'=>numberFormat($tot_amt_approved),
            'amt_paid'=>numberFormat($tot_amt_paid),
            'amt_to_pay'=>numberFormat($tot_amt_to_pay),
            'tot_interest'=>numberFormat($tot_interest),
            'tot_fee'=>numberFormat($tot_fee)
        );

        return $result;
    }

    public function getMaxAllowedAmt($savingAmt, $outStandingAmt)
    {
        if (($savingAmt - $outStandingAmt) < 0) {
            return numberFormat(0);
        }

        $maxAllowedAmt = $savingAmt - $outStandingAmt;
        $percentageToReduce = (1/100) * $maxAllowedAmt;
        $maxAllowedAmt = ($maxAllowedAmt - $percentageToReduce) - 5;
        
        if ($maxAllowedAmt < 0) {
            return numberFormat(0);
        }
        
        return numberFormat($maxAllowedAmt);
    }

    public function getSavingsLog()
    {
        return $this->hasMany('App\Models\SavingsLogModel','tpf_number','tpf_number');
    }

    public function getDeductionsLog()
    {
        return $this->hasMany('App\Models\DeductionLogModel','tpf_number','tpf_number');
    }
}
