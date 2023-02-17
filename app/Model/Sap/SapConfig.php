<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapConfig extends Model
{
    protected $table = "helpdesk_sap_config";
    protected $primaryKey = "id";

    protected $fillable = [
                            "helpdesk_id", "description", "created_at", "created_by", 
                            "updated_at", "updated_by","is_active"
                        ];


}
