<?php

$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/ventas/model/VentasTemporalModel.php');
class CotizacionModel extends Conexion
{
    protected $ventasTempModel;

    public function __construct(){
        $this->ventasTempModel = new VentasTemporalModel();
    }

    public function grabarVenta($idTemp)
    {
        $sql ="insert into cotizaciones (fecha) values( now() )";
        $consulta = mysql_query($sql,$this->connectMysql());
        
        $ultId = $this->traerUltimoIdVentas();
        $this->grabarItemsVenta($idTemp);
        
    }
    
    public function traerUltimoIdVentas()
    {
        $sql = "select max(idVenta) as id  from cotizaciones ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $result = mysql_fetch_assoc($consulta); 
        return $result['id']; 
    }
    public function grabarItemsVenta($idTemp,$itemsTemp)
    {
        // echo '<pre>'; 
        // print_r($itemsTemp); 
        // echo '</pre>';
        // die();
        foreach($itemsTemp as $request)
        {
            $sql ="insert into cotizaciones_items  
            (no_factura, codigo ,descripcion
            ,valor_unitario,cantidad,total_item,idCode)
            values ('".$idTemp."','".$request['codigo']."','".$request['descripcion']."'
            ,'".$request['valor_unitario']."','".$request['cantidad']."' ,'".$request['total_item']."','".$request['idCode']."' )
            "; 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
    }
    public function traerInfoVentaId($idVenta)
    {
        $sql = "select * from cotizaciones where idVenta =  '".$idVenta."'  "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arreglo = mysql_fetch_assoc($consulta ); 
        return $arreglo; 
    }
    
    public function traerItemsVentaIdVenta($idVenta)
    {
        $sql = "select * from cotizaciones_items where no_factura =  '".$idVenta."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arreglo = $this->get_table_assoc($consulta); 
        return $arreglo; 
    }
    
    public function traerInfoItemVentaId($idVenta)
    {
        $sql = "select * from cotizaciones_items where id_item = '".$idVenta."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arreglo = mysql_fetch_assoc($consulta); 
        return $arreglo; 
    }
    public function sumarItemsVentaId($idVenta)
    {
        $sql = "select sum(total_item) as total  from cotizaciones_items where no_factura =  '".$idVenta."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arreglo = mysql_fetch_assoc($consulta ); 
        return $arreglo['total'];
    }
    
    public function traerVentas()
    {
        $sql = " select * from  cotizaciones order by idVenta desc ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $arreglo = $this->get_table_assoc($consulta);
        return $arreglo;
    }
    
    public function eliminarItemsVentaId($id)
    {
        $sql = "delete from cotizaciones_items   where  no_factura = '".$id."'   ";
        $consulta = mysql_query($sql,$this->connectMysql());
        
    }
    
    public function eliminarVentaId($id)
    {
        $sql ="delete from cotizaciones where idVenta =  '".$id."'  "; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function eliminarItemDeVentaId($idItem)
    {
        $sql = "delete from cotizaciones_items where id_item  =  '".$idItem."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }

}



?>