<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/inventario_codigos/modelo/MovimientosInventarioModelo.php');
require_once($raiz.'/inventario_codigos/modelo/CodigosInventarioModelo.php');
require_once($raiz.'/inventario_codigos/vista/inventariosMovimientoVista.php');

class movimientosInventarioPruebaController
{
   private $modelCod; 
   private $modelMovimientos;  
   private $vistaMov;

   public function  __construct()
   {
    //    echo 'llego al controlador '; 
       $this->modelCod = new CodigosInventarioModelo();
       $this->modelMovimientos = new  MovimientosInventarioModelo();
       $this->vistaMov = new inventariosMovimientoVista();

       if(!isset($_REQUEST['opcion'])){
            $this->saludo();
       }
       if($_REQUEST['opcion']=='mostrarMovimientos')
       {
            $this->mostrarMovimientos($_REQUEST);
       }
       if($_REQUEST['opcion']=='verificacionMovimientosInventario')
       {
            $this->verificacionMovimientosInventario($_REQUEST);
       }
       if($_REQUEST['opcion']=='verificarMovimientosFecha')
       {
            $this->verificarMovimientosFecha($_REQUEST);
       }

   }

   public function saludo()
   {
       echo 'buenas desde controlador '; 
   }

   public function mostrarMovimientos($request)
   {
       $datosCod = $this->modelCod->getInfoCodeById($request['idCode']);
       $movimientosCode =  $this->modelMovimientos->searchMovCode($request['idCode']);
       $this->vistaMov->showMovCode($datosCod,$movimientosCode);   
   }

   public function verificacionMovimientosInventario()
   {
        $this->vistaMov->verificacionMovimientosInventario(); 
   }
   public function verificarMovimientosFecha($request)
   {
       $movimientos =  $this->modelMovimientos->traerMovimientosFecha($request['fechaVerificacion']); 
       $this->vistaMov->mostrarMovRealizarVerificacion($movimientos,$request['fechaVerificacion']);


   }

}


?>