<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}


if ($_SESSION['GesUsuVUs'] == "n") {
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
        <meta charset="utf-8"/>
        <title> Gestión de Usuarios | SGP Gestor Publico de Gobierno</title>
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
        <link href="Plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
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
        <script src="../Js/GestionUsuarios.js" type="text/javascript"></script>
        <script src="Js/funciones_generales.js" type="text/javascript"></script>
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
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <a href="GestionUsuario.php">Gesti&oacute;n de Usuarios</a>

                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->


                    <!-- responsive -->
                    <div id="responsive" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Datos del Usuario</h4>


                        </div>

                        <?php if ($_SESSION['usu_maestro'] == "" && $_SESSION['ses_user'] != "root") { ?>
                            <input type='text' id='txtmaestro'   value='si' style='display: none;'/>
                        <?php } else { ?>
                            <input type='text' id='txtmaestro' value='no' style='display: none;'/>
                        <?php } ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <form action='#' class='horizontal-form'>
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group"><input type="hidden" id="acc" value="1" />
                                                        <label class="control-label">Identificación:</label>
                                                        <input type="text"  id="txt_usuid" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre:</label>
                                                        <input type="text"   onkeyup="this.value = this.value.toUpperCase()" id="txt_usunom" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Sexo:</label>
                                                        <div id="c_sex" >
                                                            <select id="cbx_sexo"  class="bs-select form-control small" >
                                                                <option value=" ">Selecc..</option>
                                                                <option value="MASCULINO" >MASCULINO</option>
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
                                                        <input type="text"  id="txt_usudir" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Telefono:</label>
                                                        <input type="text"  id="txt_usuTel" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Email:</label>

                                                        <input type="text"  id="txt_usuemail" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Usuario:</label>
                                                        <input type="text"  id="txt_usuusu" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Contraseña:</label>
                                                        <input type="password"  id="txt_usucon1" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Repetir Contraseña:</label>
                                                        <input type="password"  onchange="$.validarcontra2();" id="txt_usucon2" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="display: none;" id="dicont" >
                                                    <div class="form-group">
                                                        <label class="control-label"><input type="checkbox"  onclick="$.habcontra();" id="cccont" value="ON" />Cambiar Contrase&ntilde;a</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Estado:</label>
                                                        <div id="c_est">
                                                            <select id="cbx_estado"  class="bs-select form-control small" >
                                                                <option value=" ">Selecc..</option>
                                                                <option value="ACTIVO">ACTIVO</option>
                                                                <option value="INACTIVO">INACTIVO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($_SESSION['usu_maestro'] == "") { ?>
                                                    <?php if ($_SESSION['ses_user'] != "root") { ?>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Perfil:</label>
                                                                <div id="c_perf">
                                                                    <select id="cbx_perf" name="options2"  class="form-control select2" >

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Perfil:</label>
                                                                <div id="c_perf">
                                                                    <select id="cbx_perf" name="options2"  class="form-control select2" >

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="display: none;">
                                                            <div class="form-group">
                                                                <label class="control-label"># Compañias:</label>
                                                                <input type="text"  id="txt_ncompa" class="form-control" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" style="display: none;">
                                                            <div class="form-group">
                                                                <label style="font-weight: bold"><input type='checkbox'  onclick="$.bloUsuMaes();" id="ck_usumaest" class='icheck'> Asignar a usuario Maestro</label>
                                                                <div id="c_perf">
                                                                    <select id="cbx_UsuMaes" disabled="" name="options2"  class="form-control select2" >

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-md-12">
                                                    <div id="msg">
                                                    </div>
                                                </div>
                                            </div>

                                           <h4 class="form-section"></h4>
                                            <div class="form-actions right" id="mopc" >
                                                <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                                <?php
                                                if ($_SESSION['GesUsuAUs'] == "s") {
                                                    echo '<button type="button" class="btn purple" disabled id="btn_nuevo2"><i class="fa fa-file-o"></i> Nuevo</button>';
                                                }
                                                ?>
                                                 <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-close"></i> Cerrar</button>

                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- stackable -->

                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet box purple-intense">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Gesti&oacute;n de Usuarios
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="#" class="horizontal-form">
                                <div class="form-body">

                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_1">
                                            <p>
                                            <div class='portlet box blue'>

                                                <div class='portlet-body form'>
                                                    <form action='#' class='horizontal-form'>
                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <div id="sample_1_filter" class="dataTables_filter">
                                                                        <label>
                                                                            Busqueda:
                                                                            <input class="form-control input-small input-inline"  onkeyup="$.busqUsu(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                        </label>
                                                                        <div style="float: right;">
                                                                            <?php
                                                                            if ($_SESSION['GesUsuAUs'] == "s") {
                                                                                echo '<button type="button" class="btn purple" id="btn_nuevo1"><i class="fa fa-file-o"></i> Nuevo</button>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="table-scrollable">

                                                                        <div id="tab_TipDoc" style="height: 250px;overflow: scroll;">

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class='col-md-12'  >

                                                                    <div id="bot_TipDoc" style="float:right;">

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'  >
                                                                    <div class='row'>
                                                                        <div class='col-md-2'>
                                                                            <label>No. de Resgistros:
                                                                                <select id="nreg" onchange="$.combopag2(this.value)" class='form-control'>
                                                                                    <option value="5">5</option>
                                                                                    <option value="10">10</option>
                                                                                    <option value="20">20</option>
                                                                                    <option value="50">50</option>
                                                                                    <option value="100">100</option>
                                                                                    <option value="100000">Sin Limite</option>
                                                                                </select>
                                                                            </label>

                                                                        </div>
                                                                        <div class='col-md-2'>


                                                                            <div id="cobpag">

                                                                            </div>

                                                                        </div>
                                                                        <div class='col-md-5'>




                                                                        </div>

                                                                        <div class='col-md-4'>
                                                                            <div id="bot_TipDoc" style="float:right;">
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <center><h4 class='form-section'></h4></center>

                                                        </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>


                                <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT-->

                </div>
                <!-- BEGIN CONTENT -->
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
        <script src="Plugins/icheck/icheck.js" type="text/javascript"></script>
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
