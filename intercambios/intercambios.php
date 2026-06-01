<?php
    session_start();
    if(!isset($_SESSION['CarritoIntercambio'])){
        $_SESSION['CarritoIntercambio'] = [];
    }
    require_once('../conexion.php');

    // Agregar producto al carrito de intercambio
    if(isset($_POST['producto']) && isset($_POST['cantidad']) && isset($_POST['estado'])){
        $productoSeleccionado = intval($_POST['producto']);
        $cantidadSeleccionada = intval($_POST['cantidad']);
        $estadoSeleccionado   = $_POST['estado'];

        // Validar estado
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
                // Precio ajustado según condición
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
        <style>
          
            #intercambioWrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 28px;
                padding: 20px 0 40px;
            }

            #bloqueAgregar {
                background: rgba(255,255,255,0.82);
                border-radius: 12px;
                padding: 22px 32px;
                width: 700px;
                max-width: 95vw;
                box-shadow: 0 2px 10px rgba(0,0,0,0.10);
            }
            #bloqueAgregar h3 {
                margin: 0 0 16px 0;
                font-size: 1rem;
                color: #555;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            .filaForm {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                align-items: center;
            }
            .filaForm select,
            .filaForm input[type="number"] {
                flex: 1 1 150px;
                padding: 8px 12px;
                border: 1px solid #cce0f0;
                border-radius: 8px;
                font-size: 0.92rem;
                background: #f7fbff;
                color: #333;
            }
            .filaForm select:focus,
            .filaForm input[type="number"]:focus {
                outline: 2px solid #7ec8e3;
            }
            .filaForm input[type="submit"] {
                padding: 8px 22px;
                background: #7ec8e3;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 0.92rem;
                cursor: pointer;
                transition: background 0.2s;
            }
            .filaForm input[type="submit"]:hover {
                background: #4faecf;
            }

            /* ── Bloque: tabla carrito ── */
            #bloqueCarrito {
                width: 700px;
                max-width: 95vw;
            }
            #bloqueCarrito table {
                width: 100%;
                border-collapse: collapse;
                background: rgba(255,255,255,0.82);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            }
            #bloqueCarrito th {
                background: #b8e0f0;
                padding: 11px 14px;
                font-size: 0.92rem;
                color: #3a7ca5;
                text-align: left;
            }
            #bloqueCarrito td {
                padding: 10px 14px;
                font-size: 0.9rem;
                color: #444;
                border-bottom: 1px solid #e8f4fb;
            }
            #bloqueCarrito tr:last-child td {
                border-bottom: none;
            }
            #bloqueCarrito .fila-total td,
            #bloqueCarrito .fila-total th {
                background: #d6eef8;
                font-weight: bold;
                color: #3a7ca5;
            }
            .badge-estado {
                display: inline-block;
                padding: 2px 10px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }
            .badge-Excelente { background: #c8f0c8; color: #2a7a2a; }
            .badge-Bueno     { background: #fff2cc; color: #8a6a00; }

            .btn-eliminar {
                background: #f0a0a0;
                color: #8a0000;
                border: none;
                border-radius: 6px;
                padding: 3px 10px;
                cursor: pointer;
                font-size: 0.82rem;
                transition: background 0.2s;
            }
            .btn-eliminar:hover { background: #e06060; color: #fff; }

            /* ── Bloque: registrar intercambio ── */
            #bloqueRegistrar {
                background: rgba(255,255,255,0.82);
                border-radius: 12px;
                padding: 22px 32px;
                width: 700px;
                max-width: 95vw;
                box-shadow: 0 2px 10px rgba(0,0,0,0.10);
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                align-items: center;
            }
            #bloqueRegistrar select {
                flex: 1 1 220px;
                padding: 8px 12px;
                border: 1px solid #cce0f0;
                border-radius: 8px;
                font-size: 0.92rem;
                background: #f7fbff;
                color: #333;
            }
            #bloqueRegistrar input[type="submit"] {
                padding: 9px 26px;
                background: #7ec8e3;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 0.95rem;
                cursor: pointer;
                font-weight: 600;
                transition: background 0.2s;
            }
            #bloqueRegistrar input[type="submit"]:hover {
                background: #4faecf;
            }
        </style>
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

                <!-- ── 1. Agregar producto al intercambio ── -->
                <div id="bloqueAgregar">
                    <h3>Producto a intercambiar</h3>
                    <form action="intercambios.php" method="POST">
                        <div class="filaForm">
                            <select name="producto" required>
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

                            <select name="estado" required>
                                <option value="">Estado del producto</option>
                                <option value="Excelente"> Excelente (60% del precio)</option>
                                <option value="Bueno"> Bueno (40% del precio)</option>
                            </select>

                            <input type="number" name="cantidad" min="1" value="1" placeholder="Cantidad" required>
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
                        <select name="Empleado" required>
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