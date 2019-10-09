<?php
function generateMDGUID(){
    $theMDGUID = "";
    if(function_exists("com_create_guid") === true) { $theMDGUID = md5(time()) . "-" . trim(com_create_guid(), "{}"); }
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    $theMDGUID = md5(time()) . "-" . vsprintf("%s%s-%s-%s-%s-%s%s%s", str_split(bin2hex($data), 4));
    return $theMDGUID;
}

include('db.inc.php');
$r = $conn->prepare("INSERT INTO `notes`(`UUID`, `authorUUID`, `title`, `completed`, `created`) VALUES (:uuid,:authUUID,:title,0,:created)");
$r->bindValue(':uuid',generateMDGUID());
$r->bindValue(':authUUID',$_POST['authUUID']);
$r->bindValue(':title',$_POST['title']);
$r->bindValue(':created',date("Y-m-d H:i:s", time()));
$r->execute();
if ($r->rowCount() == 0){
    exit();
}else{
	return true;
}

?>