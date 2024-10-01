<?php

namespace App\Library;

class LoanLibrary {

	public static function getTotalMonths($duration = NULL)
    {
        switch ($duration) {
            case '3 months':
                $total_months = 3;
                break;
            
            case '6 months':
                $total_months = 6;
                break;
            
            case '1 year':
                $total_months = 12;
                break;
            
            case '2 years':
                $total_months = 24;
                break;
            
            case '3 years':
                $total_months = 36;
                break;
            
            default:
                $total_months = 0;
                break;
        }

        return $total_months;
    }

    public static function getRepaymentPeriod($duration = NULL)
    {
        switch ($duration) {
            case '3 months':
                $total_period = 6;
                break;
            
            case '6 months':
                $total_period = 12;
                break;
            
            case '1 year':
                $total_period = 24;
                break;
            
            case '2 years':
                $total_period = 48;
                break;
            
            case '3 years':
                $total_period = 72;
                break;
            
            default:
                $total_period = 0;
                break;
        }

        return $total_period;
    }

    public static function LoanActivityLog($loan_id, $action, $reason="")
    {
        $loanActivityObj = new \App\Models\LoanActivityLogModel;
        $loanActivityObj->loan_id = $loan_id;
        $loanActivityObj->action = $action;
        $loanActivityObj->reason = $reason;
        $loanActivityObj->created_at = date('Y-m-d H:i:s');
        $loanActivityObj->save();        
    }
}
