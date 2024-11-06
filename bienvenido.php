<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/estilos2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
        </header>
        

    <main class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Tu cuenta</h2>
            <p>Elige la operación que deseas realizar:</p>
            
            <button class="nueva-cuenta" onclick="abrirModal()">Nueva cuenta</button>

            
            <div id="modalNuevaCuenta" class="modal">
                <div class="modal-content">
                <span class="close" onclick="cerrarModal()">&times;</span>
                <h3>Crear Nueva Cuenta</h3>
                <form action="php/crear_cuenta.php" method="POST">
                <input type="text" name="id_usuario" placeholder="Documento" required>
                <select name="tipo_cuenta" required>
                <option value="" disabled selected>Selecciona el tipo de cuenta</option>
                <option value="ahorros">Cuenta de Ahorros</option>
                <option value="corriente">Cuenta Corriente</option>
            </select>
            <input type="number" name="monto_inicial" placeholder="Monto inicial" required>
            <button type="submit">Crear cuenta</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="transacciones">
            <button onclick="window.location.href='php/datos.php'">Actualizar Datos</button>
            <button onclick="window.location.href='php/transferencia.php'">Transferir</button>
            <button onclick="window.location.href='php/recargar.php'">Recargar</button>
            <button onclick="window.location.href='php/retirar.php'">Retirar</button>
            <button onclick="window.location.href='php/movimientos.php'">Consultar Movimientos</button>
            <button onclick="window.location.href='php/saldo.php'">Consultar Saldo</button>
            <button onclick="window.location.href='php/cerrar_sesion.php'">Salir</button>
        </div>

        

    </main>
    <button class="whatsapp-button" onclick="openWhatsApp()">
        <i class="fab fa-whatsapp whatsapp-icon"></i> Contáctanos
    </button>
    <script src="./assets/js/scripts2.js"></script>
</body>
</html>
