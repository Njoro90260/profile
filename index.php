<?php
include ("connect.php");
include ("index.html");

function checkAndCreateTable($pdo, $table_name)
{
    // Use prepared statements for safety
    $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
    $stmt->execute([$table_name]);

    // If the result contains any rows, the table exists
    if ($stmt->rowCount() > 0) {
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
            -- profile_pic LONGBLOB NOT NULL,
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

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $person_name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $user_password = filter_input(INPUT_POST,'user_password', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone_number = filter_input(INPUT_POST,'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $person_address = filter_input(INPUT_POST,'address', FILTER_SANITIZE_SPECIAL_CHARS);

    try{
        $smt = $pdo->prepare("INSERT INTO profiles (person_name, email, user_password, phone, person_address,) VALUES (:person_name, :email, :user_password, :phone, :person_address)");
        $smt->bindparam(':person_name', $person_name);
        $smt->bindparam(':email', $email);
        $smt->bindparam(':password', $user_password);
        $smt->bindparam(':phone_number', $phone_number);
        $smt->bindparam(':address', $person_address);

        $stmt->execute();
    
            //  if ($stmt->execute()) {
            //      echo "Image uploaded and stored successfully.";
            //  } else {
            //      echo "Error: " . $stmt->error;
            //  }
         
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getmessage();
    }
   $smt->close();
 }
 else {
     echo "Nothing uploaded";
 }
 



$pdo = null;

    //  $imageName = $_FILES['profile_pic']['name'];
    //  $imageData = file_get_contents($_FILES['profile_pic']['tmp_name']);


    // $stmt->send_long_data(1, $imageData);
//      $null = NULL;
//      $stmt->bind_param("profile_pic", $imageName, $null);
 
//      $stmt->send_long_data(1, $imageData);
//      if ($stmt->execute()) {
//          echo "Image uploaded and stored successfully.";
//      } else {
//          echo "Error: " . $stmt->error;
//      }
 
//      $stmt->close();
//   


// try{
//     $smt = $pdo->prepare("INSERT INTO profiles(id, person_name, email, postal_code, reg_date)
//     VALUES(:person_name, :email, :user_password, :postalcode)");
//     
//     echo "New records created succesfully";
// }
// catch(PDOException $e)
// {
//     echo "Error: " . $e->getmessage();
// }

//CLOSE CONNECTION
