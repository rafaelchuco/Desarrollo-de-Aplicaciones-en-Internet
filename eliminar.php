<?php
require 'funciones.php';
session_start();
$auth = islog();
if (!$auth) {
    header('Location: login.php');
}

$id = $_GET['id'] ?? null;
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

if (isset($_SESSION['tareas'][$id])) {
    unset($_SESSION['tareas'][$id]);
    $_SESSION['tareas'] = array_values($_SESSION['tareas']);
}

header("Location: tareas.php?val=3");
