function verificarCredenciales()
{
    var user =  document.getElementById("usuario").value;
    var clave =  document.getElementById("clave").value;
    // alert(user+clave);
    const http=new XMLHttpRequest();
    const url = '../ingresotecnicos/index.php';
    // alert('Anterior'+ placaAnterior + '  nueva '+ placaNueva )
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
              var  resp = JSON.parse(this.responseText);
            //   alert(resp.datos.idTecnico);
              if(resp.valida == 1 ){
                  localStorage.setItem('usuario', resp.datos.login);
                  localStorage.setItem('id_usuario', resp.datos.id_usuario);
                  localStorage.setItem('idTecnico', resp.datos.idTecnico);
                  localStorage.setItem('token', resp.token);
                //    window.location.href = resp.linkMenu+'?idTecnico='+resp.datos.idTecnico;
                   window.location.href = resp.linkMenu;
                //   window.location.href = "https://www.alexrubiano.com/speed_design_nuevo/ingresotecnicos/ingresotecnicos.php";
                }else {
                //   window.location.href = "https://www.alexrubiano.com/speed_design_nuevo/ingresotecnicos/index.php";
                 window.location.href = resp.linkLogueo;
                    
              }
            // document.getElementById("div_principal_ingresotecnicos").innerHTML = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=verificarCredenciales"
    + "&user="+user
    + "&clave="+clave
   
    );
}