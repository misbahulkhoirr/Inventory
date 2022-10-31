@extends('layouts.panel')
@push('css')
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
                            <h5 class="m-b-10">Product {{$type}}</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Product {{$type}}</a></li>
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
                    <div class="col-sm-12  card-header">
                        <h5>Data Product {{$type}}</h5> 
                        <div class="float-right">
                            <a href="{{$type == 'In'? route('product-in.create') : route('product-out.create')}}"> <button class="btn btn-success btn-round has-ripple"><i class="feather icon-plus"></i> Add Product<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button></a>  
                            @if(count($datas) > 0)<button onclick="event.preventDefault(); document.getElementById('export').submit();" class="btn btn-primary btn-round has-ripple"><i class="feather icon-download"></i> Export<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>@endif  
                            <form action="{{$url_search}}" method="post" id="export">
                                @csrf
                                <input type="hidden" name="action" value="export">
                                @if($type == "In")
                                <input type="hidden" name="supplier" value="{{$supplier}}">
                                @else
                                <input type="hidden" name="product" value="{{$product}}">
                                @endif
                                <input type="hidden" name="gudang" value="{{$gudang}}">
                                <input type="hidden" name="from" id="from2">
                                <input type="hidden" name="to" id="to2">
                                <input type="hidden" name="type" value="{{$type}}">
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                    <form action="{{$url_search}}" method="post">
                        @csrf
                        <input type="hidden" name="from" id="from">
                        <input type="hidden" name="to" id="to">
                        <input type="hidden" name="type" value="{{$type}}">
                            <div class="row mb-2">
                                <div class="col-md-3 mb-3">
                                    <label for="">Date Range</label>
                                    <div id="reportrange" class="border p-1" style="border-color:#aaaaaa !important;">
                                        <i class="feather icon-calendar"></i>&nbsp;
                                        <span></span> <i class="feather icon-chevron-down"></i>
                                    </div>
                                </div>
                                @if($type == "In")
                                <div class="col-md-3 mb-3">
                                    <label for="">Supplier</label>
                                    <select name="supplier" class="all-supplier lg col-sm-12">
                                        <option value="">All Supplier</option>
                                        @foreach($suppliers as $pd)
                                        <option value="{{$pd->id}}" @if($pd->id == $supplier) selected @endif>{{$pd->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                <div class="col-md-3 mb-3">
                                    <label for="">Product</label>
                                    <select name="product" class="all-supplier lg col-sm-12">
                                        <option value="">All Product</option>
                                        @foreach($products as $pd)
                                        <option value="{{$pd->id}}" @if($pd->id == $product) selected @endif>{{$pd->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-3 mb-3">
                                    <label for="">Gudang</label>
                                    <select name="gudang" class="all-gudang lg col-sm-12">
                                        <option value="">All Gudang</option>
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
										<th>ID Barang Masuk</th>
                                        <th>Jumlah</th>
                                        @if($type == 'In')
                                        <th>Supplier</th>
                                        @endif
                                        <th>Gudang</th>
                                        <th>Create By</th>
                                        <th width="20">Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($datas as $key => $data)
									<tr>
										<td>
											{{$key+1}}.
										</td>
                                        <td>{{date('d M, Y', strtotime($data->tanggal))}}</td>
										<td>{{$data->no_trx}}</td>
                                        <td></td>
                                        @if($type == 'In')
                                        <td>{{$data->supplier->name}}</td>
                                        @endif
                                        <td>{{$data->gudang->name}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>
                                            @if($data->keterangan != NULL || $data->keterangan != "")
                                            <div id="exampleModalLive{{$data->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLiveLabel">Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mb-0">{{$data->keterangan}}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" data-toggle="modal" title="Keterangan" data-target="#exampleModalLive{{$data->id}}" title="Lihat" class="btn btn-icon btn-warning edit"><i class="feather icon-message-square"></i></a> <a href="#" data-toggle="modal" title="Detail" data-target="#exampleModalLive{{$data->id}}" class="btn btn-icon btn-primary edit"><i class="icon feather icon-eye"></i></a>
                                            @endif
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
@if($type == 'In')
<script src="{{asset('assets/js/pages/form-select-custom-in.js')}}"></script>
@else
<script src="{{asset('assets/js/pages/form-select-custom-out.js')}}"></script>
@endif
<script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/ac-datepicker.js')}}"></script>
@endpush