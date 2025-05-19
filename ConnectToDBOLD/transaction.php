<h2>MySQL Transaction</h2>
<style>
    body {
       font-size: 18px;
       font-family: Verdana;
    }
    .msg {
        color: red;
    }

</style>
<?php
//update the balance of two rows in customer table.
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!$db = new PDO('mysql:host=localhost; dbname=banktransactions;','root','')) echo 'connection failed';


function showBalances(){
   global $db;    
   $getdatasql = 'select * from bank where customer_id in (1,2)';
    
     echo $getdatasql . "<p>";
     foreach ($db->query($getdatasql) as $row) {
  
        echo htmlentities($row['first_name']). " ";
        echo htmlentities($row['last_name']). " ";
        echo "<strong>&pound;". number_format(htmlentities($row['balance'])) . "</strong><br>";
        echo '<hr>';
    }
}
 



showBalances();

// exit;   // uncomment to just show balances

// 'balance' field added to sakila.customer table

 
//////////// transaction ///////////
    $amount = 10;
    # debit
    $debitsql = 'UPDATE bank SET balance = balance - :amount WHERE customer_id = 1';
    $debit = $db->prepare($debitsql);
    $debit->bindParam(':amount', $amount);
    
   # credit
    $creditsql = 'UPDATE bank SET balance = balance + :amount WHERE customer_id = 2';
    $credit = $db->prepare($creditsql);
    $credit->bindParam(':amount', $amount);
     
    $db->beginTransaction();
    $debit->execute();
    
//echo $debitsql;
//echo '<br>'.$creditsql;
// a successful transaction will return a row count of 1 if succesful and 0 if fails

   if (!$debit->rowCount()){
        
        $db->rollBack();
        $error = "<p class='msg'>debit transaction failed</p>";

    }

    else {
        
         $credit->execute();
        if (!$credit->rowCount()){
        
            $db->rollBack();
            $error = "credit transaction failed";
        }
        
        else {
            $db->commit();
        }
    
        
    }

if (isset($error)) {
    echo "<p>$error</p>";
}

// after transaction

echo '<hr><p>after transaction</p>';
showBalances();

?>


