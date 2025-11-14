
function traerOrdenes()
{
    const http=new XMLHttpRequest();
    const url = '../ingresotecnicos/ingresotecnicos.php';
    // alert('Anterior'+ placaAnterior + '  nueva '+ placaNueva )
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("div_principal_mostrar_ordenes_tecnico").innerHTML = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=traerOrdenes"
    );
}


function salirTecnico()
{

    // var user =  document.getElementById("usuario").value;
    // var clave =  document.getElementById("clave").value;
    // alert(user+clave);
    const http=new XMLHttpRequest();
    const url = '../ingresotecnicos/ingresotecnicos.php';
    // alert('Anterior'+ placaAnterior + '  nueva '+ placaNueva )
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("resultaodosOrdenes").innerHTML = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=salirTecnico"
    // + "&user="+user
    // + "&clave="+clave
   
    );
}


function limpiarOrdenes()
{
    // alert('limpiar');
            document.getElementById("resultaodosOrdenes").innerHTML = ' ';
}



// function pantallaOrdenesTecnicos(){
//     const http=new XMLHttpRequest();
//     const url = '../orden/ordenes.php';
//     http.onreadystatechange = function(){
//         if(this.readyState == 4 && this.status ==200){
//            document.getElementById("div_principal").innerHTML  = this.responseText;
//         }
//     };
//     http.open("POST",url);
//     http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     http.send('opcion=ordenes'
//     );
// }
