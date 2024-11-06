<?php
session_start();
include 'conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_usuario = $_SESSION['usuario'];
    $monto = $_POST['monto'];
    $tipo_cuenta_origen = $_POST['tipo_cuenta']; 
    
    
    mysqli_begin_transaction($conexion);

    try {
       
        $query_origen = "SELECT b.c_cuenta AS c_cuenta, b.saldo AS saldo
                         FROM usuarios a, m_cuentas b 
                         WHERE a.id = b.id_usuario 
                         AND a.usuario = '$id_usuario' 
                         AND b.tipo_cuenta = '$tipo_cuenta_origen'";
                         
        $result_origen = mysqli_query($conexion, $query_origen);
        $row_origen = mysqli_fetch_assoc($result_origen);
        
        if (!$row_origen) {
            throw new Exception("Cuenta de origen no encontrada.");
        }
        
        $saldo_origen = $row_origen['saldo'];
        $cuenta_origen = $row_origen['c_cuenta'];

        
        if ($saldo_origen< $monto && trim($tipo_cuenta_origen) === 'ahorros') {
            echo '
            <script>
            alert("Saldo insuficiente");
            window.location ="./retirar.php";
            </script>
            ';
            throw new Exception("Saldo insuficiente.");
        }

       
        $nuevo_saldo_origen = $saldo_origen - $monto;

        
        $update_origen = "UPDATE m_cuentas 
                          SET saldo = '$nuevo_saldo_origen' 
                          WHERE c_cuenta = '$cuenta_origen' 
                          AND tipo_cuenta = '$tipo_cuenta_origen'";

        
        $insert = "INSERT INTO transacciones (c_cuenta, c_cuenta_origen, c_cuenta_destino, valor, tipo_transaccion) 
                   VALUES ('$cuenta_origen', '$cuenta_origen', '', '-$monto', 'RETIRO')";
        
       
        mysqli_query($conexion, $update_origen);
        mysqli_query($conexion, $insert);

        
        mysqli_commit($conexion);
        echo '
            <script>
                alert("Retiro exitoso");
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
    <title>Retiro</title>
    <link rel="stylesheet" href="../assets/css/estilos4.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
    </header>
    
    <div class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Realizar Retiro</h2>
        <div class="modal-content">
                    
        <form method="POST" action="retirar.php">
    <label for="monto">Monto a Retirar:</label>
    <input type="number" name="monto" required>
    
    <label for="tipo_cuenta">Tipo de Cuenta:</label>
    <select name="tipo_cuenta" required>
        <option value="corriente">Corriente</option>
        <option value="ahorros">Ahorros</option>
    </select>
    
    <button type="submit">Retirar</button>
</form>



    <div class="transacciones">
        <button type="button" onclick="window.location.href='../bienvenido.php'">Atrás</button>
    </div>
</form>

        </div>
        </div>
    </div>
</body>
</html>
