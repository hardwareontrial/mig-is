<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use App\Model\Elearning\Material;
use App\Model\Elearning\MaterialContent;
use App\Model\Division;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MaterialController extends Controller
{
    public function __construct()
    {
        if(!(Auth::check())){return redirect('/');}
        $this->middleware(['permission:admin all|User Supervisor|User Manager|admin okm|create material okm'])
             ->only(['create']);        
        $this->middleware(['permission:admin all|User Supervisor|User Manager|admin okm|update material okm'])
            ->only(['edit']);
        $this->middleware(['permission:admin all|User Supervisor|User Manager|admin okm|delete material okm'])
            ->only(['delete']);        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $uac_create = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,31))->get()->pluck('name')->toArray());        
        // $uac_delete = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,35))->get()->pluck('name')->toArray());
        // $uac_update = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,38))->get()->pluck('name')->toArray());
        
        //authorize role user on page index
        $uac_read_okm = auth()->user()->hasAnyPermission(Permission::whereIn('id', array('29','24'))
                                      ->get()->pluck('name')->toArray());
        if(!($uac_read_okm)){
           abort(403);
        }        

        $keyword = $request->keyword;
        $materials = Material::with('division','creator','updated_by')
                                ->when($keyword, function ($query) use ($keyword) {
                                        $query->where(function ($q) use ($keyword) {
                                            $q->orWhere('title','like',"%{$keyword}%")
                                                ->orWhere('level','like',"%{$keyword}%")
                                                ->orWhere('sinopsis','like',"%{$keyword}%")
                                                ->orWhereHas('division', function ($query2) use ($keyword){
                                                    $query2->where('name','like',"%{$keyword}%");
                                                });
                                        });
                                })
                                ->where('is_active','=',1)
                                ->orderBy('created_at','DESC')->paginate(10);
        $materials->appends($request->only('keyword'));
        
        // return view('elearning/material/index', compact('materials','keyword','uac_create','uac_delete','uac_update'));
        return view('elearning/material/index', compact('materials','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        //authorize role user on page create
        $uac_create_okm = auth()->user()->hasAnyPermission(Permission::whereIn('id', array('31','24'))
                                      ->get()->pluck('name')->toArray());
        if(!($uac_create_okm)){
           abort(403);
        } 

        $divisions = Division::get();
        return view('elearning/material/create',compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $input = $request->only(['title','division_id','level','sinopsis','hours']);
        $input['created_by'] = Auth::id();
        $inserted = Material::create($input);

        if ($inserted) {
            return redirect()->route('material.index',['keyword'=>$input['title']])
                ->with('success', 'Data materi baru berhasil ditambahkan.');
        } else {
            return redirect()->route('material.index')
                ->with('danger', 'Gagal menyimpan data materi baru.');
        }
    }

    public function store_content(Request $request)
    {
        $input = $request->only(['description','material_id']);
        $input['created_by'] = Auth::id();
        $inserted = FALSE;

        if (!empty($request->file('filepath'))) {
            $dir = 'elearning/material/'.$request->material_id;
            if (!is_dir($dir)) {
                Storage::makeDirectory($dir);
            }
            
            $file = $request->file('filepath');
            $ofilename =  $file->getClientOriginalName();
            $nfilename = Carbon::now()->timestamp.'_'.$ofilename;
            $uploaded = Storage::putFileAs($dir, new File($file), $nfilename);

            if ($uploaded) {
                $input['filepath'] = $dir.'/'.$nfilename;
                $inserted = MaterialContent::create($input);
            }
        } 

        if ($inserted) {
            return redirect()->route('material.show', $input['material_id'])
                ->with('success', 'File materi baru berhasil ditambahkan.');
        } else {
            return redirect()->route('material.show', $input['material_id'])
                ->with('danger', 'Gagal menyimpan file materi baru.');
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
        // $uac_create = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,31))->get()->pluck('name')->toArray());
        // $uac_delete = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,35))->get()->pluck('name')->toArray());
        // $uac_update = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,38))->get()->pluck('name')->toArray());
        
        // $uac = array(
        //     "create" => auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,31))->get()->pluck('name')->toArray()),
        //     "update" => auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,38))->get()->pluck('name')->toArray()),
        //     "delete" => auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,35))->get()->pluck('name')->toArray())
        // );

        $material = Material::with('creator')->where('id','=',$id)->where('is_active','=',1)->first();
        
        if (!empty($material)) {
            $division = Division::find($material->division_id)->name;
            $content = MaterialContent::where('material_id','=',$material->id)
                                        ->where('is_active','=', 1)                                
                                        ->get();

            // return view('elearning/material/detail', compact('material','division','content','uac'));
            return view('elearning/material/detail', compact('material', 'division', 'content'));
            
        } else {
            return redirect()->route('material.index')
                    ->with('warning','Data tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {  
        //authorize role user on page Edit
        $uac_edit_okm = auth()->user()->hasAnyPermission(Permission::whereIn('id', array('38','24'))
                                       ->get()->pluck('name')->toArray());        
        if(!($uac_edit_okm)){
            abort(403);
        }  

        $divisions = Division::get();
        $selected_division = Division::find($material->division_id)->id;
		if ($material->created_by != Auth::user()->id) {
			return redirect()->route('material.index')
            ->with('danger', 'Anda tidak memiliki akses untuk merubah materi ini.');
		}
        return view('elearning/material/edit',compact('material','divisions','selected_division'));
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
        $material = Material::findOrFail($id);
        $input = $request->only(['title','division_id','level','sinopsis','hours']);
        $input['updated_by'] = Auth::id();
        $updated = $material->fill($input)->save();

        if ($updated) {
            return redirect()->route('material.index',['keyword'=>$material->title])
                ->with('success', 'Material successfully updated.');
        } else {
            return redirect()->route('material.index')
                ->with('danger', 'Material failed to update.');
        }
    }

    public function update_content(Request $request, $id)
    {
        $material = MaterialContent::findOrFail($id);
        $input = $request->only(['description']);
        $input['updated_by'] = Auth::id();

        if (!empty($request->file('filepath')))
        {
            $dir = 'elearning/material/'.$material->material_id;
            Storage::delete($material->filepath);

            $file = $request->file('filepath');
            $ofilename = $file->getClientOriginalName();
            $nfilename = Carbon::now()->timestamp.'_'.$ofilename;
            Storage::putFileAs($dir, new File($file), $nfilename);
            $input['filepath'] = $dir.'/'.$nfilename;
        }

        $updated = $material->fill($input)->save();

        if ($updated) {
            return redirect()->route('material.show',$material->material_id)
                ->with('success', 'File materi berhasil diubah.');
        } else {
            return redirect()->route('material.show',$material->material_id)
                ->with('danger', 'Gagal mengubah file materi.');
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
        $material = Material::findOrFail($id);
        if($material->created_by != Auth::user()->id){
            return redirect()->route('material.index')
            ->with('dager', 'Gagal menghapus data materi.');
        }        
        $deleted = $material->fill([
                        'updated_by' => Auth::id(),
                        'is_active' => 0,
                    ])->save();

        if ($deleted) {
            return redirect()->route('material.index')
                ->with('success', 'Data materi berhasil dihapus.');
        } else {
            return redirect()->route('material.index')
                ->with('danger', 'Gagal menghapus data materi.');
        }
    }

    public function destroy_content($id)
    {
        $materialc = MaterialContent::findOrFail($id);
        $deleted = $materialc->fill([
                        'updated_by' => Auth::id(),
                        'is_active' => 0,
                    ])->save();

        if ($deleted) {
            return redirect()->route('material.show',$materialc->material_id)
                ->with('success', 'File materi berhasil dihapus.');
        } else {
            return redirect()->route('material.show',$materialc->material_id)
                ->with('danger', 'Gagal menghapus file materi.');
        }
    }
	
	public function download($id)
	{
		$materialc = MaterialContent::where('id', $id)->firstOrFail();
		$materialc->download_count = $materialc->download_count + 1;
		$materialc->save();
		
		$pathToFile = storage_path('app/' . $materialc->filepath);
		return response()->download($pathToFile);
	}
	
	public function AllMaterial($division = 'all')
	{
		$data = null;
		$data = Material::with('division',
								 'creator',
								 'updated_by'
								)
								->where('division_id','=', 8)
                                ->where('is_active','=',1)
                                ->orderBy('created_at','DESC')
								->paginate(1);
								
								
								
		if(count($data)>0){
            return response()->json(['success' => true, 'message' => 'Data Materi Berhasil Ditampilkan','data' => $data], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }else{
            return response()->json(['success' => false, 'message' => 'Data Materi Kosong']);
        } 
	}
}
