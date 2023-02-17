<?php

namespace App\Exports;

use App\User;
use App\Model\Division;
use App\Model\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{	
    public function __construct()
    {
		
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		$users = User::select('nik','name','division_id','position_id','email','photo','is_active')
						->with('position','division')
						->get();
									
		foreach ($users as $r) {
			$r->division_id = $r->division['name'];
			$r->position_id = $r->position['name'];
		}
		
        return $users;
    }
	
	public function headings(): array
    {
        return [
            'NIK',
            'NAMA',
			'DEPARTEMEN',
			'POSISI',
			'EMAIL',
			'FOTO',
			'STATUS',
        ];
    }
}
