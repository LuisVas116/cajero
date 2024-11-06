

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar datos</title>
    <link rel="stylesheet" href="../assets/css/estilos4.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
    </header>
    
    <div class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Actualizar datos</h2>
            <div class="modal-content">
                <form method="POST" action="datos2.php">
                    <label for="nombre_completo">Nombres completos:</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                    
                    <button type="submit">Actualizar</button>
                </form>

                <div class="transacciones">
                    <button type="button" onclick="window.location.href='../bienvenido.php'">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
