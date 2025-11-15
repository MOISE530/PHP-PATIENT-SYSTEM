<?php
session_start();
include("connect.php");

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM patients WHERE patient_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
header("Location: display.php");
exit;
?>
