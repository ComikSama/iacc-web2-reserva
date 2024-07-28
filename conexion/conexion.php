<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "agencia";

// Crear conexión
$conn = new mysqli($server, $username, $password, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>