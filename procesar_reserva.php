<?php
session_start();
include_once 'conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = $conn->real_escape_string($_POST['origen']);
    $destino = $conn->real_escape_string($_POST['destino']);

    $_SESSION['origen'] = $origen;
    $_SESSION['destino'] = $destino;

    header('Location: resultados_reserva.php');
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>