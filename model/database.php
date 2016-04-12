<?php
header("Content-type: text/html; charset=utf-8");
$dsn='mysql:dbname=sd;host=localhost';
$user='sd';
$password='sd'; //not real password
try{
	$db=new PDO($dsn,$user,$password);
	$db->exec("set names utf8");
}
catch(PDOException $e){
	die($e->getMessage());
}
?>
