<?php
require 'funciones.php';
session_start();
$_SESSION = [];
header('Location: login.php');

