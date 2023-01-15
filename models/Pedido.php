<?php
namespace Models;

use Lib\BaseDatos;
use Lib\Pages;
use PDOException;
use Utils\Utils;

class pedido {

    private string $id;
    private string $usuario_id;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private string $coste;
    private string $estado;
    private string $fecha;
    private string $hora;

    private BaseDatos $bd;
    private Pages $pages;

    public function __construct() {
        $this->bd = new BaseDatos();
        $this->pages = new Pages();
    }

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getUsuarioId(): string {
        return $this->usuario_id;
    }

    public function setUsuarioId(string $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    public function getProvincia(): string {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): void {
        $this->provincia = $provincia;
    }

    public function getLocalidad(): string {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): void {
        $this->localidad = $localidad;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function getCoste(): string {
        return $this->coste;
    }

    public function setCoste(string $coste): void {
        $this->coste = $coste;
    }

    public function getEstado(): string {
        return $this->estado;
    }

    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    public function getHora(): string {
        return $this->hora;
    }

    public function setHora(string $hora): void {
        $this->hora = $hora;
    }

    public function save() : bool {
        $this->bd->beginTransaction();
        try {
            $this->savePedido();
            $id_pedido = $this->bd->lastInsertId();
            $this->saveLineasPedido($id_pedido);
            $this->bd->commit();
            return true;
        } catch (PDOException $e) {
            $this->bd->rollBack();
            return false;
        }
    }

    private function savePedido(): void {
        $sql = $this->bd->prepare("INSERT INTO pedidos VALUES (NULL, :usuario_id, :provincia, :localidad, :direccion, :coste, 'confirmed', CURDATE(), CURTIME())");

        $sql->bindParam(":usuario_id", $this->usuario_id, \PDO::PARAM_INT);
        $sql->bindParam(":provincia", $this->provincia, \PDO::PARAM_STR);
        $sql->bindParam(":localidad", $this->localidad, \PDO::PARAM_STR);
        $sql->bindParam(":direccion", $this->direccion, \PDO::PARAM_STR);
        $sql->bindParam(":coste", $this->coste, \PDO::PARAM_STR);

        $sql->execute();
    }

    private function saveLineasPedido($id_pedido) : void{
        foreach ($_SESSION["carrito"]["productos"] as $producto) {
            $sql = $this->bd->prepare("INSERT INTO lineas_pedidos VALUES (NULL, :pedido_id, :producto_id, :unidades)");

            $sql->bindParam(":pedido_id", $id_pedido, \PDO::PARAM_INT);
            $sql->bindParam(":producto_id", $producto->id, \PDO::PARAM_INT);
            $sql->bindParam(":unidades", $producto->unidades, \PDO::PARAM_INT);

            $sql->execute();
        }

    }

    public function reducirStock($carrito) : void {
        foreach ($carrito as $producto) {
            $sql = $this->bd->prepare("UPDATE productos SET stock = stock - :unidades WHERE id = :id");
            $sql->bindParam(":unidades", $producto->unidades, \PDO::PARAM_INT);
            $sql->bindParam(":id", $producto->id, \PDO::PARAM_INT);
            $sql->execute();
        }
    }

    public function getByUser($userID) : array {
        $sql = $this->bd->prepare("SELECT * FROM pedidos WHERE usuario_id = :id");
        $sql->bindParam(":id", $userID, \PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getProductos($idPedido) : array {
        $sql = $this->bd->prepare("SELECT * FROM lineas_pedidos WHERE pedido_id = :id");
        $sql->bindParam(":id", $idPedido, \PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getDetallesProducto($producto_id) : array {
        $sql = $this->bd->prepare("SELECT nombre, precio, imagen FROM productos WHERE id = :id");
        $sql->bindParam(":id", $producto_id, \PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getUltimoPedido() : string {
        $bd = new BaseDatos();
        $sql = $bd->prepare("SELECT id FROM pedidos ORDER BY id DESC LIMIT 1");
        $sql->execute();
        return $sql->fetch(\PDO::FETCH_OBJ)->id;
    }


}