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
          Add Donasi
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('data/donasi') ?>">Data Donasi</a></li>
          <li class="active">Donasi Baru</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <form class="form-horizontal" method="post" id="formDonasi">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  
                  <li class="pull-right"><input type="button" name="btnsave" id="btnsave" class="btn btn-md btn-info" style="margin-right: 10px" value="Simpan" /></li>
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
                          <label for="nama" class="control-label">No ID / Nama<span style="color: red"> *</span></label>
                          <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                          required>
                        </div>
                      </div>
                      <!--
                      <div class="form-group">
                          <div class="col-sm-5">
                            <label for="program" class="control-label" style="padding-left:5px">Kelompok Program<span style="color: red"> *</span></label>
                            <select id="kelompok_program" class="form-control selectpicker" name="kelompok_program" data-live-search="true" >
                                <option  name="kelompok_program" value="1">Rutin</option>
                                <option  name="kelompok_program" value="2">Non Rutin</option>
                                <option  name="kelompok_program" value="3">Event</option>
                                <option  name="kelompok_program" value="4">Kemanusiaan</option>
                                <option  name="kelompok_program" value="5">Umum</option>
                              </select>

                          </div>
                        </div>-->
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
                          <input type="hidden" name="donaturItem" id="donaturIt" value="">
                        </div>

                        <hr></div>
                        <!--
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="program" class="control-label" style="padding-left:5px">Program<span style="color: red"> *</span></label>
                            <select id="nama_program" class="form-control" name="nama_program"  required>
                              
                            </select>
                              
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="nominal" class="control-label" style="padding-left:5px">Nominal<span style="color: red"> *</span></label>
                            <input type="number" class="form-control" name="nominal" id="nominal" placeholder="Input nominal" required>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-sm-5">
                            <label for="ket" class="control-label" style="padding-left:5px">Keterangan</label>
                            <input type="text" class="form-control" name="ket" id="ket" placeholder="keterangan" >
                          </div>
                        </div>

                        <div class="form-group"><div class="col-sm-5">
                          <label for="jupen" class="control-label">Jupen<span style="color: red"> *</span></label>
                          <select class="form-control selectpicker" name="jupen" data-live-search="true" required id="jupen">
                            <?php foreach($jungut as $kodej) : ?>  
                              <option value="<?php echo $kodej->KODEJ ?>"><?php echo $kodej->KODEJ." - ".$kodej->NAMA ?></option>
                            <?php endforeach; ?>
                          </select>
                          
                        </div>
                        -->
                      </div>
                    </div>

                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                    <!-- </form> -->

                  </div>
                  <!-- /.tab-pane -->
                  
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div>

                </div>
                <!-- /.col -->

              </div></form>
              <!-- /.row (main row) -->

            </section>
            <!-- /.content -->
          </div>
          <!-- /.content-wrapper -->
          <?php $this->load->view('partials/footer') ?>


        </div>
        <!-- ./wrapper -->
       
        <?php $this->load->view('partials/modal') ?>

        <div id="dialog-confirm" title="CETAK TANDA TERIMA">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Data telah tercetak. Apakah Tanda Terima dicetak?</p>
</div>
 
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
/*
$.ajax({
    		url: "<?php echo base_url('donasi/getProgram');?>",
			type: 'post',
			dataType: "json",
    		data: {
     			kelompok: "1"
    		},
    		success: function( data ) {
     			$('#nama_program').html(data.data);
     		}
   		});
/*
$('#kelompok_program').change(function() {
		$.ajax({
    		url: "<?php echo base_url('donasi/getProgram');?>",
			type: 'post',
			dataType: "json",
    		data: {
     			kelompok: $('#kelompok_program').val()
    		},
    		success: function( data ) {
     			$('#nama_program').html(data.data);
     		}
   		});
		//alert("change");
   	});
*/
$(function () {
       //Date picker
       $('#tgllahir').datepicker({
        format : 'dd-mm-yyyy',
        autoclose: true
      });
       $('#tgllahir').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
     })

function convertToRupiah(angka)
      {
        var rupiah = '';    
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
          return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      }
    
$(document).ready(function() {
	$( "#nama" ).autocomplete({
				source: function( request, response ) {
   // Fetch data	
   				if(request.term.length>=3){
   					$.ajax({
    					url: "<?php echo base_url('donasi/getDonaturAuto');?>",
    					type: 'post',
    					dataType: "json",
    					data: {
     						search: request.term
    					},
    					success: function( data ) {
     						response( data );
    					}
   					});
   				}
   				}
   			});
 
 
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
      
      // $('button#btn-del').click(function() {

      // });
    });
    
