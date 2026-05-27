<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_producto = intval($_POST['Cod_Producto']);
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $descripcion = $conn->real_escape_string($_POST['Descripcion']);
    $precio = $conn->real_escape_string($_POST['Precio']);
    $unidades = $conn->real_escape_string($_POST['Unidades']);
    $condicion = $conn->real_escape_string($_POST['Condicion']);
    $clasificacion = $conn->real_escape_string($_POST['Clasificacion']);
    $categoria = $conn->real_escape_string($_POST['Cod_Categoria']);

    $ruta_destino = $conn->real_escape_string($_POST['Ruta_Actual']); 

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES['Imagen']['name']);
        $ruta_destino = "_Multimedia_/" . $nombre_archivo;
        move_uploaded_file($_FILES['Imagen']['tmp_name'], $ruta_destino);
    }

    $sql = "UPDATE producto SET 
                Nombre = '$nombre', 
                Precio = '$precio', 
                Unidades = '$unidades', 
                Clasificacion = '$clasificacion', 
                Descripcion = '$descripcion', 
                Cod_Categoria = '$categoria',
                Condicion = '$condicion',
                Imagen = '$ruta_destino'
            WHERE Cod_Producto = $id_producto";

    if ($conn->query($sql) === TRUE) {
        header("Location: inventarios.php");
        exit();
    } else {
        echo "Error al intentar actualizar el registro: " . $conn->error;
        echo "<br><br><a href='inventarios.php'>Regresar al inventario</a>";
    }
} else {
    echo "Acceso denegado.";
}
?>