<?php

namespace App\Library;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReader {

	public static $filePath='';

	// Upload and read excel file(savings)
	public static function getSavingsPaymentList($request, $tag = '', $upload_path = '', $remove_file = false)
	{
		if (self::handleUpload($request, $tag, $upload_path) == false)
			return false;
		
		$savingsPaymentList = Excel::selectSheetsByIndex(0)->load(self::$filePath, function($reader) {
        })->formatDates(true, 'Y-m-d')->get(array('tpf_number', 'amount', 'date'));

        self::destroyUploaded($remove_file);

        return $savingsPaymentList;
	}

	// Upload and read excel file(advance repaid)
	public static function getAdvancePaymentList($request, $tag = '', $upload_path = '', $remove_file = false)
	{
		if (self::handleUpload($request, $tag, $upload_path) == false)
			return false;
		
		$advancePaymentList = Excel::selectSheetsByIndex(0)->load(self::$filePath, function($reader) {
        })->formatDates(true, 'Y-m-d')->get(array('periodend', 'membershipno', 'amount_deducted'));

        self::destroyUploaded($remove_file);

        return $advancePaymentList;
	}

	// Upload and read excel file(credit repaid)
	public static function getCreditPaymentList($request, $tag = '', $upload_path = '', $remove_file = false)
	{
		if (self::handleUpload($request, $tag, $upload_path) == false)
			return false;
		
		$creditPaymentList = Excel::selectSheetsByIndex(0)->load(self::$filePath, function($reader) {
        })->formatDates(true, 'Y-m-d')->get(array('periodend', 'membershipno', 'amount_deducted'));

        self::destroyUploaded($remove_file);

        return $creditPaymentList;
	}
    
    // Upload and read excel file(credit repaid)
	public static function getMembersList($request, $tag = '', $upload_path = '', $remove_file = false)
	{
		if (self::handleUpload($request, $tag, $upload_path) == false)
			return false;
		
		$membersList = Excel::selectSheetsByIndex(0)->load(self::$filePath, function($reader) {
        })->formatDates(false)->get(array('surnames', 'given_names', 'membership_no', 'dob', 'age', 'sex', 'ministry_address', 'telephone', 'occupation', 'date_of_retirement', 'bank', 'account_no', 'beneficiary', 'home_address'));

        self::destroyUploaded($remove_file);

        return $membersList;
	}

	// Generate excel file(member credit loan to be paid)
	public static function generateCreditRepaymentList($paymentsList)
	{
		$fileName='credit-loan-repayment-'.date('dmY');
		Excel::create($fileName, function($excel) use($paymentsList) {
            $excel->sheet('Sheet1', function($sheet) use($paymentsList) {
                $sheet->fromArray($paymentsList, null, 'A1', false, false);
            });
        })->export('xls');
	}

	// Generate excel file(member credit loan to be paid)
	public static function generateAdvanceRepaymentList($paymentsList)
	{
		$fileName='advance-loan-repayment-'.date('dmY');
		Excel::create($fileName, function($excel) use($paymentsList) {
            $excel->sheet('Sheet1', function($sheet) use($paymentsList) {
                $sheet->fromArray($paymentsList, null, 'A1', false, false);
            });
        })->export('xls');
	}
	
	// Upload file
	private static function handleUpload($request, $tag, $upload_path)
	{
		if ( ! $request->hasFile($tag) || ! $request->file($tag)->isValid())
			return false;
		
		$fileName = date('dmYhis') .'.'. $request->file($tag)->getClientOriginalExtension();
		self::$filePath = $upload_path .'/'. $fileName;
		return $request->file($tag)->move($upload_path, $fileName);
	}

	// Destroy's uploaded file
	private static function destroyUploaded($remove_file)
	{
		if ($remove_file)
			@unlink(base_path() .'/'. self::$filePath);
		
		return true;
	}
}
