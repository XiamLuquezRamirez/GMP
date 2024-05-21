$(document).ready(function () {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_user").addClass("start active open");
    $("#menu_ges_perf").addClass("active");

    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        perfiles: function () {
            var datos = {
                opc: "CargContratos",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagPerfiles.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Perfil').html(data['cad']);
                    $('#bot_Perfil').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqResp: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagPerfiles.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Perfil').html(data['cad']);
                    $('#bot_Perfil').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        addPerf: function () {
            $("#acc").val("1");
            if ($("#perm").val() === "n") {
                $('#botones').hide();
                $.Alert("#msg", "No Tiene permisos para Crear Perfiles", "warning", 'warning');
            }
            $("#txt_Nomb").prop('disabled', false);
        },
        editPerf: function (cod) {
            $('#acc').val("2");
            $('#botones').show();
            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            $("#idperfil").val(cod);

            var datos = {
                ope: "BusqEdperfil",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_Nomb").val(data['nomperfil']);


                    ///PARAMETROS EDICION PLAN DE DESARROLLO
                    var Tam_plan = data['perfil_plan'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_plan.length; i++) {
                        par_plan = data['perfil_plan'].split(";");
                        item_par = par_plan[i].split("/");
                        $("#GesPlaT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesPlaV" + x).prop('checked', true);
                        } else {
                            $("#GesPlaV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesPlaA" + x).prop('checked', true);
                        } else {
                            $("#GesPlaA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesPlaM" + x).prop('checked', true);
                        } else {
                            $("#GesPlaM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesPlaE" + x).prop('checked', true);
                        } else {
                            $("#GesPlaE" + x).prop('checked', false);
                        }
                        x++;
                    }
                    ///PARAMETROS EDICION PROYECTO
                    var Tam_proy = data['perfil_proy'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_proy.length; i++) {
                        par_proy = data['perfil_proy'].split(";");
                        item_par = par_proy[i].split("/");
                        $("#GesProyT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesProyV" + x).prop('checked', true);
                        } else {
                            $("#GesProyV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesProyA" + x).prop('checked', true);
                        } else {
                            $("#GesProyA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesProyM" + x).prop('checked', true);
                        } else {
                            $("#GesProyM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesProyE" + x).prop('checked', true);
                        } else {
                            $("#GesProyE" + x).prop('checked', false);
                        }
                        x++;
                    }
                    ///PARAMETROS EDICION EVALUACION
                    var Tam_eva = data['perfil_eval'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_eva.length; i++) {
                        par_eva = data['perfil_eval'].split(";");
                        item_par = par_eva[i].split("/");
                        $("#GesEvaT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesEvaV" + x).prop('checked', true);
                        } else {
                            $("#GesEvaV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesEvaA" + x).prop('checked', true);
                        } else {
                            $("#GesEvaA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesEvaM" + x).prop('checked', true);
                        } else {
                            $("#GesEvaM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesEvaE" + x).prop('checked', true);
                        } else {
                            $("#GesEvaE" + x).prop('checked', false);
                        }
                        x++;
                    }

                    ///PARAMETROS EDICION INFORME
                    var Tam_inf = data['perfil_inf'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_inf.length; i++) {
                        par_inf = data['perfil_inf'].split(";");
                        item_par = par_inf[i].split("/");
                        $("#GesInfT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesInfV" + x).prop('checked', true);
                        } else {
                            $("#GesInfV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesInfA" + x).prop('checked', true);
                        } else {
                            $("#GesInfA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesInfM" + x).prop('checked', true);
                        } else {
                            $("#GesInfM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesInfE" + x).prop('checked', true);
                        } else {
                            $("#GesInfE" + x).prop('checked', false);
                        }
                        x++;
                    }


                    ///PARAMETROS EDICION PARAMETROS
                    var Tam_par = data['perfil_para'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_par.length; i++) {
                        par_par = data['perfil_para'].split(";");
                        item_par = par_par[i].split("/");
                        $("#GesParT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesParV" + x).prop('checked', true);
                        } else {
                            $("#GesParV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesParA" + x).prop('checked', true);
                        } else {
                            $("#GesParA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesParM" + x).prop('checked', true);
                        } else {
                            $("#GesParM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesParE" + x).prop('checked', true);
                        } else {
                            $("#GesParE" + x).prop('checked', false);
                        }
                        x++;
                    }

                    ///PARAMETROS EDICION USUARIOS
                    var Tam_usu = data['perfil_usu'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_usu.length; i++) {
                        par_usu = data['perfil_usu'].split(";");
                        item_par = par_usu[i].split("/");
                        $("#GesUsuT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesUsuV" + x).prop('checked', true);
                        } else {
                            $("#GesUsuV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesUsuA" + x).prop('checked', true);
                        } else {
                            $("#GesUsuA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesUsuM" + x).prop('checked', true);
                        } else {
                            $("#GesUsuM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesUsuE" + x).prop('checked', true);
                        } else {
                            $("#GesUsuE" + x).prop('checked', false);
                        }
                        x++;
                    }

                    ///PARAMETROS EDICION USUARIOS
                    var Tam_usu = data['perfil_ava'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_usu.length; i++) {
                        par_ava = data['perfil_ava'].split(";");
                        item_par = par_ava[i].split("/");
                        $("#AvaProT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#AvaProV" + x).prop('checked', true);
                        } else {
                            $("#AvaProV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#AvaProA" + x).prop('checked', true);
                        } else {
                            $("#AvaProA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#AvaProM" + x).prop('checked', true);
                        } else {
                            $("#AvaProM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#AvaProE" + x).prop('checked', true);
                        } else {
                            $("#AvaProE" + x).prop('checked', false);
                        }
                        x++;
                    }


                    $("#acc").val("2");


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Perfil</a>");


        },
        verPerf: function (cod) {

            $("#btn_nuevo").prop('disabled', false);
            $("#btn_guardar").prop('disabled', true);
            $("#idperfil").val(cod);

            var datos = {
                ope: "BusqEdperfil",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_Nomb").val(data['nomperfil']);


                    ///PARAMETROS EDICION PLAN DE DESARROLLO
                    var Tam_plan = data['perfil_plan'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_plan.length; i++) {
                        par_plan = data['perfil_plan'].split(";");
                        item_par = par_plan[i].split("/");
                        $("#GesPlaT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesPlaV" + x).prop('checked', true);
                        } else {
                            $("#GesPlaV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesPlaA" + x).prop('checked', true);
                        } else {
                            $("#GesPlaA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesPlaM" + x).prop('checked', true);
                        } else {
                            $("#GesPlaM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesPlaE" + x).prop('checked', true);
                        } else {
                            $("#GesPlaE" + x).prop('checked', false);
                        }
                        x++;
                    }
                    ///PARAMETROS EDICION PROYECTO
                    var Tam_proy = data['perfil_proy'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_proy.length; i++) {
                        par_proy = data['perfil_proy'].split(";");
                        item_par = par_proy[i].split("/");
                        $("#GesProyT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesProyV" + x).prop('checked', true);
                        } else {
                            $("#GesProyV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesProyA" + x).prop('checked', true);
                        } else {
                            $("#GesProyA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesProyM" + x).prop('checked', true);
                        } else {
                            $("#GesProyM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesProyE" + x).prop('checked', true);
                        } else {
                            $("#GesProyE" + x).prop('checked', false);
                        }
                        x++;
                    }
                    ///PARAMETROS EDICION EVALUACION
                    var Tam_eva = data['perfil_eval'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_eva.length; i++) {
                        par_eva = data['perfil_eval'].split(";");
                        item_par = par_eva[i].split("/");
                        $("#GesEvaT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesEvaV" + x).prop('checked', true);
                        } else {
                            $("#GesEvaV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesEvaA" + x).prop('checked', true);
                        } else {
                            $("#GesEvaA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesEvaM" + x).prop('checked', true);
                        } else {
                            $("#GesEvaM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesEvaE" + x).prop('checked', true);
                        } else {
                            $("#GesEvaE" + x).prop('checked', false);
                        }
                        x++;
                    }

                    ///PARAMETROS EDICION INFORME
                    var Tam_inf = data['perfil_inf'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_inf.length; i++) {
                        par_inf = data['perfil_inf'].split(";");
                        item_par = par_inf[i].split("/");
                        $("#GesInfT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesInfV" + x).prop('checked', true);
                        } else {
                            $("#GesInfV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesInfA" + x).prop('checked', true);
                        } else {
                            $("#GesInfA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesInfM" + x).prop('checked', true);
                        } else {
                            $("#GesInfM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesInfE" + x).prop('checked', true);
                        } else {
                            $("#GesInfE" + x).prop('checked', false);
                        }
                        x++;
                    }


                    ///PARAMETROS EDICION PARAMETROS
                    var Tam_par = data['perfil_para'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_par.length; i++) {
                        par_par = data['perfil_para'].split(";");
                        item_par = par_par[i].split("/");
                        $("#GesParT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesParV" + x).prop('checked', true);
                        } else {
                            $("#GesParV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesParA" + x).prop('checked', true);
                        } else {
                            $("#GesParA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesParM" + x).prop('checked', true);
                        } else {
                            $("#GesParM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesParE" + x).prop('checked', true);
                        } else {
                            $("#GesParE" + x).prop('checked', false);
                        }
                        x++;
                    }

                    ///PARAMETROS EDICION USUARIOS
                    var Tam_usu = data['perfil_usu'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_usu.length; i++) {
                        par_usu = data['perfil_usu'].split(";");
                        item_par = par_usu[i].split("/");
                        $("#GesUsuT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#GesUsuV" + x).prop('checked', true);
                        } else {
                            $("#GesUsuV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#GesUsuA" + x).prop('checked', true);
                        } else {
                            $("#GesUsuA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#GesUsuM" + x).prop('checked', true);
                        } else {
                            $("#GesUsuM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#GesUsuE" + x).prop('checked', true);
                        } else {
                            $("#GesUsuE" + x).prop('checked', false);
                        }
                        x++;
                    }

                    ///PARAMETROS EDICION USUARIOS
                    var Tam_usu = data['perfil_ava'].split(";");
                    var x = 1;
                    for (var i = 0; i < Tam_usu.length; i++) {
                        par_ava = data['perfil_ava'].split(";");
                        item_par = par_ava[i].split("/");
                        $("#AvaProT" + x).val(item_par[0]);

                        if (item_par[1] === "s") {
                            $("#AvaProV" + x).prop('checked', true);
                        } else {
                            $("#AvaProV" + x).prop('checked', false);
                        }

                        if (item_par[2] === "s") {
                            $("#AvaProA" + x).prop('checked', true);
                        } else {
                            $("#AvaProA" + x).prop('checked', false);
                        }

                        if (item_par[3] === "s") {
                            $("#AvaProM" + x).prop('checked', true);
                        } else {
                            $("#AvaProM" + x).prop('checked', false);
                        }

                        if (item_par[4] === "s") {
                            $("#AvaProE" + x).prop('checked', true);
                        } else {
                            $("#AvaProE" + x).prop('checked', false);
                        }
                        x++;
                    }


                    $("#acc").val("2");


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Perfil</a>");

        },
        deletPerf: function (cod) {
            $("#acc").val("3");

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: $("#acc").val(),
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarPerfil.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.perfiles();
                        } else if (trimAll(data) === "nobien") {
                            $.Alert("#msg2", "No se Puede Realizar la Operación, Este Perfil ha sido asignado a un Usuario...", "warning", "warning");
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
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagPerfiles.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Perfil').html(data['cad']);
                    $('#bot_Perfil').html(data['cad2']);
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
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagPerfiles.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Perfil').html(data['cad']);
                    $('#bot_Perfil').html(data['cad2']);
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


            }

            $.ajax({
                type: "POST",
                url: "PagContancias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Perfil').html(data['cad']);
                    $('#bot_Perfil').html(data['cad2']);
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
        }


    });
    //======FUNCIONES========\\
    $.perfiles();



    $("#btn_nuevo").on("click", function () {
        $('#acc').val("1");

        $("#txt_Nomb").val("");

        $('input[type=checkbox]:checked').each(function () {
            $(this).prop('checked', false);
        });

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);


    });

    $("#btn_cancelar").on("click", function () {
        $('#acc').val("1");

        $("#txt_Nomb").val("");

        $('input[type=checkbox]:checked').each(function () {
            $(this).prop('checked', false);
        });

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);


        $("#tab_02").removeClass("active in");
        $("#tab_02_pp").removeClass("active in");
        $("#tab_01").addClass("active in");
        $("#tab_01_pp").addClass("active in");
        $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Crear Perfil</a>");



    });


    $("#txt_Nomb").on("change", function () {

        var datos = {
            ope: "verfPerf",
            cod: $("#txt_Nomb").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_Nombre").addClass("has-error");
                    $.Alert("#msg2", "Este Nombre de Perfil ya Esta Registrado...", "warning", "warning");
                    $('#txt_Nomb').focus();
                    $("#txt_Nomb").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });


    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {


        if ($('#txt_Nomb').val() == "") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            $('#txt_Nomb').focus();
            return;
        }

        Dat_Plan = "";
        for (var i = 1; i < 5; i++) {
            PlaV = "n";
            if ($("#GesPlaV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#GesPlaA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#GesPlaM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#GesPlaE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Plan += $("#GesPlaT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }
        Dat_Plan = Dat_Plan.slice(0, -1);
        Dat_Proy = "";
        for (var i = 1; i < 4; i++) {
            PlaV = "n";
            if ($("#GesProyV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#GesProyA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#GesProyM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#GesProyE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Proy += $("#GesProyT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }
        Dat_Proy = Dat_Proy.slice(0, -1);

        Dat_Eva = "";
        for (var i = 1; i < 2; i++) {
            PlaV = "n";
            if ($("#GesEvaV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#GesEvaA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#GesEvaM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#GesEvaE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Eva += $("#GesEvaT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }
        Dat_Eva = Dat_Eva.slice(0, -1);

        Dat_Inf = "";
        for (var i = 1; i < 2; i++) {
            PlaV = "n";
            if ($("#GesInfV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#GesInfA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#GesInfM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#GesInfE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Inf += $("#GesInfT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }
        Dat_Inf = Dat_Inf.slice(0, -1);

        Dat_Par = "";
        for (var i = 1; i < 11; i++) {
            PlaV = "n";
            if ($("#GesParV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#GesParA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#GesParM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#GesParE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Par += $("#GesParT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }
        Dat_Par = Dat_Par.slice(0, -1);

        Dat_Usu = "";
        for (var i = 1; i < 3; i++) {
            PlaV = "n";
            if ($("#GesUsuV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#GesUsuA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#GesUsuM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#GesUsuE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Usu += $("#GesUsuT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }

        Dat_Usu = Dat_Usu.slice(0, -1);

        Dat_Ava = "";
        for (var i = 1; i < 3; i++) {
            PlaV = "n";
            if ($("#AvaProV" + i).prop('checked')) {
                PlaV = "s";
            }
            PlaA = "n";
            if ($("#AvaProA" + i).prop('checked')) {
                PlaA = "s";
            }
            PlaM = "n";
            if ($("#AvaProM" + i).prop('checked')) {
                PlaM = "s";
            }
            PlaE = "n";
            if ($("#AvaProE" + i).prop('checked')) {
                PlaE = "s";
            }
            Dat_Ava += $("#AvaProT" + i).val() + "/" + PlaV + "/" + PlaA + "/" + PlaM + "/" + PlaE + ";";
        }

        Dat_Ava = Dat_Ava.slice(0, -1);



        var datos = "txt_Nomb=" + $("#txt_Nomb").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#idperfil").val();


        var Alldata = datos + "&Dat_Plan=" + Dat_Plan + "&Dat_Proy=" + Dat_Proy
                + "&Dat_Eva=" + Dat_Eva + "&Dat_Inf=" + Dat_Inf + "&Dat_Par=" + Dat_Par
                + "&Dat_Usu=" + Dat_Usu + "&Dat_Ava=" + Dat_Ava;
        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarPerfil.php",
            data: Alldata,
            success: function (data) {

                if (trimAll(data) === "bien") {

                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.perfiles();
                    $("#btn_nuevo").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                    $("#txt_Nomb").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});
///////////////////////
