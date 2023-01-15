<?php
namespace Controllers;

use Models\Producto;
use Models\Pedido;
use Lib\Pages;
use Utils\Utils;
use Lib\BaseDatos;
use PDOException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/phpmailer/phpmailer/src/Exception.php";
require "vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "vendor/phpmailer/phpmailer/src/SMTP.php";

class PedidoController {

    private Pages $pages;
    private BaseDatos $bd;

    public function __construct() {
        $this->pages = new Pages();
        $this->bd = new BaseDatos();
    }

    public function save() : void {
        if (isset($_SESSION["identity"])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $carrito = $_SESSION["carrito"];
                $usuarioID = $_SESSION["identity"]->id;
                $pedido = new Pedido();

                // TODO validar direccion entrega
                $pedido->setUsuarioId($usuarioID);
                $pedido->setProvincia($_POST["data"]["provincia"]);
                $pedido->setLocalidad($_POST["data"]["localidad"]);
                $pedido->setDireccion($_POST["data"]["direccion"]);
                $pedido->setCoste($carrito["total"]);

                $correcto = $pedido->save();

                if ($correcto) {
                    $pedido->reducirStock($carrito["productos"]);
                    // TODO verificar que hay stock al hacer pedido
                    $id_pedido = Pedido::getUltimoPedido();
                    $_SESSION["IdPedido"] = $id_pedido;
                    $this->sendEmail();
                    unset($_SESSION["carrito"]);
                    $this->pages->render("pedido/correcto");
                } else {
                    $this->pages->render("pedido/error");
                }
                header("Refresh: 2; URL=".base_url);
            }
            else {
                $this->pages->render("pedido/hacer");
            }

        } else {
            $_SESSION["errorIdentity"] = "<a href='" . base_url . "usuario/login'>Inicia sesión</a> para poder realizar tu pedido";
            header("Location: " . base_url . "Carrito/ver");
        }
    }

    public function misPedidos() : void {
        if (isset($_SESSION["identity"])) {
            $usuarioID = $_SESSION["identity"]->id;
            $pedido = new Pedido();
            $pedidos = $pedido->getByUser($usuarioID);

            $this->pages->render("pedido/mis_pedidos", ["pedidos" => $pedidos]);
        } else {
            $_SESSION["errorIdentity"] = "<a href='" . base_url . "usuario/login'>Inicia sesión</a> para poder ver tus pedidos";
            $this->pages->render("pedido/mis_pedidos", ["error" => $_SESSION["errorIdentity"]]);
        }

    }

    public function ver() : void {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $idPedido = $_GET["id"];
            $pedido = new Pedido();
            $productos = $pedido->getProductos($idPedido);
            foreach ($productos as $producto) {
                $datos = $pedido->getDetallesProducto($producto->producto_id)[0];
                $datos["unidades"] = $producto->unidades;
                $detallesProductos[] = $datos;
            }

            $this->pages->render("pedido/ver", ["productos" => $detallesProductos]);
        }
    }

    private function sendEmail() : void {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "iamabot1303@gmail.com";
        $mail->Password = "vvwkjlldeabtxpxl";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        try {
            $mail->setFrom("iamabot1303@gmail.com");
            $mail->addAddress($_SESSION["identity"]->email);
            $mail->isHTML(true);

            $mail->Subject = "Pedido realizado";
            ob_start();
            include_once "views/email/email.php";
            $mail->Body = ob_get_clean();
            $mail->send();

        } catch (Exception $e) {
            echo "Error al enviar el correo: $mail->ErrorInfo";
        }
    }

}