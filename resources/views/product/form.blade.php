@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
<style>
    td {
        vertical-align: middle !important;
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
                            <h5 class="m-b-10">Product In</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Product In</a></li>
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
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('No Transaksi') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <input type="text"
                                            class="form-control"
                                            v-model="no_trx" disabled>
                                    </div>
                                </div>
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
                                        <select class="form-control" v-model="selectGudang">
                                            <option value="">Pilih</option>
                                            <option v-for="gd in gudangs" :key="gd.id" :value="gd.id">@{{gd.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Supplier') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <select class="form-control" v-model="selectSupplier" id="">
                                            <option value="">Pilih</option>
                                            <option v-for="pt in suppliers" :value="pt.id">@{{pt.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-1">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Keterangan') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <input type="text"
                                            class="form-control"
                                            v-model="keterangan">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Kode Produk') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <div class="input-group pull-right" data-toggle="modal" data-target="#exampleModalCenter" id="basic-addon2">
                                            <input type="text" disabled v-model="selectProduct.product_code" class="form-control" placeholder=". . . . . ." aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                            <span class="input-group-text"><i class="feather icon-search"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end">{{ __('Jumlah') }} <span class="float-right">:</span></label>

                                    <div class="col-md-6">
                                        <div class="input-group pull-right" id="basic-addon3">
                                            <input type="text" v-model="jumlah" class="form-control" placeholder=". . . . . ." aria-label="Jumlah peoduct">
                                            <span class="input-group-text">@{{selectProduct.satuan ? selectProduct.satuan.satuan : '#' }}</i></span>
                                        </div>
                                        <!-- <input type="text" v-model="jumlah" class="form-control"> -->
                                    </div>
                                </div>
                                <div class="row mt-6">
                                    <label for="current_password" class="col-md-3 col-form-label text-md-end"></label>

                                    <div class="col-md-6 mt-4">
                                    <button type="button" @click="tambah()" class="btn btn-primary btn-round has-ripple" id="add-product"><i class="feather icon-plus"></i> Tambah<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> <button type="button" @click="simpan()" class="btn btn-success btn-round has-ripple" id="add-product"><i class="feather icon-save"></i> Simpan Transaksi<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalCenterTitle">List Product</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<div class="modal-body">
                                        <div class="input-group float-right pull-right mb-2 dataTables_filter">
                                            <input type="text" class="form-control form-control-sm" v-model="search"  style="max-width:200px" placeholder="Search" aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                            <!-- <span class="input-group-text" id="basic-addon2"><i class="feather icon-search"></i></span> -->
                                        </div>
                                        <div class="dt-responsive table-responsive">
                                            <table id="fix-header" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Stok Gudang</th>
                                                        <th width="5px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item,index) in filteredList" :key="index">
                                                        <td>@{{index+1}}.</td>
                                                        <td>@{{item.product_code}}</td>
                                                        <td>@{{item.product_name}}</td>
                                                        <td v-if="item.stok.length > 0">
                                                            <span v-for="(dt,i) in item.stok" :key="i">@{{dt.GudangProduct.name}} = @{{dt.saldo}} @{{item.satuan.satuan}}<br></span>
                                                        </td>
                                                        <td v-else>0 @{{item.satuan.satuan}}</td>
                                                        <td><button type="button" @click="pilihProduk(item)" class="btn btn-primary btn-round has-ripple" id="add-product"><i class="feather icon-navigation"></i> Pilih<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button></td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
									</div>
								</div>
							</div>
						</div>
                        <div class="dt-responsive table-responsive mt-4">
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th colspan="6">DAFTAR BARANG</th>
									</tr>
                                    <tr>
										<th width="10px">#</th>
										<th>Kode Produk</th>
                                        <th>Nama Produk</th>
										<th>Jumlah</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <tr v-for="(item,index) in ditambah" :key="index">
                                        <td>@{{index+1}}.</td>
                                        <td>@{{item.product.product_code}}</td>
                                        <td>@{{item.product.product_name}}</td>
                                        <td>@{{item.jumlah}} @{{item.product.satuan.satuan}}</td>
                                        <td><button type="button" @click="hapus(index)" class="btn btn-danger btn-round has-ripple" id="add-product"><i class="feather icon-delete"></i> Hapus<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button></td>
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
@include('components.vuejs')
<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var in_form = new Vue({
        el:"#in_form",
        data:{
            no_trx:'',
            tanggal:moment(new Date()).format('YYYY-MM-DD'),
            gudangs:[],
            selectGudang:'',
            suppliers:[],
            selectSupplier:'',
            
            products:[],
            selectProduct:'',
            ditambah:[],
            loading:false,
            jumlah:'',
            
            keterangan:'',
			msg:[],
            search:''
        },
        mounted(){
            this.load()
            this.loadNoTrx()
        },
        computed:{
            filteredList() {
                if (this.search) {
                    return this.products.filter(product => {
                        return product.product_code.toString().toLowerCase().indexOf(this.search.toLowerCase()) > -1 || product.product_name.toString().toLowerCase().indexOf(this.search.toLowerCase()) > -1
                    })
                } else {
                    return this.products;
                }
            },
        },
        methods:{
            loadNoTrx(){
                const url = "<?php echo route('no-trx.api',['type'=>'In']);?>";
                this.$http.get(url).then(function(response) {
                    this.no_trx = response.data.no_trx
                });
                
            },
            load(){
                this.loading = true
				const url = "<?php echo route('gudang.api');?>";
                this.$http.get(url).then(function(response) {
                    this.loading = false
                    this.gudangs = response.data.gudangs
                    this.suppliers = response.data.suppliers
                    this.products = response.data.products
                });
            },
            pilihProduk(item){
                this.selectProduct = item
                $('.modal').modal('hide');
            },
            tambah(){
                if (!this.selectProduct) {
                    alert('Kode Product harus diisi')
                    return
                }
                if (!this.jumlah || this.jumlah < 1) {
                    alert('Jumlah Harus diisi')
                    return
                }
                const index =  this.ditambah.filter(products => {
                    return products.product.id.toString().toLowerCase().indexOf(this.selectProduct.id.toString().toLowerCase()) > -1
                })
                if (index.length > 0) {
                    Swal.fire({
                        title: 'Info',
                        html: "Kode Produk <b>" + index[0].product.product_code + "</b> sudah ada, silahkan di hapus dahulu jika ingin dirubah.",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    })
                }else{
                    this.ditambah.push({
                        product:this.selectProduct,
                        jumlah:this.jumlah
                    })
                    this.kosongkan()
                }
                
            },
            kosongkan(){
                this.selectProduct = ''
                this.jumlah = ''
            },
            hapus(index){
                this.ditambah.splice(index, 1);
            },
            simpan(){
                this.loading = true
				const url = "<?php echo route('product-in.store');?>";
                const request = {
                    tanggal: this.tanggal,
                    supplier: this.selectSupplier,
                    gudang: this.selectGudang,
                    product: this.ditambah,
                    keterangan:this.keterangan,
                }
                this.$http.post(url,request).then(function(response) {
                    console.log(JSON.stringify(response.data));
                    this.loading = false
                    Swal.fire(
                        response.data.title,
                        response.data.message,
                        response.data.icon
                    )
                    if (response.data.code === 200) {
                        setInterval(() => {
                            window.location.href = "{{route('product-in.index')}}";
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
<script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-select-custom.js')}}"></script>
@endpush