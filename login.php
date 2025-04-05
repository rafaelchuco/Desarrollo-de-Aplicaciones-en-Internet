<?php
require 'funciones.php';
$usser = "correo@correo.com";
$pass = "123456";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uss = $_POST['usuario']??'';
    $pswd = $_POST['password']??'';
    $ussValid = filter_var($uss, FILTER_VALIDATE_EMAIL);

    if (!$uss && !$pswd) {
        $errores[] = "Ingrese las credenciales";
    }
    else{
        if (!$uss) {
            $errores[] = "Ingrese usuario";
        }
        if (!$pswd) {
            $errores[] = "Ingrese password";
        }
        if (!$ussValid) {
            $errores[] = "Ingrese un correo válido";
        }
    }
    if (!$errores) {
        if ($uss === $usser) {
            if ($pswd === $pass) {
                session_start();
                $_SESSION['auth'] = true;
                header('Location: tareas.php');
            }else{
                $errores[]='Datos incorrectos';
            }
        }else{
            $errores[] = 'Datos incorrectos';
        }
    }

}

?>

<form method="post">
    <?php foreach ($errores as $error):
        echo $error;
    endforeach;?>

    <label for="">Usuario</label>
    <input name="usuario" type="text">
    <label for="">Password</label>
    <input name="password"  type="password">
    <input type="submit">
</form>
