<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    protected $table = 'helpdesk';
    protected $fillable = ['id','title','creator_id','date_start','date_end',
                            'type','privilege','satus'];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_id');
    }

    public function assign()
    {
        return $this->hasMany('App\Model\Helpdesk\HelpdeskAssign', 'helpdesk_id', 'id');
    }

    public function md_form()
    {
        return $this->hasOne('App\Model\Helpdesk\HelpdeskSapForm', 'helpdesk_id', 'id')
        ->whereIn('request_type', ['New Master Data', 'Change Master Data', 'Delete Master Data']);
    }

    public function auth_form()
    {
        return $this->hasOne('App\Model\Helpdesk\HelpdeskSapForm', 'helpdesk_id', 'id')
        ->whereIn('request_type', ['Authorization', 'New User', 'Delete User']);
    }
}
