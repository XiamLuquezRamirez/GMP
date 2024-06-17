<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['GesPlaVEj'] == "n") {
    echo "<script>alert('Actualmente no tienes permiso de accesos a este contenido');javascript:window.history.back();</script>";
}
//
if (isset($_GET['Logout'])) {
    header("Location:cerrar.php?opc=1");
    session_destroy();
}

include("../Conectar.php");
$link = conectar();
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title> Parametrizar nieves del plan de desarrollo | GMP - Gestor Monitoreo Público</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="../http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../Plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../Css/Global/css/components.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="../Img/favicon.ico" />

    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../Js/funciones_generales.js" type="text/javascript"></script>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed page-sidebar-fixed">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a>
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
                            <i class="fa fa-file-text-o"></i>
                            <a href="../Plan_de_Desarrollo/">Plan de Desarrollo</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <i style="color: yellow;" class="fa fa-star"></i>
                            <a href="../ParametrizacionPlanDesarrollo/">Parametrizar </a>

                        </li>
                    </ul>
                </div>
                <!-- BEGIN PAGE CONTENT-->
                <div class="portlet box blue-soft">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-angle-right"></i>Parametrizar plan de desarrollo.
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="fecha">Nivel 1:</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" data-placeholder="Seleccione..." id="CbN1" name="options2">
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_new_resp" onclick="$.NewNivel(1);" title="Nuevo nivel" class="btn green-meadow">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nivel 2:</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" data-placeholder="Seleccione..." id="CbN2" name="options2">
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_new_resp" onclick="$.NewNivel(2);" title="Nuevo nivel" class="btn green-meadow">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nivel 3:</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" data-placeholder="Seleccione..." id="CbN3" name="options2">
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_new_resp" onclick="$.NewNivel(3);" title="Nuevo nivel" class="btn green-meadow">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-12' style="text-align: right">
                                    <div class='form-group'>
                                        <a onclick="$.updateNiveles()" class="btn green-meadow">
                                            <i class="fa fa-save"></i> Actualizar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div id="msgae">
                                    </div>
                                </div>
                            </div>
                            <hr>

                        </div>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END PAGE CONTENT-->

                <div id="ventanaNiveles" class="modal fade" tabindex="-1" data-width="760">
                    <input type="hidden" id="nivelSel" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Agregar Niveles plan de desarrollo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>
                                <form action='#' id="formnot" class='horizontal-form'>
                                    <div class='form-body'>
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Nombre:</label>
                                                    <input type='text' id='txt_Nombre' value="" class='form-control' />

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgmod">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <button type="button" onclick="$.guardar();" class="btn blue"><i class="fa fa-save"></i> Guardar</button>
                                            <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-close"></i> Cerrar</button>
                                        </div>
                                    </div>

                            </div>
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
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../Css/Layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function() {

            $("#home").removeClass("start active open");
            $("#menu_plan").addClass("start active open");
            $("#menu_plan_parametrizar").addClass("active");

            $.extend({
                cargarNiveles: function() {
                    let datos = {
                        ope: "buscarNiveles"
                    }

                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        dataType: 'JSON',
                        success: function(data) {
                            console.log(data.nivel1);
                            $("#CbN1").html(data.nivel1);
                            $("#CbN2").html(data.nivel2);
                            $("#CbN3").html(data.nivel3);
                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });
                },
                NewNivel: function(nivel) {
                    $("#nivelSel").val(nivel);
                    $("#ventanaNiveles").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                },
                updateNiveles: function(nivel) {

                    let CbN1 = $("#CbN1").val();
                    let CbN2 = $("#CbN2").val();
                    let CbN3 = $("#CbN3").val();
                    if (CbN1 == " ") {
                        $.Alert(
                            "#msgae",
                            "Debes de seleccionar un nombre para el nivel 1",
                            "warning",
                            "warning"
                        );
                        return;
                    }
                    if (CbN2 == " ") {
                        $.Alert(
                            "#msgae",
                            "Debes de seleccionar un nombre para el nivel 2",
                            "warning",
                            "warning"
                        );
                        return;
                    }
                    if (CbN3 == " ") {
                        $.Alert(
                            "#msgae",
                            "Debes de seleccionar un nombre para el nivel 3",
                            "warning",
                            "warning"
                        );
                        return;
                    }

                    let datos = {
                        ope: "updateNivelesPlanDesarrollo",
                        CbN1: CbN1,
                        CbN2: CbN2,
                        CbN3: CbN3
                    }

                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        success: function(data) {                            
                            $.Alert(
                                "#msgae",
                                "Operación realizada exitosamente...",
                                "success",
                                "success"
                            );
                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });


                },
                guardar: function() {

                    let txt_Nombre = $("#txt_Nombre").val();
                    let nivelSel = $("#nivelSel").val();
                    if (txt_Nombre == "") {
                        $.Alert(
                            "#msgmod",
                            "Debes de ingresar un nombre par el nivel",
                            "warning",
                            "warning"
                        );
                        return;
                    }
                    let datos = {
                        ope: "guardarNiveles",
                        nombre: txt_Nombre,
                        nivelSel: nivelSel
                    }

                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        dataType: 'JSON',
                        success: function(data) {
                            if (nivelSel == "1") {
                                $("#CbN1").html(data.niveles);
                            } else if (nivelSel == "2") {
                                $("#CbN2").html(data.niveles);
                            } else {
                                $("#CbN3").html(data.niveles);
                            }

                            $.Alert(
                                "#msgmod",
                                "Operación realizada exitosamente...",
                                "success",
                                "success"
                            );

                            $("#txt_Nombre").val("");

                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });


                },
                Alert: function(div, msg, type,ico) {
                    App.alert({
                        container: div, //  [ "" ] alerts parent container(by default placed after the page breadcrumbs)
                        place: "append", //  [ append, prepent] append or prepent in container
                        type: type, //  [success, danger, warning, info] alert's type
                        message: msg, //  Mensaje Del Alert
                        close: true, //  [true, false] make alert closable
                        reset: true, //  [true, false] close all previouse alerts first
                        focus: true, //  [true, false] auto scroll to the alert after shown
                        closeInSeconds: 5, //  [0, 1, 5, 10] auto close after defined seconds
                        icon: ico //  ["", "warning", "check", "user"] put icon before the message
                    });
                },

            });

            $.cargarNiveles();

        });
    </script>
</body>

</html>