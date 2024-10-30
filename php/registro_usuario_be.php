<?php

    include 'conexion_be.php';

    $documento =$_POST['documento'];
    $nombre_completo =$_POST['nombre_completo'];
    $email =$_POST['email'];
    $usuario =$_POST['usuario'];
    $contrasena =$_POST['contrasena'];

    $query ="INSERT INTO  usuarios(id,nombre_completo,email,usuario,contrasena)
             VALUES('$documento','$nombre_completo','$email','$usuario','$contrasena')";


    $verificar_id =mysqli_query($conexion,"SELECT * FROM usuarios where id='$documento' ");

    if(mysqli_num_rows($verificar_id) >0 ){

        echo '
            <script>
                alert("Usuario ya existe");
                window.location ="../index.php";
            </script>';
        exit();
        mysqli_close($conexion);
    }

    $verificar_usuario =mysqli_query($conexion,"SELECT * FROM usuarios where usuario='$usuario' ");

    if(mysqli_num_rows($verificar_usuario) >0 ){

        echo '
            <script>
                alert("Este usuario ya esta en uso");
                window.location ="../index.php";
            </script>';
        exit();
        mysqli_close($conexion);
    }

    $verificar_email =mysqli_query($conexion,"SELECT * FROM usuarios where email='$email' ");

    if(mysqli_num_rows($verificar_email) >0 ){

        echo '
            <script>
                alert("Email ya esta en uso");
                window.location ="../index.php";
            </script>';
        exit();
        mysqli_close($conexion);
    }
    

    $ejecutar =mysqli_query($conexion,$query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario registrado existosamente");
                window.location ="../index.php";
            </script>
        ';
    }else{
        echo '
        
         <script>
                alert("Usuario no registrado intentalo nuevamente");
                window.location ="../index.php";
            </script>

        ';
    }

    mysqli_close($conexion);


?>