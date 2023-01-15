<?php

session_start();
require_once "autoloader.php";
require_once "config/config.php";
require_once "views/layout/header.php";

use controllers\FrontController;
FrontController::main();



require_once "views/layout/footer.php";