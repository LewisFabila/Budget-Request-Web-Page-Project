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

    // Verificamos si la solicitud es POST y si se ha enviado el array de IDs
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
        // Decodificamos el array JSON que nos llega
        $ids = json_decode($_POST['ids']);

        // Preparamos la consulta para eliminar los usuarios
        $ids_placeholder = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM login WHERE id IN ($ids_placeholder)";
        $stmt = $conn->prepare($sql);

        // Enlazamos los parámetros
        $types = str_repeat('i', count($ids));  // 'i' para enteros
        $stmt->bind_param($types, ...$ids);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        $stmt->close();
        $conn->close();
    }
?>