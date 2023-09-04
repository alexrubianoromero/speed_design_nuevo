<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/inventario_codigos/modelo/CodigosInventarioModelo.php');
class inventariosMovimientoVista
{
    protected $codigoModel;

    public function __construct()
    {
        $this->codigoModel = new CodigosInventarioModelo();
    }

    public function showMovCode($datosCod,$movimientos)
    {
        echo '<div>';
        echo '<h3>'.$datosCod['descripcion'];
        echo '<label style="color:green;">';
        echo ' Saldo Act: '.$datosCod['cantidad'];
        echo '</h3>'; 
        echo '</label>';
        echo '</div>';
        echo '<table class="table table-striped">';  
        echo '<tr>';
        echo '<th>Fecha</th>';
        echo '<th>Observaciones</th>';
        echo '<th>Cant</th>';
        echo '<th>Doc</th>';
        echo '</tr>';
        while($mov = mysql_fetch_assoc($movimientos))
        {
            
            echo '<tr>';
            echo '<td>'.$mov['fecha_movimiento'].'</td>'; 
            // if($mov['tipo_movimiento']== 0)
            // {
            //     $nombreMovimiento = 'Creacion Inicial';
            // }
            // if($mov['tipo_movimiento']== 1)
            // {
            //     $nombreMovimiento = 'Entrada';
            // }
            // if($mov['tipo_movimiento']== 2)
            // {
            //     $nombreMovimiento = 'Salida';
            // }
            // echo '<td>'.$nombreMovimiento.'</td>'; 
            echo '<td>'.$mov['observaciones'].'</td>';    
            echo '<td>'.$mov['cantidad'].'</td>'; 
            if($mov['tipo_movimiento']== 1 || $mov['tipo_movimiento']== 3 )
            {
                echo '<td>'.$mov['facturacompra'].'</td>'; 
                }
            if($mov['tipo_movimiento']== 2 || $mov['tipo_movimiento']== 4 )
                {
                echo '<td>'.$mov['id_factura_venta'].'</td>'; 
            }
            echo '</tr>';
        }      
        echo '</table>';
    }

    
    public function mostrarMovRealizarVerificacion($movimientos,$fecha)
    {

        echo '<h3>'.$fecha.'</h3>';
        echo '<div>';
        echo '<table class="table table-striped">';  
        echo '<tr>';
        // echo '<th>Fecha</th>';
        echo '<th>TipoMov</th>';
        echo '<th>Id</th>';
        echo '<th>Referencia</th>';
        echo '<th>Observaciones</th>';
        echo '<th>CantAnt</th>';
        echo '<th>Cant</th>';
        echo '<th>Saldo</th>';
        echo '<th>Verif</th>';
        echo '</tr>';
        foreach($movimientos as $mov)
        {
            $infoCode = $this->codigoModel->getInfoCodeById($mov['id_codigo_producto']);
            // echo '<pre>'; 
            // print_r($infoCode);
            // echo '</pre>';
            // die();
                // die('buenas ');
            echo '<tr>';
            // echo '<td>'.$mov['fecha_movimiento'].'</td>'; 
            echo '<td>'.$mov['tipo_movimiento'].'</td>'; 
            echo '<td>'.$mov['id_codigo_producto'].'</td>'; 
            echo '<td>'.$infoCode['referencia'].'</td>'; 
          
            echo '<td>'.$mov['observaciones'].'</td>';    
            echo '<td>'.$mov['cantidadAnterior'].'</td>'; 
            echo '<td>'.$mov['cantidad'].'</td>'; 
            echo '<td>'.$mov['resultado'].'</td>';
            $valOper = $this->verificarSumasRestasInventario($mov['id_codigo_producto'],$mov['tipo_movimiento'],$mov['cantidadAnterior'],$mov['cantidad'],$mov['resultado']); 
            echo '<td>'.$valOper.'</td>'; 
          
        }      
        echo '</table>';
    }


   public function verificacionMovimientosInventario()
    {
    ?>
        <div >
            <label for="">Fecha:</label>
            <input type="date" id="fechaVerificacion"> 
            <button class="btn btn-primary"
            onclick = "verificarMovimientosFecha();"
            >Verificar Movimientos</button>  
            <div id="divResultadosVerificacionMovimientos"></div>
        </div>

    <?php
    }


    public function verificarSumasRestasInventario($idCod,$tipoMov,$anterior,$cantidad,$saldo)
    {
      //1 , 3 y 5 son entradas y suma al inventario 
      //2,4 y 6  son salidas y resta al inventario 
      if($tipoMov == 1 || $tipoMov == 3 ||  $tipoMov == 5)
      {
        $operacion = $anterior + $cantidad;
      }
      if($tipoMov == 2 || $tipoMov == 4 ||  $tipoMov == 6)
      {
        $operacion = $anterior - $cantidad;
      }
    //   echo 'operacion '.$operacion;
    //   die();
      if($operacion == $saldo)
      {
        return 'ok';
      }
      else{
        return 'error';
      }
      
      
    }

}

?>