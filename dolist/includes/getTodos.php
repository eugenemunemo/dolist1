<?php
include('db.inc.php');
$sort = $_COOKIE['sortBy'];
switch ($sort){
    case "newOld":
        $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `created` DESC");        
        break;
    case "oldNew":
        $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `created` ASC");        
        break;
    case "az":
        $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `title` ASC");        
        break;
    case "za":
        $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `title` DESC");        
        break;
    default:
        $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid");

}
$r->bindValue(':uuid',$UUID);
$r->execute();
if ($r->rowCount() == 0){
    echo "<h3>No Cur</h3>";
    $empty = true;
}else{
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
        if ($row['completed'] == 1) {
            echo "<li class='checked'>".$row['title']."</li>";
        }else{
            echo "<li>".$row['title']."</li>";
        }
        echo "<li>" . $row['created'] . "</li>";
    }
 }
 ?>