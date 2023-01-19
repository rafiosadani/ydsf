<!DOCTYPE html>
<html>
<?php $this->load->model('Mdonatur'); ?>
<head>
  <?php $this->load->view('partials/head') ?>
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
          Dashboard
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Data Donatur</li>
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
                <h3 class="box-title">Data Donatur</h3>
                <?php if ($this->session->userdata('admin') == TRUE) : ?>
                    <a href="<?php echo base_url('data/donatur/baru') ?>"><button class="btn btn-primary" style="margin-left: 15px"><span class="glyphicon glyphicon-plus text-light"></span><b>  Baru</b></button></a>
                <?php endif; ?>
                <a href="" data-toggle="modal" data-target="#modal-filter2"><button class="btn btn-success" style="margin-right: 15px;float: right"><span class="glyphicon glyphicon-search text-light"></span><b>    Filter</b></button></a>

              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive ">
              <div class="row justify-content-center">
              <div class="col-md-12">
              <?php $this->session->set_userdata('donatur',$donatur); ?>
              </div>
              <!--<div class="col-md-12 text-center">
              <p class="center">Total Jumlah Donatur : <?php if(isset($donatur)){echo $tot_donatur;}?></p>
              </div>-->
              </div>

                <table id="donatur" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Action</th>
                      <th>Kawasan</th>
                      <th>No.donatur</th>
                      <th>Nama</th>
                      <th>Status</th>
                      <th>Alamat</th>
                      <th>Program</th>
                      <th>Petugas</th>
                      <th>No.Hp</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($donatur as $d) : ?>
                    <tr>
                    <td>
                      <a href="<?php echo base_url('data/donatur/edit/').$d->autoid ?>"><button class="btn btn-info"><span
                              class="glyphicon glyphicon-pencil text-light"></span></button></a>                      
                      </td>
                      <td><?php echo $d->kwsn ?></td>
                      <td><?php echo $d->noid ?></td>
                      <td><?php echo $d->nama ?></td>
                      <td><?php echo $d->status ?></td>
                      <td><?php echo $d->almktr ?></td>
                      <td>
                        <table class="table table-bordered table-striped table-hover" style="padding: -8px !important">
                          <tr>
                            <td bgcolor="#e0e0e0">Program</td>
                            <td bgcolor="#e0e0e0">Jumlah</td>
                            <td bgcolor="#e0e0e0">Ket</td>
                          </tr>
                          <?php foreach($this->Mdonatur->getDonaturItem($d->autoid) as $v) : ?>
                            <tr>
                              <td><?php echo $v->NM_PROGRAM ?></td>
                              <td><?php echo $v->besar ?></td>
                              <td><?php echo $v->keterangan ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      </td>
                      <td><?php echo $d->kodejgt ?></td>
                      <td><?php echo $d->telphp ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

                <?php echo $this->pagination->create_links(); ?>

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

  <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
  </script>

</body>
<?php $this->load->view('partials/js') ?>
<!-- <script>
  $(function () {
    $('#donatur').DataTable()
  })
</script> -->
<!-- <script type="text/javascript">
 
 var save_method; //for save method string
 var table;

 $(document).ready(function() {
     //datatables
     table = $('#donatur').DataTable({ 
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
             "url": '',
             "type": "POST"
         },
         //Set column definition initialisation properties.
         "columns": [
             {"aaData": 0},
             {"aaData": 1},
             {"aaData": 2}
         ]

     });

 });
</script> -->
</html>
