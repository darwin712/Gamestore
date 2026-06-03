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
    echo "Error. el producto a modificar no existe.";
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
                <div id="title"> Modificar Producto </div>

               <form action="actualizarProducto.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="Cod_Producto" value="<?php echo $row['Cod_Producto']; ?>">
    <input type="hidden" name="Ruta_Actual" value="<?php echo $row['Imagen']; ?>">

    <div id="formProducto">
        <div id="imgSection">
            <label for="file-upload" class="custom-file-upload">
                <input type="file" accept="image/*" name="Imagen" id="file-upload">
                <img src="<?php echo '../' . $row['Imagen']; ?>" id="vistaprevia">
            </label>
        </div>

        <div id="datosProducto">
            <div class="fila">
                <input type="text" name="Nombre" class="fieldLarge" placeholder="Nombre del producto" value="<?php echo $row['Nombre']; ?>" required>
            </div>

            <div class="fila">
                <textarea name="Descripcion" class="fieldLarge" placeholder="Descripción..." required><?php echo $row['Descripcion']; ?></textarea>
            </div>

            <div class="filaDoble">
                <input type="number" step="0.01" name="Precio" class="fieldSmall" placeholder="Precio" value="<?php echo $row['Precio']; ?>" required>
                <input type="number" name="Unidades" class="fieldSmall" placeholder="Stock" value="<?php echo $row['Unidades']; ?>" required>
            </div>

            <div class="filaTriple">
                <select name="Condicion" class="fieldSelect">
                    <option value="NUEVO" <?php echo ($row['Condicion'] == 'NUEVO') ? 'selected' : ''; ?>>Nuevo</option>
                    <option value="SEMINUEVO" <?php echo ($row['Condicion'] == 'SEMINUEVO') ? 'selected' : ''; ?>>Seminuevo</option>
                </select>

                <select name="Clasificacion" class="fieldSelect">
                    <option value="E" <?php echo ($row['Clasificacion'] == 'E') ? 'selected' : ''; ?>>E</option>
                    <option value="T" <?php echo ($row['Clasificacion'] == 'T') ? 'selected' : ''; ?>>T</option>
                    <option value="M" <?php echo ($row['Clasificacion'] == 'M') ? 'selected' : ''; ?>>M</option>
                </select>

                <select name="Cod_Categoria" class="fieldSelect">
                    <option value="1" <?php echo ($row['Cod_Categoria'] == 1) ? 'selected' : ''; ?>>Videojuego</option>
                    <option value="2" <?php echo ($row['Cod_Categoria'] == 2) ? 'selected' : ''; ?>>Consola</option>
                    <option value="3" <?php echo ($row['Cod_Categoria'] == 3) ? 'selected' : ''; ?>>Accesorio</option>
                    <option value="4" <?php echo ($row['Cod_Categoria'] == 4) ? 'selected' : ''; ?>>Juguetes</option>
                </select>
            </div>

            <div class="fila" style="text-align: left; padding: 15px 0;">
                <label style="color: black; font-weight: bold; margin-bottom: 10px; display: block;">Etiquetas del producto:</label>
                
                <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                    <?php
                   
                    $etiquetas_actuales = []; 
                    $sql_asignadas = "SELECT Cod_Etiqueta FROM productoetiqueta WHERE Cod_Producto = $id_producto";
                    $resultado_asignadas = $conn->query($sql_asignadas);
                    
                    if ($resultado_asignadas && $resultado_asignadas->num_rows > 0) {
                        while ($row_asignada = $resultado_asignadas->fetch_assoc()) {
                            $etiquetas_actuales[] = $row_asignada['Cod_Etiqueta']; 
                        }
                    }

                    $sql_etiquetas = "SELECT Cod_Etiqueta, Nombre FROM etiqueta ORDER BY Nombre ASC";
                    $resultado_etiquetas = $conn->query($sql_etiquetas);

                    if ($resultado_etiquetas && $resultado_etiquetas->num_rows > 0) {
                        while ($row_etq = $resultado_etiquetas->fetch_assoc()) {
                            
                            $id_etq = $row_etq['Cod_Etiqueta'];
                            $nombre_etq = htmlspecialchars($row_etq['Nombre']);
                            
                            $marcado = in_array($id_etq, $etiquetas_actuales) ? 'checked' : '';

                            echo '<label style="color: black; cursor: pointer;">';
                            echo '<input type="checkbox" name="etiquetas[]" value="' . $id_etq . '" ' . $marcado . '> ';
                            echo $nombre_etq;
                            echo '</label>';
                        }
                    } else {
                        echo '<span style="color: #000000;">No hay etiquetas registradas en la base de datos.</span>';
                    }
                    ?>
                </div>
            </div>

            <button type="submit" id="btnAgregar">
                Guardar Cambios
            </button>

        </div>

    </div>

</form>
        </section>
        <script>
	const defaultFile = 'Image Icon.png';
	
	const file = document.getElementById( 'file-upload' );
	const img = document.getElementById( 'vistaprevia' );
	file.addEventListener( 'change', e => {
		if( e.target.files[0] ){
			const reader = new FileReader( );
			reader.onload = function( e ){
				img.src = e.target.result;
			}
			reader.readAsDataURL(e.target.files[0])
		}else{
			img.src = defaultFile;
		}
	} );
</script>
    </body>
</html>