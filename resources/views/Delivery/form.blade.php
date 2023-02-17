@extends('layouts.topbar.app')
@section('title', 'Form  Delivery Note')
@section('content')
    @php       
        if(isset(Request()->id)){
            $url = "DN.Update";                            
            $customer =  $data[0]->customer;
            $address = $data[0]->address;
            $city = $data[0]->city;
            $vehicles_no = $data[0]->vehicles_no;
            $driver = $data[0]->driver;
            $item = $data[0]->item;
            $qty = $data[0]->qty;
            $um = $data[0]->um;
            $po = $data[0]->po_no;
            $do = $data[0]->do_no;
            $tgl_kirim = $data[0]->tgl_kirim;
        }
        else{
            $url = "DN.Store";
            $customer = "";
            $address = "";
            $city = "";
            $vehicles_no = "";
            $driver = "";
            $item = "";
            $qty = "";
            $um = "";
            $po = "";
            $do = "";
            $tgl_kirim = "";
        }        
    @endphp
    <div class='container-fluid'>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('DN.index')}}">Delivery</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?=(Request()->id)?"Edit Delivery": "Create New Delivery";?></h4>
                </div>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-10'>
                <div class="card"> 
                    @if(Request()->id)
                        <form action="{{route($url, Request()->id)}}" method="POST">
                    @else
                        <form action="{{route($url)}}" method="POST">
                    @endif  
                        @csrf                    
                        <div class="card-header">
                            <h5>Form Delivery Information</h5>
                        </div>
                        <div class="card-body">  
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">SAP Delivery No</label>
                                <div class='input-group col-md-6 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-truck" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <input class='form-control' name='do_no' 
                                        placeholder="Nomor DO" value="{{ $do }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">SAP P/O No</label>
                                <div class='input-group col-md-6 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-file" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <input class='form-control' name='po_no'
                                        placeholder="Nomor P/O" value="{{ $po }}">
                                </div>
                            </div>                      
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Customer Name</label>
                                <div class='input-group col-md-6 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-id-card-o" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <input class='form-control' name='customer_name' 
                                        placeholder="Nama Customer" value="{{$customer}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Customer Address</label>
                                <div class='input-group col-md-6 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-building-o" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <textarea class='form-control' placeholder='Alamat Customer'name='customer_alamat'>{{$address}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">City</label>
                                <div class="input-group col-md-6 mb-2">                                    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-map-marker" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control"
                                        placeholder="Kota Customer" name="customer_kota" value="{{$city}}" Required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tranportation No.</label>
                                <div class='input-group col-md-6 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-truck" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <input class='form-control' name='kendaraan_no' 
                                        placeholder="Nomor Polisi Kendaraan" value="{{$vehicles_no}}" Required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Driver Name</label>
                                <div class='input-group col-md-6 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-wheelchair" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <input class='form-control' name='driver_name' 
                                        placeholder="Nama Driver" value="{{$driver}}" Required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Item Name</label>
                                <div class="col-lg-2 ml-4 mb-0">
                                    <input type="radio" class="form-check-input" name="item[]" value="Liquid CO2" <?= ($item == "Liquid CO2")? "checked" : "";?> Required>Liquid CO2                                  
                                </div>
                                <div class="col-lg-2">
                                    <input type="radio" class="form-check-input" name="item[]" value="Dry Ice"  <?= ($item == "Dry Ice")? "checked" : "";?> Required>Dry Ice
                                </div>    
                                <div class="col-lg-2">
                                    <input type="radio" class="form-check-input" name="item[]" value="Dry Ice (pellet)"  <?= ($item == "Dry Ice (pellet)")? "checked" : "";?> Required>Dry Ice <small><i>(pelet)</i></small>
                                </div>                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Quantity</label>
                                <div class='input-group col-md-3 mb-2'>
                                    <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-clipboard" style='width:20px;'></i>
                                        </span>
                                    </div>
                                    <input type="number" class='form-control' name='qty' 
                                        placeholder="Quantity Pengiriman" Required value="{{$qty}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Unit</label>                                
                                <div class="col-lg-2 ml-4 mb-0">
                                    <input type="radio" class="form-check-input" name="unit_measure[]" value="KG" <?=($um=="KG") ? "checked" : ""; ?> Required>Kilogram                                                                        
                                </div>
                                <div class="col-lg-2 ml-4 mb-0">
                                    <input type="radio" class="form-check-input" name="unit_measure[]" value="L" <?=($um=="L")? "checked" : "";?> Required>Liter                                                                        
                                </div>                                
                            </div>                        
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tanggal Kirim</label>
                                <div class='input-group col-md-6 mb-2'>
                                    {{-- <div class='input-group-prepend'>
                                        <span class="input-group-text">
                                            <i class="fa fa-wheelchair" style='width:20px;'></i>
                                        </span>
                                    </div> --}}
                                    <input class='form-control' name='tgl_kirim' type="date"
                                        placeholder="Nama Driver" value="{{ $tgl_kirim }}">
                                </div>
                            </div>
                        </div>   
                        <div class="card-footer">
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-success mb-2 mr-2" name="btn_save_print" value='save_print'>
                                    <i class="fa fa-print"></i>
                                    <span>Save & Print</span>                                                                        
                                </button>
                                <button type="submit" class="btn btn-primary mb-2 mr-2" name="btn_save" value="save">
                                    <i class="fa fa-save"></i>
                                    <span>Save</span>                                                                        
                                </button>                                            
                                {{-- <button class='btn btn-outline-danger mb-2 mr-2' onclick="window.history.back()"> --}}
                                <a href="{{ route('DN.index') }}" class="btn btn-outline-danger mb-2 mr-2" type="button">
                                    <i class="fa fa-level-up"></i>
                                    <span>Cancel</span>
                                </a>
                                {{-- </button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection