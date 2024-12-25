<?php
    // Seguridad de sesiones y paginación
    session_start();
    error_reporting(0);
    $varsesion = $_SESSION['usuario'];
    
    if ($varsesion == null || $varsesion == '') {
        header("location:../index.html");
        die();
    }

    // Incluir archivo de conexión a la base de datos
    require 'usuarios_conexion.php';

    // Recoger datos de la solicitud POST
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $area = $_POST['area'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $id_cargo = $_POST['id_cargo'];    

    // Usar una consulta preparada para evitar inyecciones SQL
    $stmt = $conn->prepare("UPDATE login SET nombre = ?, area = ?, usuario = ?, password = ?, id_cargo = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nombre, $area, $usuario, $password, $id_cargo, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script language='JavaScript'>           
        location.assign('usuarios.php');
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();

    // Evitar menos de 8 caracteres en contraseña.
    if (isset($_POST['submit'])) {
        // Verificar la longitud de la contraseña
        $password = $_POST['password'];

        if (strlen($password) < 8) {
            echo "<script>alert('La contraseña debe tener al menos 8 caracteres.');</script>";
            exit;  // Detener el proceso de actualización
        }
    }
?>
