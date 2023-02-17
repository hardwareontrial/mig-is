<?php

namespace App\Http\Controllers\PhoneBook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Model\Phonebook\Phonebook;
use Yajra\Datatables\Datatables;

class PhonebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::check()){return redirect('/');}
        
        return view('phonebook.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('phonebook.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $phonebook = new Phonebook([
            "nama_perusahaan"=>$request->perusahaanName,
            "alamat_perusahaan"=>$request->perusahaanAddress,
            "kota_perusahaan"=>$request->perusahaanCity,
            "telp_perusahaan"=>$request->perusahaanTelp,
            "fax_perusahaan"=>$request->perusahaanFax,
            "ket_perusahaan"=>$request->perusahaanKet,
            "nama_person"=>$request->personName,
            "alamat_person"=>$request->personAddress,
            "kota_person"=>$request->personCity,
            "telp_person"=>$request->personPhone,
            "fax_person"=>$request->personFax,
            "hp_person"=>$request->personHp,
            "ket_person"=>$request->personKet
        ]);        
        $insert = $phonebook->save();
        if($insert){
            return redirect()->route('phonebook.index')
                            ->with('success','One Contact Information Successfully Created.');
        }else{
            return redirect()->route('phonebook.create')
                            ->with('danger', 'Failed saving new contact information!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if($request->ajax()){
            $data = Phonebook::find($id);
            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Phonebook::find($id);        
        return view('phonebook.edit', compact('data'));
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
        $input = $request->all();        
        $update = Phonebook::where('id', $id)->update([
            "nama_perusahaan"=>$input['perusahaanName'],
            "alamat_perusahaan"=>$input['perusahaanAddress'],
            "kota_perusahaan"=>$input['perusahaanCity'],
            "telp_perusahaan"=>$input['perusahaanTelp'],
            "fax_perusahaan"=>$input['perusahaanFax'],
            "ket_perusahaan"=>$input['perusahaanKet'],
            "nama_person"=>$input['personName'],
            "alamat_person"=>$input['personAddress'],
            "kota_person"=>$input['personCity'],
            "telp_person"=>$input['personPhone'],
            "fax_person"=>$input['personFax'],
            "hp_person"=>$input['personHp'],
            "ket_person"=>$input['personKet']
        ]);
        if($update){
            return redirect()->route('phonebook.index')
                            ->with('success','One Contact Information Successfully Update.');
        }else{
            return redirect()->route('phonebook.edit')
                            ->with('danger', 'Failed saving new contact information!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
    }
    public function softDeleted(Request $request, $id){
        if($request->ajax()){
            $data = Phonebook::where('id', $id)->update($request->all());
            return response()->json($data);
        }
    }
    public function GetDataTable(Request $request){        
        if($request->ajax()){            
            $data = Phonebook::select(['id',
                                'nama_perusahaan',
                                'alamat_perusahaan',
                                'kota_perusahaan',
                                'nama_person'])
                                ->where("is_deleted","0")->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                   $btn = '<a href= phonebook/'.$row->id.'/edit class="edit btn btn-warning btn-sm">
                            <span class="fa fa-edit"></span></a>
                            <button class="btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <span class="fa fa-trash"></span>
                            </button>
                            ';
                    return $btn;
            })
            ->setRowId('id')
            ->rawColumns(['action'])
            ->make(true);        
            return response($data);
        } 
    }
}
