$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_conse").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";

    $("#CbGrupo, #CbVige, #Cbdigi").selectpicker();
    ///////////////////////CARGAR CONSECUTIVOS:
    $.extend({
        conse: function() {
            var datos = {
                opc: "CargSecretarias",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagConsecut.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Conse').html(data['cad']);
                    $('#bot_Conse').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqConse: function(val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagConsecut.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Conse').html(data['cad']);
                    $('#bot_Conse').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editConse: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditConse",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Estr').val(data['estruct']);
                    $("#CbGrupo").selectpicker("val", data['grupo']);
                    $("#CbVige").selectpicker("val", data['vigencia']);
                    $("#Cbdigi").selectpicker("val", data['digitos']);
                    $('#txt_Desc').val(data['descrip']);
                    $('#txt_ini').val(data['inicio']);
                    $('#txt_act').val(data['actual']);
                    $('#txt_obser').val(data['observ']);
                    $('#txt_EstrucEst').val(data['estr_fin']);

                    $('#txt_id').val(cod);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_Estr").prop('disabled', false);
            $("#CbGrupo").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_ini").prop('disabled', false);
            $("#txt_act").prop('disabled', false);
            $("#CbVige").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        VerConse : function(cod) {

             var datos = {
                ope: "BusqEditConse",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Estr').val(data['estruct']);
                    $("#CbGrupo").selectpicker("val", data['grupo']);
                    $("#CbVige").selectpicker("val", data['vigencia']);
                    $("#Cbdigi").selectpicker("val", data['digitos']);
                    $('#txt_Desc').val(data['descrip']);
                    $('#txt_ini').val(data['inicio']);
                    $('#txt_act').val(data['actual']);
                    $('#txt_obser').val(data['observ']);
                    $('#txt_EstrucEst').val(data['estr_fin']);

                    $('#txt_id').val(cod);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_Estr").prop('disabled', true);
            $("#CbGrupo").prop('disabled', true);
            $("#txt_Desc").prop('disabled', true);
            $("#txt_ini").prop('disabled', true);
            $("#txt_act").prop('disabled', true);
            $("#CbVige").prop('disabled', true);
            $("#txt_obser").prop('disabled', true);
            $('#mopc').hide();

        },
        addLeadingZeros: function(n, length)
        {
            var str = (n > 0 ? n : -n) + "";
            var zeros = "";
            for (var i = length - str.length; i > 0; i--)
                zeros += "0";
            zeros += str;
            return n >= 0 ? zeros : "-" + zeros;
        },
        deletConse: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarConse.php",
                    data: datos,
                    success: function(data) {
                        alert(data);
                        if (trimAll(data) === "bien") {
                            $.Alert("#msg2", "Datos Guardados Exitosamente...", "success", "check");
                            $.conse();
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        ValGrupo: function(grup) {

            var datos = {
                ope: "ValGrupo",
                grup: grup
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                success: function(data) {
                    if (data === "1") {
                        $("#From_Grupo").addClass("has-error");
                        $.Alert("#msg", "Este Grupo ya Esta Registrado...", "warning", "warning");
                        $("#CbGrupo").selectpicker("val", " ");

                    }
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        estruct: function() {

            var struc = "";
            $("#txt_act").val($("#txt_ini").val());
            num = $.addLeadingZeros($("#txt_ini").val(), $("#Cbdigi").val());
            var vig = $("#txt_fec").val().split("-");
            if ($("#CbVige").val() === "SI") {
                struc = $("#txt_Estr").val() + "-" + vig[0] + "-" + num;
            } else {
                struc = $("#txt_Estr").val() + "-" + num;
            }

            $("#txt_EstrucEst").val(struc);

        },
        paginador: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagConsecut.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Conse').html(data['cad']);
                    $('#bot_Conse').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagConsecut.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Conse').html(data['cad']);
                    $('#bot_Conse').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag2: function(nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagConsecut.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Conse').html(data['cad']);
                    $('#bot_Conse').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        Validar: function() {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_Estr";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Estr").addClass("has-error");
            } else {
                $("#From_Estr").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#CbGrupo";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Grupo").addClass("has-error");
            } else {
                $("#From_Grupo").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);
        },
        Alert: function(Id_Msg, Txt_Msg, Type_Msg, ico) {
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
    $.conse();
    $("#btn_nuevo1").on("click", function() {

        $('#acc').val("1");
        $("#txt_Estr").val("");
        $("#txt_Desc").val("");
        $("#txt_ini").val("0");
        $("#txt_act").val("");
        $("#txt_obser").val("");
        $("#txt_EstrucEst").val("");
        $("#CbGrupo").selectpicker("val", " ");
        $("#Cbdigi").selectpicker("val", "1");
        $("#CbVige").selectpicker("val", "");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Estr").prop('disabled', false);
        $("#CbGrupo").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_ini").prop('disabled', false);
        $("#Cbdigi").prop('disabled', false);
        $("#CbVige").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);

        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $('#mopc').show();


    });


    $("#btn_nuevo2").on("click", function() {
        $('#acc').val("1");

        $("#txt_Estr").val("");
        $("#txt_Desc").val("");
        $("#txt_ini").val("0");
        $("#txt_act").val("");
        $("#txt_obser").val("");
        $("#txt_EstrucEst").val("");
        $("#CbGrupo").selectpicker("val", " ");
        $("#Cbdigi").selectpicker("val", "1");
        $("#CbVige").selectpicker("val", "");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Estr").prop('disabled', false);
        $("#CbGrupo").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_ini").prop('disabled', false);
        $("#Cbdigi").prop('disabled', false);
        $("#CbVige").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {


        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            txt_Estr: $("#txt_Estr").val(),
            txt_Desc: $("#txt_Desc").val(),
            CbGrupo: $("#CbGrupo").val(),
            txt_ini: $("#txt_ini").val(),
            txt_act: $("#txt_act").val(),
            CbVige: $("#CbVige").val(),
            txt_obser: $("#txt_obser").val(),
            txt_EstrucEst: $("#txt_EstrucEst").val(),
            Cbdigi: $("#Cbdigi").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarConse.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.conse();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Estr").prop('disabled', true);
                    $("#CbGrupo").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_ini").prop('disabled', true);
                    $("#txt_act").prop('disabled', true);
                    $("#Cbdigi").prop('disabled', true);
                    $("#CbVige").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});
///////////////////////
