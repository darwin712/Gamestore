<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $descripcion = $conn->real_escape_string($_POST['Descripcion']);
    $precio = $conn->real_escape_string($_POST['Precio']);
    $unidades = $conn->real_escape_string($_POST['Unidades']);
    $condicion = $conn->real_escape_string($_POST['Condicion']);
    $clasificacion = $conn->real_escape_string($_POST['Clasificacion']);
    $categoria = $conn->real_escape_string($_POST['Cod_Categoria']);

    $ruta_bd = ""; 

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES['Imagen']['name']);
        
        $ruta_bd = "_Multimedia_/" . $nombre_archivo;
        
        $ruta_fisica = "../_Multimedia_/" . $nombre_archivo;
        
        move_uploaded_file($_FILES['Imagen']['tmp_name'], $ruta_fisica);
        
    } else {
        $ruta_bd = "_Multimedia_/Image Icon.png"; 
    }

    $sql = "INSERT INTO producto (Nombre, Precio, Unidades, Clasificacion, Descripcion, Cod_Categoria, Condicion, Imagen) 
            VALUES ('$nombre', '$precio', '$unidades', '$clasificacion', '$descripcion', '$categoria', '$condicion', '$ruta_bd')";


    if ($conn->query($sql) === TRUE) {
        
        $nuevo_id_producto = $conn->insert_id;

        if (isset($_POST['etiquetas']) && is_array($_POST['etiquetas'])) {
            
            foreach ($_POST['etiquetas'] as $id_etiqueta) {
                $id_etq_seguro = intval($id_etiqueta);
                
                $sql_puente = "INSERT INTO productoetiqueta (Cod_Producto, Cod_Etiqueta) 
                               VALUES ($nuevo_id_producto, $id_etq_seguro)";
                $conn->query($sql_puente);
            }
        }

        header("Location: inventarios.php");
        exit();
        
    } else {
        echo "Hubo un error al agregar el producto: " . $conn->error;
    }
} else {
    echo "Acceso denegado. No se enviaron datos.";
}
?>