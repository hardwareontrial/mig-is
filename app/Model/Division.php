<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Division extends Model
{
    protected $table = 'divisions';
    protected $fillable = ['id','name','description'];

    public static function getAll()
    {
        return DB::table('divisions')->get();
    }
    
}
