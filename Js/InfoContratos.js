$(document).ready(function () {
    verProyectos();
    var tipoInforme = "TODOS";
    $("#cmbTipo").selectpicker();
    $("#btnContratos").on({
        click: function (e) {
            e.preventDefault();
            var busqueda = '';
            VerContratos(busqueda);
            $("#busqueda").val("");
            $("#modalContratos").modal("show");
        }
    });
    $("#btnBusCon").on({
        click: function (e) {
            e.preventDefault();
            var busqueda = $("#busqueda").val();
            VerContratos(busqueda);
        }
    });
    $('#contenidoContratos').on("click", ".selContrato", function (e) {
        e.preventDefault();
        $("#contenidoEvolucion").html("");
        $("#num_contrato,#obj_contrato").val("");
        var fila = $(this).parents('tr');
        $("#num_contrato").val(fila.data('num'));
        $("#obj_contrato").val(fila.data('obj'));
        $("#modalContratos").modal("hide");
    });


    $("#btnConsultar").on({
        click: function (e) {
            e.preventDefault();
            if (tipoInforme === "INDIVIDUAL") {
                if ($("#num_contrato").val() === "") {
                    $.Alert("#msgEvoCon", "Por favor seleccione el contrato", "warning", 'warning');
                    $("#num_contrato").focus();
                    return false;
                }
                var datos = {
                    OPCION: 'CONSULTAREVOLUCIONES',
                    num_contrato: $("#num_contrato").val(),
                    tipoInforme: tipoInforme
                }
                $.ajax({
                    type: "POST",
                    url: "../Informes/EvolucionContratos.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data["Op"] === "Existe") {
                            $("#contenidoEvolucion").html("");
                            if (data['tam'] >= 1) {
                                for (var i = 1; i <= data['tam']; i++) {
                                    campo = "";
                                    campo += "<tr>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;'>" + i + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:right;'>" + Vacio(data.contrato.vadic_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:right;'>" + Vacio(data.contrato.vfin_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:right;'>" + Vacio(data.contrato.veje_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.fsusp_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.frein_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.contrato.prorg_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.ffin_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.frecb_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.porav_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.estad_contrato[i]) + "</td>";
                                    campo += "</tr>";
                                    $("#contenidoEvolucion").append(campo);
                                }
                            } else {
                                $("#contenidoEvolucion").html("<tr><td colspan='11'><center><h1>NO EXISTEN EVOLUCIONES</h1></center></td></tr>");
                            }
                        } else {
                            $("#contenidoEvolucion").html("<tr><td colspan='11'><center><h1>NO EXISTEN EVOLUCIONES</h1></center></td></tr>");
                        }
                    },
                    error: function (error_messages) {

                    }
                });
            } else {
                var datos = {
                    OPCION: 'CONSULTAREVOLUCIONES',
                    num_contrato: 0,
                    tipoInforme: tipoInforme,
                    cod_proyect: $("#cmbProyectos").val()
                }
                $.ajax({
                    type: "POST",
                    url: "../Informes/EvolucionContratos.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data["Op"] === "Existe") {
                            $("#contenidoEvolucion").html("");
                            if (data['tam'] >= 1) {
                                var id_aux = 0;
                                for (var i = 1; i <= data['tam']; i++) {
                                    campo = "";
                                    if (id_aux !== data.contrato.num_contrato[i]) {
                                        campo += "<tr style='background-color: #d5edff;'>";
                                        campo += "<td colspan='2' style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align:left;'>" + Vacio(data.contrato.num_contrato[i]) + "</td>";
                                        campo += "<td colspan='9' style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align:left;'>" + Vacio(data.contrato.obj_contrato[i]) + "</td>";
                                        campo += "</tr>";
                                    }
                                    id_aux = data.contrato.num_contrato[i];
                                    campo += "<tr>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;'>" + i + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:right;'>" + Vacio(data.contrato.vadic_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:right;'>" + Vacio(data.contrato.vfin_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:right;'>" + Vacio(data.contrato.veje_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.fsusp_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.frein_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.contrato.prorg_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.ffin_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.frecb_contrato[i]).substring(0, 10) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.porav_contrato[i]) + "</td>";
                                    campo += "<td style='font-size: 10px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.estad_contrato[i]) + "</td>";
                                    campo += "</tr>";
                                    $("#contenidoEvolucion").append(campo);
                                }
                            } else {
                                $("#contenidoEvolucion").html("<tr><td colspan='11'><center><h1>NO EXISTEN EVOLUCIONES</h1></center></td></tr>");
                            }
                        } else {
                            $("#contenidoEvolucion").html("<tr><td colspan='11'><center><h1>NO EXISTEN EVOLUCIONES</h1></center></td></tr>");
                        }
                    },
                    error: function (error_messages) {

                    }
                });
            }
        }
    });

    $("#cmbTipo").on({
        change: function (e) {
            e.preventDefault();
            var valor = $(this).val();
            if (valor === "TODOS") {
                $("#filaIndividual").css("display", "none");
                $("#filaProyectos").css("display", "block");
                tipoInforme = "TODOS";
                $("#contenidoEvolucion").html("");
            } else {
                $("#filaIndividual").css("display", "block");
                $("#filaProyectos").css("display", "none");
                tipoInforme = "INDIVIDUAL";
                $("#contenidoEvolucion").html("");
            }
        }
    });


    $("#cmbProyectos").on({
        change: function (e) {
            e.preventDefault();
            $("#contenidoEvolucion").html("");
        }
    });
    //===============FUNCION CONTRATOS===============\\
    function VerContratos(busqueda) {
        var datos = {
            OPCION: 'CONSULTARCONTRATOS',
            busqueda: busqueda
        }
        $.ajax({
            type: "POST",
            url: "../Informes/EvolucionContratos.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                if (data["Op"] === "Existe") {
                    $("#contenidoContratos").html("");
                    if (data['tam'] >= 1) {
                        for (var i = 1; i <= data['tam']; i++) {
                            campo = "";
                            campo += "<tr data-num='" + data.contrato.num_contrato[i] + "'\n\
                                        data-obj='" + data.contrato.obj_contrato[i] + "' >";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + i + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.contrato.num_contrato[i]) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align: justify;text-transform: capitalize;'>" + Vacio(data.contrato.obj_contrato[i]) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.porav_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.contrato.fini_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.contrato.ffin_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.contrato.estad_contrato[i]) + "</td>";
                            campo += "<td class='center' style='font-weight: bold;vertical-align: middle;text-align:center;'>";
                            campo += "<button \n\
                                      class='btn btn-success btn-sm selContrato btn-icon' title='Seleccionar' data-toggle='tooltip' data-placement='top'>\n\
                                        <i class='fa fa-check'></i>\n\
                                      </button>";
                            campo += "</td>";
                            campo += "</tr>";
                            $("#contenidoContratos").append(campo);
                        }
                    } else {
                        $("#contenidoContratos").html("<tr><td colspan='8'><center><h1>NO EXISTEN CONTRATOS</h1></center></td></tr>");
                    }
                } else {
                    $("#contenidoContratos").html("<tr><td colspan='8'><center><h1>NO EXISTEN CONTRATOS</h1></center></td></tr>");
                }
            },
            error: function (error_messages) {

            }
        });
    }
    //===============FUNCION CONTRATOS===============\\

    //===============FUNCION PROYECTOS===============\\
    function verProyectos() {
        var datos = {
            OPCION: 'CONSULTARPROYECTOS'
        }
        $.ajax({
            type: "POST",
            url: "../Informes/EvolucionContratos.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                if (data["Op"] === "Existe") {
                    $("#cmbProyectos").html("");
                    var campo = "";
                    campo += "<option value='TODOS' >Todos los Proyectos</option>";
                    if (data['tam'] >= 1) {
                        for (var i = 1; i <= data['tam']; i++) {
                            campo += "<option value='" + data.proyectos.id_proyect[i] + "'>" + data.proyectos.cod_proyect[i] + " -- " + data.proyectos.nombre_proyect[i].toUpperCase() + "</option>";
                        }
                        $("#cmbProyectos").append(campo);
                    }
                }
            },
            error: function (error_messages) {

            }
        });
    }
    //===============FUNCION PROYECTOS===============\\


    //===============FUNCION VACIO===============\\
    function Vacio(valor) {
        // alert(valor);
        if (valor === "" || valor === null || valor === undefined) {
            valor = "";
        }
        return valor;
    }
    //===============FUNCION VACIO===============\\ 
    $.extend({
        Alert: function (Id_Msg, Txt_Msg, Type_Msg, ico) {
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
    });
});