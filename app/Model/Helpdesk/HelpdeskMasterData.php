<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskMasterData extends Model
{
    protected $table = 'helpdesk_sap_master_data';
    protected $fillable = ['form_id','type','code','description'];
}
