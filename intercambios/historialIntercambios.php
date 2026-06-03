<?php
    session_start();
    require_once('../conexion.php');
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
                    <button type="button" id="seccion" onclick="window.location.href='../inicio.php'"> <img src="../_Multimedia_/inicio.png" class="icono-nav"> Inicio </button>
                    <button type="button" id="seccion" onclick="window.location.href='../productos/inventarios.php'"> <img src="../_Multimedia_/inventarios.png" class="icono-nav"> Inventarios </button>
                    <button type="button" id="seccion" onclick="window.location.href='../empleados/empleados.php'"> <img src="../_Multimedia_/empleados.png" class="icono-nav"> Empleados </button> 
                    <button type="button" id="seccion" onclick="window.location.href='../ventas/ventas.php'"> <img src="../_Multimedia_/ventas.png" class="icono-nav"> Ventas </button> 
                    <button type="button" id="seccion" onclick="window.location.href='../intercambios/intercambios.php'"> <img src="../_Multimedia_/intercambios.png" class="icono-nav"> Intercambios </button>
                </center>
            </nav>
        </header>
            
        <section id="background">
            <div id="title"> Historial de Intercambios </div>

            <div id="topBar">
                <form action="historialIntercambios.php" method="POST" id="formFiltros">

                    <div id="filtersSection">
                        <input type="number" placeholder="Buscar por ID..." name="busqueda" id="miniField" value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : ''; ?>">

                        <select name="empleado" id="filterSelect">
                            <option value="">Todos los Empleados</option>
                            <?php
                                $sql_emp = "SELECT Cod_Empleado, Nombre, Apellido_Paterno FROM empleado";
                                $res_emp = $conn->query($sql_emp);
                                while ($row_emp = $res_emp->fetch_assoc()) {
                                    $id_emp = $row_emp['Cod_Empleado'];
                                    $nombre_emp = $row_emp['Nombre'] . " " . $row_emp['Apellido_Paterno'];
                                    $seleccionado = (isset($_POST['empleado']) && $_POST['empleado'] == $id_emp) ? "selected" : "";
                                    echo "<option value='$id_emp' $seleccionado>$nombre_emp</option>";
                                }
                            ?>
                        </select>

                        <select name="orden" id="filterSelect">
                            <option value="">Ordenar por...</option>
                            <option value="recientes" <?php echo (isset($_POST['orden']) && $_POST['orden'] == "recientes") ? "selected" : ""; ?>>Más Recientes</option>
                            <option value="antiguas" <?php echo (isset($_POST['orden']) && $_POST['orden'] == "antiguas") ? "selected" : ""; ?>>Más Antiguas</option>
                            <option value="mayorMonto" <?php echo (isset($_POST['orden']) && $_POST['orden'] == "mayorMonto") ? "selected" : ""; ?>>Mayor Monto</option>
                        </select>

                        <input type="number" name="precioMin" placeholder="Monto mínimo" id="miniField" value="<?php echo isset($_POST['precioMin']) ? $_POST['precioMin'] : ''; ?>">

                        <input type="number" name="precioMax" placeholder="Monto máximo" id="miniField" value="<?php echo isset($_POST['precioMax']) ? $_POST['precioMax'] : ''; ?>">

                    </div>
                    <button type="submit" hidden></button>
                </form>
            </div>

            <div id="scroll2">

                <?php
                    $sql = "SELECT 
                                i.Cod_Intercambio, 
                                i.Fecha, 
                                i.Monto AS Total, 
                                CONCAT(e.Nombre, ' ', e.Apellido_Paterno) AS Empleado,
                                GROUP_CONCAT(CONCAT(p.Nombre, ' (', di.Estado_Producto, ') (x', di.Cantidad, ')') SEPARATOR '<br>') AS Detalles
                            FROM intercambio i
                            INNER JOIN empleado e ON i.Cod_Empleado = e.Cod_Empleado
                            INNER JOIN detalleintercambio di ON i.Cod_Intercambio = di.Cod_Intercambio
                            LEFT JOIN producto p ON di.Cod_Producto = p.Cod_Producto
                            WHERE 1=1";

                    if (isset($_POST['busqueda']) && $_POST['busqueda'] != "") {
                        $idInt = intval($_POST['busqueda']);
                        $sql .= " AND i.Cod_Intercambio = $idInt";
                    }

                    if (isset($_POST['empleado']) && $_POST['empleado'] != "") {
                        $idEmp = intval($_POST['empleado']);
                        $sql .= " AND i.Cod_Empleado = $idEmp";
                    }

                    if (isset($_POST['precioMin']) && $_POST['precioMin'] != "") {
                        $precioMin = floatval($_POST['precioMin']);
                        $sql .= " AND i.Monto >= $precioMin";
                    }

                    if (isset($_POST['precioMax']) && $_POST['precioMax'] != "") {
                        $precioMax = floatval($_POST['precioMax']);
                        $sql .= " AND i.Monto <= $precioMax";
                    }

                    $sql .= " GROUP BY i.Cod_Intercambio";

                    if (isset($_POST['orden']) && $_POST['orden'] != "") {
                        switch ($_POST['orden']) {
                            case "recientes":
                                $sql .= " ORDER BY i.Fecha DESC, i.Cod_Intercambio DESC";
                                break;
                            case "antiguas":
                                $sql .= " ORDER BY i.Fecha ASC, i.Cod_Intercambio ASC";
                                break;
                            case "mayorMonto":
                                $sql .= " ORDER BY i.Monto DESC";
                                break;
                        }
                    } else {
                        $sql .= " ORDER BY i.Fecha DESC, i.Cod_Intercambio DESC";
                    }

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        echo '<table id="inventario">
                        <thead>
                            <tr>
                                <th>ID Intercambio</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Artículos Recibidos</th>
                                <th>Monto Total</th>
                            </tr>
                        </thead>
                        <tbody>'; 

                        while($row = $result->fetch_assoc()) {
                            $detalles = $row['Detalles'] ? $row['Detalles'] : '<span style="color:gray;"><i>Producto no encontrado</i></span>';
                ?>
                            <tr>
                                <td><b>#<?php echo htmlspecialchars($row['Cod_Intercambio']); ?></b></td>
                                <td><?php echo htmlspecialchars($row['Fecha']); ?></td>
                                <td><?php echo htmlspecialchars($row['Empleado']); ?></td>
                                <td style="text-align: left; padding-left: 20px;"><?php echo $detalles; ?></td>
                                <td style="font-weight: bold; color: #3a7ca5;">$<?php echo number_format($row['Total'], 2); ?></td>
                            </tr> 
                <?php
                        }
                        echo '</tbody></table>'; 
                    } else {
                        echo "<p style='margin-top:20px;'>No se encontraron registros de intercambios que coincidan con tu búsqueda.</p>";
                    }
                ?>
            </div>
        </section>
    </body>
</html>