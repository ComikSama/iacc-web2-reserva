<?php
session_start();
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    array_splice($_SESSION['carrito'], $removeIndex, 1);
}

$carrito = $_SESSION['carrito'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Carrito de Compras</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Carrito de Compras</h2>
        <div class="row">
            <?php if (count($carrito) > 0): ?>
                <?php foreach ($carrito as $index => $paquete): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($paquete['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($paquete['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($paquete['nombre']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($paquete['precio']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($paquete['destino']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($paquete['fecha']); ?></p>
                                <a href="?remove=<?php echo $index; ?>" class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No hay paquetes en el carrito.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Volver a la Página Principal</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
