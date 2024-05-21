$(document).ready(function () {
    $("#fecha_ini_poliza_u,#fecha_fin_poliza_u").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });
    $('#tab_Proyect').on("click", ".btnPolizas", function (e) {
        e.preventDefault();
        var id_contrato = $(this).data('id');
        $("#id_contrato").val(id_contrato);
        var datos = {
            id_contrato: id_contrato,
            OPCION: 'CONSULTAR'
        }
        $.ajax({
            type: "POST",
            url: "../Proyecto/Polizas.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                if (data.TIENE === 1) {
                    for (var i = 1; i <= data.contrato.tam; i++) {
                        $("#num_poliza").val(data.contrato.num_poliza[i]);
                        $("#fecha_ini_poliza_u").val(data.contrato.fecha_ini[i]);
                        $("#fecha_fin_poliza_u").val(data.contrato.fecha_fin[i]);
                        $("#doc_anexo_poliza").val(data.contrato.anexo[i]);
                    }
                } else {
                    $("#num_poliza").val("");
                    $("#fecha_ini_poliza_u").val("");
                    $("#fecha_fin_poliza_u").val("");
                    $("#doc_anexo_poliza").val("");
                }
            },
            error: function (error_messages) {

            }
        });
        $("#modalPoliza").modal("show");
    });
    $('#modalPoliza').on('shown.bs.modal', function () {

    });
    $("#modalPoliza").on('hidden.bs.modal', function () {

    });
    //===============VALIDAR LAS FECHAS==================\\ 
    $("#fecha_ini_poliza_u").on('change', function (ev) {
        var hasta = $("#fecha_fin_poliza_u").val();
        var desde = $("#fecha_ini_poliza_u").val();
        if (hasta === "") {
            $("#fecha_fin_poliza_u").val(desde);
        } else {
            // hasta = dividirFechas(hasta);
            if (desde.valueOf() > hasta.valueOf()) {
                $("#fecha_fin_poliza_u").val(desde);
            }
        }
    });
    $("#fecha_fin_poliza_u").on('change', function (ev) {
        var hasta = $("#fecha_fin_poliza_u").val();
        var desde = $("#fecha_ini_poliza_u").val();
        if (desde === "") {
            $("#fecha_ini_poliza_u").val(hasta);
        } else {
            // desde = dividirFechas(desde);
            if (hasta.valueOf() < desde.valueOf()) {
                $("#fecha_ini_poliza_u").val(hasta);
            }
        }
    });
    //===============VALIDAR LAS FECHAS==================\\


    $("#anexo_poliza").on({
        change: function () {
            var archivos = document.getElementById("anexo_poliza");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
                archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }

            var ruta = "../Proyecto/SubirAnexoPoliza.php";

            $.ajax({
                async: false,
                url: ruta,
                type: "POST",
                data: archivos,
                contentType: false,
                processData: false,
                success: function (datos) {
                    var par_res = datos.split("//");
                    if (par_res[0] === "Bien") {
                        $('#doc_anexo_poliza').val(par_res[1].trim());

                        /* Limpiar vista previa */
                        $("#vista-previa").html('');
                        var archivos = document.getElementById('anexo_poliza').files;
                        var navegador = window.URL || window.webkitURL;
                        /* Recorrer los archivos */
                        for (x = 0; x < archivos.length; x++) {
                            /* Validar tamaño y tipo de archivo */
                            var size = archivos[x].size;
                            var type = archivos[x].type;
                            var name = archivos[x].name;

                            var Mb = $.Format_Bytes(size, 2);
                            $("#fileSize").html(Mb);
                            $("#Name_File").val(name);
                        }
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msgCodPol", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                },
                beforeSend: function () {
                    $('#cargando').modal({ backdrop: 'static', keyboard: false });
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

    $("#btnGuaPol").on({
        click: function (e) {
            e.preventDefault();
            if ($("#num_poliza").val() === "") {
                $.Alert("#msgCodPol", "Por favor digite el numero de poliza", "warning", 'warning');
                return false;
            }
            if ($("#fecha_ini_poliza_u").val() === "") {
                $.Alert("#msgCodPol", "Por favor seleccione la fecha de inicio de la poliza", "warning", 'warning');
                return false;
            }
            if ($("#fecha_fin_poliza_u").val() === "") {
                $.Alert("#msgCodPol", "Por favor seleccione la fecha final de la poliza", "warning", 'warning');
                return false;
            }
            if ($("#doc_anexo_poliza").val() === "") {
                $.Alert("#msgCodPol", "Por favor anexe el documento de la poliza", "warning", 'warning');
                return false;
            }
            var datos = {
                num_poliza: $("#num_poliza").val(),
                fecha_ini: $("#fecha_ini_poliza_u").val(),
                fecha_fin: $("#fecha_fin_poliza_u").val(),
                id_contrato: $("#id_contrato").val(),
                anexo: $("#doc_anexo_poliza").val(),
                OPCION: 'GUARDAR'
            }
            $.ajax({
                type: "POST",
                url: "../Proyecto/Polizas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data === 1) {
                        $.Alert("#msgCodPol", "Poliza guardada de manera exitosa", "success", 'success');
                    } else {
                        $.Alert("#msgCodPol", "La poliza no fue guardada", "warning", 'warning');
                    }
                },
                error: function (error_messages) {

                }
            });
        }
    });
});