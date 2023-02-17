@extends('layouts.topbar.app')
@section('title', 'Phone Book')
@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Phone Book</li>
                    </ol>
                </div>
                <h4 class="page-title">Daftar Telepon</h4>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class='row'>
                        <div class="col-md-12">
                            <a type="button" class="btn btn-primary float-right" href="{{route('phonebook.create')}}"> 
                                <span>
                                    <i class='fa fa-plus'></i> Create New
                                </span>
                            </a>
                        </div>
                    </div>
                </div>  
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class='table-responsive'>
                                <table class='table table-bordered' id='tblPhonebook'>
                                    <thead>
                                        <tr>
                                            <th style='width:5%;' class="text-center">No</th>
                                            <!-- <th style="display:none;">Id</th> -->
                                            <th style='width:15%' class="text-center">Nama Perusahaan</th>
                                            <th style='width:25%' class="text-center">Alamat Perusahaan</th>
                                            <th style='width:15%' class="text-center">Kota Perusahaan</th>
                                            <th style='width:15%' class="text-center">Nama PIC</th>
                                            <!-- <th style='width:5%'>Detail</th> -->
                                            <th style='width:15%'>Action</th>
                                        </tr>                                            
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Informasi Kontak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='table-responsive'>
                    <table class="table table-bordered table-sm">
                        <thead class='thead-light'>
                            <tr>
                                <th rowspan='2' class="text-center" width='20%'>Informasi</th>
                                <th colspan='2' class="text-center">Kontak</th>
                                <tr>
                                    <th class='text-center' width='40%'>Perusahaan</th>
                                    <th class='text-center' width='40%'>Personal</th>
                                </tr>    
                            </tr>                            
                        </thead>
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td id='perusahaanName'></td>
                                <td id='personName'></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td id='perusahaanAddress'></td>
                                <td id='personAddress'></td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td id='perusahaanCity'></td>
                                <td id='personCity'></td>
                            </tr>
                            <tr>
                                <th>Telp</th>
                                <td id='perusahaanPhone'></td>
                                <td id='personPhone'></td>
                            </tr>
                            <tr>
                                <th>Fax</th>
                                <td id='perusahaanFax'></td>
                                <td id='personFax'></td>
                            </tr>
                            <tr>
                                <th>No. Handphone</th>
                                <td class='text-center'>-</td>
                                <td id='personMobile'></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td id='perusahaanKet'></td>
                                <td id='personKet'></td>
                            </tr>
                        </tbody>
                    </table>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){      
            $('#tblPhonebook').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('phonebook.getdata') }}",
                columns: [                
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama_perusahaan', name: 'nama_perusahaan'},
                    {data: 'alamat_perusahaan', name: 'alamat_perusahaan'},
                    {data: 'kota_perusahaan', name: 'kota_perusahaan'},
                    {data: 'nama_person', name: 'nama_person'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });                                                    
        });  

        $('#tblPhonebook tbody').on('click',"tr > td:not(:eq(5))", function () {
            xid = $(this).parent().attr('id');            
            $.ajax({
                type:"GET",
                url:location.origin+"/general/phonebook/"+xid,                
                success:function(data){
                    $("#DetailModal #perusahaanName").text(data.nama_perusahaan);
                    $("#DetailModal #personName").text(data.nama_person);
                    $("#DetailModal #perusahaanAddress").text(data.alamat_perusahaan);
                    $("#DetailModal #personAddress").text(data.alamat_person);
                    $("#DetailModal #perusahaanCity").text(data.kota_perusahaan);
                    $("#DetailModal #personCity").text(data.kota_person);
                    $("#DetailModal #perusahaanPhone").text(data.telp_perusahaan);
                    $("#DetailModal #personPhone").text(data.telp_person);
                    $("#DetailModal #perusahaanFax").text(data.fax_perusahaan);
                    $("#DetailModal #personFax").text(data.fax_person);
                    $("#DetailModal #personMobile").text(data.hp_person);
                    $("#DetailModal #perusahaanKet").text(data.ket_perusahaan);
                    $("#DetailModal #personKet").text(data.ket_person);
                        
                        $("#DetailModal").modal('show'); 
                }
            });               
        });
        $("body").on("click", ".btn-danger",function(){                                           
            var xid= $(this).data('id');                
            if(confirm('Anda yakin ingin menghapus data ini?')){
                $.ajax({
                    headers:{
                        "X-CRSF-TOKEN":$("meta[name='csrf-token']").attr('content')
                    },
                    type:"POST",
                    url:location.origin+"/general/phonebook/deleted/"+xid,
                    data :{is_deleted:'1'}, 
                    success:function(data){
                        if(data=='1'){
                            alert("Data telah terhapus!");
                            window.location.href = "{{route('phonebook.index')}}";
                        }
                    }
                });                
            }
        });
    </script>
@endsection