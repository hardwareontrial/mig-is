<?php
    namespace App\Helpers;

    class GlobalHelper{
        // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0][3]));
        public static function convert_excel_date ($excel_date){
            // $excelDate = 43407; //2018-11-03
            $miliseconds = ($excel_date - (25567 + 2)) * 86400 * 1000;
            $seconds = $miliseconds / 1000;
            return date("Y-m-d", $seconds); 
        }

    }

?>