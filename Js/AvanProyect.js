$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_avances").addClass("start active open");
    $("#menu_AvaProy").addClass("active");

    $("#txt_fecha").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });


    $("#CbEstImg").selectpicker();

//

    var Datos, Op_Save, Id;
    Datos = "";
    Op_Save = "New";
    Id = " ";
    var X = 0;
    var Op_Edit = "New";
    var Id_Tr = "";
    var Dat_Table = "";
    var Order;
    //Order = " A.id_contra DESC";
    var Url = "Prorroga.jsp";
    var Op_Validar = [];
    var Vali = [];
    var Op_Vali = "Ok";
    var Op_Anx = "Fail";
    var List_Doc = [];
    var Op_Anx = "New";
    Op_Anx = "New";
    var Op_Url = "";

    var contMedi = 0;
    var contMetas = 0;

    var Dat_Medi = "";


    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        Proyectos: function() {
            var datos = {
                opc: "CargDependencia",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosAvan.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);

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
                nreg: $("#nreg").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosAvan.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        paginador: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosAvan.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
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
                nreg: $("#nreg").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosAvan.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
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
                pag: $("#selectpag").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "../Paginadores/PagProyectosAvan.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Proyect').html(data['cad']);
                    $('#bot_Proyect').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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
        AddAvann: function(idproy) {
            $("#id_proy").val(idproy);
            var datos = {
                ope: "CargaAvancesProy",
                cod: idproy

            };
            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                dataType: 'json',
                success: function(data) {

                    $("#tb_Galeria").html(data['Tab_Img']);
                    $("#contImg").val(data['contImg']);

                },
                beforeSend: function() {
                    $('#cargando').modal('show');
                },
                complete: function() {
                    $('#cargando').modal('hide');
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR' + JSON.stringify(error_messages));
                }
            });

            $('#tab_02_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
        },
        AddGaleria: function() {
            if ($("#archivosGale").val() === "") {
                $.Alert("#msg", "Por Favor Seleccione la Imagen a Cargar...", "warning");
                return;
            } else if ($('#CbEstImg').val() === " ") {
                $.Alert("#msg", "Por Favor Seleccione el destino de las Imagenes...", "warning");
                return;
            } else if ($('#txt_fecha').val() === "") {
                $.Alert("#msg", "Por Favor Seleccione la fecha de Publicacion...", "warning");
                return;
            } else {

                var archivos = document.getElementById("archivosGale");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
                var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
                //Creamos una instancia del Objeto FormDara.
                var archivos = new FormData();
                /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
                 Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
                 indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
                for (i = 0; i < archivo.length; i++) {
                    archivos.append('archivosGale' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
                }

                var ruta = "../Proyecto/upload_img_proyect.php";
                $.ajax({
                    url: ruta,
                    type: "POST",
                    data: archivos,
                    contentType: false,
                    processData: false,
                    success: function(datos)
                    {
                        $.AddTabla(datos);
                    }
                });
            }
        },
        AddTabla: function(dat) {

            var CbEstImg = $('#CbEstImg').val();
            var txt_fecha = $('#txt_fecha').val();
            contImg = $("#contImg").val();

            var Result = dat.split("//");
            for (i = 0; i < Result.length; i++) {
                contImg++;
                var fila = '<tr class="selected" id="filaImg' + contImg + '" >';
                var pararc = Result[i].split("*");
                fila += "<td>" + contImg + "</td>";
                fila += "<td>" + pararc[0] + "</td>";
                fila += "<td>" + CbEstImg + "</td>";
                fila += "<td>" + txt_fecha + "</td>";
                fila += "<td><input type='hidden' id='idImg" + contImg + "' name='terce' value='" + CbEstImg + "//" + pararc[0] + "//" + pararc[1] + "//" + txt_fecha + "' />\n\
                    <a onclick=\"$.QuitarImg('filaImg" + contImg + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Quitar</a>\n\
                    <a onclick=\"$.VerImg('../Proyecto/GaleriaProyecto/" + pararc[0] + "*" + pararc[1] + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>\n\
                    </td></tr>";
                $('#tb_Galeria').append(fila);
                $.reordenarImg();
                $("#contImg").val(contImg);

                $("#CbEstImg").selectpicker("val", " ");
                $("#archivosGale").val("");
                $("#vista-previa").html("");
            }


            $.updateBD();
            $.AddAvann($("#id_proy").val());



        },
        updateBD: function() {
            var Dat_Img = "";
            $("#tb_Galeria").find(':input').each(function() {
                Dat_Img += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Img += "&Long_Img=" + $("#contImg").val() + "&idproy=" + $("#id_proy").val();
            $.ajax({
                type: "POST",
                url: "../Proyecto/GuardarAvancesProy.php",
                data: Dat_Img,
                success: function(data) {


                    if (trimAll(data) === "bien") {

                        $.Alert("#msg", "Datos Guardados Exitosamente...", "success", "check");

                    }
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


        },
        reordenarImg: function() {
            var num = 1;
            $('#tb_Galeria tbody tr').each(function() {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Galeria tbody input').each(function() {
                $(this).attr('id', "idImg" + num);
                num++;
            });
        },
        QuitarImg: function(id_fila) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
                var datos = {
                    ope: "DelImgProy",
                    cod: $("#id_proy").val(),
                    fil: id_fila

                };
                $.ajax({
                    type: "POST",
                    url: "../All.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            $.Alert("#msg", "Operación Realizada Exitosamente...", "success", "check");
                            $.AddAvann($("#id_proy").val());
                        }


                    },
                    beforeSend: function() {
                        $('#cargando').modal('show');
                    },
                    complete: function() {
                        $('#cargando').modal('hide');
                    }
                });
            }

        },
        VerImg: function(img) {
            $("#contenedor img").attr("src", "");
            parimg = img.split("*");
            formimg = parimg[1];
            if (formimg.indexOf('/') !== -1) {
                parformimg = formimg.split("/");
                formimg = parformimg[0];
            }
            if (formimg === "image") {
                $("#contenedor img").attr("src", parimg[0]);
                $("#responsiveImg").modal();
            } else {
                window.open("../Proyecto/" + parimg[0], '_blank');
            }

        }

    });
    //======FUNCIONES========\\
    $.Proyectos();

});
///////////////////////
