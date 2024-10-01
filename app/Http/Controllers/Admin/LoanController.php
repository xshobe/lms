<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Mail;
use Response;

// Models
use App\Models\CustomersMasterModel;
use App\Models\LoanDetailsModel;

class LoanController extends Controller
{
    public $data=[];
    
    public function index()
    {
        $customerObj = new CustomersMasterModel;
        $customerObj->getTpfNumberList();

        $this->data['page_title'] = 'New Members Loan/Advance Scheme';
        $this->data['customerObj'] = $customerObj;
        return view('admin.loan.search_tpf')->with($this->data); 
    }

    public function getTPFDetails()
    {   
        $data = json_decode(file_get_contents("php://input"));

        if (is_numeric($data->search))
            $this->data['customer'] = CustomersMasterModel::where('tpf_number','=',$data->search)->first();
        else
            $this->data['customer'] = 'not-numeric';

        $this->data['user_input'] = $data->search;
        echo json_encode(array('html'=>view('admin.loan.search_tpf_result')->with($this->data)->render()));
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewDetails($id)
    {
        $customerObj = CustomersMasterModel::whereRaw("MD5(id)='".$id."'")->first();
        if ( ! $customerObj)
            return redirect('admin/loan_section');        
        
        // Pre-load customer data for display
        $customerObj->get_vars();
        $customerObj->full_name = getCustomerName($customerObj);

        $this->data['page_title'] = 'Details of '. $customerObj->full_name;
        $this->data['customerObj'] = $customerObj;
        
        $savingsAmount = ($customerObj->savings_amount != '') ? $customerObj->savings_amount : 0;
        $this->data['savings_amt'] = numberFormat($savingsAmount);
        // $this->data['loanFee']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('loan_fee');
        // $this->data['loanInterest']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('total_interest');
        // $this->data['loanAmtPaid']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('amount_paid');
        // $this->data['loanAmtToPay']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('amount_to_pay');

        // Customer loan & advance details
        $customerLoans = $customerObj->getCustomerLoanDetails($customerObj->id, 'approved_loans');
        $customerAdvances = $customerObj->getCustomerLoanDetails($customerObj->id, 'approved_advances');
        $generalLoanInfo = $customerObj->calculateLoanAmt($customerLoans, $customerAdvances);
        
        $this->data['customer_loans'] = $customerLoans;
        $this->data['customer_advances'] = $customerAdvances;
        $this->data['generalLoanInfo'] = $generalLoanInfo;

        return view('admin.loan.view_customer_details')->with($this->data); 
    }
    
    public function applyLoan($id = NULL, $scheme_id = NULL)
    {
        $customerObj = CustomersMasterModel::whereRaw("MD5(id)='".$id."'")->first();
        if ( ! $customerObj || ($scheme_id == ''|| $scheme_id > 2 || ! is_numeric($scheme_id)))
            return redirect('admin/loan_section');

        // Customer loan & advance details
        $customerLoans = $customerObj->getCustomerLoanDetails($customerObj->id, 'approved_loans');
        $customerAdvances = $customerObj->getCustomerLoanDetails($customerObj->id, 'approved_advances');
        $generalLoanInfo = $customerObj->calculateLoanAmt($customerLoans, $customerAdvances);
        
        if ($scheme_id == 2 && $generalLoanInfo['advanceLoan']['amt_to_pay'] > 0)
            return redirect('admin/loan_section');

        // Pre-load customer data for display
        $customerObj->get_vars();
        $customerObj->full_name = getCustomerName($customerObj);
        $page_title = ($scheme_id == '1') ? 'Loan Application' : 'Advance Pay Application';
        $page_title .= ' - Details of '. $customerObj->full_name;
        
        // Pre-load loan data for display
        $loanMasterObj = new LoanDetailsModel;
        $loanMasterObj->getVars();

        // Html view page content
        $this->data['page_title'] = $page_title;
        $this->data['customerObj'] = $customerObj;
        $this->data['loanMasterObj'] = $loanMasterObj;
        $this->data['scheme_id'] = $scheme_id;
        $this->data['bal_retire_months'] = $this->getMonthsDiff($customerObj->retirement_date);
        $this->data['loan_fee'] = \App\Models\SettingsModel::find(1)->loan_fee;
        
        $savingsAmount = ($customerObj->savings_amount != '') ? $customerObj->savings_amount : 0;
        $this->data['savings_amt'] = numberFormat($savingsAmount);
        // $this->data['loanFee']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('loan_fee');
        // $this->data['loanInterest']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('total_interest');
        // $this->data['loanAmtPaid']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('amount_paid');
        // $this->data['loanAmtToPay']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('loan_master.customer_id', '=', $customerObj->id)->sum('amount_to_pay');
        $this->data['unPaidAdvanceAmt']=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
            ->where('loan_master.customer_id', '=', $customerObj->id)
            ->where('loan_master.scheme_id', '=', '2')
            ->where('loan_approved.flag', '=', '1')
            ->sum('amount_approved');
        
        $this->data['customer_loans'] = $customerLoans;
        $this->data['customer_advances'] = $customerAdvances;
        $this->data['generalLoanInfo'] = $generalLoanInfo;
        $this->data['maxAllowedAmt'] = $customerObj->getMaxAllowedAmt($this->data['savings_amt'], $generalLoanInfo['allLoanInfo']['amt_to_pay']);

        return view('admin.loan.apply_loan')->with($this->data);
    }

    public function getMonthsDiff($date)
    {
        $date1 = strtotime(date('d-m-Y'));
        $date2 = explode('-', $date);

        $year1 = date('Y', $date1);
        $year2 = $date2[0];

        $month1 = date('m', $date1);
        $month2 = $date2[1];

        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveLoanDetails(Request $request)
    {
        $min_amt = $request->input('min_amt');
        $max_amt = $request->input('max_amt');
        $scheme_id = base64_decode($request->input('scheme_id'));

        // Credit loan scheme validation fields
        if ($scheme_id == 1)
        {
            $validator = Validator::make($request->all(), [
                'loan_classification' =>'required',
                'loan_classification_amount' =>'required',
                'loan_category' =>'required',
                'loan_amount' =>'required|numeric|min:'. ($min_amt) .'|max:'. ($max_amt)
            ]);
        }
        
        // Advance loan scheme validation fields
        if($scheme_id == 2)
        {
            $validator = Validator::make($request->all(), [
				'loan_amount' =>'required|numeric|max:'. ($max_amt)
			]);
		}

        // Is validation done correctly?
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Note: Advance scheme does not need committee approval
            // So by default loan status will be considered as approved
            // And loan officer will be taken as approved person
            $loanMasterObj = new LoanDetailsModel;
            $loanMasterObj->id = 'SIPEU-'.date('dmYHis');
            $loanMasterObj->customer_id = base64_decode($request->input('customer_id'));
            $loanMasterObj->scheme_id = $scheme_id;
            $loanMasterObj->amount_requested = $request->input('loan_amount');
            $loanMasterObj->created_by = Auth::user()->user_id;
			
			if($scheme_id == 1)
            {
                $loanMasterObj->classification_id = $request->input('loan_classification');
                $loanMasterObj->classification_range_id = $request->input('loan_classification_amount');
                $loanMasterObj->loan_cat_id = $request->input('loan_category');
                $loanMasterObj->status = 0;
            }
            elseif($scheme_id == 2)
            {
                $loanMasterObj->salary_level_id = base64_decode($request->input('salary_level_id'));
                $loanMasterObj->status = 1;
                $loanMasterObj->approved_by = $loanMasterObj->created_by;
                $loanMasterObj->approved_at = date('Y-m-d H:i:s');
            }

            if ($loanMasterObj->save())
            {
                // Add to approved loan history only for advance loan
                if ($scheme_id == 2)
                {
                    // We need mark whether the loan is comes under outstanding.
                    // This is based on if the member bought advance loan previously and it is still unpaid
                    // then the new applying loan will be marked as "outstanding"
                    $unPaidAdvanceLoans=\App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
                        ->where('loan_master.customer_id', '=', $loanMasterObj->customer_id)
                        ->where('loan_master.scheme_id', '=', '2')
                        ->where('loan_approved.flag', '=', '1')->count();

                    // To deduct loan fee for current loan
                    // read the fees amount set from admin setting
                    $loan_fee=\App\Models\SettingsModel::find(1)->loan_fee;

                    // Calculate interest(as per DB)
                    $amount_approved = $loanMasterObj->amount_requested;
                    $interest_percent = $loanMasterObj->customerSalaryLevel->interest;
                    $initial_interest = ($interest_percent / 100) * $amount_approved;
                    
                    // Calculate total amount(approved amount + interest)
                    $total_loan_amount = $amount_approved + $initial_interest;
                    
                    // Calculate per term payment amount
                    // Note: For advance loan, repayment period will be one
                    $repay_period = 1;
                    $per_term_amount = $total_loan_amount / $repay_period;

                    // Note: For advance scheme repayment will be only once
                    // so the total_interest field will be same as initial_interest
                    $loanApprovedObj = new \App\Models\LoanAccountsDetailsModel;
                    $loanApprovedObj->loan_id = $loanMasterObj->id;
                    $loanApprovedObj->customer_id = $loanMasterObj->customer_id;
                    $loanApprovedObj->amount_approved = $amount_approved;
                    $loanApprovedObj->loan_fee = $loan_fee;
                    $loanApprovedObj->initial_interest = $initial_interest;
                    $loanApprovedObj->total_loan_amount = $total_loan_amount;
                    $loanApprovedObj->total_interest = $initial_interest;
                    $loanApprovedObj->amount_to_pay = $total_loan_amount;
                    $loanApprovedObj->repay_period = $repay_period;
                    $loanApprovedObj->per_term_amount = $per_term_amount;
                    $loanApprovedObj->is_outstanding = ($unPaidAdvanceLoans>0) ? '1' : '0';
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

                    // Add transaction log for interest applied
                    $transactionObj=new \App\Models\LoanTransactionLogModel;
                    $transactionObj->loan_id=$loanMasterObj->id;
                    $transactionObj->transaction="$interest_percent% Interest";
                    $transactionObj->amount=$initial_interest;
                    $transactionObj->balance_amount=$total_loan_amount;
                    $transactionObj->created_at=date('Y-m-d H:i:s');
                    $transactionObj->save();
                }
                
                // Add loan activity log
                $config_loan_status = config('constants.loan_status');
                $action = "Loan department created loan and the status is ".$config_loan_status[$loanMasterObj->status];
                \App\Library\LoanLibrary::LoanActivityLog($loanMasterObj->id, $action, $request->input('reason'));

                // $details = array('model' => $loanMasterObj);
                // Mail::send('emails.commitee', $details, function($message) {
                //     $conf = config('mail.Committeefrom');
                //     $message->to($conf['address'], $conf['name'])->subject(config('constants.app_name').' Loan Request for committee');
                // });

                if($scheme_id == 2)
                    Session::flash('flash_message', 'Loan details submitted to the Accounts team successfully!');
                else
                    Session::flash('flash_message', 'Loan details submitted to the credit committee successfully!');
                
                return redirect('admin/loan/customerLoanRequests');
            }
        }
    }

    public function customerLoanRequests()
    {
        $paginate_length=\Config::get('constants.paginate_length');
        $LoanDetails = LoanDetailsModel::where('scheme_id', '=', '1')->orderBy('created_at', 'desc')->paginate($paginate_length);
        
        $this->data['page_title']='Member Loan/Advance Requests';
        $this->data['LoanDetails']=$LoanDetails;
        return view('admin.loan.loan_request')->with($this->data); 
    }

    public function customerAdvanceRequests()
    {
        $paginate_length=\Config::get('constants.paginate_length');
        $LoanDetails = LoanDetailsModel::where('scheme_id', '=', '2')->paginate($paginate_length);
        
        $this->data['page_title']='Member Loan/Advance Requests';
        $this->data['LoanDetails']=$LoanDetails;
        return view('admin.loan.advance_request')->with($this->data); 
    }

    public function approval(Request $request, $id)
    {
        $id=base64_decode($id);

        
        $validator = Validator::make($request->all(), [
        'status' => 'required' 
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {


            //pr($request->all());
            //exit;
         
            // Storing Loan Categories details             
            $Loan = LoanDetailsModel::find($id); 
            $Loan->status= $request->input('status');  
            $Loan->updated_at= date('Y-m-d H:i:s'); 

            $Loan->update();  
          
            Session::flash('flash_message', 'Customer loan status updated successfully!');
            return redirect('admin/loan/customerLoanDetails');
        }
    }

    public function getLoanStatusCount($user_id,$status)
    {
        return count(LoanDetailsModel::whereRaw("MD5(user_id)='".$user_id."' and status='".$status."'")->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_loan_cl_amt(Request $request)
    {
        $clid = $request->get('option');
        $items = \App\Models\LoanClassificationModel::where('classification_id', '=', $clid)->get();

        $html = '<option value="">Select Loan Classification Amount</option>';
        foreach ($items as $key => $value) {
            
            $html .= '<option value="'. $value->id .'">'. $value->min .' to '. $value->max .'</option>';
        }
        
        return $html;
    }

    public function get_loan_cl_yr(Request $request)
    {
        $clid = $request->get('option');
        $items = \App\Models\LoanClassificationModel::where('id', '=', $clid)->first();

        $response = array(
            'period' => $items->period,
            'min' => $items->min,
            'max' => $items->max,
            'months' => \App\Library\LoanLibrary::getTotalMonths($items->period)
        );
		
        return Response::make($response);
    }
}
