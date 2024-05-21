<?php
session_start();

putenv('TZ=America/Bogota');

if ($_SESSION['ses_user'] == NULL) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['permpara'] == "n") {
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
<html lang="es">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Administración Parametros Generales | Indicadores </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../Plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
        <link href="../Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../Css/Global/css/components.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="../Img/favicon.ico" />

        <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../Js/Parametros_Generales.js" type="text/javascript"></script>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
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
            <?php echo $_SESSION['Menu_SubLeft']; ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="../Administracion.php">Inicio</a>

                            </li>
                            <li>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <a href="AdminParametros.php">Parametros Generales</a>
                            </li>
                        </ul>
                    </div>
                    <h3 class="page-title"> Administraci&oacute;n Parametros Generales
                    </h3>
                    <div class="tiles">
                        <?php if ($_SESSION['GesParVCom'] == "s") { ?>
                            <div id="btn_empre" class="tile bg-purple">
                                <div class="tile-body">
                                    <i class="fa fa fa-building-o"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Datos De La Empresa
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['GesParVDep'] == "s") { ?>
                            <div id="btn_depe" class="tile bg-blue">
                                <div class="tile-body">
                                    <i class="fa fa-sitemap"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Dependencias
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['GesParVRes'] == "s") { ?>
                            <div id="btn_resp" class="tile bg-green">
                                <div class="tile-body">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Responsables
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['GesParVSup'] == "s") { ?>
                            <div id="btn_super" class="tile bg-red">
                                <div class="tile-body">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Supervisores
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['GesParVInt'] == "s") { ?>
                            <div id="btn_interv" class="tile bg-yellow">
                                <div class="tile-body">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Interventores
                                    </div> <!-- bg-green-haze-->
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['GesParVCon'] == "s") { ?>
                            <div id="btn_contr" class="tile bg-blue-madison">
                                <div class="tile-body">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Contratistas
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['GesParVSec'] == "s") { ?>
                            <div id="btn_secre" class="tile bg-green-meadow">
                                <div class="tile-body">
                                    <i class="fa fa-sitemap"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Secretarias
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['GesParVTPr'] == "s") { ?>
                            <div id="btn_tipol" class="tile bg-red-pink">
                                <div class="tile-body">
                                    <i class="fa fa-cubes"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Tipología de Proyectos
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['GesParVTCr'] == "s") { ?>
                            <div id="btn_tipocont" class="tile bg-yellow-gold">
                                <div class="tile-body">
                                    <i class="fa fa-cubes"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Tipología de Contratos
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['GesParVCsc'] == "s") { ?>
                            <div id="btn_conse" class="tile bg-purple-plum">
                                <div class="tile-body">
                                    <i class="fa fa-sort-numeric-asc"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gesti&oacute;n de Consecutivos
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--                        <div id="btn_audito" class="tile bg-blue-chambray">
                                                    <div class="tile-body">
                                                        <i class="fa fa-institution"></i>
                                                    </div>
                                                    <div class="tile-object">
                                                        <div class="name">
                                                            Auditoria
                                                        </div>
                                                    </div>
                                                </div>-->
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
    </body>
</html>
