<?php
require_once("conexion.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Gamestore</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="https://static.wikia.nocookie.net/memes-pedia/images/7/79/Padoru.jpg/revision/latest/scale-to-width-down/350?cb=20221202034528&path-prefix=es" type="image/x-icon">
    </head>
    <body>
        <header id="navegator">
            <img src="Multimedia/banner.png" id="logo">
            <nav id="navegacion"> <br>
                <center> 
                    <form action="inicio.php" Method="POST"> <input type="submit" id="seccion" value="🏠 Inicio"> </form>
                    <form action="inventarios.php" Method="POST"> <input type="submit" id="seccion" value=" 📦 Inventarios"> </form>
                    <form action="empleados.html" Method="POST"> <input type="submit" id="seccion" value="👨‍💼 Empleados"> </form> 
                    <form action="ventas.html" Method="POST"> <input type="submit" id="seccion" value="💳 Ventas"> </form> 
                    <form action="intercambios.html" Method="POST"> <input type="submit" id="seccion" value="🤝 Intercambios"> </form> 
                </center>
            </nav>
        </header>
            
        <section id="background">
            <center>
                <div id="title"> <h1> Inventarios </h1> </div>

                <div id="topBar">

    <form action="inventarios.php" method="POST" id="formFiltros">

    <div id="topRow">

        <div id="searchForm">
            <input type="text"placeholder="Buscar productos..." name="busqueda" id="busquedaInventario" value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : ''; ?>">
        </div>

    </div>

        <div id="filtersSection">

            <select name="condicion" id="filterSelect">
                <option value="">Todos</option>
                <option value="Nuevo"
                <?php
                if (isset($_POST['condicion']) && $_POST['condicion'] == "Nuevo") {
                    echo "selected";
                }
                ?>>Nuevo</option>

                <option value="Seminuevo" <?php
                if (isset($_POST['condicion']) && $_POST['condicion'] == "Seminuevo") {
                    echo "selected";
                }
                ?>>Seminuevo</option>
            </select>

            <select name="orden" id="filterSelect">
                <option value="">Ordenar por...</option>
                <option value="precioASC"  <?php
                if (isset($_POST['orden']) && $_POST['orden'] == "precioASC") {
                    echo "selected";
                }
                ?>>Precio: Menor a Mayor</option>

                <option value="precioDESC" <?php
                if (isset($_POST['orden']) && $_POST['orden'] == "precioDESC") {
                    echo "selected";
                }
                ?>>Precio: Mayor a Menor</option>

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

            <input type="number" name="precioMin" placeholder="Precio mínimo" id="miniField" value="<?php echo isset($_POST['precioMin']) ? $_POST['precioMin'] : ''; ?>">

            <input type="number" name="precioMax" placeholder="Precio máximo" id="miniField" value="<?php echo isset($_POST['precioMax']) ? $_POST['precioMax'] : ''; ?>">

            <label id="checkContainer">
                <input type="checkbox" name="stock" <?php
                       if (isset($_POST['stock'])) {
                           echo "checked";
                       }
                       ?>>
                En stock
            </label>

            <!-- <input type="submit" value="Aplicar filtros" id="btnFiltro"> -->

        </div>
        </form>
</div>
        
                <div id="scroll">
                    <form action="altas.php" Method="POST">
                        <input type="submit" id="btnAgregarTop" value="Agregar Productos">
                    </form>


                    <?php

                    $sql = "SELECT * FROM producto WHERE 1=1";

                    if (isset($_POST['busqueda']) && $_POST['busqueda'] != "") {
                        $termino = $conn->real_escape_string($_POST['busqueda']);
                        
                        $sql .= " AND (Nombre LIKE '%$termino%' OR Descripcion LIKE '%$termino%')";
                    }

                    if (isset($_POST['condicion']) && $_POST['condicion'] != "") {
                        $condicion = $conn->real_escape_string($_POST['condicion']);
                        $sql .= " AND Condicion = '$condicion'";
                    }

                    if (isset($_POST['precioMin']) && $_POST['precioMin'] != "") {
                        $precioMin = floatval($_POST['precioMin']);
                        $sql .= " AND Precio >= $precioMin";
                    }

                    if (isset($_POST['precioMax']) && $_POST['precioMax'] != "") {
                        $precioMax = floatval($_POST['precioMax']);
                        $sql .= " AND Precio <= $precioMax";
                    }

                    if (isset($_POST['stock'])) {
                        $sql .= " AND Unidades > 0";
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
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Condición</th>
                                <th>ID</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Unidades</th>
                                <th colspan="2">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>'; 

                        while($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($row['Imagen']); ?>" width="50" height="50" id="imgInventario"></td>
                                <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['Condicion']); ?></td>
                                <td><?php echo htmlspecialchars($row['Cod_Producto']); ?></td>
                                <td><?php echo htmlspecialchars($row['Descripcion']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['Precio']); ?></td>
                                <td><?php echo htmlspecialchars($row['Unidades']); ?></td>
                                <td>
                                    <form action="modificarProducto.php?id=<?php echo $row['Cod_Producto'];?>&user=<?php echo isset($usu) ? $usu : ''; ?>" method="POST">
                                        <input type="submit" value="Modificar">
                                    </form>
                                </td>
                                <td>
                                    <form action="eliminarProducto.php?id=<?php echo $row['Cod_Producto'];?>&user=<?php echo isset($usu) ? $usu : ''; ?>" method="POST">
                                        <input type="submit" value="Eliminar">
                                    </form>
                                </td>
                            </tr> 
                    <?php
                        }
                        
                        echo '</tbody></table>'; 
                        
                    } else {
                        echo "<p>No se encontraron productos que coincidan con tu búsqueda.</p>";
                    }
                    ?>
                </div>
            </center>
        </section>
    </body>
</html>