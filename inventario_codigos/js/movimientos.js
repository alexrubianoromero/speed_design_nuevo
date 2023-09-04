// function verMovimientosCodigos()
// {
//     // alert('buenas desde js');
//         const http=new XMLHttpRequest();
//     const url = '../inventario_codigos/movimientosInventario.php';
//     http.onreadystatechange = function(){
//         if(this.readyState == 4 && this.status ==200){
//             document.getElementById("cuerpoModalMovimientos").innerHTML = this.responseText;
//         }
//     };

//     http.open("POST",url);
//     http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     http.send();

// }

function verMovimientosPrueba(idCode)
{
    const http=new XMLHttpRequest();
    const url = '../inventario_codigos/movimientosInventarioPrueba.php';
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("cuerpoModalMovimientos").innerHTML = this.responseText;
        }
    };

    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=mostrarMovimientos"
               + "&idCode="+idCode
             );
}
function verificacionMovimientosInventario()
{
    // alert('verificacion');

    const http=new XMLHttpRequest();
    const url = '../inventario_codigos/movimientosInventarioPrueba.php';
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("cuerpoModalVerificarInventario").innerHTML = this.responseText;
        }
    };

    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=verificacionMovimientosInventario"
            //    + "&idCode="+idCode
             );
}

function verificarMovimientosFecha()
{
    // alert('verificacion');
    var fechaVerificacion = document.getElementById("fechaVerificacion").value;
    const http=new XMLHttpRequest();
    const url = '../inventario_codigos/movimientosInventarioPrueba.php';
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("divResultadosVerificacionMovimientos").innerHTML = this.responseText;
        }
    };

    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=verificarMovimientosFecha"
               + "&fechaVerificacion="+fechaVerificacion
             );
}

