
<?php
session_start();
include 'conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuenta_destino = $_POST['cuenta_destino'];
    $monto = $_POST['monto'];
    $id_usuario = $_SESSION['usuario'];
    $tipo_cuenta = $_POST['tipo_cuenta'];

    
    mysqli_begin_transaction($conexion);

    try {
        
        $query_origen = "SELECT b.saldo, b.c_cuenta FROM usuarios a, m_cuentas b 
            WHERE a.id = b.id_usuario AND a.usuario = '$id_usuario' AND b.tipo_cuenta = '$tipo_cuenta'";
        $result_origen = mysqli_query($conexion, $query_origen);
        $row_origen = mysqli_fetch_assoc($result_origen);
        
        if (!$row_origen) {
            throw new Exception("Cuenta de origen no encontrada.");
        }
        
        $saldo_origen = $row_origen['saldo'];
        $cuenta_origen = $row_origen['c_cuenta']; 

       
        if ($saldo_origen < $monto) {
            throw new Exception("Saldo insuficiente.");
        }

       
        $query_destino = "SELECT saldo FROM m_cuentas WHERE c_cuenta = '$cuenta_destino'";
        $result_destino = mysqli_query($conexion, $query_destino);
        
        if (mysqli_num_rows($result_destino) == 0) {
            throw new Exception("La cuenta destino no existe.");
        }
        
        $row_destino = mysqli_fetch_assoc($result_destino);
        $saldo_destino = $row_destino['saldo'];

        
        $nuevo_saldo_origen = $saldo_origen - $monto;
        $nuevo_saldo_destino = $saldo_destino + $monto;

        $update_origen = "UPDATE m_cuentas b, usuarios a SET b.saldo = '$nuevo_saldo_origen'
            WHERE a.id = b.id_usuario AND a.usuario = '$id_usuario' AND b.tipo_cuenta = '$tipo_cuenta'";
        $update_destino = "UPDATE m_cuentas SET saldo = '$nuevo_saldo_destino' WHERE c_cuenta = '$cuenta_destino'";

        
        $insert = "INSERT INTO transacciones (c_cuenta,c_cuenta_origen, c_cuenta_destino, valor,tipo_transaccion) 
        VALUES ('$cuenta_origen','$cuenta_origen', '$cuenta_destino', '$monto','TRANSFERENCIA')";
        
        
        mysqli_query($conexion, $update_origen);
        mysqli_query($conexion, $update_destino);
        mysqli_query($conexion, $insert);

        
        mysqli_commit($conexion);
        echo '
            <script>
                alert("Transferencia existosa");
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
    <title>Transferencia</title>
    <link rel="stylesheet" href="../assets/css/estilos4.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
    </header>
    
    <div class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Realizar Transferencia</h2>
        <div class="modal-content">
                    
        <form action="transferencia.php" method="POST">
    <div class="form-group">
        <label for="tipo_cuenta">Tipo de Cuenta:</label>
        <select name="tipo_cuenta" id="tipo_cuenta" required>
            <option value="" disabled selected>Selecciona el tipo de cuenta</option>
            <option value="ahorros">Cuenta de Ahorros</option>
            <option value="corriente">Cuenta Corriente</option>
        </select>
    </div>

    <div class="form-group">
        <label for="cuenta_destino">Cuenta Destino:</label>
        <input type="text" id="cuenta_destino" name="cuenta_destino" required>
    </div>

    <div class="form-group">
        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required>
    </div>

    <div class="transacciones">
        <button type="submit">Transferir</button>
    </div>
    <div class="transacciones">
        <button type="button" onclick="window.location.href='../bienvenido.php'">Atrás</button>
    </div>
</form>

        </div>
        </div>
    </div>
</body>
</html>
