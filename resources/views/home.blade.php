@extends('layouts.panel')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- seo analytics start -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>{{$in}}</h3>
                        <p class="text-muted">Product In</p>
                        <div id="seo-anlytics1"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>{{$out}}</h3>
                        <p class="text-muted">Product Out</p>
                        <div id="seo-anlytics2"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>{{$stok}}</h3>
                        <p class="text-muted">Stok</p>
                        <div id="seo-anlytics3"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>{{$opname}}</h3>
                        <p class="text-muted">Opname Approved</p>
                        <div id="seo-anlytics4"></div>
                    </div>
                </div>
            </div>
            <!-- seo analytics end -->
            <!-- Latest Order start -->
            <div class="col-xl-12" id="dash">
                <div class="card">
                    <div class="card-header">
                        <h5>Chart Product In & Out</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart-highchart-bar1" :data-grafik="grafik" style="width: 100%; height: 450px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>
@endsection
@push('js')
<script src="{{asset('assets/js/plugins/highcharts.js')}}"></script>

@include('components.vuejs')
<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var dash = new Vue({
        el:"#dash",
        data:{
            grafik:[],
        },
        mounted(){
            this.load()
        },
        methods:{
            load(){
                this.loading = true
				const url = "<?php echo route('grafik-api');?>";
                this.$http.get(url).then(function(response) {
                    // console.log(JSON.stringify(response.data));
                    this.getChart(response.data)
                });
            },
            getChart(data){
                this.grafik = data
                Highcharts.chart('chart-highchart-bar1', {
                    chart: {
                        type: 'column'
                    },
                    colors: ['#4680ff', '#000000','#9ccc65'],
                    title: {
                        text: 'Chart Product In & Out'
                    },
                    subtitle: {
                        text: 'Inventory Restoman'
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Product'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: this.grafik
                });
            }
        }
    });
</script>
<!-- <script src="{{asset('assets/js/plugins/highcharts-3d.js')}}"></script> -->
<!-- <script src="{{asset('assets/js/pages/chart-highchart-custom.js')}}"></script> -->
@endpush