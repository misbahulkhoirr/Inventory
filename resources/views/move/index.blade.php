@extends('layouts.panel')
@push('css')
<!-- <link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}"> -->
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
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
                            <h5 class="m-b-10">Transfer Stok</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Transfer Stok</a></li>
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
                        <h5>Data Transfer Stok</h5>
                        <div class="float-right mb-2">
                            <a href="{{route('transfer.create')}}"><button type="button" class="btn btn-success btn-round has-ripple"><i class="feather icon-share"></i> Transfer<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('transfer.search')}}" method="post">
                        @csrf
                        <input type="hidden" name="from" id="from">
                        <input type="hidden" name="to" id="to">
                            <div class="row mb-2">
                                <div class="col-md-3 mb-3">
                                    <label for="">Date Range</label>
                                    <div id="reportrange" class="border p-1" style="border-color:#aaaaaa !important;">
                                        <i class="feather icon-calendar"></i>&nbsp;
                                        <span></span> <i class="feather icon-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">From Gudang</label>
                                    <select name="dari_gudang" class="js-example-placeholder-multiple select-gudang lg col-sm-12">
                                        <option value="">Select</option>
                                        @foreach($gudangs as $gd)
                                        <option value="{{$gd->id}}" @if($gd->id == $dari_gudang) selected @endif>{{$gd->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">To Gudang</label>
                                    <select name="ke_gudang" class="js-example-placeholder-multiple select-gudang lg col-sm-12">
                                        <option value="">Select</option>
                                        @foreach($gudangs as $gd)
                                        <option value="{{$gd->id}}" @if($gd->id == $ke_gudang) selected @endif>{{$gd->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
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
                                        <th>Produk</th>
                                        <th>Dari Gudang</th>
										<th>Ke Gudang</th>
                                        <th>Jumlah</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($datas as $key => $data)
									<tr>
										<td>
											{{$key+1}}.
										</td>
										<td>{{$data->tanggal}}</td>
                                        <td>{{$data->product->product_name}}</td>
                                        <td>{{$data->dariGudang->name}}</td>
										<td>{{$data->keGudang->name}}</td>
										<td>{{$data->amount}} {{$data->product->satuan->satuan}}</td>
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