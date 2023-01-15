<?php
namespace Controllers;

class FrontController {

    public static function main() : void {
        function show_error() : void {
            $error = new ErrorController();
            $error->index();
        }
        if (isset($_GET['controller'])) {
            $nombre_controlador = "Controllers\\" . $_GET['controller'] . "Controller";

        } else if (!isset($_GET['action'])) {
            $nombre_controlador = controller_default;
        } else {
            show_error();
            exit();
        }

        if (class_exists($nombre_controlador)) {
            $controlador = new $nombre_controlador();

            if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
                $action = $_GET['action'];
                $controlador->$action();
            } else if (!isset($_GET['action']) && !isset($_GET['controller'])) {
                $action_default = action_default;
                $controlador->$action_default();
            } else {
                show_error();
            }
        } else {
            show_error();
        }
    }
}