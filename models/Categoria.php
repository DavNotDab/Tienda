<?php
namespace Models;

use Lib\BaseDatos;
use PDOException;

class Categoria {

    private string $id;
    private string $nombre;

    private BaseDatos $bd;

    public function __construct() {
        $this->bd = new BaseDatos();
    }

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getAll(): bool|\PDOStatement{
        try {
            return $this->bd->query("SELECT * FROM categorias ORDER BY id DESC");
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            return false;
        }
    }

    public function getOne(): bool|Object {
        try {
            $sql = $this->bd->prepare("SELECT * FROM categorias WHERE id = :id");
            $sql->bindParam(":id", $this->id, \PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetch(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            return false;
        }
    }

    public function getAllProducts(): bool|\PDOStatement {
        try {
            $sql = $this->bd->prepare("SELECT * FROM productos WHERE categoria_id = :id");
            $sql->bindParam(":id", $this->id, \PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            return false;
        }
    }

    public static function obtenerCategorias(): bool|\PDOStatement {
        $categoria = new Categoria();
        return $categoria->getAll();
    }
}