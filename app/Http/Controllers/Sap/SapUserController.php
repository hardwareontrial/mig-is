<?php

namespace App\Http\Controllers\Sap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Model\Position;
use App\Model\Subordinate;
use App\Model\Division;
use App\Model\Sap\SapBPO;
use App\Model\Sap\SapUser;
use App\Model\Sap\SapUserHasBPO;
use Maatwebsite\Excel\Facades\Excel;
//use DB;
use Session;

class SapUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!(Auth::check())){return redirect('/');}
        $keyword = $request->keyword;
        if ($keyword == null || $keyword == ""){
            $keyword = "";
        }else{
            $keyword = $keyword;
        }        
        
        $bpo = DB::table('sap_bpo as A')
                    ->join('sap_users as B', 'A.sap_user_id', 'B.id')
                    ->get();
        
        $users = DB::table('sap_user_has_bpo as A')
                    ->join('sap_users as B', 'A.sap_user_id', 'B.id', 'A.sap_user_bpo_id')
                    ->where('B.is_active', 1)
                    ->whereRaw("B.username LIKE '%".$keyword."%'")                    
                    ->orderBy('A.id', 'ASC')->paginate(10);           
        $users->appends($request->only('keyword'));        
        
        $roles = Role::get();
        $positions = Position::get();        
        
        return view('sap.users.index', compact('users','roles','positions','keyword', 'bpo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!(Auth::check())){return redirect('/');}        
        $roles = Role::get();
        $divisions = Division::get();
        $positions = Position::get();
        $bpo = DB::table('sap_bpo as A')
                  ->leftjoin('sap_users as b', 'b.id', "a.sap_user_id")                  
                 ->get();                

        return view('sap.users.create',compact('roles','divisions','positions', 'bpo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        
        $user_sap = new SapUser([
            'username'=>$request->username,
            'type'=>$request->sap_type,            
        ]);
        $insert_user = $user_sap->save();

        if($insert_user){
            $user_bpo = new SapUserHasBPO([
                'sap_user_id'=>$user_sap->id,
                'sap_user_bpo_id'=>$request->bpo_id,                
            ]);
            $user_bpo->save();
        }       
        return redirect()->route('sap_users.index')
                ->with('success','New SAP Users successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SapUser $SapUser)
    {   
        $has_bpo = SapUserHasBPO::where('sap_user_id', $SapUser->id)->pluck('sap_user_bpo_id')->first();        
        $bpo = SapUser::where('id', $has_bpo)->first();        

        return view('sap.users.show', compact('SapUser', 'bpo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SapUser $SapUser)
    {   
        $id = $SapUser->id;        
        $has_bpo = SapUserHasBPO::where('sap_user_id', $id)->pluck('sap_user_bpo_id')->first();        
        $bpo = DB::table('sap_bpo as A')
                    ->leftjoin('sap_users as b', 'b.id', "A.sap_user_id")                  
                    ->get();

        return view("sap.users.edit", compact('SapUser', 'bpo', 'has_bpo'));
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
        $user = SapUser::findOrFail($id)->update([
            'username'=>$request->username,
            'type'=>$request->sap_type,
        ]);
        $has_bpo = SapUserHasBPO::where('sap_user_id', $id)->update([
            'sap_user_bpo_id'=>$request->bpo_id
        ]);     
        if($user=='1' || $has_bpo == '1'){
            return redirect()->route('sap_users.index',['keyword'=>$request->username])
                ->with('success', 'User SAP successfully updated.');
        } else {
            return redirect()->route('users.index')
                ->with('danger', 'User SAP failed to update.');
        }

    }

    public function delete($id, Request $request){
        $sap_user = SapUser::where('id', $id)
                           ->update(['is_active'=> '0']);
        if($sap_user){
            return redirect()->route('sap_users.index')
                            ->with('success', 'Status changed successfully');            
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

    public function reset($id)
    {
        $user = User::findOrFail($id);
        $user->password = 'mig123!';
        $reset = $user->save();

        if ($reset) {
            return redirect()->route('users.index',['keyword'=>$user->nik])
                            ->with('success', 'Reset password successfully');
        }
    }
	
	public function change_status($id,$status)
    {
        $user = User::findOrFail($id);
        $user->is_active = $status;
        $changed = $user->save();

        if ($changed) {
            return redirect()->route('users.index',['keyword'=>$user->nik])
                            ->with('success', 'Status changed successfully');
        }
    }

    public function export_user()
	{
		return Excel::download(new UserExport(), 'users_list.xlsx');
    }

}
