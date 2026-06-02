<?php
    session_start();
    if(!isset($_SESSION['Carrito'])){
        $_SESSION['Carrito'] = [];
    }
    require_once('../conexion.php');

    if(isset($_POST['producto']) && isset($_POST['cantidad'])){
        $productoSeleccionado = $_POST['producto'];
        $cantidadSeleccionada = $_POST['cantidad'];

        $sql = "SELECT Nombre, Precio, Unidades FROM Producto WHERE Cod_producto = $productoSeleccionado";
        $res = $conn->query($sql);
        $row =  $res->fetch_assoc();

        if(isset($_SESSION['Carrito'][$productoSeleccionado])){
            $totalCantidad = $_SESSION['Carrito'][$productoSeleccionado]['Cantidad'] + $cantidadSeleccionada;
        } else {
            $totalCantidad = $cantidadSeleccionada;
        }

        if($totalCantidad > $row['Unidades']){
            echo "<script>alert('Error: No se tiene esa cantidad disponible en el inventario.');</script>";
        } else {
            if(!isset($_SESSION['Carrito'][$productoSeleccionado])) {
                $_SESSION['Carrito'][$productoSeleccionado] = [
                    'Nombre' => $row['Nombre'],
                    'Precio' => $row['Precio'],
                    'Cantidad' => $cantidadSeleccionada
                ];
            } else {
                $_SESSION['Carrito'][$productoSeleccionado]['Cantidad'] += $cantidadSeleccionada;
            }
        }
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Gamestore - Ventas</title>
        <link rel="stylesheet" href="../styles.css">
        <link rel="shortcut icon" href="https://static.wikia.nocookie.net/memes-pedia/images/7/79/Padoru.jpg/revision/latest/scale-to-width-down/350?cb=20221202034528&path-prefix=es" type="image/x-icon">
    </head>
    <body>
        <header id="navegator">
            <img src="../_Multimedia_/banner2.png" id="logo">
            <nav id="navegacion"> <br>
                <center> 
                    <form action="../inicio.php" method="POST"> <input type="submit" id="seccion" value="🏠 Inicio"> </form>
                    <form action="../productos/inventarios.php" method="POST"> <input type="submit" id="seccion" value=" 📦 Inventarios"> </form>
                    <form action="../empleados/empleados.php" method="POST"> <input type="submit" id="seccion" value="👨‍💼 Empleados"> </form> 
                    <form action="../ventas/ventas.php" method="POST"> <input type="submit" id="seccion" value="💳 Ventas"> </form> 
                    <form action="../intercambios/intercambios.php" method="POST"> <input type="submit" id="seccion" value="🤝 Intercambios"> </form> 
                </center>
            </nav>
        </header>
            
        <section id="background">
            <div id="title"> Ventas </div>

            <div id="intercambioWrapper">

                <div id="bloqueAgregar">
                    <h3>Producto a vender</h3>
                    <form action="ventas.php" method="POST">
                        <div class="filaForm">
                            <select name="producto" class="fieldSelect" required>
                                <option value="">Selecciona un producto</option>
                                <?php
                                    $sql_cat = "SELECT Cod_producto, Nombre FROM producto WHERE Unidades > 0";
                                    $res_cat = $conn->query($sql_cat);
                                    while ($row_producto = $res_cat->fetch_assoc()) {
                                        $id_producto = $row_producto['Cod_producto'];
                                        $nombre_producto = $row_producto['Nombre'];
                                        $seleccionado = (isset($_POST['producto']) && $_POST['producto'] == $id_producto) ? "selected" : "";
                            
                                        echo "<option value='$id_producto' $seleccionado>$nombre_producto</option>";
                                    }
                                ?>
                            </select>
                            <input type="number" name="cantidad" min="1" value="1" placeholder="Cantidad" class="fieldSmall" required>
                            <input type="submit" value="Agregar">
                        </div>
                    </form>
                </div>

                <div id="bloqueCarrito">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio unit.</th>
                            <th>Subtotal</th>
                        </tr>
                        <?php 
                        $varTotal = 0;
                        foreach($_SESSION['Carrito'] as $cod => $producto):
                            $subtotal = $producto['Cantidad'] * $producto['Precio'];
                            $varTotal += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['Nombre']) ?></td>
                            <td><?= $producto['Cantidad'] ?></td>
                            <td>$<?= number_format($producto['Precio'], 2) ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                        <?php endforeach;?>
                        <tr class="fila-total">
                            <th colspan="3">Total de la venta</th>
                            <td>$<?= number_format($varTotal, 2) ?></td>
                        </tr>
                    </table>
                </div>

                <div id="bloqueRegistrar">
                    <form action="registrarVenta.php" method="POST" style="display:flex; flex-wrap:wrap; gap:14px; align-items:center; width:100%;">
                        <select name="Empleado" class="fieldSelect" required>
                            <option value="">Empleado responsable</option>
                            <?php
                                $sql_cat = "SELECT Cod_Empleado, Nombre, Apellido_Paterno, Apellido_Materno FROM empleado";
                                $res_cat = $conn->query($sql_cat);
                                while ($row_Cod_empleado = $res_cat->fetch_assoc()) {
                                    $Cod_empleado = $row_Cod_empleado['Cod_Empleado'];
                                    $nombre_empleado = $row_Cod_empleado['Nombre'] . " " . $row_Cod_empleado['Apellido_Paterno'];
                                    $seleccionado = (isset($_POST['Empleado']) && $_POST['Empleado'] == $Cod_empleado) ? "selected" : "";
                        
                                    echo "<option value='$Cod_empleado' $seleccionado>$nombre_empleado</option>";
                                }
                            ?>
                        </select>
                        <input type="submit" value="Registrar venta">
                    </form>
                </div>

            </div>
        </section>
    </body>
</html>