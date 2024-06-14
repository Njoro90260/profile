<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="styles.css" class="">
</head>
<body>
    <h1>HELLO THERE!</h1>
    <div class="profile">
        <h2>Your profile details</h2>
        <p>Your details are: </p> <br>

        <?php
include("connect.php");
$table_name = "profiles";

$email = "sharlom@gmail.com";
$selectdata = "SELECT id, person_name, email, profile_pic, reg_date FROM  profiles WHERE email = :email;";
$results = $pdo ->prepare($selectdata);
$results -> execute(['email' => $email]);

if($results->rowCount() > 0 ) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        // $profile_pic = 'data:' .htmlspecialchars($row["profile_pic_mime"]) . ';base64,' . base64_encode($row["profile_pic"]);
        $profile_pic = htmlspecialchars($row["profile_pic"]);
        echo "<tr>
        <td><img src=' " . $profile_pic . " ' alt='profile picture'> <br><br><br></td> </tr>
        <tr> <td>" . htmlspecialchars($row["id"]). "</td> <br> <br><br></tr>
       <tr> <td>Name: " . htmlspecialchars($row["person_name"]). "</td> <br> <br><br></tr>
        <tr> <td>Email: " . htmlspecialchars($row["email"]). "</td><br><br><br> </tr>
        <tr> <td>Day you registered: " . htmlspecialchars($row["reg_date"]). " <td> <br><br><br> 
      </tr>";
    }
echo "</table>";

} else {
    echo "No results found";
}
?>

    </div>
</body>
</html>