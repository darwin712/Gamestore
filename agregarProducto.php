<?php
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $descripcion = $conn->real_escape_string($_POST['Descripcion']);
    $precio = $conn->real_escape_string($_POST['Precio']);
    $unidades = $conn->real_escape_string($_POST['Unidades']);
    $condicion = $conn->real_escape_string($_POST['Condicion']);
    $clasificacion = $conn->real_escape_string($_POST['Clasificacion']);
    $categoria = $conn->real_escape_string($_POST['Cod_Categoria']);

    $ruta_destino = "";
    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES['Imagen']['name']);
        $ruta_destino = "Multimedia/" . $nombre_archivo;
        move_uploaded_file($_FILES['Imagen']['tmp_name'], $ruta_destino);
    } else {
        $ruta_destino = "Multimedia/Image Icon.png"; 
    }

    $sql = "INSERT INTO producto (Nombre, Precio, Unidades, Clasificacion, Descripcion, Cod_Categoria, Condicion, Imagen) 
            VALUES ('$nombre', '$precio', '$unidades', '$clasificacion', '$descripcion', '$categoria', '$condicion', '$ruta_destino')";

    if ($conn->query($sql) === TRUE) {
        $usu = isset($_GET['user']) ? $_GET['user'] : '';
        header("Location: inventarios.php?user=$usu");
        exit();
    } else {
        echo "Hubo un error al agregar el producto: " . $conn->error;
    }
} else {
    echo "Acceso denegado. No se enviaron datos.";
}
?>