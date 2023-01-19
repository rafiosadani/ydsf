<?php

$databaseHost = '202.154.58.50';
$databaseName = 'ydsf_himpunan_old';
$databaseUsername = 'magang';
$databasePassword = 'magang';
$base_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$site_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$site_url .= "://".$_SERVER['HTTP_HOST']."/";
try {
	$con = mysqli_connect("202.154.58.50","magang","magang","ydsf_himpunan_old");
	$connection = new PDO("mysql:host=202.154.58.50;dbname=ydsf_himpunan_old","magang","magang");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception){
	echo $exception->getMessage();}
// echo $base_url;
?>
	
