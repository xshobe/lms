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
use App\Models\LoanAccountsDetailsModel;

use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public $data='';
    
    public function customerApprovedLoanDetails()
    {
        $this->data['page_title']='Approved Member Loan requests';
        $this->data['LoanDetails']=LoanDetailsModel::where('status', '=', '1')->orderBy('created_at', 'desc')->get();
        
        return view('admin.accounts.loan_list')->with($this->data); 
    }

    public function DepositedLoans()
    {
        $this->data['page_title']='Deposited Member Loans';
        $this->data['LoanDetails']=LoanDetailsModel::where('status', '=', '3')->orderBy('created_at', 'desc')->get();
        
        return view('admin.accounts.deposited_loan_list')->with($this->data); 
    }

    public function payLoan($id)
    {
        $loanMasterObj = LoanDetailsModel::whereRaw("MD5(id)='$id'")->first();
        if ( ! $loanMasterObj)
            return redirect('admin/accounts/customerApprovedLoanDetails');    
       
        $loanMasterObj->getVars();
        $loanMasterObj->Customer->get_vars();
        $this->data['page_title'] = 'Details of '. getCustomerName($loanMasterObj->Customer);
        $this->data['loanMasterObj'] = $loanMasterObj;
        
        return view('admin.accounts.pay_loan')->with($this->data); 
    }

    public function viewLoanDetails($id)
    {
        $id=base64_decode($id);
        if (($id = (int)$id) == '' || $id <= 0)
        return redirect('admin/accounts/DepositedLoans');

        $LoanDetails = LoanAccountsDetailsModel::find($id);
        
        $this->data['page_title']='Loan details of - '.$LoanDetails->loan_id;//page title         
        
        $this->data['model']=$LoanDetails;
        
        // load the view 
        return view('admin.accounts.viewLoanDetails')->with($this->data); 
    }

    
    public function payNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required'  
        ]);

        // Add more validation
        $this->validateChequeNumber($validator, $request);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Update loan master table
            $loanMasterObj = \App\Models\LoanDetailsModel::find(base64_decode($request->input('loan_id')));
            $loanMasterObj->status = 3;
            if ($loanMasterObj->update())
            {
                $loanApprovedObj = $loanMasterObj->LoanAccount;
                $payment_type = intval($request->input('payment_method'));

                // Update loan approved table
                $loanApprovedObj->payment_type = $payment_type;
                $loanApprovedObj->cheque_no = ($payment_type == 2) ? $request->input('cheque_number') : '';
                $loanApprovedObj->update();

                // Add loan activity log
                $config_loan_status = config('constants.loan_status');
                $payment_method = \Config::get('constants.payment_method');
                $action = "Accounts team changed the status to ".$config_loan_status[$loanMasterObj->status];
                $action .= " with Payment method: ".$payment_method[$payment_type];
                \App\Library\LoanLibrary::LoanActivityLog($loanMasterObj->id, $action, '');
                Session::flash('flash_message', 'Loan status saved successfully!');
            }
        }

        return redirect('admin/accounts/DepositedLoans');
    }

    private function validateChequeNumber($validator, $request)
    {
        $validator->after(function ($validator) use ($request) 
        {
         
            $payment_method = $request->input('payment_method');
            $cheque_number = $request->input('cheque_number');
            if($payment_method!='' && $payment_method==2){
                if($cheque_number==''){

                    $validator->errors()->add('cheque_number', 'Please enter the cheque number');

                }
                elseif (!ctype_alnum($cheque_number)) {
                    $validator->errors()->add('cheque_number', 'Please enter the cheque number as alpha numeric characters');
                }

            }       
        });
    }

    public function getAdvanceReconciliation()
    {
        $this->data['page_title']='Advance Reconciliation';
        return view('admin.accounts.advance_reconciliation')->with($this->data);
    }

    public function postAdvanceReconciliation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'opening_balance'=>'required|Numeric',
            'additional_fund'=>'required|Numeric',
            'advance_payments'=>'required|Numeric',
            'outstanding'=>'required|Numeric',
            'closing_balance'=>'required|Numeric',
            'petty_cash'=>'required|Numeric',
            'withdrawals'=>'required|Numeric',
            'advance'=>'required|Numeric',
            'overpayment'=>'required|Numeric',
            'fund_brought_forward'=>'required|Numeric'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            $reconcileObj=new \App\Models\ReconciliationModel;
            $reconcileObj->opening_balance=$request->input('opening_balance');
            $reconcileObj->additional_fund=$request->input('additional_fund');
            $reconcileObj->advance_payments=$request->input('advance_payments');
            $reconcileObj->outstanding=$request->input('outstanding');
            $reconcileObj->closing_balance=$request->input('closing_balance');
            $reconcileObj->petty_cash=$request->input('petty_cash');
            $reconcileObj->withdrawals=$request->input('withdrawals');
            $reconcileObj->advance=$request->input('advance');
            $reconcileObj->overpayment=$request->input('overpayment');
            $reconcileObj->fund_brought_forward=$request->input('fund_brought_forward');
            $reconcileObj->save();

            Session::flash('flash_message', 'Advance reconciliation saved successfully!');
            return redirect('admin/advance-reconciliation');
        }
    }
}
