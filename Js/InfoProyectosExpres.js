$(document).ready(function() {

// $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
      $("#menu_p_proyExp").addClass("start active open");
    $("#menu_p_Consul_exp").addClass("active");
    
    $("#CbTipInf,#CbEstado").selectpicker();

    var chart;
    var legend;
    var selected;
    var types = [];
    var mapa, mapa1, latitud, longitud;

    $.extend({

        Alert: function(Id_Msg, Txt_Msg, Type_Msg, ico) {
            App.alert({
                container: Id_Msg, // alerts parent container(by default placed after the page breadcrumbs)
                place: "append", // append or prepent in container [append, prepend]
                type: Type_Msg, // alert's type [success, danger, warning, info]
                message: Txt_Msg, // alert's message
                close: true, // make alert closable [true, false]
                reset: true, // close all previouse alerts first [true, false]
                focus: true, // auto scroll to the alert after shown [true, false]
                closeInSeconds: "5", // auto close after defined seconds [0, 1, 5, 10]
                icon: ico // put icon before the message [ "" , warning, check, user]
            });
        },
        HabInf: function(op) {

            if (op === "1") {
                $('#DivCbEstado').show();
            } else {
                
                $('#DivCbEstado').hide();
            }

        },
        Consultar: function() {
            var op = $("#CbTipInf").val();

            if (op === "1" || op === "2" || op === "3") {
                $.Graficar1(op);
                $('#GrafProy').show();
            } else if (op === "G") {

                $('#GeoProy').show();
                $.MostrarMap();
            } else if (op === " ") {
                $.Alert("#msg", "Por Favor Seleccione un tipo de informe...", "warning", 'warning');
                return;
            } else {
                var CbProy = $("#CbProy").val();
                if (CbProy === " ") {

                    CbProy = $("#CbProy").val();
                    var datos = {
                        ope: "ConsulProyec",
                        CbProy: trimAll(CbProy),
                        CbSecr: trimAll($("#CbSecre").val()),
                        CbEje: trimAll($("#CbEje").val()),
                        CbComp: trimAll($("#CbComp").val()),
                        CbProg: trimAll($("#CbProg").val())
                    };
                    $.ajax({
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        dataType: 'JSON',
                        success: function(data) {
                            $("#tb_proyectos").html(data['CadProy']);
                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });
                    $('#botonesExcel').show();
                    $('#ListProy').show();
                    $('#GrafProy').hide();
                } else {
                    $.Graficar2();
                    $('#GrafProy').show();
                    $('#botonesExcel').hide();
                    $('#ListProy').hide();
                    $('#btn_volver').hide();
                }
            }
        },
        VolverList: function() {
            $('#GrafProy').hide();
            $('#ListProy').show();
            $('#btn_volver').hide();
        },
        Limpiar: function() {
            $("#CbSecre").select2("val", " ");
            $("#CbEje").select2("val", " ");
            $("#CbComp").select2("val", " ");
            $("#CbProg").select2("val", " ");
            $("#CbProy").select2("val", " ");
            $("#CbComp").prop('disabled', true);
            $("#CbProg").prop('disabled', true);
            $('#GrafProy').hide();
            $('#ListProy').hide();
            $('#btn_volver').hide();
            $('#botonesExcel').hide();
        }

    });

    $("#btn_Excel").click(function() {
        CbEstado = $("#CbEstado").val();
        CbTipInf = $("#CbTipInf").val();
        window.open("../Informes/ExcelContratosExpres.php?CbEstado=" + CbEstado+ "&CbTipInf=" + CbTipInf);

    });

});
///////////////////////
