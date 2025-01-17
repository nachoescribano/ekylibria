document.addEventListener('DOMContentLoaded', function() {
    // Obtener el parámetro 'categoria-de-producto' de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoriaProducto = urlParams.get('categoria-de-producto');
    
    // Obtener todas las imágenes de las categorías
    const categoryImages = document.querySelectorAll('.category-image');

    // Recorrer todas las imágenes y añadir la clase 'active' a la que coincide con la categoría de la URL
    categoryImages.forEach(image => {
        // Comparar el valor de 'data-category' con el parámetro de la URL
        if (image.getAttribute('data-category') === categoriaProducto) {
            image.classList.add('active');
        } else {
            image.classList.remove('active');
        }
    });
});