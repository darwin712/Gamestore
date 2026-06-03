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
                <div id="title"> Registro </div>
                    <form action="registrarEmpleado.php" method="POST" enctype="multipart/form-data">
                                <div id="formProducto">

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