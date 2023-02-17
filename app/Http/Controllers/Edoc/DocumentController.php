<?php

namespace App\Http\Controllers\Edoc;

use App\Http\Controllers\Controller;
use App\Model\Edoc\EdocDocument;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
	public function __construct()
    {
        $this->middleware(['permission:admin all|admin edoc|update iso document'])->only(['create']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $documents = EdocDocument::orderBy('id','ASC')
                                    ->when($keyword, function ($query) use ($keyword) {
                                        $query->where(function ($q) use ($keyword) {
                                            $q->orWhere('id', 'like', "%{$keyword}%")
                                                ->orWhere('title', 'like', "%{$keyword}%")
                                                ->orWhere('jenis', 'like', "%{$keyword}%")
                                                ->orWhere('jenis_keterangan', 'like', "%{$keyword}%")
                                                ->orWhere('status', 'like', "%{$keyword}%");
                                        });
                                    })
                                    ->where('is_active','=',1)
                                    ->paginate(10);
        $documents->appends($request->only('keyword'));

        return view('edoc/document/index', compact('documents','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('edoc/document/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file_doc = $request->file_doc;

        //check doc/pdf is uploaded
		if (file_exists($_FILES['file_doc']['tmp_name'])){
			$filename = preg_replace('/\s+/', '_', $_FILES["file_doc"]["name"]);
        } 
        
        //check no file doc
		if (!file_exists($_FILES['file_doc']['tmp_name'])){
			return redirect()->route('document.create')
                ->with('danger', 'File tidak boleh kosong.');
			die();
        }
        
        //check format doc
		if (!empty($_FILES['file_doc']['name']) && pathinfo($_FILES['file_doc']['name'], PATHINFO_EXTENSION) != 'doc' && pathinfo($_FILES['file_doc']['name'], PATHINFO_EXTENSION) != 'docx'){
            return redirect()->route('document.create')
                ->with('danger', 'Upload DOC harus berformat DOC/DOCX.');
			die();
        }
        
        $title_no_id = explode("_",$filename,2); //title without id [1]
		$title_no_id_ext = explode('.',$title_no_id[1]); //title without id + ext [0]
		$remove_underscore = str_replace('_',' ',$title_no_id_ext[0]);
		$jenis_dokumen = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),-1);
        $divisi = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),0,-1);
        
        //DOC
        $doc_ext = pathinfo($_FILES['file_doc']['name'], PATHINFO_EXTENSION);
        
        $file_id = $title_no_id[0];
		$file_id_no_rev = explode('-R',$title_no_id[0])[0];
		
		//get revision number
		$rev_number = explode('-R', $title_no_id[0])[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_no_id[0]);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
			return redirect()->route('document.create')
                ->with('danger', 'Nama file harus ada huruf R untuk keterangan Revisi.');
			die();
        }
        
        //check document type
		$remove_rev = preg_replace('/R/', '',$remove_symbols);
		$jenis = substr($remove_rev,-1);
		if ($jenis != 'W' && $jenis != 'P')
		{
			return redirect()->route('document.create')
                ->with('danger', 'Jenis dokumen harus ada keterangan P untuk prosedur atau W untuk instruksi kerja.');
			die();
		} else {
			if ($jenis == 'W'){
				$folder_word = 'documents/work_instruction/word/';
			} else if ($jenis == 'P') {
				$folder_word = 'documents/procedure/word/';
			}
        }
        
        //check duplicate id
		$check_id = EdocDocument::find($file_id_no_rev);
		if (!empty($check_id->id) && $check_id->id == $file_id_no_rev)
		{
			return redirect()->route('document.create')
                ->with('danger', 'dokumen ID '.$file_id_no_rev.' sudah ada.');
			die();
        }
        
        
        //check duplicate name
        $check_title = EdocDocument::where('jenis', '=', $jenis)
                                    ->where('title', '=', $remove_underscore)
                                    ->first();
		if (!empty($check_title->title) && strtolower(trim($check_title->title)) == strtolower(trim($remove_underscore)))
		{
            return redirect()->route('document.create')
                ->with('danger', 'dokumen Title '.$remove_underscore.' sudah ada');
			die();
        }
        
        //upload doc
        if (file_exists($_FILES['file_doc']['tmp_name'])) {
			
			if ($_FILES["file_doc"]["name"] != NULL)
			{
                $dir = 'edoc/'.$folder_word;
                $file = $request->file('file_doc');
                $uploaded = Storage::putFileAs($dir, new File($file), $file_id.'_'.$title_no_id_ext[0].'.'.$doc_ext);
                
                if ($uploaded) {
                    $edoc = new EdocDocument;
                    $edoc->id = $file_id_no_rev;
                    $edoc->title = $remove_underscore;
                    $edoc->status = 'Active';
                    $edoc->jenis = $jenis;
                    $edoc->jenis_keterangan = $jenis == 'P'? 'Prosedur' : 'Instruksi Kerja';
                    $edoc->revisi = $rev_number;
                    $edoc->word_filepath = $folder_word.$file_id.'_'.$title_no_id_ext[0].'.'.$doc_ext;
                    $edoc->save();

                    return redirect()->route('document.create')
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
        $document = EdocDocument::where('id', $id)->firstOrFail();
        $document->is_active = 0;
        $document->save();

        return redirect()->route('document.index')
                        ->with('success', 'Sukses menghapus ' . $document->title);
    }

    public function update_file(Request $request)
    {
        //FORM POST
		$type = $request->type;
		$id_document = $request->id_document;
		$old_filepath_post = $request->old_filepath_modal;
		$jenis = $request->jenis;
        $rev_number = $request->rev_number;
        
        //check no file
		if (!file_exists($_FILES['new_filepath_modal']['tmp_name'])){
			return redirect()->route('document.index',['keyword' => $id_document])
                ->with('danger', 'File tidak boleh kosong');
			die();
        }
        
        $file_ext = pathinfo($_FILES['new_filepath_modal']['name'], PATHINFO_EXTENSION);

        //check format file
		if ($type == 'DOC' && ($file_ext != 'docx' && $file_ext != 'doc')){
			return redirect()->route('document.index',['keyword' => $id_document])
                ->with('danger', 'Upload file word harus berformat .docx atau .doc');
			die();
        } 
        
        //GET DOC BY ID
        $data_document = EdocDocument::where('id', '=', $id_document)->firstOrFail();
		
		if ($jenis == 'W')	{
			$folder_word = 'documents/work_instruction/word/';
		} else if ($jenis == 'P') {
			$folder_word = 'documents/procedure/word/';
        }
        
        //Get rev number from upload file
		$upload_file = preg_replace('/\s+/', '_', $_FILES["new_filepath_modal"]["name"]);
		$title_id = explode("_",$upload_file,2)[0]; //title without id [1]
		$new_rev_number = explode("-R",$title_id)[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_id);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
			return redirect()->route('document.index',['keyword' => $id_document])
                ->with('danger', 'Nama file harus ada huruf R untuk keterangan Revisi');
			die();
        }
        
        $location = $folder_word;

        if ($rev_number != $new_rev_number) {
			$filename = $id_document . '-R' . $rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;						
			$filename_new = $id_document . '-R' . $new_rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;
			
			//if (file_exists($location.$filename)) unlink($location.$filename);
            
            //move_uploaded_file($_FILES['new_filepath_modal']['tmp_name'], $location.$filename_new);
            $file = $request->file('new_filepath_modal');
            Storage::putFileAs('edoc/' . $location, new File($file), $filename_new);
			$filename = $filename_new;
		} else {
            return redirect()->route('document.index',['keyword' => $id_document])
                ->with('danger', 'Nomor revisi harus berbeda, update tidak diproses');
			die();
        }
        
        if ($type == 'DOC')	
		{
            $edoc = EdocDocument::where('id','=',$id_document)->first();
            $edoc->revisi = $new_rev_number;
            $edoc->word_filepath = $folder_word.$filename;
            $edoc->save();

            if ($edoc) {
                return redirect()->route('document.index', ['keyword' => $edoc->id])
                        ->with('success', 'Sukses mengubah file word ' . $edoc->title);
            }
		}
    }

    public function status($id,$status)
    {
        $document = EdocDocument::where('id', $id)->firstOrFail();
        $document->status = $status;
        $document->save();

        return redirect()->route('document.index', ['keyword' => $id])
                        ->with('success', 'Sukses mengubah status ' . $document->title. ' menjadi '. $status);
    }

    public function download($id)
	{
		$document = EdocDocument::where('id', $id)->firstOrFail();
		
		return Storage::download('edoc/' . $document->word_filepath);
	}
}
