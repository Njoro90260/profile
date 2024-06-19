<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $person_name = $_POST["person_name"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $phone = $_POST["phone_number"];
    $address = $_POST["address"];
    $profile_pic = null;

    // Check if a file was uploaded
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        // Get the image file's binary data
        $profile_pic = file_get_contents($_FILES['profile_pic']['tmp_name']);
    } else {
        echo "Failed to upload image";
        exit();
    }

    try {
        require_once "connect.php";
        $hash = password_hash($pwd, PASSWORD_DEFAULT);

        $query = "INSERT INTO profiles (person_name, email, user_password, phone, person_address, profile_pic) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);

        // Execute the statement
        $stmt->execute([$person_name, $email, $hash, $phone, $address, $profile_pic]);

        // Get the last inserted ID to pass it to profile.php
        $last_id = $pdo->lastInsertId();

        // Close the database connection
        $pdo = null;
        $stmt = null;

        // Redirect to profile.php with the user ID
        header("Location: profile.php?id=" . $last_id);
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect to index.html if accessed directly
    header("Location: index.html");
    exit();
}

function getEmailFromPost() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
        return $_POST["email"];
    }
    return null;
}

