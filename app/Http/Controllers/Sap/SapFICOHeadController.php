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
use App\Model\Sap\SapFICOHead;
use App\Model\Sap\SapUser;
use Maatwebsite\Excel\Facades\Excel;

class SapFICOHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        if(isset($request->keyword)){
            $keyword = $request->keyword;
        }else{
            $keyword = null;
        }

        // $users = SapFICOHead::with('user')
            // ->when($keyword, function ($query) use ($keyword) {
            //     $query->orWhere('username', 'like', "%{$keyword}%")
            //           ->orWhere('type','like',"%{$keyword}%");
            // })

        $users = DB::table('sap_fico_head as A')
                   ->leftjoin('users as B','A.user_id', 'B.id')
                   ->whereRaw("B.name like '%".$keyword."%'")
                   ->select('A.id as id', 'B.name as name')                                  
                ->orderBy('A.id', 'ASC')->paginate(10);
        $users->appends($request->only('keyword'));
        
        $roles = Role::get();
        $positions = Position::get();
        
        return view('sap.ficohead.index', compact('users','roles','positions','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request){
       
        $users = SapFICOHead::findorFail($id)->with('user')->first();        

        return view('sap.ficohead.show',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $users_fico = SapFICOHead::find($id);
        $users = User::where('is_active', '1')->get();

        return view('sap.ficohead.edit', compact('users', 'users_fico'));
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
        $update = SapFICOHead::find($id)->update([
            'user_id'=>$request->users      
        ]);

        if($update){
            return redirect()->route('sap_fico.index')
                             ->with('success','Updated data Successfully');
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
}
