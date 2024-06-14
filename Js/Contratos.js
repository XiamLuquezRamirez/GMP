$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
    $("#menu_p_proy").addClass("start active open");
    $("#menu_p_Contra_ges").addClass("active");

    $("#txt_fechaG,#txt_fecha,#txt_fecha_Modi,#txt_FIni,#txt_FSusp,#txt_FRein,#txt_FFina,#txt_FReci,#txt_fechaAdd,#txt_fechaGasto").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    $("#CbPersonaC,#cbx_tipo_identC,#CbEstadoProc,#CbEstado,#CbEstImg,#CbTiemDura,#CbTiemProrog,#CbGastos").selectpicker();

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
    var Dat_detAdicion = [];

    var PreTotalAdicion = 0;
    var contImg = 0;
    var Dat_Img = "";
    var Dat_Localiza = "";
    var Dat_Porce = "";
    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        Contratos: function () {
            var datos = {
                opc: "CargDependencia",
                pag: "1",
                op: "1",
                bus: "",
                Pro: $("#CbProyBusc").val(),
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratos.php",
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
        busqContrato: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                Pro: $("#CbProyBusc").val(),
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratos.php",
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
        busqContratoPro: function () {


            var datos = {
                opc: "BusqDepe",
                bus: $("#busq_centro").val(),
                Pro: $("#CbProyBusc").val(),
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratos.php",
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
        AddAvaces: function (cod) {
            $('#acc').val("1");
            $("#txt_id").val(cod);
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            $("#btn-adicion").show();

            var datos = {
                ope: "BusqEditContrato",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_Cod").val(data['num_contrato']);
                    $('#CbTiplog').val(data["idtipolg_contrato"]).change();
                    $("#txt_Nomb").val(data['obj_contrato']);
                    $("#txt_fecha").val(data['fcrea_contrato']);
                    $("#txt_fecha_Modi").val(data['fmod_contrato']);
                    $('#CbContratis').val(data["idcontrati_contrato"]).change();
                    $('#CbSuper').val(data["idsuperv_contrato"]).change();
                    $('#CbInter').val(data["idinterv_contrato"]).change();
                    $("#txt_VaCont").val('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#txt_VaAdiV").val('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#txt_VaAdi").val(data['vadic_contrato']);
                    $("#txt_VaFin").val('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#txt_VaEjeV").val('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
                    $("#txt_VaEje").val(data['veje_contrato']);
                    $("#txt_Fpago").val(data['forpag_contrato']);

                    if (data['durac_contrato'] === "  ") {
                        $("#CbTiemDura").selectpicker("val", " ");
                    } else {
                        padur = data['durac_contrato'].split(" ");
                        $("#txt_Durac").val(padur[0]);
                        $("#CbTiemDura").selectpicker("val", padur[1]);

                    }


                    if (data['prorg_contrato'] === "  ") {
                        $("#CbTiemProrog").selectpicker("val", " ");
                    } else {
                        papr = data['prorg_contrato'].split(" ");
                        $("#txt_Prorog").val(papr[0]);
                        $("#CbTiemProrog").selectpicker("val", papr[1]);
                    }

                    if (data['fini_contrato'] === "0000-00-00") {
                        $("#txt_FIni").val("");
                    } else {
                        $("#txt_FIni").val(data['fini_contrato']);
                    }

                    if (data['fsusp_contrato'] === "0000-00-00") {
                        $("#txt_FSusp").val("");
                    } else {
                        $("#txt_FSusp").val(data['fsusp_contrato']);
                    }

                    if (data['frein_contrato'] === "0000-00-00") {
                        $("#txt_FRein").val("");
                    } else {
                        $("#txt_FRein").val(data['frein_contrato']);
                    }

                    if (data['ffin_contrato'] === "0000-00-00") {
                        $("#txt_FFina").val("");
                    } else {
                        $("#txt_FFina").val(data['ffin_contrato']);
                    }

                    if (data['frecb_contrato'] === "0000-00-00") {
                        $("#txt_FReci").val("");
                    } else {
                        $("#txt_FReci").val(data['frecb_contrato']);
                    }


                    $('#CbProy').val(data["idproy_contrato"]).change();
                    $("#txt_Avance").val(data['porav_contrato']);
                    $("#txt_PorEqui").val(data['porproy_contrato']);
                    $("#txt_Url").val(data['secop_contrato']);

                    $("#CbEstado").selectpicker("val", data['estad_contrato']);
                    $("#CbEstadoProc").selectpicker("val", data['estcont_contra']);

                    $("#tb_Galeria").html(data['Tab_Img']);
                    $("#contImg").val(data['contImg']);

                    $("#tb_Localiza").html(data['Tab_Loca']);
                    $("#contLocalizacion").val(data['contUbi']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#div_estado").hide();


            $('#divtipo').css('pointer-events', 'none');
            $('#divcont').css('pointer-events', 'none');
            $('#divsupe').css('pointer-events', 'none');
            $('#divinter').css('pointer-events', 'none');

//            $("#divval").hide();
            $("#divfpag").hide();
            $("#divdura").hide();
//            $("#divfini").hide();
            $("#divtitpro").hide();
            $("#divproy").show();
            $("#divequi").hide();


            $("#txt_Cod").prop('disabled', true);
            $("#txt_fecha_Modi").prop('disabled', true);
            $("#txt_fecha").prop('disabled', true);
            $("#txt_Nomb").prop('disabled', true);
            $("#txt_VaCont").prop('disabled', true);
            $("#txt_Fpago").prop('disabled', true);
            $("#txt_Durac").prop('disabled', true);
            $("#CbTiemDura").prop('disabled', true);
            $("#txt_FIni").prop('disabled', true);
            $("#CbProy").prop('disabled', true);

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Actualizar Contrato</a>");



        },
        AditAvaces: function (cod) {
            $('#acc').val("2");
            $("#txt_id").val(cod);
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            var datos = {
                ope: "BusqEditContrato",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_Cod").val(data['num_contrato']);
                    $('#CbTiplog').val(data["idtipolg_contrato"]).change();
                    $("#txt_Nomb").val(data['obj_contrato']);
                    $("#txt_fecha").val(data['fcrea_contrato']);
                    $('#CbContratis').val(data["idcontrati_contrato"]).change();
                    $('#CbSuper').val(data["idsuperv_contrato"]).change();
                    $('#CbInter').val(data["idinterv_contrato"]).change();
                    $("#txt_VaCont").val('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#txt_VaAdiV").val('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#txt_VaAdi").val(data['vadic_contrato']);
                    $("#txt_VaFin").val('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#txt_VaEje").val(data['veje_contrato']);
                    $("#txt_VaEjeV").val('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
                    $("#txt_Fpago").val(data['forpag_contrato']);
                    $("#Text_Motivo").val(data['observacion']);

                    if (data['durac_contrato'] === "  ") {
                        $("#CbTiemDura").selectpicker("val", " ");
                    } else {
                        padur = data['durac_contrato'].split(" ");
                        $("#txt_Durac").val(padur[0]);
                        $("#CbTiemDura").selectpicker("val", padur[1]);

                    }


                    if (data['prorg_contrato'] === "  ") {
                        $("#CbTiemProrog").selectpicker("val", " ");
                    } else {
                        papr = data['prorg_contrato'].split(" ");
                        $("#txt_Prorog").val(papr[0]);
                        $("#CbTiemProrog").selectpicker("val", papr[1]);
                    }

                    if (data['fini_contrato'] === "0000-00-00") {
                        $("#txt_FIni").val("");
                    } else {
                        $("#txt_FIni").val(data['fini_contrato']);
                    }

                    if (data['fsusp_contrato'] === "0000-00-00") {
                        $("#txt_FSusp").val("");
                    } else {
                        $("#txt_FSusp").val(data['fsusp_contrato']);
                    }

                    if (data['frein_contrato'] === "0000-00-00") {
                        $("#txt_FRein").val("");
                    } else {
                        $("#txt_FRein").val(data['frein_contrato']);
                    }

                    if (data['ffin_contrato'] === "0000-00-00") {
                        $("#txt_FFina").val("");
                    } else {
                        $("#txt_FFina").val(data['ffin_contrato']);
                    }

                    if (data['frecb_contrato'] === "0000-00-00") {
                        $("#txt_FReci").val("");
                    } else {
                        $("#txt_FReci").val(data['frecb_contrato']);
                    }

                    if (data['tipnovedad'] === "Prorroga") {
                        $('#Div_CamEst').show();
                        $('#TitMoti').html("Motivo de Prorroga");
                        $('#TitAdjArc').html("Adjuntar Documento de Prorroga");
                        $("#novedad").val("Prorroga");

                    } else if (data['tipnovedad'] === "Suspension") {
                        $('#Div_CamEst').show();
                        $('#TitMoti').html("Motivo de Suspensión");
                        $('#TitAdjArc').html("Adjuntar Documento de Suspensión");
                        $("#novedad").val("Suspension");
                    } else if (data['tipnovedad'] === "Liquidado") {
                        $('#Div_CamEst').show();
                        $('#TitMoti').html("Motivo de Liquidación");
                        $('#TitAdjArc').html("Adjuntar Documento de Liquidación");
                        $("#novedad").val("Liquidacion");

                    } else {
                        $('#Div_CamEst').hide();
                        $("#Src_FileEstad").val("");
                        $("#novedad").val("");
                        $("#Text_Motivo").val("");
                    }

                    if (data['urldocumento'] !== "") {
                        $('#MostImg').show();
                        $("#Src_FileEstad").val(data['urldocumento']);
                        $("#DocuEst").attr('href', "../Proyecto/" + data['urldocumento']);
                    } else {
                        $('#MostImg').hide();

                    }

                    $('#CbProy').val(data["idproy_contrato"]).change();
                    $("#txt_Avance").val(data['porav_contrato']);
                    $("#txt_PorEqui").val(data['porproy_contrato']);
                    $("#txt_Url").val(data['secop_contrato']);
                 
                    $("#CbEstado").selectpicker("val", data['estad_contrato']);
                    $("#CbEstadoProc").selectpicker("val", data['estcont_contra']);

                    $("#tb_Galeria").html(data['Tab_Img']);
                    $("#contImg").val(data['contImg']);

                    $("#tb_Localiza").html(data['Tab_Loca']);
                    $("#contLocalizacion").val(data['contUbi']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#div_estado").hide();


            $('#divtipo').css('pointer-events', 'none');
            $('#divcont').css('pointer-events', 'none');
            $('#divsupe').css('pointer-events', 'none');
            $('#divinter').css('pointer-events', 'none');

//            $("#divval").hide();
            $("#divfpag").hide();
            $("#divdura").hide();
//            $("#divfini").hide();
            $("#divtitpro").hide();
            $("#divproy").hide();
            $("#divequi").hide();


            $("#txt_Cod").prop('disabled', true);
            $("#txt_fecha_Modi").prop('disabled', true);
            $("#txt_fecha").prop('disabled', true);
            $("#txt_Nomb").prop('disabled', true);
            $("#txt_VaCont").prop('disabled', true);
            $("#txt_Fpago").prop('disabled', true);
            $("#txt_Durac").prop('disabled', true);
            $("#CbTiemDura").prop('disabled', true);
            $("#txt_FIni").prop('disabled', true);
            $("#CbProy").prop('disabled', true);

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ediatr Avance de Contrato</a>");



        },
        editContratos: function (cod) {
            $('#acc').val("2");
            $("#txt_id").val(cod);
            $('#botones').show();
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            $("#divtipo *").prop('disabled', false);
            $("#divcont *").prop('disabled', false);
            $("#divsupe *").prop('disabled', false);
            $("#divinter *").prop('disabled', false);

            $("#divval").show();
            $("#divfpag").show();
            $("#divdura").show();
            $("#divfini").show();
            $("#divtitpro").show();
            $("#divproy").show();
            $("#divequi").show();

            $("#div_estado").show();

            var datos = {
                ope: "BusqEditContrato",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_Cod").val(data['num_contrato']);
                    $('#CbTiplog').val(data["idtipolg_contrato"]).change();
                    $("#txt_Nomb").val(data['obj_contrato']);
                    $("#txt_fecha").val(data['fcrea_contrato']);
                    $('#CbContratis').val(data["idcontrati_contrato"]).change();
                    $('#CbSuper').val(data["idsuperv_contrato"]).change();
                    $('#CbInter').val(data["idinterv_contrato"]).change();
                    $("#txt_VaCont").val('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#txt_VaAdiV").val('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#txt_VaAdi").val(data['vadic_contrato']);
                    $("#txt_VaFin").val('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#txt_VaEje").val(data['veje_contrato']);
                    $("#txt_VaEjeV").val('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
                    $("#txt_Fpago").val(data['forpag_contrato']);

                    if (data['durac_contrato'] === "  ") {
                        $("#CbTiemDura").selectpicker("val", " ");
                    } else {
                        padur = data['durac_contrato'].split(" ");
                        $("#txt_Durac").val(padur[0]);
                        $("#CbTiemDura").selectpicker("val", padur[1]);

                    }


                    if (data['prorg_contrato'] === "  ") {
                        $("#CbTiemProrog").selectpicker("val", " ");
                    } else {
                        papr = data['prorg_contrato'].split(" ");
                        $("#txt_Prorog").val(papr[0]);
                        $("#CbTiemProrog").selectpicker("val", papr[1]);
                    }


                    if (data['fini_contrato'] === "0000-00-00") {
                        $("#txt_FIni").val("");
                    } else {
                        $("#txt_FIni").val(data['fini_contrato']);
                    }

                    if (data['fsusp_contrato'] === "0000-00-00") {
                        $("#txt_FSusp").val("");
                    } else {
                        $("#txt_FSusp").val(data['fsusp_contrato']);
                    }

                    if (data['frein_contrato'] === "0000-00-00") {
                        $("#txt_FRein").val("");
                    } else {
                        $("#txt_FRein").val(data['frein_contrato']);
                    }

                    if (data['ffin_contrato'] === "0000-00-00") {
                        $("#txt_FFina").val("");
                    } else {
                        $("#txt_FFina").val(data['ffin_contrato']);
                    }

                    if (data['frecb_contrato'] === "0000-00-00") {
                        $("#txt_FReci").val("");
                    } else {
                        $("#txt_FReci").val(data['frecb_contrato']);
                    }


                    $('#CbProy').val(data["idproy_contrato"]).change();
                    $("#txt_Avance").val(data['porav_contrato']);
                    $("#txt_PorEqui").val(data['porproy_contrato']);
                    $("#txt_Url").val(data['secop_contrato']);

                    $("#CbEstado").selectpicker("val", data['estad_contrato']);
                    $("#CbEstadoProc").selectpicker("val", data['estcont_contra']);

                    $("#tb_Galeria").html(data['Tab_Img']);
                    $("#contImg").val(data['contImg']);

                    $("#tb_Localiza").html(data['Tab_Loca']);
                    $("#contLocalizacion").val(data['contUbi']);



                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Contrato</a>");

        },
        VerHistContrat: function (cod) {

            $("#ventanaHistContrato").modal();

            var datos = {
                ope: "BusqEditContrato",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#NumContr").html(data['num_contrato']);
                    $("#FecModif").html(data['fmod_contrato']);
                    $("#Tipolog").html(data['destipolg_contrato']);
                    $("#Objeto").html(data['obj_contrato']);
                    $("#Contrat").html(data['descontrati_contrato']);
                    $("#Superv").html(data['dessuperv_contrato']);
                    $("#Interv").html(data['desinterv_contrato']);
                    $("#ValCont").html('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#AddCont").html('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#ValFin").html('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#ValEje").html('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
                    $("#FormPag").html(data['forpag_contrato']);
                    $("#DurContr").html(data['durac_contrato']);


                    $("#FecIni").html(data['fini_contrato']);
                    $("#FecSusp").html(data['fsusp_contrato']);
                    $("#FecReini").html(data['frein_contrato']);
                    $("#Prorroga").html(data['prorg_contrato']);
                    $("#FecFina").html(data['ffin_contrato']);
                    $("#FecRein").html(data['frecb_contrato']);
                    $('#ProyectAsoc').html(data["desproy_contrato"]);
                    $("#Avance").html(data['porav_contrato']);
                    $("#Equiv").html(data['porproy_contrato']);
                    $("#EstadoEje").html(data['estad_contrato']);
                    if (data['secop_contrato'] === "") {
                        $("#secop").html('No fue Ingresado el link');

                    } else {
                        $("#secop").html('<a href="' + data['secop_contrato'] + '" target="_BLACK" style="color: #e02222; margin: 0px 0">' + data['secop_contrato'] + '</a>');

                    }
                    if (data['observacion'] === "") {
                        $("#Observ").html("El Contrato no ha presentado ningun cambio en su estado");
                    } else {
                        $("#Observ").html(data['observacion']);
                    }
                    if (data['urldocumento'] === "") {
                        $("#docuAdj").html('<p style="color: #e02222; margin: 0px 0">No se ha adjuntado ningun documento</p>');
                    } else {
                        $("#docuAdj").html('<a href="../Proyecto/' + data['urldocumento'] + '" target="_BLACK"  class="btn default btn-xs blue"><i class="fa fa-search"></i> Ver Documento </a>');
                    }




//                    $("#tb_Galeria").html(data['Tab_Img']);
//                    $("#contImg").val(data['contImg']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

//            $("#tab_01").removeClass("active in");
//            $("#tab_01_pp").removeClass("active in");
//            $("#tab_02").addClass("active in");
//            $("#tab_02_pp").addClass("active in");
//            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Contrato</a>");


        },
        deletContr: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Proyecto/GuardarContrato.php",
                    data: datos,
                    success: function (data) {
                        var pares = data.split("/");
                        if (trimAll(pares[0]) === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Contratos();
                        } else if (trimAll(pares[0]) === "nobien") {
                            $.Alert("#msg2", "No se Puede Eliminar un Contrato con Avances...", "warning", "warning");
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        deletHistContr: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "DelAvanceCont",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    success: function (data) {
                        var parcont=data.split("/");
                        if (trimAll(parcont[0]) === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.VerContrat($("#num_contr").val()+"/"+trimAll(parcont[1]));
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                Pro: $("#CbProyBusc").val(),
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratos.php",
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
        addCont: function () {

            if ($("#perm").val() === "n") {
                $('#botones').hide();
                $.Alert("#msg", "No Tiene permisos para Crear Contratos", "warning", 'warning');
            }
            $("#btn-adicion").hide();
        },
        CambEstado: function (val) {
            
            let resul = $.verificarEstado(val);

            if(resul){
                $("#CbEstado").selectpicker("val", " ")
                return;
            }

            if (val === "Prorroga") {
                $('#Div_CamEst').show();
                $('#TitMoti').html("Motivo de Prorroga");
                $('#TitAdjArc').html("Adjuntar Documento de Prorroga");
                $("#novedad").val("Prorroga");
            } else if (val === "Suspendido") {
                $('#Div_CamEst').show();
                $('#TitMoti').html("Motivo de Suspension");
                $('#TitAdjArc').html("Adjuntar Documento de Suspension");
                $("#novedad").val("Suspension");

            } else if (val === "Liquidado") {
                $('#Div_CamEst').show();
                $('#TitMoti').html("Motivo de Liquidación");
                $('#TitAdjArc').html("Adjuntar Documento de Liquidación");
                $("#novedad").val("Liquidacion");

            } else {
                $('#Div_CamEst').hide();
                $("#Src_FileEstad").val("");
                $("#novedad").val("");
                $("#Text_Motivo").val("");
            }



        },
        verificarEstado: function(estCont){
            let proy = $("#CbProy").val();
            let estProy = $("#text_estadoProyecto").val();
            let CbEstadoProc = $("#CbEstadoProc").val();
            

            if(proy== " "){
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Este contrato no ha sido relacionado con ningun proyecto.", 
                    showConfirmButton: true,
                    timer: 3000
                  });
                  return true;
            }else{
                if(estCont == "Ejecucion" && estProy != "En Ejecucion"){
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "Para cambiar el estado a Ejecución, el proyecto relacionado debe encontrarse en Ejecución.", 
                        showConfirmButton: true,
                        timer: 5000
                      });
                      return true;
                }else if(estCont == "Ejecucion" && CbEstadoProc == "Por Verificar"){
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "Para cambiar el estado a Ejecución, el contrato debe estar verificado.", 
                        showConfirmButton: true,
                        timer: 5000
                      });
                      return true;
                }
            }

        },
        combopag: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                Pro: $("#CbProyBusc").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratos.php",
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
                Pro: $("#CbProyBusc").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratos.php",
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
        AddLocalizacion: function () {

            var CodDepa = $("#CbDepa").val();
            var DesDepa = $('#CbDepa option:selected').text();
            var CodMun = $("#CbMun").val();
            var DesMun = $('#CbMun option:selected').text();
            var CodCor = $("#CbCorre").val();
            var DesCor = $('#CbCorre option:selected').text();
            var OtrUbi = $('#txt_OtraUbi').val();

            var lat = $('#lat').val();
            var long = $('#long').val();

            if (CodDepa === " ") {
                $.Alert("#msg", "Ingrese el Departamento", "warning", 'warning');
                return;
            }

            if (CodMun === " ") {
                $.Alert("#msg", "Ingrese el Municipio", "warning", 'warning');
                return;
            }

            if (CodCor === " ") {
                $.Alert("#msg", "Ingrese el Corregimiento", "warning", 'warning');
                return;
            }


            contLocalizacion = $("#contLocalizacion").val();

            contLocalizacion++;
            var fila = '<tr class="selected" id="filaLoca' + contLocalizacion + '" >';


            fila += "<td>" + contLocalizacion + "</td>";
            fila += "<td>" + DesDepa + "</td>";
            fila += "<td>" + DesMun + "</td>";
            fila += "<td>" + DesCor + "</td>";
            fila += "<td>" + OtrUbi + "</td>";
            fila += "<td><input type='hidden' id='Loca" + contLocalizacion + "' name='Localiza' value='" + CodDepa + "//" + CodMun + "//" + CodCor + "//" + OtrUbi + "//" + lat + "//" + long + "' />\n\
                    <a onclick=\"$.QuitarLocal('filaLoca" + contLocalizacion + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
                    <a onclick=\"$.VerLoca('" + lat + "//" + long + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-map-marker\"></i> Mostrar</a>\n\
                    </td></tr>";
            $('#tb_Localiza').append(fila);
            $.reordenarLocal();
            $.limpiarLoca();
            $("#contLocalizacion").val(contLocalizacion);

        },
        reordenarLocal: function () {
            var num = 1;
            $('#tb_Localiza tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });

            num = 1;
            $('#tb_Localiza tbody input').each(function () {
                $(this).attr('id', "Loca" + num);
                num++;
            });
        },
        VerLoca: function (dir) {
            parlatlog = dir.split("//");
            $('#lat').val(parlatlog[0]);
            $('#long').val(parlatlog[1]);
            initialize();
        },
        QuitarLocal: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarLocal();
            contLocalizacion = $('#contLocalizacion').val();
            contLocalizacion = contLocalizacion - 1;
            $("#contLocalizacion").val(contLocalizacion);

        },
        CargaTodContr: function () {

            var datos = {
                ope: "CargaTodContr"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbTiplog").html(data['Tipolog']);
                    $("#CbContratis").html(data['Contrat']);
                    $("#CbProy").html(data['Proyec']);
                    $("#CbProyBusc").html(data['ProyecBus']);
                    $("#CbSuper").html(data['Superv']);
                    $("#CbInter").html(data['Interv']);
                    $("#CbDepa").html(data['dpto']);
                    $("#CbFuenteFinanciacion").html(data['fuenteFinanciacion']);
                    $("#CbCategoriaGasto").html(data['catGastos']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        BusEstProy: function () {
            if ($("acc").val() === "1") {

                var datos = {
                    ope: "BusEstProy",
                    cod: $("#CbProy").val()
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#txt_Avance").val(data['porce']);
                        $("#CbEstado").selectpicker("val", data['estado']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        verEstadoProyecto: function (val) {
            

                var datos = {
                    ope: "BusEstProy",
                    cod: val
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#text_estadoProyecto").val(data['estado']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
          
        },
        BusMun: function (val) {

            initialize();
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
            if ($('#CbDepa option:selected').text() !== "Seleccione...") {
                var adress = $('#CbDepa option:selected').text().split(' - ');
                codeAddress('COLOMBIA, ' + adress[1]);
            }


        },
        BusCorr: function (val) {

            var datos = {
                ope: "BusCorr",
                cod: val
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbCorre").html(data['corr']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            if ($('#CbMun option:selected').text() !== "N/A") {
                if ($('#CbMun option:selected').text() !== "Seleccione...") {
                    var adressDep = $('#CbDepa option:selected').text().split(' - ');
                    var adressMun = $('#CbMun option:selected').text().split(' - ');
                    codeAddress('COLOMBIA, ' + adressDep[1] + ", " + adressMun[1]);
                }
            }


            $("#CbCorre").prop('disabled', false);

        },
        BusUbiCor: function () {
            if ($('#CbCorre option:selected').text() !== "N/A") {
                if ($('#CbCorre option:selected').text() !== "Seleccione...") {
                    var adressDep = $('#CbDepa option:selected').text().split(' - ');
                    var adressMun = $('#CbMun option:selected').text().split(' - ');
                    var adressCor = $('#CbCorre option:selected').text().split(' - ');
                    codeAddress('COLOMBIA, ' + adressDep[1] + ", " + adressMun[1] + ", " + adressCor[1]);
                }
            }
        },
        BusUbiBar: function (val) {
            var adressDep = $('#CbDepa option:selected').text().split(' - ');
            var adressMun = $('#CbMun option:selected').text().split(' - ');
            var adressCor = $('#CbCorre option:selected').text().split(' - ');
            codeAddress('COLOMBIA, ' + adressDep[1] + ", " + adressMun[1] + ", " + adressCor[1] + ", " + val);
        },
        NewSecre: function () {
            window.open("../Administracion/GestionResponsable.php", '_blank');
        },
        UpdateSecre: function () {
            $.CargSecreta();
        },
        CargSecreta: function () {

            var datos = {
                ope: "CargRespo"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbSecre").html(data['resp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        limpiarLoca: function () {

            $("#lat").val("");
            $("#long").val("");
            $("#CbDepa").select2("val", " ");
            $("#CbMun").select2("val", " ");
            $("#CbCorre").select2("val", " ");
            $("#CbBarrio").select2("val", " ");

        },
        Load_Documentos: function () {

            var Datos = "";
            Datos += ""
                    + "&ope=Load_Anexos";
            $.ajax({
                type: "POST",
                url: "../All",
                data: Datos,
                dataType: 'json',
                success: function (data) {
                    if (data["Salida"] == 1) {
                        var Selec = "<option value=' '> -- Seleccione Un Documento -- </option>";
                        $("#Cbx_Documento").html("");
                        $("#Cbx_Documento").html(Selec + data["Data"]);
                        $("#Cbx_Documento").select2("val", " ");

                    }
                    if (data["Salida"] == 2) {
                        alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
                        window.location.href = "../Logout";
                    }
                    if (data["Salida"] == 3) {
                        alert("Ha Ocurrido un Error..." + JSON.stringify(data));
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR' + JSON.stringify(error_messages));
                }
            });
        },
        Load_Anexos: function () {
            var Datos = "";
            Datos += ""
                    + "&Opcion=Load_Anexos";
            $.ajax({
                type: "POST",
                url: "../Funciones_Prorroga",
                data: Datos,
                dataType: 'json',
                success: function (data) {
                    if (data["Salida"] == 1) {
                        var Selec = "<option value=' '> -- Seleccione Un Documento -- </option>";
                        $("#Cbx_Documento").html("");
                        $("#Cbx_Documento").html(Selec + data["Data"]);
                        $("#Cbx_Documento").select2("val", " ");

                        $(".Cbx_Documento").html("");
                        $(".Cbx_Documento").html(Selec + data["Data"]);
                        $(".Cbx_Documento").select2("val", " ");
                    }
                    if (data["Salida"] == 2) {
                        alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
                        window.location.href = "../Logout";
                    }
                    if (data["Salida"] == 3) {
                        alert("Ha Ocurrido un Error..." + JSON.stringify(data));
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR' + JSON.stringify(error_messages));
                }
            });
        },
        CargcContra: function () {

            var datos = {
                ope: "CargContra"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbContratis").html(data['Contrat']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Load_Tabla_Anexos: function () {
            var Datos = "";
            Datos += ""
                    + "&Opcion=Load_Tabla";
            $.ajax({
                type: "POST",
                url: "../Funciones_Prorroga",
                data: Datos,
                dataType: 'json',
                success: function (data) {
                    if (data["Salida"] == 1) {
                        $("#Tb_Anexos").html("");
                        $("#Tb_Anexos").html(data["Data"]);
                    }
                    if (data["Salida"] == 2) {
                        alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
                        window.location.href = "../Logout";
                    }
                    if (data["Salida"] == 3) {
                        alert("Ha Ocurrido un Error..." + JSON.stringify(data));
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR' + JSON.stringify(error_messages));
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
//                replace(/"/g, "#quot").
                    replace(/%/g, "##37").
                    replace(/`/g, "##96").
                    replace(/°/g, "#deg").
                    replace(/'/g, " ").
                    replace(/~/g, "##126");
            return New;
        },
        CambiarLetra_Doc: function (String) {
            var New = "";
            New = String.replace(/Ã€/g, "A").
                    replace(/Ã�/g, "A").
                    replace(/Ã‚/g, "A").
                    replace(/Ãƒ/g, "A").
                    replace(/Ã„/g, "A").
                    replace(/Ã…/g, "A").
                    replace(/Ã†/g, "A").
                    replace(/Ã‡/g, "C").
                    replace(/Ãˆ/g, "E").
                    replace(/Ã‰/g, "E").
                    replace(/ÃŠ/g, "E").
                    replace(/Ã‹/g, "E").
                    replace(/ÃŒ/g, "I").
                    replace(/Ã�/g, "I").
                    replace(/ÃŽ/g, "I").
                    replace(/Ã�/g, "I").
                    replace(/Ã�/g, "D").
                    replace(/Ã‘/g, "N").
                    replace(/Ã’/g, "O").
                    replace(/Ã“/g, "O").
                    replace(/Ã”/g, "O").
                    replace(/Ã•/g, "O").
                    replace(/Ã–/g, "O").
                    replace(/Ã—/g, "X").
                    replace(/Ã˜/g, "O").
                    replace(/Ã™/g, "U").
                    replace(/Ãš/g, "U").
                    replace(/Ã›/g, "U").
                    replace(/Ãœ/g, "U").
                    replace(/Ã�/g, "Y").
                    replace(/Ãž/g, "_").
                    replace(/ÃŸ/g, "_").
                    replace(/Ã /g, "a").
                    replace(/Ã¡/g, "a").
                    replace(/Ã¢/g, "a").
                    replace(/Ã£/g, "a").
                    replace(/Ã¤/g, "a").
                    replace(/Ã¥/g, "a").
                    replace(/Ã¦/g, "a").
                    replace(/Ã§/g, "c").
                    replace(/Ã¨/g, "e").
                    replace(/Ã©/g, "e").
                    replace(/Ãª/g, "e").
                    replace(/Ã«/g, "e").
                    replace(/Ã¬/g, "i").
                    replace(/Ã­/g, "i").
                    replace(/Ã®/g, "i").
                    replace(/Ã¯/g, "i").
                    replace(/Ã°/g, "_").
                    replace(/Ã±/g, "n").
                    replace(/Ã²/g, "o").
                    replace(/Ã³/g, "o").
                    replace(/Ã´/g, "o").
                    replace(/Ãµ/g, "o").
                    replace(/Ã¶/g, "o").
                    replace(/Ã·/g, "_").
                    replace(/Ã¸/g, "o").
                    replace(/Ã¹/g, "u").
                    replace(/Ãº/g, "u").
                    replace(/Ã»/g, "u").
                    replace(/Ã¼/g, "u").
                    replace(/Ã½/g, "y").
                    replace(/Ã¾/g, "_").
                    replace(/Ã¿/g, "y").
                    replace(/%/g, "_").
                    replace(/`/g, "_").
                    replace(/Â°/g, "_").
                    replace(/'/g, "_").
                    replace(/ /g, "_").
                    replace(/\//g, "_").
                    replace(/~/g, "_");
            return New;
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
        AddArchivos: function () {

            var txt_DesAnex = $("#txt_DesAnex").val();
            var Src_File = $("#Src_File").val();
            var Name_File = $("#Name_File").val();

            var contAnexo = $("#contAnexo").val();
            contAnexo++;
            var fila = '<tr class="selected" id="filaAnexo' + contAnexo + '" >';

            fila += "<td>" + contAnexo + "</td>";
            fila += "<td>" + txt_DesAnex + "</td>";
            fila += "<td>" + Name_File + "</td>";
            fila += "<td><a href='" + Src_File + "' target='_blank' class=\"btn default btn-xs blue\">"
                    + "<i class=\"fa fa-search\"></i> Ver</a>";
            fila += "<input type='hidden' id='idAnexo" + contAnexo + "' name='idAnexo' value='" + txt_DesAnex + "///" + Name_File + "///" + Src_File + "' /><a onclick=\"$.QuitarAnexo('filaAnexo" + contAnexo + "')\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";

            $('#tb_Anexo').append(fila);
            $.reordenarAnexo();
            $("#contAnexo").val(contAnexo);

            $("#txt_DesAnex").val("");
            //   $("#Src_File").val("");
            $("#Name_File").val("");
            $("#archivos").val("");
            $("#fileSize").html("");

        },
        reordenarAnexo: function () {
            var num = 1;
            $('#tb_Anexo tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Anexo tbody input').each(function () {
                $(this).attr('id', "idAnexo" + num);
                num++;
            });

        },
        QuitarAnexo: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarAnexo();
            contProd = $('#contAnexo').val();
            contProd = contProd - 1;
            $("#contAnexo").val(contProd);
        },

        reordenarImg: function () {
            var num = 1;
            $('#tb_Galeria tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Galeria tbody input').each(function () {
                $(this).attr('id', "idImg" + num);
                num++;
            });
        },
        QuitarImg: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarImg();
            contImg = $('#contImg').val();
            contImg = contImg - 1;
            $("#contImg").val(contImg);
        },

        Dta_Img: function () {
            Dat_Img = "";
            $("#tb_Galeria").find(':input').each(function () {
                Dat_Img += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Img += "&Long_Img=" + $("#contImg").val();
        },
        Dta_Localizacion: function () {
            Dat_Localiza = "";
            $("#tb_Localiza").find(':input').each(function () {
                Dat_Localiza += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Localiza += "&Long_Localiza=" + $("#contLocalizacion").val();
        },
        Dta_Porcentajes: function () {
            Dat_Porce = "";
            $("#tab_PorcCont").find(':input').each(function () {
                Dat_Porce += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Porce += "&Long_Porce=" + $("#contPorcentajes").val();
        },
        Dta_Anexos: function () {
            Dat_Anexos = "";
            $("#tb_Anexo").find(':input').each(function () {
                Dat_Anexos += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Anexos += "&Long_Anexos=" + $("#contAnexo").val();
        },
        NewInd: function () {
            //window.location.href = "../Plan_Desarrollo/Indicadores.jsp";
            window.open("../Plan_Desarrollo/Indicadores.jsp", '_blank');
        },
        UpdInd: function () {
            var datos = {
                ope: "UpdIndicadores"
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#CbIndi").show(100).html(data['mun']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        ExcelContratos: function () {
            window.open('../Proyecto/ExcelContratos.php');
        },
        Validar: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_Cod";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_CodProyecto").addClass("has-error");
            } else {
                $("#From_CodProyecto").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_Nomb";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Nombre").addClass("has-error");
            } else {
                $("#From_Nombre").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_fecha";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_fecrea").addClass("has-error");
            } else {
                $("#From_fecrea").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbTiplog";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Tipologia").addClass("has-error");
            } else {
                $("#From_Tipologia").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbContratis";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Contratista").addClass("has-error");
            } else {
                $("#From_Contratista").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_VaCont";
            Value = $(Id).val();
            if (Value === "" || Value === " " || Value === "$ 0,00") {
                Op_Validar.push("Fail");
                $("#From_Valor").addClass("has-error");
            } else {
                $("#From_Valor").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_Durac";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Dur").addClass("has-error");
            } else {
                $("#From_Dur").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbTiemDura";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Dur").addClass("has-error");
            } else {
                $("#From_Dur").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_FIni";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_fini").addClass("has-error");
            } else {
                $("#From_fini").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbProy";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Proyect").addClass("has-error");
            } else {
                $("#From_Proyect").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_PorEqui";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Equiv").addClass("has-error");
            } else {
                $("#From_Equiv").removeClass("has-error");
                Op_Validar.push("Ok");
            }


            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] === "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        SelMeta: function (par) {

            var ppar = par.split("//");

            $("#txt_IdMeta").val(ppar[0]);
            $("#txt_DesMeta").val(ppar[1]);
            $("#txt_CodMeta").val(ppar[2]);

            $("#ventanaMeta").modal("hide");
            // $('#nestr').show();
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
        AddGaleria: function () {
            if ($("#archivos").val() === "") {
                $.Alert("#msg", "Por Favor Seleccione la Imagen a Cargar...", "warning");
                return;
            } else if ($('#CbEstImg').val() === " ") {
                $.Alert("#msg", "Por Favor Seleccione el destino de las Imagenes...", "warning");
                return;
            } else {

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

                var ruta = "../Proyecto/upload_img.php";
                $.ajax({
                    url: ruta,
                    async: false,
                    type: "POST",
                    data: archivos,
                    contentType: false,
                    processData: false,
                    success: function (datos)
                    {
                        $.AddTabla(datos);
                    }
                });
            }
        },
        AddTabla: function (dat) {

            var CbEstImg = $('#CbEstImg').val();
            contImg = $("#contImg").val();
            var txt_fecha = $('#txt_fechaG').val();

            var Result = dat.split("//");
            for (i = 0; i < Result.length; i++) {
                contImg++;
                var fila = '<tr class="selected" id="filaImg' + contImg + '" >';
                var pararc = Result[i].split("*");
                fila += "<td>" + contImg + "</td>";
                fila += "<td>" + pararc[0] + "</td>";
                fila += "<td>" + CbEstImg + "</td>";
                fila += "<td>" + txt_fecha + "</td>";
                fila += "<td><input type='hidden' id='idImg" + contImg + "' name='terce' value='" + CbEstImg + "//" + pararc[0] + "//" + pararc[1] + "//" + txt_fecha + "' />\n\
                    <a onclick=\"$.QuitarImg('filaImg" + contImg + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Quitar</a>\n\
                    <a onclick=\"$.VerImg('../Proyecto/Galeria/" + pararc[0] + "*" + pararc[1] + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>\n\
                    </td></tr>";
                $('#tb_Galeria').append(fila);
                $.reordenarImg();
                $("#contImg").val(contImg);

                $("#CbEstado").selectpicker("val", " ");
                $("#archivos").val("");
                $("#vista-previa").html("");
            }

        },
        VerImg: function (img) {
            parimg = img.split("*");
            formimg = parimg[1];
            if (formimg.indexOf('/') !== -1) {
                parformimg = formimg.split("/");
                formimg = parformimg[0];
            }
            if (formimg === "image") {
                $("#contenedor img").attr("src", parimg[0]);
                $("#responsiveImg").modal();
            } else {
                window.open("../Proyecto/" + parimg[0], '_blank');
            }


        },
        valtiem: function () {
            if ($("#txt_tiem").val() === "") {
                alert("Debe Ingresar el Tiempo");
                $('#txt_tiem').focus();
            }

        },

        MosAlertEst: function (val) {
            if (val === "Verificado") {
                $("#modalMensaje").modal();
            }
        },
        cancelCambEst: function () {
            $("#CbEstadoProc").selectpicker("val", "Por Verificar");
            $("#modalMensaje").modal('hide');

        },
        valtiemPro: function () {
            if ($("#txt_Prorog").val() === "") {
                alert("Debe Ingresar el Tiempo");
                $('#txt_Prorog').focus();
            } else {
                var datos = {
                    ope: "SumaFecha",
                    fei: $("#txt_FFina").val(),
                    tie: $("#CbTiemProrog").val(),
                    nsu: $("#txt_Prorog").val()
                };

                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#txt_FFina").val(data["nuevaFecha"]);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }

        },
        CalPror: function () {
            $("#CbTiemProrog").selectpicker("val", " ");
        },
        addporc: function (id) {
            var val = $("#" + id).val();

            if (parseInt(val) > 100) {
                $.Alert("#msg", "El Porcentaje no debe ser mayor a 100 Verifique...", "warning", 'warning');
                $("#" + id).val("");
            } else {
                por = $("#" + id).val().replace("%", "");
                $("#" + id).val(por + "%");
            }


        },
        valporc: function (id) {

            por = $("#" + id).val().replace("%", "");
            $("#" + id).val(por);
        },
        AddAdic: function () {
            var PVaCont = $("#txt_VaCont").val().split(" ");
            VaCon = PVaCont[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
            var VaAdi = $("#txt_VaAdi").val();

            vtotal = parseFloat(VaCon) + parseFloat(VaAdi);

            $("#txt_VaFin").val('$ ' + number_format2(vtotal, 2, ',', '.'));
            
        },
        AddVFina: function (value, id) {

            var PVaCont = $("#txt_VaCont").val();
            VaCon = PVaCont.replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
            var VaAdi = $("#txt_VaAdi").val();

            vtotal = parseFloat(VaCon) + parseFloat(VaAdi);


            $("#txt_VaFin").val('$ ' + number_format2(vtotal, 2, ',', '.'));
            textm(value, id);
        },
       
        updateporc: function (id) {
            var Toporc = 0;
            $("input[name='PorCont[]']").each(function (indice, elemento) {
                Toporc = Toporc + parseInt($(elemento).val());
            });

            var contrato = $("#" + id).attr("data-id");
            var parid = id.split("_");
            $("#Porc" + parid[2]).val(contrato + "//" + $("#" + id).val());

            if (Toporc > 100 || Toporc < 100) {
                $.Alert("#msgPorc", "El Porcentaje Total no debe ser Mayor ni  a 100%...", "warning");
                $("#btn_guardarAnio").prop('disabled', true);
                return;
            } else {
                $("#btn_guardarAnio").prop('disabled', false);
            }

            if (contrato === $("#txt_Cod").val()) {
                $("#txt_PorEqui").val($("#" + id).val());
            }

            $("#Porc_Tot").html(Toporc + "%");
        },
        VerContrat: function (contr) {

            $('#cont_princip').hide();
            $('#cont_histo').show();
            var parcont = contr.split("/");
            $("#num_contr").val(parcont[0]);
            var datos = {
                ope: "CargHisContr",
                cod: parcont[0],
                id: parcont[1]
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#titcontr').html(data['contrato']);
                    $('#tab_HistoCont').html(data['Cad']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UpdPorc: function () {


            var Proy = $("#CbProy").val();
            var Cont = $("#txt_Cod").val();
            var porequ = $("#txt_PorEqui").val();
            if (Proy === "" || Proy === " ") {
                $.Alert("#msg", "Por Favor Seleccione el Proyecto...", "warning");
                return;
            }

            $("#Porncentajes").modal({backdrop: 'static', keyboard: false});
            var datos = {
                ope: "CargPorcCont",
                proy: Proy,
                Cont: Cont,
                porequ: porequ,
                acc: $("#acc").val()
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PorcCont').html(data['Tab_Porc']);
                    $('#contPorcentajes').html(data['ContPor']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        ValidarT: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_CodT";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_CodigoT").addClass("has-error");
            } else {
                $("#From_CodigoT").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_DescT";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_DescripcionT").addClass("has-error");
            } else {
                $("#From_DescripcionT").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        ValidarC: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_identC";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_ide").addClass("has-error");
            } else {
                $("#From_ide").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_NombC";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_nomC").addClass("has-error");
            } else {
                $("#From_nomC").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        ValidarS: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_CodS";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_CodigoS").addClass("has-error");
            } else {
                $("#From_CodigoS").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_DescS";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_DescripcionS").addClass("has-error");
            } else {
                $("#From_DescripcionS").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        ValidarI: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_CodI";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_CodigoI").addClass("has-error");
            } else {
                $("#From_CodigoI").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_DescI";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_DescripcionI").addClass("has-error");
            } else {
                $("#From_DescripcionI").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        NewContra: function () {
            $("#VentContratista").modal("show");
            $.BusDepa();
        },
        Dta_Docum: function () {
            var archivos = document.getElementById("archEstad");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
                archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }

            var ruta = "../Proyecto/SubirDocumContrato.php";

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
                        $('#Src_FileEstad').val(par_res[1].trim());
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msg", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                },
                beforeSend: function () {
                    $('#cargando').modal('show');
                },
                complete: function () {
                    $('#cargando').modal('hide');
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        BusDepa: function (val) {

            var datos = {
                ope: "cargaDepar",
                cod: val
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#CbDepaC").html(data['Depa']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbMunC").prop('disabled', false);


        },

        cambioFormato: function (id,val) {
            var numero = $("#" + id).val();
            $("#"+val).val(numero);
            var formatoMoneda = formatCurrency(numero, "es-CO", "COP");
            
            $("#" + id).val(formatoMoneda);
          },
         

        NewTipo: function () {
            $("#VentTipologias").modal("show");
        },
        NewSuper: function () {
            $("#VentSupervisor").modal("show");
        },
        NewInter: function () {
            $("#VentInterventor").modal("show");
        },
        NewAdicion: function (op) {
            if(op == "1"){
                $("#VentAdicion").modal({backdrop: 'static', keyboard: false});
            }
         
            var datos = {
                ope: "CargAdiciones",
                cont: $("#txt_Cod").val()
            };

            $("#listAdiciones").show();
            $("#AddAdiciones").hide();
           
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    $("#td-AdicionContrato").html(data['CadAdicion']);
                    $("#gtotalAdicion").html(formatCurrency(data['total'],"es-CO", "COP"));
                    $("#txt_VaAdiV").val(formatCurrency(data['total'],"es-CO", "COP"));
                    $("#txt_VaAdi").val(data['total']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $.AddAdic();
          
        },
        QuitarAdicion: function(id){
            Swal.fire({
                title: '¿Estás seguro de eliminar este registro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    container: 'swal2-container'
                },
                confirmButtonText: '¡Sí, eliminar!'
              }).then((result) => {
                if (result.isConfirmed) {
        
                 var datos = {
                    ope: "eliminarAdicion",
                    id: id,
                  };
          
                  $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    success: function (data) {
                      if (data === "Bien") {
                        Swal.fire(
                          '¡Eliminado!',
                          'El registro fue eliminado exitosamente.',
                          'success'
                        )
                        $.NewAdicion('2');
                      }
                    },
                    error: function (error_messages) {
                      alert("HA OCURRIDO UN ERROR");
                    },
                  });                 
                }
              })
              
        },
        QuitarPoliza: function(id){
            Swal.fire({
                title: '¿Estás seguro de eliminar este registro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    container: 'swal2-container'
                },
                confirmButtonText: '¡Sí, eliminar!'
              }).then((result) => {
                if (result.isConfirmed) {
        
                 var datos = {
                    ope: "eliminarPoliza",
                    id: id,
                  };
          
                  $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    success: function (data) {
                      if (data === "Bien") {
                        Swal.fire(
                          '¡Eliminado!',
                          'El registro fue eliminado exitosamente.',
                          'success'
                        )
                        $.mostrarListPolizas();
                      }
                    },
                    error: function (error_messages) {
                      alert("HA OCURRIDO UN ERROR");
                    },
                  });
        
                 
                }
              })
              
        },
        QuitarGasto: function(id){
            Swal.fire({
                title: '¿Estás seguro de eliminar este registro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    container: 'swal2-container'
                },
                confirmButtonText: '¡Sí, eliminar!'
              }).then((result) => {
                if (result.isConfirmed) {
        
                 var datos = {
                    ope: "eliminarGasto",
                    id: id,
                  };
          
                  $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    success: function (data) {
                      if (data === "Bien") {
                        Swal.fire(
                          '¡Eliminado!',
                          'El registro fue eliminado exitosamente.',
                          'success'
                        )
                        $.NewGastos('2');
                      }
                    },
                    error: function (error_messages) {
                      alert("HA OCURRIDO UN ERROR");
                    },
                  });
        
                 
                }
              })
              
        },
        EditarAdicion: function (id) {
            $("#txt_idAdicion").val(id)
            var datos = {
                ope: "editAdicion",
                idAdi: id
            };

            $("#listAdiciones").hide();
            $("#AddAdiciones").show();
            $("#acc").val("5");

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_fechaAdd").val(data['fecha']);
                    $("#txt_valorAdicV").val(formatCurrency(data['valor'],"es-CO", "COP"));
                    $("#txt_valorAdic").val(data['valor']);
                    $("#Src_FileAdicion").val(data['url_documento']);

                    if(data['url_documento'] !== ""){
                        $('#btn-verDocumentos').show();
                    }else{
                        $('#btn-verDocumentos').hide();
                    }

                //detalles
                   $("#td-DetAdicionContrato").html(data['tabDetAddiciones']);
                   $("#gtotalPresTota").html(formatCurrency(data['contTotal'],"es-CO", "COP"));
                   $("#contAdicion").val(data['cont']);
                   PreTotalAdicion =data['contTotal'];

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        EditarPoliza: function (id) {   
            var datos = {
                ope: "editPoliza",
                idPoli: id
            };

            $("#opcPoliza").val("EDITAR");
            $("#id_poliza").val(id);

            $("#ListPoliza").hide();
            $("#formPoliza").show();
            
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#num_poliza").val(data['num_poliza']);
                    $("#des_poliza").val(data['descripcion']);
                    $("#fecha_ini_poliza_u").val(data['fecha_ini']);
                    $("#fecha_fin_poliza_u").val(data['fecha_fin']);
                    $("#doc_anexo_poliza").val(data['anexo']);

                    if(data['anexo'] != ''){
                        $("#From_Arch").hide();
                        $("#detaDocumento").show();
                    }else{
                        $("#From_Arch").show();
                        $("#detaDocumento").hide();
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


        },
        quitarDocumento: function(){
            $("Src_FileAdicion").val("");
            $('#btn-verDocumentos').hide();
        },
        verDocumento: function(){            
            var rutaArchivo = '../Proyecto/'+  $("#Src_FileAdicion").val();; // Cambia esta ruta a la ubicación de tu archivo
            window.open(rutaArchivo, '_blank');
        },
        verDocumentoPoliza: function(){            
            var rutaArchivo = '../Proyecto/'+  $("#doc_anexo_poliza").val();; // Cambia esta ruta a la ubicación de tu archivo
            window.open(rutaArchivo, '_blank');
        },
        quitarDocumentoGasto: function(){
            $("Src_FileGasto").val("");
            $('#btn-verDocumebtosGasto').hide();
        },
        quitarDocumentoPoliza: function(){
            $("doc_anexo_poliza").val("");
            $('#From_Arch').show();
            $('#detaDocumento').hide();
        },
        verDocumentoGasto: function(){            
            var rutaArchivo = '../Proyecto/'+  $("#Src_FileGasto").val();; // Cambia esta ruta a la ubicación de tu archivo
            window.open(rutaArchivo, '_blank');
        },
        NewGastos: function(op){
            if(op == "1"){
                $("#VentGastos").modal({backdrop: 'static', keyboard: false});
            }

            var datos = {
                ope: "CargGastos",
                cont: $("#txt_Cod").val()
            };
            $("#listGastos").show();
            $("#AddGasto").hide();
           
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#td-GastoContrato").html(data['CadGastos']);
                    $("#gtotalGasto").html(formatCurrency(data['total'],"es-CO", "COP"));
                    $("#txt_VaEjeV").val(formatCurrency(data['total'],"es-CO", "COP"));
                    $("#txt_VaEje").val(data['total']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
         
        },
        
        EditarGasto: function (id) {
            $("#txt_idGasto").val(id)
            var datos = {
                ope: "editGasto",
                idGast: id
            };

            $("#listGastos").hide();
            $("#AddGasto").show();

            $("#acc").val("7");

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_fechaGasto").val(data['fecha']);
                    $("#CbCategoriaGasto").select2("val",data['categoria'])
                    $("#txt_valorGastoV").val(formatCurrency(data['valor'],"es-CO", "COP"));
                    $("#txt_valorGasto").val(data['valor']);
                    $("#txt_descripcionGasto").val(data['descripcion']);
                    $("#Src_FileGasto").val(data['url_documento']);

                    if(data['url_documento'] !== ""){
                        $('#btn-verDocumebtosGasto').show();
                    }else{
                        $('#btn-verDocumebtosGasto').hide();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        CargTipol: function () {

            var datos = {
                ope: "CargTipologiaCont" 
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbSuper").html(data['Superv']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        CargSupervisor: function () {

            var datos = {
                ope: "CargSupervisor"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbSuper").html(data['Superv']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        CargIntervetor: function () {

            var datos = {
                ope: "CargInterventor"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbInter").html(data['Interv']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        calculaDigitoVerificador: function (i_rut) {

            var pesos = new Array(71, 67, 59, 53, 47, 43, 41, 37, 29, 23, 19, 17, 13, 7, 3);
            var rut_fmt = $.zero_fill(i_rut, 15);
            suma = 0;
            for (i = 0; i <= 14; i++)
                suma += rut_fmt.substring(i, i + 1) * pesos[i];
            resto = suma % 11;
            if (resto == 0 || resto == 1) {
                digitov = resto;
            } else {
                digitov = 11 - resto;

            }
            $('#txt_dvC').val(digitov);
        },
        zero_fill: function (i_valor, num_ceros) {
            relleno = ""
            i = 1
            salir = 0
            while (!salir) {
                total_caracteres = i_valor.length + i
                if (i > num_ceros || total_caracteres > num_ceros)
                    salir = 1
                else
                    relleno = relleno + "0"
                i++
            }

            i_valor = relleno + i_valor
            return i_valor
        },
        JustifAtraso: function (id) {
            $("#ventanaJustAtraso").modal({backdrop: 'static', keyboard: false});
            $("#id_contrato").val(id);

            var datos = {
                ope: "BusqDetaContrato",
                cod: id
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_Cod").val(data['num_contrato']);
                    $("#NumContrJust").html(data['num_contrato']);
                    $("#ObjetoJust").html(data['obj_contrato']);
                    $("#ContratJust").html(data['descontrati_contrato']);
                    $("#SupervJust").html(data['dessuperv_contrato']);
                    $("#IntervJust").html(data['desinterv_contrato']);

                    $("#DurContrJust").html(data['durac_contrato']);
                    $("#FecIniJust").html(data['fini_contrato']);
                    $("#FecFinaJust").html(data['ffin_contrato']);
                    $('#ProyectAsocJust').html(data["desproy_contrato"]);
                    $("#AvanceJust").html(data['porav_contrato']);


                    $("#Src_FilJustAtr").val(data['Evide']);
                    if (data['Evide'] !== "") {
                        $("#DivEvid").show();
                        $("#DivDetEvid").html(data['evid2']);
                    }

                    if (data['Justi'] === "") {
                        $("#txt_JustAtraso").html("No se ha Agregado Ninguna Justificación");
                    } else {
                        $("#txt_JustAtraso").html(data['Justi']);
                    }

                    if (data['Evide'] === "") {
                        $("#docuAdj").html('<p style="color: #e02222; margin: 0px 0">No se ha adjuntado ninguna Evidencia</p>');
                    } else {
                        $("#docuAdj").html('<a href="../Proyecto/' + data['Evide'] + '" target="_BLACK"  class="btn default btn-xs blue"><i class="fa fa-search"></i> Ver Documento </a>');
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        GuardarJustAtraso: function () {

            $.UploadEvid();
            var datos = "id_contrato=" + $("#id_contrato").val() + "&txt_JustAtraso=" + $("#txt_JustAtraso").val()
                    + "&eviden=" + $("#Src_FilJustAtr").val() + "&num_cont=" + $("#txt_Cod").val();

            $.ajax({
                type: "POST",
                url: "../Proyecto/GuardarJustAtrasContrato.php",
                data: datos,
                success: function (data) {

                    if (trimAll(data) === "bien") {
                        $.Alert("#msgJusti", "Datos Guardados Exitosamente...", "success", "check");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });



        },
        UploadEvid: function () {
            var archivos = document.getElementById("anexo_justAtra");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
                archivos.append('anexo_justAtra' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }

            var ruta = "../Proyecto/SubirEvidencia.php";

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
                        $('#Src_FilJustAtr').val($('#Src_FilJustAtr').val() + par_res[1].trim());
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msgArchJusti", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                },
                beforeSend: function () {
                    $('#cargando').modal({backdrop: 'static', keyboard: false});
                },
                complete: function () {
                    $('#cargando').modal('hide');
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        Dta_detallesAdicion: function () {
            Dat_detAdicion = "";
            $("#tb_AdicionContrato").find(':input').each(function () {
                
                Dat_detAdicion += "&" + $(this).attr("id") + "=" + $(this).val();
            });
         
            
          },
        guadarAdicion: function () {

           
           if ($("#txt_fechaAdd").val() === "" || $("#txt_fechaAdd").val() === " ") {
            $.Alert(
              "#msgAdicionGen",
              "Debe de seleccionar la fecha de adición",
              "warning",
              "warning"
            );
            return;
          }
           if ($("#txt_valorAdicV").val() === "$ 0,00") {
            $.Alert(
              "#msgAdicionGen",
              "Debe de agregar un detalle para la adición",
              "warning",
              "warning"
            );
            return;
          }

          $.UploadDoc();
          $.Dta_detallesAdicion();

          var datos =
            "txt_fechaAdd=" + $("#txt_fechaAdd").val()+"&txt_valorAdic="+$("#txt_valorAdic").val()
            + "&Src_FileAdicion="+$("#Src_FileAdicion").val()
            + "&idContrato="+ $("#txt_Cod").val()
            +"&Long_DetAdicion="+ $("#contAdicion").val()
            +"&txt_idAdicion="+ $("#txt_idAdicion").val()
            +"&acc="+$("#acc").val();
          

          var Alldata = datos + Dat_detAdicion;

          $.ajax({
            type: "POST",
            url: "../Proyecto/GuardarContrato.php",
            data: Alldata,
            success: function (data) {
                var pares = data.split("/");
                if (trimAll(pares[0]) === "bien") {
                $.Alert(
                  "#msgAdicionGen",
                  "Datos Guardados Exitosamente...",
                  "success",
                  "check"
                );
                

                setTimeout(function () {
                    $("#acc").val("2");
                    $.NewAdicion('2');
                }, 2000);
            
              }
            },
            error: function (error_messages) {
              alert("HA OCURRIDO UN ERROR");
            },
          });



        },
        guadarGasto: function () {

           
           if ($("#txt_fechaGasto").val() === "" || $("#txt_fechaGasto").val() === " ") {
            $.Alert(
              "#msgGastoGen",
              "Debe de seleccionar la fecha del gasto",
              "warning",
              "warning"
            );
            return;
          }
           if ($("#CbCategoriaGasto").val() === "" || $("#CbCategoriaGasto").val() === " ") {
            $.Alert(
              "#msgGastoGen",
              "Debe de seleccionar la categoria del gasto",
              "warning",
              "warning"
            );
            return;
          }
           if ($("#txt_valorGastoV").val() === "$ 0,00") {
            $.Alert(
              "#msgGastoGen",
              "Debe de agregar el valor para el gasto",
              "warning",
              "warning"
            );
            return;
          }

          $.UploadDocGasto();

          var datos = "txt_fechaGasto=" + $("#txt_fechaGasto").val()
            +"&CbCategoriaGasto="+$("#CbCategoriaGasto").val()
            +"&txt_valorGasto="+$("#txt_valorGasto").val()
            +"&idContrato="+ $("#txt_Cod").val()
            +"&txt_descripcionGasto="+ $("#txt_descripcionGasto").val()
            +"&Src_FileGasto="+ $("#Src_FileGasto").val()
            +"&txt_idGasto="+ $("#txt_idGasto").val()
            +"&acc="+$("#acc").val();
          
          $.ajax({
            type: "POST",
            url: "../Proyecto/GuardarContrato.php",
            data: datos,
            success: function (data) {
                var pares = data.split("/");
                if (trimAll(pares[0]) === "bien") {
                $.Alert(
                  "#msgGastoGen",
                  "Datos Guardados Exitosamente...",
                  "success",
                  "check"
                );
                setTimeout(function () {
                    $("#acc").val("2");
                    $.NewGastos('2');
                }, 2000);            
              }
            },
            error: function (error_messages) {
              alert("HA OCURRIDO UN ERROR");
            },
          });



        },
        nuevaPoliza: function(){

            $("#ListPoliza").hide();
            $("#formPoliza").show();

            $("#num_poliza").val("");
            $("#des_poliza").val("");
            $("#fecha_ini_poliza_u").val("");
            $("#fecha_fin_poliza_u").val("");
            $("#doc_anexo_poliza").val("");
            $("#opcPoliza").val("GUARDAR");

            $("#From_Arch").show();
            $("#detaDocumento").hide();

        },
        atrasListPolizas: function(){
            $("#ListPoliza").show();
            $("#formPoliza").hide();
        },
        mostrarListPolizas: function(){
            $("#ListPoliza").show();
            $("#formPoliza").hide();

            var id_contrato = $("#id_contrato").val();
            
            var datos = {
                id_contrato: id_contrato,
                OPCION: 'CONSULTAR'
            }
            $.ajax({
                type: "POST",
                url: "../Proyecto/Polizas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                   $("#tb_Body_polizas").html(data);
                },
                error: function (error_messages) {
    
                }
            });

        },
        AddAdicion: function () {
           $("#listAdiciones").hide(); 
           $("#AddAdiciones").show();
           $("#acc").val("4");

           //limpiar campos
           $("#txt_fechaAdd").val("");
           $("#txt_valorAdicV").val("$ 0,00");
           $("#txt_valorAdic").val("");
           $("#archivosAdicion").val("");
           $("#Src_FileAdicion").val("");

           //limpiar detalles
           $("#contAdicion").val("0");
           $("#td-DetAdicionContrato").html("");
           $("#gtotalPresTota").html("$ 0,00");

           $("#btn-verDocumentos").hide();

        },
        AddGasto: function () {
           $("#listGastos").hide(); 
           $("#AddGasto").show();
           $("#acc").val("6");
           
           //limpiar campos
           $("#txt_fechaGasto").val("");
           $("#CbCategoriaGasto").select2("val", " ");
           $("#txt_valorGastoV").val("$ 0,00");
           $("#txt_valorGasto").val("");
           $("#archivosGasto").val("");
           $("#Src_FileGasto").val("");
           $("#txt_descripcionGasto").val("");
           $("#btn-verDocumebtosGasto").hide();
        },
        atrasAdicion: function () {
            $("#AddAdiciones").hide();
            $("#listAdiciones").show();
        },
        atrasGasto: function () {
            $("#AddGasto").hide();
            $("#listGastos").show();
        },
        AddDeltalleAdicionContrato: function () {
            var CbFuenteFinanciacion = $("#CbFuenteFinanciacion").val(); 
            var desCbFuenteFinanciacion =$("#CbFuenteFinanciacion option:selected").text();
            var CbFuentesubfinanciacion = $("#subfuente").val(); 
            var desCbSubfuenteFinanciacion =$("#subfuente option:selected").text();
            var CbGastos =  $("#CbGastos").val(); 
            var txt_DesGastos =  $("#txt_DesGastos").val(); 
            var txt_valorDetAdic = $("#txt_valorDetAdic").val();
      
            PreTotalAdicion += parseFloat(txt_valorDetAdic);
      
            if ($("#CbFuenteFinanciacion").val() === " ") {
              $.Alert(
                "#msgAdicion",
                "Debe de seleccionar la fuente de financiación",
                "warning",
                "warning"
              );
              return;
            }
            if ($("#CbFuenteFinanciacion").val() === " ") {
              $.Alert(
                "#msgAdicion",
                "Debe de seleccionar la subfuente de financiación",
                "warning",
                "warning"
              );
              return;
            }
            
            if ($("#txt_valorDetAdicV").val() === "$ 0,00") {
              $.Alert(
                "#msgAdicion",
                "Debe de ingresar el valor total del item agregado",
                "warning",
                "warning"
              );
              return;
            }
      
      
            contAdicion = $("#contAdicion").val();
            contAdicion++;
            var fila = '<tr class="selected" id="filaPresup' + contAdicion + '" >';
      
            fila += "<td>" + contAdicion + "</td>";
            fila += "<td>" + desCbFuenteFinanciacion+ "</td>";
            fila += "<td>" + desCbSubfuenteFinanciacion+ "</td>";
            fila += "<td>" + CbGastos+" - "+txt_DesGastos+ "</td>";
            fila += "<td>" + formatCurrency(txt_valorDetAdic, "es-CO", "COP") + "</td>";
            fila += "<td ><input type='hidden' id='idDetAdicion" +contAdicion + "' name='terce' value='" + CbFuenteFinanciacion +"//" + CbFuentesubfinanciacion +"//" +  CbGastos +"//" +  txt_DesGastos +"//" +  txt_valorDetAdic +"' /><a data-conse='filaPresup"+contAdicion+"' data-valor='"+  txt_valorDetAdic +"'  onclick='$.QuitardetAdicion(this)' class='btn default btn-xs red'>";
            fila += "<i class='fa fa-trash-o'></i> Quitar</a></td></tr>";
            $("#td-DetAdicionContrato").append(fila);
           
            $("#gtotalPresTota").html(formatCurrency(PreTotalAdicion, "es-CO", "COP"));
            $("#txt_valorAdicV").val(formatCurrency(PreTotalAdicion, "es-CO", "COP"));
            $("#txt_valorAdic").val(PreTotalAdicion);
                        
            $.reordenarAdicion();
            $("#contAdicion").val(contAdicion);
      
            $("#CbFuenteFinanciacion").select2("val", " ");          
            $("#CbGastos").selectpicker("val", "GASTOS INDIRECTOS");
            $("#txt_DesGastos").val("");
            $("#txt_valorDetAdicV").val("$ 0,00");
            $("#txt_valorDetAdic").val("0");
          },
          QuitardetAdicion: function (element) {
            
            let idElement = element.getAttribute("data-conse");
            let valor = element.getAttribute("data-valor");
            
            console.log(idElement);
            $("#" + idElement).remove();
            $.reordenarAdicion();
            contPresup = $("#contAdicion").val();
            contPresup = contPresup - 1;
            $("#contAdicion").val(contPresup);      
      
            PreTotalAdicion = PreTotalAdicion - parseFloat(valor);
          
           $("#gtotalPresTota").html(formatCurrency(PreTotalAdicion, "es-CO", "COP"));
           $("#txt_valorAdicV").val(formatCurrency(PreTotalAdicion, "es-CO", "COP"));
           $("#txt_valorAdic").val(PreTotalAdicion);
         
          },
          buscaSubfinanciacion: function(){
            var datos = {
                ope: "buscarSubfuente",
                cod: $("#CbFuenteFinanciacion").val()
              };
        
              $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: "json",
                success: function (data) {
                  $("#subfuente").html(data["subfi"]);
                },
                error: function (error_messages) {
                  alert("HA OCURRIDO UN ERROR");
                },
              });
          },
          reordenarAdicion: function () {
            var num = 1;
            $("#tb_Presup tbody tr").each(function () {
              $(this).find("td").eq(0).text(num);
              num++;
            });
            num = 1;
            $("#tb_Presup tbody input").each(function () {
              $(this).attr("id", "idPresup" + num);
              num++;
            });
          },
          UploadDoc: function () {
           
            var archivos = document.getElementById("archivosAdicion"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
                   Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
                   indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
              archivos.append("archivosAdicion" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }
      
            var ruta = "../Proyecto/SubirDocumContrato.php";
      
            $.ajax({
              async: false,
              url: ruta,
              type: "POST",
              data: archivos,
              contentType: false,
              processData: false,
              success: function (datos) {
                var par_res = datos.split("//");
                if (par_res[0] === "Bien") {
                  $("#Src_FileAdicion").val(par_res[1].trim());
                } else if (par_res[0] === "Mal") {
                  $.Alert(
                    "#msgArchAdicion",
                    "El archivo no se Puede Agregar debido al siguiente Error:"
                      .par_res[1],
                    "warning"
                  );
                }
              },
            });
          },
          UploadDocGasto: function () {
           
            var archivos = document.getElementById("archivosGasto"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
                   Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
                   indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
              archivos.append("archivosGasto" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }
      
            var ruta = "../Proyecto/SubirDocumContrato.php";
      
            $.ajax({
              async: false,
              url: ruta,
              type: "POST",
              data: archivos,
              contentType: false,
              processData: false,
              success: function (datos) {
                var par_res = datos.split("//");
                if (par_res[0] === "Bien") {
                  $("#Src_FileGasto").val(par_res[1].trim());
                } else if (par_res[0] === "Mal") {
                  $.Alert(
                    "#msgArchGasto",
                    "El archivo no se Puede Agregar debido al siguiente Error:"
                      .par_res[1],
                    "warning"
                  );
                }
              },
            });
          },

    });
    //======FUNCIONES========\\

    $.CargaTodContr();

    var ulr = window.location.search.substring(1);
    var vars = ulr.split("&");
    var valVa = vars[0].split("=");
    if (valVa[1] === "CV") {
        $("#CbProyBusc").prop('disabled', true);
        $("#busq_centro").prop('disabled', true);
        $("#btn_ExcelCont").prop('disabled', true);
        $("#nregContra").prop('disabled', true);
        $("#TitContAtrasados").show();

        var datos = {
            pag: "1",
            op: "1",
            bus: "",
            rus: "n",
            nreg: $("#nregContra").val(),
            ord: Order
        };

        $.ajax({
            type: "POST",
            url: "../Paginadores/ContratosVencidos.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                $('#tab_Proyect').html(data['cad']);
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    } else {
        $.Contratos();
    }

    $("#txt_identC").on("change", function () {

        var datos = {
            ope: "verfContratista",
            cod: $("#txt_identC").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_ide").addClass("has-error");
                    $.Alert("#msgC", "Esta Identificación ya Esta Registrada...", "warning", "warning");
                    $('#txt_identC').focus();
                    $("#txt_identC").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });
    $("#btn_nuevoC").on("click", function () {

        $("#txt_identC").val("");
        $("#txt_dvC").val("");
        $("#txt_NombC").val("");
        $("#CbDepaC").select2("val", " ");
        $("#CbMunC").select2("val", " ");
        $("#CbPersonaC").selectpicker("val", " ");
        $("#cbx_tipo_identC").selectpicker("val", "CC");
        $("#txt_TelC").val("");
        $("#txt_DirecC").val("");
        $("#txt_CorreoC").val("");
        $("#txt_IdReprC").val("");
        $("#txt_NomReprC").val("");
        $("#txt_TelReprC").val("");
        $("#txt_obserC").val("");
        $('#datReprC').hide();

        $("#btn_nuevoC").prop('disabled', true);
        $("#btn_guardarC").prop('disabled', false);

        $("#txt_identC").prop('disabled', false);
        $("#CbPersonaC").prop('disabled', false);
        $("#cbx_tipo_identC").prop('disabled', false);
        $("#txt_NombC").prop('disabled', false);
        $("#txt_TelC").prop('disabled', false);
        $("#txt_DirecC").prop('disabled', false);
        $("#txt_CorreoC").prop('disabled', false);
        $("#txt_IdReprC").prop('disabled', false);
        $("#txt_NomReprC").prop('disabled', false);
        $("#txt_TelReprC").prop('disabled', false);
        $("#CbDepaC").prop('disabled', false);
        $("#txt_obserC").prop('disabled', false);

    });

    $("#archivos").on("change", function () {
        /* Limpiar vista previa */
        $("#vista-previa").html('');
        var archivos = document.getElementById('archivos').files;
        var navegador = window.URL || window.webkitURL;
        /* Recorrer los archivos */
        for (x = 0; x < archivos.length; x++)
        {
            /* Validar tamaño y tipo de archivo */
            var size = archivos[x].size;
            var type = archivos[x].type;
            var name = archivos[x].name;

            if (size > 10485760)
            {
                $("#vista-previa").append("<p style='color: red'>El archivo " + name + " supera el máximo permitido 10MB</p>");
            } else if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif' && type != 'video/mp4' && type != 'video/avi' && type != 'video/mpg' && type != 'video/mpeg')
            {
                $("#vista-previa").append("<p style='color: red'>El archivo " + name + " no es del tipo de imagen/video permitida.</p>");
            } else
            {
                var objeto_url = navegador.createObjectURL(archivos[x]);
                $("#vista-previa").append("<img src=" + objeto_url + " width='100' height='100'>&nbsp;");
            }
        }
    });

    $("#btn_volver").on("click", function () {
        window.location.href = "../Contratos/";

    });

    function restrictInput(event) {
        const input = event.target;
        const regex = /[^0-9.,]/g;
        
        // Remove any invalid characters
        input.value = input.value.replace(regex, '');
    
      }


      function formatCurrency(number, locale, currencySymbol) {
        return new Intl.NumberFormat(locale, {
          style: "currency",
          currency: currencySymbol,
          minimumFractionDigits: 2,
        }).format(number);
      }

    $("#anexo_justAtra").on("change", function () {
        /* Limpiar vista previa */
        var archivos = document.getElementById('anexo_justAtra').files;
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
                $.Alert("#msgArchJusti", "El archivo " + name + " supera el máximo permitido 20MB", "success");
            } else {
                var Mb = $.Format_Bytes(size, 2);
                $("#fileSizeJustAtr").html(Mb);
                $("#Name_FileJustAtr").val(name);
            }

        }
    });

    $("#txt_FIni").on("change", function () {

        var datos = {
            ope: "SumaFecha",
            fei: $("#txt_FIni").val(),
            tie: $("#CbTiemDura").val(),
            nsu: $("#txt_Durac").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                $("#txt_FFina").val(data["nuevaFecha"]);
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "VerfContrato",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $.Alert("#msg", "Este Número  ya ha sido Registrado", "warning", "warning");
                    $("#From_CodProyecto").addClass("has-error");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                } else {
                    $("#From_CodProyecto").removeClass("has-error");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_CodT").on("change", function () {

        var datos = {
            ope: "verfTipologContrat",
            cod: $("#txt_CodT").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_CodigoT").addClass("has-error");
                    $.Alert("#msgT", "Este Código ya Esta Registrado...", "warning", "warning");

                    $('#txt_CodT').focus();
                    $("#txt_CodT").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_paraMet").on("click", function () {
        $.Load_ventana('1');
    });
    $("#btn_newindi").on("click", function () {
        window.open("../Indicadores/HojaVidaIndicador.php?indi=Banco", '_blank');
    });
    $("#btn_volverContr").on("click", function () {
        $('#cont_princip').show();
        $('#cont_histo').hide();
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

    $("#btn_nuevoT").on("click", function () {

        $("#txt_CodT").val("");
        $("#txt_DescT").val("");
        $("#txt_obserT").val("");

        $("#btn_nuevoT").prop('disabled', true);
        $("#btn_guardarT").prop('disabled', false);

        $("#txt_CodT").prop('disabled', false);
        $("#txt_DescT").prop('disabled', false);
        $("#txt_obserT").prop('disabled', false);

    });

    $("#btn_nuevo").on("click", function () {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#CbTiplog").select2("val", " ");
        $("#txt_Nomb").val("");
        $("#CbContratis").select2("val", " ");
        $("#CbSuper").select2("val", " ");
        $("#CbInter").select2("val", " ");
        $("#txt_VaCont").val("$ 0,00");
        $("#txt_VaAdiV").val("$ 0,00");
        $("#txt_VaAdi").val("0");
        $("#txt_VaFin").val("$ 0,00");
        $("#txt_VaEjeV").val("$ 0,00");
        $("#txt_VaEje").val("0");
        $("#txt_Fpago").val("");
        $("#txt_Durac").val("");
        $("#txt_FIni").val("");
        $("#txt_FSusp").val("");
        $("#txt_FRein").val("");
        $("#txt_Prorog").val("");
        $("#txt_FFina").val("");
        $("#txt_FReci").val("");
        $("#txt_FReci").val("");
        $("#CbProy").select2("val", " ");
        $("#txt_Avance").val("");
        $("#CbEstado").selectpicker("val", " ");

        $('#divtipo').css('pointer-events', 'auto');
        $('#divcont').css('pointer-events', 'auto');
        $('#divsupe').css('pointer-events', 'auto');
        $('#divinter').css('pointer-events', 'auto');


        $("#divval").show();
        $("#divfpag").show();
        $("#divdura").show();
        $("#divfini").show();
        $("#divtitpro").show();
        $("#divproy").show();
        $("#divequi").show();

        $("#txt_Cod").prop('disabled', false);
        $("#txt_fecha_Modi").prop('disabled', false);
        $("#txt_fecha").prop('disabled', false);
        $("#CbTiplog").prop('disabled', false);
        $("#txt_Nomb").prop('disabled', false);
        $("#txt_VaCont").prop('disabled', false);
        $("#txt_Fpago").prop('disabled', false);
        $("#txt_Durac").prop('disabled', false);
        $("#CbTiemDura").prop('disabled', false);
        $("#txt_FIni").prop('disabled', false);
        $("#CbProy").prop('disabled', false);

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#tab_2").removeClass("active in");
        $("#tab_pp2").removeClass("active in");
        $("#tab_1").addClass("active in");
        $("#tab_pp1").addClass("active in");
    });

    $("#btn_nuevoS").on("click", function () {


        $("#txt_CodS").val("");
        $("#txt_DescS").val("");
        $("#txt_obserS").val("");
        $("#txt_CorreS").val("");
        $("#txt_TelfS").val("");


        $("#btn_nuevoS").prop('disabled', true);
        $("#btn_guardarS").prop('disabled', false);

        $("#txt_CodS").prop('disabled', false);
        $("#txt_DescS").prop('disabled', false);
        $("#txt_obserS").prop('disabled', false);
        $("#txt_CorreS").prop('disabled', false);
        $("#txt_TelfS").prop('disabled', false);


    });

    $("#btn_nuevoI").on("click", function () {

        $("#txt_CodI").val("");
        $("#txt_DescI").val("");
        $("#txt_obserI").val("");
        $("#txt_CorreI").val("");
        $("#txt_TelfI").val("");

        $("#btn_nuevoI").prop('disabled', true);
        $("#btn_guardarI").prop('disabled', false);

        $("#txt_CodI").prop('disabled', false);
        $("#txt_DescI").prop('disabled', false);
        $("#txt_CorreI").prop('disabled', false);
        $("#txt_TelfI").prop('disabled', false);
        $("#txt_obserI").prop('disabled', false);

    });

    $("#txt_CodS").on("change", function () {

        var datos = {
            ope: "verfSuperv",
            cod: $("#txt_CodS").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_CodigoS").addClass("has-error");
                    $.Alert("#msgS", "Este Código ya Esta Registrado...", "warning", "warning");
                    $('#txt_CodS').focus();
                    $("#txt_CodS").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });


    $("#txt_CodI").on("change", function () {

        var datos = {
            ope: "verfInterv",
            cod: $("#txt_CodI").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_CodigoI").addClass("has-error");
                    $.Alert("#msgI", "Este Código ya Esta Registrado...", "warning", "warning");
                    $('#txt_CodI').focus();
                    $("#txt_CodI").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_cancelar").on("click", function () {
        if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
            $.CargaTodContr();
            $("#txt_Cod").val("");
            $("#CbTiplog").select2("val", " ");
            $("#txt_Nomb").val("");
            $("#CbContratis").select2("val", " ");
            $("#CbSuper").select2("val", " ");
            $("#CbInter").select2("val", " ");
            $("#txt_VaCont").val("$ 0,00");
            $("#txt_VaAdiV").val("$ 0,00");
            $("#txt_VaAdi").val("");
            $("#txt_VaFin").val("$ 0,00");
            $("#txt_VaEje").val("0");
            $("#txt_VaEjeV").val("$ 0,00");
            $("#txt_Fpago").val("");
            $("#txt_Durac").val("");
            $("#txt_FIni").val("");
            $("#txt_FSusp").val("");
            $("#txt_FRein").val("");
            $("#txt_Prorog").val("");
            $("#txt_FFina").val("");
            $("#txt_FReci").val("");
            $("#txt_FReci").val("");
            $("#CbProy").select2("val", " ");
            $("#txt_Avance").val("");
            $("#CbEstado").selectpicker("val", " ");
            $("#CbEstadoProc").selectpicker("val", "Por Verificar");

            $("#txt_Cod").prop('disabled', false);
            $("#txt_fecha_Modi").prop('disabled', false);
            $("#txt_fecha").prop('disabled', false);
            $("#CbTiplog").prop('disabled', false);
            $("#txt_Nomb").prop('disabled', false);
            $("#txt_VaCont").prop('disabled', false);
            $("#txt_Fpago").prop('disabled', false);
            $("#txt_Durac").prop('disabled', false);
            $("#CbTiemDura").prop('disabled', false);
            $("#txt_FIni").prop('disabled', false);
            $("#CbProy").prop('disabled', false);


            $('#divtipo').css('pointer-events', 'auto');
            $('#divcont').css('pointer-events', 'auto');
            $('#divsupe').css('pointer-events', 'auto');
            $('#divinter').css('pointer-events', 'auto');


            $("#divval").show();
            $("#divfpag").show();
            $("#divdura").show();
            $("#divfini").show();
            $("#divtitpro").show();
            $("#divproy").show();
            $("#divequi").show();
            $("#div_estado").show();


            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $("#tab_01").addClass("active in");
            $("#tab_01_pp").addClass("active in");

            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab'  onclick='$.addCont();' id='atitulo'>Crear Contrato</a>");

        }

    });

    $("#CbPersonaC").on("change", function () {
        var val = $("#CbPersonaC").val();
        if (val == "NATURAL") {
            $('#datReprC').hide();
        } else {
            $('#datReprC').show();
        }
    });

    $("#Anx_Doc").on("click", function () {

        var des = $("#txt_DesAnex").val();
        var name = $("#Name_File").val();

        if (des == " " || des == "") {
            $.Alert("#msg", "Por Favor Ingrese una Descripción del Documento...", "warning");
            $("#From_DescriDocu").addClass("has-error");
            return;
        } else {
            $("#From_DescriDocu").removeClass("has-error");
        }

        if (name == " " || name == "") {
            $.Alert("#msg", "Por Favor Seleccione un Documento...", "warning");
            $("#From_Arch").addClass("has-error");
            return;
        } else {
            $("#From_Arch").removeClass("has-error");
        }

        $.UploadDoc();
        $.AddArchivos();

    });

    //BOTON GUARDAR INTERVENTOR
    $("#btn_guardarI").on("click", function () {

        $.ValidarI();

        if (Op_Vali === "Fail") {
            $.Alert("#msgI", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            cod: $("#txt_CodI").val(),
            des: $("#txt_DescI").val(),
            cor: $("#txt_CorreI").val(),
            tel: $("#txt_TelfI").val(),
            obs: $("#txt_obserI").val(),
            acc: "1"
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarInterv.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msgI", "Datos Guardados Exitosamente...", "success", "check");
                    $.CargIntervetor();
                    $("#btn_nuevoI").prop('disabled', false);
                    $("#btn_guardarI").prop('disabled', true);

                    $("#txt_CodI").prop('disabled', true);
                    $("#txt_DescI").prop('disabled', true);
                    $("#txt_CorreI").prop('disabled', true);
                    $("#txt_TelfI").prop('disabled', true);
                    $("#txt_obserI").prop('disabled', true);
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR SUPERVISOR
    $("#btn_guardarS").on("click", function () {

        $.ValidarS();

        if (Op_Vali === "Fail") {
            $.Alert("#msgS", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            cod: $("#txt_CodS").val(),
            des: $("#txt_DescS").val(),
            cor: $("#txt_CorreS").val(),
            tel: $("#txt_TelfS").val(),
            obs: $("#txt_obserS").val(),
            acc: "1"
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarSupervisor.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msgS", "Datos Guardados Exitosamente...", "success", "check");
                    $.CargSupervisor();
                    $("#btn_nuevoS").prop('disabled', false);
                    $("#btn_guardarS").prop('disabled', true);

                    $("#txt_CodS").prop('disabled', true);
                    $("#txt_DescS").prop('disabled', true);
                    $("#txt_CorreS").prop('disabled', true);
                    $("#txt_TelfS").prop('disabled', true);
                    $("#txt_obserS").prop('disabled', true);
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR CONTRATO
    $("#btn_guardarC").on("click", function () {

        $.ValidarC();

        if (Op_Vali === "Fail") {
            $.Alert("#msgC", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            CbPersona: $("#CbPersonaC").val(),
            cbx_tipo_ident: $("#cbx_tipo_identC").val(),
            txt_ident: $("#txt_identC").val(),
            txt_dv: $("#txt_dvC").val(),
            txt_Nomb: $("#txt_NombC").val(),
            txt_Tel: $("#txt_TelC").val(),
            txt_Direc: $("#txt_DirecC").val(),
            txt_Correo: $("#txt_CorreoC").val(),
            txt_IdRepr: $("#txt_IdReprC").val(),
            txt_NomRepr: $("#txt_NomReprC").val(),
            txt_TelRepr: $("#txt_TelReprC").val(),
            CbDepa: $("#CbDepaC").val(),
            CbMun: $("#CbMunC").val(),
            txt_obser: $("#txt_obserC").val(),
            acc: "1"
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarContratistas.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msgC", "Datos Guardados Exitosamente...", "success", "check");
                    $.CargcContra();
                    $("#btn_nuevoC").prop('disabled', false);
                    $("#btn_guardarC").prop('disabled', true);

                    $("#txt_identC").prop('disabled', true);
                    $("#CbPersonaC").prop('disabled', true);
                    $("#cbx_tipo_identC").prop('disabled', true);
                    $("#txt_NombC").prop('disabled', true);
                    $("#txt_TelC").prop('disabled', true);
                    $("#txt_DirecC").prop('disabled', true);
                    $("#txt_CorreoC").prop('disabled', true);
                    $("#txt_IdReprC").prop('disabled', true);
                    $("#txt_NomReprC").prop('disabled', true);
                    $("#txt_TelReprC").prop('disabled', true);
                    $("#CbDepaC").prop('disabled', true);
                    $("#CbMunC").prop('disabled', true);
                    $("#txt_obserC").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });

    //BOTON GUARDAR TIPOLOGIA
    $("#btn_guardarT").on("click", function () {

        $.ValidarT();

        if (Op_Vali === "Fail") {
            $.Alert("#msgT", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        var datos = {
            cod: $("#txt_CodT").val(),
            des: $("#txt_DescT").val(),
            obs: $("#txt_obserT").val(),
            acc: "1"
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarTipologiaContra.php",
            data: datos,
            success: function (data) {
                var par = data.split("-");
                if (trimAll(par[0]) === "bien") {

                    $.Alert("#msgT", "Datos Guardados Exitosamente...", "success", "check");
                    $.CargTipol();

                    $("#btn_nuevoT").prop('disabled', false);
                    $("#btn_guardarT").prop('disabled', true);

                    $("#txt_CodT").prop('disabled', true);
                    $("#txt_DescT").prop('disabled', true);
                    $("#txt_obserT").prop('disabled', true);
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
 

    $("#txt_FSusp").keypress(function (tecla) {
        return false;
    });
    $("#txt_FRein").keypress(function (tecla) {
        return false;
    });
    $("#txt_FReci").keypress(function (tecla) {
        return false;
    });


    //BOTON GUARDAR CONTRATO
    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        $.Dta_Img();
        $.Dta_Localizacion();
        $.Dta_Porcentajes();

        if ($('#archEstad').val()) {
            $.Dta_Docum();
        }

        var PvalCont = $("#txt_VaCont").val().split(" ");
        var ValCon = PvalCont[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
   
        var ValAdic = $("#txt_VaAdi").val();

        var PvalFin = $("#txt_VaFin").val().split(" ");
        var ValFin = PvalFin[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");

        var ValEje = $("#txt_VaEje").val();

        var txt_FIni = $("#txt_FIni").val();
        if ($("#txt_FIni").val() === "") {
            txt_FIni = "0000-00-00";
        }

        var txt_FSusp = $("#txt_FSusp").val();
        if ($("#txt_FSusp").val() === "") {
            txt_FSusp = "0000-00-00";
        }

        var txt_FRein = $("#txt_FRein").val();
        if ($("#txt_FRein").val() === "") {
            txt_FRein = "0000-00-00";
        }

        var txt_FFina = $("#txt_FFina").val();
        if ($("#txt_FFina").val() === "") {
            txt_FFina = "0000-00-00";
        }

        var txt_FReci = $("#txt_FReci").val();
        if ($("#txt_FReci").val() === "") {
            txt_FReci = "0000-00-00";
        }

        var durCont = $("#txt_Durac").val() + " " + $("#CbTiemDura").val();
        var Prorrog = $("#txt_Prorog").val() + " " + $("#CbTiemProrog").val();


        var datos = "txt_Cod=" + $("#txt_Cod").val() + "&txt_fecha_Modi=" + $("#txt_fecha_Modi").val() + "&txt_fecha=" + $("#txt_fecha").val()
                + "&CbTiplog=" + $("#CbTiplog").val() + "&DesCbTiplog=" + $("#CbTiplog option:selected").text()
                + "&txt_Nomb=" + $("#txt_Nomb").val() + "&CbContratis=" + $("#CbContratis").val()
                + "&CbContratisDesc=" + $("#CbContratis option:selected").text() + "&txt_Super=" + $("#CbSuper").val() + "&CbSuperDesc=" + $("#CbSuper option:selected").text()
                + "&txt_Inter=" + $("#CbInter").val() + "&CbInterDesc=" + $("#CbInter option:selected").text() + "&ValCon=" + ValCon + "&ValAdic=" + ValAdic + "&ValFin=" + ValFin
                + "&ValEje=" + ValEje + "&txt_Fpago=" + $("#txt_Fpago").val() + "&txt_Durac=" + durCont + "&novedad=" + $("#novedad").val()
                + "&txt_FIni=" + txt_FIni + "&txt_FSusp=" + txt_FSusp + "&txt_FRein=" + txt_FRein
                + "&txt_Prorog=" + Prorrog + "&txt_FFina=" + txt_FFina + "&txt_FReci=" + txt_FReci
                + "&CbProy=" + $("#CbProy").val() + "&CbProyDes=" + $("#CbProy option:selected").text() + "&txt_Url=" + $("#txt_Url").val()
                + "&txt_Avance=" + $("#txt_Avance").val() + "&CbEstado=" + $("#CbEstado").val() + "&txt_PorEqui=" + $("#txt_PorEqui").val() + "&Src_FileEstad=" + $('#Src_FileEstad').val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val() + "&CbEstadoProc=" + $("#CbEstadoProc").val() + "&Text_Motivo=" + $("#Text_Motivo").val();

        var Alldata = datos + Dat_Localiza + Dat_Img + Dat_Porce;

        $.ajax({
            type: "POST",
            url: "../Proyecto/GuardarContrato.php",
            data: Alldata,
            success: function (data) {
                var pares = data.split("/");
                if (trimAll(pares[0]) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success");
                    $.Contratos();
                    $("#txt_id").val(pares[1]);

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
