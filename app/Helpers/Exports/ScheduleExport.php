<?php

namespace App\Exports;

use App\Model\Elearning\ExamParticipant;
use App\Model\Elearning\ExamSchedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduleExport implements FromCollection, WithHeadings
{
	protected $schedule_id;
	
    public function __construct($id)
    {
        $this->schedule_id = $id; 
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {		
		$schedule = ExamSchedule::with('collection','collection.material')
									->where('id','=',$this->schedule_id)
									->first();								
									
		$participants = ExamParticipant::select('nik')
										->with(['user','user.position','user.division',
											'raport' => function($query) use ($schedule) {
												$query->where('schedule_id','=',$schedule->id);
											}
										])
                                        ->where('schedule_id','=',$this->schedule_id)
                                        ->where('is_active','=',1)
                                        ->get();		
		foreach($participants as $r) {
			$r->name = $r->user['name'];
			$r->division = $r->user->division['name'];			
			$r->position = $r->user->position['name'];
			$r->score = $r->raport['score'];
			
			if (!empty($r->raport['start_at']) && $r->raport['status'] == 1 
				&& $r->raport['score'] >= $schedule->collection['minimum_score']) {
				$r->status = "Lulus";
			} else if (!empty($r->raport['start_at']) && $r->raport['status'] == 1
				&& $r->raport['score'] < $schedule->collection['minimum_score']) {
				$r->status = "Tidak Lulus";
			} else if (empty($r->raport['start_at']) && $r->raport['start_at'] == null && $r->raport['status'] == 0) {
				$r->status = "Belum Dikerjakan";
			} else if (!empty($r->raport['start_at']) && $r->raport['start_at'] == null && $r->raport['status'] == 0) {
				$r->status = "Belum Diselesaikan";
			}
		}
		
        return $participants;
    }
	
	public function headings(): array
    {
        return [
            'NIK',
            'NAMA',
			'DEPARTEMEN',
			'POSISI',
			'NILAI',
			'KETERANGAN',
        ];
    }
}
