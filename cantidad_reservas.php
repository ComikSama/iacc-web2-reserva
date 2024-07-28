<?php
include_once 'conexion/conexion.php';

$num_reservas_min = isset($_POST['num_reservas_min']) ? (int)$_POST['num_reservas_min'] : null;
$num_reservas_max = isset($_POST['num_reservas_max']) ? (int)$_POST['num_reservas_max'] : null;

$sql = "SELECT hotel.id_hotel, hotel.nombre AS hotel_nombre, COUNT(reserva.id_reserva) AS total_reservas
        FROM hotel
        INNER JOIN reserva ON hotel.id_hotel = reserva.id_hotel
        GROUP BY hotel.id_hotel, hotel.nombre";

$havingConditions = [];
if (!is_null($num_reservas_min) && $num_reservas_min !== 0) {
    $havingConditions[] = "total_reservas >= $num_reservas_min";
}
if (!is_null($num_reservas_max) && $num_reservas_max !== 0) {
    $havingConditions[] = "total_reservas <= $num_reservas_max";
}

if (count($havingConditions) > 0) {
    $sql .= " HAVING " . implode(' AND ', $havingConditions);
}

// Ejecutar la consulta
$result = $conn->query($sql);

session_start();
$_SESSION['resultados'] = $result->fetch_all(MYSQLI_ASSOC);

header('Location: resultado_cantidad_reserva.php');
exit();
?>
