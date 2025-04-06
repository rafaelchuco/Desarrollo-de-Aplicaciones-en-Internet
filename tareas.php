<?php
require 'funciones.php';

$auth = islog();
if (!$auth) {
    header('Location: index.php');
    exit;
}

session_start();
$tareas = $_SESSION['tareas'] ?? [];
$val = $_GET['val'] ?? null;
$errores = [];
$tareaEditar = null;
$editId = $_GET['edit'] ?? null;

// Crear tarea
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["accion"] === "crear") {
    $tarea = trim($_POST["tarea"] ?? '');
    if (!$tarea) {
        $errores[] = "El nombre de la tarea es requerido";
    } else {
        $_SESSION['tareas'][] = $tarea;
        header('Location: tareas.php?val=1');
        exit;
    }
}

// Editar tarea
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["accion"] === "editar") {
    $editId = $_POST["edit_id"] ?? null;
    $nuevoNombre = trim($_POST["tarea_editada"] ?? '');

    if ($editId !== null && isset($_SESSION['tareas'][$editId]) && $nuevoNombre !== '') {
        $_SESSION['tareas'][$editId] = $nuevoNombre;
        header("Location: tareas.php?val=2");
        exit;
    }
}

// Eliminar tarea
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    if (isset($_SESSION["tareas"][$id])) {
        unset($_SESSION["tareas"][$id]);
        $_SESSION["tareas"] = array_values($_SESSION["tareas"]);
        header("Location: tareas.php?val=3");
        exit;
    }
}

// Obtener tarea para editar
if ($editId !== null && isset($_SESSION['tareas'][$editId])) {
    $tareaEditar = $_SESSION['tareas'][$editId];
}

require 'head.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Panel de Administrador</h2>
            <p class="text-muted mb-0">Gestión de tareas</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearTareaModal">+ Crear Tarea</button>
            <a href="cerrar.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>
    </div>

    <?php if ($val == 1): ?>
        <div class="alert alert-success alert-dismissible fade show">¡Tarea creada!</div>
    <?php elseif ($val == 2): ?>
        <div class="alert alert-warning alert-dismissible fade show">¡Tarea actualizada!</div>
    <?php elseif ($val == 3): ?>
        <div class="alert alert-danger alert-dismissible fade show">¡Tarea eliminada!</div>
    <?php endif; ?>

    <div class="row">
        <?php if ($tareas): ?>
            <?php foreach ($tareas as $index => $tarea): ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($tarea); ?></h5>
                            <div class="d-flex justify-content-between">
                                <a href="?edit=<?php echo $index; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="?delete=<?php echo $index; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar esta tarea?')">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No hay tareas disponibles.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade <?php echo (!empty($errores) && $_POST["accion"] === "crear") ? 'show d-block' : ''; ?>" id="crearTareaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" class="modal-content shadow">
            <input type="hidden" name="accion" value="crear">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Crear nueva tarea</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Nombre de la Tarea</label>
                    <input name="tarea" type="text" class="form-control" placeholder="Escribe una tarea">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<?php if ($tareaEditar !== null): ?>
<div class="modal fade show d-block" id="editarTareaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" class="modal-content shadow">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="edit_id" value="<?php echo $editId; ?>">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Editar tarea</h5>
                <a href="tareas.php" class="btn-close" aria-label="Cerrar"></a>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nuevo nombre de la tarea</label>
                    <input name="tarea_editada" type="text" class="form-control" value="<?php echo htmlspecialchars($tareaEditar); ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Actualizar</button>
                <a href="tareas.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($errores) && $_POST["accion"] === "crear"): ?>
<script>
    const modal = new bootstrap.Modal(document.getElementById('crearTareaModal'));
    modal.show();
</script>
<?php endif; ?>
