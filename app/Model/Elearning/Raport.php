<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    public $timestamps = true;

    protected $table = 'okm_raport';
    protected $fillable = ['id','nik','collection_id','schedule_id','hours','score','status', 'start_at', 'finish_at','created_at','updated_at', 'created_by','updated_by','is_active'];

    public function user()
    {
        return $this->hasOne('App\User', 'nik', 'nik');
    }
    
    public function exam()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function schedule()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function schedule_collection()
    {
        return $this->hasOne('App\Model\Elearning\ExamSchedule', 'id', 'schedule_id');
    }
}
