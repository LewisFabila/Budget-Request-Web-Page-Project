<?php
    // Parámetros de conexión a la base de datos
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "recibosr_auth";

$conn = new mysqli($hostname, $username, $password, $database);

    try {
        $conn = new mysqli($hostname, $username, $password, $database);

        // Verificar si la conexión fue exitosa
        if ($conn->connect_errno) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }

    } catch (Exception $e) {
        // Manejo de errores
        echo $e->getMessage();
    }
?>