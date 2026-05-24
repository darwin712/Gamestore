<?php

require_once("conexion.php");

if (isset($_GET['id'])) {
    
    $id_producto = intval($_GET['id']); 
    $usu = isset($_GET['user']) ? $_GET['user'] : '';

    $sql = "DELETE FROM producto WHERE Cod_Producto = $id_producto";

    if ($conn->query($sql) === TRUE) {
        header("Location: inventarios.php?user=$usu");
        exit();
    } else {
        echo "Hubo un error al intentar eliminar el producto: " . $conn->error;
        echo "<br><br><a href='inventarios.php?user=$usu'>Regresar al inventario</a>";
    }
} else {
    echo "Acceso denegado. No se especificó ningún producto para eliminar.";
}
?>