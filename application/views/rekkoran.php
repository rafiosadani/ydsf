<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="flashdata" data-flashdata="<?php echo $this->session->flashdata('flash')?>"></div>
  <div class="flashdata2" data-flashdata2="<?php echo $this->session->flashdata('flash2')?>"></div>
  <div class="flashdata3" data-flashdata3="<?php echo $this->session->flashdata('flash3')?>"></div>
  <div class="wrapper">

    <?php $this->load->view('partials/header') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('partials/sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Upload Rek Koran
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Upload Rek Koran</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Upload</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body" style="height: 450px"> 
              <div class="form-group">
                <div class="col-sm-12">
                  <label for="file" class="control-label">Pilih File <span style="color: red">( .csv ) yang di pilih harus file ( .csv )</span></label>
                </div>
                <div class="col-sm-6">
                  <form action="<?php echo base_url('front-office/rek-koran') ?>" id="form" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="nama_file" id="nm_file" value="">
                  <input type="file" id="file" name="berkas" style="display:none;">
                  <?php
                  if($this->input->post('nama_file')){?>
                    <input class="form-control" type="text" value="<?php echo $this->input->post('nama_file'); ?>" id="filename" readonly onclick="document.getElementById('file').click()">
                  <?php } else { ?>
                    <input class="form-control" type="text" id="filename" readonly onclick="document.getElementById('file').click()">                        
                  <?php } ?>
                </div>
                <div class="col-sm-2">
                  <input type="button" class="btn btn-block btn-success" value="Browse" onclick="document.getElementById('file').click()">
                </div>
                </form>
                <div class="col-sm-12" style="margin-top:10px;">
                  <span style="color:black;"><b>Contoh isi file ( .csv )  pemisahnya adalah koma ( , )</b></span>
                </div>
                  <div class="col-sm-12">
                    <div class="col-sm-12" style="border: 1px solid #A0A0A0; padding-top: 2px; padding-bottom: 2px;">
                      <span style="margin-left: -14px;">2019-08-09,2019-08-09,Yayasan Dana Sosial Al Falah,1500000,1000000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( tgl_bank,tgl_very,uraian,debit,kredit )</span><br>
                      <span style="margin-left: -14px;">2019-08-09,2019-08-09,Yayasan Dana Sosial Al Falah,1250000,1350000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( tgl_bank,tgl_very,uraian,debit,kredit )</span>
                    </div>
                  </div>
                <form action="<?= base_url('rekkoran/insert'); ?>" method="post">
                <div class="col-sm-12">
                  <?php if ($this->input->post('nama_file')) : ?>
                      <textarea style="margin-top: 10px; float: left;width: 100%;outline: none;resize: none;" name="isi" id="" cols="150" rows="10"><?php 
                        $lines = file(base_url('import/import_rekkoran.csv')); 
                        foreach ($lines as $line){
                          echo $line;
                        } ?></textarea>
                  <?php else : ?>
                    <textarea style="margin-top: 10px; float: left;width: 100%;outline: none;resize: none;" name="isi" id="" cols="150" rows="10">
                    </textarea>
                  <?php endif ?>
                </div>
                <div class="col-sm-5" style="margin-top: 10px;"> 
                  <label for="bank" class="control-label">Bank<span style="color: red"> *</span></label>
                  <select class="form-control selectpicker" name="bank" id="bank" data-live-search="true">
                    <?php foreach ($bank as $value) : ?>
                      <option value="<?php echo $value->BANK; ?>"><?php echo $value->BANK. ' - ' .$value->NM_BANK; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-5" style="margin-top: 10px;">
                  <label for="program" class="control-label">Program <span style="color: red;">*</span></label>
                  <select class="form-control selectpicker" name="program" id="program" data-live-search="true">
                    <?php foreach ($program as $value) : ?>
                      <option value="<?= $value->PROG; ?>"><?= $value->PROG.' - '.$value->NM_PROGRAM;  ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                 <div class="col-sm-2" style="margin-top: 14px;">
                  <label for=""></label>
                  <input type="submit" class="btn btn-block btn-primary" value="Import">
                </div> 
                </form>  
              </div>
            </div>
          </div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row (main row) -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view('partials/footer') ?>


  </div>
  <!-- ./wrapper -->
  <?php $this->load->view('partials/modal') ?>
  <?php $this->load->view('partials/js') ?>
<script>
const flashdata = $('.flashdata').data('flashdata');
const flashdata2 = $('.flashdata2').data('flashdata2');
const flashdata3 = $('.flashdata3').data('flashdata3');

if(flashdata){
    Swal.fire({
        title: 'Import',
        text: 'Berhasil ' + flashdata,
        type: 'success'
    });
}

if(flashdata2){
    Swal.fire({
        title: 'Kesalahan',
        text: 'Pilih file terlebih dahulu untuk ' + flashdata4 + ' Data',
        type: 'error'
    });
}

if(flashdata3){
    Swal.fire({
        title: 'Kesalahan',
        text: 'File yang dipilih harus ' + flashdata3,
        type: 'error'
    });
}
</script>
<script>
    // var nama_file = $("#filename").val();
    // $("#nm_file").val(nama_file);
    document.getElementById("file").onchange = function() {
    document.getElementById("nm_file").value=this.value;
    document.getElementById("form").submit();
};
</script>
</body>
</html>