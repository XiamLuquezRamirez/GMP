$(document).ready(function () {
    var mapa, mapa1, latitud, longitud;
    var conGlobal = 0;

   
    $.extend({
        LogComp: function (ses) {
            $("#txt_compa").val(ses);
            $("#txt_keycomp").focus();
            $("#VentanaLog").modal("show");
        },
        Login: function () {

            var comp = $("#txt_compa").val();
            var keycomp = $("#txt_keycomp").val();
            if (comp === "" || comp === " ") {
                $.Alert("#msg", "Compañia Y Contraseña Incorrecta... Verifique Por favor", "danger");
                return;
            }
            if (keycomp === "" || keycomp === " ") {
                $.Alert("#msg", "Compañia Y Contraseña Incorrecta... Verifique Por favor", "danger");
                return;
            }
            datos = "";
            datos = "&COMP=" + comp + "&KEYCOMP=" + keycomp + "&opc=verusu&ori=logcomp";
            $.ajax({
                type: 'POST',
                url: 'Login.php',
                data: datos,
                async: false,
                success: function (data) {

                    if (data == 0) {

                        $.Alert("#msg", "Bienvenido...", "success");
                        window.location.href = 'Administracion.php';
                    } else {
                        alert(data);
                        $.Alert("#msg", "Usuario Y Contraseña Incorrecta... Verifique Por Favor", "danger");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Alert: function (div, msg, type) {
            App.alert({
                container: div, //  [ "" ] alerts parent container(by default placed after the page breadcrumbs)
                place: "append", //  [ append, prepent] append or prepent in container
                type: type, //  [success, danger, warning, info] alert's type
                message: msg, //  Mensaje Del Alert
                close: true, //  [true, false] make alert closable
                reset: true, //  [true, false] close all previouse alerts first
                focus: true, //  [true, false] auto scroll to the alert after shown
                closeInSeconds: 5, //  [0, 1, 5, 10] auto close after defined seconds
                icon: ""            //  ["", "warning", "check", "user"] put icon before the message
            });
        },
        AbrirPara: function () {
            $("#ParBusq").modal();
            $('#ParBusq').modal({keyboard: false,
                show: true
            });
            $('.comenta').draggable({
                handle: ".modal-header"
            });
        },
        Dashboard: function () {
            $("#Dashboar").modal({backdrop: 'static', keyboard: false});
            $.localizame1();
         
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
         

            var marcador = new google.maps.Marker({
                /*Creamos un marcador*/
                animation: google.maps.Animation.DROP,
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: mapa, /* Lo vinculamos a nuestro mapa */
                icon: 'Img/Marker_2.png'
            });
            var Info = "<div>"
                    + "<div class='modal-header'  style='padding-top: 3px; padding-bottom: 3px;'>"
                    + "<h4 class='modal-title'>Mi Ubicacion</h4>"
                    + "</div>"

                    + "</div>"
                    + "</div>";
            var infowindow = new google.maps.InfoWindow({
                content: Info
            });
            google.maps.event.addListener(marcador, 'click', function () {
                infowindow.open(mapa, marcador);
            });

            $.CargarInf();
        },
        CargarPara: function () {
            var datos = {
                ope: "CargParaDashboard"
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "GesDashBoard.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbSecre").html(data['Secre']);
                    $("#CbEje").html(data['Ejes']);
                    $("#CbFFinanc").html(data['Fina']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        BuscarDashBoard: function () {
            $("#ParBusq").hide();
            $.localizame1();
        },
        CargarInf: function (OP) {

            var datos = {
                ope: "ConsulGesProy",
                CbSec: $("#CbSecre").val().replace(" ", ""),
                CbEje: $("#CbEje").val().replace(" ", ""),
                CbFin: $("#CbFFinanc").val().replace(" ", ""),
                CbVig: $("#CbVigencia").val().replace(" ", "")
            };

            var PresInicial = 0;
            var PresComprom = 0;
            var PresGastado = 0;
            var PresNoAfect = 0;
            var PresGasComp = 0;

            var chartProEzt = am4core.create("ProyxEst", am4charts.PieChart3D);
            am4core.useTheme(am4themes_animated);

            $.ajax({
                async: false,
                type: "POST",
                url: "GesDashBoard.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data.PI > 0) {

                        //INFORMACION MAPS
                        $.each(data.RawUbiProy, function (i, itemUbi) {

                            $.Colocar_Marcador(mapa, itemUbi.lat, itemUbi.logi,
                                    itemUbi.codproy, itemUbi.nproy, itemUbi.tip, itemUbi.sec,
                                    itemUbi.neje, itemUbi.ncomp, itemUbi.nprog, itemUbi.estad);
                        });
                        //PRESUPUESTO INICIAL
                        PresInicial = data.PI;
                        $("#Presupuesto").html("$ " + number_format2(data.PI, 2, ',', '.'));

                        //PRESUPUESTO COMPROMETIDO
                        PresComprom = parseFloat(data.TotProyPriori);
                        $("#vprecomp").html(number_format2(PresComprom, 2, ',', '.'));

                        //PRESUPUESTO GASTADO
                        PresGastado = parseFloat(data.PresEjecutado) + parseFloat(data.TotContEje);
                        $("#vpregat").html(number_format2(PresGastado, 2, ',', '.'));
                       
                        //PRESUPUESTO NO AFECTADO
                        PresNoAfect = PresInicial - (PresComprom+data.PresEjecutado);
                        
                        $("#vprenafec").html(number_format2(PresNoAfect, 2, ',', '.'));

                        PresGasComp = PresComprom - parseFloat(data.TotContEje)
                        $("#vpreCompGast").html(number_format2(PresGasComp, 2, ',', '.'));

                        ///CALCULAR PORCENTAJES
                        var ppcomp = (PresComprom * 100) / PresInicial;
                        var pgasta = (PresGastado * 100) / PresInicial;
                        var pnafec = (PresNoAfect * 100) / PresInicial;
                        var pgasco = (PresGasComp * 100) / PresComprom;
                        
                        setTimeout(function () {
                            var valor1 = (Number(ppcomp.toFixed(3)) * 360) / 100;

                            var activeBorder = $("#activeBorder1");
                            conGlobal = 0;
                            ValorFinal = ppcomp.toFixed(3);
                            $.llenarCirculos(ValorFinal, "#prec1", activeBorder, valor1, "#39B4CC");
                        }, 800);

                        setTimeout(function () {
                           
                            var valor2 = (Number(pgasta.toFixed(2)) * 360) / 100;
                            var activeBorder = $("#activeBorder2");
                            conGlobal = 0;
                            ValorFinal = pgasta.toFixed(2);
                            $.llenarCirculos(ValorFinal, "#prec2", activeBorder, valor2, "#c83d1e");
                        }, 800);

                        setTimeout(function () {
                            var valor3 = (Number(pnafec.toFixed(3)) * 360) / 100;
                            var activeBorder = $("#activeBorder3");
                            conGlobal = 0;
                            ValorFinal = pnafec.toFixed(3);
                            $.llenarCirculos(ValorFinal, "#prec3", activeBorder, valor3, "#1ec854");
                        }, 800);

                        setTimeout(function () {
                            var valor4 = (Number(pgasco.toFixed(3)) * 360) / 100;
                            var activeBorder = $("#activeBorder4");
                            conGlobal = 0;
                            ValorFinal = pgasco.toFixed(3);
                            $.llenarCirculos(ValorFinal, "#prec4", activeBorder, valor4, "#c83d1e");
                        }, 800);

                        /////PRESUPUESTO COMPROMETIDO POR SERCRETARIA
                        var PreSecr = data.PresSecret;
                        PreSecr.sort(function (a, b) {
                            return b.PorGat - a.PorGat;
                        });
                        var ContSecr = '';

                        

                        $.each(PreSecr, function (i, itemPre) {
                            var colores = ['success', 'info', 'warning', 'danger'];
                            var color = colores[Math.floor(Math.random() * colores.length)];
                            let colorFont = "#333";
                            if(itemPre.PorGat>25){
                                colorFont = "#fff";
                            }
                            ContSecr += ' <div class="row">'
                                    + '     <div class="col-md-7">'
                                    + '         <label>' + $.capitalizeWords(itemPre.Desc) + '</label>'
                                    + '     </div>'
                                    + '     <div class="col-md-5">'
                                    + '         <div class="progress progress-striped  active">'
                                    + '           <div  class="progress-bar progress-bar-' + color + ' active" role="progressbar" aria-valuenow="40" aria-valuemin="0" title="'+itemPre.PorGat+'%" aria-valuemax="100" style="color: '+colorFont+'; width: ' + itemPre.PorGat + '%">' + itemPre.PorGat + '%</div>'
                                    + '         </div>'
                                    + '     </div>'
                                    + ' </div>';
                        });

                        $("#LisSecr").html(ContSecr);


                        /////////PROYECTOS POR ESTADOS


                        chartProEzt.legend = new am4charts.Legend();
                        chartProEzt.innerRadius = am4core.percent(20);
                        chartProEzt.paddingTop = 0;
                        chartProEzt.marginTop = 0;
                        chartProEzt.valign = 'top';
                        chartProEzt.contentValign = 'top';

                        var pieSeries = chartProEzt.series.push(new am4charts.PieSeries3D());

                        chartProEzt.data = data.ProyEst;
                        pieSeries.dataFields.value = "cant";
                        pieSeries.dataFields.category = "Cate";
                        pieSeries.slices.template.cornerRadius = 10;
                        pieSeries.labels.template.text = "{category}: {value} ({value.percent.formatNumber('#.0')}%)";


                        ////////////////PRESUPUESTO COMPROMETIDO VS PRESUPUESTO GASTATO

                        am4core.useTheme(am4themes_animated);

                        // Create chart instance
                        var chart = am4core.create("LisCompxGast", am4charts.XYChart);

                        // Add data
                        chart.data = data.rawPCvsPG;

                        // Create axes
                        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                        dateAxis.renderer.grid.template.location = 0;

                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                        // Create series
                        function createSeries(field, name) {
                            var series = chart.series.push(new am4charts.LineSeries());
                            series.dataFields.valueY = field;
                            series.dataFields.dateX = "date";
                            series.name = name;
                            series.tooltipText = "{dateX}: [b]{valueY}[/]";
                            series.strokeWidth = 2;

                            var bullet = series.bullets.push(new am4charts.CircleBullet());
                            bullet.circle.stroke = am4core.color("#fff");
                            bullet.circle.strokeWidth = 2;

                            return series;
                        }

                        var series1 = createSeries("value", "Presupuesto Comprometido");
                        var series2 = createSeries("value2", "Presupuesto Gastado");
                        var series4 = createSeries("void", "Ocultar Todas");

                        series4.events.on("hidden", function () {
                            series1.hide();
                            series2.hide();
                        });

                        series4.events.on("shown", function () {
                            series1.show();
                            series2.show();
                        });

                        chart.legend = new am4charts.Legend();
                        chart.cursor = new am4charts.XYCursor();
                        $("#sidatos").show();
                        $("#nodatos").hide();
                    } else {
                        $("#nodatos").show();
                        $("#sidatos").hide();
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        capitalizeWords: function (secre) {
            return secre.toLowerCase().replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        },
        llenarCirculos: function (ValorFinal, caja, activeBorder, degs, tipo) {
            conGlobal++;
            if (conGlobal < 0)
                conGlobal = 0;
            if (conGlobal > degs)
                conGlobal = degs;
            prec = (100 * conGlobal) / 360;
            $(caja).html(Math.round(prec) + "%");
            if (degs > 0) {
                activeBorder.css('background-color', tipo);
                if (conGlobal <= 180) {
                    activeBorder.css('background-image', 'linear-gradient(' + (90 + conGlobal) + 'deg, transparent 50%, #A2ECFB 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
                    // alert(conGlobal);return;
                } else {
                    activeBorder.css('background-image', 'linear-gradient(' + (conGlobal - 90) + 'deg, transparent 50%, ' + tipo + ' 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
                }
                setTimeout(function () {
                    if (conGlobal < degs) {
                        $.llenarCirculos(ValorFinal, caja, activeBorder, degs, tipo);
                    } else {
                        $(caja).html(ValorFinal + "%");
                        return;
                    }
                }, 1);
            } else {
                $(caja).html(ValorFinal + "%");
                return;
            }
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

            var marcador = new google.maps.Marker({
                /*Creamos un marcador*/
                animation: google.maps.Animation.DROP,
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: mapa, /* Lo vinculamos a nuestro mapa */
                icon: 'Img/Marker_1.png'
            });
            var Info = "<div>"
                    + "<div class='modal-header'  style='padding-top: 3px; padding-bottom: 3px;'>"
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
        }

    });

    $.Dashboard();
    $.CargarPara();
//    $.CargarInf("T");

    $("#btn_login").on("click", function () {
        $.Login();
    });

    $("#btn_Proyectos").on("click", function () {
        window.location.href = 'Proyectos/';
    });

    $("#btn_Medir").on("click", function () {
        window.location.href = 'Medir_Indicadores/';
    });

    $("#btn_Contratos").on("click", function () {
        window.location.href = 'Contratos/';
    });

    $("#btn_plan").on("click", function () {
        window.location.href = 'Plan_de_Desarrollo/';
    });

    $("#btn_para").on("click", function () {
        window.location.href = 'Menu_Parametros_Generales/';
    });

    $("#btn_AvProy").on("click", function () {
        window.location.href = 'Avance_Proyectos/';
    });

    $("#btn_AvCont").on("click", function () {
        window.location.href = 'Avance_Contratos/';
    });


    $("#btn_user").on("click", function () {
        window.location.href = 'Usuarios/';
    });
//    $("#btn_panel_notifi").on("click", function() {
//        window.location.href = '#';
//    });
    $("#btn_audito").on("click", function () {
        window.location.href = 'Administracion/Auditoria.php';
    });




});