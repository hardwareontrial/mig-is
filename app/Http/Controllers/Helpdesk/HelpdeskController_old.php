<?php

namespace App\Http\Controllers\Helpdesk;

use App\Exports\HelpdeskExport;
use App\Model\Helpdesk\Helpdesk;
use App\Model\Helpdesk\HelpdeskAssign;
use App\Model\Helpdesk\HelpdeskActivity;
use App\Model\Helpdesk\HelpdeskComment;
use App\Model\Helpdesk\HelpdeskAttachment;
use App\Model\Helpdesk\HelpdeskSapForm;
use App\Model\Helpdesk\HelpdeskMasterData;
use App\Mail\MIGEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Division;
use Carbon\Carbon;

class HelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category = 'all')
    {
        $user_id = Auth::user()->id;
        $division_id = Auth::user()->division_id;
        $keyword = $request->keyword;
        $date_search = $request->date_search;
        $date_start = "";
        $date_end = "";

        if (!empty($request->date_search)) {
            $date_start = date('Y-m-d', strtotime(explode(' - ',$request->date_search)[0])) . " 00:00:00";
            $date_end = date('Y-m-d', strtotime(explode(' - ',$request->date_search)[1])) . " 23:59:59";
        }
        
        // echo $date_end;
        // die();
        $helpdesks = Helpdesk::with('creator','assign.user','assign.division')
                        ->when($category == 'new' || $category == 'in_process' || $category == 'complete' || $category == 'pending' || $category == 'all', function($query) use ($user_id, $keyword, $category, $division_id, $date_search, $date_start, $date_end){
                            $query->when($category == 'new', function($subquery) use ($user_id) {
                                        $subquery->where('status', '=', 'New')
                                                 ->where('creator_id', '=', $user_id);
                                    })
                                    ->when($category == 'in_process', function($subquery) use ($user_id) {
                                        $subquery->where('status', '=', 'In Process')
                                                 ->where('creator_id', '=', $user_id);
                                    })
                                    ->when($category == 'complete', function($subquery) use ($user_id) {
                                        $subquery->where('status', '=', 'Complete')
                                                 ->where('creator_id', '=', $user_id);
                                    })
                                    ->when($category == 'pending', function($subquery) use ($user_id) {
                                        $subquery->where('status', '=', 'Pending')
                                                 ->where('creator_id', '=', $user_id);
                                    })
                                    ->when($category == 'all', function($subquery) use ($user_id, $division_id, $keyword) {
                                            $subquery->where(function ($x) use ($user_id, $division_id) 
                                            {
                                                $x->orWhereHas('assign.user', function($childquery) use ($user_id) {
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
                                            });
                                    })
                                    ->when($keyword, function ($subquery) use ($keyword, $date_start, $date_end, $date_search) {
                                        $subquery->where(function ($q) use ($keyword,$date_start,$date_end,$date_search) {
                                                    $q->orWhere('id','like',"%{$keyword}%")
                                                      ->orWhere('title','like',"%{$keyword}%")
                                                      ->orWhere('type','like',"%{$keyword}%")
                                                      ->orWhere('privilege','like',"%{$keyword}%")
                                                      ->orWhere('status','like',"%{$keyword}%")
                                                      ->orWhere(function ($y) use ($date_start, $date_end) {
                                                          $y->whereBetween('date_start', [$date_start, $date_end])
                                                            ->whereBetween('date_end', [$date_start, $date_end]);
                                                      })
                                                      ->orWhereHas('creator', function ($query2) use ($keyword) {
                                                            $query2->where('id','like',"%{$keyword}%");
                                                      });
                                                });
                                    })
                                    ->when($date_search, function ($y) use ($date_start, $date_end) {
                                        $y->where(function ($q) use ($date_start, $date_end) {
                                            $q->whereBetween('date_start', [$date_start, $date_end])
                                              ->orWhereBetween('date_end', [$date_start, $date_end]);
                                        });
                                    });
                        })
                        ->when($category == 'assign_new' || $category == 'assign_in_process' || $category == 'assign_complete' || $category == 'assign_pending' , function($query) use ($user_id, $division_id, $category, $keyword, $date_start, $date_end, $date_search) 
                        {
                                $query->where(function($subquery) use ($user_id, $division_id) {
                                            $subquery->orWhereHas('assign.user', function($childquery) use ($user_id) {
                                                        $childquery->where('id', '=', $user_id);
                                                    })
                                                  ->orWhereHas('assign.division', function($childquery) use ($division_id) {
                                                        $childquery->where('id', '=', $division_id);
                                                    })
                                                  ->orWhereHas('assign', function($childquery) use ($division_id) {
                                                        $childquery->where('user_id','=',0);
                                                    });
                                        })
                                        ->when($category == 'assign_new', function($subquery) {
                                            $subquery->where('status', '=', 'New');
                                        })
                                        ->when($category == 'assign_in_process', function($subquery) {
                                            $subquery->where('status', '=', 'In Process');
                                        })
                                        ->when($category == 'assign_complete', function($subquery) {
                                            $subquery->where('status', '=', 'Complete');
                                        })
                                        ->when($category == 'assign_pending', function($subquery) {
                                            $subquery->where('status', '=', 'Pending');
                                        })
                                        ->when($keyword, function ($subquery) use ($keyword) {
                                            $subquery->where(function ($q) use ($keyword) {
                                                        $q->orWhere('id','like',"%{$keyword}%")
                                                          ->orWhere('title','like',"%{$keyword}%")
                                                          ->orWhere('type','like',"%{$keyword}%")
                                                          ->orWhere('privilege','like',"%{$keyword}%")
                                                          ->orWhere('status','like',"%{$keyword}%")
                                                          ->orWhereHas('creator', function ($query2) use ($keyword){
                                                                $query2->where('id','like',"%{$keyword}%");
                                                          });
                                                    });
                                        })
                                        ->when($date_search, function ($y) use ($date_start, $date_end) {
                                            $y->where(function ($q) use ($date_start, $date_end) {
                                                $q->whereBetween('date_start', [$date_start, $date_end])
                                                  ->orWhereBetween('date_end', [$date_start, $date_end]);
                                            });
                                        });
                        })
                        // ->when(!empty($request->date_search), function ($y) use ($date_start, $date_end) {
                        //     $y->whereBetween('date_start', [$date_start, $date_end])
                        //       ->orWhereBetween('date_end', [$date_start, $date_end]);
                        // })
                        ->orderBy('id','desc')
                        ->paginate(10);

        if (!empty($request->date_search)) {
            $helpdesks->appends(['search' => $keyword, 'date' => $request->date_search]);
        } else {
            $helpdesks->appends(['search' => $keyword]);
        }
        
        
        $total_new = Helpdesk::where('creator_id', '=', Auth::user()->id)
                                            ->where('status', '=', 'New')->get();
        
        $total_process = Helpdesk::where('creator_id', '=', Auth::user()->id)
                                            ->where('status', '=', 'In Process')->get();

        $total_pending = Helpdesk::where('creator_id', '=', Auth::user()->id)
                                            ->where('status', '=', 'Pending')->get();

        $total_complete = Helpdesk::where('creator_id', '=', Auth::user()->id)
                                            ->where('status', '=', 'Complete')->get();

        $total_assign_new = Helpdesk::with(['assign.user','assign.division'])
                                        ->where(function($query) use ($user_id,$division_id){
                                            $query->orWhereHas('assign.user', function($subquery) use ($user_id) {
                                                        $subquery->where('id', '=', $user_id);
                                                    })
                                                ->orWhereHas('assign.division', function($subquery) use ($division_id) {
                                                        $subquery->where('id', '=', $division_id);
                                                    })
                                                ->orWhereHas('assign', function($subquery) {
                                                    $subquery->where('user_id','=',0);
                                                });
                                        })
                                        ->where('status', '=', "New")->get();
        
        
        $total_assign_process = Helpdesk::with(['assign.user', 'assign.division'])
                                        ->where(function($query) use ($user_id,$division_id){
                                            $query->orWhereHas('assign.user', function($subquery) use ($user_id) {
                                                        $subquery->where('id', '=', $user_id);
                                                    })
                                                ->orWhereHas('assign.division', function($subquery) use ($division_id) {
                                                        $subquery->where('id', '=', $division_id);
                                                    })
                                                ->orWhereHas('assign', function($subquery) {
                                                        $subquery->where('user_id','=',0);
                                                    });
                                        })
                                        ->where('status', '=', 'In Process')->get();

        $total_assign_complete = Helpdesk::with(['assign.user', 'assign.division' ])
                                        ->where(function($query) use ($user_id,$division_id){
                                            $query->orWhereHas('assign.user', function($subquery) use ($user_id) {
                                                        $subquery->where('id', '=', $user_id);
                                                    })
                                                  ->orWhereHas('assign.division', function($subquery) use ($division_id) {
                                                        $subquery->where('id', '=', $division_id);
                                                    })
                                                  ->orWhereHas('assign', function($subquery) {
                                                        $subquery->where('user_id','=',0);
                                                    });
                                        })
                                        ->where('status', '=', 'Complete')->get();

        $total_assign_pending = Helpdesk::with(['assign.user', 'assign.division' ])
                                        ->where(function($query) use ($user_id,$division_id){
                                            $query->orWhereHas('assign.user', function($subquery) use ($user_id) {
                                                        $subquery->where('id', '=', $user_id);
                                                    })
                                                  ->orWhereHas('assign.division', function($subquery) use ($division_id) {
                                                        $subquery->where('id', '=', $division_id);
                                                    })
                                                  ->orWhereHas('assign', function($subquery) {
                                                        $subquery->where('user_id','=',0);
                                                    });
                                        })
                                        ->where('status', '=', 'Pending')->get();

        return view('helpdesk/index',compact('keyword', 'date_search', 'helpdesks', 'total_new', 'total_process', 'total_pending', 'total_complete', 'total_assign_new', 'total_assign_process', 'total_assign_complete', 'total_assign_pending', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::GetAllUsers();
        $divisions = Division::getAll();

        return view('helpdesk/create',compact('users','divisions'));
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

        //generate helpdesk id
        $year = date('y');
        $month = date('m');
        $base_id = (int) $year.$month;

        if (Helpdesk::where('id', 'LIKE', $base_id.'%')->count() > 0) {
            $last_helpdesk_id = Helpdesk::orderBy('id', 'desc')->first();
            $helpdesk_id = (int) $last_helpdesk_id->id + 1;
        } else {
            $helpdesk_id = $base_id."0001";
        }

        $helpdesk = new Helpdesk([
            'id' => $helpdesk_id,
            'title' => strtoupper($request->input('title')),
            'creator_id' => Auth::user()->id,
            'date_start' => $datetime_start,
            'date_end' => $datetime_end,
            'type' => $request->input('type'),
            'status' => "New",
            'privilege' => $request->input('privilege'),
        ]);

        $result_helpdesk = $helpdesk->save();

        if ($result_helpdesk) {
            //Activity create new helpdesk
            $helpdesk_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk_id,
                'user_id' => Auth::user()->id,
                'title' => "create new helpdesk"
            ]);
            $helpdesk_activity->save();

            //Activity comment & upload
            if (!empty($request->input('comment')) || !empty($request->file('attachment'))) {

                if (!empty($request->input('comment')) && !empty($request->file('attachment'))) {
                    $title_activity = "comment on this post with attachment file";
                } else if (!empty($request->file('attachment'))) {
                    $title_activity = "upload new attachment";
                } else if (!empty($request->input('comment'))) {
                    $title_activity = "comment on this post";
                }

                $create_activity = new HelpdeskActivity([
                    'helpdesk_id' => $helpdesk_id,
                    'user_id' => Auth::user()->id,
                    'title' => $title_activity,
                ]);
                $create_activity->save();

                //check upload attachment
                if (!empty($request->file('attachment'))) {
                    $dir = 'helpdesk/'.$helpdesk_id.'/';
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

            //Insert assign
            $assign_to = $request->input('assign_to');
            $assign_user_id = array();
            $assign_division_id = array();

            foreach ($assign_to as $r) {
                if (substr($r,0,2) == 'd-') {
                    $assign_division_id[] = explode('d-',$r)[1];
                    $assign_division = new HelpdeskAssign([
                        'helpdesk_id' => $helpdesk_id,
                        'division_id' => explode('d-',$r)[1],
                    ]);
                    $assign_division->save();
                } else {
                    $assign_user_id[] = $r;
                    $assign_user = new HelpdeskAssign([
                        'helpdesk_id' => $helpdesk_id,
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

            foreach(array_filter(array_unique($assign_user_email, SORT_REGULAR)) as $r) {
                Mail::to($r)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $request->input('title'),
                    "Helpdesk baru telah dibuat oleh ". Auth::user()->name ." silahkan klik <a href='".route('helpdesk.show', $helpdesk_id)."'>disini</a>"));
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
    public function show(Helpdesk $helpdesk)
    {
        $creator = User::findOrFail($helpdesk->creator_id);
        $users = User::GetAllUsers();
        $divisions = Division::getAll();
        $assigns = HelpdeskAssign::where('helpdesk_id','=',$helpdesk->id)->get();
        $activitys = HelpdeskActivity::with('user','comment','attachment')
                        ->where('helpdesk_id', '=', $helpdesk->id)
                        ->orderBy('created_at','desc')
                        ->get(); 
        
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

        return view('helpdesk/show', compact('creator','helpdesk','activitys','users','divisions','assign_all','assign_users','assign_divisions', 'assign_divisions_2'));
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
    public function update(Request $request, Helpdesk $helpdesk)
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
        

        //init message variable
		$message = "[". Auth::user()->nik. "] ". Auth::user()->name . " telah memperbarui helpdesk klik <a href=" . route('helpdesk.show',$helpdesk->id) . "> disini </a> untuk melihat detail helpdesk <br> <br> Log Activity:<br>";

        $new_date_end = date('Y-m-d', strtotime($request->input('date_end'))) . " " .
                        date('H:i:s', strtotime($request->input('time_end') . ":00"));

        //check date end update
        if ($new_date_end != $helpdesk->date_end) {
            $title_activity = "merubah <b>date end</b> dari " . $helpdesk->date_end . " menjadi " . $new_date_end;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check privilege update
        $new_privilege = $request->input("privilege");
        if ($new_privilege != $helpdesk->privilege) {
            $title_activity = "merubah <b>privilege</b> dari " . $helpdesk->privilege . " menjadi " . $new_privilege;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check cond type update
        $new_type = $request->input("type");
        if ($new_type != $helpdesk->type) {
            $title_activity = "merubah <b>condition type</b> dari " . $helpdesk->type . " menjadi " . $new_type;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check status update
        $new_status = $request->input("status");
        if ($new_status != $helpdesk->status) {
            $title_activity = "merubah <b>status</b> dari " . $helpdesk->status . " menjadi " . $new_status;
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();
            $message .= $title_activity."<br>";
            $helpdesk_is_updated = true;
        }

        //check helpdesk update
        if ($helpdesk_is_updated) {
            $helpdesk->date_end = $new_date_end;
            $helpdesk->privilege = $new_privilege;
            $helpdesk->type = $new_type;
            $helpdesk->status = $new_status;
            $helpdesk->save();
        }

        $new_assign_id = $request->input("assign_to");
        $old_assign_id = array();
        $old_assign_name = array();
        $new_assign_name = array();
        $data_assign = HelpdeskAssign::with('user','division')
                                    ->where('helpdesk_id', '=', $helpdesk->id)
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
					if ($r == $helpdesk->creator_id) {
                        return redirect()->route('helpdesk.show', $helpdesk->id)
                        ->with('danger', 'Tidak bisa menghapus user pembuat helpdesk.');
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
                        HelpdeskAssign::where('helpdesk_id', '=', $helpdesk->id)
                                        ->where('division_id', '=', explode('d-',$y)[1])
                                        ->delete();
                    } else {
                        HelpdeskAssign::where('helpdesk_id', '=', $helpdesk->id)
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
						$params_assign = new HelpdeskAssign([
							'helpdesk_id' => $helpdesk->id,
							'division_id' => explode('d-',$u)[1],
                        ]);
                        $params_assign->save();
					} else {
						$params_assign = new HelpdeskAssign([
							'helpdesk_id' => $helpdesk->id,
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
            
            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk->id,
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

            $create_activity = new HelpdeskActivity([
                'helpdesk_id' => $helpdesk->id,
                'user_id' => Auth::user()->id,
                'title' => $title_activity,
            ]);
            $create_activity->save();

            //check upload attachment
            if (!empty($request->file('attachment'))) {
                $dir = 'helpdesk/'.$helpdesk->id.'/';
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
            $assign_user_id = HelpdeskAssign::where('helpdesk_id', '=', $helpdesk->id)
                                    ->where('user_id', '!=', null)
                                    ->pluck('user_id')
                                    ->toArray();

            $assign_division_id = HelpdeskAssign::where('helpdesk_id', '=', $helpdesk->id)
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

            foreach(array_filter(array_unique($assign_user_email, SORT_REGULAR)) as $r) {
                Mail::to($r)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            //send email to owner
            if (Auth::user()->id != $helpdesk->creator_id) {
                $owner = User::where('id', '=', $helpdesk->creator_id)->pluck('email')->first();
                Mail::to($owner)->send(new MIGEmail('[Helpdesk | MIG-IS] - ' . $helpdesk->title, $message));
            }

            return redirect()->route('helpdesk.show', $helpdesk->id)
                        ->with('success', 'Berhasil mengubah helpdesk.');
        } else {
            return redirect()->route('helpdesk.show', $helpdesk->id);
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

    public function SendMail()
    {
        Mail::to('reza@molindointigas.co.id')->send(new MIGEmail('Helpdesk | MIG-IS','Reza Kurniawan'));
        die();
    }

    public function AllHelpdesk()
    {
        $user_id = 104;
        $division_id = 8;
        $category = "all";
        $data = Helpdesk::with('creator','assign.user','assign.division')
                        ->when($category == 'new', function($query) use ($user_id) {
                            $query->where('status', '=', 'New')
                                ->where('creator_id', '=', $user_id);
                        })
                        ->when($category == 'in_process', function($query) use ($user_id) {
                            $query->where('status', '=', 'In Process')
                                ->where('creator_id', '=', $user_id);
                        })
                        ->when($category == 'complete', function($query) use ($user_id) {
                            $query->where('status', '=', 'Complete')
                                ->where('creator_id', '=', $user_id);
                        })
                        ->when($category == 'pending', function($query) use ($user_id) {
                            $query->where('status', '=', 'Pending')
                                ->where('creator_id', '=', $user_id);
                        })
                        ->when($category == 'all', function($query) use ($user_id, $division_id) {
                                $query->orWhereHas('assign.user', function($subquery) use ($user_id) {
                                        $subquery->where('id','=',$user_id);
                                    })
                                    ->orWhereHas('assign.division', function($subquery) use ($division_id) {
                                        $subquery->where('id','=',$division_id);
                                    })
                                    ->orWhere('creator_id', '=', $user_id)
                                    ->orWhere('privilege','=','Public')
                                    ->orWhereHas('assign', function($subquery) use ($division_id) {
                                        $subquery->where('user_id','=',0);
                                    });
                        })
                        ->when($category == 'assign_new' || $category == 'assign_in_process' || $category == 'assign_complete' || $category == 'assign_pending' , function($query) use ($user_id, $division_id, $category) 
                        {
                                $query->where(function($subquery) use ($user_id, $division_id) {
                                            $subquery->orWhereHas('assign.user', function($childquery) use ($user_id) {
                                                        $childquery->where('id', '=', $user_id);
                                                    })
                                                ->orWhereHas('assign.division', function($childquery) use ($division_id) {
                                                        $childquery->where('id', '=', $division_id);
                                                    });
                                        })
                                        ->when($category == 'assign_new', function($subquery) {
                                            $subquery->where('status', '=', 'New');
                                        })
                                        ->when($category == 'assign_in_process', function($subquery) {
                                            $subquery->where('status', '=', 'In Process');
                                        })
                                        ->when($category == 'assign_complete', function($subquery) {
                                            $subquery->where('status', '=', 'Complete');
                                        })
                                        ->when($category == 'assign_pending', function($subquery) {
                                            $subquery->where('status', '=', 'Pending');
                                        });
                        })
                        ->orderBy('id','desc')
                        ->paginate(10);
                        
        return response()->json(['success' => true, 'message' => 'Data berhasil di tampilkan', 'data'=> $data]);
    }

    public function HelpdeskActivity()
    {
        $data = HelpdeskActivity::with('user','comment','attachment')
        ->where('helpdesk_id','=','19080005')
        ->orderBy('created_at','desc')
        ->get(); 

        $user_id = 56;
        $data2 = HelpdeskAssign::with('user','division')
                ->where('helpdesk_id', '=', "19090001")
                ->get();

        return response()->json(['success' => true, 'message' => 'Data berhasil di tampilkan', 'data'=> $data2]); 
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
}
