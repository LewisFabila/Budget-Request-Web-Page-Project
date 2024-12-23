<?php
    // Parámetros de conexión a la base de datos
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "recibosr_auth";
    
    $conn = new mysqli($hostname, $username, $password, $database);
    
    if ($conn->connect_error) {
    	die("Error de conexión" . $conn->connect_error);
    }