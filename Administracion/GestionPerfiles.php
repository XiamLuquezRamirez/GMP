<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['GesUsuVPe'] == "n") {
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
        <title>Gestión de Perfiles | SGP Gestor Publico de Gobierno</title>
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
        <script src="../Js/GestionPerfiles.js" type="text/javascript"></script>
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
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <a href="GestionPerfiles.php">Gestión de Perfiles </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->




                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Perfiles</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" data-toggle="tab"  onclick="$.addPerf();" id="atitulo">Crear Perfil</a>
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

                                                        <div class='row' id="cont_princip">

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control input-small input-inline" onkeyup="$.busqProyect(this.value);"  id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">

                                                                    <div id="tab_Perfil" style="height: 350px;overflow: scroll;">

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
                                                                        <div id="bot_Perfil" style="float:right;">
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="msg2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='row' id="cont_histo" style="display: none;">
                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">
                                                                    <div id="tab_HistoCont" style="height: 350px;overflow: scroll;">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-actions right">
                                                                <button type="button" class="btn blue" id="btn_volverContr"><i class="fa fa-mail-reply"></i> Volver</button>
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
                                        <i class="fa fa-angle-right"></i>Permisos Perfil
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab"> Inf. General </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!--                                Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>1. Información General
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <p style="font-weight: bold;" class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class='form-group' id="From_Nombre"><input type="hidden" id="idperfil" value="" /><input type="hidden" id="acc" value="1" />
                                                                        <label class='control-label'>Nombre del Perfil:<span class="required">* </span></label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_Nomb' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="msg2">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="clearfix">
                                                                        <h4 class="block">Asignar Permisos</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6" id='cbx_1'>
                                                                    <div class="clearfix">
                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Plan de Desarrollo</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>

                                                                            <!--                                                                            <div class="panel-body">
                                                                                                                                                            <p>
                                                                                                                                                                Some default panel content here. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                                                                                                                                            </p>
                                                                                                                                                        </div>-->
                                                                            <!-- Table -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Ejes
                                                                                            <input type='hidden'   id='GesPlaT1' value="Ejes"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Componentes
                                                                                            <input type='hidden'   id='GesPlaT2' value="Componentes"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaV2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaA2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaM2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaE2" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Programas
                                                                                            <input type='hidden'   id='GesPlaT3' value="Programas"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaV3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaA3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaM3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaE3" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Metas
                                                                                            <input type='hidden'   id='GesPlaT4' value="Metas"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaV4" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaA4" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaM4" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesPlaE4" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" id='cbx_2'>
                                                                    <div class="clearfix">

                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Gestion de Proyectos</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>


                                                                            <!-- Table -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Proyectos
                                                                                            <input type='hidden'   id='GesProyT1' value="Proyectos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Contratos
                                                                                            <input type='hidden'   id='GesProyT2' value="Contratos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyV2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyA2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyM2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyE2" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Medir Indicador
                                                                                            <input type='hidden'   id='GesProyT3' value="Medir Indicador"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyV3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyA3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyM3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesProyE3" class='icheck'>
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6" id="cbx_3">
                                                                    <div class="clearfix">
                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Evaluación Contratos</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>


                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Evaluación
                                                                                            <input type='hidden'   id='GesEvaT1' value="Evaluacion"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesEvaV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesEvaA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesEvaM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesEvaE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" id="cbx_4">
                                                                    <div class="clearfix">

                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Informes</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>


                                                                            <!-- Table -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Informes
                                                                                            <input type='hidden'   id='GesInfT1' value="Informes"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesInfV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesInfA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesInfM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesInfE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6" id="cbx_5">
                                                                    <div class="clearfix">
                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Parametros Generales</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>

                                                                            <!--                                                                            <div class="panel-body">
                                                                                                                                                            <p>
                                                                                                                                                                Some default panel content here. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                                                                                                                                            </p>
                                                                                                                                                        </div>-->
                                                                            <!-- Table -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Compañia
                                                                                            <input type='hidden'   id='GesParT1' value="Compania"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Dependencias
                                                                                            <input type='hidden'   id='GesParT2' value="Dependencias"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE2" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Responsables
                                                                                            <input type='hidden'   id='GesParT3' value="Responsables"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM3" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE3" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Supervisores
                                                                                            <input type='hidden'   id='GesParT4' value="Supervisores"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV4" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA4" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM4" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE4" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Interventores
                                                                                            <input type='hidden'   id='GesParT5' value="Interventores"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV5" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA5" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM5" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE5" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Contratistas
                                                                                            <input type='hidden'   id='GesParT6' value="Contratistas"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV6" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA6" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM6" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE6" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Secretarias
                                                                                            <input type='hidden'   id='GesParT7' value="Secretarias"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV7" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA7" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM7" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE7" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Tipologia Proyectos
                                                                                            <input type='hidden'   id='GesParT8' value="Tipologia Proyectos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV8" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA8" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM8" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE8" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Tipologia Contratos
                                                                                            <input type='hidden'   id='GesParT9' value="Tipologia Contratos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV9" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA9" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM9" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE9" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Consecutivos
                                                                                            <input type='hidden'   id='GesParT10' value="Consecutivos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParV10" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParA10" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParM10" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesParE10" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" id="cbx_6">
                                                                    <div class="clearfix">

                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Gestion de Usuarios</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>


                                                                            <!-- Table -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Usuarios
                                                                                            <input type='hidden'   id='GesUsuT1' value="Usuarios"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Perfiles
                                                                                            <input type='hidden'   id='GesUsuT2' value="Perfiles"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuV2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuA2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuM2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="GesUsuE2" class='icheck'>
                                                                                        </td>
                                                                                    </tr>


                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" id="cbx_6">
                                                                    <div class="clearfix">

                                                                        <div class="panel panel-primary">
                                                                            <!-- Default panel contents -->
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title">Gestión de Avances</h3>
                                                                                <div class='tools'>
                                                                                    <a href='javascript:;' class='collapse'></a>
                                                                                </div>
                                                                            </div>


                                                                            <!-- Table -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Descripción
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Visible
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Añadir
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Modificar
                                                                                        </th>
                                                                                        <th style="text-align: center;">
                                                                                            Eliminar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Avances de Proyectos
                                                                                            <input type='hidden'   id='AvaProT1' value="Avances Proyectos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProV1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProA1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProM1" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProE1" class='icheck'>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Avances de Contratos
                                                                                            <input type='hidden'   id='AvaProT2' value="Avances de Contratos"/>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProV2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProA2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProM2" class='icheck'>
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            <input type='checkbox' id="AvaProE2" class='icheck'>
                                                                                        </td>
                                                                                    </tr>


                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
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

                                    <div class="form-actions right" id="botones">
                                        <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled=""  id="btn_nuevo"><i class="fa fa-file-o"></i> Nuevo</button>
                                        <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>                                        
                                    </div>
                                    <!-- END FORM-->
                                </div>
                            </div>




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
