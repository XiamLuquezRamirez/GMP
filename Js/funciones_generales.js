function ObjetoAjax(){
    var xmlhttp=false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch (E) {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function validartxt(e) {
    tecla = e.which || e.keyCode;
    patron =/[a-zA-Z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF\s]+$/;
    te = String.fromCharCode(tecla);
    return (patron.test(te) || tecla == 9 || tecla == 8 || tecla == 37 || tecla == 39 || tecla == 46);
}

function validartxtnum(e) {
    tecla = e.which || e.keyCode;
    patron =/[0-9]+$/;
    te = String.fromCharCode(tecla);
    //    if(e.which==46 || e.keyCode==46) {
    //        tecla = 44;
    //    }
    return (patron.test(te) || tecla == 9 || tecla == 8 || tecla == 37 || tecla == 39 || tecla == 44);
}

function validartxtval(e) {
    tecla = e.which || e.keyCode;
    patron =/[0-9\u002C]+$/;
    te = String.fromCharCode(tecla);
    return (patron.test(te) || tecla==9 || tecla==8 || tecla==37 || tecla==39 || tecla==46);
}

function validarEmail(valor) {
    re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/
    if (valor!=""){
        if(!re.exec(valor)){
            alert("Correo Inv\xe1lido.");
            document.getElementById("txtemail").value="";
            document.getElementById("txtemail").focus();
        }
    }
}

function trimAll(cadena){
    if(cadena != ""){
        var sinesp = cadena;
        var re = /\s/g;
        if(cadena.search(re) != -1){
            sinesp = cadena.replace(re,"");
        }
        return sinesp;
    }
}



var nav4a = window.Event ? true : false;
function acceptNumDecim(evt){    
// NOTE: Backspace=8, tab=9, Enter=13, '0'=48, '9'=57, comma=188, decimal point=110
var key = nav4a ? evt.which : evt.keyCode;    
return (key==8 || key == 13 || (key >= 48 && key <= 57) || key==46 || key==44);
}


///FORMATO MONEDA NUMERO

function number_format2(a, b, c, d)
{
    //a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
    e = a + '';
    f = e.split(',');
    frase=f[0];
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    frase=frase.replace('.','');
    f[0]=frase;
    if (!f[0]) {
        f[0] = '0';
    }
    if (!f[1]) {
        f[1] = '';
    }
    if (f[1].length < b) {
        g = f[1];
        for (i=f[1].length + 1; i <= b; i++) {
            g += '0';
        }
        f[1] = g;
    }
    if(d != '' && f[0].length > 3) {
        h = f[0];
        f[0] = '';
        for(j = 3; j < h.length; j+=3) {
            i = h.slice(h.length - j, h.length - j + 3);
            f[0] = d + i + f[0] + '';
        }
        j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
        f[0] = j + f[0];

    }
    c = (b <= 0) ? '' : c;
    if(f[1]>99){
        var numero = "0."+f[1];
        numero = String(Math.round(numero*100)/100);
        v = numero.split('.');
        return f[0] + c + v[1];
    }else{
        return f[0] + c + f[1];
    }


}
//////////////////////////////////////////////////////////////////////////////

//FORMATEAR TEXTO A MONEDA
function textm(txt, id) {

    if (document.getElementById(id).value == '') {
        document.getElementById(id).value = '$ 0,00'
         
    } else {
        par = txt.split(" ");
       
        if (par[0] == "$") {
            document.getElementById(id).value = "$ " + number_format2(par[1], 2, ',', '.');
        } else {
            document.getElementById(id).value = "$ " + number_format2(txt, 2, ',', '.');
        }

    }
    
//   valorletras('1',id);
}
//FORMATEAR TEXTO A MONEDA
function textCump(txt, id) {
    if (document.getElementById(id).value === '') {
        document.getElementById(id).value = '$ 0,00'
         
    } else {
        par = txt.split(" ");
       
        if (par[0] === "$") {
            document.getElementById(id).value = "$ " + number_format2(par[1], 2, ',', '.');
        } else {
            document.getElementById(id).value = "$ " + number_format2(txt, 2, ',', '.');
        }

    }

    
//   valorletras('1',id);
}

function valorletras(op, id) {
    para = document.getElementById(id).value.split(" ");
    var numero = para[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
    //var numero=number_format2(document.getElementById(id).value, 2, ',', '');
    var par = numero.split(".");

    if (numero != '' && numero != null && numero != ' ') {
        var datos = {
            num1: par[0],
            num2: par[1]
        }

        $.ajax({
            type: "POST",
            url: "../num_letra",
            data: datos,
            success: function (data) {
                if (data == "bien") {

                }
            }
        });
    }

}

//function valorletras(op,id){
//    para=document.getElementById(id).value.split(" ");
//    var numero=para[1].replace(".","").replace(".","").replace(",",".");
//    //var numero=number_format2(document.getElementById(id).value, 2, ',', '');
//    var par=numero.split(".");
//
//    if(numero!='' && numero!=null && numero!=' '){
//        ajax=ObjetoAjax();
//        ajax.open("POST", "../num_letra", true);
//        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//        ajax.send("num1="+par[0]+ "&num2=" +par[1]);        
//        ajax.onreadystatechange=function(){
//            if (ajax.readyState==4){
//                if(op=='1'){
//                    divContenido = document.getElementById('valetra');
//                    divContenido.innerHTML = '<p style="color: #333333; font-size: 10pt; font-weight: bold; text-shadow: none;">'+ajax.responseText+'</p>';
//                }
//            }
//        }
//        ajax.send(null);
//    }else{
//        if(op=='1'){
//            divContenido = document.getElementById('valetra');
//            divContenido.innerHTML ='<p style="color: #333333; font-size: 10pt; font-weight: bold; text-shadow: none;">CERO PESOS</p>';
//
//        }
//        return;
//    }
//}
