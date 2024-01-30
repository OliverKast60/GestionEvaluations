<?php

define('DB_SERVER', 'localhost');

define('DB_USER', 'root');

define('DB_PASS', '');

define('DB_NAME', 'geva');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);


if (mysqli_connect_errno()) {

    echo "Echec de connexion à la base des données: " . mysqli_connect_error();
}
