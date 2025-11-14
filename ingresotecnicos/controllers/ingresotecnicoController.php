<?php
session_start();
$ruta = dirname(dirname(dirname(__FILE__)));
require_once($ruta.'/ingresotecnicos/views/ingresotecnicosView.php');
require_once($ruta.'/ingresotecnicos/models/VariosModel.php');

class ingresoController
{
    protected $view;
    protected $variosModel;
    
    public function __construct()
    {
        // echo 'controlador'.$ruta;
        $this->view = new ingresotecnicosView();
        $this->variosModel = new VariosModel();
              if(!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario']==''  )
              {
                //salir del sistema
              }
          if(!isset($_REQUEST['opcion']) || $_REQUEST['opcion']=='traerOrdenes'){
             $this->view->pantallaPrincipal();
          }
          if($_REQUEST['opcion']=='salirTecnico'){
            session_destroy();
            // $this->view->pantallaLogueo();
          }
            if($_REQUEST['opcion']=='traerOrdenes'){
                $this->view->traerOrdenes();
            }
    }

}


?>