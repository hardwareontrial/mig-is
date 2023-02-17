<?php

namespace App\Model\Delivery;

use Illuminate\Database\Eloquent\Model;

class Delivery_Activity extends Model
{
    protected $table = "delivery_activity";

    protected $fillable = [
                           'del_delivery_id',
                           'del_act_name',
                           'del_act_name',
                           'del_act_user_id'
                        ];

    protected $primarykey = "del_id";

    const CREATED_AT = "del_act_created";
    const UPDATED_AT = "del_act_updated";
}

