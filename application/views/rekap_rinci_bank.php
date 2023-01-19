<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div align="center">
<b>REKAP RINCIAN SLIP BANK PER JUNGUT<br>
<?php if(isset($petugas)){echo $petugas->name ;}?> &nbsp;KODE JUNGUT :<?php echo $petugas->kodej ?> &nbsp;  PERIODE : <?php echo date('d-m-Y',strtotime($date['date_himp1'])); ?> S/D  <?php echo date('d-m-Y',strtotime($date['date_himp2'])); ?>   TANGGAL CETAK : <?php echo date('d-m-y h:i');?>
</b>
</div>
	<div class="box-body table-responsive">
		<table width="100%" border="1">
            <tr>
                <td>No</td>
                <td>Entry Pegawai</td>
                <td>Noslip</td>
                <td>Nama Bank</td>
                <td>Nomer Rekening</td>
                <td>Jumlah</td>
                <td>Infaq</td>
                <td>Pena</td>
                <td>Zakat</td>
                <td>RCY</td>
                <td>CGQ</td>
                <td>Lain-Lain</td>
            </tr>
            <tr>
            <td colspan="12">BELUM TERVALIDASI</td>
            </tr>
            <?php foreach($perBankJgtT as $no => $belum): ;?>
            <tr>
            <td><?php echo $no+1 ?></td>
            <td><?php echo $belum->entr_pegawai ?></td>
            <td><?php echo $belum->noslip ?></td>
            <td><?php echo $belum->NM_BANK ?></td>
            <td><?php echo $belum->REC ?></td>
            <td><?php echo number_format($belum->total,0,'.',',') ?></td>
            <td><?php echo number_format($belum->infaq,0,'.',',') ?></td>
            <td><?php echo number_format($belum->pena,0,'.',',') ?></td>
            <td><?php echo number_format($belum->zakat,0,'.',',') ?></td>
            <td><?php echo number_format($belum->RCY,0,'.',',') ?></td>
            <td><?php echo number_format($belum->CGQ,0,'.',',') ?></td>
            <td><?php echo number_format($belum->dll,0,'.',',') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
            <td colspan="5" align="center">JUMLAH</td>
            <td><?php $tot=0; foreach($perBankJgtT as  $belum){
                $tot +=$belum->total;
            } echo number_format($tot,0,'.',',');?></td>
            <td>
            <?php $tot=0; foreach($perBankJgtT as $belum){
                
                $tot +=$belum->infaq;
                
            }echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtT as $belum){
                
                $tot +=$belum->pena;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtT as $belum){
                
                $tot +=$belum->zakat;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtT as $belum){
                
                $tot +=$belum->RCY;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtT as $belum){
                
                $tot +=$belum->CGQ;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtT as $belum){
                
                $tot +=$belum->dll;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            </tr>
            <tr>
            <td colspan="12">SUDAH TERVALIDASI</td>
            </tr>
            <?php foreach($perBankJgtY as $no => $belum): ?>
            <tr>
            <td><?php echo $no+1 ?></td>
            <td><?php echo $belum->entr_pegawai ?></td>
            <td><?php echo $belum->noslip ?></td>
            <td><?php echo $belum->NM_BANK ?></td>
            <td><?php echo $belum->REC ?></td>
            <td><?php echo number_format($belum->total,0,'.',',') ?></td>
            <td><?php echo number_format($belum->infaq,0,'.',',') ?></td>
            <td><?php echo number_format($belum->pena,0,'.',',') ?></td>
            <td><?php echo number_format($belum->zakat,0,'.',',') ?></td>
            <td><?php echo number_format($belum->RCY,0,'.',',') ?></td>
            <td><?php echo number_format($belum->CGQ,0,'.',',') ?></td>
            <td><?php echo number_format($belum->dll,0,'.',',') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
            <td colspan="5" align="center">JUMLAH</td>
            <td><?php $tot=0; foreach($perBankJgtY as $belum){
                $tot +=$belum->total;
            } echo number_format($tot,0,'.',',');?></td>
            <td>
            <?php $tot=0; foreach($perBankJgtY as $belum){
                
                $tot +=$belum->infaq;
                
            }echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtY as $belum){
                
                $tot +=$belum->pena;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtY as $belum){
                
                $tot +=$belum->zakat;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtY as $belum){
                
                $tot +=$belum->RCY;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtY as $belum){
                
                $tot +=$belum->CGQ;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            <td>
            <?php $tot=0; foreach($perBankJgtY as $belum){
                
                $tot +=$belum->dll;
                
            } echo number_format($tot,0,'.',','); ?>
            </td>
            </tr>
		</table>
	</div>
    <table width="100%" border="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="33%" align="center"> Ttd. Kasir </td>
							<td width="33%" align="center"> Ttd. Manager Penghimp. </td>
							<td width="33%" align="center"> Ttd. Petugas Lapangan </td>&nbsp;
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="33%" align="center"> ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
							<td width="33%" align="center"> ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
							<td width="33%" align="center"> ( <?php if(isset($petugas)){echo $petugas->name ;}?> )</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>