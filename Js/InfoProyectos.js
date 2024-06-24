$(document).ready(function () {

// $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
    $("#menu_informe").addClass("start active open");
    $("#menu_infproyec").addClass("active");

    $("#CbTipInf,#CbGenero,#CbEdad,#CbGrupEtn,#CbTipMeta").selectpicker();
//    var chart;
    var legend;
    var selected;
    var types = [];
    var chartImages = []; 
    var mapa, mapa1, latitud, longitud;
    var chart = am4core.create("chartdiv", am4charts.PieChart3D);
    var chartEstCon = am4core.create("chartdivEstaCont", am4charts.PieChart3D);
    var chart2 = am4core.create("chartdivContProy", am4charts.XYChart);
//    var chart3 = am4core.create("chartdiv3", am4charts.XYChart);
//    var chart4 = am4core.create("chartdiv4", am4charts.PieChart);

    $.extend({

        CargaTodContr: function () {

            var datos = {
                ope: "CargaDatProyect"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#CbProy").html(data['Proyec']);
                    $("#CbSecre").html(data['Secr']);
                    $("#CbEje").html(data['ejes']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        CargCompone: function (cod) {

            var datos = {
                ope: "CargSelEstrategia2",
                cod: cod
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#CbComp').html(data['estrat']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbComp").prop('disabled', false);
        },
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
        CargProg: function (cod) {

            var datos = {
                ope: "CargSelPrograma2",
                cod: cod
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#CbProg').html(data['program']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbProg").prop('disabled', false);
        },
        HabInf: function (op) {

            if (op === "1") {
                $('#DivTipPob').show();
                $('#DivSecretarias').hide();
                $('#DivTipMeta').hide();
                $('#DivContratos').hide();
                $('#DivProyectos').hide();
                $('#DivMapsCal').hide();

            } else if (op === "2") {
                $('#DivSecretarias').show();
                $('#DivTipPob').hide();
                $('#DivTipMeta').hide();
                $('#DivContratos').hide();
                $('#DivProyectos').hide();
                $('#DivMapsCal').hide();

                var datos = {
                    ope: "CargSecre"
                };
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#CbSecre").html(data['Secre']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            } else if (op === "2" || op === "4" || op === "5" || op === "6") {
                $('#DivSecretarias').show();
                $('#DivTipPob').hide();
                $('#DivTipMeta').hide();
                $('#DivContratos').hide();
                $('#DivProyectos').hide();
                $('#DivMapsCal').hide();

                var datos = {
                    ope: "CargSecre2"
                };
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#CbSecre").html(data['Secre']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

            } else if (op === "3") {
                $('#DivTipMeta').show();
                $('#DivTipPob').hide();
                $('#DivSecretarias').hide();
                $('#DivContratos').hide();
                $('#DivProyectos').hide();
                $('#DivMapsCal').hide();
                $('#GrafSecret').hide();
                $('#GrafProy').hide();

                var datos = {
                    ope: "CargEjes"
                };
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#CbEjes").html(data['ejes']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

            } else if (op === "7" || op === "9") {
                $('#DivContratos').show();
                $('#DivTipMeta').hide();
                $('#DivTipPob').hide();
                $('#DivSecretarias').hide();
                $('#DivProyectos').hide();
                $('#DivMapsCal').hide();


                var datos = {
                    ope: "CargContInf",
                    inf: op
                };
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#CbContratos").html(data['Contr']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            } else if (op === "8") {
                $('#DivProyectos').show();
                $('#DivContratos').hide();
                $('#DivTipMeta').hide();
                $('#DivTipPob').hide();
                $('#DivSecretarias').hide();
                $('#DivMapsCal').hide();


                var datos = {
                    ope: "CargProytInf"
                };
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#CbProyectos").html(data['Proyec']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

            } else if (op === "10") {

                $('#DivMapsCal').show();
                $('#DivProyectos').hide();
                $('#DivContratos').hide();
                $('#DivTipMeta').hide();
                $('#DivTipPob').hide();
                $('#DivSecretarias').hide();
                initialize2();

                var datos = {
                    ope: "CargMapsCal"
                };
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#CbProyectos2").html(data['Proyec']);
                        $("#CbDep").html(data['Depa']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

            }

        },

        CargEstrategia: function (cod) {

            var datos = {
                ope: "CargSelEstrategiainf",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#CbEtrategias').html(data['estrat']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbEtrategias").prop('disabled', false);
        },
        CargProgramas: function (cod) {

            var datos = {
                ope: "CargSelProgramainf",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#CbProgramas').html(data['program']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbProgramas").prop('disabled', false);
        },
        BusMun: function (val) {

//            initialize();
            var datos = {
                ope: "cargaMun",
                cod: val
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbMun").html(data['mun']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbMun").prop('disabled', false);

        },
        localizame1: function () {
            if (navigator.geolocation) { /* Si el navegador tiene geolocalizacion */
                navigator.geolocation.getCurrentPosition($.coordenadas);
            } else {
                alert('Oops! Tu navegador no soporta geolocalización. Bájate Chrome, que es gratis!');
            }
        },
        coordenadas: function (position) {

            latitud = position.coords.latitude; /*Guardamos nuestra latitud*/
            longitud = position.coords.longitude; /*Guardamos nuestra longitud*/
            var latlon = new google.maps.LatLng(latitud, longitud); /* Creamos un punto con nuestras coordenadas */
            var myOptions = {
                zoom: 13,
                center: latlon, /* Definimos la posicion del mapa con el punto */
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }; /*Configuramos una serie de opciones como el zoom del mapa y el tipo.*/
            mapa = new google.maps.Map($("#map_canvas").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */

            var coorMarcador = new google.maps.LatLng(latitud, longitud);
            /Un nuevo punto con nuestras coordenadas para el marcador (flecha) */

            var marcador = new google.maps.Marker({
                /*Creamos un marcador*/
                animation: google.maps.Animation.DROP,
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: mapa, /* Lo vinculamos a nuestro mapa */
                icon: '../Img/Marker_1.png'
            });
            var Info = "<div>"
                    + "<div class='modal-header'>"
                    + "<h4 class='modal-title'>Mi Ubicacion</h4>"
                    + "</div>"
                    + "<div class='modal-body'>"
                    + "<div class='row'>"
                    + "</div>"
                    + "</div>"
                    + "</div>";
            var infowindow = new google.maps.InfoWindow({
                content: Info
            });
            google.maps.event.addListener(marcador, 'click', function () {
                infowindow.open(mapa, marcador);
            });
        },
        Colocar_Marcador: function (mapa, latitud, longitud,
                codproy, nproy, secret, tipo, eje, comp, prog, esta) {

//            var latlon = new google.maps.LatLng(latitud, longitud); /* Creamos un punto con nuestras coordenadas */
//            var myOptions = {
//                zoom: 17,
//                center: latlon, /* Definimos la posicion del mapa con el punto */
//                mapTypeId: google.maps.MapTypeId.ROADMAP
//            };/*Configuramos una serie de opciones como el zoom del mapa y el tipo.*/
//            mapa = new google.maps.Map($("#map_canvas").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */

            var coorMarcador = new google.maps.LatLng(latitud, longitud);
            /Un nuevo punto con nuestras coordenadas para el marcador (flecha) */

            var marcador = new google.maps.Marker({
                /*Creamos un marcador*/
                animation: google.maps.Animation.DROP,
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: mapa, /* Lo vinculamos a nuestro mapa */
                icon: '../Img/Marker_1.png'
            });
            var Info = "<div>"
                    + "<div class='modal-header'>"
                    + "<h4 class='modal-title'>Datos Del Proyecto</h4>"
                    + "</div>"
                    + "<div class='modal-body'>"
                    + "<div class='row'>"
                    + "<div class='col-md-12'>"
                    + "<div class='form-group'>"
                    + "<p style='margin: 0px 0'><b>Nombre:</b></p>"
                    + "<div class='input-icon right'>"
                    + "<label class='control-label'>" + nproy + "</label>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "<div class='col-md-12'>"
                    + "<div class='form-group'>"
                    + "<p style='margin: 0px 0'><b>Secretaria:</b></p>"
                    + "<div class='input-icon right'>"
                    + "<label class='control-label'>" + secret + "</label>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "<div class='col-md-12'>"
                    + "<div class='form-group'>"
                    + "<p style='margin: 0px 0'><b>Eje Estrategico:</b></p>"
                    + "<div class='input-icon right'>"
                    + "<label class='control-label'>" + eje + "</label>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "<div class='col-md-12'>"
                    + "<div class='form-group'>"
                    + "<p style='margin: 0px 0'><b>Estado:</b></p>"
                    + "<div class='input-icon right'>"
                    + "<label class='control-label'>" + esta + "</label>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>";

            var infowindow = new google.maps.InfoWindow({
                content: Info
            });
            google.maps.event.addListener(marcador, 'click', function () {
                infowindow.open(mapa, marcador);
            });
        },
        MostrarMap: function () {
            var datos = {
                ope: "ConMap",
                CbSecre: trimAll($("#CbSecre").val()),
                CbEje: trimAll($("#CbEje").val()),
                CbComp: trimAll($("#CbComp").val()),
                CbProg: trimAll($("#CbProg").val()),
                CbProy: trimAll($("#CbProy").val()),
                CbEstado: $("#CbEstado").val()
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    var i = 0;
                    for (i = 0; i <= data['Tam'] - 1; i++) {
                        $.Colocar_Marcador(mapa, data['lat_' + i], data['long_' + i],
                                data['codproy_' + i], data['nproy_' + i], data['tip_' + i], data['sec_' + i],
                                data['neje_' + i], data['ncomp_' + i], data['nprog_' + i], data['estad_' + i]
                                );
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Consultar: function () {
            var op = $("#CbTipInf").val();
            if (op === " ") {
                $.Alert("#msg", "Por Favor seleccione un tipo de Informe...", "warning", "warning");
                return;
            }

            if (op === "1") {
                $('#GrafProy').show();
                $('#GrafSecret').hide();
                $('#GrafMetas').hide();
                $('#GrafProyContr').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafProyEje').hide();
                $('#GrafContEvalCont').hide();


                $.Graficar1();
            } else if (op === "2") {
                $('#GrafProy').hide();
                $('#GrafMetas').hide();
                $('#GrafProyContr').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafProyEje').hide();
                $('#GrafMapsCal').hide();
                $.Graficar2();
            } else if (op === "3") {
              
                $('#GrafProy').hide();
                $('#GrafSecret').hide();
                $('#GrafProy').hide();
                $('#GrafProyContr').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafProyEje').hide();              
                $('#GrafMapsCal').hide();
                $.Graficar3();
            } else if (op === "4") {
                $('#GrafProyEje').show();
                $('#GrafMetas').hide();
                $('#GrafProy').hide();
                $('#GrafSecret').hide();
                $('#GrafProyContr').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafMapsCal').hide();
                $.Graficar4();
            } else if (op === "5") {
                $('#GrafProyContr').show();
                $('#GrafProyEje').hide();
                $('#GrafMetas').hide();
                $('#GrafProy').hide();
                $('#GrafSecret').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafMapsCal').hide();
                $.Graficar5();
            } else if (op === "6") {
                $('#GrafContAtrSusp').show();
                $('#GrafProyContr').hide();
                $('#GrafProyEje').hide();
                $('#GrafMetas').hide();
                $('#GrafProy').hide();
                $('#GrafSecret').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafMapsCal').hide();
                $.Graficar6();
            } else if (op === "7") {
                $('#GrafContEvalCont').show();
                $('#GrafContAtrSusp').hide();
                $('#GrafProyContr').hide();
                $('#GrafProyEje').hide();
                $('#GrafMetas').hide();
                $('#GrafProy').hide();
                $('#GrafSecret').hide();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafMapsCal').hide();

                $.Graficar7();
            } else if (op === "8") {
                $('#GrafGenProy').show();
                $('#GrafContEvalCont').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafProyContr').hide();
                $('#GrafProyEje').hide();
                $('#GrafMetas').hide();
                $('#GrafProy').hide();
                $('#GrafSecret').hide();
                $('#GrafGenCont').hide();
                $('#GrafMapsCal').hide();

                $.Graficar8();
            } else if (op === "9") {
                $('#GrafGenCont').show();
                $('#GrafGenProy').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafProyContr').hide();
                $('#GrafProyEje').hide();
                $('#GrafMetas').hide();
                $('#GrafSecret').hide();
                $('#GrafProy').hide();
                $('#GrafMapsCal').hide();

                $.Graficar9();
            } else if (op === "10") {
                $('#GrafMapsCal').show();
                $('#GrafGenCont').hide();
                $('#GrafGenProy').hide();
                $('#GrafContEvalCont').hide();
                $('#GrafContAtrSusp').hide();
                $('#GrafProyContr').hide();
                $('#GrafProyEje').hide();
                $('#GrafMetas').hide();
                $('#GrafSecret').hide();
                $('#GrafProy').hide();
                $.Graficar10();
            }
        },
        VolverList: function () {
            $('#GrafProy').hide();
            $('#ListProy').show();
            $('#btn_volver').hide();
        },
        VolverGrafCont: function () {
            $.Consultar();
            $('#btn_volver2').hide();
        },
        Limpiar: function () {
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
        },

        Graficar1: function () {
            $("#divurl").html("");
            $("#DetOtProyecto").html("");
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Grupo = $('#CbGrupEtn').val();
            var TextGrupo = $('#CbGrupEtn option:selected').text();
            var Genero = $('#CbGenero').val();
            var TextGenero = $('#CbGenero option:selected').text();
            var Edad = $('#CbEdad').val();
            var TextEdad = $('#CbEdad option:selected').text();

            $("#TitInfo").html(TextTipRepor);

            var SubTit = "Proyectos Asociado";
            $("#TotProyecto").html("");
            $("#DetOtProyecto").html("");

            if (Grupo !== "") {
                SubTit += " al Grupo Étnicos  " + TextGrupo;
            } else {
                SubTit += " a todos los grupos Étnicos de población, ";
            }

            if (Edad !== "") {
                SubTit += " perteneciente al curso de vida de " + TextEdad;
            } else {
                SubTit += " perteneciente a todos los cursos de vida";
            }

            if (Genero !== "") {
                SubTit += " de genero " + TextGenero;
            } else {
                SubTit += " de todos los géneros.";
            }

            chart = am4core.create("chartdiv", am4charts.PieChart3D);
            $("#TitInfo").html(TextTipRepor);
            $("#DetTitInf").html(SubTit);

            am4core.useTheme(am4themes_animated);

            var datos = {
                proy: $("#CbProy").val(),
                Grupo: Grupo,
                Genero: Genero,
                Edad: Edad,
                ope: "GrafInfGenPoblacional"
            };
            chart.innerRadius = am4core.percent(20);
            chart.paddingTop = 0;
            chart.marginTop = 0;
            chart.valign = 'top';
            chart.contentValign = 'top';

            var pieSeries = chart.series.push(new am4charts.PieSeries3D());
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data.length > 0) {
                        $("#chartdiv").show();
                        chart.data = data;
                        pieSeries.dataFields.value = "cant";
                        pieSeries.dataFields.category = "Cate";
                        pieSeries.slices.template.cornerRadius = 6;
                        pieSeries.labels.template.text = "{category}: ({value})";

                    } else {
                        $("#chartdiv").hide();
                        $("#tit_grafpobla").html("NO EXISTE INFORMACIÓN CARGADA PARA ESTOS PARÁMETROS DE CONSULTA.");

                    }

                }});

            // Add otra información
            var InfInv = "La Población Asociada";

            if (Grupo !== "") {
                InfInv += " al grupo <b>Étnico " + TextGrupo+"</b>";
            } else {
                InfInv += " a todos los grupos Étnicos, ";
            }

            if (Edad !== "") {
                InfInv += " perteneciente al curso de vida de <b>" + TextEdad+"</b>";
            } else {
                InfInv += " pertenecientes a todos los cursos de vida";
            }

            if (Genero !== "") {
                InfInv += " de género <b>" + TextGenero+"</b>";
            } else {
                InfInv += " de todos los géneros.";
            }




            var datos = {
                proy: $("#CbProy").val(),
                Grupo: Grupo,
                Genero: Genero,
                Edad: Edad,
                InfInv: InfInv,
                ope: "InfGenPoblacion"
            };

            var Inv = "SI";

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    var porcinv = 0;
                    if (data.RawSec.length > 0) {
                        $.each(data.RawSec, function (i, item) {
                            $("#TotProyecto").append("<div class='col-md-12'><h3>Proyectos y Contratos Relacionados a la Población por Secretaria.</h3></div>");
                            $("#TotProyecto").append("<div class='col-md-12'><h4>" + item.dessec + "</h4></div>");
                            $.each(item.proy, function (i, itemP) {
                                $("#TotProyecto").append("<div class='col-md-12'><h4>" + itemP.codproy + " - " + itemP.nomproy + "</h4></div>");
                                $("#TotProyecto").append("<div class='col-md-12' style='font-style: italic'><h3>Contratos por Proyecto</h3></div>");
                                var tabC = "<table class='table table-striped table-hover table-bordered '>"
                                        + "<thead>"
                                        + "    <tr>"
                                        + "        <th>"
                                        + "            <i class='fa fa-angle-right'></i> Número"
                                        + "        </th>"
                                        + "        <th>"
                                        + "            <i class='fa fa-angle-right'></i> Objeto"
                                        + "        </th>"
                                        + "       <th>"
                                        + "            <i class='fa fa-angle-right'></i> Valor"
                                        + "        </th>"
                                        + "       <th>"
                                        + "            <i class='fa fa-angle-right'></i> Estado"
                                        + "        </th>"
                                        + "       <th>"
                                        + "            <i class='fa fa-angle-right'></i> % de Avance"
                                        + "        </th>"
                                        + "   </tr>"
                                        + "</thead>"
                                        + "<tbody id='tb_Body_Contratos'>";

                                if (itemP.Contratos.length == 0) {
                                    tabC +="<tr><td colspan='5'><div class='col-md-12'>NO TIENE RELACIOANADO NINGÚN CONTRATO</></td></tr>";
                                } else {
                                    
                                    $.each(itemP.Contratos, function (i, itemC) {
                                        var colesta = "";
                                        if (itemC.estado === "Ejecucion") {
                                            colesta = "#2ED26E";
                                        } else if (itemC.estado === "Terminado") {
                                            colesta = "#387EFC";
                                        } else if (itemC.estado === "Suspendido") {
                                            colesta = "#EA4359";
                                        } else if (itemC.estado === "Liquidado") {
                                            colesta = "#FDC20D";
                                        }
                                        tabC += "<tr class='selected'>";
                                        tabC += "<td>" + itemC.numcont + "</td>";
                                        tabC += "<td>" + itemC.obj + "</td>";
                                        tabC += "<td>" + itemC.total + "</td>";
                                        tabC += "<td style='color:" + colesta + "'>" + itemC.estado.replace('Ejecucion', 'Ejecución') + "</td>";
                                        tabC += "<td>" + itemC.porava + "</td></tr>";
                                    });
                                    
                                }
                                tabC += "</tbody>"
                                     + "</table>";
                                $("#TotProyecto").append(tabC);

                            });
                            if (Inv === "SI") {
                                porcinv = (item.inv * 100) / item.presupuesto;

                                $("#TotProyecto").append('<h3 style="padding-top: 10px;">Detalles de Inversión.</h3><div class="portlet">'
                                        + '<div class="portlet-body">');
                                $("#TotProyecto").append('<div class="well">El presupuesto asignado para esta secretaria es de <b> $ ' + number_format2(item.presupuesto, 2, ',', '.') + ',</b> con una \n\
                           inversión de <b> $ ' + number_format2(item.inv, 2, ",", ".") + '</b> distribuidos en <b>' + item.nproy + ' Proyecto(s),</b> que representa el <b>' + porcinv.toFixed(2) + '%</b> del presupuesto incial, que beneficiarán a <b>' + item.tpers + ' Personas</b> de ' + InfInv + '</div>');

                                $("#TotProyecto").append('</div></div>');

                            }
                        });
                    }
                    /////CARGAR OTROR PROYECTOS
                    if (data.RawOtrosPro.length > 0) {
                        $("#DetOtProyecto").append('<h3 style="padding-top: 10px;">Otros Proyectos.</h3>');

                        var tabP = "<table class='table table-striped table-hover table-bordered '>"
                                + "<thead>"
                                + "    <tr>"
                                + "        <th>"
                                + "            Código"
                                + "        </th>"
                                + "        <th>"
                                + "             Proyecto"
                                + "        </th>"
                                + "       <th>"
                                + "            Estado"
                                + "        </th>"
                                + "   </tr>"
                                + "</thead>"
                                + "<tbody id='tb_Body_Contratos'>";
                        var conP = 1;
                        $.each(data.RawOtrosPro, function (i, itemP) {
                            var colesta = "";
                            if (itemP.estado === "En Ejecucion") {
                                colesta = "#2ED26E";
                            } else if (itemP.estado === "Ejecutado") {
                                colesta = "#387EFC";
                            } else if (itemP.estado === "Radicado") {
                                colesta = "#EA4359";
                            } else if (itemP.estado === "Registrado") {
                                colesta = "#FDC20D";
                            } else if (itemP.estado === "No Viabilizado") {
                                colesta = "#FDC20D";
                            }
                            tabP += "<tr class='selected'>";
                            tabP += "<td>" + itemP.codproy + "</td>";
                            tabP += "<td>" + itemP.nproy + "</td>";
                            tabP += "<td style='color:" + colesta + "'>" + itemP.estado.replace('En Ejecucion', 'En Ejecución') + "</td>";
                            conP++;
                        });

                        tabP += "</tbody>"
                                + "</table>";
                        $("#DetOtProyecto").append(tabP);
                    }



                }});

        },
        Graficar2: function () {
            $("#divurl").html("");
            $("#divur2").html("");
            $("#ProyxContra").html("");
            $("#Tabla_Proyectos").html("");
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();
            var SubTit = "";

            if (Secre === " ") {
                $.Alert("#msg", "Por Favor seleccione La Secretaria...", "warning", "warning");
                return;
            }
            $('#GrafSecret').show();

            $("#TitInfoSecre").html(TextTipRepor);

            var datos = {
                Secre: Secre,
                ope: "InfGenSecretaria"
            };

            chart = am4core.create("chartdivSecre", am4charts.PieChart3D);
            am4core.useTheme(am4themes_animated);


            chart.innerRadius = am4core.percent(20);
            chart.paddingTop = 0;
            chart.marginTop = 0;
            chart.valign = 'top';
            chart.contentValign = 'top';

            var pieSeries = chart.series.push(new am4charts.PieSeries3D());
            var porcinv = 0;

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {

                    var parsecr = TextSecre.split(" - ");
                    if(data['totalpre'] == 0){
                        SubTit = "La Secretaria de " + parsecr[1].toLowerCase() + ", no cuenta con un Presupuesto inicial";
                    }else{
                        SubTit = "La Secretaria de " + parsecr[1].toLowerCase() + ", Cuenta con un Presupuesto inicial de " + '$ ' + number_format2(data['totalpre'], 2, ',', '.');
                    }
                   
                    if (data.rawdata.length > 0) {
                        $("#chartdivSecre").show();

                        chart.data = data.rawdata;
                        pieSeries.dataFields.value = "cant";
                        pieSeries.dataFields.category = "Cate";
                        pieSeries.slices.template.cornerRadius = 6;
                        pieSeries.labels.template.text = "{category}: {value} ({value.percent.formatNumber('#.0')}%)";
                    } else {
                        $("#chartdivSecre").hide();
                        $("#Tabla_Proyectos").append("<div class='col-md-12'><h4>Esta secretaria no Cuenta con algun Proyecto.</h4></div>");
                    }


                    var conMe = 1;
                    $("#Tabla_Proyectos").append("<div class='col-md-12'><h4><b>Metas Trazadoras por Proyectos.</b></h4></div>");
                    if (data.RawProyM.length > 0) {
                        $.each(data.RawProyM, function (i, itemP) {
                            var colesta = "";

                            if (itemP.estado === "En Ejecucion") {
                                colesta = "#2ED26E";
                            } else if (itemP.estado === "Ejecutado") {
                                colesta = "#387EFC";
                            } else if (itemP.estado === "Priorizados") {
                                colesta = "#1BBC9B";
                            } else if (itemP.estado === "Radicado") {
                                colesta = "#EA4359";
                            } else if (itemP.estado === "Registrado") {
                                colesta = "#FDC20D";
                            } else if (itemP.estado === "No Viabilizado") {
                                colesta = "#FDC20D";
                            }

                            $("#Tabla_Proyectos").append("<div class='col-md-12'><h5>" + itemP.nombre + "- (<label style='color:" + colesta + ";font-style: italic;'>" + itemP.estado.replace('En Ejecucion', 'En Ejecución') + "</label>)</h5></div>");
                            if (itemP.Metas.length > 0) {
                                $.each(itemP.Metas, function (i, itemM) {
                                    $("#Tabla_Proyectos").append("<div class='col-md-12'><h6 style='font-style: italic'> " + itemM.desmet + "</h6></div>");
                                });
                            } else {
                                $("#Tabla_Proyectos").append("<div class='col-md-12'><h5>Este Proyecto no tiene asociada ninguna Meta Trazadora.</h5></div>");
                            }
                        });
                    } else {
                        $("#Tabla_Proyectos").append("<div class='col-md-12'><h4>Esta Secretaria no tiene asociado ningún proyecto con Metas Trazadora.</h4></div>");
                    }

                    $("#ProyxContra").append("<div class='col-md-12'><h4><b>Proyectos y Contratos</b></h4></div>");
                    $.each(data.proyect, function (i, itemPr) {
                        var colesta = "";

                        if (itemPr.estado === "En Ejecucion") {
                            colesta = "#2ED26E";
                        } else if (itemPr.estado === "Ejecutado") {
                            colesta = "#387EFC";
                        } else if (itemPr.estado === "Priorizados") {
                            colesta = "#1BBC9B";
                        } else if (itemPr.estado === "Radicado") {
                            colesta = "#EA4359";
                        } else if (itemPr.estado === "Registrado") {
                            colesta = "#FDC20D";
                        } else if (itemPr.estado === "No Viabilizado") {
                            colesta = "#FDC20D";
                        }

                        $("#ProyxContra").append("<div class='col-md-12'><h5>" + itemPr.nombproy + " - (<label style='color:" + colesta + ";font-style: italic;'>" + itemPr.estado.replace('En Ejecucion', 'En Ejecución') + "</label>) </h5></div>");
                        $("#ProyxContra").append("<div class='col-md-12'><h5 style='font-style: italic'>Listado de Contratos.</h5></div>");

                        var tabC = "<table class='table table-striped table-hover table-bordered '>"
                                + "<thead>"
                                + "    <tr>"
                                + "        <th>"
                                + "            <i class='fa fa-angle-right'></i> Número"
                                + "        </th>"
                                + "        <th>"
                                + "            <i class='fa fa-angle-right'></i> Objeto"
                                + "        </th>"
                                + "        <th>"
                                + "            <i class='fa fa-angle-right'></i> Contratista"
                                + "        </th>"
                                + "       <th>"
                                + "            <i class='fa fa-angle-right'></i> Valor"
                                + "        </th>"
                                + "       <th>"
                                + "            <i class='fa fa-angle-right'></i> Estado"
                                + "        </th>"
                                + "   </tr>"
                                + "</thead>"
                                + "<tbody id='tb_Body_Contratos'>";

                        $.each(itemPr.Contratos, function (i, itemC) {
                            if (itemC.ncont === "No") {
                                tabC += "<tr class='selected'>";
                                tabC += "<td colspan ='5'>Este Proyecto No tiene Relacionado Ningún Contrato</td></tr>";
                            } else {
                                var colesta = "";
                                if (itemC.estado === "Ejecucion") {
                                    colesta = "#2ED26E";
                                } else if (itemC.estado === "Terminado") {
                                    colesta = "#387EFC";
                                } else if (itemC.estado === "Suspendido") {
                                    colesta = "#EA4359";
                                } else if (itemC.estado === "Liquidado") {
                                    colesta = "#FDC20D";
                                }
                                tabC += "<tr class='selected'>";
                                tabC += "<td>" + itemC.ncont + "</td>";
                                tabC += "<td>" + itemC.obj + "</td>";
                                tabC += "<td>" + itemC.descontita + "</td>";
                                tabC += "<td>" + itemC.total + "</td>";
                                tabC += "<td style='color:" + colesta + "'>" + itemC.estado.replace('Ejecucion', 'Ejecución') + "</td></tr>";
                            }
                        });
                        tabC += "</tbody>"
                                + "</table>";

                        $("#ProyxContra").append(tabC);

                    });

                    porcinv = (data['inv'] * 100) / data['totalpre'];
                    if(data['totalpre'] != 0){
                        $("#DetInvSecretaria").html("Del Presupuesto asignado de $ " + number_format2(data['totalpre'], 2, ',', '.') + " a la " + parsecr[1].toLowerCase() + " Evidencia una inversión de $ " + number_format2(data['inv'], 2, ',', '.') + ". Que representa el " + porcinv.toFixed(2) + "% del Presupuesto Inicial");

                    }

                }});

            $("#DetTitInfSecre").html(SubTit);

        },
        Graficar3: function () {
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var CbEjes = $('#CbEjes').val();
            var TextEjes = $('#CbEjes option:selected').text();
            var CbProg = $('#CbEtrategias').val();
            var TextProg = $('#CbEtrategias option:selected').text();
            var CbSubProg = $('#CbProgramas').val();
            var TextSubProg = $('#CbProgramas option:selected').text();
            var CbTipMeta = $('#CbTipMeta').val();
            var TextTipMeta = $('#CbTipMeta option:selected').text();

            $("#TMetasProy").html("");

            if (CbProg == " ") {
                CbProg = "";
            }
            if (CbSubProg == " ") {
                CbSubProg = "";
            }

            if (CbEjes == " ") {
                $.Alert("#msg", "Por Favor seleccione el Eje...", "warning", "warning");
                return;
            }

            if (CbTipMeta == " ") {
                $.Alert("#msg", "Por Favor seleccione el Tipo de Meta...", "warning", "warning");
                return;
            }

            $('#GrafMetas').show();

            var datos = {
                CbEjes: CbEjes,
                CbProg: CbProg,
                CbSubProg: CbSubProg,
                CbTipMeta: CbTipMeta,
                ope: "InfGenMetas"
            };
            var SubTit = "";
            $("#TitInfoMetas").html(TextTipRepor);
            let nivel1 = document.getElementById("nivel1").textContent;
                let nivel2 = document.getElementById("nivel2").textContent;
                let nivel3 = document.getElementById("nivel3").textContent;

            $("#TitDetMeta").html("<b>"+nivel1+"</b> " + TextEjes + "<br><b>"+nivel2+"</b> " + TextProg + "<br><b>"+nivel3+"</b> " + TextSubProg);

            var TMetas = "<table class='table table-striped table-hover table-bordered '>"
                    + "<thead>"
                    + "    <tr>"
                    + "        <th>"
                    + "            #"
                    + "        </th>"
                    + "        <th>"
                    + "             Descripción Meta"
                    + "        </th>"
                    + "       <th>"
                    + "             Meta"
                    + "        </th>"
                    + "       <th>"
                    + "          % Cumplimiento"
                    + "        </th>"
                    + "   </tr>"
                    + "</thead>"
                    + "<tbody id='tb_Body_TMetas'>";



            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    var ContM = 1;
                    if (data.ResumMetas.length > 0) {
                        $.each(data.ResumMetas, function (i, itemM) {
                            TMetas += "<tr class='selected'>";
                            TMetas += "<td>" + ContM + "</td>";
                            TMetas += "<td>" + itemM.DesMet + "</td>";
                            TMetas += "<td>" + itemM.Meta + "</td>";
                            TMetas += "<td>" + itemM.Cumplimiento + "%</td></tr>";
                            ContM++;
                            if (itemM.DetMetProy.length > 0) {

                            var TPMeta = "<table class='table table-striped table-hover table-bordered '>"
                                    + "<thead>"
                                    + "    <tr>"
                                    + "        <th>"
                                    + "            Proyecto"
                                    + "        </th>"
                                    + "       <th>"
                                    + "             Meta de Proyecto"
                                    + "        </th>"
                                    + "       <th>"
                                    + "           Resultado Medición"
                                    + "        </th>"
                                    + "       <th>"
                                    + "           % Cumplimiento"
                                    + "        </th>"
                                    + "   </tr>"
                                    + "</thead>"
                                    + "<tbody id='tb_Body_TMetas'>";

                           
                                $("#TMetasProy").append("<div class='col-md-12'><h3>" + itemM.DesMet + "</h3><label style='font-style: italic;  font-size: 20px'>(Meta: " + itemM.Meta + ")</label></div>");

                                $.each(itemM.DetMetProy, function (i, itemP) {
                                    TPMeta += "<tr class='selected'>";
                                    TPMeta += "<td>" + itemP.nproy + "</td>";
                                    TPMeta += "<td>" + itemP.meta + "</td>";
                                    TPMeta += "<td>" + itemP.resulindi + "</td>";
                                    TPMeta += "<td>" + itemP.Cumpl + "%</td></tr>";
                                });
                                TPMeta += "</tbody>";
                                TPMeta += "<tfoot>";
                                TPMeta += " <tr>";
                                TPMeta += " <th colspan='3' style='text-align: right;'>Total:</th>";
                                TPMeta += "  <th colspan='1'><label id='gtotal' style='font-weight: bold;'>" + itemM.Cumplimiento + "%</label></th>";
                                TPMeta += " </tr>";
                                TPMeta += " </tfoot>"
                                        + "</table>";

                            }

                            $("#TMetasProy").append(TPMeta);
                        });
                    } else {
                        TMetas += "<tr class='selected'>";
                        TMetas += "<td COLSPAN='4'>No Existe ninguna Meta Relacioanda a estos Parámetros de Busqueda.</td></tr>";

                    }

                    TMetas += "</tbody>"
                            + "</table>";

                    $("#TMetas").html(TMetas);


                }});
        },
        Graficar4: function () {
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();
            var SubTit = "";
            if (Secre === " ") {
                Secre = "";
            }

            $("#TitInfoProyEje").html(TextTipRepor);

            var datos = {
                Secre: Secre,
                ope: "InfGenProyEjeCont"
            };

            var porcinv = 0;

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    $("#SecProyCont").html(data['Tab_Proyectos']);
                }});

        },
        Graficar5: function () {

            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();
            var SubTit = "";
            if (Secre === " ") {
                Secre = "";
            }

            $('#GrafProyContr').show();

            $("#TitInfoContxProy").html(TextTipRepor);
            $("#TitDetSecre").html(TextSecre.replace('Todas...', 'Todas las Secretarias'));

            var datos = {
                Secre: Secre,
                ope: "InfGenContrxProy"
            };

            am4core.useTheme(am4themes_animated);
            chart2 = am4core.create("chartdivContProy", am4charts.XYChart);
            let cantCont;
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    cantCont = data.GrafCont.length;
                    chart2.data = data.GrafCont;
                    $("#DetContxProy").html(data.CadCont);
                }});


            if(cantCont>0){

                $("#chartdivContProy").show();
            // Create axes
            var categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "Cate";
            categoryAxis.renderer.grid.template.location = 0;

            var valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());

            // Create series
            var series = chart2.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = "cant";
            series.dataFields.categoryX = "Cate";
            series.tooltipText = "{valueY.cant}";
            series.columns.template.tooltipText = "Series: {name}\nCod. Proyecto: {categoryX}\nCantidad: {valueY}";
            series.columns.template.strokeOpacity = 0;
            series.columns.template.column.cornerRadiusTopRight = 10;
            series.columns.template.column.cornerRadiusTopLeft = 10;

            series.columns.template.adapter.add("fill", function (fill, target) {
                return chart2.colors.getIndex(target.dataItem.index);
            });

            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.verticalCenter = "bottom";
            labelBullet.label.dy = -10;
            labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";

        }else{
            $("#DetContxProy").html("NO EXISTEN CONTRATOS RELACIONADOS A ESTOS PARÁMETROS DE BUSQUEDA ");
            $("#chartdivContProy").hide();
        }

        },
        Graficar6: function () {
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();

            var SubTit = "";
            if (Secre === " ") {
                Secre = "";
            }

            $('#GrafContAtrSusp').show();

            $("#TitInfoProyEst").html(TextTipRepor);


            var datos = {
                Secre: Secre,
                ope: "InfGenContrxSuspAtras"
            };

            am4core.useTheme(am4themes_animated);
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    $("#ContSuspAtra").html(data.Tab_Contratos);
                    var x = 1;
                    $.each(data.RawCon, function (j, item) {
                        var chart = am4core.create("chartdivSecre" + j, am4charts.PieChart3D);
                        window['chartSe' + x] = chart;
                        chart.innerRadius = am4core.percent(20);
                        chart.paddingTop = 0;
                        chart.marginTop = 0;
                        chart.valign = 'top';
                        chart.contentValign = 'top';
                        chart.legend = new am4charts.Legend();
                        var pieSeries = chart.series.push(new am4charts.PieSeries3D());
            
                        chart.data = item.estados;
            
                        pieSeries.dataFields.value = "cant";
                        pieSeries.dataFields.category = "cate";
                        pieSeries.slices.template.cornerRadius = 6;
                        pieSeries.labels.template.text = "{category}: {value} ({value.percent.formatNumber('#.0')}%)";
                        
                       
                        // Exportar la gráfica y guardar la imagen en la variable global

                        chart.exporting.getImage("png", {
                            quality: 3, // Ajustar la calidad de la imagen
                            scale: 3,
                            keepTainted: true // Mantener los colores originales
                        }).then(function (imgData) {
                         
                            chartImages.push(imgData);
                            // Verificar si se han exportado todas las gráficas
                          
                        });
                             
                        x++;
                    });
                }});



        },
        Graficar7: function () {
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Contr = $('#CbContratos').val();
            var Ncont = "";

            var SubTit = "";
            if (Contr === " ") {
                Contr = "";
            } else {
                var parcont = Contr.split("/");
                Contr = parcont[0];
                Ncont = parcont[1];
            }

            $("#ContEvalCont").html("");

            $('#GrafContEvalCont').show();
            $("#TitInfoProyEst").append(TextTipRepor);

            var datos = {
                Contr: Contr,
                Ncont: Ncont,
                ope: "InfGenEvalCont"
            };
            $("#ContEvalCont").append("<div class='row'>");

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data.RawCtta.length > 0) {
                        $.each(data.RawCtta, function (i, item) {
                            $("#ContEvalCont").append("<div class='col-md-12' ><h3>CONTRATISTA - " + item.nombCtta + "</h3></div>");
                            $.each(item.Eval, function (j, item2) {
                                $("#ContEvalCont").append("<div class='col-md-12'><h4>EVALUACIÓN DE CONTRATO - " + item2.ncont + "</h4></div>");
                                $("#ContEvalCont").append("<div class='col-md-9'><b>Objeto:</b><br> " + item2.obj + "</div><div class='col-md-3'><b>Valor:</b><br> " + item2.valor + "</div>");
                                $("#ContEvalCont").append("<div class='col-md-9'><b>Proyecto:</b><br> " + item2.nproy + "</div><div class='col-md-3'><b>Secretaria:</b><br> " + item2.secret + "</div>");
                                $("#ContEvalCont").append("<div class='col-md-5'><b>Fecha de Evaluación:</b><br> " + item2.fecha + "</div><br>");
                                $("#ContEvalCont").append("<div class='col-md-7'><b>Calificación Obtenida:</b><br> " + item2.PuntTo + "</div><br>");
                                $("#ContEvalCont").append("<div class='col-md-12'><h4>CRITERIOS DE EVALUACIÓN</h4></div>");
                                $("#ContEvalCont").append("<div class='col-md-12'>");

                                $("#ContEvalCont").append("<div class='portlet'>"
                                        + "<div class='portlet-title'>"
                                        + "	<div class='caption'><i class='icon-reorder'></i>1. Criterios Cumplimiento Y Oportunidad <label style='font-style: italic'> (Puntaje: " + item2.PuntCO + ")</label> - <label style='font-style: italic'> (% Equivalente: " + item2.PorCO + "%)</label></div>"
                                        + "</div>"
                                        + "<div class='portlet-body'>"
                                        + "	<h4>Analisis.</h4>"
                                        + "	<blockquote style='font-size:14px'>"
                                        + "		<p>" + item2.analisis_cumpli + "</p>"
                                        + "	</blockquote>"
                                        + "</div>"
                                        + "</div>");
                                $("#ContEvalCont").append("<div class='portlet'>"
                                        + "<div class='portlet-title'>"
                                        + "	<div class='caption'><i class='icon-reorder'></i>2. Criterios En La Ejecución Del Contrato <label style='font-style: italic'> (Puntaje: " + item2.PuntCE + ")</label> - <label style='font-style: italic'> (% Equivalente: " + item2.PorCE + "%)</label></div>"
                                        + "</div>"
                                        + "<div class='portlet-body'>"
                                        + "	<h4>Analisis.</h4>"
                                        + "	<blockquote style='font-size:14px'>"
                                        + "		<p>" + item2.analisis_ejec + "</p>"
                                        + "	</blockquote>"
                                        + "</div>"
                                        + "</div>");
                                $("#ContEvalCont").append("<div class='portlet'>"
                                        + "<div class='portlet-title'>"
                                        + "	<div class='caption'><i class='icon-reorder'></i>3. Criterios De Calidad<label style='font-style: italic'> (Puntaje: " + item2.PuntCC + ")</label> - <label style='font-style: italic'> (% Equivalente: " + item2.PorCC + "%)</label></div>"
                                        + "</div>"
                                        + "<div class='portlet-body'>"
                                        + "	<h4>Analisis.</h4>"
                                        + "	<blockquote style='font-size:14px'>"
                                        + "		<p>" + item2.analisis_calidad + "</p>"
                                        + "	</blockquote>"
                                        + "</div>"
                                        + "</div>");
                                $("#ContEvalCont").append("</div>");

                                $("#ContEvalCont").append("<div class='col-md-12'><h4>FORTALEZAS Y DEBILIDADES DE LA EVALUACIÓN</h4></div>");
                                if (item2.ContF > 0) {
                                    $("#ContEvalCont").append("<div class='col-md-12'>");
                                    $("#ContEvalCont").append("<div class='portlet'>"
                                            + "<div class='portlet-title'>"
                                            + "	<div class='caption'><i class='icon-reorder'></i>Fortalezas</div>"
                                            + "</div>"
                                            + "<div class='portlet-body'>");

                                    $.each(item2.CritFort, function (j, item3) {
                                        $("#ContEvalCont").append("<blockquote style='font-size:14px'>"
                                                + "		<p>" + item3.criterioF + " (<label style='font-style: italic; font-weight: bold'>Puntaje: " + item3.puntF + "</label>)</p>"
                                                + "	</blockquote>");
                                    });


                                    $("#ContEvalCont").append("</div>"
                                            + "</div>");

                                    $("#ContEvalCont").append("</div>");
                                }
                                if (item2.ContD > 0) {

                                    $("#ContEvalCont").append("<div class='col-md-12'>");
                                    $("#ContEvalCont").append("<div class='portlet'>"
                                            + "<div class='portlet-title'>"
                                            + "	<div class='caption'><i class='icon-reorder'></i>Debilidades y Oportunidad de Mejora</div>"
                                            + "</div>"
                                            + "<div class='portlet-body'>");

                                    $.each(item2.CritDebi, function (j, item3) {
                                        $("#ContEvalCont").append("<blockquote style='font-size:14px'>"
                                                + "		<p>" + item3.criterioD + " (<label style='font-style: italic; font-weight: bold'>Puntaje: " + item3.puntD + "</label>)</p>"
                                                + "	</blockquote>");
                                    });


                                    $("#ContEvalCont").append("</div>"
                                            + "</div>");

                                    $("#ContEvalCont").append("</div>");
                                }


                            });


                            if (data.RawOtEv.length > 0) {
                                $("#ContEvalCont").append("<div class='col-md-12'><h4>OTRAS EVALUACIONES</h4></div>");

                                var TBOTEVAL = "<table class='table table-striped table-hover table-bordered '>"
                                        + "<thead>"
                                        + "    <tr>"
                                        + "        <th>"
                                        + "           Fecha "
                                        + "        </th>"
                                        + "        <th>"
                                        + "             Criterios Cumplimiento Y Oportunidad"
                                        + "        </th>"
                                        + "       <th>"
                                        + "             Criterios En La Ejecución Del Contrato"
                                        + "        </th>"
                                        + "       <th>"
                                        + "           Criterios De Calidad "
                                        + "        </th>"
                                        + "       <th>"
                                        + "          Calificación Total "
                                        + "        </th>"
                                        + "   </tr>"
                                        + "</thead>"
                                        + "<tbody id='tb_Body_TMetas'>";
                                $.each(data.RawOtEv, function (i2, itemH) {
                                    TBOTEVAL += "<tr class='selected'>";
                                    TBOTEVAL += "<td>" + itemH.freeva + "</td>";
                                    TBOTEVAL += "<td>" + itemH.PuntCO + "</td>";
                                    TBOTEVAL += "<td>" + itemH.PuntCE + "</td>";
                                    TBOTEVAL += "<td>" + itemH.PuntCC + "</td>";
                                    TBOTEVAL += "<td>" + itemH.PuntTo + "</td></tr>";
                                });

                                TBOTEVAL += "</tbody>"
                                        + "</table>";
                            }
                            $("#ContEvalCont").append(TBOTEVAL);

                            if (item.ContC > 0) {
                                $("#ContEvalCont").append("<div class='col-md-12'><h4>HISTORIAL DE CONTRATOS</h4></div>");
                                $("#ContEvalCont").append("<div class='portlet'>"

                                        + "<div class='portlet-body'>");
                                var colesta = "";
                                $.each(item.HisCont, function (j, itemH) {
                                    var colesta = "";
                                    if (itemH.estad_contrato === "Ejecucion") {
                                        colesta = "#2ED26E";
                                    } else if (itemH.estad_contrato === "Terminado") {
                                        colesta = "#387EFC";
                                    } else if (itemH.estad_contrato === "Suspendido") {
                                        colesta = "#EA4359";
                                    } else if (itemH.estad_contrato === "Liquidado") {
                                        colesta = "#FDC20D";
                                    }

                                    $("#ContEvalCont").append("<blockquote style='font-size:14px'>"
                                            + "		<p>" + itemH.num_contrato + ' - ' + itemH.obj_contrato + " (<label style='font-style: italic; font-weight: bold;color:" + colesta + "'>" + itemH.estad_contrato + "</label>)</p>"
                                            + "	</blockquote>");
                                });
                                $("#ContEvalCont").append("</div>"
                                        + "</div>");

                            }
                        });


                    } else {
                        $("#ContEvalCont").append("<div class='col-md-12' style='text-align: center;'><h3>NO EXISTE NINGUNA EVALUACIÓN RELACIONADA A ESTOS PARÁMETROS.</h3></div>");
                    }

                }});

            $("#ContEvalCont").append("</div");



        },
        Graficar8: function () {
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Proy = $('#CbProyectos').val();
            var Ncont = "";

            var SubTit = "";
            if (Proy === " ") {
                $.Alert("#msg", "Por Favor Seleccione un Proyecto...", "warning", "warning");
                return;
            }
            if (Proy === " ") {
                Proy = "";
            }



            $("#ContGenProy").html("");
             $("#TitInfoGenProy").html("");

            $("#TitInfoGenProy").append(TextTipRepor);

            var datos = {
                Proy: Proy,
                ope: "InfGenProyectos",
                dest: "html"
            };
            $("#ContGenProy").append("<div class='row'>");

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $.each(data.RawProyec, function (i, item) {
                        $("#ContGenProy").append("<div class='col-md-12'><h4>DETALLES DEL PROYECTO - " + item.cproy + "</h4></div>");
                        $("#ContGenProy").append("<div class='col-md-12'><b>Nombre:</b><br> " + item.nproy + "</div>");
                        $("#ContGenProy").append("<div class='col-md-6'><b>Secretaria:</b><br> " + item.secre + "</div><div class='col-md-6'><b>Tipologia de Proyecto:</b><br> " + item.dtipo + "</div>");
                        $("#ContGenProy").append("<div class='col-md-4'><b>Eje:</b><br> " + item.neje + "</div><div class='col-md-4'><b>Programa:</b><br> " + item.ncomp + "</div><div class='col-md-4'><b>SubPrograma:</b><br> " + item.nprog + "</div>");
                        $("#ContGenProy").append("<div class='col-md-12'><b>Porcentaje de Ejecución:</b><br> " + item.pava + "</div>");

                        $("#ContGenProy").append("<div class='col-md-12'><h4>POBLACIÓN OBJETIVO</h4></div>");
                        $("#ContGenProy").append("<div class='portlet'>"
                                + "<div class='portlet-body'>");

                        $.each(item.pobj, function (j, item2) {
                            $("#ContGenProy").append("<blockquote style='font-size:14px'>"
                                    + "<p>" + item2.grupoetnico + " (<label style='font-style: italic;'>Personas Beneficiadas: " + item2.personas + "</label>)</p></blockquote>");
                        });
                        $("#ContGenProy").append("</div>"
                                + "</div>");

                        $("#ContGenProy").append("<div class='col-md-12'><h4>METAS TRAZADORAS</h4></div>");



                        if (item.ContMT > 0) {
                            var tabMT = "<table class='table table-striped table-hover table-bordered '>"
                                    + "<thead>"
                                    + "    <tr>"
                                    + "        <th>"
                                    + "            <i class='fa fa-angle-right'></i> #"
                                    + "        </th>"
                                    + "        <th>"
                                    + "            <i class='fa fa-angle-right'></i> Descripción"
                                    + "        </th>"
                                    + "       <th>"
                                    + "            <i class='fa fa-angle-right'></i> Objetivo"
                                    + "        </th>"
                                    + "       <th>"
                                    + "            <i class='fa fa-angle-right'></i> Aporte del Proyecto"
                                    + "        </th>"
                                    + "   </tr>"
                                    + "</thead>"
                                    + "<tbody id='tb_Body_Contratos'>";
                            var conMT = 1;
                            $.each(item.mett, function (j, itemMT) {
                                tabMT += "<tr class='selected'>";
                                tabMT += "<td>" + conMT + "</td>";
                                tabMT += "<td>" + itemMT.dmet + "</td>";
                                tabMT += "<td>" + itemMT.meta + "</td>";
                                tabMT += "<td>" + itemMT.metproy + "</td></tr>";

                                conMT++;
                            });

                            tabMT += "</tbody>"
                                    + "</table>";
                        } else {
                            tabMT = "<div class='col-md-12'><h5>Este Proyecto no esta relacionado con ninguna Meta Trazadora</h5></div>";

                        }

                        $("#ContGenProy").append(tabMT);
                        $("#ContGenProy").append("<div class='col-md-12'><h4>METAS DE PRODUCTO</h4></div>");

                        if (item.ContMP > 0) {
                            var tabMP = "<table class='table table-striped table-hover table-bordered '>"
                                    + "<thead>"
                                    + "    <tr>"
                                    + "        <th>"
                                    + "            <i class='fa fa-angle-right'></i> #"
                                    + "        </th>"
                                    + "        <th>"
                                    + "            <i class='fa fa-angle-right'></i> Descripción"
                                    + "        </th>"
                                    + "       <th>"
                                    + "            <i class='fa fa-angle-right'></i> Objetivo"
                                    + "        </th>"
                                    + "       <th>"
                                    + "            <i class='fa fa-angle-right'></i> Aporte del Proyecto"
                                    + "        </th>"
                                    + "   </tr>"
                                    + "</thead>"
                                    + "<tbody id='tb_Body_Contratos'>";
                            var conMP = 1;
                            $.each(item.metp, function (j, itemMP) {
                                tabMP += "<tr class='selected'>";
                                tabMP += "<td>" + conMP + "</td>";
                                tabMP += "<td>" + itemMP.dmet + "</td>";
                                tabMP += "<td>" + itemMP.meta + "</td>";
                                tabMP += "<td>" + itemMP.metproy + "</td></tr>";

                                conMP++;
                            });

                            tabMP += "</tbody>"
                                    + "</table>";
                        } else {
                            var tabMP = "<div class='col-md-12'><h5>Este Proyecto no esta relacionado con ninguna Meta de Producto</h5></div>";

                        }

                        $("#ContGenProy").append(tabMP);


                        $("#ContGenProy").append("<div class='col-md-12'><h4>HISTORIAL DE MEDICIÓN INDICADORES.</h4></div>");

                        if (item.MedIn.length > 0) {
                            $.each(item.MedIn, function (j, itemInd) {
                                $("#ContGenProy").append("<div class='col-md-12'><label style='font-size: 16px; text-transform: capitalize; font-weight: bold;'>Indicador: " + itemInd.nombInd + "</label></div>");
                                var k = 1;
                                $.each(itemInd.Metas, function (j, itemMet) {

                                    $("#ContGenProy").append("<div class='col-md-12'><label style='font-size: 14px; text-transform: capitalize; font-weight: bold; padding-top: 15px;'>Meta: " + itemMet.nombmet + "</label></div>");
                                    $("#ContGenProy").append('<div id="chartdivHisMed' + k + '" style=" width: 100%; height: 400px;" class="chart"></div>');

                                    $.GrafHisMe(k, itemMet.ResulInd);
                                    k++;

                                });

                            });

                        } else {
                            $("#ContGenProy").append("<div class='col-md-12'><h5>Este Proyecto no esta relacionado a Ningun Indicador</h5></div>");

                        }




                        $("#ContGenProy").append("<div class='col-md-12'><h4>CONTRATOS RELACIONADOS AL PROYECTO</h4></div>");

                        $("#ContGenProy").append('<div id="chartdivEstaCont" style=" width: 100%; height: 400px;" class="chart"></div>');

                        chartEstCon = am4core.create("chartdivEstaCont", am4charts.PieChart3D);
                        am4core.useTheme(am4themes_animated);
                        chartEstCon.innerRadius = am4core.percent(20);
                        chartEstCon.paddingTop = 0;
                        chartEstCon.marginTop = 0;
                        chartEstCon.valign = 'top';
                        chartEstCon.contentValign = 'top';

                        var pieSeries = chartEstCon.series.push(new am4charts.PieSeries3D());
                        chartEstCon.data = item.estc;
                        pieSeries.dataFields.value = "cant";
                        pieSeries.dataFields.category = "cate";
                        pieSeries.slices.template.cornerRadius = 6;
                        pieSeries.labels.template.text = "{category}: {value} ({value.percent.formatNumber('#.0')}%)";


                        if (item.contr.length > 0) {
                            $.each(item.contr, function (j, itemCO) {
                                $("#ContGenProy").append("<div class='col-md-12'><h5 style='style=font-weight: bold;font-style: italic;'><b>DETALLES DEL CONTRATO - " + itemCO.num + "</h5></b></div>");
                                $("#ContGenProy").append("<div class='col-md-12'><b>Objeto:</b><br> " + itemCO.obj + "</div>");

                                var colesta = "";
                                if (itemCO.estado === "Ejecucion") {
                                    colesta = "#2ED26E";
                                } else if (itemCO.estado === "Terminado") {
                                    colesta = "#387EFC";
                                } else if (itemCO.estado === "Suspendido") {
                                    colesta = "#EA4359";
                                } else if (itemCO.estado === "Liquidado") {
                                    colesta = "#FDC20D";
                                }
                                $("#ContGenProy").append("<div class='col-md-6'><b>Contratista:</b><br> " + itemCO.ctta + "</div><div class='col-md-3'><b>Porcetaje Avance:</b><br> " + itemCO.pava + "</div><div class='col-md-3'><b>Estado:</b><br><label style='color:" + colesta + "'> " + itemCO.estado.replace('Ejecucion', 'Ejecución') + "</label></div>");
                                $("#ContGenProy").append("<div class='col-md-4'><b>Valor Contrato:</b><br> " + itemCO.vcont + "</div><div class='col-md-3'><b>Valor Adición:</b><br> " + itemCO.vadic + "</div><div class='col-md-3'><b>Valor Final:</b><br> " + itemCO.vfinal + "</div><div class='col-md-3'><b>Valor Ejecutado:</b><br> " + itemCO.vejec + "</div>");

                                if (itemCO.imgEC.length > 0) {
                                    var tabImg = "<div class='col-md-12'><h5>Registro Fotografico del Contrato</h5></div>";

                                    $.each(itemCO.imgEC, function (l, itemIM) {
                                        tabImg += "<div class='col-md-4'><b>" + itemIM.tip_galeria + "</b><br><img src=" + itemIM.img_galeria + " width='250' height='170'>&nbsp;</div>";
                                    });

                                } else {
                                    var tabImg = "<div class='col-md-12'><h5>Este Contrato no tiene Ningún Registro Fotografico</h5></div>";

                                }

                                $("#ContGenProy").append(tabImg);

                            });

                        } else {
                            var tabCO = "<div class='col-md-12'><h5>Este Proyecto no esta relacionado con ningún Contrato</h5></div>";

                        }

                    });


                }});

            $("#ContGenProy").append("</div");



        },
        GrafHisMe: function (k, datos) {


// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
            var chartP = am4core.create("chartdivHisMed" + k, am4charts.XYChart);

// Export
            chartP.exporting.menu = new am4core.ExportMenu();

// Data for both series
            var data = datos;

            /* Create axes */
            var categoryAxis = chartP.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "anio2";
            categoryAxis.renderer.minGridDistance = 30;

            /* Create value axis */
            var valueAxis = chartP.yAxes.push(new am4charts.ValueAxis());

            /* Create series */
            var columnSeries = chartP.series.push(new am4charts.ColumnSeries());
            columnSeries.name = "Resultado";
            columnSeries.dataFields.valueY = "resulindi";
            columnSeries.dataFields.categoryX = "anio2";

            columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} en {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
            columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
            columnSeries.columns.template.propertyFields.stroke = "stroke";
            columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
            columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
            columnSeries.tooltip.label.textAlign = "middle";

            var lineSeries = chartP.series.push(new am4charts.LineSeries());
            lineSeries.name = "Meta";
            lineSeries.dataFields.valueY = "meta";
            lineSeries.dataFields.categoryX = "anio2";

            lineSeries.stroke = am4core.color("#fdd400");
            lineSeries.strokeWidth = 3;
            lineSeries.propertyFields.strokeDasharray = "lineDash";
            lineSeries.tooltip.label.textAlign = "middle";

            var bullet = lineSeries.bullets.push(new am4charts.Bullet());
            bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
            bullet.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]";
            var circle = bullet.createChild(am4core.Circle);
            circle.radius = 4;
            circle.fill = am4core.color("#fff");
            circle.strokeWidth = 3;

            var labelBullet = lineSeries.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.verticalCenter = "bottom";
            labelBullet.label.dy = -10;
            labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";

            var labelBullet2 = columnSeries.bullets.push(new am4charts.LabelBullet());
            labelBullet2.label.verticalCenter = "bottom";
            labelBullet2.label.dy = -10;
            labelBullet2.label.text = "{values.valueY.workingValue.formatNumber('#.')}";

            chartP.data = data;


            chartP.exporting.getImage("png").then(function (imgData) {
//                           $("#Src_img" + x).log(imgData);

                var datos = {
                    ope: "InserImgProy",
                    img: imgData
                };
                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
//                                  $("#Src_img" + x).val(data['img']);
                    }
                });

            });


        },

        Graficar9: function () {
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Contr = $('#CbContratos').val();
            var Ncont = "";

            var SubTit = "";
            if (Contr === " ") {
                Contr = "";
            } else {
                var parcont = Contr.split("/");
                Contr = parcont[0];
                Ncont = parcont[1];
            }

            var SubTit = "";
            if (Contr === "") {
                $.Alert("#msg", "Por Favor seleccione un Contrato...", "warning", "warning");
                return;
            }

            GrafGenCont
            $("#ContGenCont").html("");
            $("#ContGenCont").append("<div class='form-body'>");

            $("#TitInfoGenCont").html(TextTipRepor);

            var datos = {
                idContr: Contr,
                Contr: Ncont,
                ope: "InfGenContratos"
            };
            $("#ContGenCont").append("<div class='row'>");
            var NumPoliza = "";
            var FIniPoliza = "";
            var FFinPoliza = "";

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $.each(data.RawContra, function (i, item) {
                        $("#ContGenCont").append("<div class='col-md-12'><h4>DETALLES DEL CONTRATO</h4></div>");
                        $("#ContGenCont").append("<div class='col-md-4'><b>Numero:</b><br> " + item.num + "</div>");
                        $("#ContGenCont").append("<div class='col-md-4'><b>Fecha Creación:</b><br> " + item.fech + "</div><div class='col-md-4'><b>Tipologia Contrato:</b><br> " + item.tipol + "</div>");
                        $("#ContGenCont").append("<div class='col-md-12'><b>Objeto:</b><br> " + item.obj + "</div>");
                        $("#ContGenCont").append("<div class='col-md-3'><b>Valor:</b><br> " + item.valor + "</div><div class='col-md-3'><b>Valor Adición:</b><br> " + item.vadic + "</div><div class='col-md-3'><b>Valor Final:</b><br> " + item.vfin + "</div><div class='col-md-3'><b>Valor Ejecutado:</b><br> " + item.veje + "</div>");
                        var colesta = "#000";
                        if (item.estado === "Ejecucion") {
                            colesta = "#2ED26E";
                        } else if (item.estado === "Terminado") {
                            colesta = "#387EFC";
                        } else if (item.estado === "Suspendido") {
                            colesta = "#EA4359";
                        } else if (item.estado === "Liquidado") {
                            colesta = "#FDC20D";
                        }
                        $("#ContGenCont").append("<div class='col-md-2'><b>Estado:</b><br> <label style='color:" + colesta + "'> " + item.estado.replace('Ejecucion', 'Ejecución') + "</label></div><div class='col-md-2'><b>% Avance:</b><br> " + item.pava + "</div><div class='col-md-2'><b>Duración:</b><br> " + item.durc + "</div>");
                        $("#ContGenCont").append("<div class='col-md-3'><b>Fecha Inicio:</b><br> " + item.fini + "</div><div class='col-md-3'><b>Fecha. Finalización:</b><br> " + item.ffin + "</div>");
                        $("#ContGenCont").append("<div class='col-md-12'><b>Contratista:</b><br> " + item.nomctta + "</div><div class='col-md-12'><b>Secretaria:</b><br> " + item.secr + "</div>");
                        $("#ContGenCont").append("<div class='col-md-12'><b>Proyecto Asociado:</b><br> " + item.proyec + "</div>");

                        NumPoliza = item.npol;
                        FIniPoliza = item.finipol;
                        FFinPoliza = item.ffinpol;

                    });

                    $("#ContGenCont").append("<div class='col-md-12'><h4> GASTOS DEL CONTRATO.</h4></div>");

                    if (data.RawaGastos.length > 0) {
                        var tabGastos = "<table class='table table-striped table-hover table-bordered p-2'>"
                        + "<thead>"
                        + "    <tr>"
                        + "        <th>"
                        + "            <i class='fa fa-angle-right'></i> #"
                        + "        </th>"
                        + "        <th>"
                        + "            <i class='fa fa-angle-right'></i> Fecha"
                        + "        </th>"
                        + "       <th>"
                        + "            <i class='fa fa-angle-right'></i> Descripción"
                        + "        </th>"
                        + "       <th>"
                        + "            <i class='fa fa-angle-right'></i> Valor"
                        + "        </th>"
                        + "   </tr>"
                        + "</thead>"
                        + "<tbody id='tb_Body_Polizas>";
                      let conG=1;
                      let total=0;
                $.each(data.RawaGastos, function (j, itemGas) {
                    tabGastos += "<tr class='selected'>";
                    tabGastos += "<td>" + conG + "</td>";
                    tabGastos += "<td>" + itemGas.fecha + "</td>";
                    tabGastos += "<td>" + itemGas.ngasto+ " - "+itemGas.descr + "</td>";
                    tabGastos += "<td>" + formatCurrency(itemGas.val, "es-CO", "COP") + "</td></tr>";
                    conG++;
                    total+=parseFloat(itemGas.val);
                });

                    tabGastos += "</tbody> <tfoot>"
                    + "<tr>"
                    + "   <th colspan='3' style='text-align: right;'>Total gastos:</th>"
                    + "    <th colspan='1'><label id='gtotalGasto' style='font-weight: bold;'>"+formatCurrency(total, "es-CO", "COP")+"</label></th>"
                    + " </tr>"
                    + " </tfoot>"
                    
                              + "</table>";
                    $("#ContGenCont").append(tabGastos);

                    }else{
                        $("#ContGenCont").append("<div class='col-md-4'>Este contrato no tiene gastos reladcionados:<br></div>");
                    }
                    

                    $("#ContGenCont").append("<div class='col-md-12'><h4>POLIZAS DEL CONTRATO.</h4></div>");
                    if (data.RawaPolizas.length > 0) {
                        var tabPolizas = "<table class='table table-striped table-hover table-bordered p-2'>"
                        + "<thead>"
                        + "    <tr>"
                        + "        <th>"
                        + "            <i class='fa fa-angle-right'></i> #"
                        + "        </th>"
                        + "        <th>"
                        + "            <i class='fa fa-angle-right'></i> Descripción"
                        + "        </th>"
                        + "       <th>"
                        + "            <i class='fa fa-angle-right'></i> Fecha de inicio"
                        + "        </th>"
                        + "       <th>"
                        + "            <i class='fa fa-angle-right'></i> Fecha de finalización"
                        + "        </th>"
                        + "   </tr>"
                        + "</thead>"
                        + "<tbody id='tb_Body_Polizas>";
                      let conP=1;
                $.each(data.RawaPolizas, function (j, itemPol) {
                    tabPolizas += "<tr class='selected'>";
                    tabPolizas += "<td>" + conP + "</td>";
                    tabPolizas += "<td>" + itemPol.num_poliza+ " - "+itemPol.descripcion + "</td>";
                    tabPolizas += "<td>" + itemPol.fecha_ini + "</td>";
                    tabPolizas += "<td>" + itemPol.fecha_fin + "</td></tr>";

                    conP++;
                });

                tabPolizas += "</tbody>"
                           + "</table>";
                    $("#ContGenCont").append(tabPolizas);

                    }else{
                        $("#ContGenCont").append("<div class='col-md-4'>Este contrato no tiene una poliza relacionada:<br></div>");

                    }

                    if (data.RawConSusp.length > 0) {
                        $("#ContGenCont").append("<div class='col-md-12'><h4>SUSPENSIÓN DEL CONTRATO.</h4></div>");
                        $.each(data.RawConSusp, function (i, item) {
                            $("#ContGenCont").append("<div class='col-md-4'><b>Fecha de Supensión:</b><br> " + item.fsusp_contrato + "</div><div class='col-md-8'><b>Motivo de Suspensión:</b><br> " + item.observacion + "</div>");
                        });
                    }

                    if (data.RawConPro.length > 0) {
                        $("#ContGenCont").append("<div class='col-md-12'><h4>PRORROGA DE CONTRATO.</h4></div>");
                        $.each(data.RawConPro, function (i, item) {
                            $("#ContGenCont").append("<div class='col-md-4'><b>Tiempo Prorroga:</b><br> " + item.prorg_contrato + "</div><div class='col-md-4'><b>Fecha Finlalización:</b><br> " + item.ffin_contratoP + "</div><div class='col-md-12'><b>Motivo de Prorroga:</b><br> " + item.observacion + "</div>");

                        });
                    }
                    if (data.RawaAtra.length > 0) {
                        $("#ContGenCont").append("<div class='col-md-12'><h4>CONTRATO ATRASADO.</h4></div>");
                        $.each(data.RawaAtra, function (i, item) {
                            $("#ContGenCont").append("<div class='col-md-12'><b>Justificación de Atraso:</b><br> " + item.just + "</div>");

                        });
                    }
                    if (data.RawUbiCon.length > 0) {
                        var ContUbi = 1;
                        $("#ContGenCont").append("<div class='col-md-12'><h4>UBICACIÓN DE CONTRATO.</h4></div>");
                        $.each(data.RawUbiCon, function (i, item) {
                            $("#ContGenCont").append("<div class='col-md-12'><b>" + ContUbi + ". </b>" + item.Ubic + "</div>");
                            ContUbi++;
                        });
                    }

                    if (data.RawFotosA.length > 0) {
                        var tabImg = "<div class='col-md-12'><h4>TREGISTRO FOTOGRAFICO DEL CONTRATO</h4></div>";

                        $.each(data.RawFotosA, function (l, itemIM) {
                            tabImg += "<div class='col-md-4'><b>" + itemIM.tip_galeria + "</b><br><img src=" + itemIM.img_galeria + " width='250' height='170'>&nbsp;</div>";
                        });

                    } else {
                        var tabImg = "<div class='col-md-12'><h5>Este Contrato no tiene Ningún Registro Fotografico</h5></div>";

                    }

                    $("#ContGenCont").append(tabImg);


                }});

            $("#ContGenCont").append("</div></div>");



        },
        Graficar10: function () {
            ////OCTENER PARÁMETROS
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();


            var SubTit = "";
//            if (Contr === " ") {
//                $.Alert("#msg", "Por Favor seleccione el Contrato...", "warning", "warning");
//                return;
//            }

            $("#TitInfoMapsCal").html(TextTipRepor);


            var adressDep = $('#CbDep option:selected').text().split(' - ');
            var adressMun = $('#CbMun option:selected').text().split(' - ');
            codeAddress2('COLOMBIA, ' + adressDep[1] + ", " + adressMun[1]);
            initialize3();



        },
        savePDF: function () {

            Promise.all([
                chart.exporting.pdfmake,
                chart.exporting.getImage("png")
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [40, 50, 50, 60],
                    content: []
                };

                doc.content.push({
                    text: "INFORME GENERAL POR POBLACIÓN ESPECIFICA.",
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 0, 0, 10]
                });

                ////OCTENER PARÁMETROS
                var TipRepor = $('#CbTipInf').val();
                var TextTipRepor = $('#CbTipInf option:selected').text();
                var Grupo = $('#CbGrupEtn').val();
                var TextGrupo = $('#CbGrupEtn option:selected').text();
                var Genero = $('#CbGenero').val();
                var TextGenero = $('#CbGenero option:selected').text();
                var Edad = $('#CbEdad').val();
                var TextEdad = $('#CbEdad option:selected').text();

                $("#TitInfo").html(TextTipRepor);

                var SubTit = "Proyectos Asociado";

                if (Grupo !== "") {
                    SubTit += " al Grupo Étnico  " + TextGrupo;
                } else {
                    SubTit += " a todos los grupos Étnicos, ";
                }

                if (Edad !== "") {
                    SubTit += " perteneciente al curso de vida de " + TextEdad;
                } else {
                    SubTit += " perteneciente a todos los cursos de vida";
                }

                if (Genero !== "") {
                    SubTit += " de genero " + TextGenero;
                } else {
                    SubTit += " de todos los géneros.";
                }

                doc.content.push({
                    text: SubTit,
                    fontSize: 11,
                    alignment: 'justify',
                    margin: [0, 0, 0, 5]
                });

                doc.content.push({
                    text: "Grafica de Proyectos por Secretarias.",
                    fontSize: 13,
                    bold: true,
                    margin: [0, 10, 0, 5]
                });

                doc.content.push({
                    image: res[1],
                    width: 530
                });

                doc.content.push({
                    text: "Proyectos y Contratos Relacionados a la Población por Secretaria.",
                    fontSize: 13,
                    bold: true,
                    margin: [0, 10, 0, 5]
                });

                // Add otra información
                var InfInv = "La Población Asociada";

                if (Grupo !== "") {
                    InfInv += " al grupo Étnico " + TextGrupo;
                } else {
                    InfInv += " a todos los grupos Étnicos, ";
                }

                if (Edad !== "") {
                    InfInv += " perteneciente al curso de vida de " + TextEdad;
                } else {
                    InfInv += " pertenecientes a todos los cursos de vida";
                }

                if (Genero !== "") {
                    InfInv += " de género " + TextGenero;
                } else {
                    InfInv += " de todos los géneros.";
                }

                var datos = {
                    proy: $("#CbProy").val(),
                    Grupo: Grupo,
                    Genero: Genero,
                    Edad: Edad,
                    InfInv: InfInv,
                    ope: "InfGenPoblacion"
                };

                var Inv = "SI";


                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {

                        var porcinv = 0;
                        $.each(data.RawSec, function (j, item) {
                            doc.content.push({text: item.dessec, fontSize: 12, bold: true, italics: false, margin: [0, 15, 0, 0]});

                            $.each(item.proy, function (j, itemP) {
                                doc.content.push({text: itemP.codproy + ' - ' + itemP.nomproy, fontSize: 11, bold: true, italics: false, margin: [0, 5, 0, 0]});
                                if (itemP.Contratos.length == 0) {
                                    doc.content.push({
                                        text: "NO TIENE RELACIOANADO NINGÚN CONTRATO.",
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 13,
                                        bold: false,
                                        margin: [0, 10, 0, 5]
                                    });
                                } else {

                                    
                                    doc.content.push({text: 'Contratos por Proyecto', fontSize: 10, bold: true, italics: true, margin: [0, 5, 0, 0]},
                                            {
                                                table: {
                                                    widths: ['10%', '55%', '15%', '10%', '10%'],
                                                    body: [
                                                        ['Número', 'Objeto del Contrato', 'Valor', 'Estado', '% Avance']

                                                    ]
                                                },
                                                layout: {
                                                    hLineWidth: function (i, node) {
                                                        return 0.3; // Grosor de la línea horizontal
                                                    },
                                                    vLineWidth: function (i, node) {
                                                        return 0.3; // Grosor de la línea vertical
                                                    },
                                                    hLineColor: function (i, node) {
                                                        return '#000000'; // Color de la línea horizontal
                                                    },
                                                    vLineColor: function (i, node) {
                                                        return '#000000'; // Color de la línea vertical
                                                    }
                                                },
                                                fontSize: 10,
                                                bold: true,
                                                fillColor: '#E8E9E9'

                                            }
                                    );

                                    $.each(itemP.Contratos, function (y, itemC) {
                                        var colesta = "";
                                        if (itemC.estado === "Ejecucion") {
                                            colesta = "#2ED26E";
                                        } else if (itemC.estado === "Terminado") {
                                            colesta = "#387EFC";
                                        } else if (itemC.estado === "Suspendido") {
                                            colesta = "#EA4359";
                                        } else if (itemC.estado === "Liquidado") {
                                            colesta = "#FDC20D";
                                        }
                                        doc.content.push({

                                            table: {
                                                widths: ['10%', '55%', '15%', '10%', '10%'],
                                                body: [
                                                    [itemC.numcont, itemC.obj, itemC.total, {text: itemC.estado.replace('Ejecucion', 'Ejecución'), bold: true, italics: true, color: colesta}, {text: itemC.porava, bold: true, italics: true}]
                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },

                                            fontSize: 8,
                                            bold: true
                                        }
                                        );
                                    });

                                }

                            });
                            if (Inv === "SI") {
                                porcinv = (item.inv * 100) / item.presupuesto;
                                doc.content.push({text: 'Detalle de Inversión', fontSize: 10, bold: true, italics: false, margin: [0, 10, 0, 0]});
                                doc.content.push({text: 'El presupuesto asignado para esta secretaria es de $ ' + number_format2(item.presupuesto, 2, ',', '.') + ', con una inversión de $ ' + number_format2(item.inv, 2, ",", ".") + ' distribuidos en ' + item.nproy + ' Proyecto(s), que representa el ' + porcinv.toFixed(2) + '% del presupuesto incial, que beneficiarán a ' + item.tpers + ' Personas de ' + InfInv + '', fontSize: 9, italics: false, margin: [0, 5, 0, 0]});
                            }
                        });

                        /////CARGAR OTROR PROYECTOS
                        if (data.RawOtrosPro.length > 0) {
                            doc.content.push({text: 'Otros Proyectos', fontSize: 10, bold: true, italics: true, margin: [0, 10, 0, 0]},
                                    {
                                        table: {
                                            widths: ['10%', '90%', '10%'],
                                            body: [
                                                ['#', 'Proyecto',  'Estado']

                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 10,
                                        bold: true,
                                        fillColor: '#E8E9E9'

                                    }
                            );
                            var contP = 1;
                            $.each(data.RawOtrosPro, function (y, itemP) {
                                var colesta = "";

                                if (itemP.estado === "En Ejecucion") {
                                    colesta = "#2ED26E";
                                } else if (itemP.estado === "Ejecutado") {
                                    colesta = "#387EFC";
                                } else if (itemP.estado === "Priorizados") {
                                    colesta = "#1BBC9B";
                                } else if (itemP.estado === "Radicado") {
                                    colesta = "#EA4359";
                                } else if (itemP.estado === "Registrado") {
                                    colesta = "#FDC20D";
                                } else if (itemP.estado === "No Viabilizado") {
                                    colesta = "#FDC20D";
                                }
                                doc.content.push({

                                    table: {
                                        widths: ['10%', '65%', '15%', '10%'],
                                        body: [
                                            [itemP.codproy, itemP.nproy, {text: itemP.estado.replace('En Ejecucion', 'En Ejecución'), bold: true, italics: true, color: colesta}]
                                        ]
                                    },
                                    layout: {
                                        hLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea horizontal
                                        },
                                        vLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea vertical
                                        },
                                        hLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea horizontal
                                        },
                                        vLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea vertical
                                        }
                                    },
                                    fontSize: 8,
                                    bold: true
                                }
                                );
                                contP++;
                            });

                        }


//                        doc.content.push({text: InfInv, fontSize: 10, bold: true, italics: false, margin: [0, 10, 0, 0]});


                    }});

                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });

        },
        savePDFSecr: function () {

            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();
            var SubTit = "";
            var Resum = "";

            Promise.all([
                chart.exporting.pdfmake,
                chart.exporting.getImage("png")
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };

                var parsecr = TextSecre.split(" - ");
                doc.content.push({
                    text: "INFORME GENERAL " + parsecr[1],
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });


                var datos = {
                    Secre: Secre,
                    ope: "InfGenSecretaria"
                };


                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        if(data['totalpre']==0){
                            SubTit = "La " + parsecr[1].toLowerCase() + ", no cuenta con un Presupuesto inicial";
                            Resum = "";
                        
                        }else{
                            SubTit = "La " + parsecr[1].toLowerCase() + ", Cuenta con un Presupuesto inicial de " + '$ ' + number_format2(data['totalpre'], 2, ',', '.');
                            porcinv = (data['inv'] * 100) / data['totalpre'];
                            Resum = "Del Presupuesto asignado de $ " + number_format2(data['totalpre'], 2, ',', '.') + " a la " + parsecr[1].toLowerCase() + " Evidencia una inversión de $ " + number_format2(data['inv'], 2, ',', '.') + ". Que representa el " + Math.round(porcinv) + "% del Presupuesto Inicial";
    
                        }
                        
                      
                        doc.content.push({
                            text: "Grafica de Proyectos por Secretarias.",
                            fontSize: 13,
                            bold: true,
                            margin: [0, 10, 0, 5]
                        });

                        doc.content.push({
                            text: SubTit,
                            fontSize: 11,
                            alignment: 'justify',
                            margin: [0, 0, 0, 5]
                        });

                        doc.content.push({
                            image: res[1],
                            width: 530
                        });

                        doc.content.push({
                            text: "Metas Trazadoras por Proyectos.",
                            fontSize: 13,
                            bold: true,
                            margin: [0, 20, 0, 0]
                        });

                        var conMe = 1;
                        if (data.RawProyM.length > 0) {
                            $.each(data.RawProyM, function (i, itemP) {
                                doc.content.push({
                                    text: itemP.nombre,
                                    fontSize: 11,
                                    bold: true,
                                    margin: [0, 15, 0, 10]
                                });

                                conMe = 1;
                                if (itemP.Metas.length > 0) {
                                    $.each(itemP.Metas, function (i, itemM) {
                                        doc.content.push({
                                            text: conMe + ". " + itemM.desmet,
                                            fontSize: 10,
                                            italic: true,
                                            margin: [0, 0, 0, 0]
                                        });
                                        conMe++;
                                    });
                                } else {
                                    doc.content.push({
                                        text: "Este Proyecto no tiene asociada ninguna Meta Trazadora.",
                                        fontSize: 10,
                                        bold: false,
                                        margin: [0, 5, 0, 5]
                                    });
                                }

                            });
                        } else {
                            doc.content.push({
                                text: "Esta Secretaria no tiene asociado ningún proyecto con Metas Trazadora",
                                fontSize: 12,
                                bold: false,
                                margin: [0, 5, 0, 5]
                            });

                        }


                        doc.content.push({
                            text: "Contratos por Proyectos.",
                            fontSize: 13,
                            bold: true,
                            margin: [0, 5, 0, 5]
                        });


                        $.each(data.proyect, function (j, item2) {
                            doc.content.push({text: item2.codproy + ' - ' + item2.nombproy, fontSize: 10, bold: true, italics: true, margin: [0, 5, 0, 0]});
                            doc.content.push({
                                text: "Contratos.", style: 'subheader'},
                                    {
                                        table: {
                                            widths: ['8%', '49%', '20%', '15%', '8%'],
                                            body: [
                                                ['Número', 'Objeto del Contrato', 'Contratista', 'Valor', 'Estado']

                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 9,
                                        bold: true,
                                        fillColor: '#E8E9E9'

                                    }
                            );

                            $.each(item2.Contratos, function (y, item3) {
                                if (item3.ncont === "No") {

                                    doc.content.push({

                                        table: {
                                            widths: ['45%', '20%', '10%', '10%', '15%'],
                                            body: [
                                                [{text: 'Este Proyecto No tiene Relacionado Ningún Contrato.', style: 'tableHeader', colSpan: 5, fontSize: 9, alignment: 'center'}]
                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 8,
                                        bold: true,
                                        margin: [0, 0, 0, 15]
                                    });

                                } else {
                                    var colesta = "";
                                    if (item3.estado === "Ejecucion") {
                                        colesta = "#2ED26E";
                                    } else if (item3.estado === "Terminado") {
                                        colesta = "#387EFC";
                                    } else if (item3.estado === "Suspendido") {
                                        colesta = "#EA4359";
                                    } else if (item3.estado === "Liquidado") {
                                        colesta = "#FDC20D";
                                    }
                                    doc.content.push({

                                        table: {
                                            widths: ['8%', '49%', '20%', '15%', '8%'],
                                            body: [
                                                [item3.ncont, item3.obj, item3.descontita, item3.total, {text: item3.estado.replace('Ejecucion', 'Ejecución'), bold: true, italics: true, color: colesta}]
                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },

                                        fontSize: 8,
                                        bold: true
                                    }
                                    );
                                }

                            });

                        });
                    }});

                doc.content.push({
                    text: Resum,
                    fontSize: 11,
                    alignment: 'justify',
                    margin: [0, 10, 0, 5]
                });

                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });

        },
        savePDFContxProy: function () {

            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();
            var SubTit = "";
            var Resum = "";

            if (Secre === " ") {
                Secre = "";
            }

            Promise.all([
                chart2.exporting.pdfmake,
                chart2.exporting.getImage("png")
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };

                var parsecr = TextSecre.split(" - ");
                doc.content.push({
                    text: TextTipRepor,
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });


                doc.content.push({
                    text: TextSecre.replace('Todas...', 'Todas las Secretarias'),
                    fontSize: 13,
                    bold: true,
                    margin: [0, 10, 0, 5]
                });

                var datos = {
                    Secre: Secre,
                    ope: "InfGenContxProy"
                };

             
                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                     
                        if(data.RawProy.length > 0){

                        doc.content.push({
                            image: res[1],
                            width: 530
                        });
        
                        $.each(data.RawProy, function (j, item2) {
                            doc.content.push({text: item2.codproy, fontSize: 10, bold: true, italics: true, margin: [0, 10, 0, 0]}, {text: item2.nomproy, fontSize: 10, bold: false, italics: true, margin: [0, 5, 0, 0]}, {text: '(' + item2.poravan + ') Completado', fontSize: 10, bold: false, italics: true, color: 'green', margin: [0, 0, 0, 5]});
                           doc.content.push({
                                text: "Contratos.", style: 'subheader'},
                                    {
                                        table: {
                                            widths: ['8%', '45%', '15%', '15%', '10%', '7%'],
                                            body: [
                                                ['Número', 'Objeto del Contrato', 'Contratista', 'Valor', 'Estado', '% de Avance']

                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 10,
                                        bold: true,
                                        fillColor: '#E8E9E9'

                                    }
                            );

                            $.each(item2.Contratos, function (y, item3) {
                                var colesta = "";
                                if (item3.estado === "Ejecucion") {
                                    colesta = "#2ED26E";
                                } else if (item3.estado === "Terminado") {
                                    colesta = "#387EFC";
                                } else if (item3.estado === "Suspendido") {
                                    colesta = "#EA4359";
                                } else if (item3.estado === "Liquidado") {
                                    colesta = "#FDC20D";
                                }
                                doc.content.push({

                                    table: {
                                        widths: ['8%', '45%', '15%', '15%', '10%', '7%'],
                                        body: [
                                            [item3.numcont, item3.obj, item3.descontita, item3.total, {text: item3.estado.replace('Ejecucion', 'Ejecución'), bold: true, italics: true, color: colesta}, {text: item3.porava, bold: true, italics: true}]

                                        ]
                                    },
                                    layout: {
                                        hLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea horizontal
                                        },
                                        vLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea vertical
                                        },
                                        hLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea horizontal
                                        },
                                        vLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea vertical
                                        }
                                    },
                                    fontSize: 8,
                                    bold: true
                                }
                                );
                            });

                        });
                        }else{
                            doc.content.push({
                                text: "NO EXISTEN CONTRATOS RELACIONADOS A ESTOS PARÁMETROS DE BUSQUEDA",
                                fontSize: 13,
                                bold: true,
                                margin: [0, 10, 0, 5]
                            });
                        }

                    }});


                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });

        },
        savePDFContAtraSusp: function () {

            console.log(chartImages);
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            var TextSecre = $('#CbSecre option:selected').text();
            var SubTit = "";
            var Resum = "";

            if (Secre === " ") {
                Secre = "";
            }

            Promise.all([
                chart.exporting.pdfmake
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };

                var parsecr = TextSecre.split(" - ");

                doc.content.push({
                    text: TextTipRepor,
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });


                var datos = {
                    Secre: Secre,
                    ope: "InfGenContSuspAtra"
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        var x = 0;
                        $.each(data.RawSec, function (i, item) {
                            doc.content.push({
                                text: item.dessec, style: 'subheader'});

                            doc.content.push({
                                image: chartImages[x],
                                width: 530,
                                alignment: 'center'

                            });
//                       
                            var dataRow = "";
                            $.each(item.Estad, function (j, item2) {
                                doc.content.push({
                                    text: 'CONTRATOS ' + item2.tipc, fontSize: 10, bold: false, italics: true, margin: [0, 7, 0, 0]});

                                doc.content.push(
                                        {
                                            table: {
                                                widths: ['8%', '40%', '15%', '10%', '7%', '20%'],
                                                body: [
                                                    ['Número', 'Objeto del Contrato', 'Contratista', 'Valor', '% de Avance', 'Justificación']

                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },
                                            fontSize: 9,
                                            bold: true,
                                            fillColor: '#E8E9E9'

                                        }
                                );

                                $.each(item2.Contratos, function (y, item3) {

                                    doc.content.push({

                                        table: {
                                            widths: ['8%', '40%', '15%', '10%', '7%', '20%'],
                                            body: [
                                                [item3.numcont, item3.obj, item3.descontita, item3.total, item3.porava, item3.justi]

                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 7,
                                        bold: true
                                    }
                                    );


                                });



                            });
                            doc.content.push({
                                text: item.ResInv, fontSize: 7, bold: false, italics: true, margin: [0, 5, 0, 10]});
                            x++;
                        });

                    }});


                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });

        },
        savePDFMetas: function () {

            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var CbEjes = $('#CbEjes').val();
            var TextEjes = $('#CbEjes option:selected').text();
            var CbProg = $('#CbEtrategias').val();
            var TextProg = $('#CbEtrategias option:selected').text();
            var CbSubProg = $('#CbProgramas').val();
            var TextSubProg = $('#CbProgramas option:selected').text();
            var CbTipMeta = $('#CbTipMeta').val();
            var TextTipMeta = $('#CbTipMeta option:selected').text();


            if (CbProg === " ") {
                CbProg = "";
            }
            if (CbSubProg === " ") {
                CbSubProg = "";
            }

            var SubTit = "";


            Promise.all([
                chart.exporting.pdfmake
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };

                doc.content.push({
                    text: "INFORME GENERAL DE METAS",
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });

                var datos = {
                    CbEjes: CbEjes,
                    CbProg: CbProg,
                    CbSubProg: CbSubProg,
                    CbTipMeta: CbTipMeta,
                    ope: "InfGenMetas"
                };

                let nivel1 = document.getElementById("nivel1").textContent;
                let nivel2 = document.getElementById("nivel2").textContent;
                let nivel3 = document.getElementById("nivel3").textContent;

                doc.content.push({text: [{text: nivel1+" ", fontSize: 10, bold: true, margin: [0, 10, 0, 0]}, {text: TextEjes, fontSize: 10, bold: false, italics: true, margin: [0, 5, 0, 0]}]});
                doc.content.push({text: [{text: nivel2+" ", fontSize: 10, bold: true, margin: [0, 10, 0, 0]}, {text: TextProg, fontSize: 10, bold: false, italics: true, margin: [0, 5, 0, 0]}]});
                doc.content.push({text: [{text: nivel3+" ", fontSize: 10, bold: true, margin: [0, 10, 0, 0]}, {text: TextSubProg, fontSize: 10, bold: false, italics: true, margin: [0, 5, 0, 0]}]});

                doc.content.push({
                    text: 'Listado de Metas ', fontSize: 13, bold: false, italics: false, margin: [0, 7, 0, 0]});

                doc.content.push(
                        {
                            table: {
                                widths: ['5%', '55%', '25%', '15%'],
                                body: [
                                    ['#', 'Descripción Meta', 'Meta', '% Cumplimiento']

                                ]
                            },
                            layout: {
                                hLineWidth: function (i, node) {
                                    return 0.3; // Grosor de la línea horizontal
                                },
                                vLineWidth: function (i, node) {
                                    return 0.3; // Grosor de la línea vertical
                                },
                                hLineColor: function (i, node) {
                                    return '#000000'; // Color de la línea horizontal
                                },
                                vLineColor: function (i, node) {
                                    return '#000000'; // Color de la línea vertical
                                }
                            },
                            fontSize: 10,
                            bold: true,
                            fillColor: '#E8E9E9'

                        }
                );

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        var ContM = 1;
                        if (data.ResumMetas.length > 0) {
                            $.each(data.ResumMetas, function (y, item3) {
                                doc.content.push({
                                    table: {
                                        widths: ['5%', '55%', '25%', '15%'],
                                        body: [
                                            [ContM, item3.DesMet, item3.Meta, item3.Cumplimiento + '%']
                                        ]
                                    },
                                    layout: {
                                        hLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea horizontal
                                        },
                                        vLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea vertical
                                        },
                                        hLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea horizontal
                                        },
                                        vLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea vertical
                                        }
                                    },
                                    fontSize: 8,
                                    bold: true
                                }
                                );

                                ContM++;
                            });
                        } else {
                            doc.content.push({

                                table: {
                                    widths: ['45%', '20%', '10%', '10%', '15%'],
                                    body: [
                                        [{text: 'No Existe ninguna Meta Relacioanda a estos Parámetros de Busqueda.', style: 'tableHeader', colSpan: 5, fontSize: 9, alignment: 'center'}]
                                    ]
                                },
                                layout: {
                                    hLineWidth: function (i, node) {
                                        return 0.3; // Grosor de la línea horizontal
                                    },
                                    vLineWidth: function (i, node) {
                                        return 0.3; // Grosor de la línea vertical
                                    },
                                    hLineColor: function (i, node) {
                                        return '#000000'; // Color de la línea horizontal
                                    },
                                    vLineColor: function (i, node) {
                                        return '#000000'; // Color de la línea vertical
                                    }
                                },
                                fontSize: 8,
                                bold: true,
                                margin: [0, 0, 0, 15]
                            });
                        }


                        doc.content.push({
                            text: 'Detalles de Medición de metas realizadas', fontSize: 13, bold: false, italics: false, margin: [0, 7, 0, 0]});
                        if (data.ResumMetas.length > 0) {
                            $.each(data.ResumMetas, function (y, item) {
                                if (item.DetMetProy.length > 0) {
//                            doc.content.push(
//                                    [{text: item.DesMet, fontSize: 13, bold: false, italics: false, margin: [0, 7, 0, 5]}, {text: ' (' + item.Meta + ')', fontSize: 13, bold: false, italics: true, margin: [0, 7, 0, 0]}]);
                                doc.content.push({text: [{text: item.DesMet, fontSize: 12, bold: true, margin: [10, 20, 0, 10]}, {text: '(Meta: ' + item.Meta + ')', fontSize: 10, bold: false, italics: true, margin: [0, 5, 0, 0]}]});

                                doc.content.push(
                                        {
                                            table: {
                                                widths: ['65%', '10%', '10%', '15%'],
                                                body: [
                                                    ['Nombre del Proyecto', 'Meta de Proyecto', 'Resultado Medición', ' % Cumplimiento']

                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },
                                            fontSize: 10,
                                            bold: true,
                                            fillColor: '#E8E9E9'

                                        }
                                );

                          
                                    $.each(item.DetMetProy, function (i, itemP) {

                                        doc.content.push({

                                            table: {
                                                widths: ['65%', '10%', '10%', '15%'],
                                                body: [
                                                    [itemP.nproy,  itemP.meta, itemP.resulindi, itemP.Cumpl + '%']

                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },
                                            fontSize: 8,
                                            bold: true
                                        });

                                    });

                                    doc.content.push({

                                        table: {
                                            widths: ['45%', '20%', '10%', '10%', '15%'],
                                            body: [
                                                [{text: 'Total: ' + item.Cumplimiento + '%', style: 'tableHeader', colSpan: 5, alignment: 'right'}]
                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 10,
                                        bold: true,
                                        fillColor: '#f2f2f2',
                                        margin: [0, 0, 0, 15]
                                    });
                                }
                            });
                        }
                    }
                });





                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });

        },
        savePDFProyEje: function () {
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Secre = $('#CbSecre').val();
            if (Secre === " ") {
                Secre = "";
            }

            var SubTit = "";

            Promise.all([
                chart.exporting.pdfmake
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };


                doc.content.push({
                    text: "INFORME GENERAL DE PROYECTOS EN EJECUCIÓN",
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });

                var datos = {
                    Secre: Secre,
                    ope: "InfGenProyEjeCont2"
                };


                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.RawSec.length > 0) {
                            $.each(data.RawSec, function (i, item) {
                                doc.content.push({
                                    text: item.dessec, style: 'subheader'});

//                            alert(item.dessec);
                                var dataRow = "";
                                $.each(item.proy, function (j, item2) {
                                    doc.content.push({
                                        text: item2.nomproy, fontSize: 10, bold: false, italics: true, margin: [0, 7, 0, 0]}, {text: '(' + item2.poravan + ') Completado', fontSize: 10, bold: false, italics: true, color: 'green', margin: [0, 0, 0, 5]});

                                    doc.content.push({
                                        text: "Contratos.", style: 'subheader'},
                                            {
                                                table: {
                                                    widths: ['8%', '45%', '15%', '15%', '10%', '7%'],
                                                    body: [
                                                        ['Número', 'Objeto del Contrato', 'Contratista', 'Valor', 'Estado', '% de Avance']

                                                    ]
                                                },
                                                layout: {
                                                    hLineWidth: function (i, node) {
                                                        return 0.3; // Grosor de la línea horizontal
                                                    },
                                                    vLineWidth: function (i, node) {
                                                        return 0.3; // Grosor de la línea vertical
                                                    },
                                                    hLineColor: function (i, node) {
                                                        return '#000000'; // Color de la línea horizontal
                                                    },
                                                    vLineColor: function (i, node) {
                                                        return '#000000'; // Color de la línea vertical
                                                    }
                                                },
                                                fontSize: 10,
                                                bold: true,
                                                fillColor: '#E8E9E9'

                                            }
                                    );

                                    if (item2.Contratos.length > 0) {
                                        $.each(item2.Contratos, function (y, item3) {
                                            var colesta = "";

                                            if (item3.numcont === "NOHAY") {
                                                doc.content.push({

                                                    table: {
                                                        widths: ['8%', '45%', '15%', '15%', '10%', '7%'],
                                                        body: [
                                                            [{text: 'Este Proyecto No tiene Relacionado Ningún Contrato.', style: 'tableHeader', colSpan: 6, fontSize: 9, alignment: 'center'}]
                                                        ]
                                                    },
                                                    layout: {
                                                        hLineWidth: function (i, node) {
                                                            return 0.3; // Grosor de la línea horizontal
                                                        },
                                                        vLineWidth: function (i, node) {
                                                            return 0.3; // Grosor de la línea vertical
                                                        },
                                                        hLineColor: function (i, node) {
                                                            return '#000000'; // Color de la línea horizontal
                                                        },
                                                        vLineColor: function (i, node) {
                                                            return '#000000'; // Color de la línea vertical
                                                        }
                                                    },
                                                    fontSize: 8,
                                                    bold: true
                                                }
                                                );
                                            } else {
                                                if (item3.estado === "Ejecucion") {
                                                    colesta = "#2ED26E";
                                                } else if (item3.estado === "Terminado") {
                                                    colesta = "#387EFC";
                                                } else if (item3.estado === "Suspendido") {
                                                    colesta = "#EA4359";
                                                } else if (item3.estado === "Liquidado") {
                                                    colesta = "#FDC20D";
                                                }
                                                doc.content.push({
                                                    table: {
                                                        widths: ['8%', '45%', '15%', '15%', '10%', '7%'],
                                                        body: [
                                                            [item3.numcont, item3.obj, item3.descontita, item3.total, {text: item3.estado.replace('Ejecucion', 'Ejecución'), bold: true, italics: true, color: colesta}, {text: item3.porava, bold: true, italics: true}]

                                                        ]
                                                    },
                                                    layout: {
                                                        hLineWidth: function (i, node) {
                                                            return 0.3; // Grosor de la línea horizontal
                                                        },
                                                        vLineWidth: function (i, node) {
                                                            return 0.3; // Grosor de la línea vertical
                                                        },
                                                        hLineColor: function (i, node) {
                                                            return '#000000'; // Color de la línea horizontal
                                                        },
                                                        vLineColor: function (i, node) {
                                                            return '#000000'; // Color de la línea vertical
                                                        }
                                                    },
                                                    fontSize: 8,
                                                    bold: true
                                                }
                                                );
                                            }
                                        });
                                    }
                                });
                                doc.content.push({
                                    text: item.ResInv, fontSize: 8, bold: false, italics: true, margin: [0, 5, 0, 10]});
                            });
                        } else {
                            doc.content.push({
                                text: "NO EXISTEN PROYECTOS RELACIONADOS A ESTOS PARÁMETROS DE BUSQUEDA ", style: 'subheader'});
                        }


                    }});

                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });
        },
        savePDFEvalContr: function () {
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Contr = $('#CbContratos').val();

            var SubTit = "";
            var Ncont = "";
            if (Contr === " ") {
                Contr = "";
            } else {
                var parcont = Contr.split("/");
                Contr = parcont[0];
                Ncont = parcont[1];
            }
            var SubTit = "";

            Promise.all([
                chart.exporting.pdfmake
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };

                doc.content.push({
                    text: "INFORME DE EVALUACIÓN DE CONTRATISTAS",
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });

                var datos = {
                    Contr: Contr,
                    Ncont: Ncont,
                    ope: "InfGenEvalCont"
                };


                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $.each(data.RawCtta, function (i, item) {

                            doc.content.push({
                                text: "CONTRATISTA - " + item.nombCtta,
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            $.each(item.Eval, function (j, item2) {

                                doc.content.push({
                                    text: "EVALUACIÓN DE CONTRATO - N° " + item2.ncont,
                                    alignment: 'left',
                                    fontSize: 11,
                                    bold: true,
                                    margin: [0, 15, 0, 5]
                                });

                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: 'Objeto:', bold: true, fontSize: 12
                                        },
                                        {
                                            width: 90,
                                            text: 'Valor:', bold: true, fontSize: 12
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: item2.obj, fontSize: 11
                                        },
                                        {
                                            width: 90,
                                            text: item2.valor, fontSize: 11
                                        }
                                    ]});

                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: 'Proyecto:', bold: true, fontSize: 12
                                        },
                                        {
                                            width: 150,
                                            text: 'Secretaria:', bold: true, fontSize: 12
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: item2.nproy, fontSize: 11
                                        },
                                        {
                                            width: 150,
                                            text: item2.secret, fontSize: 11
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: 'Fecha de Evaluacion:', bold: true, fontSize: 13
                                        },
                                        {
                                            width: '*',
                                            text: 'Calificación Obtenida:', bold: true, fontSize: 13
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: item2.fecha, fontSize: 12
                                        },
                                        {
                                            width: '*',
                                            text: item2.PuntTo, fontSize: 12, color: '#2ED26E'
                                        }
                                    ]});

                                doc.content.push({
                                    text: "CRITERIOS DE EVALUACIÓN",
                                    alignment: 'left',
                                    fontSize: 11,
                                    bold: true,
                                    margin: [0, 10, 0, 5]
                                });


                                doc.content.push({
                                    text: "1. Criterios Cumplimiento Y Oportunidad (Puntaje: " + item2.PuntCO + ") - (% Equivalente: " + item2.PorCO + ")",
                                    alignment: 'left',
                                    fontSize: 11,
                                    italics: true,
                                    margin: [0, 5, 0, 3]
                                }, {text: 'Analisis.', fontSize: 10, bold: true}, {text: item2.analisis_cumpli, fontSize: 9});


                                doc.content.push({
                                    text: "2. Criterios En La Ejecución Del Contrato (Puntaje: " + item2.PuntCE + ") - (% Equivalente: " + item2.PorCE + ")",
                                    alignment: 'left',
                                    fontSize: 11,
                                    italics: true,
                                    margin: [0, 10, 0, 3]
                                }, {text: 'Analisis.', fontSize: 10, bold: true}, {text: item2.analisis_ejec, fontSize: 9});


                                doc.content.push({
                                    text: "3. Criterios De Calidad (Puntaje: " + item2.PuntCC + ") - (% Equivalente: " + item2.PorCC + ")",
                                    alignment: 'left',
                                    fontSize: 11,
                                    italics: true,
                                    margin: [0, 10, 0, 3]
                                }, {text: 'Analisis.', fontSize: 10, bold: true}, {text: item2.analisis_calidad, fontSize: 9});


                                doc.content.push({
                                    text: "FORTALEZAS Y DEBILIDADES DE LA EVALUACIÓN",
                                    alignment: 'left',
                                    fontSize: 11,
                                    bold: true,
                                    margin: [0, 10, 0, 5]
                                });
                                if (item2.ContF > 0) {
                                    doc.content.push({
                                        text: "Fortalezas.",
                                        alignment: 'left',
                                        fontSize: 12,
                                        italics: true,
                                        margin: [0, 5, 0, 3]
                                    });

                                    $.each(item2.CritFort, function (j, item3) {
                                        doc.content.push({
                                            text: "- " + item3.criterioF + ". (Puntaje:" + item3.puntF + " )", fontSize: 10
                                        });

                                    });
                                }
                                if (item2.ContD > 0) {
                                    doc.content.push({
                                        text: "Debilidades y Oportunidad de Mejora.",
                                        alignment: 'left',
                                        fontSize: 12,
                                        italics: true,
                                        margin: [0, 10, 0, 3]
                                    });

                                    $.each(item2.CritDebi, function (j, item3) {
                                        doc.content.push({
                                            text: "- " + item3.criterioD + ". (Puntaje:" + item3.puntD + " )", fontSize: 10
                                        });

                                    });

                                }

                            });


                            if (data.RawOtEv.length > 0) {
                                doc.content.push({
                                    text: "OTRAS EVALUACIONES.",
                                    alignment: 'left',
                                    fontSize: 11,
                                    bold: true,
                                    margin: [0, 10, 0, 5]
                                });

                                doc.content.push(
                                        {
                                            table: {
                                                widths: ['10%', '25%', '25%', '25%', '15%'],
                                                body: [
                                                    ['Fecha', 'Criterios Cumplimiento Y Oportunidad', 'Criterios En La Ejecución Del Contrato', ' Criterios De Calidad', 'Calificación Total ']

                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },
                                            fontSize: 10,
                                            bold: true,
                                            fillColor: '#E8E9E9'

                                        }
                                );

                                $.each(data.RawOtEv, function (i2, itemH) {
                                    doc.content.push({
                                        table: {
                                            widths: ['10%', '25%', '25%', '25%', '15%'],
                                            body: [
                                                [itemH.freeva, itemH.PuntCO, itemH.PuntCE, itemH.PuntCC, itemH.PuntTo]

                                            ]
                                        },

                                        fontSize: 8,
                                        bold: true
                                    }
                                    );
                                });
                            }


                            if (item.ContC > 0) {

                                doc.content.push({
                                    text: "HISTORIAL DE CONTRATOS",
                                    alignment: 'left',
                                    fontSize: 11,
                                    bold: true,
                                    margin: [0, 10, 0, 5]
                                });


                                var colesta = "";
                                $.each(item.HisCont, function (j, itemH) {
                                    var colesta = "";
                                    if (itemH.estad_contrato === "Ejecucion") {
                                        colesta = "#2ED26E";
                                    } else if (itemH.estad_contrato === "Terminado") {
                                        colesta = "#387EFC";
                                    } else if (itemH.estad_contrato === "Suspendido") {
                                        colesta = "#EA4359";
                                    } else if (itemH.estad_contrato === "Liquidado") {
                                        colesta = "#FDC20D";
                                    }

                                    doc.content.push({
                                        text: [{text: " - " + itemH.num_contrato + '- ' + itemH.obj_contrato, fontSize: 9, bold: false, italics: true, margin: [0, 10, 0, 10]}, {text: " (" + itemH.estad_contrato.replace('Ejecucion', 'Ejecución') + ")", fontSize: 9, bold: false, italics: true, color: colesta, margin: [0, 10, 0, 10]}]});



                                });


                            }

                        });

                    }});

                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });
        },
        savePDFInfGenProy: function () {
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Proy = $('#CbProyectos').val();
            if (Proy === " ") {
                Proy = "";
            }

            var SubTit = "";

            Promise.all([
                chart.exporting.pdfmake,
                chartEstCon.exporting.getImage("png")
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };

                doc.content.push({
                    text: "INFORME GENERAL DE PROYECTOS",
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });

                var datos = {
                    Proy: Proy,
                    ope: "InfGenProyectos",
                    dest: "pdf"
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $.each(data.RawProyec, function (i, item) {

                            doc.content.push({
                                text: "DETALLES DEL PROYECTO - " + item.cproy,
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Nombre:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.nproy, fontSize: 11
                                    }
                                ]});


                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Secretaria:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Tipologia de Proyecto:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.secre, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.dtipo, fontSize: 11
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Eje Estrategico:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Programa:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'SubPrograma:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.neje, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.ncomp, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.nprog, fontSize: 11
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Porcentaje de Avance:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.pava, fontSize: 11
                                    }
                                ]});

                            doc.content.push({
                                text: "POBLACION OBJETIVO",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            $.each(item.pobj, function (j, item2) {
                                doc.content.push({
                                    text: [{text: " - " + item2.grupoetnico + ' (Personas Beneficiadas: ' + item2.personas + ')', fontSize: 9, bold: false, italics: true, margin: [0, 10, 0, 10]}]});
                            });

                            doc.content.push({
                                text: "METAS TRAZADORAS",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            if (item.ContMT > 0) {
                                doc.content.push(
                                        {
                                            table: {
                                                widths: ['5%', '65%', '10%', '20%'],
                                                body: [
                                                    ['#', 'Descripción', 'Objetivo', 'Aporte del Proyecto']

                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },
                                            fontSize: 9,
                                            bold: true,
                                            fillColor: '#E8E9E9'


                                        }
                                );
                                var conMT = 1;
                                console.log(item.mett);
                                $.each(item.mett, function (y, item3) {

                                    doc.content.push({

                                        table: {
                                            widths: ['5%', '65%', '10%', '20%'],
                                            body: [
                                                [conMT, item3.dmet, item3.meta, item3.metproy]

                                            ]
                                        },
                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                        fontSize: 7,
                                        bold: true,
                                    }
                                    );
                                    conMT++;

                                });

                            } else {
                                doc.content.push({
                                    text: "Este Proyecto no esta relacionado con ninguna Meta Trazadora",
                                    alignment: 'left',
                                    fontSize: 9,
                                    bold: false,
                                    margin: [0, 5, 0, 0]
                                });
                            }


                            doc.content.push({
                                text: "METAS DE PRODUCTO",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            if (item.ContMP > 0) {
                                doc.content.push(
                                        {
                                            table: {
                                                widths: ['5%', '65%', '10%', '20%'],
                                                body: [
                                                    ['#', 'Descripción', 'Objetivo', 'Aporte del Proyecto']

                                                ]
                                            },
                                            layout: {
                                                hLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea horizontal
                                                },
                                                vLineWidth: function (i, node) {
                                                    return 0.3; // Grosor de la línea vertical
                                                },
                                                hLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea horizontal
                                                },
                                                vLineColor: function (i, node) {
                                                    return '#000000'; // Color de la línea vertical
                                                }
                                            },
                                            fontSize: 10,
                                            bold: true,
                                            fillColor: '#E8E9E9'


                                        }
                                );
                                var conMP = 1;
                                $.each(item.metp, function (y, item3) {

                                    doc.content.push({

                                        table: {
                                            widths: ['5%', '65%', '10%', '20%'],
                                            body: [
                                                [conMP, item3.dmet, item3.meta, item3.metproy]

                                            ]
                                        },

                                        fontSize: 8,
                                        bold: true,

                                        layout: {
                                            hLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea horizontal
                                            },
                                            vLineWidth: function (i, node) {
                                                return 0.3; // Grosor de la línea vertical
                                            },
                                            hLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea horizontal
                                            },
                                            vLineColor: function (i, node) {
                                                return '#000000'; // Color de la línea vertical
                                            }
                                        },
                                    }
                                    );
                                    conMP++;

                                });

                            } else {
                                doc.content.push({
                                    text: "Este Proyecto no esta relacionado con ninguna Meta de Producto",
                                    alignment: 'left',
                                    fontSize: 9,
                                    bold: false,
                                    margin: [0, 5, 0, 0]
                                });
                            }



                            doc.content.push({
                                text: "HISTORIAL DE MEDICIÓN INDICADORES.",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            if (item.MedIn.length > 0) {
                                $.each(item.MedIn, function (j, itemInd) {
                                    doc.content.push({
                                        text: "Indicador: " + itemInd.nombInd,
                                        alignment: 'left',
                                        fontSize: 12,
                                        bold: true,
                                        margin: [0, 5, 0, 0]
                                    });
                                    $.each(itemInd.Metas, function (j, itemMet) {
                                        doc.content.push({
                                            text: "Meta: " + itemMet.nombmet,
                                            alignment: 'left',
                                            fontSize: 11,
                                            bold: true,
                                            margin: [0, 5, 0, 0]
                                        });

                                        doc.content.push({
                                            image: itemMet.img,
                                            width: 530
                                        });

                                    });
                                });

                            } else {
                                doc.content.push({
                                    text: "Este Proyecto no esta relacionado a Ningun Indicador",
                                    alignment: 'left',
                                    fontSize: 9,
                                    bold: false,
                                    margin: [0, 5, 0, 0]
                                });
                            }



                            doc.content.push({
                                text: "CONTRATOS RELACIONADOS AL PROYECTO",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            doc.content.push({
                                image: res[1],
                                width: 530
                            });


                            if (item.contr.length > 0) {
                                $.each(item.contr, function (j, itemCO) {

                                    doc.content.push({
                                        text: "DETALLES DEL CONTRATO - " + itemCO.num,
                                        alignment: 'left',
                                        fontSize: 12,
                                        bold: true,
                                        margin: [0, 10, 0, 0]
                                    });


                                    doc.content.push({
                                        columns: [
                                            {
                                                width: '*',
                                                text: 'Objeto:', bold: true, fontSize: 10
                                            }
                                        ]});
                                    doc.content.push({
                                        columns: [
                                            {
                                                width: '*',
                                                text: itemCO.obj, fontSize: 10
                                            }
                                        ]});

                                    var colesta = "";
                                    if (itemCO.estado === "Ejecucion") {
                                        colesta = "#2ED26E";
                                    } else if (itemCO.estado === "Terminado") {
                                        colesta = "#387EFC";
                                    } else if (itemCO.estado === "Suspendido") {
                                        colesta = "#EA4359";
                                    } else if (itemCO.estado === "Liquidado") {
                                        colesta = "#FDC20D";
                                    }

                                    doc.content.push({
                                        columns: [
                                            {
                                                width: '*',
                                                text: 'Contratista:', bold: true, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: 'Porcetaje Avance:', bold: true, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: 'Estado:', bold: true, fontSize: 10
                                            }
                                        ]});
                                    doc.content.push({
                                        columns: [
                                            {
                                                width: '*',
                                                text: itemCO.ctta, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: itemCO.pava, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: itemCO.estado.replace('Ejecucion', 'Ejecución'), fontSize: 10, color: colesta
                                            }
                                        ]});


                                    doc.content.push({
                                        columns: [
                                            {
                                                width: '*',
                                                text: 'Valor Contrato:', bold: true, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: 'Valor Adición:', bold: true, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: 'Valor Final:', bold: true, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: 'Valor Ejecutado:', bold: true, fontSize: 10
                                            }
                                        ]});
                                    doc.content.push({
                                        columns: [
                                            {
                                                width: '*',
                                                text: itemCO.vcont, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: itemCO.vadic, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: itemCO.vfinal, fontSize: 10
                                            },
                                            {
                                                width: '*',
                                                text: itemCO.vejec, fontSize: 10
                                            }
                                        ]});



                                    doc.content.push({
                                        text: "Registro Fotografico del Contrato.",
                                        alignment: 'left',
                                        fontSize: 12,
                                        bold: true,
                                        margin: [0, 5, 0, 0]
                                    });

                                    if (itemCO.imgEC.length > 0) {

                                        $.each(itemCO.imgEC2, function (l, itemIM) {
//                                            doc.content.push(itemIM.tip_galeria,{
//                                                image: itemIM.img_galeria,
//                                                width: 200,
//                                                margin: [0, 5, 0, 10]
//                                            });



                                            doc.content.push({

                                                table: {
                                                    widths: ['33%', '33%', '33%'],
                                                    body: [
                                                        ['Fase Inicial', 'Avances', 'Fase Final'],
                                                        [{
                                                                image: itemIM.ImgIni,
                                                                width: 170,
                                                                height: 140,
                                                                alignment: 'center'
                                                            }, {
                                                                image: itemIM.ImgAva,
                                                                width: 170,
                                                                height: 140,
                                                                alignment: 'center'
                                                            }, {
                                                                image: itemIM.ImgFin,
                                                                width: 170,
                                                                height: 140,
                                                                alignment: 'center'
                                                            }]

                                                    ],

                                                    hLineWidth: function (i, node) {
                                                        return (i === 0 || i === node.table.body.length) ? 2 : 1;
                                                    },
                                                    vLineWidth: function (i, node) {
                                                        return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                                                    },
                                                    hLineColor: function (i, node) {
                                                        return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                                                    },
                                                    vLineColor: function (i, node) {
                                                        return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                                                    }
                                                }

//                                             
                                            });
                                        });



                                    } else {
                                        doc.content.push({
                                            text: "Este Contrato no tiene Ningún Registro Fotografico",
                                            alignment: 'left',
                                            fontSize: 10,
                                            bold: false,
                                            margin: [0, 5, 0, 0]
                                        });
                                    }


                                });
                            } else {
                                doc.content.push({
                                    text: "Este Proyecto no esta relacionado con ningún Contrato",
                                    alignment: 'left',
                                    fontSize: 10,
                                    bold: false,
                                    margin: [0, 5, 0, 0]
                                });
                            }


                        });

                    }});

                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });
        },
        savePDFInfGenCont: function () {
            var TipRepor = $('#CbTipInf').val();
            var TextTipRepor = $('#CbTipInf option:selected').text();
            var Contr = $('#CbContratos').val();
            var Ncont = "";

            var SubTit = "";
            if (Contr === " ") {
                Contr = "";
            } else {
                var parcont = Contr.split("/");
                Contr = parcont[0];
                Ncont = parcont[1];
            }


            Promise.all([
                chart.exporting.pdfmake,
                chartEstCon.exporting.getImage("png")
            ]).then(function (res) {

                var pdfMake = res[0];

                // pdfmake is ready
                // Create document template
                var doc = {
                    pageSize: "LETTER",
                    pageOrientation: "portrait",
                    pageMargins: [30, 30, 30, 30],
                    content: []
                };


                doc.content.push({
                    text: "INFORME GENERAL DE CONTRATOS",
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                    margin: [0, 20, 0, 15]
                });

                var datos = {
                    idContr: Contr,
                    Contr: Ncont,
                    ope: "InfGenContratos"
                };

                var NumPoliza = "";
                var FIniPoliza = "";
                var FFinPoliza = "";

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $.each(data.RawContra, function (i, item) {

                            doc.content.push({
                                text: "DETALLES DEL CONTRATO",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Número:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Fecha Creación:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Tipologia del Contrato:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.num, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.fech, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.tipol, fontSize: 11
                                    }
                                ]});

                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Ojeto del Contrato:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.obj, fontSize: 11
                                    }
                                ]});

                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Valor del contrato:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Valor Adición:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Valor Final:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Valor Ejecutado:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.valor, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.vadic, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.vfin, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.veje, fontSize: 11
                                    }
                                ]});

                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Estado:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: '% de Avance:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Duración:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Fecha Inicio:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Fecha Finalización:', bold: true, fontSize: 12
                                    }
                                ]});

                            var colesta = "#000";
                            if (item.estado === "Ejecucion") {
                                colesta = "#2ED26E";
                            } else if (item.estado === "Terminado") {
                                colesta = "#387EFC";
                            } else if (item.estado === "Suspendido") {
                                colesta = "#EA4359";
                            } else if (item.estado === "Liquidado") {
                                colesta = "#FDC20D";
                            }

                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.estado.replace('Ejecucion', 'Ejecución'), fontSize: 10, color: colesta
                                    },
                                    {
                                        width: '*',
                                        text: item.pava, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.durc, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.fini, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.ffin, fontSize: 11
                                    }
                                ]});


                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Contratista:', bold: true, fontSize: 12
                                    },
                                    {
                                        width: '*',
                                        text: 'Secretaria:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.nomctta, fontSize: 11
                                    },
                                    {
                                        width: '*',
                                        text: item.secr, fontSize: 11
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: 'Proyecto Asociado:', bold: true, fontSize: 12
                                    }
                                ]});
                            doc.content.push({
                                columns: [
                                    {
                                        width: '*',
                                        text: item.proyec, fontSize: 11
                                    }
                                ]});

                            NumPoliza = item.npol;
                            FIniPoliza = item.finipol;
                            FFinPoliza = item.ffinpol;

                        });
                        

                        if (data.RawaGastos.length > 0) {
                        doc.content.push({
                            text: "GASTOS DEL CONTRATO.",
                            alignment: 'left',
                            fontSize: 13,
                            bold: true,
                            margin: [0, 5, 0, 0]
                        });

                        doc.content.push(
                            {
                                table: {
                                    widths: ['5%', '15%', '60%', '20%'],
                                    body: [
                                        ['#', 'Fecha', 'Descripción', 'Valor']
    
                                    ]
                                },
                                layout: {
                                    hLineWidth: function (i, node) {
                                        return 0.3; // Grosor de la línea horizontal
                                    },
                                    vLineWidth: function (i, node) {
                                        return 0.3; // Grosor de la línea vertical
                                    },
                                    hLineColor: function (i, node) {
                                        return '#000000'; // Color de la línea horizontal
                                    },
                                    vLineColor: function (i, node) {
                                        return '#000000'; // Color de la línea vertical
                                    }
                                },
                                fontSize: 10,
                                bold: true,
                                fillColor: '#E8E9E9'
    
                            }
                    );

                    let ContG=1;

                    $.each(data.RawaGastos, function (y, item3) {

                        doc.content.push({
                            table: {
                                widths: ['5%', '15%', '60%', '20%'],
                                body: [
                                    [ContG, item3.fecha, item3.ngasto+"-"+item3.descr, formatCurrency(item3.val, "es-CO", "COP")]

                                ]
                            },
                            layout: {
                                hLineWidth: function (i, node) {
                                    return 0.3; // Grosor de la línea horizontal
                                },
                                vLineWidth: function (i, node) {
                                    return 0.3; // Grosor de la línea vertical
                                },
                                hLineColor: function (i, node) {
                                    return '#000000'; // Color de la línea horizontal
                                },
                                vLineColor: function (i, node) {
                                    return '#000000'; // Color de la línea vertical
                                }
                            },
                            fontSize: 8,
                            bold: true
                        }
                        );

                        ContG++;
                    });

                        }

                        if (data.RawaPolizas.length > 0) {
                        doc.content.push({
                            text: "POLIZAS DEL CONTRATO.",
                            alignment: 'left',
                            fontSize: 13,
                            bold: true,
                            margin: [0, 5, 0, 0]
                        });
                        
                        doc.content.push(
                            {
                                table: {
                                    widths: ['5%', '55%', '20%', '20%'],
                                    body: [
                                        ['#', 'Descripción', 'Fecha de inicio', 'Fecha de finalización']
    
                                    ]
                                },
                                layout: {
                                    hLineWidth: function (i, node) {
                                        return 0.3; // Grosor de la línea horizontal
                                    },
                                    vLineWidth: function (i, node) {
                                        return 0.3; // Grosor de la línea vertical
                                    },
                                    hLineColor: function (i, node) {
                                        return '#000000'; // Color de la línea horizontal
                                    },
                                    vLineColor: function (i, node) {
                                        return '#000000'; // Color de la línea vertical
                                    }
                                },
                                fontSize: 10,
                                bold: true,
                                fillColor: '#E8E9E9'    
                            }
                    );

                    let ContG=1;

                    $.each(data.RawaPolizas, function (y, item4) {

                        doc.content.push({
                            table: {
                                widths: ['5%', '55%', '20%', '20%'],
                                body: [
                                    [ContG, item4.num_poliza+ " - "+item4.descripcion, item4.fecha_ini, item4.fecha_fin]

                                ]
                            },
                            layout: {
                                hLineWidth: function (i, node) {
                                    return 0.3; // Grosor de la línea horizontal
                                },
                                vLineWidth: function (i, node) {
                                    return 0.3; // Grosor de la línea vertical
                                },
                                hLineColor: function (i, node) {
                                    return '#000000'; // Color de la línea horizontal
                                },
                                vLineColor: function (i, node) {
                                    return '#000000'; // Color de la línea vertical
                                }
                            },
                            fontSize: 8,
                            bold: true
                        }
                        );

                        ContG++;
                    });

                        }


                        if (data.RawConSusp.length > 0) {
                            doc.content.push({
                                text: "SUSPENSIÓN DEL CONTRATO.",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            $.each(data.RawConSusp, function (i, item) {

                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: 'Fecha de Suspensión:', bold: true, fontSize: 10
                                        },
                                        {
                                            width: '*',
                                            text: 'Motivo de Suspensión:', bold: true, fontSize: 10
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: item.fsusp_contrato, fontSize: 10
                                        },
                                        {
                                            width: '*',
                                            text: item.observacion, fontSize: 10
                                        }
                                    ]});


                            });

                        }

                        if (data.RawConPro.length > 0) {
                            doc.content.push({
                                text: "PRORROGA DE CONTRATO.",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            $.each(data.RawConPro, function (i, item) {
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: 'Tiempo Prorroga:', bold: true, fontSize: 10
                                        },
                                        {
                                            width: '*',
                                            text: 'Fecha Finlalización:', bold: true, fontSize: 10
                                        },
                                        {
                                            width: '*',
                                            text: 'Motivo de Prorroga:', bold: true, fontSize: 10
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: item.prorg_contrato, fontSize: 10
                                        },
                                        {
                                            width: '*',
                                            text: item.ffin_contratoP, fontSize: 10
                                        },
                                        {
                                            width: '*',
                                            text: item.observacion, fontSize: 10
                                        }
                                    ]});
                            });

                        }

                        if (data.RawaAtra.length > 0) {
                            doc.content.push({
                                text: "CONTRATO ATRASADO.",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });

                            $.each(data.RawaAtra, function (i, item) {
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: 'Justificación de Atraso:', bold: true, fontSize: 12
                                        }
                                    ]});
                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: item.just, fontSize: 11
                                        }
                                    ]});
                            });

                        }

                        if (data.RawUbiCon.length > 0) {
                            doc.content.push({
                                text: "UBICACIÓN DE CONTRATO.",
                                alignment: 'left',
                                fontSize: 13,
                                bold: true,
                                margin: [0, 5, 0, 0]
                            });
                            var ContUbi = 1;
                            $.each(data.RawUbiCon, function (i, item) {

                                doc.content.push({
                                    columns: [
                                        {
                                            width: '*',
                                            text: ContUbi + ". " + item.Ubic, fontSize: 11
                                        }
                                    ]});

                                ContUbi++;
                            });

                        }



                        doc.content.push({
                            text: "REGISTRO FOTOGRAFICO DEL CONTRATO.",
                            alignment: 'left',
                            fontSize: 12,
                            bold: true,
                            margin: [0, 5, 0, 0]
                        });

                        if (data.RawFotosA2.length > 0) {

                            $.each(data.RawFotosA2, function (l, itemIM) {


                                doc.content.push({

                                    table: {
                                        widths: ['33%', '33%', '33%'],
                                        body: [
                                            ['Fase Inicial', 'Avances', 'Fase Final'],
                                            [{
                                                    image: itemIM.ImgIni,
                                                    width: 170,
                                                    height: 140,
                                                    alignment: 'center'
                                                }, {
                                                    image: itemIM.ImgAva,
                                                    width: 170,
                                                    height: 140,
                                                    alignment: 'center'
                                                }, {
                                                    image: itemIM.ImgFin,
                                                    width: 170,
                                                    height: 140,
                                                    alignment: 'center'
                                                }]

                                        ]
                                    },
                                    layout: {
                                        hLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea horizontal
                                        },
                                        vLineWidth: function (i, node) {
                                            return 0.3; // Grosor de la línea vertical
                                        },
                                        hLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea horizontal
                                        },
                                        vLineColor: function (i, node) {
                                            return '#000000'; // Color de la línea vertical
                                        }
                                    },
                                    fontSize: 8,
                                    bold: true

//                                             
                                });
                            });



                        } else {
                            doc.content.push({
                                text: "Este Contrato no tiene Ningún Registro Fotografico",
                                alignment: 'left',
                                fontSize: 10,
                                bold: false,
                                margin: [0, 5, 0, 0]
                            });
                        }
                    }});

                pdfMake.createPdf(doc).download($('#CbTipInf option:selected').text() + ".pdf");

            });
        },
        printMap: function(){
            window.print();
        }


    });
    //======FUNCIONES========\\

    $.CargaTodContr();

    function formatCurrency(number, locale, currencySymbol) {
        return new Intl.NumberFormat(locale, {
          style: "currency",
          currency: currencySymbol,
          minimumFractionDigits: 2,
        }).format(number);
      }

    $("#btn_Excel").click(function () {
        CbProy = trimAll($("#CbProy").val());
        CbSecr = trimAll($("#CbSecre").val());
        CbEje = trimAll($("#CbEje").val());
        CbComp = trimAll($("#CbComp").val());
        CbProg = trimAll($("#CbProg").val());
        window.open("../Informes/ExcelContratosEstados.php?CbProy=" + CbProy + "&CbSecr=" + CbSecr + "&CbEje=" + CbEje + "&CbComp=" + CbComp + "&CbProg=" + CbProg);
    });
});
