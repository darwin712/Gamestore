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
                <div id="title"> Registro </div>
                    <form action="registrarEmpleado.php" method="POST" enctype="multipart/form-data">
                                <div id="formProducto">

    <div id="imgSection">
        <img src="../_Multimedia_/Empleado Icon.png" id="vistaprevia">
    </div>

    <div id="datosProducto">

        <div class="fila">
            <input type="text" name="Nombre" class="fieldLarge" placeholder="Nombre(s)" required>
        </div>

        <div class="filaDoble">
            <input type="text" name="Apellido_Paterno" class="fieldSmall" placeholder="Apellido Paterno" required>
            <input type="text" name="Apellido_Materno" class="fieldSmall" placeholder="Apellido Materno" required>
        </div>

        <div class="filaDoble">
            <input type="text" name="Telefono" class="fieldSmall" placeholder="Telefono" required>

            <select name="Turno" class="fieldSelect">
                <option>Matutino</option>
                <option>Vespertino</option>
                <option>Mixto</option>
            </select>
        </div>

        <button type="submit" id="btnAgregar">
            Registrar Empleado
        </button>

    </div>

</div>
    </form>
        </section>
    </body>
</html>