<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MyDataImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */

    public $data;

    public function collection(Collection $rows): array
    {
        $data = $rows->first()->toArray(); // Get headers from the first row
        return $this->data = $data;
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'A' => NumberFormat::FORMAT_DATE_DMYMINUS,
    //     ];
    // }
}
