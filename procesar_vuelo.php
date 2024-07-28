<?php
include_once 'conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = $conn->real_escape_string($_POST['origen']);
    $destino = $conn->real_escape_string($_POST['destino']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $plazas_disponibles = (int)$_POST['plazas_disponibles'];
    $precio = (int)$_POST['precio'];

    $sql = "INSERT INTO vuelo (origen, destino, fecha, plazas_disponibles, precio) VALUES ('$origen', '$destino', '$fecha', '$plazas_disponibles', '$precio')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Vuelo registrado correctamente'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
