<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if ($_SESSION['ses_user'] == NULL) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['GesEvaVEv'] == "n") {
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
        <title>Evaluación Contratista | GMP - Gestor Monitoreo Público</title>
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
        <script src="../Js/EvalContratista.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>
        <style>
            .containerdiv {
                border: 0;
                float: left;
                position: relative;
                width: 100px;
            }
            .cornerimage {
                border: 0;
                position: absolute;
                top: 0;
                left: 0;
                overflow: hidden;
            }
            .containerdiv img{
                max-width: 100px;
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
                                <a href="../Evaluacion_Contratista/">Evaluación Contratistas</a>
                            </li>

                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <!-- ventana Contratos -->
                    <div id="ventanaContra" class="modal fade" tabindex="-1" data-width="900">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Parametros Registrados</h4>
                        </div>
                        <div class="modal-body">
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div id="sample_1_filter" class="dataTables_filter">

                                        Busqueda:
                                        <div class="input-group" >
                                            <input class="form-control  input-inline"  id="busq" type="search" placeholder="" aria-controls="sample_1">

                                            <span class="input-group-btn">
                                                <button type="button" onclick="$.Load_ventana('2');" title="Busqueda del Meta" class="btn green-meadow">
                                                    <i class="fa fa-search fa-fw"/></i>
                                                </button>
                                            </span>

                                        </div>

                                    </div>
                                    <div class="table-scrollable">
                                        <div id="tab_Vent" style="height: 250px;overflow: scroll;">

                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-12'  >
                                    <div class='row'>
                                        <div class='col-md-2'>
                                            <label>No. de Resgistros:
                                                <select id="nregVent" onchange="$.combopag2Vent(this.value)" class='form-control'>
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
                                            <div id="cobpagVent">
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

                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Evaluaciones</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" onclick="$.addEval();"  data-toggle="tab"  id="atitulo">Realizar Evaluación</a>
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
                                        <i class="fa fa-angle-right"></i>Evaluación de Contratista
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
                                            <li id="tab_pp2"  style="display: none;">
                                                <a href="#tab_2" data-toggle="tab"> Prestación de Servicios  </a>
                                            </li>
                                            <li id="tab_pp3"  style="display: none;">
                                                <a href="#tab_3" data-toggle="tab"> Suministro y Adquisición  </a>
                                            </li>
                                            <li id="tab_pp4"  style="display: none;">
                                                <a href="#tab_4" data-toggle="tab"> Arrendamiento </a>
                                            </li>
                                            <li id="tab_pp5"  style="display: none;">
                                                <a href="#tab_5" data-toggle="tab"> Consultoría / Merito </a>
                                            </li>
                                            <li id="tab_pp6"  style="display: none;">
                                                <a href="#tab_6" data-toggle="tab"> Obra Publica </a>
                                            </li>
                                            <li id="tab_pp7" style="display: none;">
                                                <a href="#tab_7" data-toggle="tab"> Análisis del Resultado </a>
                                            </li>
                                            <li id="tab_pp8">
                                                <a href="#tab_8"   data-toggle="tab"  id="par_eval">Parametros de Evaluación</a>
                                            </li>


                                        </ul>
                                        <div class="tab-content">
                                            <!--                                Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Información General
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
                                                            <div class='row'>
                                                                <div class='col-md-2'>
                                                                    <label style="font-weight: bold"><input type='checkbox' name='checkeval' value="eva" onclick="$.checktipeval(this.value);" checked="" id="ck_eval" class='icheck'> Evaluación</label>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Evaluación:</label>
                                                                        <input type='text' id='txt_fecha_Eval' value=""  class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'></label>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <label style="font-weight: bold"><input type='checkbox' name='checkeval' value="reva"  onclick="$.checktipeval(this.value);" id="ck_reval" class='icheck'> Reevaluación</label>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Reevaluación:</label>
                                                                        <input type='text' id='txt_fecha_Reval' value=""  class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group' id="From_numcon">
                                                                        <label class='control-label'>Número:</label>
                                                                        <div class="input-group" >
                                                                            <span class="input-group-btn">
                                                                                <button type="button" id="btn_paraCont" title="Busqueda del Contrato" class="btn green-meadow">
                                                                                    <input type="hidden" id="acc" value="1" />
                                                                                    <input type="hidden" id="tcont" value="1" />
                                                                                    <input type="hidden" id="txt_id" value="1" />
                                                                                    <input type="hidden" id="perm" value="<?php echo $_SESSION['GesEvaAEv']; ?>" />
                                                                                    <i class="fa fa-search fa-fw"/></i>
                                                                                </button>
                                                                            </span>
                                                                            <input type='text' id='txt_CodCont' disabled="" value="" class='form-control' />
                                                                            <input type='hidden' id='txt_IdCont' disabled="" value="" class='form-control' />

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha:</label>
                                                                        <input type='text' id='txt_fecha' value=""  class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label' >Objeto:</label>
                                                                        <textarea id="txt_Objet" disabled="" rows="4"  class='form-control' style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group' >
                                                                        <label class='control-label'>Contratista:</label>
                                                                        <input type='text' disabled="" id='txt_Contra' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group' >
                                                                        <label class='control-label'>NIT/CC:</label>
                                                                        <input type='text' disabled="" id='txt_nitcont' value="" class='form-control' />

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha de Inicio:</label>
                                                                        <input type='text' id='txt_fecini' disabled="" value="" class='form-control' />

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Terminación:</label>
                                                                        <input type='text' id='txt_fecfin' disabled="" value="" class='form-control' />

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Clase de Contrato:</label>
                                                                        <input type='text' id='txt_Clase' disabled="" value="" class='form-control' />

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--                                Primera  -->
                                         

                                            <!--Prestación de Servicios-->
                                            <div class="tab-pane fade" id="tab_2">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Prestación de Servicios
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
                                                                        <p style="font-weight: bold; font-size: 20px;text-align: center;" class="control-label"> Puntajes:   <b>2 = Malo  &nbsp;&nbsp;&nbsp;&nbsp;   3 = Regular	&nbsp;&nbsp;&nbsp;&nbsp;  4 = Bueno   &nbsp;&nbsp;&nbsp;&nbsp;  5 = Excelente </b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class="col-md-6">
                                                                    <div class="col-md-12">
                                                                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                        <div class="portlet box red">
                                                                            <div class="portlet-title">
                                                                                <div class="caption">
                                                                                    <i class="fa fa-check"></i>Criterios Cumplimiento Y Oportunidad
                                                                                </div>
                                                                                <div class="tools">
                                                                                    <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                    </a>

                                                                                </div>
                                                                            </div>
                                                                            <div class="portlet-body">
                                                                                <div class="table-scrollable">
                                                                                    <table class="table table-hover">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    #
                                                                                                </th>
                                                                                                <th>
                                                                                                    Criterios
                                                                                                </th>
                                                                                                <th>
                                                                                                    Puntaje
                                                                                                </th>


                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    1
                                                                                                </td>
                                                                                                <td>
                                                                                                    Oportunidad en el Servicio
                                                                                                    <input type="text" style="display: none;" id="textPs11" class="form-control input-xsmall" value="Oportunidad en el Servicio-Cumplimiento">
                                                                                                </td>
                                                                                                <td >
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs1(this.id);" onclick="select();" id="puntPs11" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    2
                                                                                                </td>
                                                                                                <td>
                                                                                                    Cobertura del Servicio
                                                                                                    <input type="text" style="display: none;" id="textPs12" class="form-control input-xsmall" value="Cobertura del Servicio-Cumplimiento">
                                                                                                </td>
                                                                                                <td style="text-align: center;">
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs1(this.id);"  onclick="select();" id="puntPs12" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    3
                                                                                                </td>
                                                                                                <td>
                                                                                                    Tiempo De Respuesta A Requerimientos
                                                                                                    <input type="text" style="display: none;" id="textPs13" class="form-control input-xsmall" value="Tiempo De Respuesta A Requerimientos-Cumplimiento">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs1(this.id);"  onclick="select();" id="puntPs13" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>

                                                                                            <tr style="background-color: lightgrey;">
                                                                                                <td colspan="2">
                                                                                                    <b>Total Promedio</b>
                                                                                                </td>

                                                                                                <td >
                                                                                                    <input type="hidden" style="text-align: center;"  id="puntPsTot1Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                    <input type="text" style="text-align: center;"  id="puntPsTot1" disabled="" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>


                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END SAMPLE TABLE PORTLET-->
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                        <div class="portlet box green">
                                                                            <div class="portlet-title">
                                                                                <div class="caption">
                                                                                    <i class="fa fa-check"></i>Criterios De Calidad 
                                                                                </div>
                                                                                <div class="tools">
                                                                                    <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                    </a>

                                                                                </div>
                                                                            </div>
                                                                            <div class="portlet-body">
                                                                                <div class="table-scrollable">
                                                                                    <table class="table table-hover">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    #
                                                                                                </th>
                                                                                                <th>
                                                                                                    Criterios
                                                                                                </th>
                                                                                                <th>
                                                                                                    Puntaje
                                                                                                </th>


                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    1
                                                                                                </td>
                                                                                                <td>
                                                                                                    Conformidad
                                                                                                    <input type="text" style="display: none;" id="textPs31" class="form-control input-xsmall" value="Conformidad-Calidad">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs3(this.id);" onclick="select();" id="puntPs31" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    2
                                                                                                </td>
                                                                                                <td>
                                                                                                    Devoluciones, Cambios de Elementos
                                                                                                    <input type="text" style="display: none;" id="textPs32" class="form-control input-xsmall" value="Devoluciones, Cambios de Elementos-Calidad">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs3(this.id);" onclick="select();" id="puntPs32" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    3
                                                                                                </td>
                                                                                                <td>
                                                                                                    Funcionamiento
                                                                                                    <input type="text" style="display: none;" id="textPs33" class="form-control input-xsmall" value="Funcionamiento-Calidad">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs3(this.id);" onclick="select();" id="puntPs33" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    4
                                                                                                </td>
                                                                                                <td>
                                                                                                    Soporte y Mantenimiento
                                                                                                    <input type="text" style="display: none;" id="textPs34" class="form-control input-xsmall" value="Soporte y Mantenimiento-Calidad">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs3(this.id);" onclick="select();" id="puntPs34" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    5
                                                                                                </td>
                                                                                                <td>
                                                                                                    Desempeño del Personal
                                                                                                    <input type="text" style="display: none;" id="textPs35" class="form-control input-xsmall" value="Desempeño del Personal-Calidad">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromPs3(this.id);" onclick="select();" id="puntPs35" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>

                                                                                            <tr style="background-color: lightgrey;">
                                                                                                <td colspan="2">
                                                                                                    <b>Total Promedio</b>
                                                                                                </td>

                                                                                                <td >
                                                                                                    <input type="hidden" style="text-align: center;"  id="puntPsTot3Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                    <input type="text" style="text-align: center;"  onclick="select();" id="puntPsTot3" disabled="" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END SAMPLE TABLE PORTLET-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="col-md-12">
                                                                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                        <div class="portlet box blue">
                                                                            <div class="portlet-title">
                                                                                <div class="caption">
                                                                                    <i class="fa fa-check"></i>Criterios En La Ejecución Del Contrato
                                                                                </div>
                                                                                <div class="tools">
                                                                                    <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                    </a>

                                                                                </div>
                                                                            </div>
                                                                            <div class="portlet-body">
                                                                                <div class="table-scrollable">
                                                                                    <table class="table table-hover">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    #
                                                                                                </th>
                                                                                                <th>
                                                                                                    Criterios
                                                                                                </th>
                                                                                                <th>
                                                                                                    Puntaje
                                                                                                </th>


                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    1
                                                                                                </td>
                                                                                                <td>
                                                                                                    Prestación de Informes de Avance
                                                                                                    <input type="text" style="display: none;" id="textPs21" class="form-control input-xsmall" value="Prestación de Informes de Avance-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs21" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    2
                                                                                                </td>
                                                                                                <td>
                                                                                                    Atención de Requerimientos
                                                                                                    <input type="text" style="display: none;" id="textPs22" class="form-control input-xsmall" value="Atención de Requerimientos-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs22" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    3
                                                                                                </td>
                                                                                                <td>
                                                                                                    Atención de Reclamos
                                                                                                    <input type="text" style="display: none;" id="textPs23" class="form-control input-xsmall" value="Atención de Reclamos-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs23" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    4
                                                                                                </td>
                                                                                                <td>
                                                                                                    Disposición de Servicio
                                                                                                    <input type="text" style="display: none;" id="textPs24" class="form-control input-xsmall" value="Disposición de Servicio-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs24" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    5
                                                                                                </td>
                                                                                                <td>
                                                                                                    Suministro de Repuesto
                                                                                                    <input type="text" style="display: none;" id="textPs25" class="form-control input-xsmall" value="Suministro de Repuesto-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs25" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    6
                                                                                                </td>
                                                                                                <td>
                                                                                                    Servicio Postventa
                                                                                                    <input type="text" style="display: none;" id="textPs26" class="form-control input-xsmall" value="Servicio Postventa-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs26" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    7
                                                                                                </td>
                                                                                                <td>
                                                                                                    Entrega de Factura
                                                                                                    <input type="text" style="display: none;" id="textPs27" class="form-control input-xsmall" value="Entrega de Factura-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs27" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    8
                                                                                                </td>
                                                                                                <td>
                                                                                                    Entrega de Factura
                                                                                                    <input type="text" style="display: none;" id="textPs28" class="form-control input-xsmall" value="Entrega de Factura-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs28" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    9
                                                                                                </td>
                                                                                                <td>
                                                                                                    Asignación de Reemplazo
                                                                                                    <input type="text" style="display: none;" id="textPs29" class="form-control input-xsmall" value="Asignación de Reemplazo-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs29" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    10
                                                                                                </td>
                                                                                                <td>
                                                                                                    Pago de Salarios y Prestaciones
                                                                                                    <input type="text" style="display: none;" id="textPs210" class="form-control input-xsmall" value="Pago de Salarios y Prestaciones-Ejecución">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromPs2(this.id);" onclick="select();" id="puntPs210" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                            <tr style="background-color: lightgrey;">
                                                                                                <td colspan="2">
                                                                                                    <b>Total Promedio</b>
                                                                                                </td>

                                                                                                <td >
                                                                                                    <input type="hidden" style="text-align: center;"  id="puntPsTot2Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                    <input type="text" style="text-align: center;"  id="puntPsTot2" disabled="" class="form-control input-xsmall" value="0">
                                                                                                </td>

                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END SAMPLE TABLE PORTLET-->
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                        <div class="portlet box purple">
                                                                            <div class="portlet-title">
                                                                                <div class="caption">
                                                                                    <i class="fa fa-check"></i>Evaluación Total
                                                                                </div>
                                                                                <div class="tools">
                                                                                    <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                    </a>

                                                                                </div>
                                                                            </div>
                                                                            <div class="portlet-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="dashboard-stat red-intense">
                                                                                            <div class="visual">
                                                                                                <i class="fa fa-bar-chart-o"></i>
                                                                                            </div>
                                                                                            <div class="details">
                                                                                                <div class="number" id="Lab_PromTotalPsTot">
                                                                                                    0
                                                                                                </div>
                                                                                                <div class="desc">
                                                                                                    Evaluación Total
                                                                                                </div>
                                                                                                <input type="text" style="display: none;" id="text_PsTotal" class="form-control input-xsmall" value="0">
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                        <!-- END SAMPLE TABLE PORTLET-->
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--Suminitro y Adquisición-->
                                            <div class="tab-pane fade" id="tab_3">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Suminitro y Adquisición
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
                                                                        <p style="font-weight: bold; font-size: 20px;text-align: center;" class="control-label"> Puntajes:   <b>2 = Malo  &nbsp;&nbsp;&nbsp;&nbsp;   3 = Regular	&nbsp;&nbsp;&nbsp;&nbsp;  4 = Bueno   &nbsp;&nbsp;&nbsp;&nbsp;  5 = Excelente </b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box red">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios Cumplimiento Y Oportunidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Oportunidad En La Entrega De Bienes
                                                                                                <input type="text" style="display: none;" id="textSa11" class="form-control input-xsmall" value="Oportunidad En La Entrega De Bienes-Cumplimiento">
                                                                                            </td>
                                                                                            <td >
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa1(this.id);" onclick="select();" id="puntSa11" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Cantidades De Entrega De Bienes
                                                                                                <input type="text" style="display: none;" id="textSa12" class="form-control input-xsmall" value="Cantidades De Entrega De Bienes-Cumplimiento">
                                                                                            </td>
                                                                                            <td style="text-align: center;">
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa1(this.id);"  onclick="select();" id="puntSa12" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Tiempo De Respuesta A Requerimientos
                                                                                                <input type="text" style="display: none;" id="textSa13" class="form-control input-xsmall" value="Tiempo De Respuesta A Requerimientos-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa1(this.id);"  onclick="select();" id="puntSa13" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Oportunidad en la Entrega de Documentos
                                                                                                <input type="text" style="display: none;" id="textSa14" class="form-control input-xsmall" value="Oportunidad en la Entrega de Documentos-Cumplimiento">
                                                                                            </td>
                                                                                            <td style="text-align: center;">
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa1(this.id);"  onclick="select();" id="puntSa14" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntSaTot1Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"  id="puntSaTot1" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </div>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box blue">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios En La Ejecución Del Contrato
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Atención de requerimientos
                                                                                                <input type="text" style="display: none;" id="textSa21" class="form-control input-xsmall" value="Atención de requerimientos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromSa2(this.id);" onclick="select();" id="puntSa21" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Atención de reclamos
                                                                                                <input type="text" style="display: none;" id="textSa22" class="form-control input-xsmall" value="Atención de reclamos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromSa2(this.id);" onclick="select();" id="puntSa22" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Suministro de repuestos e insumos
                                                                                                <input type="text" style="display: none;" id="textSa23" class="form-control input-xsmall" value="Suministro de repuestos e insumos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromSa2(this.id);" onclick="select();" id="puntSa23" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Almacenamiento y bodegaje
                                                                                                <input type="text" style="display: none;" id="textSa24" class="form-control input-xsmall" value="Almacenamiento y bodegaje-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromSa2(this.id);" onclick="select();" id="puntSa24" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                5
                                                                                            </td>
                                                                                            <td>
                                                                                                Servicio postventa
                                                                                                <input type="text" style="display: none;" id="textSa25" class="form-control input-xsmall" value="Servicio postventa-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromSa2(this.id);" onclick="select();" id="puntSa25" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                6
                                                                                            </td>
                                                                                            <td>
                                                                                                Entrega de factura
                                                                                                <input type="text" style="display: none;" id="textSa26" class="form-control input-xsmall" value="Entrega de factura-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;"  maxlength="1" onchange="$.CalPromSa2(this.id);" onclick="select();" id="puntSa26" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntSaTot2Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"  id="puntSaTot2" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box green">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios De Calidad Del Bien O Servicio
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Satisfacción del bien o servicio
                                                                                                <input type="text" style="display: none;" id="textSa31" class="form-control input-xsmall" value="Satisfacción del bien o servicio-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa3(this.id);" onclick="select();" id="puntSa31" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Devoluciones, cambios de mercancía y garantías
                                                                                                <input type="text" style="display: none;" id="textSa32" class="form-control input-xsmall" value="Devoluciones, cambios de mercancía y garantías-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa3(this.id);" onclick="select();" id="puntSa32" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Funcionamiento
                                                                                                <input type="text" style="display: none;" id="textSa33" class="form-control input-xsmall" value="Funcionamiento-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromSa3(this.id);" onclick="select();" id="puntSa33" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>

                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntSaTot3Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"  onclick="select();" id="puntSaTot3" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box purple">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Evaluación Total
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="dashboard-stat red-intense">
                                                                                        <div class="visual">
                                                                                            <i class="fa fa-bar-chart-o"></i>
                                                                                        </div>
                                                                                        <div class="details">
                                                                                            <div class="number" id="Lab_PromTotalSaTot">
                                                                                                0
                                                                                            </div>
                                                                                            <div class="desc">
                                                                                                Evaluación Total
                                                                                            </div>
                                                                                            <input type="text" style="display: none;" id="text_SaTotal" class="form-control input-xsmall" value="0">
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--Contrato Arrendamiento-->
                                            <div class="tab-pane fade" id="tab_4">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Contrato Arrendamiento
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
                                                                        <p style="font-weight: bold; font-size: 20px;text-align: center;" class="control-label"> Puntajes:   <b>2 = Malo  &nbsp;&nbsp;&nbsp;&nbsp;   3 = Regular	&nbsp;&nbsp;&nbsp;&nbsp;  4 = Bueno   &nbsp;&nbsp;&nbsp;&nbsp;  5 = Excelente </b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box red">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios Cumplimiento y Oportunidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Oportunidad en la Entrega
                                                                                                <input type="text" style="display: none;" id="textCa11" class="form-control input-xsmall" value="Oportunidad en la Entrega-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa1(this.id);" onclick="select();" id="puntCa11" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Funcionamiento
                                                                                                <input type="text" style="display: none;" id="textCa12" class="form-control input-xsmall" value="Funcionamiento-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa1(this.id);" onclick="select();" id="puntCa12" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Tiempo de Respuesta a Requerimientos
                                                                                                <input type="text" style="display: none;" id="textCa13" class="form-control input-xsmall" value="Tiempo de respuesta a requerimientos-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa1(this.id);" onclick="select();" id="puntCa13" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCaTot1Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;" id="puntCaTot1" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box blue">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios en la ejecución del contrato
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Atención de Requerimientos
                                                                                                <input type="text" style="display: none;" id="textCa21" class="form-control input-xsmall" value="Atención de Requerimientos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa2(this.id);" onclick="select();" id="puntCa21" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Atención de Reclamos
                                                                                                <input type="text" style="display: none;" id="textCa22" class="form-control input-xsmall" value="Atención de Reclamos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa2(this.id);" onclick="select();" id="puntCa22" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Entrega de Factura
                                                                                                <input type="text" style="display: none;" id="textCa23" class="form-control input-xsmall" value="Entrega de Factura-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa2(this.id);" onclick="select();" id="puntCa23" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>

                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCaTot2Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"   id="puntCaTot2" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box green">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios de calidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Conformidad
                                                                                                <input type="text" style="display: none;" id="textCa31" class="form-control input-xsmall" value="Conformidad-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa3(this.id);" onclick="select();" id="puntCa31" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Soporte y Mantenimiento
                                                                                                <input type="text" style="display: none;" id="textCa32" class="form-control input-xsmall" value="Soporte y Mantenimiento-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa3(this.id);" onclick="select();" id="puntCa32" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Funcionamiento
                                                                                                <input type="text" style="display: none;" id="textCa33" class="form-control input-xsmall" value="Funcionamiento-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCa3(this.id);" onclick="select();" id="puntCa33" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>


                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCaTot3Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;" onclick="select();" id="puntCaTot3" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box purple">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Evaluación Total
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="dashboard-stat red-intense">
                                                                                        <div class="visual">
                                                                                            <i class="fa fa-bar-chart-o"></i>
                                                                                        </div>
                                                                                        <div class="details">
                                                                                            <div class="number" id="Lab_PromTotalCaTot">
                                                                                                0
                                                                                            </div>
                                                                                            <div class="desc">
                                                                                                Evaluación Total
                                                                                            </div>
                                                                                            <input type="text" style="display: none;" id="text_CaTotal" class="form-control input-xsmall" value="0">
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--Contrato de consultoría/Merito-->
                                            <div class="tab-pane fade" id="tab_5">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Contrato de consultoría/Merito
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
                                                                        <p style="font-weight: bold; font-size: 20px;text-align: center;" class="control-label"> Puntajes:   <b>2 = Malo  &nbsp;&nbsp;&nbsp;&nbsp;   3 = Regular	&nbsp;&nbsp;&nbsp;&nbsp;  4 = Bueno   &nbsp;&nbsp;&nbsp;&nbsp;  5 = Excelente </b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box red">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios Cumplimiento y Oportunidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Oportunidad en la entrega de los productos
                                                                                                <input type="text" style="display: none;" id="textCc11" class="form-control input-xsmall" value="Oportunidad en la entrega de los productos-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc1(this.id);" onclick="select();" id="puntCc11" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Cobertura del servicio
                                                                                                <input type="text" style="display: none;" id="textCc12" class="form-control input-xsmall" value="Cobertura del servicio-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc1(this.id);" onclick="select();" id="puntCc12" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Tiempo de respuesta a requerimientos
                                                                                                <input type="text" style="display: none;" id="textCc13" class="form-control input-xsmall" value="Tiempo de respuesta a requerimientos-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc1(this.id);" onclick="select();" id="puntCc13" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento del plan de trabajo
                                                                                                <input type="text" style="display: none;" id="textCc14" class="form-control input-xsmall" value="Cumplimiento del plan de trabajo-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc1(this.id);" onclick="select();" id="puntCc14" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                5
                                                                                            </td>
                                                                                            <td>
                                                                                                Entrega de la totalidad de los productos
                                                                                                <input type="text" style="display: none;" id="textCc15" class="form-control input-xsmall" value="Entrega de la totalidad de los productos-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc1(this.id);" onclick="select();" id="puntCc15" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCcTot1Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;" id="puntCcTot1" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box blue">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios en la ejecución del contrato
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Presentación de informes de avance
                                                                                                <input type="text" style="display: none;" id="textCc21" class="form-control input-xsmall" value="Presentación de informes de avance-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc2(this.id);" onclick="select();" id="puntCc21" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Atención de requerimientos
                                                                                                <input type="text" style="display: none;" id="textCc22" class="form-control input-xsmall" value="Atención de requerimientos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc2(this.id);" onclick="select();" id="puntCc22" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Atención de reclamos
                                                                                                <input type="text" style="display: none;" id="textCc23" class="form-control input-xsmall" value="Atención de reclamos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc2(this.id);" onclick="select();" id="puntCc23" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Disposición de servicio
                                                                                                <input type="text" style="display: none;" id="textCc24" class="form-control input-xsmall" value="Disposición de servicio-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc2(this.id);" onclick="select();" id="puntCc24" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                5
                                                                                            </td>
                                                                                            <td>
                                                                                                Pago de salarios y prestaciones
                                                                                                <input type="text" style="display: none;" id="textCc25" class="form-control input-xsmall" value="Pago de salarios y prestaciones-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc2(this.id);" onclick="select();" id="puntCc25" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>

                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCcTot2Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"   id="puntCcTot2" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box green">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios de calidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Idoneidad de la dirección del proyecto
                                                                                                <input type="text" style="display: none;" id="textCc31" class="form-control input-xsmall" value="Idoneidad de la dirección del proyecto-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc3(this.id);" onclick="select();" id="puntCc31" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Idoneidad del equipo de trabajo
                                                                                                <input type="text" style="display: none;" id="textCc32" class="form-control input-xsmall" value="Idoneidad del equipo de trabajo-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc3(this.id);" onclick="select();" id="puntCc32" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Logística para el desarrollo del proyecto
                                                                                                <input type="text" style="display: none;" id="textCc33" class="form-control input-xsmall" value="Logística para el desarrollo del proyecto-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc3(this.id);" onclick="select();" id="puntCc33" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento de los objetivos del proyecto
                                                                                                <input type="text" style="display: none;" id="textCc34" class="form-control input-xsmall" value="Cumplimiento de los objetivos del proyecto-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCc3(this.id);" onclick="select();" id="puntCc34" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>

                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCcTot3Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;" onclick="select();" id="puntCcTot3" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box purple">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Evaluación Total
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="dashboard-stat red-intense">
                                                                                        <div class="visual">
                                                                                            <i class="fa fa-bar-chart-o"></i>
                                                                                        </div>
                                                                                        <div class="details">
                                                                                            <div class="number" id="Lab_PromTotalCcTot">
                                                                                                0
                                                                                            </div>
                                                                                            <div class="desc">
                                                                                                Evaluación Total
                                                                                            </div>
                                                                                            <input type="text" style="display: none;" id="text_CcTotal" class="form-control input-xsmall" value="0">
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--Contrato de consultoría/Merito-->
                                            <div class="tab-pane fade" id="tab_6">

                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Contrato de Obra
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
                                                                        <p style="font-weight: bold; font-size: 20px;text-align: center;" class="control-label"> Puntajes:   <b>2 = Malo  &nbsp;&nbsp;&nbsp;&nbsp;   3 = Regular	&nbsp;&nbsp;&nbsp;&nbsp;  4 = Bueno   &nbsp;&nbsp;&nbsp;&nbsp;  5 = Excelente </b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box red">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios Cumplimiento y Oportunidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Manejo financiero de los recursos
                                                                                                <input type="text" style="display: none;" id="textCo11" class="form-control input-xsmall" value="Manejo financiero de los recursos-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo1(this.id);" onclick="select();" id="puntCo11" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento en la entrega de la totalidad de los trabajos contratados
                                                                                                <input type="text" style="display: none;" id="textCo12" class="form-control input-xsmall" value="Cumplimiento en la entrega de la totalidad de los trabajos contratados-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo1(this.id);"  onclick="select();" id="puntCo12" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento en la garantía de los trabajos ejecutados y productos entregados.
                                                                                                <input type="text" style="display: none;" id="textCo13" class="form-control input-xsmall" value="Cumplimiento en la garantía de los trabajos ejecutados y productos entregados-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onclick="select(this.id);" onchange="$.CalPromCo1(this.id);"  id="puntCo13" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento del recurso humano propuesto
                                                                                                <input type="text" style="display: none;" id="textCo14" class="form-control input-xsmall" value="Cumplimiento del recurso humano propuesto-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onclick="select(this.id);" onchange="$.CalPromCo1(this.id);"  id="puntCo14" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                5
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento de las normas de salud ocupacional y seguridad industrial
                                                                                                <input type="text" style="display: none;" id="textCo15" class="form-control input-xsmall" value="Cumplimiento de las normas de salud ocupacional y seguridad industrial-Cumplimiento">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onclick="select(this.id);" onchange="$.CalPromCo1(this.id);"  id="puntCo15" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCoTot1Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"  id="puntCoTot1" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box blue">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios en la Ejecución del Contrato
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento cronogramas establecidos
                                                                                                <input type="text" style="display: none;" id="textCo21" class="form-control input-xsmall" value="cumplimiento cronogramas establecidos-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" onchange="$.CalPromCo2(this.id);" onclick="select(this.id);" id="puntCo21" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Cumplimiento de las obligaciones con el personal subcontratado
                                                                                                <input type="text" style="display: none;" id="textCo22" class="form-control input-xsmall" value="Cumplimiento de las obligaciones con el personal subcontratado-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo2(this.id);" onclick="select();" id="puntCo22" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                presentación de informes de avance
                                                                                                <input type="text" style="display: none;" id="textCo23" class="form-control input-xsmall" value="Presentación de informes de avance-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onclick="select(this.id);" onchange="$.CalPromCo2(this.id);" id="puntCo23" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Elaboración oportuna de las diferentes actas
                                                                                                <input type="text" style="display: none;" id="textCo24" class="form-control input-xsmall" value="Elaboración oportuna de las diferentes actas-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onclick="select(this.id);" onchange="$.CalPromCo2(this.id);" id="puntCo24" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                5
                                                                                            </td>
                                                                                            <td>
                                                                                                Asistencia a las reuniones o visitas técnicas programadas
                                                                                                <input type="text" style="display: none;" id="textCo25" class="form-control input-xsmall" value="Asistencia a las reuniones o visitas técnicas programadas-Ejecución">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo2(this.id);" onclick="select();" id="puntCo25" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>

                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCoTot2Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"   id="puntCoTot2" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <br>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box green">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Criterios de calidad
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="table-scrollable">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                #
                                                                                            </th>
                                                                                            <th>
                                                                                                Criterios
                                                                                            </th>
                                                                                            <th>
                                                                                                Puntaje
                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                1
                                                                                            </td>
                                                                                            <td>
                                                                                                Colaboración y compromiso con la entidad
                                                                                                <input type="text" style="display: none;" id="textCo31" class="form-control input-xsmall" value="Colaboración y compromiso con la entidad-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo31" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                2
                                                                                            </td>
                                                                                            <td>
                                                                                                Control y seguimiento financiero, administrativo, técnico y legal
                                                                                                <input type="text" style="display: none;" id="textCo32" class="form-control input-xsmall" value="Control y seguimiento financiero, administrativo, técnico y legal-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo32" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                3
                                                                                            </td>
                                                                                            <td>
                                                                                                Calidad en la ejecución de los contratos
                                                                                                <input type="text" style="display: none;" id="textCo33" class="form-control input-xsmall" value="Calidad en la ejecución de los contratos-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo33" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                4
                                                                                            </td>
                                                                                            <td>
                                                                                                Calidad en la mano de obra
                                                                                                <input type="text" style="display: none;" id="textCo34" class="form-control input-xsmall" value="Calidad en la mano de obra-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo34" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                5
                                                                                            </td>
                                                                                            <td>
                                                                                                Calidad de los materiales utilizados
                                                                                                <input type="text" style="display: none;" id="textCo35" class="form-control input-xsmall" value="Calidad de los materiales utilizados-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo35" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                6
                                                                                            </td>
                                                                                            <td>
                                                                                                Calidad en los productos entregados
                                                                                                <input type="text" style="display: none;" id="textCo36" class="form-control input-xsmall" value="Calidad en los productos entregados-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo36" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                7
                                                                                            </td>
                                                                                            <td>
                                                                                                Entrega oportuna de los planos récord, manuales y operatividad
                                                                                                <input type="text" style="display: none;" id="textCo37" class="form-control input-xsmall" value="Entrega oportuna de los planos récord, manuales y operatividad-Calidad">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" style="text-align: center;" maxlength="1" onchange="$.CalPromCo3(this.id);" onclick="select();" id="puntCo37" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>

                                                                                        <tr style="background-color: lightgrey;">
                                                                                            <td colspan="2">
                                                                                                <b>Total Promedio</b>
                                                                                            </td>

                                                                                            <td >
                                                                                                <input type="hidden" style="text-align: center;"  id="puntCoTot3Prom" disabled="" class="form-control input-xsmall" value="0">
                                                                                                <input type="text" style="text-align: center;"  onclick="select();" id="puntCoTot3" disabled="" class="form-control input-xsmall" value="0">
                                                                                            </td>

                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                    <div class="portlet box purple">
                                                                        <div class="portlet-title">
                                                                            <div class="caption">
                                                                                <i class="fa fa-check"></i>Evaluación Total
                                                                            </div>
                                                                            <div class="tools">
                                                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <div class="portlet-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="dashboard-stat red-intense">
                                                                                        <div class="visual">
                                                                                            <i class="fa fa-bar-chart-o"></i>
                                                                                        </div>
                                                                                        <div class="details">
                                                                                            <div class="number" id="Lab_PromTotalCoTot">
                                                                                                0
                                                                                            </div>
                                                                                            <div class="desc">
                                                                                                Evaluación Total
                                                                                            </div>
                                                                                            <input type="text" style="display: none;" id="text_CoTotal" class="form-control input-xsmall" value="0">
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <!-- END SAMPLE TABLE PORTLET-->
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="tab_7">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Análisis del resultado de la evaluación o reevaluación:
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class="col-md-12">
                                                                    <label class='control-label' id="TitAnal1" style="font-weight: bold;padding-top: 10px;">Análisis en el Criterios Cumplimiento y Oportunidad:</label>
                                                                    <textarea id="analisis_cumpli" rows="4"  class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class='control-label' id="TitAnal2" style="font-weight: bold;padding-top: 10px;">Análisis en el Criterios en la Ejecución del Contrato:</label>
                                                                    <textarea id="analisis_ejec" rows="4"  class='form-control' style="width: 100%"></textarea>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label class='control-label' id="TitAnal3" style="font-weight: bold;padding-top: 10px;">Análisis en Criterios de calidad:</label>
                                                                    <textarea id="analisis_calidad" rows="4"  class='form-control' style="width: 100%"></textarea>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="tab_8">
                                                <div class="portlet box purple-intense">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-angle-right"></i>Parametros de Evaluación
                                                        </div>
                                                        <div class="tools">
                                                            <a href="javascript:;" class="collapse"></a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class='col-md-4'>
                                                                    <div class='form-group' >
                                                                        <label class='control-label' for="fecha">% Criterios Cumplimiento y Oportunidad:</label>
                                                                        <input type='text' maxlength="2" onkeypress='return validartxtnum(event)'  placeholder='%' id='PorCO' name='fecha' class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group' >
                                                                        <label class='control-label'>% Criterios en la ejecución del contrato:</label>
                                                                        <input type='text' maxlength="2" onkeypress='return validartxtnum(event)' id='PorCE'  placeholder='%'  value="" class='form-control'  onclick="this.select();" />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group' >
                                                                        <label class='control-label'>% Criterios de calidad:</label>
                                                                        <input type='text' maxlength="2" onkeypress='return validartxtnum(event)' id='PorCC'  placeholder='%' value="" class='form-control'  onclick="this.select();" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="msgae">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                         
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

                                    <div class="form-actions right" id="botones">
                                        <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled=""  id="btn_nuevo"><i class="fa fa-file-o"></i> Nuevo</button>
                                        <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
                                        <button type="button" class="btn blue" id="btn_volver"><i class="fa fa-mail-reply"></i> Volver</button>
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