<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $helpdesk = $user->hasAnyPermission(Permission::whereIn('id',array(1,2,3,4,5))->get()->pluck('name')->toArray());
        $edoc = $user->hasAnyPermission(Permission::whereIn('id',range(6,23))->get()->pluck('name')->toArray());
        $okm = $user->hasAnyPermission(Permission::whereIn('id',array(1,24,29,28,29,30,31))->get()->pluck('name')->toArray());
        $asset = $user->hasAnyPermission(Permission::whereIn('id',array(1,26))->get()->pluck('name')->toArray());
        $uac = $user->hasAnyPermission(Permission::where('id','=',1)->get()->pluck('name')->toArray());
		$phonebook = $user->hasAnyPermission(Permission::whereIn('id',array(44,43,42,41))->get()->pluck('name')->toArray());

        return view('general/menu',compact('helpdesk','edoc','okm','asset','uac','phonebook'));
    }
}
