<?php 
include 'config.php';
$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
$foto;
$image1;
$image2;
if($_FILES['foto']){
	$nama = $_FILES['foto']['name'];
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['foto']['size'];
	$file_tmp = $_FILES['foto']['tmp_name'];	

	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){			
			
			$query = move_uploaded_file($file_tmp, 'img/'.$nama);
			if($query){
				$foto = $nama;
			}else{
				echo 'GAGAL MENGUPLOAD GAMBAR';
			}
		}else{
			echo 'UKURAN FILE TERLALU BESAR';
		}
	}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
	}
}
if($_FILES['image2']){
	$nama = $_FILES['image2']['name'];
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['image2']['size'];
	$file_tmp = $_FILES['image2']['tmp_name'];	

	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){			
			
			$query = move_uploaded_file($file_tmp, 'img/'.$nama);
			if($query){
				$image2 = $nama;
			}else{
				echo 'GAGAL MENGUPLOAD GAMBAR';
			}
		}else{
			echo 'UKURAN FILE TERLALU BESAR';
		}
	}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
	}
}
if($_FILES['image1']){
	$nama = $_FILES['image1']['name'];
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['image1']['size'];
	$file_tmp = $_FILES['image1']['tmp_name'];	

	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){			
			
			$query = move_uploaded_file($file_tmp, 'img/'.$nama);
			if($query){
				$image1 = $nama;
			}else{
				echo 'GAGAL MENGUPLOAD GAMBAR';
			}
		}else{
			echo 'UKURAN FILE TERLALU BESAR';
		}
	}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
	}
}
if (isset($_POST['artikel'],$_POST['sambutan'],$_POST['periode'])) {
	// $stmt = $connection->prepare("INSERT INTO config_report(periode,artikel,sambutan,image_page1,image_page2,small_image) VALUE(?,?,?,?,?,?)");
	$stmt = $connection->prepare("UPDATE config_report SET periode = ?,artikel = ?, sambutan = ?, image_page1 = ?, image_page2 = ?, small_image = ? WHERE id = 1");
	$stmt->execute([$_POST['periode'],$_POST['artikel'],$_POST['sambutan'],$image1,$image2,$foto]);
}

?>