<?php
$raiz = dirname(dirname(__file__));
// echo $raiz;
// die();
// require_once($raiz.'/models/ProductosKaymoShopModel.php');
require_once($raiz.'/views/kaymoShopView.php');

class kaymoShopController
{
    protected $modelProduct;
    protected $vistaKaymoShop;
    public function __construct()
    {
            // $this->modelProduct = new ProductosKaymoShopModel();
            $this->vistaKaymoShop = new kaymoShopView();
            if(!isset($_REQUEST['opcion']))
            {
                $this->vistaKaymoShop->pantallaPrincipal(); 
            }
    }

    // public function mostrarProdutos()
    // {
    //     $productos = $this->modelProduct->traerCodigos();
    //     echo 'despues de traer productos ';
    // }


}




?>