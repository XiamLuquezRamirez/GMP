$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_Proceso").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";
    $("#CbMacro").selectpicker();

    $.extend({
        Procesos: function() {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProceso.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proceso').html(data['cad']);
                    $('#bot_Proceso').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqDepen: function(val) {


            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProceso.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proceso').html(data['cad']);
                    $('#bot_Proceso').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editProceso: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditProcesos",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Cod').val(data['codi_proc']);
                    $('#txt_Desc').val(data['nomb_proc']);
                    $("#CbMacro").selectpicker("val", data['macropro_proc']);
                    $('#txt_obser').val(data['obse_proc']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();

            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#CbMacro").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        VerProceso: function(cod) {

            var datos = {
                ope: "BusqEditProcesos",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Cod').val(data['codi_proc']);
                    $('#txt_Desc').val(data['nomb_proc']);
                    $("#CbMacro").selectpicker("val", data['macropro_proc']);
                    $('#txt_obser').val(data['obse_proc']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();

            $("#txt_Cod").prop('disabled', true);
            $("#txt_Desc").prop('disabled', true);
            $("#CbMacro").prop('disabled', true);
            $("#txt_obser").prop('disabled', true);

            $("#responsive").modal();
            $('#mopc').hide();

        },
        deletProceso: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarProcesos.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success");
                            $.Procesos();
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function(pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProceso.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proceso').html(data['cad']);
                    $('#bot_Proceso').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag: function(pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProceso.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proceso').html(data['cad']);
                    $('#bot_Proceso').html(data['cad2']);
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
                url: "../Paginadores/PagProceso.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proceso').html(data['cad']);
                    $('#bot_Proceso').html(data['cad2']);
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

            Id = "#CbMacro";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Macro").addClass("has-error");
            } else {
                $("#From_Macro").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        },
        Alert: function(Id_Msg, Txt_Msg, Type_Msg) {
            App.alert({
                container: Id_Msg, // alerts parent container(by default placed after the page breadcrumbs)
                place: "append", // append or prepent in container [append, prepend]
                type: Type_Msg, // alert's type [success, danger, warning, info]
                message: Txt_Msg, // alert's message
                close: true, // make alert closable [true, false]
                reset: true, // close all previouse alerts first [true, false]
                focus: true, // auto scroll to the alert after shown [true, false]
                closeInSeconds: "5", // auto close after defined seconds [0, 1, 5, 10]
                icon: "" // put icon before the message [ "" , warning, check, user]
            });
        }

    });
    //======FUNCIONES========\\
    $.Procesos();

    //==============\\
    $("#btn_nuevo1").on("click", function() {
        $('#acc').val("1");
        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");
        $("#CbMacro").selectpicker("val", " ");


        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#CbMacro").prop('disabled', false);

        $("#responsive").modal();
        $('#mopc').show();


    });

    $("#txt_Cod").on("change", function() {

        var datos = {
            ope: "verfProceso",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function(data) {
                if (data === "1") {
                    $("#From_Codigo").addClass("has-error");
                    $.Alert("#msg", "Este Código ya Esta Registrado...", "warning");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_nuevo2").on("click", function() {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");
        $("#CbMacro").selectpicker("val", " ");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#CbMacro").prop('disabled', false);



    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        var datos = {
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            mac: $("#CbMacro").val(),
            obs: $("#txt_obser").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarProcesos.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success");
                    $.Procesos();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#CbMacro").prop('disabled', true);
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
