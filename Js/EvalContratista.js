$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
    $("#Menu_evalCont").addClass("start active open");

    $("#txt_fecha_Eval,#txt_fecha_Reval,#txt_fecha").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    $("#CbEstadoProc,#CbEstado,#CbEstImg,#CbTiemDura,#CbTiemProrog").selectpicker();

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
    var Dat_ResulPresCum = "";
    var Dat_ResulPresEje = "";
    var Dat_ResulPresCal = "";

    var Dat_ResulSumiCum = "";
    var Dat_ResulSumiEje = "";
    var Dat_ResulSumiCal = "";

    var Dat_ResulArreCum = "";
    var Dat_ResulArreEje = "";
    var Dat_ResulArreCal = "";

    var Dat_ResulConsCum = "";
    var Dat_ResulConsEje = "";
    var Dat_ResulConsCal = "";

    var Dat_ResulObraCum = "";
    var Dat_ResulObraEje = "";
    var Dat_ResulObraCal = "";

    var ValCerosPres = "1";
    var ValCerosSum = "1";
    var ValCerosArr = "1";
    var ValCerosCons = "1";
    var ValCerosObra = "1";
    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        Evaluciones: function () {
            var datos = {
                opc: "CargDependencia",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEvaluacion.php",
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

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEvaluacion.php",
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
        ConsuParam: function () {


            var datos = {
                ope: "BusqParaEval"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#PCCO').val(data['PorCO']);
                    $('#PCEC').val(data['PorCE']);
                    $('#PCC').val(data['PorCC']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        addEval: function () {

            if ($("#perm").val() === "n") {
                $('#botones').hide();
                $.Alert("#msg", "No Tiene permisos para Evalular Contratistas", "warning", 'warning');
            }
        },
        editEval: function (cod) {
            $('#acc').val("2");
            $('#txt_id').val(cod);
            $('#botones').show();
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);


            var datos = {
                ope: "BusqEditEval",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {

                    if (data['eval_evaluacion'] === "si") {
                        $("#ck_eval").prop('checked', true);
                    } else {
                        $("#ck_eval").prop('checked', false);
                    }

                    if (data['feval_evaluacion'] === "0000-00-00") {
                        $("#txt_fecha_Eval").val("");
                    } else {
                        $("#txt_fecha_Eval").val(data['feval_evaluacion']);
                    }

                    if (data['reeval_evaluacion'] === "si") {
                        $("#ck_reval").prop('checked', true);
                        $('#acc').val("1");
                    } else {
                        $("#ck_reval").prop('checked', false);
                    }

                    if (data['freeval_evaluacion'] === "0000-00-00") {
                        $("#txt_fecha_Reval").val("");
                    } else {
                        $("#txt_fecha_Reval").val(data['freeval_evaluacion']);
                    }

                    $("#PorCO").val(data['PorCO']);
                    $("#PorCC").val(data['PorCC']);
                    $("#PorCE").val(data['PorCE']);

                    $("#txt_CodCont").val(data['ncont_evaluacion']);
                    $("#txt_IdCont").val(data['idcont_evaluacion']);
                    $("#txt_fecha").val(data['fcont_evaluacion']);
                    $("#txt_Objet").val(data['objcont_evaluacion']);
                    $("#txt_nitcont").val(data['nitcont_evaluacion']);
                    $("#txt_Contra").val(data['nomcont_evaluacion']);
                    $("#txt_fecini").val(data['finicont_evaluacion']);
                    $("#txt_fecfin").val(data['ftercont_evaluacion']);
                    $("#txt_Clase").val(data['clacont_evaluacion']);

                    $("#analisis_cumpli").val(data['analisis_cumpli']);
                    $("#analisis_ejec").val(data['analisis_ejec']);
                    $("#analisis_calidad").val(data['analisis_calidad']);

                    $("#puntPsTot1").val(data['puntPsTot1']);
                    $("#puntPsTot2").val(data['puntPsTot2']);
                    $("#puntPsTot3").val(data['puntPsTot3']);
                    $("#text_PsTotal").val(data['text_PsTotal']);
                    $("#Lab_PromTotalPsTot").html(data['text_PsTotal']);

                    $("#puntSaTot1").val(data['puntSaTot1']);
                    $("#puntSaTot2").val(data['puntSaTot2']);
                    $("#puntSaTot3").val(data['puntSaTot3']);
                    $("#text_SaTotal").val(data['text_SaTotal']);
                    $("#Lab_PromTotalSaTot").html(data['text_SaTotal']);

                    $("#puntCaTot1").val(data['puntCaTot1']);
                    $("#puntCaTot2").val(data['puntCaTot2']);
                    $("#puntCaTot3").val(data['puntCaTot3']);
                    $("#text_CaTotal").val(data['text_CaTotal']);
                    $("#Lab_PromTotalCaTot").html(data['text_CaTotal']);

                    $("#puntCcTot1").val(data['puntCcTot1']);
                    $("#puntCcTot2").val(data['puntCcTot2']);
                    $("#puntCcTot3").val(data['puntCcTot3']);
                    $("#text_CcTotal").val(data['text_CcTotal']);
                    $("#Lab_PromTotalCoTot").html(data['text_CcTotal']);

                    $("#puntCoTot1").val(data['puntCoTot1']);
                    $("#puntCoTot2").val(data['puntCoTot2']);
                    $("#puntCoTot3").val(data['puntCoTot3']);
                    $("#text_CoTotal").val(data['text_CoTotal']);
                    $("#Lab_PromTotalCoTot").html(data['text_CoTotal']);

                    $("#puntPsTot1Prom").val(data['puntPsTot1Prom']);
                    $("#puntPsTot2Prom").val(data['puntPsTot2Prom']);
                    $("#puntPsTot3Prom").val(data['puntPsTot3Prom']);

                    $("#puntSaTot1Prom").val(data['puntSaTot1Prom']);
                    $("#puntSaTot2Prom").val(data['puntSaTot2Prom']);
                    $("#puntSaTot3Prom").val(data['puntSaTot3Prom']);

                    $("#puntCaTot1Prom").val(data['puntCaTot1Prom']);
                    $("#puntCaTot2Prom").val(data['puntCaTot2Prom']);
                    $("#puntCaTot3Prom").val(data['puntCaTot3Prom']);

                    $("#puntCcTot1Prom").val(data['puntCcTot1Prom']);
                    $("#puntCcTot2Prom").val(data['puntCcTot2Prom']);
                    $("#puntCcTot3Prom").val(data['puntCcTot3Prom']);

                    $("#puntCoTot1Prom").val(data['puntCoTot1Prom']);
                    $("#puntCoTot2Prom").val(data['puntCoTot2Prom']);
                    $("#puntCoTot3Prom").val(data['puntCoTot3Prom']);

                    $("#PorCO").val(data['PorCO']);
                    $("#PorCE").val(data['PorCE']);
                    $("#PorCC").val(data['PorCC']);

                    pacla = data['clacont_evaluacion'].split(" - ");
                    if (pacla[0] === "1") {
                        $('#tab_pp2').show();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "2") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').show();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "3") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').show();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "4") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').show();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "5") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').show();
                        $('#tab_pp7').show();
                    }


                    ///CARGA INF. CONT. PRESTACIÓN
                    var cont = data['contPres'];
                    var idPs1 = 1;
                    var idPs2 = 1;
                    var idPs3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contpres'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textPs1" + idPs1).val(parTexPut[0]);
                            $("#puntPs1" + idPs1).val(parTexPut[1]);
                            idPs1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textPs2" + idPs2).val(parTexPut[0]);
                            $("#puntPs2" + idPs2).val(parTexPut[1]);
                            idPs2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textPs3" + idPs3).val(parTexPut[0]);
                            $("#puntPs3" + idPs3).val(parTexPut[1]);
                            idPs3++;
                        }
                    }


                    ///CARGA INF. CONT. SUMINISTRO
                    var cont = data['contSumin'];
                    var idSa1 = 1;
                    var idSa2 = 1;
                    var idSa3 = 1;


                    for (var i = 0; i < cont; i++) {

                        parpunt = data['resul_contSumin'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textSa1" + idSa1).val(parTexPut[0]);
                            $("#puntSa1" + idSa1).val(parTexPut[1]);
                            idSa1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textSa2" + idSa2).val(parTexPut[0]);
                            $("#puntSa2" + idSa2).val(parTexPut[1]);
                            idSa2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textSa3" + idSa3).val(parTexPut[0]);
                            $("#puntSa3" + idSa3).val(parTexPut[1]);
                            idSa3++;
                        }
                    }

                    ///CARGA INF. CONT. ARRENDAMIENTO
                    var cont = data['contArre'];
                    var idCa1 = 1;
                    var idCa2 = 1;
                    var idCa3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contArrend'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textCa1" + idCa1).val(parTexPut[0]);
                            $("#puntCa1" + idCa1).val(parTexPut[1]);
                            idCa1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textCa2" + idCa2).val(parTexPut[0]);
                            $("#puntCa2" + idCa2).val(parTexPut[1]);
                            idCa2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textCa3" + idCa3).val(parTexPut[0]);
                            $("#puntCa3" + idCa3).val(parTexPut[1]);
                            idCa3++;
                        }
                    }
                    ///CARGA INF. CONT. ARRENDAMIENTO
                    var cont = data['contConsul'];
                    var idCc1 = 1;
                    var idCc2 = 1;
                    var idCc3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contConsult'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textCc1" + idCc1).val(parTexPut[0]);
                            $("#puntCc1" + idCc1).val(parTexPut[1]);
                            idCc1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textCc2" + idCc2).val(parTexPut[0]);
                            $("#puntCc2" + idCc2).val(parTexPut[1]);
                            idCc2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textCc3" + idCc3).val(parTexPut[0]);
                            $("#puntCc3" + idCc3).val(parTexPut[1]);
                            idCc3++;
                        }
                    }
                    ///CARGA INF. CONT. OBRA
                    var cont = data['contObra'];
                    var idCo1 = 1;
                    var idCo2 = 1;
                    var idCo3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contObra'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textCo1" + idCo1).val(parTexPut[0]);
                            $("#puntCo1" + idCo1).val(parTexPut[1]);
                            idCo1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textCo2" + idCo2).val(parTexPut[0]);
                            $("#puntCo2" + idCo2).val(parTexPut[1]);
                            idCo2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textCo3" + idCo3).val(parTexPut[0]);
                            $("#puntCo3" + idCo3).val(parTexPut[1]);
                            idCo3++;
                        }
                    }



                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Evaluación</a>");


        },
        VerEval: function (cod) {
            $('#acc').val("2");
            $('#txt_id').val(cod);

            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', true);


            var datos = {
                ope: "BusqEditEval",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data['eval_evaluacion'] === "si") {
                        $("#ck_eval").prop('checked', true);
                    } else {
                        $("#ck_eval").prop('checked', false);
                    }

                    if (data['feval_evaluacion'] === "0000-00-00") {
                        $("#txt_fecha_Eval").val("");
                    } else {
                        $("#txt_fecha_Eval").val(data['feval_evaluacion']);
                    }

                    if (data['reeval_evaluacion'] === "si") {
                        $("#ck_reval").prop('checked', true);
                    } else {
                        $("#ck_reval").prop('checked', false);
                    }

                    if (data['freeval_evaluacion'] === "0000-00-00") {
                        $("#txt_fecha_Reval").val("");
                    } else {
                        $("#txt_fecha_Reval").val(data['freeval_evaluacion']);
                    }

                    $("#txt_CodCont").val(data['ncont_evaluacion']);
                    $("#txt_IdCont").val(data['idcont_evaluacion']);
                    $("#txt_fecha").val(data['fcont_evaluacion']);
                    $("#txt_Objet").val(data['objcont_evaluacion']);
                    $("#txt_nitcont").val(data['nitcont_evaluacion']);
                    $("#txt_Contra").val(data['nomcont_evaluacion']);
                    $("#txt_fecini").val(data['finicont_evaluacion']);
                    $("#txt_fecfin").val(data['ftercont_evaluacion']);
                    $("#txt_Clase").val(data['clacont_evaluacion']);

                    $("#analisis_cumpli").val(data['analisis_cumpli']);
                    $("#analisis_ejec").val(data['analisis_ejec']);
                    $("#analisis_calidads").val(data['analisis_calidads']);

                    $("#puntPsTot1").val(data['puntPsTot1']);
                    $("#puntPsTot2").val(data['puntPsTot2']);
                    $("#puntPsTot3").val(data['puntPsTot3']);
                    $("#text_PsTotal").val(data['text_PsTotal']);
                    $("#Lab_PromTotalPsTot").html(data['text_PsTotal']);

                    $("#puntSaTot1").val(data['puntSaTot1']);
                    $("#puntSaTot2").val(data['puntSaTot2']);
                    $("#puntSaTot3").val(data['puntSaTot3']);
                    $("#text_SaTotal").val(data['text_SaTotal']);
                    $("#Lab_PromTotalSaTot").html(data['text_SaTotal']);

                    $("#puntCaTot1").val(data['puntCaTot1']);
                    $("#puntCaTot2").val(data['puntCaTot2']);
                    $("#puntCaTot3").val(data['puntCaTot3']);
                    $("#text_CaTotal").val(data['text_CaTotal']);
                    $("#Lab_PromTotalCaTot").html(data['text_CaTotal']);

                    $("#puntCcTot1").val(data['puntCcTot1']);
                    $("#puntCcTot2").val(data['puntCcTot2']);
                    $("#puntCcTot3").val(data['puntCcTot3']);
                    $("#text_CcTotal").val(data['text_CcTotal']);
                    $("#Lab_PromTotalCoTot").html(data['text_CcTotal']);

                    $("#puntCoTot1").val(data['puntCoTot1']);
                    $("#puntCoTot2").val(data['puntCoTot2']);
                    $("#puntCoTot3").val(data['puntCoTot3']);
                    $("#text_CoTotal").val(data['text_CoTotal']);
                    $("#Lab_PromTotalCoTot").html(data['text_CoTotal']);

                    $("#puntPsTot1Prom").val(data['puntPsTot1Prom']);
                    $("#puntPsTot2Prom").val(data['puntPsTot2Prom']);
                    $("#puntPsTot3Prom").val(data['puntPsTot3Prom']);

                    $("#puntSaTot1Prom").val(data['puntSaTot1Prom']);
                    $("#puntSaTot2Prom").val(data['puntSaTot2Prom']);
                    $("#puntSaTot3Prom").val(data['puntSaTot3Prom']);

                    $("#puntCaTot1Prom").val(data['puntCaTot1Prom']);
                    $("#puntCaTot2Prom").val(data['puntCaTot2Prom']);
                    $("#puntCaTot3Prom").val(data['puntCaTot3Prom']);

                    $("#puntCcTot1Prom").val(data['puntCcTot1Prom']);
                    $("#puntCcTot2Prom").val(data['puntCcTot2Prom']);
                    $("#puntCcTot3Prom").val(data['puntCcTot3Prom']);

                    $("#puntCoTot1Prom").val(data['puntCoTot1Prom']);
                    $("#puntCoTot2Prom").val(data['puntCoTot2Prom']);
                    $("#puntCoTot3Prom").val(data['puntCoTot3Prom']);

                    pacla = data['clacont_evaluacion'].split(" - ");
                    if (pacla[0] === "1") {
                        $('#tab_pp2').show();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "2") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').show();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "3") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').show();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "4") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').show();
                        $('#tab_pp6').hide();
                        $('#tab_pp7').show();
                    } else if (pacla[0] === "5") {
                        $('#tab_pp2').hide();
                        $('#tab_pp3').hide();
                        $('#tab_pp4').hide();
                        $('#tab_pp5').hide();
                        $('#tab_pp6').show();
                        $('#tab_pp7').show();
                    }


                    ///CARGA INF. CONT. PRESTACIÓN
                    var cont = data['contPres'];
                    var idPs1 = 1;
                    var idPs2 = 1;
                    var idPs3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contpres'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textPs1" + idPs1).val(parTexPut[0]);
                            $("#puntPs1" + idPs1).val(parTexPut[1]);
                            idPs1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textPs2" + idPs2).val(parTexPut[0]);
                            $("#puntPs2" + idPs2).val(parTexPut[1]);
                            idPs2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textPs3" + idPs3).val(parTexPut[0]);
                            $("#puntPs3" + idPs3).val(parTexPut[1]);
                            idPs3++;
                        }
                    }


                    ///CARGA INF. CONT. SUMINISTRO
                    var cont = data['contSumin'];
                    var idSa1 = 1;
                    var idSa2 = 1;
                    var idSa3 = 1;


                    for (var i = 0; i < cont; i++) {

                        parpunt = data['resul_contSumin'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textSa1" + idSa1).val(parTexPut[0]);
                            $("#puntSa1" + idSa1).val(parTexPut[1]);
                            idSa1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textSa2" + idSa2).val(parTexPut[0]);
                            $("#puntSa2" + idSa2).val(parTexPut[1]);
                            idSa2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textSa3" + idSa3).val(parTexPut[0]);
                            $("#puntSa3" + idSa3).val(parTexPut[1]);
                            idSa3++;
                        }
                    }

                    ///CARGA INF. CONT. ARRENDAMIENTO
                    var cont = data['contArre'];
                    var idCa1 = 1;
                    var idCa2 = 1;
                    var idCa3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contArrend'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textCa1" + idCa1).val(parTexPut[0]);
                            $("#puntCa1" + idCa1).val(parTexPut[1]);
                            idCa1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textCa2" + idCa2).val(parTexPut[0]);
                            $("#puntCa2" + idCa2).val(parTexPut[1]);
                            idCa2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textCa3" + idCa3).val(parTexPut[0]);
                            $("#puntCa3" + idCa3).val(parTexPut[1]);
                            idCa3++;
                        }
                    }
                    ///CARGA INF. CONT. ARRENDAMIENTO
                    var cont = data['contConsul'];
                    var idCc1 = 1;
                    var idCc2 = 1;
                    var idCc3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contConsult'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textCc1" + idCc1).val(parTexPut[0]);
                            $("#puntCc1" + idCc1).val(parTexPut[1]);
                            idCc1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textCc2" + idCc2).val(parTexPut[0]);
                            $("#puntCc2" + idCc2).val(parTexPut[1]);
                            idCc2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textCc3" + idCc3).val(parTexPut[0]);
                            $("#puntCc3" + idCc3).val(parTexPut[1]);
                            idCc3++;
                        }
                    }
                    ///CARGA INF. CONT. OBRA
                    var cont = data['contObra'];
                    var idCo1 = 1;
                    var idCo2 = 1;
                    var idCo3 = 1;

                    for (var i = 0; i < cont; i++) {
                        parpunt = data['resul_contObra'].split(";");
                        parTexPut = parpunt[i].split("//");
                        partipcri = parTexPut[0].split("-");

                        if (partipcri[1] === "Cumplimiento") {
                            $("#textCo1" + idCo1).val(parTexPut[0]);
                            $("#puntCo1" + idCo1).val(parTexPut[1]);
                            idCo1++;
                        }
                        if (partipcri[1] === "Ejecución") {
                            $("#textCo2" + idCo2).val(parTexPut[0]);
                            $("#puntCo2" + idCo2).val(parTexPut[1]);
                            idCo2++;
                        }
                        if (partipcri[1] === "Calidad") {
                            $("#textCo3" + idCo3).val(parTexPut[0]);
                            $("#puntCo3" + idCo3).val(parTexPut[1]);
                            idCo3++;
                        }
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Evaluación</a>");


        },
        deletEval: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarEvaluacion.php",
                    data: datos,
                    success: function (data) {
                        var pares = data.split("/");
                        if (trimAll(pares[0]) === "bien") {
                            $.Alert("#msg", "Operación Realizada Exitosamente...", "success");
                            $.Evaluciones();
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
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEvaluacion.php",
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

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEvaluacion.php",
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
                url: "../Paginadores/PagEvaluacion.php",
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

        Validar: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_CodCont";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_numcon").addClass("has-error");
            } else {
                $("#From_numcon").removeClass("has-error");
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
                $("#ventanaContra").modal("show");
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
                url: "../Paginadores/PagContVent.php",
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
        SelContra: function (par) {

            var ppar = par.split("//");
            parcont = ppar[4].split(" - ");

            var datos = {
                ope: "BusEvalCont",
                idcon: ppar[1],
                idcont: parcont[0]
            };

            var VerEvl = "";

            $.ajax({
                type: "POST",
                async: false,
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    VerEvl = data['Eval'];

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            if (VerEvl === "NO") {
                $("#txt_IdCont").val(ppar[0]);
                $("#txt_CodCont").val(ppar[1]);
                $("#txt_Objet").val(ppar[2]);

                $("#txt_Contra").val(parcont[1]);
                $("#txt_nitcont").val(parcont[0]);
                $("#txt_Clase").val(ppar[3]);
                $("#txt_fecini").val(ppar[5]);
                $("#txt_fecfin").val(ppar[6]);
                $("#txt_fecha").val(ppar[7]);


                pacla = ppar[3].split(" - ");
                if (pacla[0] === "1") {
                    $('#tab_pp2').show();
                    $('#tab_pp3').hide();
                    $('#tab_pp4').hide();
                    $('#tab_pp5').hide();
                    $('#tab_pp6').hide();
                    $('#tab_pp7').show();
                } else if (pacla[0] === "2") {
                    $('#tab_pp2').hide();
                    $('#tab_pp3').show();
                    $('#tab_pp4').hide();
                    $('#tab_pp5').hide();
                    $('#tab_pp6').hide();
                    $('#tab_pp7').show();
                } else if (pacla[0] === "3") {
                    $('#tab_pp2').hide();
                    $('#tab_pp3').hide();
                    $('#tab_pp4').show();
                    $('#tab_pp5').hide();
                    $('#tab_pp6').hide();
                    $('#tab_pp7').show();
                } else if (pacla[0] === "4") {
                    $('#tab_pp2').hide();
                    $('#tab_pp3').hide();
                    $('#tab_pp4').hide();
                    $('#tab_pp5').show();
                    $('#tab_pp6').hide();
                    $('#tab_pp7').show();
                } else if (pacla[0] === "5") {
                    $('#tab_pp2').hide();
                    $('#tab_pp3').hide();
                    $('#tab_pp4').hide();
                    $('#tab_pp5').hide();
                    $('#tab_pp6').show();
                    $('#tab_pp7').show();
                }
                $("#tcont").val(pacla[0]);


                $("#ventanaContra").modal("hide");
            } else {
                if (confirm("Este Contrattista ya ha sido Evaluado con este Contrato. Desea realizar una Reevaluación?")) {
                    $.editEval(VerEvl);

                    $('#ck_eval').prop('checked', false);
                    $('#ck_reval').prop('checked', true);
                    $("#ventanaContra").modal("hide");

                }


            }






        },
        checktipeval: function (val) {
            if (val === "eva") {
                $("#ck_eval").prop('checked', true);
                $("#ck_reval").prop('checked', false);
                $("#txt_fecha_Reval").val("");

            } else {
                $('#acc').val("1");
                $("#ck_reval").prop('checked', true);
                $("#ck_eval").prop('checked', false);
                $("#txt_fecha_Eval").val("");
            }


        },
        VerParCal: function () {

        },
        ///Calculo Prestación de Servicios  
        CalPromPs1: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }


            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {

                valTot = parseInt($("#puntPs11").val()) + parseInt($("#puntPs12").val()) + parseInt($("#puntPs13").val());
                valAct = valTot / 3;
                valAct = valAct.toFixed(2);
                var PorCO = parseFloat($("#PorCO").val() / 100);
                PorCO = valAct * PorCO;
                PorCO = PorCO.toFixed(2);

                $("#puntPsTot1Prom").val(PorCO);
                $("#puntPsTot1").val(valAct);


                valGenAct = parseFloat($("#puntPsTot1Prom").val()) + parseFloat($("#puntPsTot2Prom").val()) + parseFloat($("#puntPsTot3Prom").val());

                $("#text_PsTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalPsTot").html(valGenAct.toFixed(2));

            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }



        },
        CalPromPs2: function (id) {

            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {

                valTot = parseInt($("#puntPs21").val()) + parseInt($("#puntPs22").val()) + parseInt($("#puntPs23").val()) + parseInt($("#puntPs24").val()) + parseInt($("#puntPs25").val()) + parseInt($("#puntPs26").val()) + parseInt($("#puntPs27").val()) + parseInt($("#puntPs28").val()) + parseInt($("#puntPs29").val()) + parseInt($("#puntPs210").val());
                valAct = valTot / 10;

                $("#puntPsTot2").val(valAct.toFixed(2));
                var PorCE = parseFloat($("#PorCE").val() / 100);
                PorCE = valAct * PorCE;
                PorCE = PorCE.toFixed(2);

                $("#puntPsTot2Prom").val(PorCE);

                valGenAct = parseFloat($("#puntPsTot1Prom").val()) + parseFloat($("#puntPsTot2Prom").val()) + parseFloat($("#puntPsTot3Prom").val());

                $("#text_PsTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalPsTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }

        },
        CalPromPs3: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {
                valTot = parseInt($("#puntPs31").val()) + parseInt($("#puntPs32").val()) + parseInt($("#puntPs33").val()) + parseInt($("#puntPs34").val()) + parseInt($("#puntPs35").val());
                valAct = valTot / 5;
                $("#puntPsTot3").val(valAct.toFixed(2));
                var PorCC = parseFloat($("#PorCC").val() / 100);
                PorCC = valAct * PorCC;
                PorCC = PorCC.toFixed(2);

                $("#puntPsTot3Prom").val(PorCC);

                valGenAct = parseFloat($("#puntPsTot1Prom").val()) + parseFloat($("#puntPsTot2Prom").val()) + parseFloat($("#puntPsTot3Prom").val());
                $("#text_PsTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalPsTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");

                return;
            }

        },
        ///Suministro y Adquisición
        CalPromSa1: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {

                valTot = parseInt($("#puntSa11").val()) + parseInt($("#puntSa12").val()) + parseInt($("#puntSa13").val()) + parseInt($("#puntSa14").val());
                valAct = valTot / 4;
                valAct = valAct.toFixed(2);
                var PorCO = parseFloat($("#PorCO").val() / 100);
                PorCO = valAct * PorCO;
                PorCO = PorCO.toFixed(2);

                $("#puntSaTot1Prom").val(PorCO);
                $("#puntSaTot1").val(valAct);


                valGenAct = parseFloat($("#puntSaTot1Prom").val()) + parseFloat($("#puntSaTot2Prom").val()) + parseFloat($("#puntSaTot3Prom").val());

                $("#text_SaTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalSaTot").html(valGenAct.toFixed(2));

            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }



        },
        CalPromSa2: function (id) {

            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {

                valTot = parseInt($("#puntSa21").val()) + parseInt($("#puntSa22").val()) + parseInt($("#puntSa23").val()) + parseInt($("#puntSa24").val()) + parseInt($("#puntSa25").val()) + parseInt($("#puntSa26").val());
                valAct = valTot / 6;
                $("#puntSaTot2").val(valAct.toFixed(2));
                var PorCE = parseFloat($("#PorCE").val() / 100);

                PorCE = valAct * PorCE;
                PorCE = PorCE.toFixed(2);

                $("#puntSaTot2Prom").val(PorCE);

                valGenAct = parseFloat($("#puntSaTot1Prom").val()) + parseFloat($("#puntSaTot2Prom").val()) + parseFloat($("#puntSaTot3Prom").val());

                $("#text_SaTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalSaTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }

        },
        CalPromSa3: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {
                valTot = parseInt($("#puntSa31").val()) + parseInt($("#puntSa32").val()) + parseInt($("#puntSa33").val());
                valAct = valTot / 3;
                $("#puntSaTot3").val(valAct.toFixed(2));
                var PorCC = parseFloat($("#PorCC").val() / 100);
                PorCC = valAct * PorCC;
                PorCC = PorCC.toFixed(2);

                $("#puntSaTot3Prom").val(PorCC);

                valGenAct = parseFloat($("#puntSaTot1Prom").val()) + parseFloat($("#puntSaTot2Prom").val()) + parseFloat($("#puntSaTot2Prom").val());

                $("#text_SaTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalSaTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");

                return;
            }

        },
        ///Calculo contrato de Arriendo 
        CalPromCa1: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {

                valTot = parseInt($("#puntCa11").val()) + parseInt($("#puntCa12").val()) + parseInt($("#puntCa13").val());
                valAct = valTot / 3;
                valAct = valAct.toFixed(2);
                var PorCO = parseFloat($("#PorCO").val() / 100);
                PorCO = valAct * PorCO;
                PorCO = PorCO.toFixed(2);

                $("#puntCaTot1Prom").val(PorCO);
                $("#puntCaTot1").val(valAct);


                valGenAct = parseFloat($("#puntCaTot1Prom").val()) + parseFloat($("#puntCaTot2Prom").val()) + parseFloat($("#puntCaTot3Prom").val());

                $("#text_CaTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCaTot").html(valGenAct.toFixed(2));

            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }



        },
        CalPromCa2: function (id) {

            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {

                valTot = parseInt($("#puntCa21").val()) + parseInt($("#puntCa22").val()) + parseInt($("#puntCa23").val());
                valAct = valTot / 3;
                $("#puntCaTot2").val(valAct.toFixed(2));
                var PorCE = parseFloat($("#PorCE").val() / 100);

                PorCE = valAct * PorCE;
                PorCE = PorCE.toFixed(2);

                $("#puntCaTot2Prom").val(PorCE);

                valGenAct = parseFloat($("#puntCaTot1Prom").val()) + parseFloat($("#puntCaTot2Prom").val()) + parseFloat($("#puntCaTot3Prom").val());
                $("#text_CaTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCaTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }

        },
        CalPromCa3: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {
                valTot = parseInt($("#puntCa31").val()) + parseInt($("#puntCa32").val()) + parseInt($("#puntCa33").val());
                valAct = valTot / 3;
                $("#puntCaTot3").val(valAct.toFixed(2));
                var PorCC = parseFloat($("#PorCC").val() / 100);
                PorCC = valAct * PorCC;
                PorCC = PorCC.toFixed(2);

                $("#puntCaTot3Prom").val(PorCC);
                valGenAct = parseFloat($("#puntCaTot1Prom").val()) + parseFloat($("#puntCaTot2Prom").val()) + parseFloat($("#puntCaTot3Prom").val());
                $("#text_CaTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCaTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");

                return;
            }

        },
        ///////////
        CalPromCc1: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {
                valTot = parseInt($("#puntCc11").val()) + parseInt($("#puntCc12").val()) + parseInt($("#puntCc13").val()) + parseInt($("#puntCc14").val()) + parseInt($("#puntCc15").val());
                valAct = valTot / 5;

                var PorCO = parseFloat($("#PorCO").val() / 100);
                PorCO = valAct * PorCO;
                PorCO = PorCO.toFixed(2);
                $("#puntCcTot1Prom").val(PorCO);
                $("#puntCcTot1").val(valAct.toFixed(2));

                valGenAct = parseFloat($("#puntCcTot1Prom").val()) + parseFloat($("#puntCcTot2Prom").val()) + parseFloat($("#puntCcTot3Prom").val());
                $("#text_CcTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCcTot").html(valGenAct.toFixed(2));
            } else {

                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }

        },
        CalPromCc2: function (id) {

            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {
                valTot = parseInt($("#puntCc21").val()) + parseInt($("#puntCc22").val()) + parseInt($("#puntCc23").val()) + parseInt($("#puntCc24").val()) + parseInt($("#puntCc25").val());
                valAct = valTot / 5;

                var PorCE = parseFloat($("#PorCE").val() / 100);

                PorCE = valAct * PorCE;
                PorCE = PorCE.toFixed(2);
                $("#puntCcTot2").val(valAct.toFixed(2));
                $("#puntCcTot2Prom").val(PorCE);

                valGenAct = parseFloat($("#puntCcTot1Prom").val()) + parseFloat($("#puntCcTot2Prom").val()) + parseFloat($("#puntCcTot3Prom").val());

                $("#text_CcTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCcTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }

        },
        CalPromCc3: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5" || $("#" + id).val() === "0") {
                valTot = parseInt($("#puntCc31").val()) + parseInt($("#puntCc32").val()) + parseInt($("#puntCc33").val()) + parseInt($("#puntCc34").val());
                valAct = valTot / 4;
                var PorCC = parseFloat($("#PorCC").val() / 100);
                PorCC = valAct * PorCC;
                PorCC = PorCC.toFixed(2);
                $("#puntCcTot3").val(valAct.toFixed(2));
                $("#puntCcTot3Prom").val(PorCC);

                valGenAct = parseFloat($("#puntCcTot1Prom").val()) + parseFloat($("#puntCcTot2Prom").val()) + parseFloat($("#puntCcTot3Prom").val());

                $("#text_CcTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCcTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                return;
            }

        },
        ///////////
        CalPromCo1: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
                $("#" + id).focus();
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5") {
                valTot = parseInt($("#puntCo11").val()) + parseInt($("#puntCo12").val()) + parseInt($("#puntCo13").val()) + parseInt($("#puntCo14").val()) + parseInt($("#puntCo15").val());
                valAct = valTot / 5;
                var PorCO = parseFloat($("#PorCO").val() / 100);
                PorCO = valAct * PorCO;
                PorCO = PorCO.toFixed(2);
                $("#puntCoTot1Prom").val(PorCO);
                $("#puntCoTot1").val(valAct.toFixed(2));
//                alert($("#puntCoTot1Prom").val() + '-' + $("#puntCoTot2Prom").val() + '-' + $("#puntCoTot3Prom").val());
                valGenAct = parseFloat($("#puntCoTot1Prom").val()) + parseFloat($("#puntCoTot2Prom").val()) + parseFloat($("#puntCoTot3Prom").val());


                $("#text_CoTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCoTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                $("#" + id).focus();
                return;

            }

        },
        CalPromCo2: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5") {
                valTot = parseInt($("#puntCo21").val()) + parseInt($("#puntCo22").val()) + parseInt($("#puntCo23").val()) + parseInt($("#puntCo24").val()) + parseInt($("#puntCo25").val());
                valAct = valTot / 5;
                var PorCE = parseFloat($("#PorCE").val() / 100);

                PorCE = valAct * PorCE;
                PorCE = PorCE.toFixed(2);
                $("#puntCoTot2").val(valAct.toFixed(2));
                $("#puntCoTot2Prom").val(PorCE);

                valGenAct = parseFloat($("#puntCoTot1Prom").val()) + parseFloat($("#puntCoTot2Prom").val()) + parseFloat($("#puntCoTot3Prom").val());

                $("#text_CoTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCoTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                $("#" + id).focus();
                return;
            }

        },
        CalPromCo3: function (id) {
            if ($("#" + id).val() === "" || $("#" + id).val() === " ") {
                $("#" + id).val("0");
            }

            if ($("#" + id).val() === "2" || $("#" + id).val() === "3" || $("#" + id).val() === "4" || $("#" + id).val() === "5") {
                valTot = parseInt($("#puntCo31").val()) + parseInt($("#puntCo32").val()) + parseInt($("#puntCo33").val()) + parseInt($("#puntCo34").val()) + parseInt($("#puntCo35").val()) + parseInt($("#puntCo36").val()) + parseInt($("#puntCo37").val());
                valAct = valTot / 7;

                var PorCC = parseFloat($("#PorCC").val() / 100);
                PorCC = valAct * PorCC;
                PorCC = PorCC.toFixed(2);

                $("#puntCoTot3").val(valAct.toFixed(2));
                $("#puntCoTot3Prom").val(PorCC);

                valGenAct = parseFloat($("#puntCoTot1Prom").val()) + parseFloat($("#puntCoTot2Prom").val()) + parseFloat($("#puntCoTot3Prom").val());

                $("#text_CoTotal").val(valGenAct.toFixed(2));
                $("#Lab_PromTotalCoTot").html(valGenAct.toFixed(2));
            } else {
                $("#" + id).val("0");
                $.Alert("#msg", "No pertenece a un Puntaje de Calificación, Verifique...", "warning", "warning");
                $("#" + id).focus();
                return;
            }

        },
        Dta_ResulPres: function () {
            Dat_ResulPresCum = "";
            for (var i = 1; i < 4; i++) {
                if ($("#puntPs1" + i).val() === "0") {
                    ValCerosPres = "0";
                }
                Dat_ResulPresCum += "&textPs1" + i + "=" + $("#textPs1" + i).val() + "&puntPs1" + i + "=" + $("#puntPs1" + i).val();
            }

            Dat_ResulPresEje = "";
            for (var i = 1; i < 11; i++) {
                if ($("#puntPs2" + i).val() === "0") {
                    ValCerosPres = "0";
                }
                Dat_ResulPresEje += "&textPs2" + i + "=" + $("#textPs2" + i).val() + "&puntPs2" + i + "=" + $("#puntPs2" + i).val();
            }

            Dat_ResulPresCal = "";
            for (var i = 1; i < 6; i++) {
                if ($("#puntPs3" + i).val() === "0") {
                    ValCerosPres = "0";
                }
                Dat_ResulPresCal += "&textPs3" + i + "=" + $("#textPs3" + i).val() + "&puntPs3" + i + "=" + $("#puntPs3" + i).val();
            }
        },
        ///////////
        Dta_ResulSumi: function () {

            Dat_ResulSumiCum = "";
            for (var i = 1; i < 5; i++) {
                if ($("#puntSa1" + i).val() === "0") {
                    ValCerosSum = "0";
                }
                Dat_ResulSumiCum += "&textSa1" + i + "=" + $("#textSa1" + i).val() + "&puntSa1" + i + "=" + $("#puntSa1" + i).val();
            }

            Dat_ResulSumiEje = "";
            for (var i = 1; i < 7; i++) {
                if ($("#puntSa2" + i).val() === "0") {
                    ValCerosSum = "0";
                }
                Dat_ResulSumiEje += "&textSa2" + i + "=" + $("#textSa2" + i).val() + "&puntSa2" + i + "=" + $("#puntSa2" + i).val();

            }

            Dat_ResulSumiCal = "";
            for (var i = 1; i < 4; i++) {
                if ($("#puntSa3" + i).val() === "0") {
                    ValCerosSum = "0";
                }
                Dat_ResulSumiCal += "&textSa3" + i + "=" + $("#textSa3" + i).val() + "&puntSa3" + i + "=" + $("#puntSa3" + i).val();

            }
        },
        ///////////
        Dta_ResulArre: function () {

            Dat_ResulArreCum = "";
            for (var i = 1; i < 4; i++) {
                if ($("#puntCa1" + i).val() === "0") {
                    ValCerosArr = "0";
                }
                Dat_ResulArreCum += "&textCa1" + i + "=" + $("#textCa1" + i).val() + "&puntCa1" + i + "=" + $("#puntCa1" + i).val();

            }

            Dat_ResulArreEje = "";
            for (var i = 1; i < 4; i++) {
                if ($("#puntCa2" + i).val() === "0") {
                    ValCerosArr = "0";
                }
                Dat_ResulArreEje += "&textCa2" + i + "=" + $("#textCa2" + i).val() + "&puntCa2" + i + "=" + $("#puntCa2" + i).val();

            }

            Dat_ResulArreCal = "";
            for (var i = 1; i < 4; i++) {
                if ($("#puntCa3" + i).val() === "0") {
                    ValCerosArr = "0";
                }
                Dat_ResulArreCal += "&textCa3" + i + "=" + $("#textCa3" + i).val() + "&puntCa3" + i + "=" + $("#puntCa3" + i).val();

            }
        },
        ///////////
        Dta_ResulCons: function () {

            Dat_ResulConsCum = "";
            for (var i = 1; i < 6; i++) {
                if ($("#puntCc1" + i).val() === "0") {
                    ValCerosCons = "0";
                }
                Dat_ResulConsCum += "&textCc1" + i + "=" + $("#textCc1" + i).val() + "&puntCc1" + i + "=" + $("#puntCc1" + i).val();

            }

            Dat_ResulConsEje = "";
            for (var i = 1; i < 6; i++) {
                if ($("#puntCc2" + i).val() === "0") {
                    ValCerosCons = "0";
                }
                Dat_ResulConsEje += "&textCc2" + i + "=" + $("#textCc2" + i).val() + "&puntCc2" + i + "=" + $("#puntCc2" + i).val();

            }

            Dat_ResulConsCal = "";
            for (var i = 1; i < 5; i++) {
                if ($("#puntCc3" + i).val() === "0") {
                    ValCerosCons = "0";
                }
                Dat_ResulConsCal += "&textCc3" + i + "=" + $("#textCc3" + i).val() + "&puntCc3" + i + "=" + $("#puntCc3" + i).val();

            }
        },
        ///////////
        Dta_ResulObra: function () {

            Dat_ResulObraCum = "";
            for (var i = 1; i < 6; i++) {
                if ($("#puntCo1" + i).val() === "0") {
                    ValCerosObra = "0";
                }
                Dat_ResulObraCum += "&textCo1" + i + "=" + $("#textCo1" + i).val() + "&puntCo1" + i + "=" + $("#puntCo1" + i).val();

            }

            Dat_ResulObraEje = "";
            for (var i = 1; i < 6; i++) {
                if ($("#puntCo2" + i).val() === "0") {
                    ValCerosObra = "0";
                }
                Dat_ResulObraEje += "&textCo2" + i + "=" + $("#textCo2" + i).val() + "&puntCo2" + i + "=" + $("#puntCo2" + i).val();

            }

            Dat_ResulObraCal = "";
            for (var i = 1; i < 8; i++) {
                if ($("#puntCo3" + i).val() === "0") {
                    ValCerosObra = "0";
                }
                Dat_ResulObraCal += "&textCo3" + i + "=" + $("#textCo3" + i).val() + "&puntCo3" + i + "=" + $("#puntCo3" + i).val();

            }
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
        }

    });
    //======FUNCIONES========\\
    $.Evaluciones();
    $.ConsuParam();


    $("#btn_volver").on("click", function () {
        window.location.href = "../Administracion.php";

    });


    $("#btn_paraCont").on("click", function () {
        if ($("#PorCO").val() === "" || $("#PorCE").val() === "" || $("#PorCC").val() === "") {
            $.Alert("#msg", "Ingrese los Parametros de Evaluación del Contratista", "warning", "warning");

        } else {
            var PCCO = $("#PorCO").val();
            var PCEC = $("#PorCE").val();
            var PCC = $("#PorCC").val();
            var valtot = parseFloat(PCCO) + parseFloat(PCEC) + parseFloat(PCC);

            if (valtot !== 100) {
                $.Alert("#msg", "El Porcentaje de parametros de Evaluación no debe ser mayor ni menor a 100%...", "warning", "warning");
                return;
            } else {
                $.Load_ventana('1');
            }

        }

    });




    $("#btn_nuevo").on("click", function () {
        $('#acc').val("1");

        $("#ck_eval").prop('checked', false);
        $("#txt_fecha_Eval").val("");
        $("#ck_reval").prop('checked', false);
        $("#txt_fecha_Reval").val("");
        $("#txt_CodCont").val("");
        $("#txt_IdCont").val("");
        $("#txt_fecha").val("");
        $("#txt_Objet").val("");
        $("#txt_Contra").val("");
        $("#txt_nitcont").val("");
        $("#txt_fecini").val("");
        $("#txt_fecfin").val("");
        $("#txt_Clase").val("");
        $("#txt_Analisis").val("");

        $("#puntSa11").val("0");
        $("#puntSa12").val("0");
        $("#puntSa13").val("0");
        $("#puntSa14").val("0");
        $("#puntSaTot1").val("0");

        $("#puntSa21").val("0");
        $("#puntSa22").val("0");
        $("#puntSa23").val("0");
        $("#puntSa24").val("0");
        $("#puntSa25").val("0");
        $("#puntSa26").val("0");
        $("#puntSaTot2").val("0");

        $("#puntSa31").val("0");
        $("#puntSa32").val("0");
        $("#puntSa33").val("0");

        $("#puntSaTot3").val("0");

        $("#text_SaTotal").val("0");
        $("#Lab_PromTotalSaTot").html("0");


        $("#puntCc11").val("0");
        $("#puntCc12").val("0");
        $("#puntCc13").val("0");
        $("#puntCc14").val("0");
        $("#puntCc15").val("0");
        $("#puntCcTot1").val("0");


        $("#puntCc21").val("0");
        $("#puntCc22").val("0");
        $("#puntCc23").val("0");
        $("#puntCc24").val("0");
        $("#puntCc25").val("0");
        $("#puntCcTot2").val("0");


        $("#puntCc31").val("0");
        $("#puntCc32").val("0");
        $("#puntCc33").val("0");
        $("#puntCc34").val("0");
        $("#puntCcTot3").val("0");

        $("#text_CcTotal").val("0");
        $("#Lab_PromTotalCcTot").html("0");



        $("#puntCo11").val("0");
        $("#puntCo12").val("0");
        $("#puntCo13").val("0");
        $("#puntCo14").val("0");
        $("#puntCo15").val("0");
        $("#puntCoTot1").val("0");


        $("#puntCo21").val("0");
        $("#puntCo22").val("0");
        $("#puntCo23").val("0");
        $("#puntCo24").val("0");
        $("#puntCo25").val("0");
        $("#puntCoTot2").val("0");


        $("#puntCo31").val("0");
        $("#puntCo32").val("0");
        $("#puntCo33").val("0");
        $("#puntCo34").val("0");
        $("#puntCo35").val("0");
        $("#puntCo36").val("0");
        $("#puntCo37").val("0");
        $("#puntCoTot3").val("0");


        $("#text_CoTotal").val("0");
        $("#Lab_PromTotalCoTot").html("0");

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);


        for (var i = 2; i <= 5; i++) {
            $("#tab_" + i).removeClass("active in");
            $("#tab_pp" + i).removeClass("active in");
        }

        $("#tab_1").addClass("active in");
        $("#tab_pp1").addClass("active in");

        $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Realizar Evaluación</a>");

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);
    });

    $("#btn_cancelar").on("click", function () {
        if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
            $('#acc').val("1");

            $("#ck_eval").prop('checked', false);
            $("#txt_fecha_Eval").val("");
            $("#ck_reval").prop('checked', false);
            $("#txt_fecha_Reval").val("");
            $("#txt_CodCont").val("");
            $("#txt_IdCont").val("");
            $("#txt_fecha").val("");
            $("#txt_Objet").val("");
            $("#txt_Contra").val("");
            $("#txt_nitcont").val("");
            $("#txt_fecini").val("");
            $("#txt_fecfin").val("");
            $("#txt_Clase").val("");
            $("#txt_Analisis").val("");

            $("#puntSa11").val("0");
            $("#puntSa12").val("0");
            $("#puntSa13").val("0");
            $("#puntSa14").val("0");
            $("#puntSaTot1").val("0");

            $("#puntSa21").val("0");
            $("#puntSa22").val("0");
            $("#puntSa23").val("0");
            $("#puntSa24").val("0");
            $("#puntSa25").val("0");
            $("#puntSa26").val("0");
            $("#puntSaTot2").val("0");

            $("#puntSa31").val("0");
            $("#puntSa32").val("0");
            $("#puntSa33").val("0");

            $("#puntSaTot3").val("0");

            $("#text_SaTotal").val("0");
            $("#Lab_PromTotalSaTot").html("0");


            $("#puntCc11").val("0");
            $("#puntCc12").val("0");
            $("#puntCc13").val("0");
            $("#puntCc14").val("0");
            $("#puntCc15").val("0");
            $("#puntCcTot1").val("0");


            $("#puntCc21").val("0");
            $("#puntCc22").val("0");
            $("#puntCc23").val("0");
            $("#puntCc24").val("0");
            $("#puntCc25").val("0");
            $("#puntCcTot2").val("0");


            $("#puntCc31").val("0");
            $("#puntCc32").val("0");
            $("#puntCc33").val("0");
            $("#puntCc34").val("0");
            $("#puntCcTot3").val("0");

            $("#text_CcTotal").val("0");
            $("#Lab_PromTotalCcTot").html("0");



            $("#puntCo11").val("0");
            $("#puntCo12").val("0");
            $("#puntCo13").val("0");
            $("#puntCo14").val("0");
            $("#puntCo15").val("0");
            $("#puntCoTot1").val("0");


            $("#puntCo21").val("0");
            $("#puntCo22").val("0");
            $("#puntCo23").val("0");
            $("#puntCo24").val("0");
            $("#puntCo25").val("0");
            $("#puntCoTot2").val("0");


            $("#puntCo31").val("0");
            $("#puntCo32").val("0");
            $("#puntCo33").val("0");
            $("#puntCo34").val("0");
            $("#puntCo35").val("0");
            $("#puntCo36").val("0");
            $("#puntCo37").val("0");
            $("#puntCoTot3").val("0");


            $("#text_CoTotal").val("0");
            $("#Lab_PromTotalCoTot").html("0");

            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);



            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $("#tab_01").addClass("active in");
            $("#tab_01_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Realizar Evaluación</a>");

        }

    });


    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }


        var TipEvaluacion = "";
        var Eval = "no";
        var Reeval = "no";
        if ($('#ck_eval').prop('checked')) {
            Eval = "si";
            TipEvaluacion = "Evaluación";
        }
        if ($('#ck_reval').prop('checked')) {
            Reeval = 'si';
            TipEvaluacion = "Reevaluación";
        }

        var txt_fecha_Eval = $("#txt_fecha_Eval").val();
        if ($("#txt_fecha_Eval").val() === "") {
            txt_fecha_Eval = "0000-00-00";
        }

        var txt_fecha_Reval = $("#txt_fecha_Reval").val();
        if ($("#txt_fecha_Reval").val() === "") {
            txt_fecha_Reval = "0000-00-00";
        }

        $.Dta_ResulPres();
        $.Dta_ResulSumi();
        $.Dta_ResulArre();
        $.Dta_ResulCons();
        $.Dta_ResulObra();

        var tcont = $("#tcont").val();

        if (tcont === "1") {
            if (ValCerosPres === "0") {
                $.Alert("#msg", "La Evaluacion no debe tener Criterios en 0. Verifique...", "warning", "warning");
                return;
            }
        } else if (tcont === "2") {
            if (ValCerosSum === "0") {
                $.Alert("#msg", "La Evaluacion no debe tener Criterios en 0. Verifique...", "warning", "warning");
                return;
            }
        } else if (tcont === "3") {
            if (ValCerosArr === "0") {
                $.Alert("#msg", "La Evaluacion no debe tener Criterios en 0. Verifique...", "warning", "warning");
                return;
            }
        } else if (tcont === "4") {
            if (ValCerosCons === "0") {
                $.Alert("#msg", "La Evaluacion no debe tener Criterios en 0. Verifique...", "warning", "warning");
                return;
            }
        } else if (tcont === "5") {
            if (ValCerosObra === "0") {
                $.Alert("#msg", "La Evaluacion no debe tener Criterios en 0. Verifique...", "warning", "warning");
                return;
            }
        }


        var datos = "txt_IdCont=" + $("#txt_IdCont").val() + "&txt_CodCont=" + $("#txt_CodCont").val()
                + "&txt_fecha=" + $("#txt_fecha").val() + "&txt_Objet=" + $("#txt_Objet").val()
                + "&txt_Contra=" + $("#txt_Contra").val() + "&txt_nitcont=" + $("#txt_nitcont").val()
                + "&txt_fecini=" + $("#txt_fecini").val() + "&txt_fecfin=" + $("#txt_fecfin").val()
                + "&puntPsTot1=" + $("#puntPsTot1").val() + "&puntPsTot2=" + $("#puntPsTot2").val()
                + "&puntPsTot3=" + $("#puntPsTot3").val() + "&text_PsTotal=" + $("#text_PsTotal").val()
                + "&puntSaTot1=" + $("#puntSaTot1").val() + "&puntSaTot2=" + $("#puntSaTot2").val()
                + "&puntSaTot3=" + $("#puntSaTot3").val() + "&text_SaTotal=" + $("#text_SaTotal").val()
                + "&puntCaTot1=" + $("#puntCaTot1").val() + "&puntCaTot2=" + $("#puntCaTot2").val()
                + "&puntCaTot3=" + $("#puntCaTot3").val() + "&text_CaTotal=" + $("#text_CaTotal").val()
                + "&puntCcTot1=" + $("#puntCcTot1").val() + "&puntCcTot2=" + $("#puntCcTot2").val()
                + "&puntCcTot3=" + $("#puntCcTot3").val() + "&text_CcTotal=" + $("#text_CcTotal").val()
                + "&puntCoTot1=" + $("#puntCoTot1").val() + "&puntCoTot2=" + $("#puntCoTot2").val()
                + "&puntCoTot3=" + $("#puntCoTot3").val() + "&text_CoTotal=" + $("#text_CoTotal").val()
                + "&puntPsTot1Prom=" + $("#puntPsTot1Prom").val() + "&puntPsTot2Prom=" + $("#puntPsTot2Prom").val()
                + "&puntPsTot3Prom=" + $("#puntPsTot3Prom").val() + "&puntSaTot1Prom=" + $("#puntSaTot1Prom").val()
                + "&puntSaTot2Prom=" + $("#puntSaTot2Prom").val() + "&puntSaTot3Prom=" + $("#puntSaTot3Prom").val()
                + "&puntCaTot1Prom=" + $("#puntCaTot1Prom").val() + "&puntCaTot2Prom=" + $("#puntCaTot2Prom").val()
                + "&puntCaTot3Prom=" + $("#puntCaTot3Prom").val() + "&puntCcTot1Prom=" + $("#puntCcTot1Prom").val()
                + "&puntCcTot2Prom=" + $("#puntCcTot2Prom").val() + "&puntCcTot3Prom=" + $("#puntCcTot3Prom").val()
                + "&puntCoTot1Prom=" + $("#puntCoTot1Prom").val() + "&puntCoTot2Prom=" + $("#puntCoTot2Prom").val()
                + "&puntCoTot3Prom=" + $("#puntCoTot3Prom").val()
                + "&txt_Clase=" + $("#txt_Clase").val() + "&TipEvaluacion=" + TipEvaluacion
                + "&txt_fecha_Eval=" + txt_fecha_Eval + "&txt_fecha_Reval=" + txt_fecha_Reval
                + "&Eval=" + Eval + "&Reeval=" + Reeval + "&analisis_cumpli=" + $("#analisis_cumpli").val()
                + "&analisis_ejec=" + $("#analisis_ejec").val() + "&analisis_calidad=" + $("#analisis_calidad").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val() + "&PorCO=" + $("#PorCO").val()
                + "&PorCE=" + $("#PorCE").val() + "&PorCC=" + $("#PorCC").val();


        var Alldata = datos + Dat_ResulPresCum + Dat_ResulPresEje + Dat_ResulPresCal
                + Dat_ResulSumiCum + Dat_ResulSumiEje + Dat_ResulSumiCal
                + Dat_ResulArreCum + Dat_ResulArreEje + Dat_ResulArreCal
                + Dat_ResulConsCum + Dat_ResulConsEje + Dat_ResulConsCal
                + Dat_ResulObraCum + Dat_ResulObraEje + Dat_ResulObraCal;

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarEvaluacion.php",
            data: Alldata,
            success: function (data) {
                var pares = data.split("/");
                if (trimAll(pares[0]) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", 'check');
                    $.Evaluciones();
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
