<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

echo "Welcome, ".$_SESSION['username']."!<br>";

if(isset($_COOKIE['username'])){
    echo "Hello again, ".$_COOKIE['username']."!<br>";
}

echo "<a href='insert.php'>Add Patient</a> | ";
echo "<a href='display.php'>View Patients</a> | ";
echo "<a href='logout.php'>Logout</a>";
?>
