<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class EdocAttachment extends Model
{
    protected $table = 'edoc_attachment';
    protected $fillable = ['activity_id','filename','filepath'];
}
