<?php
require 'funciones.php';

$auth = islog();
if  (!$auth){
    header('Location: login.php');
}
$tareas = $_SESSION['tareas'] ?? false;
$val = $_GET['val'] ?? null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indice = filter_var($_POST['indice'],FILTER_SANITIZE_NUMBER_INT);
    unset($tareas[$indice]);
    $_SESSION['tareas'] = $tareas;

}
?>
<?php
    if ($val == 1):?>
        <h1>TAREA REGISTRADA</h1>
<?php endif; ?>
<a href="cerrar.php">Cerrar Sesión</a>
<a href="crear.php">Crear Tarea</a>

<h1>TAREAS</h1>
<table>
    <tr>
        <th>Tarea</th>
    </tr>
    <?php if ($tareas):
    foreach ($tareas as $i => $tarea): ?>
        <tr>
            <td>
                <?php echo $tarea; ?>
                <a href="actualizar.php?id=<?php echo $i ?>">Actualizar</a>
                <form method="post">
                    <input type="submit" value="Eliminar"/>
                    <input type="hidden" name="indice" value="<?php echo $i ?> >"/>
                </form>
            </td>

        </tr>
    <?php endforeach;
    endif ?>
</table>
