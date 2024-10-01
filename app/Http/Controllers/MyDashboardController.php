<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Validator;
use Hash;
use PDF;

use App\Models\CustomersMasterModel;
use App\Models\LoanDetailsModel;

class MyDashboardController extends Controller
{
	/**
     * The page variables.
     *
     * @var array
     */
	public $data = array();
	
	/**
     * Contains user data.
     *
     * @var null
     */
	private $user_data = NULL;

	public function __construct()
	{
		$this->middleware('front');
		$this->user_data = Auth::guard('customer')->user();
	}

	public function index()
	{
		$this->data['user_data'] = $this->user_data;
		$this->data['page_title'] = 'Dashboard';
		return view('front.user.dashboard')->with($this->data);
	}

	public function getProfile()
	{
		$this->data['user_data'] = $this->user_data;
		$this->data['page_title'] = 'Profile';
		return view('front.user.profile')->with($this->data);
	}

	public function postProfile(Request $request)
	{
		$customer = CustomersMasterModel::find($this->user_data->id);
        
        $validator = Validator::make($request->all(), [
			'email' => 'required|email|unique:'.$customer->table.',email,'. $this->user_data->id .',id,deleted_at,NULL',
			'mobile' => 'Numeric',
			'account_no' => 'required|Numeric',
			'beneficiary' => 'required',
        ]);     

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
        	// Storing customer details
            $customer->email = $request->input('email');
            $customer->contact = $request->input('contact');
            $customer->mobile = $request->input('mobile');
            $customer->account_no = $request->input('account_no');
            $customer->beneficiary = $request->input('beneficiary');
            $customer->updated_at = date('Y-m-d H:i:s');
          
			if($customer->update())
			{
				Session::flash('flash_message', 'Profile updated successfully!');
				return redirect('profile'); 
			}

			return redirect()->back()->withErrors('Something went wrong. Please try later.');
        }
	}

	public function getChangePassword()
	{
		$this->data['page_title'] = 'Change Password';
		return view('front.user.change_password')->with($this->data);
	}

	public function postChangePassword(Request $request)
	{
		$customer = CustomersMasterModel::find($this->user_data->id);
        
        $validator = Validator::make($request->all(), [
			'current_password' => 'required',
			'password' => 'required|min:6|confirmed|different:current_password',
			'password_confirmation' => 'required|min:6'
        ]);     

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        elseif (Hash::check($request->input('current_password'), $customer->password))
        {
        	// Storing customer details
            $customer->password = Hash::make($request->input('password'));
            $customer->updated_at = date('Y-m-d H:i:s');
          
			if($customer->update())
			{
				Session::flash('flash_message', 'Password updated successfully!');
				return redirect('change-password'); 
			}
        }
        else
        {
            return redirect()->back()->withErrors('Password incorrect.');
        }
	}

	public function getLoanHistory()
	{
		$this->data['user_data'] = $this->user_data;
		$this->data['loan_history'] = LoanDetailsModel::where('customer_id', '=', $this->user_data->id)->get();
		$this->data['page_title'] = 'Loan History';
		return view('front.user.loan_history')->with($this->data);
	}

	public function getLoanDetail($loan_id = NULL)
	{
		$loan_data = LoanDetailsModel::whereRaw('MD5(id) = "'. $loan_id .'" AND customer_id = "'. $this->user_data->id .'"')->first();
		if ( ! $loan_data)
		{
			Session::flash('error_flash_message', 'The request no longer exist.');
			return redirect('loan-history');
		}

		$this->data['user_data'] = $this->user_data;
		$this->data['loan_data'] = $loan_data;
		$this->data['loan_status'] = $this->getLoanStatus($loan_data);
		$this->data['page_title'] = 'Loan Detail Information';
		return view('front.user.loan_detail')->with($this->data);
	}

	private function getLoanStatus($loan_data)
	{
		if ($loan_data->scheme_id == 2)
			return false;
		
		$loan_status = config('constants.loan_status');
		$state0_html = $state1_html = $state2_html = $state3_html = '';
		
		if ($loan_data->status == 0)
			$state0_html = ' class="active"';
		elseif ($loan_data->status == 1)
			$state1_html = ' class="active"';
		elseif ($loan_data->status == 2)
			$state2_html = ' class="active"';
		elseif ($loan_data->status == 3)
			$state3_html = ' class="active"';
		
		return '<div class="loan-status-container">
		<h1>Loan Current Status</h1><p class="fillstages">
		<span'. $state0_html .'>'. $loan_status[0] .'</span>&nbsp;<i class="fa fa-angle-double-right"></i>
		<span'. $state1_html .'>'. $loan_status[1] .'</span>&nbsp;<i class="fa fa-angle-double-right"></i>
		<span'. $state2_html .'>'. $loan_status[2] .'</span>&nbsp;<i class="fa fa-angle-double-right"></i>
		<span'. $state3_html .'>'. $loan_status[3] .'</span>
		</p></div>';
	}

	public function getLoanPdf($loan_id = NULL)
    {
    	$loan_data = LoanDetailsModel::whereRaw('MD5(id) = "'. $loan_id .'" AND customer_id = "'. $this->user_data->id .'"')->first();
    	if ( ! $loan_data)
		{
			Session::flash('error_flash_message', 'The request no longer exist.');
			return redirect('loan-history');
		}
		
		$this->data['user_data'] = $this->user_data;
		$this->data['loan_data'] = $loan_data;
		$pdf = PDF::loadView('pdf.loan_detail', $this->data);
		return $pdf->download($loan_data->id .'.pdf');
    }

    public function getShareHistory()
    {
    	$this->data['user_data'] = $this->user_data;
		$this->data['share_history'] = LoanDetailsModel::where('customer_id', '=', $this->user_data->id)->get();
		$this->data['page_title'] = 'Share Balance History';
		return view('front.user.share_history')->with($this->data);
    }
}
