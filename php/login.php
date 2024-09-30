<?php

    // Definición de variables para la conexión a la base de datos.
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    //Iniciar Sesion.
    session_start();
    $_SESSION['usuario'] = $usuario;

    // Establecer una conexión con la base de datos usando mysqli_connect.
    $conexion = mysqli_connect("localhost","recibosr_root","Card0045#@","recibosr_auth");

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
            if($filas['id_cargo']==1 && $filas['usuario']=="CARLOS_SISTEM" ){ //ADMINISTRADOR
                header("location:../php/menu-admin.php");
                exit();
            }else if($filas['id_cargo']==1 && $filas['usuario']!="CARLOS_SISTEM"){ //FATIMA FINANZAS  
                header("location:MENU-ADMIN_FATIMA_HISTORICO_SYSTEM-OTRO.php");
                exit();
            }else if($filas['id_cargo']==2){ //FATIMA FINANZAS
                header("location:MENU-FATIMA_PRINCIPAL.php");
                exit();
            }else if($filas['id_cargo']==3){ //CONTABILIDAD
                header("location:MENU-CONTABILIDAD_FATIMA_HISTORICO.php");
                exit();
            }else if($filas['id_cargo']==4){ //USUARIO GENERAL
                header("location:MENU-ADMIN_FATIMA_HISTORICO_PRODUCCION.php");
                exit();
            }else if($filas['id_cargo']==5){ //RECURSOS HUMANOS
                header("location:MENU-ADMIN_FATIMA_HISTORICO_FINANZASPRESUPUESTOS.php");
                exit();
            }else if($filas['id_cargo']==6){ //DISEÑO
                header("location:MENU-ADMIN_FATIMA_HISTORICO_DISENO.php");
                exit();
            }else if($filas['id_cargo']==7){ //MK
                header("location:MENU-ADMIN_FATIMA_HISTORICO_MK.php");
                exit();
            }else if($filas['id_cargo']==8){ //VENTAS
                header("location:MENU-ADMIN_FATIMA_HISTORICO_VENTAS.php");
                exit();
            }else if($filas['id_cargo']==9){ //MH
                header("location:MENU-ADMIN_FATIMA_HISTORICO_MH.php");
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