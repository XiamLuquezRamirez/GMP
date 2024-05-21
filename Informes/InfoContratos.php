<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['GesInfVIn'] == "n") {
    echo "<script>alert('Actualmente no tienes permiso de accesos a este contenido');javascript:window.history.back();</script>";
}
//
if (isset($_GET['Logout'])) {
    header("Location:cerrar.php?opc=1");
    session_destroy();
}

include "../Conectar.php";
$link = conectar();
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Informe de Contratos | GMP - Gestor Monitoreo Público</title>
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

        <!-- AMCHARTS STYLES -->
        <link href="../Plugins/amcharts/export.css" rel="stylesheet" type="text/css"/>
        <!-- END AMCHARTS STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="../Img/favicon.ico" />

        <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>
        <script src="../Js/InfoContratos.js" type="text/javascript"></script>
        <script type="text/javascript"
                src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false" >
        </script>


        <style>
            #chartdiv {
                width: 100%;
                height: 500px;
                font-size: 11px;
            }

            .amcharts-pie-slice {
                transform: scale(1);
                transform-origin: 50% 50%;
                transition-duration: 0.3s;
                transition: all .3s ease-out;
                -webkit-transition: all .3s ease-out;
                -moz-transition: all .3s ease-out;
                -o-transition: all .3s ease-out;
                cursor: pointer;
                box-shadow: 0 0 30px 0 #000;
            }


        </style>

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
                                <a>Administración</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <a href="../Evolucion_Contratos/">Evolución de los contratos</a>
                            </li>

                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <!-- Inicio Ventana Contratos -->
                    <div id="modalContratos" class="modal fade" tabindex="-1" data-width="980" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-body">
                            <div class='portlet box red'>
                                <div class='portlet-title'>
                                    <div class='caption'>
                                        <i class='fa fa-angle-right'></i>Listado de Contratos
                                    </div>
                                </div>
                                <div class='portlet-body form'>
                                    <div class='form-body'>
                                        <div class='row'>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class='control-label' for='busqueda'>Busqueda </span></label>
                                                    <input type='text' name='busqueda' id='busqueda' class='form-control' />
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class='control-label' for='obj_contrato'>&nbsp;</label>
                                                    <label class='control-label' for='obj_contrato'>&nbsp;</label>
                                                    <a href="javascript:;" class="btn red icn-only" id='btnBusCon'><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed table-hover table-striped " >
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col" style="font-size: 10px;width: 5%">#</th>
                                                                <th style="font-size: 10px;width: 10%;"># Contrato</th>
                                                                <th style="font-size: 10px;width: 35%;">Objeto Contrato</th>
                                                                <th style="font-size: 10px;width: 10%;text-align:center;">% Avance</th>
                                                                <th style="font-size: 10px;width: 10%">Inicio</th>
                                                                <th style="font-size: 10px;width: 10%">Finalización</th>
                                                                <th style="font-size: 10px;width: 10%;text-align:center;">Estado</th>
                                                                <th style="font-size: 10px;width: 10%;text-align:center;">Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="contenidoContratos">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn green btn-sm">
                                <i class='fa fa-close'></i> Cancelar
                            </button>
                        </div>
                    </div>
                    <!-- Fin Ventana Contratos -->
                    <!-- stackable -->

                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet box blue-soft">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Evolución de los Contratos.
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                            <!-- <h3 class="form-section">Datos del Contrato</h3> -->
                                <div class="tab-content">
                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgEvoCon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class=row >
                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Tipo de Informe:<span class="required">* </span></label>
                                                    <select class='form-control' id="cmbTipo" name="cmbTipo">
                                                        <option value="TODOS"  >Todos los Contratos</option>
                                                        <option value="INDIVIDUAL" >Individual</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='col-md-9'>
                                                <div class='form-group' id='filaProyectos' >
                                                    <label class='control-label'>Proyectos:</label>
                                                    <select class='form-control select2' id="cmbProyectos" name="cmbProyectos">
                                                        <option value='TODOS'  >Todos los Proyectos</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style='display:none;' id='filaIndividual'>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class='control-label' for='num_contrato'>Número de Contrato</label>
                                                    <input type='text' name='num_contrato' id='num_contrato' class='form-control' placeholder='Número de Contrato' readonly style='background-color:white;'/>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class='control-label' for='obj_contrato'>Objeto de Contrato</label>
                                                    <input type='text' name='obj_contrato' id='obj_contrato' class='form-control' placeholder='Objeto de Contrato' readonly style='background-color:white;'/>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class='control-label' for='obj_contrato'>&nbsp;</label>
                                                    <label class='control-label' for='obj_contrato'>&nbsp;</label>
                                                    <a href="javascript:;" class="btn red icn-only" id='btnContratos'><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row' style='text-align: right;'>
                                        <div class='col-md-12'>
                                            <a href='javascript:;' class='btn btn-warning' id='btnExportar'>
                                                <i class="fa fa-file-pdf-o"></i> Exportar
                                            </a>
                                            <a href='javascript:;' class='btn btn-success' id='btnConsultar'>
                                                <i class='fa fa-search'></i> Consultar
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-hover table-striped " >
                                                    <thead class="">
                                                        <tr>
                                                            <th scope="col" style="font-size: 10px;width: 5%">#</th>
                                                            <th style="font-size: 10px;width: 13%;text-align:right;">V. Adición</th>
                                                            <th style="font-size: 10px;width: 13%;text-align:right;">V. Final</th>
                                                            <th style="font-size: 10px;width: 13%;text-align:right;">V. Ejecutado</th>
                                                            <th style="font-size: 10px;width: 10%;text-align:center;">Fec. Suspensión</th>
                                                            <th style="font-size: 10px;width: 9%;text-align:center;">Fec. Reinicio</th>
                                                            <th style="font-size: 10px;width: 7%"> Prorroga</th>
                                                            <th style="font-size: 10px;width: 10%;text-align:center;">Fec. Finalización</th>
                                                            <th style="font-size: 10px;width: 8%;text-align:center;">Fec. Recibo</th>
                                                            <th style="font-size: 10px;width: 7%;text-align:center;">% Avance</th>
                                                            <th style="font-size: 10px;width: 5%;text-align:center;">Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contenidoEvolucion">

                                                    </tbody>
                                                </table>
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

        <!-- AMCHARTS -->
        <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="http://www.amcharts.com/lib/3/pie.js"></script>
        <script src="../Plugins/amcharts/export.min.js" type="text/javascript"></script>
        <script src="../Plugins/amcharts/light.js" type="text/javascript"></script>
        <!-- END AMCHARTS -->


    </body>
</html>
?>