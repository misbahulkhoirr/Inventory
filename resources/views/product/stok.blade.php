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
                            <h5 class="m-b-10">Stok Product</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Stok Product</a></li>
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
                        <h5>Data Stok Product</h5>
                    </div>
                    <div class="card-body">
                    @foreach($gudangs as $key => $data)
                        <div class="dt-responsive table-responsive">
                            @if(count($data->saldo) > 0)
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
                                    <tr>
                                        <th colspan="3">{{$data->name}}</th>
                                    </tr>
									<tr>
										<th>#</th>
										<th>Nama Product</th>
										<th>Stok</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($data->saldo as $in => $dt)
									<tr>
										<td>{{$in+1}}.</td>
										<td>{{$dt->product->product_name}}</td>
                                        <td>{{$dt->saldo}} {{$dt->product->satuan->satuan}}</td>
									</tr>
                                    @endforeach
								</tbody>
                            </table>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection