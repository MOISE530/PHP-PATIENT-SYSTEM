<?php
session_start();
include("connect.php");

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
$cookie_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']); // checkbox

    $stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $db_password);
    mysqli_stmt_fetch($stmt);

    if($db_password){
        if($password === $db_password){
            $_SESSION['username'] = $username;

            // Set or delete cookie
            if($remember){
                setcookie("username", $username, time() + (86400*7), "/"); // 7 days
            } else {
                setcookie("username", "", time() - 3600, "/"); // delete
            }

            header("Location: $redirect");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    Username: <input type="text" name="username" value="<?php echo htmlspecialchars($cookie_username); ?>" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <label>
        <input type="checkbox" name="remember" <?php if($cookie_username) echo "checked"; ?>> Remember Me
    </label><br><br>
    <input type="submit" name="login" value="Login">
</form>
</body>
</html>
