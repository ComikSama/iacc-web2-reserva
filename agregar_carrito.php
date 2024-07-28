<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paquete = json_decode($_POST['paquete'], true);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $_SESSION['carrito'][] = $paquete;
    echo 'Paquete agregado al carrito';
}
?>
