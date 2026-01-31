<?php 
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}

// Fix the include path - we're already in the includes directory
include('connect.php');

$userid = $_SESSION['userid'];
$up = $conn->query("SELECT * FROM users where id = $userid ");

date_default_timezone_set('Africa/Cairo');





?>
<html>
<body>
   