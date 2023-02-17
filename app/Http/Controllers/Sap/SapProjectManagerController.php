<?php

namespace App\Http\Controllers\Sap;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Model\Sap\SapProjectManag;
use App\User;

class SapProjectManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_sap = DB::table('sap_project_manager as A')
                                  ->join('users as B', 'A.user_id', 'B.id')
                                  ->where('A.is_active', 1)
                                  ->select('A.id as id', 'B.name')
                                  ->get();        
        
        return view('sap.projectmanager.index',compact('users_sap'));
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
    public function show($id)
    {
        $users = SapProjectManag::with('user')->find($id)->first();       

        return view('sap.projectmanager.show',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $users = User::where('is_active', 1)->get();        
        $users_pro_manag = SapProjectManag::where('id',$id)->first();    

        return view('sap.projectmanager.edit',compact('users','users_pro_manag'));
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
        $update = SapProjectManag::findorFail($id)->update([
            "user_id"=>$request->users
        ]);
        if($update){
            return redirect()->route('sap_pro_manag.index')
                             ->with('success','updated data successfully');
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
