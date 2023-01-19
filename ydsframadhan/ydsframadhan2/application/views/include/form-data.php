
<script src="<?= base_url() ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
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
                <h3 class="text-themecolor m-b-0 m-t-0"><?= $forpage['namahalaman']?></h3>
                <!--ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol-->
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
                    <div class="card-block">
                        
                        <?= ($this->session->flashdata('info') != null) ? '<div class="alert alert-success text-center">' . $this->session->flashdata('info') . '</div>' : ''; ?>
                        <?= ($this->session->flashdata('error') != null) ? '<div class="alert alert-danger text-center">' . $this->session->flashdata('error') . '</div>' : ''; ?>
                        <?= $this->formbuilder->open_form(array('action' => $forpage['post-controller'], 'class' => 'form-horizontal', 'method' => 'post','target'=>'_blank')); ?>
                        <?php //print_r($datavalue); ?>
                        <?= $this->formbuilder->build_form_horizontal($formdata, $datavalue); ?>

                        <?= $this->formbuilder->close_form(); ?>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
</div>
<link href="<?= base_url() ?>assets/css/datepicker.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
    <?php if(isset($customjs)) echo $customjs;?>
//
//    $('#tglsurat').datepicker({
//        format: 'yyyy-mm-dd',
//        autoclose: true,
//        setDate: new Date(),
//    });
//    $('#tglsuratmasuk').datepicker({
//        format: 'yyyy-mm-dd',
//        autoclose: true,
//        setDate: new Date(),
//    });
//    $('input[type="file"]').change(function () {
//        var filename = this.value.match(/[^\\\/]+$/, '')[0];
//        $('#filescan').val(filename);
//    });
//    CKEDITOR.replace('perihal');
</script>