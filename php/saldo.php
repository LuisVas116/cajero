<?php
session_start();
include 'conexion_be.php';


$id_usuario = $_SESSION['usuario'];
$query = "SELECT b.c_cuenta,b.tipo_cuenta,b.saldo FROM usuarios a,m_cuentas b 
            WHERE a.id=b.id_usuario AND a.usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultar Saldo</title>
    <link rel="stylesheet" href="../assets/css/estilos5.css">
</head>
<body>
    <header class="banner">
        <h1>BancoAmigo</h1>
    </header>
    <div class="contenedor__todo">
        <div class="caja__informacion">
            <h2>Saldo de tus cuentas</h2>
            
            <?php
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='movimientos-tabla'>";
                    echo "<tr>
                            <th>Número de Cuenta</th>
                            <th>Tipo de Cuenta</th>
                            <th>Saldo</th>
                          </tr>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['c_cuenta']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_cuenta']) . "</td>";
                        echo "<td>$" . number_format($row['saldo'], 0) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No se encontraron cuentas para este usuario.</p>";
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
