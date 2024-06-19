<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['GesPlaVCo'] == "n") {
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
        <title> Gestión de <?php echo $_SESSION['nivel2']; ?> | GMP - Gestor Monitoreo Público</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="../http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
        <script src="../Js/GestionComponentes.js" type="text/javascript"></script>
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
                                <i style="color: yellow;"  class="fa fa-star"></i>
                                <a href="../Programas/">Gestión de <?php echo $_SESSION['nivel2']; ?> </a>

                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <div id="ventanaImg" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <form action='#' id="formnot" class='horizontal-form'>
                                        <div class='form-body'>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <div id="contenedor">
                                                        <img src="" alt="Imagen" style="height: 500px; width: 100%;" >
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <h2 class='form-section'></h2>
                                        <div class="form-actions right">
                                            <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-"></i> Cerrar</button>
                                        </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="responsive" class="modal fade" tabindex="-1" data-width="900">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Datos de <?php echo $_SESSION['nivel2']; ?></h4>


                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <p class="control-label" style="font-weight: bold;"> Campos Obligatorios <span class="required">* </span> </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label">Codigo: <span class="required">* </span></label>
                                                    <div class="form-inline">
                                                        <div class="form-group" id="From_Codigo0">
                                                            <div class="input-group" >
                                                                <span class="input-group-btn">
                                                                    <button type="button" id="btn_para" title="Busqueda del Eje" class="btn green-meadow">
                                                                        <i class="fa fa-search fa-fw"/></i>
                                                                    </button>
                                                                </span>
                                                                <input type="text" id="txt_cod_pp" title="Código del Eje" class="form-control input-xsmall" disabled />

                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="From_Codigo">
                                                            <input type="text" id="txt_codigo" disabled="" onkeyup='this.value = this.value.toUpperCase()' class="form-control input-small"  /><input type="hidden" id="acc" value="1" /><input type="hidden" id="txt_id" value="1" /><input type="hidden" id="cons" value="1" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group" id="From_Descripcion">
                                                    <label class="control-label">Descripción: <span class="required">* </span></label>
                                                    <textarea id="txt_Descripcion" class="form-control txt" ></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="nestr" style="display: none">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php  echo  $_SESSION['nivel1']; ?></label>
                                                    <input type="hidden" id="txt_id_pp"  class="form-control" disabled />
                                                    <textarea id="txt_nomb_est" cols="2" class="form-control txt" disabled></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Observación: </label>
                                                    <textarea id="txt_obser" class="form-control txt" ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group" id="From_Arch">
                                                    <label class="control-label">Imagen:</label>
                                                    <form enctype="multipart/form-data" class="form" id="form">
                                                        <input type="file" id="archivos" name="archivos" accept="application/" >
                                                        Tamaño Del Archivo: <span id="fileSize">0</span></p>
                                                    </form>
                                                    <input type="hidden" id="Src_File" class="form-control"  />
                                                    <input type="hidden" id="Name_File" class="form-control" placeholder="Name_File" />
                                                </div>
                                            </div>
                                            <div class="col-md-2" id="MostImg" style="display: none;">
                                                <div class="form-group">
                                                    <button type="button" class="btn blue" id="btn_img"><i class="fa fa-search"></i> Ver Imagen</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msg">
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class='form-section'></h2>
                                        <div class="form-actions right" id="mopc" >
                                            <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>

                                            <?php
                                            if ($_SESSION['GesPlaACo'] == "s") {
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
                    <div id="ventana" class="modal fade" tabindex="-1" data-width="900">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Parametros Registrados</h4>
                        </div>
                        <div class="modal-body">
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div id="sample_1_filter" class="dataTables_filter">
                                        <label>
                                            Busqueda:
                                            <input class="form-control input-small input-inline" onkeyup="$.busqEjes(this.value);"  id="busq" type="search" placeholder="" aria-controls="sample_1">
                                        </label>
                                    </div>
                                    <div class="table-scrollable">
                                        <div id="tab_Vent" style="height: 250px;overflow: scroll;">

                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-12'  >
                                    <div class='row'>
                                        <div class='col-md-2'>
                                            <label>No. de Registros:
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
                                            <div id="cobpagVent">
                                            </div>
                                        </div>
                                        <div class='col-md-5'>
                                        </div>
                                        <div class='col-md-4'>
                                            <div id="bot_Vent" style="float:right;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" id="btn_aceptar" class="btn green" title="Aceptar"><i class="fa fa-check"></i> Aceptar</button>-->
                            <button type="button" data-dismiss="modal" class="btn red" title="Cancelar"><i class="fa fa-times"></i> Cancelar</button>
                        </div>
                    </div>



                    <!-- stackable -->

                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet box blue-soft">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Gestión de <?php echo $_SESSION['nivel2']; ?>.
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">

                            <div class="form-body">

                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab_1">
                                        <p>
                                        <div class='portlet box blue'>

                                            <div class='portlet-body form'>

                                                <div class='form-body'>

                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <div id="sample_1_filter" class="dataTables_filter">
                                                                <label>
                                                                    Busqueda:
                                                                    <input class="form-control input-small input-inline" onkeyup="$.busqCompo(this.value);"  id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                </label>
                                                                <div style="float: right;">
                                                                    <div class="btn-group dropup">
                                                                        <button class="btn green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-file-excel-o"></i> Generar Excel 
                                                                        </button>
                                                                        <ul class="dropdown-menu pull-right" role="menu">

                                                                            <li >
                                                                                <a onclick="$.ExcelPlan();">
                                                                                    Plan de Desarrollo </a>
                                                                            </li>
                                                                            <li>
                                                                                <a onclick="$.ExcelComp() ;">
                                                                                <?php echo $_SESSION['nivel2']; ?> </a>
                                                                            </li>


                                                                        </ul>
                                                                    </div>
                                                                    <!--<button type="button" class="btn green" id="btn_Excel"><i class="fa fa-file-excel-o"></i> Generar Excel</button>-->
                                                                    <?php
                                                                    if ($_SESSION['GesPlaACo'] == "s") {
                                                                        echo ' <button type = "button" class = "btn purple" id = "btn_nuevo1"><i class = "fa fa-file-o"></i> Nuevo</button>';
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>

                                                            <div class="table-scrollable">

                                                                <div id="tab_Estrategias"  style="height: 250px;overflow: scroll; ">

                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class='col-md-12'  >
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="msg2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-2'>
                                                                    <label>No. de Registros:
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
                                                                    <div id="bot_Estrategias" style="float:right;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class='form-section'></h4>

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
