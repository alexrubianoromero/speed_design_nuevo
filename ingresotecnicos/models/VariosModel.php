<?php
$ruta = dirname(dirname(dirname(__FILE__)));
require_once($ruta.'/conexion/Conexion.php');

class VariosModel extends Conexion
{
    public function traerOrdenes()
    {
        // echo 'traer ordenes '; 
        $sql = "select * from ordenes order by id desc";
         $consulta = mysql_query($sql,$this->connectMysql()); 
         $ordenes = $this->get_table_assoc($consulta);
         return $ordenes;
    }

    public function verificarCredencialesTecnicos($request)
    {
        $conexion = $this->connectMysql();
        $sql = "select u.id_usuario,u.login,u.clave,u.nombre,u.id_perfil,p.nombre_perfil,p.nivel from usuarios u 
        inner join perfiles p on (p.id_perfil =  u.id_perfil )
        where login = '".$request['user']."'   "; 
        $consulta = mysql_query($sql,$conexion);
        $filas = mysql_num_rows($consulta);
        
        // die('<br>'.$sql.'<br>'.$filas);
        $datosUser  =[];
        if($filas>0)
        {
            $datosUser = mysql_fetch_assoc($consulta);  
            if($datosUser['clave']==$request['clave']  )
            {
                $valida = 1; 
            }
            else {
                $valida = 0;
            }
        }else{
            $valida = 0; 
        } 
        $respu = [];
        $respu['valida'] = $valida;
        $respu['datos'] = $datosUser;
        
        return $respu;  
    } 
}



?>