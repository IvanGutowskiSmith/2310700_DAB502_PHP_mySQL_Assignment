<?php
// include('pdo-connect-inc.php');
 
$database = "sakila";

include('pdo-connect.php');

// named parameters allow us to use db field names
 
    $name = 'JOE';
   
    
    $stmt = $db->prepare("select * from actor where first_name = :first_name  limit 10");

 

    $stmt->bindParam(':first_name', $name);  // need to use bindParam with a vars

    
    $stmt->execute(); // 

    echo "rows returned = ". $stmt->rowCount();
    echo "<br>";
//var_dump($stmt) ;


    while  ($row  = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $first_name = $row['first_name'];
        echo 'first name = ' . htmlentities($first_name) .  "<br>";        
       
    }

?>