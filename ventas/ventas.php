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
            echo "Error, no se tiene esa cantidad disponible";
            return;
        }

        if(!isset($_SESSION['Carrito'][$productoSeleccionado])) {
        $_SESSION['Carrito'][$productoSeleccionado] = [
            'Nombre' => $row['Nombre'],
            'Precio' => $row['Precio'],
            'Cantidad' => $cantidadSeleccionada
        ];
        }else {
            $_SESSION['Carrito'][$productoSeleccionado]['Cantidad'] += $cantidadSeleccionada;
        }
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Gamestore</title>
        <link rel="stylesheet" href="../styles.css">
        <link rel="shortcut icon" href="https://static.wikia.nocookie.net/memes-pedia/images/7/79/Padoru.jpg/revision/latest/scale-to-width-down/350?cb=20221202034528&path-prefix=es" type="image/x-icon">
    </head>
    <body>
        <header id="navegator">
            <img src="../_Multimedia_/banner2.png" id="logo">
            <nav id="navegacion"> <br>
                <center> 
                    <form action="../inicio.php" Method="POST"> <input type="submit" id="seccion" value="🏠 Inicio"> </form>
                    <form action="../productos/inventarios.php" Method="POST"> <input type="submit" id="seccion" value=" 📦 Inventarios"> </form>
                    <form action="../empleados/empleados.php" Method="POST"> <input type="submit" id="seccion" value="👨‍💼 Empleados"> </form> 
                    <form action="../ventas/ventas.php" Method="POST"> <input type="submit" id="seccion" value="💳 Ventas"> </form> 
                    <form action="../intercambios/intercambios.php" Method="POST"> <input type="submit" id="seccion" value="🤝 Intercambios"> </form> 
                </center>
            </nav>
        </header>
            
        <section id="background">
                <div id="title"> Ventas </div>
                    <form action="ventas.php" method="POST" enctype="multipart/form-data">
                        <select name="producto" id="filterSelect">
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
                        <input type="number" name="cantidad" min="1">
                        <input type="submit" value="Agregar">
                    </form>
        
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                <?php 
                $varTotal = 0;
                foreach($_SESSION['Carrito'] as $cod => $producto):
                    $varTotal += $producto['Cantidad'] * $producto['Precio'];
                    ?>
                     
                    <tr>
                        <td><?= $producto['Nombre'] ?></td>
                        <td><?= $producto['Cantidad'] ?></td>
                        <td><?= $producto['Cantidad'] * $producto['Precio'] ?></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <th>Total</th>
                    <td></td>
                    <td><?= $varTotal ?></td>
                </tr>
                </table>

            <form action="registrarVenta.php" method="POST" enctype="multipart/form-data">
                <select name="Empleado" id="filterSelect">
                    <option value="">Empleado responsable</option>
                    <?php
                             $sql_cat = "SELECT Cod_Empleado, Nombre, Apellido_Paterno, Apellido_Materno FROM empleado";
                             $res_cat = $conn->query($sql_cat);
                             while ($row_Cod_empleado = $res_cat->fetch_assoc()) {
                                 $Cod_empleado = $row_Cod_empleado['Cod_Empleado'];
                                 $nombre_empleado = $row_Cod_empleado['Nombre'];
                                 $seleccionado = isset($_POST['Empleado']) && $_POST['Empleado'] == $Cod_empleado ? "selected" : "";
                    
                                echo "<option value='$Cod_empleado' $seleccionado>$nombre_empleado</option>";
                             }
                        ?>
                </select>
                <input type="submit" value="Registrar venta">
            </form>
        </section>
    </body>
</html>