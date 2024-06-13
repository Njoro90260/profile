<?php
include ("connect.php");

function checkAndCreateTable($pdo, $table_name)
{
    // Use prepared statements for safety
    $smt = $pdo->prepare("SHOW TABLES LIKE ?");
    $smt->execute([$table_name]);

    // If the result contains any rows, the table exists
    if ($smt->rowCount() > 0) {
        return true;
    } else {
        // SQL TO CREATE TABLE
        $createTablesql = "CREATE TABLE $table_name (
            id  INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            person_name VARCHAR(30) NOT NULL,
            email VARCHAR(100) NOT NULL,
            user_password varchar(255),
            phone varchar(15),
            person_address text,
            profile_pic BLOB NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        // EXCECUTE QUERRY
        try {
            $pdo->exec( $createTablesql);
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage();
        }
        return false;
    }
}
$table_name = "profiles";

 // Call the function
 checkAndCreateTable($pdo, $table_name);
//close connection
// $pdo = null;