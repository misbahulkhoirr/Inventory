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
                                        <th width="250px">Jumlah *</th>
                                        <th v-if="type === 'Out'">Sisa</th>                                        
                                        <th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
                                    <tr v-for="(item,index) in products" :key="index">
                                        <td>@{{index+1}}.</td>
                                        <td>@{{item.product_name}}</td>
                                        <td>@{{item.satuan}}</td>
                                        <td>@{{toRupiah(item.price)}}</td>
                                        <td>@{{item.GudangProduct.name}}</td>
                                        <td>@{{item.saldo}}</td>
                                        <td>
                                            <div class="input-group pull-right">
                                                <input type="number" class="form-control" v-model="jumlah[index]" placeholder=". . . . . ." aria-label="Jumlah peoduct" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">@{{item.satuan}}</span>
                                            </div>
                                        </td>
                                        <td><span :class="sisa[index] < 0 ? 'text-danger':''">@{{sisa[index]}}</span></td>
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
                    this.sisa[index] = values.saldo - value[index];
                });
            },
		},
        methods:{
            toRupiah(nominal) {
                var nominal = parseFloat(nominal).toFixed(0);
                const format = nominal.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                return rupiah;
            },

            load(){
                this.loading = true
				const url = "<?php echo route('product-gudang2.api');?>";
                this.$http.get(url).then(function(response) {
                    console.log(JSON.stringify(response.data));
                    this.loading = false
                    this.products = response.data.products
                    this.products.forEach((value,index ) => {
                        this.jumlah.push('');
                        this.keterangan.push('');
                        this.sisa.push(0);
                    });
                });
            },
            save(){
                this.loading = true
				const url = "<?php echo route('product.store2',$type);?>";
                const request = {
                    product: this.products,
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