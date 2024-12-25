<?php
    require 'usuarios_conexion.php';
    
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM login WHERE id = '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row); // Devuelve los datos en formato JSON
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }
?>
