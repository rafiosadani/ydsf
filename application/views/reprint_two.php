<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>YDSF | Himpunan</title>
</head>
<body>
	<?php 
		function penyebut($nilai) {
			$nilai = abs($nilai);
			$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
			$temp = "";
			if ($nilai < 12) {
				$temp = " ". $huruf[$nilai];
			} else if ($nilai <20) {
				$temp = penyebut($nilai - 10). " belas";
			} else if ($nilai < 100) {
				$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
			} else if ($nilai < 200) {
				$temp = " seratus" . penyebut($nilai - 100);
			} else if ($nilai < 1000) {
				$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
			} else if ($nilai < 2000) {
				$temp = " seribu" . penyebut($nilai - 1000);
			} else if ($nilai < 1000000) {
				$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
			} else if ($nilai < 1000000000) {
				$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
			} else if ($nilai < 1000000000000) {
				$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
			} else if ($nilai < 1000000000000000) {
				$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
			}     
			return $temp;
		}
 
		function terbilang($nilai) {
			if($nilai<0) {
				$hasil = "minus ". trim(penyebut($nilai));
			} else {
				$hasil = trim(penyebut($nilai));
			}     		
			return $hasil;
		}

		function rupiah($angka) {
			$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
			return $hasil_rupiah; 
		}
	?>
	<table>
		<tr>
			<td><b>Nomer Induk</b></td>
			<td><b>:</b></td>
			<td><?= $this->input->get('noid'); ?></td>
		</tr>
		<tr>
			<td><b>Nama</b></td>
			<td><b>:</b></td>
			<td><?= $this->input->get('nama'); ?></td>
		</tr>
		<tr>
			<td><b>Alamat</b></td>
			<td><b>:</b></td>
			<td><?= $this->input->get('alamat'); ?></td>
		</tr>
		<tr>
			<td><b>Instansi</b></td>
			<td><b>:</b></td>
			<td>
				<?php if ($this->input->get('rk') == 'R') : ?>
					<?php echo "-" ?>
				<?php elseif($this->input->get('rk') == 'K') : ?>
					<?= $this->input->get('ins_pk');  ?>
				<?php endif ?>
			</td>
		</tr>
		<tr>
			<td><b>Bulan</b></td>
			<td><b>:</b></td>
			<td><?= $this->input->get('report_ket'); ?></td>
		</tr>
		<tr>
			<td><b>Jumlah</b></td>
			<td><b>:</b></td>
			<?php $total = $this->input->get('nominal'); ?>
			<td><?php echo rupiah($total) . " (". penyebut($total) .") "; ?></td>
		</tr>
	</table>
</body>
</html>