<?php 
session_start();
include('db.inc.php');
$UUID = $_POST['UUID'];

$r = $conn->prepare("DELETE FROM `notes` WHERE UUID = :uuid");
$r->bindValue(':uuid',htmlspecialchars_decode($UUID));
$r->execute();
if ($r->rowCount() == 0){
	exit();
}








 ?>