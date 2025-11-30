<?php
session_start();
include "includes/connect.php";

if (isset($_GET["ad"])) {
    $id = $_GET["ad"];
    $query = "SELECT * FROM ads WHERE id='$id'";

    if($result = mysqli_query($enlace,$query)){
        $fila = mysqli_fetch_array($result);

        $newClicks = $fila['clicks'] + 1;
        $query= "UPDATE ads SET clicks='".$newClicks."' WHERE id='$id'";
        mysqli_query($enlace,$query);
    }
}

if (isset($_GET["redirect"])) {
    $redirect = $_GET["redirect"];
} else {
    $redirect = "index.php";
}
header("Location: $redirect");
exit;

?>
