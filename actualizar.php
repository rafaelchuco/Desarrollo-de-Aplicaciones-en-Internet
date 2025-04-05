<?php
include 'funciones.php';
$auth = islog();
if (!$auth) {
    header('Location: login.php');
}



