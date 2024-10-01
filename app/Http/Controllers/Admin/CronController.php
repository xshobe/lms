<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class CronController extends Controller
{
	public $data=[];

    public function deductAdministrationFee()
    {
    	$this->data['failed']=[];
        $successHit=0;
    	
    	// To deduct administration fee for the current month
    	// read the fees amount set from admin setting
        $settingObj=\App\Models\SettingsModel::find(1);

    	// Select all customer(s) who having savings in SIPEU
    	$customers=\App\Models\CustomersMasterModel::where('savings_amount', '!=', '')->get();
    	foreach ($customers as $customer)
    	{
    		if ($customer->savings_amount < $settingObj->administration_fee)
    		{
    			$this->data['failed'][]="Savings amount not managed to pay administration fee for TPF number $customer->tpf_number";
    			continue;
    		}
    		else
    		{
    			// Deduct administration fee from customer saving amount
    			$savingsAmount=$customer->savings_amount - $settingObj->administration_fee;
				
				// Add deduction log for administration fee
				$deductionObj=new \App\Models\DeductionLogModel;
				$deductionObj->tpf_number=$customer->tpf_number;
				$deductionObj->type=2;
				$deductionObj->reason='Administration fees';
				$deductionObj->amount_deducted=$settingObj->administration_fee;
				$deductionObj->created_at=date('Y-m-d H:i:s');
				$deductionObj->save();

	            // Update savings amount after deduction
	            \App\Models\CustomersMasterModel::where('id', '=', $customer->id)
	                ->update(array(
	                    'savings_amount'=>$savingsAmount
	                ));

                $successHit++;
    		}
    	}

		// Mail::send('emails.administration_fee_statement', $this->data, function($message) {
		// 	$conf = config('mail.Committeefrom');
		// 	$message->to($conf['address'], $conf['name'])->subject(config('constants.app_name').' Loan Request for committee');
		// });
    }

    public function calculateLoanInterest()
    {
        $this->data['failed']=[];
        $successHit=0;
        $interestPercent=\Config::get('constants.loan_interest_percent');

        $creditLoanList=\App\Models\LoanDetailsModel::Join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
            ->where('loan_master.scheme_id', '=', '1')
            ->where('loan_master.status', '=', '3')
            ->where('loan_approved.flag', '=', '1')
            ->get();

        foreach ($creditLoanList as $row)
        {
            $interestAmt=($interestPercent/100) * $row->amount_to_pay;
            $totalInterest=$row->total_interest+$interestAmt;
            $amountToPay=$row->amount_to_pay+$interestAmt;
            $perTermAmount=$amountToPay / ($row->repay_period - $row->repay_period_completed);

            // Update interest for loan
            \App\Models\LoanAccountsDetailsModel::where('loan_id', '=', $row->loan_id)
                ->update(array(
                    'total_interest'=>$totalInterest,
                    'amount_to_pay'=>$amountToPay,
                    'per_term_amount'=>$perTermAmount
                ));

			// Add transaction log for interest applied
			$transactionObj=new \App\Models\LoanTransactionLogModel;
			$transactionObj->loan_id=$row->loan_id;
			$transactionObj->transaction="$interestPercent% Interest";
			$transactionObj->amount=$interestAmt;
			$transactionObj->balance_amount=$amountToPay;
			$transactionObj->created_at=date('Y-m-d H:i:s');
			$transactionObj->save();

            $successHit++;
        }

        // Mail::send('emails.loan_interest_statement', $this->data, function($message) {
        //  $conf = config('mail.Committeefrom');
        //  $message->to($conf['address'], $conf['name'])->subject(config('constants.app_name').' Loan Request for committee');
        // });
    }

    public function changeCustomerCategory()
    {
        $customerList=\App\Models\CustomersMasterModel::where('customer_category_id', '=', '0')
            ->whereRaw("tpf_number != ''")
            ->get();

        foreach ($customerList as $row)
        {
            $tpf_number=substr($row->tpf_number, 0, 1);
            switch ($tpf_number)
            {
                case '3':
                $category_id=4;
                break;
                
                case '2':
                $category_id=3;
                break;
                
                case '1':
                $category_id=2;
                break;
                
                case '7':
                $category_id=1;
                break;

                default:
                $category_id=0;
                break;
            }

            \App\Models\CustomersMasterModel::where('id', '=', $row->id)
                ->update(array(
                    'customer_category_id'=>$category_id
                ));
        }
    }
}
