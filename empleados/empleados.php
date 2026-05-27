<?php
require_once("../conexion.php");

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
                <div id="title"> Empleados </div>

                <div id="topBar">

    <form action="inventarios.php" method="POST" id="formFiltros">

    <div id="topRow">

        <div id="searchForm">
            <input type="text"placeholder="Consultar empleado..." name="busqueda" id="busquedaInventario" value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : ''; ?>">
        </div>

    </div>

        <div id="filtersSection">

            <select name="turno" id="filterSelect">
                <option value="">Turno</option>
                <option value="Matutino"
                <?php
                if (isset($_POST['condicion']) && $_POST['condicion'] == "Nuevo") {
                    echo "selected";
                }
                ?>>Matutino</option>

                <option value="Vespertino" <?php
                if (isset($_POST['condicion']) && $_POST['condicion'] == "Seminuevo") {
                    echo "selected";
                }
                ?>>Vespertino</option>

                <option value="Mixto" <?php
                if (isset($_POST['condicion']) && $_POST['condicion'] == "Seminuevo") {
                    echo "selected";
                }
                ?>>Mixto</option>
            </select>

            <select name="orden" id="filterSelect">
                <option value="">Ordenar por...</option>
                <option value="nombreASC" <?php
                if (isset($_POST['orden']) && $_POST['orden'] == "nombreASC") {
                    echo "selected";
                }
                ?>>Nombre A-Z</option>

                <option value="nombreDESC" <?php
                if (isset($_POST['orden']) && $_POST['orden'] == "nombreDESC") {
                    echo "selected";
                }
                ?>>Nombre Z-A</option>
            </select>

            <!-- <input type="submit" value="Aplicar filtros" id="btnFiltro"> -->

        </div>
        <button type="submit" hidden></button>
        </form>
</div>
        
                <div id="scroll">
                    <form action="altasEmpleados.php" Method="POST">
                        <input type="submit" id="btnAgregarTop" value="Registrar Empleado">
                    </form>


                    <?php

                    $sql = "SELECT * FROM empleado WHERE 1=1";

                    if (isset($_POST['busqueda']) && $_POST['busqueda'] != "") {
                        $termino = $conn->real_escape_string($_POST['busqueda']);
                        
                        $sql .= " AND (Nombre LIKE '%$termino%' OR Apellido_Paterno LIKE '%$termino%' OR Apellido_Materno LIKE '%$termino%')";
                    }

                    if (isset($_POST['condicion']) && $_POST['condicion'] != "") {
                        $condicion = $conn->real_escape_string($_POST['condicion']);
                        $sql .= " AND Condicion = '$condicion'";
                    }

                    if (isset($_POST['orden'])) {
                        switch ($_POST['orden']) {
                            case "precioASC":
                                $sql .= " ORDER BY Precio ASC";
                            break;
                                
                            case "precioDESC":
                                $sql .= " ORDER BY Precio DESC";
                            break;
                                
                            case "nombreASC":
                                $sql .= " ORDER BY Nombre ASC";
                            break;
                                
                            case "nombreDESC":
                                $sql .= " ORDER BY Nombre DESC";
                            break;
                        }
                    }

                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        
                        echo '<table id="inventario">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre(s)</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>ID</th>
                                <th>Telefono</th>
                                <th>Turnos</th>
                                <th colspan="2">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>'; 

                        while($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><img src="../_Multimedia_/Empleado Icon.png" width="50" height="50"></td>
                                <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['Apellido_Paterno']); ?></td>
                                <td><?php echo htmlspecialchars($row['Apellido_Materno']); ?></td>
                                <td><?php echo htmlspecialchars($row['Cod_Empleado']); ?></td>
                                <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                                <td><?php echo htmlspecialchars($row['Turno']); ?></td>
                                <td>
                                    <form action="modificarEmpleado.php?id=<?php echo $row['Cod_Empleado'];?>" method="POST">
                                        <input type="submit" value="Editar datos">
                                    </form>
                                </td>
                                <td>
                                    <form action="darDeBaja.php?id=<?php echo $row['Cod_Empleado'];?>" method="POST">
                                        <input type="submit" value="Dar de baja">
                                    </form>
                                </td>
                            </tr> 
                    <?php
                        }
                        
                        echo '</tbody></table>'; 
                        
                    } else {
                        echo "<p>No se encontraron empleados.</p>";
                    }
                    ?>
                </div>
        </section>
    </body>
</html>