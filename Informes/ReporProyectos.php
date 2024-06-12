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

include("../Conectar.php");
$link = conectar();
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Reportes de Proyectos | GMP - Gestor Monitoreo Público</title>
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

        <!-- AMCHARTS STYLES -->
        <link href="../Plugins/amcharts/export.css" rel="stylesheet" type="text/css"/>
        <!-- END AMCHARTS STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="../Img/favicon.ico" />
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false" >
        </script>

        <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../Js/ReporProyectos.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>
      


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

            /*            .amcharts-pie-slice:hover {
                            transform: scale(1.1);
                            filter: url(#shadow);
                        }*/
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
                                <a href="#">Reportes de Proyectos</a>

                            </li>

                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <div id="VentDetContratos" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Datos del Contrato</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Número:</label>
                                        <p id="ncontrat" style="color: #e02222; margin: 0px 0;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Creacion:</label>
                                        <p id="fcontrat" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipología del Contrato:</label>
                                        <p id="tipcontrat" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Objeto:</label>
                                        <p id="objcontrat" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Contratista:</label>
                                        <p id="Contratis" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Supervisor:</label>
                                        <p id="Supervi" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Interventor:</label>
                                        <p id="Intervent" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Valor del Contrato:</label>
                                        <p id="ValContrat" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Adicion del Contrato:</label>
                                        <p id="ValAdicion" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Valor Final del Contrato:</label>
                                        <p id="ValFinal" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">V. Eje. del Contrato:</label>
                                        <p id="ValEjecut" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Forma de Pago:</label>
                                        <p id="FPago" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Duración:</label>
                                        <p id="DurContra" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">F. de Inicio:</label>
                                        <p id="Fecini" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">F. de Suspensión:</label>
                                        <p id="FecSusp" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">F. de Reinicio:</label>
                                        <p id="FecRein" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Prorroga:</label>
                                        <p id="Prorroga" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">F. de Finalización:</label>
                                        <p id="FecFinal" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Recibo:</label>
                                        <p id="FecRecib" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Estado:</label>
                                        <p id="Estado" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">% de Avance:</label>
                                        <p id="PorAva" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div id="VentDetProyectos" class="modal fade" tabindex="-1" data-width="900">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Datos del Proyecto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Código:</label>
                                        <p id="codproy" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Creacion:</label>
                                        <p id="fproyecto" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a href="../All.php"></a>
                                        <label class="control-label">Tipología del Proyecto:</label>
                                        <p id="tipproyecto" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Nombre:</label>
                                        <p id="nombproy" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Secretaria:</label>
                                        <p id="nsecreataria" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Estado:</label>
                                        <p id="estProy" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-body">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab"> Contratos</a>
                                            </li>
                                            <li >
                                                <a href="#tab_2" data-toggle="tab"> Metas Trazadoras</a>
                                            </li>
                                            <li>
                                                <a href="#tab_3" data-toggle="tab"> Metas de Producto </a>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <!--                                            Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Contratos
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class="row">
                                                                <table class='table table-striped table-hover table-bordered' id="tb_Contratos">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> #
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Código
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Objeto
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Tipologia
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id='tb_Body_Contratos'>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                            </div>

                                            <!--                                            Articulacion Con El Plan De Desarrollo -->
                                            <div class="tab-pane fade" id="tab_2">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Metas Trazadoras
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <table class='table table-striped table-hover table-bordered' id="tb_MetasT">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> #
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Descripción Meta
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Unidad Medida
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Base
                                                                            </th>
                                                                            <th>
                                                                                <i class='fa fa-angle-right'></i> Meta
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id='tb_Body_MetasP'>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                            </div>
                                            <!--                                            Descripción     -->
                                            <div class="tab-pane fade" id="tab_3">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Metas de Producto
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
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_MetasP">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </th>
                                                                                    <th>
                                                                                        <i class='fa fa-angle-right'></i> Código
                                                                                    </th>
                                                                                    <th>
                                                                                        <i class='fa fa-angle-right'></i> Descripción de la Meta
                                                                                    </th>
                                                                                    <th>
                                                                                        <i class='fa fa-angle-right'></i> Acción
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id='tb_Body_MetaProd'>

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="VentDetGraf" class="modal fade" tabindex="-1"   data-width="760" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Contrato por Proyecto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div id="chartdiv2" style="overflow-y: scroll; height: 700px; " ></div>


                            </div>

                        </div>

                    </div>

                    <!-- stackable -->

                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet box blue-soft">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Reportes de Proyectos.
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">

                            <div class="form-body">

                                <div class="tab-content">
                                    <div class="tab-pane fade active in" >                                                                                <div class='portlet box blue'>
                                            <div class='portlet-body form'>
                                                <div class='form-body'>

                                                    <div class='row'>
                                                        <div class='col-md-4'>
                                                            <div class='form-group' id="From_Estado">
                                                                <label class='control-label'>Tipo de Reporte:</label>

                                                                <select class='form-control' id="CbTipInf" onchange="$.HabInf(this.value);" name="options2">
                                                                    <option value=" ">Select...</option>
                                                                    <option value="1">Reporte General de Proyectos por Estados</option>
                                                                    <option value="4">Reporte General de Contratos por Estados</option>
                                                                    <option value="2">Reporte General de Proyectos por Secretarias</option>
                                                                    <option value="3">Reporte General de Proyectos por Ejes</option>
                                                                    <option value="5">Reporte de Gestión de Proyectos</option>
                                                                    <option value="C">Reporte de proyectos por Contratos</option>
                                                                    <option value="G">Cosultar Mapa Geoferrencial de Proyectos</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='row' id="filtros" >

                                                        <div class='col-md-6'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Secretaria:</label>
                                                                <select class="form-control select2" disabled="" id="CbSecre"  name="options2">

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class='col-md-6'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Ejes:</label>
                                                                <select class="form-control select2" disabled  id="CbEje" onchange="$.CargCompone(this.value);"  name="options2">

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class='col-md-6'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>Programa:</label>
                                                                <select class="form-control select2" disabled="" onchange="$.CargProg(this.value);"  id="CbComp"  name="options2">
                                                                    <option value=' '>Todos...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <div class='form-group' >
                                                                <label class='control-label'>SubPrograma:</label>
                                                                <select class="form-control select2" disabled="" id="CbProg"  name="options2">
                                                                    <option value=' '>Todos...</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class='col-md-12' id="DivCbProy">
                                                            <div class='form-group' >
                                                                <label class='control-label'>Proyecto:</label>
                                                                <select class="form-control select2" disabled  id="CbProy"  name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3' id="DivCbEstado" style="display: none;">
                                                            <div class='form-group'>
                                                                <label class='control-label'>Estado:</label>
                                                                <select class='form-control' id="CbEstado"  name="options2">
                                                                    <option value="">Todos...</option>
                                                                    <option value="Radicado">Radicados</option>
                                                                    <option value="Registrados">Registrados</option>
                                                                    <option value="Priorizados">Priorizados</option>
                                                                    <option value="En Ejecucion">En Ejecución</option>
                                                                    <option value="No Viabilizados">No Viabilizados</option>
                                                                    <option value="Ejecutado">Ejecutado</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3' id="DivCbEstadoCont" style="display: none;">
                                                            <div class='form-group'>
                                                                <label class='control-label'>Estado:</label>
                                                                <select class='form-control' id="CbEstadoCont"  name="options2">
                                                                    <option value="">Todos...</option>
                                                                    <option value="Ejecucion"  >Ejecución</option>
                                                                    <option value="Suspendido" >Suspendido</option>
                                                                    <option value="Terminado" >Terminado</option>
                                                                    <option value="Liquidado" >Liquidado</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="msg">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class='row' id="botones" >

                                                        <div class="form-actions right">
                                                            <button type="button" class="btn" onclick="$.Limpiar();" id="btn_Limpi"><i class="fa fa-rotate-left"></i> Limpiar</button>
                                                            <button type="button" class="btn blue" onclick="$.Consultar();" id="btn_informe"><i class="fa fa-search"></i> Consultar</button>
                                                        </div>

                                                    </div>
                                                    <div class='row' id="botonesExcel" style="display: none;" >
                                                        <div class="form-actions left">
                                                            <button type="button" class="btn green" id="btn_Excel"><i class="fa fa-file-excel-o"></i> Generar Excel Contratos</button>

                                                        </div>

                                                    </div>
                                                    <div class='row'>
                                                        <div class='col-md-12'  id="ListProy"  style="display: none;">
                                                            <table class='table table-striped table-hover table-bordered' id="tb_proyectos">
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> #
                                                                        </td>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> Código
                                                                        </td>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> Nombre
                                                                        </td>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> Tipologia
                                                                        </td>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> Secretaria
                                                                        </td>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> Estado
                                                                        </td>
                                                                        <td>
                                                                            <i class='fa fa-angle-right'></i> Acción
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody >


                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class='col-md-12' id="GeoProy" style="display: none;">
                                                            <div id="map_canvas" style="width:100%;height:400px;"></div>
                                                            <p><label> </label><input type="hidden" readonly name="lat" id="lat"/></p>
                                                            <p><label> </label> <input type="hidden" readonly name="lng" id="long"/></p>
                                                        </div>
                                                        <div class='col-md-12' id="GrafProy" style="display: none;">
                                                            <div id="chartdiv"></div>
                                                        </div>
                                                        <div class='col-md-12' id="GrafProyDeta" style="display: none;">
                                                            <div id="chartdivProy"></div>
                                                        </div>
                                                        <div class="form-actions right" style="display: none;" id="btn_volver">
                                                            <button type="button" class="btn btn-success" onclick="$.VolverList();" id="btn_informe"><i class="fa fa-reply"></i> Volver</button>
                                                        </div>
                                                        <div class="form-actions right" style="display: none;" id="btn_volver2">
                                                            <button type="button" class="btn btn-success" onclick="$.VolverGrafCont();" id="btn_informe"><i class="fa fa-reply"></i> Volver</button>
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
<!--        <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="http://www.amcharts.com/lib/3/pie.js"></script>
        <script src="../Plugins/amcharts/export.min.js" type="text/javascript"></script>
        <script src="../Plugins/amcharts/light.js" type="text/javascript"></script>-->
        <script src="../Js/amchart/core.js"></script>
        <script src="../Js/amchart/charts.js"></script>
        <script src="../Js/amchart/themes/animated.js"></script>
        <style>

            #chartdiv {
                width: 100%;
                max-height: 600px;
                height: 100vh;
            }
        </style>

        <!-- END AMCHARTS -->


    </body>
</html>
?>