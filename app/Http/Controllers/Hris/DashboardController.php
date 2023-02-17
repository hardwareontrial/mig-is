<?php

namespace App\Http\Controllers\Hris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{

    public function __construct()
    {
        if(!(Auth::check())){Return redirect('/');}
    }
    public function index(){
        return view("hris.dashboard.index");
    }
    
}
