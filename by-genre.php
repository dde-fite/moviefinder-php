<?php
include("includes/visit.php")
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Peliculas por Genero | MovieFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input[type="radio"]:checked + label img {
            /* Estilos específicos para la imagen cuando el radio button está seleccionado */
            border: 2px solid cornflowerblue; /* Cambia el color del borde según tus preferencias */
        }
    </style>
</head>
<body>
<?php
include ("includes/adminbar.php")
?>
<main class="min-h-screen bg-gray-100">
    <header class="bg-white shadow-sm py-4 px-6">
        <div class="container mx-auto flex items-center justify-between">
            <a class="flex items-center text-2xl font-bold text-gray-900" href="index.php">
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
                    <a class="text-gray-900" href="by-genre.php">
                        Por Genero
                    </a>
                    <a class="text-gray-900" href="index.php?last=TRUE">
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
        <div class="grid md:grid-cols-[240px_1fr] gap-10 items-start">
            <div class="grid gap-6 md:gap-8">
                <h2 class="text-2xl font-semibold">Movies by Genre</h2>
                <div class="gap-20">
                    <?php
                    include ("includes/connect.php");

                    $query = "SELECT DISTINCT genre FROM movies ORDER BY genre";

                    if($result = mysqli_query($enlace, $query)) {
                        while ($fila = mysqli_fetch_array($result)) {
                            echo '
                                <div class="relative group">
                                    <a class="text-base text-gray-900" href="index.php?category='.$fila["genre"].'">
                                        '.$fila["genre"].'
                                    </a>
                                </div>
                            ';
                        }
                    }

                    mysqli_close($enlace);
                    ?>


                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>