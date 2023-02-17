@extends('layouts.topbar.app')
@section('title', 'Delivery')
@section('script')
	<script>
	$(document).ready(function(){
			
		$("#tbl-dn tbody tr").on('change','#fi_remark',function(){
			xrows = $(this).closest('tr');
			if(xrows.find("#fi_remark").is(":checked")){			
				xid = xrows.find("td:nth-child(1)").text();
				xdn = xrows.find("td:nth-child(3)").text();
				xcn = xrows.find("td:nth-child(4)").text();				
				
				$("#modal-invoice .modal-body").find("#delivery_id").text(xid);
				$("#modal-invoice .modal-body").find("#delivery_no").text(xdn);
				$("#modal-invoice .modal-body").find("#customer_name").text(xcn);
				$("#modal-invoice").modal('show');
			}				
		});
		$("#modal-invoice .modal-footer").on("click", ".btn-primary", function(){						
			var xid = $("#delivery_id").text();
			var xinvoice_no = $("#inp_invoice").val();
			var checked = $("#fi_remark").val();
			//var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');			
			
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				/* the route pointing to the post function */
				url:"{{url('/')}}/delivery/remark/invoice/"+xid,				
				type: 'POST',
				/* send the csrf-token and the input to the controller */
				data: {delivery_invoice_no:xinvoice_no,
						is_checked : checked},
				dataType: 'JSON',
				success : function(msg){
					if(msg=='1'){						
						$("#modal-invoice").modal('hide');											
						$.toast({
							text: 'Successfully updated!',
							heading: 'MIG-IS',
							showHideTransition: 'plain',
							position: 'top-right',
							loaderBg: '#5ba035',
							icon: 'success',
							hideAfter: 2000,
							stack: 1
						});
						setTimeout(function() {
							location.reload();
						}, 2000);
						
					}
				}
			}); 					          			
		});		
	});
		
	</script>
@stop


