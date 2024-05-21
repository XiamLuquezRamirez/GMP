$(document).ready(function () {

    $("#home").removeClass("start active open");

    $("#menu_p_proy").addClass("start active open");
    $("#menu_p_proy_ind").addClass("start active open");
    $("#menu_p_proy_ind_des").addClass("active");

    var Op_Validar = [];
    var Op_Vali = "Ok";
    var contProyecc = 0;
    var Dat_Proy = "";
    var Dat_Metas = "";
    var Dat_Varia = "";
    $("#CbFreMed,#CbTipInd,#CbTendInd,#CbAnioProy,#CbUnida").selectpicker();


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
                url: "../Paginadores/PagIndicadores.php",
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
                url: "../Paginadores/PagIndicadores.php",
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
        editIndi: function (cod) {
            $('#acc').val("2");

            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            $("#txt_id").val(cod);

            var datos = {
                ope: "BusqEditIndicadores",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_CodIndi").val(data['cod_indi']);
                    $("#txt_NumIndi").val(data['num_indi']);
                    $("#txt_NomIndi").val(data['nomb_indi']);
                    $("#txt_ObjIndi").val(data['obj_indi']);
                    $('#CbProceso').val(data["proc_indi"]).change();
                    $("#CbFreMed").selectpicker("val", data['frec_indi']);
                    $("#CbUnida").selectpicker("val", data['unid_indi']);
                    var fuent = data["fuent_indi"].split(",");
                    $("#Cbfuente").val(fuent).change();
                    $("#CbTipInd").selectpicker("val", data['tip_indi']);
                    var resp = data["resp_indi"].split(",");
                    $("#CbRespo").val(resp).change();
                    $("#txt_RelMat").val(data['relmat_indi']);

                    $("#tb_Metas").html(data['Tab_Meta']);
                    $("#contMetas").val(data['contMeta']);

                    $("#tb_Body_Variable").html(data['Tab_Vari']);
                    $("#contVariables").val(data['contVaria']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Indicadores</a>");


        },
        VerIndi: function (cod) {


            $("#btn_nuevo").prop('disabled', false);
            $("#btn_guardar").prop('disabled', true);

            var datos = {
                ope: "BusqEditIndicadores",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_CodIndi").val(data['cod_indi']);
                    $("#txt_NumIndi").val(data['num_indi']);
                    $("#txt_NomIndi").val(data['nomb_indi']);
                    $("#txt_ObjIndi").val(data['obj_indi']);
                    $('#CbProceso').val(data["proc_indi"]).change();
                    $("#CbFreMed").selectpicker("val", data['frec_indi']);
                    $("#CbUnida").selectpicker("val", data['unid_indi']);
                    var fuent = data["fuent_indi"].split(",");
                    $("#Cbfuente").val(fuent).change();
                    $("#CbTipInd").selectpicker("val", data['tip_indi']);
                    var resp = data["resp_indi"].split(",");
                    $("#CbRespo").val(resp).change();
                    $("#txt_RelMat").val(data['relmat_indi']);

                    $("#tb_Metas").html(data['Tab_Meta']);
                    $("#contMetas").val(data['contMeta']);

                    $("#tb_Body_Variable").html(data['Tab_Vari']);
                    $("#contVariables").val(data['contVaria']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Indicadores</a>");


        },
        deletIndi: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Indicadores/GuardarIndicadores.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Indicadores();
                        } else {
                            $.Alert("#msg2", "No se Puede Eliminar, Existen Registros de Medición sobre este Indicador.", "warning", "warning");
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
                url: "../Paginadores/PagIndicadores.php",
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
                url: "../Paginadores/PagIndicadores.php",
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
                url: "../Paginadores/PagIndicadores.php",
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
        cargarTodo: function (op) {

            var datos = {
                ope: "ConsTodoIndi"
            };

            $.ajax({
                type: "POST",
                async: false,
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

        AddMetas: function () {

            var txt_CodMeta = $('#txt_CodMeta').val();
            var txt_DesMeta = $("#txt_DesMeta").val();
            var txt_IdMeta = $("#txt_IdMeta").val();
            var FlatMet = "n";

            $(".metas").each(function () {
                if ($(this).val() === txt_IdMeta) {
                    FlatMet = "s";
                }

            });

            if (txt_CodMeta === "") {
                $.Alert("#msg", "Debe de Seleccionar una Meta", "warning", "warning");
            } else if (FlatMet === "s") {
                $.Alert("#msg", "Esta Meta ya ha sido Asignada... Verifique.", "warning", "warning");
            } else {
                var contMetas = $("#contMetas").val();
                contMetas++;
                var fila = '<tr class="selected" id="filaMetas' + contMetas + '" >';

                fila += "<td>" + contMetas + "</td>";
                fila += "<td>" + txt_CodMeta + "</td>";
                fila += "<td>" + txt_DesMeta + "</td>";
                fila += "<td>  <input type='hidden' class='metas'  value='" + txt_IdMeta + "' /><input type='hidden' id='idMetas" + contMetas + "' name='terce' value='" + txt_IdMeta + "//" + txt_CodMeta + "//" + txt_DesMeta + "' />\n\
                            <a onclick=\"$.QuitarMeta('filaMetas" + contMetas + "')\" class=\"btn default btn-xs red\">"
                        + "<i class=\"fa fa-trash-o\"></i> Quitar</a>\n\
                            \n\
                            \n\<a onclick=\"$.VerMeta('" + txt_IdMeta + "')\"  class='btn default btn-xs blue'><i class='fa fa-search'></i> Ver </a>\n\
                        </td></tr>";
                $('#tb_Metas').append(fila);
//                $.reordenarMetas();
                $("#contMetas").val(contMetas);

                $("#txt_CodMeta").val("");
                $("#txt_DesMeta").val("");
            }


        },
        VerMeta: function (cod) {

            $("#ventanaDetaMeta").modal({backdrop: 'static', keyboard: false});

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
                    $('#Meta').html(data["meta"]);
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
        reordenarMetas: function () {
            var num = 1;
            $('#tb_Metas tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Metas tbody input').each(function () {
                $(this).attr('id', "idMetas" + num);
                num++;
            });
        },
        AbriModForm: function () {
            $("#ModFormula").modal({backdrop: 'static', keyboard: false});
            $("#txt_RelMateEdit").val($("#txt_RelMat").val());
        },
        AddVariable: function () {


            var txt_Variable = $.trim($('#txt_Variable').val());


            if (txt_Variable === "") {
                $.Alert("#msg3", "Debe de Ingresar la Variable", "warning", "warning");
            } else {
                var contvari = $("#contVariables").val();
                contvari++;
                var fila = '<tr class="selected" id="filaVari' + contvari + '" >';

                fila += "<td style='cursor:pointer;' onclick=\"$.AddVarForm('idVariable" + contvari + "')\">" + contvari + "</td>";
                fila += "<td style='cursor:pointer;' onclick=\"$.AddVarForm('idVariable" + contvari + "')\">" + txt_Variable + "</td>";
                fila += "<td><input type='hidden'  id='idVariable" + contvari + "' name='idVariable' value='" + txt_Variable + "' /><a onclick=\"$.QuitarVari('filaVari" + contvari + "')\" class=\"btn default btn-xs red\">"
                        + "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
                $('#tb_Body_Variable').append(fila);

                $("#contVariables").val(contvari);
                $("#txt_Variable").val("");
            }

        },
        QuitarVari: function (id_fila) {
            $('#' + id_fila).remove();
            contVari = $('#contVariables').val() - 1;
            $("#contVariables").val(contVari);
        },
        AddVarForm: function (id) {
            $('#txt_RelMateEdit').val($('#txt_RelMateEdit').val() + $('#' + id).val());
            $('#txt_RelMateEdit').focus();
        },
        ValidarExpre: function () {
            var Exp = $('#txt_RelMateEdit').val();
            var flat = "n";

            $("#tb_Body_Variable").find(':input').each(function () {

                let  variables = $(this).val();
                let posicion = Exp.indexOf(variables);
                if (posicion !== -1) {
                    flat = "s";
                    var patron = variables,
                            nuevoValor = "1";
                    Exp = Exp.replace(patron, nuevoValor);

                } else {
                    flat = "n";
                    $.Alert("#msg3", "Las Variables creadas no corresponden a la Formula Ingresada... Verifique.", "warning", "warning");

                }

            });
            $.cal(Exp);


        },
        cal: function (fx) {
            var error = true;
            try {
                //Si sólo tiene números y signos + - * / ( )
                if (/^[\d-+/*()]+$/.test(fx)) {
                    // Evaluar el resultado

                    //resultado.value = eval(fx.value);
                    error = false;
                    $("#Btn_AddForm").prop('disabled', false);
                    $.Alert("#msg3", "Formula Verificada...", "success", "check");

                }
            } catch (err) {
            }
            if (error) { // Si no se pudo calcular
                $.Alert("#msg3", "Exixten Errores en la Formula... Verifique.", "warning", "warning");

                $("#Btn_AddForm").prop('disabled', false);

            }
        },
        AddForm: function () {
            $('#txt_RelMat').val($('#txt_RelMateEdit').val());
        },
        AddProyecccion: function () {

            var anio = $("#CbAnioProy").val();
            var val = $("#txt_Valot").val();
            valg = "";
            if ($("#txt_Valot").val() === "Pesos") {
                var parval = val.split(" ");
                valg = parseFloat(parval[1].replace(".", "").replace(".", "").replace(",", "."));
            } else {
                valg = $("#txt_Valot").val();
            }
            var flag = "si";

            if ($("#idProy1").length > 0) {
                $("#tb_Proyec").find(':input').each(function () {
                    par = $(this).val().split("//");
                    if (par[0] === anio) {
                        $.Alert("#msgPro", "Ya se establecio una royección para el año " + par[0] + "", "warning", "warning");
                        flag = "no";
                    }
                });
            }

            if (val === "") {
                $.Alert("#msgPro", "No se ha establecido un valor para la proyección", "warning", "warning");
            } else {
                if (flag === "si") {
                    contProyecc = parseInt($("#contProyecc").val()) + 1;
                    var fila = '<tr class="selected" id="filaProyecc' + contProyecc + '" >';

                    fila += "<td>" + contProyecc + "</td>";
                    fila += "<td>" + anio + "</td>";
                    fila += "<td>" + val + "</td>";
                    fila += "<td><input type='hidden' id='idProy" + contProyecc + "' name='Proy' value='" + anio + "//" + valg + "' /><a onclick=\"$.QuitarProyecc('filaProyecc" + contProyecc + "')\" class=\"btn default btn-xs red\">"
                            + "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
                    $('#tb_Proyec').append(fila);
                    $.reordenarProyecc();
                    $("#contProyecc").val(contProyecc);
                    $("#CbAnioProy").selectpicker("val", " ");
                    $("#txt_Valot").val("");
                }
            }

        },
        reordenarProyecc: function () {
            var num = 1;
            $('#tb_Proyec tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Proyec tbody input').each(function () {
                $(this).attr('id', "idProy" + num);
                num++;
            });

        },
        QuitarProyecc: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarProyecc();
            contProyecc = parseInt($('#contProyecc').val()) - 1;
            $("#contProyecc").val(contProyecc);
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
        Dta_Metas: function () {
            Dat_Metas = "";
            $("#tb_Metas").find(':input').each(function () {
                Dat_Metas += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Metas += "&Long_Metas=" + $("#contMetas").val();
        },
        Dta_Varia: function () {
            Dat_Varia = "";
            $("#tb_Body_Variable").find(':input').each(function () {
                Dat_Varia += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Varia += "&Long_Varia=" + $("#contVariables").val();
        },
        conse: function () {

            var text = $("#atitulo").text();

            if (text === "Crear Indicador") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: "INDICADORES"
                };


                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#txt_NumIndi").val(data['StrAct']);
                        $("#cons").val(data['cons']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

                //  $('#mopc').hide();

            }

        },
        paginadorMet: function (pag, servel) {

            var eje = $("#CbEjes").val();
            if (eje === null) {
                eje = "";
            }
            var estr = $("#CbEtrategias").val();
            if (estr === null) {
                estr = "";
            }
            var prog = $("#CbProgramas").val();
            if (prog === null) {
                prog = "";
            }
            var datos = {
                pag: pag,
                eje: trimAll(eje),
                comp: trimAll(estr),
                prog: trimAll(prog),
                nreg: $("#nregVentMet").val(),
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVentMet').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopagMet: function (pag, servel) {
            var eje = $("#CbEjes").val();
            if (eje === null) {
                eje = "";
            }
            var estr = $("#CbEtrategias").val();
            if (estr === null) {
                estr = "";
            }
            var prog = $("#CbProgramas").val();
            if (prog === null) {
                prog = "";
            }
            var datos = {
                pag: pag,
                eje: trimAll(eje),
                comp: trimAll(estr),
                prog: trimAll(prog),
                nreg: $("#nregVentMet").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVentMet').html(data['cbp']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag2VentMet: function (nre) {


            var eje = $("#CbEjes").val();
            if (eje === null) {
                eje = "";
            }
            var estr = $("#CbEtrategias").val();
            if (estr === null) {
                estr = "";
            }
            var prog = $("#CbProgramas").val();
            if (prog === null) {
                prog = "";
            }
            var datos = {
                nreg: nre,
                eje: trimAll(eje),
                comp: trimAll(estr),
                prog: trimAll(prog),
                pag: $("#selectpagMet").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVentMet').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        Load_ventanaMeta: function (op) {
            if (op === "1") {
                $("#ventanaMeta").modal({backdrop: 'static', keyboard: false});
            }
            var eje = $("#CbEjes").val();
            if (eje === null) {
                eje = "";
            }
            var estr = $("#CbEtrategias").val();
            if (estr === null) {
                estr = "";
            }
            var prog = $("#CbProgramas").val();
            if (prog === null) {
                prog = "";
            }

            var datos = {
                eje: trimAll(eje),
                comp: trimAll(estr),
                prog: trimAll(prog),
                pag: "1",
                op: "1",
                nreg: $("#nregVentMet").val(),
                ori: 'Banco'

            };
            $.ajax({
                type: "POST",
                async: false,
                url: "../Paginadores/PagMetVent.php",
                data: datos,
                dataType: 'json',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVentMet').html(data['cbp']);
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
        SelMeta: function (par) {

            var ppar = par.split("//");

            $("#txt_IdMeta").val(ppar[0]);
            $("#txt_DesMeta").val(ppar[1]);
            $("#txt_CodMeta").val(ppar[2]);

            $("#ventanaMeta").modal("hide");
            // $('#nestr').show();
        },
        QuitarMeta: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarMetas();
            contMetas = $('#contMetas').val();
            contMetas = contMetas - 1;
            $("#contMetas").val(contMetas);
        },
        cargarEje: function () {

            var datos = {
                ope: "ConsulTodo"
            };

            $.ajax({
                type: "POST",
                async: false,
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#CbEjes').html(data['ejes']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        CargEstrategia: function (cod) {

            var datos = {
                ope: "CargSelEstrategia",
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
            $.busqMetas();
        },
        CargProgramas: function (cod) {

            var datos = {
                ope: "CargSelPrograma",
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
            $.busqMetas();
        },
        busqMetas: function () {

            var eje = $("#CbEjes").val();
            if (eje === null) {
                eje = "";
            }
            var estr = $("#CbEtrategias").val();
            if (estr === null) {
                estr = "";
            }
            var prog = $("#CbProgramas").val();
            if (prog === null) {
                prog = "";
            }


            var datos = {
                opc: "BusqDepe",
                eje: eje,
                comp: estr,
                prog: prog,
                pag: "1",
                op: "1",
                nreg: $("#nregVentMet").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVentMet').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }

    });
    //======FUNCIONES========\\
    $.Indicadores();
    $.cargarTodo('T');

    //==============\\

    $("#btn_para").on("click", function () {
        $.Load_ventana('1');
    });
    $("#btn_cancelar").on("click", function () {
        window.location.href = 'HojaVidaIndicador.php';
    });

    $("#btn_nuevo").on("click", function () {

        $('#acc').val("1");
        $('#txt_CodIndi').val("");
        $.conse();
        $('#txt_NumIndi').val("");
        $('#txt_NomIndi').val("");
        $('#txt_ObjIndi').val("");
        $("#CbProceso").val(" ").change();
        $("#CbFreMed").selectpicker("val", " ");
        $("#CbUnida").selectpicker("val", " ");
        $("#Cbfuente").val(" ").change();
        $("#CbTipInd").selectpicker("val", " ");
        $("#CbRespo").val(" ").change();
        $('#txt_RelMat').val("");
        $('#txt_RelMateEdit').val("");

        $("#tb_BodyVar").html("");
        $('#contVariables').val("0");

        $("#tb_Body_Meta").html("");
        $('#contMetas').val("0");

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

    $('#txt_RelMateEdit').on('keypress', function (e) {
        if (e.which == 32 || e.which == 13)
            return false;
    });


    $("#btn_paraMet").on("click", function () {

        $.cargarEje();
        // $("#CbEjes").val(" ").change();
        $("#CbEtrategias").html("");
        $("#CbEtrategias").prop('disabled', true);
        $("#CbProgramas").html("");
        $("#CbProgramas").prop('disabled', true);

        $.Load_ventanaMeta('1');
    });




    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        $.Validar();
        $.conse();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        $.Dta_Metas();
        $.Dta_Varia();

        var NewFDat = [];
        var Data = $("#Cbfuente").select2("data");
        for (var i = 0; i <= Data.length - 1; i++) {
            NewFDat.push(Data[i].id);
        }

        var NewResp = [];
        var Data = $("#CbRespo").select2("data");
        for (var i = 0; i <= Data.length - 1; i++) {
            NewResp.push(Data[i].id);
        }


        var datos = "txt_CodIndi=" + $("#txt_CodIndi").val() + "&txt_NumIndi=" + $("#txt_NumIndi").val()
                + "&txt_NomIndi=" + $("#txt_NomIndi").val() + "&txt_ObjIndi=" + $("#txt_ObjIndi").val()
                + "&CbProceso=" + $("#CbProceso").val() + "&FuentDat=" + NewFDat.join(',')
                + "&CbFreMed=" + $("#CbFreMed").val() + "&CbUnida=" + $("#CbUnida").val()
                + "&CbTipInd=" + $("#CbTipInd").val() + "&Resp=" + NewResp.join(',')
                + "&txt_RelMat=" + $.param({body: $("#txt_RelMat").val()}) + "&acc=" + $("#acc").val()
                + "&id=" + $("#txt_id").val();
        var Alldata = datos + Dat_Metas + Dat_Varia;

        $.ajax({
            type: "POST",
            url: "../Indicadores/GuardarIndicadores.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "success");

                    $.Indicadores();
                    $("#btn_nuevo").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_codigo").prop('disabled', true);
                    $("#txt_Descripcion").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});
///////////////////////
