<?php
include 'funciones.php';
$auth = islog();
if (!$auth) {
    header('Location: login.php');
}
$id = $_GET['id'];
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
if ($id == '') {
    header('Location: tareas.php');
}
$tareas = $_SESSION['tareas'];

$comp = array_key_exists($id, $tareas);
if (!$comp) {
    header('Location: tareas.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tareas[$id] = $_POST['actualizado'];
    $_SESSION['tareas'] = $tareas;
    header('Location: tareas.php');
}
?>
<h1>ACTUALIZAR TAREA</h1>
<form method="post">
    <input type="text" placeholder="<?php echo $tareas[$id] ?>" name="actualizado">
    <input type="submit" value="Actualizar">
</form>


