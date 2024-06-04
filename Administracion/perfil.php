<?php
session_start();

putenv('TZ=America/Bogota');

if ($_SESSION['ses_user'] == null) {
    echo "<script>location.href='index.php'</script>";
    exit();
}
//
if (isset($_GET['Logout'])) {
    header("Location:cerrar.php?opc=1");
    session_destroy();
}

include "../Conectar.php";
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8" />
    <title>GMP - Gestor Monitoreo Público | Mi perfil</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="../Plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/> -->
    <link href="../Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL ../Plugins -->
    <link href="../Plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <script src="../Plugins/jquery-knob/js/jquery.knob.js"></script>
    <!--
                <link href="Plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet"/>
                <link href="Plugins/jquery-ui/jquery.ui.slider.css" rel="stylesheet"/> -->
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <style>




    </style>
    <link href="../Css/Global/css/components.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="../Css/circle.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="../Img/favicon.ico" />
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false">
    </script>
    <script src="../Js/sweetalert2.all.min.js"></script>
    <link href="../Css/Global/css/sweetalert2.min.css" rel="stylesheet">


    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>


    <style>
        .informacionGeneral {
            padding-left: 20px;
            display: flex;
        }

        .detUsu {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
        }

        .detUsu ul {
            padding-left: 10px;
        }

        .informacionGeneral div {
            margin-right: 20px;
        }

        #tr_proyecto tr {
            cursor: pointer !important;
            text-decoration: none;
            font-size: x-small;
        }

        div:where(.swal2-container).swal2-center>.swal2-popup {

            border-radius: 5px !important;
        }

        div:where(.swal2-icon).swal2-warning.swal2-icon-show {
            border-radius: 50% !important;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            border-radius: 5px !important;
        }

        .imagenUsu {
            width: 200px;
            height: 200px;
            border: 1px solid #333;
            text-align: center;
            border-radius: 50% !important;
            box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
        }

        .imagenUsu img {
            height: 100%;
            object-fit: cover;
            object-position: center center;
            border-radius: 50% !important;
        }
    </style>

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed page-sidebar-fixed">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="../Administracion.php">
                    <img src="../Img/logo.png" alt="logo" class="logo-default" />
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <?php echo $_SESSION['User_SubLogin']; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="clearfix"> </div>

    <div class="page-container">
        <input type="hidden" readonly name="lat" id="lat" />
        <input type="hidden" readonly name="lng" id="long" />

        <?php echo $_SESSION['Menu_SubLeft']; ?>
        <div class="page-content-wrapper">

            <div class="page-content">
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="../Administracion.php">Administración</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <i style="color: yellow;" class="fa fa-star"></i>
                            <a href="../MiPerfil/">Mi Perfil </a>

                        </li>
                    </ul>
                </div>

                <h3 class="page-title"> GMP - Gestor Monitoreo Público | Mi perfil
                </h3>
                <div class="tiles">
                    <div class="row-fluid profile">
                        <div class="span12">
                            <!--BEGIN TABS-->
                            <div class="tabbable tabbable-custom tabbable-full-width">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1_1" data-toggle="tab">Descripción general</a></li>
                                    <li><a href="#tab_1_2" data-toggle="tab">Información de cuenta</a></li>
                                </ul>
                                <input type="hidden" id="idUsuario" value="<?php echo $_SESSION['ses_idusu'] ?>" />
                                <div class="tab-content">
                                    <div class="tab-pane row-fluid active" id="tab_1_1">
                                        <div class="informacionGeneral">
                                            <div>
                                                <img src="../Img/Usuarios/<?php echo $_SESSION['cue_foto'] ?>" width="120" alt="" />

                                            </div>
                                            <div class="detUsu">
                                                <h4><?php echo $_SESSION['ses_nombre'] ?></h4>
                                                <ul class="unstyled inline">
                                                    <li id="infCorreo"></li>
                                                    <li id="infTelefono"></li>
                                                    <li><i class="fa fa-bank"></i> <?php echo $_SESSION['ses_compa'] ?></li>
                                                    <li id="infDireccion"></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <h3>Listado de proyectos asignados.</h3>
                                            <table id="tabla-proye" class="table table-striped table-bordered table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th> #</th>
                                                        <th><i class="icon-briefcase"></i> proyectos</th>
                                                        <th class="hidden-phone"><i class="fa fa-sitemap"></i> Secretaria</th>
                                                        <th><i class="fa fa-exclamation"></i> Detalles</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tr_proyecto">

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="tab-pane row-fluid profile-account" id="tab_1_2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                    <li class="active">
                                                        <a data-toggle="tab" href="#tab_1-1">
                                                            <i class="fa fa-id-card-o"></i>
                                                            Información personal
                                                        </a>
                                                        <span class="after"></span>
                                                    </li>
                                                    <li><a data-toggle="tab" href="#tab_2-2"><i class="icon-picture"></i> Cambiar imagen</a></li>
                                                    <li><a data-toggle="tab" href="#tab_3-3"><i class="icon-lock"></i> Cambiar contraseña</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="tab-content">
                                                    <div id="tab_1-1" class="tab-pane active">
                                                        <div class='portlet-body form'>
                                                            <input type="hidden" id="accPerfil" value="">
                                                            <form action='../Administracion/updatePerfil.php' method="post" id="formUpdatePerfil" class='horizontal-form'>

                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group"><input type="hidden" id="acc" value="1" />
                                                                                <label class="control-label">Identificación:</label>
                                                                                <input type="text" id="txt_identi" name="txt_identi" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Nombre:</label>
                                                                                <input type="text" onkeyup="this.value = this.value.toUpperCase()" id="txt_usunom" name="txt_usunom" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Sexo:</label>
                                                                                <div id="c_sex">
                                                                                    <select id="cbx_sexo" name="cbx_sexo" class="bs-select form-control small">
                                                                                        <option value=" ">Selecc..</option>
                                                                                        <option value="MASCULINO">MASCULINO</option>
                                                                                        <option value="FEMENINO">FEMENINO</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Dirección:</label>
                                                                                <input type="text" id="txt_usudir" name="txt_usudir" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Telefono:</label>
                                                                                <input type="text" id="txt_usuTel" name="txt_usuTel" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email:</label>

                                                                                <input type="text" id="txt_usuemail" name="txt_usuemail" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-actions right" id="mopc">
                                                                        <button type="button" onclick="$.updateInfPerfil();" class="btn green"><i class="fa fa-save"></i> Actualizar</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div id="tab_2-2" class="tab-pane">
                                                        <div class='portlet-body form'>
                                                            <div style="display: flex; justify-content: center;">

                                                                <div class="imagenUsu" id="vista-previa">
                                                                    <img src="" id="imgUsu" alt="">
                                                                </div>
                                                                <div id="respuesta"></div>

                                                            </div>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Adjuntar Imagenes<span class='required'>* </span></label>
                                                                <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                                    <input type="file" id="archivos">

                                                                </form>
                                                            </div>

                                                            <div class="form-actions right" id="mopc">
                                                                <button type="button" onclick="$.updateFotoPerfil();" class="btn green"><i class="fa fa-save"></i> Actualizar</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div id="tab_3-3" class="tab-pane">
                                                        <div class='portlet-body form'>
                                                            <form action="#">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Contraseña actual:</label>
                                                                            <input type="password" id="psw_actual" name="psw_actual" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Contraseña nueva:</label>
                                                                            <input type="password" id="psw_nueva" name="psw_nueva" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Repetir contraseña nueva:</label>
                                                                            <input type="password" id="psw_confNueva" name="psw_confNueva" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-actions right" id="mopc">
                                                                    <button type="button" onclick="$.updatePaswPerfil();" class="btn green"><i class="fa fa-save"></i> Actualizar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TABS-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php echo $_SESSION['Footer']; ?>

    <!-- BEGIN CORE PLUGINS -->
    <script src="../Plugins/jquery.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../Plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="../Plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../Plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../Plugins/moment.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js" type="text/javascript"></script>
    <script src="../Plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="../Plugins/select2/js/select2.full.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="../Plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../Css/Global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../Plugins/Scripts/components-bootstrap-select.js" type="text/javascript"></script>
    <script src="../Plugins/Scripts/components-select2.js" type="text/javascript"></script>
    <script src="../Plugins/Scripts/components-date-time-pickers.js" type="text/javascript"></script>
    <script src="../Plugins/Scripts/form-samples.js" type="text/javascript"></script>
    <script src="../Plugins/Scripts/form-input-mask.js" type="text/javascript"></script>
    <script src="../Plugins/Scripts/ui-extended-modals.js" type="text/javascript"></script>
    <!-- <script src="Plugins/jquery-knob/js/jquery.knob.js"></script>
        <script src="Plugins/ui-sliders.js"></script> -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../Css/Layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

    <script src="../Js/amchart/core.js"></script>
    <script src="../Js/amchart/charts.js"></script>
    <script src="../Js/amchart/themes/animated.js"></script>
    <script src="../Js/amchart/themes/dataviz.js"></script>

    <script>
        $(document).ready(function() {

            $.extend({
                cargarDatos: function() {
                    let idUsu = $("#idUsuario").val();

                    var datos = {
                        ope: "buscarDatosUsuario",
                        idUsu: idUsu
                    };

                    $.ajax({
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        dataType: "json",
                        success: function(data) {
                            $("#infCorreo").html('<i class="fa fa fa-envelope-o"></i>' + data['cue_correo']);
                            $("#infTelefono").html('<i class="fa fa-phone"></i>' + data['cue_tele']);
                            $("#infDireccion").html('<i class="fa fa-map-signs"></i>' + data['cue_dir']);

                            $("#tr_proyecto").html(data['tr_poryectos']);

                            $("#txt_identi").val(data['cue_inden']);
                            $("#txt_usunom").val(data['cue_nombres']);
                            $("#cbx_sexo").selectpicker("val", data['cue_sexo']);
                            $("#txt_usudir").val(data['cue_dir']);
                            $("#txt_usuTel").val(data['cue_tele']);
                            $("#txt_usuemail").val(data['cue_correo']);

                            let imagen = document.getElementById('imgUsu');
                            imagen.setAttribute('src', '../Img/Usuarios/' + data['cue_foto']);

                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });

                },
                updateInfPerfil: function() {

                    var form = $("#formUpdatePerfil");
                    var url = form.attr("action");
                    var idUsu = $("#idUsuario").val();
                    var accPerfil = $("#accPerfil").val();


                    $("#idusu").remove();
                    $("#accp").remove();
                    form.append("<input type='hidden' id='idusu' name='idusu'  value='" + idUsu + "'>");

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: new FormData($('#formUpdatePerfil')[0]),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(respuesta) {

                            if (respuesta.estado == "bien") {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Operación realizada exitosamente.",
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                type: "errot",
                                title: "Opsss...",
                                text: "Ha ocurrido un error",
                                confirmButtonClass: "btn btn-primary",
                                timer: 1500,
                                buttonsStyling: false
                            });
                        }
                    });
                },
                updateFotoPerfil: function() {

                    if ($("#archivos").val() === "") {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Por Favor Seleccione la Imagen a Cargar...",
                            showConfirmButton: true,
                            timer: 3000
                        });
                        return;
                    } else if ($('#CbEstImg').val() === " ") {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Por Favor Seleccione el destino de las Imagenes...",
                            showConfirmButton: true,
                            timer: 3000
                        });
                        return;
                    } else {

                        var archivos = document.getElementById("archivos"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
                        var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
                        //Creamos una instancia del Objeto FormDara.
                        var archivos = new FormData();
                        /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
                         Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
                         indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
                        for (i = 0; i < archivo.length; i++) {
                            archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
                        }

                        var ruta = "../Administracion/subirImgUsuario.php";
                        $.ajax({
                            url: ruta,
                            async: false,
                            type: "POST",
                            data: archivos,
                            contentType: false,
                            processData: false,
                            success: function(datos) {
                                if (datos == "Bien") {
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Operación realizada exitosamente.",
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                }
                            }
                        });
                    }
                },
                updatePaswPerfil: function() {
                    if ($("#psw_actual").val() === "") {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Por favor ingrese la contraseña actual...",
                            showConfirmButton: true,
                            timer: 3000
                        });
                        return;
                    }


                    if ($("#psw_nueva").val() === "") {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Por favor ingrese la nueva contraseña...",
                            showConfirmButton: true,
                            timer: 3000
                        });
                        return;
                    }

                    if ($("#psw_confNueva").val() === "") {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Por favor repita la nueva contraseña...",
                            showConfirmButton: true,
                            timer: 3000
                        });
                        return;
                    }

                    if ($("#psw_confNueva").val() !== $("#psw_nueva").val()) {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Las contraseñas deben ser iguales",
                            showConfirmButton: true,
                            timer: 3000
                        });
                        return;
                    }

                    var datos = {
                        ope: "changePasword",
                        old: $("#psw_actual").val(),
                        new: $("#psw_confNueva").val()
                    }

                    $.ajax({
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        success: function(data) {
                            if (data.trim() === 'diferente') {
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "Las contraseñas ingresada no es la actual, Verifique",
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                                $("#psw_actual").focus();

                            } else {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Operación realizada exitosamente.",
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });
                }
            });

            $.cargarDatos();

            $("#archivos").on("change", function() {
                /* Limpiar vista previa */

                var archivos = document.getElementById('archivos').files;
                var navegador = window.URL || window.webkitURL;
                /* Recorrer los archivos */
                for (x = 0; x < archivos.length; x++) {
                    /* Validar tamaño y tipo de archivo */
                    var size = archivos[x].size;
                    var type = archivos[x].type;
                    var name = archivos[x].name;

                    if (size > 10485760) {
                        $("#vista-previa").append("<p style='color: red'>El archivo " + name + " supera el máximo permitido 10MB</p>");
                    } else if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif' && type != 'video/mp4' && type != 'video/avi' && type != 'video/mpg' && type != 'video/mpeg') {
                        $("#vista-previa").append("<p style='color: red'>El archivo " + name + " no es del tipo de imagen/video permitida.</p>");
                    } else {
                        var objeto_url = navegador.createObjectURL(archivos[x]);
                        let imagen = document.getElementById('imgUsu');
                        imagen.setAttribute('src', objeto_url);
                    }
                }
            });


        });
    </script>
</body>

</html>