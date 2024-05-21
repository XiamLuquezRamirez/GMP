$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_Depe").addClass("active");
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
                url: "../Paginadores/PagDependencia.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Dependencia').html(data['cad']);
                    $('#bot_Dependencia').html(data['cad2']);
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
                url: "../Paginadores/PagDependencia.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Dependencia').html(data['cad']);
                    $('#bot_Dependencia').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editDepen: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditDependencia",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Cod').val(data['cod_dependencia']);
                    $('#txt_Desc').val(data['des_dependencia']);
                    $('#txt_Corre').val(data['correo_dependencia']);
                    $('#txt_Telf').val(data['tel_dependencia']);
                    $('#txt_obser').val(data['obs_dependencia']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_Corre").prop('disabled', false);
            $("#txt_Telf").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        VerDepen: function(cod) {

            var datos = {
                ope: "BusqEditDependencia",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#txt_Cod').val(data['cod_dependencia']);
                    $('#txt_Desc').val(data['des_dependencia']);
                    $('#txt_Corre').val(data['correo_dependencia']);
                    $('#txt_Telf').val(data['tel_dependencia']);
                    $('#txt_obser').val(data['obs_dependencia']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').hide();

            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_Corre").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);

        },
        deletDepen: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarDependencia.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Depend();
                        } else if (data === "nbien") {
                            $.Alert("#msg2", "Esta Dependencia no se puede Eliminar, Se encuentra relacionada a una Meta", "warning", "warning");
                        } else if (data === "rbien") {
                            $.Alert("#msg2", "Esta Dependencia no se puede Eliminar, Se encuentra relacionada a una Responsable", "warning", "warning");
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
                url: "../Paginadores/PagDependencia.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Dependencia').html(data['cad']);
                    $('#bot_Dependencia').html(data['cad2']);
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
                url: "../Paginadores/PagDependencia.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Dependencia').html(data['cad']);
                    $('#bot_Dependencia').html(data['cad2']);
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
                url: "../Paginadores/PagDependencia.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Dependencia').html(data['cad']);
                    $('#bot_Dependencia').html(data['cad2']);
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
    $.Depend();

    //==============\\
    $("#btn_nuevo1").on("click", function() {
        $('#acc').val("1");
        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");
        $("#txt_Corre").val("");
        $("#txt_Telf").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#txt_Telf").prop('disabled', false);
        $("#txt_Corre").prop('disabled', false);

        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $('#mopc').show();


    });

    $("#txt_Cod").on("change", function() {

        var datos = {
            ope: "verfDepend",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function(data) {
                if (data === "1") {
                    $("#From_Codigo").addClass("has-error");
                    $.Alert("#msg", "Este Código ya Esta Registrado...", "warning", "warning");
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
        $("#txt_Telf").val("");
        $("#txt_Corre").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#txt_Telf").prop('disabled', false);
        $("#txt_Corre").prop('disabled', false);



    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }

        var datos = {
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            cor: $("#txt_Corre").val(),
            tel: $("#txt_Telf").val(),
            obs: $("#txt_obser").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarDependencia.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.Depend();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_Corre").prop('disabled', true);
                    $("#txt_Telf").prop('disabled', true);
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
