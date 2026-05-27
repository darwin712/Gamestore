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
        <title>Gamestore - Modificar Producto</title>
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
                </select>
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