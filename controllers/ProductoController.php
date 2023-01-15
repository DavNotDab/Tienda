<?php
namespace Controllers;

use Models\Producto;
use Models\Categoria;
use Lib\Pages;
use Utils\Utils;
use Lib\BaseDatos;
use PDOException;

class ProductoController {

    private Pages $pages;
    private BaseDatos $bd;

    public function __construct() {
        $this->pages = new Pages();
        $this->bd = new BaseDatos();
    }

    public function index(): void {
        Utils::isAdmin();
        $producto = new Producto();
        $productos = $producto->getAll();

        $this->pages->render("producto/index", ["productos" => $productos]);
    }

    public function crear(): void {
        Utils::isAdmin();
        $this->pages->render("producto/crear", ["categorias" => Categoria::obtenerCategorias()]);
    }

    public function save(): void {
        Utils::isAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["data"])) {
                $_POST["data"]["fecha"] = date("Y-d-m");
                $valido = Producto::validarSave($_POST["data"], $_FILES["imagen"]);
                if ($valido === true) {
                    Utils::guardarImagen($_FILES["imagen"]);
                    $producto = new Producto();

                    $guardado = $producto->save($_POST["data"], $_FILES["imagen"]);

                    if ($guardado === true) {
                        header("Location: ".base_url."producto/index");
                    } else {
                        $error = "Error, no se pudo guardar el producto";
                    }
                }
                else {
                    $error = $valido;
                }
            }
        }
        $this->pages->render("producto/crear", ["categorias" => Categoria::obtenerCategorias(), "error" => $error ?? ""]);
    }

}