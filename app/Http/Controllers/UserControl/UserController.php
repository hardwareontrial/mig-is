<?php

namespace App\Http\Controllers\UserControl;

use Illuminate\Http\Request;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Model\Position;
use App\Model\Subordinate;
use App\Model\Division;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::with('position','division')
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('email', 'like', "%{$keyword}%")
                          ->orWhere('nik','like',"%{$keyword}%")
                          ->orWhere('name', 'like', "%{$keyword}%")
                          ->orWhereHas('position', function ($query2) use ($keyword) {
                              $query2->where('name','like',"%{$keyword}%");
                          })
						  ->orWhereHas('division', function ($query2) use ($keyword) {
                              $query2->where('name','like',"%{$keyword}%");
                          });
                })
                ->where('nik','!=','000')
                ->orderBy('nik', 'ASC')->paginate(10);
        $users->appends($request->only('keyword'));
		
        
        $roles = Role::get();
        $positions = Position::get();
        
        return view('users.index', compact('users','roles','positions','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $divisions = Division::get();
        $positions = Position::get();

        return view('users.create',compact('roles','divisions','positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$check_nik = User::where('nik','=',$request->nik)
						->orWhere('email','=',$request->email)
						->first();
		
		if (!$check_nik) {
			$user = User::create($request->only('nik', 'name','division_id','position_id','email','password'));
			$roles = $request['roles'];
			$user->assignRole(Role::where('id', '=', $roles)->firstOrFail());

			return redirect()->route('users.index')
				->with('success',
				 'User successfully added.');
		} else {
			return back()->withInput()
				->with('danger',
				 'NIK or Email already exists.');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $position = Position::find($user->position_id);
		$subordinate = null;
		
		if ($user->roles->contains(7)) {
			$subordinate = User::with('position')
								->where('id','!=',$user->id)
								->where('division_id','=',$user->division_id)
								->where('is_active','=',1)
								->get();
		} else if ($user->roles->contains(8)) {
			$subordinate = Subordinate::where('parent_id','=',$user->id)->get();
		}
		
        return view('users.detail',compact('user','position','subordinate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $positions = Position::get();

        return view('users.edit',compact('user','roles','positions'));
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
        $user = User::findOrFail($id);
        $input = $request->only(['name','email','position_id','is_active']);
        $roles =  $request->input('roles');
        $updated = $user->fill($input)->save();

        if (isset($roles)) {        
            $user->roles()->sync($roles);            
        }        
        else {
            $user->roles()->detach();
        }

        if ($updated) {
            return redirect()->route('users.index',['keyword'=>$user->nik])
                ->with('success', 'User successfully updated.');
        } else {
            return redirect()->route('users.index')
                ->with('danger', 'User failed to update.');
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
