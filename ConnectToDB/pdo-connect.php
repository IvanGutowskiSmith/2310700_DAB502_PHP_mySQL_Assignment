<?php
/*

mysql_* commands deprecated and should be replaced...

We can use PDO (PHP data objects )or mysqli

-No risk of SQL injection
-both support prepared statements
-PDO supports more dbs

*/
//show errors
error_reporting(E_ALL);
ini_set('display_errors', 1);


//connect to db


$servername = "localhost";
$username = "root";
$password = "";


try {
  $db = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>

