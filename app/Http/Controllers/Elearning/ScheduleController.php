<?php

namespace App\Http\Controllers\Elearning;

use App\Exports\ScheduleExport;
use App\Http\Controllers\Controller;
use App\Model\Division;
use App\Model\Position;
use App\Model\Elearning\ExamSchedule;
use App\Model\Elearning\ExamParticipant;
use App\Model\Elearning\ExamPagePosition;
use App\Model\Elearning\QuestionCollection;
use App\Model\Elearning\QuestionContent;
use App\Model\Elearning\Raport;
use App\Model\Elearning\ExamUserAnswer;
use App\Model\Elearning\QuestionAnswer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:admin all|admin okm|create schedule okm'])->only(['create']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $category = "all")
    {
        $uac_create = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,33))
                                    ->get()
                                    ->pluck('name')
                                    ->toArray());
        $uac_delete = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,34))
                                    ->get()
                                    ->pluck('name')
                                    ->toArray());
        $uac_update = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24,37))
                                    ->get()
                                    ->pluck('name')
                                    ->toArray());
		$uac_admin = Auth::user()->hasAnyPermission([1,24]);

        $keyword = $request->keyword;
        $current_date_time = date("Y-m-d H:i:s");
        //$category = "all"; 
        
        if ($uac_admin) {
            $schedules = ExamSchedule::with('collection','creator')
                                       ->when($keyword, function ($query) use ($keyword){
                                           $query->where('duration','like', "%{$keyword}%")
                                                 ->orWhere('date_start','like', "%{$keyword}%")
                                                 ->orWhereHas('collection', function ($query2) use ($keyword) {
                                                        $query2->where('title','like',"%{$keyword}%");
                                                    });
                                       })
                                       ->when($category, function ($query2) use ($category) {
                                           if ($category == "now") {
                                                $query2->where('date_start','<=', date("Y-m-d H:i:s"))
                                                       ->where('date_end','>=', date("Y-m-d H:i:s"));
                                           } else if ($category == "upcomming") {
                                               $query2->where('date_start','>', date("Y-m-d H:i:s"));
                                           } else if ($category == "done") {
                                               $query2->where('date_end','<', date("Y-m-d H:i:s"));
                                           }
                                       })
                                       ->where('is_active','=',1)
                                       ->orderBy('created_at', 'DESC')->paginate(10);
            $schedules->appends($request->only('keyword'));
        } else {
            $user_nik = Auth::user()->nik;
            $user_id = Auth::user()->id;
            $schedules = ExamSchedule::with('collection','raport','creator')
                                       ->when($keyword, function ($query) use ($keyword){
                                           $query->orWhere('duration','like', "%{$keyword}%")
                                                 ->orWhere('date_start','like', "%{$keyword}%")
                                                 ->orWhereHas('collection', function ($query2) use ($keyword) {
                                                        $query2->where('title','like',"%{$keyword}%");
                                                    })
                                                 ->where(function($q){
														   $q/* ->orWhereHas('raport', function($query5)	{
																		$query5->where('nik','=',Auth::user()->nik);
																	   }) */
														   ->orWhereHas('participants', function($query6)	{
																$query6->where('nik','=',Auth::user()->nik)
																	   ->where('is_active','=',1);
															})
															->orWhere('created_by','=',Auth::user()->id);
													   });
                                       })
                                       ->when($category, function ($query4) use ($category,$keyword) {
                                            if ($category == "now") {
                                                $query4->where('date_start','<=', date("Y-m-d H:i:s"))
													   ->where('date_end','>=', date("Y-m-d H:i:s"))
													   ->where(function($q){
														   $q/* ->orWhereHas('raport', function($query5)	{
																		$query5->where('nik','=',Auth::user()->nik);
																	   }) */
														   ->orWhereHas('participants', function($query6)	{
																$query6->where('nik','=',Auth::user()->nik)
																	   ->where('is_active','=',1);
															})
															->orWhere('created_by','=',Auth::user()->id);
													   });
                                            } else if ($category == "upcomming") {
                                                $query4->where('date_start','>', date("Y-m-d H:i:s"))
													   ->where(function($q){
														   $q/* ->orWhereHas('raport', function($query5)	{
																		$query5->where('nik','=',Auth::user()->nik);
																	   }) */
														   ->orWhereHas('participants', function($query6)	{
																$query6->where('nik','=',Auth::user()->nik)
																	   ->where('is_active','=',1);
															})
															->orWhere('created_by','=',Auth::user()->id);
													   });
                                            } else if ($category == "done") {
                                                $query4->where('date_end','<', date("Y-m-d H:i:s"))
													   ->where(function($q){
														   $q/* ->orWhereHas('raport', function($query5)	{
																		$query5->where('nik','=',Auth::user()->nik);
																	   }) */
														   ->orWhereHas('participants', function($query6)	{
																$query6->where('nik','=',Auth::user()->nik)
																	   ->where('is_active','=',1);
															})
															->orWhere('created_by','=',Auth::user()->id);
													   });
                                            } else if ($category == "all" || $category == "") {
												$query4->where(function($q){
														   $q/* ->orWhereHas('raport', function($query5)	{
																		$query5->where('nik','=',Auth::user()->nik);
																	   }) */
														   ->orWhereHas('participants', function($query6)	{
																$query6->where('nik','=',Auth::user()->nik)
																	   ->where('is_active','=',1);
															})
															->orWhere('created_by','=',Auth::user()->id);
													   });
											}
                                        })
                                       ->where('is_active','=',1)
                                       ->orderBy('created_at', 'DESC')->paginate(10);
            $schedules->appends($request->only('keyword'));
        }                
        return view('elearning/schedule/index',compact('uac_admin','uac_create','uac_delete','uac_update','schedules','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::get();
        $positions = Position::get();
        $users = User ::GetAllUsers();

        $collections = QuestionCollection::where('is_active','=',1)
                                        // ->where('created_by','=',Auth::user()->id)
                                        ->orderBy('id', 'DESC')->get();                                
        
        return view('elearning/schedule/create',compact('divisions','positions','users','collections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $input = $request->all();
        $input_date_start = date('Y-m-d', strtotime($input['date_start'])).' '.$input['time_start'];
        $input_date_end = date("Y-m-d", strtotime($input['date_end'])).' '.$input['time_end'];
        $schedule = new ExamSchedule([
            'collection_id' => $input['collection_id'],
            'program' => $input['program'],
            'description' => $input['description'],
            'date_start' => $input_date_start,
            'date_end' => $input_date_end,
            'created_by' => Auth::id(),
        ]);
        $inserted = $schedule->save();    

        if ($inserted) {
            $list_participants = array();
            foreach ($input['exam_participants'] as $r) {
                if (substr($r,0,2) == 'd-') {
                    $users = User::where('division_id','=',explode('d-',$r)[1])
                                   ->where('is_active','=',1)->get();
                                   
                    foreach ($users as $x) {
                        $list_participants[] = $x;
                    }
                } else if (substr($r,0,2) == 'p-') {
                    $users = User::where('position_id','=',explode('p-',$r)[1])
                                   ->where('is_active','=',1)->get();
                                   
                    foreach ($users as $y) {
                        $list_participants[] = $y;
                    }
                } else if ($r == "all") {
                    $users = User::whereNotIn('id', [1, 2, 101, 102, 103, 130])
									->where('is_active','=',1)
                                    ->get();
                                    
                    foreach ($users as $z) {
                        $list_participants[] = $z;
                    }
                } else if ($r == "spv") {
                    $users = User::role('User Supervisor')
                                    ->where('is_active','=',1)
                                    ->get();

                    foreach ($users as $z) {
                        $list_participants[] = $z;
                    }
                } else if ($r == "manager") {
                    $users = User::role('User Manager')
                                    ->where('is_active','=',1)
                                    ->get();
                    
                    foreach ($users as $z) {
                        $list_participants[] = $z;
                    }
                } else if ($r == "staff") {
                    $users = User::role('User Staff')
                                    ->where('is_active','=',1)
                                    ->get();
                    
                    foreach ($users as $z) {
                        $list_participants[] = $z;
                    }
                } else {
                    $list_participants[] = User::where('id','=',$r)
												->whereNotIn('id', [1, 101, 102, 103, 2, 130])
												->where('is_active','=',1)
												->where('id','!=',1)->first();
                }
            }

            $filter_participants = array_unique($list_participants, SORT_REGULAR);

            foreach ($filter_participants as $r) 
            {
				if (Auth::user()->nik != $r['nik']) {
					$participant = new ExamParticipant([
						'schedule_id' => $schedule->id,
						'nik' => $r['nik'],
						'created_by' => Auth::id(),
					]);
					$participant->save();

					$raport = new Raport([
						'nik' => $r['nik'],
						'collection_id' => $input['collection_id'],
						'schedule_id' => $schedule->id,
						'hours' => 0,
						'score' => 0,
						'status' => '0',
					]);
					$raport->save();
				}
            }

            return redirect()->route('schedule.index')
                    ->with('success', 'Berhasil membuat jadwal ujian baru.');
        } else {
            return redirect()->route('schedule.index')
                    ->with('danger', 'Gagal membuat jadwal ujian baru.');
        }
        //  var_dump($input['exam_participants']);
        
    }

    public function add_participant(Request $request, $id)
    {
        $input = $request->all();

        $list_participants = array();
        foreach ($input['exam_participants'] as $r) {
            if (substr($r,0,2) == 'd-') {
                $users = User::where('division_id','=',explode('d-',$r)[1])
								->where('is_active','=',1)
								->get();
                foreach ($users as $x) {
                    $list_participants[] = $x;
                }
            } else if (substr($r,0,2) == 'p-') {
                $users = User::where('position_id','=',explode('p-',$r)[1])
								->where('is_active','=',1)
								->get();
                foreach ($users as $y) {
                    $list_participants[] = $y;
                }
            } else if ($r == "all") {
                $users = User::whereNotIn('id',[1,2,101,102,103])
								->where('is_active','=',1)
								->get();
                foreach ($users as $z) {
                    $list_participants[] = $z;
                }
            }  else if ($r == "manager") {
                $users = User::role('User Manager')
                                ->where('is_active','=',1)
                                ->get();
                
                foreach ($users as $z) {
                    $list_participants[] = $z;
                }
            } else if ($r == "spv") {
                $users = User::role('User Supervisor')
                                ->where('is_active','=',1)
                                ->get();

                foreach ($users as $z) {
                    $list_participants[] = $z;
                }
            } else if ($r == "staff") {
                $users = User::role('User Staff')
                                ->where('is_active','=',1)
                                ->get();
                
                foreach ($users as $z) {
                    $list_participants[] = $z;
                }
            } else {
                $list_participants[] = User::where('id','=',$r)
                                            ->where('is_active','=',1)
											->whereNotIn('id',[1,2,101,102,103, 130])->first();
            }
        }

        $filter_participants = array_unique($list_participants, SORT_REGULAR);
        $exist_participants = ExamParticipant::where('schedule_id','=',$id)->get()->pluck('nik')->toArray();
        $schedule = ExamSchedule::findOrFail($id);

        foreach ($filter_participants as $r) 
        {
            if (!in_array($r['nik'], $exist_participants)) {
                $participant = new ExamParticipant([
                    'schedule_id' => $id,
                    'nik' => $r['nik'],
                    'created_by' => Auth::id(),
                ]);
                $participant->save();

                $raport = new Raport([
                    'nik' => $r['nik'],
                    'collection_id' => $schedule->collection_id,
                    'schedule_id' => $id,
                    'hours' => 0,
                    'score' => 0,
                    'status' => '0',
                ]);
                $raport->save();
            } else {
				$participant = ExamParticipant::where('nik','=',$r['nik'])->first();
				if ($participant) {
					$participant->is_active = 1;
					$participant->save();
				}
			}
        }

        return redirect()->route('schedule.show',$id)
                    ->with('success', 'Berhasil menambah peserta ujian.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $category = "all")
    {                
        $schedule = ExamSchedule::with('collection','collection.material')
                                ->where('id','=',$id)
                                ->first();        

        $questions_count = QuestionContent::with('user_answers')
                                    ->where('collection_id','=',$schedule->collection_id)
                                    ->where('is_active','=',1)
                                    ->get();
		
		$participants = null;
		
		//Semua Peserta
        $participants_all = ExamParticipant::with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
										->where('schedule_id','=',$schedule->id)
                                        ->where('is_active','=',1)
                                        ->get();              
		
		//Peserta yang lulus
		$participants_passed = ExamParticipant::with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
										->whereHas('raport', function($query) use ($schedule) {
											$query->whereNotNull('start_at')
												  ->where('status','=','1')
												  ->where('score','>=',$schedule->collection['minimum_score'])
												  ->where('schedule_id','=',$schedule->id);
										})
                                        ->where('schedule_id','=',$id)
                                        ->where('is_active','=',1)
                                        ->get();
										
		//Peserta yang tidak lulus
		$participants_not_passed = ExamParticipant::with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
										->whereHas('raport', function($query) use ($schedule,$id) {
											$query->whereNotNull('start_at')
												  ->where('status','=','1')
												  ->where('score','<',$schedule->collection['minimum_score'])
												  ->where('schedule_id','=',$schedule->id);
										})
                                        ->where('schedule_id','=',$id)
                                        ->where('is_active','=',1)
                                        ->get();
		
		//Peserta belum menyelesaikan ujian
		$participants_not_complete = ExamParticipant::with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
										->whereHas('raport', function($query) use ($schedule,$id) {
											$query->whereNotNull('start_at')
												  ->where('status','=', '0')
												  ->where('schedule_id','=',$schedule->id);
										})
                                        ->where('schedule_id','=',$id)
                                        ->where('is_active','=',1)
                                        ->get();
										
		//Peserta belum mengerjakan ujian
		$participants_not_exam = ExamParticipant::with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
										->whereHas('raport', function($query) use ($schedule,$id) {
											$query->whereNull('start_at')
												  ->where('status','=', '0')
												  ->where('schedule_id','=',$schedule->id);
										})
                                        ->where('schedule_id','=',$id)
                                        ->where('is_active','=',1)
                                        ->get();
		
        $divisions = Division::get();
        $positions = Position::get();
        $users = User::GetAllUsers();

        $uac_admin = auth()->user()->hasAnyPermission(Permission::whereIn('id',array(1,24))
                                    ->get()->pluck('name')->toArray());
        
        $participant_access = null;
        $exam_page_position = null;
        
        $participant_access = ExamParticipant::where('schedule_id','=',$id)
                                    ->where('nik','=', Auth::user()->nik)
                                    ->where('is_active','=',1)
                                    ->first();
                
        $exam_page_position = ExamPagePosition::where('nik','=', Auth::user()->nik)
                                ->where('schedule_id','=', $id)
                                ->first();
       
        if (!$uac_admin) {		
            if (empty($participant_access) && $schedule->created_by != Auth::user()->id) {
                return redirect()->route('schedule.index')
                    ->with('danger', 'Anda tidak terdaftar sebagai peserta ujian.');
            } 
        }
		
		if ($category == "all") {
			$participants = $participants_all;
		} else if ($category == "passed") {
			$participants = $participants_passed;
		} else if ($category == "not_passed") {
			$participants = $participants_not_passed;
		} else if ($category == "not_complete") {
			$participants = $participants_not_complete;
		} else if ($category == "not_exam") {
			$participants = $participants_not_exam;
        }

        return view('elearning/schedule/detail',compact('questions_count','schedule','participants',
                                                        'participant_access','divisions','positions',
                                                        'users','exam_page_position','participants_all',
                                                        'participants_passed','participants_not_passed',
                                                        'participants_not_complete','participants_not_exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {                
        $divisions = Division::get();
        $positions = Position::get();
        $users = User::GetAllUsers();
                
        $schedule = ExamSchedule::find($id);
        $collections = QuestionCollection::where('is_active','=',1)
                                        //->where('created_by','=',Auth::user()->id)
                                        ->orderBy('id', 'DESC')->get();
										
        return view('elearning.schedule.edit', compact('schedule', 'collections','divisions','positions','users'));
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
        $datetime_start = Date('Y-m-d H:i:00', strtotime($request->date_start." ". $request->time_start));
        $datetime_end = Date('Y-m-d H:i:00', strtotime($request->date_end." ". $request->time_end));

        $update_schedule = ExamSchedule::find($id)->update([
            "collection_id"=>$request->collection_id,
            "program"=>$request->program,
            "description"=>$request->description,
            "date_start"=>$datetime_start,
            "date_end"=>$datetime_end
        ]);
        if($update_schedule){
            return redirect()->route('schedule.index')
                    ->with('success', 'Berhasil mengubah jadwal ujian.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove_participant($id)
    {
        $participant = ExamParticipant::findOrFail($id);
        $schedule_id = $participant->schedule_id;
        $nik = $participant->nik;

        $deleted = $participant->fill([
                        'updated_by' => Auth::id(),
                        'is_active' => 0,
                    ])->save();

        if ($deleted) {
            $raport = Raport::where('nik','=',$nik)->where('schedule_id','=',$schedule_id)->first();
            $deleted = $raport->fill([
                            'updated_by' => Auth::id(),
                            'is_active' => 0,
                        ])->save();

            return redirect()->route('schedule.show',$participant->schedule_id)
                ->with('success', 'Peserta berhasil dihapus.');
        } else {
            return redirect()->route('schedule.show',$participant->schedule_id)
                ->with('danger', 'Gagal menghapus Peserta.');
        }
    }

    public function destroy($id)
    {
        $schedule = ExamSchedule::findOrFail($id);
        $deleted = $schedule->fill([
                        'updated_by' => Auth::id(),
                        'is_active' => 0,
                    ])->save();

        if ($deleted) {
            return redirect()->route('schedule.index')
                ->with('success', 'Jadwal berhasil dihapus.');
        } else {
            return redirect()->route('schedule.index')
                ->with('danger', 'Gagal menghapus jadwal.');
        }
    }
	
	public function export_schedule($id)
	{
		$schedule = ExamSchedule::findOrFail($id);
		$question = QuestionCollection::findOrFail($schedule->collection_id);
		
		/*$schedule = ExamSchedule::with('collection','collection.material')
									->where('id','=',$id)
									->first();								
									
		$participants = ExamParticipant::select('nik')
										->with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
                                        ->where('schedule_id','=',$id)
                                        ->where('is_active','=',1)
                                        ->get();
		foreach($participants as $r) {
			$r->name = $r->user['name'];
			$r->division = $r->user->division['name'];			
			$r->position = $r->user->position['name'];
			$r->score = $r->raport['score'];			
		}*/		
		
		return Excel::download(new ScheduleExport($id), str_replace(' ','_',$question->title).'.xlsx');
	}

    public function schedule_list()
    {
        
    }

    //new dwiki function
    public function user_answers($id_schedule, $nik, Request $request){        
        if($request->ajax()){                    
            $result = array();
            $right_answer = "";
            $user_answer = "";            
            $schedule = ExamSchedule::where('id', $id_schedule)->get()->first();

            $questions_answer = QuestionContent::with([ 'question_answers', 
                                                        'user_answers'=> function($query) use ($nik){
                                                            $query->where('nik', $nik);                                                        
                                                        }])                                                
                                                ->where('collection_id', $schedule->collection_id)                                            
                                                ->get();            
            foreach($questions_answer as $data){
                for($i=0; $i<count($data->question_answers); $i++){                    
                    if($data->question_answers[$i]->answer_key == '1'){
                        $right_answer = array($data->question_answers[$i]->answer);
                    }
                    if($data->question_answers[$i]->id == $data->user_answers['answer_id']){
                        $user_answer = $data->question_answers[$i]->answer;                        
                    }                    
                }
                
                $right_answer[0] == $user_answer ? $status=true : $status=false;           
                $arr_data = array(
                        'questions' => $data->question,
                        'right_answer' => $right_answer[0],
                        'user_answer' => $user_answer,
                        'status' => $status
                    );
                array_push($result, $arr_data);
            }
            return response()->json($result);
        }               
         
    }
}
