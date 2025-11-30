<?php
session_start();
include ("includes/connect.php");

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $confirmTitle = $_POST["confirmtitle"];

    $query = "SELECT * FROM movies WHERE id = '$id'";

    if($result = mysqli_query($enlace, $query)) {
        $fila = mysqli_fetch_array($result);
    }

    if($confirmTitle == $fila["title"]) {
        $query = "DELETE FROM movies WHERE id='$id'";
        if (mysqli_query($enlace,$query)){
            header("Location: dashboard.php");
            exit;
        } else {
            echo 'Ha habido un error al borrar la pelicula';
        }
    }

} elseif (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "SELECT * FROM movies WHERE id = '$id'";

    if($result = mysqli_query($enlace, $query)) {
        $fila = mysqli_fetch_array($result);
    }
} else {
    header("Location: dashboard.php");
    exit;
}

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Pelicula | MovieFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<main class="min-h-screen bg-gray-100">
    <?php
    include ("includes/adminheader.php")
    ?>
    <section class="container mx-auto py-6 px-4 md:px-6 sm:w-full md:w-full lg:w-1/2 xl:w-1/2">
        <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900">Eliminar Película</h2>
                <form class="mt-4 space-y-4" method="post">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Escribe "<span class="text-red-600 select-none"><?php echo $fila["title"] ?></span>" para confirmar el borrado</label>
                        <input
                            class="p-3 mt-3 block w-full rounded-md focus:bg-red-600 focus:border-transparent focus:ring-0 text-red-600 focus:text-white vg-place placeholder-red-500 focus:placeholder-white border border-red-400 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none focus-visible:ring-color-red border-red-400"
                            placeholder="Ingresar título de la película"
                            type="text"
                            name="confirmtitle"
                        />
                        <input type="hidden" name="id" value="<?php echo $fila["id"] ?>">
                    </div>
                    <button
                        type="button"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                        Eliminar Película
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

</body>
</html>
