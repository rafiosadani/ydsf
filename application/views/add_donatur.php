<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('partials/head') ?>
  <script src="https://cdn.jsdelivr.net/npm/table-to-json@0.13.0/lib/jquery.tabletojson.min.js" integrity="sha256-AqDz23QC5g2yyhRaZcEGhMMZwQnp8fC6sCZpf+e7pnw=" crossorigin="anonymous"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view('partials/header') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('partials/sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Add Donatur
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('data/donatur') ?>">Data Donatur</a></li>
          <li class="active">Donatur Baru</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <form class="form-horizontal" action="<?php echo base_url("donatur/addDonatur") ?>" method="post">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li>
                  <li class="pull-right"><input type="submit" name="btnsave" class="btn btn-md btn-info" style="margin-right: 10px" value="Simpan" /></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="container-fluid">
                      <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-info" role="alert">
                          <?php echo $this->session->flashdata('success'); ?>
                        </div>
                      <?php endif; ?>
                      <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger" role="alert">
                          <?php echo $this->session->flashdata('error'); ?>
                        </div>
                      <?php endif; ?>
                    </div>

                    <div class="box-body">
                      <div class="form-group">


                        <div class="col-sm-5">
                          <label for="status" class="control-label">Status<span style="color: red"> *</span></label>
                          <select class="form-control selectpicker" name="status" data-live-search="true" required>
                            <option name="status" value="A">Aktif</option>
                            <option name="status" value="P">Pasif</option>
                          </select>
                        </div>

                        <div class="col-sm-5">
                          <label for="ketpasif" class="control-label">Ket pasif</label>
                          <select class="form-control selectpicker" name="ketpasif" data-live-search="true">
                            <option name="ketpasif" value=""></option>
                            <?php foreach($ket_ap as $ket) : ?>
                              <option name="ketpasif" value="<?php echo $ket->KETPASIF ?>"><?php echo $ket->NM_KETAP ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="kwsn" class="control-label">Kawasan<span style="color: red"> *</span></label>
                          <input type="text" class="form-control" name="kwsn" id="kwsn" placeholder="input kawasan"
                          required pattern=".{6,6}" title="kode kawasan harus 6 digit">
                        </div>

                        <div class="col-sm-5">
                          <label for="nama" class="control-label">Nama<span style="color: red"> *</span></label>
                          <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                          required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <table style="empty-cells: hide;">
                            <tr>
                              <td class="td-ajax" id="td" style="padding-right: 180px"></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="gender" class="control-label">Gender</label>
                          <select class="form-control selectpicker" name="gender" data-live-search="true">
                            <option name="gender" value="-"> - </option>
                            <option name="gender" value="L">Laki-laki</option>
                            <option name="gender" value="P">Perempuan</option>
                          </select>
                        </div>

                        <div class="col-sm-5">
                          <label for="tmplahir" class="control-label">Tempat Lahir</label>
                          <input type="text" class="form-control" name="tmplahir" id="tmplahir" placeholder="Tempat Lahir">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="tgllahir" class="control-label">Tanggal Lahir</label>
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="tgllahir" class="form-control pull-right" id="tgllahir" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                          </div> 
                        </div>

                        <div class="col-sm-5">
                          <label for="alamatktr" class="control-label">Alamat Tagih<span style="color: red"> *</span></label>
                          <input type="text" class="form-control" name="alamatktr" id="alamatktr" placeholder="Alamat tagih" required>
                        </div>


                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="alamat" class="control-label">Alamat Rumah</label>
                          <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat tagih">

                        </div> 
                      </div><div style="background-color: #f0ff91">
                        <hr>

                        <div class="form-group">
                          <div class="col-sm-5">
                            <table id="prog" style="empty-cells: hide;">
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="program" class="control-label" style="padding-left:5px">Program<span style="color: red"> *</span></label>
                            <select id="nama_program" class="form-control selectpicker" name="program" data-live-search="true" required>
                              <?php foreach($program as $program) : ?>  
                                <option  name="program" value="<?php echo $program->PROG ?>"><?php echo $program->NM_PROGRAM ?></option>
                              <?php endforeach; ?>
                            </select>

                          </div>
                          <div class="col-sm-5">
                            <label for="nominal" class="control-label" style="padding-left:5px">Nominal<span style="color: red"> *</span></label>
                            <input id="nominal" type="number" class="form-control" name="nominal" id="nominal" placeholder="Input nominal" min="0" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="ket" class="control-label" style="padding-left:5px">Keterangan</label>
                            <input id="ket" type="text" class="form-control" name="ket" id="ket" placeholder="keterangan" value="-">
                          </div><br>
                          <div class="col-sm-5" style="margin-top: 10px">
                            <!-- <input id="btnprog" type="submit" name="btnprog" class="btn btn-md btn-info pull-right" value="Add program" /> -->
                            <button id="btnprog" type="button" class="btn btn-md btn-info pull-right">Add Program</button>
                            <!-- <button id="btncoba" type="button">Test KK</button> -->
                          </div>
                        </div>

                        <hr></div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="tlprmh" class="control-label">Tlp Rumah</label>
                            <input type="text" class="form-control" name="tlprmh" id="tlprmh" placeholder="input telp rumah" value=" ">
                          </div>
                          <div class="col-sm-5">
                            <label for="tlpktr" class="control-label">Tlp Kantor</label>
                            <input type="text" class="form-control" name="tlpktr" id="tlpktr" placeholder="input telp kantor " value=" ">
                          </div>


                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="faxktr" class="control-label">Fax kantor</label>
                            <input type="text" class="form-control" name="faxktr" id="faxktr" placeholder="input fax kantor" value=" ">
                          </div>
                          <div class="col-sm-5">
                            <label for="tlphp" class="control-label">Handphone<span style="color: red"> *</span></label>
                            <input type="text" class="form-control" name="tlphp" id="tlphp" placeholder="input no handphone" min="0" required>
                          </div>

                        </div>
                        <div class="form-group">

                          <div class="col-sm-5">
                            <label for="tlphp2" class="control-label">Handphone 2</label>
                            <input type="text" class="form-control" name="tlphp2" id="tlphp2" placeholder="input no handphone 2"
                            value=" ">
                          </div>
                          <div class="col-sm-5">
                            <label for="tlphp3" class="control-label">Handphone 3</label>
                            <input type="text" class="form-control" name="tlphp3" id="tlphp3" placeholder="input no handphone 3"
                            value=" ">
                          </div>


                        </div>

                        <div class="form-group"><div class="col-sm-5">
                          <label for="jupen" class="control-label">Jupen<span style="color: red"> *</span></label>
                          <select class="form-control selectpicker" name="jupen" data-live-search="true" required id="jupen">
                            <?php foreach($jungut as $kodej) : ?>  
                              <option name="program" value="<?php echo $kodej->KODEJ ?>"><?php echo $kodej->KODEJ." - ".$kodej->NAMA ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                    <!-- </form> -->

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    <div class="box-body">
                      <div class="form-group">


                        <div class="col-sm-5">
                          <label for="email" class="control-label">Email</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="input email">
                        </div>

                        <div class="col-sm-5">
                          <label for="crbyr" class="control-label">Cara bayar</label>
                          <select class="form-control selectpicker" name="crbyr" data-live-search="true">
                            <option name="crbyr" value=""> - </option>  
                            <?php foreach($carabayar as $byr) : ?>  
                              <option name="crbyr" value="<?php echo $byr->CARABYR ?>"><?php echo $byr->NM_BAYAR ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="rekdonatur" class="control-label">Rekening Donatur</label>
                          <input type="text" name="rekdonatur" class="form-control pull-right" id="rekdonatur" placeholder="input no rekening">
                        </div>

                        <div class="col-sm-5">
                          <label for="bank" class="control-label">Bank</label>
                          <input type="text" class="form-control" name="bank" id="bank" placeholder="input bank">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="kolektif" class="control-label">Kolektif</label>
                          <input type="text" class="form-control" name="kolektif" id="kolektif" placeholder="input" >
                        </div>

                        <div class="col-sm-5">
                          <label for="waktu_tagih" class="control-label">Waktu Tagih</label>
                          <select class="form-control selectpicker" name="waktu_tagih" data-live-search="true">
                            <option name="waktu_tagih" value=""> - </option>    
                            <?php foreach($waktu_tagih as $tgh) : ?>  
                              <option name="waktu_tagih" value="<?php echo $tgh->waktu_tagih ?>"><?php echo $tgh->NM_tagih ?></option>
                            <?php endforeach; ?>
                          </select>                    </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="npwp" class="control-label">Npwp</label>
                            <input type="text" class="form-control" name="npwp" id="npwp" placeholder="input" >
                          </div> 
                        </div>
                      </div>

                      <!-- /.box-body -->

                      <!-- /.box-footer -->
                      <!-- </form> -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                      <div class="box-body">
                        <div class="form-group">


                          <div class="col-sm-5">
                            <label for="info" class="control-label">info</label>
                            <select class="form-control selectpicker" name="info" data-live-search="true">
                              <option name="info" value=""> - </option>  
                            </select>
                          </div>

                          <div class="col-sm-5">
                            <label for="pekerjaan" class="control-label">Pekerjaan</label>
                            <select class="form-control selectpicker" name="pekerjaan" data-live-search="true">
                              <?php foreach($kerja as $kerja) : ?>  
                                <option name="kerja" value="<?php echo $kerja->PEKERJAAN ?>"><?php echo $kerja->NM_PEKERJAAN ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="jabatan" class="control-label">Jabatan</label>
                            <select class="form-control selectpicker" name="jabatan" data-live-search="true">
                              <?php foreach($jabatan as $jabatan) : ?>  
                                <option name="jabatan" value="<?php echo $jabatan->jabatan ?>"><?php echo $jabatan->nm_jabatan ?></option>
                              <?php endforeach; ?>
                            </select>                    </div>

                            <div class="col-sm-5">
                              <label for="hobby" class="control-label">Hobi</label>
                              <select class="form-control selectpicker" name="hobby" data-live-search="true">
                                <?php foreach($hobi as $hobi) : ?>  
                                  <option name="hobby" value="<?php echo $hobi->hobby ?>"><?php echo $hobi->nm_hobby ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-5">
                              <label for="pendidikan" class="control-label">Pendidikan</label>
                              <select class="form-control selectpicker" name="pendidikan" data-live-search="true">
                                <?php foreach($pend as $pend) : ?>  
                                  <option name="hobi" value="<?php echo $pend->PENDIDIKAN ?>"><?php echo $pend->NM_pendidikan ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="col-sm-5">
                              <label for="gaji" class="control-label">Gaji</label>
                              <select class="form-control selectpicker" name="gaji" data-live-search="true">
                                <?php foreach($gaji as $gaji) : ?>  
                                  <option name="hobi" value="<?php echo $gaji->GAJI ?>"><?php echo $gaji->GOL_GAJI ?></option>
                                <?php endforeach; ?>
                              </select>                    </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-5">
                                <label for="rk" class="control-label">Jenis Donatur<span style="color: red"> *</span></label>
                                <select class="form-control selectpicker" name="rk" data-live-search="true" required>  
                                  <option name="rk" value="R">Perorangan (R)</option>
                                  <option name="rk" value="K">Instansi (K)</option>
                                </select>
                              </div>
                            </div>
                            <input type="hidden" name="donaturItem" id="donaturIt" value="">
                          </div>

                          <!-- /.box-body -->

                          <!-- /.box-footer -->
                        </form>
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div>

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

         
      </body>
      <?php $this->load->view('partials/js') ?>
      <script>
        $(document).ready(function(){
            $("#kwsn").autocomplete({
              source: "<?php echo base_url('donatur/getAutoComplete');?>",
              select: function (event, ui) {
                    $('[name="kwsn"]').val(ui.item.label); 
                    // $('[name="description"]').val(ui.item.description); 
                }
            });
        });
    </script>
      
<!-- <script>
  $(function () {
    $('#example1').DataTable()
  })
</script> -->
<script src="https://github.com/douglascrockford/JSON-js/blob/master/json2.js"></script>
<script>
  $(function () {
       //Date picker
       $('#tgllahir').datepicker({
        format : 'dd-mm-yyyy',
        autoclose: true
      });
       $('#tgllahir').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
     })
   </script>
   <script>
    $(document).ready(function() {
      var donaturItem = new Array();
      // $("#btncoba").click(function() {
      //   var item =$("#donaturIt").val();
      //   alert(item);
      // });
      $('#kwsn').focusout(function() {
        var kwsn = $(this).val();
        // alert(kwsn);
        var cont = '';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getKwsn') ?>',
          data  : {kwsn : kwsn},
          async : true,
          dataType : 'json',
          success : function(data){
            cont = data.nm_kawasan;
              // alert(cont);
              $(".td-ajax").html(cont);
              $("#alamatktr").val(data.alamat);
              $("#alamat").val(data.alamat);
              $('#jupen').selectpicker("val", data.kodejgt);
              $('.selectpicker').selectpicker('refresh');
            }
          });
      });
      $("#btnprog").click(function(){
        var name    = $("#nama_program").children('option:selected').text();
        var prog    = $("#nama_program").children('option:selected').val();
        var nominal = $("#nominal").val();

        var cont = '<tr data-prog="'+prog+'" data-nominal="'+nominal+'"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+name+'</td>'+
        '<td class="di-nominal" style="padding-right: 20px">'+convertToRupiah(nominal)+'</td>'+
        '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+prog+'" data-nominal="'+nominal+'"> Ubah </button></td>'+
        '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';
        $("#prog").append(cont);
        save();
      });
      function convertToRupiah(angka)
      {
        var rupiah = '';    
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
          return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      }
      // $('button#btn-del').click(function() {

      // });
    });
    $(document).on('click', 'button#btn-del', function () {
     $(this).closest('tr').remove();
     // return false;
     save();
   });
    $(document).on('click', 'button#btn-edit', function () {
      var _this = $(this).closest('tr');
      var prog = $(this).attr('data-program');
      var nominal = $(this).attr('data-nominal');
      $("#modal-program").val(prog);
      $("#modal-nominal").val(nominal);
      $('.selectpicker').selectpicker('refresh');
      $(document).on('click', '#btn-edit2', function() {
        var new_prog = $(".modal-body #modal-program").children('option:selected').val();
        var new_nominal = $(".modal-body #modal-nominal").val();
        var new_prog_name = $(".modal-body #modal-program").children('option:selected').text();
        var cont = '<tr data-prog="'+new_prog+'" data-nominal="'+new_nominal+'"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+new_prog_name+'</td>'+
        '<td class="di-nominal" style="padding-right: 20px">Rp. '+new_nominal+'</td>'+
        '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+new_prog+'" data-nominal="'+new_nominal+'"> Ubah </button></td>'+
        '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';
        _this.replaceWith(cont);
        save();
        // alert(new_prog);
      });
    });
    function save() {
      donaturItem = [];
      var data = [];
      $("table#prog").find('tr').each(function(index, el) {
        var nominal = $(this).attr('data-nominal');
        var prog = $(this).attr('data-prog');
          // alert(prog);
          // data = [];
          var array = [prog , nominal];
          data.push(array);
        });
        // donaturItem = [];
        // donaturItem.push(data);
        // alert(JSON.stringify(donaturItem));
        $("#donaturIt").val(JSON.stringify(data));
        console.log($('#donaturIt').val());
      }


    </script>
    </html>