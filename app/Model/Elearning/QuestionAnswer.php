<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    public $timestamps = true;

    protected $table = 'okm_question_answer';
    protected $fillable = ['id','question_content_id','answer','answer_key','created_at','updated_at',
                           'created_by','updated_by'];

    public function created_by()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
