// Función para abrir el modal
function abrirModal() {
    document.getElementById("modalNuevaCuenta").style.display = "flex";
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById("modalNuevaCuenta").style.display = "none";
}

// Cerrar el modal al hacer clic fuera del contenido
window.onclick = function(event) {
    const modal = document.getElementById("modalNuevaCuenta");
    if (event.target === modal) {
        cerrarModal();
    }
};




function openWhatsApp() {
    // Cambia la URL de WhatsApp a la página que quieras
    const url = 'https://wa.me/+573017478865'; // Reemplaza 1234567890 con el número de teléfono deseado
    window.open(url, '_blank');
}