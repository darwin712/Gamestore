<?php
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $descripcion = $conn->real_escape_string($_POST['Descripcion']);
    $precio = $conn->real_escape_string($_POST['Precio']);
    $unidades = $conn->real_escape_string($_POST['Unidades']);
    $clasificacion = $conn->real_escape_string($_POST['Clasificacion']);
    $categoria = $conn->real_escape_string($_POST['Cod_Categoria']);

    $sql = "INSERT INTO producto (Nombre, Precio, Unidades, Clasificacion, Descripcion, Cod_Categoria) 
            VALUES ('$nombre', '$precio', '$unidades', '$clasificacion', '$descripcion', '$categoria')";

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