<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapIT extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_it';
    protected $fillable = ['id','user_id','type','is_active','created_at','updated_at','created_by','updated_by'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