$(document).on('click', '#btnsave', function(e){
	$.ajax({
    	data:$("#formDonasi").serialize(),
      type: "POST",
      url: "<?php echo base_url('donasi/addDonasi');?>",
            dataType: 'json',
            timeout: 600000,
            success: function (data) {
            	$( "#dialog-confirm" ).dialog({
    					resizable: false,
    					height: "auto",
    					width: 400,
    					modal: true,
    					buttons: {
    						"Tidak": function() {
      							$( this ).dialog( "close" );
    		            window.open("http://donaturydsf.exploremybos.com/data/donasi","_self");
    						},
    						"Cetak": function() {
    					window.open("http://localhost/index.php?jupen_alm="+data.jupen_alm+"&&jupen_tlpktr="+data.jupen_tlpktr+"&&nama="+data.report_nama+"&&alamat="+data.report_alamat+"&&program="+data.report_program+"&&nominal="+data.report_nominal+"&&jupen_nama="+data.jupen_nama+"&&jupen_tlp="+data.jupen_tlp+"&&jupen_terima="+data.jupen_terima+"&&jupen_doa="+data.jupen_doa+"&&jupen_web="+data.jupen_web+"&&donasi="+$('#donaturIt').val());
      							$( this ).dialog( "close" );
                        window.open("http://donaturydsf.exploremybos.com/data/donasi","_self");
    						}
    					}
    			});

                    //alert("Success");
                        
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                    }
        });
});

$("#btnprog").click(function(){
        var name    = $("#nama_program").children('option:selected').text();
        var prog    = $("#nama_program").children('option:selected').val();
        var nominal = $("#nominal").val();
		var ket = $("#ket").val();

        var cont = '<tr data-prog="'+prog+'" data-name="'+name+'" data-nominal="'+nominal+'"   data-ket="'+ket+'"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+name+'</td>'+
        '<td class="di-nominal" style="padding-right: 20px">'+convertToRupiah(nominal)+'</td>'+
        '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+prog+'" data-nominal="'+nominal+'"  data-ket="'+ket+'"> Ubah </button></td>'+
        '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';
        $("#prog").append(cont);
        save();
      });

$(document).on('click', 'button#btn-del', function () {
     $(this).closest('tr').remove();
     save();
   });
var _this;
$(document).on('click', 'button#btn-edit', function () {
      _this = $(this).closest('tr');
      var prog = $(this).attr('data-program');
      var nominal = $(this).attr('data-nominal');
      var ket = $(this).attr('data-ket');
      $("#modal-program").val(prog).change();
      $("#modal-nominal").val(nominal);
      $("#modaledit-ket").val(ket);
      $('.selectpicker').selectpicker('refresh');

      

    });

      $("#btn-edit2").click(function() {
        var new_prog = $(".modal-body #modal-program").children('option:selected').val();
        var new_name    = $(".modal-body #modal-program").children('option:selected').text();
        var new_nominal = $(".modal-body #modal-nominal").val();
        var new_ket = $(".modal-body #modal-ket").val();
        var new_prog_name = $(".modal-body #modal-program").children('option:selected').text();
        var cont = '<tr data-prog="'+new_prog+'" data-name="'+new_name+'" data-nominal="'+new_nominal+'"   data-ket="'+new_ket+'"><td class="di-name" style="padding-right: 70px;padding-left:5px">'+new_prog_name+'</td>'+
        '<td class="di-nominal" style="padding-right: 20px">Rp. '+new_nominal+'</td>'+
        '<td style="padding-right: 10px"><button id="btn-edit" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit" data-program="'+new_prog+'" data-nominal="'+new_nominal+'"  data-ket="'+new_ket+'"> Ubah </button></td>'+
        '<td><button type="button" id="btn-del" name="btnhapus" class="btn btn-sm btn-danger"> X </button></td></tr>';
        alert(cont);
      
        _this.replaceWith(cont);
        save();
        // alert(new_prog);
      });
function save() {
      donaturItem = [];
      var data = [];
      $("table#prog").find('tr').each(function(index, el) {
        var nominal = $(this).attr('data-nominal');
        var prog = $(this).attr('data-prog');
        var name = $(this).attr('data-name');
        var ket = $(this).attr('data-ket');
          // alert(prog);
          // data = [];
          var array = [prog, name , nominal,ket];
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