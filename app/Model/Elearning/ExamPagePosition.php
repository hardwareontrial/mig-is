<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExamPagePosition extends Model
{
    public $timestamps = true;

    protected $table = 'okm_user_page_position';
    protected $fillable = ['id','nik','schedule_id','page','is_active','created_at','updated_at',
                           'created_by','updated_by'];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
