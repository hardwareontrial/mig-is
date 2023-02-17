<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik', 'name', 'email', 'division_id', 'position_id', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function position()
    {
        return $this->hasOne('App\Model\Position', 'id', 'position_id');
    }

    public function division()
    {
        return $this->hasOne('App\Model\Division', 'id', 'division_id');
    }

    public function subordinates()
    {
        return $this->hasMany('App\Model\Subordinate','parent_id','id');
    }
	
	public function division_subordinates()
    {
        return $this->hasMany('App\User','division_id','division_id')->where('is_active','=',1);
    }

    public static function GetAllUsers() 
    {
        return DB::table('users')->where('is_active','=',1)
        ->whereNotIn('id',[1,2,101,102,103,130])->get();
    }
}
