<?php
require '../funciones.php';
$auth = islog();
if  (!$auth){
    header('Location: login.php');
}

$errores = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    debuguear($_SESSION);
    $tarea = $_POST["tarea"];
    if(!$tarea){
        $errores[] = "El nombre de la tarea es requerido";
    }
    if (!$errores) {
        $_SESSION['tareas'][] = $tarea;
        header('location: tareas.php?val=1');
    }
    }
?>

<?php foreach ($errores as $error):
    echo $error;
endforeach;
?>
<a href="cerrar.php">Cerrar Sesión</a>
<form method="post">
    <label>Tarea</label>
    <input name="tarea" type="text" placeholder="Ingrese su tarea">
    <input type="submit">
</form>