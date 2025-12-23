
<?php
require_once($ruta.'/ingresotecnicos/models/VariosModel.php');
class ingresotecnicosView
{
    protected $variosModel;

    public function __construct()
    {
           $this->variosModel =   new VariosModel();
    }

    public function pantallaPrincipal()
    {
        // echo '<pre>'; print_r($_SESSION);   echo '</pre>';die();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
             <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <link rel="stylesheet" href="../ingresotecnicos/css/estilostecnicos.css">
        </head>
        <!-- <body style="background-color: black; color: white;" > -->
        <body class="fondoprograma">
            <div id="div_principal_mostrar_ordenes_tecnico"  class="container col-lg-10" >
                <div>
                    <img src="">
                    <h3>ORDENES DE TRABAJO </h3>
                </div>
                <div id="divBotonesPrincipales" style="padding:5px;">
                    
                    <button class="btn btn-primary" onclick="traerOrdenesTecnico();">Ordenes</button>
                    <button class="btn btn-primary" onclick="limpiarOrdenes();">Limpiar</button>
                    <button class="btn btn-primary" onclick="salirTecnico();">Salir</button>
                </div>
                <div id="resultaodosOrdenes" class="mt-3 container ">
                    <?php  
                            // $this->traerOrdenes();  
                    ?>
                    <!-- <button onclick="pantallaOrdenesTecnicos();">Ver Ordenes</button> -->
                </div>
            </div>
            
        </body>
        </html>
                 <script src="../ingresotecnicos/js/ingresotecnicos.js"></script>
        <?php
    } 
    
    public function traerOrdenes()
    {
        ?>
         <table class="table table-striped" >
            <tr>
                <th>Orden</th>
                <th>Pdf</th>
            </tr>
                <?php
                $ordenes = $this->variosModel->traerOrdenesUsuarioEnProceso();
                foreach($ordenes as $orden )
                {
                    echo '<tr>'; 
                    echo '<td>'.$orden['orden'].'</td>';
                    echo '<td><a href="../orden/pdf/ordenPdf3.php?idOrden='.$orden['id'].'"  target="_blank">Pdf</a></td>';
                    echo '</tr>';
                }
                ?>
        </table>
        <?php
    }
    public function traerOrdenesTecnico($idTecnico)
    {
        ?>
         <table class="table table-striped">
            <tr>
                <th>Orden</th>
                <th>Pdf</th>
                <th>Fecha</th>
                <th>Placa</th>
                <th>Linea</th>
                <th>Observaciones</th>
                <th>Estado</th>
            </tr>
                <?php
                $ordenes = $this->variosModel->traerOrdenesUsuarioEnProceso($idTecnico);
            
                foreach($ordenes as $orden )
                {
                    $infoCarro = $this->variosModel->traerInfoCarroPlaca($orden['placa']);
                    $infoEstado = $this->variosModel->traerInfoEstado($orden['estado']);
                    echo '<tr>'; 
                    echo '<td>'.$orden['orden'].'</td>';
                    echo '<td><a href="../orden/pdf/ordenPdf3.php?idOrden='.$orden['id'].'"  target="_blank"><i class="fas fa-file-pdf"></i></a></td>';
                    echo '<td>'.$orden['fecha'].'</td>';
                    echo '<td>'.$orden['placa'].'</td>';
                    echo '<td>'.$infoCarro['tipo'].'</td>';
                    echo '<td>'.$orden['observaciones'].'</td>';
                    echo '<td>'.$infoEstado['descripcion_estado'].'</td>';
                    echo '</tr>';
                }
                ?>
        </table>
        <?php
    }

}


?>