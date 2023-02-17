<?php

namespace App\Http\Controllers\UserControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use DB;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $permissions = Permission::when($keyword, function ($query) use ($keyword) {
                                    $query->where('name','like',"%{$keyword}%");
                        })->paginate(10);
        $permissions->appends($request->only('keyword'));
        return view('permissions.index',compact('permissions','keyword'));
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
        $prm_name = $request->name;
        $check_count = Permission::where('name','=',$prm_name)->count();

        if ($check_count == 0) {
            $permissions = Permission::create($request->only('name'));

            return redirect()->route('permissions.index',['keyword'=>$prm_name])
                ->with('success','Permission successfully added.');
        } else {
            return redirect()->route('permissions.index',['keyword'=>$prm_name])
                ->with('danger', 'Permission already exists.');
        }
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
        $prm = Permission::findOrFail($id);
        $prm->name = $request->prm_name;
        $check_name = Permission::where('name','=',$request->prm_name)->count();
        if ($check_name == 0) {
            $updated = $prm->save();

            if ($updated) {
                return redirect()->route('permissions.index',['keyword'=>$prm->name])
                                    ->with('success','Permissions sucessfully updated');
            } else {
                return redirect()->route('permissions.index',['keyword'=>$prm->name])
                                    ->with('danger','Permissions failed to update');
            }
        } else {
            return redirect()->route('permissions.index',['keyword'=>$prm->name])
                                ->with('danger','Permission name already exists.');
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
