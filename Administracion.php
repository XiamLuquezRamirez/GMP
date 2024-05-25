<?php
session_start();

putenv('TZ=America/Bogota');

if ($_SESSION['ses_user'] == null) {
    echo "<script>location.href='index.php'</script>";
    exit();
}
//
if (isset($_GET['Logout'])) {
    header("Location:cerrar.php?opc=1");
    session_destroy();
}

include "Conectar.php";
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8" />
        <title>GMP - Gestor Monitoreo Público | Administraci&oacute;n</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="Plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/> -->
        <link href="Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="Plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
        <script src="Plugins/jquery-knob/js/jquery.knob.js"></script>
        <!--
                <link href="Plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet"/>
                <link href="Plugins/jquery-ui/jquery.ui.slider.css" rel="stylesheet"/> -->
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <style>

            .prec123{
                top: 50px;
                position: relative;
                font-size: 40px;
            }

            .circle123{
                position: relative;
                top: 5px;
                left: 5px;
                text-align: center;
                width: 150px;
                height: 150px;
                border-radius: 100% !important;
                background-color: #E6F4F7;
            }

            .active-border123{
                position: relative;
                text-align: center;
                width: 160px;
                height: 160px;
                border-radius: 100%!important;

                /* background-color:#39B4CC; */
                background-image:
                    linear-gradient(0deg, transparent 50%, #A2ECFB 50%),
                    linear-gradient(0deg, #A2ECFB 50%, transparent 50%);
                /* linear-gradient(162deg, transparent 50%, #A2ECFB 50%),
                linear-gradient(90deg, #A2ECFB 50%, transparent 50%); */

            }svg{width:50%;}

            
        </style>
        <link href="Css/Global/css/components.min.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css"/>

        <link href="Css/circle.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="Img/favicon.ico" />
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false" >
        </script>

        <script src="Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="Js/Administracion.js" type="text/javascript"></script>
        <script src="Js/AlertaPolizas.js" type="text/javascript"></script>
        <script src="Js/funciones_generales.js" type="text/javascript"></script>
        <script src="Js/UbiMap.js" type="text/javascript"></script>
        <!--<script src="Js/DashBoard.js" type="text/javascript"></script>-->
       

    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed page-sidebar-fixed">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="Administracion.php">
                        <img src="Img/logo.png" alt="logo" class="logo-default" />
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
                        <?php echo $_SESSION['User_Login']; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div id="VentanaLog" class="modal fade" tabindex="-1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Cambio de Compañia</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" id="compania">
                    <h3 class="form-title">Iniciar Sesi&oacute;n</h3>
                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">Username</label>
                        <div class="input-icon">
                            <i class="fa fa-bank"></i>
                            <input class="form-control  placeholder-no-fix" type="text" autocomplete="off" placeholder="Compañia" id="txt_compa" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">Password</label>
                        <div class="input-icon">
                            <i class="fa fa-lock"></i>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" id="txt_keycomp" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="msg">
                        </div>
                    </div>
                    <div class="form-actions">
                        <!--<button type="button" id="ayuda" class="btn btn-default"><i class="fa fa-info-circle"></i></button>-->

                        <button type="submit" class="btn green pull-right" id="btn_login"> Entrar <li class="m-icon-swapright m-icon-white"></li></button>
                    </div>
                    <br>
                </div>
            </div>

        </div>

        <div class="clearfix"> </div>

        <div class="page-container">
            <input type="hidden" readonly name="lat" id="lat"/>
            <input type="hidden" readonly name="lng" id="long"/>

            <?php echo $_SESSION['Menu_Left']; ?>
            <div class="page-content-wrapper">

                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i style="color: yellow;" class="fa fa-home"></i>
                                <a href="Administracion.php">Inicio</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title">  GMP - Gestor Monitoreo Público | Administraci&oacute;n
                    </h3>
                    <br>

                    <div class="row" id="divAlertas" style='display:none;'>
                        <div class="col-md-12">
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption"><i class="icon-cogs"></i>VENCIMIENTO DE VIGENCIA DE POLIZAS</div>
                                    <div class="tools">
                                        <a href="javascript:;" class="remove hidden-phone"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div  id="VP">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiles">

                        <?php if ($_SESSION['ses_compa'] != "") { ?>

                            <?php if ($_SESSION['GesProyVPr'] == "s") { ?>
                                <div id="btn_Proyectos" class="tile bg-blue">
                                    <div class="tile-body">
                                        <i class="fa fa-th-list"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Proyectos
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['GesProyVCo'] == "s") { ?>
                                <div id="btn_Contratos" class="tile bg-purple">
                                    <div class="tile-body">
                                        <i class="fa fa-th-list"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Contratos
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['GesProyVMe'] == "s") { ?>
                                <div id="btn_Medir" class="tile bg-green-meadow">
                                    <div class="tile-body">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Medir Indicador
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['permplan'] == "s") { ?>
                                <div id="btn_plan" class="tile bg-blue-madison">
                                    <div class="tile-body">
                                        <i class="fa fa-newspaper-o"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Plan De Desarrollo
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['permpara'] == "s") { ?>
                                <div id="btn_para" class="tile bg-red-pink">
                                    <div class="tile-body">
                                        <i class="fa fa-cogs"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Parametros Generales
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['GesUsuVUs'] == "s") { ?>
                                <div id="btn_user" class="tile bg-yellow-gold">
                                    <div class="tile-body">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Gestión de Usuarios
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['GesAvaVPro'] == "s") { ?>
                                <div id="btn_AvProy" class="tile bg-green-meadow">
                                    <div class="tile-body">
                                        <i class="fa fa-cloud-upload"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Avances de Proyectos
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['GesAvaVCont'] == "s") { ?>
                                <div id="btn_AvCont" class="tile bg-blue-madison">
                                    <div class="tile-body">
                                        <i class="fa fa-cloud-upload"></i>
                                    </div>
                                    <div class="tile-object">
                                        <div class="name">
                                            Avances de Cotratos
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        <?php } else { ?>
                            <div id="btn_Comp" class="tile bg-red-pink">
                                <div class="tile-body">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Compañias
                                    </div>
                                </div>
                            </div>
                            <div id="btn_user" class="tile bg-yellow-gold">
                                <div class="tile-body">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Gestión de Usuarios
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>
        <!-- Inicio Ventana Alerta Polizas -->
        <div id="modalFinCon" class="modal fade" tabindex="-1" data-width="980" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-body">
                <div class='portlet box red'>
                    <div class='portlet-title'>
                        <div class='caption'>
                            <!-- <i class='fa fa-angle-right'></i>Notificaciones de las polizas de los contratos -->
                            <h5 class="modal-title" id="modalFinConLabel" style="font-weight: bold;"></h5>
                        </div>
                    </div>
                    <div class='portlet-body'>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-hover table-striped "  style="font-size: 12px;">
                                        <thead class="">
                                            <tr >
                                                <th scope="col" style="width: 5%">#</th>
                                                <th style="width: 12%;text-align:center;"># Contrato</th>
                                                <th style="width: 33%">Objeto</th>
                                                <th style="width: 8%">Inicio</th>
                                                <th style="width: 8%">Fin</th>
                                                <th style="width: 10%;text-align:center;"># Poliza</th>
                                                <th style="width: 12%">Inicio Poliza</th>
                                                <th style="width: 18%">Fin Poliza</th>
                                                <!-- <th style="width: 7%">Estado</th> -->
                                                <th style="width: 9%;text-align:center;">Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenido">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn green btn-sm">
                    <i class='fa fa-close'></i> Cerrar
                </button>
            </div>
        </div>

        <!-- Inicio Ventana DashBoard -->
        <div id="Dashboar" class="modal container fade" tabindex="-1">
            <div class="modal-body">
                <div class='portlet box purple'>
                    <div class='portlet-title' >
                        <div class='caption'>
                            <h3 class="modal-title" style="font-weight: bold;text-align:center;">
                                DASHBOARD DE SEGUIMIENTO - GESTIÓN DE MONITOREO PÚBLICO 
                            </h3>
                        </div>
                    </div>
                    <div class='portlet-body'>

                        <div class="tabbable tabbable-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1p" data-toggle="tab">Inicio</a></li>
                                <li style="display: none;"><a href="#tab_2p" data-toggle="tab">Gestión de Contratos</a></li>
                                <li style=""><a onclick="$.AbrirPara();" data-toggle="tab">Parametros de Busqueda</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row" id="nodatos" style="display:none;">
                                        <div   class="col-md-12 " id="cbx_5">
                                            <h4>NO EXISTE INFORMACIÓN RELACIONADA A LOS PARAMETRSO DE BUSQUEDA SELECCIONADOS</h4>  
                                        </div>
                                    </div>
                                    <div class="row" id="sidatos">

                                        <div class="col-md-5"  id="cbx_5">
                                            <div class="clearfix">
                                                <div class="panel panel-primary">

                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Ubicación Proyectos</h3>
                                                        <div class="tools">
                                                            <a href="javascript:;" class="collapse"></a>
                                                        </div>
                                                    </div>
                                                    <div id="map_canvas" style="width:100%;height:300px;"></div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="row">
                                                <div class='portlet box purple'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Presupuesto Total: <b><label id="Presupuesto"></label></b>
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <div class='form-body'>
                                                            <div class="row" style="width:100%;height:255px; display: flex; align-items: center; justify-content: space-between; ">

                                                                <div class="col-md-4" style='text-align:center;'>
                                                                  
                                                                        <div id="activeBorder1" class="active-border123">
                                                                            <div id="circle1" class="circle123">
                                                                                <span class="prec123 " id="prec1" valor='5'></span>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    <div class="desc" style='text-align:center;font-weight:bold;font-size:12px;margin-top: 10px;'>% Presupuesto Comprometido <br>(<i class='fa fa-dollar'></i> <label id="vprecomp"></label>)</div>
                                                                </div>
                                                                <div class="col-md-4" style='text-align:center;'>
                                                                 
                                                                        <div id="activeBorder2" class="active-border123">
                                                                            <div id="circle2" class="circle123">
                                                                                <span class="prec123 " id="prec2" valor='7'></span>
                                                                            </div>
                                                                        </div>
                                                                
                                                                    <div class="desc" style='text-align:center;font-weight:bold;font-size:12px;margin-top: 10px;'>% Presupuesto Gastado <br>(<i class='fa fa-dollar'></i> <label id="vpregat"></label>)</div>
                                                                </div>
                                                                <div class="col-md-4" style='text-align:center;'>
                                                              
                                                                        <div id="activeBorder3" class="active-border123">
                                                                            <div id="circle3" class="circle123">
                                                                                <span class="prec123 " id="prec3" valor='8'></span>
                                                                            </div>
                                                                        </div>
                                                               
                                                                    <div class="desc" style='text-align:center;font-weight:bold;font-size:12px;margin-top: 10px;'>% Presupuesto no Afectado <br>(<i class='fa fa-dollar'></i> <label id="vprenafec"></label>)</div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>



                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Presupuesto Comprometido por Secretarias 
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <div class='form-body'>
                                                            <div class="row">
                                                                <div class='form-body' id='LisSecr' style="height: 62vh; max-height: 62vh; overflow: auto;">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-md-7">

                                                <div class='portlet box red-intense'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Proyectos por Estado
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <div class='form-body'>
                                                            <div class="row">
                                                                <div class='form-body' >
                                                                    <div id='ProyxEst' style="width: 100%;  height: 55vh;max-height: 55vh;overflow: auto;">

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
                                                <div class='portlet box red'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Presupuesto Comprometido vs Gastado 
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <div class='form-body'>
                                                            <div class="row">
                                                                <div class='form-body' >
                                                                    <div id='LisCompxGast' style="width: 100%;  height: 300px;">

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
                                <div class="tab-pane" id="tab_2">
                                    <p>Plan de Desarrollo</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn green btn-sm">
                    <i class='fa fa-close'></i> Cerrar
                </button>
            </div>
        </div>
        <div id="ParBusq" class="modal container fade" tabindex="-1">
            <div class='portlet box blue '>
                <div class='portlet-title'>
                    <div class='caption'>
                        <i class='fa fa-angle-right'></i>Parametros de Busqueda
                    </div>
                    <div class='tools'>
                        <a href='javascript:;' class='collapse'></a>
                    </div>
                </div>
                <div class='portlet-body form'>
                    <input type="hidden" id="contPobla" style="padding-top: 5px; padding-bottom: 5px;" value="0" />
                    <div class='form-body'>
                        <div class='row'>
                            <div class='col-md-8' >
                                <div class='form-group' style="margin-bottom:0px;margin-top: 0px;" >
                                    <label class='control-label'>Secretaria:</label>
                                    <select class="form-control select2"  id="CbSecre"  name="options2">

                                    </select>
                                </div>
                            </div>
                            <div class='col-md-4' >
                                <div class='form-group' style="margin-bottom:5px;margin-top: 0px;">
                                    <label class='control-label'>Vigencia:</label>
                                    <select class="form-control select2" id="CbVigencia"  name="options2">
                                        <option value=" ">Todas...</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-6' >
                                <div class='form-group' style="margin-bottom:0px;">
                                    <label class='control-label'>Eje:</label>
                                    <select class="form-control select2"  id="CbEje"  name="options2">

                                    </select>
                                </div>
                            </div>
                            <div class='col-md-6' >
                                <div class='form-group' style="margin-bottom:0px;">
                                    <label class='control-label'>Fuente de Financiación::</label>
                                    <select class="form-control select2"  id="CbFFinanc"  name="options2">

                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="$.BuscarDashBoard();" data-dismiss="modal" class="btn blue btn-sm">
                                <i class='fa fa-search'></i> Buscar
                            </button>
                        </div>

                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn green btn-sm">
                    <i class='fa fa-close'></i> Cerrar
                </button>
            </div>
        </div>

        <!-- Inicio Ventana DashBoard -->


        <?php echo $_SESSION['Footer']; ?>

        <!-- BEGIN CORE PLUGINS -->
        <script src="Plugins/jquery.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="Plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="Plugins/moment.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js" type="text/javascript"></script>
        <script src="Plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="Plugins/select2/js/select2.full.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="Css/Global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="Plugins/Scripts/components-bootstrap-select.js" type="text/javascript"></script>
        <script src="Plugins/Scripts/components-select2.js" type="text/javascript"></script>
        <script src="Plugins/Scripts/components-date-time-pickers.js" type="text/javascript"></script>
        <script src="Plugins/Scripts/form-samples.js" type="text/javascript"></script>
        <script src="Plugins/Scripts/form-input-mask.js" type="text/javascript"></script>
        <script src="Plugins/Scripts/ui-extended-modals.js" type="text/javascript"></script>
        <!-- <script src="Plugins/jquery-knob/js/jquery.knob.js"></script>
        <script src="Plugins/ui-sliders.js"></script> -->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="Css/Layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="Css/Layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="Css/Layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script src="Js/amchart/core.js"></script>
        <script src="Js/amchart/charts.js"></script>
        <script src="Js/amchart/themes/animated.js"></script>
        <script src="Js/amchart/themes/dataviz.js"></script>

        <!-- END THEME LAYOUT SCRIPTS -->
    </body>
</html>
