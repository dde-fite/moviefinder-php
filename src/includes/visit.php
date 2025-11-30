<?php
include "includes/connect.php";

$query = "SELECT * FROM views WHERE id='1'";

if($result = mysqli_query($enlace,$query)){
    $fila = mysqli_fetch_array($result);

    $newVisit = $fila['number'] + 1;
    $query= "UPDATE views SET number='".$newVisit."' WHERE id='1'";
    mysqli_query($enlace,$query);
    }

mysqli_close($enlace);
?>