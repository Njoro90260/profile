<?php
include("index.html");

class Person {
    public $person_name;
    public $email;
    public $pwd;
    public $phone;
    public $address;
    public $profile_pic;

    public function __construct($name, $email, $pwd, $phone, $address, $profile_pic){
        $this->person_name = $name;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->phone = $phone;
        $this->address = $address;
        $this->profile_pic = $profile_pic;
    }
    public static function get_user_data() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $person_name = filter_input(INPUT_POST, "person_name", FILTER_SANITIZE_SPECIAL_CHARS);//$_POST["person_name"];
            $email =  filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);//$_POST["email"];
            $pwd =  filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);//$_POST["password"];
            $phone =  filter_input(INPUT_POST, "phone_number", FILTER_SANITIZE_SPECIAL_CHARS);//$_POST["phone_number"];
            $address =  filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);//$_POST["address"];
            $profile_pic = null;
            //check if file was uploaded
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

                //validate the file type to only allow images
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['profile_pic']['type'], $allowed_types)) {
                    //sanitize file name
                    $profile_pic_name = basename($_FILES['profile_pic']['name']);
                    $profile_pic_name =preg_replace("/[^a-zA-Z0-9\._-]/", "", $profile_pic_name);
                    //move file to a safe location
                    $upload_dir = 'uploads/';
                    $profile_pic_path = $upload_dir . $profile_pic_name;
                    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_path)) {
                        $profile_pic = $profile_pic_path;
                    } else {
                        echo "Failed to upload file.";
                    }
                } else {
                    echo "Invalid file type";
                }

                // get the image file's binary data
                // $imagedata = file_get_contents($_FILES['profile_pic']['tmp_name']);
            } else {
                echo "failed to upload image";
            }
            
            return new self($person_name, $email, $pwd, $phone, $address, $profile_pic);
        }
            else
            {
                header("locaton: index.php");
                exit();
            }
             
    }
    public function insert_into_database() {
        $this->get_user_data();
        try{
            require_once "connect.php";
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
    
            $querry = "INSERT INTO profiles (person_name, email, user_password, phone, person_address, profile_pic) VALUES 
            (?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($querry);
            // $stmt->bindparam(":profile_pic", $imagedata PDO::PARAM_LOB);
    
    
    //excecute the statement
         $stmt->execute([$person_name, $email, $hash, $phone, $address, $imagedata]);
    
    
            // $pdo = null;
            $stmt = null;
    
            header("Location: profile.php");
    
            die();
        } catch (PDOException $e) {
            die("Querry failed: " . $e->getMessage());
        }
    }
    //get email
    function getemail($email) {
        $email = $_POST["email"];
        return $this->email;
    }
}
//usage example
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $person = Person::get_user_data();
    $person->insert_into_database();
}
    
