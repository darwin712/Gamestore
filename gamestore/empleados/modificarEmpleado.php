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
                    <form action="actualizarEmpleado.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="Cod_Empleado" value="<?php echo $row['Cod_Empleado']; ?>">

                                <div id="formProducto">

    <div id="imgSection">
        <img src="../_Multimedia_/Empleado Icon.png" id="vistaprevia">
    </div>

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