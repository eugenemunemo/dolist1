<?php
//PDO OOP approach//////////////////////////////////////////////////////////
/*
Requires a database name or will return error
PDO works with 12 different database systems, whereas MySQLi
only works with MySQL databases
You only have to change the connection string and a few queries
see excpetions/trycatch.php for details on exceptions
*/
$servername = "167.71.74.228";
$username = "eugene";
$password = "Exertion42Flak22sitters";
try {
   $conn = new PDO("mysql:host=$servername;port=3306;dbname=2019BWebIntensive_eugene", $username, $password);
   // set the PDO error mode to exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Connected successfully";
   }
catch(PDOException $e)
   {
   echo "Connection failed: " . $e->getMessage();
   }
?>
