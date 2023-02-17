<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Mail\MIGEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\Model\Helpdesk\Helpdesk;
use App\Model\Helpdesk\HelpdeskActivity;
use App\Model\Helpdesk\HelpdeskAssign;
use App\Model\Helpdesk\HelpdeskSapApproval;
use App\Model\Helpdesk\HelpdeskComment;
use App\Model\Sap\SapAbap;
use App\Model\Sap\SapUser;
use App\Model\Sap\SapFICOHead;
use App\Model\Sap\SapProjectManag;
use App\Model\Sap\SapIT;

class SapAbapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()){return redirect()->route('home');}

        $sap_users = SapUser::where('is_active','1')->get();
        $sap_assign_bpo = DB::table('sap_bpo as A')
        ->join('users as B', 'B.id', 'A.user_id')
        ->get();

        return view("sap.abap.create", compact('sap_users', 'sap_assign_bpo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::check()){return redirect()->route('home');}

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
        $datetime_start = date('Y-m-d', strtotime($request->input('date_start'))) . " " .
                $request->input('time_start') . ":00";
        $datetime_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                $request->input('time_end') . ":00";

        /*  -----   generate helpdesk title  -----   */
        $sap_user = SapUser::find($request->input('sap_user'));        
        $user_id = Auth::user()->id;

        $helpdesk_title = "[Helpdesk | MIG-IS] - [".$helpdesk_id.'] - SAP Request ABAP - '.$sap_user->username; 
        
        //Insert Helpdesk
        $helpdesk = new Helpdesk([
            'id' => $helpdesk_id,
            'category' => 'SAP ABAP',            
            'title'=> "Request SAP ABAP",
            'sap_user_id' => $request->sap_user,
            'creator_id' => $user_id,
            'date_start' => $datetime_start,
            'date_end' => $datetime_end,
            'type' => $request->input('type'),
            'status' => "New",
            'privilege' => "Private",
        ]);
        $result_helpdesk = $helpdesk->save();
            
        if($result_helpdesk){
            
            //  Insert Helpdesk Request Abap
            $sap_config = new SapAbap([
                'helpdesk_id' => $helpdesk_id,
                'type' => $request->abap_type,
                'tcode' => $request->abap_tcode,
                'description' => $request->abap_desc,
                'created_by' => Auth::user()->id,
                'is_active' => '1'
            ]);
            $sap_config->save();
            
            //  Insert Helpdesk Activity
            $sap_activity = new HelpdeskActivity([
                'helpdesk_id'=>$helpdesk_id,
                'user_id'=>Auth::user()->id,
                'title'=>"Create New Helpdesk Request SAP ABAP"
            ]);
            $sap_activity->save();

            $sap_bpo = $request->assign_bpo;
            $sap_fico_head = SapFICOHead::where('is_active',1)->get();
            $sap_project_manag = SapProjectManag::where('is_active',1)->get();
            $sap_it = SapIT::where('type', 'Master Data')->where('is_active',1)->get();             
            
            $array_assign = [$sap_bpo, $sap_fico_head[0]->user_id, $sap_project_manag[0]->user_id, $sap_it[0]->user_id];
            foreach($array_assign as $assign_id){
                //Insert Assign
                $sap_assign = new HelpdeskAssign([
                    'helpdesk_id'=> $helpdesk_id,
                    'user_id' => $assign_id,
                ]);
                $sap_assign->save();
            }

            //Insert Approval
            $sap_approval = new HelpdeskSapApproval([
                'helpdesk_id' => $helpdesk_id,
                'bpo_id' => $sap_bpo,
                'fico_head_id' => $sap_fico_head[0]->user_id,
                'proman_id' => $sap_project_manag[0]->user_id,
                'it_id' => $sap_it[0]->user_id,
            ]);
            $sap_approval->save();

            //Push Email
            foreach($array_assign as $value){           
                $user_email = User::find($value);                
                if(!empty($user_email)){
                    Mail::to($user_email->email)->send(new MIGEmail($helpdesk_title,
                    "Helpdesk permintaan SAP Configuration telah dibuat oleh ". Auth::user()->name ." 
                    silahkan klik <a href='".route('helpdesk.show', $helpdesk_id)."'>disini</a>"));
                }
            }

            return redirect()->route('helpdesk.index')
            ->with('success','New helpdesk successfully created.');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Helpdesk $abap)
    {                              
        $helpdesk = $abap;        
        $creator = User::findOrFail($abap->creator_id);    

        $sap_user = SapUser::where('is_active',1)->select('username')->first();
                
        $sap_abap = SapAbap::where('helpdesk_id', $abap->id)
                               ->where('is_active', 1)
                               ->first();        

        $activitys = HelpdeskActivity::with('user','comment','attachment')
                               ->where('helpdesk_id', $abap->id)
                               ->orderBy('created_at','desc')
                               ->get();        

        $approval = HelpdeskSapApproval::where('helpdesk_id',$abap->id)->first();

        $assigns = HelpdeskAssign::where('helpdesk_id','=',$abap->id)->get();

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
        return view('sap.abap.show', compact(   'creator','sap_user', 'sap_abap', 
                                                'helpdesk', 'approval', 'activitys',
                                                'assign_all','assign_users', 'assign_divisions' ));
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
    public function update(Request $request,Helpdesk $abap)
    {
        $date_end_is_update = false;
        $privilege_is_update = false;
        $type_is_update = false;
        $status_is_update = false;
        $assign_to_is_update = false;
        $helpdesk_is_updated = false;
                
        $comment_is_sent = false;
        $abap_is_update = false;

        //  declare new message 
        $message = "[". Auth::user()->nik. "] ". Auth::user()->name . " telah memperbarui helpdesk klik <a href=" .         
                        route('helpdesk.show',$abap->id) . "> disini </a> 
                        untuk melihat detail helpdesk <br> <br> Log Activity:<br>";                  

        //check approval
        $approval = HelpdeskSapApproval::where('helpdesk_id','=',$abap->id)->first();
        
        if ($approval->fico_head_approve == null && $approval->bpo_approve == null 
            && $approval->proman_approve == null) {            
            
            $abap_data = SapAbap::where('helpdesk_id', $abap->id)->first();
            
            if (!empty($abap_data)) {            
                if($abap_data->tcode != $request->abap_tcode){
                    $message .= " Merubah  dari ".$abap_data->tcode ." Ke ".$request->abap_tcode;
                    $abap_data->tcode = $request->abap_tcode;
                    $abap_is_update = $abap_data->save();
                    $abap_is_update = true;
                }
                if($abap_data->description != $request->abap_desc){
                    $message .= "<br> Merubah  dari ".$abap_data->description ." Ke ".$request->abap_desc;
                    $abap_data->description = $request->abap_desc;
                    $abap_is_update = $abap_data->save();
                    $abap_is_update = true;
                }               
                
                if($abap_is_update){
                    
                    $title_activity = "Change on ABAP Request";

                    $create_activity = new HelpdeskActivity([
                        'helpdesk_id' => $abap->id,
                        'user_id' => Auth::user()->id,
                        'title' => $title_activity,
                    ]);
                    $create_activity->save();                    
                }
            }            
        }

         //  Declare New End Date
         $new_date_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
         date('H:i:s', strtotime($request->input('time_end') . ":00"));

        //  Comparison new end date with old end date
        if($new_date_end != $abap->date_end){
            $title_activity = "merubah <b>date end</b> dari " . $abap->date_end . " menjadi " . $new_date_end;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $abap->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check cond type update
        $new_type = $request->input("type");
        if ($new_type != $abap->type) {
            $title_activity = "merubah <b>condition type</b> dari " . $abap->type . " menjadi " . $new_type;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $abap->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check helpdesk update
        if ($helpdesk_is_updated) {
            $abap->date_end = $new_date_end;
            $abap->type = $new_type;
            $abap->save();
        }

        //Activity comment
        if (!empty($request->input('comment'))) {

            $title_activity = "comment on this post";
            $comment_is_sent = true;        

            $message .= $title_activity.'<br>';

            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $abap->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();            

            //check comment
            if (!empty($request->input('comment'))) {
                $comment = new HelpdeskComment([
                    'activity_id' => $create_activity->id,
                    'content' => ($request->input('comment')) ? $request->input('comment') : "",
                ]);
                $comment->save();
            }
        }

        if ($helpdesk_is_updated || $abap_is_update || $comment_is_sent){
            $assign_user_id = HelpdeskAssign::where('helpdesk_id', '=', $abap->id)
                        ->where('user_id', '!=', null)
                        ->pluck('user_id')
                        ->toArray();

            $assign_division_id = HelpdeskAssign::where('helpdesk_id', '=', $abap->id)
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

            if (Auth::user()->id != $abap->creator_id) {
                $owner = User::where('id', '=', $abap->creator_id)->pluck('email')->first();                
                Mail::to($owner)
                    ->send(new MIGEmail('[Helpdesk | MIG-IS] - ['.$abap->id.'] - ' . $abap->title.' - Response '.Auth::User()->name, $message));
            }

            return redirect()->route('abap.show', $abap->id)
                    ->with('success', 'Berhasil mengubah helpdesk.');
        } else {
            return redirect()->route('abap.show', $abap->id);
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

            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            if ($approval) {
                return redirect()->route('abap.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }

    public function fico_approval($approval_id,$helpdesk_id,$status) {
        $approval = HelpdeskSapApproval::find($approval_id);
        $helpdesk = Helpdesk::find($helpdesk_id);        
        
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
            
            //  init Meessage
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            if ($approval) {
                return redirect()->route('config.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }
    
    public function proman_approval($approval_id, $helpdesk_id, $status){
        $approval = HelpdeskSapApproval::find($approval_id);
        $helpdesk = Helpdesk::find($helpdesk_id);                      
        
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
            
            //  init Meessage
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }            

            if ($approval) {
                return redirect()->route('config.show', $helpdesk_id)
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

            //  init Meessage
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            if ($approval) {
                return redirect()->route('abap.show', $helpdesk_id)
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
                
        //send email to owner
        if (Auth::user()->id != $helpdesk->creator_id) {
            $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
            Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
        }        

        if ($approval) {
            return redirect()->route('abap.show', $helpdesk_id)
                        ->with('success', 'Berhasil mengubah data.');
        }
    }
}
