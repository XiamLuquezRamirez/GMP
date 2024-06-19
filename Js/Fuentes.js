$(document).ready(function () {
    $(".clasesCombos").selectpicker();
    $("#fecha").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });
    $('#tab_Secre').on("click", ".btnPresupuestar", function (e) {
        e.preventDefault();
        var id_secretaria = $(this).data('id');
        $("#nomSecretaria").html($(this).data('nombre'));
        $("#id_secretaria").val(id_secretaria);
        $("#fuente").val();
        $("#From_Fuente").removeClass("has-error");
        $("#fecha").val("");
        $("#From_Fecha").removeClass("has-error");
        $("#valor").val("");
        $("#From_Valor").removeClass("has-error");
        $("#msgAgrePre").html("");
        var datos = {
            id_secretaria: id_secretaria,
            OPCION: 'CONSULTAR'
        }
        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarPresupuestar.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                $("#detalle_presupuestar").html("");
                if (data.TIENE === 1) {
                    for (var i = 1; i <= data.tam; i++) {
                        
                        agregar(data.presupuestar.IDSP[i], data.presupuestar.IDSECRE[i], data.presupuestar.IDFUENTE[i],data.presupuestar.IDSUBFUENTE[i], data.presupuestar.FUENTE[i],data.presupuestar.SUBFUENTE[i], data.presupuestar.FECHA[i], data.presupuestar.VALOR[i]);
                   
                    }
                } else {
                    $("#detalle_presupuestar").html("");
                    $("#txtTotal").val("");
                }
                if (data.TIENE2 === 1) {
                    $("#detalle_grantotal").html("");
                    for (var i = 1; i <= data.tam2; i++) {
                        agregar2(data.grantotal.FUENTE[i], data.grantotal.VALOR[i],data.grantotal.SUBFUENTE[i],);
                    }
                } else {
                    $("#detalle_grantotal").html("");
                }
                Buscar2($("#detalle_presupuestar"));
                Buscar3($("#detalle_grantotal"));
                recorrerTabla2($("#detalle_grantotal"));
            },
            error: function (error_messages) {

            }
        });
                $("#modalPresupuestar").modal({backdrop: 'static', keyboard: false});

    });

    function listar() {
        var id_secretaria = $("#id_secretaria").val();
        $("#From_Fuente").removeClass("has-error");
        $("#fecha").val("");
        $("#From_Fecha").removeClass("has-error");
        $("#valor").val("");
        $("#From_Valor").removeClass("has-error");
        $("#msgAgrePre").html("");
        var datos = {
            id_secretaria: id_secretaria,
            OPCION: 'CONSULTAR'
        }
        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarPresupuestar.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                $("#detalle_presupuestar").html("");
                if (data.TIENE === 1) {
                    for (var i = 1; i <= data.tam; i++) {
                        agregar(data.presupuestar.IDSP[i], data.presupuestar.IDSECRE[i], data.presupuestar.IDFUENTE[i],data.presupuestar.IDSUBFUENTE[i], data.presupuestar.FUENTE[i],  data.presupuestar.SUBFUENTE[i], data.presupuestar.FECHA[i], data.presupuestar.VALOR[i]);
                    }
                } else {
                    $("#detalle_presupuestar").html("");
                    $("#txtTotal").val("");
                }
                if (data.TIENE2 === 1) {
                    $("#detalle_grantotal").html("");
                    for (var i = 1; i <= data.tam2; i++) {
                        agregar2(data.grantotal.FUENTE[i], data.grantotal.VALOR[i],data.grantotal.SUBFUENTE[i],);
                    }
                } else {
                    $("#detalle_grantotal").html("");
                }
                Buscar2($("#detalle_presupuestar"));
                Buscar3($("#detalle_grantotal"));
                recorrerTabla2($("#detalle_grantotal"));
            },
            error: function (error_messages) {

            }
        });
    }

    $("#valor").on({
        change: function (e) {
            var num = accounting.formatMoney($(this).val(), "$", 2, ",", ".");
            // var num = new Intl.NumberFormat('es-CO').format($(this).val());
            $(this).val(num);
        }
    });

    $(".btnAgregar").on({
        click: function (e) {
            e.preventDefault();
            var Op_Validar = [];
            var Op_Vali = "Ok";
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#id_secretaria";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
            } else {
                Op_Validar.push("Ok");
            }

            Id = "#fuente";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Fuente").addClass("has-error");
            } else {
                $("#From_Fuente").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#subfuente";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Subfuente").addClass("has-error");
            } else {
                $("#From_Subfuente").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#fecha";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Fecha").addClass("has-error");
            } else {
                $("#From_Fecha").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#valor";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Valor").addClass("has-error");
            } else {
                $("#From_Valor").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);
            if (Op_Vali === "Fail") {
                $.Alert("#msgAgrePre", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
                return;
            }
            $("#msgAgrePre").html("");

            var id = 0;
            var id_secre = $("#id_secretaria").val();
            var id_fue = $("#fuente").val();
            var id_subfue = $("#subfuente").val();
            var fuente = $('#fuente option:selected').html();
            var subfuente = $('#subfuente option:selected').html();
            var fecha = $("#fecha").val();
            var valor = $("#valor").val();
            $("#fecha,#valor").val("");
            agregar(id, id_secre, id_fue,id_subfue, fuente,subfuente, fecha, valor);
        }
    });
    function agregar(id, id_secre, id_fue,id_subfue, fuente, subfuente, fecha, valor) {
        var campo = "";
        campo += "<tr data-id='" + id + "'>";
        campo += "<td>";
        campo += "<input type='hidden' name='txtid[]' id='txtid' value='" + id + "'><input type='hidden' name='txtidSec' id='txtidSec' value='" + id_secre + "'>";
        campo += "<input type='hidden' name='txtid_secretaria[]' id='txtid_secretaria' value='" + id_secre + "'>";
        campo += "<input type='hidden' name='txtid_fuente[]' id='txtid_fuente' value='" + id_fue + "'>";
        campo += "<input type='hidden' name='txtid_subfuente[]' id='txtid_subfuente' value='" + id_subfue + "'>";
        campo += "<input type='text' class='form-control' readonly name='txtfuente[]' id='txtfuente' style='background-color:white;' value='" + fuente + "'>";
        campo += "</td>";
        campo += "<td>";
        campo += "<input type='text' class='form-control' readonly name='txtsubfuente[]' id='txtsubfuente' style='background-color:white;' value='" + subfuente + "'>";
        campo += "</td>";
        campo += "<td>";
        campo += "<input type='text' class='form-control' readonly name='txtfecha[]' id='txtfecha' style='background-color:white;' value='" + fecha + "'>";
        campo += "</td>";
        campo += "<td>";
        campo += "<input type='text' class='form-control' readonly name='txtvalor[]' id='txtvalor' style='background-color:white;text-align:right;' value='" + valor + "'>";
        campo += "</td>";
        campo += "<td style='text-align:center;'>";
        campo += "<a href='javascript:void(0);' class='btn btn-danger btn-sm btnEliminar' title='Eliminar' ><i class='fa fa-trash-o'></i></a>";
        campo += "</td>";
        campo += "</tr>";
        $("#detalle_presupuestar").append(campo);
        recorrerTabla($("#detalle_presupuestar"));
    }
    function agregar2(fuente, valor,subfuente) {
        var campo = "";
        campo += "<tr>";
        campo += "<td>";
        campo += "<input type='text' class='form-control' readonly name='txtfuente[]' id='txtfuente' style='background-color:white;font-weight:bold;' value='" + fuente + "'>";
        campo += "</td>";
        campo += "<td>";
        campo += "<input type='text' class='form-control' readonly name='txtsubfuente[]' id='txtsubfuente' style='background-color:white;font-weight:bold;' value='" + subfuente + "'>";
        campo += "</td>";
        campo += "<td>";
        campo += "<input type='text' class='form-control' readonly name='txtvalor[]' id='txtvalor' style='background-color:white;text-align:right;font-weight:bold;' value='" + valor + "'>";
        campo += "</td>";
        campo += "</tr>";
        $("#detalle_grantotal").append(campo);
    }
    $("#detalle_presupuestar").on("click", '.btnEliminar', function (e) {
        e.preventDefault();
        if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
            var fila = $(this).parents('tr');
            var id = fila.data('id');
            
            if (id !== 0) {
                $(this).closest('tr').remove();
            } else {

            }
            recorrerTabla($("#detalle_presupuestar"));
        }
    });
    
    $("#btnGuardar").on({
        click: function (e) {
            e.preventDefault();
            var tam = $("#detalle_presupuestar tr").length;
            if (tam <= 0) {
                $.Alert("#msgAgrePre", "Por Favor Agregue Por Lo Menos Una Fila a La Tabla...", "warning", "warning");
                return;
            }
            $("#msgAgrePre").html("");
            var form = $("#formPresupuestar");
            Buscar($("#detalle_presupuestar"));
            var datos = form.serialize();
            $.ajax({
                type: "POST",
                url: "../Administracion/GuardarPresupuestar.php",
                data: datos,
                success: function (data) {
                    if ($.trim(data) === "bien") {
                        $.Alert("#msgAgrePre", "Datos Guardados Exitosamente...", "success", "check");
                        $("#fecha").val("");
                        $("#valor").val("");
                        listar();
                    } else {
                        alert('Datos no guardados');
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

    function recorrerTabla(tabla) {
        var suma = 0;
        var filas = tabla.find("tr");
        for (var i = 0; i < filas.length; i++) {
            var celdas = $(filas[i]).find("td");
        
            var valor = $($(celdas[3]).children("input")[0]).val();
          
            valor = accounting.unformat("$ " + valor);
            suma = suma + valor;
        }
        suma = accounting.formatMoney(suma, "$", 2, ",", ".");
       
        $("#txtTotal").val(suma);
        return true;
    }

    function recorrerTabla2(tabla) {
        var suma = 0;
        var filas = tabla.find("tr");
        for (var i = 0; i < filas.length; i++) {
            var celdas = $(filas[i]).find("td");
            var valor = $($(celdas[2]).children("input")[0]).val();
             
            valor = accounting.unformat("$ " + valor);
            suma = suma + valor;
        }
        suma = accounting.formatMoney(suma, "$", 2, ",", ".");
        $("#txtTotal2").val(suma);
        return true;
    }

    function Buscar(tabla) {
        var suma = 0;
        var filas = tabla.find("tr");
        for (var i = 0; i < filas.length; i++) {
            var celdas = $(filas[i]).find("td");
            
            var valo = accounting.unformat("$ " + $($(celdas[3]).children("input")[0]).val());
            $($(celdas[3]).children("input")[0]).val(valo);
        }
        return true;
    }
    function Buscar2(tabla) {
        var suma = 0;
        var filas = tabla.find("tr");
        for (var i = 0; i < filas.length; i++) {
            var celdas = $(filas[i]).find("td");
            
            var valo = $($(celdas[3]).children("input")[0]).val();
            valo = accounting.formatMoney(valo, "$", 2, ",", ".");
            $($(celdas[3]).children("input")[0]).val(valo);
        }
        return true;
    }

    function Buscar3(tabla) {
        var suma = 0;
        var filas = tabla.find("tr");
        for (var i = 0; i < filas.length; i++) {
            var celdas = $(filas[i]).find("td");
           
            var valo = $($(celdas[2]).children("input")[0]).val();
            valo = accounting.formatMoney(valo, "$", 2, ",", ".");
            $($(celdas[2]).children("input")[0]).val(valo);
        }
        return true;
    }
    $.extend({

    });

});

function check(e) {
    var key = (document.all) ? e.keyCode : e.which;
    var tecla = String.fromCharCode(key).toLowerCase();
    //        var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    var letras = "0123456789.";
    var especiales = "8-37-39-46";

    var tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}