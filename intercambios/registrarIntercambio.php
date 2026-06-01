<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once('../conexion.php');

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo "Acceso denegado. No se enviaron datos.";
        exit;
    }

    // Validar que haya productos en el carrito
    if(empty($_SESSION['CarritoIntercambio'])){
        echo "No hay productos en el intercambio.";
        exit;
    }

    // Validar empleado
    if(!isset($_POST['Empleado']) || $_POST['Empleado'] === ''){
        echo "Debes seleccionar un empleado responsable.";
        exit;
    }

    $varEmpleado = intval($_POST['Empleado']);
    $fecha       = date('Y-m-d');

    // Calcular monto total
    $montoTotal = 0;
    foreach($_SESSION['CarritoIntercambio'] as $item){
        $montoTotal += $item['Cantidad'] * $item['Precio'];
    }
    $montoTotal = round($montoTotal, 2);

    // Insertar encabezado del intercambio
    $sqlIntercambio = "INSERT INTO intercambio (Fecha, Monto, Cod_Empleado)
                       VALUES ('$fecha', '$montoTotal', '$varEmpleado')";

    if($conn->query($sqlIntercambio) !== TRUE){
        echo "Error al registrar el intercambio: " . $conn->error;
        exit;
    }

    $idIntercambio = $conn->insert_id;

    // Insertar cada detalle
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
            echo "Error al guardar detalle del intercambio: " . $conn->error;
            exit;
        }

        // Los productos recibidos en intercambio se suman al inventario
        $sqlActualizar = "UPDATE producto
                          SET Unidades = Unidades + $cantidad
                          WHERE Cod_Producto = $cod_producto";
        $conn->query($sqlActualizar);
    }

    // Limpiar carrito de intercambio
    $_SESSION['CarritoIntercambio'] = [];

    // Redirigir de vuelta
    header('Location: intercambios.php');
    exit;
?>
