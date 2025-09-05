<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

/**
 * Configuration for the import of customers from an Excel file.
 */
class CustomersImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        return Customer::updateOrCreate(
            ['user_id' => auth()->id(), 'email' => $row['email']],
            $row->toArray()
        );
    }

    /**
     * Our schema has a unique constraint on the combination of user_id and email.
     */
    public function uniqueBy()
    {
        return ['user_id', 'email'];
    }
}
