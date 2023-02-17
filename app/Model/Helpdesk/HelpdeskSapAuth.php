<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskSapAuth extends Model
{
    public $timestamps = true;
    
    protected $table = 'helpdesk_sap_auth';
    protected $fillable = [
        'id','helpdesk_id','tcode','description','is_active',
        'created_at','updated_at','created_by','updated_by'
    ];
}
