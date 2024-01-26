<?php

$raiz= $_SERVER['DOCUMENT_ROOT'];
date_default_timezone_set('America/Bogota');
require_once($raiz.'/fpdf/fpdf.php');
$ruta = dirname(dirname(dirname(__FILE__)));
require_once($ruta .'/orden/modelo/OrdenesModelo.class.php');
require_once($ruta .'/inventario_codigos/modelo/CodigosInventarioModelo.php');
require_once($ruta .'/ventas/model/VentasModel.php');
// die($ruta);
// require_once($ruta .'/vehiculos/modelo/VehiculosModelo.php');

$orden = new OrdenesModelo();
$infoCode = new CodigosInventarioModelo();
$ventaModel = new VentasModel();

$datosVenta =  $ventaModel->traerInfoVentaId($_REQUEST['idVenta']);
$itemsVenta = $ventaModel->traerItemsVentaIdVenta($_REQUEST['idVenta']);
// $datoOrden = $orden->traerOrdenId($_REQUEST['idOrden']);
// $datosCarro = $orden->traerDatosCarroConPlaca($datoOrden['placa']);
// $datosCliente = $orden->traerDatosPropietarioConPlaca($datosCarro['propietario']); 
// $datosItems = $orden->traerItemsAsociadosOrdenPorIdOrden($_REQUEST['idOrden']); 



$pdf=new FPDF();

$pdf->AddPage();
    $pdf->Ln(5);
    $pdf->Ln(5);
    $pdf->Ln(5);
    $pdf->Ln(5);
    $pdf->Image('../../logos/speeddesign.jpeg',15,20,50);

    $pdf->SetFont('Arial','B',15);
    // Movernos a la derecha
    $pdf->Cell(80);
    // T�tulo
    $pdf->Cell(60,10,'Venta No ',1,0,'');
    $pdf->Cell(19,10,$datosVenta['idVenta'],1,1,'C');

    
    $pdf->SetFont('Arial','',10);
    $pdf->Ln(5);
    $pdf->Ln(5);
    $pdf->Ln(5);
// $pdf->Cell(80);

// $pdf->Cell(40,6,'Cliente',1,0,'C');
// $pdf->Cell(25,6,'Identificacion',1,0,'C');
// $pdf->Cell(25,6,'Telefono',1,1,'C');

// $pdf->Cell(80);
// $pdf->Cell(40,6,$datosCliente['nombre'],1,0,'C');
// $pdf->Cell(25,6,$datosCliente['identi'],1,0,'C');
// $pdf->Cell(25,6,$datosCliente['telefono'],1,1,'C');
// $pdf->Cell(80);
// $pdf->Cell(90,6,$datosCliente['direccion'],1,1,'C');
$pdf->Cell(17);
$pdf->Cell(22,6,'KAYMO SOFTWARE',0,0,'C');
$pdf->Cell(41);
$pdf->Cell(40,6,'Fecha',1,0,'C');
$pdf->Cell(40,6,$datosVenta['fecha'],1,1,'C');

$pdf->Cell(17);
$pdf->Cell(22,6,'Carrera 27 No 74A-39',0,1,'C');
$pdf->Cell(17);
$pdf->Cell(22,6,'Nit:',0,1,'C');


// $kilometraje = $datoOrden['kilometraje'];
// $pdf->Ln(5);
// $pdf->Cell(25);
// $pdf->Cell(22,6,'Fecha',1,0,'C');
// $pdf->Cell(22,6,'Factura',1,0,'C');
// $pdf->Cell(20);
// $pdf->Cell(22,6,'Moto',1,0,'C');
// $pdf->Cell(22,6,'placa',1,0,'C');
// $pdf->Cell(22,6,'Kilometraje',1,1,'C');
// $pdf->Cell(25);
// $pdf->Cell(22,6,$datoOrden['fecha'],1,0,'C');
// $pdf->Cell(22,6,$datoOrden['orden'],1,0,'C');
// $pdf->Cell(20);
// $pdf->Cell(22,6,$datosCarro['marca'],1,0,'C');
// $pdf->Cell(22,6,$datoOrden['placa'],1,0,'C');
// $pdf->Cell(22,6,number_format($kilometraje, 0, ',', '.'),1,1,'C');


$pdf->SetFont('Arial','B',9);
$pdf->Ln(5);
$pdf->Cell(5);
$pdf->Cell(50,6,'Codigo',1,0,'C');
$pdf->Cell(50,6,'Descripcion',1,0,'C');
$pdf->Cell(22,6,'Vr. Unitario',1,0,'C');
$pdf->Cell(20,6,'Cantidad',1,0,'C');
$pdf->Cell(22,6,'Total',1,1,'C');
$suma = 0;
$filas = count($itemsVenta); 
$pdf->SetFont('Arial','',9);
    foreach ($itemsVenta as $itemVenta)    
    {
      $vrUnit =   $itemVenta['valor_unitario'];
      $vrTotal = $itemVenta['total_item'];
    $datosCodigo = $infoCode->verifiqueCodigoSiExiste($itemVenta['codigo']);    
    // echo '<pre>';
    // print_r($datosCodigo['data']); 
    // echo '</pre>';
	$pdf->Cell(5);
	$pdf->Cell(50,6,$itemVenta['codigo'],1,0,'C');
	$pdf->Cell(50,6,$itemVenta['descripcion'].' '.$datosCodigo['data']['referencia'] ,1,0,'C');
	$pdf->Cell(22,6,number_format($vrUnit, 0, ',', '.'),1,0,'C');
	$pdf->Cell(20,6,$itemVenta['cantidad'],1,0,'C');
	$pdf->Cell(22,6,number_format($vrTotal, 0, ',', '.'),1,1,'C');
    $suma = $suma + $vrTotal;
}
$pdf->Cell(5);
$pdf->Cell(50,6,'',1,0,'C');
$pdf->Cell(50,6,'',1,0,'C');
$pdf->Cell(22,6,'',1,0,'C');
$pdf->Cell(20,6,'Subtotal: ',1,0,'C');
$pdf->Cell(22,6,number_format($suma, 0, ',', '.'),1,1,'C');


$pdf->Ln(5);
$pdf->Cell(5);
$pdf->Cell(50,6,'Recibido',0,0,'');
$pdf->Cell(40,6,'___________________',0,1,'');
// $pdf->Ln(5);
// $pdf->Cell(5);
// $pdf->Cell(50,6,'Observaciones',0,1,'');
// $pdf->SetFont('Arial','',6);
// $pdf->Cell(5);
// $pdf->MultiCell(180,8,'TODA REPARACION DEBE SER CANCELADA ESTRICTAMENTE DE CONTADO. NUESTRO REPUESTO NO CONSTITUYE UNA OBLIGACION DE NUESTRA PARTE YA QUE, YA QUE AL INICIAR LOS TRABAJOS PUEDEN APARECER NUEVAS REPARACIONES QUE NO SON EVIDENTES EN LA PRIMERA INSPECCION',0,1,'');

$pdf->Output();

?>