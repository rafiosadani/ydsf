<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">

<?php
$cbg = "";
$grup = "";
$data = $this->mrkay->getCabGrup();
for($a = 0;$a < count($data);$a++) {
	if ($data[$a]->id_cab == $this->input->post('cabang')) {
		$cbg = $data[$a]->nm_cabang;
		$grup = $data[$a]->nm_group;
	}
}

$pintu = "";
$data1 = $this->mrkay->getPintu();
if ($this->input->post('pintu') == '-') {
	$pintu = "SEMUA PINTU";
} else {
	for ($a = 0;$a < count($data1);$a++) {
		if ($data1[$a]->id_pintu_rtn == $this->input->post('pintu')) {
			$pintu = strtoupper($data1[$a]->nm_pinturtn);
		}
	}
}

$bulan = array(
	0 => [
		"id" => 1,
		"bulan" => "Januari"
	],
	1 => [
		"id" => 2,
		"bulan" => "Februari"
	],
	2 => [
		"id" => 3,
		"bulan" => "Maret"
	],
	3 => [
		"id" => 4,
		"bulan" => "April"
	],
	4 => [
		"id" => 5,
		"bulan" => "Mei"
	],
	5 => [
		"id" => 6,
		"bulan" => "Juni"
	],
	6 => [
		"id" => 7,
		"bulan" => "Juli"
	],
	7 => [
		"id" => 8,
		"bulan" => "Agustus"
	],
	8 => [
		"id" => 9,
		"bulan" => "September"
	],
	9 => [
		"id" => 10,
		"bulan" => "Oktober"
	],
	10 => [
		"id" => 11,
		"bulan" => "November"
	],
	11 => [
		"id" => 12,
		"bulan" => "Desember"
	],
);
$bln = "";
for ($a = 0;$a < count($bulan);$a++) {
	if ($bulan[$a]['id'] == $this->input->post('bulan')) {
		$bln = $bulan[$a]['bulan'];
	}
}
?>

	<div class="box-body table-responsive">
		<table width="100%">
			<tr class="tableheader">
				<b>
					<td colspan="2" align="center">REKAP RKAY</td>
				</b>
			</tr>
			<tr class="tableheader">
				<b>
					<?php if ($this->input->post('cabang') == '-') : ?>
						<td colspan="2" align="center"><?php echo "SEMUA CABANG - PINTU ".$pintu ?></td>
					<?php endif; ?>
					<?php if ($this->input->post('cabang') != '-') : ?>
						<td colspan="2" align="center"><?php echo "YDSF ".$grup." CABANG ".$cbg." PINTU ".$pintu ?></td>
					<?php endif; ?>
				</b>
			</tr>
		</table>
		<p>
			<p>
		<table width="100%" border="1">
            <!-- <thead> -->
                <tr>
                    <td rowspan="2" colspan="3" align="center">Nama Program</td>
                    <td colspan="5" align="center">Bulan <?php echo $bln ?></td>
					<td colspan="5" align="center">Bulan Januari sd <?php echo $bln ?></td>
					<td colspan="5" align="center">Pencapaian Setahun</td>
                </tr>
				<tr>
					<td>RKAY 2019(a)</td>
					<td>Perolehan 2019(b)</td>
					<td>Perolehan 2018(c)</td>
					<td>%(b vs a)</td>
					<td>%(b vs c)</td>
					<td>RKAY 2019(a)</td>
					<td>Perolehan 2019(b)</td>
					<td>Perolehan 2018(c)</td>
					<td>%(b vs a)</td>
					<td>%(b vs c)</td>
					<td>RKAY 2019(a)</td>
					<td>Perolehan 2019(b)</td>
					<td>Perolehan 2018(c)</td>
					<td>%(b vs a)</td>
					<td>%(b vs c)</td>
                </tr>
				<?php
					$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = 0; 
					foreach ($rkay as $value) {
						$sum1 += $value->rkay20191;
						$sum2 += $value->per20191;
						$sum3 += $value->per20181;
						$sum4 += $value->rkay20192;
						$sum5 += $value->per20192;
						$sum6 += $value->per20182;
						$sum7 += $value->rkay20193;
						$sum8 += $value->per20193;
						$sum9 += $value->per20183;
						?>
					<tr>
						<td><?php echo $value->rkay_2 ?></td>
						<td><?php echo $value->rkay_1 ?></td>
						<td><?php echo $value->nm_rkay ?></td>
						<td align="right"><?php echo number_format($value->rkay20191,0,'.',',') ?></td>
						<td align="right"><?php echo number_format($value->per20191,0,'.',',') ?></td>
						<td align="right"><?php echo number_format($value->per20181,0,'.',',') ?></td>
						<?php if ($value->per20191 == 0 || $value->rkay20191 == 0 ) : ?>
							<td align="right"><?php echo "0.00%" ?></td>
						<?php endif; ?><?php if ($value->per20191 != 0 && $value->rkay20191 != 0) : ?>
							<td align="right"><?php echo round(100*($value->per20191/$value->rkay20191),2)."%" ?></td>
						<?php endif; ?>
						<?php if ($value->per20191 == 0 || $value->per20181 == 0 ) : ?>
							<td align="right"><?php echo "0.00%" ?></td>
						<?php endif; ?><?php if ($value->per20191 != 0 && $value->per20181 != 0) : ?>
							<td align="right"><?php echo round(100*($value->per20191/$value->per20181),2)."%" ?></td>
						<?php endif; ?>
						<td align="right"><?php echo number_format($value->rkay20192,0,'.',',') ?></td>
						<td align="right"><?php echo number_format($value->per20192,0,'.',',') ?></td>
						<td align="right"><?php echo number_format($value->per20182,0,'.',',') ?></td>
						<?php if ($value->per20192 == 0 || $value->rkay20192 == 0 ) : ?>
							<td align="right"><?php echo "0.00%" ?></td>
						<?php endif; ?><?php if ($value->per20192 != 0 && $value->rkay20192 != 0) : ?>
							<td align="right"><?php echo round(100*($value->per20192/$value->rkay20192),2)."%" ?></td>
						<?php endif; ?>
						<?php if ($value->per20192 == 0 || $value->per20182 == 0 ) : ?>
							<td align="right"><?php echo "0.00%" ?></td>
						<?php endif; ?><?php if ($value->per20192 != 0 && $value->per20182 != 0) : ?>
							<td align="right"><?php echo round(100*($value->per20192/$value->per20182),2)."%" ?></td>
						<?php endif; ?>
						<td align="right"><?php echo number_format($value->rkay20193,0,'.',',') ?></td>
						<td align="right"><?php echo number_format($value->per20193,0,'.',',') ?></td>
						<td align="right"><?php echo number_format($value->per20183,0,'.',',') ?></td>
						<?php if ($value->per20193 == 0 || $value->rkay20193 == 0 ) : ?>
							<td align="right"><?php echo "0.00%" ?></td>
						<?php endif; ?><?php if ($value->per20193 != 0 && $value->rkay20193 != 0) : ?>
							<td align="right"><?php echo round(100*($value->per20193/$value->rkay20193),2)."%" ?></td>
						<?php endif; ?>
						<?php if ($value->per20193 == 0 || $value->per20183 == 0 ) : ?>
							<td align="right"><?php echo "0.00%" ?></td>
						<?php endif; ?><?php if ($value->per20193 != 0 && $value->per20183 != 0) : ?>
							<td align="right"><?php echo round(100*($value->per20193/$value->per20183),2)."%" ?></td>
						<?php endif; ?>
					</tr>
				<?php } ?>
				
				<tr>
					<th colspan="3">Total</th>
					<th style="text-align:right"><?php echo number_format($sum1,0,'.',',') ?></th>
					<th style="text-align:right"><?php echo number_format($sum2,0,'.',',') ?></th>
					<th style="text-align:right"><?php echo number_format($sum3,0,'.',',') ?></th>
					<?php if ($sum2 == 0 || $sum1 == 0 ) : ?>
						<th style="text-align:right"><?php echo "0.00%" ?></th>
					<?php endif; ?><?php if ($sum2 != 0 && $sum1 != 0) : ?>
						<th style="text-align:right"><?php echo round(100*($sum2/$sum1),2)."%" ?></th>
					<?php endif; ?>
					<?php if ($sum2 == 0 || $sum3 == 0 ) : ?>
						<th style="text-align:right"><?php echo "0.00%" ?></th>
					<?php endif; ?><?php if ($sum2 != 0 && $sum3 != 0) : ?>
						<th style="text-align:right"><?php echo round(100*($sum2/$sum3),2)."%" ?></th>
					<?php endif; ?>
					<th style="text-align:right"><?php echo number_format($sum4,0,'.',',') ?></th>
					<th style="text-align:right"><?php echo number_format($sum5,0,'.',',') ?></th>
					<th style="text-align:right"><?php echo number_format($sum6,0,'.',',') ?></th>
					<?php if ($sum5 == 0 || $sum4 == 0 ) : ?>
						<th style="text-align:right"><?php echo "0.00%" ?></th>
					<?php endif; ?><?php if ($sum5 != 0 && $sum4 != 0) : ?>
						<th style="text-align:right"><?php echo round(100*($sum5/$sum4),2)."%" ?></th>
					<?php endif; ?>
					<?php if ($sum5 == 0 || $sum6 == 0 ) : ?>
						<th style="text-align:right"><?php echo "0.00%" ?></th>
					<?php endif; ?><?php if ($sum5 != 0 && $sum6 != 0) : ?>
						<th style="text-align:right"><?php echo round(100*($sum5/$sum6),2)."%" ?></th>
					<?php endif; ?>
					<th style="text-align:right"><?php echo number_format($sum7,0,'.',',') ?></th>
					<th style="text-align:right"><?php echo number_format($sum8,0,'.',',') ?></th>
					<th style="text-align:right"><?php echo number_format($sum9,0,'.',',') ?></th>
					<?php if ($sum8 == 0 || $sum7 == 0 ) : ?>
						<th style="text-align:right"><?php echo "0.00%" ?></th>
					<?php endif; ?><?php if ($sum8 != 0 && $sum7 != 0) : ?>
						<th style="text-align:right"><?php echo round(100*($sum8/$sum7),2)."%" ?></th>
					<?php endif; ?>
					<?php if ($sum8 == 0 || $sum9 == 0 ) : ?>
						<th style="text-align:right"><?php echo "0.00%" ?></th>
					<?php endif; ?><?php if ($sum8 != 0 && $sum9 != 0) : ?>
						<th style="text-align:right"><?php echo round(100*($sum8/$sum9),2)."%" ?></th>
					<?php endif; ?>
				</tr>
				<!-- <tr>
					<td rowspan="2">Tidak Rutin</td>
                </tr>
				<tr>
					<td>a
					</td>
				<tr> -->
            <!-- </thead> -->
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