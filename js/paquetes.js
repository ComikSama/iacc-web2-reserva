document.addEventListener("DOMContentLoaded", function () {
    class PaqueteTuristico {
        constructor(nombre, precio, disponible, destino, fecha, imagen) {
            this.nombre = nombre;
            this.precio = precio;
            this.disponible = disponible;
            this.destino = destino;
            this.fecha = fecha;
            this.imagen = imagen;
        }

        cumpleFiltros(destinoSeleccionado, precioSeleccionado, disponibleSeleccionado, fechaSeleccionada) {
            const destinoLower = destinoSeleccionado.toLowerCase();
            const destinoPaqueteLower = this.destino.toLowerCase();

            const cumpleDestino = destinoLower === "" || destinoPaqueteLower === destinoLower;

            const precioNumerico = parseInt(this.precio.replace(/\D/g, ""));
            let cumplePrecio = true;
            if (precioSeleccionado) {
                const [minPrecio, maxPrecio] = precioSeleccionado.split("-").map(Number);
                cumplePrecio = precioNumerico >= minPrecio && precioNumerico <= maxPrecio;
            }

            const cumpleDisponibilidad = disponibleSeleccionado === "" || String(this.disponible) === disponibleSeleccionado;

            const cumpleFecha = fechaSeleccionada === "" || this.fecha === fechaSeleccionada;

            return cumpleDestino && cumplePrecio && cumpleDisponibilidad && cumpleFecha;
        }
    }

    async function cargarPaquetesDesdeJSON() {
        try {
            const response = await fetch('paquetes.json');
            const paquetesJSON = await response.json();
            console.log('Datos cargados desde JSON:', paquetesJSON);

            const paquetesTuristicos = paquetesJSON.map(item => {
                return new PaqueteTuristico(
                    item.nombre,
                    item.precio,
                    item.disponible,
                    item.destino.toLowerCase(),
                    item.fecha,
                    item.imagen
                );
            });

            window.paquetesTuristicos = paquetesTuristicos;
            return paquetesTuristicos;
        } catch (error) {
            console.error('Error al cargar los paquetes turísticos desde el JSON:', error);
            return [];
        }
    }

    async function cargarOpciones() {
        const selectDestino = document.getElementById('select-destino');

        const paquetesTuristicos = await cargarPaquetesDesdeJSON();

        const destinosUnicos = [...new Set(paquetesTuristicos.map(paquete => paquete.destino))];

        destinosUnicos.forEach(destino => {
            const option = document.createElement('option');
            option.value = destino.toLowerCase();
            option.textContent = destino;
            selectDestino.appendChild(option);
        });
    }

    function mostrarPaquetes(destinoSeleccionado, precioSeleccionado, disponibleSeleccionado, fechaSeleccionada) {
        console.log('Filtros seleccionados:', {
            destino: destinoSeleccionado,
            precio: precioSeleccionado,
            disponible: disponibleSeleccionado,
            fecha: fechaSeleccionada
        });

        const resultsList = document.getElementById('results-list');
        const resultsContainer = document.getElementById('results-container');

        resultsList.innerHTML = '';

        const paquetesTuristicos = window.paquetesTuristicos || [];

        const filteredResults = paquetesTuristicos.filter(paquete => {
            return paquete.cumpleFiltros(destinoSeleccionado, precioSeleccionado, disponibleSeleccionado, fechaSeleccionada);
        });

        console.log('Resultados filtrados:', filteredResults);

        const rowContainer = document.createElement('div');
        rowContainer.className = 'row';

        if (filteredResults.length > 0) {
            filteredResults.forEach((paquete, index) => {
                const card = document.createElement('div');
                card.className = 'col-md-4 mb-4';
                card.innerHTML = `
                    <div class="card">
                        <img src="${paquete.imagen}" class="card-img-top" alt="${paquete.nombre}">
                        <div class="card-body text-center">
                            <h5 class="card-title">${paquete.nombre}</h5>
                            <p class="card-text fw-bold">${paquete.precio}</p>
                            <p class="card-text"><span class="fw-bold ${paquete.disponible ? 'text-success' : 'text-danger'}">${paquete.disponible ? 'Disponible' : 'No disponible'}</span></p>
                            <p class="card-text text-capitalize">${paquete.destino}</p>
                            <p class="card-text">${paquete.fecha}</p>
                            <button class="btn btn-primary agregar-carrito" data-index="${index}">Agregar al Carrito</button>
                        </div>
                    </div>
                `;
                rowContainer.appendChild(card);
            });
        } else {
            const noResults = document.createElement('div');
            noResults.className = 'col-12';
            noResults.innerHTML = '<p class="text-center">No se encontraron paquetes turísticos que coincidan con los criterios de búsqueda.</p>';
            rowContainer.appendChild(noResults);
        }

        resultsList.appendChild(rowContainer);

        resultsContainer.style.display = 'block';
    }

    cargarOpciones();

    const searchButton = document.getElementById('search-button');
    if (searchButton) {
        searchButton.addEventListener('click', function () {
            const destinoSeleccionado = document.getElementById('select-destino').value.toLowerCase();
            const precioSeleccionado = document.getElementById('select-precio').value;
            const disponibleSeleccionado = document.getElementById('select-disponible').value;
            const fechaSeleccionada = document.getElementById('select-fecha').value;
            mostrarPaquetes(destinoSeleccionado, precioSeleccionado, disponibleSeleccionado, fechaSeleccionada);
        });
    }

    // Manejar el evento de clic en el botón Agregar al Carrito
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('agregar-carrito')) {
            const index = event.target.dataset.index;
            agregarAlCarrito(index);
        }
    });

    function agregarAlCarrito(index) {
        const paquetesTuristicos = window.paquetesTuristicos || [];
        const paquete = paquetesTuristicos[index];

        if (!paquete) {
            console.error('Paquete no encontrado en el índice:', index); //Verificar estado de los Paquetes
            return;
        }

        agregarAlCarritoServidor(paquete);
    }

    function agregarAlCarritoServidor(paquete) {
        const formData = new FormData();
        formData.append('paquete', JSON.stringify(paquete));

        fetch('agregar_carrito.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al agregar al carrito');
            }
            console.log('Paquete agregado al carrito'); // Verificar que fue agregado al carrito
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
