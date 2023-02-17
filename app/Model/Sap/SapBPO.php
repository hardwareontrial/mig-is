<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapBPO extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_bpo';
    protected $fillable = ['id','user_id','sap_user_id','is_active','created_at','updated_at','created_by','updated_by'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function user_sap()
    {
        return $this->hasOne('App\Model\Sap\SapUser', 'id', 'sap_user_id');
    }
}
