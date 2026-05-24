<?php
$servername = "127.0.0.1";
$database = "cimagames";
$username = "root";
$password = "01052006";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Fallo en la conexion: " . mysqli_connect_error());
}

?>