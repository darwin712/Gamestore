<?php
require_once("../conexion.php");

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);

    $sql = "SELECT * FROM producto WHERE Cod_Producto = $id_producto";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "El producto no existe en la base de datos.";
        exit();
    }
} else {
    echo "Error. el producto no existe.";
    exit();
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
                <div id="title"> Producto </div>

    <div id="formProducto">
        <div id="imgSectionVista">
            <img src="<?php echo '../' . $row['Imagen']; ?>" id="imagenProducto">
        </div>

        <div id="datosProductoVista">
                <h1 style="text-align: left;"> <?php echo $row['Nombre']; ?> </h1>

                <h2 style="text-align: left;"> $<?php echo $row['Precio']; ?> </h2>

                <p style="text-align: left;"> <?php echo $row['Descripcion']; ?> </p>

                <h3 style="text-align: left;"> <?php echo $row['Unidades']; ?> unidades en Stock </h4>

            <div class="filaTriple">
                
                <h4 style="text-align: left;"> Condición: <?php echo $row['Condicion']; ?></h4>
                <h4 style="text-align: left;"> Clasificación: <?php echo $row['Clasificacion']; ?></h4>

                <h4 style="text-align: left;"> <?php
                        switch ($row['Cod_Categoria']) {
                            case 1: echo "Videojuego"; break;
                            case 2: echo "Consola"; break;
                            case 3: echo "Accesorio"; break;
                        }
                ?> </h4>
            </div>

            <div class="fila" style="text-align: left; padding: 15px 0;">
                <label style="color: black; font-weight: bold; margin-bottom: 10px; display: block;">Etiquetas del producto:</label>
                
                <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                    <?php
$sql_etiquetas = "
    SELECT e.Nombre
    FROM etiqueta e
    INNER JOIN productoetiqueta pe
        ON e.Cod_Etiqueta = pe.Cod_Etiqueta
    WHERE pe.Cod_Producto = $id_producto
    ORDER BY e.Nombre ASC
";

$resultado_etiquetas = $conn->query($sql_etiquetas);

if ($resultado_etiquetas && $resultado_etiquetas->num_rows > 0) {
    while ($row_etq = $resultado_etiquetas->fetch_assoc()) {
        echo '<span style="
            background: #e9ecef;
            padding: 6px 12px;
            border-radius: 20px;
            color: black;
            font-size: 14px;
        ">';
        echo htmlspecialchars($row_etq['Nombre']);
        echo '</span>';
    }
} else {
    echo '<span style="color:black;">Este producto no tiene etiquetas.</span>';
}
?>
                </div>
            </div>

        </div>

    </div>
                    
        </section>
    </body>
</html>