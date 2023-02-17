<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class EdocAssign extends Model
{
    protected $table = 'edoc_assign';
    protected $fillable = ['edoc_id','user_id','division_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')->select(['id', 'nik', 'name','email']);
    }

    public function division()
    {
        return $this->hasOne('App\Model\Division', 'id', 'division_id')->select(['id','name','description']);
    }
}
