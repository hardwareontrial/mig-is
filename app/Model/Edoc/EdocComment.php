<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class EdocComment extends Model
{
    protected $table = 'edoc_comment';
    protected $fillable = ['activity_id','content'];
}
