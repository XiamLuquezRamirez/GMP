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
        <title>Gestión de Indicadores | Indicadores </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
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
        <script src="../Js/HojaVidaIndicador.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>


    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed page-sidebar-fixed">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="../Administracion.jsp">
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
                                        <label class="control-label">Meta:</label>
                                        <p id="Meta" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Proposito:</label>
                                        <p id="Prop" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Responsable:</label>
                                        <p id="Respo" style="color: #e02222; margin: 0px 0"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label  class="control-label">Eje:</label>
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

        <!-- ventana metas -->
        <div id="ventanaMeta" class="modal fade" tabindex="-1" data-width="900">
            <div class="modal-header">
                <input type="hidden" id="contVariables" value="0" />
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Parametros Registrados</h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group' id="From_Eje">
                            <label class='control-label'>Eje:</label>
                            <select class="form-control select2" data-placeholder="Seleccione..." onchange="$.CargEstrategia(this.value);"  id="CbEjes" name="options2">

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
                            <select class="form-control select2" disabled data-placeholder="Seleccione..."  onchange="$.busqMetas();"  id="CbProgramas" name="options2">

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
                    <div class='col-md-12'  >
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

        <!--Ventana Formula Matematica indicador-->
        <div id="ModFormula" class="modal fade" tabindex="-1" data-width="500">
            <div class="modal-header">
                <input type="hidden" id="contMetas" value="0" />
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Parametrizar Formula</h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='form-group' id="From_Eje">
                            <label class='control-label'>Variables:</label>

                            <div class="input-group " >
                                <input type='text' id='txt_Variable'  value="" class='form-control' />

                                <span class="input-group-btn">
                                    <button type="button" id="btn_new_resp" onclick="$.AddVariable();" title="Agregar Formula Matematica" class="btn green-meadow">
                                        <i class="fa fa-plus"/></i>
                                    </button>
                                </span>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="msg3">
                        </div>
                    </div>

                    <div class='col-md-12'>
                        <div class='form-group' id="From_Est">
                            <div class="control-group">
                                <label class="control-label">Variables Agregadas:</label>
                                <div class="controls">
                                    <table>
                                        <table class="table table-striped table-hover table-bordered" id="tb_Body_Variable">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <i class="fa fa-angle-right"></i> #
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-angle-right"></i> Descripción Variable
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-angle-right"></i> Acción
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody id="tb_BodyVar">

                                            </tbody>
                                        </table>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class='row'>

                    <div class='col-md-12'>
                        <div class="form-group">
                            <label class='control-label'>Eidtar Formula Matematica:</label>
                            <textarea id="txt_RelMateEdit" rows="2"   class='form-control' style="width: 100%"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"  onclick="$.ValidarExpre();" class="btn blue" title="Validar Expresión"><i class="fa fa-check-square"></i> Validar Expresión</button>
                <button type="button" id="Btn_AddForm" class="btn green" onclick="$.AddForm();" data-dismiss="modal" disabled="" title="Aceptar"><i class="fa fa-green"></i> Aceptar</button>
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
                                <a href="../Indicadores/HojaVidaIndicador.php">Gestión de Indicadores</a>
                                <i class="fa fa-circle"></i>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

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
                                   <h4 class='form-section'></h4>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Indicadores</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" data-toggle="tab" onclick="$.conse();" id="atitulo">Crear Indicador</a>
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
                                        <i class="fa fa-angle-right"></i>Información Indicador.
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab"> Identificación del Indicador</a>
                                            </li>
                                            <li >
                                                <a href="#tab_2" data-toggle="tab"> Caracteristicas del Indicador </a>
                                            </li>
                                            <li>
                                                <a href="#tab_3" data-toggle="tab"> Descripción de Metas </a>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <!--                                            Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>1. Identificación del Indicador
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
                                                                        <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row' >
                                                                <div class='col-md-9' >
                                                                    <div class='form-group' style="text-align: right;">

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3' >
                                                                    <div class='form-group' style="text-align: right;">
                                                                        <label class='control-label'>Código:</label><input type="hidden" id="acc" value="1" /><input type="hidden" id="txt_id" value="1" /><input type="hidden" id="txt_ori" value="<?php echo $_GET['indi']; ?>" />
                                                                        <input type='text' id='txt_CodIndi'  value="" class='form-control' />
                                                                        <input type="hidden" id="cons" value="1" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>



                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>No. Indicador:</label>
                                                                        <input type='text' id='txt_NumIndi' disabled="" value="" class='form-control' />
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-10'>
                                                                    <div class='form-group' id="From_NomIndi">
                                                                        <label class='control-label'>Nombre Indicador:<span class="required">* </span></label>
                                                                        <textarea id="txt_NomIndi" rows="2"  class='form-control' style="width: 100%"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Objetivo:</label>
                                                                        <textarea id="txt_ObjIndi" rows="2"  class='form-control' style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-6'>
                                                                    <div class='form-group' id="From_Proceso">
                                                                        <label class='control-label'>Proceso:<span class="required">* </span></label>

                                                                        <div class="input-group " >
                                                                            <select class="form-control select2" data-placeholder="Seleccione..." id="CbProceso" name="options2">

                                                                            </select>
                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_new_resp" onclick="$.UpdateProceso();" title="Actualizar Fuentes de Datos" class="btn blue-soft">
                                                                                    <i class="fa fa-refresh"/></i>
                                                                                </button>
                                                                            </span>
                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_new_resp" onclick="$.NewProceso();" title="Crear Nueva Fuente de Datos" class="btn green-meadow">
                                                                                    <i class="fa fa-plus"/></i>
                                                                                </button>
                                                                            </span>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group' id="From_FreMed">
                                                                        <label class='control-label'>Frecuencia de Medicion:<span class="required">* </span></label>
                                                                        <select class='form-control' id="CbFreMed" name="options2">
                                                                            <option value=" ">Seleccione...</option>
                                                                            <option value="Mensual">Mensual</option>
                                                                            <option value="Trimestral">Trimestral</option>
                                                                            <option value="Semestral">Semestral</option>
                                                                            <option value="Anual">Anual</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'  id="From_Unida">
                                                                        <label class='control-label'>Unidad de Medida:<span class="required">* </span></label>
                                                                        <select class='form-control' id="CbUnida" name="options2">
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
                                                                <div class="col-md-12">
                                                                    <label class='control-label'>Fuente de Datos:</label>
                                                                    <div class="input-group ">
                                                                        <select class="form-control select2-multiple"  data-placeholder="Seleccione..." multiple="multiple"  id="Cbfuente" name="options2">

                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.UpdateFuente();" title="Actualizar Fuentes de Datos" class="btn blue-soft">
                                                                                <i class="fa fa-refresh"/></i>
                                                                            </button>
                                                                        </span>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewFuente();" title="Crear Nueva Fuente de Datos" class="btn green-meadow">
                                                                                <i class="fa fa-plus"/></i>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                    <!-- /input-group -->
                                                                </div>

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
                                                            <i class='fa fa-angle-right'></i>2. Caracteristicas del Indicador
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tipo de Indicador:</label>
                                                                        <select class='form-control' id="CbTipInd" name="options2">
                                                                            <option value=" ">Seleccione...</option>
                                                                            <option value="Eficacia">Eficacia</option>
                                                                            <option value="Eficiencia">Eficiencia</option>
                                                                            <option value="Economia">Economia</option>
                                                                            <option value="Calidad">Calidad</option>
                                                                            <option value="Incremento">Incremento</option>
                                                                            <option value="Comparación">Comparación</option>

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-10'>
                                                                    <div class='form-group'  id="From_Respo">
                                                                        <label class='control-label'>Responsable:<span class="required">* </span></label>
                                                                        <div class="input-group " >
                                                                            <select class="form-control select2-multiple"  data-placeholder="Seleccione..." multiple="multiple"  id="CbRespo" name="options2">

                                                                            </select>
                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_new_resp" onclick="$.UpdateRespon();" title="Crear Nuevo Responsable" class="btn blue-soft">
                                                                                    <i class="fa fa-refresh"/></i>
                                                                                </button>
                                                                            </span>
                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_new_resp" onclick="$.NewRespon();" title="Crear Nuevo Responsable" class="btn green-meadow">
                                                                                    <i class="fa fa-plus"/></i>
                                                                                </button>
                                                                            </span>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'  id="From_RelMat">
                                                                        <label class='control-label'>Relacion Matematica:<span class="required">* </span></label>
                                                                        <textarea id="txt_RelMat" readonly="" rows="2" onclick="$.AbriModForm();"  class='form-control' style="width: 100%"></textarea>

                                                                    </div>
                                                                </div>
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
                                                            <i class='fa fa-angle-right'></i>3. Descripción de Metas
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Código:</label>
                                                                        <div class="input-group" >
                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_paraMet" title="Busqueda del Indicador" class="btn green-meadow">
                                                                                    <i class="fa fa-search fa-fw"/></i>
                                                                                </button>
                                                                            </span>
                                                                            <input type='text' id='txt_CodMeta' disabled="" value="" class='form-control' />
                                                                            <input type='hidden' id='txt_IdMeta' disabled="" value="" class='form-control' />

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-8'>
                                                                    <div class='form-group'id="From_Act">
                                                                        <label class='control-label' >Descripción:</label>
                                                                        <textarea id="txt_DesMeta" rows="4"  class='form-control' style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>


                                                                <div class='col-md-2' style="vertical-align: middle;">
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
                                                </p>
                                            </div>
                                            <!--                                            Indicador     -->
                                            <div class="tab-pane fade" id="tab_4">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>4. Indicadores Clave
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
                                                                        <label class='control-label'>Indicador Clave:</label>
                                                                        <div class="input-group">
                                                                            <input type="hidden" id="contIndicador" value="0" />
                                                                            <textarea id="txt_IndClave" rows="4"  class='form-control' style="width: 100%"></textarea>
                                                                            <span class="input-group-btn">
                                                                                <button class="btn blue" onclick="$.AddIndi()" type="button">Agregar</button>
                                                                            </span>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Indicadores Asignados:</b></label>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group' id="From_Ind">
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Indicador">
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
                                                                            <tbody id="tb_Body_Indicador">


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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions right">
                                        <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled=""  id="btn_nuevo"><i class="fa fa-file-o"></i> Nuevo</button>
                                        <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
                                    </div>
                                    <!-- END FORM-->
                                </div>
                            </div>



                            </p>
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
