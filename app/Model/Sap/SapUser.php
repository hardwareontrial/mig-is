<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapUser extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_users';
    protected $fillable = ['id','username','type','is_active','created_at','updated_at','created_by','updated_by'];
}
