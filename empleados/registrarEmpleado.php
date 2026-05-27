<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $apellido_paterno = $conn->real_escape_string($_POST['Apellido_Paterno']);
    $apellido_materno = $conn->real_escape_string($_POST['Apellido_Materno']);
    $telefono = $conn->real_escape_string($_POST['Telefono']);
    $turno = $conn->real_escape_string($_POST['Turno']);

    $sql = "INSERT INTO empleado (Nombre, Apellido_Materno, Apellido_Paterno, Telefono, Turno) 
            VALUES ('$nombre', '$apellido_materno', '$apellido_paterno', '$telefono', '$turno')";

    if ($conn->query($sql) === TRUE) {
        header("Location: empleados.php");
        exit();
    } else {
        echo "Hubo un error al registrar al empleado: " . $conn->error;
    }
} else {
    echo "Acceso denegado. No se enviaron datos.";
}
?>