<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Subordinate extends Model
{
    protected $table = 'subordinate';
    protected $fillable = ['id','parent_id'];

    public function user()
    {
        return $this->hasOne('App\User','id','id');
    }
    
}
