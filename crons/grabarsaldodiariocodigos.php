<?php
date_default_timezone_set('America/Bogota');
$fechapan =  time();
$fechapan =  date ( "Y/m/j" , $fechapan );
try {
    # Conexión a MySQL
    // $cnn = new PDO("mysql:host=localhost;dbname=prueba123", "root", "");
    $cnn = new PDO("mysql:host=localhost;dbname=ctwtvsxj_base_demo2_speed_desing", "ctwtvsxj_admin", "ElMejorProgramador***");
    $respuesta = $cnn->prepare("select * from productos");
    $respuesta->execute();

    foreach($respuesta as $res){
		//Llenamos la data en el array
	    // $usuarios[]=$res;
        // echo '<br>'.$res['placa'];

        ///////////////////

        $stmt = $cnn->prepare("INSERT INTO saldosfinalesCodigos (fecha,id_codigo,saldo) 
        VALUES (:fecha,:id_codigo,:saldo)");
        $stmt->bindParam(':fecha',$fechapan);
        $stmt->bindParam(':id_codigo',$res['id_codigo']);
        $stmt->bindParam(':saldo',$res['cantidad']);
        $stmt->execute();

        //////////////////
	}
    // $sql="insert into recetas (titulo) values('receta1234')";
    // $respuesta2 = $cnn->prepare($sql);
    // $respuesta2->execute();


}
  catch(PDOException $e) {
      echo $e->getMessage();
  }
?>