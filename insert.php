<?php
session_start();
include("connect.php");

if(!isset($_SESSION['username'])){
    $current = basename($_SERVER['PHP_SELF']);
    header("Location: login.php?redirect=$current");
    exit;
}

if(isset($_POST['submit'])){
    $patient_id     = htmlspecialchars(trim($_POST['patient_id']));
    $patient_name   = htmlspecialchars(trim($_POST['patient_name']));
    $patient_age    = htmlspecialchars(trim($_POST['patient_age']));
    $patient_gender = htmlspecialchars(trim($_POST['patient_gender']));

    if($patient_id && $patient_name && $patient_age && $patient_gender){
        $stmt = mysqli_prepare($conn, "INSERT INTO patients (patient_id, patient_name, patient_age, patient_gender) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isis", $patient_id, $patient_name, $patient_age, $patient_gender);

        if(mysqli_stmt_execute($stmt)){
            header("Location: display.php");
            exit;
        } else {
            $error = "Error inserting record!";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "All fields are required!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head><title>Add Patient</title></head>
<body>
<h2>Add New Patient</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <input type="number" name="patient_id" placeholder="Patient ID" required><br>
    <input type="text" name="patient_name" placeholder="Patient Name" required><br>
    <input type="number" name="patient_age" placeholder="Patient Age" required><br>
    <select name="patient_gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>
    <input type="submit" name="submit" value="Add Patient">
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
