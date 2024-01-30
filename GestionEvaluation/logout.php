<?php
ob_start();
session_start();
include("includes/dbconnection.php");
date_default_timezone_set('Africa/Goma');
$ldate = date('d-m-Y h:i:s A', time());
$username = $_SESSION['name'];
$sql = "UPDATE userlog  SET logout=:ldate WHERE name like '$username' ORDER BY id DESC LIMIT 1";
$query = $dbh->prepare($sql);
$query->bindParam(':ldate', $ldate, PDO::PARAM_STR);
$query->execute();

echo "<script>alert('Vous serez déconnecté!!.');</script>";

$_SESSION['errmsg'] = "Vous serez déconnecté!";

unset($_SESSION['cpmsaid']);
session_destroy(); // destroy session
header("location:../index.php");
ob_end_flush();
