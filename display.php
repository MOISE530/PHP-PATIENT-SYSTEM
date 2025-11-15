<?php
session_start();
include("connect.php");

if(!isset($_SESSION['username'])){
    $current = basename($_SERVER['PHP_SELF']);
    header("Location: login.php?redirect=$current");
    exit;
}
$result = mysqli_query($conn, "SELECT * FROM patients");
?>

<!DOCTYPE html>
<html>
<head><title>Patients</title></head>
<body>
<h2>All Patients</h2>
<a href="insert.php">Add Patient</a> | <a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>Actions</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['patient_id']; ?></td>
    <td><?php echo $row['patient_name']; ?></td>
    <td><?php echo $row['patient_age']; ?></td>
    <td><?php echo $row['patient_gender']; ?></td>
    <td>
        <a href="update.php?id=<?php echo $row['patient_id']; ?>">Edit</a> |
        <a href="delete.php?id=<?php echo $row['patient_id']; ?>" onclick="return confirm('Delete this patient?');">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
<?php mysqli_close($conn); ?>
