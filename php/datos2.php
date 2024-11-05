<?php
session_start();
include 'conexion_be.php';

$id_usuario = $_SESSION['usuario'];

$nombres = mysqli_real_escape_string($conexion, $_POST['nombre_completo']);
$email = mysqli_real_escape_string($conexion, $_POST['email']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

// Actualizar los datos del usuario
$query = "UPDATE usuarios SET email='$email', nombre_completo='$nombres', contrasena='$contrasena' WHERE usuario='$id_usuario'";

$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    echo '
        <script>
            alert("Datos actualizados exitosamente");
            window.location ="../bienvenido.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Los datos no se actualizaron, inténtalo nuevamente");
            window.location ="../bienvenido.php";
        </script>
    ';
}

mysqli_close($conexion);
?>