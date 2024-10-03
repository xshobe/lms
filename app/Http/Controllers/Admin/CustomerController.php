<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Hash;
use Illuminate\Support\Facades\Validator;
use PDF;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $data;
    public function index()
    {
        $customerObj = new \App\Models\CustomersMasterModel;
        $customerObj->get_vars();

        return view('admin.customers.index')->with([
            'customerObj' => $customerObj,
            'customers' => $customerObj::orderByDesc('id')->paginate(1000),
            'page_title' => 'Manage Members',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tpf_number = NULL)
    {
        $customerObj = new \App\Models\CustomersMasterModel;
        $customerObj->get_vars();

        // Html view page content
        $this->data['customerObj'] = $customerObj;
        $this->data['tpf_number'] = $tpf_number;
        $this->data['selected_category'] = $this->get_tpf_based_category($tpf_number, $customerObj->customer_types);
        $this->data['page_title'] = 'Add Member';
        return view('admin.customers.create')->with($this->data);
    }

    private function get_tpf_based_category($tpf_number, $categories)
    {
        $tpf_number = substr($tpf_number, 0, 1);
        switch ($tpf_number) {
            case '1':
                $category = '2';
                break;

            case '2':
                $category = '3';
                break;

            case '3':
                $category = '4';
                break;

            case '7':
                $category = '1';
                break;

            default:
                $category = NULL;
                break;
        }

        return $category;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new \App\Models\CustomersMasterModel;
        $validator = Validator::make($request->all(), [
            'customer_category' => 'required',
            'tpf_number' => 'required|numeric|unique:' . $customer->table . ',tpf_number,NULL,id,deleted_at,NULL',
            'salary_level' => 'required',
            'first_name' => 'required|regex:/(^[A-Za-z ]+$)+/',
            'last_name' => 'required|regex:/(^[A-Za-z ]+$)+/',
            'email' => 'email|unique:' . $customer->table . ',email,NULL,id,deleted_at,NULL',
            'dob' => 'required',
            'mobile' => 'numeric',
            'bank_type' => 'required',
            'account_no' => 'required|numeric',
            'retirement_date' => 'required',
            'profile_image' => 'mimes:jpg,jpeg,png'
        ]);
        $this->validateTpf($validator, $request);

        // Run validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Store customer details
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->salary_level = $request->input('salary_level');
            $customer->gender = $request->input('gender');
            $customer->dob = $this->sanitizeDate($request->input('dob'));
            $customer->current_age = $request->input('current_age');
            $customer->contact = $request->input('contact');
            $customer->mobile = $request->input('mobile');
            $customer->tpf_number = $request->input('tpf_number');
            $customer->customer_category_id = $request->input('customer_category');
            $customer->bank_id = $request->input('bank_type');
            $customer->account_no = $request->input('account_no');
            $customer->job_title = $request->input('job_title');
            $customer->ministry = $request->input('ministry');
            $customer->school = $request->input('school');
            $customer->retirement_date = $this->sanitizeDate($request->input('retirement_date'));
            $customer->register_date = $this->sanitizeDate($request->input('register_date'));
            $customer->width_date = $this->sanitizeDate($request->input('width_date'));
            $customer->status = '1';

            if ($customer->save()) {
                // Let add customer beneficiaries
                $aBeneficiary = $request->input('beneficiary');
                $aRelationship = $request->input('relationship');
                $aPortion = $request->input('portion');
                $totalLength = count($aBeneficiary);
                for ($i = 0; $i < $totalLength; $i++) {
                    $beneficiaryObj = new \App\Models\BeneficiaryModel;
                    $beneficiaryObj->customer_id = $customer->id;
                    $beneficiaryObj->beneficiary = $aBeneficiary[$i];
                    $beneficiaryObj->relationship = $aRelationship[$i];
                    $beneficiaryObj->portion = $aPortion[$i];
                    $beneficiaryObj->save();
                }

                // Upload member profile picture
                $profile_image = $this->handleUpload($request, $customer->id);
                \App\Models\CustomersMasterModel::where('id', '=', $customer->id)->update(['profile_image' => $profile_image]);

                Session::flash('flash_message', 'Member added successfully!');
                return redirect('admin/customers');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! ($customerObj = \App\Models\CustomersMasterModel::find(intval($id))))
            return redirect('admin/customers');

        // Pre-load customer related data
        $customerObj->get_vars();

        $this->data['customerObj'] = $customerObj;
        $this->data['loanMasterObj'] = new \App\Models\LoanDetailsModel;
        $this->data['page_title'] = 'Details of ' . getCustomerName($customerObj);

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
        $this->data['maxAllowedAmt'] = $customerObj->getMaxAllowedAmt($this->data['savings_amt'], $generalLoanInfo['allLoanInfo']['amt_to_pay']);

        return view('admin.customers.show')->with($this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! ($model = \App\Models\CustomersMasterModel::find(intval($id))))
            return redirect('admin/customers');

        $model->get_vars();

        // Html view page content
        $this->data['model'] = $model;
        $this->data['beneficiaries'] = \App\Models\BeneficiaryModel::where('customer_id', '=', $model->id)->get();
        $this->data['page_title'] = 'Edit User - ' . $model->first_name . ' ' . $model->last_name;
        return view('admin.customers.edit')->with($this->data);
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
        $model = new \App\Models\CustomersMasterModel;
        $validator = Validator::make($request->all(), [
            'customer_category' => 'required',
            'salary_level' => 'required',
            'first_name' => 'required|regex:/(^[A-Za-z ]+$)+/',
            'last_name' => 'required|regex:/(^[A-Za-z ]+$)+/',
            'email' => 'email|unique:' . $model->table . ',email,' . $id . ',id,deleted_at,NULL',
            'dob' => 'required',
            'mobile' => 'numeric',
            'bank_type' => 'required',
            'account_no' => 'required|numeric',
            'retirement_date' => 'required',
            'profile_image' => 'mimes:jpg,jpeg,png'
        ]);
        $this->validateTpf($validator, $request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Store customer details
            $customer = \App\Models\CustomersMasterModel::find($id);
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->salary_level = $request->input('salary_level');
            $customer->gender = $request->input('gender');
            $customer->dob = $this->sanitizeDate($request->input('dob'));
            $customer->current_age = $request->input('current_age');
            $customer->contact = $request->input('contact');
            $customer->mobile = $request->input('mobile');
            $customer->customer_category_id = $request->input('customer_category');
            $customer->bank_id = $request->input('bank_type');
            $customer->account_no = $request->input('account_no');
            $customer->job_title = $request->input('job_title');
            $customer->ministry = $request->input('ministry');
            $customer->school = $request->input('school');
            if (($profile_image = $this->handleUpload($request, $customer->id)) != null) {
                $customer->profile_image = $profile_image;
            }
            $customer->retirement_date = $this->sanitizeDate($request->input('retirement_date'));
            $customer->width_date = $this->sanitizeDate($request->input('width_date'));
            $customer->status = $request->input('status');

            if ($customer->update()) {
                \App\Models\BeneficiaryModel::where('customer_id', '=', $customer->id)->delete();

                // Let add customer beneficiaries
                $aBeneficiary = $request->input('beneficiary');
                $aRelationship = $request->input('relationship');
                $aPortion = $request->input('portion');
                $totalLength = count($aBeneficiary);
                for ($i = 0; $i < $totalLength; $i++) {
                    $beneficiaryObj = new \App\Models\BeneficiaryModel;
                    $beneficiaryObj->customer_id = $customer->id;
                    $beneficiaryObj->beneficiary = $aBeneficiary[$i];
                    $beneficiaryObj->relationship = $aRelationship[$i];
                    $beneficiaryObj->portion = $aPortion[$i];
                    $beneficiaryObj->save();
                }

                Session::flash('flash_message', 'Member updated successfully!');
                return redirect('admin/customers');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = \App\Models\CustomersMasterModel::find($id);
        $customer->delete();

        Session::flash('flash_message', 'Member deleted successfully!');
        return redirect('admin/customers');
    }

    /**
     * Coverts user input date into SQL DATE
     *
     * @param  string  $date
     * @return Response
     */
    private function sanitizeDate($dateString = NULL)
    {
        if ($dateString == NULL || $dateString == 'dd/mm/yyyy')
            return NULL;

        $dateString = str_replace('/', '-', $dateString);
        return date_format(date_create($dateString), 'Y-m-d');
    }

    /**
     * Validates user TPF number for designation
     *
     * @param  object  $validator
     * @param  object  $request
     * @param  object  $obj
     * @sets Error
     */
    private function validateTpf($validator, $request)
    {
        $validator->after(function ($validator) use ($request) {
            $model = new \App\Models\CustomersMasterModel;
            $model->get_vars();

            // Retrieve user input
            $category_id = $request->input('customer_category');
            $tpf_number = substr($request->input('tpf_number'), 0, 1);

            $customer_category = isset($model->customer_types[$category_id])
                ? strtolower($model->customer_types[$category_id])
                : NULL;

            switch ($customer_category) {
                case 'police':
                case 'polices':
                    if ($tpf_number != 3) {
                        $validator->errors()->add('tpf_number', 'The TPF number should start with 3 for ' . $customer_category);
                    }
                    break;

                case 'teachers':
                case 'teacher':
                    if ($tpf_number != 2) {
                        $validator->errors()->add('tpf_number', 'The TPF number should start with 2 for ' . $customer_category);
                    }
                    break;

                case 'established':
                    if ($tpf_number != 1) {
                        $validator->errors()->add('tpf_number', 'The TPF number should start with 1 for ' . $customer_category);
                    }
                    break;

                case 'non-establised':
                    if ($tpf_number != 7) {
                        $validator->errors()->add('tpf_number', 'The TPF number should start with 7 for ' . $customer_category);
                    }
                    break;

                default:
                    $validator->errors()->add('tpf_number', 'The TPF number not recognized');
                    break;
            }
        });
    }

    private function handleUpload($request, $customerId)
    {
        if (! $request->hasFile('profile_image') || ! $request->file('profile_image')->isValid())
            return null;

        // Delete the file(s) which uploaded before
        $upload_path = 'storage/profile/' . $customerId;
        $files = glob($upload_path . '/*');
        foreach ($files as $file) {
            unlink($file);
        }

        $fileName = time() . '.' . $request->file('profile_image')->getClientOriginalExtension();
        $request->file('profile_image')->move($upload_path, $fileName);
        return $upload_path . '/' . $fileName;
    }

    public function getStatement($id)
    {
        if (! ($customerObj = \App\Models\CustomersMasterModel::whereRaw("MD5(id)='" . $id . "'")->first()))
            return redirect('admin/customers');

        // Pre-load customer related data
        $customerObj->get_vars();

        $this->data['customerObj'] = $customerObj;
        $this->data['loanMasterObj'] = new \App\Models\LoanDetailsModel;

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

        $pdf = PDF::loadView('pdf.customer_history', $this->data);
        return $pdf->download($customerObj->tpf_number . '-' . date('Y-m-d') . '.pdf');
    }

    public function getAdvanceTransactionHistory($id, $loan_id)
    {
        if (! ($customerObj = \App\Models\CustomersMasterModel::select('id')->where('id', '=', $id)->first()))
            return json_encode(array('status' => '0', 'msg' => 'No customer found.'));

        // Get advance transaction history
        $advanceHistory = \App\Models\LoanPaymentLogModel::select('amount_paid', 'actual_amount', 'amount_to_pay', 'quarter')
            ->where('loan_id', '=', $loan_id)
            ->get();

        if (count($advanceHistory) <= 0)
            return json_encode(array('status' => '1', 'msg' => 'Retrieved successfully.', 'data' => '<p><b>No transaction history found.</b></p>'));

        $html = view('admin.customers.advance_history')->with('advanceHistory', $advanceHistory)->render();
        return json_encode(array('status' => '1', 'msg' => 'Retrieved successfully.', 'data' => $html));
    }
}
