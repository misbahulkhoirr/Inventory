@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
<style>
    td {
        vertical-align: middle !important;
    }
</style>
@endpush
@section('content')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Opname</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Opname</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Basic Header fix table start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>Data Opname</h5>
                                <div class="float-right mb-2">
                                <a href="{{route('opname.create')}}"><button type="button" class="btn btn-success btn-round has-ripple"><i class="feather icon-plus"></i> Tambah Opname<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                    <form action="{{route('opname.search')}}" method="post">
                        @csrf
                        <input type="hidden" name="from" id="from">
                        <input type="hidden" name="to" id="to">
                            <div class="row mb-2">
                                <div class="col-md-4 mb-3">
                                    <label for="">Date Range</label>
                                    <div id="reportrange" class="border p-1" style="border-color:#aaaaaa !important;">
                                        <i class="feather icon-calendar"></i>&nbsp;
                                        <span></span> <i class="feather icon-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Status</label>
                                    <select name="status" class="js-example-placeholder-multiple lg col-sm-12">
                                        @php
                                            $statuses = ['New','Approved','Rejected'];
                                        @endphp
                                        <option value="">Select</option>
                                        @foreach($statuses as $mt)
                                        <option value="{{$mt}}" @if($mt == $status) selected @endif>{{$mt}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-sm btn-primary mb-0 mt-4 btn-block" width="100%"> <i class="feather mr-2 icon-search"></i> SEARCH</button>
                                </div>
                            </div>
                        </form>
                        <div class="dt-responsive table-responsive">
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>#</th>
                                        <th>Tanggal</th>
										<th>Gudang</th>
                                        <th>Operator Gudang</th>
										<th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($datas as $key => $data)
									<tr>
										<td>
											{{$key+1}}.
										</td>
                                        <td>{{date('d M, Y', strtotime($data->tanggal))}}</td>
                                        <td>{{$data->gudang->name}}</td>
										<td>
                                            @foreach($data->operators as $i => $op)
                                            @if($i>0),&nbsp;&nbsp;@endif{{$op->user->name}} 
                                            @endforeach
                                        </td>
										<td><div class="badge @if($data->status == 'New') badge-primary @elseif($data->status == 'Approved') badge-success @else badge-danger @endif badge-pill">{{$data->status}}</div></td>
                                        <td>
                                            <a href="{{route('opname.view',$data->id)}}" title="Lihat" class="btn btn-icon btn-warning edit"><i class="icon feather icon-eye"></i></a>
                                            @if($data->status == 'New')<a href="{{route('opname.edit',$data->id)}}" title="Edit" class="btn btn-icon btn-success delete"><i class="feather icon-edit"></i></a>@endif
                                        </td>
									</tr>
                                    @endforeach
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection
@push('js')
<!-- select2 Js -->
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
<!-- form-select-custom Js -->
<script src="{{asset('assets/js/pages/form-select-custom.js')}}"></script>

<script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/ac-datepicker.js')}}"></script>
@endpush
<!-- @push('js')
<script src="{{asset('assets/js/pages/task-board.js')}}"></script>
@endpush -->