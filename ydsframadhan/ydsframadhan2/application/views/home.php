  
<?php 
$datachart='';
$totalramadhan=0;
foreach ($perprogram as $value) {
    $datachart.= "{ name:'".$value['NM_PROGRAM']."' , y :".$value['jml']."}, ";
    $totalramadhan+=$value['jml'];
}
?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Home</h3>
                <!--                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>-->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block bg-info">
                        <h4 class="text-white card-title">Selamat Datang, 
                            <b style="text-transform: capitalize; "><?= $this->session->userdata('name') ?>!</b>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block bg-success text-center">
                        <h4 class="text-white card-title">Rekap Perolehan Ramadhan 1439<br>
                            <b style="text-transform: capitalize; "><?= formatRupiah($totalramadhan)?></b>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Grafik Per Program </h3>
                        
                        <div id="chartContainer" style="height: 800px; width: 100%;"></div>
                    </div>
                    <div>
                        <hr class="m-t-0 m-b-0">
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
            <?php 
                if($this->input->post('grafikprogram')=='') $textgrafik= 'Semua Cabang';
                else $textgrafik= $a_cabang[$this->input->post('grafikprogram')];
            ?>
            <script type="text/javascript">
                Highcharts.chart('chartContainer', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Grafik Per Program Cabang <?= $textgrafik?>'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                            name: 'Brands',
                            colorByPoint: true,
                            data : [  <?= $datachart?>
                            ]
                        }]
                });
            </script>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
</div>