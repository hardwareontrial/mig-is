<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use App\Imports\QuestionImport;
use App\Model\Division;
use App\Model\Elearning\QuestionCollection;
use App\Model\Elearning\QuestionContent;
use App\Model\Elearning\QuestionAnswer;
use App\Model\Elearning\Material;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:admin all|admin okm|read question okm'])->only(['index']);
        $this->middleware(['permission:admin all|admin okm|create question okm'])->only(['show']);
        $this->middleware(['permission:admin all|admin okm|create question okm'])->only(['create']);
        $this->middleware(['permission:admin all|admin okm|update question okm'])->only(['edit']);
        $this->middleware(['permission:admin all|admin okm|update question okm'])->only(['edit_content']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $collections = QuestionCollection::with('material.division')
                        ->when($keyword, function ($query) use ($keyword) {
                                $query->where(function($q) use ($keyword) {
										$q->orWhere('title','like',"%{$keyword}%")
										  ->orWhereHas('material.division', function ($query2) use ($keyword){
												$query2->where('name','like',"%{$keyword}%")
													   ->orWhere('level','like',"%{$keyword}%");
											});
										});
						})
                        ->withCount('questions')
                        ->where('is_active','=',1)
						->where('created_by','=',Auth::user()->id)
                        ->orderBy('created_at','DESC')->paginate(10);
        $collections->appends($request->only('keyword'));

        return view('elearning/question/index',compact('collections','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials = Material::where('is_active','=',1)->get();
        return view('elearning/question/create', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['material_id','title','duration','minimum_score']);
        $input['created_by'] = Auth::id();
        $inserted = QuestionCollection::create($input);

        if ($inserted) {
            return redirect()->route('question.index',['keyword'=>$input['title']])
            ->with('success', 'Data ujian baru berhasil ditambahkan.');
        } else {
            return redirect()->route('question.index')
                ->with('danger', 'Gagal menyimpan data ujian baru.');
        }
    }

    public function store_content(Request $request)
    {
        $input = $request->only(['collection_id','question','answer','answer_key','a','b','c','d']);
        $content_params = array(
                            'collection_id' => $input['collection_id'],
                            'question' => $input['question'],
                            'created_by' => Auth::id()
                        );
        $inserted = QuestionContent::create($content_params);

        if ($inserted) 
        {
            $opt_answers = array(
                'a' => $input['a'],
                'b' => $input['b'],
                'c' => $input['c'],
                'd' => $input['d']
            );
            foreach ($opt_answers as $key => $r) {
                $answer_params = array(
                    'question_content_id' => $inserted->id,
                    'answer' => $r,
                    'created_by' => Auth::id()
                );
                if ($input['answer_key'] == $key) {
                    $answer_params['answer_key'] = '1';
                } else {
                    $answer_params['answer_key'] = '0';
                }
                QuestionAnswer::create($answer_params);
            }

            return redirect()->route('question.show',$input['collection_id'])
                ->with('success', 'Data pertanyaan baru berhasil disimpan.');
        } else {
            return redirect()->route('question.show',$input['collection_id'])
                ->with('danger', 'Gagal menyimpan pertanyaan baru.');
        }
    }
	
	public function import_content(Request $request, $id)
	{
		$imported = Excel::import(new QuestionImport($id), $request['import_file']);
		if ($imported) {
			return redirect()->route('question.show',$id)
                ->with('success', 'Data pertanyaan baru berhasil di import.');
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
        $collection = QuestionCollection::with('material.division')
                        ->withCount('questions')
                        ->where('is_active','=',1)
                        ->where('id','=',$id)
                        ->first();
        $contents = QuestionContent::with('answers')
                                    ->where('collection_id','=',$id)
                                    ->where('is_active','=',1)
                                    ->get();

        if ($collection) {
            return view('elearning/question/detail',compact('collection','contents'));
        } else {
            return redirect()->route('question.index')
            ->with('warning', 'Data soal tidak ditemukan.');
        }
    }

    public function show_content($id)
    {
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = QuestionCollection::where('id','=',$id)->where('is_active','=',1)->first();
        $materials = Material::where('is_active','=',1)->get();
        return view('elearning/question/edit', compact('materials','question'));
    }

    public function edit_content($id)
    {
        $questionc = QuestionContent::findOrFail($id);
        $question = QuestionCollection::where('id','=',$questionc->collection_id)->where('is_active','=',1)->first();
        $answers = QuestionAnswer::where('question_content_id','=',$id)->get();
        $answer_key = QuestionAnswer::where('question_content_id','=',$id)
                                     ->where('answer_key','=',1)
                                     ->first();
        return view('elearning/question/content/edit', compact('question','questionc','answers','answer_key'));
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
        $question = QuestionCollection::findOrFail($id);
        $input = $request->only(['title','material_id','minimum_score','duration']);
        $input['updated_by'] = Auth::id();
        $updated = $question->fill($input)->save();

        if ($updated) {
            return redirect()->route('question.index',['keyword'=>$question->title])
                ->with('success', 'Master soal berhasil diperbarui');
        } else {
            return redirect()->route('question.index')
                ->with('danger', 'Gagal memperbarui master soal.');
        }
    }

    public function update_content(Request $request, $id)
    {
        $questionc = QuestionContent::findOrFail($id);
        $input = $request->only(['collection_id','question']);
        $input['updated_by'] = Auth::id();
        $updated = $questionc->fill($input)->save();

        if ($updated) {
            $input_opt_id = $request->only(['id_1','id_2','id_3','id_4']);
            $input_opt_val = $request->only(['opt_1','opt_2','opt_3','opt_4']);
            $input_answer_key = $request->input('answer_key');
            $input_count = 1;
            foreach ($input_opt_id as $r) {
                $answer = QuestionAnswer::findOrFail($r);
                if ($r == $input_answer_key) {
                    $answer->fill([
                        'answer' => $input_opt_val['opt_'.$input_count],
                        'answer_key' => '1',
                        'updated_by' => Auth::id()
                        ])->save();
                } else {
                    $answer->fill([
                        'answer' => $input_opt_val['opt_'.$input_count],
                        'answer_key' => '0',
                        'updated_by' => Auth::id()
                        ])->save();
                }
                $input_count++;
            }
            return redirect()->route('question.show',$input['collection_id'])
                ->with('success', 'Berhasil memperbarui pertanyaan.');
        } else {
            return redirect()->route('question.show',$input['collection_id'])
                ->with('danger', 'Gagal memperbarui pertanyaan.');
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
        $question = QuestionCollection::findOrFail($id);
        $deleted = $question->fill([
                        'updated_by' => Auth::id(),
                        'is_active' => 0,
                    ])->save();

        if ($deleted) {
            return redirect()->route('question.index')
                ->with('success', 'Data soal berhasil dihapus.');
        } else {
            return redirect()->route('question.index')
                ->with('danger', 'Gagal menghapus data soal.');
        }
    }

    public function destroy_content($id)
    {
        $content = QuestionContent::findOrFail($id);
        $deleted = $content->fill([
                        'updated_by' => Auth::id(),
                        'is_active' => 0,
                    ])->save();

        if ($deleted) {
            return redirect()->route('question.show',$content->collection_id)
                ->with('success', 'Pertanyaan berhasil dihapus.');
        } else {
            return redirect()->route('question.show',$content->collection_id)
                ->with('danger', 'Gagal menghapus pertanyaan.');
        }
    }

    public function exam_list()
    {
        $data = QuestionCollection::with('material.division')
                        ->get(); 
        return response()->json(['success' => true, 'message' => 'Data berhasil di tampilkan', 'data'=> $data]);
    }
}
