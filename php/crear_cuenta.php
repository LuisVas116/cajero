<?php

    include 'conexion_be.php';

   




    
    $tipo_cuenta = $_POST['tipo_cuenta'];
    $monto_inicial = $_POST['monto_inicial'];
    $id_usuario = $_POST['id_usuario'];

   

    
    $query = "INSERT INTO m_cuentas (tipo_cuenta,id_usuario,saldo) 
                VALUES ('$tipo_cuenta','$id_usuario','$monto_inicial')";
    $verificar_id =mysqli_query($conexion,"SELECT * FROM m_cuentas where id_usuario='$id_usuario' AND tipo_cuenta='$tipo_cuenta' ");

    if(mysqli_num_rows($verificar_id) >0 ){

        echo '
            <script>
                alert("Este usuario ya tiene este tipo de cuenta");
                window.location ="../bienvenido.php";
            </script>';
        exit();
        mysqli_close($conexion);
    }

    $ejecutar =mysqli_query($conexion,$query);
    if($ejecutar){
        echo '
            <script>
                alert("Cuenta creada existosamente");
                window.location ="../bienvenido.php";
            </script>
        ';
    }else{
        echo '
        
         <script>
                alert("La cuenta no creada, intentalo nuevamente");
                window.location ="../bienvenido.php";
            </script>

        ';
    }

    mysqli_close($conexion);

?>



