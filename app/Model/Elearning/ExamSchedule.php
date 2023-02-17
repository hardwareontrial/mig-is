<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExamSchedule extends Model
{
    public $timestamps = true;

    protected $table = 'okm_exam_schedule';
    protected $fillable = ['id','collection_id','description','duration','program','date_start','date_end','is_active','created_at','updated_at',
                           'created_by','updated_by'];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    public function collection()
    {
        return $this->hasOne('App\Model\Elearning\QuestionCollection', 'id', 'collection_id');
    }

    public function raport()
    {
        return $this->hasOne('App\Model\Elearning\Raport', 'schedule_id', 'id')->where("nik","=",Auth::user()->nik);
    }

    public function participants()
    {
        return $this->hasMany('App\Model\Elearning\ExamParticipant', 'schedule_id', 'id');
    }
}
