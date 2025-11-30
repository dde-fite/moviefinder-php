<?php
include ("includes/connect.php");


if (isset($_POST["id_pelicula"]) && isset($_POST["vote"])) {
    $id_pelicula = $_POST["id_pelicula"];
    $vote = $_POST["vote"];

    $cookie_name = "vote_" . $id_pelicula;

    if (!isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, $vote, time() + (86400 * 30), "/");
        if ($vote == 1) {
            $query = "UPDATE movies SET up_vote = up_vote + 1 WHERE id = $id_pelicula";
            mysqli_query($enlace,$query);
            updateDB();
        } elseif ($vote == -1) {
            $query = "UPDATE movies SET down_vote = up_vote + 1 WHERE id = $id_pelicula";
            mysqli_query($enlace,$query);
            updateDB();
        }
    }
}

header('Location: details.php?id='.$id_pelicula);
exit;




function updateDB () {

    include ("includes/connect.php");
    $id_pelicula = $_POST["id_pelicula"];

    $query = "SELECT * FROM movies WHERE id = '".$id_pelicula."'";

    if($result = mysqli_query($enlace, $query)) {
        while ($fila = mysqli_fetch_array($result)) {
            $up_vote = $fila["up_vote"] + 1;
            $down_vote = $fila["down_vote"] + 1;
        }
    }

    $percentUpVote = $up_vote/($up_vote+$down_vote);

    $new_score = number_format(10*($percentUpVote) , 1);

    $query = "UPDATE movies SET score = ". $new_score ." WHERE id = ".$id_pelicula;
    mysqli_query($enlace,$query);
}

mysqli_close($enlace);

?>