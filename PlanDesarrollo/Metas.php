<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}
if ($_SESSION['GesPlaVMe'] == "n") {
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
        <title>Gestión de Metas Trazadoras | GMP - Gestor Monitoreo Público </title>
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
        <script src="../Js/GestionMetas.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>

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
                                <i   style="color: yellow;" class="fa fa-star"></i>
                                <a href="../PlanDesarrollo/Metas.php">Gestión de Metas Trazadoras</a>

                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <!-- Ventana Dependecian -->
                    <div id="VentDependencia" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Crear Dependencia</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group' id="From_CodigoDep">
                                        <label class='control-label'>Código:</label><span class="required">* </span>

                                        <input type='text' id='txt_CodDep' class='form-control' />
                                    </div>
                                </div>
                                <div class='col-md-8'>
                                    <div class='form-group' id="From_DescripcionDep">
                                        <label class='control-label'>Nombre:</label><span class="required">* </span>
                                        <input type='text'   id='txt_DescDep' class='form-control'/>
                                    </div>
                                </div>
                                <div class='col-md-7'>
                                    <div class='form-group'>
                                        <label class='control-label'>Correo Electronico:</label>
                                        <input type='text'   id='txt_CorreDep' class='form-control'/>
                                    </div>
                                </div>
                                <div class='col-md-5'>
                                    <div class='form-group'>
                                        <label class='control-label'>Telefono:</label>
                                        <input type='text'   id='txt_TelfDep' class='form-control'/>
                                    </div>
                                </div>

                                <div class='col-md-12'>
                                    <div class='form-group'>
                                        <label class='control-label'>Observación:</label>
                                        <textarea id="txt_obserDep" rows="2"  class='form-control' style="width: 100%"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="msgD">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <center><h2 class='form-section'></h2></center>
                            <div class="form-actions right" >
                                <button type="button" class="btn green" id="btn_guardarD"><i class="fa fa-save"></i> Guardar</button>
                                <button type="button" class="btn purple" disabled id="btn_nuevoD"><i class="fa fa-file-o"></i> Nuevo</button>
                                <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-close"></i> Cerrar</button>

                            </div>
                        </div>

                    </div>
                    <!-- Fin Ventana dependecia -->
                    <!-- Ventana fuentes -->
                    <div id="VentFuentes" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Crear Fuente</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>

                                <div class='col-md-12'>
                                    <div class='form-group' id="From_DescripcionFue">
                                        <label class='control-label'>Nombre:</label><span class="required">* </span>
                                        <input type='text'   id='txt_DescFue' class='form-control'/>
                                    </div>
                                </div>


                                <div class='col-md-12'>
                                    <div class='form-group'>
                                        <label class='control-label'>Observación:</label>
                                        <textarea id="txt_obserFue" rows="2"  class='form-control' style="width: 100%"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="msgF">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <center><h2 class='form-section'></h2></center>
                            <div class="form-actions right" >
                                <button type="button" class="btn green" id="btn_guardarF"><i class="fa fa-save"></i> Guardar</button>
                                <button type="button" class="btn purple" disabled id="btn_nuevoF"><i class="fa fa-file-o"></i> Nuevo</button>
                                <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-close"></i> Cerrar</button>

                            </div>
                        </div>

                    </div>
                    <!-- Fin Ventana fuentes -->

                    <!-- responsive actividades -->
                    <div id="responsiveAct" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Selección Actividades </h4>


                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>

                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div id="sample_1_filter" class="dataTables_filter">
                                                    <label>
                                                        Busqueda:
                                                        <input class="form-control input-small input-inline" onkeypress="$.busqActi(this.value);" onchange="$.busqActi(this.value);" id="busq_terce" type="search" placeholder="" aria-controls="sample_1">
                                                    </label>
                                                </div>
                                                <div class="table-scrollable">
                                                    <div id="tab_Actividades" style="height: 250px;overflow: scroll;">

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





                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Metas Trazadoras</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" onclick="$.addMeta();" data-toggle="tab"  id="atitulo">Crear Meta Trazadora</a>
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

                                                            <div class='col-md-7'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control m-wrap large input-inline"  onkeyup="$.busqPlan(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>

                                                                </div>
                                                            </div>
                                                          
                                                            <div class='col-md-5' style="text-align: right;">
                                                                <div class='form-group'>
                                                                    <button type="button" class="btn green" id="btn_Excel"><i class="fa fa-file-excel-o"></i> Generar Excel</button>

                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">

                                                                    <div id="tab_PlanAccion" style="height: 350px;overflow: scroll;">

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
                                                                  

                                                                    <div class='col-md-4'>
                                                                        <div id="bot_PlanAccion" style="float:right;">
                                                                        </div>

                                                                    </div>

                                                                    <div class='col-md-4' style="text-align: right;">
                                                                        <button type="button" class="btn green-meadow"id="btn_inf"><i class="icon-bar-chart"></i> <label  style="font-weight: bold;"id="TotMet"></label></button>

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
                        <div class="tab-pane fade" id="tab_02">
                            <p>
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Informacion Plan de la Meta
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
                                            <li >
                                                <a href="#tab_2" data-toggle="tab"> Art. Plan de Desarrollo </a>
                                            </li>
                                            <li >
                                                <a href="#tab_3" data-toggle="tab"> Proyección  </a>
                                            </li>
                                            <li >
                                                <a href="#tab_4" data-toggle="tab"> Semaforizacion  </a>
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
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <p class="control-label" style="font-weight: bold;"> Campos Obligatorios <span class="required">* </span> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>

                                                                <div class='col-md-2'>

                                                                    <div class='form-group' id="From_Codigo">
                                                                        <label class='control-label'>Código:<span class="required">* </span></label>
                                                                        <input type="hidden" id="acc" value="1" />
                                                                        <input type="hidden" id="txt_id" value="1" />
                                                                        <input type="hidden" id="cons" value="1" />
                                                                        <input type="hidden" id="perm" value="<?php echo $_SESSION['GesPlaAMe']; ?>" />
                                                                        <input type='text' id='txt_Cod'  disabled="" value="" class='form-control' />
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-10'>
                                                                    <div class='form-group' id="From_Descripcion">
                                                                        <label class='control-label'>Descripción:<span class="required">* </span></label>
                                                                        <textarea id="txt_Desc" rows="2"  class='form-control' style="width: 100%"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group' id="From_Dato">
                                                                        <label class='control-label'>Unidad de Medida:<span class="required">* </span></label>

                                                                        <select class='form-control' onchange="$.HabIndice(this.value);"  id="CbTipDato" name="options2">
                                                                            <option value=" ">Seleccione...</option>
                                                                            <option value="Cantidad">Cantidad</option>
                                                                            <option value="Indice">Indice</option>
                                                                            <option value="Kilometros">Kilometros</option>
                                                                            <option value="m2">Metros Cuadrados</option>
                                                                            <option value="Hectareas">Hectareas</option>
                                                                            <option value="Kilogramos">Kilogramos</option>
                                                                            <option value="Porcentaje">Porcentaje</option>
                                                                            <option value="Pesos">Pesos</option>
                                                                            <option value="Horas">Horas</option>
                                                                            <option value="MW">MW</option>
                                                                            <option value="Cualitativa">Cualitativa</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' id="div_Indice" style="pointer-events:none;">
                                                                    <div class='form-group' id="From_Dato">
                                                                        <label class='control-label'>Indice:<span class="required">* </span></label>
                                                                        <select  class='form-control'  id="CbIndice" name="options2">
                                                                            <option value="NO APLICA">NO APLICA</option>
                                                                            <option value="x 1.000">x 1.000</option>
                                                                            <option value="x 100.000">x 100.000</option>
                                                                             <option value="0-10">0-10</option>
                                                                            <option value="0-100">0-100</option>                                                                           
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group' id="From_Base">
                                                                        <label class='control-label'>Línea Base:<span class="required">* </span></label>

                                                                        <input type='text' id='txt_LinBase'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group' id="From_Base">
                                                                        <label class='control-label'>Meta:</label>

                                                                        <input type='text' id='txt_Meta'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Proposito de la Meta:<span class="required">* </span></label>

                                                                        <select class='form-control' id="CbProMet" name="options2">
                                                                            <option value=" ">Seleccione...</option>
                                                                            <option value="Aumentar">Aumentar</option>
                                                                            <option value="Disminuir">Disminuir</option>
                                                                            <option value="Mantener">Mantener</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group' id="From_Dep">
                                                                        <label class='control-label'>Clasificación Integral:<span class="required">* </span></label>
                                                                        <div class="input-group " >
                                                                            <select class="form-control select2"  onchange="$.HabDerFund(this.value)" id="CbClasif" name="options2">
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3' id="div_DerFund" style="pointer-events:none;">
                                                                    <div class='form-group' id="From_Dep">
                                                                        <label class='control-label'>Derecho Fundamental:<span class="required">* </span></label>
                                                                        <select class="form-control select2" id="CbDerFund"  name="options2">

                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-6'>
                                                                    <div class='form-group' id="From_Dep">
                                                                        <label class='control-label'>Fuente:<span class="required">* </span></label>
                                                                        <div class="input-group " >
                                                                            <select class="form-control select2" data-placeholder="Seleccione..." multiple="" id="CbFuente" name="options2">

                                                                            </select>

                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_new_resp" onclick="$.NewFuente();" title="Crear Nueva Dependencia" class="btn green-meadow">
                                                                                    <i class="fa fa-plus"/></i>
                                                                                </button>
                                                                            </span>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group' id="From_Dep">
                                                                        <label class='control-label'>Sectotial Responsable:<span class="required">* </span></label>
                                                                        <div class="input-group " >
                                                                            <select class="form-control select2" data-placeholder="Seleccione..." multiple="" id="CbDepend" name="options2">

                                                                            </select>

                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_new_resp" onclick="$.NewDepend();" title="Crear Nueva Dependencia" class="btn green-meadow">
                                                                                    <i class="fa fa-plus"/></i>
                                                                                </button>
                                                                            </span>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--                                            Articulacion Con El Plan De Desarrollo -->
                                            <div class="tab-pane fade" id="tab_2">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>2. Articulacion Con El Plan De Desarrollo
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
                                                                        <p class="control-label" style="font-weight: bold;"> Campos Obligatorios <span class="required">* </span> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group' id="From_Eje">
                                                                        <label class='control-label'>Eje:<span class="required">* </span></label>
                                                                        <select class="form-control select2" data-placeholder="Seleccione..." onchange="$.CargEstrategia(this.value);"  id="CbEjes" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group' id="From_Est">
                                                                        <label class='control-label'>Programa:<span class="required">* </span></label>
                                                                        <select class="form-control select2" disabled data-placeholder="Seleccione..." onchange="$.CargProgramas(this.value);" id="CbEtrategias" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group' id="From_Pro">
                                                                        <label class='control-label'>SubPrograma:<span class="required">* </span></label>
                                                                        <select class="form-control select2" disabled data-placeholder="Seleccione..."  id="CbProgramas" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--                                            Articulacion Con El Plan De Desarrollo -->
                                            <div class="tab-pane fade" id="tab_3">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>3.Proyeccción
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class="row">
                                                                <div class="col-md-12" style="padding-top: 10px;">
                                                                    <div class='portlet box blue'>

                                                                        <div class='portlet-body form'>
                                                                            <input type="hidden" id="contProyecc" value="0" />
                                                                            <div class='form-body'>
                                                                                <div class='row'>

                                                                                    <div class='col-md-3'>
                                                                                        <div class='form-group'>
                                                                                            <label class='control-label'>Año:</label>
                                                                                            <select class='form-control' id="CbAnioProy" name="options2">
                                                                                                <option value=" ">Select...</option>
                                                                                                <option value="2015">2015</option>
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
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-4'>
                                                                                        <div class='form-group'>
                                                                                            <label class='control-label'>Valor:</label>
                                                                                            <input type='text' id='txt_Valot'   onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" value="" class='form-control'    class='form-control'/>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-5' style="text-align: right">
                                                                                        <div class='form-group' >
                                                                                            <label class='control-label'>&nbsp;</label>
                                                                                            <a onclick="$.AddProyecccion()" class="btn green-meadow">
                                                                                                <i class="fa fa-plus-circle"></i> Agregar
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div id="msgPro">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class='col-md-12'>
                                                                                        <div class='form-group'>
                                                                                            <table class='table table-striped table-hover table-bordered' id="tb_Proyec">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <i class='fa fa-angle-right'></i> #
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <i class='fa fa-angle-right'></i> Año
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <i class='fa fa-angle-right'></i> Valor
                                                                                                        </td>

                                                                                                        <td>
                                                                                                            <i class='fa fa-angle-right'></i> Acción
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody id="tb_Body_Proyeccion">


                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                        <!--                                            Articulacion Con El Plan De Desarrollo -->
                                        <div class="tab-pane fade" id="tab_4">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>4.Semaforizacion
                                                    </div>
                                                    <div class='tools'>
                                                        <a href='javascript:;' class='collapse'></a>
                                                    </div>
                                                </div>
                                                <div class='portlet-body form'>

                                                    <div class='form-body'>
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-top: 10px;">
                                                                <div class='portlet box blue'>

                                                                    <div class='portlet-body form'>
                                                                        <div class='form-body'>
                                                                            <div class='row'>

                                                                                <div class='col-md-12'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'><b>Aceptable:</b></label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group   has-success' >
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa fa-check tooltips" data-original-title="Minimo!" data-container="body"></i>
                                                                                            <input type='text' id='txt_AcepMin'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" placeholder="Minimo" value="" class='form-control'/>

                                                                                        </div>


                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group   has-success' >

                                                                                        <div class="input-icon right">
                                                                                            <i class="fa fa-check tooltips" data-original-title="Maximo!" data-container="body"></i>
                                                                                            <input type='text' id='txt_AcepMax'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();"  placeholder="Maximo"  value="" class='form-control'/>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <div class='col-md-6'>
                                                                                    <div class='form-group   has-success' >

                                                                                        <div class="input-icon right">
                                                                                            <input type='text' id='txt_AcepDesc'   placeholder="Descripción"  value="" class='form-control'/>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <!--                                                                                    ///////////////////-->
                                                                                <div class='col-md-12'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'><b>Con Riesgo:</b></label>
                                                                                    </div>
                                                                                </div>


                                                                                <div class='col-md-3'>

                                                                                    <div class='form-group has-warning' >
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa fa-exclamation tooltips" data-original-title="Minimo!" data-container="body"></i>
                                                                                            <input type='text' id='txt_RiesMin'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" placeholder="Minimo"  value="" class='form-control'/>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group has-warning' >

                                                                                        <div class="input-icon right">
                                                                                            <i class="fa fa-exclamation tooltips" data-original-title="Maximo!" data-container="body"></i>
                                                                                            <input type='text' id='txt_RiesMax'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" placeholder="Maximo"   value="" class='form-control'/>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <div class='col-md-6'>
                                                                                    <div class='form-group   has-warning' >

                                                                                        <div class="input-icon right">

                                                                                            <input type='text' id='txt_RiesDesc'   placeholder="Descripción"  value="" class='form-control'/>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class='col-md-12'>
                                                                                    <div class='form-group'>
                                                                                        <label class='control-label'><b>Critico:</b></label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group has-error' >
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa fa-warning  tooltips" data-original-title="Minimo!" data-container="body"></i>
                                                                                            <input type='text' id='txt_CritMin'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" value="" placeholder="Minimo" class='form-control'/>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class='col-md-3'>

                                                                                    <div class='form-group has-error' >

                                                                                        <div class="input-icon right">
                                                                                            <i class="fa fa-warning  tooltips" data-original-title="Maximo!" data-container="body"></i>
                                                                                            <input type='text' id='txt_CritMax'  onkeypress="return check(event)" onchange="$.FormNum(this.id);" onclick="this.select();" placeholder="Maximo"  value="" class='form-control'/>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class='col-md-6'>
                                                                                    <div class='form-group   has-error' >

                                                                                        <div class="input-icon right">

                                                                                            <input type='text' id='txt_CritDesc'   placeholder="Descripción"  value="" class='form-control'/>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div
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
