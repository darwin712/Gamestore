<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_producto = intval($_POST['Cod_Producto']);
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $descripcion = $conn->real_escape_string($_POST['Descripcion']);
    $precio = $conn->real_escape_string($_POST['Precio']);
    $unidades = $conn->real_escape_string($_POST['Unidades']);
    $clasificacion = $conn->real_escape_string($_POST['Clasificacion']);
    $categoria = $conn->real_escape_string($_POST['Cod_Categoria']);

    $ruta_bd = $conn->real_escape_string($_POST['Ruta_Actual']); 

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES['Imagen']['name']);
        
        $ruta_bd = "_Portadas_/" . $nombre_archivo;
        $ruta_fisica = "../_Portadas_/" . $nombre_archivo;
        
        if (move_uploaded_file($_FILES['Imagen']['tmp_name'], $ruta_fisica)) {
            chmod($ruta_fisica, 0777); 
        }
    }

    $sql = "UPDATE producto SET 
                Nombre = '$nombre', 
                Precio = '$precio', 
                Unidades = '$unidades', 
                Clasificacion = '$clasificacion', 
                Descripcion = '$descripcion', 
                Cod_Categoria = '$categoria',
                Imagen = '$ruta_bd'
            WHERE Cod_Producto = $id_producto";

    if ($conn->query($sql) === TRUE) {
        
        $sql_limpiar = "DELETE FROM productoetiqueta WHERE Cod_Producto = $id_producto";
        $conn->query($sql_limpiar);

        if (isset($_POST['etiquetas']) && is_array($_POST['etiquetas'])) {
            foreach ($_POST['etiquetas'] as $id_etiqueta) {
                $id_etq_seguro = intval($id_etiqueta);
                $sql_puente = "INSERT INTO productoetiqueta (Cod_Producto, Cod_Etiqueta) VALUES ($id_producto, $id_etq_seguro)";
                $conn->query($sql_puente);
            }
        }

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