<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskSapForm extends Model
{
    protected $table = 'helpdesk_sap_form';
    protected $fillable = ['request_type','helpdesk_id','user_id','username'];

    public function master_data() {
        return $this->hasMany('App\Model\Helpdesk\HelpdeskMasterData','form_id','id');
    }

    public function auth_data() {

    }
}
