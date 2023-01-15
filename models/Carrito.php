<?php
namespace Models;

use Lib\BaseDatos;
use PDOException;

class Carrito {

    private BaseDatos $bd;

    public function __construct() {
        $this->bd = new BaseDatos();
    }

    public function addProducto(object $producto): void {
        if (isset($_SESSION["carrito"]["productos"])) {
            $counter = 0;

            foreach ($_SESSION["carrito"]["productos"] as $indice => $elemento) {
                if ($elemento->id == $producto->id) {
                    $_SESSION["carrito"]["productos"][$indice]->unidades++;
                    $counter++;
                    header("Location: ".base_url."Carrito/ver");
                }
            }
        }

        if (!isset($counter) || $counter == 0) {
            $_SESSION["carrito"]["productos"][] = $producto;
            header("Location: ".base_url."Categoria/ver&id=".$producto->categoria_id);
        }
        $_SESSION["carrito"]["total"] += $producto->precio;
        $_SESSION["carrito"]["total_unidades"]++;
    }

    public function removeProducto($id): void {
        foreach ($_SESSION["carrito"]["productos"] as $indice => $elemento) {
            if ($elemento->id == $id) {
                $_SESSION["carrito"]["total"] -= $elemento->precio;
                $_SESSION["carrito"]["total_unidades"]--;
                if ($elemento->unidades > 1) {
                    $_SESSION["carrito"]["productos"][$indice]->unidades--;
                } else {
                    unset($_SESSION["carrito"]["productos"][$indice]);
                }
            }
        }
    }

    public function deleteProducto($id): void {
        foreach ($_SESSION["carrito"]["productos"] as $indice => $elemento) {
            if ($elemento->id == $id) {
                $_SESSION["carrito"]["total"] -= $elemento->precio * $elemento->unidades;
                $_SESSION["carrito"]["total_unidades"] -= $elemento->unidades;
                unset($_SESSION["carrito"]["productos"][$indice]);
            }
        }
    }

    public function getAllProducts(): array {
        $productos = array();
        if (isset($_SESSION["carrito"]["productos"])) {
            $productos = $_SESSION["carrito"]["productos"];
        }
        return $productos;
    }

    public function delete(): void {
        unset($_SESSION["carrito"]);
    }
}