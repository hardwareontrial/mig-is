<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskActivity extends Model
{
    protected $table = 'helpdesk_activity';
    protected $fillable = ['helpdesk_id','user_id','title','comment_id','created_at','updated_at'];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id')->select(['id', 'nik', 'name','email','photo']);
    }

    public function comment() {
        return $this->hasOne('App\Model\Helpdesk\HelpdeskComment', 'activity_id', 'id')->select(['activity_id','content']);
    }

    public function attachment() {
        return $this->hasMany('App\Model\Helpdesk\HelpdeskAttachment', 'activity_id', 'id')->select(['id', 'activity_id','filename','filepath']);
    }

}
