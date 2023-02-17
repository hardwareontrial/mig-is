<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class MaterialContent extends Model
{
    protected $table = 'okm_material_content';
    protected $fillable = ['id','material_id', 'description', 'filepath', 'created_at', 'created_by',
                            'updated_at', 'updated_by', 'is_active'];
}
