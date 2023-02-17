<?php

namespace App\Http\Controllers\Delivery;

use App\Exports\DeliveryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Model\Delivery\Delivery_Transactions;
use App\Model\Delivery\Delivery_Detail;
use App\Model\Delivery\Delivery_Activity;
use App\Model\Delivery\Delivery_Export;

class DeliveryController extends Controller
{
    public function index(Request $request){
        $sort = "10";
        $date = "";
        $search = "";
        
        if ($request->sorting || $request->date || $request->searching){
            $sort = $request->sorting;
            $date = Date('Y-m-d', strtotime($request->date));
            $search = $request->searching;
        }
					
        		
        $data = Delivery_Transactions::delivery_view()
                                     ->whereRaw('substring(A.delivery_created_at,1,10) = "'.$date.'" || 
                                                 B.del_det_customer LIKE "%'.$search.'%"')
									 ->orderBy('A.delivery_created_at',"DESC")
                                    ->paginate($sort);
        return view('Delivery.index', compact('data'));
    }

    public function create(){
        if(!Auth::check()){return redirect('/');}
        
        return view('Delivery.form');
    }

    public function store(Request $request){
        
        $year = date('y');
        $month = date('m');
        $date = Date('d');
    
        $base_id = "S-".$year.$month.$date;

        if (Delivery_Transactions::where('delivery_no', 'LIKE', $base_id.'%')->count() > 0) {
            $last_delivery_no = Delivery_Transactions::orderBy('delivery_no', 'desc')->first();
            $counting_no = substr($last_delivery_no->delivery_no,2)+1;            
            $delivery_no = "S-".$counting_no;            
        } else {
            $delivery_no = $base_id."0001";
        }

        if($request->btn_save_print){
            $print_count = "1";
            $activity = "Create & Print Delivery";
        }else if($request->btn_save){
            $print_count= "0";
            $activity = "Create Delivery";
        }
        
        $new_del_transactions = new Delivery_Transactions([
            "delivery_no"=>$delivery_no,
            "delivery_created_by"=>Auth::user()->id,
            "delivery_print_count"=>$print_count,
            'do_no' => $request->do_no,
            'po_no' => $request->po_no
        ]);
        $new_del_transactions->save();
            
        $delivery_id = $new_del_transactions->delivery_id;
        $item = $request->item;
        $measure = $request->unit_measure;
        foreach($item as $x){
            $input['item'] = $x;
        }
        foreach($measure as $y){
            $input['um'] = $y;
        }        

        $new_detail_delivery = new Delivery_Detail([
            "del_delivery_id"=>$delivery_id,
            "del_det_customer"=>$request->customer_name,
            "del_det_address"=>$request->customer_alamat,
            "del_det_city"=>$request->customer_kota,
            "del_det_vehicles_no"=>$request->kendaraan_no,
            'del_det_driver'=>$request->driver_name,
            'del_det_item'=>$input['item'],
            'del_det_qty'=>$request->qty,
            'del_det_um'=>$input['um'],
            "del_det_date_send"=>$request->tgl_kirim,
        ]);
        $new_detail_delivery->save();        

        $new_del_activity = new Delivery_Activity([
            "del_delivery_id"=>$delivery_id,
            "del_act_name"=>$activity,
            "del_act_user_id"=>Auth::user()->id,
        ]);
        $new_del_activity->save();

        if($request->btn_save_print){
            return redirect()->route('DN.Print', $delivery_id);
        }else if($request->btn_save){                            
            return redirect()->route('DN.index')
            ->with('success','New Delivery successfully created.');      
        }                
    }

    public function edit($id, Request $request){
        if(!Auth::check()){return redirect('/');}        

        $query = Delivery_transactions::select('delivery_print_count')->find($id);
        $print_count = $query->delivery_print_count;
        if($print_count <> 0){
            return redirect()->route('DN.index')
                             ->with('danger', 'Surat jalan telah terbit, tidak dapat di edit kembali!');
        }
        
        $data = Delivery_Transactions::delivery_view()->where("delivery_id",$id)->get();                       
        return view('Delivery.form', compact('data'));
    }

    public function update($id, Request $request){   
        $count_print = 0;
        $activity = "Edit Delivery Note";
        $up_po = $request->po_no;
        $up_do = $request->do_no;
        
        $item = $request->item;        
        $measure = $request->unit_measure;
        foreach($item as $x){ $input['item'] = $x; }
        foreach($measure as $y){ $input['um'] = $y; }

        if($request->btn_save_print){
            $delivery_transactions = Delivery_Transactions::find($id);
            $count_print = $delivery_transactions->delivery_print_count + 1;

            $activity = "Edit & Print Delivery Note"; 

            $delivery_transactions->update([
                'delivery_print_count'=>$count_print,
                'po_no' => $request->po_no,
                'do_no' => $request->do_no
            ]);
        }
                  
        if($request->btn_save){
            $delivery_transactions = Delivery_Transactions::find($id);
            $activity = "Edit & Print Delivery Note"; 
            $delivery_transactions->update([
                'po_no' => $request->po_no,
                'do_no' => $request->do_no
            ]);
        }

        $update_detail = Delivery_detail::where('del_delivery_id', $id)->update([            
            "del_det_customer"=>$request->customer_name,
            "del_det_address"=>$request->customer_alamat,
            "del_det_city"=>$request->customer_kota,
            "del_det_vehicles_no"=>$request->kendaraan_no,
            'del_det_driver'=>$request->driver_name,
            'del_det_item'=>$input['item'],
            'del_det_qty'=>$request->qty,
            'del_det_um'=>$input['um'],
            "del_det_date_send"=>$request->tgl_kirim,
        ]);

        $edit_del_activity = new Delivery_Activity([
            "del_delivery_id"=>$id,
            "del_act_name"=>$activity,
            "del_act_user_id"=>Auth::user()->id,
        ]);
        $edit_del_activity->save();

        if($request->btn_save_print){
            return redirect()->route('DN.Print', $id);
        }else if($request->btn_save){                            
            return redirect()->route('DN.index')
            ->with('success','New Delivery successfully created.');      
        }                         
    }

    public function preview($id, Request $request){

    }

    public function print($id, Request $request){			
        $query = Delivery_Transactions::where('delivery_id', $id)->get()->first();        
        $data = Delivery_Transactions::delivery_view()->where('delivery_id', $id)->get()->first();
        $x = Delivery_Transactions::find($id);
        $y = Delivery_Detail::where('del_delivery_id', $id)->get();
        
		
        $count_print = $query->delivery_print_count;
        if($count_print > 0){
            $count_print+=1;
            $data->delivery_no = $data->delivery_no."-R".$count_print;            
        }else{
            $data->delivery_no = $data->delivery_no;
        }        

        return view("Delivery.print", compact('data', 'x', 'y'));
    }

    public function confirm_print($id){               
        $query = Delivery_Transactions::where('delivery_id', $id)->first();
        $count = $query->delivery_print_count;        
        $input = $count+1;
        
        Delivery_Transactions::where('delivery_id', $id)->update(['delivery_print_count'=>$input]);

        Delivery_activity::create([            
            'del_delivery_id'=>$id,
            'del_act_name'=>"Print_surat jalan",
            'del_act_user_id'=>Auth::user()->id]);

        return response()->json(1);        
    }

    public function export_excel(){
        $date = Date('Y-m-d');
        ob_end_clean(); // this
        ob_start(); // and this        
        return Excel::download(new DeliveryExport, 'Delivery_exp_'.$date.'.xls');    
        // $data = Delivery_Export::Delivery_export_data()->get();
        // dd($data);
    }

	public function remarks_invoice(Request $request, $id){
		if(!Auth::check()){return redirect('/');}
		if($request->ajax()){
				
			$delivery_trans = Delivery_Transactions::find($id)->update([
											'delivery_is_remark'=> 1,
											'delivery_invoice_no'=> $request->delivery_invoice_no,
										]);
										
			if($delivery_trans){
				return response()->json($delivery_trans);
			}
		}
	}
}