<?php
session_start();
include ('includes/connect.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['form'])) {
    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != '' && $_POST['password'] != '') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username = '" . $username . "'";

        if ($result = mysqli_query($enlace, $query)) {
            $fila = mysqli_fetch_array($result);
            if ($username == $fila['username'] && $password == $fila['password']) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
                exit;
            }
        }
    }

    mysqli_close($enlace);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Area Administrativa | MovieFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

<main class="min-h-screen bg-gray-100">
    <header class="bg-white shadow-sm py-4 px-6">
        <div class="container mx-auto flex items-center justify-between">
            <a class="flex items-center text-2xl font-bold text-gray-900" href="#">
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
                <a class="text-gray-900" href="index.php">
                    <- Volver
                </a>
            </div>
        </div>
    </header>
    <section class="container mx-auto py-6 px-4 md:px-6">
        <div class="flex justify-center items-center h-screen">
            <div class="w-full max-w-md">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post" action="login.php">
                    <div class="mb-4">
                        <label
                            class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block text-gray-700 text-sm font-bold mb-2"
                            for="username"
                        >
                            Usuario:
                        </label>
                        <input
                            class="flex h-10 border-input bg-background text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                            id="username"
                            placeholder="Usuario"
                            type="text"
                            name="username"
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block text-gray-700 text-sm font-bold mb-2"
                            for="password"
                        >
                            Contraseña:
                        </label>
                        <input
                            class="flex h-10 border-input bg-background text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password"
                            placeholder="******************"
                            type="password"
                            name="password"
                        />
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="inline-flex items-center justify-center text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit"
                            name="form"
                        >
                            Iniciar Sesión
                        </button>
                        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

</body>


</html>
