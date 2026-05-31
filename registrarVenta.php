<?php
    session_start();
    require_once('../conexion.php');

    $varEmpleado = $_POST['Empleado']; 
    $fecha = date('Y-m-d');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $varEmpleado = $conn->real_escape_string($_POST['Empleado']);

    $sql = "INSERT INTO venta(Fecha, total, Cod_Empleado) VALUES ('$fecha', '0', '$varEmpleado')";

    if ($conn->query($sql) === TRUE) {
        $idVenta = $conn->insert_id;
        foreach($_SESSION['Carrito'] as $cod => $producto){
            $sql_detalle = "INSERT INTO detalleventa(Cod_venta, Cod_producto, Precio_Unitario, Cantidad) VALUES ('$idVenta', '$cod', '{$producto['Precio']}', {$producto['Cantidad']})";
            $sql_actualizarUnidades = "UPDATE producto SET Unidades = Unidades - {$producto['Cantidad']} WHERE Cod_Producto = $cod";
            $conn->query($sql_detalle);
            $conn->query($sql_actualizarUnidades);
        }
        $_SESSION['Carrito'] = [];
        header('Location: ventas.php');
    } else {
            echo "Hubo un error al registrar la venta: " . $conn->error;
        }
    } else {
        echo "Acceso denegado. No se enviaron datos.";
}
     
?>
ini_set('display_errors', 1);
error_reporting(E_ALL);