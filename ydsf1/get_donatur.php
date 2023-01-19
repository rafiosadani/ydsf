<?php 
include_once 'config.php';
if ($_GET['kwsn'] == '') {
	$stmt = $connection->prepare("SELECT noid,alamat,nama,kwsn,email from donatur where email IS NOT NULL  AND email != '' ");
	$stmt->execute();
}
else{
	$stmt = $connection->prepare("SELECT noid,alamat,nama,kwsn,email from donatur where email IS NOT NULL  AND email != '' AND kwsn = ? ");
	$stmt->execute([$_GET['kwsn']]);
}
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>