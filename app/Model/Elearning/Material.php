<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $timestamps = true;

    protected $table = 'okm_material';
    protected $fillable = ['id','title','division_id','level','sinopsis','hours','is_active','created_at','updated_at',
                           'created_by','updated_by'];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    public function division()
    {
        return $this->hasOne('App\Model\Division','id','division_id');
    }

    public function content()
    {
        return $this->hasMany('App\Model\Elearning\MaterialContent','material_id','id');
    }

    public function collection()
    {
        return $this->hasMany('App\Model\Elearning\QuestionCollection','material_id','id');
    }
}
