<?php

    // Definición de variables para la conexión a la base de datos.
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    //Iniciar Sesion.
    session_start();
    $_SESSION['usuario'] = $usuario;

    // Establecer una conexión con la base de datos usando mysqli_connect.
    $conexion = mysqli_connect("localhost","root","","recibosr_auth");

    // Verificar si la conexión fue exitosa.
    if (!$conexion) {
        die("Error de conexión :( " . mysqli_connect_error());
    }

    // Preparar la consulta para evitar inyección SQL.
    $consulta = "SELECT * FROM login WHERE usuario = ? AND password = ?";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt === false) {
        die("Error en la preparación de la consulta :( " . mysqli_error($conexion));
    }

    // Asociar los parámetros a la consulta.
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);

    // Ejecutar la consulta.
    mysqli_stmt_execute($stmt);

    // Obtener los resultados.
    $resultado = mysqli_stmt_get_result($stmt); 
    
    // Verificar si la consulta fue exitosa
    if (mysqli_num_rows($resultado) > 0){
        $filas = mysqli_fetch_array($resultado);
        if ($filas && isset($filas['id_cargo'])){       
            if($filas['id_cargo']==1 && $filas['usuario']=="Admin" ){ //ADMINISTRADOR SISTEMAS
                header("location:../php/menu-admin.php");
                exit();
            }else if($filas['id_cargo']==1 && $filas['usuario']!="Admin"){ //AREA SISTEMAS
                header("location:../php/menu-admin_historico.php");
                exit();
            }else if($filas['id_cargo']==2){ //ADMINISTRADOR FINANZAS
                header("location:../php/menu-admin_historico.php");
                exit();
            }else if($filas['id_cargo']==3){ //USUARIO CONTABLE
                header("location:../php/");
                exit();
            }else if($filas['id_cargo']==4){ //USUARIO GENERAL
                header("location:../php/");
                exit();
            }
        }else {
            header("Location: ../index.html?error=1");
            exit();
        }
    }else {
        header("Location: ../index.html?error=1");
        exit();
    }

    // Cerrar la declaración y la conexión.
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

?>