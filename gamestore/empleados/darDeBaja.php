<?php

require_once("../conexion.php");

if (isset($_GET['id'])) {
    
    $id_empleado = intval($_GET['id']); 

    $sql = "DELETE FROM empleado WHERE Cod_Empleado = $id_empleado";

    if ($conn->query($sql) === TRUE) {
        header("Location: empleados.php");
        exit();
    } else {
        echo "Hubo un error al intentar eliminar el empleado: " . $conn->error;
        echo "<br><br><a href='empleados.php'>Regresar al inventario</a>";
    }
} else {
    echo "Acceso denegado. No se especificó ningún producto para eliminar.";
}
?>