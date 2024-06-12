

    <?php
        include("connect.php");
        include("index.html");
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = filter_input(INPUT_POST, "person_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        // $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $phonenumber = filter_input(INPUT_POST, "phone_number", FILTER_SANITIZE_NUMBER_INT);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
        // $checkemail = "SELECT * FROM users WHERE email='$email'";
        // $result = $conn->query($checkemail);
    
        if(empty($name)){
            echo "please enter name";
        }
        elseif(empty($email)){
            echo "please enter email";
        }
        elseif(empty($phonenumber)){
            echo "enter phone number";
        }
        elseif(empty($address)) {
            echo "please enter address";
        }
        // elseif($result->num_rows>0){
        //     echo "That email allready exist!";
        // }
        else{
    
            // $hash = password_hash($password, PASSWORD_DEFAULT);
            // $sql = "INSERT INTO profiles (name, email, phone, address, profile_pic)
            //                 VALUES('$name', '$email', '$phone', '$address', '$profile_pic)";
            $sql = "INSERT INTO profiles VALUES('$name', '$email', '$phone', '$address', '$profile_pic')";
            if(mysqli_query($conn, $sql)){
                header("loation: index.php");
            }
            else{
                echo "Error:".$conn->error;
            }
            
    
        }
    
    
    
    }
    mysqli_close($conn);
    
    
    
    ?>