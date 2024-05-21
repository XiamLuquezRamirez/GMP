$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_Tipolo").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok";

    $.extend({
        Tipo: function () {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagTipologia.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Tipologia').html(data['cad']);
                    $('#bot_Tipologia').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqOrInfo: function (val) {

            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagTipologia.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Tipologia').html(data['cad']);
                    $('#bot_Tipologia').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editTipolog: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditTipoProyecto",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Cod').val(data['cod_tipolo']);
                    $('#txt_Desc').val(data['des_tipolo']);
                    $('#txt_obser').val(data['obs_tipolo']);
                    $('#Src_File').val(data['img_tipolo']);
                    if (data['img_tipolo'] !== "") {
                        $('#MostImg').show();
                        $('#ImgEmpresa').attr('src', "../Administracion/" + data['img_tipolo']);
                    }
                    $('#txt_id').val(cod);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();
            $('#btn_Clasif').show();

            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        VerTipolog: function (cod) {

            var datos = {
                ope: "BusqEditTipoProyecto",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Cod').val(data['cod_tipolo']);
                    $('#txt_Desc').val(data['des_tipolo']);
                    $('#txt_obser').val(data['obs_tipolo']);
                    $('#Src_File').val(data['img_tipolo']);
                    if (data['img_tipolo'] !== "") {
                        $('#MostImg').show();
                        $('#ImgEmpresa').attr('src', "../Administracion/" + data['img_tipolo']);
                    }
                    $('#txt_id').val(cod);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $('#btn_Clasif').show();

            $("#txt_Cod").prop('disabled', true);
            $("#txt_Desc").prop('disabled', true);
            $("#txt_obser").prop('disabled', true);

            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').hide();

        },
        deletTipolog: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarTipologia.php",
                    data: datos,
                    success: function (data) {

                        var par = data.split("-");
                        if (trimAll(par[0]) === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Tipo();
                        } else if (trimAll(par[0]) === "nbien") {
                            $.Alert("#msg2", "Esta Tipologia no se puede Eliminar, Se encuentra relacionado a un Proyecto", "warning", "warning");
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
                url: "../Paginadores/PagTipologia.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Tipologia').html(data['cad']);
                    $('#bot_Tipologia').html(data['cad2']);
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
                url: "../Paginadores/PagTipologia.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Tipologia').html(data['cad']);
                    $('#bot_Tipologia').html(data['cad2']);
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
                url: "../Paginadores/PagTipologia.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Tipologia').html(data['cad']);
                    $('#bot_Tipologia').html(data['cad2']);
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
        UploadDoc: function () {
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

            var ruta = "../Administracion/SubirImgTipo.php";

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
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msgArch", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                }
            });
        },

        Format_Bytes: function (bytes, decimals) {
            if (bytes == 0)
                return '0 Byte';
            var k = 1024;
            var dm = decimals + 1 || 3;
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
        }

    });
    //======FUNCIONES========\\
    $.Tipo();
    $("#archivos").on("change", function () {
        /* Limpiar vista previa */
        $("#vista-previa").html('');
        var archivos = document.getElementById('archivos').files;
        var navegador = window.URL || window.webkitURL;
        /* Recorrer los archivos */
        for (x = 0; x < archivos.length; x++)
        {
            /* Validar tamaño y tipo de archivo */
            var size = archivos[x].size;
            var type = archivos[x].type;
            var name = archivos[x].name;

            var Mb = $.Format_Bytes(size, 2);
            $("#fileSize").html(Mb);
            $("#Name_File").val(name);
        }
    });

    $('#btn_img').on('click', function () {
        $("#ventanaImg").modal({backdrop: 'static', keyboard: false});
    });


    //==============\\
    $("#btn_nuevo1").on("click", function () {
        $('#acc').val("1");
        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $('#mopc').show();
        $('#btn_Clasif').hide();
        $('#MostImg').hide();


    });

    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "verfTipologPtoyect",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                alert(data);
                if (data === "1") {
                    $("#From_Codigo").addClass("has-error");
                    $.Alert("#msg", "Este Código ya Esta Registrado...", "warning", "warning");

                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_nuevo2").on("click", function () {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $('#btn_Clasif').hide();
        $('#MostImg').hide();




    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", "warning");
            return;
        }
        $.UploadDoc();
        var datos = {
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            obs: $("#txt_obser").val(),
            acc: $("#acc").val(),
            url: $("#Src_File").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarTipologia.php",
            data: datos,
            success: function (data) {
                var par = data.split("-");
                if (trimAll(par[0]) === "bien") {
                    $("#txt_id").val(par[1]);
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.Tipo();

                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_Corre").prop('disabled', true);
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
