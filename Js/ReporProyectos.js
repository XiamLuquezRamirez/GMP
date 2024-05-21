$(document).ready(function () {

// $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
    $("#menu_informe").addClass("start active open");
    $("#menu_reporproyec").addClass("active");

    $("#CbTipInf,#CbEstado,#CbEstadoCont").selectpicker();
    var chart;
    var legend;
    var selected;
    var types = [];
    var mapa, mapa1, latitud, longitud;
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

            if (op === "1" || op === "2" || op === "3") {
                $("#CbSecre").prop('disabled', false);
                $("#CbEje").prop('disabled', false);
                $("#CbEstado").prop('disabled', false);
                $('#DivCbEstado').show();
                $('#DivCbEstadoCont').hide();
                $('#DivCbProy').hide();
            } else if (op === "4") {
                $("#CbSecre").prop('disabled', false);
                $("#CbEje").prop('disabled', true);
                $('#DivCbEstadoCont').show();
                $('#DivCbEstado').hide();
                $('#DivCbProy').hide();
            } else if (op === "5") {
                $("#CbSecre").prop('disabled', true);
                $("#CbEje").prop('disabled', true);
                $('#DivCbEstado').show();
                $('#DivCbEstadoCont').hide();
                $('#DivCbProy').hide();

            } else if (op === "T") {
                $("#CbSecre").prop('disabled', false);
                $("#CbEje").prop('disabled', false);
                $("#CbProy").prop('disabled', false);
                $('#DivCbProy').show();
                $('#DivCbEstadoCont').hide();
                $('#DivCbEstado').hide();
            } else if (op === "G") {
                $("#CbSecre").prop('disabled', false);
                $("#CbEje").prop('disabled', false);
                $("#CbProy").prop('disabled', false);
                $('#DivCbProy').show();
                $('#DivCbEstado').show();
                $('#DivCbEstadoCont').hide();
                $('#GeoProy').hide();
                $.localizame1();
            } else {
                $("#CbSecre").prop('disabled', false);
                $("#CbEje").prop('disabled', false);
                $("#CbProy").prop('disabled', false);
                $('#DivCbProy').show();
                $('#DivCbEstadoCont').hide();
                $('#DivCbEstado').hide();
            }

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
            if (op === "1" || op === "2" || op === "3") {
                $.Graficar1(op);
                $('#GrafProy').show();
                $('#ListProy').hide();
                $('#GeoProy').hide();
            } else if (op === "4") {
                $('#GrafProy').show();
                $('#ListProy').hide();
                $('#GeoProy').hide();
                $.Graficar4();
            } else if (op === "5") {
                $('#GrafProy').show();
                $('#ListProy').hide();
                $('#GeoProy').hide();
                $.Graficar5();
            } else if (op === "G") {
                $('#GeoProy').show();
                $('#GrafProy').hide();
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
                        success: function (data) {
                            $("#tb_proyectos").html(data['CadProy']);
                        },
                        error: function (error_messages) {
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
            $('#GeoProy').hide();
            $('#ListProy').hide();
            $('#btn_volver').hide();
            $('#botonesExcel').hide();
        },
        Graficar2: function () {
            $("#").html("chartdiv2");
            var datos = {
                proy: $("#CbProy").val(),
                ope: "GrafContrat"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    var chart = AmCharts.makeChart("chartdiv", {
                        "type": "pie",
                        "startDuration": 0,
                        "theme": "light",
                        "addClassNames": true,
                        "legend": {
                            "position": "right",
                            "marginRight": 100,
                            "autoMargins": false
                        },
                        "innerRadius": "30%",
                        "titles": [{
                                "text": "Contratos por Proyectos",
                                "size": 16
                            }],
                        "defs": {
                            "filter": [{
                                    "id": "shadow",
                                    "width": "200%",
                                    "height": "200%",
                                    "feOffset": {
                                        "result": "offOut",
                                        "in": "SourceAlpha",
                                        "dx": 0,
                                        "dy": 0
                                    },
                                    "feGaussianBlur": {
                                        "result": "blurOut",
                                        "in": "offOut",
                                        "stdDeviation": 5
                                    },
                                    "feBlend": {
                                        "in": "SourceGraphic",
                                        "in2": "blurOut",
                                        "mode": "normal"
                                    }
                                }]
                        },
                        "dataProvider": data,
                        "valueField": "porc",
                        "titleField": "contr",
                        "startEffect": "elastic",
                        "startDuration": 2,
                        "labelRadius": 15,
                        "innerRadius": "50%",
                        "depth3D": 10,
                        "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                        "angle": 15,
                        "export": {
                            "enabled": true
                        },
                        "listeners": [{
                                "event": "clickSlice",
                                "method": myCustomClick
                            }]
                    });
//                    chart.addListener("init", handleInit);
//
//                    chart.addListener("rollOverSlice", function(e) {
//                        handleRollOver(e);
//                    });
//
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Graficar1: function (op) {
            $("#chartdiv2").html("");
            var datos = {
                ope: "GrafContrat" + op,
                CbEsta: $("#CbEstado").val(),
                CbSecr: trimAll($("#CbSecre").val()),
                CbEje: trimAll($("#CbEje").val()),
                CbComp: trimAll($("#CbComp").val()),
                CbProg: trimAll($("#CbProg").val())
            };
            var TituloGraf = $('#CbTipInf option:selected').text();
            if (trimAll($("#CbSecre").val()) !== "") {
                ParSec = $('#CbSecre option:selected').text().split(" - ");
                TituloGraf += " " + ParSec[1];
            }

            if (trimAll($("#CbEje").val()) !== "") {
                ParSec = $('#CbEje option:selected').text().split(" - ");
                TituloGraf += ", " + ParSec[1];
            }

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data.length > 0) {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.createFromConfig({
                            "data": data,
                            "legend": {},
                            "innerRadius": "40%",
                            "titles": [{
                                    "text": TituloGraf,
                                    "fontSize": 20,
                                    "marginTop": 15
                                }],
                            "series": [{
                                    "type": "PieSeries3D",
                                    "dataFields": {
                                        "value": "cant",
                                        "category": "Cate"
                                    },
                                    "tooltip": {
                                        "keepTargetHover": true,
                                        "label": {
                                            "interactionsEnabled": true
                                        }
                                    },
                                    "labels": {
                                        "text": "{category}: {value} ({value.percent.formatNumber('#.0')}%)"
                                    },
                                    "slices": {
                                        "tooltipHTML": '<b>{category}: {value}</b><br><a id="{category}" style="color:#ffffff" onclick="$.MostProyectos(this.id)">Ver Proyectos</a>'
                                    },
                                    "exporting": {
                                        "menu": {
                                            // ...
                                            "items": [{
                                                    "label": "...",
                                                    "menu": [
                                                        {"type": "png", "label": "PNG"},
                                                        {"type": "jpg", "label": "JPG"},
                                                        {"type": "pdf", "label": "PDF"}
                                                    ]
                                                }]
                                        },
                                        "callback": function () {
                                            this.getFormatOptions("pdf").addURL = false;
                                        }
                                    }
                                }]
                        }, "chartdiv", "PieChart3D");
                    } else {
                        $("#chartdiv").html("<div style='text-align: center;'><h4>NO EXISTE REGISTROS PARA ESTE PARAMETRO DE BUSQUEDA..</h4></div>");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Graficar4: function (op) {
            $("#chartdiv2").html("");
            var datos = {
                ope: "GrafContrat4",
                CbEsta: $("#CbEstadoCont").val(),
                CbSecr: trimAll($("#CbSecre").val()),
                CbEje: trimAll($("#CbEje").val()),
                CbComp: trimAll($("#CbComp").val()),
                CbProg: trimAll($("#CbProg").val())
            };
            var TituloGraf = $('#CbTipInf option:selected').text();
            if (trimAll($("#CbSecre").val()) !== "") {
                ParSec = $('#CbSecre option:selected').text().split(" - ");
                TituloGraf += " " + ParSec[1];
            }

            if (trimAll($("#CbEje").val()) !== "") {
                ParSec = $('#CbEje option:selected').text().split(" - ");
                TituloGraf += ", " + ParSec[1];
            }

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data.length > 0) {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.createFromConfig({
                            "data": data,
                            "legend": {},
                            "innerRadius": "20%",
                            "titles": [{
                                    "text": TituloGraf,
                                    "fontSize": 20,
                                    "marginTop": 15
                                }],
                            "series": [{
                                    "type": "PieSeries3D",
                                    "dataFields": {
                                        "value": "cant",
                                        "category": "Cate"
                                    },
                                    "tooltip": {
                                        "keepTargetHover": true,
                                        "label": {
                                            "interactionsEnabled": true
                                        }
                                    },
                                    "labels": {
                                        "text": "{category}: {value} ({value.percent.formatNumber('#.0')}%)"
                                    },

                                    "slices": {
                                        "tooltipHTML": '<b>{category}: {value}</b><br><a id="{category}" style="color:#ffffff" onclick="$.MostContratos(this.id)">Ver Contratos</a>'
                                    },
                                    "exporting": {
                                        "menu": {
                                            // ...
                                            "items": [{
                                                    "label": "...",
                                                    "menu": [
                                                        {"type": "png", "label": "PNG"},
                                                        {"type": "jpg", "label": "JPG"},
                                                        {"type": "pdf", "label": "PDF"}
                                                    ]
                                                }]
                                        },
                                        "callback": function () {
                                            this.getFormatOptions("pdf").addURL = false;
                                        }
                                    }
                                }]
                        }, "chartdiv", "PieChart3D");
                    } else {
                        $("#chartdiv").html("<div style='text-align: center;'><h4>NO EXISTE REGISTROS PARA ESTE PARAMETRO DE BUSQUEDA..</h4></div>");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Graficar5: function (op) {

            var datos = {
                ope: "GrafContrat5",
                CbEsta: $("#CbEstado").val(),
                CbSecr: trimAll($("#CbSecre").val()),
                CbEje: trimAll($("#CbEje").val()),
                CbComp: trimAll($("#CbComp").val()),
                CbProg: trimAll($("#CbProg").val())

            };
            var TituloGraf = $('#CbTipInf option:selected').text();


// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

            var chart = am4core.create("chartdiv", am4charts.XYChart);

// algo de relleno adicional para etiquetas de rango
            chart.paddingBottom = 50;

            chart.cursor = new am4charts.XYCursor();
            chart.scrollbarX = new am4core.Scrollbar();

// usará esto para almacenar colores de los mismos artículos
            var colors = {};

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.minGridDistance = 60;
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataItems.template.text = "{realName}";
            categoryAxis.adapter.add("tooltipText", function (tooltipText, target) {
                return categoryAxis.tooltipDataItem.dataContext.realName;
            })

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.min = 0;

// serie de una sola columna para todos los datos
            var columnSeries = chart.series.push(new am4charts.ColumnSeries());
            columnSeries.columns.template.width = am4core.percent(80);
            columnSeries.tooltipText = "{provider}: {realName}, {valueY}";
            columnSeries.dataFields.categoryX = "category";
            columnSeries.dataFields.valueY = "value";

// segundo eje de valor para la cantidad
            var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis2.renderer.opposite = true;
            valueAxis2.syncWithAxis = valueAxis;
            valueAxis2.tooltip.disabled = true;

// cantidad línea serie
            var lineSeries = chart.series.push(new am4charts.LineSeries());
            lineSeries.tooltipText = "{valueY}";
            lineSeries.dataFields.categoryX = "category";
            lineSeries.dataFields.valueY = "quantity";
            lineSeries.yAxis = valueAxis2;
            lineSeries.bullets.push(new am4charts.CircleBullet());
            lineSeries.stroke = chart.colors.getIndex(13);
            lineSeries.fill = lineSeries.stroke;
            lineSeries.strokeWidth = 2;
            lineSeries.snapTooltip = true;

// cuando se validan los datos, ajuste la ubicación del elemento de datos según el recuento
            lineSeries.events.on("datavalidated", function () {
                lineSeries.dataItems.each(function (dataItem) {
                    // si el recuento se divide por dos, la ubicación es 0 (en la cuadrícula)
                    if (dataItem.dataContext.count / 2 == Math.round(dataItem.dataContext.count / 2)) {
                        dataItem.setLocation("categoryX", 0);
                    }
                    // de lo contrario, la ubicación es 0.5 (medio)
                    else {
                        dataItem.setLocation("categoryX", 0.5);
                    }
                })
            })

// adaptador de relleno, aquí guardamos el valor del color en el objeto de colores para que cada vez que el artículo tenga el mismo nombre, se use el mismo color
            columnSeries.columns.template.adapter.add("fill", function (fill, target) {
                var name = target.dataItem.dataContext.realName;
                if (!colors[name]) {
                    colors[name] = chart.colors.next();
                }
                target.stroke = colors[name];
                return colors[name];
            })


            var rangeTemplate = categoryAxis.axisRanges.template;
            rangeTemplate.tick.disabled = false;
            rangeTemplate.tick.location = 0;
            rangeTemplate.tick.strokeOpacity = 0.6;
            rangeTemplate.tick.length = 60;
            rangeTemplate.grid.strokeOpacity = 0.5;
            rangeTemplate.label.tooltip = new am4core.Tooltip();
            rangeTemplate.label.tooltip.dy = -10;
            rangeTemplate.label.cloneTooltip = false;

///// DATA
            var chartData = [];
            var lineSeriesData = [];

            var datas;

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data.length > 0) {
                        datas = data;

                        $.each(data, function (j, itemSec) {
//                            var providerData = datas[providerName];


                            // agregar datos de un proveedor a la matriz temporal
                            var tempArray = [];
                            var count = 0;
                            // add items
                            $.each(itemSec.Estados, function (l, itemEst) {


                                count++;
//                        
                                tempArray.push({category: itemSec.Secretarias + "_" + itemEst.Estados, realName: itemEst.Estados, value: itemEst.Cant, provider: itemSec.Secretarias})

                            });
                            // ordenar matriz temporal
                            tempArray.sort(function (a, b) {
                                if (a.value > b.value) {
                                    return 1;
                                } else if (a.value < b.value) {
                                    return -1
                                } else {
                                    return 0;
                                }
                            })


                            am4core.array.each(tempArray, function (item) {
                                chartData.push(item);
                            })

                            // crear rango (la etiqueta adicional en la parte inferior)
                            var range = categoryAxis.axisRanges.create();
                            range.category = tempArray[0].category;
                            range.endCategory = tempArray[tempArray.length - 1].category;
                            range.label.text = tempArray[0].provider;
                            range.label.dy = 30;
                            range.label.truncate = true;
                            range.label.fontWeight = "bold";
                            range.label.tooltipText = tempArray[0].provider;

                            range.label.adapter.add("maxWidth", function (maxWidth, target) {
                                var range = target.dataItem;
                                var startPosition = categoryAxis.categoryToPosition(range.category, 0);
                                var endPosition = categoryAxis.categoryToPosition(range.endCategory, 1);
                                var startX = categoryAxis.positionToCoordinate(startPosition);
                                var endX = categoryAxis.positionToCoordinate(endPosition);
                                return endX - startX;
                            })
                        });

                        chart.data = chartData;

                    } else {
                        $("#chartdiv").html("<div style='text-align: center;'><h4>NO EXISTE REGISTROS PARA ESTE PARAMETRO DE BUSQUEDA..</h4></div>");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

// procesar datos y prepararlo para el gráfico



// last tick
            var range = categoryAxis.axisRanges.create();
            range.category = chart.data[chart.data.length - 1].category;
            range.label.disabled = true;
            range.tick.location = 1;
            range.grid.location = 1;


        },
        MostProyectos: function (val) {
            $('#btn_volver2').show();
            var TipInf = $("#CbTipInf").val();
            var Estado = val;

            var datos = {
                Estad: Estado,
                TipInf: TipInf,
                ope: "GrafProyectos"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.createFromConfig({
                        "data": data,
                        "legend": {},
                        "innerRadius": "40%",
                        "titles": [{
                                "text": "Proyectos " + Estado,
                                "fontSize": 20,
                                "marginTop": 15

                            }],
                        "series": [{
                                "type": "PieSeries3D",
                                "dataFields": {
                                    "value": "cant",
                                    "category": "Cate"
                                },
                                "tooltip": {
                                    "keepTargetHover": true,
                                    "label": {
                                        "interactionsEnabled": true
                                    }
                                },
                                "slices": {
                                    "tooltipHTML": '<b>{category}: {value}</b><br><a id="{category}" style="color:#ffffff" onclick="$.MostDetaProyecto(this.id)">Ver Detalle</a>'
                                },
                                "exporting": {
                                    "menu": {
                                        // ...
                                        "items": [{
                                                "label": "...",
                                                "menu": [
                                                    {"type": "png", "label": "PNG"},
                                                    {"type": "jpg", "label": "JPG"},
                                                    {"type": "pdf", "label": "PDF"}
                                                ]
                                            }]
                                    },
                                    "callback": function () {
                                        this.getFormatOptions("pdf").addURL = false;
                                    }
                                }
                            }]
                    }, "chartdiv", "PieChart3D");
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        MostContratos: function (val) {
            alert(val);
            $('#btn_volver2').show();
            var TipInf = $("#CbTipInf").val();
            var Estado = val;

            var datos = {
                Estad: Estado.replace('Ejecución', 'Ejecucion'),
                ope: "GrafContratos"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.createFromConfig({
                        "data": data,
                        "legend": {},
                        "innerRadius": "20%",
                        "titles": [{
                                "text": "Contratos en " + Estado,
                                "fontSize": 20,
                                "marginTop": 15

                            }],
                        "series": [{
                                "type": "PieSeries3D",
                                "dataFields": {
                                    "value": "cant",
                                    "category": "Cate"
                                },
                                "tooltip": {
                                    "keepTargetHover": true,
                                    "label": {
                                        "interactionsEnabled": true
                                    }
                                },
                                "labels": {
                                    "text": "{category}"
                                },
                                "slices": {
                                    "tooltipHTML": '<b>{category}</b><br><a id="{category}" style="color:#ffffff" onclick="$.MostDetaContrato(this.id)">Ver Detalle</a>'
                                },
                                "exporting": {
                                    "menu": {
                                        // ...
                                        "items": [{
                                                "label": "...",
                                                "menu": [
                                                    {"type": "png", "label": "PNG"},
                                                    {"type": "jpg", "label": "JPG"},
                                                    {"type": "pdf", "label": "PDF"}
                                                ]
                                            }]
                                    },
                                    "callback": function () {
                                        this.getFormatOptions("pdf").addURL = false;
                                    }
                                }
                            }]
                    }, "chartdiv", "PieChart3D");
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        MostDetaProyecto: function (val) {
            var datos = {
                ope: "BusqInfProyecto",
                cod: val
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#codproy").html(data['cod_proyect']);
                    $("#fproyecto").html(data['fec_crea_proyect']);
                    $("#tipproyecto").html(data['dtipol_proyec']);
                    $("#nombproy").html(data['nombre_proyect']);
                    $('#nsecreataria').html(data["dsecretar_proyect"]);
                    $('#estProy').html(data["estado_proyect"]);
                    $('#tb_Contratos').html(data["Tab_Cont"]);
                    $('#tb_MetasT').html(data["Tab_MetaT"]);
                    $('#tb_MetasP').html(data["Tab_MetaP"]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#VentDetProyectos").modal();
        },
        MostDetaContrato: function (val) {
            var datos = {
                ope: "BusqInfContra",
                cod: val
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#ncontrat").html(data['num_contrato']);
                    $("#fcontrat").html(data['fcrea_contrato']);
                    $("#tipcontrat").html(data['destipolg_contrato']);
                    $("#objcontrat").html(data['obj_contrato']);
                    $('#Contratis').html(data["descontrati_contrato"]);
                    $('#Supervi').html(data["dessuperv_contrato"]);
                    $('#Intervent').html(data["desinterv_contrato"]);
                    $("#ValContrat").html('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#ValAdicion").html('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#ValFinal").html('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#ValEjecut").html('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
                    $("#FPago").html(data['forpag_contrato']);
                    $("#DurContra").html(data['durac_contrato']);
                    $("#Prorroga").html(data['prorg_contrato']);
                    if (data['fini_contrato'] === "0000-00-00") {
                        $("#Fecini").html("---");
                    } else {
                        $("#Fecini").html(data['fini_contrato']);
                    }

                    if (data['fsusp_contrato'] === "0000-00-00") {
                        $("#FecSusp").html("---");
                    } else {
                        $("#FecSusp").html(data['fsusp_contrato']);
                    }

                    if (data['frein_contrato'] === "0000-00-00") {
                        $("#FecRein").html("---");
                    } else {
                        $("#FecRein").html(data['frein_contrato']);
                    }

                    if (data['ffin_contrato'] === "0000-00-00") {
                        $("#FecFinal").html("---");
                    } else {
                        $("#FecFinal").html(data['ffin_contrato']);
                    }

                    if (data['frecb_contrato'] === "0000-00-00") {
                        $("#FecRecib").html("---");
                    } else {
                        $("#FecRecib").html(data['frecb_contrato']);
                    }

                    $("#PorAva").html(data['porav_contrato']);
                    $("#Estado").html(data['estad_contrato']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#VentDetContratos").modal();
        },
        ListGrafica: function (proy) {
            $('#GrafProy').show();
            $('#ListProy').hide();
            $('#btn_volver').show();
            var datos = {
                proy: proy,
                ope: "GrafContrat"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data === "no") {
                        $("#chartdiv").html('<div style="font-size: 20px;" id="prefix_1566889262626" class="custom-alerts alert alert-warning fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><i class="fa-lg fa fa-warning"></i>  No hay Contratos Relacionados a este Proyecto...</div>');
                    } else {

                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.createFromConfig({
                            "data": data,
                            "legend": {},
                            "innerRadius": "40%",
                            "titles": [{
                                    "text": "Contratos por Proyecto",
                                    "fontSize": 20,
                                    "marginTop": 15

                                }],
                            "series": [{
                                    "type": "PieSeries3D",
                                    "dataFields": {
                                        "value": "porc",
                                        "category": "contr"
                                    },
                                    "tooltip": {
                                        "keepTargetHover": true,
                                        "label": {
                                            "interactionsEnabled": true
                                        }
                                    },
                                    "slices": {
                                        "tooltipHTML": '<b>{category}</b><br><a id="{category}" style="color:#ffffff" onclick="$.MostDetaContrato(this.id)">Ver Detalle</a>'
                                    },
                                    "exporting": {
                                        "menu": {
                                            // ...
                                            "items": [{
                                                    "label": "...",
                                                    "menu": [
                                                        {"type": "png", "label": "PNG"},
                                                        {"type": "jpg", "label": "JPG"},
                                                        {"type": "pdf", "label": "PDF"}
                                                    ]
                                                }]
                                        },
                                        "callback": function () {
                                            this.getFormatOptions("pdf").addURL = false;
                                        }
                                    }
                                }]
                        }, "chartdiv", "PieChart3D");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }

    });
    //======FUNCIONES========\\

    $.CargaTodContr();
    function handleInit() {

        chart.legend.addListener("rollOverItem", handleRollOver);
    }

    function generateChartData() {

        var chartData = [];
        for (var i = 0; i < types.length; i++) {

            if (i == selected) {
                for (var x = 0; x < types[i].proy.length; x++) {

                    chartData.push({
                        Cate: types[i].proy[x].Cate,
                        cant: types[i].proy[x].cant,
                        color: types[i].color,
                        pulled: true
                    });
                }
            } else {
                chartData.push({
                    Cate: types[i].Cate,
                    cant: types[i].cant,
                    color: types[i].color,
                    id: i
                });
            }
        }
        return chartData;
    }

    function handleClick(event)
    {

        alert(event.item.category + ": " + event.item.values.value);
    }

    function handleRollOver(e) {
        var wedge = e.dataItem.wedge.node;
        wedge.parentNode.appendChild(wedge);
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
///////////////////////
