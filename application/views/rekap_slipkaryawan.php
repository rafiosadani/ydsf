<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">


<table width="50%" border="1" style="margin-left:6px;margin-bottom:7px;">
<tr>
<td>
<table cellpadding="3px" >
	<tr style="font-family:arial;font-size:16px">
		<td rowspan=2 width="3%">&nbsp;<img src="<?php echo base_url('logo.png') ?>" width="96px" height="39px" ></td>
		<td colspan=2 align="center"><b>YAYASAN DANA SOSIAL AL FALAH</b></td>
		
	</tr>
	<tr style="font-family:arial;font-size:15px;">
		<td colspan=2 align="center"><?php if(isset($datakaryawan->nm_ggroup)){echo $datakaryawan->nm_ggroup;} echo " ".$bulan." ".$tahun;?></td>
	</tr>

<p></p>
<tr><td colspan="3"><hr></td></tr>
<p></p>

	<tr >
		<td  >No</td>
		<td width="1%" >:</td>
		<td  ><?php if(isset($datakaryawan->nm_ggroup)){ echo $datakaryawan->nomer;}?></td>
	</tr>
	<tr >
		<td  >Nip</td>
		<td width="1%" >:</td>
		<td  ><?php if(isset($datakaryawan->nm_ggroup)){ echo $datakaryawan->nip;}?></td>
	</tr>
	<tr>
		<td >Nama </td>
		<td width="1%" >:</td>
		<td><?php if(isset($datakaryawan->nm_ggroup)){echo $datakaryawan->NAMA;} ?></td>
	</tr>
	<tr>
		<td >Bagian </td>
		<td width="1%" >:</td>
		<td><?php if(isset($datakaryawan->nm_ggroup)){ echo $datakaryawan->Bagian;} ?></td>
	</tr>
	<tr>
		<td >Status </td>
		<td width="1%" >:</td>
		<td><?php if(isset($datakaryawan->nm_ggroup)){ echo $datakaryawan->status;} ?></td>
	</tr>
	<tr>
		<td width="5%">Kantor </td>
		<td width="1%" >:</td>
		<td><?php if(isset($datakaryawan->nm_ggroup)){ echo $datakaryawan->kantor;} ?></td>
	</tr>


<tr><td colspan="3"><hr></td></tr>

<?php $totals=0; foreach($datagroupkaryawan as $datakar): ?>
<tr><td colspan="3"><b><?php echo $datakar->nm_Group ?></b></td></tr>  
<?php $total=0; $datadetail=$this->mslipkaryawan->getDetail($datakar->id_vrb_group,$datakar->bulan,$datakar->tahun,$datakar->id_ggroup,$datakar->nip);
foreach($datadetail as $datadetail):
?>
<tr>
<td colspan="2"><?php echo $datadetail->nm_uraian ?></td>
<td align="right"><?php echo number_format($datadetail->jumlah_uraian,0,',',',') ?></td>
</tr>
<?php $total += $datadetail->jumlah_uraian; endforeach; ?>
<tr>
<td colspan="2" align="center"><b>Jumlah</b></td>
<td align="right"><b><?php echo number_format($total,0,',',',') ?></b></td>
</tr>
<tr><td colspan="3"><hr></td></tr>
<?php $totals += $datakar->jumlah; endforeach; ?>
<tr>
<td colspan="2" align="center"><b style="font-size:21px;">TOTAL</b></td>
<td align="right"><b style="font-size:21px;"><?php echo number_format($totals,0,',',','); ?></b></td>
</tr>
</table>

<p><p>
<table width="100%" border="1" >

	<tr> <?php $widthMenu = 100/3;?>
		<td width="<?php echo round($widthMenu);?>%" align="center"> Diterima Oleh: <br>
		<?php echo date('d F Y');?><br><br><br><br><br><br><br>( <?php if(isset($datakaryawan->nm_ggroup)){echo $datakaryawan->NAMA;}?> )
		</td>
		<td width="<?php echo round($widthMenu);?>%" align="center"> Diperiksa Oleh: <br>
		Manajer Keuangan <br><br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
		</td>
		<td width="<?php echo round($widthMenu);?>%" align="center"> Dibuat Oleh: <br> 
		Manajer SDM <br><br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
		</td>&nbsp;
	</tr>
	
</table>
</td>
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