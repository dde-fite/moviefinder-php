<?php
    $_SESSION['loggedin'] = false;
    unset($_SESSION['username']);

    $_SESSION = array();

    session_unset();
    session_regenerate_id(true);

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    if (isset($_GET["redirect"])) {
        $redirect = $_GET["redirect"];
    } else {
        $redirect = "index.php";
    }
    header("Location: $redirect");
    exit;

    mysqli_close($enlace);

?>