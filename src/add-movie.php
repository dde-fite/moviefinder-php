<?php
include ("includes/connect.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id"]) && $_GET["id"] != "")  {
    $idEdit = $_GET["id"];
    $id = $_GET["id"];

    $query = "SELECT * FROM movies WHERE id='$id'";
    if($result = mysqli_query($enlace, $query)) {
        $fila = mysqli_fetch_array($result);
    }

}


if (isset($_POST["submited"])) {

    if ($_POST["title"] != "") {
        $elements = ["title","year","genre","duration","director","actor1","actor2","actor3","actor4","actor5","country","age","description","photo","link"];

        $queryArg = "";

        for ($i=0;$i<count($elements);$i++) {
                $elements[$i] = $_POST["$elements[$i]"];
        }

        for ($i=0;$i<count($elements);$i++) {
            $queryArg = $queryArg . "'$elements[$i]',";
        }

        if (!isset($idEdit)) {
            $fechaACT = date('Y-m-d H:i:s');
            $query = "INSERT INTO movies(title,year,genre,duration,director,actor1,actor2,actor3,actor4,actor5,country,age,description,photo,link,score,`FECHA INS`,`FECHA ACT`) VALUES ($queryArg'5','$fechaACT','$fechaACT')";
        } else {
            $fechaACT = date('Y-m-d H:i:s');
            $query = "UPDATE movies SET title='$elements[0]',year='$elements[1]',genre='$elements[2]',duration='$elements[3]',director='$elements[4]',actor1='$elements[5]',actor2='$elements[6]',actor3='$elements[7]',actor4='$elements[8]',actor5='$elements[9]',country='$elements[10]',age='$elements[11]',description='$elements[12]',photo='$elements[13]',link='$elements[14]',`FECHA ACT`='$fechaACT' WHERE id='$id'";
        }

        mysqli_query($enlace, $query);

        mysqli_close($enlace);

        header("Location: dashboard.php?id=");
        exit;
    }else{


    echo '*El Titulo de la Pelicula es obligatorio';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Pelicula | MovieFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input[type="radio"]:checked + label img {
            border: 2px solid cornflowerblue;
        }
    </style>
</head>
<body>

<main class="min-h-screen bg-gray-100">
    <?php
    include ("includes/adminheader.php")
    ?>
    <section class="container mx-auto py-6 px-4 md:px-6">
        <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900"><?php if(!isset($idEdit)) { echo 'Añadir Nueva Película'; } else { echo 'Editar: ' . $fila['title']; } ?></h2>
                <form class="mt-4 space-y-4" method="post">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Título de la Película</label>
                        <input
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            placeholder="Ingresar título de la película"
                            type="text"
                            name="title"
                            <?php if(isset($idEdit)) { echo 'value="'.$fila['title'].'"'; } ?>
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                        <lt-mirror contenteditable="false" style="display: none;" data-lt-linked="1">
                            <lt-highlighter contenteditable="false" style="display: none;">
                                <lt-div
                                    spellcheck="false"
                                    class="lt-highlighter__wrapper"
                                    style="width: 1228.8px !important; height: 72px !important; transform: none !important; transform-origin: 614.4px 36px !important; zoom: 1 !important; margin-top: 4px !important;"
                                >
                                    <lt-div
                                        class="lt-highlighter__scroll-element"
                                        style="top: 0px !important; left: 0px !important; width: 1228.8px !important; height: 72px !important;"
                                    ></lt-div>
                                </lt-div>
                            </lt-highlighter>
                            <lt-div
                                spellcheck="false"
                                class="lt-mirror__wrapper notranslate"
                                data-lt-scroll-top="0"
                                data-lt-scroll-left="0"
                                data-lt-scroll-top-scaled="0"
                                data-lt-scroll-left-scaled="0"
                                data-lt-scroll-top-scaled-and-zoomed="0"
                                data-lt-scroll-left-scaled-and-zoomed="0"
                                style="border: 0px solid rgba(0, 0, 0, 0) !important; border-radius: 6px !important; direction: ltr !important; font: 400 16px / 1.5 __Inter_e66fe9, __Inter_Fallback_e66fe9 !important; font-synthesis: weight style small-caps !important; hyphens: manual !important; letter-spacing: normal !important; line-break: auto !important; margin: 4px 0px 0px !important; padding: 0px !important; text-align: start !important; text-decoration: none solid rgb(17, 24, 39) !important; text-indent: 0px !important; text-rendering: auto !important; text-transform: none !important; transform: none !important; transform-origin: 614.4px 36px !important; unicode-bidi: normal !important; white-space: pre-wrap !important; word-spacing: 0px !important; overflow-wrap: break-word !important; writing-mode: horizontal-tb !important; zoom: 1 !important; -webkit-locale: &quot;en&quot; !important; -webkit-rtl-ordering: logical !important; width: 1228.8px !important; height: 72px !important;"
                            >
                                <lt-div
                                    class="lt-mirror__canvas"
                                    style="margin-top: 0px !important; margin-left: 0px !important; width: 1228.8px !important; height: 72px !important;"
                                ></lt-div>
                            </lt-div>
                        </lt-mirror>
                        <textarea
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            rows="3"
                            placeholder="Ingresar descripción de la película"
                            data-lt-tmp-id="lt-69736"
                            spellcheck="false"
                            data-gramm="false"
                            name="description"

                        ><?php if(isset($idEdit)) { echo $fila['description']; } ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Año de Lanzamiento</label>
                        <input
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            type="number"
                            value="<?php if (!isset($idEdit)) { echo date("Y");} else { echo $fila['year']; } ?>"
                            name="year"

                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Duración</label>
                        <input
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            type="number"
                            placeholder="Ingresar duración de la película en minutos"
                            name="duration"
                            <?php if(isset($idEdit)) { echo 'value="'.$fila['duration'].'"'; } ?>

                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Género</label>
                        <input
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            placeholder="Ingresar género de la película"
                            type="text"
                            name="genre"
                            <?php if(isset($idEdit)) { echo 'value="'.$fila['genre'].'"'; } ?>
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">País</label>
                        <select

                                id="country"
                                name="country"
                                role="combobox"
                                aria-controls="radix-:rg4:"
                                aria-expanded="false"
                                aria-autocomplete="none"
                                dir="ltr"
                                data-state="closed"
                                data-placeholder=""
                                class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                        >
                            <?php
                            // URL del JSON externo
                            $json_url = 'https://flagcdn.com/es/codes.json';

                            // Obtener el contenido del JSON
                            $json_data = file_get_contents($json_url);

                            // Decodificar el JSON en un array asociativo
                            $data_array = json_decode($json_data, true);

                            $nameCountries = [];

                            // Buscar el código del país en el array
                            foreach ($data_array as $nombre) {
                                    array_push($nameCountries,$nombre);
                            }

                            sort($nameCountries);

                            for ($i=0;$i<count($nameCountries);$i++) {
                                if ($nameCountries[$i] == $fila["country"]) {
                                    echo'
                                    <option value="'.$nameCountries[$i].'" selected>'.$nameCountries[$i].'</option>
                                    ';
                                } else {
                                    echo'
                                    <option value="'.$nameCountries[$i].'">'.$nameCountries[$i].'</option>
                                ';
                                }

                            }

                            ?>

                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Director</label>
                        <input
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            placeholder="Ingresar nombre del director"
                            type="text"
                            name="director"
                            <?php if(isset($idEdit)) { echo 'value="'.$fila['director'].'"'; } ?>
                        />
                    </div>

                    <?php
                        for ($i=1;$i<=5;$i++) {
                            echo '
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Actor '.$i.'</label>
                                <input
                                    class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                                    placeholder="Ingresar nombre del actor '.$i.'"
                                    type="text"
                                    name="actor'.$i.'"';
                            if (isset($idEdit)) {
                                echo 'value="' . $fila['actor'.$i] . '"';
                            }
                            echo '
                                />
                            </div>
                            ';
                        }
                    ?>

                    <div>
                        <label class="">Age</label>
                        <div class="grid grid-cols-6">
                            <div class="p-1">
                                <input type="radio" name="age" value="" id="none-age" class="absolute opacity-0 w-0 h-0">
                                <label for="none-age"><img style="height:27px;"  src="img/redcross.png" class="cursor-pointer pais-select"></label>
                            </div>
                            <?php
                            $avAges = [0,7,12,16,18];

                            for ($i=0;$i<count($avAges);$i++) {
                                if(isset($fila["age"]) && $avAges[$i] == $fila["age"]) {
                                        echo '
                                    <div class="p-1">
                                        <input type="radio" name="age" value="'.$avAges[$i].'" id="'.$avAges[$i].'-age" class="absolute opacity-0 w-0 h-0" checked="checked">
                                        <label for="'.$avAges[$i].'-age"><img style="height:27px;"  src="img/edad-'.$avAges[$i].'.png" class="cursor-pointer pais-select"></label>
                                    </div>
                                    ';
                                } else {
                                    echo '
                                    <div class="p-1">
                                        <input type="radio" name="age" value="'.$avAges[$i].'" id="'.$avAges[$i].'-age" class="absolute opacity-0 w-0 h-0">
                                        <label for="'.$avAges[$i].'-age"><img style="height:27px;"  src="img/edad-'.$avAges[$i].'.png" class="cursor-pointer pais-select"></label>
                                    </div>
                                ';
                                }

                            }
                            ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Poster de la Película</label>
                        <input
                            class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                            placeholder="Ingresar URL del poster"
                            type="text"
                            name="photo"
                            <?php if(isset($idEdit)) { echo 'value="'.$fila['photo'].'"'; } ?>
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Youtube Trailer Embed Link</label>
                        <input
                                class="p-3 mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900"
                                placeholder="Introduzca el ID del Trailer de Youtube"
                                type="text"
                                name="link"
                            <?php if(isset($idEdit)) { echo 'value="'.$fila['link'].'"'; } ?>
                        />
                    </div>
                    <button
                        type="submit"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        name="submited"
                        value="submited "
                    >
                        <?php if(isset($idEdit)) { echo 'Guardar Cambios'; } else {echo 'Añadir Película';} ?>
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

</body>
</html>

<?php mysqli_close($enlace); ?>