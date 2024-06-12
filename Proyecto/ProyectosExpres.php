<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}
if ($_SESSION['GesProyVCo'] == "n") {
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
        <title>Gestión Proyectos y Contratos | GMP - Gestor Monitoreo Público</title>
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
        <script src="../Js/PoyectosContratos.js" type="text/javascript"></script>
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
                                <i  style="color: yellow;"  class="fa fa-star"></i>
                                <a href="../Proyecto/ProyectosExpres.php">Proyectos y Contratos</a>

                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                             <!-- Ventana contratista -->
                    <div id="VentContratista" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Crear Contratistas</h4>
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
                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Persona:</label>
                                                    <select class="form-control" id="CbPersonaC" >
                                                        <option value=" ">Select...</option>
                                                        <option value="NATURAL">NATURAL</option>
                                                        <option value="JURIDICA">JURIDICA</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <label class="control-label">Documento de Identificación: <span class="required">* </span></label>
                                                <div class="form-inline">
                                                    <div class="form-group" id="From_ide">
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <select id="cbx_tipo_identC" class="bs-select form-control">
                                                                    <option value="CC">CC</option>
                                                                    <option value="PAS">PAS</option>
                                                                    <option value="CE">CE</option>
                                                                    <option value="NIT">NIT</option>
                                                                    <option value="OT">OT</option>
                                                                </select>
                                                            </span>
                                                            <input type="text" id="txt_identC" onchange="$.calculaDigitoVerificador(this.value);" class="form-control txt" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">DV -</label>
                                                        <input type="text" id="txt_dvC" disabled class="form-control txt" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group' id="From_nomC">
                                                    <label class='control-label'>Nombre:<span class="required">* </span></label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_NombC' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Telefono:</label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onkeypress='return validartxtnum(event)' id='txt_TelC' class='form-control'/>

                                                </div>
                                            </div>

                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Dirección:</label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_DirecC' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Correo:</label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_CorreoC' class='form-control'/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row' id="datReprC" style="display: none;">
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label' style="color: #F3565D;">Datos Respresentate Legal </label>

                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Identificacion:</label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_IdReprC' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Nombre:</label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_NomReprC' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Teléfono:</label>
                                                    <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_TelReprC' class='form-control'/>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class='col-md-4'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Departamento:</label>
                                                    <select class="form-control select2" id="CbDepaC" onchange="$.BusMun(this.value)" name="options2">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Municipio:</label>
                                                    <select class="form-control select2" id="CbMunC" data-placeholder="Seleccione..." disabled name="options2">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación</label>
                                                    <textarea id="txt_obserC" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="msgC">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-actions right" id="mopc" >
                                            <button type="button" class="btn green" id="btn_guardarC"><i class="fa fa-save"></i> Guardar</button>
                                            <button type="button" class="btn purple" disabled id="btn_nuevoC"><i class="fa fa-file-o"></i> Nuevo</button>


                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Fin Ventana contratista -->
                    <!-- Ventana Tipologia -->
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

                                                    <input type='text'  id='txt_CodT' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-8'>
                                                <div class='form-group' id="From_DescripcionT">
                                                    <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                    <input type='text'   id='txt_DescT' class='form-control'/>
                                                </div>
                                            </div>

                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación:</label>
                                                    <textarea id="txt_obserT" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
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
                    <!-- Fin Ventana Tipologia -->
                    <!-- Ventana Supervisor -->
                    <div id="VentSupervisor" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Crear Supervisor</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-4'>
                                                <div class='form-group' id="From_CodigoS">
                                                    <label class='control-label'>Identificación:</label><span class="required">* </span>

                                                    <input type='text'  id='txt_CodS' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-8'>
                                                <div class='form-group' id="From_DescripcionS">
                                                    <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                    <input type='text'   id='txt_DescS' class='form-control'/>
                                                </div>
                                            </div>

                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Correo Electronico:</label>
                                                    <input type='text'   id='txt_Corre' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Teléfonos:</label>
                                                    <input type='text'   id='txt_TelfS' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación:</label>
                                                    <textarea id="txt_obserS" rows="2"  class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="msgS">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <button type="button" class="btn green" id="btn_guardarS"><i class="fa fa-save"></i> Guardar</button>
                                            <button type="button" class="btn purple" disabled id="btn_nuevoS"><i class="fa fa-file-o"></i> Nuevo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Fin Ventana Supervisor -->
                    <!-- Ventana Interventor -->
                    <div id="VentInterventor" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Crear Interventor</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-4'>
                                                <div class='form-group' id="From_CodigoI">
                                                    <label class='control-label'>Identificación:</label><span class="required">* </span>

                                                    <input type='text'  id='txt_CodI' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-8'>
                                                <div class='form-group' id="From_DescripcionI">
                                                    <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                    <input type='text'   id='txt_DescI' class='form-control'/>
                                                </div>
                                            </div>

                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Correo Electronico:</label>
                                                    <input type='text'   id='txt_CorreI' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Teléfonos:</label>
                                                    <input type='text'   id='txt_TelfI' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación:</label>
                                                    <textarea id="txt_obserI" rows="2"  class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="msgI">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right" id="mopc" >
                                            <button type="button" class="btn green" id="btn_guardarI"><i class="fa fa-save"></i> Guardar</button>
                                            <button type="button" class="btn purple" disabled id="btn_nuevoI"><i class="fa fa-file-o"></i> Nuevo</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Fin Ventana Supervisor -->

                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" id="listado" data-toggle="tab"> Listado de Proyectos</a>
                        </li>
                        <li id="tab_02_pp" style="display: none;">
                            <a href="#tab_02"  data-toggle="tab" id="iform">Crear Poryecto</a>
                        </li>
                        <li id="tab_03_pp" style="display: none;">
                            <a href="#tab_3"  data-toggle="tab" id="iformCont">Crear Contrato</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_01">
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_011">

                                            <div class='portlet box blue' id="List_Proyectos">
                                                <div class='portlet-body form'>
                                                    <div class='form-body'>
                                                        <div class='row' id="cont_princip">
                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control" onkeyup="$.busqProyectos(this.value);"  id="busq_Proyectos" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class="btn-group dropup">
                                                                    <button class="btn green dropdown-toggle" onclick="$.NewProyect();" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        Ingresar Proyecto <i class="fa fa-newspaper-o"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class="btn-group dropup">
                                                                    <button class="btn green dropdown-toggle" onclick="$.GesContratos();" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        Gestión Contratos <i class="fa fa-newspaper-o"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class="btn-group dropup">
                                                                    <button class="btn purple dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        Generar Excel <i class="fa fa-file-excel-o"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                        <li>
                                                                            <a onclick="$.ExcelProyectos();">
                                                                                Listado de Poryectos </a>
                                                                        </li>
                                                                        <li>
                                                                            <a onclick="$.ExcelProyContExp();">
                                                                                Listado de Proyectos y Contratos </a>
                                                                        </li>
                                                                    </ul>
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
                                            <div class='portlet box blue' id="List_Contratos" style="display: none;">
                                                <div class='portlet-body form'>
                                                    <div class='form-body'>
                                                        <div class='row' id="cont_princip">
                                                            <div class='col-md-7'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control" onkeyup="$.busqContrato(this.value);"  id="busq_contratos" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class="btn-group dropup">
                                                                    <button class="btn green dropdown-toggle" onclick="$.NewContrato();" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        Ingresar Contrato <i class="fa fa-newspaper-o"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-1'>
                                                                <div class="btn-group dropup">
                                                                    <button class="btn green dropdown-toggle" onclick="$.VolProyecto();" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        Volver <i class="fa fa-mail-reply"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class="btn-group dropup">
                                                                    <button class="btn purple dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                        Generar Excel <i class="fa fa-file-excel-o"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                        <li>
                                                                            <a onclick="$.ExcelProyContExp();">
                                                                                Listado de Proyectos y Contratos </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">
                                                                    <div id="tab_Contratos" style="height: 350px;overflow: scroll;">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'  >
                                                                <div class='row'>
                                                                    <div class='col-md-2'>
                                                                        <label>No. de Resgistros:
                                                                            <select id="nregContra" onchange="$.combopag2Contra(this.value)" class='form-control'>
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
                                                                        <div id="cobpagContra">

                                                                        </div>
                                                                    </div>
                                                                    <div class='col-md-5'>
                                                                    </div>
                                                                    <div class='col-md-4'>
                                                                        <div id="bot_Contra" style="float:right;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div id="msg2Contra">
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
                                                <div id="msgCod">
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-2'>
                                                <div class='form-group' id="From_CodProyecto"><input type="hidden" id="cons" value="" /><input type="hidden" id="acc" value="1" /><input type="hidden" id="txt_id" value="" /><input type="hidden" id="txt_fec" value="<%=formateador.format(fecha1)%>" />
                                                    <label class='control-label'>Código del Proyecto:</label>
                                                    <input type='text'  id='txt_CodProy'   class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-10'>
                                                <div class='form-group' id="From_NombreProy">
                                                    <label class='control-label'>Nombre del Proyecto:<span class="required">* </span></label>
                                                    <textarea id="txt_NombProy" rows="2"  class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgProy">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right" id="botones">
                                        <button type="button" class="btn green" id="btn_guardarProy"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled=""  id="btn_nuevoProy"><i class="fa fa-file-o"></i> Nuevo</button>
                                        <button type="button" onclick="$.VolProyecto();" class="btn blue" ><i class="fa fa-mail-reply"></i> Volver</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab_03">
                            <p>
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Información del Contratos
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
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
                                                        <div id="msgCod">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class='col-md-12'  id="divproy">
                                                        <div class='form-group' id="From_Proyect">
                                                            <label class='control-label'>Proyecto Asociado:<span class="required">* </span></label>
                                                            <select class="form-control select2"  id="CbProy"  name="options2">

                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <div class='form-group' id="From_CodProyecto"><input type="hidden" id="cons" value="" />
                                                            <input type="hidden" id="acc" value="1" />
                                                            <input type="hidden" id="accCont" value="1" />
                                                            <input type="hidden" id="txt_id" value="" />
                                                            <input type="hidden" id="txt_idCont" value="" />
                                                            <input type="hidden" id="txt_fec" value="<%=formateador.format(fecha1)%>" />
                                                            <label class='control-label'>Número del Contrato:<span class="required">* </span></label>
                                                            <input type='text'  id='txt_Cod'   class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-9' id="divtipo">
                                                        <div class='form-group' id="From_Tipologia">
                                                            <label class='control-label'>Tipología del Contrato:<span class="required">* </span></label>
                                                            <div class="input-group " >
                                                                <select class="form-control select2" id="CbTiplog"  name="options2">
                                                                </select>
                                                                <span class="input-group-btn">
                                                                    <button type="button" id="btn_new_resp" onclick="$.NewTipo();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                        <i class="fa fa-plus"/></i>
                                                                    </button>
                                                                </span>

                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class='col-md-12'>
                                                        <div class='form-group' id="From_Nombre">
                                                            <label class='control-label'>Objeto del Contrato:<span class="required">* </span></label>
                                                            <textarea id="txt_Nomb" rows="2"  class='form-control' style="width: 100%"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class='col-md-4' id="divcont">
                                                        <div class='form-group' id="From_Contratista">
                                                            <label class='control-label'>Contratista:<span class="required">* </span></label>
                                                            <div class="input-group " >
                                                                <select class="form-control select2" id="CbContratis"  name="options2">

                                                                </select>
                                                                <span class="input-group-btn">
                                                                    <button type="button" id="btn_new_resp" onclick="$.NewContra();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                        <i class="fa fa-plus"/></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4' id="divsupe">
                                                        <div class='form-group' id="From_Super">
                                                            <label class='control-label'>Responsable Supervisor:</label>
                                                            <div class="input-group " >
                                                                <select class="form-control select2" id="CbSuper"  name="options2">

                                                                </select>
                                                                <span class="input-group-btn">
                                                                    <button type="button" id="btn_new_resp" onclick="$.NewSuper();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                        <i class="fa fa-plus"/></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4' id="divinter">
                                                        <div class='form-group' id="From_Interv">
                                                            <label class='control-label'>Responsable Interventoria:</label>
                                                            <div class="input-group " >
                                                                <select class="form-control select2" id="CbInter"  name="options2">

                                                                </select>
                                                                <span class="input-group-btn">
                                                                    <button type="button" id="btn_new_resp" onclick="$.NewInter();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                        <i class="fa fa-plus"/></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr align="left" style="margin: 20px 0;" noshade="noshade" size="2" width="100%" />
                                                    <div class='col-md-12'>
                                                        <div class='form-group'>
                                                            <label class='control-label'><b>Valores:</b></label>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3' id="divval">
                                                        <div class='form-group' id="From_Valor">
                                                            <label class='control-label'>Valor del Contrato:<span class="required">* </span></label>
                                                            <input type='text' id='txt_VaCont' onchange="$.AddVFina(this.value, this.id);" value="$ 0,00" class='form-control'  onclick="this.select();"  />

                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='form-group' >
                                                            <label class='control-label'>Adicion del Contrato:</label>
                                                            <input type='text' id='txt_VaAdi' value="$ 0,00" class='form-control'   onchange="$.AddAdic(this.value, this.id);"  onclick="this.select();"  />

                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='form-group' >
                                                            <label class='control-label'>Valor Final del Contrato:</label>
                                                            <input type='text' id='txt_VaFin' value="$ 0,00" class='form-control'  onclick="this.select();" onblur="textm(this.value, this.id)"/>

                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='form-group' >
                                                            <label class='control-label'>Valor Ejecutado del Contrato:</label>
                                                            <input type='text' id='txt_VaEje' value="$ 0,00" class='form-control'  onclick="this.select();"  onblur="textm(this.value, this.id)"/>

                                                        </div>
                                                    </div>
                                                    <div class='col-md-12' id="divfpag">
                                                        <div class='form-group' >
                                                            <label class='control-label'>Forma de Pago:</label>
                                                            <input type='text'  id='txt_Fpago'  class='form-control' />
                                                        </div>
                                                    </div>
                                                    <hr align="left" style="margin: 20px 0; " noshade="noshade" size="2" width="100%" />

                                                    <div class='col-md-12'>
                                                        <div class='form-group' >
                                                            <label class='control-label'><b>Fechas:</b></label>
                                                        </div>
                                                    </div>

                                                    <div class='col-md-3' id="divdura">
                                                        <div class='form-group'>
                                                            <div class='form-group'  id="From_Dur">
                                                                <label class='control-label'>Duración:<span class="required">* </span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="txt_Durac" maxlength="3" onkeypress='return validartxtnum(event)' class="form-control">
                                                                    <span class="input-group-btn">
                                                                        <select class='form-control' id="CbTiemDura" onchange="$.valtiem();" name="options2">
                                                                            <option value=" ">Sel...</option>
                                                                            <option value="Dia(s)">Dia(s)</option>
                                                                            <option value="Mes(es)">Mes(es)</option>
                                                                            <option value="Año(s)">A&ntilde;o(s)</option>
                                                                        </select>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-2' id="divfini">
                                                        <div class='form-group'  id="From_fini">
                                                            <label class='control-label'>Fecha de Inicio:<span class="required">* </span></label>
                                                            <input type='text' id='txt_FIni' value=""  class='form-control' readonly/>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>Fec. de Suspensión:</label>
                                                            <input type='text' id='txt_FSusp' value=""  class='form-control' readonly/>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>Fecha de Reinicio:</label>
                                                            <input type='text' id='txt_FRein' value=""  class='form-control' readonly/>
                                                        </div>
                                                    </div>

                                                    <div class='col-md-3'>
                                                        <div class='form-group'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Prorroga:</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="txt_Prorog" maxlength="3" onchange="$.CalPror();" onkeypress='return validartxtnum(event)' class="form-control">
                                                                    <span class="input-group-btn">
                                                                        <select class='form-control' id="CbTiemProrog" onchange="$.valtiemPro();" name="options2">
                                                                            <option value=" ">Sel...</option>
                                                                            <option value="Dia(s)">Dia(s)</option>
                                                                            <option value="Mes(es)">Mes(es)</option>
                                                                            <option value="Año(s)">A&ntilde;o(s)</option>
                                                                        </select>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class='col-md-2'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>F. de Finalización:</label>
                                                            <input type='text' id='txt_FFina' value=""  class='form-control' readonly/>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>Fecha de Recibo:</label>
                                                            <input type='text' id='txt_FReci' value=""  class='form-control' readonly/>
                                                        </div>
                                                    </div>
                                                    <hr align="left" style="margin: 20px 0;" noshade="noshade" size="2" width="100%" />
                                                    
                                                </div>
                                                
                                                <div class="row">
                                                          <div class='col-md-3'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>% de Avance del Contrato:</label>
                                                            <input type='text' id='txt_Avance' value="" onchange='$.addporc(this.id);'  class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='form-group' id="From_Estado">
                                                            <label class='control-label'>Estado del Contrato:<span class="required">* </span></label>
                                                            <select class='form-control' id="CbEstado" name="options2">
                                                                <option value=" ">Select...</option>
                                                                <option value="Ejecución"  >Ejecución</option>
                                                                <option value="Suspendido" >Suspendido</option>
                                                                <option value="Terminado" >Terminado</option>
                                                                <option value="Liquidado" >Liquidado</option>
                                                            </select>
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

                                    <div class="form-actions right" id="botonesCont">
                                        <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled=""  id="btn_nuevo"><i class="fa fa-file-o"></i> Nuevo</button>
                                        <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
                                        <button type="button" class="btn blue" onclick="$.VolContratos();"><i class="fa fa-mail-reply"></i> Volver</button>
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