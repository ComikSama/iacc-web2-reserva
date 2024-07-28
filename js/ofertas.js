document.addEventListener("DOMContentLoaded", function () {
    const ofertasEspeciales = [
        { texto: '¡Oferta especial! Descuento del 20% en paquete a Madrid.', imagen: 'img/madrid.jpg' },
        { texto: '¡Aprovecha nuestro paquete a las Maldivas con todo incluido!', imagen: 'img/maldivas.jpg' },
        { texto: 'Descuento del 30% en estadía en Barcelona este verano.', imagen: 'img/barcelona.jpg' }
    ];

    let currentOfertaIndex = 0;

    function mostrarOfertaEspecial() {
        const ofertasContainer = document.getElementById('ofertas-container');
        const ofertaElement = document.createElement('div');
        ofertaElement.className = 'oferta-especial row align-items-center';
        
        // Imagen
        const imagenColumn = document.createElement('div');
        imagenColumn.className = 'col-5 text-center';
        const imagenElement = document.createElement('img');
        imagenElement.src = ofertasEspeciales[currentOfertaIndex].imagen;
        imagenElement.className = 'img-fluid rounded';
        imagenColumn.appendChild(imagenElement);
        ofertaElement.appendChild(imagenColumn);

        // Texto
        const textoColumn = document.createElement('div');
        textoColumn.className = 'col-7';
        const textoElement = document.createElement('p');
        textoElement.textContent = ofertasEspeciales[currentOfertaIndex].texto;
        textoColumn.appendChild(textoElement);
        ofertaElement.appendChild(textoColumn);

        currentOfertaIndex = (currentOfertaIndex + 1) % ofertasEspeciales.length;

        ofertasContainer.innerHTML = '';
        ofertasContainer.appendChild(ofertaElement);

        // Próxima Oferta en 5 segundos
        setTimeout(mostrarOfertaEspecial, 5000);
    }

    mostrarOfertaEspecial();
});
