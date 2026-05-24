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
                    <form action="inicio.php" Method="POST" style="display:inline-block;"> <input type="submit" id="seccion" value="🏠 Inicio"> </form>
                    <form action="inventarios.php" Method="POST" style="display:inline-block;"> <input type="submit" id="seccion" value=" 📦 Inventarios"> </form>
                    <form action="empleados.html" Method="POST" style="display:inline-block;"> <input type="submit" id="seccion" value="👨‍💼 Empleados"> </form> 
                    <form action="ventas.html" Method="POST" style="display:inline-block;"> <input type="submit" id="seccion" value="💳 Ventas"> </form> 
                    <form action="intercambios.html" Method="POST" style="display:inline-block;"> <input type="submit" id="seccion" value="🤝 Intercambios"> </form> 
                </center>
            </nav>
        </header>
            
        <section id="background">
            <center>
                <div id="title"> <h1> Inicio </h1> </div>
                <form action="busquedaproductos.php" Method="POST">
                    <input type="text" placeholder="Buscar productos..." name="busqueda" id="busqueda">
                </form>
        
                <div id="scroll">
                    <?php
                    $sql = "SELECT * FROM producto";
                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            
                            $ruta_imagen = ($row['Imagen'] != '') ? $row['Imagen'] : 'https://via.placeholder.com/160x160.png?text=Sin+Imagen';
                    ?>
                            <div style="display: inline-block; margin: 15px; vertical-align: top;"> 
                                <form action="verproducto.php" method="GET">
                                    <input type="hidden" name="ID" value="<?php echo ($row['Cod_Producto']); ?>">
                                    <input type="hidden" name="user" value="<?php echo isset($usu) ? $usu : ''; ?>">
                                    
                                    <button type="submit" id="btnProduct" > 
                                        <div id="contenedor"> 
                                            <img alt="Portada" width="160px" height="160px" id="imagesize" src="<?php echo htmlspecialchars($ruta_imagen); ?>">
                                            
                                            <div id="infoBox">
                                                <h2> <?php echo ($row['Nombre']); ?> 
                                                     <span style="font-size: 14px; color: #ccc;">(<?php echo ($row['Condicion']); ?>)</span>
                                                </h2>
                                                <h3> $<?php echo ($row['Precio']); ?> </h3>
                                            </div>
                                        </div> 
                                    </button> 
                                </form>
                            </div>
                    <?php
                        } 
                    } else {
                        echo "<p style='color: white; margin-top: 20px;'>No hay productos disponibles por el momento.</p>";
                    }
                    ?>
                </div>
            </center>
        </section>
    </body>
</html>