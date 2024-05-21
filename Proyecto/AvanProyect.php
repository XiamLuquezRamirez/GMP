<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if ($_SESSION['ses_user'] == NULL) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}


if ($_SESSION['GesAvaVPro'] == "n") {
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
        <title>Avances de Proyectos | GMP - Gestor Monitoreo Público</title>
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
        <script src="../Js/AvanProyect.js" type="text/javascript"></script>
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
                                <i style="color: yellow;"  class="fa fa-star"></i>
                                <a href="../Avances/AvanProyect.php">Avances de Proyectos</a>

                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <!-- responsive -->
                    <div id="responsiveImg" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'></h4>


                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <form action='#' id="formnot" class='horizontal-form'>
                                        <div class='form-body'>

                                            <input type="hidden" id="idGal" value="" />
                                            <input type="hidden" id="idnoti" value="" />

                                            <div class='row'>

                                                <div class='col-md-12'>
                                                    <div id="contenedor">
                                                        <img src="" alt="Imagen" style="height: 500px; width: 100%;" >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab" id="titlist" > Listado de Proyectos</a>
                        </li>
                        <li id="tab_02_pp" style="display: none;">
                            <a href="#tab_02" data-toggle="tab"  id="atitulo">Agregar Avance de Proyecto</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_01">

                            <div class="portlet-body form">

                                <div class="form-body">

                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_011">
                                            <p>
                                            <div class='portlet box blue'>

                                                <div class='portlet-body form'>

                                                    <div class='form-body'>

                                                        <div class='row'  id="ListProyect">

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control input-small input-inline" onkeypress="$.busqProyect(this.value);" onchange="$.busqProyect(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>

                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">

                                                                    <div id="tab_Proyect" style="height: 350px;overflow: scroll;">

                                                                    </div>
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
                                                                        <div id="bot_Proyect" style="float:right;">
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>


                                <!-- END FORM-->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_02">
                            <p>
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Agregar Avance de Proyecto
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class='portlet-body form'>
                                    <input type="hidden" id="contImg" value="0" />
                                    <input type="hidden" id="id_proy" value="0" />
                                    <input type="hidden" id="typearchid_proy" value="" />
                                    <div class='form-body'>
                                        <div class='row'>
                                            <div class='col-md-4'>
                                                <div class='form-group' id="From_Act">
                                                    <label class='control-label' >Imagenes de:</label>
                                                    <select class='form-control' id="CbEstImg" name="options2">
                                                        <option value=" ">Select...</option>
                                                        <option value="Estado Inicial"  >Estado Inicial</option>
                                                        <option value="Avances" >Avances</option>
                                                        <option value="Estado Final" >Estado Final</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group' id="From_Fech">
                                                    <label class='control-label' >Fecha:</label>
                                                    <input type='text' id='txt_fecha' value="" class='form-control' readonly/>
                                                </div>
                                            </div>

                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Adjuntar Imagenes<span class='required'>* </span></label>
                                                    <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                        <input type="file" id="archivosGale"  multiple>

                                                    </form>
                                                </div>
                                            </div>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <div id="vista-previa"></div>
                                                    <div id="respuesta"></div>
                                                </div>
                                            </div>

                                            <div class='col-md-2' style="vertical-align: middle;">
                                                <div class='form-group'>
                                                    <a onclick="$.AddGaleria()" class="btn green-meadow">
                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="msg">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <table class='table table-striped table-hover table-bordered' id="tb_Galeria">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <i class='fa fa-angle-right'></i> #
                                                                </th>
                                                                <th>
                                                                    <i class='fa fa-angle-right'></i> Nombre
                                                                </th>
                                                                <th>
                                                                    <i class='fa fa-angle-right'></i> Imagenes de
                                                                </th>

                                                                <th>
                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id='tb_Body_Galeria'>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                        <!-- END PAGE CONTENT-->

                        <div id="cargando" class="modal fade" tabindex="-1" data-width="150">
                            <div class="modal-footer">
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
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
            <script src="../Plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
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
>