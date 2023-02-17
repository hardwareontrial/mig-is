<?php

namespace App\Http\Controllers\Elearning;

use App\Model\Elearning\ExamSchedule;
use App\Model\Elearning\ExamParticipant;
use App\Model\Elearning\Material;
use App\Model\Elearning\QuestionCollection;
use App\Model\Elearning\Raport;
use App\Model\Subordinate;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$keyword = $request->keyword;
        $uac_admin = auth()->user()->hasRole([1,4]);
		$uac_manager = Auth::user()->hasRole(7);
        $uac_subordinate = Subordinate::where('parent_id','=',Auth::id())->get();

        if ($uac_admin) {
            $user = User::with('division','position')
                          ->whereNotIn('id',[1,2,101,102,103])
						  ->when($keyword, function ($query) use ($keyword) {
								$query->where(function($q) use ($keyword){
											$q->orWhere('email', 'like', "%{$keyword}%")
											  ->orWhere('nik','like',"%{$keyword}%")
											  ->orWhere('name', 'like', "%{$keyword}%")
											  ->orWhereHas('position', function ($query2) use ($keyword) {
												  $query2->where('name','like',"%{$keyword}%");
											  })
											  ->orWhereHas('division', function ($query3) use ($keyword) {
												  $query3->where('name','like',"%{$keyword}%");
											  });
									  })
									  ->where(function($q){
										  $q->where('is_active','=',1);
									  });
							})
						  ->where('is_active','=',1)
                          ->paginate(9);
			$user->appends($request->only('keyword'));
            return view('elearning/raport/index_v2',compact('user','uac_subordinate','keyword'));
        } else if ($uac_manager) { 
			$user = User::with('position','division','division_subordinates.division','division_subordinates.position')
                           ->where('id','=',Auth::user()->id)
						   ->where('division_id','=',Auth::user()->division_id)
						   ->where('is_active','=',1)
                           ->first();
            return view('elearning/raport/index_v2',compact('user','uac_subordinate','uac_manager'));
		} else if ($uac_subordinate->count() > 0 && !$uac_manager) {
            $user = User::with('subordinates.user.position','subordinates.user.division')
                           ->where('id','=',Auth::id())               
                           ->first();
            return view('elearning/raport/index_v2',compact('user','uac_subordinate'));
        } else {
            $materials = Material::with(['collection.raport' => function($query) {
                                        $query->where('nik','=', Auth::user()->nik)->where('is_active','=',1);
                                }])
								 ->when($keyword, function ($query) use ($keyword){
									 $query->where('title','like',"%{$keyword}%")
										   ->orWhere('level','like',"%{$keyword}%");
								 })
                                 ->whereHas('collection.raport', function($query3) {
                                     $query3->where('nik','=', Auth::user()->nik)->where('is_active','=',1);
                                 })
                                 ->paginate(10);
			$materials->appends($request->only('keyword'));
            $nik = Auth::user()->nik;
            return view('elearning/raport/index',compact('materials','nik','keyword'));
        }
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
        //
    }

    public function by_user(Request $request, $nik)
    {
		$keyword = $request->keyword;
        $user = User::with('position','division')->where('nik','=',$nik)->first();
        $materials = Material::with(['collection.raport' => function($query) use ($nik) {
                                     $query->where('nik','=',$nik)->where('is_active','=',1);
                                }])
								->when($keyword, function ($query2) use ($keyword){
									 $query2->where('title','like',"%{$keyword}%")
										   ->orWhere('level','like',"%{$keyword}%");
								 })
                                 ->whereHas('collection.raport', function($query3) use ($nik) {
                                     $query3->where('nik','=',$nik)->where('is_active','=',1);
                                 })
                                 ->get();
        return view('elearning/raport/index_by_user',compact('materials','user','keyword'));
    }

    public function detail($nik, $material_id)
    {
        $uac_admin = auth()->user()->hasPermissionTo('admin all');
        $uac_subordinate = Subordinate::where('parent_id','=',Auth::id())->get();
        $user = User::with('position','division')->where('nik','=',$nik)->first();
        $raport = Material::with(['collection.raport' => function($query) use ($nik) {
                                    $query->where('nik','=',$nik)
									      ->where('is_active', '=', 1);
                            },'collection.raport.schedule_collection'])
                            ->whereHas('collection.raport', function($query2) use ($nik) {
                                $query2->where('nik','=',$nik)->where('is_active','=',1);
                            })
                            ->where('id','=',$material_id)
                            ->first();
        
        return view('elearning/raport/detail',compact('raport','user','uac_admin','uac_subordinate'));
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
        //
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

    public function raport_list()
    {
        // $data = Material::with('collection.raport')
        // ->whereHas('collection.raport', function($query) {
        //     $query->where('nik','=',244);
        // })
        // ->first();
        /* $data = Material::with(['collection.raport' => function($query){
                                    $query->where('nik','=',244);
                            },'collection.raport.schedule_collection'])
                            ->whereHas('collection.raport', function($query2) {
                                $query2->where('nik','=',244);
                            })
                            ->get(); */
							
		$data = User::with('position','division','division_subordinates.division','division_subordinates.position')
                           ->where('id','=',104)
						   ->where('division_id','=',8)
                           ->first();
						   
        return response()->json(['success' => true, 'message' => 'Data berhasil di tampilkan', 'data'=> $data]);
    }
}
