
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
        </head>
        <body>
            <div id="div_principal_mostrar_ordenes_tecnico"  class="container col-lg-10">
                <div>
                    <img src="">
                    <h1>ORDENES DE TRABAJO </h1>
                </div>
                <div id="divBotonesPrincipales" style="padding:5px;">
                    
                    <button class="btn btn-primary" onclick="traerOrdenes();">Ordenes</button>
                    <button class="btn btn-primary" onclick="limpiarOrdenes();">Limpiar</button>
                    <button class="btn btn-primary" onclick="salirTecnico();">Salir</button>
                </div>
                <div id="resultaodosOrdenes" class="mt-3 container ">
                    <?php  
                            $this->traerOrdenes();  
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
         <table class="table table-striped">
            <tr>
                <th>Orden</th>
                <th>Pdf</th>
            </tr>
                <?php
                $ordenes = $this->variosModel->traerOrdenes();
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

}


?>