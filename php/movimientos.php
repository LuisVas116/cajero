<?php
session_start();
include 'conexion_be.php';

$id_usuario = $_SESSION['usuario'];
$query1 = "SELECT a.c_transaccion AS codigo, a.c_cuenta_origen AS cuenta_origen, 
                  a.c_cuenta_destino AS cuenta_destino, b.nombre_completo AS nombres, 
                  a.valor AS valor, c.tipo_cuenta AS tipo_cuenta, a.tipo_transaccion AS tipo_transaccion 
           FROM transacciones a, usuarios b, m_cuentas c 
           WHERE a.c_cuenta_origen = c.c_cuenta AND b.id = c.id_usuario AND b.usuario = '$id_usuario'";
           
$query2 = "SELECT a.c_transaccion AS codigo, a.c_cuenta_origen AS cuenta_origen, 
                  a.c_cuenta_destino AS cuenta_destino, b.nombre_completo AS nombres, 
                  a.valor AS valor, c.tipo_cuenta AS tipo_cuenta, a.tipo_transaccion AS tipo_transaccion 
           FROM transacciones a, usuarios b, m_cuentas c 
           WHERE a.c_cuenta_destino = c.c_cuenta AND b.id = c.id_usuario AND b.usuario = '$id_usuario'";

// Ejecutar ambas consultas
$result1 = mysqli_query($conexion, $query1);
$result2 = mysqli_query($conexion, $query2);

if (!$result1 || !$result2) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultar Movimientos</title>
    <link rel="stylesheet" href="../assets/css/estilos5.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
    </header>
    <div class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Movimientos</h2>
            
            <?php
                // Verificar si hay resultados en alguna de las consultas
                if (mysqli_num_rows($result1) > 0 || mysqli_num_rows($result2) > 0) {
                    echo "<table class='movimientos-tabla'>";
                    echo "<tr>
                            <th>Transacción</th>
                            <th>Tipo Transacción</th>
                            <th>Nombres</th>
                            <th>Cuenta Origen</th>
                            <th>Cuenta Destino</th>
                            <th>Tipo Cuenta</th>
                            <th>Valor</th>
                          </tr>";
                    
                    // Mostrar resultados de la primera consulta
                    while ($row = mysqli_fetch_assoc($result1)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['codigo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_transaccion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombres']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['cuenta_origen']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['cuenta_destino']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_cuenta']) . "</td>";
                        echo "<td>$" . number_format($row['valor'], 0) . "</td>";
                        echo "</tr>";
                    }

                    // Mostrar resultados de la segunda consulta
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['codigo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_transaccion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombres']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['cuenta_origen']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['cuenta_destino']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_cuenta']) . "</td>";
                        echo "<td>$" . number_format($row['valor'], 0) . "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "<p>No se encontraron movimientos para esta cuenta.</p>";
                }

                mysqli_close($conexion);
            ?>
            
            <div class="transacciones">
                <button onclick="window.location.href='../bienvenido.php'">Atrás</button>
            </div>
        </div>
    </div>
</body>
</html>
