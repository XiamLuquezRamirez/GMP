$(document).ready(function() {
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_conf_emp").addClass("active");

    var Datos = "";
    var Opcion = "";
    var TK_ID = "";
    var Op_Validar = [];
    var Op_Vali = "Ok";
    var contLocalizacion = 0;
    var Dat_Localiza = "";
    Opcion = "1";
    $.extend({
        Companias: function() {
            var datos = {
                opc: "CargDependencia",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompanias.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_companias').html(data['cad']);
                    $('#bot_companias').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Dta_Localizacion: function() {
            Dat_Localiza = "";
            $("#tb_Localiza").find(':input').each(function() {
                Dat_Localiza += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Localiza += "&Long_Localiza=" + $("#contLocalizacion").val();
        },
        AddLocalizacion: function() {

            var CodDepa = $("#CbDepa").val();
            var DesDepa = $('#CbDepa option:selected').text();
            var CodMun = $("#CbMun").val();
            var DesMun = $('#CbMun option:selected').text();
            var CodCor = $("#CbCorre").val();
            var DesCor = $('#CbCorre option:selected').text();
            var CodBar = $("#CbBarrio").val();
            var DesBar = $('#CbBarrio option:selected').text();

            var lat = $('#lat').val();
            var long = $('#long').val();


            contLocalizacion = $("#contLocalizacion").val();

            contLocalizacion++;
            var fila = '<tr class="selected" id="filaLoca' + contLocalizacion + '" >';


            fila += "<td>" + contLocalizacion + "</td>";
            fila += "<td>" + DesDepa + "</td>";
            fila += "<td>" + DesMun + "</td>";
            fila += "<td>" + DesCor + "</td>";
            fila += "<td>" + DesBar + "</td>";
            fila += "<td><input type='hidden' id='Loca" + contLocalizacion + "' name='Localiza' value='" + CodDepa + "//" + CodMun + "//" + CodCor + "//" + CodBar + "//" + lat + "//" + long + "' />\n\
<a onclick=\"$.QuitarLocal('filaLoca" + contLocalizacion + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
<a onclick=\"$.VerLoca('" + lat + "//" + long + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-map-marker\"></i> Mostrar</a>\n\
</td></tr>";
            $('#tb_Localiza').append(fila);
            $.reordenarLocal();
            $.limpiarLoca();
            $("#contLocalizacion").val(contLocalizacion);

        },
        reordenarLocal: function() {
            var num = 1;
            $('#tb_Localiza tbody tr').each(function() {
                $(this).find('td').eq(0).text(num);
                num++;
            });

            num = 1;
            $('#tb_Localiza tbody input').each(function() {
                $(this).attr('id', "Loca" + num);
                num++;
            });
        },
        limpiarLoca: function() {

            $("#lat").val("");
            $("#long").val("");
            $("#CbDepa").select2("val", " ");
            $("#CbMun").select2("val", " ");
            $("#CbCorre").select2("val", " ");
            $("#CbBarrio").select2("val", " ");

        },
        CargaDato: function() {

            var datos = {
                ope: "CargaDatCompa"
            };

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {

                    $("#CbDepa").html(data['dpto']);
                    $("#CbBarrio").html(data['barrio']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqProyect: function(val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompanias.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_companias').html(data['cad']);
                    $('#bot_companias').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        BusMun: function(val) {
            initialize();
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
            if ($('#CbDepa option:selected').text() !== "Seleccione...") {
                var adress = $('#CbDepa option:selected').text().split(' - ');
                codeAddress(adress[1]);
            }


        },
        BusCorr: function(val) {

            var datos = {
                ope: "BusCorr",
                cod: val
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {

                    $("#CbCorre").html(data['corr']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            if ($('#CbMun option:selected').text() !== "N/A") {
                if ($('#CbMun option:selected').text() !== "Seleccione...") {
                    var adressDep = $('#CbDepa option:selected').text().split(' - ');
                    var adressMun = $('#CbMun option:selected').text().split(' - ');
                    codeAddress(adressDep[1] + ", " + adressMun[1]);
                }
            }


            $("#CbCorre").prop('disabled', false);

        },
        BusUbiCor: function() {
            if ($('#CbCorre option:selected').text() !== "N/A") {
                if ($('#CbCorre option:selected').text() !== "Seleccione...") {
                    var adressDep = $('#CbDepa option:selected').text().split(' - ');
                    var adressMun = $('#CbMun option:selected').text().split(' - ');
                    var adressCor = $('#CbCorre option:selected').text().split(' - ');
                    codeAddress(adressDep[1] + ", " + adressMun[1] + ", " + adressCor[1]);
                }

                if ($('#CbCorre option:selected').text() === "20001000 - VALLEDUPAR") {
                    $("#CbBarrio").prop('disabled', false);
                }
            }

        },
        BusUbiBar: function() {
            if ($('#CbBarrio option:selected').text() !== "N/A") {
                if ($('#CbBarrio option:selected').text() !== "Seleccione...") {
                    var adressDep = $('#CbDepa option:selected').text().split(' - ');
                    var adressMun = $('#CbMun option:selected').text().split(' - ');
                    var adressCor = $('#CbCorre option:selected').text().split(' - ');
                    var adressBar = $('#CbBarrio option:selected').text().split(' - ');
                    codeAddress(adressDep[1] + ", " + adressMun[1] + ", " + adressCor[1] + ", " + adressBar[1]);
                }

            }

        },
        addComp: function() {

            if ($("#perm").val() === "n") {
                $('#botones').hide();
                $.Alert("#msg", "No Tiene permisos para Crear Compañias", "warning", 'warning');
            }
        },
        VerLoca: function(dir) {
            parlatlog = dir.split("//");
            $('#lat').val(parlatlog[0]);
            $('#long').val(parlatlog[1]);
            initialize();
        },
        editComp: function(cod) {
            $('#acc').val("2");

            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            var Datos = {
                opc: "CargarDatEmpresa",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: Datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#txt_nit").val(data['companias_nit']);
                    $("#txt_tipo_nit").selectpicker("val", data['companias_tid']);
                    $("#txt_razon_social").val(data['companias_descripcion']);
                    $("#txt_represe").val(data['companias_rlegal']);
                    $("#txt_depart").val(data['companias_dep']);
                    $("#txt_muni").val(data['companias_muni']);
                    $("#txt_direccion").val(data['companias_direccion']);
                    $("#txt_telefono").val(data['companias_telefono1']);
                    $("#txt_fax").val(data['companias_fax']);
                    $("#txt_email").val(data['companias_email']);
                    $("#txt_usuusu").val(data['companias_login']);
                    if (data['companias_img'] !== "") {
                        $('#MostImg').show();
                        $('#ImgEmpresa').attr('src', data['companias_img']);
                    }

                    $("#tb_Localiza").html(data['Tab_Locali']);
                    $("#contLocalizacion").val(data['contLocal']);
                }
            });

            $("#txt_nit").prop('disabled', false);
            $("#txt_tipo_nit").prop('disabled', false);
            $("#txt_razon_social").prop('disabled', false);
            $("#txt_represe").prop('disabled', false);
            $("#txt_depart").prop('disabled', false);
            $("#txt_muni").prop('disabled', false);
            $("#txt_direccion").prop('disabled', false);
            $("#txt_telefono").prop('disabled', false);
            $("#txt_fax").prop('disabled', false);
            $("#txt_email").prop('disabled', false);
            $("#txt_usuusu").prop('disabled', true);
            $("#txt_usucon1").prop('disabled', true);
            $("#txt_usucon2").prop('disabled', true);

            $("#dicont").css("display", "block");

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Actualizar Compañia</a>");



        },
        verComp: function(cod) {

            $("#btn_nuevo").prop('disabled', true);
            $("#btn_guardar").prop('disabled', true);

            var Datos = {
                opc: "CargarDatEmpresa",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: Datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#txt_nit").val(data['companias_nit']);
                    $("#txt_tipo_nit").selectpicker("val", data['companias_tid']);
                    $("#txt_razon_social").val(data['companias_descripcion']);
                    $("#txt_represe").val(data['companias_rlegal']);
                    $("#txt_depart").val(data['companias_dep']);
                    $("#txt_muni").val(data['companias_muni']);
                    $("#txt_direccion").val(data['companias_direccion']);
                    $("#txt_telefono").val(data['companias_telefono1']);
                    $("#txt_fax").val(data['companias_fax']);
                    $("#txt_email").val(data['companias_email']);
                    $("#txt_usuusu").val(data['companias_login']);
                    if (data['companias_img'] !== "") {
                        $('#MostImg').show();
                        $('#ImgEmpresa').attr('src', data['companias_img']);
                    }
                }
            });

            $("#txt_nit").prop('disabled', true);
            $("#txt_tipo_nit").prop('disabled', true);
            $("#txt_razon_social").prop('disabled', true);
            $("#txt_represe").prop('disabled', true);
            $("#txt_depart").prop('disabled', true);
            $("#txt_muni").prop('disabled', true);
            $("#txt_direccion").prop('disabled', true);
            $("#txt_telefono").prop('disabled', true);
            $("#txt_fax").prop('disabled', true);
            $("#txt_email").prop('disabled', true);
            $("#txt_usuusu").prop('disabled', true);
            $("#txt_usucon1").prop('disabled', true);
            $("#txt_usucon2").prop('disabled', true);


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Compañia</a>");


        },
        deletComp: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "../BancoProyecto/GuardarProyecto.php",
                    data: datos,
                    success: function(data) {
                        var pares = data.split("/");
                        if (trimAll(pares[0]) === "bien") {
                            $.Alert("#msg", "Operación Realizada Exitosamente...", "success");
                            $.Proyectos();
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompanias.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_companias').html(data['cad']);
                    $('#bot_companias').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagCompanias.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_companias').html(data['cad']);
                    $('#bot_companias').html(data['cad2']);
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
                url: "../Paginadores/PagCompanias.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_companias').html(data['cad']);
                    $('#bot_companias').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Cargar_Datos_Empre: function(TK_ID1) {
            var Datos = {
                opc: "CargarDatEmpresa"
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "../All.php",
                data: Datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#txt_nit").val(data['TK_NIT']);
                    $("#txt_tipo_nit").selectpicker("val", data['TK_TIPO_NIT']);
                    $("#txt_razon_social").val(data['TK_RAZON_SOCIAL']);
                    $("#txt_depart").val(data['TK_DEPAR']);
                    $("#txt_muni").val(data['TK_MUNI']);
                    $("#txt_direccion").val(data['TK_DIRECCION']);
                    $("#txt_telefono").val(data['TK_TELEFONO']);
                    $("#txt_fax").val(data['TK_FAX']);
                    $("#txt_email").val(data['TK_EMAIL']);
                    if (data['TK_IMG_ADM'] !== "") {
                        $('#MostImg').show();
                        $('#ImgEmpresa').attr('src', data['TK_IMG_ADM']);
                    }


                }
            });
        },

        habcontra: function() {

            if ($('#cccont').prop('checked')) {
                $("#txt_usucon1").prop('disabled', false);
                $("#txt_usucon2").prop('disabled', false);
            } else {
                $("#txt_usucon1").prop('disabled', true);
                $("#txt_usucon2").prop('disabled', true);
            }
        },

        Enviar_Datos: function() {
            $.UploadDoc();


            var changPAss = "n";
            if ($('#cccont').prop('checked')) {
                changPAss = "s";
            }
            Datos = ""
                    + "&TK_NIT=" + $("#txt_nit").val()
                    + "&TK_TIPO_NIT=" + $("#txt_tipo_nit").val()
                    + "&TK_RAZON_SOCIAL=" + $("#txt_razon_social").val()
                    + "&TK_REPRE" + $("#txt_represe").val()
                    + "&TK_MUNI=" + $("#txt_muni").val()
                    + "&TK_DEPA=" + $("#txt_depart").val()
                    + "&TK_DIRECCION=" + $("#txt_direccion").val()
                    + "&TK_TELEFONO=" + $("#txt_telefono").val()
                    + "&TK_FAX=" + $("#txt_fax").val()
                    + "&TK_EMAIL=" + $("#txt_email").val()
                    + "&TK_IMG=" + $("#Src_File").val()
                    + "&TK_LOG=" + $("#txt_usuusu").val()
                    + "&TK_CONT=" + $("#txt_usucon1").val()
                    + "&changPAss=" + changPAss
                    + "&acc=" + $("#acc").val()
                    ;
        },
        UploadDoc: function() {
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

            var ruta = "../Administracion/SubirImg.php";

            $.ajax({
                async: false,
                url: ruta,
                type: "POST",
                data: archivos,
                contentType: false,
                processData: false,
                success: function(datos)
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
        Format_Bytes: function(bytes, decimals) {
            if (bytes == 0)
                return '0 Byte';
            var k = 1024;
            var dm = decimals + 1 || 3;
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
        },
        validarcontra: function(con, con1) {
            if (con === con1)
                return 'bien';
            else
                return 'mal';
        },
        validarcontra2: function() {
            con = $("#txt_usucon1").val();
            con1 = $("#txt_usucon2").val();
            if (con !== con1) {
                alert("Las Contrase\u00f1a no Coinciden. Verifique");
                $("#txt_usucon2").val("");
                $("#txt_usucon2").focus();
            }
        },
        crear_bd: function() {
            Datos = "usu=" + $("#user").val() + "&comp=" + $("#txt_usuusu").val();

            $.ajax({

                type: "POST",
                url: "CrearBD.php",
                data: Datos,
                success: function(data) {
                    if (data == 1) {
                        $.Alert("#msg", "Datos Guardados Exitosamente...", "success");
                        $.Companias();
                        $("#btn_nuevo").prop('disabled', false);
                        $("#btn_guardar").prop('disabled', true);
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
        Validar: function() {
            var Id = "", Value = "";
            Op_Vali = "Ok";

            Id = "#txt_tipo_nit";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#Form_Tipo_Nit").addClass("has-error");
            } else {
                $("#Form_Tipo_Nit").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_nit";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#Form_Nit").addClass("has-error");
            } else {
                $("#Form_Nit").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_razon_social";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#Form_Razon").addClass("has-error");
            } else {
                $("#Form_Razon").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            Id = "#txt_usuusu";
            Value = $(Id).val();
            if (Value === "" || Value === " ") {
                Op_Validar.push("Fail");
                $("#From_log").addClass("has-error");
            } else {
                $("#From_log").removeClass("has-error");
                Op_Validar.push("Ok");
            }

            if ($("#acc") === "1") {
                Id = "#txt_usucon1";
                Value = $(Id).val();
                if (Value === "" || Value === " ") {
                    Op_Validar.push("Fail");
                    $("#From_cont1").addClass("has-error");
                } else {
                    $("#From_cont1").removeClass("has-error");
                    Op_Validar.push("Ok");
                }

                Id = "#txt_usucon2";
                Value = $(Id).val();
                if (Value === "" || Value === " ") {
                    Op_Validar.push("Fail");
                    $("#From_cont2").addClass("has-error");
                } else {
                    $("#From_cont2").removeClass("has-error");
                    Op_Validar.push("Ok");
                }
            } else {
                if ($('#cccont').prop('checked')) {
                    Id = "#txt_usucon1";
                    Value = $(Id).val();
                    if (Value === "" || Value === " ") {
                        Op_Validar.push("Fail");
                        $("#From_cont1").addClass("has-error");
                    } else {
                        $("#From_cont1").removeClass("has-error");
                        Op_Validar.push("Ok");
                    }

                    Id = "#txt_usucon2";
                    Value = $(Id).val();
                    if (Value === "" || Value === " ") {
                        Op_Validar.push("Fail");
                        $("#From_cont2").addClass("has-error");
                    } else {
                        $("#From_cont2").removeClass("has-error");
                        Op_Validar.push("Ok");
                    }
                }
            }




            for (var i = 0; i <= Op_Validar.length - 1; i++) {
                if (Op_Validar[i] == "Fail") {
                    Op_Vali = "Fail";
                }
            }

            Op_Validar.splice(0, Op_Validar.length);


        }
    });

    $.Companias();
    $.CargaDato();

    //====BOTON VOLVER====\\
    $('#btn_volver').on('click', function() {
        window.location.href = 'AdminParametros.php';
    });
    $('#btn_cancelar').on('click', function() {
        window.location.href = 'DatosEmpresa.php';
    });
    $('#btn_nuevo').on('click', function() {
        $("#txt_tipo_nit").selectpicker("val", " ");
        $("#txt_nit").val("");
        $("#txt_razon_social").val("");
        $("#txt_represe").val("");
        $("#txt_depart").val("");
        $("#txt_muni").val("");
        $("#txt_direccion").val("");
        $("#txt_telefono").val("");
        $("#txt_fax").val("");
        $("#txt_email").val("");
        $("#archivos").val("");
        $("#Src_File").val("");
        $("#Name_File").val("");
        $("#txt_usuusu").val("");
        $("#txt_usucon1").val("");
        $("#txt_usucon2").val("");
        $("#dicont").css("display", "none");
        $('#MostImg').hide();

        $("#tb_Localiza tbody").empty();
        $("#contLocalizacion").val("0");

        $("#tab_2").removeClass("active in");
        $("#tab_pp2").removeClass("active in");
        $("#tab_1").addClass("active in");
        $("#tab_pp1").addClass("active in");

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

    });
    //====BOTON VER IMG====\\
    $('#btn_img').on('click', function() {
        $("#ventanaImg").modal("show");
    });
    //====BOTON VOLVER====\\

    $("#archivos").on("change", function() {
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

    //====BOTON GUARDAR====\\
    $('#btn_guardar').on('click', function() {

        $.Validar();

        if (Op_Vali === "Fail") {
            $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning", 'warning');
            return;
        }

        $.Dta_Localizacion();

        $.Enviar_Datos();
        Datos += "&Opcion=" + Opcion + Dat_Localiza;
        $.ajax({
            async: false,
            type: "POST",
            url: "../Administracion/Gestionar_Config_Empresa.php",
            data: Datos,
            success: function(data) {
                if (data == 1) {
                    if ($("#acc").val() === "1") {
                        // $.crear_bd();
                        $.Alert("#msg", "Datos Guardados Exitosamente...", "success");
                        $.Companias();
                        $("#btn_nuevo").prop('disabled', false);
                        $("#btn_guardar").prop('disabled', true);
                    } else {
                        $.Alert("#msg", "Datos Guardados Exitosamente...", "success");
                        $.Companias();
                        $("#btn_nuevo").prop('disabled', false);
                        $("#btn_guardar").prop('disabled', true);
                    }

                }
            }
        });
    });


});