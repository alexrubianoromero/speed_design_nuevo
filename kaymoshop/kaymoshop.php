<?php
// session_start();
date_default_timezone_set('America/Bogota');
$raiz = dirname(dirname(__file__));
// echo $raiz;
require_once($raiz.'/kaymoshop/controllers/kaymoShopController.php');
$controller = new kaymoShopController();
?>