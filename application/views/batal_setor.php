<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('partials/head') ?>
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
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
          Batal Setoran
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Batal Setoran</li>
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
                <h3 class="box-title">Filter Pencarian</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
              <div class="row">
              <form action="<?php echo base_url('Donatur/batalSetor') ?>" method="post">
              <div class="form-group">
                  <div class="col-sm-4"> 
                    <label for="kodej" class="control-label">Jungut<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" id="jungut" name="kodej" data-live-search="true">
                        <option value="null" disabled <?php if(empty($this->session->userdata('jungut'))){echo ("selected");} ?>>Pilih</option>
                      <?php foreach ($jungut as $report) : ?>
                        <option name="kodej" value="<?php echo $report->kodej ?>" <?php if($report->kodej == $this->session->userdata('jungut')){echo ("selected");} ?>><?php echo $report->kodej.' - '.$report->name ?></option>
                    <?php endforeach; ?>
                   
                    </select>
                    </div>
                    
                    <div class="col-sm-3"> 
                      <label for="kawasan" class="control-label">Kawasan<span style="color: red"> *</span></label>
                      <select class="form-control selectpicker" id="kawasan" name="kawasan" data-live-search="true">
                      </select>
                    </div>

                    <div class="col-sm-3"> 
                    <label for="date" class="control-label">Tanggal<span style="color: red">*</span></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control daterange-btn" id="date" name="date"/>
                    </div>
                    </div>

                    <div class="col-sm-2">
                    <label for="button"> </label>
                      <button type="submit" name="button" class="btn btn-block btn-success">Submit  <span><i class="fa fa-search"></i></span></button>
                    </div>
                    </div>
              </div>
              
              <!-- /.box-body -->
              </div>
              </form>
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row (main row) -->

        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title"></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
              <div class="row">
              <div class="col-md-12">

              <h5 class="text-center" >Total Setoran : Rp. <span id="total_setoran"></span> </h5>
              </div>
              </div>
              <table id="tabel_batal" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th></th>
                <th>ID CLient</th>
                  <th>ID Kawasan</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Tanggal</th>
                  <th>Program</th>
                  <th>Jumlah</th>
                  <th class="hidden"></th>
                  <th class="hidden"></th>
                  <!-- <th>Hapus</th> -->
                </tr>
                </thead>
                <tbody>
                <!-- <form action="" id="batal_form" method="post"> -->
                <?php
                if(!empty($hasil)):
                foreach($hasil as $hasil): ?>
                <tr>
                  <td nilai="<?php echo $hasil->jumlah?>"></td>
                  <td><?php echo $hasil->noid ?></td>
                  <td><?php echo $hasil->kwsn ?></td>
                  <td><?php echo $hasil->nama ?></td>
                  <td><?php echo $hasil->almktr ?></td>
                  <td><?php echo $hasil->tanggal ?></td>
                  <td><?php echo $hasil->NM_PROGRAM ?></td>
                  <td><?php echo $hasil->jumlah ?></td>
                  <td class="hidden"><?php echo $hasil->report_id ?></td>
                  <td class="hidden"><?php echo $hasil->jumlah ?></td>
                </tr>
                <?php endforeach;
                endif; ?>
                </tbody>
              </table>
              <?php if(!empty($hasil)):?>
              <div class="row">
              <div class="col-md-12">
              <button type="submit" value="hapus" name="hapus" id="hapus_tombol"  class="btn btn-block btn-danger">Hapus<span><i class="fa fa-trash"></i></span></button>
              </div>
              </div>
                <?php endif; ?>
              <!-- </form> -->
              <!-- /.box-body -->
              </div>
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view('partials/footer') ?>


  </div>
  <!-- ./wrapper -->

  <?php $this->load->view('partials/modal') ?>

  <!-- <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
  </script> -->
</body>
<?php $this->load->view('partials/js') ?>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function(){

  $(function () {
    $('.daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
      },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {
        $('.daterange-btn').html(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'))
      }
      
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  })
  //
  $("select#jungut").on('change',function() {
        var kodej = $(this).children("option:selected").val();
        var tgl = $("#date").val();
        var cont = '<option value="" selected> - </option>';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('Donatur/getKawasanJ') ?>',
          data  : {
            kodej : kodej,
            tgl : tgl
          },
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option  value="'+data[i].kwsn+'">'+data[i].kwsn+' - '+data[i].nm_kawasan+' </option>';
            };
            $('select#kawasan').html(cont);
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });

    })  

    //
    // 

    function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');
}

var tabel = $('#tabel_batal').DataTable({
      columnDefs: [ {
            targets: 0,
            data:8,
            'checkboxes':{
              'selectRow':true
            }
      }
         ],
        select: {
            style:'multi',
        },
        order: [[ 1, 'asc' ]]
    });

        
  var chckbxtbl = tabel.column(0).nodes().to$().find('input[type=checkbox]')
  $(chckbxtbl).change(function(){
  var checkbx = chckbxtbl;
  console.log(checkbx);
  var sum = 0;
  for(i=0;i<checkbx.length;i++){
    if(checkbx[i].checked){
    sum = sum + parseInt($(checkbx[i]).parent().attr('nilai'));
    }
  }
  $("#total_setoran").html(convertToRupiah(sum));
})


</script>
<script>
$(document).ready(function(){

$("#hapus_tombol").click(function () { 
  var report_id = tabel.columns().checkboxes.selected()[0];
  console.log(report_id);
  if (report_id.length > 0){
    $.ajax({
      type: "post",
      url: "<?php echo base_url('Donatur/hapusSetor') ?>",
      data: {report_id:report_id},  
      success: function () {
        window.location.href = '<?php echo base_url('batal/setor') ?>';
      }
    });
  }
});

var all_form=$(".dt-checkboxes-select-all").find('input[type=checkbox]');
$(all_form).on('change',function(){
  if(this.checked){
    var checkbx = chckbxtbl;
    var sum = 0;
    for(i=0;i<checkbx.length;i++){
    if(checkbx[i].checked){
    sum = sum + parseInt($(checkbx[i]).parent().attr('nilai'));
    }
  }
 }else{
   sum = 0;
 }
  $("#total_setoran").html(convertToRupiah(sum));
});

});
</script>

</html>