@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@endpush
@section('content')
<section class="pcoded-main-container" id="invoice">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Invoice</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Invoice</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Invoice ] start -->
            <div class="container">
                <div>
                    <div class="card" id="printTable">
                        <div class="row invoice-contact">
                            <div class="col-md-8">
                                <div class="invoice-box row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive invoice-table table-borderless p-l-20">
                                            <tbody>
                                                <tr>
                                                    <td> <h2>PRODUCT {{strtoupper($data->mutasi)}}</h2>  </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td>1065 Mandan Road, Columbia MO, Missouri. (123)-65202</td>
                                                </tr>
                                                <tr>
                                                    <td><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">demo@gmail.com</a></td>
                                                </tr>
                                                <tr>
                                                    <td>+91 919-91-91-919</td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="card-body">
                            <div class="row invoive-info">
                                <div class="col-md-12 col-sm-12">
                                    <h6 id="title">Order Information :</h6>
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <th class="kiri">Id</th>
                                                            <td>
                                                            : #{{$data->no_trx}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="kiri">Date</th>
                                                            <td>: {{$data->tanggal}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="kiri">Gudang</th>
                                                            <td>: {{$data->gudang->name}}</td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                    <tbody>
                                                        @if($data->supplier_id > 0)
                                                        <tr>
                                                            <th class="kiri">Supplier</th>
                                                            <td>
                                                                <span class="label label-warning">: {{ucwords($data->supplier->name)}}</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                        <tr>
                                                            <th class="kiri">Keterangan </th>
                                                            <td>
                                                                <span class="label label-warning">: {!! ucfirst($data->keterangan) !!}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="kiri">Created By </th>
                                                            <td>
                                                                <span class="label label-warning">: {{ ucwords($data->user->name) }}</span>
                                                            </td>
                                                        </tr>
                                                        
                                                        <!-- <tr>
                                                            <th class="kiri">
                                                                <h6 class="text-uppercase text-primary">Total </h6>
                                                            </th>
                                                            <td>
                                                                <h6 class="text-uppercase text-primary"><span>: {{$data->mutasis->sum('jumlah')}}</span></h6>
                                                            </td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                                <!-- <div class="col-md-6 col-sm-6">
                                    <h6 class="m-b-20"><span></span></h6>
                                    
                                    
                                </div> -->
                            </div>
                            <div class="row" id="items">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="table" width="100%" class="table invoice-detail-table">
                                            <thead>
                                                <tr class="thead-default">
                                                    <th>#</th>
                                                    <th class="kiri">PRODUCT CODE</th>
                                                    <th class="kiri">PRODUCT</th>
                                                    <th class="kanan">QUANTITY</th>
                                                    <th class="kanan">STOK</th>
                                                    <th class="kanan">AMOUNT</th>
                                                    <th class="kanan">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php 
                                                    $tot_qty = 0;
                                                    $tot_stok = 0;
                                                    $tot_mount = 0;
                                                    $tot_total = 0;
                                                @endphp
                                                @foreach($data->mutasis as $key => $dt)
                                                @php 
                                                    $tot_qty+= $dt->jumlah;
                                                    $tot_stok+= $dt->balance;
                                                    $tot_mount+= $dt->product->price;
                                                    $tot_total+= (int)($dt->product->price* $dt->jumlah);
                                                @endphp
                                                <tr>
                                                    <td>{{$key+1}}.</td>
                                                    <td class="kiri">
                                                        <p class="m-0">{{$dt->product->product_code}} </p>
                                                    </td>
                                                    <td class="kiri">
                                                        <p class="m-0">{{ucwords($dt->product->product_name)}} </p>
                                                    </td>
                                                    <td class="kanan">{{$dt->jumlah}} {{$dt->product->satuan->satuan}}</td>
                                                    <td class="kanan">{{$dt->balance}} {{$dt->product->satuan->satuan}}</td>
                                                    <td class="kanan">{{number_format($dt->product->price,0,',','.')}} / {{$dt->product->satuan->satuan}}</td>
                                                    <td class="kanan">{{number_format($dt->product->price * $dt->jumlah,0,',','.')}}</td>
                                                </tr>
                                                @endforeach
                                                @if(count($data->mutasis) > 0)
                                                <tr>
                                                    <th  class="kiri" colspan="3">Total</th>
                                                    <th class="kanan">{{$tot_qty}}</th>
                                                    <th class="kanan">{{$tot_stok}}</th>
                                                    <th class="kanan">{{number_format($tot_mount,0,',','.')}}</th>
                                                    <th class="kanan">{{number_format($tot_total,0,',','.')}}</th>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-12 kanan">
                                    <table class="table table-responsive invoice-table invoice-total ">
                                        <tbody>
                                            <tr>
                                                <th>Sub Total :</th>
                                                <td>$4725.00</td>
                                            </tr>
                                            <tr>
                                                <th>Taxes (10%) :</th>
                                                <td>$57.00</td>
                                            </tr>
                                            <tr>
                                                <th>Discount (5%) :</th>
                                                <td>$45.00</td>
                                            </tr>
                                            <tr class="text-info">
                                                <td>
                                                    <hr />
                                                    <h5 class="text-primary m-r-10">Total :</h5>
                                                </td>
                                                <td>
                                                    <hr />
                                                    <h5 class="text-primary">$ 4827.00</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-sm-12">
                                    <h6>Terms and Condition :</h6>
                                    <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                    </p>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-12 invoice-btn-group text-center">
                            <button type="button" @click="getPrint" class="btn waves-effect waves-light btn-primary btn-print-invoice m-b-10">Print</button>
                            <a href="javascript:history.back()" type="button" class="btn waves-effect waves-light btn-secondary m-b-10 ">BACK</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Invoice ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection
@push('js')
@include('components.vuejs')
<script src="{{asset('assets/js/vue-html-to-paper.js')}}" type="text/javascript"></script>
<script>
    let basePath= '{{config('app.url')}}';
    const options = {
        name: '_blank',
        specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes',
        ],
        styles: [
            `${basePath}/assets/css/myPrint.css`,
        ],
        timeout: 1000, // default timeout before the print window appears
        autoClose: true, // if false, the window will not close after printing

    }
    Vue.use(VueHtmlToPaper,options);
    var invoice = new Vue({
        el:"#invoice",
        data:{
            printing:false
        },
        methods:{
            async getPrint(){
                this.printing = true;
                document.getElementById("table").setAttribute("border", "1px solid #000000");
                document.getElementById("table").setAttribute("style", "border-collapse: collapse;");
                const myWindow = await this.$htmlToPaper('printTable', () => {
                    this.printing = false;
                    document.getElementById("table").removeAttribute("border");
                    document.getElementById("table").removeAttribute("style");
                });
                document.getElementById("table").removeAttribute("border");
                document.getElementById("table").removeAttribute("style");
            },

        }
    });
</script>
@endpush
