<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if (!isset($_SESSION['ses_user'])) {
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
        <title>Gestión de Indicadores a Medir | Indicadores </title>
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
        <script src="../Js/MedirIndicadorProyecto.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>
        <script src="../Js/math.js" type="text/javascript"></script>


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
                                <i class="fa fa-line-chart"></i>
                                <a href="../Indicadores/MedirIndicadorProyectos.php">Gestión de Indicadores a Medir</a>
                                <i class="fa fa-circle"></i>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <!-- responsive historia indicador -->
                    <div id="HistorIdi" class="modal fade" tabindex="-1" data-width="1200">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Historial de Medicion para este Indicador </h4>


                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>

                                        <div class='row'>
                                            <div class='col-md-12'  id="tab_HistIndi">


                                            </div>
                                        </div>

                                        <h4 class='form-section'></h4>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn green btn-sm" title="Cancelar"><i class="fa fa-close"></i> Salir</button>
                        </div>

                    </div>
                    <!-- responsive historia medicion -->
                    <div id="ventanaResul" class="modal fade" tabindex="-1" data-width="1200">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Medicion Y plan de Mejora para este Indicador </h4>

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre Del Indicador:</label>
                                                    <p id="NomInd" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre Del Proyecto:</label>
                                                    <p id="Proyect" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Año:</label>
                                                    <p id="Anio" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Frecuencia Medida:</label>
                                                    <p id="FrecuencMed" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Meta:</label>
                                                    <p id="MetaMed" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label style="font-weight: bold;" class="control-label">Resultado de Primera Medicion:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Fecha Medicion:</label>
                                                    <p id="Fecha_med" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Resultado:</label>
                                                    <p id="Resulind" style="color: #e02222"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Estado:</label>
                                                    <p id="Estado" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Responsable:</label>
                                                    <p id="Responsable" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Evidencia: </label>
                                                    <div id="Evidencia">

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label style="font-weight: bold;"  class="control-label">Plan Mejora - Ruta de Actividades:</label>
                                                </div>
                                            </div>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <table class='table table-striped table-hover table-bordered' id="tb_ActivHisto">
                                                        <thead>
                                                            <tr>
                                                                <td>
                                                                    <i class='fa fa-angle-right'></i> #
                                                                </td>
                                                                <td>
                                                                    <i class='fa fa-angle-right'></i> Actividad
                                                                </td>
                                                                <td>
                                                                    <i class='fa fa-angle-right'></i> Responsable
                                                                </td>
                                                                <td>
                                                                    <i class='fa fa-angle-right'></i> Estado
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label style="font-weight: bold;" class="control-label">Resultado de Medicion despues del plan de Mejora</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Fecha Medicion:</label>
                                                    <p id="Fecha_medMej" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Resultado:</label>
                                                    <p id="ResulindMej" style="color: #e02222"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Estado:</label>
                                                    <p id="EstadoMej" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Responsable:</label>
                                                    <p id="ResponsableMej" style="color: #e02222"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Evidencia: </label>
                                                    <a id="EvidenciaMej" target="_blank" href="">Evidencia Cargada</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- responsive Grafica Historia indicador -->
                    <div id="MostrarGrafica" class="modal fade" style="font-size: 15px; text-transform: capitalize; font-weight: bold;" tabindex="-1" data-width="1200">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformiGraf'>Grafica de Datos de Medición</h4>


                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>

                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div id="chartdiv"></div>

                                            </div>
                                        </div>

                                        <h4 class='form-section'></h4>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Proyectos</a>
                        </li>
                        <li id="tab_02_pp" style="display: none;">
                            <a href="#tab_02" data-toggle="tab"  id="atitulo">Medir Indicadores</a>
                        </li>
                        <li id="tab_03_pp">
                            <a href="#tab_03" data-toggle="tab" onclick="$.listIndPlan();" id="atitulo">Medir Indicadores en Plan de Mejora</a>
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

                                                        <div class='row'>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control input-small input-inline" onkeypress="$.busqIndicador(this.value);" onchange="$.busqIndicador(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>

                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">

                                                                    <div id="tab_Indicador" style="height: 250px;overflow: scroll;">

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
                                                                        <label>No. de Resgistros:
                                                                            <select id="nreg" onchange="$.combopag2(this.value)" class='form-control'>
                                                                                <option value="5">5</option>
                                                                                <option value="10">10</option>
                                                                                <option value="20">20</option>
                                                                                <option value="50">50</option>
                                                                                <option value="100">100</option>
                                                                                <option value="*">Sin Limite</option>
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
                                                                        <div id="bot_Indicador" style="float:right;">
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <h4 class='form-section'></h4>

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
                        <div class="tab-pane fade" id="tab_02">
                            <p>
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Indicadores del Proyecto.
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
                                                <a href="#tab_IndPol" data-toggle="tab">Indicadores del Proyecto</a>
                                            </li>
                                            <li id="tab_MedIndP"  style="display: none;">
                                                <a href="#tab_MedInd" data-toggle="tab"> Medir Indicador </a>
                                            </li>


                                        </ul>
                                        <div class="tab-content">
                                            <!--                                            Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_IndPol">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Indicadores del Proyecto
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
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Indicadores">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Nombre del Indicador
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Tipo de Indicador
                                                                                    </td>

                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acción
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tb_Body_Indicadores">


                                                                            </tbody>
                                                                        </table>
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
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Detalle del Indicador.
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Nombre Del Indicador</label>
                                                                        <p id="Nom_Indi" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Objetivo</label>
                                                                        <p id="Obj_Indi" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Proceso</label>
                                                                        <p id="Proces" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Frecuencia</label>
                                                                        <p id="Frecuenc" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tipo de Indicador</label>
                                                                        <p id="TipoInd" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Fuente de Datos</label>
                                                                        <p id="Fuent" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Responsable</label>
                                                                        <p id="Respon" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Formula Matematica</label>
                                                                        <p id="Formula" style="color: #e02222"></p>
                                                                    </div>
                                                                </div>




                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                                <p>
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
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Seleccionar Meta:</label>
                                                                        <select class="form-control select2-multiple"  data-placeholder="Seleccione..." onchange="$.CambMeta(this.value)"  id="CbMetas" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Fecha de Medición:</label>
                                                                        <input type='text' id='txt_fecha_Medi' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Vigencia:</label>
                                                                        <select class='form-control'  id="CbAnio" name="options2">
                                                                            <option value=" ">Seleccione...</option>
                                                                            <option value="2016">2016</option>
                                                                            <option value="2017">2017</option>
                                                                            <option value="2018">2018</option>
                                                                            <option value="2019">2019</option>
                                                                            <option value="2020">2020</option>
                                                                            <option value="2021">2021</option>
                                                                            <option value="2022">2022</option>
                                                                            <option value="2023">2023</option>
                                                                            <option value="2024">2024</option>
                                                                            <option value="2025">2025</option>
                                                                            <option value="2026">2026</option>
                                                                            <option value="2027">2027</option>
                                                                            <option value="2028">2028</option>
                                                                            <option value="2029">2029</option>
                                                                            <option value="2030">2030</option>

                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Frecuencia a Medir:</label>
                                                                        <select class="form-control select2-multiple"  data-placeholder="Seleccione..."  id="CbFreMedmedi" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Responsable de la Medición:</label>
                                                                        <input type='text' id='txt_Respo' value="<?php echo $_SESSION['ses_nombre']; ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>


                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Variables">

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Analisis de Causas:</label>
                                                                        <textarea id="txt_AnaCaus" rows="2" class="form-control" style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Acciones Propuestas:</label>
                                                                        <textarea id="txt_AccProp" rows="2" class="form-control" style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" id="From_Arch">
                                                                        <label class="control-label">Adjuntar Evidencias <span class="required">* </span></label>
                                                                        <form enctype="multipart/form-data" class="form" id="form">
                                                                            <input type="file" id="archivos" multiple name="archivos" accept="application/" >
                                                                            Tamaño Del Archivo: <span id="fileSize">0</span></p>
                                                                        </form>
                                                                        <p class="help-block">
                                                                            <span class="label label-danger">
                                                                                NOTA: </span>
                                                                            &nbsp; El Tamaño Del Documento No Puede Ser Mayor De 20 MB.
                                                                        </p>
                                                                        <input type="hidden" id="Src_File" class="form-control"  />
                                                                        <input type="hidden" id="Name_File" class="form-control" placeholder="Name_File" />

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div id="msgArch">
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12' style="text-align: right">
                                                                    <div class='form-group' >
                                                                        <label class='control-label'>&nbsp;</label>
                                                                        <a onclick="$.AddMedIndi()" class="btn green-meadow">
                                                                            <i class="fa fa-plus-circle"></i> Agregar
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_IndMedi">

                                                                        </table>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="display: none;">
                                                                    <div class="form-group">
                                                                        <input type='hidden' onkeypress="$.restForm();" id='txt_expre' onchange="$.cal();" value="" class='form-control' />
                                                                        <input type='hidden' onkeypress="$.restForm();" id='txt_expreCal' onchange="$.cal();" value="" class='form-control' />
                                                                        <input type='hidden'  id='txt_formula' value="" class='form-control' />
                                                                        <input type='hidden'  id='txt_resindi' value="" class='form-control' />
                                                                        <input type='text'  id='txt_metaPlan' value="" class='form-control' />
                                                                        <input type='text'  id='contIndMedi' value="0" class='form-control' />
                                                                        <input type="hidden" id="TitVar" value="" />
                                                                        <input type="hidden" id="ValVar" value="" />
                                                                        <input type="hidden" id="txt_id" value="" />
                                                                        <input type="hidden" id="txt_EstEval" value="" />
                                                                        <input type="hidden" id="acc" value="1" />
                                                                        <input type="hidden" id="id_ori" value="" />

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
                                                        <div class="form-actions right">
                                                            <button type="button" class="btn blue" id="btn_histo"><i class="fa fa-bar-chart"></i> Historial de Medicion</button>
                                                            <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                                            <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
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
                            </p>
                        </div>
                        <div class="tab-pane fade" id="tab_03">
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Medir Indicadores en Plan de Mejora.
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>

                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <label id="nom_poli" style="font-size: 14px; font-weight: bold;"></label>
                                        <ul class="nav nav-tabs">
                                            <li id="tab_IndPlanP"  class="active">
                                                <a href="#tab_IndPlan" data-toggle="tab">Indicadores en Plan de Mejora</a>
                                            </li>
                                            <li id="tab_MedIndPlanP"  style="display: none;">
                                                <a href="#tab_MedIndplan" data-toggle="tab"> Medir Indicador en Plan de Mejora </a>
                                            </li>


                                        </ul>
                                        <div class="tab-content">
                                            <!--                                            Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_IndPlan">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Indicadores en Plan de Mejora
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class='row'>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label>
                                                                            Busqueda:
                                                                            <input class="form-control input-small input-inline" onkeypress="$.busqIndicadorPlan(this.value);" onchange="$.busqIndicadorPlan(this.value);" id="busq_IndPlan" type="search" placeholder="" aria-controls="sample_1">
                                                                        </label>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class="table-scrollable">

                                                                        <div id="tab_IndicadorPlan" style="height: 250px;overflow: scroll;">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'  >
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div id="msg2Plan">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='row'>
                                                                        <div class='col-md-2'>
                                                                            <label>No. de Resgistros:
                                                                                <select id="nregPlan" onchange="$.combopag2Plan(this.value)" class='form-control'>
                                                                                    <option value="5">5</option>
                                                                                    <option value="10">10</option>
                                                                                    <option value="20">20</option>
                                                                                    <option value="50">50</option>
                                                                                    <option value="100">100</option>
                                                                                    <option value="*">Sin Limite</option>
                                                                                </select>
                                                                            </label>

                                                                        </div>
                                                                        <div class='col-md-2'>


                                                                            <div id="cobpagPlan">

                                                                            </div>

                                                                        </div>
                                                                        <div class='col-md-5'>

                                                                        </div>

                                                                        <div class='col-md-4'>
                                                                            <div id="bot_IndicadorPlan" style="float:right;">
                                                                            </div>

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
                                            <div class="tab-pane fade" id="tab_MedIndPlan">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Ruta de Actividades.
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
                                                                        <input type="hidden" id="IdInd" value="" />
                                                                        <!--<input type="hidden" id="txt_id" value="" />-->
                                                                        <input type="hidden" id="txt_idEval" value="" />
                                                                        <input type="hidden" id="contActivi" value="0" />
                                                                        <input type="hidden" id="acc" value="1" />
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Activ">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Actividad
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Responsable
                                                                                    </td>

                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acción
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tb_Body_Actividades">


                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="msg3">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-actions right">
                                                                <button type="button" class="btn blue" id="btn_MedIndPlan"><i class="fa fa-bar-chart"></i> Medir Indicador</button>
                                                                <button type="button" class="btn green" id="btn_guardarActPlan"><i class="fa fa-save"></i> Guardar Ruta de Atividades</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                                <p>
                                                <div class='portlet box blue' id="idpanelmedi"  style="display: none;">
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
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Fecha de Medición:</label>
                                                                        <input type='text' id='txt_fecha_MediPlan' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Año:</label>
                                                                        <input type='text' id='AnioPlan' disabled value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Frecuencia a Medir:</label>
                                                                        <input type='text' id='FreMedmediPlan' disabled="" value="" class='form-control' />

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Responsable de la Medición:</label>
                                                                        <input type='text' id='txt_RespoPlan' value="<?php echo $_SESSION['ses_nombre']; ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_VariablesPlan">

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Analisis de Causas:</label>
                                                                        <textarea id="txt_AnaCausPlan" rows="2" class="form-control" style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Acciones Propuestas:</label>
                                                                        <textarea id="txt_AccPropPlan" rows="2" class="form-control" style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" id="From_Arch">
                                                                        <label class="control-label">Adjuntar Evidencias <span class="required">* </span></label>
                                                                        <form enctype="multipart/form-data" class="form" id="form">
                                                                            <input type="file" id="archivosPlan" name="archivosPlan" multiple  accept="application/" >
                                                                            Tamaño Del Archivo: <span id="fileSizePlan">0</span></p>
                                                                        </form>
                                                                        <p class="help-block">
                                                                            <span class="label label-danger">
                                                                                NOTA: </span>
                                                                            &nbsp; El Tamaño Del Documento No Puede Ser Mayor De 20 MB.
                                                                        </p>
                                                                        <input type="hidden" id="Src_FilePlan" class="form-control"  />
                                                                        <input type="hidden" id="Name_FilePlan" class="form-control" placeholder="Name_File" />

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div id="msgArchPlan">
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_IndMediPlan">

                                                                        </table>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="display: none;">
                                                                    <div class="form-group">
                                                                        <input type='text' onkeypress="$.restForm();" id='txt_exprePlan' onchange="$.calPlan();" value="" class='form-control' />
                                                                        <input type='hidden'  id='txt_formulaPlan' value="" class='form-control' />
                                                                        <input type='text'  id='txt_resindiPlan' value="" class='form-control' />
                                                                        <input type='text'  id='txt_titPlan0' value="" class='form-control' />
                                                                        <input type='text'  id='txt_titPlan1' value="" class='form-control' />
                                                                        <input type='text'  id='contIndMediPlan' value="0" class='form-control' />
                                                                        <input type="hidden" id="txt_idPlan" value="" />
                                                                        <input type="hidden" id="txt_idMed" value="" />
                                                                        <input type="hidden" id="accPlan" value="1" />
                                                                        <input type="hidden" id="id_oriPlan" value="" />

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div id="msgPla">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-actions right">
                                                            <button type="button" class="btn blue" id="btn_histo2"><i class="fa fa-bar-chart"></i> Historial de Medicion</button>
                                                            <button type="button" class="btn green" id="btn_guardarPlan"><i class="fa fa-save"></i> Guardar</button>
                                                            <button type="button" class="btn red" id="btn_cancelarPlan"><i class="fa fa-times"></i> Cancelar</button>
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
