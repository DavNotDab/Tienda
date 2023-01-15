<?php
namespace lib;
use PDO;
use PDOException;

class BaseDatos extends PDO{
    private PDO $conexion;
    private mixed $resultado;
    public function __construct(
        private string $tipo_de_base = "mysql",
        private string $servidor = SERVIDOR,
        private string $usuario = USUARIO,
        private string $password = PASSWORD,
        private string $baseDatos = BASE_DATOS) {

        // Sobreescribo el constructor de la clase PDO
        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );
            parent::__construct("{$this->tipo_de_base}:dbname={$this->baseDatos};host=$this->servidor", $this->usuario, $this->password, $opciones);
        }
        catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            exit;
        }
    }
}