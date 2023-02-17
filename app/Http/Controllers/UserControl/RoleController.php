<?php

namespace App\Http\Controllers\UserControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use DB;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $roles = Role::when($keyword, function ($query) use ($keyword) {
                        $query->where('name','like',"%{$keyword}%");
                })->paginate(10);
        $roles->appends($request->only('keyword'));
        $permissions = Permission::get();
        return view('roles.index',compact('roles','permissions','keyword'));
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
        $name = $request['roles_name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index',['keyword' => $role->name])
                    ->with('success','Roles sucessfully inserted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $r_permissions = $request->input('permissions');
        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $role->name = $request->input('roles_name');
        $updated = $role->save();

        foreach ($permissions as $r) {
            $role->revokePermissionTo($r);
        }

        foreach ($r_permissions as $r) {
            $n_permission = Permission::where('id', '=', $r)->firstOrFail();
            $result_1 = $role->givePermissionTo($n_permission);  
        }

        /*$result_2 = DB::table('roles')
                    ->where('id', $id)
                    ->update(['name' => $r_name]);*/

        if ($result_1 || $updated) {
            return redirect()->route('roles.index',['keyword' => $role->name])
                    ->with('success','Roles sucessfully updated');
            //return response()->json(['success'=>TRUE,'msg'=>'Data has been changed successfully.']);
        } else {
            return redirect()->route('roles.index',['keyword' => $role->name])
                    ->with('danger','Roles failed to updated');
            //return response()->json(['success'=>FALSE,'msg'=>'Data failed to change']);
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
