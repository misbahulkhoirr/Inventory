@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
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
                            <h5 class="m-b-10">Product Out</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Product Out</a></li>
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
                        <h5>Data Product Out</h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama Product</th>
										<th>Satuan</th>
                                        <th>Harga/Satuan</th>
										<th>Penyimpanan (Suhu)</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($datas as $key => $data)
									<tr>
										<td>
											{{$key+1}}.
										</td>
										<td>{{$data->product_name}}</td>
										<td>{{$data->satuan->satuan}}</td>
										<td>{{number_format($data->price,0,',','.')}}</td>
                                        <td>{{$data->storageId->name}} ({{$data->storageId->temperature}})</td>
                                        <td>
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