<?php
    session_start();
    require_once('../conexion.php');

    function mostrarAlerta($titulo, $mensaje, $urlDestino = 'intercambios.php') {
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

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        mostrarAlerta('Acceso denegado', 'No se enviaron datos.');
    }

    if(empty($_SESSION['CarritoIntercambio'])){
        mostrarAlerta('Carrito Vacío', 'No hay productos en el intercambio.');
    }

    if(!isset($_POST['Empleado']) || $_POST['Empleado'] === ''){
        mostrarAlerta('Faltan Datos', 'Debes seleccionar un empleado responsable.');
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
        mostrarAlerta('Error de Registro', 'No se pudo guardar el encabezado del intercambio.');
    }

    $idIntercambio = $conn->insert_id;

    foreach($_SESSION['CarritoIntercambio'] as $item){
        $cod_producto_original = intval($item['Cod_Producto']);
        $precio_unit    = floatval($item['Precio']);
        $estado         = $conn->real_escape_string($item['Estado']);
        $cantidad       = intval($item['Cantidad']);

        $sqlOriginal = "SELECT * FROM producto WHERE Cod_Producto = $cod_producto_original";
        $resOriginal = $conn->query($sqlOriginal);
        $rowOriginal = $resOriginal->fetch_assoc();

        $nombre = $conn->real_escape_string($rowOriginal['Nombre']);
        
        $condicion_destino = ($estado === 'Excelente') ? 'NUEVO' : 'SEMINUEVO';

        $sqlBuscar = "SELECT Cod_Producto FROM producto WHERE Nombre = '$nombre' AND Condicion = '$condicion_destino' AND Activo = 1 LIMIT 1";
        $resBuscar = $conn->query($sqlBuscar);

        if ($resBuscar->num_rows > 0) {
            $rowBuscado = $resBuscar->fetch_assoc();
            $id_producto_final = $rowBuscado['Cod_Producto'];
        } else {
            $precioBase = floatval($rowOriginal['Precio']);
            
            $precioReventa = ($condicion_destino === 'NUEVO') ? $precioBase : round($precioBase * 0.80, 2); 
            
            $imagen = $conn->real_escape_string($rowOriginal['Imagen']);
            $clasificacion = $conn->real_escape_string($rowOriginal['Clasificacion']);
            $descripcion = $conn->real_escape_string($rowOriginal['Descripcion']);
            $categoria = intval($rowOriginal['Cod_Categoria']);

            $sqlInsertNuevo = "INSERT INTO producto (Imagen, Nombre, Precio, Unidades, Clasificacion, Condicion, Descripcion, Cod_Categoria, Activo) 
                               VALUES ('$imagen', '$nombre', '$precioReventa', 0, '$clasificacion', '$condicion_destino', '$descripcion', '$categoria', 1)";
            
            if ($conn->query($sqlInsertNuevo) === TRUE) {
                $id_producto_final = $conn->insert_id;

                $sqlTags = "SELECT Cod_Etiqueta FROM productoetiqueta WHERE Cod_Producto = $cod_producto_original";
                $resTags = $conn->query($sqlTags);
                while($rowTag = $resTags->fetch_assoc()){
                    $idEtq = intval($rowTag['Cod_Etiqueta']);
                    $conn->query("INSERT INTO productoetiqueta (Cod_Producto, Cod_Etiqueta) VALUES ($id_producto_final, $idEtq)");
                }
            } else {
                mostrarAlerta('Error de Base de Datos', 'Error al generar la variante de inventario: ' . $conn->error);
            }
        }

        $sqlDetalle = "INSERT INTO detalleintercambio
                           (Cod_Intercambio, Cod_Producto, Precio_Unitario, Estado_Producto, Cantidad)
                       VALUES
                           ('$idIntercambio', '$id_producto_final', '$precio_unit', '$estado', '$cantidad')";

        if($conn->query($sqlDetalle) !== TRUE){
            if ($conn->errno == 1062) {
                mostrarAlerta('Producto Duplicado', 'Intentaste registrar exactamente el mismo producto con el mismo estado dos veces. Agrupa las cantidades.');
            } else {
                mostrarAlerta('Error de Base de Datos', 'Error al guardar el detalle: ' . $conn->error);
            }
        }

        $sqlActualizar = "UPDATE producto
                          SET Unidades = Unidades + $cantidad
                          WHERE Cod_Producto = $id_producto_final";
        $conn->query($sqlActualizar);
    }

    $_SESSION['CarritoIntercambio'] = [];
    
    mostrarAlerta('¡Éxito!', 'El intercambio se ha registrado y el inventario correspondiente ha sido actualizado.');
?>