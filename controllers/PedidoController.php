<?php
namespace Controllers;

use Models\Pedido;
use Lib\Pages;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/phpmailer/phpmailer/src/Exception.php";
require "vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "vendor/phpmailer/phpmailer/src/SMTP.php";

class PedidoController {

    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function save() : void {
        if (isset($_SESSION["identity"])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $carrito = $_SESSION["carrito"];
                $usuarioID = $_SESSION["identity"]->id;
                $pedido = new Pedido();

                $valido = $pedido->validarDireccion($_POST["data"]);

                if ($valido === true) {

                    // TODO validar direccion entrega
                    $pedido->setUsuarioId($usuarioID);
                    $pedido->setProvincia($_POST["data"]["provincia"]);
                    $pedido->setLocalidad($_POST["data"]["localidad"]);
                    $pedido->setDireccion($_POST["data"]["direccion"]);
                    $pedido->setCoste($carrito["total"]);

                    if ($pedido->hayStock($carrito["productos"])){
                        $correcto = $pedido->save();

                        if ($correcto) {
                            $pedido->reducirStock($carrito["productos"]);
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
                        $errorStock = "No hay stock suficiente de alguno de los productos";
                        $this->pages->render("carrito/ver", ["errorStock" => $errorStock]);
                        header("Refresh: 2; URL=".base_url."carrito/ver");

                    }
                } else {
                    $this->pages->render("pedido/hacer", ["error" => $valido]);
                }
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
        $mail->Password = "rxzhgqczmyoxbdhs";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        try {
            $mail->setFrom("iamabot1303@gmail.com");
            $mail->addAddress($_SESSION["identity"]->email);
            $mail->isHTML();

            $mail->Subject = "Pedido realizado";
            ob_start();
            include_once "views/email/email.php";
            $mail->Body = ob_get_clean();
            $mail->send();

        } catch (Exception) {
            echo "Error al enviar el correo: $mail->ErrorInfo";
        }
    }

}