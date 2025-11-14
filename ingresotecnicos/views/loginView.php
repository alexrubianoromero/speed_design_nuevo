<?php
require_once($ruta.'/ingresotecnicos/models/VariosModel.php');
class loginView
{

    public function pantallaLogueo()
    {
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
            <div id="div_principal_ingresotecnicos"class="contaniner" style="padding:10px;" align="center">
                <div class="row col-lg-4  mt-3">
                    <div>SISTEMA CONTROL ORDENES DE REPARACION </div>
                    <div class="col-lg-12 mt-3">
                        <label>Usuario:</label>
                        <input type="text" id="usuario" class="form-control">
                    </div>
                    <div class="col-lg-12 mt-3">
                        <label>Clave:</label>
                        <input type="password" id="clave" class="form-control">
                    </div>
                    <div class="mt-3 text-center">
                        <button class="btn btn-primary " onclick="verificarCredenciales();">Verificar</button>
                    </div>
                </div>  
            </div>
            
        </body>
        </html>
           <script src="../ingresotecnicos/js/login.js"></script>

        <?php
    }

}