<?php

namespace App\Http\Controllers\Sap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
use Session;

class SapBPOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
        }else{
            $keyword = "";
        }
        
        $users = DB::table('sap_bpo as A')
                    ->join('sap_users as B', 'A.sap_user_id', 'B.id')
                    ->join('users as C', 'A.user_id', 'C.id')                                    
                    ->whereRaw("C.name LIKE '%".$keyword."%' or B.username LIKE '%".$keyword."%'")
                    ->select('A.id as id', 'B.username as username', 'C.name as name', 'A.is_active as is_active')
                    ->orderBy('A.id', 'ASC')->paginate(10);
        $users->appends($request->only('keyword'));
        
        $roles = Role::get();
        $positions = Position::get();
        
        return view('sap.bpo.index', compact('users','roles','positions','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!(Auth::check())){ return redirect('/');}
        
        $users = User::where('is_active',1)->get();
        $sap_users = SapUser::where('is_active', 1)->get();

        return view('sap.bpo.create', compact('users','sap_users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = SapBPO::create([
            'user_id'=>$request->user_id,
            'sap_user_id'=>$request->sap_user_id,
        ]);
        return redirect()->route('sap_bpo.index')
				->with('success',
				 'BPO successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $bpo = SapBPO::with('user', 'user_sap')->find($id);
		
        return view('sap.bpo.show',compact('bpo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {            
        $bpo = SapBPO::find($id);        
        $users = User::where('is_active',1)->get();
        $sap_users = SapUser::where('is_active', 1)->get();        

        return view('sap.bpo.edit',compact('bpo','sap_users', 'users'));
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
        $has_bpo = SapBPO::where('id', $id)->update([
            'user_id'=>$request->user_id,
            'sap_user_id'=>$request->sap_user_id,
        ]);

        return redirect()->route('sap_bpo.index')
                ->with('success', 'User BPO successfully updated.');
        // $user = User::findOrFail($id);
        // $input = $request->only(['name','email','position_id','is_active']);
        // $roles =  $request->input('roles');
        // $updated = $user->fill($input)->save();

        // if (isset($roles)) {        
        //     $user->roles()->sync($roles);            
        // }        
        // else {
        //     $user->roles()->detach();
        // }

        // if ($updated) {
        //     return redirect()->route('users.index',['keyword'=>$user->nik])
        //         ->with('success', 'User successfully updated.');
        // } else {
        //     return redirect()->route('users.index')
        //         ->with('danger', 'User failed to update.');
        // }
        

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
        $bpo = SapBPO::findOrFail($id);
        $bpo->is_active = 0;
        $changed = $bpo->save();

        if ($changed) {
            return redirect()->route('sap_bpo.index')
                            ->with('success', 'deleted data successfully');
        }
    }

}
