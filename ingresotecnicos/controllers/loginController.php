<?php
$ruta = dirname(dirname(dirname(__FILE__)));
require_once($ruta.'/ingresotecnicos/views/loginView.php');
require_once($ruta.'/ingresotecnicos/models/VariosModel.php');

class loginController
{
    protected $loguinView;
    protected $variosModel;

     public function __construct()
    {
        $this->loguinView = new loginView();
        $this->variosModel = new VariosModel();
         if(!isset($_REQUEST['opcion'])){
             $this->pantallaLogueo();
          }
           else{

               if($_REQUEST['opcion']=='verificarCredenciales'){
                    $this->verificarCredenciales($_REQUEST); 
                }
            }
    }

    public function pantallaLogueo()
    {
        $this->loguinView->pantallaLogueo();
    }

     public function verificarCredenciales($request)
    {
        $respu = $this->variosModel->verificarCredencialesTecnicos($request);
        if($respu['valida']==1)
        {
            session_start();
            $_SESSION['login'] = $respu['datos']['login'];
            $_SESSION['id_usuario'] = $respu['datos']['id_usuario'];
            $_SESSION['id_perfil'] = $respu['datos']['id_perfil'];
        }
        echo  json_encode($respu);
        exit();
    }



}    