<?php
namespace Models;

use Lib\BaseDatos;
use PDOException;

class Usuario {

    private string $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $rol;

    private BaseDatos $bd;

    public function __construct(string $id, string $nombre, string $apellidos, string $email, string $password, string $rol) {
        $this->bd = new BaseDatos();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
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

    public function getApellidos(): string {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getRol(): string {
        return $this->rol;
    }

    public function setRol(string $rol): void {
        $this->rol = $rol;
    }

    public function validarUsuario(): bool {
        //TODO validar usuario
        return true;
    }

    public static function fromArray(array $data): Usuario {
        return new usuario(
            $data["id"] ?? "",
            $data["nombre"] ?? "",
            $data["apellidos"] ?? "",
            $data["email"] ?? "",
            $data["password"] ?? "",
            $data["rol"] ?? "");
    }

    public function save(): bool {
        $sql = $this->bd->prepare("INSERT INTO usuarios (id, nombre, apellidos, email, password, rol) VALUES (:id, :nombre, :apellidos, :email, :password, :rol)");

        $sql->bindParam(":id", $id);
        $sql->bindParam(":nombre", $nombre, \PDO::PARAM_STR);
        $sql->bindParam(":apellidos", $apellidos, \PDO::PARAM_STR);
        $sql->bindParam(":email", $email, \PDO::PARAM_STR);
        $sql->bindParam(":password", $password, \PDO::PARAM_STR);
        $sql->bindParam(":rol", $rol, \PDO::PARAM_STR);

        $id = NULL;
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $password = $this->getPassword();
        $rol = "user";

        try {
            $sql->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public function login(): Object|string {
        $email = $this->getEmail();
        $password = $this->getPassword();

        $usuario = $this->buscaMail($email);

        if ($usuario !== false) {
            $verify = password_verify($password, $usuario->password);

            if ($verify) {
                return $usuario;
            }
            else {
                return "Contraseña incorrecta";
            }
        }
        return "El usuario no existe, <a href='".base_url."usuario/registro'>Reg&iacute;strese</a>";
    }

    public function buscaMail($email): Object|false {
        $sql = $this->bd->prepare("SELECT * FROM usuarios WHERE email = :email");

        $sql->bindParam(":email", $email, \PDO::PARAM_STR);

        try {
            $sql->execute();
            if ($sql->rowCount() == 1) {
                $result = $sql->fetch(\PDO::FETCH_OBJ);
            }
            else {
                $result = false;
            }
        } catch (PDOException) {
            $result = false;
        }
        return $result;
    }

}