<?php

require("db-inc.php");


$sql = "SELECT * FROM film ORDER BY title DESC LIMIT 20";

foreach ($db->query($sql) AS $row) {
    echo '<a href="filmdetails.php?film_id='.$row['film_id'].'">'.$row['title']."</a><br>";   // DO NOT DO THE <br> in assignment, the question mark says everythign next is a perameter
}


?>