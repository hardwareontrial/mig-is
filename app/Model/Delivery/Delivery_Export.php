<?php

namespace App\Model\Delivery;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Delivery_Export extends Model
{
    public static function Delivery_export_data(){
        return DB::table('delivery_transactions as A')
                    ->join('delivery_detail as B', 'A.delivery_id', 'B.del_delivery_id')
                    ->join('delivery_activity as C', 'A.delivery_id', 'C.del_delivery_id')
                    ->Join('users as D', 'D.id', 'C.del_act_user_id')
                    ->select("A.delivery_no", "B.del_det_customer", "B.del_det_address", "B.del_det_city", 
                              "B.del_det_item", "B.del_det_qty", "B.del_det_um", "D.name","A.delivery_created_at")
                    ->whereRaw('C.del_act_name = "Create Delivery" or C.del_act_name = "Create & Print Delivery"')                            
                    ->orderBy('A.delivery_id', 'ASC');        
    }
}
