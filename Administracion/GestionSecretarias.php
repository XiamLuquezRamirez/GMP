<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}


if ($_SESSION['GesParVSec'] == "n") {
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
        <title> Gestión de Secretarias | SGP Gestor Publico de Gobierno</title>
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

        <link rel="stylesheet" href="../Css/colorpicker/colorpicker.css">

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
        <script src="../Js/accounting.min.js" type="text/javascript"></script>
        <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../Js/GestionSecre.js" type="text/javascript"></script>
        <script src="../Js/funciones_generales.js" type="text/javascript"></script>
        <script src="../Js/Fuentes.js" type="text/javascript"></script>

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
                                <a href="GestionSecretarias.php">Gestión de Secretarias </a>

                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> </h3>


                    <div id="ventanaImg" class="modal fade" tabindex="-1" data-width="760">
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
                                                        <img src="" alt="Imagen" style="height: 500px; width: 100%;" >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="responsive" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Datos de la Secretaria</h4>
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
                                                <div class='form-group' id="From_Codigo">
                                                    <input type="hidden" id="acc" value="1" />
                                                    <input type="hidden" id="accProc" value="1" />
                                                    <input type="hidden" id="txt_id" value="1" />
                                                    <input type="hidden" id="txt_idProc" value="" />
                                                    <label class='control-label'>Código:</label><span class="required">* </span>

                                                    <input type='text' id='txt_Cod' class='form-control' />
                                                </div>
                                            </div>
                                            <div class='col-md-8'>
                                                <div class='form-group' id="From_Descripcion">
                                                    <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                    <input type='text'   id='txt_Desc' class='form-control'/>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Responsable:</label>
                                                    <select class="form-control select2" onchange="$.BuscInfResp(this.value)"  data-placeholder="Seleccione..."  id="CbResponsables" name="options2">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Correo Electronico:</label>
                                                    <input type='text'   id='txt_Corre' class='form-control'/>
                                                </div>
                                            </div>

                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación:</label>
                                                    <textarea id="txt_obser" rows="2" class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group" id="From_Arch">
                                                    <label class="control-label">Imagen:<span class="required">* </span></label>
                                                    <form enctype="multipart/form-data" class="form" id="form">
                                                        <input type="file" id="archivos" name="archivos" accept="application/" >
                                                        Tamaño Del Archivo: <span id="fileSize">0</span>
                                                    </form>
                                                    <input type="hidden" id="Src_File" class="form-control"  />
                                                    <input type="hidden" id="Name_File" class="form-control" placeholder="Name_File" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="colorpicker-inner ts-forms mg-b-23">
                                                    <div class="tsbox">
                                                        <label class="control-label">Color Representativo:</label>
                                                        <label class="color-group" for="hex4">
                                                            <input type="text" class='form-control' placeholder="#ff0000" id="hex4">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" id="MostImg" style="display: none;">
                                                <div class="form-group">
                                                    <button type="button" class="btn blue" id="btn_img"><i class="fa fa-search"></i> Ver Imagen</button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="msg">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-actions right" id="mopc" >
                                            <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                            <?php
                                            if ($_SESSION['GesParASec'] == "s") {
                                                echo '<button type="button" class="btn purple" disabled id="btn_nuevo2"><i class="fa fa-file-o"></i> Nuevo</button>';
                                            }
                                            ?>
                                            <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-close"></i> Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- GESTIÓN DE PROCESOS--> 
                    <div id="ModalProcesos" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Gestión de Procesos</h4>
                        </div>
                        <div class="modal-body">
                            <div class='row'>

                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <label class='control-label'>Descripción:</label>
                                        <input type='text' id='txt_DesProc'   value="" class='form-control'/>

                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <label class='control-label'>Clase de proceso:</label>
                                        <select class='form-control' id="CbClaPro" name="options2">
                                            <option value=" ">Select...</option>
                                            <option value="Apoyo">Apoyo</option>
                                            <option value="Gestión">Gestión</option>
                                        </select>

                                    </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='form-group'>
                                        <label class='control-label'>Objetivo del Proceso:</label>
                                        <textarea id="txt_ObjetivoPro" rows="1" class='form-control' style="width: 100%"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="msgProc">
                                        </div>
                                    </div>
                                </div>

                                <div class='col-md-12' style="text-align: right">
                                    <div class='form-group' >
                                        <a onclick="$.AddProceso()" class="btn green-meadow">
                                            <i class="fa fa-plus-circle"></i> Agregar
                                        </a>
                                    </div>
                                </div>


                                <div class='col-md-12' style="height: 200px;overflow: scroll;">
                                    <div class='form-group'>
                                        <table class='table table-striped table-hover table-bordered' id="tb_Procesos">
                                            <thead>
                                                <tr>
                                                    <td>
                                                        <i class='fa fa-angle-right'></i> #
                                                    </td>
                                                    <td>
                                                        <i class='fa fa-angle-right'></i> Descripción
                                                    </td>
                                                    <td>
                                                        <i class='fa fa-angle-right'></i> Clase
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


                    <div id="modalPresupuestar" class="modal fade" tabindex="-1" data-width="860" style='height: 660px;'>
                        <div class="modal-body">
                            <div class="row">
                                <div class='col-md-12'>
                                    <div class="portlet box red">
                                        <div class="portlet-title">
                                            <div class="caption"><i class="icon-cogs"></i><span id='nomSecretaria'>Datos de la Secretaria</span></div>
                                            <div class="tools">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                        </div>
                                        <div class='portlet-body form'>
                                            <hr>
                                            <div class="row">
                                                <div class='col-md-12'>
                                                    <!-- TAB -->
                                                    <div class="tabbable tabbable-custom">
                                                        <ul class="nav nav-tabs">                                                        
                                                            <li class="active"><a href="#tab_2p" data-toggle="tab">Total</a></li>
                                                            <li><a href="#tab_1p" data-toggle="tab">Presupuestar</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane" id="tab_1p">
                                                                <div class='form-body'>
                                                                    <!-- <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class='row'>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div id="msgAgrePre">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class='row'>
                                                                                <div class='form-group col-md-5' id="From_Fuente">
                                                                                    <input type='hidden' id='id_secretaria' name='id_secretaria' value='0'>
                                                                                    <label class='control-label' for="fuente">Fuente:<span class="required">* </span></label>
                                                                                    <select class='form-control clasesCombos' id="fuente" name="fuente">
                                                                                        <option value='' >(Seleccione)</option>
                                                                                        <?php
                                                                                        $link = conectar();
                                                                                        $sql = "SELECT * FROM fuentes WHERE estado='ACTIVO'";
                                                                                        $consulta = mysqli_query($link, $sql);
                                                                                        while ($resp = $consulta->fetch_assoc()) {
                                                                                            echo "<option value='" . $resp['id'] . "' >" . $resp['nombre'] . "</option>";
                                                                                        }
                                                                                        mysqli_close($link);
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group' id="From_Fecha">
                                                                                        <label class='control-label' for="fecha">Fecha:<span class="required">* </span></label>
                                                                                        <input type='text'  placeholder='Fecha' id='fecha' name='fecha' class='form-control' readonly style='background-color:white;'/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-3'>
                                                                                    <div class='form-group' id="From_Valor">
                                                                                        <label class='control-label'>Valor:<span class="required">* </span></label>
                                                                                        <input type='text' id='valor' onkeypress="return check(event)" value="" class='form-control'  onclick="this.select();"  style='text-align:right;'/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-1'>
                                                                                    <div class='form-group' id="From_Boton">
                                                                                        <label class='control-label'>&nbsp;</label>
                                                                                        <a class='btn btn-warning btn-sm btnAgregar' title='Agregar'><i class='fa fa-plus'></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class='row'>
                                                                                <div class="col-md-12" style='width:100%;overflow-y: auto !important;;height:200px '>
                                                                                    <form id="formPresupuestar" name='formPresupuestar' method="POST" action="">
                                                                                        <input type='hidden' value='GUARDAR' id="OPCION" name='OPCION'>
                                                                                        <table class="table-bordered table-striped table-condensed cf" style='width:100%;'>
                                                                                            <thead class="cf">
                                                                                                <tr>
                                                                                                    <th>Fuente</th>
                                                                                                    <th>Fecha</th>
                                                                                                    <th style='text-align:right;'>Valor</th>
                                                                                                    <th>Opciones</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody id='detalle_presupuestar'>
                                                                                            </tbody>
                                                                                        </table>                                                                     
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            <div class='row'>
                                                                                <div class="col-md-12">
                                                                                    <table class="table-bordered table-striped table-condensed cf" style='width:100%;'>   
                                                                                        <tr>
                                                                                            <td colspan="2">
                                                                                                <input type="text" class="form-control" readonly value="Total" style='text-align: right;font-size:16px;font-weight: bold;background-color:white;'>
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" class="form-control" readonly value="$ 0.00" style='text-align: right;font-size:16px;font-weight: bold;background-color:white;' id="txtTotal">
                                                                                            </td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>                                                                        
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="" style='text-align:center;' id="botones">
                                                                        <button type="button" class="btn green" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                                                        <button type="button" class="btn red" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Cancelar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane active" id="tab_2p">
                                                                <div class='row'>
                                                                    <div class="col-md-12">
                                                                        <table class="table-bordered table-striped table-condensed cf" style='width:100%;'>   
                                                                            <thead class="cf">
                                                                                <tr>
                                                                                    <th>Fuente</th>
                                                                                    <th style='text-align:right;'>Valor</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id='detalle_grantotal'>
                                                                            </tbody>                                                                                                                                    
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class='row'>
                                                                    <div class="col-md-12">
                                                                        <table class="table-bordered table-striped table-condensed cf" style='width:100%;'>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td >
                                                                                        <input type="text" class="form-control" readonly value="Total" style='text-align: right;font-size:16px;font-weight: bold;background-color:white;'>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" readonly value="$ 0.00" style='text-align: right;font-size:16px;font-weight: bold;background-color:white;' id="txtTotal2">
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>                                                            
                                                            </div>                                                        
                                                        </div>
                                                    </div>
                                                    <!-- TAB -->    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- stackable -->

                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet box blue-soft">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Gestión de Secretaria.
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">

                            <div class="form-body">

                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab_1">
                                        <p>
                                        <div class='portlet box blue'>

                                            <div class='portlet-body form'>

                                                <div class='form-body'>

                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <div id="sample_1_filter" class="dataTables_filter">
                                                                <label>
                                                                    Busqueda:
                                                                    <input class="form-control input-small input-inline" onkeypress="$.busqDepen(this.value);" onchange="$.busqDepen(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                </label>
                                                                <div style="float: right;">
                                                                    <?php
                                                                    if ($_SESSION['GesParASec'] == "s") {
                                                                        echo '<button type="button" class="btn purple"  id="btn_nuevo1"><i class="fa fa-file-o"></i> Nuevo</button>';
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>

                                                            <div class="table-scrollable">

                                                                <div id="tab_Secre" style="height: 250px;overflow: scroll;">

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
                                                                    <div id="bot_Secre" style="float:right;">
                                                                    </div>

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
                            </div>


                            <!-- END FORM-->
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

        <!-- colorpicker JS
     ============================================ -->
        <script src="../js/colorpicker/jquery.spectrum.min.js"></script>
        <script src="../js/colorpicker/color-picker-active.js"></script>
        <!-- datapicker JS
                    ============================================ -->

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
