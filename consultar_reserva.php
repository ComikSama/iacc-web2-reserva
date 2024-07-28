<?php
session_start();
include_once 'conexion/conexion.php';

$nombre_cliente = isset($_POST['nombre_usuario']) ? $conn->real_escape_string($_POST['nombre_usuario']) : '';

$sql = "SELECT reserva.id_reserva, cliente.nombre_cliente, reserva.fecha_reserva, vuelo.origen, vuelo.destino, hotel.nombre AS hotel_nombre
        FROM reserva
        INNER JOIN cliente ON reserva.id_cliente = cliente.id_cliente
        LEFT JOIN vuelo ON reserva.id_vuelo = vuelo.id_vuelo
        LEFT JOIN hotel ON reserva.id_hotel = hotel.id_hotel
        WHERE cliente.nombre_cliente = '$nombre_cliente'";

// Ejecutar la consulta
$result_consulta = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Consultar Reserva</title>
</head>
<body>
    <div class="container mt-5">
        <div class="text-center">
            <h2 class="mb-4">Reservas de <?php echo strtoupper(htmlspecialchars($nombre_cliente)); ?></h2>
        </div>
        <?php if ($result_consulta->num_rows > 0): ?>
            <table class='table table-bordered'>
                <thead class='table-dark'>
                    <tr class='text-center'>
                        <th>Fecha Reserva</th>
                        <th>Origen Vuelo</th>
                        <th>Destino Vuelo</th>
                        <th>Hotel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_consulta->fetch_assoc()): ?>
                        <tr class='text-center'>
                            <td><?php echo date('d/m/Y', strtotime($row['fecha_reserva'])); ?></td>
                            <td><?php echo $row['origen']; ?></td>
                            <td><?php echo $row['destino']; ?></td>
                            <td><?php echo $row['hotel_nombre']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No se encontraron reservas para el cliente <?php echo htmlspecialchars($nombre_cliente); ?>.</p>
        <?php endif; ?>
        
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Volver</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
