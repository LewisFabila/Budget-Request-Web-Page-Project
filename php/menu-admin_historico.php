<?php
    //seguridad de sesiones paginacion
    session_start();
    error_reporting(0);
    $varsesion= $_SESSION['usuario'];
    if($varsesion== null || $varsesion=''){
        header("location:../index.html");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>Registro de Usuarios</title>
</head>

<body>
    <header>
        <nav>
            <a class="texto-simple"><i class="bi bi-cash-coin"></i> MENU DE PRESUPUESTOS </a>
            <ul>
                <li><a class="op-texto"><i class="bi bi-person-circle"></i> <?php echo  $_SESSION['usuario']?></li>
                <li><a class="op-texto" onClick="history.go(-1);"><i class="bi bi-arrow-return-left"></i> REGRESAR</a></li>
                <li><a class="op-texto" href="logout.php"><i class="bi bi-door-open-fill"></i> CERRAR SESION</a></li>
            </ul>
        </nav>
    </header>
    <div>
        <ul class="contenedor-submenu">
            <li><section class="menu-carta" onclick="location.href=' '"><img class="img-align" src="../img/sis_pre.png" width="60%" alt=""><a class="texto-carta">SISTEMAS PRESUPUESTOS</a></section></li>
            <li><section class="menu-carta" onclick="location.href=' '"><img class="img-align" src="../img/sis_his.png" width="60%" alt=""><a class="texto-carta">SISTEMAS HISTORICO</a></section></li>
            <li><section class="menu-carta" onclick="location.href=' '"><img class="img-align" src="../img/pre_rech.png" width="60%" alt=""><a class="texto-carta">PRESUPUESTOS RECHAZADOS</a></section></li>
        </ul>
    </div>
</body>
</html>