<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapTitle extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_title';
    protected $fillable = ['id','title','is_active','created_at','updated_at','created_by','updated_by'];

}
