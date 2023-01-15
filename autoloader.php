<?php
spl_autoload_register(function ($clase) {
    $directorio_clase = str_replace("\\", "/", $clase) . ".php";
    if (file_exists($directorio_clase)) {
        require_once $directorio_clase;
    }
});