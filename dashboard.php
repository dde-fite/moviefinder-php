<?php
include ("includes/connect.php");

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | MovieFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<main class="min-h-screen bg-gray-100">
    <?php
    include ("includes/adminheader.php")
    ?>
    <section class="container mx-auto py-6 px-4 md:px-6">
        <h2 class="text-2xl font-semibold mb-3">
            <?php
            $hour = date("G");

            if($hour > 0 && $hour < 24){
                if($hour >= 3 && $hour < 12)
                {
                    echo "<p>Good Morning, ".$_SESSION['username']."</p>";
                }else if($hour >= 12 && $hour < 17){
                    echo "<p>Good afternoon, ".$_SESSION['username']."</p>";
                }else{
                    echo "<p>Good evening, ".$_SESSION['username']."</p>";
                }
            }
            else {
                echo "<p>Greetings, ".$_SESSION['username']."</p>";
            }
            ?>
        </h2>
        <div class="grid md:grid-cols-3 gap-10 items-start">
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900">Visitas</h2>
                    <div><span class="text-4xl font-semibold">
                        <?php
                        $queryVisits = "SELECT * FROM views WHERE id='1'";

                        if($resultVisits = mysqli_query($enlace, $queryVisits)) {
                             $filaVisits = mysqli_fetch_array($resultVisits);
                             echo $filaVisits["number"];
                        }
                        ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900">Clicks en Anuncios</h2>
                    <div><span class="text-4xl font-semibold">
                        <?php
                        $queryClicks = "SELECT * FROM ads";

                        $totalClicks = 0;

                        if($resultClicks = mysqli_query($enlace, $queryClicks)) {
                            while ($filaClicks = mysqli_fetch_array($resultClicks)) {
                                $totalClicks = $totalClicks + $filaClicks["clicks"];
                            }
                            echo $totalClicks;
                        }
                        ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900">Votos Totales</h2>
                    <div><span class="text-4xl font-semibold">
                        <?php
                        $queryVotes = "SELECT * FROM movies";

                        $totalVotes = 0;

                        if($resultVotes = mysqli_query($enlace, $queryVotes)) {
                            while ($filaVotes = mysqli_fetch_array($resultVotes)) {
                                $totalVotes = $totalVotes + $filaVotes["up_vote"] + $filaVotes["down_vote"];
                            }
                            echo $totalVotes;
                        }
                        ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <p class="mt-8 text-xl">Total Peliculas: <span class="font-semibold">
        <?php
        $query = "SELECT * FROM movies ORDER BY id DESC";

        if($result = mysqli_query($enlace, $query)) {
            echo mysqli_num_rows( $result );
        }
        ?>
            </span></p>
        <div class="grid lg:grid-cols-6 gap-8 mt-3">
            <?php
            $query = "SELECT * FROM movies ORDER BY id DESC";

            if($result = mysqli_query($enlace, $query)) {
                while ($fila = mysqli_fetch_array($result)) {
                    echo '
                    <div class="grid gap-6 relative group">
                        <img
                            src="img/'.$fila["photo"].'"
                            alt="Imagen de Pelicula '.$fila["title"].'"
                            width="450"
                            height="600"
                            class="rounded-lg object-cover w-full aspect-[3/4] group-hover:opacity-50 transition-opacity"
                        />
                        <div class="absolute bottom-20 right-1 flex">
                        <a href="details.php?id='.$fila["id"].'">
                            <img src="img/eye.png" height="32" width="32" class="bg-blue-300 p-1 rounded-lg mx-1 hover:bg-violet-600">
                        </a>
                        <a href="add-movie.php?id='.$fila["id"].'">
                            <img src="img/edit.png" height="32" width="32" class="bg-yellow-300 p-1 rounded-lg mx-1 hover:bg-violet-600">
                        </a>
                        <a href="delete.php?id='.$fila["id"].'">
                            <img src="img/delete.png" height="32" width="32" class="bg-red-300 p-1 rounded-lg mx-1 hover:bg-violet-600">
                        </a>
                        </div>
                        <div class="grid gap-1">
                            <h3 class="font-semibold">'.$fila["title"].' - '.$fila["year"].'</h3>
                            <p class="text-sm leading-none">Average Rating: '.$fila["score"].'</p>
                        </div>
                    </div>
                            ';
                }
            }

            mysqli_close($enlace);
            ?>




        </div>
    </section>
</main>

</body>
</html>
