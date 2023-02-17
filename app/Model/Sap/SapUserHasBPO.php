<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapUserHasBPO extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_user_has_bpo';
    protected $fillable = ['id','sap_user_id','sap_user_bpo_id','is_active','created_at','updated_at','created_by','updated_by'];

    public function user()
    {
        return $this->hasOne('App\Model\Sap\SapUser', 'id', 'sap_user_id');
    }

    public function bpo()
    {
        return $this->hasOne('App\Model\Sap\SapUser', 'id', 'sap_user_bpo_id');
    }
}
