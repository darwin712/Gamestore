<?php
    session_start();
    if(!isset($_SESSION['CarritoIntercambio'])){
        $_SESSION['CarritoIntercambio'] = [];
    }
    require_once('../conexion.php');

    if(isset($_POST['producto']) && isset($_POST['cantidad']) && isset($_POST['estado'])){
        $productoSeleccionado = intval($_POST['producto']);
        $cantidadSeleccionada = intval($_POST['cantidad']);
        $estadoSeleccionado   = $_POST['estado'];

        $estadosValidos = ['Excelente', 'Bueno'];
        if(!in_array($estadoSeleccionado, $estadosValidos)){
            echo "<script>alert('Estado inválido.');</script>";
        } elseif($cantidadSeleccionada < 1){
            echo "<script>alert('La cantidad debe ser al menos 1.');</script>";
        } else {
            $sql = "SELECT Nombre, Precio FROM producto WHERE Cod_Producto = $productoSeleccionado";
            $res = $conn->query($sql);
            $row = $res->fetch_assoc();

            if($row){
                $precioBase = floatval($row['Precio']);
                $precioIntercambio = ($estadoSeleccionado === 'Excelente') ? round($precioBase * 0.60, 2) : round($precioBase * 0.40, 2);

                $key = $productoSeleccionado . '_' . $estadoSeleccionado;

                if(isset($_SESSION['CarritoIntercambio'][$key])){
                    $_SESSION['CarritoIntercambio'][$key]['Cantidad'] += $cantidadSeleccionada;
                } else {
                    $_SESSION['CarritoIntercambio'][$key] = [
                        'Cod_Producto'  => $productoSeleccionado,
                        'Nombre'        => $row['Nombre'],
                        'Precio'        => $precioIntercambio,
                        'Estado'        => $estadoSeleccionado,
                        'Cantidad'      => $cantidadSeleccionada
                    ];
                }
            }
        }
    }


    if(isset($_GET['eliminar'])){
        $keyEliminar = $_GET['eliminar'];
        if(isset($_SESSION['CarritoIntercambio'][$keyEliminar])){
            unset($_SESSION['CarritoIntercambio'][$keyEliminar]);
        }
        header('Location: intercambios.php');
        exit;
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
                    <form action="../inicio.php" method="POST">                          <input type="submit" id="seccion" value="🏠 Inicio"> </form>
                    <form action="../productos/inventarios.php" method="POST">           <input type="submit" id="seccion" value="📦 Inventarios"> </form>
                    <form action="../empleados/empleados.php" method="POST">             <input type="submit" id="seccion" value="👨‍💼 Empleados"> </form>
                    <form action="../ventas/ventas.php" method="POST">                   <input type="submit" id="seccion" value="💳 Ventas"> </form>
                    <form action="../intercambios/intercambios.php" method="POST">       <input type="submit" id="seccion" value="🤝 Intercambios"> </form>
                </center>
            </nav>
        </header>

        <section id="background">
            <div id="title">Intercambios</div>

            <div id="intercambioWrapper">
                <div id="bloqueAgregar">
                    <h3>Producto a intercambiar</h3>
                    <form action="intercambios.php" method="POST">
                        <div class="filaForm">
                            <select name="producto" class="fieldSelect" required>
                                <option value="">Selecciona un producto</option>
                                <?php
                                    $sql_prod = "SELECT Cod_Producto, Nombre FROM producto WHERE Unidades > 0";
                                    $res_prod = $conn->query($sql_prod);
                                    while($row_prod = $res_prod->fetch_assoc()):
                                        $sel = (isset($_POST['producto']) && $_POST['producto'] == $row_prod['Cod_Producto']) ? 'selected' : '';
                                        echo "<option value='{$row_prod['Cod_Producto']}' $sel>{$row_prod['Nombre']}</option>";
                                    endwhile;
                                ?>
                            </select>

                            <select name="estado" class="fieldSelect" required>
                                <option value="">Estado del producto</option>
                                <option value="Excelente"> Excelente (60% del precio)</option>
                                <option value="Bueno"> Bueno (40% del precio)</option>
                            </select>

                            <input type="number" name="cantidad" min="1" value="1" placeholder="Cantidad"  class="fieldSmall" required>
                            <input type="submit" value="Agregar">
                        </div>
                    </form>
                </div>

               
                <div id="bloqueCarrito">
                    <table>
                        <tr>
                            <th>Producto</th>
                            <th>Estado</th>
                            <th>Cant.</th>
                            <th>Precio unit.</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                        <?php
                            $montoTotal = 0;
                            foreach($_SESSION['CarritoIntercambio'] as $key => $item):
                                $subtotal = $item['Cantidad'] * $item['Precio'];
                                $montoTotal += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['Nombre']) ?></td>
                            <td><span class="badge-estado badge-<?= $item['Estado'] ?>"><?= $item['Estado'] ?></span></td>
                            <td><?= $item['Cantidad'] ?></td>
                            <td>$<?= number_format($item['Precio'], 2) ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td>
                                <a href="intercambios.php?eliminar=<?= urlencode($key) ?>">
                                    <button class="btn-eliminar" type="button">✕</button>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="fila-total">
                            <th colspan="4">Monto total del intercambio</th>
                            <td colspan="2">$<?= number_format($montoTotal, 2) ?></td>
                        </tr>
                    </table>
                </div>

              
                <div id="bloqueRegistrar">
                    <form action="registrarIntercambio.php" method="POST" style="display:flex; flex-wrap:wrap; gap:14px; align-items:center; width:100%;">
                        <select name="Empleado" class="fieldSelect" required>
                            <option value=""> Empleado responsable</option>
                            <?php
                                $sql_emp = "SELECT Cod_Empleado, Nombre, Apellido_Paterno FROM empleado";
                                $res_emp = $conn->query($sql_emp);
                                while($row_emp = $res_emp->fetch_assoc()):
                                    echo "<option value='{$row_emp['Cod_Empleado']}'>{$row_emp['Nombre']} {$row_emp['Apellido_Paterno']}</option>";
                                endwhile;
                            ?>
                        </select>
                        <input type="submit" value="Registrar intercambio">
                    </form>
                </div>

            </div>
        </section>
    </body>
</html>