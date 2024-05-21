$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_p_proy").addClass("start active open");
    $("#menu_p_proy_ind").addClass("start active open");
    $("#menu_p_proy_ind_Medi").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";
    var contIndMedi = 0;
    var Dat_IndMedi = "";
    var Dat_Actv = "";
    $("#CbFreMed,#CbTipInd,#CbTendInd,#CbAnioProy,#CbUnida,#CbAnio").selectpicker();
    $("#txt_fecha_MediPlan,#txt_fecha_Medi").datepicker({
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
                url: "../Paginadores/PagProyectoIndicadoresMedir.php",
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
        listIndPlan: function () {

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
                url: "../Paginadores/PagProyectoIndicadoresPlan.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_IndicadorPlan').html(data['cad']);
                    $('#bot_IndicadorPlan').html(data['cad2']);
                    $('#cobpagPlan').html(data['cbp']);
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
                url: "../Paginadores/PagProyectoIndicadoresMedir.php",
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
            $('#tab_02_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_03").removeClass("active in");
            $("#tab_03_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Indicadores de Proyecto</a>");
        },
        MedirIndicador: function (cod) {
            var formula = "";
            var varia;
            var metas = "";
            $("#txt_id").val(cod);
            var datos = {
                ope: "BusqDetalleIndicadores",
                cod: cod,
                proy: $("#id_ori").val()
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#Nom_Indi").html(data['nom']);
                    $("#Obj_Indi").html(data['obj']);
                    $("#Proces").html(data['nomproc']);
                    $("#Frecuenc").html(data['frec']);
                    $("#TipoInd").html(data['tind']);
                    $("#Meta").html(data['met']);
                    $("#Fuent").html(data['oinf']);
                    $("#Respon").html(data['resp']);
                    $("#Formula").html(data['relmat']);
                    $("#txt_formula").val(data['relmat']);
                    varia = data.variables;

                    $("#txt_expre").val(data['relmat']);
                    $('#CbFreMedmedi').html(data['freMedi']);
                    $('#CbMetas').html(data['metas']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $('#tb_Variables').html("");
            var fila = '<thead>';
            fila += '<tr>';
            $.each(varia, function (i, item) {
                fila += "<td>" + item.variable + "</td>";
            });

            fila += "<td>Meta</td>";
            fila += "<td>Indicador</td>";
            fila += '</tr>';
            fila += '</thead>';
            fila += '<tr class="selected" id="filaVariables' + contIndMedi + '" >';

            $.each(varia, function (i, item) {
                fila += "<td><input type='hidden' id='txtTit" + i + "' name='txtTit[]' value='" + item.variable + "' /><input type='hidden'   id='txt_vari" + i + "' name='txt_vari[]' value='" + item.variable + "' />\n\
                         <input type='text' onchange='$.cambio(this.value,this.id)' class='form-control' id='vari_" + i + "' name='vari[]' value='' /></td>";
            });

            fila += "<td><input type='text' class='form-control' disabled id='MetaProy' name='MetaProy' value='' /></td>";
            fila += "<td><label id='resuIndi'><input type='hidden' class='form-control' disabled id='meta' name='txt_resindi' value='' /></label></td>";
            fila += '</tr>';
            fila += '</tbody>';
            $('#tb_Variables').append(fila);
            $('#tab_MedIndP').show();
            $("#tab_IndPoliP").removeClass("active in");
            $("#tab_IndPol").removeClass("active in");
            $("#tab_MedIndP").addClass("active in");
            $("#tab_MedInd").addClass("active in");
        },
        EvalIndiProy: function (cod) {
            var formula = "";
            var varia;
            var metas = "";
            var parcod = cod.split("//");
            $("#txt_idEval").val(parcod[0]);
            if (parcod[1] === "EVALUADO") {
                $("#btn_guardarActPlan").prop('disabled', true);
                $("#btn_MedIndPlan").prop('disabled', true);
            } else {
                $("#btn_guardarActPlan").prop('disabled', false);
                $("#btn_MedIndPlan").prop('disabled', false);
            }

            var datos = {
                ope: "BusqDetalleIndicadorPlan",
                cod: parcod[0],
                idind: parcod[2]
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#Nom_Indi").html(data['nom']);
                    $("#Obj_Indi").html(data['obj']);
                    $("#Proces").html(data['nomproc']);
                    $("#Frecuenc").html(data['frec']);
                    $("#TipoInd").html(data['tind']);
                    $("#Meta").html(data['met']);
                    $("#Fuent").html(data['oinf']);
                    $("#Respon").html(data['resp']);
                    $("#Formula").html(data['relmat']);
                    $("#txt_formula").val(data['relmat']);
                    $("#txt_idPlan").val(data['id_indi']);
                    $("#txt_id").val(data['id_indi']);
                    $("#txt_metaPlan").val(data['id_meta']);

                    $("#id_oriPlan").val(data['idorigen']);
                    $("#txt_idMed").val(data['id_med']);
                    //formula = data['relmat'];
                    varia = data.variables;
                    metas = data['meta'];
                    $("#txt_exprePlan").val(data['relmat']);
                    $('#CbFreMedmedi').html(data['freMedi']);
                    ////
                    $("#AnioPlan").val(data['anio']);
                    $("#FreMedmediPlan").val(data['frecuencia']);
                    ////

                    $("#tb_Activ").html(data['tb_Activ']);
                    $("#contActivi").val(data['contAct']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            var TitVariables = [];

            $('#tb_VariablesPlan').html("");
            var fila = '<thead>';
            fila += '<tr>';
            $.each(varia, function (i, item) {
                fila += "<td>" + item.variable + "</td>";
                TitVariables.push(item.variable);
            });



            fila += "<td>Meta</td>";
            fila += "<td>Indicador</td>";
            fila += '</tr>';
            fila += '</thead>';
            fila += '<tr class="selected" id="filaVariablesPlan' + contIndMedi + '" >';

            $.each(varia, function (i, item) {

                fila += "<td><input type='hidden' id='txtTit" + i + "' name='txtTitplan[]' value='" + item.variable + "' /><input type='hidden'   id='txt_variplan" + i + "' name='txt_variplan[]' value='" + item.variable + "' />\n\
                         <input type='text' onchange='$.cambioPlan(this.value,this.id)' class='form-control' id='variplan_" + i + "' name='variplan[]' value='' /></td>";
            });

            fila += "<td><input type='text' class='form-control' disabled id='metaPlan' name='Meta' value='" + metas + "' /></td>";
            fila += "<td><label id='resuIndiPlan'><input type='hidden' class='form-control' disabled id='metaPlan' name='txt_resindi' value='' /></label></td>";
            fila += '</tr>';
            fila += '</tbody>';
            $('#tb_VariablesPlan').append(fila);
            $("#TitVar").val(TitVariables);

            $('#tab_MedIndPlanP').show();
            $("#tab_IndPlanP").removeClass("active in");
            $("#tab_IndPlan").removeClass("active in");
            $("#tab_MedIndPlanP").addClass("active in");
            $("#tab_MedIndPlan").addClass("active in");
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
                    document.getElementById('txt_resindi').value = eval(fx.value).toFixed(1);
                    error = false;
                }
            } catch (err) {
            }
            if (error) // Si no se pudo calcular
                resultado.innerText = "Error";
        },

        cambio: function (val, id) {
            var paid = id.split("_");
            var vartext = $("#txt_vari" + paid[1]).val();

            var textreal = $("#txt_expre").val().replace(vartext, val);
            $("#txt_vari" + paid[1]).val(val);
            $("#txt_expre").val(textreal);

            $.cal();
        },
        calPlan: function () {

            var fx = document.getElementById('txt_exprePlan'),
                    resultado = document.getElementById('resuIndiPlan'),
                    resulInd = document.getElementById('txt_resindiPlan');
            var error = true;
            try {
                //Si sólo tiene números y signos + - * / ( )
                if (/^[\d-+/*()]+$/.test(fx.value)) {
                    // Evaluar el resultado

                    //resultado.value = eval(fx.value);
                    resultado.innerText = eval(fx.value).toFixed(2);
                    document.getElementById('txt_resindiPlan').value = eval(fx.value).toFixed(1);
                    error = false;
                }
            } catch (err) {
            }
            if (error) // Si no se pudo calcular
                resultado.innerText = "Error";
        },
        cambioPlan: function (val, id) {
            var paid = id.split("_");

            var vartext = $("#txt_variplan" + paid[1]).val();

            var textreal = $("#txt_exprePlan").val().replace(vartext, val);
            $("#txt_variplan" + paid[1]).val(val);
            $("#txt_exprePlan").val(textreal);

            $.calPlan();
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
                url: "../Paginadores/PagProyectoIndicadoresMedir.php",
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
                url: "../Paginadores/PagProyectoIndicadoresMedir.php",
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
                url: "../Paginadores/PagProyectoIndicadoresMedir.php",
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

        },
        CambMeta: function (val) {
            var pmet = val.split("/");
            $("#MetaProy").val(pmet[1]);
        },
        Graficar: function (met) {
       
            $("#titformiGraf").html("Grafica de Datos de Medición - " + $("#titu_met" + met).val());

            $("#MostrarGrafica").modal("show");
            var datos = {
                id: $("#txt_id").val(),
                met: met,
                ope: "GrafIndicadores",
                ori: 'Banco'
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                async: false,
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    AmCharts.addInitHandler(function (chart) {
                        // check if there are graphs with autoColor: true set
                        for (var i = 0; i < chart.graphs.length; i++) {
                            var graph = chart.graphs[i];
                            if (graph.autoColor !== true)
                                continue;
                            var colorKey = "autoColor-" + i;
                            graph.lineColorField = colorKey;
                            graph.fillColorsField = colorKey;
                            for (var x = 0; x < chart.dataProvider.length; x++) {
                                var color = chart.colors[x]
                                chart.dataProvider[x][colorKey] = color;
                            }
                        }

                    }, ["serial"]);
                    var chart = AmCharts.makeChart("chartdiv", {
                        "type": "serial",
                        "dataFields": {
                            "valueX": "date",
                            "valueY": "value"
                        },

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
                        "title": {
                            "text": "Turnover ($M)",
                            "fontWeight": "bold"
                        },
                        "startDuration": 1,

                        "graphs": [{
                                "alphaField": "alpha",
                                "balloonText": "<span style='font-size:12px;'>[[title]] en [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                                "fillAlphas": 1,
                                "title": "Indicador",
                                "type": "column",
                                "valueField": "resulindi",
                                "dashLengthField": "dashLengthColumn",
                                "autoColor": true
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
                        "categoryField": "anio2",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "axisAlpha": 0,
                            "tickLength": 0
                        },
                        "legend": {
                            "useGraphSettings": true
                        },
                        "yAxes": [{
                                "type": "ValueAxis",
                                "title": {
                                    "text": "Turnover ($M)",
                                    "fontWeight": "bold"
                                }
                            }],

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
                        $('#CbRespo').html(data['respon']);
                    } else if (op === "F") {
                        $('#Cbfuente').html(data['fuent']);
                    } else if (op === "P") {
                        $('#CbProceso').html(data['proce']);
                    } else if (op === "R") {
                        $('#CbRespo').html(data['respon']);
                    }


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        AddMedIndi: function () {

            $.UploadDoc();
            var flag = "";

            var txt_fecha_Medi = $("#txt_fecha_Medi").val();
            var CbAnio = $("#CbAnio").val();
            var CbMetas = $("#CbMetas").val();
            var txt_AnaCaus = $("#txt_AnaCaus").val();
            var txt_AccProp = $("#txt_AccProp").val();
            var PaMetas = CbMetas.split("/");
            var CbFreMedmedi = $("#CbFreMedmedi").val();
            var txt_Respo = $("#txt_Respo").val();
            var Src_File = $("#Src_File").val();
            var Name_File = $("#Name_File").val();
            var Variables = [];
            var TitVariables = [];


            if (CbAnio === " ") {
                $.Alert("#msg", "Por Favor Ingrese la Vigencia...", "warning", 'warning');
                return;
            }

            $("input[name='vari[]']").each(function (indice, elemento) {
                if ($(elemento).val() === "" || $(elemento).val() === " ") {
                    $.Alert("#msg", "Por Favor Ingrese el valor de las variable...", "warning", 'warning');
                    $(elemento).focus();
                    return;
                }
            });

            var meta = $("#MetaProy").val();
            var txt_resindi = $("#txt_resindi").val();
            contIndMedi = parseInt($("#contIndMedi").val());
            if (contIndMedi === 0) {
                $('#tb_IndMedi').html("");
                var fila = '<thead>';
                fila += '<tr>';
                fila += "<td>Vigencia</td>";

                $("input[name='txtTit[]']").each(function (indice, elemento) {
                    fila += "<td>" + $(elemento).val() + "</td>";
                    TitVariables.push($(elemento).val());
                });

                fila += "<td>Meta</td>";
                fila += "<td>Indicador</td>";
                fila += "<td>Evidencias</td>";
                fila += "<td>Acciones</td>";
                fila += '</tr>';
                fila += '</thead>';
            }
            contIndMedi = parseInt($("#contIndMedi").val() + 1);
            fila += '<tr class="selected" id="filaVariables' + contIndMedi + '" >';
            fila += "<td>" + CbAnio + "</td>";

            $("input[name='txt_vari[]']").each(function (indice, elemento) {
                fila += "<td>" + $(elemento).val() + "</td>";
                Variables.push($(elemento).val());
            });


            fila += "<td>" + meta + "</td>";
            fila += "<td>" + txt_resindi + "</td>";

            var src = Src_File.split("*");
            if (Src_File !== "") {
                fila += "<td>";
                for (i = 0; i < src.length; i++) {
                    fila += "<a href='" + src[i] + "' target='_blank' class=\"btn default btn-xs blue\">"
                            + "<i class=\"fa fa-search\"></i> Ver</a>";
                }
                fila += "</td>";
            } else {
                fila += "<td>Ninguna</td>";
            }



            fila += "<td><input type='hidden' class='form-control' disabled id='IdMedInd" + contIndMedi + "' name='IdMedInd' value='" + CbAnio + "//" + txt_fecha_Medi + "//" + CbFreMedmedi + "//" + meta + "//" + txt_resindi + "//" + Src_File + "//" + PaMetas[0] + "//" + txt_AnaCaus + "//" + txt_AccProp + "//" + TitVariables + "//" + Variables + "' /><a onclick=\"$.QuitarVariables('filaVariables" + contIndMedi + "')\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
            fila += '</tbody>';
            $("#contIndMedi").val(contIndMedi);
            $('#tb_IndMedi').append(fila);
            $.LimpiarCalInd();
        },
        LimpiarCalInd: function () {
            $("#CbMetas").select2("val", " ");
            $("#CbAnio").selectpicker("val", " ");
//            $("#CbFreMedmedi").selectpicker("val", " ");

            $("input[name='vari[]']").each(function (indice, elemento) {
                $(elemento).val("");
            });

            $("#MetaProy").val("");
            $("#meta").val("");
            $("#archivos").val(null);
            $("#fileSize").html("0");
            $("#resuIndi").html("");
            $("#Src_File").val("");
            $("#Name_File").val("");
            $("#txt_AnaCaus").val("");
            $("#txt_AccProp").val("");

        },
        reordenarVari: function () {
            var num = 1;
            $('#tb_IndMedi tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_IndMedi tbody input').each(function () {
                $(this).attr('id', "IdMedInd" + num);
                num++;
            });
        },
        QuitarVariables: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarVari();
            contIndMedi = parseInt($('#contIndMedi').val()) - 1;
            $("#contIndMedi").val(contIndMedi);
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
        verResul: function (id) {

            $("#ventanaResul").modal({backdrop: 'static', keyboard: false});
            var datos = {
                ope: "BusqDetalleMedIndiHist",
                cod: id
            };
            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#NomInd").html(data['nombind']);
                    $("#Proyect").html(data['nomproy']);
                    $("#Fecha_med").html(data['nomproc']);
                    $("#Anio").html(data['anio']);
                    $("#FrecuencMed").html(data['frec']);
                    $("#Resulind").html(data['resul']);
                    $("#Fecha_med").html(data['fech']);
                    if (data['uni'] === "Porcentaje") {
                        $("#MetaMed").html(data['meta'] + "%");
                    } else {
                        $("#MetaMed").html(data['meta']);
                    }
                    if (data['estmed'] === "Cumplida") {
                        $("#Estado").html(data['estmed']);
                        $("#Estado").css("color", "#08b734");
                    } else {
                        $("#Estado").html(data['estmed']);
                        $("#Estado").css("color", "#e02222");
                    }

                    $("#Responsable").html(data['resp']);
                    $("#Evidencia").html(data['evid']);
                    //actividades del plan de mejora
                    $("#tb_ActivHisto").html(data['tb_Activ']);
                    //resultado del indicador despues del plan de mejora
                    $("#ResulindMej").html(data['resulMej']);
                    $("#Fecha_medMej").html(data['fechMej']);

                    if (data['estmedMej'] === "Cumplida") {
                        $("#EstadoMej").html(data['estmedMej']);
                        $("#EstadoMej").css("color", "#08b734");
                    } else {
                        $("#EstadoMej").html(data['estmedMej']);
                        $("#EstadoMej").css("color", "#e02222");
                    }

                    $("#ResponsableMej").html(data['resp']);
                    $("#EvidenciaMej").html(data['evid2']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Dta_IndMedi: function () {
            Dat_IndMedi = "";
            $("#tb_IndMedi").find(':input').each(function () {
                Dat_IndMedi += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_IndMedi += "&Long_IndMedi=" + $("#contIndMedi").val();
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

            var meta = $("#CbMetas").val();
            var parmeta = meta.split("/");

            var datos = {
                ope: "BuscValMeta",
                id: parmeta[0],
                anio: anio
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data['meta'] === "noexiste") {
                        $.Alert("#msg", "No se ha ingresado una meta para esta Vigencia...", "warning", 'warning');
                        return;
                    } else {
                        $("#MetaProy").val(data['meta']);
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
            var archivos = document.getElementById("archivos"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
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
        },
        UploadDoc2: function () {
            var archivos = document.getElementById("archivosPlan"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
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
                        $('#Src_FilePlan').val(par_res[1].trim());
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msgArchPlan", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                }
            });
        }

    });
    //======FUNCIONES========\\
    $.Indicadores();
    $.cargarTodo('T');
    //==============\\



    $("#archivos").on("change", function () {
        /* Limpiar vista previa */
//$("#vista-previa").html('');
        var archivos = document.getElementById('archivos').files;
        var navegador = window.URL || window.webkitURL;
        /* Recorrer los archivos */
        var name = "";
        for (x = 0; x < archivos.length; x++)
        {
            /* Validar tamaño y tipo de archivo */
            var size = archivos[x].size;
            var type = archivos[x].type;
            name = name + archivos[x].name + "*";
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
    $("#archivosPlan").on("change", function () {
        /* Limpiar vista previa */
//$("#vista-previa").html('');
        var archivos = document.getElementById('archivosPlan').files;
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
                $.Alert("#msgArchPlan", "El archivo " + name + " supera el máximo permitido 20MB", "success");
            } else {
                var Mb = $.Format_Bytes(size, 2);
                $("#fileSizePlan").html(Mb);
                $("#Name_FilePlan").val(name);
            }

        }

        $.UploadDoc2();
    });
    $("#btn_para").on("click", function () {
        $.Load_ventana('1');
    });
    $("#btn_MedIndPlan").on("click", function () {

        $("#idpanelmedi").show();

    });
    $("#btn_guardarActPlan").on("click", function () {

        Dat_Actv = "";
        var num_elementos = document.getElementsByName("Activ").length;
        for (var contador = 0; contador < num_elementos; contador++) {			//
            if (document.getElementsByName("sel")[contador].checked === true) {	//> se obtiene el value del check seleccionado
                Dat_Actv += document.getElementsByName("Activ")[contador].value + "/"; //
            }
        }

        var Alldata = "Txt_IndEva=" + $("#txt_idEval").val() + "&Dat_Actv=" + Dat_Actv;
        $.ajax({
            type: "POST",
            url: "../Indicadores/GuardarRutAct.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg3", "Datos Guardados Exitosamente...", "success");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    $("#btn_histo").on("click", function () {

        $("#HistorIdi").modal({backdrop: 'static', keyboard: false});
        var datos = {
            id: $("#txt_id").val(),
            ope: "ConsHistoMedIndi"

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
    $("#btn_histo2").on("click", function () {

        $("#HistorIdi").modal("show");
        var datos = {
            id: $("#txt_idPlan").val(),
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
            window.location.href = 'MedirIndicadorProyectos.php';
        }

    });
    $("#busq").on("keypress", function (event) {
        if (event.which == 13) {
            $.Load_ventana('2');
        }
    });
    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {
        if ($("#contIndMedi").val() === "0") {
            $.Alert("#msg", "No se ha Realizado ninguna medicion...", "warning", 'warning');
            return;
        }

        $.Dta_IndMedi();
        var datos = "txt_indi=" + $("#txt_id").val() + "&txt_Respo=" + $("#txt_Respo").val() + "&id_ori=" + $("#id_ori").val()
                + "&acc=" + $("#acc").val();
        var Alldata = datos + Dat_IndMedi;
        $.ajax({
            type: "POST",
            url: "../Indicadores/GuardarMedicion.php",
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
    $("#btn_guardarPlan").on("click", function () {


        $("input[name='variplan[]']").each(function (indice, elemento) {
            if ($(elemento).val() === "" || $(elemento).val() === " ") {
                $.Alert("#msg", "Por Favor Ingrese el valor de las variable...", "warning", 'warning');
                $(elemento).focus();
                return;
            }
        });

        $.UploadDoc2();
        var Variables = [];

        $("input[name='txt_variplan[]']").each(function (indice, elemento) {
            Variables.push($(elemento).val());
        });

        var datos = "txt_indi=" + $("#txt_idPlan").val() + "&txt_Respo=" + $("#txt_RespoPlan").val()
                + "&id_ori=" + $("#id_oriPlan").val() + "&acc=" + $("#acc").val()
                + "&txt_resindiPlan=" + $("#txt_resindiPlan").val() + "&metaPlan=" + $("#metaPlan").val()
                + "&Src_FilePlan=" + $("#Src_FilePlan").val() + "&txt_fecha_MediPlan=" + $("#txt_fecha_MediPlan").val()
                + "&FreMedmediPlan=" + $("#FreMedmediPlan").val() + "&txt_metaPlan=" + $("#txt_metaPlan").val()
                + "&txt_idEval=" + $("#txt_idEval").val() + "&ValVar=" + Variables + "&TitVar=" + $("#TitVar").val()
                + "&txt_AnaCausPlan=" + $("#txt_AnaCausPlan").val() + "&txt_AccPropPlan=" + $("#txt_AccPropPlan").val()
                + "&AnioPlan=" + $("#AnioPlan").val() + "&txt_idMed=" + $("#txt_idMed").val();
        var Alldata = datos;
        $.ajax({
            type: "POST",
            url: "../Indicadores/GuardarMedicionPlan.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msgPla", "Datos Guardados Exitosamente...", "success");
                    $.listIndPlan();
                    // $("#btn_nuevo").prop('disabled', false);
                    $("#btn_guardarPlan").prop('disabled', true);
//                    $("#txt_codigo").prop('disabled', true);
//                    $("#txt_Descripcion").prop('disabled', true);
//                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});
///////////////////////
