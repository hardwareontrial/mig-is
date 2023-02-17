<?php

namespace App\Model\Edoc;

use Illuminate\Database\Eloquent\Model;

class EdocDocument extends Model
{
    public $timestamps = true;
    public $incrementing = false;

    protected $table = 'edoc_document';
    protected $fillable = ['id','title','status','jenis','jenis_keterangan','revisi','word_filepath','pdf_filepath',
                           'created_by','updated_by','is_active'];
}
