<?php
include_once "config.php";
$stmt = $connection->prepare("SELECT kwsn,nm_kawasan,kwsn_lm FROM kawasan WHERE kodejgt = ? ORDER BY kwsn ASC");
$stmt->execute([$_GET['kodej']]);
$data= $stmt->fetchAll(PDO::FETCH_ASSOC);
// if (count($data) > 0) {
// 	foreach ($data as $row)
// 		$arr_result[] = array(
// 			'label'	=> $row->nm_kawasan,
// 		);
// 	echo json_encode($arr_result);
// }
echo json_encode($data);

?>