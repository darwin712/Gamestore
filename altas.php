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
                <div id="title"> <h1> Altas de Producto </h1> </div>

                <div id="scroll"> 
                    <form action="agregarProducto.php?user=<?php echo isset($usu) ? $usu : ''; ?>" method="POST" enctype="multipart/form-data">
                        <table id="agregar">
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Unidades</th>
                                <th>Condición</th>
                                <th>Clasificación</th>
                                <th>Categoría</th>
                            </tr>
                            <tr>  
                                <td>
                                <input type="file" name="Imagen" accept="image/*" required style="display: block !important; width: 180px; visibility: visible !important; opacity: 1 !important; color: black; font-size: 12px; background-color: white;"></td> 
                                <td><input type="text" maxlength="100" name="Nombre" id="field" placeholder="Ej. FC 26" required></td>
                                <td><input type="text" maxlength="255" name="Descripcion" id="field" placeholder="Breve descripción..."></td>
                                
                                <td><input type="number" step="0.01" name="Precio" id="numberField" placeholder="0.00" required></td>
                                <td><input type="number" name="Unidades" id="numberField" value="0" required></td>
                                
                                <td>
                                    <select name="Condicion" id="field" style="width: 100%;">
                                        <option value="NUEVO">Nuevo</option>
                                        <option value="SEMINUEVO">Seminuevo</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="Clasificacion" id="field" style="width: 100%;">
                                        <option value="E (Everyone)">E (Todos)</option>
                                        <option value="T (Teen)">T (Adolescentes)</option>
                                        <option value="M (Mature)">M (Maduros)</option>
                                        <option value="N/A">N/A (Accesorios/Consolas)</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="Cod_Categoria" id="field" style="width: 100%;">
                                        <option value="1">Videojuego</option>
                                        <option value="2">Consola</option>
                                        <option value="3">Accesorios</option>
                                        <option value="4">Juguetes</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" value="Agregar Producto" class="button">
                        <br><br>
                    </form>
                </div>
            </center>
        </section>
    </body>
</html>