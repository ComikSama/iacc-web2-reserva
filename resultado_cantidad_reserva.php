<?php  
session_start();  

// Obtener los resultados de la sesión  
$resultados = isset($_SESSION['resultados']) ? $_SESSION['resultados'] : [];  

// Limpiar los resultados de la sesión  
unset($_SESSION['resultados']);  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <title>Resultados de Búsqueda</title>  
</head>  
<body>  
    <div class="container mt-5">  
        <h2 class="text-center mb-4">Resultados de Búsqueda</h2>  
        <?php if (count($resultados) > 0): ?>  
            <table class="table table-bordered">  
                <thead class="table-dark">  
                    <tr>  
                        <th>Hotel</th>  
                        <th>Total de Reservas</th>  
                    </tr>  
                </thead>  
                <tbody>  
                    <?php foreach ($resultados as $row): ?>  
                        <tr>  
                            <td><?php echo htmlspecialchars($row['hotel_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>  
                            <td><?php echo htmlspecialchars($row['total_reservas'], ENT_QUOTES, 'UTF-8'); ?></td>  
                        </tr>  
                    <?php endforeach; ?>  
                </tbody>  
            </table>  
        <?php else: ?>  
            <p class="text-center">No se encontraron hoteles con las reservas especificadas.</p>  
        <?php endif; ?>  
        
        <div class="text-center mt-3">  
            <a href="index.php" class="btn btn-primary">Volver</a>  
        </div>  
    </div>  

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
