$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_fueinf").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";

    $.extend({
        Depend: function() {
            var datos = {
                pag: "1",
                op: "1",
                bus: "", 
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagFuenteInformacion.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Fuente').html(data['cad']);
                    $('#bot_Fuente').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqOrInfo: function(val) {


            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagFuenteInformacion.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Fuente').html(data['cad']);
                    $('#bot_Fuente').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editFuente: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditfuenteInf",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Desc').val(data['nombre']);
                    $('#txt_obser').val(data['descripcion']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
             $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_Desc").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        VerFuente: function(cod) {

            var datos = {
                ope: "BusqEditResponsable",
                cod: cod
            };

            var datos = {
                ope: "BusqEditfuenteInf",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Desc').val(data['nombre']);
                    $('#txt_obser').val(data['descripcion']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
             $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_Desc").prop('disabled', true);
            $("#txt_obser").prop('disabled', true);

             $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').hide();

        },
        deletFuente: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarFuenInfor.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success");
                            $.Depend();
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
                url: "../Paginadores/PagFuenteInformacion.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Fuente').html(data['cad']);
                    $('#bot_Fuente').html(data['cad2']);
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
                url: "../Paginadores/PagFuenteInformacion.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Fuente').html(data['cad']);
                    $('#bot_Fuente').html(data['cad2']);
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
                url: "../Paginadores/PagFuenteInformacion.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Fuente').html(data['cad']);
                    $('#bot_Fuente').html(data['cad2']);
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


            Id = "#txt_Desc";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Descripcion").addClass("has-error");
            } else {
                $("#From_Descripcion").removeClass("has-error");
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
    $.Depend();

    //==============\\
    $("#btn_nuevo1").on("click", function() {
        $('#acc').val("1");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);

        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $('#mopc').show();


    });


    $("#btn_nuevo2").on("click", function() {
        $('#acc').val("1");

        $("#txt_Desc").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);



    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        var datos = {
            des: $("#txt_Desc").val(),
            obs: $("#txt_obser").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarFuenInfor.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success");
                    $.Depend();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Desc").prop('disabled', true);
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
