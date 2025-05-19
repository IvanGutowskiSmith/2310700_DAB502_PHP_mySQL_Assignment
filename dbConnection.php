<?php
/*
More 'graceful' error handling
*/

// Database credentials
$host = 'localhost';
$dbname = 'test'; // Replace with your database name
$username = 'root'; // Default XAMPP MySQL username
$password = '';     // Default XAMPP MySQL password (usually blank)

// Connect to db using PDO
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
} catch(PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    die(); // Terminate the script if connection fails
}

// You can optionally test the connection if needed
// var_dump($db);

?>