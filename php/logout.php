<?php
    // Iniciar la sesión
    session_start();

    // Restablecer todas las variables de sesión
    $_SESSION = array();

    // Si se está usando una cookie de sesión, eliminarla
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, 
            $params["path"], 
            $params["domain"], 
            $params["secure"], 
            $params["httponly"]
        );
    }

    // Destruir la sesión
    session_destroy();

    // Redirigir a la página de inicio de sesión u otra página después de cerrar sesión
    header("location: ../index.html");
    exit();
?>