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
            <img src="_Multimedia_/banner2.png" id="logo">
            <nav id="navegacion"> <br>
                <center> 
                    <button type="button" id="seccion" onclick="window.location.href='inicio.php'"> <img src="_Multimedia_/inicio.png" class="icono-nav"> Inicio </button>
                    <button type="button" id="seccion" onclick="window.location.href='../gamestore/productos/inventarios.php'"> <img src="_Multimedia_/inventarios.png" class="icono-nav"> Inventarios </button>
                    <button type="button" id="seccion" onclick="window.location.href='../gamestore/empleados/empleados.php'"> <img src="_Multimedia_/empleados.png" class="icono-nav"> Empleados </button> 
                    <button type="button" id="seccion" onclick="window.location.href='../gamestore/ventas/ventas.php'"> <img src="_Multimedia_/ventas.png" class="icono-nav"> Ventas </button> 
                    <button type="button" id="seccion" onclick="window.location.href='../gamestore/intercambios/intercambios.php'"> <img src="_Multimedia_/intercambios.png" class="icono-nav"> Intercambios </button>
                    <button type="button" id="seccion" onclick="window.location.href='reporteFinanciero.php'"> <img src="_Multimedia_/reporte.png" class="icono-nav"> Reporte Financiero </button>
                </center>
            </nav>
        </header>

    <section id="background">
        <div id="title"> Reporte Financiero </div>

            <table id="inventario">
                <thead>
                    <tr>
                        <th>Tipo de movimiento</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT 'VENTA' AS Tipo_Movimiento, Cod_Venta AS Folio, Fecha, Total AS Monto FROM venta
                            UNION
                            SELECT 'INTERCAMBIO' AS Tipo_Movimiento, Cod_Intercambio AS Folio, Fecha, Monto AS Monto FROM intercambio
                            ORDER BY Fecha DESC, Folio DESC";

                    $result = $conn->query($sql);
                    
                    $totalVentas = 0;
                    $totalIntercambios = 0;

                    while($row = $result->fetch_assoc()) {
                        if ($row['Tipo_Movimiento'] == 'VENTA') {
                            $totalVentas += $row['Monto'];
                            $colorMonto = "color: green; font-weight: bold;";
                            $signo = "+ $";
                        } else {
                            $totalIntercambios += $row['Monto'];
                            $colorMonto = "color: red; font-weight: bold;";
                            $signo = "- $";
                        }
                    ?>
                        <tr>
                            <td style="font-weight: bold;"><?= $row['Tipo_Movimiento'] ?></td>
                            <td> <?php 
                                $prefijo = ($row['Tipo_Movimiento'] == 'VENTA') ? 'V-' : 'I-';
                                echo $prefijo . str_pad($row['Folio'], 4, '0', STR_PAD_LEFT); 
                            ?> </td>
                            <td><?= $row['Fecha'] ?></td>
                            <td style="<?= $colorMonto ?>"><?= $signo . number_format($row['Monto'], 2) ?></td>
                        </tr>
                    <?php } 
                    
                    $balanceGeneral = $totalVentas - $totalIntercambios;
                    $colorBalance = ($balanceGeneral >= 0) ? "color: green;" : "color: red;";
                    ?>
                    
                    <tr style="background: #e8f5e9; font-weight: bold;">
                        <td colspan="3" style="text-align: right; padding-right: 20px;">Total Ingresos (Ventas):</td>
                        <td style="color: green;">+ $<?= number_format($totalVentas, 2) ?></td>
                    </tr>
                    <tr style="background: #ffebee; font-weight: bold;">
                        <td colspan="3" style="text-align: right; padding-right: 20px;">Total Egresos (Intercambios):</td>
                        <td style="color: red;">- $<?= number_format($totalIntercambios, 2) ?></td>
                    </tr>
                    <tr style="background: #d6eef8; font-weight: bold; font-size: 1.1em;">
                        <td colspan="3" style="text-align: right; padding-right: 20px;">Balance General en Caja:</td>
                        <td style="<?= $colorBalance ?>">$<?= number_format($balanceGeneral, 2) ?></td>
                    </tr>
                </tbody>
            </table>

    </section>
</body>
</html>