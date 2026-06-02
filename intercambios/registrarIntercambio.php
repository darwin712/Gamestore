<?php
    session_start();
    require_once('../conexion.php');

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
                    
                    <button id="btnAgregar" onclick="window.location.href=\'intercambios.php\'">Aceptar</button>
                    
                </div>
            </section>
        </body>
        </html>';
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        mostrarAlerta('Acceso denegado', 'No se enviaron datos.', 'error');
    }

    if(empty($_SESSION['CarritoIntercambio'])){
        mostrarAlerta('Carrito Vacío', 'No hay productos en el intercambio.', 'warning');
    }

    if(!isset($_POST['Empleado']) || $_POST['Empleado'] === ''){
        mostrarAlerta('Faltan Datos', 'Debes seleccionar un empleado responsable.', 'warning');
    }

    $varEmpleado = intval($_POST['Empleado']);
    $fecha       = date('Y-m-d');

    $montoTotal = 0;
    foreach($_SESSION['CarritoIntercambio'] as $item){
        $montoTotal += $item['Cantidad'] * $item['Precio'];
    }
    $montoTotal = round($montoTotal, 2);

    $sqlIntercambio = "INSERT INTO intercambio (Fecha, Monto, Cod_Empleado)
                       VALUES ('$fecha', '$montoTotal', '$varEmpleado')";

    if($conn->query($sqlIntercambio) !== TRUE){
        mostrarAlerta('Error de Registro', 'No se pudo guardar el intercambio.', 'error');
    }

    $idIntercambio = $conn->insert_id;

    foreach($_SESSION['CarritoIntercambio'] as $item){
        $cod_producto   = intval($item['Cod_Producto']);
        $precio_unit    = floatval($item['Precio']);
        $estado         = $conn->real_escape_string($item['Estado']);
        $cantidad       = intval($item['Cantidad']);

        $sqlDetalle = "INSERT INTO detalleintercambio
                           (Cod_Intercambio, Cod_Producto, Precio_Unitario, Estado_Producto, Cantidad)
                       VALUES
                           ('$idIntercambio', '$cod_producto', '$precio_unit', '$estado', '$cantidad')";

        if($conn->query($sqlDetalle) !== TRUE){
            if ($conn->errno == 1062) {
                mostrarAlerta('Producto Duplicado', 'Intentaste registrar el mismo producto dos veces. Revisa el estado o agrupa las cantidades.', 'error');
            } else {
                mostrarAlerta('Error de Base de Datos', 'Error al guardar el detalle: ' . $conn->error, 'error');
            }
        }

        $sqlActualizar = "UPDATE producto
                          SET Unidades = Unidades + $cantidad
                          WHERE Cod_Producto = $cod_producto";
        $conn->query($sqlActualizar);
    }

    $_SESSION['CarritoIntercambio'] = [];
    
    mostrarAlerta('¡Éxito!', 'El intercambio se ha registrado correctamente.', 'success');
?>