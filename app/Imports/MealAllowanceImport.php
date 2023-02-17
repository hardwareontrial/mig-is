<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Helpers\GlobalHelper;
use App\Model\Hris\MealAllowance;

class MealAllowanceImport implements ToCollection, WithHeadingRow, 
WithBatchInserts, WithChunkReading 
{
    /**
    * @param Collection $collection
    */
    // protected $periode_start, $periode_end, $note;
    protected $data_array;

    public function __construct($id)
    {
        $this->master_id = $id;
    }

    public function collection(Collection $rows)
    {
        foreach($rows as $r){           
            $insert_meal_allowance = MealAllowance::create([
                'master_id'=> $this->master_id,
                'nik' => $r['nik'],
                'date' => globalhelper::convert_excel_date($r['date']),
                'meal_allowance_val'=> $r['uang_makan'],
                'overtime_val' => $r['uang_lembur'],
                'overtime_hour' => $r['jam_lembur'],
                'meal_overtime_val' => $r['um_lembur'],
                'note' => $r['note']
            ]);
        }
    }

    public function headingRow(): int
    {
        return 4;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

// class MealAllowanceImport implements ToModel, 
// WithHeadingRow, WithBatchInserts, WithChunkReading
// {
//     public function model(Array $rows){
//        foreach($rows as $r){
//             echo $r;
//        }
//     }

//     public function headingRow(): int
//     {
//         return 3;
//     }

//     public function batchSize(): int
//     {
//         return 1000;
//     }public function chunkSize(): int
//     {
//         return 1000;
//     }
// }