<?php

namespace App\Http\Controllers\Edoc;

use App\Http\Controllers\Controller;
use App\Model\Edoc\EdocSupporting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupportingController extends Controller
{
	public function __construct()
    {
        $this->middleware(['permission:admin all|admin edoc|update supporting document'])->only(['create']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $supportings = EdocSupporting::orderBy('id','ASC')
                                    ->when($keyword, function ($query) use ($keyword) {
                                        $query->where(function ($q) use ($keyword) {
                                            $q->orWhere('id', 'like', "%{$keyword}%")
                                                ->orWhere('title', 'like', "%{$keyword}%")
                                                ->orWhere('jenis', 'like', "%{$keyword}%")
                                                ->orWhere('status', 'like', "%{$keyword}%");
                                        });
                                    })
                                    ->where('is_active','=',1)
                                    ->paginate(10);
        $supportings->appends($request->only('keyword'));

        return view('edoc/supporting/index', compact('supportings','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('edoc/supporting/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jenis = 'SD';
		$file_supporting = $request->file_supporting;
		
		//check file is uploaded
		if (file_exists($_FILES['file_supporting']['tmp_name'])){
			$filename = preg_replace('/\s+/', '_', $_FILES["file_supporting"]["name"]);
		}
		
		//check no file
		if (!file_exists($_FILES['file_supporting']['tmp_name'])){
			return redirect()->route('supporting.create')
                ->with('danger', 'File tidak boleh kosong.');
			die();
		}
		
        $format_file = array('xls','xlsx','doc','docx','pdf');
        
        //check format file
		if (!empty($_FILES['file_supporting']['name']) && !in_array(pathinfo($_FILES['file_supporting']['name'], PATHINFO_EXTENSION), $format_file)){
            return redirect()->route('supporting.create')
                ->with('danger', 'Upload file harus berformat xls,xlsx,doc,docx,pdf.');
			die();
        }
        
        $title_no_id = explode("_",$filename,2); //title without id [1]
		$title_no_id_ext = explode('.',$title_no_id[1]); //title without id + ext [0]
		$remove_underscore = str_replace('_',' ',$title_no_id_ext[0]);
		$jenis_dokumen = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),-1);
        $divisi = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),0,-1);
        
        //get file extension
        $file_ext = pathinfo($_FILES['file_supporting']['name'], PATHINFO_EXTENSION);
        
        $file_id = $title_no_id[0];
        $file_id_no_rev = explode('-R',$title_no_id[0])[0];
        
        //get revision number
        $rev_number = explode('-R', $title_no_id[0])[1];
        
        //check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_no_id[0]);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
            return redirect()->route('supporting.create')
                ->with('danger', 'Nama file harus ada huruf R untuk keterangan Revisi.');
			die();
        }
        
        //check document SD
		$remove_rev = preg_replace('/R/', '',$remove_symbols);
		if (substr($remove_rev,-2) != 'SD')
		{
            return redirect()->route('supporting.create')
                ->with('danger', 'Nama file harus ada huruf SD.');
			die();
        }
        
        //check duplicate id
		$check_id = EdocSupporting::find($file_id_no_rev);
		if (!empty($check_id->id) && $check_id->id == $file_id_no_rev)
		{
            return redirect()->route('supporting.create')
                ->with('danger', 'Supporting Document ID '.$file_id_no_rev.' sudah ada.');
			die();
        }
        
        //check duplicate name
		$check_title = EdocSupporting::where('jenis','=',$jenis)
                        ->where('title', '=', $remove_underscore)
                        ->first();
		if (!empty($check_title->title) && strtolower(trim($check_title->title)) == strtolower(trim($remove_underscore)))
		{
            return redirect()->route('supporting.create')
                ->with('danger', 'Supporting Document title '.$remove_underscore.' sudah ada.');
			die();
        }
        
        //upload supporting doc
        if (file_exists($_FILES['file_supporting']['tmp_name'])) {
			
			if ($_FILES["file_supporting"]["name"] != NULL)
			{
                $dir = 'edoc/supportings/';
                $file = $request->file('file_supporting');
                $uploaded = Storage::putFileAs($dir, new File($file), $file_id.'_'.$title_no_id_ext[0].'.'.$file_ext);
                
                if ($uploaded) {
                    $edoc = new EdocSupporting;
                    $edoc->id = $file_id_no_rev;
                    $edoc->title = $remove_underscore;
                    $edoc->status = 'Active';
                    $edoc->jenis = $jenis;
                    $edoc->revisi = $rev_number;
                    $edoc->filepath = 'supportings/'.$file_id.'_'.$title_no_id_ext[0].'.'.$file_ext;
                    $edoc->save();

                    return redirect()->route('supporting.create')
                        ->with('success', 'Sukses menambah data');
                }
			}
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
        $supporting = EdocSupporting::where('id', $id)->firstOrFail();
        $supporting->is_active = 0;
        $supporting->save();

        return redirect()->route('supporting.index')
                        ->with('success', 'Sukses menghapus ' . $supporting->title);
    }
    
    public function update_file(Request $request)
    {
        //FORM POST
		$id_document = $request->id_document;
		$old_filepath_post = $request->old_filepath_modal;
        $rev_number = $request->rev_number;
        
        //check no file
		if (!file_exists($_FILES['new_filepath_modal']['tmp_name'])){
            return redirect()->route('supporting.index',['keyword' => $id_document])
                ->with('danger', 'File tidak boleh kosong');
			die();
        }
        
        //GET DOC BY ID
        $data_document = EdocSupporting::where('id', '=', $id_document)->firstOrFail();
        
        //Get rev number from upload file
		$upload_file = preg_replace('/\s+/', '_', $_FILES["new_filepath_modal"]["name"]);
		$title_id = explode("_",$upload_file,2)[0]; //title without id [1]
        $new_rev_number = explode("-R",$title_id)[1];
        
        //check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_id);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
			return redirect()->route('supporting.index',['keyword' => $id_document])
                ->with('danger', 'Nama file harus ada huruf R untuk keterangan Revisi');
			die();
        }
        
        $location = 'supportings/';
        $file_ext = pathinfo($_FILES['new_filepath_modal']['name'], PATHINFO_EXTENSION);
        if ($rev_number != $new_rev_number) {
			$filename = $id_document . '-R' . $rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;			
			$filename_new = $id_document . '-R' . $new_rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;
            
            $file = $request->file('new_filepath_modal');
            Storage::putFileAs('edoc/' . $location, new File($file), $filename_new);
            
            $edoc = EdocSupporting::where('id','=',$id_document)->first();
            $edoc->revisi = $new_rev_number;
            $edoc->filepath = $location.$filename_new;
            $edoc->save();

            if ($edoc) {
                return redirect()->route('supporting.index', ['keyword' => $edoc->id])
                        ->with('success', 'Sukses mengubah file form ' . $edoc->title);
            }
		} else {
            return redirect()->route('supporting.index',['keyword' => $id_document])
                ->with('danger', 'Nomor revisi harus berbeda, update tidak diproses');
			die();
        }
    }

    public function status($id,$status)
    {
        $supporting = EdocSupporting::where('id', $id)->firstOrFail();
        $supporting->status = $status;
        $supporting->save();

        return redirect()->route('supporting.index', ['keyword' => $id])
                        ->with('success', 'Sukses mengubah status ' . $supporting->title. ' menjadi '. $status);
    }

    public function download($id)
	{
		$supporting = EdocSupporting::where('id', $id)->firstOrFail();
		
        return Storage::download('edoc/' . $supporting->filepath);
	}
}
