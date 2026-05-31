<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_empleado = intval($_POST['Cod_Empleado']);
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $apellido_paterno = $conn->real_escape_string($_POST['Apellido_Paterno']);
    $apellido_materno = $conn->real_escape_string($_POST['Apellido_Materno']);
    $telefono = $conn->real_escape_string($_POST['Telefono']);
    $turno = $conn->real_escape_string($_POST['Turno']);

    $sql = "UPDATE empleado SET 
                Nombre = '$nombre', 
                Apellido_Paterno = '$apellido_paterno', 
                Apellido_Materno = '$apellido_materno', 
                Telefono = '$telefono', 
                Turno = '$turno', 
                Cod_Empleado = '$id_empleado'
            WHERE Cod_Empleado = $id_empleado";

    if ($conn->query($sql) === TRUE) {
        header("Location: empleados.php");
        exit();
    } else {
        echo "Error al intentar actualizar el registro: " . $conn->error;
        echo "<br><br><a href='empleados.php'>Regresar al inventario</a>";
    }
} else {
    echo "Acceso denegado.";
}
?>