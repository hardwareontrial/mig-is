<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Http\File;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HelpdeskExport;

use App\Model\Helpdesk\Helpdesk;
use App\Model\Helpdesk\HelpdeskAssign;
use App\Model\Helpdesk\HelpdeskActivity;
use App\Model\Helpdesk\HelpdeskComment;
use App\Model\Helpdesk\HelpdeskAttachment;
use App\Model\Helpdesk\HelpdeskSapApproval;
use App\Model\Sap\SapVendor;
use App\Model\Sap\SapUser;
use App\Model\Sap\SapBPO;
use App\Model\Sap\SapIT;
use App\Model\Sap\SapFICOHead;
use App\Model\Sap\SapTitle;
use App\Model\Sap\SapRegion;
use App\Model\Sap\SapCountry;
use App\Model\Sap\SapReconcAcct;
use App\Model\Sap\SapProjectManag;
use App\Mail\MIGEmail;

use App\User;
use App\Model\Division;

use Carbon\Carbon;
use HelpdeskHelp;

class SapVendorController extends Controller
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
    public function create()
    {
        $bpo = SapBPO::with('user')
                        ->where('is_active','=',1)
                        ->get();

        $BpGrouping = HelpdeskHelp::BpGrouping();
        $BpTop = HelpdeskHelp::BpTop();
        $BpReconcAcct = HelpdeskHelp::BpReconAcc();

        $divisions = Division::getAll();
        $sap_users = SapUser::all();
        $sap_title = SapTitle::all();
        $sap_country = SapCountry::all();
        $sap_region = SapRegion::all();
        $sap_reconc_acct = SapReconcAcct::all();

        $assign_purc = User::where('division_id','9')
                            ->where('is_active','1')
                            ->get();

        $assign_fico = User::where('division_id','5')
                            ->where('is_active','1')
                            ->get();

        $sap_assign_bpo = DB::table('sap_bpo as A')
                            ->join('users as B', 'B.id', 'A.user_id')
                            ->get();

        return view('sap/mastervendor/create',compact('bpo','BpGrouping',
                                                      'BpTop','BpReconcAcct',
                                                      'divisions',
                                                      'sap_users','sap_title',
                                                      'sap_region', 'sap_country',
                                                      'sap_reconc_acct', 'assign_purc',
                                                      'assign_fico','sap_assign_bpo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $titlesap= SapTitle::where('id', $request->inp_title)->first();
        //dd($titlesap->title);

        // generate helpdesk id
        $year = date('y');
        $month = date('m');
        $base_id = (int) $year.$month;

        $datetime_start = date('Y-m-d', strtotime($request->input('date_start'))) . " " .
                          $request->input('time_start') . ":00";
        $datetime_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                         $request->input('time_end') . ":00";

        if (Helpdesk::where('id', 'LIKE', $base_id.'%')->count() > 0) {
            $last_helpdesk_id = Helpdesk::orderBy('id', 'desc')->first();
            $helpdesk_id = (int) $last_helpdesk_id->id + 1;
        } else {
            $helpdesk_id = $base_id."0001";
        }

        $sap_user = SapUser::find($request->input('sap_user'));
        $user_id = Auth::user()->id;

        $helpdesk_title = "[Helpdesk | MIG-IS] - [".$helpdesk_id.'] - SAP Master Data Vendor Req - '.$sap_user->username;

        /*  Insert helpdesk */
         $helpdesk = new Helpdesk([
            'id' => $helpdesk_id,
            'category' => 'SAP Master Data Vendor',
            'title' => 'Request Master Data Vendor '.$titlesap->title.' '.$request->inp_VenName,
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
            /*  Insert Vendor Master Data   */
            $sap_vendor = new SapVendor([
                "helpdesk_id" => $helpdesk_id,
                "grouping_id" => $request->groupingBP,
                "title_id" => $request->inp_title,
                "name" => $request->inp_VenName,
                "address" => $request->inp_address,
                "city" => $request->inp_city,
                "postal_code" => $request->inpt_postcode,
                "country" => $request->inp_country,
                "phone" => $request->inp_phone,
                "mobile_phone" => $request->inp_handphone,
                "email" => $request->inp_email,
                "bank_name" => $request->inp_bank,
                "bank_rek" => $request->inp_rek,
                "bank_acct_name" =>$request->inp_AccName,
                "tax_number" => $request->inp_taxNumber,
                "tax_name" => $request->inp_taxName,
                "order_currency" =>$request->inp_currency,
                "top" => $request->inp_top,
                "recon_acct_id" =>$request->inp_reconciliation,
                "wht_id" => $request->inp_wht,
            ]);
            $insert_sap_vendor = $sap_vendor->save();

            if($insert_sap_vendor){

                /*  Activity create new helpdesk  */
                $helpdesk_activity = new HelpdeskActivity([
                    'helpdesk_id' => $helpdesk_id,
                    'user_id' => Auth::user()->id,
                    'title' => "Create new helpdesk SAP Master Data Vendor"
                ]);
                $helpdesk_activity->save();

                $SAP_fico = SapFICOHead::where('is_active', '1')->pluck('user_id')->first();
                $SAP_it = SapIT::where('type','Master Data')->where('is_active','1')->pluck('user_id')->first();
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
                        Mail::to($user_email)->send(new MIGEmail($helpdesk_title,
                        "Helpdesk permintaan SAP Master Data Vendor telah dibuat oleh ". Auth::user()->name ."
                        silahkan klik <a href='".route('vendor.show', $helpdesk_id)."'>disini</a>"));
                    }
                }

                return redirect()->route('helpdesk.index')
                                 ->with('success','New helpdesk successfully created.');
            }
        }

        return redirect()->route('helpdesk.index')
            ->with('danger','New helpdesk failed created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Helpdesk  $helpdesk
     * @return \Illuminate\Http\Response
     */

    public function show(Helpdesk $vendor)
    {
        $creator = User::findOrFail($vendor->creator_id);
        $users = User::GetAllUsers();
        $divisions = Division::getAll();

        $assigns = HelpdeskAssign::where('helpdesk_id','=',$vendor->id)->get();
        $activitys = HelpdeskActivity::with('user','comment','attachment')
                        ->where('helpdesk_id', '=', $vendor->id)
                        ->orderBy('created_at','desc')
                        ->get();
        $approval = HelpdeskSapApproval::where('helpdesk_id','=',$vendor->id)->first();

		$bpo = SapBPO::with('user')
                        ->where('is_active','=',1)
                        ->get();
        $BpGrouping = HelpdeskHelp::BpGrouping();
        $sap_title = SapTitle::all();
        $BpTop = HelpdeskHelp::BpTop();
        $BpReconcAcct = HelpdeskHelp::BpReconAcc();

        $sap_vendor = SapVendor::where('helpdesk_id','=',$vendor->id)
                                    ->where('is_active','=',1)
                                    ->first();

        $sap_user = SapUser::find($vendor->sap_user_id);

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

        $helpdesk = $vendor;

        return view('sap.mastervendor.show', compact(
                                                     'sap_user','bpo','approval',
                                                     'BpGrouping','sap_title',
                                                     'creator','helpdesk','activitys',
                                                     'users','divisions','assign_all','assign_users',
                                                     'assign_divisions', 'assign_divisions_2',
                                                     'sap_vendor','BpTop','BpReconcAcct'
                                                    ));
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
    public function update(Request $request, Helpdesk $vendor)
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
        $vendor_is_update = false;

        //init message variable
        $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "
                    telah memperbarui helpdesk klik <a href=" . route('helpdesk.show',$vendor->id) . ">
                    disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";

        $new_date_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                        date('H:i:s', strtotime($request->input('time_end') . ":00"));

        //check approval
        $approval = HelpdeskSapApproval::where('helpdesk_id','=',$vendor->id)->first();

        if ($approval['fico_head_approve'] == null && $approval['bpo_approve'] == null) {
            $data_sap_vendor = SapVendor::where('helpdesk_id', $vendor->id)->first();

            if($data_sap_vendor->grouping_id != $request->input('inp_grouping')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'grouping_id' => $request->input('inp_grouping')
                ]);
            }
            if($data_sap_vendor->title_id != $request->input('inp_title')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'title_id' => $request->input('inp_title')
                ]);
            }
            if($data_sap_vendor->name != $request->input('inp_VenName')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'name' => $request->input('inp_VenName')
                ]);
            }
            if($data_sap_vendor->address != $request->input('inp_address')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'address' => $request->input('inp_address')
                ]);
            }
            if($data_sap_vendor->city != $request->input('inp_city')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'city' => $request->input('inp_city')
                ]);
            }
            if($data_sap_vendor->postal_code != $request->input('inpt_postcode')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'postal_code' => $request->input('inpt_postcode')
                ]);
            }
            if($data_sap_vendor->country != $request->input('inp_country')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'country' => $request->input('inp_country')
                ]);
            }
            if($data_sap_vendor->phone != $request->input('inp_phone')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'phone' => $request->input('inp_phone')
                ]);
            }
            if($data_sap_vendor->mobile_phone != $request->input('inp_handphone')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'mobile_phone' => $request->input('inp_handphone')
                ]);
            }
            if($data_sap_vendor->email != $request->input('inp_email')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'email' => $request->input('inp_email')
                ]);
            }
            if($data_sap_vendor->bank_name != $request->input('inp_bank')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'bank_name' => $request->input('inp_bank')
                ]);
            }
            if($data_sap_vendor->bank_rek != $request->input('inp_rek')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'bank_rek' => $request->input('inp_rek')
                ]);
            }
            if($data_sap_vendor->bank_acct_name != $request->input('inp_AccName')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'bank_acct_name' => $request->input('inp_AccName')
                ]);
            }
            if($data_sap_vendor->tax_number != $request->input('inp_taxName')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'tax_number' => $request->input('inp_taxName')
                ]);
            }
            if($data_sap_vendor->tax_name != $request->input('inp_taxName')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'tax_name' => $request->input('inp_taxName')
                ]);
            }
            if($data_sap_vendor->order_currency != $request->input('inp_currency')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'order_currency' => $request->input('inp_currency')
                ]);
            }
            if($data_sap_vendor->top != $request->input('inp_top')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'top' => $request->input('inp_top')
                ]);
            }
            if($data_sap_vendor->recon_acct_id != $request->input('inp_reconciliation')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'recon_acct_id' => $request->input('inp_reconciliation')
                ]);
            }
            if($data_sap_vendor->wht_id != $request->input('inp_wht')){
                $vendor_is_update = SapVendor::where('helpdesk_id', $vendor->id)->update([
                    'wht_id' => $request->input('inp_wht')
                ]);
            }

            if($vendor_is_update){
                $title_activity = "merubah Detail Informasi Vendor";
                $create_activity = new HelpdeskActivity([
                                    'helpdesk_id' => $vendor->id,
                                    'user_id' => Auth::user()->id,
                                    'title' => $title_activity,
                                ]);
                $create_activity->save();
                $message .= "<b>".$title_activity."<b>";
            }

            if($vendor->date_end != $new_date_end){
                $title_activity = "merubah tanggal akhir helpdesk dari ".$vendor->date_end." ke ".$request->date_end;
                $create_activity = new HelpdeskActivity([
                                    'helpdesk_id' => $vendor->id,
                                    'user_id' => Auth::user()->id,
                                    'title' => $title_activity,
                                ]);
                $create_activity->save();
                $message .= $title_activity;
            }

            if($vendor->type != $request->type){
                $title_activity = "Merubah type dari ".$vendor->type." ke ".$request->type;
                $create_activity = new HelpdeskActivity([
                    'helpdesk_id' => $vendor->id,
                    'user_id' => Auth::user()->id,
                    'title' => $title_activity,
                ]);
                $create_activity->save();
                $message .= $title_activity;
            }

            $update_helpdesk = Helpdesk::find($vendor->id)->update([
                'date_end' => $new_date_end,
                'type' => $request->type
            ]);
            $helpdesk_is_updated = $update_helpdesk;


        }

        //Activity comment
        if (!empty($request->input('comment'))) {

            $title_activity = "comment on this post";
            $comment_is_sent = true;

            $message .= $title_activity.'<br>';

            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $vendor->id,
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

        if ($helpdesk_is_updated || $assign_is_updated || $comment_is_sent || $file_is_uploaded)
        {
            $assign_user_id = HelpdeskAssign::where('helpdesk_id', '=', $vendor->id)
                                    ->where('user_id', '!=', null)
                                    ->pluck('user_id')
                                    ->toArray();

            $assign_division_id = HelpdeskAssign::where('helpdesk_id', '=', $vendor->id)
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
            if (Auth::user()->id != $vendor->creator_id) {
                $owner = User::where('id', '=', $vendor->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $vendor->title, $message));
            }

            return redirect()->route('vendor.show', $vendor->id)
                        ->with('success', 'Berhasil mengubah helpdesk.');
        } else {
            return redirect()->route('vendor.show', $vendor->id)->with('warning', 'Helpdesk tidak dapat di edit!');
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
                $title_activity = "menyetujui permintaan create vendor baru";
            } else if ($status == 0) {
                $title_activity = "menolak permintaan create vendor baru";
            }

            // Initial Message
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('vendor.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

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

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            if ($approval) {
                return redirect()->route('vendor.show', $helpdesk_id)
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

            // Initial Message
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('vendor.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            $approval->fico_head_approve = $status;
            $approval->fico_head_act_at = date('Y-m-d H:i:s');
            $approval->save();

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
                return redirect()->route('vendor.show', $helpdesk_id)
                            ->with('success', 'Berhasil mengubah helpdesk.');
            }
        }
    }


    public function it_approval($approval_id,$helpdesk_id,$status) {
        $approval = HelpdeskSapApproval::find($approval_id);
        $helpdesk = Helpdesk::find($helpdesk_id);

        if ($approval->bpo_approve != null && $approval->fico_head_approve != null) {

            $title_activity = "";
            if ($status == 1) {
                $title_activity = "menyetujui permintaan otorisasi, dan status helpdesk menjadi Complete";
            } else if ($status == 0) {
                $title_activity = "menolak permintaan otorisasi, dan status helpdesk menjadi Complete";
            }

            //  init Meessage
            $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
            $message .= $title_activity;

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

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            if ($approval) {
                return redirect()->route('vendor.show', $helpdesk_id)
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
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        } else if ($type == "FICO") {
            $approval->fico_head_approve = NULL;
            $approval->fico_head_act_at = NULL;
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        } else if ($type == "proman") {
            $approval->proman_approve = NULL;
            $approval->proman_act_at = NULL;
            $approval->save();
        }else if ($type == "IT") {
            $approval->it_approve = NULL;
            $approval->it_act_at = NULL;
            $approval->save();
        }

        $helpdesk->status = "In Process";
        $helpdesk->save();

        $title_activity = "membatalkan approval otorisasi";

        // Initial Message
        $message = "[". Auth::user()->nik. "] ". Auth::user()->name . "<a href=" . route('helpdesk.show',$helpdesk_id) . "> klik disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";
        $message .= $title_activity;

        $create_activity = new HelpdeskActivity([
            'helpdesk_id' => $helpdesk_id,
            'user_id' => Auth::user()->id,
            'title' => $title_activity,
        ]);
        $create_activity->save();

        //send email to owner
        if (Auth::user()->id != $helpdesk->creator_id) {
            $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
            Mail::to("dwiki@molindointigas.co.id")->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
        }

        if ($approval) {
            return redirect()->route('vendor.show', $helpdesk_id)
                        ->with('success', 'Berhasil mengubah data.');
        }
    }
}
