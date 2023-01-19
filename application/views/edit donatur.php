<?php
$provin = substr($data->iddesa, 0,2);
$selectedKabkot = substr($data->iddesa, 0,4);
$selectedKec = substr($data->iddesa, 0,7);
$selectedKel = $data->iddesa;
?>
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
    <?php if ($this->session->userdata('admin') == TRUE): ?>
        <?php $this->load->view('partials/sidebar') ?>
    <?php endif; ?>
    <?php if ($this->session->userdata('admin') != TRUE): ?>
        <?php $this->load->view('partials/sidebar_user') ?>
    <?php endif; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Edit Donatur
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('data/donatur') ?>">Data Donatur</a></li>
          <li class="active">Edit Donatur</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <form class="form-horizontal" action="<?php echo base_url("donatur/editDonatur/").$data->autoid ?>" method="post">
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
                      <?php if ($this->session->userdata('admin') == TRUE) : ?>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="status" class="control-label">Status<span style="color: red"> *</span></label>
                            <select class="form-control selectpicker" name="status" data-live-search="true" required id="stats">
                              <option name="status" value="A">Aktif</option>
                              <option name="status" value="P">Pasif</option>
                            </select>
                          </div>
                          <div class="col-sm-5">
                            <label for="ketpasif" class="control-label">Ket pasif</label>
                            <select class="form-control selectpicker" name="ketpasif" data-live-search="true" id="ketpasif">
                              <option name="ketpasif" value=""></option>
                              <?php foreach($ket_ap as $ket) : ?>
                                <option name="ketpasif" value="<?php echo $ket->KETPASIF ?>"><?php echo $ket->NM_KETAP ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      <?php endif; ?>
                      <?php if ($this->session->userdata('admin') == TRUE) { ?>
                          <div class="form-group">
                        <div class="col-sm-5">
                          <label for="kwsn" class="control-label">Kawasan<span style="color: red"> *</span></label>
                          <input id="kwsn" type="text" class="form-control" name="kwsn" placeholder="input kawasan" value="<?php echo $data->kwsn ?>">
                        </div>

                        <div class="col-sm-5">
                          <label for="nama" class="control-label">Nama<span style="color: red"> *</span></label>
                          <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                          required value="<?php echo $data->nama ?>">
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
                          <select class="form-control selectpicker" name="gender" data-live-search="true" id="gender">
                            <option name="gender" value="-"> - </option>
                            <option name="gender" value="L">Laki-laki</option>
                            <option name="gender" value="P">Perempuan</option>
                          </select>
                        </div>

                        <div class="col-sm-5">
                          <label for="tmplahir" class="control-label">Tempat Lahir</label>
                          <input type="text" class="form-control" name="tmplahir" id="tmplahir" placeholder="Tempat Lahir" value="<?php echo $data->tmplahir ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="tgllahir" class="control-label">Tanggal Lahir</label>
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="tgllahir" class="form-control pull-right" id="tgllahir" value="<?php echo $data->tgllahir ?>" >
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <label for="alamatktr" class="control-label">Alamat Tagih<span style="color: red"> *</span></label>
                          <input type="text" class="form-control" name="alamatktr" id="alamatktr" placeholder="Alamat tagih" required value="<?php echo $data->almktr ?>">
                        </div>


                      </div>
                      <div class="form-group">

                        <div class="col-sm-5">
                          <label for="alamat" class="control-label">Alamat Rumah</label>
                          <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat rumah" value="<?php echo $data->alamat ?>">

                        </div>
                      </div>
                    <?php } ?>
                      <?php if ($this->session->userdata('admin') != TRUE) : ?>
                          <div class="form-group">
                            <div class="col-sm-5">
                              <label for="nama" class="control-label">Nama<span style="color: red"> *</span></label>
                              <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                              required value="<?php echo $data->nama ?>">
                            </div>
                            <div class="col-sm-5">
                              <label for="gender" class="control-label">Gender</label>
                              <select class="form-control selectpicker" name="gender" data-live-search="true" id="gender">
                                <option name="gender" value="-"> - </option>
                                <option name="gender" value="L">Laki-laki</option>
                                <option name="gender" value="P">Perempuan</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-5">
                              <label for="tmplahir" class="control-label">Tempat Lahir</label>
                              <input type="text" class="form-control" name="tmplahir" id="tmplahir" placeholder="Tempat Lahir" value="<?php echo $data->tmplahir ?>">
                            </div>
                            <div class="col-sm-5">
                              <label for="tgllahir" class="control-label">Tanggal Lahir</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="tgllahir" class="form-control pull-right" id="tgllahir" value="<?php echo $data->tgllahir ?>" >
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-5">
                              <label for="alamatktr" class="control-label">Alamat Tagih<span style="color: red"> *</span></label>
                              <input type="text" class="form-control" name="alamatktr" id="alamatktr" placeholder="Alamat tagih" required value="<?php echo $data->almktr ?>">
                            </div>
                            <div class="col-sm-5">
                              <label for="alamat" class="control-label">Alamat Rumah</label>
                              <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat rumah" value="<?php echo $data->alamat ?>">
                            </div>
                          </div>
                      <?php endif; ?>
                      <div style="background-color: #f0ff91">
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
                            <select id="nama_program" class="form-control selectpicker" name="program" data-live-search="true" >
                              <?php foreach($program as $program) : ?>
                                <option  name="program" value="<?php echo $program->PROG ?>"><?php echo $program->NM_PROGRAM ?></option>
                              <?php endforeach; ?>
                            </select>

                          </div>
                          <div class="col-sm-5">
                            <label for="nominal" class="control-label" style="padding-left:5px">Nominal<span style="color: red"> *</span></label>
                            <input id="nominal" type="number" class="form-control" name="nominal" id="nominal" placeholder="Input nominal" min="0">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="ket" class="control-label" style="padding-left:5px">Keterangan</label>
                            <input id="ket" type="text" class="form-control" name="ket" id="ket" placeholder="keterangan" >
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
                            <input type="text" class="form-control" name="tlprmh" id="tlprmh" placeholder="input telp rumah" value="<?php echo $data->tlprmh ?>">
                          </div>
                          <div class="col-sm-5">
                            <label for="tlpktr" class="control-label">Tlp Kantor</label>
                            <input type="text" class="form-control" name="tlpktr" id="tlpktr" placeholder="input telp kantor " value="<?php echo $data->tlpktr ?>">
                          </div>


                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="faxktr" class="control-label">Fax kantor</label>
                            <input type="text" class="form-control" name="faxktr" id="faxktr" placeholder="input fax kantor" value="<?php echo $data->faxktr ?>">
                          </div>
                          <div class="col-sm-5">
                            <label for="tlphp" class="control-label">Handphone<span style="color: red"> *</span></label>
                            <input type="text" class="form-control" name="tlphp" id="tlphp" placeholder="input no handphone" min="0" required value="<?php echo $data->telphp ?>">
                          </div>

                        </div>
                        <div class="form-group">

                          <div class="col-sm-5">
                            <label for="tlphp2" class="control-label">Handphone 2</label>
                            <input type="text" class="form-control" name="tlphp2" id="tlphp2" placeholder="input no handphone 2"
                            value="<?php echo $data->telphp2 ?>">
                          </div>
                          <div class="col-sm-5">
                            <label for="tlphp3" class="control-label">Handphone 3</label>
                            <input type="text" class="form-control" name="tlphp3" id="tlphp3" placeholder="input no handphone 3" value="<?php echo $data->tlphp3 ?>">
                          </div>


                        </div>

                        <div class="form-group">
                          <?php if ($this->session->userdata('admin') == TRUE) : ?>
                          <div class="col-sm-5">
                          <label for="jupen" class="control-label">Jupen<span style="color: red"> *</span></label>
                          <select class="form-control selectpicker" name="jupen" data-live-search="true" required id="jupen">
                            <?php foreach($jungut as $kodej) : ?>
                              <option name="program" value="<?php echo $kodej->KODEJ ?>"><?php echo $kodej->KODEJ." - ".$kodej->NAMA ?></option>
                            <?php endforeach; ?>
                          </select></div>
                          <?php endif; ?>
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
                          <input type="email" class="form-control" name="email" id="email" placeholder="input email" value="<?php echo $data->email ?>">
                        </div>

                        <div class="col-sm-5">
                          <label for="crbyr" class="control-label">Cara bayar</label>
                          <select class="form-control selectpicker" name="crbyr" data-live-search="true" id="carabayar">
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
                          <input type="text" name="rekdonatur" class="form-control pull-right" id="rekdonatur" placeholder="input no rekening" value="<?php echo $data->rekdonatur ?>">
                        </div>

                        <div class="col-sm-5">
                          <label for="bank" class="control-label">Bank</label>
                          <input type="text" class="form-control" name="bank" id="bank" placeholder="input bank" value="<?php echo $data->bank ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-5">
                          <label for="kolektif" class="control-label">Kolektif</label>
                          <input type="text" class="form-control" name="kolektif" id="kolektif" placeholder="input" value="<?php echo $data->kolektif ?>">
                        </div>

                        <div class="col-sm-5">
                          <label for="waktu_tagih" class="control-label">Waktu Tagih</label>
                          <select class="form-control selectpicker" name="waktu_tagih" data-live-search="true" id="waktu_tagih">
                            <option name="waktu_tagih" value=""> - </option>
                            <?php foreach($waktu_tagih as $tgh) : ?>
                              <option name="waktu_tagih" value="<?php echo $tgh->waktu_tagih ?>"><?php echo $tgh->NM_tagih ?></option>
                            <?php endforeach; ?>
                          </select>                    </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="npwp" class="control-label">Npwp</label>
                            <input type="text" class="form-control" name="npwp" id="npwp" placeholder="input" value="<?php echo $data->npwp ?>">
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
                            <label for="info" class="control-label">Info</label>
                            <select class="form-control selectpicker" name="info" data-live-search="true" id="info">
                              <option name="info" value=""> - </option>
                              <?php foreach($info as $tampil) : ?>
                                <option name="info" id="info" value="<?php echo $tampil->INFO ?>"><?php echo $tampil->NM_INFO ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <div class="col-sm-5">
                            <label for="pekerjaan" class="control-label">Pekerjaan</label>
                            <select class="form-control selectpicker" name="pekerjaan" data-live-search="true" id="pekerjaan">
                              <?php foreach($kerja as $kerja) : ?>
                                <option name="kerja" value="<?php echo $kerja->PEKERJAAN ?>"><?php echo $kerja->NM_PEKERJAAN ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="jabatan" class="control-label">Jabatan</label>
                            <select class="form-control selectpicker" name="jabatan" data-live-search="true" id="jabatan">
                              <?php foreach($jabatan as $jabatan) : ?>
                                <option name="jabatan" value="<?php echo $jabatan->jabatan ?>"><?php echo $jabatan->nm_jabatan ?></option>
                              <?php endforeach; ?>
                            </select>                    </div>

                            <div class="col-sm-5">
                              <label for="hobby" class="control-label">Hobi</label>
                              <select class="form-control selectpicker" name="hobby" data-live-search="true" id="hobby">
                                <?php foreach($hobi as $hobi) : ?>
                                  <option name="hobby" value="<?php echo $hobi->hobby ?>"><?php echo $hobi->nm_hobby ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-5">
                              <label for="pendidikan" class="control-label">Pendidikan</label>
                              <select class="form-control selectpicker" name="pendidikan" data-live-search="true" id="pend">
                                <?php foreach($pend as $pend) : ?>
                                  <option name="hobi" value="<?php echo $pend->PENDIDIKAN ?>"><?php echo $pend->NM_pendidikan ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="col-sm-5">
                              <label for="gaji" class="control-label">Gaji</label>
                              <select class="form-control selectpicker" name="gaji" data-live-search="true" id="gaji">
                                <?php foreach($gaji as $gaji) : ?>
                                  <option name="hobi" value="<?php echo $gaji->GAJI ?>"><?php echo $gaji->GOL_GAJI ?></option>
                                <?php endforeach; ?>
                              </select>                    </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-5">
                                <label for="rk" class="control-label">RK<span style="color: red"> *</span></label>
                                <select class="form-control selectpicker" name="rk" data-live-search="true" required id="rk">
                                  <option name="rk" value="R">R</option>
                                  <option name="rk" value="K">K</option>
                                </select>
                              </div>
                            </div>
                            <input type="hidden" name="donaturItem" id="donaturIt" value="">
                            <input type="hidden" name="deleteItem" id="deleteIt" value="">
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
        format : 'yyyy-mm-dd',
        autoclose: true
      });
      // $('#tgllahir').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
    })
    function convertToRupiah(angka)
      {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
          return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      }
  </script>
  <script>
    $(document).ready(function() {
    var cont="";
    <?php
    for($a=0;$a<count($donatur_item);$a++){
    ?>
    cont += '<tr data-prog="'+pad(<?php echo strval($donatur_item[$a]['prog']) ?>,4)+'" data-nominal="'+<?php echo $donatur_item[$a]['besar'] ?>+'" data-ket="<?php echo $donatur_item[$a]['keterangan'] ?>" data-id="'+<?php echo $donatur_item[$a]['iddonaturitem'] ?>+'"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+'<?php echo $donatur_item[$a]['NM_PROGRAM'] ?>'+'</td>'+
      '<td class="di-nominal" style="padding-right: 20px">'+convertToRupiah(<?php echo $donatur_item[$a]['besar'] ?>)+'</td>'+
      '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+pad(<?php echo strval($donatur_item[$a]['prog']) ?>,4)+'" data-nominal="'+<?php echo $donatur_item[$a]['besar'] ?>+'" data-ket="<?php echo $donatur_item[$a]['keterangan'] ?>" data-id="'+<?php echo $donatur_item[$a]['iddonaturitem'] ?>+'"> Ubah </button></td>'+
      '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';

    <?php
    }

    ?>
    /*
	  var cont = '<tr data-prog="'+pad(<?php echo strval($donatur_item->prog) ?>,4)+'" data-nominal="<?php echo $donatur_item->besar ?>" data-id="<?php echo $donatur_item->iddonaturitem ?>"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+'<?php echo $donatur_item->NM_PROGRAM ?>'+'</td>'+
      '<td class="di-nominal" style="padding-right: 20px">'+convertToRupiah(<?php echo $donatur_item->besar ?>)+'</td>'+
      '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+pad(<?php echo strval($donatur_item->prog) ?>,4)+'" data-nominal="'+<?php echo $donatur_item->besar ?>+'"  data-id="<?php echo $donatur_item->iddonaturitem ?>"> Ubah </button></td>'+
      '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';*/
      $("#prog").html(cont);
      save();
      var donaturItem = new Array();
      $('select#stats').selectpicker("val" , '<?php echo $data->status ?>');
      $('select#ketpasif').selectpicker("val" , '<?php echo $data->ketpasif ?>');
      $('select#gender').selectpicker("val" , '<?php echo $data->sex ?>');
      $('select#rk').selectpicker("val" , '<?php echo $data->koderk ?>');
      $('select#jupen').selectpicker("val" , '<?php echo $data->jupen ?>');
      $('select#carabayar').selectpicker("val", '<?php echo $data->carabyr ?>');
      $('select#waktu_tagih').selectpicker("val", '<?php echo $data->waktu_tagih ?>');
      $('select#info').selectpicker("val", '<?php echo $data->info ?>');
      $('select#pekerjaan').selectpicker("val", '<?php echo $data->pekerjaan ?>');
      $('select#jabatan').selectpicker("val", '<?php echo $data->jabatan ?>');
      $('select#hobby').selectpicker("val", '<?php echo $data->hobby ?>');
      $('select#pend').selectpicker("val", '<?php echo $data->pendidikan ?>');
      $('select#gaji').selectpicker("val", '<?php echo $data->gaji ?>');
      $('.selectpicker').selectpicker('refresh');
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
            cont += data.nm_kawasan;
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
		var ket = $("#ket").val();

        var cont = '<tr data-prog="'+prog+'" data-nominal="'+nominal+'" data-ket="'+ket+'" data-id=""><td class="di-name" style="padding-right: 70px;padding-left:5px">'+name+'</td>'+
        '<td class="di-nominal" style="padding-right: 20px">'+convertToRupiah(nominal)+'</td>'+
        '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+prog+'" data-nominal="'+nominal+'" data-ket="'+ket+'" data-id=""> Ubah </button></td>'+
        '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';
        $("#prog").append(cont);
        save();
      });

      // $('button#btn-del').click(function() {

      // });
    });
    var deleteIt=[];
    $(document).on('click', 'button#btn-del', function () {
     	var _this = $(this).closest('tr');
     	var id = _this.attr('data-id');
      	$(this).closest('tr').remove();
      	if(id!=null||id!=""){
      		deleteIt.push(id);
      		$("#deleteIt").val(JSON.stringify(deleteIt));
      		console.log($('#deleteIt').val());
      		}
     	save();
   });
    $(document).on('click', 'button#btn-edit', function () {
      var _this = $(this).closest('tr');
      var prog = $(this).attr('data-program');
      var nominal = $(this).attr('data-nominal');
      var id = $(this).attr('data-id');
      var ket = $(this).attr('data-ket');
      $("#modal-program").val(prog);
      $("#modal-nominal").val(nominal);
      $("#modal-ket").val(ket);
      $("#modal-id").val(id);
      $('.selectpicker').selectpicker('refresh');
      var batal=0;
      $(document).on('click', '#btn-edit2', function() {
      if(batal==0){
        var new_prog = $(".modal-body #modal-program").children('option:selected').val();
        var new_nominal = $(".modal-body #modal-nominal").val();
        var new_ket = $(".modal-body #modal-ket").val();
        if(new_ket==null)
        new_ket="";
        var new_prog_name = $(".modal-body #modal-program").children('option:selected').text();
        var cont = '<tr data-prog="'+new_prog+'" data-nominal="'+new_nominal+'" data-ket="'+new_ket+'" data-id="'+id+'"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+new_prog_name+'</td>'+
        '<td class="di-nominal" style="padding-right: 20px">'+convertToRupiah(new_nominal)+'</td>'+
        '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+new_prog+'" data-nominal="'+new_nominal+'"   data-ket="'+new_ket+'" data-id="'+id+'"> Ubah </button></td>'+
        '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';
        _this.replaceWith(cont);
        save();
        }
        // alert(new_prog);
      });
      $(document).on('click', '#btn-batal', function() {
      batal=1;
      });
    });
    function save() {
      donaturItem = [];
      var data = [];
      $("table#prog").find('tr').each(function(index, el) {
        var nominal = $(this).attr('data-nominal');
        var prog = $(this).attr('data-prog');
        var id = $(this).attr('data-id');
        var ket = $(this).attr('data-ket');
          // alert(prog);
          // data = [];
          var array = [prog , nominal,ket,id];
          data.push(array);
        });
      // donaturItem = [];
      // donaturItem.push(data);
      //   // alert(JSON.stringify(donaturItem));
      $("#donaturIt").val(JSON.stringify(data));
      console.log($('#donaturIt').val());
    }
    function pad(n, width, z) {
      z = z || '0';
      n = n + '';
      return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }
  </script>
  </html>
