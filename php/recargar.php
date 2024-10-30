<?php
session_start();
include 'conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $monto = $_POST['monto'];
    $cuenta_destino = $_POST['cuenta_destino'];
    $tipo_cuenta_destino = $_POST['tipo_cuenta_destino']; 
    
    
    mysqli_begin_transaction($conexion);

    try {
        
        $query_destino = "SELECT saldo 
                          FROM m_cuentas 
                          WHERE c_cuenta = '$cuenta_destino' 
                          AND tipo_cuenta = '$tipo_cuenta_destino'";
                          
        $result_destino = mysqli_query($conexion, $query_destino);
        
        if (mysqli_num_rows($result_destino) == 0) {
            throw new Exception("La cuenta destino no existe o el tipo de cuenta es incorrecto.");
        }
        
        $row_destino = mysqli_fetch_assoc($result_destino);
        $saldo_destino = $row_destino['saldo'];

        
        $nuevo_saldo_destino = $saldo_destino + $monto;

        
        $update_destino = "UPDATE m_cuentas 
                           SET saldo = '$nuevo_saldo_destino' 
                           WHERE c_cuenta = '$cuenta_destino' 
                           AND tipo_cuenta = '$tipo_cuenta_destino'";

        
        $insert = "INSERT INTO transacciones (c_cuenta, c_cuenta_origen, c_cuenta_destino, valor, tipo_transaccion) 
                   VALUES ('$cuenta_destino', '', '$cuenta_destino', '$monto', 'RECARGA')";
        
       
        mysqli_query($conexion, $update_destino);
        mysqli_query($conexion, $insert);

        
        mysqli_commit($conexion);
        echo '
            <script>
                alert("Recarga exitosa");
                window.location ="../bienvenido.php";
            </script>
        ';
    } catch (Exception $e) {
        mysqli_rollback($conexion);
        echo "Error: " . $e->getMessage();
    } finally {
        mysqli_close($conexion);
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recarga</title>
    <link rel="stylesheet" href="../assets/css/estilos4.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
    </header>
    
    <div class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Realizar Recarga</h2>
        <div class="modal-content">
                    
        <form method="POST" action="recargar.php">
    <label for="monto">Monto:</label>
    <input type="number" name="monto" required>
    
    <label for="cuenta_destino">Cuenta Destino:</label>
    <input type="text" name="cuenta_destino" required>
    
    <label for="tipo_cuenta_destino">Tipo de Cuenta:</label>
    <select name="tipo_cuenta_destino" required>
        <option value="corriente">Corriente</option>
        <option value="ahorros">Ahorros</option>
    </select>
    
    <button type="submit">Recargar</button>


    <div class="transacciones">
        <button type="button" onclick="window.location.href='../bienvenido.php'">Atrás</button>
    </div>
</form>

        </div>
        </div>
    </div>
</body>
</html>
