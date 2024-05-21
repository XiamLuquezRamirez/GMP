$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_plan").addClass("start active open");
    $("#menu_subPrograma").addClass("start active open");
    $("#menu_GesSubPrograma").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";

    $.extend({
        prog: function () {

            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProgramas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Programas').html(data['cad']);
                    $('#bot_Programas').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqProgramas: function (val) {


            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProgramas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Programas').html(data['cad']);
                    $('#bot_Programas').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqProgramasVent: function (val) {

            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nregVent").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVent').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editProg: function (cod) {
            $('#acc').val("2");
            $('#MostImg').hide();
            $('#archivos').val("");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditPrograma",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    var tam = data['codestr'].length;
                    var codSub = data['codprog'].substr(parseInt(tam) + 1);
                    $('#txt_codigo').val(codSub);
                    $('#txt_cod_pp').val(data['codestr'] + "-");
                    $('#txt_Descripcion').val(data['nomprog']);
                    $('#txt_obser').val(data['obsprog']);
                    $('#txt_id_ej').val(data['idej']);
                    $('#txt_nomb_eje').val(data['nomej']);
                    $('#txt_id_Est').val(data['idestr']);
                    $('#txt_nomb_est').val(data['nomestr']);
                    $('#txt_obser').val(data['obsprog']);
                    $('#Src_File').val(data['IMG']);

                    if (data['IMG'] !== "") {
                        $('#MostImg').show();
                        $("#contenedor img").attr("src", "../PlanDesarrollo/" + data['IMG']);
                    }
                    $('#txt_id').val(cod);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $("#btn_guardar").show();
            $("#btn_nuevo2").show();
            $("#btn_cerrar").show();
            $('#nestr').show();

            $("#txt_codigo").prop('disabled', false);
            $("#txt_Descripcion").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        ExcelProg: function () {
            window.open('../PlanDesarrollo/ExcelPrograma.php');
        },
        ExcelPlan: function () {
            window.open('../PlanDesarrollo/ExcelPlanDesarrollo.php');
        },
        VerProg: function (cod) {

            var datos = {
                ope: "BusqEditPrograma",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    var tam = data['codestr'].length;
                    var cod = data['codprog'].substr(parseInt(tam) + 1);
                    $('#txt_codigo').val(cod);
                    $('#txt_cod_pp').val(data['codestr'] + "-");
                    $('#txt_Descripcion').val(data['nomprog']);
                    $('#txt_id_ej').val(data['idej']);
                    $('#txt_nomb_eje').val(data['nomej']);
                    $('#txt_id_Est').val(data['idestr']);
                    $('#txt_nomb_est').val(data['nomestr']);
                    $('#txt_obser').val(data['obsprog']);
                    $('#Src_File').val(data['IMG']);

                    if (data['IMG'] !== "") {
                        $('#MostImg').show();
                        $("#contenedor img").attr("src", "../PlanDesarrollo/" + data['IMG']);
                    }
                    $('#txt_id').val(cod);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $("#btn_guardar").hide();
            $("#btn_nuevo2").hide();
            $("#btn_cerrar").show();
            $('#nestr').show();

            $("#txt_codigo").prop('disabled', true);
            $("#txt_Descripcion").prop('disabled', true);
            $("#txt_obser").prop('disabled', true);

            $("#responsive").modal({backdrop: 'static', keyboard: false});
         
        },
        deletProg: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../PlanDesarrollo/GuardarProgramas.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", 'check');
                            $.prog();
                        } else if (data === "nobien") {
                            $.Alert("#msg2", "No se Puede Realizar la Operación... Existen Metas relacionados con este Programa.", "warning", 'warning');
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProgramas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Programas').html(data['cad']);
                    $('#bot_Programas').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        paginadorVent: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq").val(),
                nreg: $("#nregVent").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVent').html(data['cbp']);
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
                url: "../Paginadores/PagProgramas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Programas').html(data['cad']);
                    $('#bot_Programas').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopagVent: function (pag) {

            var datos = {
                pag: pag,
                bus: $("#busq").val(),
                nreg: $("#nregVent").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVent').html(data['cbp']);
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
                url: "../Paginadores/PagProgramas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Programas').html(data['cad']);
                    $('#bot_Programas').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        combopag2Vent: function (nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq").val(),
                pag: $("#selectpagVent").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompVent.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Vent').html(data['cad']);
                    $('#bot_Vent').html(data['cad2']);
                    $('#cobpagVent').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Validar: function () {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_cod_pp";
            Value = $(Id).val();

            if (Value === "" || Value === " ") {

                Op_Validar.push("Fail");
                $("#From_Codigo0").addClass("has-error");
            } else {
                $("#From_Codigo0").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_codigo";
            Value = $(Id).val();

            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Codigo").addClass("has-error");
            } else {

                $("#From_Codigo").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_Descripcion";
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
        SelEjes: function (par) {

            var ppar = par.split("//");

            $("#txt_cod_pp").val(ppar[4] + '-');
            $("#txt_id_ej").val(ppar[0]);
            $("#txt_id_Est").val(ppar[3]);
            $("#txt_nomb_eje").val(ppar[2]);
            $("#txt_nomb_est").val(ppar[5]);
            $("#ventana").modal("hide");
            $('#nestr').show();
        },
        Load_ventana: function (op) {
            if (op === "1") {
                $("#ventana").modal({backdrop: 'static', keyboard: false});
            }

            var datos = {
                bus: $("#busq").val(),
                pag: "1",
                op: "1",
                nreg: $("#nregVent").val()

            };
            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompVent.php",
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
        conse: function () {


            var datos = {
                ope: "ConConsecutivo",
                tco: "SUBPROGRAMAS"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data['flag'] === "n") {
                        $("#responsive").modal('toggle');
                        $.Alert("#msg2", "No se Puede Realizar la Operación... No se creado un Consecutivo para los Programas. Verifique...", "warning", 'warning');
                    } else {
                        $("#txt_codigo").val(data['StrAct']);
                        $("#cons").val(data['cons']);
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UploadImg: function () {
            var archivos = document.getElementById("archivos");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
                archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }

            var ruta = "../PlanDesarrollo/SubirImgPlan.php";

            $.ajax({
                async: false,
                url: ruta,
                type: "POST",
                data: archivos,
                contentType: false,
                processData: false,
                success: function (datos)
                {
                    var par_res = datos.split("//");
                    if (par_res[0] === "Bien") {
                        $('#Src_File').val(par_res[1].trim());
                        $('#MostImg').show();
                        $("#contenedor img").attr("src", "../PlanDesarrollo/" + par_res[1].trim());
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msg", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                },
                beforeSend: function () {
                    $('#cargando').modal('show');
                },
                complete: function () {
                    $('#cargando').modal('hide');
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }

    });
    //======FUNCIONES========\\
    $.prog();

    //==============\\

    $("#btn_para").on("click", function () {
        $.Load_ventana('1');
    });


    $("#busq").on("keypress", function (event) {
        if (event.which == 13) {
            $.Load_ventana('2');
        }
    });

    $('#btn_img').on('click', function () {
        $("#ventanaImg").modal("show");
    });

    $("#btn_nuevo1").on("click", function () {
        $.conse();
        $('#acc').val("1");
        $("#txt_cod_pp").val("");
        $("#txt_codigo").val("");
        $("#txt_Descripcion").val("");
        $("#txt_nomb_est").val("");
        $("#txt_obser").val("");
        $("#archivos").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        //   $("#txt_codigo").prop('disabled', false);
        $("#txt_Descripcion").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $("#btn_guardar").show();
        $("#btn_nuevo2").show();
        $("#btn_cerrar").show();
        $('#nestr').hide();
        $('#MostImg').hide();


    });

    $("#txt_codigo").on("change", function () {

        var datos = {
            ope: "verfProg",
            cod: $("#txt_cod_pp").val() + $("#txt_codigo").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_Codigo").addClass("has-error");
                    $.Alert("#msg", "Este Código ya Esta Registrado...", "warning", "warning");
                    $('#txt_codigo').focus();
                    $("#txt_codigo").val("");
                } else {
                    $("#From_Codigo").removeClass("has-error");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });



    $("#btn_nuevo2").on("click", function () {
        $.conse();
        $('#acc').val("1");

        $("#txt_cod_pp").val("");
        $("#txt_codigo").val("");
        $("#txt_Descripcion").val("");
        $("#txt_nomb_est").val("");
        $("#txt_obser").val("");
        $("#archivos").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        //   $("#txt_codigo").prop('disabled', false);
        $("#txt_Descripcion").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);

        $('#nestr').hide();
        $('#MostImg').hide();

    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
            return;
        }

        $.UploadImg();
        $.conse();

        var datos = {
            cod: $("#txt_cod_pp").val() + $("#txt_codigo").val(),
            idej: $("#txt_id_ej").val(),
            ides: $("#txt_id_Est").val(),
            des: $("#txt_Descripcion").val(),
            obs: $("#txt_obser").val(),
            url: $("#Src_File").val(),
            acc: $("#acc").val(),
            cons: $("#cons").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../PlanDesarrollo/GuardarProgramas.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", 'check');
                    // alert("Datos Guardados Exitosamente");
                    $.prog();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_codigo").prop('disabled', true);
                    $("#txt_Descripcion").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});
///////////////////////
