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
                            <h5 class="m-b-10">Edit Opname</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit Opname</a></li>
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

                                    <div class="col-md-6">
                                        <input type="date"
                                            class="form-control"
                                            v-model="tanggal">
                                    </div>
                                </div>
                                
                                
                                <div class="row">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <span class="form-control">{{$datas->gudang->name}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Petugas Gudang') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <vue-multiselect v-model="selectPetugas" :multiple="true" :options="petugases" :close-on-select="false" :clear-on-select="false" placeholder="Pilih Petugas" label="name" value="id" track-by="name"></vue-multiselect>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Status') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6 mt-2">
                                    <div class="badge @if($datas->status == 'New') badge-primary @elseif($datas->status == 'Approved') badge-success @else badge-danger @endif badge-pill">{{$datas->status}}</div>
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
                                        <td>@{{item.DetailProduct.product_name}}</td>
                                        <td>@{{item.DetailProduct.satuan.satuan}}</td>
                                        <td>@{{item.seharusnya}}</td>
                                        <td>
                                            <div class="input-group pull-right">
                                                <input type="number" class="form-control" v-model="fisik[index]" placeholder=". . . . . ." aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">@{{item.DetailProduct.satuan.satuan}}</span>
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
                        <div class="row">
                            <div v-show="products.length > 0" class="col-md-12">
                            <button v-if="loadingUpdate" class="btn  btn-primary m-2" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Loading...
                            </button> 
                            <button v-else @click="update()" type="button" class="btn btn-primary btn-round has-ripple"><i class="feather icon-save"></i> UPDATE<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
                                @if(auth()->user()->role_id == 1)
                                <div class="float-right mb-2">
                                    <button v-if="loadingRejected" class="btn  btn-danger m-2" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                        Loading...
                                    </button>
                                    <button v-else type="button" @click="reject()" class="btn btn-danger btn-round has-ripple"><i class="feather icon-x-circle"></i> REJECT<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
                                    <button v-if="loadingApproved" class="btn  btn-success m-2" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                        Loading...
                                    </button>
                                    <button v-else type="button"  @click="approved()" class="btn btn-success btn-round has-ripple"><i class="feather icon-check-square"></i> APPROVE<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> 
                                </div>
                                @endif
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
            tanggal:"{{$datas->tanggal}}",
            selectGudang:"{{$datas->gudang_id}}",
            selectPetugas:[],
            petugases:[],
            products:[],
            loading:false,
            loadingApproved:false,
            loadingUpdate:false,
            loadingRejected:false,
            fisik:[],
            selisih:[],
            gudangs:[],
            diubah:false,
            keterangan:[],
			msg:[]
        },
        mounted(){
            this.load()
            this.loadPetugas()
        },
        watch: {
            fisik(value){
                this.diubah = true
                this.products.forEach((values,index ) => {
                    this.selisih[index] = parseInt(value[index]) - parseInt(this.products[index].seharusnya);
                });
            },
            keterangan(value){
                this.diubah = true
            },
            tanggal(value){
                this.diubah = true
            },

		},
        methods:{
            updatePetugas(){
                this.diubah = true
            },
            loadPetugas(){
                const url = "<?php echo route('opname.petugas',$datas->id);?>";
                this.$http.get(url).then(function(response) {
                    this.selectPetugas = response.data
                });
            },
            load(){
                this.loading = true
				const url = "<?php echo route('gudang.api');?>";
                this.$http.get(url).then(function(response) {
                    this.loading = false
                    this.gudangs = response.data.gudangs
                    this.petugases = response.data.petugas
                    this.getProduct()
                });
            },
            getProduct(){
                this.loading = true
				const url = "<?php echo route('opname.api',$datas->id);?>";
                this.$http.post(url,{gudang_id:this.selectGudang}).then(function(response) {
                    this.loading = false
                    this.products = response.data.DetailOpname
                    this.products.forEach((value,index ) => {
                        this.fisik[index] = value.fisik;
                        this.selisih[index] = value.selisih;
                        this.keterangan[index] = value.keterangan;
                    });
                });
            },
            update(){
                this.loadingUpdate = true
				const url = "<?php echo route('opname.update',$datas->id);?>";
                const request = {
                    tanggal: this.tanggal,
                    petugas: this.selectPetugas,
                    gudang: this.selectGudang,
                    fisik: this.fisik,
                    product:this.products,
                    keterangan: this.keterangan
                }
                this.$http.post(url,request).then(function(response) {
                    console.log(JSON.stringify(response.data));
                    this.loadingUpdate = false
                    Swal.fire(
                        response.data.title,
                        response.data.message,
                        response.data.icon
                    )
                    this.diubah = false
                    var authId = "{{auth()->user()->role_id}}"
                    if (authId == 2) {
                        setInterval(() => {
                            window.location.href = "{{route('opname.index')}}";
                        }, 1000);
                    }
                });
            },
            reject(){
                this.loadingRejected = true
				const url = "<?php echo route('opname.reject',$datas->id);?>";
                this.$http.get(url).then(function(response) {
                    console.log(JSON.stringify(response.data));
                    this.loadingRejected = false
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
            approved(){
                if (this.diubah) {
                    Swal.fire(
                        'Opps',
                        'Data telah di ubah, silahkan klik Update dahulu',
                        'error'
                    )
                    return false
                }
                this.loadingApproved = true
				const url = "<?php echo route('opname.approved',$datas->id);?>";
                const request = {
                    tanggal: this.tanggal,
                    petugas: this.selectPetugas,
                    gudang: this.selectGudang,
                    fisik: this.fisik,
                    product:this.products,
                    keterangan: this.keterangan
                }
                this.$http.post(url,request).then(function(response) {
                    console.log(JSON.stringify(response.data));
                    this.loadingApproved = false
                    Swal.fire(
                        response.data.title,
                        response.data.message,
                        response.data.icon
                    )
                    this.diubah = false
                    if (response.data.code === 200) {
                        setInterval(() => {
                            window.location.href = "{{route('opname.index')}}";
                        }, 1000);
                    }
                });
                // this.$http.get(url).then(function(response) {
                //     console.log(JSON.stringify(response.data));
                //     this.loadingApproved = false
                //     Swal.fire(
                //         response.data.title,
                //         response.data.message,
                //         response.data.icon
                //     )
                //     if (response.data.code === 200) {
                //         setInterval(() => {
                //             window.location.href = "{{route('opname.index')}}";
                //         }, 1000);
                //     }
                // });
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