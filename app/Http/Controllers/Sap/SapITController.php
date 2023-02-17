<?php

namespace App\Http\Controllers\Sap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Model\Position;
use App\Model\Subordinate;
use App\Model\Division;
use App\Model\Sap\SapIT;
use App\Model\Sap\SapProjectManag;
use App\Model\Sap\SapUser;
use Maatwebsite\Excel\Facades\Excel;
// use DB;
use Session;

class SapITController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
				
        $keyword = $request->keyword;
        // $users = SapIT::with('user')
        $users = DB::table('sap_it as A')
                ->join('users as B', 'A.user_id', 'B.id')            
                ->whereRaw("B.name LIKE '%".$keyword."%'")
                ->select('A.id as id','A.type', 'B.name')
                ->where('A.is_active',1)
                ->orderBy('A.id', 'ASC')->paginate(10);
        $users->appends($request->only('keyword'));              
        
        $roles = Role::get();
        $positions = Position::get();
        
        return view('sap.userit.index', compact('users','roles','positions','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('is_active',1)->get();
        return view('sap.userit.create', compact('users'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
			
        $insert = SapIT::create([
            'user_id' => $request->users,
            'type'=>$request->type_users
        ]);		
        if($insert){
            return redirect()->route('sap_it.index')
                            ->with('success', 'created data successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $users_web = User::where('is_active', 1)->get();
        $users_it = SapIT::where('id', $id)->first();        

        return view('sap.userit.edit',compact('users_web','users_it'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {		
        $update = SapIT::findOrFail($id)->update([
            'user_id' => $request->users,
			'type' => $request->type_users,
        ]);                

        if ($update) {
            return redirect()->route('sap_it.index')
                            ->with('success', 'updated data successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $it = SapIT::findOrFail($id)->update([
            'is_active'=>'0'
        ]);                

        if ($it) {
            return redirect()->route('sap_it.index')
                            ->with('success', 'deleted data successfully');
        }                
    }
}
