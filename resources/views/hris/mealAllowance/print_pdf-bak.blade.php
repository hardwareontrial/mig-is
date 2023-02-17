<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>NIK {{$data_detail[0]->User->nik}} ( {{Date('d-m-Y', strtotime($data_master->periode_start))}} - {{Date('d-m-Y', strtotime($data_master->periode_end))}} )</title>
	<style>
        body{
            margin: auto;
            padding: auto;
            background-color: #FAFAFA;
			font-family: 'dejavu sans';
			font-size: 10 pt;
        }
        .page {
            width: 10cm;
            min-height: auto;
            padding: 1cm;
            margin:  1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .table-header{
            width: 10cm;
            /* border:1px solid; */
            font-size:10pt;
        }
        .table-header > tr > td{
            width: 10cm;
            font-size: 10pt;
        }
        #logo{
            text-align: center;
            object-fit: cover;

        }
        .table-content{  
            width : 10cm;
            border: 1px solid;
            border-collapse: collapse;
            font-size: 10pt;
        }
        th.col-content-header{
            border: 1px solid;  
        }
        tr.row-content{
            border: 1px solid;  
            border-collapse:collapse;
        }
        td.col-content{
            border: 1px solid;
            border-collapse:collapse;
            text-align: center;
        }

        @page {
            size: ;
            margin:;
        }
        @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
        }
        table.table-footer{
            width: 10cm;
            font-size: 10pt;
        }
        td.col-event{
            width: 10cm;
            height: auto;
            border: 1px solid;
            text-align: center;
            
        }

	</style>
</head>
<body>
  <div class="header">
	<table class ="table-header">
		<tr>
			<td colspan="3"><b>PT. Molindo Inti Gas</b></td>
			<td colspan="3" rowspan="6" id="logo"><img src="" alt="Logo MIG" height="80" width="60"></img></td>
		</tr>
		<tr>
			<td colspan="3">Uang Makan dan Lembur</td>
		</tr>
		<tr>
			<td colspan="3">Periode : {{Date('d-m-Y', strtotime($data_master->periode_start))}} sd. {{Date('d-m-Y', strtotime($data_master->periode_end))}}</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td>{{$data_detail[0]->User->name}}</td>
		</tr>
		<tr>
			<td>NIK</td>
			<td>:</td>
			<td>{{$data_detail[0]->User->nik}}</td>
		</tr>
		<tr>
			<td>Departemen</td>
			<td>:</td>
			<td>{{$department->name}}</td>
		</tr>
	</table></div>
	<div class="content">
    <table class="table-content">
        <tr>
			<td class="col-content"><b>Tanggal</b></td>
			<td class="col-content"><b>Uang Makan</b></td>
			<td class="col-content"><b>Lembur</b></td>
			<td class="col-content" cellpadding="3"><b>Jam</b></td>
			<td class="col-content"><b>UM Lembur</b></td>
			<td class="col-content"><b>Jumlah</b></td>
        </tr>
		@php $total = 0; @endphp
		@foreach($data_detail as $data)
		@php
			$jumlah = $data->meal_allowance_val + $data->overtime_val + $data->meal_overtime_val;
            $total += $jumlah;
        @endphp
			<tr class="row-content">
				<td class="col-content">{{Date('d-m-Y', strtotime($data->date))}}</td>
				<td class="col-content">{{($data->meal_allowance_val == null) ? '-': number_format($data->meal_allowance_val,0,'.','.')}}</td>
				<td class="col-content">{{($data->overtime_val == null) ? '-' : number_format($data->overtime_val,0,'.','.')}}</td>
				<td class="col-content">{{($data->overtime_hour == null) ? '-' : $data->overtime_hour }}</td>
				<td class="col-content">{{($data->meal_overtime_val == null) ? '-' : number_format($data->meal_overtime_val,0,'.','.')}}</td>
				<td class="col-content">{{number_format($jumlah,0,'.','.')}}</td>
            </tr>
			@endforeach
            <tr>
				<td colspan="5" class="col-content">Total</td>
                <td class="col-content">{{number_format($total,0,'.','.')}}</td>
            </tr>
		@php
		$pembulatan = 0;
		$dibulatkan = substr($total,3);
			if(substr($dibulatkan,-2)>0){
			$pembulatan = substr($dibulatkan,0,1) + 1;  }
		@endphp	
            <tr>
				<td colspan="5" class="col-content">Pembulatan</td>
					@php $total = substr($total,0,3).''.$pembulatan.'00' @endphp
				<td class="col-content">{{number_format($total,0,'.','.')}}</td>
			</tr>
		
	</table></div>
	<div class="footer">
	<table class="table-footer">
		<tr class="row-footer">
			<td class="col-footer">Note :</td>
		</tr>
			@foreach($note as $key => $value)
		<tr>
			<td>{{$value}}</td>
		</tr>
			@endforeach
		<tr>
			<td class="col-content"><b>"{{$data_master->quotes}}"</b></td>
		</tr>
		
	</table></div>
</body>
</html>