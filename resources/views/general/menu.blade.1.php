@extends('layouts.topbar.app')

@section('title','Main Menu')

@section('brand','MIG - Information System')

@section('content')

<!-- Page -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

    <div class="page-content container-fluid">
        <div class="row" data-plugin="masonry">
            @role('Admin|User Level 1')
            <div class="col-lg-3 col-sm-12 masonry-item">
                <!-- Widget -->
                <a href="{{ route('helpdesk.index') }}" style="text-decoration: none;">
                    <div class="card card-shadow">

                        <div class="card-img-top cover overlay overlay-hover">
                            <div class="counter counter-lg counter-inverse bg-cyan-600 vertical-align h-150">
                                <div class="vertical-align-middle">
                                    <span class="counter-icon ml-10" style="font-size:72px;"><i class="icon wb-list"
                                            aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title">Helpdesk</h4>
                            <p class="card-text">Sistem pelaporan pekerjaan. </p>
                        </div>

                    </div>
                </a>
                <!-- End Widget -->
            </div>
            @endrole
            <div class="col-lg-3 col-sm-12 masonry-item">
                <!-- Widget -->
                <div class="card card-shadow">
                    <div class="card-img-top cover overlay overlay-hover">
                        <div class="counter counter-lg counter-inverse bg-green-600 vertical-align h-150">
                            <div class="vertical-align-middle">
                                <span class="counter-icon ml-10" style="font-size:72px;"><i class="icon wb-file"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <h4 class="card-title">E-Document</h4>
                        <p class="card-text">Sistem register dan revisi dokumen. </p>
                    </div>
                </div>
                <!-- End Widget -->
            </div>
            <div class="col-lg-3 col-sm-12 masonry-item">
                <!-- Widget -->
                <div class="card card-shadow">
                    <div class="card-img-top cover overlay overlay-hover">
                        <div class="counter counter-lg counter-inverse bg-yellow-600 vertical-align h-150">
                            <div class="vertical-align-middle">
                                <span class="counter-icon ml-10" style="font-size:72px;"><i class="icon wb-book"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <h4 class="card-title">E-Learning</h4>
                        <p class="card-text">Sistem pembelajaran. </p>
                    </div>
                </div>
                <!-- End Widget -->
            </div>
            <div class="col-lg-3 col-sm-12 masonry-item">
                <!-- Widget -->
                <div class="card card-shadow">
                    <div class="card-img-top cover overlay overlay-hover">
                        <div class="counter counter-lg counter-inverse bg-purple-600 vertical-align h-150">
                            <div class="vertical-align-middle">
                                <span class="counter-icon ml-10" style="font-size:72px;"><i class="icon wb-calendar"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <h4 class="card-title">Cuti & Lembur Online</h4>
                        <p class="card-text">Sistem pengambilan cuti & Lembur. </p>
                    </div>
                </div>
                <!-- End Widget -->
            </div>
            <div class="col-lg-3 col-sm-12 masonry-item">
                <!-- Widget -->
                <div class="card card-shadow">
                    <div class="card-img-top cover overlay overlay-hover">
                        <div class="counter counter-lg counter-inverse bg-red-600 vertical-align h-150">
                            <div class="vertical-align-middle">
                                <span class="counter-icon ml-10" style="font-size:72px;"><i class="icon wb-briefcase"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <h4 class="card-title">Assets IT</h4>
                        <p class="card-text">Sistem pendataan assets IT. </p>
                    </div>
                </div>
                <!-- End Widget -->
            </div>
            @role('Admin')
            <div class="col-lg-3 col-sm-12 masonry-item">
                <!-- Widget -->
                <a href="{{ route('users.index') }}" style="text-decoration: none;">
                    <div class="card card-shadow">
                        <div class="card-img-top cover overlay overlay-hover">
                            <div class="counter counter-lg counter-inverse bg-blue-600 vertical-align h-150">
                                <div class="vertical-align-middle">
                                    <span class="counter-icon ml-10" style="font-size:72px;"><i class="icon wb-users"
                                            aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title">Manage User</h4>
                            <p class="card-text">Konfigurasi user akun MIG. </p>
                        </div>
                    </div>
                </a>
                <!-- End Widget -->
            </div>
            @endrole
        </div>
    </div>
</div>
</div>
</div>
<!-- End Page -->
@stop
