<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/conexion/Conexion.php');

class TecnicosModelo extends Conexion
{
    public function __construct(){

    }

    public function traerTecnicos($conexion = ''){
        $sql = "SELECT * FROM tecnicos "; 
        // echo '<br>'.$sql;
        // die();
        $consulta = mysql_query($sql,$this->connectMysql());
        return $consulta;  
    }
    public function traerTecnicosNew()
    {
        $sql = "select * from tecnicos order by idcliente desc "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arregloTecnicos = $this->get_table_assoc($consulta);
        return $arregloTecnicos;  
    }
    public function traerTecnicoPorId($id)
    {
        $sql = "select * from tecnicos where idcliente = '".$id."'  "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arregloTecnicos = mysql_fetch_assoc($consulta);
        return $arregloTecnicos;  
        
    }
    
    public function grabarTecnico($request)
    {
        $sql = "insert into tecnicos (identi,nombre,telefono,porcentaje_nomina,idlabor) 
        values ('".$request['cedula']."','".$request['nombre']."','".$request['telefono']."'
        ,'".$request['porcentaje']."'
        ,'".$request['idLabor']."'
        
        )"; 
        $consulta = mysql_query($sql,$this->connectMysql());
        
        echo 'Tecnico grabado';
    }
    public function grabarUsuario($request)
    {
        $sql = "insert into usuarios (login,clave,idempresa,id_perfil,idTecnico,nombre,id_empresa_externa) 
        values ('".$request['login']."','".$request['clave']."','300'
        ,'8'
        ,'".$request['idtecnico']."'
        ,'".$request['login']."'
        ,'0'
        )"; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $maxId = $this->traerMaxIdUsuario();
        return $maxId;
    }

    public function traerMaxIdUsuario()
    {
        $sql ="select max(id_usuario) as idMax  from usuarios ";
          $consulta = mysql_query($sql,$this->connectMysql());
        $arrOrden = mysql_fetch_assoc($consulta);
        $maxId = $arrOrden['idMax'];
        return $maxId;
    }

    public function  actualizarIdUsuariotecnico($request,$idUsuario)
    {
         $sql = "update tecnicos set 
        idUsuario = '".$idUsuario."'
        where idcliente = '".$request['idtecnico']."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function actualizarTecnico($request)
    {
        $sql = "update tecnicos set 
        identi = '".$request['cedula']."'
        ,nombre = '".$request['nombre']."'
        ,telefono = '".$request['telefono']."'
        ,porcentaje_nomina = '".$request['porcentaje']."'
        ,idlabor = '".$request['idLabor']."'
        where idcliente = '".$request['idcliente']."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        echo 'Informacion Actualizada';
        
    }
    
    public function eliminarTecnico($idcliente)
    {
        $sql ="delete from tecnicos where idcliente = '".$idcliente."'   ";
        $consulta = mysql_query($sql,$this->connectMysql());
        echo 'Informacion Eliminada';
    }
    public function traerTecnicoAsignadoIdOrden($idOrden)
    {
        $sql = 'select mecanico from ordenes where id='.$idOrden;
        // echo '<br>'.$sql.'<br>';
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrOrden = mysql_fetch_assoc($consulta);
        
        $sql = "select * from tecnicos where idcliente = ".$arrOrden['mecanico']."    ";
        // echo '<br>'.$sql;
        // die();
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrTecnico = mysql_fetch_assoc($consulta);
        return $arrTecnico; 
    }

}







?>