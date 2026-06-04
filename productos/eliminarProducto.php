<?php
    require_once("../conexion.php");

    function mostrarAlerta($titulo, $mensaje, $urlDestino = 'inventarios.php') {
        // ... (Todo el código HTML de tu función mostrarAlerta se queda exactamente igual) ...
        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Gamestore - ' . htmlspecialchars($titulo) . '</title>
            <link rel="stylesheet" href="../styles.css">
            <link rel="shortcut icon" href="https://static.wikia.nocookie.net/memes-pedia/images/7/79/Padoru.jpg/revision/latest/scale-to-width-down/350?cb=20221202034528&path-prefix=es" type="image/x-icon">
        </head>
        <body>
            <header id="navegator">
                <img src="../_Multimedia_/banner2.png" id="logo">
                <nav id="navegacion"> <br>
                    <center>
                    <button type="button" id="seccion" onclick="window.location.href=\'../inicio.php\'"> <img src="../_Multimedia_/inicio.png" class="icono-nav"> Inicio </button>
                    <button type="button" id="seccion" onclick="window.location.href=\'../productos/inventarios.php\'"> <img src="../_Multimedia_/inventarios.png" class="icono-nav"> Inventarios </button>
                    <button type="button" id="seccion" onclick="window.location.href=\'../empleados/empleados.php\'"> <img src="../_Multimedia_/empleados.png" class="icono-nav"> Empleados </button> 
                    <button type="button" id="seccion" onclick="window.location.href=\'../ventas/ventas.php\'"> <img src="../_Multimedia_/ventas.png" class="icono-nav"> Ventas </button> 
                    <button type="button" id="seccion" onclick="window.location.href=\'../intercambios/intercambios.php\'"> <img src="../_Multimedia_/intercambios.png" class="icono-nav"> Intercambios </button>
                    <button type="button" id="seccion" onclick="window.location.href=\'../reporteFinanciero.php\'"> <img src="../_Multimedia_/reporte.png" class="icono-nav"> Reporte Financiero </button>
                    </center>
                </nav>
            </header>
            
            <section id="background">
                
                <div id="title">' . htmlspecialchars($titulo) . '</div>

            <div id="bloqueAgregar" style="margin-top: 30px; width: 55%; max-width: 100%; height: auto; padding: 30px; box-sizing: border-box; text-align: center; display: flex; flex-direction: column; align-items: center;">
                <h3 style="color: #4a6572; margin-bottom: 30px; font-weight: normal; font-size: 19px; line-height: 1.5; word-wrap: break-word;">' . $mensaje . '</h3>
                <button id="btnAgregar" onclick="window.location.href=\'' . $urlDestino . '\'">Aceptar</button>
            </div>

            </section>
        </body>
        </html>';
        exit;
    }

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);

    $sql_check = "SELECT 
                    (SELECT COUNT(*) FROM detalleventa WHERE Cod_Producto = $id_producto) + 
                    (SELECT COUNT(*) FROM detalleintercambio WHERE Cod_Producto = $id_producto) AS total_registros";
    
    $result_check = $conn->query($sql_check);
    $row_check = $result_check->fetch_assoc();
    $total_registros = $row_check['total_registros'];

    if ($total_registros == 0) {
        $sql_delete_etiquetas = "DELETE FROM productoetiqueta WHERE Cod_Producto = $id_producto";
        $conn->query($sql_delete_etiquetas); 
        
        $sql_delete = "DELETE FROM producto WHERE Cod_Producto = $id_producto";
        if ($conn->query($sql_delete) === TRUE) {
            mostrarAlerta('¡Producto Eliminado!', 'El producto ha sido eliminado permanentemente.');
        } else {
            mostrarAlerta('Error', 'No se pudo eliminar: ' . $conn->error);
        }
        
    } else {
        $sql_update = "UPDATE producto SET Activo = 0 WHERE Cod_Producto = $id_producto";
        if ($conn->query($sql_update) === TRUE) {
            mostrarAlerta('Producto Desactivado', 'El producto tiene un historial de movimientos, por lo que se ha desactivado.');
        } else {
            mostrarAlerta('Error', 'Hubo un error al intentar desactivar: ' . $conn->error);
        }
    }
} else {
    mostrarAlerta('Acceso Denegado', 'No se especificó ningún producto.');
}
?>