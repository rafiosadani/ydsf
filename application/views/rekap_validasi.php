<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">


    <div class="box-body table-responsive">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="tableheader">
                <b>
                    <td colspan="2" align="center">DATA NOSLIP : <?php echo $data['noslip'] ?> - KODE JUNGUT <?php echo $data['kodej'] ?></td>
                </b>
            </tr>
        </table>
        <p>
            <p>
                <table width="100%" border="1">
                    <tr class="style1">
                        <td>
                            No.
                        </td>
                        <td>
                            No Id
                        </td>
                        <td>
                            Nama
                        </td>
                        <td>
                            Alamat
                        </td>
                        <td>
                            Prog
                        </td>
                        <td>
                            Kawasan
                        </td>
                        <td>
                            Jumlah
                        </td>
                    </tr>
                    <?php $total = 0; foreach ($rekap as $key => $rekap) { 
                        $total += $rekap->jumlah;
                        ?>    
                        <tr class='style1'>
                            <td><?php echo $key+1 ?></td>
                            <td align='left'><?php echo $rekap->noid ?></td>
                            <td align='left'><?php echo $rekap->nama ?></td>
                            <td align='left'><?php echo $rekap->alamat ?></td>
                            <td align='left'><?php echo $rekap->prog ?></td>
                            <td align='left'><?php echo $rekap->kwsn ?></td>
                            <td align='right'><?php echo number_format($rekap->jumlah,0,'.',',') ?></td></tr>
                        <tr>
                    <?php } ?>
                        <td colspan='6'><b>J U M L A H</b></td>
                        <td align=right><b><?php echo number_format($total,0,'.',',') ?></b></td>
                    </tr>
                </table>
    </div>



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>