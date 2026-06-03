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
                    <button type="button" id="seccion" onclick="window.location.href='../inicio.php'"> <img src="../_Multimedia_/inicio.png" class="icono-nav"> Inicio </button>
                    <button type="button" id="seccion" onclick="window.location.href='../productos/inventarios.php'"> <img src="../_Multimedia_/inventarios.png" class="icono-nav"> Inventarios </button>
                    <button type="button" id="seccion" onclick="window.location.href='../empleados/empleados.php'"> <img src="../_Multimedia_/empleados.png" class="icono-nav"> Empleados </button> 
                    <button type="button" id="seccion" onclick="window.location.href='../ventas/ventas.php'"> <img src="../_Multimedia_/ventas.png" class="icono-nav"> Ventas </button> 
                    <button type="button" id="seccion" onclick="window.location.href='../intercambios/intercambios.php'"> <img src="../_Multimedia_/intercambios.png" class="icono-nav"> Intercambios </button>
                    <button type="button" id="seccion" onclick="window.location.href='../reporteFinanciero.php'"> <img src="../_Multimedia_/reporte.png" class="icono-nav"> Reporte Financiero </button>
                </center>
            </nav>
        </header>
            
        <section id="background">
                <div id="title"> Inventarios </div>

                <div id="topBar">

    <form action="inventarios.php" method="POST" id="formFiltros">

    <div id="topRow">

        <div id="searchForm">
            <input type="text"placeholder="Buscar productos..." name="busqueda" id="busquedaInventario" value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : ''; ?>">
        </div>

        <div>
            <button type="submit" id="btnLupa"> <img src="../_Multimedia_/buscar.png" class="icono-nav" style="width: 30px; height: 25px; object-fit: contain;">  </button>
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

            <select name="categoria" id="filterSelect">
                <option value="">Todas las Categorías</option>
                <?php
                $sql_cat = "SELECT Cod_Categoria, Nombre FROM categoria";
                $res_cat = $conn->query($sql_cat);
                while ($row_cat = $res_cat->fetch_assoc()) {
                    $id_cat = $row_cat['Cod_Categoria'];
                    $nombre_cat = $row_cat['Nombre'];
                    $seleccionado = (isset($_POST['categoria']) && $_POST['categoria'] == $id_cat) ? "selected" : "";
                    
                    echo "<option value='$id_cat' $seleccionado>$nombre_cat</option>";
                }
                ?>
            </select>

            <select name="etiqueta" id="filterSelect">
                <option value="">Todas las Etiquetas</option>
                <?php
                $sql_etq = "SELECT Cod_Etiqueta, Nombre FROM etiqueta";
                $res_etq = $conn->query($sql_etq);
                while ($row_etq = $res_etq->fetch_assoc()) {
                    $id_etq = $row_etq['Cod_Etiqueta'];
                    $nombre_etq = $row_etq['Nombre'];
                    
                    $seleccionado = (isset($_POST['etiqueta']) && $_POST['etiqueta'] == $id_etq) ? "selected" : "";
                    
                    echo "<option value='$id_etq' $seleccionado>$nombre_etq</option>";
                }
                ?>
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
        <button type="submit" hidden></button>
        </form>
</div>
        
                <div id="scroll2">
                    <form action="altas.php" Method="POST">
                        <input type="submit" id="btnAgregarTop" value="Agregar Productos">
                    </form>


                    <?php

                    $sql = "SELECT * FROM producto WHERE Activo = 1";

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

                    if (isset($_POST['categoria']) && $_POST['categoria'] != "") {
                        $cat_id = intval($_POST['categoria']);
                        $sql .= " AND Cod_Categoria = $cat_id";
                    }

                    if (isset($_POST['etiqueta']) && $_POST['etiqueta'] != "") {
                        $etq_id = intval($_POST['etiqueta']);
                        $sql .= " AND Cod_Producto IN (SELECT Cod_Producto FROM productoetiqueta WHERE Cod_Etiqueta = $etq_id)";
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
                                <td><img src="<?php echo '../' . htmlspecialchars($row['Imagen']); ?>" width="50" height="50" id="imgInventario"></td>
                                <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['Condicion']); ?></td>
                                <td><?php echo htmlspecialchars($row['Cod_Producto']); ?></td>
                                <td><?php echo htmlspecialchars($row['Descripcion']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['Precio']); ?></td>
                                <td><?php echo htmlspecialchars($row['Unidades']); ?></td>
                                <td>
                                    <form action="modificarProducto.php?id=<?php echo $row['Cod_Producto'];?>" method="POST">
                                        <input type="submit" value="Modificar">
                                    </form>
                                </td>
                                <td>
                                    <form action="eliminarProducto.php?id=<?php echo $row['Cod_Producto'];?>" method="POST" onsubmit="return confirm('¿Deseas eliminar este producto? Esta acción no se puede deshacer.');">
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
        </section>
    </body>
</html>