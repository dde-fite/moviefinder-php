<?php

$hostname = "localhost";
$database = "buscacine-es";
$username = "root";
$password = "root";

$enlace = mysqli_connect($hostname,$username,$password,$database);

//header("Content-Type: text/html;charset=utf-8");

$enlace->query("SET NAMES 'utf8'");

if (mysqli_connect_errno()) {
    echo "No se ha podido conectar: " . mysqli_connect_error();
}

?>