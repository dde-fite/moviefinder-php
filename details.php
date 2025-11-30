<?php
include("includes/visit.php")
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        } else {
            header('Location: index.php');
            exit;
        }
        include ("includes/connect.php");

        $query = "SELECT * FROM movies WHERE id = '".$id."'";

        if($result = mysqli_query($enlace, $query)) {
            $fila = mysqli_fetch_array($result);
            echo "<title>".$fila['title']." | MovieFinder</title>";
        }



    ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php
include ("includes/adminbar.php")
?>
<main class="min-h-screen bg-gray-100">
    <header class="bg-white shadow-sm py-4 px-6">
        <div class="container mx-auto flex items-center justify-between">
            <a class="flex items-center text-2xl font-bold text-gray-900" href="index.php" rel="ugc">
                <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="h-6 w-6 mr-2"
                >
                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                    <path d="M7 3v18"></path>
                    <path d="M3 7.5h4"></path>
                    <path d="M3 12h18"></path>
                    <path d="M3 16.5h4"></path>
                    <path d="M17 3v18"></path>
                    <path d="M17 7.5h4"></path>
                    <path d="M17 16.5h4"></path>
                </svg>
                MovieFinder
            </a>
            <div class="flex items-center gap-4">
                <form action="index.php" class="relative">
                    <input
                            class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-64"
                            placeholder="Search movies..."
                            type="search"
                            name="search"
                    />
                    <button
                            type="submit"
                            class="absolute right-2 top-2">
                        <img src="img/search.png" height="24" width="24">
                    </button>
                </form>
                <div class="flex items-center gap-4">
                    <a class="text-gray-900" href="by-genre.php" rel="ugc">
                        Por Genero
                    </a>
                    <a class="text-gray-900" href="index.php?last=TRUE" rel="ugc">
                        Mas Votadas
                    </a>
                    <a class="text-gray-900" href="?year=2023&yrtitle=TRUE">
                        2023
                    </a>
                    <a class="text-gray-900" href="?last=TRUE">
                        Ultimas
                    </a>
                </div>
            </div>
        </div>
    </header>
    <section class="container mx-auto py-6 px-4 md:px-6">
        <div class="grid md:grid-cols-[1fr] gap-10 items-start">
            <div class="grid gap-6 md:gap-8">
                <div class="grid lg:grid-cols-2 gap-8">
                    <?php
                    if($result = mysqli_query($enlace, $query)) {
                        $fila = mysqli_fetch_array($result);

                        // URL del JSON externo
                        $json_url = 'https://flagcdn.com/es/codes.json';

                        // Obtener el contenido del JSON
                        $json_data = file_get_contents($json_url);

                        // Decodificar el JSON en un array asociativo
                        $data_array = json_decode($json_data, true);

                        $nombre_pais = $fila["country"]; // Puedes cambiarlo al país que desees

                        // Buscar el código del país en el array
                        foreach ($data_array as $codigo => $nombre) {
                            if ($nombre == $nombre_pais) {
                                break; // Terminar el bucle una vez que se encuentra el país
                            }
                        }



                        echo '
                            <div class="relative group">
                        <img
                                src="img/'.$fila["photo"].'"
                                alt="Movie"
                                width="450"
                                height="600"
                                class="rounded-lg object-cover w-full aspect-[3/4] group-hover:opacity-50 transition-opacity"
                        />
                    </div>
                    <div class="relative">
                        <div class="absolute right-0 text-center" >
                            <p class="text-lg">Average Rating</p>
                            <div class="flex items-center justify-center">';

                        $cookie_name = "vote_" . $fila["id"];

                        if (!isset($_COOKIE[$cookie_name])) {
                            echo '
                                <form action="vote.php" method="post" class="flex items-center justify-center">
                                    <input type="hidden" name="id_pelicula" value="'.$fila["id"].'">
                                    <button type="submit" name="vote" value="1">
                                        <img src="img/arrow-up.png" class="size-9 m-2">
                                    </button>
                                    
                                    <p class="text-6xl font-bold text-center">'.$fila["score"].'</p>
                                    
                                    <button type="submit" name="vote" value="-1">
                                        <img src="img/arrow-down.png" class="size-9 m-2">
                                    </button>
                                
                                </form>
                            ';
                        } else {
                            if ($_COOKIE[$cookie_name] == 1){
                                echo '
                                    <img src="img/arrow-up.png" class="size-9 m-2">
                                    <p class="text-6xl font-bold text-center">'.$fila["score"].'</p>
                                ';
                            } elseif ($_COOKIE[$cookie_name] == -1) {
                                echo'
                                    <p class="text-6xl font-bold text-center">'.$fila["score"].'</p>
                                    <img src="img/arrow-down.png" class="size-9 m-2">
                                ';
                            } else {
                                echo '
                                    <img src="img/arrow-up.png" class="size-9 m-2">
                                    <p class="text-6xl font-bold text-center">'.$fila["score"].'</p>
                                    <img src="img/arrow-down.png" class="size-9 m-2">
                                ';
                            }
                        }

                        echo '
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold">'.$fila["title"].'</h2>
                        <p class="text-xl font-normal">'.$fila["year"].'</p>
                         <div class="mb-2">
                            <h3 class="text-2xl font-semibold mt-4">Synopsis</h3>
                            <p class="text-base">
                                '.$fila["description"].'
                            </p>
                        </div>
                        <div class="relative">
                            <div>
                                <p class="text-lg font-semibold mb-2">Genre: <span class="font-normal">'.$fila["genre"].'</span></p>
                                <p class="text-lg font-semibold mb-2">Country: <span class="font-normal">'.$fila["country"].'</span>
                        
                                <img
                                src="https://flagcdn.com/64x48/' .$codigo. '.png"
                                srcset="https://flagcdn.com/128x96/' .$codigo. '.png 2x,
                                https://flagcdn.com/192x144/' .$codigo. '.png 3x"
                                width="48"
                                height="36"
                                title="Flag of '.$nombre_pais.'"
                                >
                                </p>
                                <p class="text-lg font-semibold mt-4 mb-10">Age: <span class="font-normal">'.$fila["age"].'</span>
                                <img style="height:48px;"  src="img/edad-'.$fila["age"].'.png">
                                </p>
                                
                                <p class="text-lg font-semibold mt-4">Director: <span class="font-normal"><a href="index.php?director='.$fila["director"].'">'.$fila["director"].'</a></span></p>
                        ';

                        for($i=1;$i<=5;$i++) {
                            if (!$fila["actor$i"] == "") {
                                echo "
                                    <p class='text-lg font-semibold mt-4'>Actor $i: <span class='font-normal'><a href='index.php?actor=".$fila['actor'.$i]."'>".$fila['actor'.$i]."</a></span></p>
                                ";
                            }
                        }


                    $rndID = 0;

                    $queryAd = "SELECT * FROM ads";

                    if ($resultAd = mysqli_query($enlace, $queryAd)) {
                        $rowcount = mysqli_num_rows($resultAd);

                        $prevRndID = $rndID;
                        $rndID = random_int(0, $rowcount);
                        while ($rndID == $prevRndID) {
                            $rndID = random_int(0, $rowcount);
                        }
                    } else {
                        $rowcount = 0;
                        $rndID = 0;
                    }

                    $queryAd = "SELECT * FROM ads WHERE id='" . $rndID . "'";
                    if ($resultAd = mysqli_query($enlace, $queryAd)) {
                        while ($filaAd = mysqli_fetch_array($resultAd)) {
                            echo '
                                <div class="absolute right-0 top-3">
                                <div class="grid gap-6 relative group">
                                    <a class="absolute inset-0 z-10" href="adview.php?ad='.$filaAd['id'].'&redirect='.$_SERVER["REQUEST_URI"].'">
                                        <span class="sr-only">View</span>
                                    </a>
                                    <img
                                        src="img/ads/' . $filaAd["url"] . '"
                                        alt="Imagen de Pelicula ' . $filaAd["adname"] . '"
                                        class="rounded-lg object-cover w-9/12 aspect-[3/4] group-hover:opacity-50 transition-opacity"
                                    />
                                    <div class="grid gap-1">
                                        <h3 class="font-semibold">' . $filaAd["adname"] . '</h3>
                                        <p class="text-sm leading-none">Patrocinado</p>
                                    </div>
                                </div>
                                </div>
                                ';
                        }
                    }


                    echo '</div>
                    </div>';

                        echo '
                        <iframe 
                        class="mt-20"
                        width="560" 
                        height="315" 
                        src="https://www.youtube.com/embed/'.$fila["link"].'" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                        </iframe>
                    </div>
                        ';

                    }


                    mysqli_close($enlace)
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>