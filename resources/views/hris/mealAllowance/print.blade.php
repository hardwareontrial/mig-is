<html>
    <head>
        <style>
        body{
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }
        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
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
            size: A4;
            margin: 0;
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
        <div class="page">
            <div class="print">
                <div class="header">
                    <table class="table-header">
                        <tr>
                            <td colspan="3">PT. Molindo Inti Gas</td>
                            <td  colspan="3" rowspan="6" id="logo">
                                <img src="{{asset('backend/assets/images/logo-mig.svg')}}" alt="Logo MIG" height="80" width="60">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">Uang Makan & Lembur</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                            Periode : {{Date('d-m-Y', strtotime($data_master->periode_start))}} sd.
                            {{Date('d-m-Y', strtotime($data_master->periode_end))}}</td>
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
                            <td>Department</td>
                            <td>:</td>
                            <td>{{$department->name}}</td>
                        </tr>
                    </table>
                </div>
                <div class="content">
                    <table class="table-content">
                        <thead>
                            <th class="col-content-header">Tanggal</th>
                            <th class="col-content-header">Uang Makan</th>
                            <th class="col-content-header">Lembur</th>
                            <th class="col-content-header">Jam</th>
                            <th class="col-content-header">UM Lembur</th>
                            <th class="col-content-header">Jumlah</th>
                        </thead>
                        <tbody>
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
                                <td class="col-content">{{($data->overtime_hour == null) ? '-' : $data->hour}}</td>
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
                                    $pembulatan = substr($dibulatkan,0,1) + 1;
                                }
                            @endphp
                            <tr>
                                <td colspan="5" class="col-content">Pembulatan</td>
                                @php $total = substr($total,0,3).''.$pembulatan.'00' @endphp
                                <td class="col-content">{{number_format($total,0,'.','.')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                            <td class="col-event">{{$data_master->quotes}}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </body>

</html>