$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_Contratis").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";

    $("#CbPersona, #cbx_tipo_ident").selectpicker();

    $.extend({
        Contr: function() {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagContratistas.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Contratistas').html(data['cad']);
                    $('#bot_Contratistas').html(data['cad2']);
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
                url: "../Paginadores/PagContratistas.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Contratistas').html(data['cad']);
                    $('#bot_Contratistas').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editContra: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditContratista",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {

                    $("#txt_ident").val(data['ident_contratis']);
                    $("#txt_dv").val(data['dv_contratis']);
                    $("#txt_Nomb").val(data['nom_contratis']);
                    $('#CbDepa').val(data["depart_contratis"]).change();
                    $.BusMun($('#CbDepa').val());
                    $('#CbMun').val(data["mun_contratis"]).change();
                    $("#CbPersona").selectpicker("val", data['tper_contratis']);
                    if (data['tper_contratis'] === "NATURAL") {
                        $('#datRepr').hide();
                    } else {
                        $('#datRepr').show();
                    }
                    $("#cbx_tipo_ident").selectpicker("val", data['tid_contratis']);
                    $("#txt_Tel").val(data['telcon_contratis']);
                    $("#txt_Direc").val(data['dircon_contratis']);
                    $("#txt_Correo").val(data['corcont_contratis']);
                    $("#txt_IdRepr").val(data['idrpr_contratis']);
                    $("#txt_NomRepr").val(data['nomrpr_contratis']);
                    $("#txt_TelRepr").val(data['telrpr_contratis']);
                    $("#txt_obser").val(data['observ_contratist']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_ident").prop('disabled', false);
            $("#CbPersona").prop('disabled', false);
            $("#cbx_tipo_ident").prop('disabled', false);
            $("#txt_Nomb").prop('disabled', false);
            $("#txt_Tel").prop('disabled', false);
            $("#txt_Direc").prop('disabled', false);
            $("#txt_Correo").prop('disabled', false);
            $("#txt_IdRepr").prop('disabled', false);
            $("#txt_NomRepr").prop('disabled', false);
            $("#txt_TelRepr").prop('disabled', false);
            $("#CbDepa").prop('disabled', false);
            $("#CbMun").prop('disabled', true);
            $("#txt_obser").prop('disabled', false);


        },
        VerContra: function(cod) {

            var datos = {
                ope: "BusqEditContratista",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {

                    $("#txt_ident").val(data['ident_contratis']);
                    $("#txt_dv").val(data['dv_contratis']);
                    $("#txt_Nomb").val(data['nom_contratis']);
                    $('#CbDepa').val(data["depart_contratis"]).change();
                    $.BusMun($('#CbDepa').val());
                    $('#CbMun').val(data["mun_contratis"]).change();
                    $("#CbPersona").selectpicker("val", data['tper_contratis']);
                    if (data['tper_contratis'] === "NATURAL") {
                        $('#datRepr').hide();
                    } else {
                        $('#datRepr').show();
                    }
                    $("#cbx_tipo_ident").selectpicker("val", data['tid_contratis']);
                    $("#txt_Tel").val(data['telcon_contratis']);
                    $("#txt_Direc").val(data['dircon_contratis']);
                    $("#txt_Correo").val(data['corcont_contratis']);
                    $("#txt_IdRepr").val(data['idrpr_contratis']);
                    $("#txt_NomRepr").val(data['nomrpr_contratis']);
                    $("#txt_TelRepr").val(data['telrpr_contratis']);
                    $("#txt_obser").val(data['observ_contratist']);
                    $('#txt_id').val(cod);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').hide();

            $("#txt_ident").prop('disabled', false);
            $("#CbPersona").prop('disabled', false);
            $("#cbx_tipo_ident").prop('disabled', false);
            $("#txt_Nomb").prop('disabled', false);
            $("#txt_Tel").prop('disabled', false);
            $("#txt_Direc").prop('disabled', false);
            $("#txt_Correo").prop('disabled', false);
            $("#txt_IdRepr").prop('disabled', false);
            $("#txt_NomRepr").prop('disabled', false);
            $("#txt_TelRepr").prop('disabled', false);
            $("#CbDepa").prop('disabled', false);
            $("#CbMun").prop('disabled', true);
            $("#txt_obser").prop('disabled', false);

        },
        deletContra: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarContratistas.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Contr();
                        } else if (data === "nbien") {
                            $.Alert("#msg2", "Este Contratista no se puede Eliminar, Se encuentra relacionado a un Contrato", "warning", "warning");
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
                url: "../Paginadores/PagContratistas.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Contratistas').html(data['cad']);
                    $('#bot_Contratistas').html(data['cad2']);
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
                url: "../Paginadores/PagContratistas.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Contratistas').html(data['cad']);
                    $('#bot_Contratistas').html(data['cad2']);
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
                url: "../Paginadores/PagContratistas.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Contratistas').html(data['cad']);
                    $('#bot_Contratistas').html(data['cad2']);
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

            Id = "#CbPersona";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Persona").addClass("has-error");
            } else {
                $("#From_Persona").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_ident";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_ide").addClass("has-error");
            } else {
                $("#From_ide").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_Nomb";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_nom").addClass("has-error");
            } else {
                $("#From_nom").removeClass("has-error");
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
        },
        calculaDigitoVerificador: function(i_rut) {

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
            $('#txt_dv').val(digitov);
        },
        zero_fill: function(i_valor, num_ceros) {
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
        BusDepa: function(val) {

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
                success: function(data) {

                    $("#CbDepa").html(data['Depa']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbMun").prop('disabled', false);


        },
        BusMun: function(val) {

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
                success: function(data) {

                    $("#CbMun").html(data['mun']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbMun").prop('disabled', false);



        }

    });
    //======FUNCIONES========\\
    $.BusDepa();
    $.Contr();

    //==============\\
    $("#btn_nuevo1").on("click", function() {
        $('#acc').val("1");
        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $('#mopc').show();

        $("#txt_ident").val("");
        $("#txt_dvC").val("");
        $("#txt_Nomb").val("");
        $("#CbDepa").select2("val", " ");
        $("#CbMun").select2("val", " ");
        $("#CbPersona").selectpicker("val", " ");
        $("#cbx_tipo_ident").selectpicker("val", "CC");
        $("#txt_Tel").val("");
        $("#txt_Direc").val("");
        $("#txt_Correo").val("");
        $("#txt_IdRepr").val("");
        $("#txt_NomRepr").val("");
        $("#txt_TelRepr").val("");
        $("#txt_obser").val("");
        $('#datRepr').hide();

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_ident").prop('disabled', false);
        $("#CbPersona").prop('disabled', false);
        $("#cbx_tipo_ident").prop('disabled', false);
        $("#txt_Nomb").prop('disabled', false);
        $("#txt_Tel").prop('disabled', false);
        $("#txt_Direc").prop('disabled', false);
        $("#txt_Correo").prop('disabled', false);
        $("#txt_IdRepr").prop('disabled', false);
        $("#txt_NomRepr").prop('disabled', false);
        $("#txt_TelRepr").prop('disabled', false);
        $("#CbDepa").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);

    });

    $("#CbPersona").on("change", function() {
        var val = $("#CbPersona").val();
        if (val == "NATURAL") {
            $('#datRepr').hide();
        } else {
            $('#datRepr').show();
        }
    });

    $("#txt_ident").on("change", function() {

        var datos = {
            ope: "verfContratista",
            cod: $("#txt_ident").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function(data) {
                if (data === "1") {
                    $("#From_ide").addClass("has-error");
                    $.Alert("#msg", "Esta Identificación ya Esta Registrada...", "warning", "warning");
                    $('#txt_ident').focus();
                    $("#txt_ident").val("");
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_nuevo2").on("click", function() {
        $('#acc').val("1");

        $("#txt_ident").val("");
        $("#txt_dvC").val("");
        $("#txt_Nomb").val("");
        $("#CbDepa").select2("val", " ");
        $("#CbMun").select2("val", " ");
        $("#CbPersona").selectpicker("val", " ");
        $("#cbx_tipo_ident").selectpicker("val", "CC");
        $("#txt_Tel").val("");
        $("#txt_Direc").val("");
        $("#txt_Correo").val("");
        $("#txt_IdRepr").val("");
        $("#txt_NomRepr").val("");
        $("#txt_TelRepr").val("");
        $("#txt_obser").val("");
        $('#datRepr').hide();

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_ident").prop('disabled', false);
        $("#CbPersona").prop('disabled', false);
        $("#cbx_tipo_ident").prop('disabled', false);
        $("#txt_Nomb").prop('disabled', false);
        $("#txt_Tel").prop('disabled', false);
        $("#txt_Direc").prop('disabled', false);
        $("#txt_Correo").prop('disabled', false);
        $("#txt_IdRepr").prop('disabled', false);
        $("#txt_NomRepr").prop('disabled', false);
        $("#txt_TelRepr").prop('disabled', false);
        $("#CbDepa").prop('disabled', false);
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
            CbPersona: $("#CbPersona").val(),
            cbx_tipo_ident: $("#cbx_tipo_ident").val(),
            txt_ident: $("#txt_ident").val(),
            txt_dv: $("#txt_dv").val(),
            txt_Nomb: $("#txt_Nomb").val(),
            txt_Tel: $("#txt_Tel").val(),
            txt_Direc: $("#txt_Direc").val(),
            txt_Correo: $("#txt_Correo").val(),
            txt_IdRepr: $("#txt_IdRepr").val(),
            txt_NomRepr: $("#txt_NomRepr").val(),
            txt_TelRepr: $("#txt_TelRepr").val(),
            CbDepa: $("#CbDepa").val(),
            CbMun: $("#CbMun").val(),
            txt_obser: $("#txt_obser").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarContratistas.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.Contr();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_ident").prop('disabled', true);
                    $("#CbPersona").prop('disabled', true);
                    $("#cbx_tipo_ident").prop('disabled', true);
                    $("#txt_Nomb").prop('disabled', true);
                    $("#txt_Tel").prop('disabled', true);
                    $("#txt_Direc").prop('disabled', true);
                    $("#txt_Correo").prop('disabled', true);
                    $("#txt_IdRepr").prop('disabled', true);
                    $("#txt_NomRepr").prop('disabled', true);
                    $("#txt_TelRepr").prop('disabled', true);
                    $("#CbDepa").prop('disabled', true);
                    $("#CbMun").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});

