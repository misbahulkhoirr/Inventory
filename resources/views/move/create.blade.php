@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
<style>
    td {
        vertical-align: middle !important;
    }
    td.dua{
        padding-top: 1.72rem;
        padding-right: 0.75rem;
        padding-bottom: 1.72rem;
        padding-left: 0.75rem;
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
                            <h5 class="m-b-10">Transfer Stok</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Form</a></li>
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
                                <div class="row mb-1">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Tanggal') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <input type="date"
                                            class="form-control"
                                            v-model="tanggal">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Dari Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <select class="form-control" v-model="selectGudangDari" @change="getProductGudangDari()">
                                            <option value="">Pilih</option>
                                            <option v-for="gd in gudangs" :key="gd.id" :value="gd.id">@{{gd.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Ke Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <select class="form-control" v-model="selectGudangKe" @change="getProductGudangKe()">
                                            <option value="">Pilih</option>
                                            <option v-for="gd in gudangs" :key="gd.id" :value="gd.id">@{{gd.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dt-responsive table-responsive">
                            <table width="100%">
                                <tr>
                                    <td v-show="selectGudangDari > 0" width="45%">
                                        <table  id="fix-header" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th colspan="4"><span>@{{labelGudang(selectGudangDari)}}</span></th>
                                                </tr>
                                                <tr>
                                                    <th width="10px">#</th>
                                                    <th>Nama Product</th>
                                                    <th>Stok</th>
                                                    <th width="250px">Jumlah Transfer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in products" :key="index">
                                                    <td>@{{index+1}}.</td>
                                                    <td>@{{item.product_name}}</td>
                                                    <td>@{{item.saldo}} @{{item.satuan}}</td>
                                                    <td>
                                                        <div class="input-group pull-right">
                                                            <input type="number" class="form-control" v-model="item.jumlah" placeholder=". . . . . ." aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">@{{item.satuan}}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr v-show="products.length < 1">
                                                    <td colspan="4" align="center"> Barang Kosong</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td v-show="selectGudangKe > 0 && selectGudangDari !== selectGudangKe" width="10%" align="center">
                                    <button v-if="loading" class="btn btn-sm btn-success"
                                                type="button" disabled>
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </button>
                                        <button v-else class="btn btn-success" @click="transfer()">Transfer <i class="feather icon-fast-forward"></i> </button>
                                    </td>
                                    <td v-show="selectGudangKe > 0 && selectGudangDari !== selectGudangKe" width="45%">
                                        <table id="fix-header" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th colspan="3"><span>@{{labelGudang(selectGudangKe)}}</span></th>
                                                </tr>
                                                <tr>
                                                    <th width="10px">#</th>
                                                    <th>Nama Product</th>
                                                    <th>Stok</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(items,index) in productss" :key="index">
                                                    <td class="dua">@{{index+1}}.</td>
                                                    <td class="dua">@{{items.product_name}}</td>
                                                    <td class="dua">@{{items.saldo}} @{{items.satuan}}</td>
                                                </tr>
                                                <tr v-show="productss.length < 1">
                                                    <td colspan="4" align="center"> Barang Kosong</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
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
<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var in_form = new Vue({
        el:"#in_form",
        data:{
            tanggal:moment(new Date()).format('YYYY-MM-DD'),
            selectGudangDari:'',
            selectGudangKe:'',
            products:[],
            productss:[],
            loading:false,
            gudangs:[],
			msg:[]
        },
        mounted(){
            this.load()
        },
        methods:{
            labelGudang(ids){
                const gudang = this.gudangs.find(({
                    id
                }) => id === ids);
                return gudang ? gudang.name : '';
            },
            load(){
                this.loading = true
				const url = "<?php echo route('gudang.api');?>";
                this.$http.get(url).then(function(response) {
                    this.loading = false
                    this.gudangs = response.data.gudangs
                });
            },
            getProductGudangDari(){
                this.loading = true
				const url = "<?php echo route('product-gudang.api');?>";
                this.$http.post(url,{gudang_id:this.selectGudangDari, page: 'transfer'}).then(function(response) {
                    this.loading = false
                    this.products = response.data
                    this.products.forEach((value,index ) => {
                        this.products[index].jumlah = '';
                    });
                    console.log('PP = ' + JSON.stringify(this.products));
                });
            },
            getProductGudangKe(){
                this.loading = true
				const url = "<?php echo route('product-gudang.api');?>";
                this.$http.post(url,{gudang_id:this.selectGudangKe, page: 'transfer'}).then(function(response) {
                    // console.log('PP = ' + JSON.stringify(response.data));
                    this.loading = false
                    this.productss = response.data
                });
            },
            transfer(){
                this.loading = true
				const url = "<?php echo route('transfer.store');?>";
                const request = {
                    tanggal: this.tanggal,
                    product:this.products,
                    gudang_dari: this.selectGudangDari,
                    gudang_ke: this.selectGudangKe
                }
                this.$http.post(url,request).then(function(response) {
                    console.log(JSON.stringify(response.data));
                    this.loading = false
                    Swal.fire({
                        position: 'top',
                        icon: response.data.icon,
                        title: response.data.title,
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    if (response.data.code === 200) {
                        this.getProductGudangDari()
                        this.getProductGudangKe()
                    }
                });
            },
            toRupiah(nominal) {
                var nominal = parseFloat(nominal).toFixed(0);
                const format = nominal.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                return rupiah;
            },
        }
    });
</script>
<script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-select-custom.js')}}"></script>
@endpush