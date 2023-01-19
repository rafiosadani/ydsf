<!DOCTYPE html>
<html>

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
          <li class="active">Kawasan</li>
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
                <h3 class="box-title">Data Kawasan</h3>
                <a href="<?php echo base_url('data/kawasan/baru') ?>"><button class="btn btn-primary" style="margin-left: 15px"><span class="glyphicon glyphicon-plus text-light"></span><b>  Baru</b></button></a>
                <a href="" data-toggle="modal" data-target="#modal-filter1"><button class="btn btn-success" style="margin-right: 10px;float: right"><span class="glyphicon glyphicon-search text-light"></span><b>    Filter</b></button></a>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">

                <table id="donatur" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Action</th>
                      <th>Kawasan</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Kode jgt</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach ($kawasan as $kawasan) : ?>
                    <tr>
                      <td>
                        <a href="<?php echo base_url('data/kawasan/edit/').$kawasan->kwsn ?>"><button class="btn btn-info"><span
                              class="glyphicon glyphicon-pencil text-light"></span></button></a>
                        <!-- <a onclick="deleteConfirm('')" href="#"
                          class="btn btn-danger" data-toggle="modal" data-target="#modal-delete"><span class="glyphicon glyphicon-trash text-light"></span></a> -->
                      </td>
                      <td>
                        <?php echo $kawasan->kwsn ?>
                      </td>
                      <td>
                        <?php echo $kawasan->nm_kawasan ?>
                      </td>
                      <td>
                        <?php echo $kawasan->alamat ?>
                      </td>
                      <td>
                        <?php echo $kawasan->kodejgt ?>
                      </td>
                    </tr>
                    <?php endforeach ?>

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

</html>