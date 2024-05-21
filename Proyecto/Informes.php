<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if ($_SESSION['ses_user'] == NULL) {
    echo "<script>location.href='../index.php'</script>";
    exit();
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
        <title>Gestión de Proyectos | GMP - Gestor Monitoreo Público </title>
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

        <style>
            #chartdiv {
                width: 100%;
                height: 500px;
            }
        </style>

        <link rel="shortcut icon" href="../Img/favicon.ico" />

        <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../Js/InformeBanco.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>
        <script src="../Js/math.js" type="text/javascript"></script>
        <!--<script src="../Js/UbiMapBanco.js" type="text/javascript"></script>-->
        <script type="text/javascript"
                src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false" >
        </script>


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
                                <i class="fa fa-line-chart"></i>
                                <a href="Proyecto/Informes.php">Gestión de Informes Banco de Banco de Proyecto</a>
                                <i class="fa fa-circle"></i>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>


                    <div class="portlet box purple-intense">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Informe del Banco de Proyecto.
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>

                        <div class="portlet-body form">
                            <div class="form-body">
                                <label id="nom_poli" style="font-size: 14px; font-weight: bold;"></label>
                                <ul class="nav nav-tabs">
                                    <li id="tab_IndPoliP"  class="active">
                                        <a href="#tab_IndPol" data-toggle="tab">Generar Informe</a>
                                    </li>
                                    <li id="tab_MedIndP" onclick="$.localizame();"  >
                                        <a href="#tab_MedInd" data-toggle="tab">Consultas Georreferenciadas</a>
                                    </li>


                                </ul>
                                <div class="tab-content">
                                    <!--                                            Inf. General -->
                                    <div class="tab-pane fade active in" id="tab_IndPol">
                                        <p>
                                        <div class='portlet box blue'>
                                            <div class='portlet-title'>
                                                <div class='caption'>
                                                    <i class='fa fa-angle-right'></i>Parametros de informe
                                                </div>
                                                <div class='tools'>
                                                    <a href='javascript:;' class='collapse'></a>
                                                </div>
                                            </div>
                                            <div class='portlet-body form'>
                                                <div class='form-body'>
                                                    <div class="row">
                                                        <div class='col-md-12'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Proyecto:</label>
                                                                <select class="form-control select2" id="CbProyec"  name="options2">

                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class='col-md-4'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Eje:</label>
                                                                <select class="form-control select2" data-placeholder="Seleccione..."   id="CbEjes" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class='col-md-4'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Estrategia:</label>
                                                                <select class="form-control select2"  data-placeholder="Seleccione..."  id="CbEtrategias" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Programa:</label>
                                                                <select class="form-control select2"  data-placeholder="Seleccione..." id="CbProgramas" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class='col-md-4'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Tipologia:</label>
                                                                <select class="form-control select2" id="CbTiplog"  name="options2">

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Dependencia:</label>
                                                                <select class="form-control select2" id="CbDepend"  name="options2">

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Proceso Estrategico:</label>
                                                                <select class="form-control select2" id="CbProceso" name="options2">

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Estado:</label>
                                                                <select class='form-control' id="CbEstado" name="options2">
                                                                    <option value=" ">Todos...</option>
                                                                    <option value="Radicados"  >Radicados</option>
                                                                    <option value="Registrados" >Registrados</option>
                                                                    <option value="Priorizado" >Priorizados</option>
                                                                    <option value="En Ejecucion" >En Ejecución</option>
                                                                    <option value="No Viabilizados" >No Viabilizados</option>
                                                                    <option value="Ejecutado" >Ejecutado</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Departamento:</label>
                                                                <select class="form-control select2" id="CbDepa" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Municipio:</label>
                                                                <select class="form-control select2" id="CbMun"  name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Corregimiento:</label>
                                                                <select class="form-control select2"   id="CbCorre" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-actions right">
                                                            <button type="button" class="btn blue" id="btn_informe"><i class="fa fa-search"></i> Consultar</button>
                                                        </div>
                                                        <div class="row">
                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_ResulInf">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Proyecto
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i>Dependencia
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i>Indicador
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Proceso Estrategico
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Resultado
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id='tb_Body_Indicador'>

                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan='4' style='text-align: right;'>Total:</th>
                                                                                <th colspan='1'><label id='gtotal' style='font-weight: bold;'></label></th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </p>
                                    </div>

                                    <!--                                            Articulacion Con El Plan De Desarrollo -->
                                    <div class="tab-pane fade" id="tab_MedInd">


                                        <div class='portlet box blue'>
                                            <div class='portlet-title'>
                                                <div class='caption'>
                                                    <i class='fa fa-angle-right'></i>Medir Indicador.
                                                </div>
                                                <div class='tools'>
                                                    <a href='javascript:;' class='collapse'></a>
                                                </div>
                                            </div>
                                            <div class='portlet-body form'>

                                                <div class='form-body'>

                                                    <div class="row">
                                                        <div class='col-md-4'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Eje:</label>
                                                                <select class="form-control select2" data-placeholder="Seleccione..."   id="CbEjes2" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Dependencia:</label>
                                                                <select class="form-control select2" id="CbDepend2"  name="options2">

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Estado:</label>
                                                                <select class='form-control' id="CbEstado2" name="options2">
                                                                    <option value=" ">Todos...</option>
                                                                    <option value="Radicados"  >Radicados</option>
                                                                    <option value="Registrados" >Registrados</option>
                                                                    <option value="Priorizado" >Priorizados</option>
                                                                    <option value="En Ejecucion" >En Ejecución</option>
                                                                    <option value="No Viabilizados" >No Viabilizados</option>
                                                                    <option value="Ejecutado" >Ejecutado</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Departamento:</label>
                                                                <select class="form-control select2" id="CbDepa2" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Municipio:</label>
                                                                <select class="form-control select2" id="CbMun2"  name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Corregimiento:</label>
                                                                <select class="form-control select2"   id="CbCorre2" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class='col-md-3' style="text-align: right">
                                                            <div class='form-group' >
                                                                <label class='control-label'>&nbsp;</label>
                                                                <a onclick="$.MostrarMap()" class="btn green-meadow">
                                                                    <i class="fa fa-map-marker"></i> Mostrar
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class='col-md-12'>
                                                            <div class='form-group'>
                                                                <p><label>Localización geográfica: </label>
                                                                    <input style="width:400px;display: none;" type="text" id="direccion" name="direccion" value=""/>
                                                                    <button style="display: none;" id="pasar">Obtener coordenadas</button>
                                                                <div id="map_canvas" style="width:100%;height:400px;"></div>

                                                                <p><label> </label><input type="hidden" readonly name="lat" id="lat"/></p>
                                                                <p><label> </label> <input type="hidden" readonly name="lng" id="long"/></p>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="msg">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        </p>
                                    </div>



                                </div>

                            </div>


                            <!-- END FORM-->
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

        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>


        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../Css/Layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../Css/Layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../Css/Layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>
</html>
