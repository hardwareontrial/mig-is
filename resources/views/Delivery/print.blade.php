@extends('layouts.topbar.app')
@section('title', 'Delivery - print')
@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('DN.index')}}">Delivery</a></li>
                        <li class="breadcrumb-item active">Print</li>
                    </ol>
                </div>
                <h4 class="page-title">Print Surat Pengiriman</h4>
            </div>
            <div class="card">
                <div class="card-header">
                    <button class=" btn btn-outline-success btnprint">
                        <i class="fa fa-print"></i><span>Print</span>
                    </button>
                </div>
                <div class="card-body"> 
                    <div class="print" style="margin-top:60px;">
                        <div class="row">
                            <div class="col-md-12">
                                <table width="100%" id="tbl-he" cellspacing="0">
                                    <tr>
                                        <td style="width: 14%;">No. Surat Jalan</td>
                                        <td style="width: 2%;">:</td>
                                        <td style="width: 48%;">{{ $data->do_no ?? $data->delivery_no }}</td>
                                        <td>Kepada  :</td>
                                    </tr>   
                                    <tr>
                                        <td style="">Tanggal</td>
                                        <td style="">:</td>
                                        {{-- <td>{{ Date(('d.m.Y'), strtotime($data->datetime)) }}</td> --}}
                                        <td>{{ ($data->tgl_kirim) ? date(('d.m.Y'), strtotime($data->tgl_kirim)) : date(('d.m.Y'), strtotime($data->datetime)) }}</td>
                                        <td>{{$data->customer}}</td>
                                    </tr>
                                    <tr>
                                        <td style="">No. PO</td>
                                        <td style="">:</td>
                                        <td>{{ $data->po_no }}</td>
                                        <td rowspan="4" valign="top">{{ $data->address }}<br>{{$data->city}}</td>
                                    </tr>
                                    <tr>
                                        <td style="">No. Kendaraan</td>
                                        <td style="">:</td>
                                        {{-- <td>{{ $data->vehicles_no }}</td> --}}
                                        <td><?=str_replace(' ', '', $data->vehicles_no)?></td>
                                    </tr>
                                    <tr>
                                        <td style=""></td>
                                        <td style=""></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style=""></td>
                                        <td style=""></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            {{-- <div class="col-6">
                                <table class="table-bordered">
                                    <tr>
                                        <td style="width: 35%;">No. Surat Jalan</td>
                                        <td style="width: 7%;">:</td>
                                        <td>{{ $data->do_no ?? $data->delivery_no }}</td>
                                    </tr>   
                                    <tr>
                                        <td style="">Tanggal</td>
                                        <td style="">:</td>
                                        <td>{{ Date(('d-m-Y'), strtotime($data->datetime)) }}</td>										
                                    </tr>
                                    <tr>
                                        <td style="">No. PO</td>
                                        <td style="">:</td>
                                        <td>{{ $data->po_no }}</td>                                        
                                    </tr>
                                    <tr>
                                        <td style="">No. Kendaraan</td>
                                        <td style="">:</td>
                                        <td>{{ $data->vehicles_no }}</td>                                        
                                    </tr>  
                                </table>
                            </div>
                            <div class="col-6" align="right">
                                <table style="margin-right:50px;" class="table-bordered">
                                    <tr>
                                        <td>Kepada  :</td>
                                    </tr>
                                    <tr>
                                        <td>{{$data->customer}}</td>   
                                    </tr>
                                    <tr>
                                        <td>{{$data->address}}<br>{{$data->city}}</td>
                                    </tr>
                                </table>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="item-tbl" style="margin-top: 10px;">
                                    <thead>
                                        <tr style="border:1px solid;">
                                            <th style="text-align:center; font-weight:400; width:9%; ">No.</th>
                                            <th style="text-align:center; font-weight:400;">Jenis Barang</th>
                                            <th style="text-align:center; font-weight:400; width:24%;">Quantity</th>
                                            <th style="text-align:center; font-weight:400; width:14%;">Satuan</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody>                                        
                                        <tr>                                            
                                            <td style="text-align:center">1</td>
                                            <td style="text-align:center">{{ $data->item }}</td>
                                            <td style="text-align:center">{{ $data->qty }}</td>
                                            <td style="text-align:center">{{ $data->um }}</td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table style="margin-top: 10px;" class="">
                                    <tr>
                                        <td>Kemasan</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="width:41%">Tanggal terima Barang</td>
                                        <td style="width:7%">:</td>
                                        <td>.........................................................</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="list_assign_tbl">
                                    <tr>
                                        <td rowspan="4" width="40%" horizontal-align="center"> 
                                            <p>
                                                Barang tsb. bersegel telah diterima diperiksa 
                                                dengan betul isi dan kualitasnya
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%" style="text-align:center; font-weight:400;">Penerima</th>
                                        <th width="20%" style="text-align:center; font-weight:400;">Pengemudi</th>
                                        <th width="20%" style="text-align:center; font-weight:400;">Gudang</th>
                                    </tr>
                                    <tr height="50px;"></tr>                                    
                                    <tr>
                                        <td width="20%" style="text-align:center;">(.............................)</td>
                                        <td width="20%" style="text-align:center;">( {{$data->driver}} )</td>
                                        <td width="20%" style="text-align:center;">(.............................)</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table width="100%" class="">
                                    <tr>
                                        <td rowspan="3" valign="top" style="width: 7%";>Note</td>
                                        <td style="width: 52%;">Brutto..................</td>
                                    </tr>
                                    <tr> 
                                        <td>Tara.....................</td>
                                        {{-- <td style="text-align:center;">Pengembalian Drum / Box Kosong</td> --}}
                                        {{-- <td style="width: 5%;">Pengembalian</td>
                                        <td>Drum / Box Kosong</td> --}}
                                    </tr>
                                    <tr>
                                        <td>Netto...................</td>                                                                                                                                                                                                                                   
                                        {{-- <td style="text-align:center;">..................................................... &nbsp; Drum / Box Kosong</td>                                         --}}
                                        {{-- <td>.........................</td>
                                        <td>Drum / Box Kosong</td> --}}
                                        <td style="font-size: 10pt;"><u>Pengembalian</u> <u>Drum</u> <u>/</u> <u>Box</u> <u>Kosong</u></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>...........................................</td>
                                        <td style="font-size: 10pt;" align="right">Drum / box kosong</td>
                                    </tr>
                                </table>                                                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table width="100%">
                                    <tr>
                                        <td style="text-align: left;"><span style="font-size: 8pt; color:darkgrey;">Tgl Cetak: <i>{{ date(('d-M-Y'), strtotime($data->datetime)) }}</i></span></td>
                                        <td style="text-align: right;"><span style="font-size: 8pt; color:darkgrey;">{{ $data->delivery_no }}</span></td>
                                    </tr>
                                </table>                                                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<style>
    @media print{
        @page{
            size: auto;
            margin: 7mm;                                    
        }
        .print{
            font-size : 12pt;
            width: 100%;
            height: 153mm;
            overflow:visible;
        }
        .card-header{
            display:none;
        }
        #item-tbl{
            width:100%;
        }
    }
    #item-tbl{
        width:100%;
        border:1px solid;
    }
    #item-tbl th{
        border:1px solid;
    }
    #item-tbl td{
        border:1px solid;          
    }
    #list_assign_tbl{
        width:100%;
    }
    #tbl-he td:empty::before{content: '\00a0'; visibility: hidden;}
    /* th:empty::before,td:empty::before{content:'\00a0';visibility:hidden} */
    
</style>
@endsection
@section('script')
<script>
    $(".btnprint").on("click", function(){
        /*var xid = <?php echo Request()->id;?>;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })          
        swalWithBootstrapButtons.fire({
        title: 'Ingin mencetak surat jalan ini?',
        text: "Data akan dicetak!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, cetak!',
        cancelButtonText: 'Tidak, batal!',
        reverseButtons: true
        }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('DN.Confirm', Request()->id)}}",
                success: function( msg ) {
                    if(msg == '1'){*/
                        window.print();                                                   
                    /*}                                        
                }
                
            });            
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) 
        {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Data anda batal di cetak!',
                'error'
            )
        }
        })*/
    });
</script>
    
@endsection