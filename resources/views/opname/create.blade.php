@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
<style>
    td {
        vertical-align: middle !important;
    }
</style>
<script src="{{asset('assets/vue/vue-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/vue/vue-multiselect.min.css')}}">
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
                            <h5 class="m-b-10">Form Opname</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Form Opname</a></li>
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
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <select class="form-control" v-model="selectGudang" @change="getProduct()">
                                            <option value="">Pilih</option>
                                            <option v-for="gd in gudangs" :key="gd.id" :value="gd.id">@{{gd.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Petugas Gudang') }} <span class="float-right">:</span></label>
                                    <div class="col-md-6">
                                        <vue-multiselect v-model="selectPetugas" :multiple="true" :options="petugases" :close-on-select="true" :clear-on-select="false" placeholder="Pilih Petugas" label="name" value="id" track-by="name"></vue-multiselect>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-show="products.length > 0" class="dt-responsive table-responsive">
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
                                    <tr v-for="(item,index) in products" :key="index">
                                        <td>@{{index+1}}.</td>
                                        <td>@{{item.product_name}}</td>
                                        <td>@{{item.satuan}}</td>
                                        <td>@{{item.saldo}}</td>
                                        <td>
                                            <div class="input-group pull-right">
                                                <input type="number" class="form-control" v-model="fisik[index]" placeholder=". . . . . ." aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">@{{item.satuan}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span>@{{isNaN(selisih[index]) ? '##':selisih[index]}}</span>
                                        </td>
                                        <td>
                                        <textarea v-model="keterangan[index]" class="form-control" cols="30" rows="1" placeholder="Keterangan"></textarea>
                                        </td>
                                    </tr>
								</tbody>
                            </table>
                        </div>
                        <div v-show="products.length > 0" class="col-md-12">
                            <div class="float-right mb-2">
                                <a href="{{route('opname.index')}}"><button type="button" class="btn btn-danger btn-round has-ripple"><i class="feather icon-skip-back"></i> BACK<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button></a> 
                                <button type="button" @click="save()" class="btn btn-success btn-round has-ripple"><i class="feather icon-save"></i> SAVE<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> 
                            </div>
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
@include('components.vuejs')
<script>
    Vue.component('vue-multiselect', window.VueMultiselect.default)
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var in_form = new Vue({
        el:"#in_form",
        data:{
            tanggal:moment(new Date()).format('YYYY-MM-DD'),
            selectGudang:'',
            selectPetugas:[],
            petugases:[],
            products:[],
            loading:false,
            fisik:[],
            selisih:[],
            gudangs:[],
            keterangan:[],
			msg:[]
        },
        mounted(){
            this.load()
        },
        watch: {
            fisik(value){
                this.products.forEach((values,index ) => {
                    this.selisih[index] = parseInt(value[index]) - parseInt(this.products[index].saldo);
                });
            },
		},
        methods:{
            load(){
                this.loading = true
				const url = "<?php echo route('gudang.api');?>";
                this.$http.get(url).then(function(response) {
                    this.loading = false
                    this.gudangs = response.data.gudangs
                    this.petugases = response.data.petugas
                });
            },
            getProduct(){
                this.loading = true
				const url = "<?php echo route('product-gudang.api');?>";
                this.$http.post(url,{gudang_id:this.selectGudang, page: 'opname'}).then(function(response) {
                    // console.log('PP = ' + JSON.stringify(response.data));
                    this.loading = false
                    this.products = response.data
                    this.products.forEach((value,index ) => {
                        this.fisik.push('');
                        this.selisih.push('0');
                        this.keterangan.push('');
                    });
                });
            },
            save(){
                this.loading = true
				const url = "<?php echo route('opname.store');?>";
                const request = {
                    tanggal: this.tanggal,
                    petugas: this.selectPetugas,
                    gudang: this.selectGudang,
                    fisik: this.fisik,
                    product:this.products,
                    keterangan:this.keterangan,
                }
                this.$http.post(url,request).then(function(response) {
                    // console.log(JSON.stringify(response.data));
                    this.loading = false
                    Swal.fire(
                        response.data.title,
                        response.data.message,
                        response.data.icon
                    )
                    if (response.data.code === 200) {
                        setInterval(() => {
                            window.location.href = "{{route('opname.index')}}";
                        }, 1000);
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
<!-- <style src="vue-multiselect/dist/vue-multiselect.min.css"></style> -->
<script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-select-custom.js')}}"></script>
@endpush