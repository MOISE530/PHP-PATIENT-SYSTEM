<?php
include "connect.php";

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

   // $hash_password=password_hash($password, PASSWORD_DEFAULT);

    // Insert user directly (NOT hashed)
    $sql =$conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $sql->bind_param("ss",$username,$password);

    $sql->execute();
    $sql->close();
    $conn->close();
        echo "Signup successful! <a href='Login.php'>Login here</a>";
    } 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>
    <h2>Create Account</h2>

    <form action="" method="POST">
        Username: <br>
        <input type="text" name="username" required><br><br>

        Password: <br>
        <input type="text" name="password" required><br><br>

        <input type="submit" name="signup" value="Signup">
    </form>
</body>
</html>
