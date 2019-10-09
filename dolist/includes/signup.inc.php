<?php
include('db.inc.php');
session_start();


function generateMDGUID(){
    $theMDGUID = "";
    if(function_exists("com_create_guid") === true) { $theMDGUID = md5(time()) . "-" . trim(com_create_guid(), "{}"); }
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    $theMDGUID = md5(time()) . "-" . vsprintf("%s%s-%s-%s-%s-%s%s%s", str_split(bin2hex($data), 4));
    return $theMDGUID;
}
function validString($string,$stringConf) {
  $containsSmallLetter = preg_match('/[a-z]/', $string);
  $containsCapsLetter = preg_match('/[A-Z]/', $string);
  $containsDigit = preg_match('/\d/', $string);
  $containsSpecial = preg_match('/[^a-zA-Z\d]/', $string);
  return ($containsSmallLetter && $containsCapsLetter && $containsDigit && $containsSpecial);
}




$us = $_POST['user'];
$pw = $_POST['password'];
$pwconf = $_POST['passwordconf'];





if ($us !== strip_tags($us)) {
    $_SESSION['tempT']= "Signup Error";
    $_SESSION['temp']="Username '<b>".htmlspecialchars($us)."</b>' Contains HTML Tags! ";
    header('Location: ../signup.php');
    exit();     
}
$us = strip_tags($us);
$notAllowedChars = ['/',"'",'"',"\\","(",")","[","]","{","}"];
foreach ($notAllowedChars as $val) {
    if (strpos($us,$val) !== false){
        $_SESSION['tempT']= "Signup Error";
        $_SESSION['temp']="Username '<b>".$us."</b>' Contains Banned Chars! ";
        header('Location: ../signup.php');
        exit(); 
    }
}





if($pw != $pwconf){
    $_SESSION['tempT']= "Signup Error";
    $_SESSION['temp']="Passwords Don't Match! ";
    header('Location: ../signup.php');
    exit();
}
if(validString($pw,$pwconf) == false){
    $_SESSION['tempT']= "Signup Error";
    $_SESSION['temp']='Password Not Strong Enough';
    header('Location: ../signup.php');
    exit();
}




$r = $conn->prepare("SELECT * FROM `users` where upper(`username`) = upper(:us)");
$r->bindValue(':us',$us);
$r->execute();
//print_r($r->fetchAll(PDO::FETCH_ASSOC));
if ($r->rowCount() >= 1){
    $_SESSION['tempT']= "Signup Error";
    $_SESSION['temp']="Username '<b>".$us."</b>' Is Taken! ";
    header('Location: ../signup.php');
    exit();
}
$r= null;






$UUID = substr(generateMDGUID(), 0, 255);
$r = $conn->prepare("INSERT INTO `users`(`UUID`, `username`, `password`) VALUES (:UUID,:US,:PW)");
$r->bindValue(':UUID',$UUID);
$r->bindValue(':US',$us);
$r->bindValue(':PW',password_hash($pw, PASSWORD_DEFAULT));
$r->execute();
if ($r->rowCount() >= 1){
    $_SESSION['tempT']= "Signup Successful";
    $_SESSION['temp']=$us.", Your account has been created <a href='./login.php'>Login!</a> ";
    header('Location: ../signup.php');
    exit();
}





?>