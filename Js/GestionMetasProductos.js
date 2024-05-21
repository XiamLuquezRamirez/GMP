$(document).ready(function () {
    $("#home").removeClass("start active open");
    $("#menu_plan").addClass("start active open");
    $("#menu_MetasProducto").addClass("active");
    var opcion = "GUARDAR";
    var aumentar = "SI";

    $.extend({
        consecutivo: function () {
            var datos = {
                ope: "ConConsecutivo",
                tco: "METAS_PRODUCTOS"
            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data['flag'] === "n") {
                        $.Alert("#msg", "No se Puede Realizar la Operación... No se creado un Consecutivo para las Metas. Verifique...", "warning", 'warning');
                    } else {
                        $("#codigo").val(data['StrAct']);
                        $("#cons").val(data['cons']);
                    }

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
        },
        Metas: function () {

            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetasPro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqPlan: function (val) {

            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetasPro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        paginador: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetasPro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetasPro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
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
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagMetasPro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_PlanAccion').html(data['cad']);
                    $('#bot_PlanAccion').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        FormNum: function (id) {
            //            var val = $("#" + id).val().replace(".", "").replace(".", "").replace(".", "").replace(",", ".");
            var num = new Intl.NumberFormat('es-CO').format($("#" + id).val());
            $("#" + id).val(num);
        },
    });
    $.consecutivo();
    $.Metas();

    $("#id_eje").on({
        change: function (e) {
            e.preventDefault();
            var datos = {
                OPCION: "CONSULTARPROGRAMAS",
                id_eje: $("#id_eje").val()
            };
            $.ajax({
                type: "POST",
                url: "../PlanDesarrollo/Metas_Pro.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    $("#id_programa").html("");
                    $("#id_subprograma").html("");
                    if (data['TIENE'] === 1) {
                        $("#id_programa").append("<option value='0'>Seleccione</option>");
                        for (var i = 1; i <= data.programas.TAM; i++) {
                            $("#id_programa").append("<option value='" + data.programas.ID_PROGRAMA[i] + "'>" + data.programas.PROGRAMA[i] + "</option>");
                        }
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

    $("#id_programa").on({
        change: function (e) {
            e.preventDefault();
            var datos = {
                OPCION: "CONSULTARSUBPROGRAMAS",
                id_eje: $("#id_eje").val(),
                id_pro: $("#id_programa").val()
            };
            $.ajax({
                type: "POST",
                url: "../PlanDesarrollo/Metas_Pro.php",
                data: datos,
                async: false,
                dataType: 'JSON',
                success: function (data) {
                    $("#id_subprograma").html("");
                    if (data['TIENE'] === 1) {
                        $("#id_subprograma").append("<option value='0'>Seleccione</option>");
                        for (var i = 1; i <= data.programas.TAM; i++) {
                            $("#id_subprograma").append("<option value='" + data.programas.ID_SUBPROGRAMA[i] + "'>" + data.programas.SUBPROGRAMA[i] + "</option>");
                        }
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

    $("#btn_guardar").on({
        click: function (e) {
            e.preventDefault();
            var id = $("#id").val();
            var clasificacion = $("#clasificacion").val();
            var codigo = $("#codigo").val();
            var descripcion = $("#descripcion").val();
            var objetivo = $("#objetivo").val();

            // var id_secretaria = $("#id_secretaria").val();
            var id_secretaria = [];
            var Data = $("#id_secretaria").select2("data");
            for (var i = 0; i <= Data.length - 1; i++) {
                id_secretaria.push(Data[i].id);
            }


            var id_eje = $("#id_eje").val();
            var id_programa = $("#id_programa").val();
            var id_subprograma = $("#id_subprograma").val();
            var cons = $("#cons").val();
            if (codigo === "") {
                $.Alert("#msg", "Por Favor Llene El codigo...", "warning", "warning");
                return;
            }
            if (descripcion === "") {
                $.Alert("#msg", "Por Favor Digite la Descripción...", "warning", "warning");
                return;
            }
            if (objetivo <= 0) {
                $.Alert("#msg", "Por Favor Llene La Meta...", "warning", "warning");
                return;
            }
            if (id_secretaria === "0") {
                $.Alert("#msg", "Por Favor Seleccione la Secretaria...", "warning", "warning");
                return;
            }
            if (id_eje === "0") {
                $.Alert("#msg", "Por Favor Seleccione el Eje...", "warning", "warning");
                return;
            }
            if (id_programa === "0") {
                $.Alert("#msg", "Por Favor Seleccione el Programa...", "warning", "warning");
                return;
            }
            if (id_subprograma === "0") {
                $.Alert("#msg", "Por Favor Seleccione el Sub Programa...", "warning", "warning");
                return;
            }
            var datos = {
                OPCION: opcion,
                cons: cons,
                id: id,
                clasificacion: clasificacion,
                codigo: codigo,
                descripcion: descripcion,
                objetivo: objetivo,
                id_secretaria: id_secretaria.join(','),
                id_eje: id_eje,
                id_programa: id_programa,
                id_subprograma: id_subprograma,
                aumentar: aumentar
            };
            $.ajax({
                type: "POST",
                async: false,
                url: "../PlanDesarrollo/Metas_Pro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data === 1) {
                        $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                        $("#id").val("0");
                        $("#clasificacion").val(0);
                        $('#clasificacion').css('width', '100%');
                        $("#clasificacion").select2();
                        // $("#codigo").val();
                        $("#descripcion").val("");
                        $("#objetivo").val("");
                        $("#id_secretaria").val("0");
                        $('#id_secretaria').css('width', '100%');
                        $("#id_secretaria").select2();
                        $("#id_eje").val("0");
                        $('#id_eje').css('width', '100%');
                        $("#id_eje").select2();
                        $("#id_programa").html("");
                        $("#id_subprograma").html("");
                        aumentar = "SI";
                        $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Crear Meta de Producto</a>");
                        $.consecutivo();
                        $.Metas();
                    } else {
                        $.Alert("#msg", "HA OCURRIDO UN ERROR...", "warning", "warning");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });
    $('#tab_PlanAccion').on("click", ".btnEditar", function (e) {
        e.preventDefault();
        var fila = $(this).parents('tr');
        aumentar = "NO";
        $("#clasificacion").val(fila.data('clasificacion'));
        $('#clasificacion').css('width', '100%');
        $("#clasificacion").select2();
        $("#id").val(fila.data('id'));
        $("#descripcion").val(fila.data('descripcion'));
        $("#codigo").val(fila.data('codigo'));
        $("#objetivo").val(fila.data('objetivo'));


        // $("#id_secretaria").val(fila.data('id_dependencia'));
        // $('#id_secretaria').css('width', '100%');
        // $("#id_secretaria").select2();

        var depen = fila.data("id_dependencia") + "";
        var resp = depen.split(",")
        $("#id_secretaria").val(resp).change();
        // if (depen.indexOf(",") != -1) {

        // } else {
        //     $("#id_secretaria").val(depen).change();
        // }

        $('#id_secretaria').css('width', '100%');
        $("#id_secretaria").select2();

        $("#id_eje").val(fila.data('id_eje'));
        $('#id_eje').css('width', '100%');
        $("#id_eje").select2();
        $("#id_eje").change();
        $("#id_programa").val(fila.data('id_programa'));
        $('#id_programa').css('width', '100%');
        $("#id_programa").select2();
        $("#id_programa").change();
        $("#id_subprograma").val(fila.data('id_subprograma'));
        $('#id_subprograma').css('width', '100%');
        $("#id_subprograma").select2();

        $("#tab_01").removeClass("active in");
        $("#tab_01_pp").removeClass("active in");
        $("#tab_02").addClass("active in");
        $("#tab_02_pp").addClass("active in");
        $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Meta de Producto</a>");
    });
    $('#tab_PlanAccion').on("click", ".btnEliminar", function (e) {
        e.preventDefault();
        var fila = $(this).parents('tr');
        if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
            opcion = "ELIMINAR";
            var datos = {
                id: fila.data('id'),
                OPCION: opcion
            };
            $.ajax({
                type: "POST",
                url: "../PlanDesarrollo/Metas_Pro.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data === 1) {
                        $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                        $.Metas();
                    } else if (data === "nbien") {
                        $.Alert("#msg2", "Esta Fuente no se puede Eliminar", "warning", "warning");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });
    $("#btn_cancelar").on("click", function () {
        if (confirm("\xbfEsta seguro de Cancelar la operaci\xf3n?")) {
            $("#id").val("0");
            $("#clasificacion").val(0);
            $('#clasificacion').css('width', '100%');
            $("#clasificacion").select2();
            // $("#codigo").val();
            $("#descripcion").val("");
            $("#objetivo").val("");
            $("#id_secretaria").val("0");
            $('#id_secretaria').css('width', '100%');
            $("#id_secretaria").select2();
            $("#id_eje").val("0");
            $('#id_eje').css('width', '100%');
            $("#id_eje").select2();
            $("#id_programa").html("");
            $("#id_subprograma").html("");
            aumentar = "SI";
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Crear Meta de Producto</a>");
            $.consecutivo();
            $.Metas();

        }

    });
    $("#btn_volver").click(function () {
        window.location.href = '../MetasProducto/';

    });

    $("#objetivo").on({
        change: function (e) {
            e.preventDefault();
            if ($(this).val() === "NaN") {
                $(this).val("");
            }
        }
    });
});

function check(e) {
    var key = (document.all) ? e.keyCode : e.which;
    var tecla = String.fromCharCode(key).toLowerCase();
    //        var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    var letras = "0123456789.";
    var especiales = "8-37-39-46";

    var tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}