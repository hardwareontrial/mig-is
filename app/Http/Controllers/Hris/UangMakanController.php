<?php

namespace App\Http\Controllers\Hris;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Http\Controllers\Controller;
use App\Imports\MealAllowanceImport;
use App\Model\Hris\Allowance_Import_Master;
use App\Model\Hris\MealAllowance;
use App\Model\Division;
use App\User;
//use Barryvdh\DomPDF\Facade as PDF;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UangMakanController extends Controller
{

    public function __construct()
    {
        if(!(Auth::check())){return redirect('/');}
        // $this->middleware(['Role:Admin Hris|Admin'])->only(['show']);
    }
    public function index(Request $request){

        $sort = '15';
        $keyword = $request->keyword;

        $data = Allowance_Import_Master::with('user')
                            ->where('transactions_type', 'Meal Allowance')
                            ->orderBy('periode_start', 'DESC')
                            ->paginate($sort);
        
        return view('hris.mealAllowance.index',compact('data'));
    }

    public function create(){
        $uac_create_mealallowance = auth()->user()->hasAnyPermission(Permission::whereIn('id', array('52','56'))
                                      ->get()->pluck('name')->toArray());
        
        if(!($uac_create_mealallowance)){
            abort(403);
        }
          
        return view('hris.mealAllowance.create');
    }

    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            'import_file' => 'required|mimes:xlsx,xls'
        ]);
        if($validate->fails()){
            return redirect()->route('MealAllowance.create')
                             ->with('danger', 'Periksa kembali format file.');
        }

        $file = $request->file('import_file');
        $transaction_type = "Meal Allowance";
        $periode_start = $request->date_periode_start;
        $periode_end = $request->date_periode_end;
        $note =""; 
        $file_name = date('d_m', strtotime($periode_start)).'_'.date('d_m', strtotime($periode_end)).'_'.$file->getClientOriginalName();

        if(count($request->note) > 1){
                $note = implode("|", $request->note);
        }else{
            foreach($request->note as $key => $value){
                $note = $value;
            }
        }

        $insert_allowance_master = Allowance_Import_Master::create([
            'transactions_type' => $transaction_type,
            'periode_start' => $periode_start,
            'periode_end' => $periode_end,
            'file_name' => $file_name,
            'note' => $note,
            'quotes'=>$request->quotes,
            'created_by' => Auth::user()->id,
        ]);

        if($insert_allowance_master){
            $file = $request->file('import_file');
            $dir  = 'hris/mealallowance';
            
            if (!is_dir($dir)) {
                Storage::makeDirectory($dir);
            }

            $uploaded = Storage::putFileAs($dir, new File($file), $file_name);

            $path = $request->file('import_file')->getRealPath();

            $imported = Excel::import(new MealAllowanceImport($insert_allowance_master->id), 
                        $request->file('import_file'));
            
        }

        return redirect()->route('MealAllowance.index')->with('success', 'Data berhasil di import.');

    }

    public function show(Request $request, $id){
        $data_detail = "";
        $sort =14;
        $keyword = $request->keyword;

        $data_master = Allowance_Import_Master::find($id);
    
        if(Auth::user()->nik == '666'){
            $data_detail = MealAllowance::with('User')
                                        ->when($keyword, function($query) use ($keyword){
                                            $query->where('nik','LIKE', '%'.$keyword.'%')
                                                  ->orWhereHas('user', function($q) use ($keyword){
                                                      $q->where('name', 'LIKE', '%'.$keyword.'%');
                                                  });
                                        })
                                        ->where('master_id', $data_master->id)
                                        ->paginate($sort);
        }else{
            $data_detail = MealAllowance::with('User')
                                        ->where('master_id', $data_master->id)
                                        ->where('nik', Auth::user()->nik)
                                        ->paginate($sort);
        }

        return view('hris.mealAllowance.show', compact('data_master', 'data_detail'));
    }
    
    public function delete($id){
        $data = Allowance_Import_Master::find($id);
        $data->delete();

        return redirect()->route('MealAllowance.index')->with('success', 'Data Terhapus.');
    }

    public function download_template(){
        $filename = "Template_MealAllowance.xlsx";
        $path = storage_path('app/hris/mealallowance/template/' . $filename);

        // Download file with custom headers
        $response = response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]); 
        ob_end_clean();
        return $response;
    }

    public function import_view(){

        return view('hris.mealAllowance.create');
    }
    
    public function print_mealallowance($id){

        $data_master = Allowance_Import_Master::find($id);
        $data_detail = MealAllowance::with('User')
                                        ->where('master_id', $data_master->id)
                                        ->where('nik', Auth::user()->nik)
                                        ->get();
        $department = division::find($data_detail[0]->User->division_id);
        $note  = explode('|', $data_master->note);

        return view('hris.mealAllowance.print', compact('data_master', 'data_detail', 'department', 'note'));
    }

    public function send_email($id){
        $nik = User::where('is_active', 1)
                    ->where('division_id','<>', 'null')
                    ->pluck('nik')
                    ->toArray();  
        
        
        foreach($nik as $key => $value){
            // $data_detail = MealAllowance::where('master_id');
            $array_nik = array($value);

        }
    }

        //  -------------------  dwipetrus add PDF 1/3/21 ----------------------//
  
    public function printPDF($id){

    //$datar = [
    //    'oke' => 'sukses'] ;
      $data_master = Allowance_Import_Master::find($id);
      $data_detail = MealAllowance::with('User')
                    ->where('master_id', $data_master->id)
                    ->where('nik', Auth::user()->nik)
                    ->get();
      $department = division::find($data_detail[0]->User->division_id);
      $note  = explode('|', $data_master->note);
    //  $pdfnik = User::find($data_detail[0]->User->nik);

      $pdf = \PDF::loadview('hris\mealAllowance\print_pdf', compact('data_master', 'data_detail', 'department', 'note'));
        return $pdf->stream("NIK {$data_detail[0]->User->nik}");
    //  $pdf = PDF::loadview('pdf_view', $datar, compact('data_master', 'data_detail', 'department', 'note'));
    //  return $pdf->stream("NIK {$data_detail[0]->User->nik}");
    }
    
        


        // $data_detail = MealAllowance::with('User')
        //                             ->where('master_id', $data_master->id)
        //                             ->get();

        // $department = division::find($data_detail[0]->User->division_id);
        // $note  = explode('|', $data_master->note);
        // $nik = MealAllowance::where('master_id', $data_master->id)->groupBy('nik')->distinct('nik')->count();
        // dd($nik);

        // return view('mail.hris.index', compact('data_master', 'data_detail', 'department','note'));
    

   
}
