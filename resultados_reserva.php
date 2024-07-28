<?php
session_start();
include_once 'conexion/conexion.php';

$origen = isset($_SESSION['origen']) ? $_SESSION['origen'] : '';
$destino = isset($_SESSION['destino']) ? $_SESSION['destino'] : '';

$sql = "SELECT vuelo.id_vuelo, vuelo.origen, vuelo.destino, hotel.id_hotel, hotel.nombre AS hotel_nombre, vuelo.fecha, hotel.habitaciones_disponibles, vuelo.plazas_disponibles, vuelo.precio AS vuelo_precio, hotel.tarifa_noche
        FROM vuelo
        INNER JOIN hotel ON vuelo.destino = hotel.ubicacion
        WHERE 1=1"; 

if (!empty($origen)) {
    $sql .= " AND vuelo.origen = '$origen'";
}
if (!empty($destino)) {
    $sql .= " AND vuelo.destino = '$destino'";
}

// Ejecutar la consulta
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Resultados de Búsqueda</title>
</head>
<body>
    <div class="container mt-5">
        <form action="terminar_reserva.php" method="post">
            <table class='table table-bordered'>
                <thead class='table-dark'>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Hotel</th>
                        <th>Fecha</th>
                        <th>Habitaciones Disponibles</th>
                        <th>Plazas Disponibles</th>
                        <th>Precio Vuelo</th>
                        <th>Tarifa por Noche</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="seleccion[]" value="<?php echo $row['id_vuelo'] . ',' . $row['id_hotel']; ?>"></td>
                            <td><?php echo $row['origen']; ?></td>
                            <td><?php echo $row['destino']; ?></td>
                            <td><?php echo $row['hotel_nombre']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                            <td><?php echo $row['habitaciones_disponibles']; ?></td>
                            <td><?php echo $row['plazas_disponibles']; ?></td>
                            <td>$<?php echo $row['vuelo_precio']; ?></td>
                            <td>$<?php echo $row['tarifa_noche']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
            </div>
            <button type="submit" class="btn btn-primary">Reservar en Agencia</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




