$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_p_proy").addClass("start active open");
    $("#menu_p_Indi_ges").addClass("active");

    $("#txt_FMed").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    $("#CbTendencia").selectpicker();

    var Datos, Op_Save, Id;
    Datos = "";
    Op_Save = "New";
    Id = " ";
    var X = 0;
    var Op_Edit = "New";
    var Id_Tr = "";
    var Dat_Table = "";
    var Order;
    //Order = " A.id_contra DESC";
    var Url = "Prorroga.jsp";
    var Op_Validar = [];
    var Vali = [];
    var Op_Vali = "Ok";
    var Op_Anx = "Fail";
    var List_Doc = [];
    var Op_Anx = "New";
    Op_Anx = "New";
    var Op_Url = "";

    var contMedi = 0;
    var contMetas = 0;

    var Dat_Medi = "";


    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        Proyectos: function () {
            var datos = {
                opc: "CargDependencia",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosIndi.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqProyect: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosIndi.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        paginador: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosIndi.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosIndi.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
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
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosIndi.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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
        Load_ventana: function (op) {
            if (op === "1") {
                $("#ventanaMeta").modal("show");
            }

            var datos = {
                bus: $("#busq").val(),
                pag: "1",
                op: "1",
                nreg: $("#nregVent").val(),
                ori: 'Banco'

            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetVent.php",
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
        VerMeta: function (cod) {

            $("#ventanaDetaMeta").modal("show");

            var datos = {
                ope: "CargaDetMeta",
                cod: cod

            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'json',
                success: function (data) {

                    $("#CodMeta").html(data['cod_meta']);
                    $("#DesMeta").html(data['desc_meta']);
                    $("#LinBase").html(data['base_meta']);
                    $('#Prop').html(data["prop_metas"]);
                    $('#Respo').html(data["resp_Met"]);
                    $('#Eje').html(data["des_eje_metas"]);
                    $('#Compo').html(data["des_comp_metas"]);
                    $('#Prog').html(data["des_prog_metas"]);
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
        VerMetas: function (contr) {

            $('#ListProyect').hide();
            $('#ListMetas').show();
            $('#titlist').show(100).html("<a href='#tab_01' data-toggle='tab' id='titlist'>Listado de Metas</a>");

            var datos = {
                ope: "CargMetas",
                cod: contr
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Metas').html(data['Cad']);
                    $('#titproyect').html(data['nproy']);
                    $('#txt_idProy').val(data['idproy']);
                    $('#txt_desProy').val(data['nproy']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        MedirMeta: function (idmet) {

            var datos = {
                ope: "CargaDetMeta2",
                cod: idmet,
                idp: $("#txt_idProy").val()

            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'json',
                success: function (data) {

                    $("#CodMeta").html(data['cod_meta']);
                    $("#DesMeta").html(data['desc_meta']);
                    $("#LinBase").html(data['base_meta']);
                    $("#UnidMed").html(data['unimedida']);
                    $("#CbContra").html(data['Contr']);
                    $("#txt_UnidMed").val(data['unimedida']);
                    $('#Prop').html(data["prop_metas"]);
                    $('#Respo').html(data["resp_Met"]);
                    $('#Eje').html(data["des_eje_metas"]);
                    $('#Compo').html(data["des_comp_metas"]);
                    $('#Prog').html(data["des_prog_metas"]);
                    $('#txt_Base').val(data["baseAct_meta"]);
                    $('#txt_idmet').val(data["id_meta"]);
                    $('#txt_desmet').val(data["desc_meta"]);

                    $("#tb_Medicion").html(data['CadMedi']);
                    $("#contMedi").val(data['cont']);

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

            $('#tab_02_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
        },
        VerDetMeta: function (idmet) {

            var datos = {
                ope: "VerDetMeta",
                cod: idmet,
                idp: $("#txt_idProy").val()

            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'json',
                success: function (data) {

                    $("#CodMeta2").html(data['cod_meta']);
                    $("#DesMeta2").html(data['desc_meta']);
                    $("#LinBase2").html(data['base_meta']);
                    $('#Prop2').html(data["prop_metas"]);
                    $('#Respo2').html(data["resp_Met"]);
                    $('#Eje2').html(data["des_eje_metas"]);
                    $('#Compo2').html(data["des_comp_metas"]);
                    $('#Prog2').html(data["des_prog_metas"]);

                    $("#tb_Medicion2").html(data['CadMedi']);


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

            $("#ventanaDetaMeta").modal("show");
        },
        volver: function () {

            $('#ListProyect').show();
            $('#ListMetas').hide();
        },
        CalResulInd: function () {
            if ($("#txt_ResultMeta").val() === "") {
                $.Alert("#msg", "Por Favor Ingrese el Resultado", "warning");
                return;
            } else {
                if ($("#txt_UnidMed").val() === "Cantidad") {
                    base = parseInt($("#txt_Base").val());
                    resu = parseInt($("#txt_ResultMeta").val());
                } else if ($("#txt_UnidMed").val() === "Indice") {
                    base = parseFloat($("#txt_Base").val().replace(",", "."));
                    resu = parseFloat($("#txt_ResultMeta").val().replace(",", "."));
                } else if ($("#txt_UnidMed").val() === "Kilometros") {
                    base = parseFloat($("#txt_Base").val().replace(",", "."));
                    resu = parseFloat($("#txt_ResultMeta").val().replace(",", "."));
                } else if ($("#txt_UnidMed").val() === "Kilogramos") {
                    base = parseFloat($("#txt_Base").val().replace(",", "."));
                    resu = parseFloat($("#txt_ResultMeta").val().replace(",", "."));
                } else if ($("#txt_UnidMed").val() === "Porcentaje") {
                    base = parseFloat($("#txt_Base").val().replace(",", "."));
                    resu = parseFloat($("#txt_ResultMeta").val().replace(",", "."));
                } else if ($("#txt_UnidMed").val() === "Pesos") {
                    base = parseFloat($("#txt_Base").val());
                    resu = parseFloat($("#txt_ResultMeta").val());
                }


                if ($("#CbTendencia").val() === "Aumenar") {
                    resul = base + resu;
                } else if ($("#CbTendencia").val() === "Disminuir") {
                    resul = base - resu;
                } else {
                    resul = $("#txt_Base").val();
                }
                if ($("#txt_UnidMed").val() === "Cantidad") {
                    $("#txt_Result").val(resul);
                } else {
                    $("#txt_Result").val(resul.toFixed(1));
                }

            }
        },
        AddMedic: function () {

            var txt_FMed = $("#txt_FMed").val();
            var txt_Base = $("#txt_Base").val();
            var CbTendencia = $("#CbTendencia").val();
            var txt_ResultMeta = $("#txt_ResultMeta").val();
            var txt_Result = $("#txt_Result").val();
            var CbContra = $("#CbContra").val();
            var Contra = $('#CbContra option:selected').text();
            parcontra = Contra.split("-");



            if (CbContra === " ") {
                $.Alert("#msg", "Por Favor Ingrese el Origen de la Medicion del Indicador...", "warning");
                return;
            } else if (txt_FMed === "") {
                $.Alert("#msg", "Por Favor Ingrese la Fecha de Medición del Indicador...", "warning");
                return;
            } else if (txt_ResultMeta === "") {
                $.Alert("#msg", "Por Favor Ingrese la Medición del Indicador...", "warning");
                return;
            }

            contMedi = $("#contMedi").val();
            contMedi++;
            var fila = '<tr class="selected" id="filaMedi' + contMedi + '" >';

            fila += "<td>" + contMedi + "</td>";
            fila += "<td>" + txt_FMed + "</td>";
            fila += "<td>" + txt_Base + "</td>";
            fila += "<td>" + txt_ResultMeta + "</td>";
            fila += "<td>" + txt_Result + "</td>";
            fila += "<td>" + parcontra[0] + "</td>";
            fila += "<td><input type='hidden' id='Medi" + contMedi + "' name='Medi' value='" + txt_FMed + "//" + txt_Base + "//" + CbTendencia + "//" + txt_ResultMeta + "//" + txt_Result + "//" + CbContra + "//" + Contra + "' />\n\
            <a onclick=\"$.QuitarMedi('filaMedi" + contMedi + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
            </td></tr>";
            $('#tb_Medicion').append(fila);
            $.reordenarMedi();
            $.limpiarMedi(txt_Result);
            $("#contMedi").val(contMedi);

        },
        reordenarMedi: function () {
            var num = 1;
            $('#tb_Medicion tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });

            num = 1;
            $('#tb_Medicion tbody input').each(function () {
                $(this).attr('id', "Medi" + num);
                num++;
            });
        },
        QuitarMedi: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarMedi();
            contMedi = $('#contMedi').val();
            $("#contMedi").val(contMedi - 1);

        },
        limpiarMedi: function (newbase) {
            $("#txt_FMed").val("");
            $("#txt_Base").val(newbase);
            $("#CbTendencia").selectpicker("val", "Aumenar");
            $("#txt_ResultMeta").val("");
            $("#txt_Result").val("");
        },
        Dta_Medi: function () {
            Dat_Medi = "";
            $("#tb_Medicion").find(':input').each(function () {
                Dat_Medi += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Medi += "&Long_Medi=" + $("#contMedi").val();
        },
        CambiarLetra: function (String) {
            var New = "";
            New = String.replace(/À/g, "#Agrave").
                    replace(/Á/g, "#Aacute").
                    replace(/Â/g, "#Acirc").
                    replace(/Ã/g, "#Atilde").
                    replace(/Ä/g, "#Auml").
                    replace(/Å/g, "#Aring").
                    replace(/Æ/g, "#AElig").
                    replace(/Ç/g, "#Ccedil").
                    replace(/È/g, "#Egrave").
                    replace(/É/g, "#Eacute").
                    replace(/Ê/g, "#Ecirc").
                    replace(/Ë/g, "#Euml").
                    replace(/Ì/g, "#Igrave").
                    replace(/Í/g, "#Iacute").
                    replace(/Î/g, "#Icirc").
                    replace(/Ï/g, "#Iuml").
                    replace(/Ð/g, "#ETH").
                    replace(/Ñ/g, "#Ntilde").
                    replace(/Ò/g, "#Ograve").
                    replace(/Ó/g, "#Oacute").
                    replace(/Ô/g, "#Ocirc").
                    replace(/Õ/g, "#Otilde").
                    replace(/Ö/g, "#Ouml").
                    replace(/×/g, "#times").
                    replace(/Ø/g, "#Oslash").
                    replace(/Ù/g, "#Ugrave").
                    replace(/Ú/g, "#Uacute").
                    replace(/Û/g, "#Ucirc").
                    replace(/Ü/g, "#Uuml").
                    replace(/Ý/g, "#Yacute").
                    replace(/Þ/g, "#THORN").
                    replace(/ß/g, "#szlig").
                    replace(/à/g, "#agrave").
                    replace(/á/g, "#aacute").
                    replace(/â/g, "#acirc").
                    replace(/ã/g, "#atilde").
                    replace(/ä/g, "#auml").
                    replace(/å/g, "#aring").
                    replace(/æ/g, "#aelig").
                    replace(/ç/g, "#ccedil").
                    replace(/è/g, "#egrave").
                    replace(/é/g, "#eacute").
                    replace(/ê/g, "#ecirc").
                    replace(/ë/g, "#euml").
                    replace(/ì/g, "#igrave").
                    replace(/í/g, "#iacute").
                    replace(/î/g, "#icirc").
                    replace(/ï/g, "#iuml").
                    replace(/ð/g, "#eth").
                    replace(/ñ/g, "#ntilde").
                    replace(/ò/g, "#ograve").
                    replace(/ó/g, "#oacute").
                    replace(/ô/g, "#ocirc").
                    replace(/õ/g, "#otilde").
                    replace(/ö/g, "#ouml").
                    replace(/÷/g, "#divide").
                    replace(/ø/g, "#oslash").
                    replace(/ù/g, "#ugrave").
                    replace(/ú/g, "#uacute").
                    replace(/û/g, "#ucirc").
                    replace(/ü/g, "#uuml").
                    replace(/ý/g, "#yacute").
                    replace(/þ/g, "#thorn").
                    replace(/ÿ/g, "#yuml").
                    replace(/%/g, "##37").
                    replace(/`/g, "##96").
                    replace(/°/g, "#deg").
                    replace(/'/g, "").
                    replace(/~/g, "##126");
            return New;
        },
        Guardar: function () {
            if ($("#contMedi").val() === "0") {
                $.Alert("#msg", "Por Favor Agregue una Medición del Indicador...", "warning");
                return;
            }

            $.Dta_Medi();

            var datos = "txt_idmet=" + $("#txt_idmet").val() + "&txt_desmet=" + $("#txt_desmet").val()
                    + "&txt_idProy=" + $("#txt_idProy").val() + "&txt_desProy=" + $("#txt_desProy").val();

            var Alldata = datos + Dat_Medi;

            $.ajax({
                type: "POST",
                url: "../Proyecto/GuardarMediIndMeta.php",
                data: Alldata,
                success: function (data) {
                    if (trimAll(data) === "bien") {
                        $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Cancelar: function () {
            if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
                window.location.href = 'MedIndicadores.php';
            }
        }


    });
    //======FUNCIONES========\\
    $.Proyectos();

    $("#btn_paraMet").on("click", function () {
        $.Load_ventana('1');
    });
    $("#btn_volver2").on("click", function () {
        $('#tab_01_pp').show();
        $("#tab_02").removeClass("active in");
        $("#tab_02_pp").removeClass("active in");

        $("#tab_01").addClass("active in");
        $("#tab_01_pp").addClass("active in");

        $("#CodMeta").html("");
        $("#DesMeta").html("");
        $("#LinBase").html("");
        $("#UnidMed").html("");
        $("#CbContra").html("");
        $("#txt_UnidMed").val("");
        $('#Prop').html("");
        $('#Respo').html("");
        $('#Eje').html("");
        $('#Compo').html("");
        $('#Prog').html("");
        $('#txt_Base').val("");
        $('#txt_idmet').val("");
        $('#txt_desmet').val("");

        $("#tb_Medicion").html("");
        $("#contMedi").val("");
    });


    $("#CbCumplimi").on("change", function () {

        if ($("#CbCumplimi").val() === "$") {
            $("#txt_Cumplimi").prop('disabled', false);
            $('#txt_Cumplimi').attr('onblur', 'textCump(this.value, this.id)');

        } else if ($("#CbCumplimi").val() === "#") {
            $("#txt_Cumplimi").prop('disabled', false);
            $('#txt_Cumplimi').attr('onblur', '');
            $("#txt_Cumplimi").val("");
        } else {
            $("#txt_Cumplimi").prop('disabled', true);
            $('#txt_Cumplimi').attr('onblur', '#');
        }
    });

    $("#btn_cancelar").on("click", function () {
        if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
            $("#CbContra").select2("val", " ");
            $("#txt_FMed").val("");
            $("#txt_ResultMeta").val("");
            $("#CbTendencia").selectpicker("val", "Aumenar");
            $("#txt_Result").selectpicker("val", " ");

        }

    });

});
///////////////////////
