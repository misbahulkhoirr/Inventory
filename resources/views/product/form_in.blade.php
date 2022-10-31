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
<section class="pcoded-main-container" id="in_form">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Form Product @{{type}}</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Form Product @{{type}}</a></li>
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
                <div class="card select-card">
                    <div class="card-body">
                        <form>
                        <div class="float-right mb-2">
                            <a href="{{route('product-'.strtolower($type).'.index',$type)}}"><button type="button" class="btn btn-danger btn-round has-ripple"><i class="feather icon-skip-back"></i> BACK<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button></a> 
                            <button type="button" @click="save()" class="btn btn-success btn-round has-ripple"><i class="feather icon-save"></i> SAVE<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button> 
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama Product</th>
										<th>Satuan</th>
                                        <th>Harga/Satuan</th>
                                        <th>Gudang</th>
                                        <th v-if="type === 'Out'">Stok</th>
                                        <th width="250px">Jumlah</th>
                                        <th v-if="type === 'Out'">Sisa</th>
                                        <th v-if="type === 'In'">Supplier</th>
                                        
                                        <th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
                                    <tr v-for="(item,index) in products" :key="index">
                                        <td>@{{index+1}}.</td>
                                        <td>@{{item.product_name}}</td>
                                        <td>@{{item.satuan}}</td>
                                        <td>@{{toRupiah(item.price)}}</td>
                                        <td>
                                            <select v-model="gudang[index]" id="" class="form-control" @change="selectGudang(gudang[index],item.id,index)">
                                                <option value="">Pilih</option>
                                                <option v-for="gd in gudangs" :value="gd.id">@{{gd.name}}</option>
                                            </select>
                                        </td>
                                        <td v-if="type === 'Out'"><span v-if="stok[index] > 0">@{{stok[index]}} @{{item.satuan}}</span><span v-else>-</span></td>
                                        <td>
                                            <div class="input-group pull-right">
                                                <input type="number" class="form-control" v-model="jumlah[index]" placeholder=". . . . . ." aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">@{{item.satuan}}</span>
                                            </div>
                                        </td>
                                        <td v-if="type === 'Out'"><span v-if="sisa[index] > 0">@{{sisa[index]}} @{{item.satuan}}</span><span v-else-if="sisa[index] === 0">@{{sisa[index]}}</span><span v-else class="text-danger">@{{sisa[index]}}</span></td>
                                        <td v-if="type === 'In'">
                                            <select v-model="supplier[index]" id="" class="form-control">
                                                <option value="">Pilih</option>
                                                <option v-for="spr in suppliers" :value="spr.id">@{{spr.name}}</option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <textarea v-model="keterangan[index]" class="form-control" cols="30" rows="1" placeholder="Keterangan"></textarea>
                                        </td>
                                    </tr>
								</tbody>
                            </table>
                        </div>
                        </form>
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
            products:[],
            loading:false,
            jumlah:[],
            supplier:[],
            keterangan:[],
            gudang:[],
            suppliers:[],
            gudangs:[],
            saldos:[],
            stok:[],
            sisa:[],
			msg:[],
            type:"{{$type}}"
        },
        mounted(){
            this.load()
        },
        watch: {
            jumlah(value){
                this.products.forEach((values,index ) => {
                    this.sisa[index] = this.stok[index] - value[index];
                });
            },
		},
        methods:{
            selectGudang(gudangId, productId, index){
                if (gudangId === '' || gudangId === null) {
                    this.stok[index] = 0;
                    this.sisa[index] = this.stok[index] - this.jumlah[index];
                    return
                }
                const cariGudang = this.saldos.filter(data => {
                    return data.gudang_id.toString().indexOf(gudangId) > -1 && data.product_id.toString().indexOf(productId) > -1
                })
                if (cariGudang.length > 0) {
                    this.stok[index] = cariGudang[0].saldo
                }else{
                    this.stok[index] = 0
                }
                this.sisa[index] = this.stok[index] - this.jumlah[index];
            },
            toRupiah(nominal) {
                var nominal = parseFloat(nominal).toFixed(0);
                const format = nominal.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                return rupiah;
            },

            load(){
                this.loading = true
				const url = "<?php echo route('product.api');?>";
                this.$http.get(url).then(function(response) {
                    // console.log(JSON.stringify(response.data));
                    this.loading = false
                    this.suppliers = response.data.suppliers
                    this.gudangs = response.data.gudangs
                    this.products = response.data.products
                    this.saldos = response.data.saldos
                    this.products.forEach((value,index ) => {
                        this.jumlah.push('');
                        this.supplier.push('');
                        this.keterangan.push('');
                        this.gudang.push('');
                        this.stok.push(0);
                        this.sisa.push(0);
                    });
                });
            },
            save(){
                this.loading = true
				const url = "<?php echo route('product.store',$type);?>";
                const request = {
                    product: this.products,
                    supplier: this.type === 'Out' ? [] : this.supplier,
                    gudang: this.gudang,
                    jumlah: this.jumlah,
                    keterangan: this.keterangan
                }
                this.$http.post(url,request).then(function(response) {
                    this.loading = false
                    Swal.fire(
                        response.data.title,
                        response.data.message,
                        response.data.icon
                    )
                    if (response.data.code === 200) {
                        setTimeout(() => {
                            window.location.href = "{{route('product-'.strtolower($type).'.index',$type)}}";
                        }, 1000);
                    }
                });
            },
        }
    });
</script>
<script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-select-custom.js')}}"></script>
@endpush