<?php
namespace Controllers;

use Models\Categoria;
use Models\Producto;
use Lib\Pages;
use Utils\Utils;
use Lib\BaseDatos;
use PDOException;

class CategoriaController {

    private Pages $pages;
    private BaseDatos $bd;

    public function __construct() {
        $this->pages = new Pages();
        $this->bd = new BaseDatos();
    }

    public function index(): void {
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();

        $this->pages->render("categoria/index", ["categorias" => $categorias]);
    }

    public function crear(): void {
        Utils::isAdmin();
        $this->pages->render("categoria/crear");
    }

    public function save(): bool|null {
        Utils::isAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["nombre"])) {
                $nombre = $_POST["nombre"];
                $sql = $this->bd->prepare("INSERT INTO categorias VALUES (NULL, :nombre)");

                $sql->bindParam(":nombre", $nombre, \PDO::PARAM_STR);

                try {
                    $sql->execute();
                    header("Location: ".base_url."categoria/index");
                } catch (\PDOException $e) {
                    $error = $e;
                }
            }
        }
        $this->pages->render("categoria/crear");
        return null;
    }

    public function ver(): void {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $categoria = new Categoria();
            $categoria->setId($id);
            $productos = $categoria->getAllProducts();
            $categoria = $categoria->getOne();
            $this->pages->render("categoria/ver", ["categoria" => $categoria, "productos" => $productos]);
        }
    }


}