<?php

namespace App\Model\Helpdesk;

use Illuminate\Database\Eloquent\Model;

class HelpdeskComment extends Model
{
    protected $table = 'helpdesk_comment';
    protected $fillable = ['activity_id','content'];
}
