$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
    $("#menu_p_proyExp").addClass("start active open");
    $("#menu_p_proy_exp").addClass("active");

    $("#txt_fechaG,#txt_fecha,#txt_fecha_Modi,#txt_FIni,#txt_FSusp,#txt_FRein,#txt_FFina,#txt_FReci").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    $("#CbPersonaC,#cbx_tipo_identC,#CbEstadoProc,#CbEstado,#CbEstImg,#CbTiemDura,#CbTiemProrog").selectpicker();

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

    var contImg = 0;
    var Dat_Img = "";
    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        Contratos: function () {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nregContra").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratosExpre.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Contratos').html(data['cad']);
                    $('#bot_Contra').html(data['cad2']);
                    $('#cobpagContra').html(data['cbp']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Proyectos: function () {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosContratos.php",
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
        busqProyectos: function (val) {
            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ord: Order
            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosContratos.php",
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
        busqContratos: function (val) {
            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nregContra").val(),
                ord: Order
            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratosExpre.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Contratos').html(data['cad']);
                    $('#bot_Contra').html(data['cad2']);
                    $('#cobpagContra').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editContr: function (cod) {
            $('#accCont').val("2");
            $("#txt_idCont").val(cod);
            $('#botones').show();

            $('#tab_03_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");
            $('#iformCont').show(100).html("<a href='#tab_02' data-toggle='tab' id='iformCont'>Editar Contrato</a>");

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



            var datos = {
                ope: "BusqEditContratoExp",
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
                    $('#CbContratis').val(data["idcontrati_contrato"]).change();
                    $('#CbSuper').val(data["idsuperv_contrato"]).change();
                    $('#CbInter').val(data["idinterv_contrato"]).change();
                    $("#txt_VaCont").val('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#txt_VaAdi").val('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#txt_VaFin").val('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#txt_VaEje").val('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
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

                    $("#CbEstado").selectpicker("val", data['estad_contrato']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


        },
        VerContr: function (cod) {

            $("#txt_idCont").val(cod);
            $('#botonesCont').hide();

            $('#tab_03_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");
            $('#iformCont').show(100).html("<a href='#tab_02' data-toggle='tab' id='iformCont'>Ver Contrato</a>");

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



            var datos = {
                ope: "BusqEditContratoExp",
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
                    $('#CbContratis').val(data["idcontrati_contrato"]).change();
                    $('#CbSuper').val(data["idsuperv_contrato"]).change();
                    $('#CbInter').val(data["idinterv_contrato"]).change();
                    $("#txt_VaCont").val('$ ' + number_format2(data['vcontr_contrato'], 2, ',', '.'));
                    $("#txt_VaAdi").val('$ ' + number_format2(data['vadic_contrato'], 2, ',', '.'));
                    $("#txt_VaFin").val('$ ' + number_format2(data['vfin_contrato'], 2, ',', '.'));
                    $("#txt_VaEje").val('$ ' + number_format2(data['veje_contrato'], 2, ',', '.'));
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

                    $("#CbEstado").selectpicker("val", data['estad_contrato']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");
            $('#iformCont').show(100).html("<a href='#tab_03' data-toggle='tab' id='iformCont'>Ver Contrato</a>");


        },
        editProy: function (cod) {
            $('#acc').val("2");
            $("#txt_id").val(cod);
            $('#botones').show();
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            var datos = {
                ope: "BusqEditProyectExp",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_CodProy").val(data['codigo']);
                    $("#txt_NombProy").val(data['nombre']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });



            $('#tab_02_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#iform').show(100).html("<a href='#tab_02' data-toggle='tab' id='iform'>Editar Proyecto</a>");


        },
        deletProy: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Proyecto/GuardarProyectoExp.php",
                    data: datos,
                    success: function (data) {
                        var pares = data.split("/");
                        if (trimAll(pares[0]) === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Proyectos();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        deletContr: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Proyecto/GuardarContratoExpre.php",
                    data: datos,
                    success: function (data) {
                        var pares = data.split("/");
                        if (trimAll(pares[0]) === "bien") {
                            $.Alert("#msg2Contra", "Operación Realizada Exitosamente...", "success", "check");
                            $.Contratos();
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
                bus: $("#busq_Proyectos").val(),
                nreg: $("#nreg").val(),
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosContratos.php",
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
        paginadorCont: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_contratos").val(),
                nreg: $("#nregContra ").val(),
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratosExpre.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Contratos').html(data['cad']);
                    $('#bot_Contra').html(data['cad2']);
                    $('#cobpagContra').html(data['cbp']);
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
        },
        combopag: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_Proyectos").val(),
                nreg: $("#nreg").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosContratos.php",
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
        combopagCont: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_contratos").val(),
                nreg: $("#nregContra ").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratosExpre.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Contratos').html(data['cad']);
                    $('#bot_Contra').html(data['cad2']);
                    $('#cobpagContra').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag2: function (nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_Proyectos").val(),
                pag: $("#selectpag").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosContratos.php",
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
        combopag2Contra: function (nre) {
            var datos = {
                nreg: nre,
                bus: $("#busq_contratos").val(),
                pag: $("#selectpagCont").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratosExpre.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Contratos').html(data['cad']);
                    $('#bot_Contra').html(data['cad2']);
                    $('#cobpagContra').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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
                    $("#CbProy").html(data['ProExp']);
                    $("#CbSuper").html(data['Superv']);
                    $("#CbInter").html(data['Interv']);
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
                codeAddress(adress[1]);
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
                    codeAddress(adressDep[1] + ", " + adressMun[1]);
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
                    codeAddress(adressDep[1] + ", " + adressMun[1] + ", " + adressCor[1]);
                }

                if ($('#CbCorre option:selected').text() === "20001000 - VALLEDUPAR") {
                    $("#CbBarrio").prop('disabled', false);
                }
            }

        },
        BusUbiBar: function () {
            if ($('#CbBarrio option:selected').text() !== "N/A") {
                if ($('#CbBarrio option:selected').text() !== "Seleccione...") {
                    var adressDep = $('#CbDepa option:selected').text().split(' - ');
                    var adressMun = $('#CbMun option:selected').text().split(' - ');
                    var adressCor = $('#CbCorre option:selected').text().split(' - ');
                    var adressBar = $('#CbBarrio option:selected').text().split(' - ');
                    codeAddress(adressDep[1] + ", " + adressMun[1] + ", " + adressCor[1] + ", " + adressBar[1]);
                }

            }

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
        Dta_Localizacion: function () {
            Dat_Localiza = "";
            $("#tb_Localiza").find(':input').each(function () {
                Dat_Localiza += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Localiza += "&Long_Localiza=" + $("#contLocalizacion").val();
        },
        Dta_Img: function () {
            Dat_Img = "";
            $("#tb_Galeria").find(':input').each(function () {
                Dat_Img += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Img += "&Long_Img=" + $("#contImg").val();
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
        ExcelProyectos: function () {
            window.open('../Proyecto/ExcelProyectosExpres.php');
        },
        ExcelProyContExp: function () {
            window.open('../Proyecto/ExcelProyectoContratoExpres.php');
        },
//        ExcelContratos: function () {
//            window.open('../Proyecto/ExcelContratos.php');
//        },
        ValidarProy: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_NombProy";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_NombreProy").addClass("has-error");
            } else {
                $("#From_NombreProy").removeClass("has-error");
                Op_Validar.push("Ok");
            }
            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] === "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


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
            por = $("#" + id).val().replace("%", "");
            $("#" + id).val(por + "%");

        },
        valporc: function (id) {

            por = $("#" + id).val().replace("%", "");
            $("#" + id).val(por);
        },
        AddAdic: function (value, id) {
            var PVaCont = $("#txt_VaCont").val().split(" ");
            VaCon = PVaCont[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
            var PVaAdi = $("#txt_VaAdi").val();
            VaAdi = PVaAdi.replace(".", "").replace(".", "").replace(".", "").replace(",", ".");

            vtotal = parseFloat(VaCon) + parseFloat(VaAdi);

            $("#txt_VaFin").val('$ ' + number_format2(vtotal, 2, ',', '.'));
            textm(value, id);
        },
        AddVFina: function (value, id) {

            var PVaCont = $("#txt_VaCont").val();
            VaCon = PVaCont.replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
            var PVaAdi = $("#txt_VaAdi").val().split(" ");
            VaAdi = PVaAdi[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");

            vtotal = parseFloat(VaCon) + parseFloat(VaAdi);


            $("#txt_VaFin").val('$ ' + number_format2(vtotal, 2, ',', '.'));
            textm(value, id);
        },
        VerContrat: function (contr) {

            $('#cont_princip').hide();
            $('#cont_histo').show();

            var datos = {
                ope: "CargHisContr",
                cod: contr
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
        NewProyect: function () {
            $('#tab_02_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#iform').show(100).html("<a href='#tab_02' data-toggle='tab' id='iform'>Crear Proyecto</a>");

        },
        NewContrato: function () {
            $("#accCont").val("1");
            $('#tab_03_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");
            $('#iformCont').show(100).html("<a href='#tab_02' data-toggle='tab' id='iformCont'>Crear Contrato</a>");
            $.nuevoCont();
        },

        nuevoCont: function () {
            $("#txt_Cod").val("");
            $("#CbTiplog").select2("val", " ");
            $("#txt_Nomb").val("");
            $("#CbContratis").select2("val", " ");
            $("#CbSuper").select2("val", " ");
            $("#CbInter").select2("val", " ");
            $("#txt_VaCont").val("$ 0,00");
            $("#txt_VaAdi").val("$ 0,00");
            $("#txt_VaFin").val("$ 0,00");
            $("#txt_VaEje").val("$ 0,00");
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
            $("#divtitpro").show();
            $("#divproy").show();
            $("#divequi").show();

            $("#txt_Cod").prop('disabled', false);
            $("#CbTiplog").prop('disabled', false);
            $("#txt_Nomb").prop('disabled', false);
            $("#txt_VaCont").prop('disabled', false);
            $("#txt_Fpago").prop('disabled', false);
            $("#txt_Durac").prop('disabled', false);
            $("#CbTiemDura").prop('disabled', false);
            $("#txt_FIni").prop('disabled', false);
            $("#CbProy").prop('disabled', false);

        },
        VolProyecto: function () {
            $("#tab_01").addClass("active in");
            $("#tab_01_pp").addClass("active in");
            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $('#tab_02_pp').hide();
            $('#List_Proyectos').show();
            $('#List_Contratos').hide();
            $('#listado').show(100).html("<a href='#tab_02' data-toggle='tab' id='listado'>Listado de Proyectos</a>");

        },
        VolContratos: function () {
            $.Contratos();
            $("#tab_01").addClass("active in");
            $("#tab_01_pp").addClass("active in");
            $("#tab_03").removeClass("active in");
            $("#tab_03_pp").removeClass("active in");
            $('#tab_03_pp').hide();
            $('#List_Contratos').show();
            $('#listado').show(100).html("<a href='#tab_02' data-toggle='tab' id='listado'>Listado de Contratos</a>");

        },
        GesContratos: function () {
            $.Contratos();
            $("#tab_01").addClass("active in");
            $("#tab_01_pp").addClass("active in");
            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $('#tab_02_pp').hide();
            $('#List_Proyectos').hide();
            $('#List_Contratos').show();
            $('#listado').show(100).html("<a href='#tab_02' data-toggle='tab' id='listado'>Listado de Contratos</a>");


        },
        Validar: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_Nomb";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Nombre").addClass("has-error");
            } else {
                $("#From_Nombre").removeClass("has-error");
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

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] === "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


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
    
        NewTipo: function () {
            $("#VentTipologias").modal("show");
        },
        NewSuper: function () {
            $("#VentSupervisor").modal("show");
        },
        NewInter: function () {
            $("#VentInterventor").modal("show");
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
        }

    });
    //======FUNCIONES========\\
    $.Proyectos();
    $.CargaTodContr();


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

    $("#btn_nuevoProy").on("click", function () {

        $("#txt_CodProy").val("");
        $("#txt_NombProy").val("");
        $("#acc").val("1");


        $("#btn_nuevoProy").prop('disabled', true);
        $("#btn_guardarProy").prop('disabled', false);

        $("#txt_CodProy").prop('disabled', false);
        $("#txt_NombProy").prop('disabled', false);


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
            $("#txt_VaAdi").val("$ 0,00");
            $("#txt_VaFin").val("$ 0,00");
            $("#txt_VaEje").val("$ 0,00");
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

    //BOTON GUARDAR PROYECTOS
    $("#btn_guardarProy").on("click", function () {

        $.ValidarProy();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        var datos = "txt_CodProy=" + $("#txt_CodProy").val() + "&txt_NombProy=" + $("#txt_NombProy").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val();

        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "../Proyecto/GuardarProyectoExp.php",
            data: Alldata,
            success: function (data) {
                var pares = data.split("/");
                if (trimAll(pares[0]) === "bien") {
                    $.Alert("#msgProy", "Datos Guardados Exitosamente...", "success", 'check');
                    $.Proyectos();
                     $.CargaTodContr();                    
                    $("#txt_id").val(pares[1]);

                    $("#btn_nuevoProy").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });

    //BOTON GUARDAR CONTRATO
    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        var PvalCont = $("#txt_VaCont").val().split(" ");
        var ValCon = PvalCont[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");

        var PvalAdic = $("#txt_VaAdi").val().split(" ");
        var ValAdic = PvalAdic[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");


        var PvalFin = $("#txt_VaFin").val().split(" ");
        var ValFin = PvalFin[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");

        var PvalEje = $("#txt_VaEje").val().split(" ");
        var ValEje = PvalEje[1].replace(".", "").replace(".", "").replace(".", "").replace(",", ".");

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


        var datos = "txt_Cod=" + $("#txt_Cod").val() + "&CbTiplog=" + $("#CbTiplog").val() + "&DesCbTiplog=" + $("#CbTiplog option:selected").text()
                + "&txt_Nomb=" + $("#txt_Nomb").val() + "&CbContratis=" + $("#CbContratis").val()
                + "&CbContratisDesc=" + $("#CbContratis option:selected").text() + "&txt_Super=" + $("#CbSuper").val() + "&CbSuperDesc=" + $("#CbSuper option:selected").text()
                + "&txt_Inter=" + $("#CbInter").val() + "&CbInterDesc=" + $("#CbInter option:selected").text() + "&ValCon=" + ValCon + "&ValAdic=" + ValAdic + "&ValFin=" + ValFin
                + "&ValEje=" + ValEje + "&txt_Fpago=" + $("#txt_Fpago").val() + "&txt_Durac=" + durCont
                + "&txt_FIni=" + txt_FIni + "&txt_FSusp=" + txt_FSusp + "&txt_FRein=" + txt_FRein
                + "&txt_Prorog=" + Prorrog + "&txt_FFina=" + txt_FFina + "&txt_FReci=" + txt_FReci
                + "&CbProy=" + $("#CbProy").val() + "&CbProyDes=" + $("#CbProy option:selected").text()
                + "&txt_Avance=" + $("#txt_Avance").val() + "&CbEstado=" + $("#CbEstado").val() + "&acc=" + $("#accCont").val() + "&id=" + $("#txt_idCont").val();

        var Alldata = datos + Dat_Img;

        $.ajax({
            type: "POST",
            url: "../Proyecto/GuardarContratoExpre.php",
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
