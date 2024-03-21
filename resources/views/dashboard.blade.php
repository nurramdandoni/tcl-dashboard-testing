<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

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
                <h6 class="m-0 font-weight-bold text-primary">Temperature History</h6>
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
                <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
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
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
</div>
<!-- /.container-fluid -->
<script>
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
        // Panggil AJAX di sini
        $.ajax({
            url: '/dataBar',
            type: 'POST',
            dataType: 'json',
            data:{
                tanggal:formattedDate+'%',
                client_id:'1',
                _token: $('meta[name="csrf-token"]').attr('content') // Menyertakan token CSRF
            },
            success: function(response) {
                var list_time = [];
                var list_temp = [];
                var batas_atas_thresh = response[0].client.batas_atas;
                var batas_bawah_thresh = response[0].client.batas_bawah;
                // console.log(response[0]);
                $.each(response, function(key, val){
                    // console.log(val.created_at);
                    var tempTime = val.created_at;
                    var spliting = tempTime.split('T');
                    var substring = spliting[1];
                    var timeData = substring.substring(0,5);
                    list_time.push(timeData);
                    list_temp.push(val.temperature_data);
                })
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

                var status_ok =0;
                var status_lower=0;
                var status_higher =0;
                var persentase_ok = 0
                
                $.each(response, function(key2, val2){
                    // console.log(val2.client.batas_atas);
                    // console.log(val2.temperature_data);
                    if(val2.temperature_data < val2.client.batas_atas){
                        status_higher++;
                    }else if(val2.temperature_data > val2.client.batas_bawah){
                        status_lower++;
                    }else{
                        status_ok++
                    }
                });
                console.log("total data : ",response.length);
                persentase_ok = (status_ok/response.length)*100;
                console.log("presentase ok : ",persentase_ok);
                var warna = [];
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
                        console.log("Data Value: " + dataValue);
                    }
                    }
                },
                });

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });



</script>
@endsection
