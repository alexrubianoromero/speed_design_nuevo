<?php
    $raiz = dirname(dirname(dirname(__file__)));
    require_once($raiz.'/conexion/Conexion.php');
    require_once($raiz.'/inventario_codigos/modelo/CodigosInventarioModelo.php');

    class MovimientosInventarioModelo extends Conexion
    {
        protected $codigosModel; 

        public function __construct(){
            $this->codigosModel = new CodigosInventarioModelo();
        }

      
        public function registerMovInicial($data,$id_codigo)
        {
            // echo '<pre>'; 
            // print_r($data); 
            // echo '</pre>';
            // die();
                $observaciones = 'Registro Inicial'; 
                $sql = "insert into movimientos_inventario 
                (fecha_movimiento,cantidad,tipo_movimiento,id_codigo_producto,observaciones)
                values( 
                now()
                , '".$data['cantidad']."'
                ,'0'
                ,'".$id_codigo."'
                ,'".$observaciones."'
                ) "; 
                $consulta = mysql_query($sql,$this->connectMysql());  
                echo '<br>Movimiento grabado';        
            }
            
            
            public function registerMov($data)
            {
                $conexion = $this->connectMysql();
                
                if($data['tipo']==6)
                { 
                    $obseTipo= '';
                    $campo = 'id_factura_venta';
            }        

            if($data['tipo']==4)
            { 
                $obseTipo= '';
                $campo = 'facturacompra';
            }        
            
            if($data['tipo']==5)
            { 
                $obseTipo= '';
                $campo = 'facturacompra';
            }        
            
            if($data['tipo']==3)
            { 
                $obseTipo= '';
                $campo = 'facturacompra';
            }        
            
            if($data['tipo']==1)
            { 
                $obseTipo= 'Entrada Inventario';
                $campo = 'facturacompra';}
                
                if($data['tipo']==2){ 
                    $obseTipo = 'Salida  Inventario';
                    $campo = 'id_factura_venta';
                }
                
                $observaciones = $obseTipo.': '.$data['observaciones'];
                
                
                $sql = "insert into movimientos_inventario 
                (fecha_movimiento,cantidad,tipo_movimiento,".$campo.",id_codigo_producto,observaciones)
                values( now(), '".$data['cantidad']."','".$data['tipo']."'
                ,'".$data['factura']."'
                ,'".$data['id']."'
                ,'".$observaciones."'
                ) "; 
                //  die($sql); 
                $consulta = mysql_query($sql,$conexion);  
                // echo '<br>Movimiento grabado';        
            }
            
            public function registerMovNew($data,$request)
            {
                
                //////////////1 , 3 y 5 son entradas y suma al inventario 
                //1 es entrada de inventario realizada desde el modulo de inventario osea suma al inventario
                //3 es es la eliminacion del un item del inventario osea se suma al inventario porque vuelve 
                //5 es la reversion de una venta de mostrador
                
                /////////////2,4 y 6  son salidas y resta al inventario 
                //2 es una salida de inventario desde el modulo de inventarios osea resta del inventario
                //4 es un item agregado a una orden osea resta del inventario
                //6 es una venta de mostrador debe restar
                
                $cantidadActualCodigo =  $this->codigosModel->traerCantidadCodigoId( $data['id']);  
                // echo '<pre>'; 
                // print_r($cantidadActualCodigo); 
                // echo '</pre>';
                // die(); 
                
                $conexion = $this->connectMysql();
                
                if($data['tipo']==6)
                { 
                    $obseTipo= '';
                    $campo = 'id_factura_venta';
                }        
                
                if($data['tipo']==4)
                { 
                    $obseTipo= '';
                    $campo = 'facturacompra';
                }        
            
                if($data['tipo']==5)
                { 
                $obseTipo= '';
                $campo = 'facturacompra';
                }        

                if($data['tipo']==3)
                { 
                $obseTipo= '';
                $campo = 'facturacompra';
                }        
            
                if($data['tipo']==1)
                { 
                $obseTipo= 'Entrada Inventario';
                $campo = 'facturacompra';}
                
                if($data['tipo']==2){ 
                    $obseTipo = 'Salida  Inventario';
                    $campo = 'id_factura_venta';
                }
                
                $observaciones = $obseTipo.': '.$data['observaciones'];
                
                
                if($data['tipo']==1 || $data['tipo']==3 || $data['tipo']==5 ) //lo que suma al inventario
                {
                    $nuevoSaldo = $cantidadActualCodigo +  $request['cantidad'];
                }
                if($data['tipo']==2 || $data['tipo']==4 || $data['tipo']==6  ) //lo que resta al inventario 
                {
                    $nuevoSaldo = $cantidadActualCodigo -  $request['cantidad'];
                }
                
                
                
                $sql = "insert into movimientos_inventario 
                (fecha_movimiento,cantidad,tipo_movimiento,".$campo.",id_codigo_producto,observaciones
                ,cantidadAnterior,resultado)
                values( now(), '".$request['cantidad']."','".$data['tipo']."'
                ,'".$data['factura']."'
                ,'".$data['id']."'
                ,'".$observaciones."'
                ,'".$cantidadActualCodigo."'
                ,'".$nuevoSaldo."'
                ) "; 
                //  die($sql); 
                $consulta = mysql_query($sql,$conexion);  
                // echo '<br>Movimiento grabado';        
                $ultimoId = $this->traerIdUltimoMovimiento();
                return $ultimoId;
            }
            
            public function searchMovCode($idCode)
            {
                $conexion = $this->connectMysql();
            $sql = "select * from movimientos_inventario where id_codigo_producto = '".$idCode."'  order by fecha_movimiento asc ";
            $consulta = mysql_query($sql,$conexion);
            return $consulta;
        }
        
        public function traerIdUltimoMovimiento()
        {
            $sql = "select max(id_movimiento) as maximo from movimientos_inventario ";
            $consulta = mysql_query($sql,$this->connectMysql());  
            $arrMaxId = mysql_fetch_assoc($consulta); 
            $maximo = $arrMaxId['maximo']; 
            // die($maximo);
            return $maximo; 
        }
        public function traerMovimientosFecha($fecha)
        {
            $sql ="select * from movimientos_inventario where fecha_movimiento = '".$fecha."'  
            and anulado =  0 "; 
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());  
            $arrMovimientos = $this->get_table_assoc($consulta);
            return $arrMovimientos;
        }
        
        
        
    }
    
    
    ?>