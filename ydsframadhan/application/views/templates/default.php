<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/logo.png" type="image/png">
        <title>YDSF</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
        <!--plugin-->
        <link href="<?= base_url() ?>assets/plugins/materialdesign/css/materialdesignicons.css" rel="stylesheet">
        
        <!-- You can change the theme colors from here -->
        <link href="<?= base_url() ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
        <link href="<?= base_url() ?>assets/css/custom.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
            <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
            <script src="<?= base_url() ?>assets/plugins/highcharts/highcharts.js"></script>
            <script src="<?= base_url() ?>assets/plugins/highcharts/modules/exporting.js"></script>
            <script src="<?= base_url() ?>assets/plugins/highcharts/modules/export-data.js"></script>
    </head>

    <body class="fix-header fix-sidebar card-no-border">
        
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        
            
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div-->
    
        
	<div id="main-wrapper">	
        <?php $this->load->view('include/header');?>
        <?php $this->load->view('include/sidebar');?>
            
        <?= $body;?>
        <?php $this->load->view('include/footer');?>
        
            </div>
            <!-- ============================================================== -->
            <!-- End Wrapper -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- All Jquery -->
            <!-- ============================================================== -->
            <!-- Bootstrap tether Core JavaScript -->
            <script src="<?= base_url() ?>assets/plugins/bootstrap/js/tether.min.js"></script>
            <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
            <!-- slimscrollbar scrollbar JavaScript -->
            <script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
            <!--Wave Effects -->
            <script src="<?= base_url() ?>assets/js/waves.js"></script>
            <!--Menu sidebar -->
            <script src="<?= base_url() ?>assets/js/sidebarmenu.js"></script>
            <!--stickey kit -->
            <script src="<?= base_url() ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
            <!--Custom JavaScript -->
            <script src="<?= base_url() ?>assets/js/custom.js"></script>
            
            <!-- Chart JS -->
    </body>

</html>
