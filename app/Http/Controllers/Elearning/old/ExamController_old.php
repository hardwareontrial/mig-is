<?php

namespace App\Http\Controllers\Elearning;

use App\Model\Elearning\ExamSchedule;
use App\Model\Elearning\ExamParticipant;
use App\Model\Elearning\ExamPattern;
use App\Model\Elearning\ExamPagePosition;
use App\Model\Elearning\ExamUserAnswer;
use App\Model\Elearning\Material;
use App\Model\Elearning\QuestionCollection;
use App\Model\Elearning\QuestionContent;
use App\Model\Elearning\QuestionAnswer;
use App\Model\Elearning\Raport;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public static $instance = null;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = ExamSchedule::with('collection')->where('id','=',$id)->first();

        $questions = QuestionContent::with('answers')
                                    ->where('collection_id','=',$schedule->collection_id)
                                    ->where('is_active','=',1)
                                    ->inRandomOrder()
                                    ->get();

        $check_raport = Raport::where('nik','=',Auth::user()->nik)
                                ->where('schedule_id','=',$id)
                                ->where('status','=',1)
                                ->first();

        $date_time_start = $schedule->date_start;
        $duration = $schedule->duration;
        $current_date_time = date("Y-m-d H:i:s");

        $ts_date_start = strtotime($date_time_start);
        $ts_date_end = $ts_date_start + ($duration * 60);
        $date_time_end = date("Y-m-d H:i:s", $ts_date_end);

        if ($current_date_time <= $date_time_start) {
            return redirect()->route('schedule.show',$id)
            ->with('warning', 'Ujian belum dimulai.');
        }
        
        if ($current_date_time > $date_time_end) {
            return redirect()->route('schedule.show',$id)
            ->with('danger', 'Ujian sudah selesai.');
        }

        if (!empty($check_raport)) {
			return redirect()->route('schedule.show',$id)
            ->with('danger', 'Anda sudah menyelesaikan ujian.');
		}
      
        return view('elearning/exam/start',compact('questions','schedule','date_time_end'));
    }

    public function start(Request $request, $schedule_id, $lastpage = null)
    {
        $schedule = ExamSchedule::with('collection')->where('id','=',$schedule_id)->first();

        $exam_pattern = ExamPattern::where('nik','=', Auth::user()->nik)
                                    ->where('schedule_id', '=', $schedule_id)
                                    ->first();
        
        $participant_access = ExamParticipant::where('schedule_id','=',$schedule_id)
                                    ->where('nik','=', Auth::user()->nik)
                                    ->first();
        
        //check jika tidak terdaftar sebagai peserta ujian
        if (empty($participant_access)) {
            return redirect()->route('schedule.index')
                ->with('danger', 'Anda tidak terdaftar sebagai peserta ujian.');
        }

        if (!$exam_pattern) {
            $random_question = QuestionContent::where('collection_id','=',$schedule->collection_id)
                                                ->where('is_active','=',1)
                                                ->inRandomOrder()
                                                ->pluck('id')
                                                ->toArray();
            
            $pattern = new ExamPattern([
                'nik' => Auth::user()->nik,
                'schedule_id' => $schedule_id,
                'pattern' => implode(',',$random_question),
            ]);
            $pattern->save();

            $exam_pattern = ExamPattern::where('nik','=', Auth::user()->nik)
                                    ->where('schedule_id', '=', $schedule_id)
                                    ->first();
        } 
       
        $exam_page_position = ExamPagePosition::where('nik','=', Auth::user()->nik)
                                    ->where('schedule_id','=', $schedule_id)
                                    ->first();
        
        if ($exam_page_position) {
            
        } else {
            $exam_page_position = new ExamPagePosition([
                'nik' => Auth::user()->nik,
                'schedule_id' => $schedule_id,
                'page' => 1
            ]);
            $exam_page_position->save();
        }

        $questions_count = QuestionContent::with('answers')
                                    ->where('collection_id','=',$schedule->collection_id)
                                    ->where('is_active','=',1)
                                    ->get();

        $questions = QuestionContent::with('answers')
                                    ->where('collection_id','=',$schedule->collection_id)
                                    ->where('is_active','=',1)
                                    ->orderByRaw(DB::raw("FIELD(id, $exam_pattern->pattern) ASC"))
                                    ->paginate(1, ['*'], 'page', $lastpage);

        if ($exam_page_position) {
            $exam_page_position->fill([
                'page' => $questions->currentPage()
            ])->save();
        }
        
        $user_answer = ExamUserAnswer::where('nik','=', Auth::user()->nik)
                                        ->where('schedule_id', '=', $schedule_id)
                                        ->where('question_id','=', $questions[0]->id)
                                        ->first();

        $user_page = ExamUserAnswer::where('nik','=', Auth::user()->nik)
                                        ->where('schedule_id', '=', $schedule_id)
                                        ->get();

        $check_raport = Raport::where('nik','=',Auth::user()->nik)
                                ->where('schedule_id','=',$schedule_id)
                                ->first();
        
        $date_time_end = $schedule->date_end;
        $current_date_time = date("Y-m-d H:i:s");

        //check jadwal belum dimulai
        if ($current_date_time < $schedule->date_start) {
            return redirect()->route('schedule.show',$schedule_id)
            ->with('warning', 'Jadwal ujian belum dimulai.');
        }
        
        if (empty($check_raport->start_at) && $current_date_time > $schedule->date_start 
            && $current_date_time < $schedule->date_end) {
            $check_raport->fill([
                'start_at' => date("Y-m-d H:i:s")
            ])->save();
        }


        $ts_timer_start = strtotime($check_raport->start_at);
        $ts_timer_end = $ts_timer_start + ($schedule->collection['duration'] * 60); 
        $timer_end = date("Y-m-d H:i:s", $ts_timer_end);

        if (($current_date_time > $date_time_end && empty($check_raport->start_at)) 
            || ($current_date_time > $date_time_end && !empty($timer_end) && $current_date_time > $timer_end)) {
            
            if (empty($check_raport->finish_at) && !empty($check_raport->start_at)) {
                $this->result($schedule_id);
            }
            return redirect()->route('schedule.show',$schedule_id)
            ->with('danger', 'Jadwal ujian telah selesai.');
        }

        //check sudah mengerjakan ujian
        if (!empty($check_raport->finish_at)) {
			return redirect()->route('schedule.show',$schedule_id)
            ->with('danger', 'Anda sudah menyelesaikan ujian.');
        }

        //check timer ujian sudah habis
        if ($current_date_time > $timer_end) {
            if (empty($check_raport->finish_at)) {
                $this->result($schedule_id);
            }
            return redirect()->route('schedule.show',$schedule_id)
            ->with('danger', 'Timer ujian sudah habis.');
        }
        
        return view('elearning/exam/wizard',compact('questions','user_answer','schedule','date_time_end','exam_pattern','timer_end', 'user_page', 'questions_count'));
    }

    public function score(Request $request, $id)
    {
        $schedule = ExamSchedule::with('collection')->where('id','=',$id)->first();
        $exam = QuestionCollection::findOrFail($schedule->collection_id);
        $questions = QuestionContent::with('answers')
                                    ->where('collection_id','=',$exam->id)
                                    ->where('is_active','=',1)
                                    ->get();

        $true_answer = 0;
		foreach ($questions as $r){
			if ($request->post($r->id)) {
				$answer = $request->post($r->id);
                $value = DB::table('okm_question')
                                    ->leftJoin('okm_question_answer', 'okm_question_answer.question_content_id', '=', 'okm_question.id')
                                    ->where('okm_question_answer.id','=',$answer)
                                    ->first();
                $true_answer += $value->answer_key;
			}
        }
        
        $question_score = 100 / $questions->count();
		$exam_score = number_format($true_answer * $question_score,2);
        $status = $exam_score >= $exam->minimum_score ? 'Selamat anda lulus' : 'Maaf anda tidak lulus';

        $raport = Raport::where('nik', '=', Auth::user()->nik)
                        ->where('collection_id', '=', $exam->id)
                        ->where('schedule_id', '=', $id)
                        ->first();
        
        $updated = $raport->fill([
                            'hours' => $exam_score >= $exam->minimum_score ? $exam->hours : 0,
                            'score' => $exam_score,
                            'status' => '1',
                            'finish_at' => date("Y-m-d H:i:s"),
                        ])->save();

        return view('elearning/exam/score',compact('status'));
    }

    public function result($schedule_id)
    {
        $schedule = ExamSchedule::with('collection')->where('id','=',$schedule_id)->first();

        $user_answer = ExamUserAnswer::where('nik','=', Auth::user()->nik)
                                        ->where('schedule_id', '=', $schedule_id)
                                        ->get();
        
        $questions = QuestionContent::with('answers')
                                    ->where('collection_id','=',$schedule['collection_id'])
                                    ->where('is_active','=',1)
                                    ->get();
        
        $true_answer = 0;
        foreach ($user_answer as $r) {
            $question_answer = QuestionAnswer::findOrFail($r->answer_id);
            if ($question_answer) {
                $true_answer += $question_answer->answer_key;
            }
        }

        $question_score = 100 / $questions->count();
        $exam_score = number_format($true_answer * $question_score,2);
        $status = $exam_score >= $schedule->collection['minimum_score'] ? 'Selamat anda lulus' : 'Maaf anda tidak lulus';
		$status_bool = $exam_score >= $schedule->collection['minimum_score'] ? true : false;

        $raport = Raport::where('nik', '=', Auth::user()->nik)
                        ->where('collection_id', '=', $schedule->collection_id)
                        ->where('schedule_id', '=', $schedule_id)
                        ->first();

        $material = Material::findOrFail($schedule->collection['material_id']);
        
        $updated = $raport->fill([
                            'hours' => $exam_score >= $schedule->collection['minimum_score'] ? $material->hours : 0,
                            'score' => $exam_score,
                            'status' => '1',
                            'finish_at' => date("Y-m-d H:i:s"),
                        ])->save();

        return view('elearning/exam/score',compact('status','status_bool','exam_score','raport'));
    }

    public function store_answer($schedule_id, $question_id, $answer_id, $page_number)
    {
        $check = ExamUserAnswer::where('nik','=', Auth::user()->nik)
                                ->where('schedule_id', '=', $schedule_id)
                                ->where('question_id', '=', $question_id)
                                ->first();
        
        if ($check) {
            if ($answer_id != $check->answer_id) {
                $check->fill(['answer_id'=>$answer_id])->save();
            } 
        } else {
            $exam_answer = new ExamUserAnswer([
                "nik" => Auth::user()->nik,
                "schedule_id" => $schedule_id,
                "page" => $page_number,
                "question_id" => $question_id,
                "answer_id" => $answer_id
            ]);
            $exam_answer->save();
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
        //
    }
}
