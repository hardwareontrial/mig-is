<?php

namespace App\Exports;

use App\Model\Delivery\Delivery_Export;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Delivery_Export::Delivery_export_data()->get();
        $no =  0;
        $arrdata = array();
        foreach($data as $d){
            $no++;
            $arrdata[] = [
            'no' => $no,
            'delivery_no' => $d->delivery_no,
            'customer' => $d->del_det_customer,
            'address' => $d->del_det_address,
            'city' => $d->del_det_city,
            'item' => $d->del_det_item,
            'qty' => $d->del_det_qty,
            'um' => $d->del_det_um,
            'creator'=> $d->name,
            'created_at' => $d->delivery_created_at,
            ];
        }        
        return collect($arrdata);                
    }

    public function headings(): array
    {
        return [
            'no',            
            'No Pengiriman',
			'Nama Customer',
            'Alamat Customer',
            'Kota Customer',
            'Nama Item',
            'Qty',
            'Satuan',
            'Creator',
            'Created at',			
        ];
    }
}
