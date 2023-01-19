<?php 
	
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
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

	function rupiah($angka){
		$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
		return $hasil_rupiah;
	}

	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Tampil Cetak Donasi</title>
</head>
<body>

	<?php foreach ($hasil as $tampil) : ?>
	<br><br><br><br>
	<table cellpadding="3" style="margin-left: 3em;">
		<tr>
			<td><?= $tampil->noid; ?> - <?= $tampil->NM_PROGRAM; ?></td>
		</tr>
		<tr>
			<td><?= $tampil->nama;?></td>
		</tr>
		<tr>
			<td><?= $tampil->almktr;?></td>
		</tr>
		<tr>
			<td>
			<?php 
				if($tampil->rk === 'R'){
					echo '-';
				}else{
					echo $tampil->ins_pk;
				}
			?>			
			</td>
		</tr>
		<tr>
			<td><?= $tampil->kwsn; ?></td>
		</tr>
		<tr>	
			<td><?= tgl_indo(date('Y-m-d'));?></td>
		</tr>	
		<tr>
			<td><?php echo rupiah($tampil->besar); ?> ( <?= terbilang($tampil->besar) . ' Rupiah'; ?> )</td>
		</tr>
	</table>
	<br><br><br><br>
	<?php endforeach; ?>
</body>
</html>