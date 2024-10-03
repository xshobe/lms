<?php

namespace App\Library;

use App\Exports\PaymentExport;
use App\Imports\MyDataImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReader
{

    public static $filePath = '';

    // Upload and read excel file(savings)
    public static function getSavingsPaymentList($request, $tag = '', $upload_path = '', $remove_file = false)
    {
        if (self::handleUpload($request, $tag, $upload_path) == false) {
            return false;
        }

        // $savingsPaymentList = Excel::selectSheetsByIndex(0)->load(self::$filePath, function ($reader) {})->formatDates(true, 'Y-m-d')->get(array('tpf_number', 'amount', 'date'));

        $savingsPaymentList = new MyDataImport;
        Excel::import($savingsPaymentList, self::$filePath);

        self::destroyUploaded($remove_file);

        return $savingsPaymentList;
    }

    // Upload and read excel file(advance repaid)
    public static function getAdvancePaymentList($request, $tag = '', $upload_path = '', $remove_file = false)
    {
        if (self::handleUpload($request, $tag, $upload_path) == false) {
            return false;
        }

        // $advancePaymentList = Excel::selectSheetsByIndex(0)->load(self::$filePath, function ($reader) {})->formatDates(true, 'Y-m-d')->get(array('periodend', 'membershipno', 'amount_deducted'));

        $advancePaymentList = new MyDataImport;
        Excel::import($advancePaymentList, self::$filePath);

        self::destroyUploaded($remove_file);

        return $advancePaymentList;
    }

    // Upload and read excel file(credit repaid)
    public static function getCreditPaymentList($request, $tag = '', $upload_path = '', $remove_file = false)
    {
        if (self::handleUpload($request, $tag, $upload_path) == false) {
            return false;
        }
        $creditPaymentList = new MyDataImport;
        Excel::import($creditPaymentList, self::$filePath);

        self::destroyUploaded($remove_file);

        return $creditPaymentList;
    }

    // Upload and read excel file(credit repaid)
    public static function getMembersList($request, $tag = '', $upload_path = '', $remove_file = false)
    {
        if (self::handleUpload($request, $tag, $upload_path) == false) {
            return false;
        }

        $membersList = new MyDataImport;
        Excel::import($membersList, self::$filePath);
        self::destroyUploaded($remove_file);

        return $membersList;
    }

    // Generate excel file(member credit loan to be paid)
    public static function generateCreditRepaymentList($paymentsList)
    {
        $fileName = 'credit-loan-repayment-' . date('dmY');
        return Excel::download(new PaymentExport($paymentsList), $fileName . '.xlsx');
    }

    // Generate excel file(member credit loan to be paid)
    public static function generateAdvanceRepaymentList($paymentsList)
    {
        $fileName = 'advance-loan-repayment-' . date('dmY');
        return Excel::download(new PaymentExport($paymentsList), $fileName . '.xlsx');
    }

    // Upload file
    private static function handleUpload($request, $tag, $upload_path)
    {
        if (! $request->hasFile($tag) || ! $request->file($tag)->isValid())
            return false;

        $fileName = date('dmYhis') . '.' . $request->file($tag)->getClientOriginalExtension();
        self::$filePath = $upload_path . '/' . $fileName;
        return $request->file($tag)->move($upload_path, $fileName);
    }

    // Destroy's uploaded file
    private static function destroyUploaded($remove_file)
    {
        if ($remove_file)
            @unlink(base_path() . '/' . self::$filePath);

        return true;
    }
}
