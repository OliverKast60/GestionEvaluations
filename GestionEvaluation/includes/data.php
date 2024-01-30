<?php
	$conn = new mysqli("localhost", "root", "", "sdmsdb");
 
	if ($conn->connect_error) {
	    die("Echec de connexion: " . $conn->connect_error);
	}

	//$cat = array();

	//for canceled
	$sql="select count(id) as cn from booking where cancelevent=1";
	$query=$conn->query($sql);
	$canc = $query->num_rows;

	//for repporter
	$sql="select count(id) as cn from booking where repportevent=1";
	$aquery=$conn->query($sql);
	$repport = $aquery->num_rows;

	//for en cours
	$sql="select count(id) as cn from booking where statusevent=1";
	$vquery=$conn->query($sql);
	$cours = $vquery->num_rows;

	//for passee
	$sql="select count(id) as cn from booking left statusevent=2";
	$squery=$conn->query($sql);
	$pass = $squery->num_rows;
