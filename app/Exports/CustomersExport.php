<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class CustomersExport implements FromCollection, WithHeadings, WithColumnWidths,WithStyles 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::all();
    }
    public function headings(): array
    {
        return ['ID', 'First Name', 'Last Name', 'Age', 'Date of Birth', 'Email Address'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, 
            'B' => 20, 
            'C' => 20, 
            'D' => 10, 
            'E' => 20, 
            'F' => 30, 
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Make the first row (headings) bold
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
    }
}
