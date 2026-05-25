<?php
    session_start();
    $usu = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Gamestore - Agregar Producto</title>
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
                <div id="title"> <h1> Altas de Producto </h1> </div>
                    <form action="agregarProducto.php?user=<?php echo isset($usu) ? $usu : ''; ?>" method="POST" enctype="multipart/form-data">
                                <div id="formProducto">
    <div id="imgSection">
        <label for="file-upload" class="custom-file-upload">
            <input type="file" accept="image/*" name="Imagen" id="file-upload">

            <img src="Multimedia/Image Icon.png" id="vistaprevia">
        </label>
    </div>

    <div id="datosProducto">

        <div class="fila">
            <input type="text" name="Nombre" class="fieldLarge" placeholder="Nombre del producto">
        </div>

        <div class="fila">
            <textarea name="Descripcion" class="fieldLarge" placeholder="Descripción..."></textarea>
        </div>

        <div class="filaDoble">

            <input type="number" step="0.01" name="Precio" class="fieldSmall" placeholder="Precio">

            <input type="number" name="Unidades" class="fieldSmall" placeholder="Stock">

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

        <button type="submit" id="btnAgregar">
            Agregar Producto
        </button>

    </div>

</div>
    </form>
            </center>
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