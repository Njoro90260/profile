

    <?php
        include("connect.php");
        include("index.html");
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $fname = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lname = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    
        $checkemail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkemail);
    
        if(empty($fname)){
            echo "please enter first name";
        }
        elseif(empty($lname)){
            echo "please enter lastname";
        }
        elseif(empty($email)){
            echo "please enter email";
        }
        elseif(empty($password)){
            echo "please enter password";
        }
        elseif($result->num_rows>0){
            echo "That email allready exist!";
        }
        else{
    
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fname, lname, email, password)
                            VALUES('$fname', '$lname', '$email', '$hash')";
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