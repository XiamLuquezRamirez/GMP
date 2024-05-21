<?php
session_start();

putenv('TZ=America/Bogota');

if ($_SESSION['ses_user'] == NULL) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if ($_SESSION['GesParVCom'] == "n") {
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
<html lang="es">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Datos de la Compañia | SGP Gestor Publico de Gobierno</title>
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
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="../Img/favicon.ico" />

        <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../Js/DatosEmpresa.js" type="text/javascript"></script>
        <script src="../Js/UbiMap.js" type="text/javascript"></script>
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
                                <i class="fa fa-cogs"></i>
                                <a href="AdminParametros.php">Parametros Generales</a>
                                <i class="fa fa-circle"></i>
                            </li>

                            <li>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <a href="../Administracion/DatosEmpresa.php">Datos De La Compañia</a>

                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>

                    <div id="ventanaImg" class="modal fade" tabindex="-1">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Imagen Empresa</h4>
                        </div>
                        <div class="modal-body">
                            <div class='row'>
                                <img src="" alt="logo" id="ImgEmpresa" class="logo-default" />

                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" data-dismiss="modal" class="btn red" title="Cerrar"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>


                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Compañias</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" onclick="$.addComp();" data-toggle="tab"  id="atitulo">Crear Compañias</a>
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

                                                                    <div id="tab_companias" style="height: 350px;overflow: scroll;">

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
                                                                        <div id="bot_companias" style="float:right;">
                                                                        </div>

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
                                        <i class="fa fa-angle-right"></i>Información del Contratos
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
                                            <li onclick="initialize()" id="tab_pp2">
                                                <a href="#tab_2" data-toggle="tab"> Localización  </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!--                                Inf. General -->
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class="portlet box blue">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-building"></i> Datos De La Empresa
                                                        </div>
                                                        <div class="tools">
                                                            <a href="javascript:;" class="collapse"></a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="portlet-body form">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="acc" value="1" />
                                                                <input type="hidden" id="perm" value="<?php echo $_SESSION['GesParACom']; ?>" />
                                                                <input type="hidden" id="user" value="<?php echo $_SESSION['ses_user']; ?>" />
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <div class="form-group" id="Form_Tipo_Nit">
                                                                            <label class="control-label">Tipo De Id: <span class="required">* </span></label>
                                                                            <select id="txt_tipo_nit" class="bs-select form-control">
                                                                                <option value=" ">--Seleccione--</option>
                                                                                <option value="NIT">NIT</option>
                                                                                <option value="C.C.">C.C.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group" id="Form_Nit">
                                                                            <label class="control-label">Identificación o Nit:<span class="required">* </span></label>
                                                                            <input type="text" id="txt_nit" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group" id="Form_Razon">
                                                                            <label class="control-label">Razon Social:<span class="required">* </span></label>
                                                                            <input type="text" id="txt_razon_social" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group" id="Form_Rrepre">
                                                                            <label class="control-label">Representante:</label>
                                                                            <input type="text" id="txt_represe" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Departamento:</label>
                                                                            <input type="text" id="txt_depart" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Municipio:</label>
                                                                            <input type="text" id="txt_muni" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dirección:</label>
                                                                            <input type="text" id="txt_direccion" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Tel&eacute;fono:</label>
                                                                            <input type="text" id="txt_telefono" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Fax:</label>
                                                                            <input type="text" id="txt_fax" class="form-control txt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">E-Mail:</label>
                                                                            <input type="text" id="txt_email" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group" id="From_Arch">
                                                                            <label class="control-label">Imagen:</label>
                                                                            <form enctype="multipart/form-data" class="form" id="form">
                                                                                <input type="file" id="archivos" name="archivos" accept="application/" >
                                                                                Tamaño Del Archivo: <span id="fileSize">0</span>
                                                                            </form>
                                                                            <input type="hidden" id="Src_File" class="form-control"  />
                                                                            <input type="hidden" id="Name_File" class="form-control" placeholder="Name_File" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2" id="MostImg" style="display: none;">
                                                                        <div class="form-group">
                                                                            <button type="button" class="btn blue" id="btn_img"><i class="fa fa-search"></i> Ver Imagen</button>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-3">
                                                                        <div class="form-group" id="From_log">
                                                                            <label class="control-label">Login/Sigla:<span class="required">* </span></label>
                                                                            <input type="text"  id="txt_usuusu" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" id="From_cont1">
                                                                            <label class="control-label">Contraseña:<span class="required">* </span></label>
                                                                            <input type="password"  id="txt_usucon1" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" id="From_cont2">
                                                                            <label class="control-label">Repetir Contraseña:<span class="required">* </span></label>
                                                                            <input type="password"  onchange="$.validarcontra2();" id="txt_usucon2" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3" style="display: none;" id="dicont" >
                                                                        <div class="form-group">
                                                                            <label class="control-label"><input type="checkbox"  onclick="$.habcontra();" id="cccont" value="ON" />Cambiar Contrase&ntilde;a</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div id="msgArch">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <!--                                         Localización      -->
                                            <div class="tab-pane fade" id="tab_2">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>2. Localización
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
                                                                        <select class="form-control select2" onchange="$.BusUbiCor()"  disabled id="CbCorre" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Barrio de Ejecución:</label>
                                                                        <select class="form-control select2" onchange="$.BusUbiBar()"  disabled  id="CbBarrio" name="options2">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <p><label>Localización geográfica: </label>
                                                                            <input style="width:400px;display: none;" type="text" id="direccion" name="direccion" value=""/>
                                                                            <button style="display: none;" id="pasar">Obtener coordenadas</button>
                                                                        <div id="map_canvas" style="width:100%;height:400px;"></div>

                                                                        <input type="hidden" readonly name="lat" id="lat"/>
                                                                        <input type="hidden" readonly name="lng" id="long"/>
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
                                                                                        <i class='fa fa-angle-right'></i> Barrio
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-actions right" id="botones">
                                                <button type="button" class="btn green" id="btn_guardar" ><i class="fa fa-check"></i> Guardar</button>
                                                <button type="button" class="btn purple" disabled=""  id="btn_nuevo"><i class="fa fa-file-o"></i> Nuevo</button>
                                                <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
                                                <button type="button" class="btn blue" id="btn_volver"><i class="fa fa-mail-reply"></i> Volver</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msg">
                                                </div>
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
