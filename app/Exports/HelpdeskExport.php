<?php

namespace App\Exports;

use App\Model\Helpdesk\Helpdesk;
use App\Model\Helpdesk\HelpdeskAssign;
use App\Model\Helpdesk\HelpdeskActivity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HelpdeskExport implements FromCollection, WithHeadings
{
    protected $user_id;
    protected $division_id;
	
    public function __construct($user_id, $division_id)
    {
        $this->user_id = $user_id; 
        $this->division_id = $division_id; 
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user_id = $this->user_id; 
        $division_id = $this->division_id;

        $helpdesks = Helpdesk::select('id','title','date_start','date_end','type','privilege','status')
                                    ->with('assign.user','assign.division')
                                    ->where(function ($x) use ($user_id, $division_id) 
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
                                            })
                                    ->get();
        
        $export_d = [];
        $tmp_assign = null;
        foreach ($helpdesks as $r) {
            $tmp_assign = null;
            foreach ($r->assign as $s) {
                if ($s->division != null) {
                    if ($tmp_assign == null){
                        $tmp_assign .= $s->division['name'];
                    } else {
                        $tmp_assign .= ", ".$s->division['name'];
                    }
                }
                else if ($s->user != null) {
                    if ($tmp_assign == null){
                        $tmp_assign .= $s->user['name'];
                    } else {
                        $tmp_assign .= ", ".$s->user['name'];
                    }
                }
                else if ($s->user == 0) {
                    if ($tmp_assign == null){
                        $tmp_assign .= "Semua";
                    } else {
                        $tmp_assign .= ", Semua";
                    }
                }    
            }
            $export_d[] = [
                "id" => $r->id,
                "title" => $r->title,
                "assign" => $tmp_assign,
                "date_start" => $r->date_start,
                "date_end" => $r->date_end,
                "type" => $r->type,
                "privilege" => $r->privilege,
                "status" => $r->status,
            ];
        }
		
        return collect($export_d);
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'TITLE',
			'ASSIGN_TO',
			'DATE_START',
			'DATE_END',
            'TYPE',
            'PRIVILEGE',
            'STATUS'
        ];
    }
}
