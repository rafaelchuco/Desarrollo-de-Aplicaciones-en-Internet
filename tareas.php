<?php
require 'funciones.php';

$auth = islog();
if  (!$auth){
    header('Location: login.php');
}
$tareas = $_SESSION['tareas'] ?? false;
$val = $_GET['val'] ?? null;

?>
<?php
    if ($val == 1){
        echo 'TAREA AGREGADA';
    }
?>
<a href="cerrar.php">Cerrar Sesión</a>
<a href="crear.php">Crear Tarea</a>
<?php
if (!$tareas){

}
?>