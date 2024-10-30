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

/*
function abrirModalSaldo() {
    document.getElementById("modalConsultarSaldo").style.display = "flex";
}

function cerrarModalSaldo() {
    document.getElementById("modalConsultarSaldo").style.display = "none";
}*/