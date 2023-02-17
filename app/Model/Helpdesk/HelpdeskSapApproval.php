<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskSapApproval extends Model
{
    protected $table = 'helpdesk_sap_approval';
    protected $fillable = [	'helpdesk_id','bpo_id','bpo_approve','bpo_act_at',
							'fico_head_id','fico_head_approve','fico_head_act_at','it_id',
							'proman_id', 'proman_approve', 'proman_act_at',
							'it_approve','it_act_at','created_at','updated_at','created_by','updated_by'];

    public function bpo() {
        return $this->hasOne('App\User', 'id', 'bpo_id');
    }

    public function controlling() {
        return $this->hasOne('App\User', 'id', 'controlling_id');
    }

}
