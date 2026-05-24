<?php
require_once("conexion.php");

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $usu = isset($_GET['user']) ? $_GET['user'] : '';

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
                <div id="title"> <h1> Modificar Producto </h1> </div>

                <div id="scroll"> 
                    <form action="actualizarProducto.php?user=<?php echo $usu; ?>" method="POST">
                        
                        <input type="hidden" name="Cod_Producto" value="<?php echo $row['Cod_Producto']; ?>">

                        <table id="agregar">
                            <tr>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Unidades</th>
                                <th>Clasificación</th>
                                <th>Categoría</th>
                            </tr>
                            <tr>          
                                <td><input type="text" maxlength="100" name="Nombre" id="field" value="<?php echo ($row['Nombre']); ?>" required></td>
                                <td><input type="text" maxlength="255" name="Descripcion" id="field" value="<?php echo ($row['Descripcion']); ?>"></td>
                                <td><input type="number" step="0.01" name="Precio" id="numberField" value="<?php echo ($row['Precio']); ?>" required></td>
                                <td><input type="number" name="Unidades" id="numberField" value="<?php echo ($row['Unidades']); ?>" required></td>
                                
                                <td>
                                    <select name="Clasificacion" id="field" style="width: 100%;">
                                        <option value="E (Everyone)" <?php echo ($row['Clasificacion'] == 'E (Everyone)') ? 'selected' : ''; ?>>E (Todos)</option>
                                        <option value="T (Teen)" <?php echo ($row['Clasificacion'] == 'T (Teen)') ? 'selected' : ''; ?>>T (Adolescentes)</option>
                                        <option value="M (Mature)" <?php echo ($row['Clasificacion'] == 'M (Mature)') ? 'selected' : ''; ?>>M (Maduros)</option>
                                        <option value="N/A" <?php echo ($row['Clasificacion'] == 'N/A') ? 'selected' : ''; ?>>N/A (Accesorios/Consolas)</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="Cod_Categoria" id="field" style="width: 100%;">
                                        <option value="1" <?php echo ($row['Cod_Categoria'] == 1) ? 'selected' : ''; ?>>Videojuego</option>
                                        <option value="2" <?php echo ($row['Cod_Categoria'] == 2) ? 'selected' : ''; ?>>Consola</option>
                                        <option value="3" <?php echo ($row['Cod_Categoria'] == 3) ? 'selected' : ''; ?>>Accesorios</option>
                                        <option value="4" <?php echo ($row['Cod_Categoria'] == 4) ? 'selected' : ''; ?>>Juguetes</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" value="Guardar Cambios" class="button">
                        <br><br>
                    </form>
                </div>
            </center>
        </section>
    </body>
</html>