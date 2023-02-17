<?php

namespace App\Model\Delivery;

use Illuminate\Database\Eloquent\Model;

class Delivery_Detail extends Model
{
    protected $table = "delivery_detail";

    protected $fillable = ["del_delivery_id",
                           "del_det_customer",
                           "del_det_address", 
                           "del_det_city", 
                           "del_det_vehicles_no",
                           "del_det_driver",
                           "del_det_item",
                           "del_det_qty", 
                           "del_det_um",
                           "del_det_date_send",
                        ];

    protected $primaryKey = "del_det_id";

}
