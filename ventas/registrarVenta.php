<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
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
                    
                    <button id="btnAgregar" onclick="window.location.href=\'ventas.php\'">Aceptar</button>
                    
                </div>
            </section>
        </body>
        </html>';
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        mostrarAlerta('Acceso denegado', 'No se enviaron datos desde el formulario.');
    }

    if (empty($_SESSION['Carrito'])) {
        mostrarAlerta('Carrito Vacío', 'No hay productos seleccionados para la venta.');
    }

    if (!isset($_POST['Empleado']) || $_POST['Empleado'] === '') {
        mostrarAlerta('Faltan Datos', 'Debes seleccionar un empleado responsable para registrar la venta.');
    }

    $varEmpleado = $conn->real_escape_string($_POST['Empleado']);
    $fecha = date('Y-m-d');

    $montoTotal = 0;
    foreach($_SESSION['Carrito'] as $cod => $producto){
        $montoTotal += ($producto['Precio'] * $producto['Cantidad']);
    }

    $sql = "INSERT INTO venta(Fecha, total, Cod_Empleado) VALUES ('$fecha', '$montoTotal', '$varEmpleado')";

    if ($conn->query($sql) === TRUE) {
        $idVenta = $conn->insert_id;
        
        foreach($_SESSION['Carrito'] as $cod => $producto){
            $precio = floatval($producto['Precio']);
            $cantidad = intval($producto['Cantidad']);
            $cod_seguro = intval($cod);

            $sql_detalle = "INSERT INTO detalleventa(Cod_venta, Cod_producto, Precio_Unitario, Cantidad) VALUES ('$idVenta', '$cod_seguro', '$precio', '$cantidad')";
            $sql_actualizarUnidades = "UPDATE producto SET Unidades = Unidades - $cantidad WHERE Cod_Producto = $cod_seguro";
            
            $conn->query($sql_detalle);
            $conn->query($sql_actualizarUnidades);
        }
        
        $_SESSION['Carrito'] = [];
        mostrarAlerta('¡Venta Exitosa!', 'La venta se ha registrado correctamente y el inventario ha sido actualizado.');
        
    } else {
        mostrarAlerta('Error de Registro', 'Hubo un error al registrar la venta: ' . $conn->error);
    }
?>