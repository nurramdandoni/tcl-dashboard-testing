<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">
<style>
    .center-text {
    position: absolute;
    top: 55%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 200;
    font-size:15px;
}
</style>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Summary Data</h1>
<p class="mb-4">Berikut adalah Data History dan Status Chamber pada Client Tertentu pada Tanggal yang dipilih.</p>
<!-- <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in this theme.
    The charts below have been customized - for further customization options, please visit the <a
        target="_blank" href="https://www.chartjs.org/docs/latest/">official Chart.js
        documentation</a>.</p> -->

<!-- Content Row -->
<div class="row">

    <div class="col-xl-8 col-lg-7">

        <!-- Area Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Temperature History
                <select id="pilihTgl" class="form-select" aria-label="Default select example">
                    <option selected>Pilih Tanggal</option>
                    <option value="2024-03-21">2024-03-21</option>
                    <option value="2024-03-20">2024-03-20</option>
                    <option value="2024-03-19">2024-03-19</option>
                </select>
                <select id="pilihChamber" class="form-select" aria-label="Default select example">
                    <option selected>Pilih Chamber</option>
                    <option value="1">Chamber 1</option>
                    <option value="2">Chamber 2</option>
                    <option value="3">Chamber 3</option>
                </select>
                <select id="pilihClient" class="form-select" aria-label="Default select example">
                    <option selected>Pilih Client</option>
                    <option value="1">Client 1</option>
                    <option value="2">Client 2</option>
                    <option value="3">Client 3</option>
                </select>
                <button id="showDynamic">Lihat</button>
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
                <hr>
                Data berdasarkan pada Tanggal 25/04/2024 yang Memuat history dalam interval waktu 5 menit.
                <!-- Styling for the area chart can be found in the
                <code>/js/demo/chart-area-demo.js</code> file. -->
            </div>
        </div>

        <!-- Bar Chart -->
        <!-- <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                </div>
                <hr>
                Styling for the bar chart can be found in the
                <code>/js/demo/chart-bar-demo.js</code> file.
            </div>
        </div> -->

    </div>

    <!-- Donut Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Chamber Status</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 ct">
                    <canvas id="myPieChart"></canvas>
                    <span id="presentase" class="center-text">%</span>
                </div>
                <hr>
                Data dan Warna Berdasarkan Total Status 'OK' pada semua chamber
                <br>
                Hijau = OK > 96%
                <br>
                Merah = OK < 96%
                <!-- Styling for the donut chart can be found in the
                <code>/js/demo/chart-pie-demo.js</code> file. -->
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-5">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel History Data Client ::: <span id="cln"></span></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">ID Chamber</th>
                                            <th>Nama Chamber</th>
                                            <th style="text-align:center;">Temperature</th>
                                            <th style="text-align:center;">Batas Atas</th>
                                            <th style="text-align:center;">Batas Bawah</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="text-align:center;">ID Chamber</th>
                                            <th>Nama Chamber</th>
                                            <th style="text-align:center;">Temperature</th>
                                            <th style="text-align:center;">Batas Atas</th>
                                            <th style="text-align:center;">Batas Bawah</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="dtTabel">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    </div>

