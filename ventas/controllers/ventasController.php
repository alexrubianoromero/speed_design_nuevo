<?php

$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/ventas/vista/ventasVista.php');
require_once($raiz.'/ventas/model/VentasTemporalModel.php');
require_once($raiz.'/ventas/model/VentasModel.php');
require_once($raiz.'/inventario_codigos/modelo/CodigosInventarioModelo.php'); 
require_once($raiz.'/inventario_codigos/modelo/MovimientosInventarioModelo.php'); 
  // echo '<pre>'; 
        // print_r($itemsTemp);
        // echo '</pre>';
        // die(); 
class ventasController
{
    protected $vista;
    protected $codigosModelo;
    protected $ventasTemporalModel; 
    protected $ventasModel; 
    protected $movimientosModelo;

    public function __construct()
    {
        $this->vista = new ventasVista();
        $this->codigosModelo = new CodigosInventarioModelo();
        $this->movimientosModelo = new MovimientosInventarioModelo();
        $this->ventasTemporalModel = new VentasTemporalModel();
        $this->ventasModel = new VentasModel();

        // echo 'llego a controlador '; 
        if($_REQUEST['opcion']=='pantallaPrincipalVentas'){
            $this->pantallaPrincipalVentas($_REQUEST);
       }       
        if($_REQUEST['opcion']=='pantallaNuevaVenta'){
            $this->pantallaNuevaVenta($_REQUEST);
       }       
        if($_REQUEST['opcion']=='pregunteNuevoItemNewVentas'){
            $this->pregunteNuevoItemNewVentas($_REQUEST);
       }       
        if($_REQUEST['opcion']=='formuFiltrosInventarioVentas'){
            $this->formuFiltrosInventarioVentas($_REQUEST);
       }   
        if($_REQUEST['opcion']=='busqueCodigosConFiltroVentas'){
            $this->busqueCodigosConFiltroVentas($_REQUEST);
       }   
        if($_REQUEST['opcion']=='grabarItemsTemporalVenta'){
            $this->grabarItemsTemporalVenta($_REQUEST);
       }   
        if($_REQUEST['opcion']=='grabarVenta'){
            $this->grabarVenta($_REQUEST);
       }   
        if($_REQUEST['opcion']=='verItemsVenta'){
            $this->verItemsVenta($_REQUEST);
       }   
        if($_REQUEST['opcion']=='muestreVentas'){
            $this->muestreVentas();
       }   
       if($_REQUEST['opcion']=='eliminarVenta'){
        $this->eliminarVenta($_REQUEST);
        } 
       if($_REQUEST['opcion']=='pedirClaveEliminar'){
        $this->pedirClaveEliminar($_REQUEST);
        } 
        
        if($_REQUEST['opcion']=='verificarClaveEliminar'){
            $this->verificarClaveEliminar($_REQUEST);
        } 
        if($_REQUEST['opcion']=='eliminarItemVentaMostrador'){
            $this->eliminarItemVentaMostrador($_REQUEST);
        } 
        
        if($_REQUEST['opcion']=='pedirClaveEliminarItemVenta'){
          $this->vista->pedirClaveEliminarItemVenta($_REQUEST['idItem']);
        } 
   

       
    }


    public function eliminarItemVentaMostrador($request)
    {
        $infoItemVenta = $this->ventasModel->traerInfoItemVentaId($request['idItem']); 
        // echo 'desde funcion<pre>'; 
        // print_r($infoItemVenta);
        // echo '</pre>';
        // die(); 
        //registrar el movimiento del producto o codigo
        //hay que armar la data al parecer es el id codigo, tipo, cantidad 
        //de acuerdo a una mejora anterior a esta funcion le debo enviar un arelgo request con campo  cantidad del item que voya a eliminar
        $data['tipo']= 5;
        $data['cantidad'] = $infoItemVenta['cantidad'];
        $data['factura'] = ''; 
        $data['id'] = $infoItemVenta['codigo'];
        $data['observaciones'] = ' Ingreso por anulacion item Venta  id '.$request['idItem']; 
        //ahora graba el registro del movimiento 
        //esta parte la tuve que colocar porque la funcion registerMovNew ahora pide el request con el campo cantidad
        //esto porque donde esteban estaba fallando el descuento de inventario 
        $requestNuevo['cantidad'] = $infoItemVenta['cantidad'];
        $idUltMov = $this->movimientosModelo->registerMovNew($data,$requestNuevo);
        //hacer el ajuste de inventario y sumar nuevamente la cantidad que se habia colocado en el item 
        $parametros['id'] = $infoItemVenta['codigo'];
        $parametros['tipo'] = 5;
        $parametros['cantidad']= $infoItemVenta['cantidad'];
        $this->codigosModelo->saveMoreLessInventNew($parametros,$idUltMov);
        //eliminar el item del inventario 
        $this->ventasModel->eliminarItemDeVentaId($request['idItem']);

        echo 'Eliminacion realizada ';
    }

