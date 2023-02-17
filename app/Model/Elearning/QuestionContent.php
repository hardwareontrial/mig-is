<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class QuestionContent extends Model
{
    public $timestamps = true;

    protected $table = 'okm_question';
    protected $fillable = ['id','collection_id','question','is_active','created_at','updated_at',
                           'created_by','updated_by'];

    public function created_by()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    public function answers()
    {
        return $this->hasMany('App\Model\Elearning\QuestionAnswer','question_content_id','id');
    }
	
	//Dwiki Create Model
	 public function question_answers()
    {
        return $this->hasMany('App\Model\Elearning\QuestionAnswer','question_content_id','id');
    }

    public function user_answers()
    {        
        // return $this->belongsToOne('App\Model\Elearning\ExamUserAnswer','question_id', 'id');
        return $this->hasOne('App\Model\Elearning\ExamUserAnswer','question_id', 'id');
    }

}
