<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Validator;
use Mail;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\CustomersMasterModel;
use App\Models\LoanDetailsModel;
use Illuminate\Support\Facades\Auth;

class CommitteeController extends Controller
{
    public $data='';
    
    public function customerLoanDetails()
    {
        $this->data['page_title']='Member Loan requests';
        $this->data['LoanDetails']=LoanDetailsModel::whereRaw("status IN('0') AND scheme_id='1'")->orderBy('created_at', 'desc')->get();

        return view('admin.committee.request_list')->with($this->data); 
    }

    public function customerApprovedLoanDetails()
    {
        $this->data['page_title']='Approved & Deposited Loans';
        $this->data['LoanDetails']=LoanDetailsModel::whereRaw("status IN('1','2','3')")->orderBy('created_at', 'desc')->get();
        
        return view('admin.committee.approve_deposit_list')->with($this->data); 
    }

    public function viewCustomerLoanDetails($id)
    {
        $loanMasterObj = LoanDetailsModel::whereRaw("MD5(id)='$id'")->first();
        if ( ! $loanMasterObj)
            return redirect('admin/loan/customerLoanDetails');

        // Pre-load customer and loan data for display
        $customerObj = new \App\Models\CustomersMasterModel;
        $customerObj->get_vars();
        $loanMasterObj->getVars();

        $this->data['page_title'] = 'Loan Application';
        $this->data['loanMasterObj'] = $loanMasterObj;
        $this->data['customerObj'] = $customerObj;
        $this->data['loan_fee'] = \App\Models\SettingsModel::find(1)->loan_fee;
        
        // Committee team will not have (Pending and Deposited) loan status
        $loan_status = \Config::get('constants.loan_status');
        unset($loan_status[0]);
        unset($loan_status[3]);
        $this->data['loan_status'] = $loan_status;

        return view('admin.committee.view_customer_loan_details')->with($this->data); 
    }

    public function approval(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'loan_amount' => 'required|numeric|max:'. $request->input('max_amt'),
            'status' => 'required'
        ]);
        
        // Add more validation
        $this->validateComments($validator, $request);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            $loanMasterObj = \App\Models\LoanDetailsModel::whereRaw("MD5(id)='".$id."'")->first();
            $status = intval($request->input('status'));
            
            if ($status == 1)
            {
                // Set approved by
                $loanMasterObj->approved_by = Auth::user()->user_id;
                $loanMasterObj->approved_at = date('Y-m-d H:i:s');

                // Based on repayment duration get total repayment period(no.of payment cycles)
                $duration = $loanMasterObj->LoanRepaymentPeriod->period;
                $repay_period = \App\Library\LoanLibrary::getRepaymentPeriod($duration);

                // To deduct loan fee for current loan
                // read the fees amount set from admin setting
                $loan_fee=\App\Models\SettingsModel::find(1)->loan_fee;
                
                // Calculate total amount(approved amount is considered as total amount)
                $total_loan_amount = $amount_approved = $request->input('loan_amount');
                
                // Calculate per term payment amount
                $per_term_amount = $total_loan_amount / $repay_period;

                $loanApprovedObj = new \App\Models\LoanAccountsDetailsModel;  
                $loanApprovedObj->loan_id = $loanMasterObj->id;
                $loanApprovedObj->customer_id = $loanMasterObj->customer_id;
                $loanApprovedObj->amount_approved = $amount_approved;
                $loanApprovedObj->loan_fee = $loan_fee;
                $loanApprovedObj->total_loan_amount = $total_loan_amount;
                $loanApprovedObj->amount_to_pay = $total_loan_amount;
                $loanApprovedObj->repay_period = $repay_period;
                $loanApprovedObj->per_term_amount = $per_term_amount;
                $loanApprovedObj->save();

                $customerObj = \App\Models\CustomersMasterModel::where('id', '=', $loanMasterObj->customer_id)->first();

                if ($loan_fee > 0) {
                    // Add deduction log for loan fee
                    $deductionObj=new \App\Models\DeductionLogModel;
                    $deductionObj->tpf_number=$customerObj->tpf_number;
                    $deductionObj->type=3;
                    $deductionObj->reason='Loan fees';
                    $deductionObj->amount_deducted=$loan_fee;
                    $deductionObj->created_at=date('Y-m-d H:i:s');
                    $deductionObj->save();
                }

                // Deduct loan fee from customer saving amount
                $customerObj->savings_amount=$customerObj->savings_amount - $loan_fee;
                $customerObj->update();

                // Add transaction log for loan received
                $transactionObj=new \App\Models\LoanTransactionLogModel;
                $transactionObj->loan_id=$loanMasterObj->id;
                $transactionObj->transaction='Loan Received';
                $transactionObj->amount=$amount_approved;
                $transactionObj->balance_amount=$amount_approved;
                $transactionObj->created_at=date('Y-m-d H:i:s');
                $transactionObj->save();
            }
            elseif ($status == 2)
            {
                // Set rejected by
                $loanMasterObj->rejected_by = Auth::user()->user_id;
                $loanMasterObj->rejected_at = date('Y-m-d H:i:s');
            }

            // Update loan master table
            $loanMasterObj->status = $status;
            $loanMasterObj->update();
            
            // Update loan activity log
            $config_loan_status = config('constants.loan_status');
            $action = "credit committee changed the status to ".$config_loan_status[$status];
            $reason = ($status == 2) ? $request->input('comments') : '';
            \App\Library\LoanLibrary::LoanActivityLog($loanMasterObj->id, $action, $reason);
            Session::flash('flash_message', 'Member loan status updated successfully!');
            
            if($status == 0)
                return redirect('admin/committee/customerLoanDetails');
            else
                return redirect('admin/committee/customerApprovedLoanDetails');
        }
    }

    private function validateComments($validator, $request)
    {
        $validator->after(function ($validator) use ($request) 
        {
         
            $status = $request->input('status');
            $comments = $request->input('comments');
            if($status!='' && $status==2){
                if($comments==''){

                    $validator->errors()->add('comments', 'Please enter comments');

                }

            }       
        });
    }
}
