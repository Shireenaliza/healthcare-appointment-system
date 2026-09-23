<?php
session_start();
include('../config/connection.php');

if (!isset($_SESSION['user']) || $_SESSION['usertype'] != 'p') {
    header('location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $scheduleid = $_GET['id'];
    $email = $_SESSION['user'];
    
    $pat = $database->query("SELECT * FROM patient WHERE pemail='$email'")->fetch_assoc();
    $pid = $pat['pid'];
    
    $apponum_res = $database->query("SELECT COUNT(*) as total FROM appointment WHERE scheduleid='$scheduleid'");
    $apponum = $apponum_res->fetch_assoc()['total'] + 1;
    $date = date('Y-m-d');

    $database->query("INSERT INTO appointment (pid, apponum, scheduleid, appodate) VALUES ('$pid', '$apponum', '$scheduleid', '$date')");
    header('location: index.php?status=booked');
}
?>