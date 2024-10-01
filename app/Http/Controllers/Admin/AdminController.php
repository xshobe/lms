<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    public $data = [];

    public function index()
    {
        return redirect('admin/home');
    }

    public function getAdminHome()
    {
        $this->data['page_title'] = 'Home';
        return view('admin.home')->with($this->data);
    }

    public function dashboard()
    {
        $this->data['page_title'] = 'Dashboard';

        // Get total loan(s) and amount(requested)
        $this->data['tot_loan_requested'] = \App\Models\LoanDetailsModel::where('scheme_id', '=', '1')->count();
        $this->data['tot_advance_requested'] = \App\Models\LoanDetailsModel::where('scheme_id', '=', '2')->count();
        $this->data['loan_amt_requested'] = \App\Models\LoanDetailsModel::where('scheme_id', '=', '1')->sum('amount_requested');
        $this->data['advance_amt_requested'] = \App\Models\LoanDetailsModel::where('scheme_id', '=', '2')->sum('amount_requested');

        // Get total loan(s) and amount(approved by SIPEU)
        $this->data['tot_loan_approved'] = \App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('scheme_id', '=', '1')->count();
        $this->data['tot_advance_approved'] = \App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('scheme_id', '=', '2')->count();
        $this->data['loan_amt_approved'] = \App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('scheme_id', '=', '1')->sum('amount_approved');
        $this->data['advance_amt_approved'] = \App\Models\LoanDetailsModel::join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->where('scheme_id', '=', '2')->sum('amount_approved');

        // Get total member(s) in SIPEU
        $this->data['tot_members'] = \App\Models\CustomersMasterModel::count();

        return view('admin.dashboard')->with($this->data);
    }

    public function getAdminSettings()
    {
        $this->data['page_title'] = 'Settings';
        $this->data['settingObj'] = \App\Models\SettingsModel::find(1);

        return view('admin.settings')->with($this->data);
    }

    public function postAdminSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'withdraw_fee' => 'Numeric',
            'administration_fee' => 'Numeric',
            'membership_fee' => 'Numeric',
            'loan_fee' => 'Numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $settingObj = \App\Models\SettingsModel::find(1);
            if (is_null($settingObj)) {
                $settingObj = new \App\Models\SettingsModel;
                $settingObj->withdraw_fee = $request->input('withdraw_fee');
                $settingObj->administration_fee = $request->input('administration_fee');
                $settingObj->membership_fee = $request->input('membership_fee');
                $settingObj->loan_fee = $request->input('loan_fee');
                $settingObj->save();
            } else {
                $settingObj->withdraw_fee = $request->input('withdraw_fee');
                $settingObj->administration_fee = $request->input('administration_fee');
                $settingObj->membership_fee = $request->input('membership_fee');
                $settingObj->loan_fee = $request->input('loan_fee');
                $settingObj->update();
            }

            Session::flash('flash_message', 'Settings saved successfully!');
            return redirect('admin/settings');
        }
    }

    public function getProfile()
    {
        if (($id = Auth::user()->user_id) == '' || $id < 0)
            return redirect(url('admin/users'));

        $model = \App\Models\UserModel::find($id);
        $model->getVars();

        $this->data['page_title'] = 'User Profile - ' . $model->first_name;
        $this->data['model'] = $model;
        return view('admin.users.profile')->with($this->data);
    }

    public function postProfile(Request $request, $id)
    {
        $User = \App\Models\UserModel::find($id);

        $validator = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required|min:2|max:30|regex:/(^[A-Za-z ]+$)+/',
            'user_name' => 'required|min:2|max:30|regex:/(^[A-Za-z ]+$)+/',
            'last_name' => 'required|max:30|regex:/(^[A-Za-z ]+$)+/',
            'user_name' => 'required|min:2|max:30|regex:/(^[A-Za-z ]+$)+/|unique:' . $User->table . ',user_name,' . $id . ',user_id,deleted_at,NULL',
            'email' => 'required|email|unique:' . $User->table . ',email,' . $id . ',user_id,deleted_at,NULL',
            'mobile' => 'required|Numeric',
            'city' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'state' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'country' => 'min:2|max:40|regex:/(^[A-Za-z ]+$)+/',
            'zip_code' => 'Numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Storing user details
            $User->first_name = $request->input('first_name');
            $User->user_name = $request->input('user_name');
            $User->last_name = $request->input('last_name');
            $User->salutation = $request->input('salutation');
            $User->email = $request->input('email');
            $User->mobile = $request->input('mobile');
            $User->updated_at = date('Y-m-d H:i:s');

            if ($User->update()) {


                // Storing user Address details
                $UserAddress = \App\Models\UserAddressModel::where('user_reg_id', $id)->first();

                if ($UserAddress) {
                    // Updating user Address details
                    $UserAddress->address1 = $request->input('address1');
                    $UserAddress->address2 = $request->input('address2');
                    $UserAddress->city = $request->input('city');
                    $UserAddress->state = $request->input('state');
                    $UserAddress->country = $request->input('country');
                    $UserAddress->zip_code = $request->input('zip_code');
                    $UserAddress->save();
                } else {
                    // Storing user Address details
                    if ($request->input('address1') != '' && $request->input('city') != '' && $request->input('state') != '' && $request->input('country') != '') {
                        $UserAddress = new \App\Models\UserAddressModel;
                        $UserAddress->user_reg_id = $id;
                        $UserAddress->address1 = $request->input('address1');
                        $UserAddress->address2 = $request->input('address2');
                        $UserAddress->city = $request->input('city');
                        $UserAddress->state = $request->input('state');
                        $UserAddress->country = $request->input('country');
                        if ($request->input('zip_code') != '') {
                            $UserAddress->zip_code = $request->input('zip_code');
                        }
                        $UserAddress->save();
                    }
                }
            }
            Session::flash('flash_message', 'Profile Updated successfully!');
            return redirect('admin/profile');
        }
    }

    public function getChangePassword()
    {
        $id = Auth::user()->user_id;
        $id = (int)$id;
        if ($id == '' || $id < 0)
            return redirect(url('admin/dashboard'));

        $model = \App\Models\UserModel::find($id);

        $this->data['page_title'] = 'Change Password'; //page title
        $this->data['model'] = $model; //model
        return view('admin.users.changepassword')->with($this->data);
    }

    public function postChangePassword(Request $request, $id)
    {
        $User = \App\Models\UserModel::find($id);
        $Hash_password = Hash::make($request->input('password'));
        $current_password = $request->input('current_password');

        $validator = Validator::make($request->all(), [
            'current_password'      => 'required',
            'password'              => 'required|min:6|confirmed|different:current_password',
            'password_confirmation' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } elseif (Hash::check($current_password, $User->password)) {
            // Storing user details

            if ($request->input('password') != "") {
                $User->password = $Hash_password;
            }

            $User->updated_at = date('Y-m-d H:i:s');

            if ($User->update()) {
                Session::flash('flash_message', 'Password Updated successfully!');
                return redirect('admin/changePassword');
            }
        } else {
            return redirect()->back()->withErrors('Password incorrect');
        }
    }

    // Savings payment upload page
    public function getSavingsUpload()
    {
        $this->data['quarter'] = \App\Library\Payment::getQuarterPeriod();
        $this->data['page_title'] = 'Upload Savings';
        return view('admin.payments.savings_upload')->with($this->data);
    }

    // Credit loan payment upload page
    public function getCreditLoanUpload()
    {
        $this->data['quarter'] = \App\Library\Payment::getQuarterPeriod();
        $this->data['page_title'] = 'Upload Loan Repayment';
        return view('admin.payments.credit_loan_upload')->with($this->data);
    }

    // Advance loan payment upload page
    public function getAdvanceLoanUpload()
    {
        $this->data['quarter'] = \App\Library\Payment::getQuarterPeriod();
        $this->data['page_title'] = 'Upload Advance Repayment';
        return view('admin.payments.advance_loan_upload')->with($this->data);
    }

    // Process savings payment(uploaded)
    public function postSavingsUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quarter' => 'required',
            'file' => 'required'
        ]);

        // Is validation done correctly?
        if ($validator->fails()) {
            $this->showError('validation', $validator->messages()->all());
        }

        // Read payment excel file and check is the file correct format?
        $savingsList = \App\Library\ExcelReader::getSavingsPaymentList($request, 'file', 'storage/repayments/saving');
        if (! isset($savingsList[0]) || ! isset($savingsList[0]['tpf_number']) || ! isset($savingsList[0]['amount']) || ! isset($savingsList[0]['date'])) {
            $this->showError('file');
        }

        // Here we will check whether the member paid his membership fee or not
        // To deduct membership fee, read the fees amount set from admin setting
        $settingObj = \App\Models\SettingsModel::find(1);

        $member_not_exist = $already_updated = $not_manageable = $success = NULL;
        foreach ($savingsList as $key => $row) {
            switch ($this->doSavingsPaymentUpdate($row, $settingObj)) {
                case 'member_not_exist':
                    $member_not_exist .= "<tr><td>The member account does not exist for TPF number <b>$row->tpf_number</b></td></tr>";
                    break;

                case 'already_updated':
                    $already_updated .= "<tr><td>Savings amount added already for TPF number <b>$row->tpf_number</b></td></tr>";
                    break;

                case 'not_manageable':
                    $not_manageable .= "<tr><td>Savings amount not managed to pay membership fee for TPF number <b>$row->tpf_number</b></td></tr>";
                    break;

                case 'success':
                    $success .= "<tr><td>Savings amount worth ($row->amount) added successfully for TPF number <b>$row->tpf_number</b></td></tr>";
                    break;
            }
        }

        // The detailed payment updated report
        $succ_msg = $success . $member_not_exist . $not_manageable . $already_updated;
        $this->showSuccess($succ_msg, count($savingsList));
    }

    private function doSavingsPaymentUpdate($row, $settingObj)
    {
        // Make sure customer account exist
        $customerObj = \App\Models\CustomersMasterModel::where('tpf_number', '=', $row->tpf_number)->first();
        if ($customerObj == NULL)
            return 'member_not_exist';

        // Check whether savings log already added
        $is_log_exist = \App\Models\SavingsLogModel::where('tpf_number', '=', $customerObj->tpf_number)
            ->where('quarter', '=', Input::get('quarter'))
            ->first();
        if ($is_log_exist != NULL)
            return 'already_updated';

        // Is the member paid membership fee?
        if ($customerObj->paid_membership_fee == 0) {
            if ($row->amount < $settingObj->membership_fee)
                return 'not_manageable';

            // Add deduction log for membership fee
            $deductionObj = new \App\Models\DeductionLogModel;
            $deductionObj->tpf_number = $customerObj->tpf_number;
            $deductionObj->type = 1;
            $deductionObj->reason = 'Membership fees';
            $deductionObj->amount_deducted = $settingObj->membership_fee;
            $deductionObj->created_at = date('Y-m-d H:i:s');
            $deductionObj->save();

            // Update member has paid membership fee
            $customerObj->paid_membership_fee = 1;
            $customerObj->update();
        }

        // Add savings log
        $savingsObj = new \App\Models\SavingsLogModel;
        $savingsObj->tpf_number = $customerObj->tpf_number;
        $savingsObj->amount_paid = $row->amount;
        $savingsObj->quarter = Input::get('quarter');
        $savingsObj->created_at = $row->date;
        if ($savingsObj->save()) {
            // Update in customer master
            $savingsInfo = \App\Library\Payment::getTotalSavings($customerObj->tpf_number);
            $customerObj->savings_amount = $savingsInfo['netSavings'];
            $customerObj->update();
        }

        return 'success';
    }

    // Process advance loan payment(uploaded)
    public function postAdvanceLoanUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quarter' => 'required',
            'file' => 'required'
        ]);

        // Is validation done correctly?
        if ($validator->fails()) {
            $this->showError('validation', $validator->messages()->all());
        }

        // Read payment excel file and check is the file correct format?
        $advanceList = \App\Library\ExcelReader::getAdvancePaymentList($request, 'file', 'storage/repayments/advance');
        if (! isset($advanceList[0]) || ! isset($advanceList[0]['membershipno']) || ! isset($advanceList[0]['amount_deducted']) || ! isset($advanceList[0]['periodend'])) {
            $this->showError('file');
        }

        $member_not_exist = $not_manageable = $already_updated = $success = NULL;
        foreach ($advanceList as $key => $row) {
            switch ($this->doAdvancePaymentUpdate($row)) {
                case 'member_not_exist':
                    $member_not_exist .= "<tr><td>The member account does not exist for TPF number <b>$row->membershipno</b></td></tr>";
                    break;

                case 'not_manageable':
                    $not_manageable .= "<tr><td>Advance repayment amount not enough to manage for TPF number <b>$row->membershipno</b></td></tr>";
                    break;

                case 'already_updated':
                    $already_updated .= "<tr><td>Advance repayment already updated for TPF number <b>$row->membershipno</b></td></tr>";
                    break;

                case 'success':
                    $success .= "<tr><td>Advance repayment updated successfully for TPF number <b>$row->membershipno</b></td></tr>";
                    break;
            }
        }

        // The detailed payment updated report
        $succ_msg = $success . $member_not_exist . $not_manageable . $already_updated;
        $this->showSuccess($succ_msg, count($advanceList));
    }

    private function doAdvancePaymentUpdate($row)
    {
        // Make sure customer account exist
        $customerObj = \App\Models\CustomersMasterModel::where('tpf_number', '=', $row->membershipno)->first();
        if ($customerObj == NULL)
            return 'member_not_exist';

        // Is any advance loan exist for customer?
        $advanceLoanList = \App\Models\LoanDetailsModel::Join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
            ->where('loan_master.customer_id', '=', $customerObj->id)
            ->where('scheme_id', '=', '2')
            ->where('status', '=', '3')
            ->where('flag', '=', '1')
            ->orderBy('loan_master.created_at', 'asc')
            ->get();

        $updated = 0;
        foreach ($advanceLoanList as $val) {
            // Check whether payment log already added
            $is_log_exist = \App\Models\LoanPaymentLogModel::where('tpf_number', '=', $customerObj->tpf_number)
                ->where('loan_id', '=', $val->loan_id)
                ->where('quarter', '=', Input::get('quarter'))
                ->first();
            if ($is_log_exist != NULL) {
                $updated++;
                continue;
            }

            // Check whether member paid enough amount?
            // if ($val->total_loan_amount > $row->amount_deducted)
            if ($row->amount_deducted <= 0)
                return 'not_manageable';

            // Add payment log
            $paymentLogObj = new \App\Models\LoanPaymentLogModel;
            $paymentLogObj->loan_id = $val->loan_id;
            $paymentLogObj->tpf_number = $customerObj->tpf_number;
            $paymentLogObj->amount_paid = $row->amount_deducted;
            $paymentLogObj->quarter = Input::get('quarter');
            $paymentLogObj->created_at = $row->periodend;
            if ($paymentLogObj->save()) {
                // Update payment info
                $amountPaid = \App\Library\Payment::getTotalRepaymentAmt($val->loan_id);
                $amountToPay = $val->total_loan_amount - $amountPaid;
                $amountToPay = ($amountToPay <= 0) ? 0 : $amountToPay;
                $periodCompleted = intval($val->repay_period_completed) + 1;

                // $perTermAmount = ($val->repay_period - $periodCompleted!=0)
                //     ? $amountToPay / ($val->repay_period - $periodCompleted)
                //     : 0;

                // Now we are introducing partial repayment for the "advance" loan
                // So when the customer pay's insufficient amount for the loan, we should automatically increase repay period
                $repayPeriod = ($amountToPay > 0) ? intval($val->repay_period) + 1 : intval($val->repay_period);
                $isOutstanding = ($amountToPay > 0) ? 1 : 0;

                $perTermAmount = (($repayPeriod - $periodCompleted) != 0)
                    ? $amountToPay / ($repayPeriod - $periodCompleted)
                    : 0;

                $flag = ($amountToPay <= 0) ? 2 : 1;
                \App\Models\LoanAccountsDetailsModel::where('loan_id', '=', $val->loan_id)
                    ->update(array(
                        'amount_paid' => $amountPaid,
                        'amount_to_pay' => $amountToPay,
                        'repay_period' => $repayPeriod,
                        'repay_period_completed' => $periodCompleted,
                        'per_term_amount' => $perTermAmount,
                        'is_outstanding' => $isOutstanding,
                        'flag' => $flag
                    ));

                // We need to maintain how much the member being paid interest
                \App\Models\LoanPaymentLogModel::where('id', '=', $paymentLogObj->id)
                    ->update(array(
                        //'actual_amount' => $val->total_loan_amount,
                        'actual_amount' => $val->amount_to_pay,
                        'amount_to_pay' => $amountToPay
                    ));

                // Add transaction log for repayment
                $transactionObj = new \App\Models\LoanTransactionLogModel;
                $transactionObj->loan_id = $val->loan_id;
                $transactionObj->transaction = "Loan Repayment";
                $transactionObj->amount = $row->amount_deducted;
                $transactionObj->balance_amount = $amountToPay;
                $transactionObj->created_at = date('Y-m-d H:i:s');
                $transactionObj->save();

                return 'success';
            }
        }

        return ($updated == count($advanceLoanList)) ? 'already_updated' : 'success';
    }

    // Process credit loan payment(uploaded)
    public function postCreditLoanUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quarter' => 'required',
            'file' => 'required'
        ]);

        // Is validation done correctly?
        if ($validator->fails()) {
            $this->showError('validation', $validator->messages()->all());
        }

        // Read payment excel file and check is the file correct format?
        $creditList = \App\Library\ExcelReader::getCreditPaymentList($request, 'file', 'storage/repayments/loan');
        if (! isset($creditList[0]) || ! isset($creditList[0]['membershipno']) || ! isset($creditList[0]['amount_deducted']) || ! isset($creditList[0]['periodend'])) {
            $this->showError('file');
        }

        $member_not_exist = $not_manageable = $already_updated = $success = NULL;
        foreach ($creditList as $key => $row) {
            switch ($this->doCreditPaymentUpdate($row)) {
                case 'member_not_exist':
                    $member_not_exist .= "<tr><td>The member account does not exist for TPF number <b>$row->membershipno</b></td></tr>";
                    break;

                case 'not_manageable':
                    $not_manageable .= "<tr><td>Loan repayment amount not enough to manage for TPF number <b>$row->membershipno</b></td></tr>";
                    break;

                case 'already_updated':
                    $already_updated .= "<tr><td>Loan repayment already updated for TPF number <b>$row->membershipno</b></td></tr>";
                    break;

                case 'success':
                    $success .= "<tr><td>Loan repayment updated successfully for TPF number <b>$row->membershipno</b></td></tr>";
                    break;
            }
        }

        // The detailed payment updated report
        $succ_msg = $success . $member_not_exist . $not_manageable . $already_updated;
        $this->showSuccess($succ_msg, count($creditList));
    }

    private function doCreditPaymentUpdate($row)
    {
        // Make sure customer account exist
        $customerObj = \App\Models\CustomersMasterModel::where('tpf_number', '=', $row->membershipno)->first();
        if ($customerObj == NULL)
            return 'member_not_exist';

        // Is any credit loan exist for customer?
        $creditLoanList = \App\Models\LoanDetailsModel::Join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
            ->where('loan_master.customer_id', '=', $customerObj->id)
            ->where('scheme_id', '=', '1')
            ->where('status', '=', '3')
            ->where('flag', '=', '1')
            ->orderBy('loan_master.created_at', 'asc')
            ->get();

        $updated = 0;
        foreach ($creditLoanList as $val) {
            // Check whether payment log already added
            $is_log_exist = \App\Models\LoanPaymentLogModel::where('tpf_number', '=', $customerObj->tpf_number)
                ->where('loan_id', '=', $val->loan_id)
                ->where('quarter', '=', Input::get('quarter'))
                ->first();
            if ($is_log_exist != NULL) {
                $updated++;
                continue;
            }

            if ($val->per_term_amount > $row->amount_deducted)
                return 'not_manageable';

            // Add payment log
            $paymentLogObj = new \App\Models\LoanPaymentLogModel;
            $paymentLogObj->loan_id = $val->loan_id;
            $paymentLogObj->tpf_number = $customerObj->tpf_number;
            $paymentLogObj->amount_paid = $row->amount_deducted;
            $paymentLogObj->quarter = Input::get('quarter');
            $paymentLogObj->created_at = $row->periodend;
            if ($paymentLogObj->save()) {
                // Update payment info
                $amountPaid = \App\Library\Payment::getTotalRepaymentAmt($val->loan_id);
                $amountToPay = $val->amount_to_pay - $val->per_term_amount;
                $amountToPay = ($amountToPay <= 0) ? 0 : $amountToPay;
                $periodCompleted = intval($val->repay_period_completed) + 1;

                $perTermAmount = (($val->repay_period - $periodCompleted) != 0)
                    ? $amountToPay / ($val->repay_period - $periodCompleted)
                    : 0;

                $flag = ($amountToPay <= 0) ? 2 : 1;
                \App\Models\LoanAccountsDetailsModel::where('loan_id', '=', $val->loan_id)
                    ->update(array(
                        'amount_paid' => $amountPaid,
                        'amount_to_pay' => $amountToPay,
                        'repay_period_completed' => $periodCompleted,
                        'per_term_amount' => $perTermAmount,
                        'flag' => $flag
                    ));

                \App\Models\LoanPaymentLogModel::where('id', '=', $paymentLogObj->id)
                    ->update(array(
                        'actual_amount' => $val->amount_to_pay,
                        'amount_to_pay' => $amountToPay
                    ));

                // Add transaction log for repayment
                $transactionObj = new \App\Models\LoanTransactionLogModel;
                $transactionObj->loan_id = $val->loan_id;
                $transactionObj->transaction = "Loan Repayment";
                $transactionObj->amount = $row->amount_deducted;
                $transactionObj->balance_amount = $amountToPay;
                $transactionObj->created_at = date('Y-m-d H:i:s');
                $transactionObj->save();

                return 'success';
            }
        }

        return ($updated == count($creditLoanList)) ? 'already_updated' : 'success';
    }

    public function generateAdvancePaymentList()
    {
        // Is any advance loan exist for customers?
        $advanceLoanList = \App\Models\LoanDetailsModel::Join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
            ->Join('customers_master', 'loan_master.customer_id', '=', 'customers_master.id')
            ->select('tpf_number', 'first_name', 'last_name', 'total_loan_amount', 'per_term_amount')
            ->where('loan_master.scheme_id', '=', '2')
            ->where('loan_master.status', '=', '3')
            ->where('loan_approved.flag', '=', '1')
            ->orderBy('loan_master.created_at', 'asc')
            ->get();

        // Initialize the array which will be passed into the Excel generator.
        $paymentsList = [];

        // Define the Excel spreadsheet headers
        $paymentsList[] = ['txtCounter', 'membershipno', 'Given Names', 'Surnames', 'amount borrowed', 'Amt To be Deducted'];

        // Convert each collection into an array, and append it to the payments array.
        $i = 1;
        foreach ($advanceLoanList as $val) {
            $paymentsList[$i][] = $i;
            $paymentsList[$i][] = $val->tpf_number;
            $paymentsList[$i][] = $val->first_name;
            $paymentsList[$i][] = $val->last_name;
            $paymentsList[$i][] = $val->total_loan_amount;
            $paymentsList[$i][] = $val->per_term_amount;
            $i++;
        }

        \App\Library\ExcelReader::generateAdvanceRepaymentList($paymentsList);
    }

    public function generateCreditPaymentList()
    {
        // Is any credit loan exist for customers?
        $creditLoanList = \App\Models\LoanDetailsModel::Join('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')
            ->Join('customers_master', 'loan_master.customer_id', '=', 'customers_master.id')
            ->select('tpf_number', 'first_name', 'last_name', 'total_loan_amount', 'per_term_amount')
            ->where('loan_master.scheme_id', '=', '1')
            ->where('loan_master.status', '=', '3')
            ->where('loan_approved.flag', '=', '1')
            ->orderBy('loan_master.created_at', 'asc')
            ->get();

        // Initialize the array which will be passed into the Excel generator.
        $paymentsList = [];

        // Define the Excel spreadsheet headers
        $paymentsList[] = ['txtCounter', 'membershipno', 'Given Names', 'Surnames', 'amount borrowed', 'Amt To be Deducted'];

        // Convert each collection into an array, and append it to the payments array.
        $i = 1;
        foreach ($creditLoanList as $val) {
            $paymentsList[$i][] = $i;
            $paymentsList[$i][] = $val->tpf_number;
            $paymentsList[$i][] = $val->first_name;
            $paymentsList[$i][] = $val->last_name;
            $paymentsList[$i][] = $val->total_loan_amount;
            $paymentsList[$i][] = $val->per_term_amount;
            $i++;
        }

        \App\Library\ExcelReader::generateCreditRepaymentList($paymentsList);
    }

    public function getTotalLoans()
    {
        $paginate_length = Config::get('constants.paginate_length');

        $this->data['page_title'] = Config::get('constants.app_slug_name') . ' Loans';
        $this->data['total_loans'] = \App\Models\LoanDetailsModel::leftJoin('loan_approved', 'loan_master.id', '=', 'loan_approved.loan_id')->whereIn('loan_master.status', [1, 3])->orderBy('created_at', 'desc')->paginate($paginate_length);
        return view('admin.total_loans')->with($this->data);
    }

    // Download's sample payment document
    public function getForceDownload($fileType)
    {
        return \App\Library\Payment::download($fileType);
    }

    private function showError($type = NULL, $msg = NULL)
    {
        switch ($type) {
            case 'validation':
                $msg = implode('<br>', $msg);
                break;
            case 'file':
                $msg = 'Either the file cannot be processed (or) not a correct format.';
                break;
            default:
                $msg = '';
                break;
        }

        echo '<div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Report Status</h3></div>
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
        <tr><td>Status</td><td><span>Failed</span></td></tr>
        <tr><td>Reason</td><td><span>' . $msg . '</span></td></tr>
        </table></div></div>';
        exit;
    }

    private function showSuccess($msg = NULL, $total_items = 0)
    {
        echo '<div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Status Report</h3></div>
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
        <tr><td>Status</td><td><span>Success</span></td></tr>
        <tr><td>Message</td><td><span>Please check/review the below list carefully.</span></td></tr>
        </table></div></div>
        <div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Message</h3><h3 class="box-title pull-right">Total List: ' . $total_items . '</h3></div>
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
        ' . $msg . '
        </table></div></div>';
        exit;
    }

    function getImport()
    {
        $this->data['page_title'] = 'Upload Members';
        return view('admin.members_upload')->with($this->data);
    }

    function postImport(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'required']);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Read members excel file
            $membersList = \App\Library\ExcelReader::getMembersList($request, 'file', 'storage/members');
            if (empty($membersList)) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            foreach ($membersList as $key => $row) {
                $customerObj = \App\Models\CustomersMasterModel::where('tpf_number', '=', $row->membership_no)->first();
                if ($customerObj == NULL) {
                    $customer = new \App\Models\CustomersMasterModel;
                    $customer->first_name = trim($row->surnames);
                    $customer->last_name = trim($row->given_names);

                    $customer->gender = 0;
                    if (strtolower($row->sex) == 'female') {
                        $customer->gender = 1;
                    }

                    $customer->dob = '0000-00-00';
                    if ($row->dob != 'N/A' && strpos(strtolower($row->dob), 'yr') === false) {
                        $temp_str = str_replace('.', '-', $row->dob);
                        $customer->dob = date('Y-m-d', strtotime($temp_str));
                    } else if ($row->dob == 'N/A' && $row->age != 'N/A') {
                        $year = date('Y') - intval($row->age);
                        $customer->dob = $year . '-01-01';
                    }

                    if ($row->age != 'N/A') {
                        $customer->current_age = intval($row->age);
                    }

                    $customer->contact = trim($row->home_address);
                    $customer->mobile = trim($row->telephone);
                    $customer->tpf_number = trim($row->membership_no);
                    $customer->paid_membership_fee = 0;

                    $category_id = \App\Library\Customer::getTpfBasedCategory($row->membership_no);
                    if ($category_id != '') {
                        $customer->customer_category_id = $category_id;
                    }

                    if ($row->bank != '') {
                        $customer->bank_id = trim($row->bank);
                    }

                    $customer->account_no = trim($row->account_no);
                    $customer->job_title = trim($row->occupation);
                    $customer->ministry = trim($row->ministry_address);

                    $customer->retirement_date = '0000-00-00';
                    /*if ($row->date_of_retirement != 'N/A' && strpos(strtolower($row->date_of_retirement), 'yr') === false) {
                        $temp_str = str_replace(['.', '/'], ['-', '-'], $row->date_of_retirement);
                        $customer->retirement_date = date('Y-m-d', strtotime($temp_str));
                    }
                    if ($row->date_of_retirement == 'N/A' && $customer->dob != '0000-00-00') {*/
                    if ($customer->dob != '0000-00-00') {
                        $date = date_create($customer->dob);
                        date_add($date, date_interval_create_from_date_string('56 years'));
                        $customer->retirement_date = date_format($date, 'Y-m-d');
                    }

                    $customer->register_date = date('Y-m-d');
                    $customer->created_at = date('Y-m-d H:i:s');
                    $customer->status = '1';
                    $customer->save();

                    if ($row->beneficiary != '' && $row->beneficiary != 'N/A') {
                        $beneficiaryObj = new \App\Models\BeneficiaryModel;
                        $beneficiaryObj->customer_id = $customer->id;
                        $beneficiaryObj->beneficiary = trim($row->beneficiary);
                        $beneficiaryObj->save();
                    }
                } else {
                    $customerObj->first_name = trim($row->surnames);
                    $customerObj->last_name = trim($row->given_names);

                    $customerObj->gender = 0;
                    if (strtolower($row->sex) == 'female') {
                        $customerObj->gender = 1;
                    }

                    $customerObj->dob = '0000-00-00';
                    if ($row->dob != 'N/A' && strpos(strtolower($row->dob), 'yr') === false) {
                        $temp_str = str_replace('.', '-', $row->dob);
                        $customerObj->dob = date('Y-m-d', strtotime($temp_str));
                    } else if ($row->dob == 'N/A' && $row->age != 'N/A') {
                        $year = date('Y') - intval($row->age);
                        $customerObj->dob = $year . '-01-01';
                    }

                    if ($row->age != 'N/A') {
                        $customerObj->current_age = intval($row->age);
                    }

                    $customerObj->contact = trim($row->home_address);
                    $customerObj->mobile = trim($row->telephone);
                    $customerObj->tpf_number = trim($row->membership_no);
                    $customerObj->paid_membership_fee = 0;

                    $category_id = \App\Library\Customer::getTpfBasedCategory($row->membership_no);
                    if ($category_id != '') {
                        $customerObj->customer_category_id = $category_id;
                    }

                    if ($row->bank != '') {
                        $customerObj->bank_id = trim($row->bank);
                    }

                    $customerObj->account_no = trim($row->account_no);
                    $customerObj->job_title = trim($row->occupation);
                    $customerObj->ministry = trim($row->ministry_address);

                    $customerObj->retirement_date = '0000-00-00';
                    /*if ($row->date_of_retirement != 'N/A' && strpos(strtolower($row->date_of_retirement), 'yr') === false) {
                        $temp_str = str_replace(['.', '/'], ['-', '-'], $row->date_of_retirement);
                        $customer->retirement_date = date('Y-m-d', strtotime($temp_str));
                    }
                    if ($row->date_of_retirement == 'N/A' && $customer->dob != '0000-00-00') {*/
                    if ($customerObj->dob != '0000-00-00') {
                        $date = date_create($customerObj->dob);
                        date_add($date, date_interval_create_from_date_string('56 years'));
                        $customerObj->retirement_date = date_format($date, 'Y-m-d');
                    }

                    $customerObj->register_date = date('Y-m-d');
                    $customerObj->created_at = date('Y-m-d H:i:s');
                    $customerObj->status = '1';
                    $customerObj->update();
                }
            }

            Session::flash('flash_message', 'Member(s) imported successfully!');
            return redirect('admin/import/members');
        }
    }

    /*function postSalaryLevelImport(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'required']);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            // Get all salary level
            $salaryLevels = \App\Models\SalaryLevelModel::all();

            $membersList = [];
            foreach($membersList as $key => $row)
            {
                $customerObj = \App\Models\CustomersMasterModel::where('tpf_number', '=', $row->membership_no)->first();
                if ($customerObj != NULL)
                {
                    $salaryLevel = '';
                    foreach($salaryLevels as $salKey => $salRow)
                    {
                        if ($row->salary_level >= $salRow->salary_from && $row->salary_level <= $salRow->salary_to) {
                            $salaryLevel = $salRow->id;
                            break;
                        }
                    }

                    if ($salaryLevel == '') {
                        $segments = explode('.', $row->salary_level);
                        foreach($salaryLevels as $salKey => $salRow)
                        {
                            if ($segments[0] >= $salRow->salary_from && $segments[0] <= $salRow->salary_to) {
                                $salaryLevel = $salRow->id;
                                break;
                            }
                        }
                    }

                    if ($salaryLevel != '')
                    {
                        $customerObj->salary_level = $salaryLevel;
                        $customerObj->update();
                    }
                }
            }

            Session::flash('flash_message', 'Member(s) imported successfully!');
            return redirect('admin/import/members');
        }
    }*/
}