@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Delivery</li>
                    </ol>
                </div>
                <h4 class="page-title">Dokumentasi Pengiriman</h4>
            </div>
            <div class="card">
                <div class="card-header">
                    
                    <form action="" method="GET">
                        <div class="form-inline row">
                            <div class="form-group col-md-2">
                                <label for="" class="col-md-1 mr-2">Sort</label>
                                <select name="sorting" class="form-control">
                                    <option value="10" <?=(!isset($_GET['sorting']))?"selected":"";?>>10</option>
                                    <option value="25"<?=(isset($_GET['sorting']))&&($_GET['sorting']=='25')?"selected":"";?>>25</option>
                                    <option value="50" <?=(isset($_GET['sorting']))&& ($_GET['sorting']=='50')?"selected":"";?>>50</option>
                                    <option value="75" <?=(isset($_GET['sorting']))&&($_GET['sorting']=='75')?"selected":"";?>>75</option>
                                    <option value="100" <?=(isset($_GET['sorting'])) && ($_GET['sorting']=='100')?"selected":"";?>>100</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="" class="col-md-1 mr-2">Date</label>
                                <input type="date" class="form-control" name="date" placeholder="Masukan Tanggal Trans." value="{{ isset($_GET['date'])?
                                $_GET['date']:''}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="col-md-1 mr-2">Search</label>
                                <input type="text" class="form-control mr-2" name="searching" placeholder="Masukan Kata Kunci" 
                                value="<?= (isset($_GET['searching']))?$_GET['searching']:"";?>">
                                <button class="btn btn-info col-md-4" type="submit">
                                    <i class="fa fa-search"></i>
                                    <span>Search</span>
                                </button>
                            </div>
							
							@php 
								$style = '';
								$btn_style = '';
							@endphp
							@if(Auth::user()->nik == '271' || Auth::user()->nik == '218' || Auth::user()->nik == '248')
								@php 
									$style = "display:none;";
								@endphp
							@endif							
                            <div class="form-group col-md-1 mr-2" style="{{$style}}">
                                <a type="button" class="btn btn-primary float-right" href="{{route('DN.Create')}}" {{$btn_style}}> 
                                    <span>
                                        <i class='fa fa-plus'></i> Create New 
                                    </span>
                                </a>
                            </div>

                            <div class="form-group col-md-1 ml-2">   
                                <a type="button" class="btn btn-outline-success float-right" href="{{route('DN.Export')}}"> 
                                    <span>
                                        <i class='fa fa-file-excel-o'></i> Import Excel
                                    </span>
                                </a>
                            </div>							
							
                        </div>
                    </form>                  
                                                                                                        
                </div>  
                <div class="card-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover" id="tbl-dn">
                                    <thead>
                                        <th width="5%">No.</th>
                                        <th width="11%">No Pengiriman</th>
                                        <th width="20%">Customer</th>
                                        <th width="20%">Transporter</th>
                                        <th>Item / Barang</th>
                                        <th>Created</th>
										<th>Remark / Status</th>
                                        <th>Action</th>
                                    </thead> 
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach($data as $d)
                                            @php $no++; @endphp
                                            <tr>
												<td id="data-id" style="display:none;">{{$d->delivery_id}}</td>
                                                <td>{{ ($data->currentpage()-1) * $data->perpage() + $no}}</td>
                                                <td>
                                                    {{$d->delivery_no}}<br>
                                                    @if ($d->do_no != null)
                                                    <span class="text-muted" style="font-size: 8pt">DO: {{ $d->do_no }}</span><br>
                                                    @endif
                                                    @if ($d->po_no != null)
                                                    <span class="text-muted" style="font-size: 8pt">PO: {{ $d->po_no }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$d->customer}}<br>
                                                    {{$d->address}}<br>
                                                    {{$d->city}}                                            
                                                </td>
                                                <td>
                                                    <label>Nomor Kendaraan :</label> {{$d->vehicles_no}} <br>
                                                    <label>Driver : </label>{{$d->driver}}
                                                </td>
                                                <td>
                                                    {{$d->item}} <br>
                                                    {{$d->qty}}{{ strtoupper($d->um)}}
                                                </td>
                                                <td>
                                                    {{$d->creator}} <br>
                                                    {{ Date('d-m-Y', strtotime($d->datetime))}}
                                                </td>
												<td align="center">
													@if($d->delivery_is_remark == 1 && $d->delivery_invoice_no != null)
														<span class="label label-success">Complete</span><br>
														<label>Inv. No : {{$d->delivery_invoice_no}}</label>														
													@else
														@if(Auth::user()->nik == "248")
															<input type="checkbox" id="fi_remark" autocomplete="off">
														@else
															<span><small><em>Proccessing</em></small><span>
														@endif
													@endif
												</td>
                                                <td>													
                                                    <a href="{{route('DN.Edit', $d->id)}}" class="btn btn-sm btn-warning" 
                                                        title="Edit" style="{{$style}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>													
                                                    <!-- <a href="{{route('DN.Preview', $d->id)}}" class="btn btn-sm btn-outline-info" 
                                                        title="Detail Information">
                                                        <i class="fa fa-info"></i>
                                                    </a> -->
                                                    <a href="{{route('DN.Print', $d->id)}}" class="btn btn-sm btn-success" 
                                                        title="Print">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                           {{ $data->appends(Request::only('search','sort','date'))->links() }}
                        </ul>
                    </nav>
                </div>
            </div>            
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal-invoice">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Form Invoice Number</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">					
						<table  class="table table-bordered">
							<tbody>
								<tr style="display:none;"><td id="delivery_id"></td></tr>
								<tr>
									<th>Delivery No.</th>
									<td id="delivery_no"></td>
								</tr>
								<tr>
									<th>Customer Name</th>
									<td id="customer_name"></td>
								</tr>
							</tbody>
						</table>					
					</div>
					<form action="" method="POST" id="form-invoice">
						<div class="form-group row">
							<label class="col-md-12 col-sm-12 col-xs-12">Invoice No</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input class="form-control" name="invoice_no" id="inp_invoice" placeholder="Entry invoice no.">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
@stop