</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
</div>
<!-- /.container-fluid -->
<script>
    var status_ok_data =[];
    var status_lower_data=[];
    var status_higher_data =[];

    var batas_atas_thresh = 0;
    var batas_bawah_thresh = 0;
    $(document).ready(function() {
        // Buat objek tanggal baru
        var today = new Date();

        
        // Dapatkan tahun, bulan, dan tanggal
        var year = today.getFullYear();
        var month = ('0' + (today.getMonth() + 1)).slice(-2); // Tambahkan 1 karena bulan dimulai dari 0
        var day = ('0' + today.getDate()).slice(-2);
        
        // Gabungkan tahun, bulan, dan tanggal dengan format yang diinginkan
        var formattedDate = year + '-' + month + '-' + day;
        
        console.log(formattedDate)
        $("#pilihTgl").val(formattedDate);
        $("#pilihChamber").val(1);
        $("#pilihClient").val(1);
        $("#showDynamic").click();

        
        // // Panggil AJAX di sini
        // $.ajax({
        //     url: '/dataBar',
        //     type: 'POST',
        //     dataType: 'json',
        //     data:{
        //         tanggal:formattedDate+'%',
        //         chamber_id:'1',
        //         client_id:'1',
        //         _token: $('meta[name="csrf-token"]').attr('content') // Menyertakan token CSRF
        //     },
        //     success: function(response) {
        //         var tbl ='';
        //         var list_time = [];
        //         var list_temp = [];
        //         var batas_atas_thresh = 0;
        //         var batas_bawah_thresh = 0;
        //         if(response.length > 0){
        //             batas_atas_thresh = response[0].client.batas_atas;
        //             batas_bawah_thresh = response[0].client.batas_bawah;
        //             $("#cln").text(response[0].client.nama_client);

        //         }
        //         // console.log(response[0]);
        //         $.each(response, function(key, val){

        //             tbl +=`<tr>
        //                         <td style="text-align:center;">`+val.chamber.id_chamber+`</td>
        //                         <td>`+val.chamber.nama_chamber+`</td>
        //                         <td style="text-align:center;">`+val.temperature_data+`°C</td>
        //                         <td style="text-align:center;">`+val.client.batas_atas+`°C</td>
        //                         <td style="text-align:center;">`+val.client.batas_bawah+`°C</td>
        //                     </tr>`;
        //             // console.log(val.created_at);
        //             var tempTime = val.created_at;
        //             var spliting = tempTime.split('T');
        //             var substring = spliting[1];
        //             var timeData = substring.substring(0,5);
        //             list_time.push(timeData);
        //             list_temp.push(val.temperature_data);
        //         })
        //         $("#dtTabel").html(tbl);
                
        //         console.log(list_time);
        //         console.log(list_temp);
        //         // Tambahkan logika untuk menangani data dari response AJAX di sini
        //         // Area Chart Example
        //         var ctx = document.getElementById("myAreaChart");
        //         var myLineChart = new Chart(ctx, {
        //         type: 'line',
        //         data: {
        //             // labels: ["10:05", "10:10", "10:15", "10:20", "10:25", "10:30", "10:35", "10:35", "10:40", "10:45", "10:50", "10:55"],
        //             labels: list_time,
        //             datasets: [{
        //             label: "Temperature",
        //             lineTension: 0.3,
        //             backgroundColor: "rgba(78, 115, 223, 0.05)",
        //             borderColor: "rgba(78, 115, 223, 1)",
        //             pointRadius: 3,
        //             pointBackgroundColor: "rgba(78, 115, 223, 1)",
        //             pointBorderColor: "rgba(78, 115, 223, 1)",
        //             pointHoverRadius: 3,
        //             pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        //             pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        //             pointHitRadius: 10,
        //             pointBorderWidth: 2,
        //             // data: [-19, -12, -23, -20, -18, -15, -15, -16, -40, -25, -27, -55],
        //             data: list_temp,
        //             }],
        //         },
        //         options: {
        //             maintainAspectRatio: false,
        //             layout: {
        //             padding: {
        //                 left: 10,
        //                 right: 25,
        //                 top: 25,
        //                 bottom: 0
        //             }
        //             },
        //             scales: {
        //             xAxes: [{
        //                 time: {
        //                 unit: 'date'
        //                 },
        //                 gridLines: {
        //                 display: false,
        //                 drawBorder: false
        //                 },
        //                 ticks: {
        //                 maxTicksLimit: 7
        //                 }
        //             }],
        //             yAxes: [{
        //                 ticks: {
        //                 maxTicksLimit: 5,
        //                 padding: 10,
        //                 // Include a dollar sign in the ticks
        //                 callback: function(value, index, values) {
        //                     return value;
        //                 }
        //                 },
        //                 gridLines: {
        //                 color: "rgb(234, 236, 244)",
        //                 zeroLineColor: "rgb(234, 236, 244)",
        //                 drawBorder: false,
        //                 borderDash: [2],
        //                 zeroLineBorderDash: [2]
        //                 }
        //             }],
        //             },
        //             legend: {
        //             display: false
        //             },
        //             tooltips: {
        //             backgroundColor: "rgb(255,255,255)",
        //             bodyFontColor: "#858796",
        //             titleMarginBottom: 10,
        //             titleFontColor: '#6e707e',
        //             titleFontSize: 14,
        //             borderColor: '#dddfeb',
        //             borderWidth: 1,
        //             xPadding: 15,
        //             yPadding: 15,
        //             displayColors: false,
        //             intersect: false,
        //             mode: 'index',
        //             caretPadding: 10,
        //             callbacks: {
        //                 label: function(tooltipItem, chart) {
        //                 var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
        //                 return datasetLabel + ': ' + tooltipItem.yLabel+' °C';
        //                 }
        //             }
        //             },
        //             // options lainnya...
        //             annotation: {
        //                 annotations: [{
        //                     type: 'line',
        //                     mode: 'horizontal',
        //                     scaleID: 'y-axis-0',
        //                     value: batas_atas_thresh,
        //                     borderColor: 'red',
        //                     borderWidth: 2,
        //                     label: {
        //                         enabled: true,
        //                         content: ' Max. '+batas_atas_thresh+'°C'
        //                     }
        //                 }, {
        //                     type: 'line',
        //                     mode: 'horizontal',
        //                     scaleID: 'y-axis-0',
        //                     value: batas_bawah_thresh,
        //                     borderColor: 'green',
        //                     borderWidth: 2,
        //                     label: {
        //                         enabled: true,
        //                         content: 'Min. '+batas_bawah_thresh+'°C'
        //                     }
        //                 }]
        //             }
        //         }
        //         });

        //         var status_ok =0;
        //         var status_lower=0;
        //         var status_higher =0;
        //         var persentase_ok = 0
                
        //         $.each(response, function(key2, val2){
        //             // console.log(val2.client.batas_atas);
        //             // console.log(val2.temperature_data);
        //             if(val2.temperature_data < val2.client.batas_atas){
        //                 status_higher++;
        //             }else if(val2.temperature_data > val2.client.batas_bawah){
        //                 status_lower++;
        //             }else{
        //                 status_ok++
        //             }
        //         });
        //         console.log("total data : ",response.length);
        //         persentase_ok = (status_ok/response.length)*100;
        //         console.log("presentase ok : ",persentase_ok);
        //         var warna = [];
        //         $("#presentase").text(persentase_ok.toFixed(2)+'%');
        //         if(persentase_ok > 96){
        //             var warna = ['#59df4e', '#59df4e', '#59df4e'];
        //         }else{
        //             var warna = ['#f21111', '#f21111', '#f21111'];
        //         }
        //         var list_status = ["OK","HIGHER","LOWER"];
        //         var list_data = [status_ok,status_higher,status_lower];
        //         // Pie Chart Example
        //         var ctx = document.getElementById("myPieChart");
        //         var myPieChart = new Chart(ctx, {
        //         type: 'doughnut',
        //         data: {
        //             // labels: ["Direct", "Referral", "Social"],
        //             labels: list_status,
        //             datasets: [{
        //             // data: [55, 30, 15],
        //             data: list_data,
        //             // backgroundColor: ['#59df4e', '#59df4e', '#59df4e'],
        //             backgroundColor: warna,
        //             hoverBackgroundColor: ['#59df4e', '#f21111', '#4e73df'],
        //             hoverBorderColor: "rgba(234, 236, 244, 1)",
        //             }],
        //         },
        //         options: {
        //             maintainAspectRatio: false,
        //             tooltips: {
        //             backgroundColor: "rgb(255,255,255)",
        //             bodyFontColor: "#858796",
        //             borderColor: '#dddfeb',
        //             borderWidth: 1,
        //             xPadding: 15,
        //             yPadding: 15,
        //             displayColors: false,
        //             caretPadding: 10,
        //             },
        //             legend: {
        //             display: false
        //             },
        //             // cutoutPercentage: 80,
        //             onClick: function(event, elements) {
        //             // Ambil elemen yang diklik
        //             var clickedElement = this.getElementAtEvent(event);

        //             // Jika ada elemen yang diklik
        //             if (clickedElement.length > 0) {
        //                 // Ambil indeks elemen yang diklik
        //                 var dataIndex = clickedElement[0]._index;

        //                 // Ambil data sesuai dengan indeks
        //                 var dataLabel = this.data.labels[dataIndex];
        //                 var dataValue = this.data.datasets[0].data[dataIndex];

        //                 // Tampilkan data
        //                 console.log("Data Label: " + dataLabel);
        //                 console.log("Data Value: " + dataValue);
        //                 }
        //             },
        //         },
        //         });

        //     },
        //     error: function(xhr, status, error) {
        //         console.error(xhr.responseText);
        //     }
        // });

    });
    
    
    
