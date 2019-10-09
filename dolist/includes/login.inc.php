<?php 
session_start();
include('db.inc.php');
$us = $_POST['user'];
$pw = $_POST['password'];

$r = $conn->prepare("SELECT * FROM `users` WHERE upper(username) = upper(:us)");
$r->bindValue(':us',$us);
$r->execute();
if ($r->rowCount() == 0){
	$_SESSION['tempT']= "Login Error";
	$_SESSION['temp']= "Incorrect Credentials!";
	header('Location: ../login.php');
	exit();
}
while ($row = $r->fetch(PDO::FETCH_ASSOC)){
	if (password_verify($pw, $row['password']) == true){
		$_SESSION['UUID'] = $row['UUID'];
		$_SESSION['username'] = $row['username'];
		header('Location: ../index.php');
    	exit();
	}else{
		$_SESSION['tempT']= "Login Error";
    	$_SESSION['temp']= "Incorrect Credentials!";
    	header('Location: ../login.php');
    	exit();	
	}   
}







 ?>