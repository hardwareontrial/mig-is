<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapAbap extends Model
{
    protected $table = "helpdesk_sap_abap";

    protected $fillable = ['id','helpdesk_id', 'type', 'tcode', 'description',
                            'created_at', 'created_by', 'updated_at', 'updated_by',
                            'is_active'];
                            
}
