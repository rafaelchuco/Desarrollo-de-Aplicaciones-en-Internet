<?php
require 'funciones.php';
$usser = "correo@correo.com";
$pass = "123456";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uss = $_POST['usuario'] ?? '';
    $pswd = $_POST['password'] ?? '';
    $ussValid = filter_var($uss, FILTER_VALIDATE_EMAIL);

    if (!$uss && !$pswd) {
        $errores[] = "Ingrese las credenciales";
    } else {
        if (!$uss) {
            $errores[] = "Ingrese usuario";
        }
        if (!$pswd) {
            $errores[] = "Ingrese password";
        }
        if ($uss && !$ussValid) {
            $errores[] = "Ingrese un correo válido";
        }
    }

    if (!$errores) {
        if ($uss === $usser) {
            if ($pswd === $pass) {
                session_start();
                $_SESSION['auth'] = true;
                header('Location: tareas.php');
                exit;
            } else {
                $errores[] = 'Datos incorrectos';
            }
        } else {
            $errores[] = 'Datos incorrectos';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 400px;">
        
        <form method="post" action="login.php" class="border p-4 rounded shadow">

            <h2 class="mb-4 text-center">Iniciar sesión</h2>    

            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input name="usuario" type="text" class="form-control" placeholder="Ingrese su correo">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Password">
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-primary w-100" value="Ingresar">
            </div>
        </form>
    </div>
</div>

<!-- ALERTA FLOTANTE -->
<?php if (!empty($errores)): ?>
    <div id="alertaError" class="alert alert-danger position-fixed top-0 end-0 m-4 fade show" role="alert" style="z-index: 1050;">
        <button type="button" class="btn-close float-end" aria-label="Cerrar" onclick="document.getElementById('alertaError').remove();"></button>
        <ul class="mb-0">
            <?php foreach ($errores as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- Script para cerrar automáticamente el alert -->
<script>
    setTimeout(function() {
        const alerta = document.getElementById('alertaError');
        if (alerta) {
            alerta.classList.remove('show');
            alerta.classList.add('fade');
            setTimeout(() => alerta.remove(), 400); // lo elimina del DOM
        }
    }, 4000); // 4 segundos
</script>

</body>
</html>
