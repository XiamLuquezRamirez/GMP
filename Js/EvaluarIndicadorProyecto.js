$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_p_proy").addClass("start active open");
    $("#menu_p_proy_ind").addClass("start active open");
    $("#menu_p_proy_ind_Eva").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";
    var contIndMedi = 0;
    var contActivi = 0;
    var Dat_Activ = "";
    $("#CbFreMed,#CbTipInd,#CbTendInd,#CbAnioProy,#CbUnida,#CbAnio").selectpicker();
    $("#txt_FecTermi").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });
    $.extend({
        Indicadores: function () {

            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ori: $("#txt_ori").val()
            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectoIndicadoresEvaluar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Indicador').html(data['cad']);
                    $('#bot_Indicador').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqIndicador: function (val) {


            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ori: $("#txt_ori").val()

            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectoIndicadoresEvaluar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Indicador').html(data['cad']);
                    $('#bot_Indicador').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        VerIndiProy: function (cod) {

            $("#id_ori").val(cod);
            var datos = {
                ope: "BusqIndicadoresProyect",
                cod: cod
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#nom_poli").html(data['nom_politica']);
                    $("#tb_Indicadores").html(data['CadIndi']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Indicadores de Proyecto</a>");
        },
        EvalIndiProy: function (cod) {

            $("#txt_id").val(cod);
            $("#acc").val("1");
            var datos = {
                ope: "BusqDetalleMedIndi",
                cod: cod
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#IdInd").val(data['idind']);
                    $("#NomInd").html(data['nombind']);
                    $("#Proyect").html(data['nomproy']);
                    $("#Fecha_med").html(data['fecmed']);
                    $("#Anio").html(data['aniomed']);
                    $("#Frecuenc").html(data['frec']);
                    if (data['tvari'] === "Porcentaje") {
                        $("#Resulind").html(data['resind'] * 100 + "%");
                    } else {
                        $("#Resulind").html(data['resind']);
                    }
                    if (data['tvari'] === "Porcentaje") {
                        $("#Meta").html(data['metproy'] + "%");
                    } else {
                        $("#Meta").html(data['metproy']);
                    }
//                    if (data['estmed'] === "Con Riesgo") {
//                        $("#Estado").html(data['estmed']);
//                    } else {
//                        $("#Estado").html(data['estmed'] + " (" + data['descrit'] + ")");
//                    }

                    $("#Responsable").html(data['responsa']);
                    $("#Evidencia").html(data['evid']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Evaluar Indicadores de Proyectos</a>");
        },
        EvalIndiProyEdit: function (cod) {
            var formula = "";
            var varia = "";
            var metas = "";
            $("#txt_id").val(cod);
            $("#acc").val("2");
            
            var datos = {
                ope: "BusqDetalleMedIndiEdit",
                cod: cod
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#IdInd").val(data['id_indi']);
                    $("#NomInd").html(data['nombind']);
                    $("#Proyect").html(data['nomproy']);
                    $("#Fecha_med").html(data['fecmed']);
                    $("#Anio").html(data['aniomed']);
                    $("#Frecuenc").html(data['frec']);
                    if (data['tvari'] === "Porcentaje") {
                        $("#Resulind").html(data['resind'] * 100 + "%");
                    } else {
                        $("#Resulind").html(data['resind']);
                    }
                    if (data['tvari'] === "Porcentaje") {
                        $("#Meta").html(data['metproy'] + "%");
                    } else {
                        $("#Meta").html(data['metproy']);
                    }
//                    if (data['estmed'] === "Con Riesgo") {
//                        $("#Estado").html(data['estmed'] + " (" + data['desries'] + ")");
//                    } else {
//                        $("#Estado").html(data['estmed'] + " (" + data['descrit'] + ")");
//                    }

                    $("#Responsable").html(data['responsa']);
                    $("#Evidencia").html(data['evid']);

                    $("#txt_FecTermi").val(data['fecha']);

                    $("#tb_Activ").html(data['tb_Activ']);
                    $("#contActivi").val(data['contAct']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Evaluar Indicadores de Proyectos</a>");
        },
        cal: function () {
            var fx = document.getElementById('txt_expre'),
                    resultado = document.getElementById('resuIndi'),
                    resulInd = document.getElementById('txt_resindi');
            var error = true;
            try {
                //Si sólo tiene números y signos + - * / ( )
                if (/^[\d-+/*()]+$/.test(fx.value)) {
                    // Evaluar el resultado

                    //resultado.value = eval(fx.value);
                    resultado.innerText = eval(fx.value).toFixed(2);
                    resulInd.value = eval(fx.value).toFixed(2);
                    error = false;
                }
            } catch (err) {
            }
            if (error) // Si no se pudo calcular
                resultado.innerText = "Error";
        },
        cambio: function (val, id) {
            var formu = "";
            var datos = {
                form: $("#txt_expre").val(),
                ope: "CambioVariables"
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    formu = data['Form'];
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            var pormu = formu.split("/");
            for (i = 0; i < pormu.length; i++) {
                part = id.slice(-1);
                if (parseInt(part) === parseInt(i)) {
                    $("#txt_tit" + part).val(pormu[i]);
                    var textreal = $("#txt_expre").val().replace(pormu[i], val);
                }
            }

            $("#txt_expre").val(textreal);
            $.cal();
        },
        deletIndi: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };
                $.ajax({
                    type: "POST",
                    url: "../PlanAccion/GuardarPlanAccion.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success");
                            $.Indicadores();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ori: $("#txt_ori").val()
            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectoIndicadoresEvaluar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        combopag: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ori: $("#txt_ori").val()
            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectoIndicadoresEvaluar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Indicador').html(data['cad']);
                    $('#bot_Indicador').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        combopag2: function (nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val(),
                ori: $("#txt_ori").val()
            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectoIndicadoresEvaluar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Indicador').html(data['cad']);
                    $('#bot_Indicador').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        NewRespon: function () {
            window.open("../Administracion/GestionCargos.php", '_blank');
        },
        UpdateRespon: function () {
            $.cargarTodo('R');
        },
        NewFuente: function () {
            window.open("../Administracion/GestionOrigenInformacion.php", '_blank');
        },
        UpdateFuente: function () {
            $.cargarTodo('F');
        },
        NewProceso: function () {
            window.open("../Administracion/GestionProcesos.php", '_blank');
        },
        UpdateProceso: function () {
            $.cargarTodo('P');
        },
        VefUnidad: function (val, id) {
            if ($("#CbUnida").val() === "Pesos") {
                textm(val, id);
            }
            6
        },
        Graficar: function () {
            $("#MostrarGrafica").modal("show");
            var datos = {
                id: $("#txt_id").val(),
                ope: "GrafIndicadores",
                ori: 'Banco'
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    var chart = AmCharts.makeChart("chartdiv", {
                        "type": "serial",
                        "addClassNames": true,
                        "theme": "light",
                        "autoMargins": false,
                        "marginLeft": 30,
                        "marginRight": 8,
                        "marginTop": 10,
                        "marginBottom": 26,
                        "balloon": {
                            "adjustBorderColor": false,
                            "horizontalPadding": 10,
                            "verticalPadding": 8,
                            "color": "#ffffff"
                        },
                        "dataProvider": data,
                        "valueAxes": [{
                                "axisAlpha": 0,
                                "position": "left"
                            }],
                        "startDuration": 1,
                        "graphs": [{
                                "alphaField": "alpha",
                                "balloonText": "<span style='font-size:12px;'>[[title]] en [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                                "fillAlphas": 1,
                                "title": "Indicador",
                                "type": "column",
                                "valueField": "resulindi",
                                "dashLengthField": "dashLengthColumn"
                            }, {
                                "id": "graph2",
                                "balloonText": "<span style='font-size:12px;'>[[title]] en [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                                "bullet": "round",
                                "lineThickness": 3,
                                "bulletSize": 7,
                                "bulletBorderAlpha": 1,
                                "bulletColor": "#FFFFFF",
                                "useLineColorForBulletBorder": true,
                                "bulletBorderThickness": 3,
                                "fillAlphas": 0,
                                "lineAlpha": 1,
                                "title": "Meta",
                                "valueField": "meta",
                                "dashLengthField": "dashLengthLine"
                            }],
                        "categoryField": "anio",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "axisAlpha": 0,
                            "tickLength": 0
                        },
                        "legend": {
                            "useGraphSettings": true
                        },
                        "export": {
                            "enabled": true
                        }
                    });
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        cargarTodo: function (op) {

            var datos = {
                ope: "ConsTodoIndi"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (op === "T") {
                        $('#Cbfuente').html(data['fuent']);
                        $('#CbProceso').html(data['proce']);
                        $('#CbRespo').html("<option value=' '>Seleccione...</option>" + data['respon2']);
                    } else if (op === "F") {
                        $('#Cbfuente').html(data['fuent']);
                    } else if (op === "P") {
                        $('#CbProceso').html(data['proce']);
                    } else if (op === "R") {
                        $('#CbRespo').html("<option value=' '>Seleccione...</option>" + data['respon']);
                    }


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        AddActividades: function () {

            var desAct = $("#txt_Actividad").val();
            var resp = $('#CbRespo option:selected').text();
            var Codresp = $('#CbRespo').val();

            contActivi = parseInt($("#contActivi").val()) + 1;
            var fila = '<tr class="selected" id="filaAct' + contActivi + '" >';
            fila += "<td>" + contActivi + "</td>";
            fila += "<td>" + desAct + "</td>";
            fila += "<td>" + resp + "</td>";
            fila += "<td><input type='hidden' id='Acti" + contActivi + "' name='actividades' value='" + desAct + "//" + Codresp + "' /><a onclick=\"$.QuitarActi('filaAct" + contActivi + "')\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
            $('#tb_Activ').append(fila);
            $.reordenarAct();

            $("#txt_Actividad").val("");
            $("#CbRespo").select2("val", " ");

            $("#contActivi").val(contActivi);

        },
        reordenarAct: function () {
            var num = 1;
            $('#tb_Activ tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });

            num = 1;
            $('#tb_Activ tbody input').each(function () {
                $(this).attr('id', "Acti" + num);
                num++;
            });
        },
        QuitarActi: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarAct();
            contActivi = $('#contActivi').val();
            contActivi = contActivi - 1;
            $("#contActivi").val(contActivi);
        },
        Validar: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";
            Id = "#txt_NomIndi";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_NomIndi").addClass("has-error");
            } else {
                $("#From_NomIndi").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbProceso";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Proceso").addClass("has-error");
            } else {

                $("#From_Proceso").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbFreMed";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_FreMed").addClass("has-error");
            } else {
                $("#From_FreMed").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbUnida";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Unida").addClass("has-error");
            } else {
                $("#From_Unida").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbRespo";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Respo").addClass("has-error");
            } else {
                $("#From_Respo").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_RelMat";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_RelMat").addClass("has-error");
            } else {
                $("#From_RelMat").removeClass("has-error");
                Op_Validar.push("Ok");
            }

//            Id = "#CbResponsa";
//            Value = $(Id).val();
//
//            if (Value === "" || Value === " ") {
//                Op_Validar.push("Fail");
//                $("#From_Resp").addClass("has-error");
//            } else {
//                $("#From_Resp").removeClass("has-error");
//                Op_Validar.push("Ok");
//            }

//            Id = "#CbResponsa";
//            Value = $(Id).val();
//            if (Value === "" || Value === " ") {
//                Op_Validar.push("Fail");
//                $("#From_Ind").addClass("has-error");
//            } else {
//                $("#From_Ind").removeClass("has-error");
//                Op_Validar.push("Ok");
//            }



            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);
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
        SelEjes: function (par) {

            var ppar = par.split("//");
            $("#txt_cod_pp").val(ppar[4] + '-');
            $("#txt_id_ej").val(ppar[0]);
            $("#txt_id_Est").val(ppar[3]);
            $("#txt_nomb_eje").val(ppar[2]);
            $("#txt_nomb_est").val(ppar[5]);
            $("#ventana").modal("hide");
            $('#nestr').show();
        },
        Load_ventana: function (op) {
            if (op === "1") {
                $("#ventana").modal("show");
            }

            var datos = {
                bus: $("#busq").val(),
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEstrVent.php",
                data: datos,
                dataType: 'json',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVent').html(data['cbp']);
                },
                beforeSend: function () {
                    $('#cargando').modal('show');
                },
                complete: function () {
                    $('#cargando').modal('hide');
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR' + JSON.stringify(error_messages));
                }
            });
        },
        Dta_Act: function () {
            Dat_Activ = "";
            $("#tb_Activ").find(':input').each(function () {
                Dat_Activ += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Activ += "&Long_Act=" + $("#contActivi").val();
        },
        conse: function () {

            var text = $("#atitulo").text();
            if (text === "Crear Indicador") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: "INDICADOR"
                };
                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#txt_NumIndi").val(data['cid']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
                //  $('#mopc').hide();

            }

        },
        BuscMeta: function (anio) {

            var indi = $("#txt_id").val();

            var datos = {
                ope: "BuscValMeta",
                id: indi,
                anio: anio
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data['meta'] === "noexiste") {
                        $.Alert("#msg", "No se ha ingresado una meta para este Año...", "warning", 'warning');
                        return;
                    } else {
                        $("#meta").val(data['meta']);
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Format_Bytes: function (bytes, decimals) {
            if (bytes == 0)
                return '0 Byte';
            var k = 1024;
            var dm = decimals + 1 || 3;
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
        },
        UploadDoc: function () {
            var archivos = document.getElementById("archivos");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
                archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }

            var ruta = "../Indicadores/upload.php";

            $.ajax({
                async: false,
                url: ruta,
                type: "POST",
                data: archivos,
                contentType: false,
                processData: false,
                success: function (datos)
                {
                    var par_res = datos.split("//");
                    if (par_res[0] === "Bien") {
                        $('#Src_File').val(par_res[1].trim());
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msgArch", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                }
            });
        }

    });
    //======FUNCIONES========\\
    $.Indicadores();
    $.cargarTodo('R');
    //==============\\



    $("#archivos").on("change", function () {
        /* Limpiar vista previa */
        //$("#vista-previa").html('');
        var archivos = document.getElementById('archivos').files;
        var navegador = window.URL || window.webkitURL;
        /* Recorrer los archivos */
        for (x = 0; x < archivos.length; x++)
        {
            /* Validar tamaño y tipo de archivo */
            var size = archivos[x].size;
            var type = archivos[x].type;
            var name = archivos[x].name;

            if (size > 20971520)
            {
                $.Alert("#msgArch", "El archivo " + name + " supera el máximo permitido 20MB", "success");
            } else {
                var Mb = $.Format_Bytes(size, 2);
                $("#fileSize").html(Mb);
                $("#Name_File").val(name);
            }

        }
    });

    $("#btn_para").on("click", function () {
        $.Load_ventana('1');
    });
    $("#btn_histo").on("click", function () {

        $("#HistorIdi").modal("show");
        var datos = {
            id: $("#txt_id").val(),
            ope: "ConsHistoMedIndi",
            ori: "Banco"

        };
        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            dataType: 'json',
            success: function (data) {
                $('#tab_HistIndi').html(data['CadIndi']);
            },
            beforeSend: function () {
                $('#cargando').modal('show');
            },
            complete: function () {
                $('#cargando').modal('hide');
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR' + JSON.stringify(error_messages));
            }
        });
    });
    $("#btn_nuevo").on("click", function () {

        $('#acc').val("1");
        $('#txt_CodIndi').val("");
        $.conse();
        $('#txt_NomIndi').val("");
        $('#txt_ObjIndi').val("");
        $("#CbProceso").val(" ").change();
        $("#CbFreMed").selectpicker("val", " ");
        $("#CbUnida").selectpicker("val", " ");
        $("#Cbfuente").val(" ").change();
        $("#CbTipInd").selectpicker("val", " ");
        $("#CbRespo").val(" ").change();
        $('#txt_RelMat').val("");
        $('#txt_LinBase').val("");
        $('#txt_MetInd').val("");
        $("#CbTendInd").selectpicker("val", " ");
        $('#txt_MetInd').val("");
        $('#contProyecc').val("0");
        $("#tb_Body_Proyeccion").html("");
        $('#txt_AcepMax').val("");
        $('#txt_AcepMin').val("");
        $('#txt_RiesMax').val("");
        $('#txt_RiesMin').val("");
        $('#txt_CritMax').val("");
        $('#txt_CritMin').val("");
        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);
    });
    $("#btn_cancelar").on("click", function () {
        if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
            $('#acc').val("1");
            $('#txt_CodIndi').val("");
            $.conse();
            $('#txt_NomIndi').val("");
            $('#txt_ObjIndi').val("");
            $("#CbProceso").val(" ").change();
            $("#CbFreMed").selectpicker("val", " ");
            $("#CbUnida").selectpicker("val", " ");
            $("#Cbfuente").val("").change();
            $("#CbTipInd").selectpicker("val", " ");
            $("#CbRespo").val("").change();
            $('#txt_RelMat').val("");
            $('#txt_LinBase').val("");
            $('#txt_MetInd').val("");
            $("#CbTendInd").selectpicker("val", " ");
            $('#txt_MetInd').val("");
            $('#contProyecc').val("0");
            $("#tb_Body_Proyeccion").html("");
            $('#txt_AcepMax').val("");
            $('#txt_AcepMin').val("");
            $('#txt_RiesMax').val("");
            $('#txt_RiesMin').val("");
            $('#txt_CritMax').val("");
            $('#txt_CritMin').val("");
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' onclick='$.conse();' data-toggle='tab' id='atitulo'>Crear Indicador</a>");
        }

    });
    $("#busq").on("keypress", function (event) {
        if (event.which == 13) {
            $.Load_ventana('2');
        }
    });
    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        $.Dta_Act();
        var datos = "txt_Med=" + $("#txt_id").val() + "&txt_FecTermi=" + $("#txt_FecTermi").val()
                + "&IdInd=" + $("#IdInd").val() + "&acc=" + $("#acc").val() + "&ori=Banco";
        var Alldata = datos + Dat_Activ;
        $.ajax({
            type: "POST",
            url: "../Indicadores/GuardarEvaluacion.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success");

                    $("#btn_nuevo").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});
///////////////////////
