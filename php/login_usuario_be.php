<?php
    session_start();
    include 'conexion_be.php';

    $usuario =$_POST['usuario'];
    $contrasena =$_POST['contrasena'];

   $validar_login = mysqli_query($conexion,"SELECT * FROM usuarios 
   WHERE usuario='$usuario' AND contrasena='$contrasena' AND usuario<>'' ");

   if(mysqli_num_rows($validar_login) >0 ){

        $_SESSION['usuario']=$usuario;

        header("location: ../bienvenido.php");

   }else{
        echo '
        <script>
            alert("Usuario no existe y/o contraseña incorrecta");
            window.location ="../index.php";
        </script>
        ';
        exit();
    mysqli_close($conexion);
    };
    



?>