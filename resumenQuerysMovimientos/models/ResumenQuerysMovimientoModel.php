<?php
$raiz = dirname(dirname(dirname(__file__)));

require_once($raiz.'/conexion/Conexion.php');

class ResumenQuerysMovimientoModel extends Conexion
{
        public function registrarQueryMovimiento($info)
        {
            $querySinComillas = addslashes ( $info['query']);
            $sql = "insert into resumenQuerysMovimientos  
            (id_movimiento,funcion,query)
            values ('".$info['id_movimiento']."','".$info['funcion']."','".$querySinComillas."')
            "; 
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());   
        }
}