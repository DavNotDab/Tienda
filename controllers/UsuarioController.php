<?php
namespace Controllers;
use Models\Usuario;
use Lib\Pages;


class UsuarioController {
    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function index(): void {

    }

    public function registro(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST["data"]) {
                $registrado = $_POST["data"];
                $registrado["password"] = password_hash($registrado["password"], PASSWORD_BCRYPT, ["cost" => 4]);

                $usuario = Usuario::fromArray($registrado);

                // TODO validar usuario con sus metodos

                $save = $usuario->save();
                if ($save) {
                    $_SESSION["register"] = "complete";
                } else {
                    $_SESSION["register"] = "failed";
                }
            } else {
                $_SESSION["register"] = "failed";
            }
        }
        $this->pages->render("usuario/registro");
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST["data"]) {
                $usuario = Usuario::fromArray($_POST["data"]);
                // TODO validar usuario con sus metodos
                $identity = $usuario->login();

                if ($identity && is_object($identity)) {
                    if (isset($_SESSION["errorIdentity"])) {
                        unset($_SESSION["errorIdentity"]);
                    }
                    $_SESSION["identity"] = $identity;

                    if ($identity->rol == "admin") {
                        $_SESSION["admin"] = true;
                    }
                    header("Location:" . base_url);

                } else {
                    $this->pages->render("usuario/login", ["error" => $identity]);
                }
            }
        }
        $this->pages->render("usuario/login");
    }

    public function logout(): void {
        if (isset($_SESSION["identity"])) {
            unset($_SESSION["identity"]);
        }
        if (isset($_SESSION["admin"])) {
            unset($_SESSION["admin"]);
        }
        if (isset($_SESSION["carrito"])) {
            unset($_SESSION["carrito"]);
        }
        header("Location: ".base_url);
    }
}