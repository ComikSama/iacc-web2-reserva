<?php
session_start();

// Mensaje de alerta
$mensaje = "¡Oferta especial! Descuento del 20% en paquetes turísticos a Madrid. ¡Reserva ahora y ahorra!";

// JavaScript para mostrar el mensaje de alerta
echo "<script type='text/javascript'>alert('$mensaje');</script>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Agencia de Viajes</title>
</head>
<body>
    <div class="container shadow mb-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Buscar Destinos</h5>
                        <div class="form-group">
                            <label for="select-destino">Destino</label>
                            <select class="form-select text-capitalize" id="select-destino" aria-label="Seleccionar destino">
                                <option value="">Seleccionar un destino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-precio">Precio</label>
                            <select class="form-select" id="select-precio" aria-label="Seleccionar precio">
                                <option value="">Seleccionar un rango de precio</option>
                                <option value="0-100000">$0 - $100.000</option>
                                <option value="100000-200000">$100.000 - $200.000</option>
                                <option value="200000-300000">$200.000 - $300.000</option>
                                <option value="300000-400000">$300.000 - $400.000</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-disponible">Disponibilidad</label>
                            <select class="form-select" id="select-disponible" aria-label="Seleccionar disponibilidad">
                                <option value="">Seleccionar disponibilidad</option>
                                <option value="true">Disponible</option>
                                <option value="false">No disponible</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-fecha">Fecha</label>
                            <input type="date" class="form-control" id="select-fecha" aria-label="Seleccionar fecha">
                        </div>
                        
                        <div class="row justify-content-center mt-3 pb-5">
                            <div class="col-md-5">
                                <a href="carrito.php" class="btn btn-primary">Carrito de Compras</a>
                            </div>
                            <div class="col-md-5">
                                <button id="search-button" class="btn btn-primary btn-block">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="cantidad_reservas.php" method="post">
                            <h5 class="card-title text-center">Número de Reservas de Hoteles</h5>
                            <div class="form-group">
                                <label for="num_reservas_min">Número de Reservas Mínimas</label>
                                <input type="number" class="form-control" id="num_reservas_min" name="num_reservas_min" placeholder="Ingrese el número de reservas mínimas">
                            </div>
                            <div class="form-group mt-3">
                                <label for="num_reservas_max">Número de Reservas Máximas</label>
                                <input type="number" class="form-control" id="num_reservas_max" name="num_reservas_max" placeholder="Ingrese el número de reservas máximas">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Consultar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-12">
                    <div class="card p-4">
                        <h2 class="text-center">Consultar de Reserva</h2>
                        <form action="consultar_reserva.php" method="post">
                            <div class="form-group">
                                <label for="nombre_usuario">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Consultar Reserva</button>
                        </form>
                    </div>    
                </div>
                <div class="card p-4">
                    <h2 class="text-center">Formulario de Reserva</h2>
                    <form action="procesar_reserva.php" method="post">
                        <div class="form-group">
                            <label for="origen">Origen</label>
                            <input type="text" class="form-control" id="origen" name="origen">
                        </div>
                        <div class="form-group">
                            <label for="destino">Destino</label>
                            <input type="text" class="form-control" id="destino" name="destino">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Buscar Disponibilidad</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Ofertas Disponibles</h5>
                            <div id="ofertas-container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3 pb-5">
            <div class="col-md-8">
                <div id="results-container" class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Resultados</h5>
                        <ul id="results-list" class="list-group">
                            <!-- RESULTADOS DE BUSQUEDA -->
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center mt-3 pb-5">
            <div class="col-md-6">
                <div class="container mt-5 card p-4 bg-dark-subtle">
                    <h2 class="text-center">Registro de Vuelos</h2>
                    <form action="procesar_vuelo.php" method="post" onsubmit="return validarVuelo()">
                        <input type="hidden" name="formulario" value="vuelo">
                        <div class="form-group">
                            <label for="origen">Origen</label>
                            <input type="text" class="form-control" id="origen" name="origen" required>
                        </div>
                        <div class="form-group">
                            <label for="destino">Destino</label>
                            <input type="text" class="form-control" id="destino" name="destino" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="plazas_disponibles">Plazas Disponibles</label>
                            <input type="number" class="form-control" id="plazas_disponibles" name="plazas_disponibles" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                    </form>
                </div>    
            </div>
            <div class="col-md-6">
                <div class="container mt-5 card p-4 bg-dark-subtle">
                    <h2 class="text-center">Registro de Hoteles</h2>
                    <form action="procesar_hotel.php" method="post" onsubmit="return validarHotel()">
                        <input type="hidden" name="formulario" value="hotel">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="form-group">
                            <label for="habitaciones_disponibles">Habitaciones Disponibles</label>
                            <input type="number" class="form-control" id="habitaciones_disponibles" name="habitaciones_disponibles" required>
                        </div>
                        <div class="form-group">
                            <label for="tarifa_noche">Tarifa por Noche</label>
                            <input type="number" class="form-control" id="tarifa_noche" name="tarifa_noche" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                    </form>
                </div>    
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/paquetes.js"></script>
    <script src="js/ofertas.js"></script>
    <script>
        function validarVuelo() {
            const origen = document.getElementById('origen').value;
            const destino = document.getElementById('destino').value;
            const fecha = document.getElementById('fecha').value;
            const plazas = document.getElementById('plazas_disponibles').value;
            const precio = document.getElementById('precio').value;

            if (!origen || !destino || !fecha || !plazas || !precio) {
                alert('Por favor, complete todos los campos.');
                return false;
            }

            return true;
        }

        function validarHotel() {
            const nombre = document.getElementById('nombre').value;
            const ubicacion = document.getElementById('ubicacion').value;
            const habitaciones = document.getElementById('habitaciones_disponibles').value;
            const tarifa = document.getElementById('tarifa_noche').value;

            if (!nombre || !ubicacion || !habitaciones || !tarifa) {
                alert('Por favor, complete todos los campos.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
