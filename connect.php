<?php
// PDO connection
$dsn = "mysql:host=localhost; dbname=website";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    // set the PDO error mode to exception
    $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected successfully";
} catch (PDOException $e) {
    //throw $th;
    die("connection failed: " . $e->getMessage());
}

//close the connection
// $pdo = null;