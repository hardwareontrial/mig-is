<?php

namespace App\Http\Controllers\Edoc;

use App\Http\Controllers\Controller;
use App\Model\Edoc\Edoc;
use App\Model\Edoc\EdocAssign;
use App\Model\Edoc\EdocActivity;
use App\Model\Edoc\EdocComment;
use App\Model\Edoc\EdocAttachment;
use App\Model\Edoc\EdocDocument;
use App\Model\Edoc\EdocForm;
use App\Model\Edoc\EdocSupporting;
use App\Model\Division;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EdocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responses
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $user_id = Auth::user()->id;
        $division_id = Auth::user()->division_id;
        $uac_admin = Auth::user()->hasAnyPermission([1,7]);

        if ($uac_admin) {
            $edocs = Edoc::with('creator','assign.user')
                        ->where(function($query) use ($keyword) {
                            $query->when($keyword, function($subquery) use ($keyword) {
                                $subquery->orWhere('id','like',"%{$keyword}%")
                                        ->orWhere('title','like',"%{$keyword}%")
                                        ->orWhere('type','like',"%{$keyword}%")
                                        ->orWhere('privilege','like',"%{$keyword}%")
                                        ->orWhere('status','like',"%{$keyword}%");
                            });
                        })
                        ->orderBy('id','desc')
                        ->paginate(10);
            $edocs->appends(['search' => $keyword]);
        } else {
            $edocs = Edoc::with('creator','assign.user')
                            ->where(function($query) use ($keyword) {
                                $query->when($keyword, function($subquery) use ($keyword) {
                                    $subquery->orWhere('id','like',"%{$keyword}%")
                                            ->orWhere('title','like',"%{$keyword}%")
                                            ->orWhere('type','like',"%{$keyword}%")
                                            ->orWhere('privilege','like',"%{$keyword}%")
                                            ->orWhere('status','like',"%{$keyword}%");
                                });
                            })
                            ->where(function($query) use ($user_id,$division_id) {
                                $query->orWhereHas('assign.user', function($childquery) use ($user_id) {
                                            $childquery->where('id','=',$user_id);
                                        })
                                        ->orWhereHas('assign.division', function($childquery) use ($division_id) {
                                            $childquery->where('id','=',$division_id);
                                        })
                                        ->orWhere('creator_id', '=', $user_id)
                                        ->orWhere('privilege','=','Public')
                                        ->orWhereHas('assign', function($childquery) use ($division_id) {
                                            $childquery->where('user_id','=',0);
                                        });
                            })
                            ->orderBy('id','desc')
                            ->paginate(10);
            $edocs->appends(['search' => $keyword]);
        }

        return view('edoc/list/index', compact('edocs','keyword'));
        //return view('general/maintenance');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null,$doc_type = null,$iso_type = null)
    {
        if ($id == null){
			$title = "Register Dokumen"; 
		} else {
			$title = "Revisi Dokumen";
        }

        if ($id != null) {
			
			if ($doc_type == 'P' || $doc_type == 'W'){
				$check_active = EdocDocument::find($id)->value('status');
				$edoc = EdocDocument::find($id);
			} else if ($doc_type == 'SD') {
				$check_active = EdocSupporting::find($id)->value('status');
				$edoc = EdocSupporting::find($id);				
			} else {
				$check_active = EdocForm::find($id)->value('status');
				$edoc = EdocForm::find($id);				
			}
			
			if ($check_active == 'Deactive')
			{
				if ($doc_type == 'P' || $doc_type == 'W'){
                    return redirect()->route('document.index',['keyword' => $id])
                        ->with('warning', 'Dokumen tidak aktif');
                    die();
				} else if ($doc_type == 'SD'){
                    return redirect()->route('supporting.index',['keyword' => $id])
                        ->with('warning', 'Dokumen tidak aktif');
                    die();
				}else {
                    return redirect()->route('form.index',['keyword' => $id])
                        ->with('warning', 'Dokumen tidak aktif');
                    die();
				}
			}
		}
        
        $users = User::GetAllUsers();
        $divisions = Division::getAll();
        return view('edoc/list/create', compact('users','divisions','edoc','title','id','iso_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datetime_start = date('Y-m-d', strtotime($request->input('date_start'))) . " " .
                          $request->input('time_start') . ":00";
        $datetime_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                         $request->input('time_end') . ":00";

        //generate edoc id
        $year = date('y');
        $month = date('m');
        $base_id = (int) $year.$month;

        if (Edoc::where('id', 'LIKE', $base_id.'%')->count() > 0) {
            $last_edoc_id = Edoc::orderBy('id', 'desc')->first();
            $edoc_id = (int) $last_edoc_id->id + 1;
        } else {
            $edoc_id = $base_id."0001";
        }

        //generate title
        $is_register = true;
        $title = strtoupper($request->input('title'));
        if ($request->input('iso_id') != null) {
            $is_register = false;
        }

        $edoc = new Edoc([
            'id' => $edoc_id,
            'iso_id' => $request->input('iso_id'),
            'iso_type' => $request->input('iso_type'),
            'title' => $is_register ? '[REGISTER] '.$title : $title,
            'creator_id' => Auth::user()->id,
            'date_start' => $datetime_start,
            'date_end' => $datetime_end,
            'type' => $request->input('type'),
            'status' => "New",
            'privilege' => $request->input('privilege'),
        ]);

        $result_edoc = $edoc->save();

         //Activity create new edoc
         $edoc_activity = new EdocActivity([
            'edoc_id' => $edoc_id,
            'user_id' => Auth::user()->id,
            'title' => "create new edoc"
        ]);
        $edoc_activity->save();

        if ($result_edoc) {

            //Activity comment & upload
            if (!empty($request->input('comment')) || !empty($request->file('attachment'))) {

                if (!empty($request->input('comment')) && !empty($request->file('attachment'))) {
                    $title_activity = "comment on this post with attachment file";
                } else if (!empty($request->file('attachment'))) {
                    $title_activity = "upload new attachment";
                } else if (!empty($request->input('comment'))) {
                    $title_activity = "comment on this post";
                }

                $create_activity = new EdocActivity([
                    'edoc_id' => $edoc_id,
                    'user_id' => Auth::user()->id,
                    'title' => $title_activity,
                ]);
                $create_activity->save();

                //check upload attachment
                if (!empty($request->file('attachment'))) {
                    $dir = 'edoc/file/'.$edoc_id.'/';
                    if (!is_dir($dir)) {
                        Storage::makeDirectory($dir);
                    }

                    $file = $request->file('attachment');
                    $name = $file->getClientOriginalName();
                    $rawname = Carbon::now()->timestamp.'_'.$name;

                    Storage::putFileAs($dir, new File($file), $rawname);

                    $create_attachment = new EdocAttachment([
                        'activity_id' => $create_activity->id,
                        'filename' => $name,
                        'filepath' => $dir.'/'.$rawname,
                    ]);

                    $create_attachment->save();
                }

                //check comment
                if (!empty($request->input('comment'))) {
                    $comment = new EdocComment([
                        'activity_id' => $create_activity->id,
                        'content' => ($request->input('comment')) ? $request->input('comment') : "",
                    ]);

                    $comment->save();
                }
            } 

            //Insert assign
            $assign_to = $request->input('assign_to');
            $assign_user_id = array();
            $assign_division_id = array();

            foreach ($assign_to as $r) {
                if (substr($r,0,2) == 'd-') {
                    $assign_division_id[] = explode('d-',$r)[1];
                    $assign_division = new EdocAssign([
                        'edoc_id' => $edoc_id,
                        'division_id' => explode('d-',$r)[1],
                    ]);
                    $assign_division->save();
                } else {
                    $assign_user_id[] = $r;
                    $assign_user = new EdocAssign([
                        'edoc_id' => $edoc_id,
                        'user_id' => $r,
                    ]);
                    $assign_user->save();
                }
            }

            if (in_array(0, $assign_user_id)) {
                $assign_user_email[] = User::where('is_active','=',1)->pluck('email')->toArray();
            } else {
                $assign_user_email[] = User::orWhereIn('division_id',$assign_division_id)
                                            ->orWhereIn('id',$assign_user_id)
                                            ->where('is_active','=',1)->pluck('email')
                                            ->toArray();
            }

            // foreach(array_filter(array_unique($assign_user_email, SORT_REGULAR)) as $r) {
            //     Mail::to($r)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $request->input('title'),
            //         "Helpdesk baru telah dibuat oleh ". Auth::user()->name ." silahkan klik <a href='".route('helpdesk.show', $helpdesk_id)."'>disini</a>"));
            // }

            return redirect()->route('list.index')
            ->with('success','Revisi edoc berhasil dibuat.');
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
        $edoc = Edoc::findOrFail($id);
        $creator = User::findOrFail($edoc->creator_id);
        $users = User::GetAllUsers();
        $divisions = Division::getAll();
        $assigns = EdocAssign::where('edoc_id','=',$edoc->id)->get();
        $activitys = EdocActivity::with('user','comment','attachment')
                        ->where('edoc_id', '=', $edoc->id)
                        ->orderBy('created_at','desc')
                        ->get(); 
        
        $assign_all = 0;
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

        return view('edoc/list/show', compact('creator','edoc','activitys','users','divisions','assign_all','assign_users','assign_divisions', 'assign_divisions_2'));
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
        $date_end_is_update = false;
        $privilege_is_update = false;
        $type_is_update = false;
        $status_is_update = false;
        $assign_to_is_update = false;

        $edoc_is_updated = false;
        $assign_is_updated = false;
        $comment_is_sent = false;
        $file_is_uploaded = false;
        
        $edoc = Edoc::findOrFail($id);

        //init message variable
		$message = "[". Auth::user()->nik. "] ". Auth::user()->name . " telah memperbarui edoc klik <a href=" . route('list.show',$edoc->id) . "> disini </a> untuk melihat detail edoc <br> <br> Log Activity:<br>";

        $new_date_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                        date('H:i:s', strtotime($request->input('time_end') . ":00"));

        //check date end update
        if ($new_date_end != $edoc->date_end) {
            $title_activity = "merubah <b>date end</b> dari " . $edoc->date_end . " menjadi " . $new_date_end;
            $create_activity = new EdocActivity([
                'edoc_id' => $edoc->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $edoc_is_updated = true;
        }

        //check privilege update
        $new_privilege = $request->input("privilege");
        if ($new_privilege != $edoc->privilege) {
            $title_activity = "merubah <b>privilege</b> dari " . $edoc->privilege . " menjadi " . $new_privilege;
            $create_activity = new EdocActivity([
                'edoc_id' => $edoc->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $edoc_is_updated = true;
        }

        //check cond type update
        $new_type = $request->input("type");
        if ($new_type != $edoc->type) {
            $title_activity = "merubah <b>condition type</b> dari " . $edoc->type . " menjadi " . $new_type;
            $create_activity = new EdocActivity([
                'edoc_id' => $edoc->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $edoc_is_updated = true;
        }

        //check status update
        $new_status = $request->input("status");
        if ($new_status != $edoc->status) {
            $title_activity = "merubah <b>status</b> dari " . $edoc->status . " menjadi " . $new_status;
            $create_activity = new EdocActivity([
                'edoc_id' => $edoc->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $edoc_is_updated = true;
        }

        //check edoc update
        if ($edoc_is_updated) {
            $edoc->date_end = $new_date_end;
            $edoc->privilege = $new_privilege;
            $edoc->type = $new_type;
            $edoc->status = $new_status;
            $edoc->save();
        }

        $new_assign_id = $request->input("assign_to");
        $old_assign_id = array();
        $old_assign_name = array();
        $new_assign_name = array();
        $data_assign = EdocAssign::with('user','division')
                                    ->where('edoc_id', '=', $edoc->id)
                                    ->get();

        foreach ($data_assign as $r) {
            if (!empty($r->user_id) && $r->user_id != 0) {
				$old_assign_id[] = (string) $r->user_id;
				$old_assign_name[] = $r->user->name;
			} else if (!empty($r->division) && empty($r->user_id)) {
				$old_assign_id[] = 'd-'.$r->division_id;
				$old_assign_name[] = $r->division->name;
			} else if ($r->user_id == 0) {
                $old_assign_id[] = "0";
                $old_assign_name[] = "Semua";
            }
        }

        if (array_diff($old_assign_id, $new_assign_id) !== array_diff($new_assign_id, $old_assign_id)) {
            $assign_is_updated = true;
            
            //check owner deleted or not
			foreach ($old_assign_id as $r)
			{
				if (!in_array($r,$new_assign_id))
				{
					if ($r == $edoc->creator_id) {
                        return redirect()->route('list.show', $edoc->id)
                        ->with('danger', 'Tidak bisa menghapus user pembuat edoc.');
                        die();
					}
				}
            }
            
            //delete user
			foreach ($old_assign_id as $y)
			{
				if (!in_array($y,$new_assign_id))
				{
                    if (substr($y,0,2) == 'd-')
                    {
                        EdocAssign::where('edoc_id', '=', $edoc->id)
                                        ->where('division_id', '=', explode('d-',$y)[1])
                                        ->delete();
                    } else {
                        EdocAssign::where('edoc_id', '=', $edoc->id)
                                        ->where('user_id', '=', $y)
                                        ->delete();
                    }
				}
            }

            //insert user
			foreach ($new_assign_id as $u)
			{
				if (!in_array($u,$old_assign_id))
				{
					if (substr($u,0,2) == 'd-') {
						$params_assign = new EdocAssign([
							'edoc_id' => $edoc->id,
							'division_id' => explode('d-',$u)[1],
                        ]);
                        $params_assign->save();
					} else {
						$params_assign = new EdocAssign([
							'edoc_id' => $edoc->id,
							'user_id' => $u,
                        ]);
                        $params_assign->save();
					}
				}
            }
            
            //Get fullname new assign user
			foreach ($new_assign_id as $r)
			{
				if (substr($r,0,2) == 'd-') {
                    $new_assign_name[] = Division::where('id','=',explode('d-',$r)[1])
                                                    ->value('name');
				} else if ($r != "0") {
					$new_assign_name[] = User::where('id','=',$r)->value('name');
				} else {
                    $new_assign_name[] = "Semua";
                }
			}

			//Set assign to timeline title
			//$timeline_title = count($new_assign_name) > 1 ? implode(", ", $new_assign_name) : $new_assign_name[0];

			// Insert timeline
            /* $this->update_timeline($id,"change <b>assign to</b> from ".implode(", ", $old_assign_name)." <b>to</b> ".$timeline_title); */
			
            // $title_activity = "merubah <b>assign to</b> dari ".implode(", ", $old_assign_name)." <b>to</b> ". count($new_assign_name) > 1 ? implode(", ", $new_assign_name) : $new_assign_name[0] . "<br>";
            $title_new_assign_name = count($new_assign_name) > 1 ? implode(", ", $new_assign_name) : $new_assign_name[0] . "<br>";
            $title_activity = "merubah <b>assign to</b> dari ".implode(", ", $old_assign_name)." <b>to</b> ". $title_new_assign_name;
            
            $create_activity = new EdocActivity([
                'edoc_id' => $edoc->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);

            $create_activity->save();

            $message .= $title_activity.'<br>';
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

            $create_activity = new EdocActivity([
                'edoc_id' => $edoc->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            //check upload attachment
            if (!empty($request->file('attachment'))) {
                $dir = 'edoc/file/'.$edoc->id.'/';
                if (!is_dir($dir)) {
                    Storage::makeDirectory($dir);
                }

                $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $rawname = Carbon::now()->timestamp.'_'.$name;

                Storage::putFileAs($dir, new File($file), $rawname);

                $create_attachment = new EdocAttachment([
                    'activity_id' => $create_activity->id,
                    'filename' => $name,
                    'filepath' => $dir.'/'.$rawname,
                ]);

                $create_attachment->save();
            }

            //check comment
            if (!empty($request->input('comment'))) {
                $comment = new EdocComment([
                    'activity_id' => $create_activity->id,
                    'content' => ($request->input('comment')) ? $request->input('comment') : "",
                ]);

                $comment->save();
            }
        }

        if ($edoc_is_updated || $assign_is_updated || $comment_is_sent || $file_is_uploaded) 
        {   
            $assign_user_id = EdocAssign::where('edoc_id', '=', $edoc->id)
                                    ->where('user_id', '!=', null)
                                    ->pluck('user_id')
                                    ->toArray();

            $assign_division_id = EdocAssign::where('edoc_id', '=', $edoc->id)
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

            // //send email to owner
            // if (Auth::user()->id != $helpdesk->creator_id) {
            //     $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
            //     Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            // }

            if ($new_status == 'Complete' && Auth::user()->hasAnyPermission([1,7])) {
				$iso_id = $request->input('iso_id');
				$iso_type = $request->input('iso_type');
				
				if ($iso_type == "Form"){
                    $iso_detail = EdocForm::findOrFail($iso_id);
                    $form_result = $this->update_form($request,$id,$iso_detail->id,$iso_detail->revisi);

                    if ($form_result['status'] == "error") {
                        return redirect()->route('list.show', $id)
                                        ->with('danger', $form_result['message']);
                        die();
                    } else {
                        return redirect()->route('list.show', $id)
                                        ->with('success', $form_result['message']);
                        die();
                    }
				} else if ($iso_type == "Document") {
					$iso_detail = EdocDocument::findOrFail($iso_id);
					$remove_number = preg_replace('/[0-9]+/', '',$iso_id);
					$jenis = substr($remove_number,-1);
                    $result = $this->update_document($request,$id,$iso_detail->id,$iso_detail->revisi,$jenis,'DOC');
                    
                    if ($result['status'] == "error") {
                        return redirect()->route('list.show', $id)
                                        ->with('danger', $result['message']);
                        die();
                    } else {
                        return redirect()->route('list.show', $id)
                                        ->with('success', $result['message']);
                        die();
                    }
				} else if ($iso_type == "Supporting") {
					$iso_detail = EdocSupporting::findOrFail($iso_id);
                    $support_result = $this->update_supporting($request,$id,$iso_detail->id,$iso_detail->revisi);

                    if ($support_result['status'] == "error") {
                        return redirect()->route('list.show', $id)
                                        ->with('danger', $support_result['message']);
                        die();
                    } else {
                        return redirect()->route('list.show', $id)
                                        ->with('success', $support_result['message']);
                        die();
                    }
				} else {
					$register_file = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);
					$title_no_id = explode("_",$register_file,2); //title without id [1]
					$remove_number = preg_replace('/[0-9]+/', '',$title_no_id[0]);
					$remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
					$remove_rev = preg_replace('/R/', '',$remove_symbols);
					$jenis = substr($remove_rev,-1);
					
					if ($jenis == 'P' || $jenis == 'W'){
                        $result = $this->upload_new_document($request,$id);
                        
                        if ($result['status'] == "error") {
                            return redirect()->route('list.show', $id)
                                            ->with('danger', $result['message']);
                            die();
                        } else {
                            return redirect()->route('list.show', $id)
                                            ->with('success', $result['message']);
                            die();
                        }
					} else if ($jenis == 'F') {
                        $result = $this->upload_new_form($request,$id);
                        
                        if ($result['status'] == "error") {
                            return redirect()->route('list.show', $id)
                                            ->with('danger', $result['message']);
                            die();
                        } else {
                            return redirect()->route('list.show', $id)
                                            ->with('success', $result['message']);
                            die();
                        }
					} else {
                        $result = $this->upload_new_supporting($request,$id);
                        
                        if ($result['status'] == "error") {
                            return redirect()->route('list.show', $id)
                                            ->with('danger', $result['message']);
                            die();
                        } else {
                            return redirect()->route('list.show', $id)
                                            ->with('success', $result['message']);
                            die();
                        }
					} 
				}
				
            }

            return redirect()->route('list.show', $edoc->id)
                        ->with('success', 'Berhasil mengubah edoc.');
        } else {
            return redirect()->route('list.show', $edoc->id);
        }
    }

    public function getValue($value) {
        return $value;
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

    public function download($id)
	{
		$attachment = EdocAttachment::where('id', $id)->firstOrFail();
		
		$pathToFile = storage_path('app/' . $attachment->filepath);
		return response()->download($pathToFile);
    }

    function update_form($request,$edoc_id,$id_document,$rev_number)
	{
		//GET DOC BY ID
        $data_document = EdocForm::findOrFail($id_document);
		
		//Get rev number from upload file
        $upload_file = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);
        
        if (strpos($upload_file, '_') === false) {
            $data = array(
                "status" => "error",
                "message" => "Format nama form tidak sesuai dengan standart"
            );
            return $data;
			die();
        }

        if (strpos($upload_file, '-R') === false) {
            $data = array(
                "status" => "error",
                "message" => "Format nama form tidak sesuai dengan standart"
            );
            return $data;
			die();
        }

		$title_id = explode("_",$upload_file,2)[0]; //title without id [1]
		$new_rev_number = explode("-R",$title_id)[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_id);
		$remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
		
		if (substr($remove_symbols,-1) != 'R')
		{
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf R untuk keterangan Revisi"
            );
            return $data;
			die();
		}
		
		$location = 'forms/';
		$file_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
		if ($rev_number != $new_rev_number) {
			$filename = $id_document . '-R' . $rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;			
            $filename_new = $id_document . '-R' . $new_rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;
            
            $file = $request->file('attachment');
            Storage::putFileAs('edoc/' . $location, new File($file), $filename_new);
            
            $edoc = EdocForm::where('id','=',$id_document)->first();
            $edoc->revisi = $new_rev_number;
            $edoc->filepath = $location.$filename_new;
            $edoc->save();

            if ($edoc) {
                $data = array(
                    "status" => "success",
                    "message" => "Sukses mengubah file form " . $edoc->title
                );
                return $data;
                die();
            }
		} else {
            $data = array(
                "status" => "error",
                "message" => "Nomor revisi harus berbeda, update tidak diproses"
            );
            return $data;
			die();
        }
    }
    
    public function update_supporting($request,$edoc_id,$id_document,$rev_number)
    {
        //GET DOC BY ID
        $data_document = EdocSupporting::findOrFail($id_document);
		
		//Get rev number from upload file
        $upload_file = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);

        if (strpos($upload_file, '-R') === false) {
            $data = array(
                "status" => "error",
                "message" => "Format nama supporting document tidak sesuai dengan standart"
            );
            return $data;
			die();
        }

		$title_id = explode("_",$upload_file,2)[0]; //title without id [1]
		$new_rev_number = explode("-R",$title_id)[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_id);
		$remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
		
		if (substr($remove_symbols,-1) != 'R')
		{
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf R untuk keterangan Revisi"
            );
            return $data;
			die();
		}
		
		$location = 'supportings/';
		$file_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
		if ($rev_number != $new_rev_number) {
			$filename = $id_document . '-R' . $rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;			
            $filename_new = $id_document . '-R' . $new_rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;
            
            $file = $request->file('attachment');
            Storage::putFileAs('edoc/' . $location, new File($file), $filename_new);
            
            $edoc = EdocSupporting::where('id','=',$id_document)->first();
            $edoc->revisi = $new_rev_number;
            $edoc->filepath = $location.$filename_new;
            $edoc->save();

            if ($edoc) {
                $data = array(
                    "status" => "success",
                    "message" => "Sukses mengubah file supporting document " . $edoc->title
                );
                return $data;
                die();
            }
		} else {
            $data = array(
                "status" => "error",
                "message" => "Nomor revisi harus berbeda, update tidak diproses"
            );
            return $data;
			die();
        }
    }

    public function update_document($request,$detail_id,$id_document,$rev_number,$jenis,$type)
	{	
		$file_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
		
		//GET DOC BY ID
		$data_document = EdocDocument::findOrFail($id_document);
		
		if ($jenis == 'W')	{
			$folder_word = 'documents/work_instruction/word/';
		} else if ($jenis == 'P') {
			$folder_word = 'documents/procedure/word/';
		}
		
		//Get rev number from upload file
		$upload_file = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);
		$title_id = explode("_",$upload_file,2)[0]; //title without id [1]
		$new_rev_number = explode("-R",$title_id)[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_id);
		$remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
		
		if (substr($remove_symbols,-1) != 'R')
		{
            $data = array(
                "status" => "error",
                "message" => "Gagal menyimpan ke master dokumen, nama file harus ada huruf R untuk keterangan Revisi"
            );
            return $data;
			die();
		}
        
        $location = $folder_word;

        if ($rev_number != $new_rev_number) {
			$filename = $id_document . '-R' . $rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;						
			$filename_new = $id_document . '-R' . $new_rev_number . '_' . preg_replace('/\s+/', '_', $data_document->title).'.'.$file_ext;
			
            $file = $request->file('attachment');
            Storage::putFileAs('edoc/' . $location, new File($file), $filename_new);
            $filename = $filename_new;
            
            if ($type == 'DOC')	
            {
                $edoc = EdocDocument::where('id','=',$id_document)->first();
                $edoc->revisi = $new_rev_number;
                $edoc->word_filepath = $folder_word.$filename;
                $edoc->save();

                if ($edoc) {
                    $data = array(
                        "status" => "success",
                        "message" => "Sukses mengubah file document " . $edoc->title
                    );
                    return $data;
                    die();
                } 
            }
		} else {
            $data = array(
                "status" => "error",
                "message" => "Nomor revisi harus berbeda, update tidak diproses"
            );
            return $data;
			die();
        }
    }
    
    public function upload_new_document($request,$id) 
    {
        $file_doc = $request->attachment;

        //check doc/pdf is uploaded
		if (file_exists($_FILES['attachment']['tmp_name'])){
			$filename = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);
        } 
        
        //check no file doc
		if (!file_exists($_FILES['attachment']['tmp_name'])){
            $data = array(
                "status" => "error",
                "message" => "File tidak boleh kosong."
            );
            return $data;
			die();
        }
        
        //check format doc
		if (!empty($_FILES['attachment']['name']) && pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION) != 'doc' && pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION) != 'docx'){
            $data = array(
                "status" => "error",
                "message" => "Upload DOC harus berformat DOC/DOCX."
            );
            return $data;
			die();
        }
        
        $title_no_id = explode("_",$filename,2); //title without id [1]
		$title_no_id_ext = explode('.',$title_no_id[1]); //title without id + ext [0]
		$remove_underscore = str_replace('_',' ',$title_no_id_ext[0]);
		$jenis_dokumen = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),-1);
        $divisi = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),0,-1);
        
        //DOC
        $doc_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        
        $file_id = $title_no_id[0];
		$file_id_no_rev = explode('-R',$title_no_id[0])[0];
		
		//get revision number
		$rev_number = explode('-R', $title_no_id[0])[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_no_id[0]);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf R untuk keterangan Revisi."
            );
            return $data;
			die();
        }
        
        //check document type
		$remove_rev = preg_replace('/R/', '',$remove_symbols);
		$jenis = substr($remove_rev,-1);
		if ($jenis != 'W' && $jenis != 'P')
		{
            $data = array(
                "status" => "error",
                "message" => "Jenis dokumen harus ada keterangan P untuk prosedur atau W untuk instruksi kerja."
            );
            return $data;
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
            $data = array(
                "status" => "error",
                "message" => "Dokumen ID '.$file_id_no_rev.' sudah ada."
            );
            return $data;
			die();
        }
        
        
        //check duplicate name
        $check_title = EdocDocument::where('jenis', '=', $jenis)
                                    ->where('title', '=', $remove_underscore)
                                    ->first();
		if (!empty($check_title->title) && strtolower(trim($check_title->title)) == strtolower(trim($remove_underscore)))
		{
            $data = array(
                "status" => "error",
                "message" => "Dokumen Title '.$remove_underscore.' sudah ada."
            );
            return $data;
			die();
        }
        
        //upload doc
        if (file_exists($_FILES['attachment']['tmp_name'])) {
			
			if ($_FILES["attachment"]["name"] != NULL)
			{
                $dir = 'edoc/'.$folder_word;
                $file = $request->file('attachment');
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

                    $data = array(
                        "status" => "success",
                        "message" => "Sukses menambah data"
                    );
                    return $data;
                    die();
                }
			}
		}
    }

    public function upload_new_form($request,$id) {
        $jenis = 'F';
		$file_form = $request->attachment;
		
		//check file is uploaded
		if (file_exists($_FILES['attachment']['tmp_name'])){
			$filename = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);
		}
		
		//check no file
		if (!file_exists($_FILES['attachment']['tmp_name'])){
            $data = array(
                "status" => "error",
                "message" => "File tidak boleh kosong."
            );
            return $data;
			die();
        }
        
        $format_file = array('xls','xlsx','doc','docx','pdf');
		
		//check format file
		if (!empty($_FILES['attachment']['name']) && !in_array(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION), $format_file)){
            $data = array(
                "status" => "error",
                "message" => "Upload file harus berformat xls,xlsx,doc,docx,pdf."
            );
            return $data;
			die();
        }
        
        $title_no_id = explode("_",$filename,2); //title without id [1]
		$title_no_id_ext = explode('.',$title_no_id[1]); //title without id + ext [0]
		$remove_underscore = str_replace('_',' ',$title_no_id_ext[0]);
		$jenis_dokumen = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),-1);
        $divisi = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),0,-1);
        
        //get file extension
		$file_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
		
		$file_id = $title_no_id[0];
		$file_id_no_rev = explode('-R',$title_no_id[0])[0];
		
		//get revision number
		$rev_number = explode('-R', $title_no_id[0])[1];
		
		//check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_no_id[0]);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf R untuk keterangan Revisi."
            );
            return $data;
			die();
        }
        
        //check document F
		$remove_rev = preg_replace('/R/', '',$remove_symbols);
		if (substr($remove_rev,-1) != 'F')
		{
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf F."
            );
            return $data;
			die();
        }
        
        //check duplicate id
		$check_id = EdocForm::find($file_id_no_rev);
		if (!empty($check_id->id) && $check_id->id == $file_id_no_rev)
		{
            $data = array(
                "status" => "error",
                "message" => "Form ID '.$file_id_no_rev.' sudah ada"
            );
            return $data;
			die();
        }
        
        //check duplicate name
        $check_title = EdocForm::where('jenis','=',$jenis)
                                    ->where('title', '=', $remove_underscore)
                                    ->first();
		if (!empty($check_title->title) && strtolower(trim($check_title->title)) == strtolower(trim($remove_underscore)))
		{
            $data = array(
                "status" => "error",
                "message" => "Form title '.$remove_underscore.' sudah ada"
            );
            return $data;
			die();
        }
        
        //upload form
        if (file_exists($_FILES['attachment']['tmp_name'])) {
			
			if ($_FILES["attachment"]["name"] != NULL)
			{
                $dir = 'edoc/forms/';
                $file = $request->file('attachment');
                $uploaded = Storage::putFileAs($dir, new File($file), $file_id.'_'.$title_no_id_ext[0].'.'.$file_ext);
                
                if ($uploaded) {
                    $edoc = new EdocForm;
                    $edoc->id = $file_id_no_rev;
                    $edoc->title = $remove_underscore;
                    $edoc->status = 'Active';
                    $edoc->jenis = $jenis;
                    $edoc->revisi = $rev_number;
                    $edoc->filepath = 'forms/'.$file_id.'_'.$title_no_id_ext[0].'.'.$file_ext;
                    $edoc->save();

                    $data = array(
                        "status" => "success",
                        "message" => "Sukses menambah data"
                    );
                    return $data;
                    die();
                }
			}
		}
    }

    public function upload_new_supporting($request,$id) {
        $jenis = 'SD';
		$file_supporting = $request->attachment;
		
		//check file is uploaded
		if (file_exists($_FILES['attachment']['tmp_name'])){
			$filename = preg_replace('/\s+/', '_', $_FILES["attachment"]["name"]);
		}
		
		//check no file
		if (!file_exists($_FILES['attachment']['tmp_name'])){
            $data = array(
                "status" => "error",
                "message" => "File tidak boleh kosong."
            );
            return $data;
			die();
		}
		
        $format_file = array('xls','xlsx','doc','docx','pdf');
        
        //check format file
		if (!empty($_FILES['attachment']['name']) && !in_array(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION), $format_file)){
            $data = array(
                "status" => "error",
                "message" => "Upload file harus berformat xls,xlsx,doc,docx,pdf."
            );
            return $data;
			die();
        }
        
        $title_no_id = explode("_",$filename,2); //title without id [1]
		$title_no_id_ext = explode('.',$title_no_id[1]); //title without id + ext [0]
		$remove_underscore = str_replace('_',' ',$title_no_id_ext[0]);
		$jenis_dokumen = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),-1);
        $divisi = substr(preg_replace('/[0-9]+/', '', $title_no_id[0]),0,-1);
        
        //get file extension
        $file_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        
        $file_id = $title_no_id[0];
        $file_id_no_rev = explode('-R',$title_no_id[0])[0];
        
        //get revision number
        $rev_number = explode('-R', $title_no_id[0])[1];
        
        //check document R
		$remove_number = preg_replace('/[0-9]+/', '',$title_no_id[0]);
        $remove_symbols = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remove_number);
        
        if (substr($remove_symbols,-1) != 'R')
		{
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf R untuk keterangan Revisi."
            );
            return $data;
			die();
        }
        
        //check document SD
		$remove_rev = preg_replace('/R/', '',$remove_symbols);
		if (substr($remove_rev,-2) != 'SD')
		{   
            $data = array(
                "status" => "error",
                "message" => "Nama file harus ada huruf SD."
            );
            return $data;
			die();
        }
        
        //check duplicate id
		$check_id = EdocSupporting::find($file_id_no_rev);
		if (!empty($check_id->id) && $check_id->id == $file_id_no_rev)
		{   
            $data = array(
                "status" => "error",
                "message" => "Supporting Document ID '.$file_id_no_rev.' sudah ada."
            );
            return $data;
			die();
        }
        
        //check duplicate name
		$check_title = EdocSupporting::where('jenis','=',$jenis)
                        ->where('title', '=', $remove_underscore)
                        ->first();
		if (!empty($check_title->title) && strtolower(trim($check_title->title)) == strtolower(trim($remove_underscore)))
		{   
            $data = array(
                "status" => "error",
                "message" => "Supporting Document title '.$remove_underscore.' sudah ada."
            );
            return $data;
			die();
        }
        
        //upload supporting doc
        if (file_exists($_FILES['attachment']['tmp_name'])) {
			
			if ($_FILES["attachment"]["name"] != NULL)
			{
                $dir = 'edoc/supportings/';
                $file = $request->file('attachment');
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

                    $data = array(
                        "status" => "success",
                        "message" => "Sukses menambah data"
                    );
                    return $data;
                    die();
                }
			}
		}
    }
}
