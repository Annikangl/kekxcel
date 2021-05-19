<?php

require "./config/rb-mysql.php";



$host = 'localhost';
$dbname = 'kekxcel_db';
$user = 'root';
$password = 'root';

\R::setup(
    "mysql:host=$host;dbname=$dbname",
    $user,
    $password
); //for both mysql or mariaDB
