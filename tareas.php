<?php
require 'funciones.php';

$auth = islog();
if (!$auth) {
    header('Location: login.php');
    exit;
}

$tareas = $_SESSION['tareas'] ?? [];
$val = $_GET['val'] ?? null;

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tarea = $_POST["tarea"] ?? '';

    if (!$tarea) {
        $errores[] = "El nombre de la tarea es requerido";
    }

    if (!$errores) {
        $_SESSION['tareas'][] = $tarea;
        header('Location: tareas.php?val=1');
        exit;
    }
}

require 'head.php'; // Asegúrate que incluye Bootstrap y abre el <body>
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Panel de Administrador</h2>
            <p class="text-muted mb-0">Bienvenido a la gestión de tareas</p>
        </div>
        <a href="cerrar.php" class="btn btn-outline-danger">Cerrar sesión</a>
    </div>

    <?php if ($val == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ¡Tarea agregada exitosamente!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <div class="mb-4 text-end">
        <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#crearTareaModal">
            + Crear Tarea
        </button>
    </div>

    <div class="row">
        <?php if ($tareas): ?>
            <?php foreach ($tareas as $tarea): ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($tarea); ?></h5>
                            <p class="card-text text-muted">Tarea registrada</p>
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

<!-- Modal -->
<div class="modal fade <?php if (!empty($errores)) echo 'show d-block'; ?>" id="crearTareaModal" tabindex="-1" aria-labelledby="crearTareaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="post" class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="crearTareaModalLabel">Crear nueva tarea</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mostrar el modal automáticamente si hay errores -->
<?php if (!empty($errores)): ?>
<script>
    const modal = new bootstrap.Modal(document.getElementById('crearTareaModal'));
    modal.show();
</script>
<?php endif; ?>

</body>
</html>
