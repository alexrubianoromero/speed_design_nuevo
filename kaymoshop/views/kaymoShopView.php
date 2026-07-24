
<?php
$raiz = dirname(dirname(__file__));
// echo $raiz;
// die();
require_once($raiz.'/models/ProductosKaymoShopModel.php');
// require_once($raiz.'/models/EmpreShopModel.php');


class kaymoShopView
{
    protected $modelProduct;
    public function __construct()
    {
        $this->modelProduct = new ProductosKaymoShopModel();
    }

    public function  pantallaPrincipal()
    {
        $infoEmpresa =  $this->modelProduct->traerEmpresaShop(); 
        // echo '<pre>'; 
        // print_r($infoEmpresa);
        // echo '</pre>';
        // die('pantalla');
      ?>
            <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        /* RESET TOTAL PARA EVITAR ERRORES */
                        * { box-sizing: border-box; }
                        body { 
                            background-color: #000000; 
                            color: #ffffff; 
                            font-family: sans-serif; 
                            margin: 0; 
                            padding: 0; 
                        }

                        header {
                            background: #111;
                            padding: 20px;
                            text-align: center;
                            border-bottom: 2px solid red;
                            font-weight: bold;
                            font-size: 22px;
                        }

                        .catalog { padding: 15px; }

                        /* LA TARJETA DEL PRODUCTO */
                        .producto {
                            background: #111;
                            border: 1px solid #333;
                            margin-bottom: 10px;
                            border-radius: 8px;
                            cursor: pointer;
                        }

                        /* AREA DEL NOMBRE (Siempre visible) */
                        .nombre-precio {
                            padding: 15px;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        }

                        .nombre-precio h3 { margin: 0; font-size: 16px; }
                        .precio { color: red; font-weight: bold; }

                        /* AREA DE LA IMAGEN (Oculta por defecto) */
                        .detalles {
                            display: none; /* ESTO ES LO QUE CAMBIA AL HACER CLIC */
                            padding: 15px;
                            background: #050505;
                            text-align: center;
                            border-top: 1px solid #222;
                        }

                        .foto {
                            width: 100%;
                            max-width: 400px;
                            border-radius: 5px;
                            margin-bottom: 15px;
                        }

                        .btn-pedir {
                            background: red;
                            color: white;
                            text-decoration: none;
                            padding: 12px;
                            display: block;
                            border-radius: 5px;
                            font-weight: bold;
                        }
                    </style>
                </head>
                <body>
                    <header><?php  echo $infoEmpresa['razon_social'].' ' ?><span style="color:red">SHOP</span></header>

                    <?php  $this->menuProductos();  ?>

                    <script>
                        function mostrarFoto(elemento) {
                            // Buscamos la sección de detalles dentro del elemento clickeado
                            var detalles = elemento.querySelector('.detalles');
                            
                            // Si está oculto lo muestra, si no lo oculta
                            if (detalles.style.display === "block") {
                                detalles.style.display = "none";
                            } else {
                                detalles.style.display = "block";
                            }
                        }
                    </script>

                </body>
                </html>
      <?php
    }

    public function menuProductos()
    {
        $productos = $this->modelProduct->traerCodigos();
        // echo 'despues de traer productos ';
        $this->mostrarCodigos($productos);
    }

    public function mostrarCodigos($codigos){
        echo '<div class="catalog">';

        foreach($codigos as $codigo)
        {
            ?>
                                <div class="producto" onclick="mostrarFoto(this)">
                                    <div class="nombre-precio">
                                        <div class="info">
                                            <h3><?php echo $codigo['referencia']  ?></h3>
                                            <span class="precio"><?php echo number_format($codigo['valorventa'], 0, ',', ' ')  ?></span>
                                        </div>
                                        <small style="color:#666">VER FOTO ▼</small>
                                    </div>
                                    
                                    <div class="detalles">
                                        <img src="https://via.placeholder.com/400x250/222/ff0000?text=KAYMO+REPUESTO" class="foto">
                                        <a href="https://wa.me/573124551226" class="btn-pedir">PEDIR POR WHATSAPP</a>
                                    </div>
                                </div>
                                <?php
            }
            echo '</div>';
      
    }



}



