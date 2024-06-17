<?php
    require_once "index.html";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $person_name = $_POST["person_name"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        $phone = $_POST["phone_number"];
        $address = $_POST["address"];
        $profile_pic = $_POST["profile_pic"];
    
        //check if file was uploaded
        if (isset($_FILES['profile_pic']) && $_FILES['image']['error'] == 0) {
            // get the image file's binary data
            $imagedata = file_get_contents($_FILES['profile_pic']['tmp_name']);
        } else {
            echo "failed to upload image";
        }
    
        try{
            require_once "connect.php";
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
    
            $querry = "INSERT INTO profiles (person_name, email, user_password, phone, person_address, profile_pic) VALUES 
            (?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($querry);
            // $stmt->bindparam(":profile_pic", $imagedata PDO::PARAM_LOB);
    
    
    //excecute the statement
         $stmt->execute([$person_name, $email, $hash, $phone, $address, $imagedata]);
    
    
            $pdo = null;
            $stmt = null;
    
            header("Location: profile.php");
    
            die();
        } catch (PDOException $e) {
            die("Querry failed: " . $e->getMessage());
        }
    } else {
        header("locaton: index.php");
    }

function getemail($email) {

    return $email;
}