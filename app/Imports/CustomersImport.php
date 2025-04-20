<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['email_address'])) {
            return null;
        }

        if (!filter_var($row['email_address'], FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        if (Customer::where('email', strtolower($row['email_address']))->exists()) {
            return null;
        }

        $dob = $row['date_of_birth'] ?? $row['dob'] ?? null;
        $formattedDob = null;

        if ($dob) {
            if (is_numeric($dob)) {
                $formattedDob = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dob)->format('Y-m-d');
            } else {
                $formattedDob = date('Y-m-d', strtotime(str_replace('/', '-', $dob)));
            }

            // Optional: Skip future DOBs
            if (strtotime($formattedDob) > time()) {
                return null;
            }
        }

        return new Customer([
            'first_name' => ucwords(strtolower($row['first_name'] ?? '')),
            'last_name' => ucwords(strtolower($row['last_name'] ?? '')),
            'email' => strtolower($row['email_address']),
            'age' => (int) $row['age'],
            'dob' => $formattedDob,
        ]);
    }

}



