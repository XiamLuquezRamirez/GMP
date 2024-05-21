$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_plan").addClass("start active open");
    $("#menu_plan_ejes").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";

    $.extend({
        ejes: function () {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEjes.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Ejes').html(data['cad']);
                    $('#bot_Ejes').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqResponsa: function (val) {


            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEjes.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Ejes').html(data['cad']);
                    $('#bot_Ejes').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editEjes: function (cod) {
            $('#acc').val("2");
            $('#MostImg').hide();
            $('#archivos').val("");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditEjes",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Cod').val(data['CODIGO']);
                    $('#txt_Desc').val(data['NOMBRE']);
                    $('#txt_obser').val(data['OBSERVACION']);
                    $('#Src_File').val(data['IMG']);
                    $("#Cbx_Dime").val(data["DIMENSION"]).change();

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

            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);

        },
        VerEjes: function (cod) {

            var datos = {
                ope: "BusqEditEjes",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Cod').val(data['CODIGO']);
                    $('#txt_Desc').val(data['NOMBRE']);
                    $('#txt_obser').val(data['OBSERVACION']);
                    $('#Src_File').val(data['IMG']);
                    $("#Cbx_Dime").val(data["DIMENSION"]).change();
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
            $('#mopc').show();

            $("#txt_Cod").prop('disabled', true);
            $("#txt_Desc").prop('disabled', true);
            $("#txt_obser").prop('disabled', true);


            $("#btn_guardar").hide();
            $("#btn_nuevo2").hide();
            $("#btn_cerrar").show();

        },
        deletEjes: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../PlanDesarrollo/GuardarEjes.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", 'check');
                            $.ejes();
                        } else if (data === "nobien") {
                            $.Alert("#msg2", "No se Puede Realizar la Operación... Existen Componentes relacionados con este Eje.", "warning", 'warning');
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
                bus: $("#busq_ejes").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEjes.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
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
                bus: $("#busq_ejes").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEjes.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Ejes').html(data['cad']);
                    $('#bot_Ejes').html(data['cad2']);
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
                bus: $("#busq_ejes").val(),
                pag: $("#selectpag").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagEjes.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Ejes').html(data['cad']);
                    $('#bot_Ejes').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Validar: function () {
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
            Id = "#Cbx_Dime";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Dimension").addClass("has-error");
            } else {
                $("#From_Dimension").removeClass("has-error");
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
        ExcelMet: function () {
            window.open('../PlanDesarrollo/ExcelEjes.php');
        },
        ExcelPlan: function () {
            window.open('../PlanDesarrollo/ExcelPlanDesarrollo.php');
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
        conse: function () {


            var datos = {
                ope: "ConConsecutivo",
                tco: "EJES"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data['flag'] === "n") {
                        $("#responsive").modal('toggle');
                        $.Alert("#msg2", "No se Puede Realizar la Operación... No se creado un Consecutivo para los Ejes. Verifique...", "warning", 'warning');
                    } else {
                        $("#txt_Cod").val(data['StrAct']);
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
        },
        Dimensiones: function () {

            var datos = {
                ope: "dimensiones"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#Cbx_Dime').html(data['Dime']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }

    });
    //======FUNCIONES========\\
    $.ejes();
    $.Dimensiones();

    //==============\\
    $("#btn_nuevo1").on("click", function () {

        $.conse();
        $('#acc').val("1");
        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");
        $('#MostImg').hide();
        $("#archivos").val("");
        $("#Cbx_Dime").select2("val", " ");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        //    $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $("#btn_guardar").show();
        $("#btn_nuevo2").show();
        $("#btn_cerrar").show();
        $('#MostImg').hide();


    });

    $("#btn_Excel").click(function () {
        window.open('../PlanDesarrollo/ExcelEjes.php');

    });


    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "verfEje",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                if (data === "1") {
                    $("#From_Codigo").addClass("has-error");
                    $.Alert("#msg", "Este Código ya Esta Registrado...", "warning", 'warning');

                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                } else {
                    $("#From_Codigo").removeClass("has-error");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $('#btn_img').on('click', function () {
        $("#ventanaImg").modal({backdrop: 'static', keyboard: false});
    });

    $("#btn_nuevo2").on("click", function () {

        $.conse();
        $('#acc').val("1");
        $('#MostImg').hide();

        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");
        $("#archivos").val("");
        $("#Cbx_Dime").select2("val", " ");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        //     $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $('#MostImg').hide();



    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", 'warning');
            return;
        }

        $.UploadImg();
        $.conse();

        var datos = {
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            obs: $("#txt_obser").val(),
            dime: $("#Cbx_Dime").val(),
            url: $("#Src_File").val(),
            acc: $("#acc").val(),
            cons: $("#cons").val(),
            id: $("#txt_id").val()

        };

        $.ajax({
            type: "POST",
            url: "../PlanDesarrollo/GuardarEjes.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", 'check');
                    // alert("Datos Guardados Exitosamente");
                    $.ejes();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
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
