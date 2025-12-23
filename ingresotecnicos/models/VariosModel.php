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
    public function traerOrdenesUsuario($idTecnico)
    {
        // echo 'traer ordenes '; 
        $sql = "select * from ordenes where mecanico = '".$idTecnico."'   order by id desc limit 10";
        // die($sql);
         $consulta = mysql_query($sql,$this->connectMysql()); 
         $ordenes = $this->get_table_assoc($consulta);
         return $ordenes;
    }
    public function traerOrdenesUsuarioEnProceso($idTecnico)
    {
        // echo 'traer ordenes '; 
        $sql = "select * from ordenes where mecanico = '".$idTecnico."' and estado='0'  order by id desc limit 10";
        // die($sql);
         $consulta = mysql_query($sql,$this->connectMysql()); 
         $ordenes = $this->get_table_assoc($consulta);
         return $ordenes;
    }

    public function verificarCredencialesTecnicos($request)
    {
        $conexion = $this->connectMysql();
        $sql = "select u.id_usuario,u.login,u.clave,u.nombre,u.id_perfil,p.nombre_perfil,p.nivel,u.idTecnico 
        from usuarios u 
        inner join perfiles p on (p.id_perfil =  u.id_perfil )
        where login = '".$request['user']."'   "; 
        // die($sql);
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


    public function traerInfoTecnico($idUsuario)
    {
        $sql ="select * from tecnicos where idUsuario = '".$idUsuario."'   ";
               $consulta = mysql_query($sql,$this->connectMysql()); 
         $arrTecnico = mysql_fetch_assoc($consulta);
         return $arrTecnico;
    }

    public function traerInfoUsuarioIdTecnico($idTecnico)
    {
        $sql ="select * from usuarios where idTecnico = '".$idTecnico."'   ";
               $consulta = mysql_query($sql,$this->connectMysql()); 
         $arrUsuario = mysql_fetch_assoc($consulta);
         return $arrUsuario;
    }
    
    public function traerInfoEmpresa()
    {
        $sql ="select * from empresa  ";
              $consulta = mysql_query($sql,$this->connectMysql()); 
         $arrEmpre = mysql_fetch_assoc($consulta);
         return $arrEmpre;
    }

    public function traerInfoCarroPlaca($placa)
    {
        $sql ="select * from carros where placa =  '".$placa."'    ";
        $consulta = mysql_query($sql,$this->connectMysql()); 
         $arrEmpre = mysql_fetch_assoc($consulta);
         return $arrEmpre;
    }
    public function traerInfoEstado($idEstado)
    {
        $sql ="select * from estados_ordenes where valor_estado = '".$idEstado."'    ";
        $consulta = mysql_query($sql,$this->connectMysql()); 
         $arrEstado = mysql_fetch_assoc($consulta);
         return $arrEstado;
    }

}



?>