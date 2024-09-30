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
    <title>Menu de Administrador</title>
</head>

<body>
    <header>
        <nav>
            <a class="texto-simple"><i class="bi bi-list"></i> MENU DE ADMINISTRADOR</a>
            <ul>
                <li><a class="op-texto"><i class="bi bi-person-circle"></i> <?php echo  $_SESSION['usuario']?></li>
                <li><a class="op-texto" href="logout.php"><i class="bi bi-door-open-fill"></i> CERRAR SESION</a></li>
            </ul>
        </nav>
    </header>
    <div>
        <ul class="contenedor-menu">
            <li><section class="menu-carta" onclick="location.href='usuarios.php'"><img class="img-align" src="../img/reg_per.png" width="60%" alt=""><a class="texto-carta">REGISTRO DE PERSONAL</a></section></li>
            <li><section class="menu-carta" onclick="location.href='menu-admin_historico.php'"><img class="img-align" src="../img/reg_pre.png" width="60%" alt=""><a class="texto-carta">REGISTRAR PRESUPUESTO</a></section></li>
        </ul>
    </div>
</body>
</html>