<?php
$raiz = dirname(dirname(dirname(__file__)));

require_once($raiz.'/conexion/Conexion.php');

    class  productosKaymoShopModel extends Conexion
    {
        public function __construct(){
         
        }

    //    public function getInfoCode($codigo)
    //     {
    //         $sql = "select * from productos where codigo_producto = '".$codigo."'  ";
    //         $consulta = mysql_query($sql,$this->connectMysql());
    //         $arrCodigo = mysql_fetch_assoc($consulta);
    //         return $arrCodigo;
    //     }


       public function traerCodigos()
        {
            $sql = "select * from productos order by id_codigo ";
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrCodigo = $this->get_table_assoc($consulta);
            return $arrCodigo;
        }
       public function traerEmpresaShop()
        {
            $sql = "select * from empresa ";
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrCodigo = mysql_fetch_assoc($consulta);
            return $arrCodigo;
        }


    }

 ?>   