$(document).ready(function () {
    Load2();
    //===============FUNCION LOAD===============\\ 
    function Load2() {
        var Datos = "";
        var type = "POST";
        var dataType = "json";
        Datos = {
            OPCION: "CONSULTARALERTAS"
        }
        $.ajax({
            type: type,
            url: "Proyecto/Polizas.php",
            data: Datos,
            dataType: dataType,
            success: function (data) {
                var campo = "";
                if (data['RIESGOALTO'] > 0) {
                    campo += "<div class='alert alert-block alert-danger fade in'>\n\
                                        <div class='row'>\n\
                                        <div class='col-md-10'  style='font-weight: bold;font-size: 15px;'>\n\
                                        <span class='badge badge-pill badge-danger' style='font-size: 15px;'>RIESGO ALTO</span>\n\
                                        " + data['RIESGOALTO'] + " Poliza(s) de contrato(s) esta(n) proxima(s) a vencer \n\
                                        </div>\n\
                                        <div class='col-md-1' >\n\
                                        <a href='#' id='RIESGOALTO' class='btn btn-primary btn-sm mb-1' >\n\
                                        <span class='fa fa-search'> Detalle</span></a>\n\
                                        </div></div></div>";
                    $("#divAlertas").css('display', 'block');
                }
                if (data['RIESGOMEDIO'] > 0) {
                    campo += "<div class='alert alert-block alert-warning fade in'>\n\
                                        <div class='row'>\n\
                                        <div class='col-md-10'  style='font-weight: bold;font-size: 15px;'>\n\
                                        <span class='badge badge-pill badge-warning' style='font-size: 15px;'>RIESGO MEDIO</span>\n\
                                        " + data['RIESGOMEDIO'] + " Poliza(s) de contrato(s) se encuentra(n) en riesgo medio de acuerdo al porcentaje ejecutado del proyecto  \n\
                                        </div>\n\
                                        <div class='col-md-1'>\n\
                                        <a href='#' id='RIESGOMEDIO' class='btn btn-primary btn-sm' ><span class='fa fa-search'> Detalle</span></a>\n\
                                        </div></div></div>";
                    $("#divAlertas").css('display', 'block');
                }
                if (data['RIESGOBAJO'] > 0) {
                    campo += "<div class='alert alert-block alert-success fade in'>\n\
                                        <div class='row'>\n\
                                        <div class='col-md-10'  style='font-weight: bold;font-size: 15px;'>\n\
                                        <span class='badge badge-pill badge-success' style='font-size: 15px;'>RIESGO BAJO</span>\n\
                                        " + data['RIESGOBAJO'] + " Poliza(s) de contrato(s) se encuentra(n) en riesgo bajo con relación al porcentaje ejecutado del proyecto  \n\
                                        </div>\n\
                                        <div class='col-md-1' >\n\
                                        <a href='#' id='RIESGOBAJO' class='btn btn-primary btn-sm' ><span class='fa fa-search'> Detalle</span></a>\n\
                                        </div></div></div>";
                    $("#divAlertas").css('display', 'block');
                }
                $("#VP").html(campo);
            },
            beforeSend: function () {
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    }
    //===============FUNCION LOAD===============\\


    $('#VP').on("click", "#RIESGOALTO", function (e) {
        e.preventDefault();
        $("#modalFinConLabel").html("Polizas de contratos que estan proximas a vencer");
        var Datos = "";
        var type = "POST";
        var dataType = "json";
        Datos = {
            OPCION: "PAGINAR2"
        }
        $.ajax({
            type: type,
            url: "Proyecto/Polizas.php",
            data: Datos,
            dataType: dataType,
            success: function (data) {
                agreDatos(data, "RIESGOALTO");
            },
            beforeSend: function () {
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    $('#VP').on("click", "#RIESGOMEDIO", function (e) {
        e.preventDefault();
        $("#modalFinConLabel").html("Polizas de contratos que se encuentran en riesgo medio");
        var Datos = "";
        var type = "POST";
        var dataType = "json";
        Datos = {
            OPCION: "PAGINAR2"
        }
        $.ajax({
            type: type,
            url: "Proyecto/Polizas.php",
            data: Datos,
            dataType: dataType,
            success: function (data) {
                agreDatos(data, "RIESGOMEDIO");
            },
            beforeSend: function () {
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    $('#VP').on("click", "#RIESGOBAJO", function (e) {
        e.preventDefault();
        $("#modalFinConLabel").html("Polizas de contratos que se encuentran en riesgo bajo");
        var Datos = "";
        var type = "POST";
        var dataType = "json";
        Datos = {
            OPCION: "PAGINAR2"
        }
        $.ajax({
            type: type,
            url: "Proyecto/Polizas.php",
            data: Datos,
            dataType: dataType,
            success: function (data) {
                agreDatos(data, "RIESGOBAJO");
            },
            beforeSend: function () {
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });

    //===============FUNCION VACIO===============\\
    function Vacio(valor) {
        // alert(valor);
        if (valor === "" || valor === null || valor === undefined) {
            valor = "";
        }
        return valor;
    }
    //===============FUNCION VACIO===============\\       
    //===============AGREGAR DATOS===============\\
    function agreDatos(data, RIESGO) {
        $("#contenido").html("");
        var campo = "";
        if (data["Salida"] === 1) {
            console.info(data);
            if (RIESGO === "RIESGOALTO") {
                if (data["OpA"] === "Existe") {
                    $("#contenido").html("");
                    if (data['tamA'] >= 1) {
                        for (var i = 1; i <= data['tamA']; i++) {
                            campo = "";
                            campo += "<tr>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + i + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align: justify;'>" +Vacio(data.RIESGOALTO.num_contrato[i])+ "-"+ Vacio(data.RIESGOALTO.obj_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.fini_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.ffin_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.num_poliza[i]) + "-"+Vacio(data.RIESGOALTO.descripcion[i]) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.fecha_ini[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.fecha_fin[i]).substring(0, 10) + "</td>";
                            //                                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data['por_con' + i]) + " %</td>";
                            // campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.estad_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.RIESGOALTO.porav_contrato[i]).toUpperCase() + "</td>";
                            campo += "</tr>";
                            $("#contenido").append(campo);
                        }
                    }
                } else {
                    $("#contenido").html("<tr><td colspan='8'><h1>NO EXISTEN CONTRATOS</h1></td></tr>");
                }
            }

            if (RIESGO === "RIESGOMEDIO") {
                if (data["OpM"] === "Existe") {
                    $("#contenido").html("");
                    if (data['tamM'] >= 1) {
                        for (var i = 1; i <= data['tamM']; i++) {
                            campo = "";
                            campo += "<tr>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + i + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align: justify;'>" +Vacio(data.RIESGOMEDIO.num_contrato[i])+ "-"+ Vacio(data.RIESGOMEDIO.obj_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOMEDIO.fini_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOMEDIO.ffin_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOMEDIO.num_poliza[i]) + "-"+Vacio(data.RIESGOMEDIO.descripcion[i]) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOMEDIO.fecha_ini[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOMEDIO.fecha_fin[i]).substring(0, 10) + "</td>";
                            //                                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data['por_con' + i]) + " %</td>";
                            // campo += "<td style='font-size: 11px;font-weight: b:old;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.estad_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align middle;text-align:center;'>" + Vacio(data.RIESGOMEDIO.porav_contrato[i]).toUpperCase() + "</td>";
                            campo += "</tr>";
                            $("#contenido").append(campo);
                        }
                    }
                } else {
                    $("#contenido").html("<tr><td colspan='8'><h1>NO EXISTEN CONTRATOS</h1></td></tr>");
                }
            }

            if (RIESGO === "RIESGOBAJO") {
                if (data["OpB"] === "Existe") {
                    $("#contenido").html("");
                    if (data['tamB'] >= 1) {
                        for (var i = 1; i <= data['tamB']; i++) {
                            campo = "";
                            campo += "<tr>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + i + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align: justify;'>" +Vacio(data.RIESGOBAJO.num_contrato[i])+ "-"+ Vacio(data.RIESGOBAJO.obj_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOBAJO.fini_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOBAJO.ffin_contrato[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOBAJO.num_poliza[i]) +"-"+Vacio(data.RIESGOBAJO.descripcion[i]) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOBAJO.fecha_ini[i]).substring(0, 10) + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOBAJO.fecha_fin[i]).substring(0, 10) + "</td>";
                            //                                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data['por_con' + i]) + " %</td>";
                            // campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;'>" + Vacio(data.RIESGOALTO.estad_contrato[i]).toUpperCase() + "</td>";
                            campo += "<td style='font-size: 11px;font-weight: bold;vertical-align: middle;text-align:center;'>" + Vacio(data.RIESGOBAJO.porav_contrato[i]).toUpperCase() + "</td>";
                            campo += "</tr>";
                            $("#contenido").append(campo);
                        }
                    }
                } else {
                    $("#contenido").html("<tr><td colspan='8'><h1>NO EXISTEN CONTRATOS</h1></td></tr>");
                }
            }
            $("#modalFinCon").modal("show");
        }
        if (data["Salida"] === 2) {
            alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
            window.location.href = "cerrar.php?opc=1";
        }
        if (data["Salida"] === 3) {
            alert("Ha Ocurrido un Error...");
        }
    }
    //===============AGREGAR DATOS===============\\       
});