$("#showDynamic").click(function(){
    // $("#myAreaChart").clear();
    console.log("hallo");
    var tgl = $("#pilihTgl").val();
    var cham = $("#pilihChamber").val();
    var cln = $("#pilihClient").val();
    // Panggil AJAX di sini
    $.ajax({
        url: '/dataBar',
        type: 'POST',
        dataType: 'json',
        data:{
            tanggal:tgl+'%',
            chamber_id:cham,
            client_id:cln,
            _token: $('meta[name="csrf-token"]').attr('content') // Menyertakan token CSRF
        },
        success: function(response) {
            var tbl ='';
            var list_time = [];
            var list_temp = [];
            
            if(response.length > 0){
                batas_atas_thresh = response[0].client.batas_atas;
                batas_bawah_thresh = response[0].client.batas_bawah;
                $("#cln").text(response[0].client.nama_client);

            }
            // console.log(response[0]);
            $.each(response, function(key, val){

                tbl +=`<tr>
                            <td style="text-align:center;">`+val.chamber.id_chamber+`</td>
                            <td>`+val.chamber.nama_chamber+`</td>
                            <td style="text-align:center;">`+val.temperature_data+`°C</td>
                            <td style="text-align:center;">`+val.client.batas_atas+`°C</td>
                            <td style="text-align:center;">`+val.client.batas_bawah+`°C</td>
                        </tr>`;
                // console.log(val.created_at);
                var tempTime = val.created_at;
                var spliting = tempTime.split('T');
                var substring = spliting[1];
                var timeData = substring.substring(0,5);
                list_time.push(timeData);
                list_temp.push(val.temperature_data);
            })
            $("#dtTabel").html(tbl);
            
            console.log(list_time);
            console.log(list_temp);
            // Tambahkan logika untuk menangani data dari response AJAX di sini
            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                // labels: ["10:05", "10:10", "10:15", "10:20", "10:25", "10:30", "10:35", "10:35", "10:40", "10:45", "10:50", "10:55"],
                labels: list_time,
                datasets: [{
                label: "Temperature",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                // data: [-19, -12, -23, -20, -18, -15, -15, -16, -40, -25, -27, -55],
                data: list_temp,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false,
                    drawBorder: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return value;
                    }
                    },
                    gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                    }
                }],
                },
                legend: {
                display: false
                },
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel+' °C';
                    }
                }
                },
                // options lainnya...
                annotation: {
                    annotations: [{
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: batas_atas_thresh,
                        borderColor: 'red',
                        borderWidth: 2,
                        label: {
                            enabled: true,
                            content: ' Max. '+batas_atas_thresh+'°C'
                        }
                    }, {
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: batas_bawah_thresh,
                        borderColor: 'green',
                        borderWidth: 2,
                        label: {
                            enabled: true,
                            content: 'Min. '+batas_bawah_thresh+'°C'
                        }
                    }]
                }
            }
            });
            myLineChart.update();

            var status_ok =0;
            var status_lower=0;
            var status_higher =0;
            var persentase_ok = 0
            
            $.each(response, function(key2, val2){
                // console.log(val2.client.batas_atas);
                // console.log(val2.temperature_data);
                if(val2.temperature_data < val2.client.batas_atas){
                    status_higher++;
                    status_higher_data.push(val2);
                }else if(val2.temperature_data > val2.client.batas_bawah){
                    status_lower++;
                    status_lower_data.push(val2);
                }else{
                    status_ok++
                    status_ok_data.push(val2);
                }
            });
            console.log("total data : ",response.length);
            persentase_ok = (status_ok/response.length)*100;
            console.log("presentase ok : ",persentase_ok);
            var warna = [];
            $("#presentase").text('OK : '+persentase_ok.toFixed(2)+'%');
            if(persentase_ok > 96){
                var warna = ['#59df4e', '#59df4e', '#59df4e'];
            }else{
                var warna = ['#f21111', '#f21111', '#f21111'];
            }
            var list_status = ["OK","HIGHER","LOWER"];
            var list_data = [status_ok,status_higher,status_lower];
            // Pie Chart Example
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                // labels: ["Direct", "Referral", "Social"],
                labels: list_status,
                datasets: [{
                // data: [55, 30, 15],
                data: list_data,
                // backgroundColor: ['#59df4e', '#59df4e', '#59df4e'],
                backgroundColor: warna,
                hoverBackgroundColor: ['#59df4e', '#f21111', '#4e73df'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                // cutoutPercentage: 80,
                onClick: function(event, elements) {
                // Ambil elemen yang diklik
                var clickedElement = this.getElementAtEvent(event);

                // Jika ada elemen yang diklik
                if (clickedElement.length > 0) {
                    // Ambil indeks elemen yang diklik
                    var dataIndex = clickedElement[0]._index;

                    // Ambil data sesuai dengan indeks
                    var dataLabel = this.data.labels[dataIndex];
                    var dataValue = this.data.datasets[0].data[dataIndex];

                    // Tampilkan data
                    console.log("Data Label: " + dataLabel);
                    $("#DetailChamberModal").modal('show');
                    console.log("Data Value: " + dataValue);
                        if(dataLabel == "OK"){
                            console.log(status_ok_data);
                            $("#categoryChamber").text("OK");
                            infoChamber("OK");
                        }else if(dataLabel == "HIGHER"){
                            console.log(status_higher_data);
                            $("#categoryChamber").text("HIGHER");
                            infoChamber("HIGHER");
                        }else if(dataLabel == "LOWER"){
                            console.log(status_lower_data);
                            $("#categoryChamber").text("LOWER");
                            infoChamber("LOWER");
                        }
                    }
                },
            },
            });
            myPieChart.update();

        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

