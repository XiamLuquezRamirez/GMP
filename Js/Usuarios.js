$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_user").addClass("start active open");
    $("#menu_user_user").addClass("active");

    var Op_Save = "";
    Op_Save = "New";
    var Id_User = "";
    var Datos;
    Datos = "";
    var Op_Validar = 0;

    $.extend({
        Cargar_User: function() {
            var Aux = "";
            if ($("#txt_busq").val() == "") {
                Aux = "Inactivo";
            } else {
                Aux = "Activo";
            }
            var Datos = "";
            Datos += ""
                    + "&Aux=" + Aux
                    + "&Txt=" + $("#txt_busq").val()
                    + "&Pag=1"
                    + "&N_Reg=5";
            $.ajax({
                type: "POST",
                url: "../Paginador_User",
                data: Datos,
                dataType: 'json',
                success: function(data) {
                    if (data["Salida"] == 1) {
                        $('#tb_conte').show(100).html(data['Doc']);
                        $('#cbx_pag').show(100).html(data['Pag']);
                        $('#indi').show(100).html(data['Indi']);
                    }
                    if (data["Salida"] == 2) {
                        alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
                        window.location.href = "../Logout";
                    }
                    if (data["Salida"] == 3) {
                        alert("Ha Ocurrido un Error...");
                    }
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Edit_User: function(Id) {
            $("#btn_nuevo").css("display", "none");
            $("#btn_guardar").css("display", "initial");
            $("#btn_cancelar").css("display", "initial");
            var datos = {
                Opcion: "Edit_User",
                Id: Id
            }
            $.ajax({
                type: "POST",
                url: "../Funciones_User",
                data: datos,
                dataType: 'json',
                success: function(data) {
                    $("#div_contra").css("display", "initial");
                    Op_Save = "Edit_Datos";

                    $("#tab_01_pp").removeClass("active");
                    $("#tab_01").removeClass("active in");

                    $("#tab_02_pp").addClass("active");
                    $("#tab_02").addClass("active in");

                    Id_User = data['ID'];
                    $("#txt_ced").val(data['CEDULA']);
                    $("#txt_nombre").val(data['NOMBRE']);
                    $("#cbx_sexo").selectpicker("val", data['SEXO']);
                    $("#txt_telefono").val(data['TELEFONO']);
                    $("#txt_email").val(data['EMAIL']);
                    $("#txt_user").val(data['USUARIO']);
                    $("#cbx_perfil").selectpicker("val", data['PERFIL']);
                    $("#cbx_estado").selectpicker("val", data['ESTADO']);


                    $.Enable();
                    $("#txt_key").prop('disabled', true);
                    $("#txt_key2").prop('disabled', true);
                },
                beforeSend: function() {
                    $('#cargando').modal('show');
                },
                complete: function() {
                    $('#cargando').modal('hide');
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Elimi_User: function(Id) {
            if (confirm("¿Esta Seguro De Desea Eliminar Este Registro?")) {
                var datos = {
                    Op_Save: "Eliminar",
                    Id: Id
                }
                $.ajax({
                    type: "POST",
                    url: "../Gestionar_User",
                    data: datos,
                    dataType: 'json',
                    success: function(data) {
                        if (data["Salida"] == 1) {
                            alert("Usuario Eliminado Exitosamente");
                            $.Cargar_User();
                        }
                        if (data["Salida"] == 2) {
                            alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
                            window.location.href = "../Logout";
                        }
                        if (data["Salida"] == 3) {
                            alert("Ha Ocurrido un Error...");
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        Hab_Contra: function() {
            if ($('#chk_contra').attr('checked')) {
                Op_Save = "Edit_Key";
                $("#txt_key").prop('disabled', false);
                $("#txt_key2").prop('disabled', false);
            } else {
                $("#txt_key").prop('disabled', true);
                $("#txt_key2").prop('disabled', true);
            }
        },
        Validar_Contra: function() {
            var key, key2;
            key = $("#txt_key").val();
            key2 = $("#txt_key2").val();
            if (key == key2) {
                $.Alert("#msg_user", "Contraseñas Validas", "success");
                $("#btn_guardar").css("display", "initial");
            } else {
                $.Alert("#msg_user", "Las Contraseñas NO SON IGUALES", "danger");
                $("#btn_guardar").css("display", "none");
            }
        },
        Limpiar: function() {
            $("#txt_ced").val("");
            $("#txt_nombre").val("");
            $("#cbx_sexo").selectpicker("val", " ");
            $("#txt_telefono").val("");
            $("#txt_email").val("");
            $("#txt_user").val("");
            $("#txt_key").val("");
            $("#txt_key2").val("");
            $("#cbx_perfil").selectpicker("val", " ");
        },
        Enable: function() {
            $("#txt_ced").prop('disabled', false);
            $("#txt_nombre").prop('disabled', false);
            $("#txt_telefono").prop('disabled', false);
            $("#txt_email").prop('disabled', false);
            $("#txt_user").prop('disabled', false);
            $("#txt_key").prop('disabled', false);
            $("#txt_key2").prop('disabled', false);

            $("#cbx_sexo").prop('disabled', false);
            $("#cbx_sexo").selectpicker('refresh');
            $("#cbx_estado").prop('disabled', false);
            $("#cbx_estado").selectpicker('refresh');
            $("#cbx_perfil").prop('disabled', false);
            $("#cbx_perfil").selectpicker('refresh');
        },
        Disabled: function() {
            $("#txt_ced").prop('disabled', true);
            $("#txt_nombre").prop('disabled', true);
            $("#txt_telefono").prop('disabled', true);
            $("#txt_email").prop('disabled', true);
            $("#txt_user").prop('disabled', true);
            $("#txt_key").prop('disabled', true);
            $("#txt_key2").prop('disabled', true);

            $("#cbx_sexo").prop('disabled', true);
            $("#cbx_sexo").selectpicker('refresh');
            $("#cbx_estado").prop('disabled', true);
            $("#cbx_estado").selectpicker('refresh');
            $("#cbx_perfil").prop('disabled', true);
            $("#cbx_perfil").selectpicker('refresh');
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
        },
        Paginador: function(pag) {
            var Aux = "";
            if ($("#txt_busq").val() == "") {
                Aux = "Inactivo";
            } else {
                Aux = "Activo";
            }
            var Datos = "";
            Datos += "&Opcion=Busq_Doc"
                    + "&Aux=" + Aux
                    + "&Txt=" + $("#txt_busq").val()
                    + "&Pag=" + pag
                    + "&N_Reg=" + $("#nreg").val();
            $.ajax({
                type: "POST",
                url: "../Paginador_User",
                data: Datos,
                dataType: 'json',
                success: function(data) {
                    $('#tb_conte').show(100).html(data['Doc']);
                    $('#cbx_pag').show(100).html(data['Pag']);
                    $('#indi').show(100).html(data['Indi']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Cbx_Paginador: function(pag) {
            var Aux = "";
            if ($("#txt_busq").val() == "") {
                Aux = "Inactivo";
            } else {
                Aux = "Activo";
            }
            var Datos = "";
            Datos += "&Opcion=Busq_Doc"
                    + "&Aux=" + Aux
                    + "&Txt=" + $("#txt_busq").val()
                    + "&Pag=" + pag
                    + "&N_Reg=" + $("#nreg").val();
            $.ajax({
                type: "POST",
                url: "../Paginador_User",
                data: Datos,
                dataType: 'json',
                success: function(data) {
                    $('#tb_conte').show(100).html(data['Doc']);
                    $('#cbx_pag').show(100).html(data['Pag']);
                    $('#indi').show(100).html(data['Indi']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Cbx_Reg: function(nre) {
            var Aux = "";
            if ($("#txt_busq").val() == "") {
                Aux = "Inactivo";
            } else {
                Aux = "Activo";
            }
            var Datos = "";
            Datos += "&Opcion=Busq_Doc"
                    + "&Aux=" + Aux
                    + "&Txt=" + $("#txt_busq").val()
                    + "&Pag=1"
                    + "&N_Reg=" + nre;
            $.ajax({
                type: "POST",
                url: "../Paginador_User",
                data: Datos,
                dataType: 'json',
                success: function(data) {
                    $('#tb_conte').show(100).html(data['Doc']);
                    $('#cbx_pag').show(100).html(data['Pag']);
                    $('#indi').show(100).html(data['Indi']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        Validar: function() {
            var Value = "";
            var Id = "";
            Id = "#txt_ced";
            Value = $(Id).val();
            if (Value == "" || Value == " ") {
                Op_Validar = 1;
                $(Id).css('background-color', '#EA5338');
            } else {
                $(Id).removeAttr('style');
                Op_Validar = 0;
            }
            Id = "#txt_nombre";
            Value = $(Id).val();
            if (Value == "" || Value == " ") {
                Op_Validar = 1;
                $(Id).css('background-color', '#EA5338');
            } else {
                $(Id).removeAttr('style');
                Op_Validar = 0;
            }
            Id = "#cbx_sexo";
            Value = $(Id).val();
            if (Value == "" || Value == " ") {
                Op_Validar = 1;
                $("#div_sexo").css('background-color', '#EA5338');
            } else {
                $("#div_sexo").removeAttr('style');
                Op_Validar = 0;
            }
            Id = "#txt_user";
            Value = $(Id).val();
            if (Value == "" || Value == " ") {
                Op_Validar = 1;
                $(Id).css('background-color', '#EA5338');
            } else {
                $(Id).removeAttr('style');
                Op_Validar = 0;
            }
            if (Op_Save == "New" || Op_Save == "Edit_Key") {
                Id = "#txt_key";
                Value = $(Id).val();
                if (Value == "" || Value == " ") {
                    Op_Validar = 1;
                    $(Id).css('background-color', '#EA5338');
                } else {
                    $(Id).removeAttr('style');
                    Op_Validar = 0;
                }
                Id = "#txt_key2";
                Value = $(Id).val();
                if (Value == "" || Value == " ") {
                    Op_Validar = 1;
                    $(Id).css('background-color', '#EA5338');
                } else {
                    $(Id).removeAttr('style');
                    Op_Validar = 0;
                }
            }
            Id = "#cbx_perfil";
            Value = $(Id).val();
            if (Value == "" || Value == " ") {
                Op_Validar = 1;
                $("#div_perfil").css('background-color', '#EA5338');
            } else {
                $("#div_perfil").removeAttr('style');
                Op_Validar = 0;
            }
        },

        Validar_Ced: function() {
            if (Op_Save == "New") {
                if ($("#txt_ced").val() == " " || $("#txt_ced").val() == "") {
                    $.Alert("#msg_user", "Numero De Identificación Erroneo", "danger");
                    $("#txt_ced").val("");
                    $('#txt_ced').focus();
                    $("#btn_guardar").css("display", "none");
                    return;
                }
            }
            var datos = {
                Opcion: "Existe_Ced",
                Ced: $("#txt_ced").val()
            };
            $.ajax({
                type: "POST",
                url: "../Funciones_User",
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if (data['Salida'] == "Existe") {
                        $.Alert("#msg_user", "Ya existe un Usuario Registrado Con Esa Identificación", "danger");
                        $("#txt_ced").val("");
                        $('#txt_ced').focus();
                        $("#btn_guardar").css("display", "none");
                    }
                    if (data['Salida'] == "No_Existe") {
                        $.Alert("#msg_user", "Numero De Identificación Valida", "success");
                        $("#btn_guardar").css("display", "initial");
                    }
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Validar_User: function() {
            if (Op_Save == "New") {
                if ($("#txt_user").val() == " " || $("#txt_user").val() == "") {
                    $.Alert("#msg_user", "Nombre De Usuario Erroneo", "danger");
                    $("#txt_user").val("");
                    $('#txt_user').focus();
                    $("#btn_guardar").css("display", "none");
                    return;
                }
            }
            var datos = {
                Opcion: "Existe_User",
                Usu: $("#txt_user").val()
            }
            $.ajax({
                type: "POST",
                url: "../Funciones_User",
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if (data['Salida'] == "Existe") {
                        $.Alert("#msg_user", "Ya Existe Este Usuario..Por Favor Eliga Otro Usuario", "danger");
                        $("#txt_user").val("");
                        $('#txt_user').focus();
                        $("#btn_guardar").css("display", "none");
                    }
                    if (data['Salida'] == "No_Existe") {
                        $("#btn_guardar").css("display", "initial");
                        $.Alert("#msg_user", "Nombre De Usuario Valido", "success");
                    }
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
    });

    $.Cargar_User();

    //====BUSQUEDA DE REGISTRO====\\
    $("#btn_busq").on("click", function() {
        $.Cargar_User();
    });
    $("#txt_busq").on("keypress", function(event) {
        if (event.which == 13) {
            $.Cargar_User();
        }
    });
    //====BUSQUEDA DE REGISTRO====\\

    //====VERIFICAR SI EXISTE LA CEDULA====\\
    $('#txt_ced').change(function() {
        $.Validar_Ced();
    });
    $('#txt_ced').focusout(function() {
        if (Op_Save == "New") {
            $.Validar_Ced();
        }
    });

    //====VERIFICAR SI EXISTE LA CEDULA====\\

    //====VERIFICAR SI EXISTE USUARIO====\\
    $('#txt_user').change(function() {
        $.Validar_User();
    });
    $('#txt_user').focusout(function() {
        if (Op_Save == "New") {
            $.Validar_User();
        }
    });
    //====VERIFICAR SI EXISTE USUARIO====\\

    //====VERIFICAR SI LAS CONTRASEÑAS SON IGUALES ====\\
    $('#txt_key2').change(function() {
        $.Validar_Contra();
    });
    $('#txt_key2').focusout(function() {
        $.Validar_Contra();
    });
    //====VERIFICAR SI LAS CONTRASEÑAS SON IGUALES ====\\

    //====BOTON NUEVO====\\
    $('#btn_nuevo').on('click', function() {
        $("#btn_nuevo").css("display", "none");
        $("#btn_guardar").css("display", "initial");
        $("#btn_cancelar").css("display", "initial");
        $.Enable();
        $.Limpiar();
        $("#txt_ced").focus();
    });
    //====BOTON NUEVO====\\

    //====BOTON GUARDAR====\\
    $('#btn_guardar').on('click', function() {
        $.Run();
        $.Validar();
        if (Op_Validar == 1) {
            Datos = "";
            Op_Validar = 0;
            $.Alert("#msg", "Por Favor Llenar Los Campos Obligatorios", "warning");
            return;
        }
        $.ajax({
            type: "POST",
            url: "../Gestionar_User",
            data: Datos,
            dataType: 'json',
            success: function(data) {
                if (data["Salida"] == 1) {
                    alert("Usuario Guardado Exitosamente");
                    $.Cargar_User();
                    $.Disabled();
                    $.Limpiar();
                    $("#btn_nuevo").css("display", "initial");
                    $("#btn_guardar").css("display", "none");
                    $("#btn_cancelar").css("display", "none");
                }
                if (data["Salida"] == 2) {
                    alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
                    window.location.href = "../Logout";
                }
                if (data["Salida"] == 3) {
                    alert("Ha Ocurrido un Error...");
                }
            },
            beforeSend: function() {
                $('#cargando').modal('show');
            },
            complete: function() {
                $('#cargando').modal('hide');
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    //====BOTON GUARDAR====\\

    //====RESTINGIR BOTON BORRAR PARA IR ATRAS====\\
    if (typeof window.event == 'undefined') {
        document.onkeypress = function(e) {
            var test_var = e.target.nodeName.toUpperCase();
            if (e.target.type)
                var test_type = e.target.type.toUpperCase();
            if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA') {
                return e.keyCode;
            } else if (e.keyCode == 8) {
                e.preventDefault();
            }
        }
    } else {
        document.onkeydown = function() {
            var test_var = event.srcElement.tagName.toUpperCase();
            if (event.srcElement.type)
                var test_type = event.srcElement.type.toUpperCase();
            if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA') {
                return event.keyCode;
            } else if (event.keyCode == 8) {
                event.returnValue = false;
            }
        }
    }
});