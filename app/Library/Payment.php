<?php

namespace App\Library;

class Payment {

	public static function getQuarterPeriod()
    {
        $year = date('Y');
        return array(
            '01-01-'. $year => 'Jan First Quarter - '. $year,
            '01-02-'. $year => 'Jan Second Quarter - '. $year,
            '02-01-'. $year => 'Feb First Quarter - '. $year,
            '02-02-'. $year => 'Feb Second Quarter - '. $year,
            '03-01-'. $year => 'Mar First Quarter - '. $year,
            '03-02-'. $year => 'Mar Second Quarter - '. $year,
            '04-01-'. $year => 'Apr First Quarter - '. $year,
            '04-02-'. $year => 'Apr Second Quarter - '. $year,
            '05-01-'. $year => 'May First Quarter - '. $year,
            '05-02-'. $year => 'May Second Quarter - '. $year,
            '06-01-'. $year => 'Jun First Quarter - '. $year,
            '06-02-'. $year => 'Jun Second Quarter - '. $year,
            '07-01-'. $year => 'Jul First Quarter - '. $year,
            '07-02-'. $year => 'Jul Second Quarter - '. $year,
            '08-01-'. $year => 'Aug First Quarter - '. $year,
            '08-02-'. $year => 'Aug Second Quarter - '. $year,
            '09-01-'. $year => 'Sep First Quarter - '. $year,
            '09-02-'. $year => 'Sep Second Quarter - '. $year,
            '10-01-'. $year => 'Oct First Quarter - '. $year,
            '10-02-'. $year => 'Oct Second Quarter - '. $year,
            '11-01-'. $year => 'Nov First Quarter - '. $year,
            '11-02-'. $year => 'Nov Second Quarter - '. $year,
            '12-01-'. $year => 'Dec First Quarter - '. $year,
            '12-02-'. $year => 'Dec Second Quarter - '. $year
        );
    }

    public static function download($file_type)
    {
        switch($file_type)
        {
            case 'sample-savings-import-file':
                $file = '/sample-savings-import.xlsx';
                break;
            
            case 'sample-credit-loan-import-file':
                $file = '/sample-credit-loan-import.xlsx';
                break;

            case 'sample-advance-loan-import-file':
                $file = '/sample-advance-loan-import.xlsx';
                break;
        }

        if (isset($file))
        	return response()->download(base_path(). $file);
    }

    public static function getTotalSavings($tpf_number = NULL)
    {
        $savings=\App\Models\SavingsLogModel::where('tpf_number', '=', $tpf_number)->sum('amount_paid');
        $deduction=\App\Models\DeductionLogModel::where('tpf_number', '=', $tpf_number)->sum('amount_deducted');

        return array(
            'actualSavings'=>numberFormat($savings),
            'netSavings'=>numberFormat($savings - $deduction)
        );
    }

    public static function getTotalRepaymentAmt($loan_id = NULL)
    {
        $repaymentAmt=\App\Models\LoanPaymentLogModel::where('loan_id', '=', $loan_id)->sum('amount_paid');
        return numberFormat($repaymentAmt);
    }
}
