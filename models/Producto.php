<?php
namespace Models;

use Lib\BaseDatos;
use PDOException;
use Utils\Utils;

class Producto {

    private string $id;
    private string $categoria_id;
    private string $nombre;
    private string $descripcion;
    private string $precio;
    private string $stock;
    private string $oferta;
    private string $fecha;
    private string $imagen;

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

    public function getCategoriaId(): string {
        return $this->categoria_id;
    }

    public function setCategoriaId(string $categoria_id): void {
        $this->categoria_id = $categoria_id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getPrecio(): string {
        return $this->precio;
    }

    public function setPrecio(string $precio): void {
        $this->precio = $precio;
    }

    public function getStock(): string {
        return $this->stock;
    }

    public function setStock(string $stock): void {
        $this->stock = $stock;
    }

    public function getOferta(): string {
        return $this->oferta;
    }

    public function setOferta(string $oferta): void {
        $this->oferta = $oferta;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    public function getImagen(): string {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void {
        $this->imagen = $imagen;
    }

    public function getAll(): bool|\PDOStatement{
        try {
            return $this->bd->query("SELECT * FROM productos ORDER BY id DESC");
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            return false;
        }
    }

    public static function obtenerProductos(): bool|\PDOStatement {
        $producto = new Producto();
        return $producto->getAll();
    }

    public function getOne(): bool|Object {
        try {
            $sql = $this->bd->prepare("SELECT * FROM productos WHERE id = :id");
            $sql->bindParam(":id", $this->id, \PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetch(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            return false;
        }
    }

    public function save($data, $imagen) : bool {
        $sql = $this->bd->prepare("INSERT INTO productos VALUES (NULL, :id_categoria, :nombre, :descripcion, :precio, :stock, NULL, CURRENT_DATE, :imagen)");

        $sql->bindParam(":id_categoria", $data["categoria"], \PDO::PARAM_INT);
        $sql->bindParam(":nombre", $data["nombre"], \PDO::PARAM_STR);
        $sql->bindParam(":descripcion", $data["descripcion"], \PDO::PARAM_STR);
        $sql->bindParam(":precio", $data["precio"], \PDO::PARAM_STR);
        $sql->bindParam(":stock", $data["stock"], \PDO::PARAM_INT);
        $sql->bindParam(":imagen", $imagen["name"], \PDO::PARAM_STR);

        try {
            $sql->execute();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function validarSave(array $data, $dataImagen): bool|string {
        $nombre = Utils::validarNombre($data['nombre']);
        $descripcion = Utils::validarTexto($data['descripcion']);
        $precio = Utils::validarNumero($data['precio']);
        $stock = Utils::validarNumero($data['stock']);
        $imagen = Utils::validarImagen($dataImagen);

        if ($nombre === true) {
            if ($descripcion === true) {
                if ($precio === true) {
                    if ($stock === true) {
                        if ($imagen === true) {
                            return true;
                        } else {
                            return $imagen;
                        }
                    } else {
                        return $stock;
                    }
                } else {
                    return $precio;
                }
            } else {
                return $descripcion;
            }
        } else {
            return $nombre;
        }
    }

}