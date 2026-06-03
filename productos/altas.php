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
                </center>
            </nav>
        </header>
            
        <section id="background">
                <div id="title"> Registro </div>
                    <form action="agregarProducto.php" method="POST" enctype="multipart/form-data">
                                <div id="formProducto">
    <div id="imgSection">
        <label for="file-upload" class="custom-file-upload">
            <input type="file" accept="image/*" name="Imagen" id="file-upload">

            <img src="../_Multimedia_/Image Icon2.png" id="vistaprevia">
        </label>
    </div>

    <div id="datosProducto">

        <div class="fila">
            <input type="text" name="Nombre" class="fieldLarge" placeholder="Nombre del producto" required>
        </div>

        <div class="fila">
            <textarea name="Descripcion" class="fieldLarge" placeholder="Descripción..." required></textarea>
        </div>

        <div class="filaDoble">

            <input type="number" step="0.01" name="Precio" class="fieldSmall" placeholder="Precio" required>

            <input type="number" name="Unidades" class="fieldSmall" placeholder="Stock" required>

        </div>

        <div class="filaTriple">

            <select name="Condicion" class="fieldSelect">
                <option>Nuevo</option>
                <option>Seminuevo</option>
            </select>

            <select name="Clasificacion" class="fieldSelect">
                <option>E</option>
                <option>T</option>
                <option>M</option>
            </select>

            <select name="Cod_Categoria" class="fieldSelect">
                <option value="1">Videojuego</option>
                <option value="2">Consola</option>
                <option value="3">Accesorio</option>
            </select>

        </div>

        <div class="fila" style="text-align: left; padding: 10px 0;">
            <label style="color: BLACK; font-weight: bold; margin-bottom: 5px; display: block;">Etiquetas (Selecciona varias):</label>
            
            <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                <?php
                $sql_etiquetas = "SELECT Cod_Etiqueta, Nombre FROM etiqueta ORDER BY Nombre ASC";
                $resultado_etiquetas = $conn->query($sql_etiquetas);

                if ($resultado_etiquetas && $resultado_etiquetas->num_rows > 0) {
                    while ($row_etq = $resultado_etiquetas->fetch_assoc()) {
                        echo '<label style="color: black; cursor: pointer;">';
                        echo '<input type="checkbox" name="etiquetas[]" value="' . $row_etq['Cod_Etiqueta'] . '"> ';
                        echo htmlspecialchars($row_etq['Nombre']);
                        echo '</label>';
                    }
                } else {
                    echo '<span style="color: #000000;">No hay etiquetas registradas en el sistema.</span>';
                }
                ?>
            </div>
        </div>

        <button type="submit" id="btnAgregar">
            Agregar Producto
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