<?php
ob_start();
session_start();
include("dbconnection.php");
date_default_timezone_set('Europe/Paris');
$ldate=date( 'd-m-Y h:i:s A', time () );
$email=$_SESSION['email'];
$sql="UPDATE userlog  SET logout=:ldate WHERE userEmail = '$email' ORDER BY id DESC LIMIT 1";
$query=$dbh->prepare($sql);
$query->bindParam(':ldate',$ldate,PDO::PARAM_STR);
$query->execute();
$_SESSION['errmsg']="Vous vous etes deconnecté!";
unset($_SESSION['cpmsaid']);
session_destroy(); // destroy session
header("location:../../../../../../Erreur-de-connexion.php");
ob_endflush();
?>
