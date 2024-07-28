<?php
include_once 'conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $habitaciones_disponibles = (int)$_POST['habitaciones_disponibles'];
    $tarifa_noche = (int)$_POST['tarifa_noche'];

    $sql = "INSERT INTO hotel (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES ('$nombre', '$ubicacion', '$habitaciones_disponibles', '$tarifa_noche')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Hotel registrado correctamente'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
