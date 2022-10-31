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
                            <h5 class="m-b-10">Mutasi</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Mutasi</a></li>
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
                        <h5>Data Mutasi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('mutasi.search')}}" method="post">
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
                                    <label for="">Product</label>
                                    <select name="product" class="js-example-placeholder-multiple select-product lg col-sm-12">
                                    <option value="">Select</option>
                                        @foreach($products as $pd)
                                        <option value="{{$pd->id}}" @if($pd->id == $product) selected @endif>{{$pd->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">Gudang</label>
                                    <select name="gudang" class="js-example-placeholder-multiple select-gudang lg col-sm-12">
                                        <option value="">Select</option>
                                        @foreach($gudangs as $gd)
                                        <option value="{{$gd->id}}" @if($gd->id == $gudang) selected @endif>{{$gd->name}}</option>
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
                                        <th>Product</th>
                                        <th>Satuan</th>
										<th>In</th>
                                        <th>Out</th>
										<th>Balance</th>
                                        <th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
                                    @php
                                        $in = 0;
                                        $out = 0;
                                        $tot_in = 0;
                                        $tot_out = 0;
                                    @endphp
                                    @foreach($datas as $key => $data)
                                    @php
                                        if($data->mutasi == 'In')
                                            $in = $data->jumlah;
                                        else $in = 0;

                                        if($data->mutasi == 'Out')
                                            $out = $data->jumlah;
                                        else $out = 0;

                                        $tot_in+=$in;
                                        $tot_out+=$out;
                                    @endphp
									<tr>
										<td>
											{{$key+1}}.
										</td>
										<td>{{date('d M, Y H:i', strtotime($data->created_at))}}</td>
                                        <td>{{$data->product->product_name}}</td>
                                        <td>{{$data->product->satuan->satuan}}</td>
										<td>@if($data->mutasi == 'In'){{$data->jumlah}} @else 0 @endif</td>
										<td>@if($data->mutasi == 'Out'){{$data->jumlah}} @else 0 @endif</td>
                                        <td>{{$data->balance}}</td>
                                        <td>{{$data->keterangan}}</td>
									</tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th>{{$tot_in}}</th>
                                        <th>{{$tot_out}}</th>
                                        <th colspan="2"></th>
                                    </tr>
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