<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapRegion extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_region';
    protected $fillable = ['id','code','name','is_active','created_at','updated_at','created_by','updated_by'];

}
