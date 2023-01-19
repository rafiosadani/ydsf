
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
                    <div id="deleteModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>Anda yakin akan menghapus data?</p>
                                    <form id="formdelete" method="post" >
                                        <input id="idtable" type="hidden" name="idtable">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#formdelete').submit()">hapus</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">batal</button>
                                </div>
                            </div>

                        </div>
                    </div>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0"><?= $forpage['namahalaman'] ?></h3>
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
                <?= ($this->session->flashdata('info') != null) ? '<div class="alert alert-success text-center">' . $this->session->flashdata('info') . '</div>' : ''; ?>
                <?= ($this->session->flashdata('error') != null) ? '<div class="alert alert-danger text-center">' . $this->session->flashdata('error') . '</div>' : ''; ?>

                <div class="card">
                    <a href="<?= $forpage['insert-controller'] ?>">
                        <button type="button" class="btn btn-success btn-md pull-right"><i class="mdi mdi-plus"></i> Tambah</button>
                    </a>

                    <div class="card-block">
                        <table id="datatable" class="display table table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($kolom as $row) {
                                        $cek = explode(",", $row);
                                        if ($row == '') {
                                            echo "<th style='display:none;'>$row</th>";
                                        } elseif (!empty($cek[1]) && $cek[1] == 'cek') {
                                            echo "<th>$cek[0]</th>";
                                        } else {
                                            echo "<th>$row</th>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <?php
                                    foreach ($kolom as $row) {
                                        $cek = explode(",", $row);
                                        if ($row == 'sembunyikan') {
                                            echo "<th style='display:none;'>$row</th>";
                                        } elseif (!empty($cek[1]) && $cek[1] == 'cek') {
                                            echo "<th>$cek[0]</th>";
                                        } else {
                                            echo "<th>$row</th>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </tfoot>

                            <tbody>
                                <tr>
                                    <td colspan="<?php echo (count($kolom) + 1); ?>" class="dataTables_empty text-center">Loading data from server</td>
                                </tr>  
                            </tbody>
                        </table>
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
<link href="<?= base_url() ?>assets/plugins/DataTables/datatables.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/plugins/DataTables/datatables.responsive.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/plugins/DataTables/datatables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/DataTables/datatables.responsive.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/DataTables/datatables.buttons.js" type="text/javascript"></script>
<script type="text/javascript">
<?= $customjs ?>
</script>