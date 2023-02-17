<?php

namespace App\Model\Delivery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Delivery_Transactions extends Model
{
    protected $table = "delivery_transactions";

    protected $fillable = [
                            "delivery_no",
                            "delivery_created_by",
                            "delivery_is_status",
                            "delivery_print_count",							
							"delivery_is_remark",
							"delivery_invoice_no",
                            'do_no',
                            'po_no'
                        ];

    protected $primaryKey = "delivery_id";

    const CREATED_AT = "delivery_created_at";
    const UPDATED_AT = "delivery_updated_at";

    public static function delivery_view(){

        return DB::table('delivery_transactions as A')
                  ->leftjoin('delivery_detail as B', 'B.del_delivery_id', 'A.delivery_id' )
                  ->leftJoin("users as C", "C.id", "A.delivery_created_by")
                  ->select('A.delivery_id','A.delivery_no as delivery_no', 'A.delivery_created_at as datetime', 'A.do_no', 'A.po_no',
                           'A.delivery_id as id','A.delivery_invoice_no','A.delivery_is_remark',
                           'B.del_det_customer as customer',
                           'B.del_det_address as address', 'B.del_det_city as city',
                           'B.del_det_vehicles_no as vehicles_no', 'B.del_det_driver as driver',
                           'B.del_det_item as item','B.del_det_qty as qty',
                           'B.del_det_um as um','B.del_det_date_send as tgl_kirim',
                           "C.name as creator");

    }

}