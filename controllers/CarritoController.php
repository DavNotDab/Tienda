<?php
namespace Controllers;

use Models\Carrito;
use Models\Producto;
use Lib\BaseDatos;
use Lib\Pages;

class CarritoController {

    private Pages $pages;
    private BaseDatos $bd;

    public function __construct() {
        $this->pages = new Pages();
        $this->bd = new BaseDatos();
    }

    public function ver(): void {
        $carrito = new Carrito();
        $productos = $carrito->getAllProducts();
        $this->pages->render("carrito/ver", ["productos" => $productos]);
    }

    public function addProducto(): void {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $producto = new Producto();
            $producto->setId($id);
            $producto = $producto->getOne();
            $producto->unidades = 1;

            if (is_object($producto)) {
                $carrito = new Carrito();
                $carrito->addProducto($producto);
            }
        }
    }

    public function removeProducto(): void {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $carrito = new Carrito();
            $carrito->removeProducto($id);
            header("Location: ".base_url."Carrito/ver");
        }
    }

    public function deleteProducto(): void {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $carrito = new Carrito();
            $carrito->deleteProducto($id);
            header("Location: ".base_url."carrito/ver");
        }
    }

    public function delete(): void {
        $carrito = new Carrito();
        $carrito->delete();
        header("Location: ".base_url."carrito/ver");
    }

}