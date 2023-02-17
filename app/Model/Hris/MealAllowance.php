<?php

namespace App\Model\Hris;

use Illuminate\Database\Eloquent\Model;

class MealAllowance extends Model
{
    protected $table = "hris_meal_allowance";
    protected $fillable = [ 'master_id', 'nik', 'date', 'meal_allowance_val', 
                            'overtime_val', 'overtime_hour', 'meal_overtime_val','note'];

    public function master_mealallowance(){
        return $this->hasOne('App\Model\Hris\Allowance_Import_Master', 'id', 'master_id');
    }

    public function User(){
        return $this->hasOne('App\User', 'nik', 'nik');
    }
}
