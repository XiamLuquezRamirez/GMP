<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}


if ($_SESSION['GesProyVPr'] == "n") {
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
    <title>Gestión de Proyectos | GMP - Gestor Monitoreo Público</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false">
    </script>
    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../Js/Proyectos.js" type="text/javascript"></script>
    <script src="../Js/funciones_generales.js" type="text/javascript"></script>
    <script src="../Js/UbiMap.js" type="text/javascript"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


    <script src="../Js/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="../Js/ckeditor/styles.js" type="text/javascript"></script>

  




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
                                <a href="Administracion.php">Administración</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <i style="color: yellow;"  class="fa fa-star"></i>
                                <a href="Perfil/">Mi perfil </a>

                            </li>
                        </ul>
                </div>

                <h3 class="page-title"> </h3>


                <!-- Ventana Secretaria -->
                <div id="VentSecretarias" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Crear Secretarias</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>
                                <form action='#' id="formnot" class='horizontal-form'>
                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-4'>
                                                <div class='form-group' id="From_CodigoS">
                                                    <label class='control-label'>Código:</label><span class="required">* </span>

                                                    <input type='text' id='txt_CodS' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-8'>
                                                <div class='form-group' id="From_DescripcionS">
                                                    <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                    <input type='text' id='txt_DescS' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Responsable:</label>
                                                    <input type='text' id='txt_RespoS' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Correo Electronico:</label>
                                                    <input type='text' id='txt_CorreS' class='form-control' />
                                                </div>
                                            </div>

                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación:</label>
                                                    <textarea id="txt_obserS" rows="2" class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group" id="From_ArchS">
                                                    <label class="control-label">Imagen:</label>
                                                    <form enctype="multipart/form-data" class="form" id="formS">
                                                        <input type="file" id="archivosS" name="archivos" accept="application/">
                                                        Tamaño Del Archivo: <span id="fileSizeS">0</span>
                                                    </form>
                                                    <input type="hidden" id="Src_FileS" class="form-control" />
                                                    <input type="hidden" id="Name_FileS" class="form-control" placeholder="Name_File" />
                                                </div>
                                            </div>
                                            <div class="col-md-2" id="MostImgS" style="display: none;">
                                                <div class="form-group">
                                                    <button type="button" class="btn blue" id="btn_imgS"><i class="fa fa-search"></i> Ver Imagen</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="msgS">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-actions right" id="mopc">
                                            <button type="button" class="btn green" id="btn_guardarS"><i class="fa fa-save"></i> Guardar</button>
                                            <button type="button" class="btn purple" disabled id="btn_nuevoS"><i class="fa fa-file-o"></i> Nuevo</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin Ventana Secretaria  -->


                <!-- Ventana Tipologias -->
                <div id="VentTipologias" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Crear Tipologia</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>

                                <div class='form-body'>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                            <div class='form-group' id="From_CodigoT">
                                                <label class='control-label'>Código:</label><span class="required">* </span>

                                                <input type='text' id='txt_CodT' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            <div class='form-group' id="From_DescripcionT">
                                                <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                <input type='text' id='txt_DescT' class='form-control' />
                                            </div>
                                        </div>

                                        <div class='col-md-12'>
                                            <div class='form-group'>
                                                <label class='control-label'>Observación:</label>
                                                <textarea id="txt_obserT" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group" id="From_ArchT">
                                                <label class="control-label">Imagen:</label>
                                                <form enctype="multipart/form-data" class="form" id="form">
                                                    <input type="file" id="archivosT" name="archivos" accept="application/">
                                                    Tamaño Del Archivo: <span id="fileSizeT">0</span></p>
                                                </form>
                                                <input type="hidden" id="Src_FileT" class="form-control" />
                                                <input type="hidden" id="Name_FileT" class="form-control" placeholder="Name_File" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgT">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-actions right">

                                        <button type="button" class="btn green" id="btn_guardarT"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled id="btn_nuevoT"><i class="fa fa-file-o"></i> Nuevo</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin Ventana Tipologias  -->

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
                                                    <img src="" alt="Imagen" style="height: 500px; width: 100%;">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    </from>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- ventana metas -->
                <div id="ventanaMeta" class="modal fade" tabindex="-1" data-width="900">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Metas Trazadoras</h4>
                    </div>
                    <div class="modal-body">
                        <div class='row'>
                            <div class='col-md-3'>
                                <div class='form-group' id="From_Eje">
                                    <label class='control-label'>Eje:</label>
                                    <select class="form-control select2" data-placeholder="Seleccione..." onchange="$.CargEstrategia(this.value);" id="CbEjes" name="options2">

                                    </select>
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <div class='form-group' id="From_Est">
                                    <label class='control-label'>Componente:</label>
                                    <select class="form-control select2" disabled data-placeholder="Seleccione..." onchange="$.CargProgramas(this.value);" id="CbEtrategias" name="options2">

                                    </select>
                                </div>
                            </div>
                            <div class='col-md-5'>
                                <div class='form-group' id="From_Pro">
                                    <label class='control-label'>Programa:</label>
                                    <select class="form-control select2" disabled data-placeholder="Seleccione..." onchange="$.busqMetas();" id="CbProgramas" name="options2">

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class="table-scrollable">
                                    <div id="tab_Vent" style="height: 250px;overflow: scroll;">

                                    </div>
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        <label>No. de Resgistros:
                                            <select id="nregVentMet" onchange="$.combopag2VentMet(this.value)" class='form-control'>
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
                                        <div id="cobpagVentMet">
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

                        <button type="button" data-dismiss="modal" class="btn red" title="Cancelar"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
                <!-- ventana metas Producto-->
                <div id="ventanaMetaP" class="modal fade" tabindex="-1" data-width="900">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Metas de Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class='row'>
                            <div class='col-md-3'>
                                <div class='form-group' id="From_Eje">
                                    <label class='control-label'>Eje:</label>
                                    <select class="form-control select2" data-placeholder="Seleccione..." onchange="$.CargEstrategiaP(this.value);" id="CbEjesP" name="options2">

                                    </select>
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <div class='form-group' id="From_Est">
                                    <label class='control-label'>Componente:</label>
                                    <select class="form-control select2" disabled data-placeholder="Seleccione..." onchange="$.CargProgramasP(this.value);" id="CbEtrategiasP" name="options2">

                                    </select>
                                </div>
                            </div>
                            <div class='col-md-5'>
                                <div class='form-group' id="From_Pro">
                                    <label class='control-label'>Programa:</label>
                                    <select class="form-control select2" disabled data-placeholder="Seleccione..." onchange="$.busqMetasP();" id="CbProgramasP" name="options2">

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class="table-scrollable">
                                    <div id="tab_VentP" style="height: 250px;overflow: scroll;">

                                    </div>
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        <label>No. de Resgistros:
                                            <select id="nregVentMetP" onchange="$.combopag2VentMet(this.value)" class='form-control'>
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
                                        <div id="cobpagVentMetP">
                                        </div>
                                    </div>
                                    <div class='col-md-5'>
                                    </div>
                                    <div class='col-md-4'>
                                        <div id="bot_VentP" style="float:right;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn red" title="Cancelar"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>

                <!-- ventana  detalle metas -->
                <div id="ventanaDetaMeta" class="modal fade" tabindex="-1" data-width="900">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Detalles de la Meta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>
                                <div class='form-body'>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Código:</label>
                                                <p id="CodMeta" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label class="control-label">Descripción:</label>
                                                <p id="DesMeta" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Linea Base:</label>
                                                <p id="LinBase" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Proposito:</label>
                                                <p id="Prop" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="control-label">Responsable:</label>
                                                <p id="Respo" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Eje:</label>
                                                <p id="Eje" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Componente:</label>
                                                <p id="Compo" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Programa:</label>
                                                <p id="Prog" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn red" title="Cancelar"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>

                <!-- BEGIN PAGE CONTENT-->
                <ul class="nav nav-tabs">
                    <li class="active" id="tab_01_pp">
                        <a href="#tab_01" data-toggle="tab"> Listado de Proyectos</a>
                    </li>
                    <li id="tab_02_pp">
                        <a href="#tab_02" onclick="$.addProy();" data-toggle="tab" id="atitulo">Crear Proyecto</a>
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

                                                        <div class='col-md-10'>
                                                            <div class='form-group'>
                                                                <label>
                                                                    Busqueda:
                                                                    <input class="form-control input-small input-inline" onkeyup="$.busqProyect(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                </label>

                                                            </div>
                                                        </div>
                                                        <div class='col-md-2'>
                                                            <div class="btn-group dropup">
                                                                <button class="btn green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                    Generar Excel <i class="fa fa-file-excel-o"></i>
                                                                </button>
                                                                <ul class="dropdown-menu pull-right" role="menu">

                                                                    <li>
                                                                        <a onclick="$.ExcelProyectos();">
                                                                            Listado de Proyectos </a>
                                                                    </li>
                                                                    <li>
                                                                        <a onclick="$.ExcelProyMetas();">
                                                                            Listado de Proyectos por Metas </a>
                                                                    </li>
                                                                    <li>
                                                                        <a onclick="$.ExcelProyCont();">
                                                                            Listado de Proyectos por Contratos </a>
                                                                    </li>


                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class='col-md-12'>
                                                            <div class="table-scrollable">

                                                                <div id="tab_Proyect" style="height: 450px;overflow: scroll;">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class='col-md-12'>
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
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="msg2">
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
                    <div class="tab-pane fade" id="tab_02">
                        <p>
                        <div class="portlet box purple-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-angle-right"></i>Información del Proyecto
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <ul class="nav nav-tabs">
                                        <li class="active" id="tab_pp1">
                                            <a href="#tab_1" data-toggle="tab"> Inf. General </a>
                                        </li>
                                        <li id="tab_pp2">
                                            <a href="#tab_2" data-toggle="tab"> Identificación </a>
                                        </li>
                                        <li id="tab_pp3">
                                            <a href="#tab_3" data-toggle="tab"> Descripción </a>
                                        </li>
                                        <li style="display: none;" id="tab_pp4">
                                            <a href="#tab_4" data-toggle="tab"> Costos Asociados </a>
                                        </li>
                                        <li id="tab_pp5">
                                            <a href="#tab_5" data-toggle="tab"> Estudios </a>
                                        </li>
                                        <li onclick="initialize()" id="tab_pp6">
                                            <a href="#tab_6" data-toggle="tab"> Localización </a>
                                        </li>
                                        <li id="tab_pp7">
                                            <a href="#tab_7" data-toggle="tab"> Actividades </a>
                                        </li>
                                        <li id="tab_pp8">
                                            <a href="#tab_8" data-toggle="tab"> Metas </a>
                                        </li>
                                        <li id="tab_pp9">
                                            <a href="#tab_9" data-toggle="tab"> Financiación </a>
                                        </li>
                                        <li id="tab_pp10">
                                            <a href="#tab_10" data-toggle="tab"> Presupuesto </a>
                                        </li>
                                        <li id="tab_pp11">
                                            <a href="#tab_11" data-toggle="tab"> Ingresos </a>
                                        </li>

                                        <li id="tab_pp12">
                                            <a href="#tab_12" data-toggle="tab"> Anexos </a>
                                        </li>
                                        <li id="tab_pp13">
                                            <a href="#tab_13" data-toggle="tab"> Galeria </a>
                                        </li>
                                        <li id="tab_pp14">
                                            <a href="#tab_14" data-toggle="tab"> Usuarios </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!--                                            Inf. General -->
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
                                                            <div class="col-md-12">
                                                                <div id="msgCod">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <p style="font-weight: bold;" class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_CodProyecto">
                                                                    <input type="hidden" id="cons" value="" />
                                                                    <input type="hidden" id="acc" value="1" />
                                                                    <input type="hidden" id="txt_id" value="1" />
                                                                    <input type="hidden" id="perm" value="<?php echo $_SESSION['GesProyAPr']; ?>" />
                                                                    <label class='control-label'>Código:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_Cod' disabled="" onkeyup='this.value = this.value.toUpperCase()' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha Presentación:<span class="required">* </span></label>

                                                                    <input type='hidden' id='txt_fecha_def' value="<?php echo date('d-m-Y'); ?>" class='form-control' readonly />
                                                                    <input type='text' id='txt_fecha_Cre' value="<?php echo date('d-m-Y'); ?>" class='form-control' readonly />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Ultima Fecha Modificación:</label>

                                                                    <input type='text' disabled="" value="<?php echo date('d-m-Y'); ?>" id='txt_fecMod' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class='form-group' id="From_Nombre">
                                                                    <label class='control-label'>Nombre del Proyecto:<span class="required">* </span></label>
                                                                    <textarea id="txt_Nomb" rows="2" class='form-control' style="width: 100%"></textarea>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group' id="From_Tipologia">
                                                                    <label class='control-label'>Tipología del Proyecto:<span class="required">* </span></label>
                                                                    <div class="input-group ">

                                                                        <select class="form-control select2" id="CbTiplog" name="options2">

                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewTipo();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                                <i class="fa fa-plus" ></i>
                                                                            </button>
                                                                        </span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group' id="From_Secreta">
                                                                    <label class='control-label'>Secretaria:<span class="required">* </span></label>

                                                                    <div class="input-group ">
                                                                        <select class="form-control select2" data-placeholder="Seleccione..." id="CbSecre" name="options2">

                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewSecre();" title="Crear Nueva Secretaria" class="btn green-meadow">
                                                                                <i class="fa fa-plus" ></i>
                                                                            </button>
                                                                        </span>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Cronología del Proyecto:</label>
                                                                    <select class='form-control' id="CbCrono" name="options2">
                                                                        <option value=" ">Select...</option>
                                                                        <option value="Nuevo">Nuevo</option>
                                                                        <option value="Continuación">Continuación</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_Estado">
                                                                    <label class='control-label'>Estado:<span class="required">* </span></label>
                                                                    <select class='form-control' onchange="$.habilitarPresupuesto(this.value);" id="CbEstado" name="options2">
                                                                        <option value=" ">Select...</option>
                                                                        <option value="Radicado">Radicado</option>
                                                                        <option value="Registrado">Registrado</option>
                                                                        <option value="Priorizado">Priorizado</option>
                                                                        <option value="En Ejecucion">En Ejecución</option>
                                                                        <option value="No Viabilizado">No Viabilizado</option>
                                                                        <option value="Ejecutado">Ejecutado</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_FecIni">
                                                                    <label class='control-label'>F. Inicio:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_FeciniProy' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_FecFin">
                                                                    <label class='control-label'>F. Finalización:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_FecFinProy' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_Vigencia">
                                                                    <label class='control-label'>Vigencia del Proyecto:<span class="required">* </span></label>
                                                                    <input type='hidden' value="<?php echo date('Y'); ?>" id='CbVigeDef' readonly class='form-control' />
                                                                    <input type='text' value="<?php echo date('Y'); ?>" id='CbVige' readonly class='form-control' />

                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'><b>Proyecto Asociado:</b></label>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Código:</label>
                                                                    <input type='text' id='txt_CodProyAs' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-9'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Nombre:</label>
                                                                    <textarea id="txt_NombProyAs" rows="2" class='form-control' style="width: 100%"></textarea>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha de Resolución de Aprobación:</label>
                                                                    <input type='text' id='txt_FecAproProAso' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha de Inicio:</label>
                                                                    <input type='text' id='txt_Fecini' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Plazo de Ejecución:</label>
                                                                    <input type='text' id='txt_Plazo' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Vigencia del Proyecto:</label>
                                                                    <input type='text' id='txt_vigenc' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Estado del Proyecto:</label>
                                                                    <input type='text' id='txt_estaProye' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Elaboró:</label>
                                                                    <input type='text' id='txt_elabo' class='form-control' />
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--                                            Identificación     -->
                                        <div class="tab-pane fade" id="tab_2">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>2. Identificación
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>

                                                    <div class='form-body'>

                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <form id="form_identProb" method="post">

                                                                    <div class='form-group'>

                                                                        <label class='control-label'>Identificación del Problema:</label>
                                                                        <textarea id="txt_IdProblema" name="txt_IdProblema"></textarea>
                                                                    </div>


                                                                </form>

                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="control-label">Causas: </label>
                                                                <div class="input-group">
                                                                    <input type="hidden" id="contCausas" value="0" />
                                                                    <input type="text" id="txt_Caus" class="form-control">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn blue" onclick="$.AddCaus()" type="button"> <i class="fa fa-plus-circle" /></i> Agregar</button>
                                                                    </span>
                                                                </div>
                                                                <!-- /input-group -->
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Causas">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Descripción
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>


                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="control-label">Efectos: </label>
                                                                <div class="input-group">
                                                                    <input type="hidden" id="contEfect" value="0" />
                                                                    <input type="text" id="txt_Efect" class="form-control">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn blue" onclick="$.AddEfect()" type="button"><i class="fa fa-plus-circle" /></i> Agregar</button>
                                                                    </span>
                                                                </div>

                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Efect">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Descripción
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--                                            Descripción     -->
                                        <div class="tab-pane fade" id="tab_3">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>3. Descripción General
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
                                                                    <label class='control-label'>Objetivo General:</label>
                                                                    <textarea id="txt_ObjGenr" rows="4" class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="control-label">Objetivos Específicos: </label>
                                                                <div class="input-group">
                                                                    <input type="hidden" id="contObjet" value="0" />
                                                                    <input type="text" id="txt_Obj" class="form-control">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn blue" onclick="$.AddObjEspec()" type="button"><i class="fa fa-plus-circle" /></i> Agregar</button>
                                                                    </span>
                                                                </div>
                                                                <!-- /input-group -->
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Objet">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Descripción
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>


                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="control-label">Descripción del Proyecto:</label>
                                                                <textarea id="txt_DesProy" name="txt_DesProyx" rows="4" class='form-control' style="width: 100%"></textarea>
                                                            </div>
                                                            <br>
                                                            <div class="col-md-12" style="padding-top: 10px;">
                                                                <div class='portlet box blue'>
                                                                    <div class='portlet-title'>
                                                                        <div class='caption'>
                                                                            <i class='fa fa-angle-right'></i>Productos
                                                                        </div>
                                                                        <div class='tools'>
                                                                            <a href='javascript:;' class='collapse'></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class='portlet-body form'>
                                                                        <input type="hidden" id="contProd" value="0" />
                                                                        <div class='form-body'>
                                                                            <div class='row'>
                                                                                <div class='col-md-6'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Producto:</label>
                                                                                        <input type='text' id='txt_Productos' value="" class='form-control' />
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-6'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Indicadores:</label>
                                                                                        <input type='text' id='txt_Indicadores' value="" class='form-control' />
                                                                                    </div>
                                                                                </div>

                                                                                <div class='col-md-4'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Meta:</label>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn">
                                                                                                <select class='form-control' id="CbMetProd" name="options2">
                                                                                                    <option value=" ">Select...</option>
                                                                                                    <option value="2015">Año 2015</option>
                                                                                                    <option value="2016">Año 2016</option>
                                                                                                    <option value="2017">Año 2017</option>
                                                                                                    <option value="2018">Año 2018</option>
                                                                                                    <option value="2019">Año 2019</option>
                                                                                                    <option value="2020">Año 2020</option>
                                                                                                    <option value="2021">Año 2021</option>
                                                                                                    <option value="2022">Año 2022</option>
                                                                                                    <option value="2023">Año 2023</option>
                                                                                                    <option value="2024">Año 2024</option>
                                                                                                    <option value="2025">Año 2025</option>
                                                                                                </select>
                                                                                            </span>
                                                                                            <input type="text" id="txt_MetAnio" class="form-control">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-8' style="text-align: right">
                                                                                    <div class='form-group'>
                                                                                        <a onclick="$.AddProd()" class="btn green-meadow">
                                                                                            <i class="fa fa-plus-circle"></i> Agregar
                                                                                        </a>
                                                                                    </div>
                                                                                </div>


                                                                                <div class='col-md-12'>
                                                                                    <div class='form-group'>
                                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Product">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Producto
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Indicador
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Año
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Meta
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Acción
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>


                                                                                            </tbody>
                                                                                        </table>


                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="col-md-12" style="padding-top: 10px;">
                                                                <div class='portlet box blue'>
                                                                    <div class='portlet-title'>
                                                                        <div class='caption'>
                                                                            <i class='fa fa-angle-right'></i>Población Objetivo:
                                                                        </div>
                                                                        <div class='tools'>
                                                                            <a href='javascript:;' class='collapse'></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class='portlet-body form'>
                                                                        <input type="hidden" id="contPobla" value="0" />
                                                                        <div class='form-body'>
                                                                            <div class='row'>
                                                                                <div class='col-md-2'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'># Personas:</label>
                                                                                        <input type='text' id='txt_Person' value="" class='form-control' />

                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-2'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Genero:</label>
                                                                                        <select class='form-control' id="CbGenero" name="options2">
                                                                                            <option value=" ">Select...</option>
                                                                                            <option value="Masculino">Masculino</option>
                                                                                            <option value="Femenino">Femenino</option>
                                                                                            <option value="LGTBI">LGTBI</option>
                                                                                            <option value="Todos">Todos</option>

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-2'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Edad:</label>
                                                                                        <select class='form-control' id="CbEdad" name="options2">
                                                                                            <option value=" ">Select...</option>
                                                                                            <option value="0 - 5">0 - 5 Años Primera Infancia</option>
                                                                                            <option value="6 - 11">6 - 11 Años Infancia</option>
                                                                                            <option value="12 - 17">12 - 18 Años Adolescencia</option>
                                                                                            <option value="18 - 26">18 - 26 Años Juventud</option>
                                                                                            <option value="27 - 59">27 - 59 Años Adultez</option>
                                                                                            <option value="> 60 ">> 60 Año Vejez</option>
                                                                                            <option value="Todos"> Todos </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-6'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Grupo Etnico:</label>
                                                                                        <select class='form-control' id="CbGrupEtn" name="options2">
                                                                                            <option value=" ">Select...</option>
                                                                                            <option value="Indigena">Indigena</option>
                                                                                            <option value="ROM">ROM</option>
                                                                                            <option value="Raizal">Raizal</option>
                                                                                            <option value="Palenquero de San Bacilio">Palenquero de San Bacilio</option>
                                                                                            <option value="Negro, Mulato, Afrocolombiano O Afrodescendiente">Negro, Mulato, Afrocolombiano O Afrodescendiente</option>
                                                                                            <option value="Otros">Otros</option>
                                                                                            <option value="Ninguno">Ninguno</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'>Fase del Proyecto:</label>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn">
                                                                                                <input type='text' value="<?php echo date('Y'); ?>" id='CbFase' readonly class='form-control' />
                                                                                            </span>


                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-12' style="text-align: right">
                                                                                    <div class='form-group'>
                                                                                        <a onclick="$.AddPobla()" class="btn green-meadow">
                                                                                            <i class="fa fa-plus-circle"></i> Agregar
                                                                                        </a>
                                                                                    </div>
                                                                                </div>


                                                                                <div class='col-md-12'>
                                                                                    <div class='form-group'>
                                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Pobla">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> # Personas
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Genero
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Edad
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Grupo Etnico
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Fase del Proyecto
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <i class='fa fa-angle-right'></i> Acción
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>


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
                                                </div>
                                            </div>

                                        </div>

                                        <!--                                          Costos Asociados Al Proyecto      -->
                                        <div class="tab-pane fade" id="tab_4">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>4. Costos Asociados Al Proyecto
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contCostosAsoc" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Identificación:</label>
                                                                    <input type='text' id='txt_identCost' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Nombre:</label>
                                                                    <input type='text' id='txt_nomb_Cost' value="" class='form-control' />

                                                                </div>
                                                            </div>

                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Cargo:</label>
                                                                    <input type='text' id='Cbx_cargoCost' value="" class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Horas Semanales dedicadas al Proyecto:</label>
                                                                    <input type='text' id='txt_Hr_Proy' value="" class='form-control' />

                                                                </div>
                                                            </div>

                                                            <div class='col-md-9' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddCostAsoc()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_CostosAsoc">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Identificación
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Nombre
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Cargo
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Horas Semanales
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!--                                          Estudios Que Respaldan El Proyecto      -->
                                        <div class="tab-pane fade" id="tab_5">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>5. Estudios Que Respaldan El Proyecto
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contEstudios" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Titulo:</label>
                                                                    <input type='text' id='txt_TitEst' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Autor:</label>
                                                                    <input type='text' id='txt_AutEst' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Entidad:</label>
                                                                    <input type='text' id='txt_EntEst' value="" class='form-control' />

                                                                </div>
                                                            </div>

                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha:</label>
                                                                    <input type='text' id='txt_FecEst' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Observaciones:</label>
                                                                    <textarea id="txt_ObsEst" rows="2" class='form-control' style="width: 100%"></textarea>

                                                                </div>
                                                            </div>

                                                            <div class='col-md-12' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddEstudios()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Estudios">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Titulo
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Autor
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Entidad
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Fecha
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Observaciones
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--                                         Localización      -->
                                        <div class="tab-pane fade" id="tab_6">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>6. Localización
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>

                                                    <div class='form-body'>
                                                        <div class='row'>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Departamento de Ejecución:</label>
                                                                    <select class="form-control select2" id="CbDepa" onchange="$.BusMun(this.value)" name="options2">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Municipio de Ejecución:</label>
                                                                    <select class="form-control select2" id="CbMun" disabled onchange="$.BusCorr(this.value)" name="options2">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Corregimiento de Ejecución:</label>
                                                                    <select class="form-control select2" onchange="$.BusUbiCor()" disabled id="CbCorre" name="options2">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Otra Ubicación:</label>
                                                                    <input type='text' id='txt_OtraUbi' onkeypress="$.BusUbiBar(this.value)" value="" class='form-control' />


                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <p><label>Localización geográfica: </label>
                                                                        <input style="width:400px;display: none;" type="text" id="direccion" name="direccion" value="" />
                                                                        <button style="display: none;" id="pasar">Obtener coordenadas</button>
                                                                    <div id="map_canvas" style="width:100%;height:400px;"></div>

                                                                    <input type="hidden" readonly name="lat" id="lat" />
                                                                    <input type="hidden" readonly name="lng" id="long" />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddLocalizacion()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <input type="hidden" id="contLocalizacion" value="0" />
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Localiza">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Departamanto
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Municipio
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Corregimiento
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Otra Ubicación
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--                                         Actividades      -->
                                        <div class="tab-pane fade" id="tab_7">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>7. Actividades
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contActivi" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Metas:</label>
                                                                    <textarea id="txt_Metas" rows="2" class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Actividades:</label>
                                                                    <textarea id="txt_Actividad" rows="2" class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-7'>

                                                                <label class='control-label'>Responsable:</label>

                                                                <div class="input-group ">
                                                                    <select class="form-control select2" data-placeholder="Seleccione..." onchange="$.cargDatResp(this.value);" id="CbRespoAct" name="options2">

                                                                    </select>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" id="btn_new_resp" onclick="$.UpdateRespon('2');" title="Crear Nuevo Responsable" class="btn blue-soft">
                                                                            <i class="fa fa-refresh" /></i>
                                                                        </button>
                                                                    </span>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" id="btn_new_resp" onclick="$.NewRespon();" title="Crear Nuevo Responsable" class="btn green-meadow">
                                                                            <i class="fa fa-plus" /></i>
                                                                        </button>
                                                                    </span>

                                                                </div>

                                                            </div>
                                                            <div class='col-md-5'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Estado:</label>
                                                                    <select class='form-control' id="CbEstadoAct" name="options2">
                                                                        <option value=" ">Select...</option>
                                                                        <option value="Pendiente">Pendiente</option>
                                                                        <option value="Aprobada">Aprobada</option>
                                                                        <option value="Rechazada">Rechazada</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Costos:</label>

                                                                    <input type='hidden' id='txt_costActTotal' value="0,00" class='form-control' />
                                                                    <input type='text' id='txt_costAct' value="$ 0,00" class='form-control' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha y Hora de Inicio:</label>

                                                                    <input type='text' id='txt_fecha_Ini' value="" class='form-control' readonly />
                                                                </div>
                                                            </div>


                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha y Hora Final</label>

                                                                    <input type='text' id='txt_fecha_Fin' value="" class='form-control' readonly />
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddAct()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Activ">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Meta
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Actividad
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Responsable
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Costo
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Estado
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Fec. Inicio
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> H. Inicio
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Fec. Final
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> H. Final
                                                                                </td>
                                                                                <td>
                                                                                    <i></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan='4' style='text-align: right;'>Total Costos:</th>
                                                                                <th colspan='1'><label id='gtotalCostosAct' style='font-weight: bold;'>0,00</label></th>
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

                                        <!--                                       Indicadores      -->
                                        <div class="tab-pane fade" id="tab_8">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>8.1. Metas Trazadoras
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contMetas" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Código:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_paraMet" title="Busqueda del Indicador" class="btn green-meadow">
                                                                                <i class="fa fa-search fa-fw" /></i>
                                                                            </button>
                                                                        </span>
                                                                        <input type='text' id='txt_CodMeta' disabled="" value="" class='form-control' />
                                                                        <input type='hidden' id='txt_IdMeta' disabled="" value="" class='form-control' />

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-10'>
                                                                <div class='form-group' id="From_Act">
                                                                    <label class='control-label'>Descripción:</label>
                                                                    <textarea id="txt_DesMeta" rows="4" class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Meta:</label>
                                                                    <input type='text' id='txt_MetaT' disabled="" value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Meta Generada:</label>
                                                                    <input type='text' id='txt_MetGen' onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" value="" class='form-control' />

                                                                </div>
                                                            </div>

                                                            <div class='col-md-8' style="text-align: right; vertical-align: middle;">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddMetas()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Metas">
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
                                                                                    <i class='fa fa-angle-right'></i> Meta Generada
                                                                                </th>
                                                                                <th>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id='tb_Body_Meta'>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>8.2. Metas de Productos
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contMetasP" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Código:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_paraMetP" title="Busqueda del Indicador" class="btn green-meadow">
                                                                                <i class="fa fa-search fa-fw" /></i>
                                                                            </button>
                                                                        </span>
                                                                        <input type='text' id='txt_CodMetaP' disabled="" value="" class='form-control' />
                                                                        <input type='hidden' id='txt_IdMetaP' disabled="" value="" class='form-control' />

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-10'>
                                                                <div class='form-group' id="From_Act">
                                                                    <label class='control-label'>Descripción:</label>
                                                                    <textarea id="txt_DesMetaP" rows="3" class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Objetivo Meta:</label>
                                                                    <input type='text' id='txt_MetaP' disabled="" value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Meta Generada:</label>
                                                                    <input type='text' id='txt_MetEstab' onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" value="" class='form-control' />

                                                                </div>
                                                            </div>


                                                            <div class='col-md-8' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddMetasP()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>

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
                                                                                    <i class='fa fa-angle-right'></i> Objetivo de la Meta
                                                                                </th>
                                                                                <th>
                                                                                    <i class='fa fa-angle-right'></i> Meta Generada
                                                                                </th>
                                                                                <th>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id='tb_Body_MetaP'>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--                                       Financiación      -->
                                        <div class="tab-pane fade" id="tab_9">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>9. Fuentes De Financiación:
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contFinancia" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-9'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Origen de la Financiación:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <select class="form-control select2" data-placeholder="Seleccione..." id="CbOriFinancia" name="options2">
                                                                             
                                                                            </select>
                                                                        </span>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Valor:</label>
                                                                    <input type='hidden' id='txt_FinanciaTotal' value="0" class='form-control' />
                                                                    <input type='text' id='txt_cosFinVi' value="$ 0,00" class='form-control' onclick="this.select();" value="$ 0,00"  onkeyup="restrictInput(event);"  onchange="$.cambioFormato(this.id,'txt_cosFin');" />
                                                                    <input type='hidden' id='txt_cosFin' value="" class='form-control' />

                                                                </div>
                                                            </div>


                                                            <div class='col-md-12' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <label class='control-label'>&nbsp;</label>
                                                                    <a onclick="$.AddFinancia()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Financia">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Origen de la Financiación
                                                                                </td>                                                                              
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Valor
                                                                                </td>

                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan='2' style='text-align: right;'>Total Financiación:</th>
                                                                                <th colspan='1'><label id='gtotalFinanc' style='font-weight: bold;'>0,00</label></th>
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

                                        <!--                                      Presupuesto      -->
                                        <div class="tab-pane fade" id="tab_10">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>10. Presupuesto
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contPresup" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-7'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Descripción:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <select class="form-control" data-placeholder="Seleccione..." id="CbOriPres" name="options2">
                                                                                <option value="GASTOS INDIRECTOS">GASTOS INDIRECTOS</option>
                                                                                <option value="GASTOS DIRECTOS">GASTOS DIRECTOS</option>
                                                                            </select>
                                                                        </span>
                                                                        <input type='text' id='txt_DesPres' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Total:</label>
                                                                    <input type='text' id='txt_valPreTotVis' value="$ 0,00" class='form-control' onchange="$.cambioFormato(this.id,'txt_valPreTot');" onclick="this.select()" />
                                                                    <input type='hidden' id='txt_valPreTot' value="" class='form-control' />

                                                                </div>
                                                            </div>

                                                            <div class='col-md-2' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddPresupuesto()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Presup">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style='vertical-align: middle; text-align:center;'>#</th>
                                                                                <th style='vertical-align: middle; text-align:left;'>Descripción</th>
                                                                                <th style='vertical-align: middle; text-align:left;'>Valor</th>
                                                                                <th style='vertical-align: middle; text-align:left;'>Accion</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan='2' style='text-align: right;'>Total Proyecto:</th>
                                                                                <th colspan='1'><label id='gtotalPresTota' style='font-weight: bold;'>$ 0,00</label></th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class='portlet box blue' id="div-presupuesto" style="display: none;">
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Comprometer Presupuesto
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <input type="hidden" id="contPresup" value="0" />
                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'> <input type="checkbox" id="sel1ComPre" class="form-control" name="sel" value="">Comprometer Presupuesto</label>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Aprobación:</label>
                                                                        <input type='text' id='txt_fecha_ComPre' value="<?php echo date('Y-m-d'); ?>" readonly="" class='form-control' />

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group" id="From_ArchS">
                                                                        <label class="control-label">Adjuntar Documento:</label>
                                                                        <form enctype="multipart/form-data" class="form" id="formComp">
                                                                            <input type="file" id="archivosComp" name="archivos" accept="application/">
                                                                        </form>
                                                                        <input type="hidden" id="Src_FileComp" class="form-control" />
                                                                        <input type="hidden" id="Name_FileComp" class="form-control" placeholder="Name_File" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2" id="MostDocComp" style="display: none;">
                                                                    <div class="form-group" style="text-align: center;">
                                                                        <button type="button" class="btn blue" id="btn_imgComp"><i class="fa fa-search"></i> Ver Doc.</button>
                                                                        <button type="button" class="btn red mt-1" onclick="$.quitarDoc();" id="btn_delComp"><i class="fa fa-trash-o"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="msgComp">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </p>

                                        <!--                                      Ingresos Proyectados      -->
                                        <div class="tab-pane fade" id="tab_11">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>11. Ingresos Proyectados
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contIngPres" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Descripción:</label>
                                                                    <input type='text' id='txt_DesIngre' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Cantidad:</label>
                                                                    <input type='text' id='txt_CantIngre' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Valor Unidad:</label>
                                                                    <input type='text' id='txt_UnMedIgre' onblur="textm(this.value, this.id)" onclick="this.select();" value="$ 0,00" value="" class='form-control' />
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12' style="text-align: right">
                                                                <div class='form-group'>
                                                                    <a onclick="$.AddIngresos()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Ingresos">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Descripción
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Cantidad
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Valor unidad
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Total
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--Ingresos Anexos      -->
                                        <div class="tab-pane fade" id="tab_12">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>12. Registro de Anexos
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>

                                                    <div class='form-body'>

                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <div class='form-group' id="From_DescriDocu">
                                                                    <label class='control-label'>Descripción:</label>
                                                                    <input type='text' id='txt_DesAnex' value="" class='form-control' />

                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="panel panel-default">

                                                                    <div class="panel-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group" id="From_Arch">
                                                                                    <label class="control-label">Adjuntar Documento <span class="required">* </span></label>
                                                                                    <form enctype="multipart/form-data" class="form" id="form">
                                                                                        <input type="file" id="archivos" name="archivos" accept="application/">
                                                                                        Tamaño Del Archivo: <span id="fileSize">0</span></p>

                                                                                        <p class="help-block">
                                                                                            <span class="label label-danger">
                                                                                                NOTA: </span>
                                                                                            &nbsp; El Tamaño Del Documento No Puede Ser Mayor De 20MB, Y Solo Extensiones .pdf
                                                                                        </p>
                                                                                        <input type="hidden" id="Src_File" class="form-control" />
                                                                                        <input type="hidden" id="Name_File" class="form-control" placeholder="Name_File" />

                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div id="msgArch">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group" style="float: right">
                                                                                    <button type="button" id="Anx_Doc" class="btn green-meadow" title="Anexar Documento">
                                                                                        <i class="fa fa-plus-circle" ></i> Anexar Documento
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class='col-md-12'>
                                                                                <div class='form-group'>
                                                                                    <input type="hidden" id="contAnexo" value="0" />
                                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Anexo">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                                </td>
                                                                                                <td>
                                                                                                    <i class='fa fa-angle-right'></i> Descripcion
                                                                                                </td>
                                                                                                <td>
                                                                                                    <i class='fa fa-angle-right'></i> Nombre Del Archivo
                                                                                                </td>

                                                                                                <td>
                                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                                </td>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>


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
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="tab_13">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i> 13. Galeria
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contImg" value="0" />
                                                    <input type="hidden" id="typearch" value="" />
                                                    <div class='form-body'>
                                                        <div class='row'>
                                                            <div class='col-md-4'>
                                                                <div class='form-group' id="From_Act">
                                                                    <label class='control-label'>Imagenes de:</label>
                                                                    <select class='form-control' id="CbEstImg" name="options2">
                                                                        <option value=" ">Select...</option>
                                                                        <option value="Estado Inicial">Estado Inicial</option>
                                                                        <option value="Avances">Avances</option>
                                                                        <option value="Estado Final">Estado Final</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_Fech">
                                                                    <label class='control-label'>Fecha:</label>
                                                                    <input type='text' id='txt_fecha' value="" class='form-control' readonly />
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Adjuntar Imagenes<span class='required'>* </span></label>
                                                                    <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                                        <input type="file" id="archivosGale" multiple>

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
                                                                                    <i class='fa fa-angle-right'></i> Fecha
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

                                        <!--                                      Usuarios Asignados      -->
                                        <div class="tab-pane fade" id="tab_14">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>14. Usuarios Asignados
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>
                                                    <input type="hidden" id="contUsua" value="0" />
                                                    <div class='form-body'>
                                                        <div class='row'>

                                                            <div class='col-md-10'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Usuario:</label>
                                                                    <select class="form-control select2" data-placeholder="Seleccione..." id="CbUsuarios" name="options2">

                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>&nbsp;</label><br>
                                                                    <a onclick="$.AddUsuarios()" class="btn green-meadow">
                                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <table class='table table-striped table-hover table-bordered' id="tb_Usuarios">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> #
                                                                                </td>
                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Nombre de Usuario
                                                                                </td>

                                                                                <td>
                                                                                    <i class='fa fa-angle-right'></i> Acción
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tb_Body_Usuarios">


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--                                      Ingresos Anexos      -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="msg">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions right" id="botones">
                                    <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-check"></i> Guardar</button>
                                    <button type="button" class="btn purple" disabled="" id="btn_nuevo"><i class="fa fa-file-o"></i> Nuevo</button>
                                    <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
                                    <button type="button" class="btn blue" id="btn_volver"><i class="fa fa-mail-reply"></i> Volver</button>
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
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../Css/Layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
>