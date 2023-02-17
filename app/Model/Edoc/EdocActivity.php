<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class EdocActivity extends Model
{
    protected $table = 'edoc_activity';
    protected $fillable = ['edoc_id','user_id','title','comment_id','created_at','updated_at'];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id')->select(['id', 'nik', 'name','email','photo']);
    }

    public function comment() {
        return $this->hasOne('App\Model\Edoc\EdocComment', 'activity_id', 'id')->select(['activity_id','content']);
    }

    public function attachment() {
        return $this->hasMany('App\Model\Edoc\EdocAttachment', 'activity_id', 'id')->select(['id', 'activity_id','filename','filepath']);
    }

}
