// 'use strict';
// $(document).ready(function() {
//     // [ besic-bar-chart ] start
//     setTimeout(function() {
//        var datas = document.getElementsById("chart-highchart-bar1");
//        var grafik = datas[0].getAttribute('data-grafik');
//        console.log('grafik = ' + JSON.stringify(grafik));
//         Highcharts.chart('chart-highchart-bar1', {
//             chart: {
//                 type: 'column'
//             },
//             colors: ['#4680ff', '#000000'],
//             title: {
//                 text: 'Chart Product In & Out'
//             },
//             subtitle: {
//                 text: 'Inventory Restoman'
//             },
//             xAxis: {
//                 categories: [
//                     'Jan',
//                     'Feb',
//                     'Mar',
//                     'Apr',
//                     'May',
//                     'Jun',
//                     'Jul',
//                     'Aug',
//                     'Sep',
//                     'Oct',
//                     'Nov',
//                     'Dec'
//                 ],
//                 crosshair: true
//             },
//             yAxis: {
//                 min: 0,
//                 title: {
//                     text: 'Jumlah Product'
//                 }
//             },
//             tooltip: {
//                 headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//                 pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
//                     '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
//                 footerFormat: '</table>',
//                 shared: true,
//                 useHTML: true
//             },
//             plotOptions: {
//                 column: {
//                     pointPadding: 0.2,
//                     borderWidth: 0
//                 }
//             },
//             series: [{
//                 name: 'Produtc In',
//                 data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

//             }, {
//                 name: 'Product Out',
//                 data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
//             }]
//         });
//     }, 700);
//     // [ Column, line & pie-chart ] end
// });
