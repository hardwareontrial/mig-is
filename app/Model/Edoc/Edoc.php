<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class Edoc extends Model
{
    public $timestamps = true;
    public $incrementing = false;

    protected $table = 'edoc';
    protected $fillable = ['id','iso_id','iso_type','title','creator_id','date_start','date_end','type','privilege',
                            'status','approve','created_by','updated_by'];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_id');
    }

    public function assign()
    {
        return $this->hasMany('App\Model\Edoc\EdocAssign', 'edoc_id', 'id');
    }
}
