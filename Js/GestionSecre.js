$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_secre").addClass("active");
    var Op_Validar = [];
    var Op_Vali = "Ok"

    $.extend({
        Secre: function () {
            var datos = {
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagSecretarias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Secre').html(data['cad']);
                    $('#bot_Secre').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqDepen: function (val) {


            var datos = {
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagSecretarias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Secre').html(data['cad']);
                    $('#bot_Secre').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editSecre: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditSecre",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Cod').val(data['cod_secretarias']);
                    $('#txt_Desc').val(data['des_secretarias']);
                    $('#txt_Respo').val(data['responsanble_secretarias']);
                    $('#txt_Corre').val(data['correo_secretarias']);
                    $('#txt_obser').val(data['obs_secretarias']);
                    $('#Src_File').val(data['ico_secretarias']);
                    $('#hex4').val(data['color']);

                    if (data['ico_secretarias'] !== "") {
                        $('#MostImg').show();
                        $("#contenedor img").attr("src", "../Administracion/" + data['ico_secretarias']);
                        //$('#ImgEmpresa').attr('src', data['ico_secretarias']);
                    }
                    $('#txt_id').val(cod);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').show();

            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_Corre").prop('disabled', false);
            $("#txt_Respo").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);


        },
        VerSecre: function (cod) {

            var datos = {
                ope: "BusqEditSecre",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Cod').val(data['cod_secretarias']);
                    $('#txt_Desc').val(data['des_secretarias']);
                    $('#txt_Respo').val(data['responsanble_secretarias']);
                    $('#txt_Corre').val(data['correo_secretarias']);
                    $('#txt_obser').val(data['obs_secretarias']);
                    $('#Src_File').val(data['ico_secretarias']);
                    $('#hex4').val(data['color']);
                    if (data['ico_secretarias'] !== "") {
                        $('#MostImg').show();
                        $("#contenedor img").attr("src", "../Administracion/" + data['ico_secretarias']);

                    }
                    $('#txt_id').val(cod);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


            $("#txt_Cod").prop('disabled', false);
            $("#txt_Desc").prop('disabled', false);
            $("#txt_Corre").prop('disabled', false);
            $("#txt_Respo").prop('disabled', false);
            $("#txt_obser").prop('disabled', false);

            $("#responsive").modal({backdrop: 'static', keyboard: false});
            $('#mopc').hide();

        },
        Procesos: function (cod) {
            var IdSec = cod;
            if (IdSec === undefined) {
                IdSec = $('#txt_idProc').val();
            } else {
                $('#txt_idProc').val(IdSec);
                $("#ModalProcesos").modal({backdrop: 'static', keyboard: false});

            }

            var datos = {
                ope: "BusqInfProcSec",
                cod: IdSec
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tb_Procesos').html(data['Procesos']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });





        },
        deletSecre: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../Administracion/GuardarSecretaria.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            $.Alert("#msg2", "Operación Realizada Exitosamente...", "success", "check");
                            $.Secre();
                        } else if (data === "nbien") {
                            $.Alert("#msg2", "Esta Secretaria no se puede Eliminar, Se encuentra relacionado a un Proyecto", "warning", "warning");
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
                url: "../Paginadores/PagSecretarias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Secre').html(data['cad']);
                    $('#bot_Secre').html(data['cad2']);
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
                url: "../Paginadores/PagSecretarias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Secre').html(data['cad']);
                    $('#bot_Secre').html(data['cad2']);
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
                url: "../Paginadores/PagSecretarias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_Secre').html(data['cad']);
                    $('#bot_Secre').html(data['cad2']);
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

            Id = "#archivos";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_Arch").addClass("has-error");
            } else {
                $("#From_Arch").removeClass("has-error");
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
        Format_Bytes: function (bytes, decimals) {
            if (bytes == 0)
                return '0 Byte';
            var k = 1024;
            var dm = decimals + 1 || 3;
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
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

            var ruta = "../Administracion/SubirImgSecre.php";

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
                        $.Alert("#msg", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                },
                beforeSend: function () {
                    $('#cargando').modal({backdrop: 'static', keyboard: false});
                },
                complete: function () {
                    $('#cargando').modal('hide');
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Responsables: function () {
            var datos = {
                ope: "ConsRespon"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbResponsables").html(data['respon']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        BuscInfResp: function (id) {
            var datos = {
                ope: "BuscInfResp",
                id: id
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_Corre").val(data['email']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        AddProceso: function () {
            var Des=$("#txt_DesProc").val();
            var Cla=$("#CbClaPro").val();
            
            if (Des === "") {
                $.Alert("#msg", "Por Favor Ingrese la Descripción del Proceso...", "warning", "warning");
                return;
            }
            
            if (Cla === " ") {
                $.Alert("#msg", "Por Favor Seleccione la Clasificación...", "warning", "warning");
                return;
            }

            $.UploadDoc();

            var datos = {
                Desc: $("#txt_DesProc").val(),
                Clas: $("#CbClaPro").val(),
                Obj: $("#txt_ObjetivoPro").val(),
                IdSec: $("#txt_idProc").val(),
                acc: $("#accProc").val(),
                id: $("#txt_idProc").val()
            };

            $.ajax({
                type: "POST",
                url: "../Administracion/GuardarProcesos.php",
                data: datos,
                success: function (data) {
                    if ($.trim(data) === "bien") {
                        $.Alert("#msgProc", "Datos Guardados Exitosamente...", "success", "check");
                        $.Procesos();

                        $("#txt_DesProc").val('');
                        $("#CbClaPro").selectpicker("val", " ");
                        $("#txt_ObjetivoPro").val('');

                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        QuitarProceso: function (id) {
            

            $.UploadDoc();

            var datos = {
                cod: id,
                acc: "3"
            };

            $.ajax({
                type: "POST",
                url: "../Administracion/GuardarProcesos.php",
                data: datos,
                success: function (data) {
                    if ($.trim(data) === "bien") {
                        $.Alert("#msgProc", "Dato Eliminado Exitosamente...", "success", "check");
                        $.Procesos();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        }

    });
    //======FUNCIONES========\\
    $.Secre();
    $.Responsables();

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
        $("#txt_Corre").val("");
        $("#txt_Respo").val("");
        $("#archivos").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#txt_Respo").prop('disabled', false);
        $("#txt_Corre").prop('disabled', false);
        $('#MostImg').hide();


        $("#responsive").modal({backdrop: 'static', keyboard: false});
        $('#mopc').show();


    });

    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "verfSecre",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
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
        $("#txt_Respo").val("");
        $("#txt_Corre").val("");
        $("#archivos").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#txt_Corre").prop('disabled', false);
        $("#txt_Respo").prop('disabled', false);
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
            cor: $("#txt_Corre").val(),
            resp: $("#txt_Respo").val(),
            obs: $("#txt_obser").val(),
            cbr: $("#CbResponsables").val(),
            url: $("#Src_File").val(),
            col: $("#hex4").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "../Administracion/GuardarSecretaria.php",
            data: datos,
            success: function (data) {
                if ($.trim(data) === "bien") {
                    $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");
                    $.Secre();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_Corre").prop('disabled', true);
                    $("#txt_Respo").prop('disabled', true);
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