function infoChamber(id){
    var tempDataChamber = [];
    var idDataChamber = [];
    console.log(id);
    console.log(batas_atas_thresh);
    console.log(batas_bawah_thresh);
    var dataObjectInfo;
    if(id == "OK"){
        dataObjectInfo = status_ok_data;
    }else if(id == "HIGHER"){
        dataObjectInfo = status_higher_data;
    }else if(id == "LOWER"){
        dataObjectInfo = status_lower_data;
    }
    console.log(dataObjectInfo);
    $.each(dataObjectInfo, function(key3, val3){
        console.log(val3);
        idDataChamber.push(val3.created_at)
        tempDataChamber.push(val3.temperature_data)
    });
    console.log(tempDataChamber);
    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        // labels: ["January", "February", "March", "April", "May", "June"],
        labels: idDataChamber,
        datasets: [{
        label: "Temperature",
        backgroundColor: "#4e73df",
        hoverBackgroundColor: "#2e59d9",
        borderColor: "#4e73df",
        // data: [4215, 5312, 6251, 7841, 9821, 14984],
        data: tempDataChamber,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
        padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
        }
        },
        scales: {
        xAxes: [{
            // time: {
            // unit: 'month'
            // },
            gridLines: {
            display: false,
            drawBorder: false
            },
            ticks: {
            maxTicksLimit: 6
            },
            maxBarThickness: 25,
        }],
        yAxes: [{
            ticks: {
            min: -30,
            max: 0,
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
                return value;
            }
            },
            gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
            }
        }],
        },
        legend: {
        display: false
        },
        tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
            label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': ' +tooltipItem.yLabel+'°C';
            }
        }
        },
    }
    });
    myBarChart.update()
}
</script>
@endsection
