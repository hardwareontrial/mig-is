<?php

namespace App\Model\hris;

use Illuminate\Database\Eloquent\Model;

class Allowance_Import_Master extends Model
{
    protected $table = "hris_allowance_import_master";
    protected $fillable = ['id', 'transactions_type', 'periode_start', 'periode_end', 
                            'file_name', 'note','quotes', 'created_by'];

    public function detail_mealallowance(){
        return $this->hasmany('App\Model\Hris\MealAllowance', 'master_id', 'id');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'created_by');
    }

}
