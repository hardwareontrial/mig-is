<?php

namespace App\Imports;

use App\Model\Elearning\QuestionContent;
use App\Model\Elearning\QuestionAnswer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuestionImport implements ToCollection, WithMultipleSheets, WithStartRow
{
	protected $collection_id;
	
    public function __construct($id)
    {
        $this->collection_id = $id; 
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $r){
			$question = QuestionContent::create([
				'collection_id' => $this->collection_id,
				'question' => $r[0],
				'created_by' => Auth::user()->id,
				'is_active' => 1,
			]);
			
			//pilihan 1
			$answer1 = QuestionAnswer::create([
				'question_content_id' => $question->id,
				'answer' => $r[1],
				'answer_key' => $r[5] == "1" ? "1" : "0",
			]);
			
			//pilihan 2
			$answer2 = QuestionAnswer::create([
				'question_content_id' => $question->id,
				'answer' => $r[2],
				'answer_key' => $r[5] == "2" ? "1" : "0",
			]);
			
			//pilihan 3
			$answer3 = QuestionAnswer::create([
				'question_content_id' => $question->id,
				'answer' => $r[3],
				'answer_key' => $r[5] == "3" ? "1" : "0",
			]);
			
			//pilihan 4
			$answer4 = QuestionAnswer::create([
				'question_content_id' => $question->id,
				'answer' => $r[4],
				'answer_key' => $r[5] == "4" ? "1" : "0",
			]);
		}
    }
	
	public function startRow(): int
    {
        return 11;
    }
	
	public function sheets(): array
    {
        return [
            'SOAL' => $this,
        ];
    }
}
