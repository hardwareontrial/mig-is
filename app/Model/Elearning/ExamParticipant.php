<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class ExamParticipant extends Model
{
    public $timestamps = true;

    protected $table = 'okm_exam_participant';
    protected $fillable = ['id','schedule_id','nik','created_at','updated_at',
                           'created_by','updated_by','is_active'];

    public function created_by()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'nik', 'nik');
    }
	
	public function raport()
    {
        return $this->hasOne('App\Model\Elearning\Raport', 'nik', 'nik');
    }
}
