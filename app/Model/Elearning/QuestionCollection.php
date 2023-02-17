<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class QuestionCollection extends Model
{
    public $timestamps = true;

    protected $table = 'okm_question_collection';
    protected $fillable = ['material_id','title','division_id','duration','minimum_score','is_active','created_at','updated_at',
                           'created_by','updated_by'];

    public function created_by()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    public function questions()
    {
        return $this->hasMany('App\Model\Elearning\QuestionContent','collection_id','id')->where('is_active','=',1);
    }

    public function material()
    {
        return $this->hasOne('App\Model\Elearning\Material','id','material_id');
    }

    public function raport()
    {
        return $this->hasMany('App\Model\Elearning\Raport','collection_id','id');
    }
}
