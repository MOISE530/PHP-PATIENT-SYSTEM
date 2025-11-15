<?php
session_start();
include("connect.php");

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: display_patients.php");
    exit;
}

$id = intval($_GET['id']);
$error = "";

if(isset($_POST['update'])){
    $patient_name   = htmlspecialchars(trim($_POST['patient_name']));
    $patient_age    = htmlspecialchars(trim($_POST['patient_age']));
    $patient_gender = htmlspecialchars(trim($_POST['patient_gender']));

    if($patient_name && $patient_age && $patient_gender){
        $stmt = mysqli_prepare($conn, "UPDATE patients SET patient_name=?, patient_age=?, patient_gender=? WHERE patient_id=?");
        mysqli_stmt_bind_param($stmt, "sisi", $patient_name, $patient_age, $patient_gender, $id);
        if(mysqli_stmt_execute($stmt)){
            header("Location: display_patients.php");
            exit;
        } else {
            $error = "Error updating record!";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "All fields are required!";
    }
}

$stmt = mysqli_prepare($conn, "SELECT patient_name, patient_age, patient_gender FROM patients WHERE patient_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name, $age, $gender);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head><title>Edit Patient</title></head>
<body>
<h2>Edit Patient</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <input type="text" name="patient_name" value="<?php echo $name; ?>" required><br>
    <input type="number" name="patient_age" value="<?php echo $age; ?>" required><br>
    <select name="patient_gender" required>
        <option value="">Select Gender</option>
        <option value="Male" <?php if($gender=="Male") echo "selected"; ?>>Male</option>
        <option value="Female" <?php if($gender=="Female") echo "selected"; ?>>Female</option>
    </select><br>
    <input type="submit" name="update" value="Update Patient">
</form>
<a href="display.php">Back to Patients</a>
</body>
</html>
