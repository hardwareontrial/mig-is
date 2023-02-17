<?php

namespace App\Http\Controllers\Helpdesk;

use App\Exports\HelpdeskExport;
use App\Model\Helpdesk\Helpdesk;
use App\Model\Helpdesk\HelpdeskAssign;
use App\Model\Helpdesk\HelpdeskActivity;
use App\Model\Helpdesk\HelpdeskComment;
use App\Model\Helpdesk\HelpdeskAttachment;
use App\Model\Helpdesk\HelpdeskSapAuth;
use App\Model\Helpdesk\HelpdeskSapForm;
use App\Model\Helpdesk\HelpdeskMasterData;
use App\Model\Helpdesk\HelpdeskSapApproval;
use App\Model\Sap\SapUser;
use App\Model\Sap\SapBPO;
use App\Model\Sap\SapIT;
use App\Model\Sap\SapFICOHead;
use App\Model\Sap\SapUserHasBPO;
use App\Mail\MIGEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Division;
use App\Model\Sap\SapProjectManag;
use Carbon\Carbon;

class SapAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category = 'all')
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $bpo = SapBPO::with('user')
                        ->where('is_active','=',1)
                        ->get();
        $divisions = Division::getAll();        
        $sap_users = SapUser::all();
        $sap_assign_bpo = DB::table('sap_bpo as A')
        ->join('users as B', 'B.id', 'A.user_id')
        ->get();                 

        return view('sap/authorization/create',compact('bpo','divisions','sap_users',
                                                        'sap_assign_bpo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){                

        $datetime_start = date('Y-m-d', strtotime($request->input('date_start'))) . " " .
                          $request->input('time_start') . ":00";
        $datetime_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                         $request->input('time_end') . ":00";                                 
        
        /* -----    generate helpdesk id    -----   */
        $year = date('y');
        $month = date('m');
        $base_id = $year.$month;

        if (Helpdesk::where('id', 'LIKE', $base_id.'%')->count() > 0) {
            $last_helpdesk_id = Helpdesk::orderBy('id', 'desc')->first();
            $helpdesk_id = $last_helpdesk_id->id + 1;
        } else {
            $helpdesk_id = $base_id."0001";
        }

        /*  -----   generate helpdesk title  -----   */
        $sap_user = SapUser::find($request->input('sap_user'));        
        $user_id = Auth::user()->id;
                
        $helpdesk_title = "[Helpdesk | MIG-IS] - [".$helpdesk_id.'] - SAP Authorization Req - '.$sap_user->username;                        

        $helpdesk = new Helpdesk([
            'id' => $helpdesk_id,
            'category' => 'SAP Authorization',
            // 'title' => $helpdesk_title,
            'title'=> "Request SAP Authorization",
            'sap_user_id' => $request->sap_user,
            'creator_id' => $user_id,
            'date_start' => $datetime_start,
            'date_end' => $datetime_end,
            'type' => $request->input('type'),
            'status' => "New",
            'privilege' => "Private",
        ]);
        $result_helpdesk = $helpdesk->save();                

        $count_tcode = count($request->input('auth_tcode'));
        $auth_tcode = $request->input('auth_tcode');
        $auth_desc = $request->input('auth_desc');

        for($i = 0; $i<$count_tcode; $i++){
            $helpdesk_auth_sap = new HelpdeskSapAuth([
                'helpdesk_id'=>$helpdesk_id,
                'tcode'=>$auth_tcode[$i],
                'description'=>$auth_desc[$i],
                'created_by'=>$user_id
            ]);
            $helpdesk_auth_sap->save();
        } 
        
        if ($result_helpdesk){

            //Activity create new helpdesk
            $helpdesk_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => "create new request SAP Authorization Helpdesk"
            ]);
            $helpdesk_activity->save();

            $SAP_fico = SapFICOHead::where('is_active', '1')->pluck('user_id')->first();
            $SAP_it = SapIT::where('type','Basis')->where('is_active','1')->pluck('user_id')->first();
            $SAP_bpo = $request->assign_bpo;
            $Sap_proman = SapProjectManag::where('is_active','1')->pluck('user_id');                        
           
            $array_assign =  [$SAP_bpo, $SAP_fico, $SAP_it,$Sap_proman[0]];            
            foreach($array_assign as $value){
                $helpdesk_assign = new HelpdeskAssign([
                            "helpdesk_id"=>$helpdesk_id,
                            "user_id"=>$value  
                        ]);
                $helpdesk_assign->save();
            }

            //Insert approval
            $approval = new HelpdeskSapApproval([
                'helpdesk_id' => $helpdesk_id,
                'bpo_id' => $SAP_bpo,
                'fico_head_id' =>$SAP_fico,
                'proman_id'=>$Sap_proman[0],
                'it_id' => $SAP_it
            ]);
            $approval->save();               
            
            foreach($array_assign as $value){           
                $user_email = User::find($value);                
                if(!empty($user_email)){
                    Mail::to($user_email->email)->send(new MIGEmail($helpdesk_title,
                    "Helpdesk permintaan SAP Authorization telah dibuat oleh ". Auth::user()->name ." 
                    silahkan klik <a href='".route('helpdesk.show', $helpdesk_id)."'>disini</a>"));
                }
            }
        }
        
        return redirect()->route('helpdesk.index')
            ->with('success','New helpdesk successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Helpdesk  $helpdesk
     * @return \Illuminate\Http\Response
     */
    public function show(Helpdesk $authorization)
    {
        $creator = User::findOrFail($authorization->creator_id);
        $users = User::GetAllUsers();
        $divisions = Division::getAll();
        $assigns = HelpdeskAssign::where('helpdesk_id','=',$authorization->id)->get();
        $activitys = HelpdeskActivity::with('user','comment','attachment')
                        ->where('helpdesk_id', '=', $authorization->id)
                        ->orderBy('created_at','desc')
                        ->get(); 

        $sap_auth = HelpdeskSapAuth::where('helpdesk_id','=',$authorization->id)
                                    ->where('is_active','=',1)
                                    ->get();        

        $approval = HelpdeskSapApproval::where('helpdesk_id','=',$authorization->id)->first();

        $bpo = SapBPO::with('user')
                        ->where('is_active','=',1)
                        ->get();

        $sap_user = SapUser::find($authorization->sap_user_id);

        //get field name
        $arr_auth_key = [];
        for ($i = 1; $i <= $sap_auth->count(); $i++) {
            $arr_auth_key[] = $i;
        }
        $sap_auth_key = implode(',',$arr_auth_key);                

        //get array id
        $arr_auth_id = [];
        foreach ($sap_auth as $r) {
            $arr_auth_id[] = $r->id;
        }
        $sap_auth_id = implode(',',$arr_auth_id);        
        

        $assign_all = 0;
        $assign_divisions = [];
        $assign_divisions_2 = [];
        foreach ($assigns as $r) {
            if (!empty($r->user_id) && $r->user_id != 0) {
                $assign_users[] = $r->user_id;
            } else if (!empty($r->division_id)){
                $assign_divisions[] = 'd-'.$r->division_id;
                $assign_divisions_2[] = $r->division_id;
            } else if ($r->user_id == 0) {
                $assign_all = 1;
            }
        }

        $helpdesk = $authorization;

        return view('sap/authorization/show', compact('sap_user','bpo','approval','creator','sap_auth',
                                                      'sap_auth_key','sap_auth_id','helpdesk','activitys',
                                                      'users','divisions','assign_all','assign_users',
                                                      'assign_divisions', 'assign_divisions_2'));
        
        // return view('sap/authorization/show', compact('helpdesk','sap_auth'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Helpdesk  $helpdesk
     * @return \Illuminate\Http\Response
     */
    public function edit(Helpdesk $helpdesk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Helpdesk  $helpdesk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Helpdesk $authorization)
    {          
        $date_end_is_update = false;
        $privilege_is_update = false;
        $type_is_update = false;
        $status_is_update = false;
        $assign_to_is_update = false;

        $helpdesk_is_updated = false;
        $assign_is_updated = false;
        $comment_is_sent = false;
        $file_is_uploaded = false;
        $tcode_is_updated = false;

        //check approval
        $approval = HelpdeskSapApproval::where('helpdesk_id','=',$authorization->id)->first();

        //check tcode edited
        $auth_count = explode(',',$request->auth_count);
        $arr_auth_id = [];
        
        if ($approval['fico_head_approve'] == null && $approval['bpo_approve'] == null) {
            foreach ($auth_count as $r) {
                $auth_id = $request->input('auth_id_'.$r);
                $auth_tcode = $request->input('auth_tcode_'.$r);
                $auth_desc = $request->input('auth_desc_'.$r);

                $auth_data = HelpdeskSapAuth::find($auth_id);
                
                if (!empty($auth_data)) {
                    $arr_auth_id[] = (int) $auth_id;
                    if ($auth_data->tcode != $auth_tcode || $auth_data->description != $auth_desc) {
                        $auth_data->tcode = $auth_tcode;
                        $auth_data->description = $auth_desc;
                        $auth_data->save();
                    }
                } else {
                    $helpdesk_auth = new HelpdeskSapAuth([
                            'helpdesk_id' => $authorization->id,
                            'tcode' => $request->input('auth_tcode_'.$r),
                            'description' => $request->input('auth_desc_'.$r),
                            'created_by' => Auth::id()
                        ]);
                    $helpdesk_auth->save();
                    $arr_auth_id[] = $helpdesk_auth->id;
                }
            }

            $auth_data_by_helpdesk_id = HelpdeskSapAuth::where('helpdesk_id','=',$authorization->id)
                                                        ->where('is_active','=','1')
                                                        ->get();

            foreach ($auth_data_by_helpdesk_id as $r) {
                if (!in_array($r->id,$arr_auth_id)) {
                    echo 'hore';
                    $delete_auth_data = HelpdeskSapAuth::find($r->id);
                    $delete_auth_data->is_active = '0';
                    $delete_auth_data->save();
                }
            }
        }

        //init message variable
		$message = "[". Auth::user()->nik. "] ". Auth::user()->name . " telah memperbarui helpdesk klik <a href=" . route('helpdesk.show',$authorization->id) . "> disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";

        $new_date_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                        date('H:i:s', strtotime($request->input('time_end') . ":00"));

        //check date end update
        if ($new_date_end != $authorization->date_end) {
            $title_activity = "merubah <b>date end</b> dari " . $authorization->date_end . " menjadi " . $new_date_end;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $authorization->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check cond type update
        $new_type = $request->input("type");
        if ($new_type != $authorization->type) {
            $title_activity = "merubah <b>condition type</b> dari " . $authorization->type . " menjadi " . $new_type;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $authorization->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check helpdesk update
        if ($helpdesk_is_updated) {
            $authorization->date_end = $new_date_end;
            $authorization->type = $new_type;
            $authorization->save();
        }

        //Activity comment & upload
        if (!empty($request->input('comment')) || !empty($request->file('attachment'))) {

            if (!empty($request->input('comment')) && !empty($request->file('attachment'))) {
                $title_activity = "comment on this post with attachment file";
                $comment_is_sent = true;
                $file_is_uploaded = true;
            } else if (!empty($request->file('attachment'))) {
                $title_activity = "upload attachment file";
                $file_is_uploaded = true;
            } else if (!empty($request->input('comment'))) {
                $title_activity = "comment on this post";
                $comment_is_sent = true;
            }

            $message .= $title_activity.'<br>';

            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $authorization->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            //check upload attachment
            if (!empty($request->file('attachment'))) {
                $dir = 'helpdesk/'.$authorization->id.'/';
                if (!is_dir($dir)) {
                    Storage::makeDirectory($dir);
                }

                $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $rawname = Carbon::now()->timestamp.'_'.$name;

                Storage::putFileAs($dir, new File($file), $rawname);

                $create_attachment = new HelpdeskAttachment([
                    'activity_id' => $create_activity->id,
                    'filename' => $name,
                    'filepath' => $dir.'/'.$rawname,
                ]);

                $create_attachment->save();
            }

            //check comment
            if (!empty($request->input('comment'))) {
                $comment = new HelpdeskComment([
                    'activity_id' => $create_activity->id,
                    'content' => ($request->input('comment')) ? $request->input('comment') : "",
                ]);
                $comment->save();
            }
        }

        if ($helpdesk_is_updated || $assign_is_updated || $comment_is_sent || $file_is_uploaded) 
        {
            $assign_user_id = HelpdeskAssign::where('helpdesk_id', '=', $authorization->id)
                                    ->where('user_id', '!=', null)
                                    ->pluck('user_id')
                                    ->toArray();

            $assign_division_id = HelpdeskAssign::where('helpdesk_id', '=', $authorization->id)
                                    ->where('division_id', '!=', null)
                                    ->pluck('division_id')
                                    ->toArray();

            if (in_array(0, $assign_user_id)) {
                $assign_user_email[] = User::where('is_active','=',1)->pluck('email')->toArray();
            } else {
                $assign_user_email[] = User::orWhereIn('division_id',$assign_division_id)
                                            ->orWhereIn('id',$assign_user_id)
                                            ->where('is_active','=',1)->pluck('email')
                                            ->toArray();
            }

            // foreach(array_filter(array_unique($assign_user_email, SORT_REGULAR)) as $r) {
            //     Mail::to($r)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            // }            

            //send email to owner
            if (Auth::user()->id != $authorization->creator_id) {
                $owner = User::where('id', '=', $authorization->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - [$helpdek->id]' . $authorization->title.' - Response '.Auth::User()->name, $message));
            }

            return redirect()->route('authorization.show', $authorization->id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
        } else {
            return redirect()->route('authorization.show', $authorization->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Helpdesk  $helpdesk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Helpdesk $helpdesk)
    {
        //
    }

    public function download($id)
	{
		$attachment = HelpdeskAttachment::where('id', $id)->firstOrFail();
		
		$pathToFile = storage_path('app/' . $attachment->filepath);
		return response()->download($pathToFile);
    }
    
    public function export()
	{
        $user_id = Auth::user()->id;
        $division_id = Auth::user()->division_id;
        return Excel::download(new HelpdeskExport($user_id,$division_id), date("Y-m-d H:i:s").'_helpdesk.xlsx');
    }

    public function bpo_approval($approval_id,$helpdesk_id,$status) {
        $approval = HelpdeskSapApproval::find($approval_id);
        $helpdesk = Helpdesk::find($helpdesk_id);        

        if ($approval->bpo_approve == null && $approval->fico_head_approve == null) {

            $title_activity = "";
            if ($status == 1) {
                $title_activity = "menyetujui permintaan otorisasi";
            } else if ($status == 0) {
                $title_activity = "menolak permintaan otorisasi";
            }
            
            //init message variable
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";

            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            $helpdesk->status = 'In Process';
            $helpdesk->save();

            $approval->bpo_approve = $status;
            $approval->bpo_act_at = date('Y-m-d H:i:s');
            $approval->save();

            // $assign_user_id = HelpdeskAssign::where('helpdesk_id', '=', $helpdesk_id)
            //                         ->where('user_id', '!=', null)
            //                         ->pluck('user_id')
            //                         ->toArray();

            // $assign_user_email[] = User::whereIn('id',$assign_user_id)
            //                         ->where('is_active','=',1)->pluck('email')
            //                         ->toArray();

            // foreach(array_filter(array_unique($assign_user_email, SORT_REGULAR)) as $r) {
            //     Mail::to($r)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            // }

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            if ($approval) {
                return redirect()->route('authorization.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }

    public function fico_approval($approval_id,$helpdesk_id,$status) {
        $approval = HelpdeskSapApproval::find($approval_id);
        
        if ($approval->bpo_approve != null && $approval->fico_head_approve == null) {

            $title_activity = "";
            if ($status == 1) {
                $title_activity = "menyetujui permintaan otorisasi";
            } else if ($status == 0) {
                $title_activity = "menolak permintaan otorisasi";
            }
           
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            $approval->fico_head_approve = $status;
            $approval->fico_head_act_at = date('Y-m-d H:i:s');
            $approval->save();

            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            if ($approval) {
                return redirect()->route('authorization.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }
    
    public function proman_approval($approval_id, $helpdesk_id, $status){
        $approval = HelpdeskSapApproval::find($approval_id);              
        
        if ($approval->bpo_approve != null && $approval->fico_head_approve != null) {
            
            $title_activity = "";
            if ($status == 1) {
                $title_activity = "menyetujui permintaan otorisasi";
            } else if ($status == 0) {
                $title_activity = "menolak permintaan otorisasi";
            }
           
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            $approval->proman_approve = $status;
            $approval->proman_act_at = date('Y-m-d H:i:s');
            $approval->save();

            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            if ($approval) {
                return redirect()->route('authorization.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }

    public function it_approval($approval_id,$helpdesk_id,$status) {
        $approval = HelpdeskSapApproval::find($approval_id);
        $helpdesk = Helpdesk::find($helpdesk_id);

        if ($approval->bpo_approve != null && $approval->fico_head_approve != null && $approval->proman_approve != null) {
            
            $title_activity = "";
            if ($status == 1) {
                $title_activity = "menyetujui permintaan otorisasi, dan status helpdesk menjadi Complete";
            } else if ($status == 0) {
                $title_activity = "menolak permintaan otorisasi, dan status helpdesk menjadi Complete";
            }
           
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            
            $helpdesk->status = 'Complete';
            $helpdesk->save();

            $approval->it_approve = $status;
            $approval->it_act_at = date('Y-m-d H:i:s');
            $approval->save();

            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            if ($approval) {
                return redirect()->route('authorization.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }

    public function cancel_approval($type,$approval_id,$helpdesk_id) {
        $approval = HelpdeskSapApproval::find($approval_id);
        $helpdesk = Helpdesk::find($helpdesk_id);        

        if ($type == "BPO") {
            $approval->bpo_approve = NULL;
            $approval->bpo_act_at = NULL;
            $approval->fico_head_approve = NULL;
            $approval->fico_head_act_at = NULL;
            $approval->proman_approve = NULL;
            $approval->proman_act_at = NULL;
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        } else if ($type == "FICO") {
            $approval->fico_head_approve = NULL;
            $approval->fico_head_act_at = NULL;            
            $approval->proman_approve = NULL;
            $approval->proman_act_at = NULL;
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        } else if($type == 'proman'){
            $approval->proman_approve = NULL;
            $approval->proman_act_at = NULL;
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        }else if ($type == "IT") {
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        }

        $helpdesk->status = "In Process";
        $helpdesk->save();

        $title_activity = "membatalkan approval otorisasi";
        
        $create_activity = new HelpdeskActivity([
            'helpdesk_id' => $helpdesk_id,
            'user_id' => Auth::user()->id,
            'title' => $title_activity,
        ]);
        $create_activity->save();

        $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
        $message .= $title_activity;

        if ($approval) {
            return redirect()->route('authorization.show', $helpdesk_id)
                        ->with('success', 'Berhasil mengubah data.');
        }
    }
}
