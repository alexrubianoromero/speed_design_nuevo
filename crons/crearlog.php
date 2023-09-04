<?php
   include('../valotablapc.php');
   include('../funciones.php');
    echo 'esto es desde el archivo crear log 1234';
    
    echo '<br>'.$tabla100;


    $sql = "select * from carros limit 10";
    // die($sql);
    $consulta = mysql_query($sql,$conexion);
    $carros = get_table_assoc($consulta);
    foreach($carros as $carro)
    {
        echo '<br>'.$carro['placa'];
        grabarlog($carro['placa'],$conexion); 
        
    }
    


    function grabarlog($placa,$conexion)
    {
        $sql = "insert into logs (descripcion) values ('".$placa."')"; 
        $consulta = mysql_query($sql,$conexion);
    }




?>