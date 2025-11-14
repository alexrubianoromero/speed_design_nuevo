<?php
// session_start();
date_default_timezone_set('America/Bogota');
$raiz = dirname(dirname(__file__));
// echo $raiz;

//  die();

require_once($raiz.'/cotizaciones/controllers/cotizacionesController.php');
$ventas = new cotizacionesController();
?>