    public function pantallaPrincipalVentas($request)
    {
        $this->vista->pantallaPrincipalVentas();
    }
    public function pantallaNuevaVenta($request)
    {
        //crear registro temporal 
        $idTemp =  $this->ventasTemporalModel->crearVentaTemporal();
        $this->vista->pantallaNuevaVenta($idTemp);
    }
    public function pregunteNuevoItemNewVentas($request){
        
        $this->vista->pregunteNuevoItemNewVentas($request);
    }
    
    
    public function formuFiltrosInventarioVentas($request){
        
        $this->vista->formuFiltrosInventarioVentas();
    }
    public function busqueCodigosConFiltroVentas($request)
    {
        $codigos = $this->codigosModelo->getInfoCodeFiltros($request);
        $this->vista->mostrarCodigosBucadosFiltroVentas($codigos);
    }
    
    public function grabarItemsTemporalVenta($request)
    {
        $this->ventasTemporalModel->grabarItemsVentaTemporal($request);
        $itemsVentaTemporal =  $this->ventasTemporalModel->traerItemsVentaTemporal($request['idTemp']);
        $this->vista->muestreItemsTemporales($request['idTemp'],$itemsVentaTemporal);
    }
    
    public function grabarVenta($request)
    {
        $this->ventasModel->grabarventa($request['idTemp']);
        $ultIdVenta = $this->ventasModel->traerUltimoIdVentas();
        $itemsTemp = $this->ventasTemporalModel->traerItemsVentaTemporal($request['idTemp']);
        $this->ventasModel->grabarItemsVenta($ultIdVenta,$itemsTemp); 
        $this->registrarMovimientosInventario($ultIdVenta,$itemsTemp);
        // $this->relizarDescuentosInventario($itemsTemp);
        //limpiar las tablas temporales
        $respu['idVenta']= $ultIdVenta;
        echo json_encode($respu);
        exit();
    }
    
    public function relizarDescuentosInventario($itemsTemp)
    {
        foreach($itemsTemp as $itemTemp)
        {
            $parametros['id'] = $itemTemp['idCode'];
            $parametros['tipo'] = 6;
            $parametros['cantidad']= $itemTemp['cantidad'];
            $this->codigosModelo->saveMoreLessInvent($parametros);
        }
    }
    public function registrarMovimientosInventario($ultIdVenta,$itemsTemp)
    {
        foreach($itemsTemp as $itemTemp)
        {
            $data['tipo']= 6;
            $data['cantidad'] = $itemTemp['cantidad'];
            $data['factura'] = ''; 
            $data['id'] = $itemTemp['idCode'];
            $data['observaciones'] = 'Salida en Venta '.$ultIdVenta; 
            //ahora graba el registro del movimiento 
            //esta parte la tuve que colocar porque la funcion registerMovNew ahora pide el request con el campo cantidad
            //esto porque donde esteban estaba fallando el descuento de inventario 
            $requestNuevo['cantidad'] = $itemTemp['cantidad'];
            $idUltMov = $this->movimientosModelo->registerMovNew($data,$requestNuevo);
            $parametros['id'] = $itemTemp['idCode'];
            $parametros['tipo'] = 6;
            $parametros['cantidad']= $itemTemp['cantidad'];
            $this->codigosModelo->saveMoreLessInventNew($parametros,$idUltMov);
        }    
    }
    public function verItemsVenta($request)
    {
        $itemsVenta =$this->ventasModel->traerItemsVentaIdVenta($request['idVenta']);
        $this->vista->verItemsVenta($itemsVenta,$request);
        
    }
    public function muestreVentas()
    {
        $this->vista->muestreVentas();
        
    }
    public function eliminarVenta($request)
    {
        
        $itemsVenta =$this->ventasModel->traerItemsVentaIdVenta($request['idVenta']);
        
        $this->relizarDevolucionInventario($itemsVenta);
        $this->registrarMovimientosInventarioReversionVenta($request['idVenta'],$itemsVenta);
        $this->ventasModel->eliminarItemsVentaId($request['idVenta']);
        $this->ventasModel->eliminarVentaId($request['idVenta']);
        echo 'Eliminacion Realizada';
    }
    public function relizarDevolucionInventario($itemsTemp)
    {
        
        foreach($itemsTemp as $itemTemp)
        {
            $parametros['id'] = $itemTemp['idCode'];
            $parametros['tipo'] = 5;
            $parametros['cantidad']= $itemTemp['cantidad'];
            $this->codigosModelo->saveMoreLessInvent($parametros);
        }
    }
    
    public function registrarMovimientosInventarioReversionVenta($idVenta,$itemsTemp)
    {
        foreach($itemsTemp as $itemTemp)
        {
            $data['tipo']= 5;
            $data['cantidad'] = $itemTemp['cantidad'];
            $data['factura'] = ''; 
            $data['id'] = $itemTemp['idCode'];
            $data['observaciones'] = 'Reversion en Venta '.$idVenta; 
            //ahora graba el registro del movimiento 
            $this->movimientosModelo->registerMov($data);
        }    
    }
    public function pedirClaveEliminar($request)
    {
        $this->vista->pedirClaveEliminar($request['idVenta']);
    }

    public function verificarClaveEliminar($request)
    {
        if($request['clavePan']=='A123456b*')
        {
            $validacion = 1;
        }
        else{
            $validacion = 0;
        }
        echo json_encode($validacion);
        exit();
    }
    
    
}

?>