<?php
require_once("../conexion.php");

if (isset($_GET['id'])) {
    $id_empleado = intval($_GET['id']);

    $sql = "SELECT * FROM empleado WHERE Cod_Empleado = $id_empleado";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "El empleado no existe en la base de datos.";
        exit();
    }
} else {
    echo "Error. el empleado a modificar no existe.";
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
                <div id="title"> Editar datos del empleado </div>
                    <form action="actualizarEmpleado.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="Cod_Empleado" value="<?php echo $row['Cod_Empleado']; ?>">

                                <div id="formProducto">

    <div id="datosProducto">

        <div class="fila">
            <input type="text" name="Nombre" class="fieldLarge" placeholder="Nombre(s)" value="<?php echo $row['Nombre']; ?>" required>
        </div>

        <div class="filaDoble">
            <input type="text" name="Apellido_Paterno" class="fieldSmall" placeholder="Apellido Paterno" value="<?php echo $row['Apellido_Paterno']; ?>" required>
            <input type="text" name="Apellido_Materno" class="fieldSmall" placeholder="Apellido Materno" value="<?php echo $row['Apellido_Materno']; ?>" required>
        </div>

        <div class="filaDoble">
            <input type="text" name="Telefono" class="fieldSmall" placeholder="Telefono" value="<?php echo $row['Telefono']; ?>" required>

            <select name="Turno" class="fieldSelect">
                <option value="Matutino" <?php echo ($row['Turno'] == 'Matutino') ? 'selected' : ''; ?>>Matutino</option>
                <option value="Vespertino" <?php echo ($row['Turno'] == 'Vespertino') ? 'selected' : ''; ?>>Vespertino</option>
                <option value="Mixto" <?php echo ($row['Turno'] == 'Mixto') ? 'selected' : ''; ?>>Mixto</option>
            </select>
        </div>

        <button type="submit" id="btnAgregar">
            Guardar Cambios
        </button>

    </div>

</div>
    </form>
        </section>
    </body>
</html>