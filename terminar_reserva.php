<?php
session_start();
include_once 'conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['seleccion']) && isset($_POST['nombre_cliente'])) {
    $seleccion = $_POST['seleccion'];
    $nombre_cliente = $conn->real_escape_string($_POST['nombre_cliente']);

    $sql_cliente = "SELECT id_cliente FROM cliente WHERE nombre_cliente = '$nombre_cliente'";
    $result_cliente = $conn->query($sql_cliente);

    if ($result_cliente->num_rows > 0) {
        $row_cliente = $result_cliente->fetch_assoc();
        $id_cliente = $row_cliente['id_cliente'];
    } else {
        $sql_insert_cliente = "INSERT INTO cliente (nombre_cliente) VALUES ('$nombre_cliente')";
        $conn->query($sql_insert_cliente);
        $id_cliente = $conn->insert_id;
    }

    foreach ($seleccion as $item) {
        list($id_vuelo, $id_hotel) = explode(',', $item);

        $sql_update_vuelo = "UPDATE vuelo SET plazas_disponibles = plazas_disponibles - 1 WHERE id_vuelo = '$id_vuelo'";
        $conn->query($sql_update_vuelo);

        $sql_update_hotel = "UPDATE hotel SET habitaciones_disponibles = habitaciones_disponibles - 1 WHERE id_hotel = '$id_hotel'";
        $conn->query($sql_update_hotel);

        $fecha_reserva = date('Y-m-d H:i:s');
        $sql_insert_reserva = "INSERT INTO agencia.reserva (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES ('$id_cliente', '$fecha_reserva', '$id_vuelo', '$id_hotel')";
        $conn->query($sql_insert_reserva);
    }

    echo "<script>alert('Reserva realizada con éxito.'); window.location.href = 'index.php';</script>";
    exit();
} else {
    header('Location: index.php');
    exit();
}

$conn->close();
?>
