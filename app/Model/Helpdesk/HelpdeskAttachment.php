<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskAttachment extends Model
{
    protected $table = 'helpdesk_attachment';
    protected $fillable = ['activity_id','filename','user_id','filepath'];
}
