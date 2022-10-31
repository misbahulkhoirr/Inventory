@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
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
                            <h5 class="m-b-10">View Opname</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">View Opname</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row" id="in_form">
            <!-- Basic Header fix table start -->
            <div class="col-sm-12">
                <div class="card select-card">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Tanggal') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6 mt-2">
                                        {{$datas->tanggal}}
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6 mt-2">
                                        {{$datas->gudang->name}}
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Petugas Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6 mt-2">
                                        @foreach($datas->operators as $i => $op)
                                            @if($i>0),&nbsp;&nbsp;@endif{{$op->user->name}} 
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Status') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6 mt-2">
                                    <div class="badge @if($datas->status == 'New') badge-primary @elseif($datas->status == 'Approved') badge-success @else badge-danger @endif badge-pill">{{$datas->status}}</div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        
                        <div class="dt-responsive table-responsive">
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama Product</th>
										<th>Satuan</th>
                                        <th>Stok Seharusnya</th>
                                        <th width="250px">Stok Fisik</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($datas->detail as $key => $data)
                                    <tr>
                                        <td>{{$key+1}}.</td>
                                        <td>{{$data->product->product_name}}</td>
                                        <td>{{$data->product->satuan->satuan}}</td>
                                        <td>{{$data->seharusnya}}</td>
                                        <td>{{$data->fisik}}</td>
                                        <td>
                                            <span>{{number_format($data->selisih,0,',','.')}}</span>
                                        </td>
                                        <td>{{$data->keterangan}}</td>
                                    </tr>
                                    @endforeach
								</tbody>
                            </table>
                        </div>
                        <!-- <div v-show="products.length > 0" class="col-md-12">
                            <div class="float-right mb-2">
                                <a href="{{route('opname.index')}}"><button type="button" class="btn btn-danger btn-round has-ripple"><i class="feather icon-skip-back"></i> BACK<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button></a> 
                                <button type="button" @click="save()" class="btn btn-success btn-round has-ripple"><i class="feather icon-save"></i> SAVE<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> 
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection
@push('js')
@include('components.vuejs')

<script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-select-custom.js')}}"></script>
@endpush