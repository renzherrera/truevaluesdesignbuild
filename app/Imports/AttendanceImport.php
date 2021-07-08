<?php

namespace App\Imports;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AttendanceImport implements ToModel, WithStartRow ,WithMultipleSheets
{
    public function startRow(): int
    {
        return 5;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
          if(!Attendance::where('biometric_id', '=', $row[0])->where('attendance_date','=',\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]))->exists()) {
            if ($row['4'] === null ) {
                return null;
              }
        return new Attendance([
            'biometric_id' => $row[0],
            // 'attendance_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $row[3]),
            'attendance_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'first_onDuty' => $row[4],
            'first_offDuty' => $row[5],
            'second_onDuty' =>  $row[6],
            'second_offDuty' => $row[7],
          
        ]);
    }
    }

    public function sheets(): array
    {
        return [
            3 => $this,
        ];
    }

}
