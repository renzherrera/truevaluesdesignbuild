<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
           'first_name' => $row['first_name'],
           'middle_name' => $row['middle_name'],
           'last_name' => $row['last_name'],
           'contact' => $row['contact'],
           'date_of_birth' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']),
           'gender' => $row['gender'],
           'position_id' => $row['position_id'],
           'schedule_id' => $row['schedule_id'],
           'project_id' => $row['project_id'],
           'address' => $row['address'],
           'status' => $row['status'],
        ]);
    }
}
