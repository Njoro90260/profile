<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>HELLO THERE!</h1>
    <div class="profile">
        <h2>Your profile details</h2>
        <p>Your details are: </p> <br>

        <?php
        require_once "connect.php";

        // Check if ID is passed in the URL
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];

            try {
                // Prepare the SQL query to fetch user data
                $query = "SELECT id, person_name, email, phone, person_address, profile_pic, reg_date FROM profiles WHERE id = ?";
                $stmt = $pdo->prepare($query);

                // Execute the statement with the user ID
                $stmt->execute([$user_id]);

                // Fetch the user data
                $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user_data) {
                    if ($user_data["profile_pic"]) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($user_data["profile_pic"]) . '" alt="Profile Picture">';
                    }
                } else {
                    echo "<p>No user found with ID " . htmlspecialchars($user_id) . ".</p>";
                }
                    echo "<p><strong>ID:</strong> " . htmlspecialchars($user_data["id"]) . "</p>";
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($user_data["person_name"]) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($user_data["email"]) . "</p>";
                    echo "<p><strong>Phone:</strong> " . htmlspecialchars($user_data["phone"]) . "</p>";
                    echo "<p><strong>Address:</strong> " . htmlspecialchars($user_data["person_address"]) . "</p>";
                    echo "<p><strong>Day you registered:</strong> " . htmlspecialchars($user_data["reg_date"]) . "</p>";

            

                // Close the database connection
                $pdo = null;
                $stmt = null;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        } else {
            echo "<p>No user ID provided.</p>";
        }
        ?>

    </div>
</body>

</html>
