<?php

require("db-inc.php");

echo $_GET['film_id']; // This value is from the URL
$a = $_GET['film_id'];

$sqlOneResult = "SELECT * FROM film WHERE film_id = $a";



$result = $db->query($sqlOneResult);
$row = $result->fetch()


echo "<h1>".$row["title"]."</h1>";


// Look on week 8 for the files



?>