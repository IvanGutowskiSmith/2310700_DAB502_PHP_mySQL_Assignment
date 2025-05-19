<?php
/*
More 'graceful' error handling
*/
 
//connect to db
try {
$db = new PDO('mysql:host=localhost; dbname=sakila;','root','');

}


catch(Exception $e) {
  
    echo $e->getMessage();
} 


var_dump($db);


?>