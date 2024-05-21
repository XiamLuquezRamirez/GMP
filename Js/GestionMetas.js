$(document).ready(function () {

    $("#home").removeClass("start active open");

    $("#menu_plan").addClass("start active open");
    $("#menu_subPrograma").addClass("start active open");
    $("#menu_Metas").addClass("active");

    var Op_Validar = [];
    var Op_Vali = "Ok";
    var contIndicad = 0;
    var Dat_Indi = "";
    var Dat_Proy = "";
    $("#CbTipDato,#CbProMet,#CbAnioProy,#CbIndice").selectpicker();


    $.extend({
        Metas: function () {

            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#TotMet').html('Total Metas Trazadoras (' + data['Cont'] + ')');
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqPlan: function (val) {

            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editMet: function (cod) {
            $('#acc').val("2");
            $('#botones').show();
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            $("#txt_id").val(cod);

            var datos = {
                ope: "BusqEditMet",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_Cod").val(data['cod_meta']);
                    $("#txt_Desc").val(data['desc_meta']);
                    $("#txt_LinBase").val(data['base_meta']);
                    $("#txt_Meta").val(data['meta']);
                    $("#CbTipDato").selectpicker("val", data['tipdato_metas']);
                    $("#CbProMet").selectpicker("val", data['prop_metas']);
                    $("#CbIndice").selectpicker("val", data['indice_metas']);
                    if (data['tipdato_metas'] === "Indice") {
                        $("#div_Indice").css("pointer-events", "auto");
                    } else {
                        $("#div_Indice").css("pointer-events", "none");
                    }
                    $('#CbClasif').val(data["clasif_metas"]).change();

                    if (data['clasif_metas'] !== "NO APLICA") {
                        $("#div_DerFund").css("pointer-events", "auto");
                    } else {
                        $('#div_DerFund').css('pointer-events', 'none');

                    }


                    $('#CbEjes').val(data["ideje_metas"]).change();
                    $.CargEstrategia($('#CbEjes').val());
                    $('#CbEtrategias').val(data["idcomp_metas"]).change();
                    $.CargProgramas($('#CbEtrategias').val());
                    $('#CbProgramas').val(data["idprog_metas"]).change();

                    var resp = data["respo_metas"].split(",");

                    $("#CbDepend").val(resp).change();

                    var fuent = data["fuente_metas"].split(",");

                    $("#CbFuente").val(fuent).change();

                    $("#txt_AcepMax").val(data['acepmax_indi']);
                    $("#txt_AcepMin").val(data['acepmin_indi']);
                    $("#txt_RiesMax").val(data['riemax_indi']);
                    $("#txt_RiesMin").val(data['riemin_indi']);
                    $("#txt_CritMax").val(data['crimax_indi']);
                    $("#txt_CritMin").val(data['crimin_indi']);

                    $("#txt_AcepDesc").val(data['desacept']);
                    $("#txt_RiesDesc").val(data['desriesg']);
                    $("#txt_CritDesc").val(data['descriti']);

                    $("#tb_Proyec").html(data['CadProy']);
                    $("#contProyecc").val(data['cont']);


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Meta Trazadora</a>");
        },
        VerMet: function (cod) {

            var datos = {
                ope: "BusqEditMet",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_Cod").val(data['cod_meta']);
                    $("#txt_Desc").val(data['desc_meta']);
                    $("#txt_LinBase").val(data['base_meta']);
                    $("#txt_Meta").val(data['meta']);
                    $("#CbTipDato").selectpicker("val", data['tipdato_metas']);
                    $("#CbProMet").selectpicker("val", data['prop_metas']);

                    $('#CbEjes').val(data["ideje_metas"]).change();
                    $.CargEstrategia($('#CbEjes').val());
                    $('#CbEtrategias').val(data["idcomp_metas"]).change();
                    $.CargProgramas($('#CbEtrategias').val());
                    $('#CbProgramas').val(data["idprog_metas"]).change();

                    var resp = data["respo_metas"].split(",");
                    $("#CbDepend").val(resp).change();

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Meta Trazadora</a>");


        },
        deletMet: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../PlanDesarrollo/GuardarMetas.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success");
                            $.Metas();
                        } else if (data === "nobien") {
                            $.Alert("#msg2", "No se Puede Realizar la Operación... Esta Meta esta Relacionada a un Proyecto.", "warning", 'warning');
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
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
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
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
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
                pag: $("#selectpag").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        UpdateDepend: function () {
            $.cargarTodo('D');
        },
        UpdateFuentes: function () {
            $.cargarTodo('F');
        },
        cargarTodo: function (op) {

            var datos = {
                op: op,
                ope: "ConsulTodo"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (op === "T") {
                        $('#CbDepend').html(data['depend']);
                        $('#CbEjes').html(data['ejes']);
                        $('#CbFuente').html(data['fuente']);
                        $('#CbClasif').html(data['clasif']);
                        $('#CbDerFund').html(data['DerFund']);

                    } else if (op === "D") {
                        $('#CbDepend').html(data['depend']);
                    } else if (op === "F") {
                        $('#CbFuente').html(data['fuente']);
                    }

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
        },

        Validar: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#CbEjes";
            Value = $(Id).val();

            if (Value === "" || Value === " ") {

                Op_Validar.push("Fail");
                $("#From_Eje").addClass("has-error");
            } else {
                $("#From_Eje").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbEtrategias";
            Value = $(Id).val();

            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Est").addClass("has-error");
            } else {

                $("#From_Est").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbProgramas";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Pro").addClass("has-error");
            } else {
                $("#From_Pro").removeClass("has-error");
                Op_Validar.push("Ok");
            }


            Id = "#txt_Cod";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Codigo").addClass("has-error");
            } else {
                $("#From_Codigo").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_Desc";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Descripcion").addClass("has-error");
            } else {
                $("#From_Descripcion").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbTipDato";
            Value = $(Id).val();

            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Dato").addClass("has-error");
            } else {
                $("#From_Dato").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_LinBase";
            Value = $(Id).val();

            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Base").addClass("has-error");
            } else {
                $("#From_Base").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbDepend";
            Value = $(Id).val();

            if (Value === null || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Dep").addClass("has-error");
            } else {
                $("#From_Dep").removeClass("has-error");
                Op_Validar.push("Ok");
            }



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
        addMeta: function () {

            if ($("#perm").val() === "n") {
                $('#botones').hide();
                $.Alert("#msg", "No Tiene permisos para Crear Metas", "warning", 'warning');
            } else {
                $.conse();
            }
        },
        NewDepend: function () {
            $("#VentDependencia").modal({backdrop: 'static', keyboard: false});
        },
        NewFuente: function () {
            $("#VentFuentes").modal({backdrop: 'static', keyboard: false});
        },
        FormNum: function (id) {
            var tdat = $("#CbTipDato").val();
            if (tdat !== "Cualitativa") {
                var num = new Intl.NumberFormat('es-CO').format($("#" + id).val());
                $("#" + id).val(num);
            }

        },
        AddProyecccion: function () {
            var anio = $("#CbAnioProy").val();
            var val = $("#txt_Valot").val();
            valg = "";

            valg = $("#txt_Valot").val();

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
            if (anio === " ") {
                $.Alert("#msgPro", "No se ha seleccionado un periodo", "warning", "warning");
            } else if (val === "") {
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

            $("#txt_Valot").val("");
            $("#CbAnioProy").selectpicker("val", " ");


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
        ValidarD: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_CodDep";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_CodigoDep").addClass("has-error");
            } else {
                $("#From_CodigoDep").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_DescDep";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_DescripcionDep").addClass("has-error");
            } else {
                $("#From_DescripcionDep").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        ValidarF: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";



            Id = "#txt_DescFue";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_DescripcionFue").addClass("has-error");
            } else {
                $("#From_DescripcionFue").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },

        conse: function () {

            var text = $("#atitulo").text();

            if (text === "Crear Meta Trazadora") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: "METAS"
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data['flag'] === "n") {
                            $('#botones').hide();
                            $.Alert("#msg", "No se Puede Realizar la Operación... No se creado un Consecutivo para las Metas. Verifique...", "warning", 'warning');
                        } else {
                            $("#txt_Cod").val(data['StrAct']);
                            $("#cons").val(data['cons']);
                            $('#botones').show();
                        }

                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }

        },
        Dta_Proye: function () {
            Dat_Proy = "";
            $("#tb_Proyec").find(':input').each(function () {
                Dat_Proy += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Proy += "&Long_Proy=" + $("#contProyecc").val();
        },
        HabIndice: function (valor) {
            if (valor === "Indice") {
                $("#div_Indice").css("pointer-events", "auto");
            } else {
                $('#div_Indice').css('pointer-events', 'none');
                $("#CbIndice").selectpicker("val", "NO APLICA");
            }


        },
        HabDerFund: function (valor) {

            if (valor !== "NO APLICA") {
                $("#div_DerFund").css("pointer-events", "auto");
            } else {
                $('#div_DerFund').css('pointer-events', 'none');
                $("#CbDerFund").val("NO APLICA").change();
            }
        }

    });
    //======FUNCIONES========\\
    $.Metas();
    $.cargarTodo("T");

    //==============\\


    $("#btn_nuevo").on("click", function () {
        $.conse();
        $('#acc').val("1");
        $("#CbDepend").val(" ").change();
        $("#CbEjes").val(" ").change();
        $("#CbClasif").val(" ").change();
        $("#CbFuente").val(" ").change();
        $("#CbDerFund").val("NO APLICA").change();
        $("#CbEtrategias").html("");
        $("#CbEtrategias").prop('disabled', true);
        $("#CbProgramas").html("");
        $("#CbProgramas").prop('disabled', true);

        //  $('#txt_Cod').val("");
        $('#txt_Desc').val("");
        $('#txt_LinBase').val("");
        $('#txt_Meta').val("");

        $("#CbTipDato").selectpicker("val", " ");
        $("#CbProMet").selectpicker("val", " ");
        $("#CbIndice").selectpicker("val", "NO APLICA");
        $('#div_Indice').css('pointer-events', 'none');
        $('#div_DerFund').css('pointer-events', 'none');

        $("#tb_Body_Proyeccion").html("");
        $("#contProyecc").val("0");


        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Crear Meta Trazadora</a>");


    });

    $("#btn_Excel").click(function () {
        window.open('../PlanDesarrollo/ExcelMetas.php');

    });
    $("#btn_volver").click(function () {
        window.location.href = '../Metas/';

    });



    $("#btn_cancelar").on("click", function () {
        if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
            $('#acc').val("1");
            $("#CbDepend").val(" ").change();
            $("#CbEjes").val(" ").change();
            $("#CbClasif").val(" ").change();
            $("#CbFuente").val(" ").change();
            $("#CbDerFund").val("NO APLICA").change();
            $("#CbEtrategias").html("");
            $("#CbEtrategias").prop('disabled', true);
            $("#CbProgramas").html("");
            $("#CbProgramas").prop('disabled', true);

            //  $('#txt_Cod').val("");
            $('#txt_Desc').val("");
            $('#txt_LinBase').val("");
            $('#txt_Meta').val("");

            $("#CbTipDato").selectpicker("val", " ");
            $("#CbProMet").selectpicker("val", " ");
            $("#CbIndice").selectpicker("val", "NO APLICA");
            $('#div_Indice').css('pointer-events', 'none');
            $('#div_DerFund').css('pointer-events', 'none');

            $("#tb_Body_Proyeccion").html("");
            $("#contProyecc").val("0");


            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Crear Meta Trazadora</a>");

        }

    });


    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "verfMeta",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_Codigo").addClass("has-error");
                    $.Alert("#msg", "Este Código ya Esta Registrado...", "warning", "warning");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                } else {
                    $("#From_Codigo").removeClass("has-error");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });


    $("#btn_nuevoD").on("click", function () {

        $("#txt_CodDep").val("");
        $("#txt_DescDep").val("");
        $("#txt_obserDep").val("");
        $("#txt_TelfDep").val("");
        $("#txt_CorreDep").val("");

        $("#btn_nuevoD").prop('disabled', true);
        $("#btn_guardarD").prop('disabled', false);

        $("#txt_CodDep").prop('disabled', false);
        $("#txt_DescDep").prop('disabled', false);
        $("#txt_obserDep").prop('disabled', false);
        $("#txt_TelfDep").prop('disabled', false);
        $("#txt_CorreDep").prop('disabled', false);

    });

    $("#btn_nuevoF").on("click", function () {

        $("#txt_DescFue").val("");
        $("#txt_obserFue").val("");

        $("#btn_nuevoF").prop('disabled', true);
        $("#btn_guardarF").prop('disabled', false);

        $("#txt_DescFue").prop('disabled', false);
        $("#txt_obserFue").prop('disabled', false);

    });

    $("#txt_CodDep").on("change", function () {

        var datos = {
            ope: "verfDepend",
            cod: $("#txt_CodDep").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_CodigoDep").addClass("has-error");
                    $.Alert("#msgD", "Este Código ya Esta Registrado...", "warning", "warning");
                    $('#txt_CodDep').focus();
                    $("#txt_CodDep").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_guardarD").on("click", function () {

        $.ValidarD();

        if (Op_Vali === "Fail") {
            $.Alert("#msgD", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            cod: $("#txt_CodDep").val(),
            des: $("#txt_DescDep").val(),
            cor: $("#txt_CorreDep").val(),
            tel: $("#txt_TelfDep").val(),
            obs: $("#txt_obserDep").val(),
            acc: "1"

        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarDependencia.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msgD", "Datos Guardados Exitosamente...", "success", "check");
                    $.UpdateDepend();
                    $("#btn_nuevoD").prop('disabled', false);
                    $("#btn_guardarD").prop('disabled', true);

                    $("#txt_CodDep").prop('disabled', true);
                    $("#txt_DescDep").prop('disabled', true);
                    $("#txt_CorreDep").prop('disabled', true);
                    $("#txt_TelfDep").prop('disabled', true);
                    $("#txt_obserDep").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });
    $("#btn_guardarF").on("click", function () {

        $.ValidarF();

        if (Op_Vali === "Fail") {
            $.Alert("#msgF", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            des: $("#txt_DescFue").val(),
            obs: $("#txt_obserFue").val(),
            acc: "1"

        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarFuenInfor.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msgF", "Datos Guardados Exitosamente...", "success", "check");
                    $.UpdateFuentes();
                    $("#btn_nuevoF").prop('disabled', false);
                    $("#btn_guardarF").prop('disabled', true);

                    $("#txt_DescDep").prop('disabled', true);
                    $("#txt_obserDep").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }


        var NewResp = [];
        var Data = $("#CbDepend").select2("data");
        for (var i = 0; i <= Data.length - 1; i++) {
            NewResp.push(Data[i].id);
        }

        $.conse();
        $.Dta_Proye();

        var txt_LinBase = $("#txt_LinBase").val();
        var txt_MetInd = $("#txt_MetInd").val();
        var txt_AcepMax = $("#txt_AcepMax").val();
        var txt_AcepMin = $("#txt_AcepMin").val();
        var txt_RiesMax = $("#txt_RiesMax").val();
        var txt_RiesMin = $("#txt_RiesMin").val();
        var txt_CritMax = $("#txt_CritMax").val();
        var txt_CritMin = $("#txt_CritMin").val();
        var txt_AcepDesc = $("#txt_AcepDesc").val();
        var txt_RiesDesc = $("#txt_RiesDesc").val();
        var txt_CritDesc = $("#txt_CritDesc").val();


        var datos = "txt_Cod=" + $("#txt_Cod").val() + "&txt_Desc=" + $("#txt_Desc").val()
                + "&CbTipDato=" + $("#CbTipDato").val() + "&txt_LinBase=" + $("#txt_LinBase").val() + "&txt_Meta=" + $("#txt_Meta").val()
                + "&CbProMet=" + $("#CbProMet").val() + "&CbResponsa=" + NewResp.join(',')
                + "&CbEjes=" + $("#CbEjes").val() + "&CbEtrategias=" + $("#CbEtrategias").val()
                + "&CbProgramas=" + $("#CbProgramas").val() + "&cons=" + $("#cons").val()
                + "&CbEjesDes=" + $("#CbEjes option:selected").text() + "&CbEtrategiasDes=" + $("#CbEtrategias option:selected").text()
                + "&CbProgramasDes=" + $("#CbProgramas option:selected").text()
                + "&txt_AcepMax=" + txt_AcepMax + "&txt_AcepMin=" + txt_AcepMin + "&txt_AcepDesc=" + txt_AcepDesc
                + "&txt_RiesMax=" + txt_RiesMax + "&txt_RiesMin=" + txt_RiesMin + "&txt_RiesDesc=" + txt_RiesDesc
                + "&txt_CritMax=" + txt_CritMax + "&txt_CritMin=" + txt_CritMin + "&txt_CritDesc=" + txt_CritDesc
                + "&CbIndice=" + $("#CbIndice").val() + "&CbClasif=" + $("#CbClasif").val() + "&CbDerFund=" + $("#CbDerFund").val() + "&CbFuente=" + $("#CbFuente").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val();

        var Alldata = datos + Dat_Proy;
        $.ajax({
            type: "POST",
            url: "../PlanDesarrollo/GuardarMetas.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.Metas();
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

function check(e) {
    var valor = $("#CbTipDato").val();
    if (valor !== "Cualitativa") {
        var key = (document.all) ? e.keyCode : e.which;
        var tecla = String.fromCharCode(key).toLowerCase();
        //        var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        var letras = "0123456789.";
        var especiales = "8-37-39-46";

        var tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }

}
///////////////////////
