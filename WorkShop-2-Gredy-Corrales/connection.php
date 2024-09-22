<?php

$server     = "localhost";
$user       = "root";
$password   = "";
$db         = "registration_workshop2";

$connection = mysqli_connect($server, $user, $password, $db);

if ($connection->connect_errno) {
    die("Failed Connection" . $connection->connect_errno);
} 

?>