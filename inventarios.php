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

    <div id="topRow">

        <form action="inventarios.php" Method="POST" id="searchForm">
            <input type="text" placeholder="Buscar productos..." name="busqueda" id="busquedaInventario">
        </form>

        <form action="altas.php" Method="POST">
            <input type="submit" id="btnAgregarTop" value="Agregar Productos">
        </form>

    </div>

    <form action="inventarios.php" Method="POST" id="formFiltros">

        <div id="filtersSection">

            <select name="condicion" id="filterSelect">
                <option value="">Todos</option>
                <option value="Nuevo">Nuevo</option>
                <option value="Usado">Usado</option>
            </select>

            <select name="orden" id="filterSelect">
                <option value="">Ordenar por...</option>
                <option value="precioASC">Precio: Menor a Mayor</option>
                <option value="precioDESC">Precio: Mayor a Menor</option>
                <option value="nombreASC">Nombre A-Z</option>
                <option value="nombreDESC">Nombre Z-A</option>
            </select>

            <input type="number" name="precioMin" placeholder="Precio mínimo" id="miniField">

            <input type="number" name="precioMax" placeholder="Precio máximo" id="miniField">

            <label id="checkContainer">
                <input type="checkbox" name="stock">
                En stock
            </label>

            <input type="submit" value="Aplicar filtros" id="btnFiltro">

        </div>

    </form>

</div>
        
                <div id="scroll">
                    <?php

                    if (isset($_POST['busqueda']) && $_POST['busqueda'] != "") {
                        $termino = $conn->real_escape_string($_POST['busqueda']); 
                        $sql = "SELECT * FROM producto WHERE Nombre LIKE '%$termino%' OR Descripcion LIKE '%$termino%'";
                    } else {
                        $sql = "SELECT * FROM producto";
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
                        echo "<p style='color: white; margin-top: 20px;'>No se encontraron productos que coincidan con tu búsqueda.</p>";
                    }
                    ?>
                </div>
            </center>
        </section>
    </body>
</html>