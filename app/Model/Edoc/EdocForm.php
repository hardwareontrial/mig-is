<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class EdocForm extends Model
{
    public $timestamps = true;
    public $incrementing = false;

    protected $table = 'edoc_form';
    protected $fillable = ['id','title','status','jenis','revisi','filepath','created_by','updated_by','is_active'];
}
