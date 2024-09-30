<?php
//seguridad de sessiones paginacion
session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location:../index.html");
    die();
}


require 'usuarios_conexion.php';

$id = $conn->real_escape_string($_POST['id']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$area = $conn->real_escape_string($_POST['area']);
$usuario = $conn->real_escape_string($_POST['usuario']);
$password = $conn->real_escape_string($_POST['password']);
$id_cargo = $conn->real_escape_string($_POST['id_cargo']);


$sql = "INSERT INTO login 
(id,nombre,area,usuario,password,id_cargo)
VALUES 
('$id', '$nombre','$area','$usuario','$password','$id_cargo')";

$resultado = $conn->query($sql);


 if ($resultado) {
                echo "<script language='JavaScript'>           
                location.assign('usuarios.php');
                </script>";
            }



?>