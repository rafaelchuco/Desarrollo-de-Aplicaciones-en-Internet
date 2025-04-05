<?php
function debuguear($input){
    echo "<pre>";
    var_dump($input);
    echo "</pre>";
}
function islog() : bool{
    session_start();
    $auth = $_SESSION['auth'];
    if(!$auth){
        return false;
    }return true;
}
