<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class PaymentExport implements FromCollection
{
    protected  $paymentsList;

    public function __construct($paymentsList)
    {
        $this->paymentsList = $paymentsList;
    }

    public function collection()
    {
        return collect($this->paymentsList);
    }
}
