<?php
require_once("../conexion.php");

function mostrarAlerta($titulo, $mensaje) {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Gamestore - Aviso</title>
        <link rel="stylesheet" href="../styles.css">
    </head>
    <body>
        <section id="background" style="margin: auto; margin-top: 10vh; max-width: 600px; width: 90%; min-height: auto; height: auto; padding-bottom: 40px; justify-content: center;">
            <div id="title">' . $titulo . '</div>
            <div id="bloqueAgregar" style="margin-top: 30px; width: 85%; max-width: 100%; height: auto; padding: 30px; box-sizing: border-box; text-align: center; display: flex; flex-direction: column; align-items: center;">
                <h3 style="color: #4a6572; margin-bottom: 30px; font-weight: normal; font-size: 19px; line-height: 1.5; word-wrap: break-word;">' . $mensaje . '</h3>
                <button id="btnAgregar" onclick="window.location.href=\'empleados.php\'">Aceptar</button>
            </div>
        </section>
    </body>
    </html>';
    exit;
}

if (isset($_GET['id'])) {
    
    $id_empleado = intval($_GET['id']); 

    $sql = "UPDATE empleado SET Activo = 0 WHERE Cod_Empleado = $id_empleado";
    $resultado = $conn->query($sql);

    if ($resultado === TRUE) {
        mostrarAlerta('¡Baja Exitosa!', 'El empleado ha sido dado de baja del sistema correctamente.');
    } else {
        mostrarAlerta('Error al Dar de Baja', 'Hubo un error al intentar actualizar el estado del empleado: ' . $conn->error);
    }
} else {
    mostrarAlerta('Acceso Denegado', 'No se especificó ningún empleado válido para dar de baja.');
}
?>