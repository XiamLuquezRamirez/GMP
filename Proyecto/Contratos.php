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

include "../Conectar.php";
$link = conectar();
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Gestión de Contratos | GMP - Gestor Monitoreo Público</title>
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
    <script src="../Js/sweetalert2.all.min.js"></script>
    <link href="../Css/Global/css/sweetalert2.min.css" rel="stylesheet">

    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../Js/Contratos.js" type="text/javascript"></script>
    <script src="../Js/funciones_generales.js" type="text/javascript"></script>
    <script src="../Js/UbiMap.js" type="text/javascript"></script>
    <script src="../Js/Polizas.js" type="text/javascript"></script>
    <style>
        /* Estilo personalizado para asegurarse de que el z-index sea alto */
        .swal2-container {
            z-index: 10052 !important;
        }

        div:where(.swal2-container).swal2-center>.swal2-popup {

            border-radius: 5px !important;
        }

        div:where(.swal2-icon).swal2-warning.swal2-icon-show {
            border-radius: 50% !important;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            border-radius: 5px !important;
        }

        .opciones {
            display: flex;
            flex-direction: column;
            margin: 5px;
        }

        .opciones a {
            margin-bottom: 3px;
            transition: all .5s ease;
        }

        .opciones a:hover {
            transform: translateX(3px);
        }

        thead {
            background-color: #f9f9f9;
            /* Fondo del encabezado */
            position: sticky;
            /* Posición pegajosa */
            top: 0;
            /* Fijo en la parte superior */
            z-index: 1;
            /* Asegurarse de que el encabezado esté por encima del contenido */
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
                            <a href="../Administracion.php">Administración</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <i style="color: yellow;" class="fa fa-star"></i>
                            <a href="../Proyecto/Contratos.php">Gestión de Contratos</a>

                        </li>
                    </ul>
                </div>

                <h3 class="page-title"> </h3>

                <div id="modalMensaje" class="modal fade" tabindex="-1">

                    <div class="modal-header">
                        <button type="button" class="close" onclick="$.cancelCambEst();" aria-hidden="true"></button>
                        <h4 class="modal-title"><b>Confirmación</b></h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Si cambia al estado <b>Comprobado</b> no se podra realizar ninguna modificacion de este Contrado. <br> <b>Desea Continuar la Operación?</b>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$.cancelCambEst();" class="btn default">Cancelar</button>
                        <button type="button" data-dismiss="modal" class="btn green">Continuar</button>
                    </div>
                </div>

                <!-- ventana  detalle Historia contrato -->
                <div id="ventanaHistContrato" class="modal fade" tabindex="-1" data-width="900">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Detalles del Contrato</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="overflow-y: scroll; height: 400px;">
                            <div class='portlet-body form'>
                                <div class='form-body'>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label"># de Contrato:</label>
                                                <p id="NumContr" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fecha de Modificación:</label>
                                                <p id="FecModif" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Estado:</label>
                                                <p id="EstadoEje" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">% de Avance del contrato:</label>
                                                <p id="Avance" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Tipologia:</label>
                                                <p id="Tipolog" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Link SECOP</label>
                                                <div id="secop" style="color: #e02222; margin: 0px 0"></div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Objeto:</label>
                                                <p id="Objeto" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Contratista:</label>
                                                <p id="Contrat" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Supervisor:</label>
                                                <p id="Superv" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Interventor:</label>
                                                <p id="Interv" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Valor del Contrato:</label>
                                                <p id="ValCont" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Adicion del Contrato:</label>
                                                <p id="AddCont" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Valor Final:</label>
                                                <p id="ValFin" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Valor Ejecutado:</label>
                                                <p id="ValEje" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Forma de Pago:</label>
                                                <p id="FormPag" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Duración del Contrato:</label>
                                                <p id="DurContr" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Inicio:</label>
                                                <p id="FecIni" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fec. de Suspensión:</label>
                                                <p id="FecSusp" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fecha de Reinicio:</label>
                                                <p id="FecReini" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Prorroga:</label>
                                                <p id="Prorroga" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">F. de Finalización:</label>
                                                <p id="FecFina" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fecha de Recibo:</label>
                                                <p id="FecRein" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="control-label">Proyecto Asociado:</label>
                                                <p id="ProyectAsoc" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label class="control-label">% Equivalente en Proyecto:</label>
                                                <p id="Equiv" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="control-label">Observación:</label>
                                                <p id="Observ" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="DocAdjunto">
                                            <div class="form-group">
                                                <label class="control-label">Documento Adjunto:</label>
                                                <div id="docuAdj"></div>
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

                <div id="Porncentajes" class="modal fade" tabindex="-1" data-width="600">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Porcentajes de Contratos en el Proyecto</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>
                                <form action='#' id="formnot" class='horizontal-form'>
                                    <div class='form-body'>
                                        <div class='row'>
                                            <div class="table-scrollable">
                                                <input type="hidden" id="contPorcentajes" class="form-control" />

                                                <table class='table table-striped table-hover table-bordered' id="tab_PorcCont">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Contrato
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Porcentaje
                                                            </td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgPorc">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions right">
                                            <button type="button" class="btn green" data-dismiss="modal" id="btn_guardarAnio"><i class="fa fa-check"></i> Aceptar</button>

                                        </div>

                                    </div>
                                    </from>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ventana Justificacion Atraso-->
                <div id="ventanaJustAtraso" class="modal fade" tabindex="-1" data-width="900">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Justificar Atraso de Contrato</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="overflow-y: scroll; height: 400px;">
                            <div class='portlet-body form'>
                                <div class='form-body'>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label"># de Contrato:</label>
                                                <p id="NumContrJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">% de Avance del contrato:</label>
                                                <p id="AvanceJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Objeto:</label>
                                                <p id="ObjetoJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Contratista:</label>
                                                <p id="ContratJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Supervisor:</label>
                                                <p id="SupervJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Interventor:</label>
                                                <p id="IntervJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Duración del Contrato:</label>
                                                <p id="DurContrJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Inicio:</label>
                                                <p id="FecIniJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">F. de Finalización:</label>
                                                <p id="FecFinaJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Proyecto Asociado:</label>
                                                <p id="ProyectAsocJust" style="color: #e02222; margin: 0px 0"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Justificar:</label>
                                                <textarea id="txt_JustAtraso" rows="2" class='form-control' style="width: 100%"></textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display: none;" id="DivEvid">
                                            <label class="control-label">Evidencias Agregadas</label>
                                            <div id="DivDetEvid">

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Anexar Pruebas</label>
                                                <input type="file" multiple="" id="anexo_justAtra" name="anexo_justAtra" accept="image/jpeg,image/png,application/pdf">
                                                Tamaño Del Archivo: <span id="fileSizeJustAtr">0</span></p>
                                                <input type="hidden" id="Src_FilJustAtr" class="form-control" />
                                                <input type="hidden" id="Name_FileJustAtr" class="form-control" placeholder="Name_File" />

                                                <p class="help-block">
                                                    <span class="label label-danger">
                                                        NOTA: </span>
                                                    &nbsp; El Tamaño Del Anexo No Puede Ser Mayor De 20MB, Y Solo Extensiones .pdf,jpeg,png
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgArchJusti">
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
                            <div id="msgJusti">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$.GuardarJustAtraso()" class="btn blue" title="Guardar"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>

                <!-- Ventana Imagenes -->
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
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin Ventana Imagenes -->
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
                                                <select class="form-control" id="CbPersonaC">
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
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_NombC' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label class='control-label'>Telefono:</label>
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' onkeypress='return validartxtnum(event)' id='txt_TelC' class='form-control' />

                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                <label class='control-label'>Dirección:</label>
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_DirecC' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                <label class='control-label'>Correo:</label>
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_CorreoC' class='form-control' />
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
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_IdReprC' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                <label class='control-label'>Nombre:</label>
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_NomReprC' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label class='control-label'>Teléfono:</label>
                                                <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_TelReprC' class='form-control' />
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

                                    <div class="form-actions right" id="mopc">
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
                <!-- Ventana Adición -->
                <div id="VentAdicion" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Agregar adición</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>

                                <div class='form-body' id="listAdiciones">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 style="margin-left: 10px;">Adiciones agregadas.</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-actions right">
                                                <button type="button" class="btn green" onclick="$.AddAdicion()" id="btn_guardarAdici"><i class="fa fa-plus"></i> Agregar adición</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='col-md-12'>
                                            <div class='form-group'>

                                                <table class='table table-striped table-hover table-bordered'>
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> #
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Fecha
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Documento
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Valor
                                                            </td>

                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Acción
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="td-AdicionContrato">


                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan='3' style='text-align: right;'>Total adición:</th>
                                                            <th colspan='1'><label id='gtotalAdicion' style='font-weight: bold;'>$ 0,00</label></th>
                                                            <input type='hidden' name='' id='gtotalAdicionVal' />
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='form-body' id="AddAdiciones" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-3'>
                                            <div class='form-group' id="From_FechaAdd">
                                                <label class='control-label'>Fecha:</label><span class="required">* </span>
                                                <input type='text' id='txt_fechaAdd' class='form-control' />
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group' id="From_FechaAdd">
                                                <label class='control-label'>Valor:</label><span class="required">* </span>
                                                <input type='text' id='txt_valorAdicV' disabled onclick="this.select();" value="$ 0,00" onchange="$.cambioFormato(this.id,'txt_valorAdic');" class='form-control' />
                                                <input type='hidden' id='txt_valorAdic' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            <div class='form-group'>
                                                <label class='control-label'>Adjuntar documento<span class='required'>* </span></label>
                                                <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                    <input type="file" id="archivosAdicion">
                                                    <input type="hidden" id="Src_FileAdicion" class="form-control" />

                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgArchAdicion">
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-actions right"'>
                                                <div class="input-group">
                                                    <span class="input-group-btn" id="btn-verDocumentos" style="display: none;">
                                                        <button type="button" id="btn_new_resp" onclick="$.verDocumento();" title="Ver documento" class="btn green-meadow btn-sm">
                                                            <i class="fa fa-search"></i> Ver
                                                        </button>
                                                        <button type="button" id="btn_new_resp" onclick="$.quitarDocumento();" title="Quitar documento" class="btn red btn-sm">
                                                            <i class="fa fa-trash-o"> </i> Quitar
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 style="margin-left: 10px; font-weight: bold;">Detalles de adición.</h4>
                                            </div>
                                        </div>

                                        <div class='col-md-5'>
                                            <div class='form-group' id="From_fuenteAdd">
                                                <label class='control-label'>Fuente de financiación:</label><span class="required">* </span>
                                                <select class="form-control select2" id="CbFuenteFinanciacion" name="options2">

                                                </select>
                                            </div>
                                        </div>
                                        <div class='col-md-7'>
                                            <div class='form-group'>
                                                <label class='control-label'>Gasto:</label>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <select class="form-control" data-placeholder="Seleccione..." id="CbGastos" name="options2">
                                                            <option value="GASTOS INDIRECTOS">GASTOS INDIRECTOS</option>
                                                            <option value="GASTOS DIRECTOS">GASTOS DIRECTOS</option>
                                                        </select>
                                                    </span>
                                                    <input type='text' id='txt_DesGastos' placeholder="Descripción del tipo de gasto" value="" class='form-control' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group' id="From_FechaAdd">
                                                <label class='control-label'>Valor:</label><span class="required">* </span>
                                                <input type='text' id='txt_valorDetAdicV' onclick="this.select();" value="$ 0,00" onchange="$.cambioFormato(this.id,'txt_valorDetAdic');" class='form-control' />
                                                <input type='hidden' id='txt_valorDetAdic' class='form-control' />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-actions right">
                                                <button type="button" class="btn blue" onclick="$.AddDeltalleAdicionContrato()" id="btn_guardarAdici"><i class="fa fa-plus"></i> Agregar</button>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgAdicion">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 style="margin-left: 10px;">Items agregados.</h5>
                                            </div>
                                        </div>
                                        <div class='col-md-12'>
                                            <div class='form-group'>
                                                <input type="hidden" id="contAdicion" value="0" />
                                                <table class='table table-striped table-hover table-bordered' id="tb_AdicionContrato">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> #
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Fuentes de financiación
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Gastos
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Valor
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Acción
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="td-DetAdicionContrato">


                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan='3' style='text-align: right;'>Total items:</th>
                                                            <th colspan='1'><label id='gtotalPresTota' style='font-weight: bold;'>$ 0,00</label></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="msgAdicionGen">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right" id="botones">
                                        <input type="hidden" name="txt_idAdicion" id="txt_idAdicion" value="" />
                                        <button type="button" class="btn blue" onclick="$.atrasAdicion();" id="btn_atrasAdicion"><i class="fa fa-mail-reply"></i> Volver</button>
                                        <button type="button" class="btn green" onclick="$.guadarAdicion();" id="btn_guardarAdicion"><i class="fa fa-save"></i> Guardar</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin Ventana adicion -->
                <!-- Ventana gastos -->
                <div id="VentGastos" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Agregar Gasto</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>

                                <div class='form-body' id="listGastos">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 style="margin-left: 10px;">Gastos agregados.</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-actions right">
                                                <button type="button" class="btn green" onclick="$.AddGasto()" id="btn_guardarAdici"><i class="fa fa-plus"></i> Agregar gasto</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='col-md-12'>
                                            <div class='form-group'>

                                                <table class='table table-striped table-hover table-bordered'>
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> #
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Fecha
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Categoria
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Documento
                                                            </td>
                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Valor
                                                            </td>

                                                            <td>
                                                                <i class='fa fa-angle-right'></i> Acción
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="td-GastoContrato">


                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan='4' style='text-align: right;'>Total gastos:</th>
                                                            <th colspan='1'><label id='gtotalGasto' style='font-weight: bold;'>$ 0,00</label></th>
                                                            <input type='hidden' name='' id='gtotalGastoVal' />
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='form-body' id="AddGasto" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-3'>
                                            <div class='form-group' id="From_FechaGasto">
                                                <label class='control-label'>Fecha:</label><span class="required">* </span>
                                                <input type='text' id='txt_fechaGasto' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class='form-group' id="From_CategoriaGasto">
                                                <label class='control-label'>Categoria del gasto:</label><span class="required">* </span>
                                                <select class="form-control select2" id="CbCategoriaGasto" name="options2">

                                                </select>
                                            </div>
                                        </div>


                                        <div class='col-md-3'>
                                            <div class='form-group' id="From_ValorGasto">
                                                <label class='control-label'>Valor:</label><span class="required">* </span>
                                                <input type='text' id='txt_valorGastoV' onclick="this.select();" value="$ 0,00" onchange="$.cambioFormato(this.id,'txt_valorGasto');" class='form-control' />
                                                <input type='hidden' id='txt_valorGasto' class='form-control' />
                                            </div>
                                        </div>

                                        <div class='col-md-12'>
                                            <div class='form-group' id="From_decripcionGasto">
                                                <label class='control-label'>Descripción del gasto:</label>
                                                <textarea id="txt_descripcionGasto" rows="2" class='form-control' style="width: 100%"></textarea>
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            <div class='form-group'>
                                                <label class='control-label'>Adjuntar documento<span class='required'>* </span></label>
                                                <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                    <input type="file" id="archivosGasto">
                                                    <input type="hidden" id="Src_FileGasto" class="form-control" />
                                                </form>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-actions right"'>
                                                <div class="input-group">
                                                    <span class="input-group-btn" id="btn-verDocumebtosGasto" style="display: none;">
                                                        <button type="button" id="btn_new_resp" onclick="$.verDocumentoGasto();" title="Ver documento" class="btn green-meadow btn-sm">
                                                            <i class="fa fa-search"></i> Ver
                                                        </button>
                                                        <button type="button" id="btn_new_resp" onclick="$.quitarDocumentoGasto();" title="Quitar documento" class="btn red btn-sm">
                                                            <i class="fa fa-trash-o"> </i> Quitar
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgArchGasto">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="msgGastoGen">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right" id="botones">
                                        <input type="hidden" name="txt_idGasto" id="txt_idGasto" value="" />
                                        <button type="button" class="btn blue" onclick="$.atrasGasto();" id="btn_atrasAdicion"><i class="fa fa-mail-reply"></i> Volver</button>
                                        <button type="button" class="btn green" onclick="$.guadarGasto();" id="btn_guardarAdicion"><i class="fa fa-save"></i> Guardar</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin Ventana gastos -->
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
                                                <label class='control-label'>Correo Electronico:</label>
                                                <input type='text' id='txt_Corre' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                <label class='control-label'>Teléfonos:</label>
                                                <input type='text' id='txt_TelfS' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-12'>
                                            <div class='form-group'>
                                                <label class='control-label'>Observación:</label>
                                                <textarea id="txt_obserS" rows="2" class='form-control' style="width: 100%"></textarea>
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

                                                <input type='text' id='txt_CodI' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-8'>
                                            <div class='form-group' id="From_DescripcionI">
                                                <label class='control-label'>Nombre:</label><span class="required">* </span>
                                                <input type='text' id='txt_DescI' class='form-control' />
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                <label class='control-label'>Correo Electronico:</label>
                                                <input type='text' id='txt_CorreI' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                <label class='control-label'>Teléfonos:</label>
                                                <input type='text' id='txt_TelfI' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-12'>
                                            <div class='form-group'>
                                                <label class='control-label'>Observación:</label>
                                                <textarea id="txt_obserI" rows="2" class='form-control' style="width: 100%"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msgI">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions right" id="mopc">
                                        <button type="button" class="btn green" id="btn_guardarI"><i class="fa fa-save"></i> Guardar</button>
                                        <button type="button" class="btn purple" disabled id="btn_nuevoI"><i class="fa fa-file-o"></i> Nuevo</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin Ventana Supervisor -->

                <!-- Inicio Ventana Poliza -->
                <div id="modalPoliza" class="modal fade" tabindex="-1" data-width="760" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-body">
                        <div class='portlet box blue'>
                            <div class='portlet-title'>
                                <div class='caption'>
                                    <i class='fa fa-angle-right'></i>Datos de la Poliza
                                </div>
                            </div>
                            <div class='portlet-body form'>
                                <div class='form-body'>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="msgCodPol">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <p style="font-weight: bold;" class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="hidden" id="doc_anexo_poliza" name='doc_anexo_poliza' />
                                                <input type="hidden" id="id_contrato" name='id_contrato' />
                                                <label class='control-label' for='num_poliza'>Número:<span class="required">* </span></label>
                                                <input type='text' name='num_poliza' id='num_poliza' class='form-control' />
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label class='control-label' for="fecha_ini_poliza">Fecha de Inicio:<span class="required">* </span></label>
                                                <input type='text' placeholder='Fecha de Inicio' id='fecha_ini_poliza_u' name='fecha_ini_poliza' class='form-control' style='background-color:white;' />
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label class='control-label' for="fecha_fin_poliza">Fecha Final:<span class="required">* </span></label>
                                                <input type='text' placeholder='Fecha Final' id='fecha_fin_poliza_u' name='fecha_fin_poliza' class='form-control' style='background-color:white;' />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" id="From_Arch">
                                                <form method="POST" id="form_polizas" action="#" class="form-vertical" enctype="multipart/form-data">
                                                    <label class="control-label">Anexar Documento <span class="required">* </span></label>
                                                    <input type="file" id="anexo_poliza" name="anexo_poliza" accept="image/jpeg,image/png,application/pdf">
                                                    Tamaño Del Archivo: <span id="fileSize">0</span></p>

                                                    <p class="help-block">
                                                        <span class="label label-danger">
                                                            NOTA: </span>
                                                        &nbsp; El Tamaño Del Anexo No Puede Ser Mayor De 20MB, Y Solo Extensiones .pdf,jpeg,png
                                                    </p>
                                                </form>
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
                    <div class="modal-footer">
                        <a href='javascript:;' class='btn btn-sm red' id='btnGuaPol'> <i class='fa fa-edit'></i> Guardar</a>
                        <button type="button" data-dismiss="modal" class="btn green btn-sm">
                            <i class='fa fa-close'></i> Cancelar
                        </button>
                    </div>
                </div>
                <!-- Fin Ventana Poliza -->

                <!-- BEGIN PAGE CONTENT-->
                <ul class="nav nav-tabs">
                    <li class="active" id="tab_01_pp">
                        <a href="#tab_01" data-toggle="tab"> Listado de Contratos</a>
                    </li>
                    <li id="tab_02_pp">
                        <a href="#tab_02" data-toggle="tab" onclick="$.addCont();" id="atitulo">Crear Contratos</a>
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

                                                        <div class='col-md-7'>
                                                            <div class='form-group'>
                                                                <label class="label-control">Proyectos: </label>
                                                                <select class="form-control select2" onchange="$.busqContratoPro()" id="CbProyBusc" name="options2">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3'>
                                                            <div class='form-group'>
                                                                <label class="label-control">Busqueda:</label>
                                                                <input class="form-control" onkeyup="$.busqContrato(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                            </div>
                                                        </div>
                                                        <div class='col-md-1 justify-content-center align-items-center minh-100'>
                                                            <div class="btn-group dropup">
                                                                <label class="label-control" style="color: #FFFFFF;">:</label>
                                                                <button id='btn_ExcelCont' class="btn green dropdown-toggle" style="vertical-align: bottom;" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                    Generar Excel <i class="fa fa-file-excel-o"></i>
                                                                </button>
                                                                <ul class="dropdown-menu pull-right" role="menu">

                                                                    <li>
                                                                        <a onclick="$.ExcelContratos();">
                                                                            Listado de Contratos </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="display: none;" id="TitContAtrasados">
                                                            <h3 class="page-title"> Listado Contratos Atrasados</h3>
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
                                                    <div class='row' id="cont_histo" style="display: none;">
                                                        <div class='col-md-12'>
                                                            <div>
                                                                <div class="caption">
                                                                    <i class="fa fa-globe"></i> <label style="padding-top: 15px;font-size: 16px; font-weight: bold;" id="titcontr"></label>
                                                                </div>

                                                            </div>
                                                            <div class="table-scrollable">
                                                                <div id="tab_HistoCont" style="height: 350px;overflow: scroll;">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-actions right">
                                                            <button type="button" class="btn blue" id="btn_volverContr"><i class="fa fa-mail-reply"></i> Volver</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="msg2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <center>
                                                        <h4 class='form-section'></h4>
                                                    </center>
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
                                            <a href="#tab_2" data-toggle="tab"> Localización </a>
                                        </li>
                                        <li id="tab_pp3">
                                            <a href="#tab_3" data-toggle="tab"> Galeria </a>
                                        </li>


                                    </ul>
                                    <div class="tab-content">
                                        <!--                                Inf. General -->
                                        <div class="tab-pane fade active in" id="tab_1">
                                            <input type="hidden" id="perm" value="<?php echo $_SESSION['GesProyACo']; ?>" />
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
                                                                <div id="msgCod">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_CodProyecto"><input type="hidden" id="cons" value="" /><input type="hidden" id="acc" value="1" /><input type="hidden" id="txt_id" value="" /><input type="hidden" id="txt_fec" value="<%=formateador.format(fecha1)%>" />
                                                                    <label class='control-label'>Número del Contrato:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_Cod' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label' id="From_fecrea">Fecha Creación:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_fecha' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>F. Ult. Modificación:</label>
                                                                    <input type='text' id='txt_fecha_Modi' disabled="" value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-5' id="divtipo">
                                                                <div class='form-group' id="From_Tipologia">
                                                                    <label class='control-label'>Tipología del Contrato:<span class="required">* </span></label>
                                                                    <div class="input-group ">
                                                                        <select class="form-control select2" id="CbTiplog" name="options2">
                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewTipo();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </span>

                                                                    </div>

                                                                </div>
                                                            </div>


                                                            <div class='col-md-12'>
                                                                <div class='form-group' id="From_Nombre">
                                                                    <label class='control-label'>Objeto del Contrato:<span class="required">* </span></label>
                                                                    <textarea id="txt_Nomb" rows="2" class='form-control' style="width: 100%"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-4' id="divcont">
                                                                <div class='form-group' id="From_Contratista">
                                                                    <label class='control-label'>Contratista:<span class="required">* </span></label>
                                                                    <div class="input-group ">
                                                                        <select class="form-control select2" id="CbContratis" name="options2">

                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewContra();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </span>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-4' id="divsupe">
                                                                <div class='form-group' id="From_Super">
                                                                    <label class='control-label'>Responsable Supervisor:</label>
                                                                    <div class="input-group ">
                                                                        <select class="form-control select2" id="CbSuper" name="options2">

                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewSuper();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </span>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-4' id="divinter">
                                                                <div class='form-group' id="From_Interv">
                                                                    <label class='control-label'>Responsable Interventoria:</label>
                                                                    <div class="input-group ">
                                                                        <select class="form-control select2" id="CbInter" name="options2">

                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewInter();" title="Crear Nueva Tipologia" class="btn green-meadow">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </span>

                                                                    </div>


                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>URL Contrato SECOP:</label>
                                                                    <input type='text' id='txt_Url' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'><b>Valores:</b></label>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3' id="divval">
                                                                <div class='form-group' id="From_Valor">
                                                                    <label class='control-label'>Valor del Contrato:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_VaCont' onchange="$.AddVFina(this.value, this.id);" value="$ 0,00" class='form-control' onclick="this.select();" />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Adición del Contrato:</label>
                                                                    <div class="input-group ">
                                                                        <input type='text' id='txt_VaAdiV' value="$ 0,00" class='form-control' disabled onchange="$.AddAdic(this.value, this.id);" onclick="this.select();" />
                                                                        <input type='hidden' id='txt_VaAdi' value="$ 0,00" class='form-control' />
                                                                        <span class="input-group-btn" id="btn-adicion" style="display: none;">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewAdicion('1');" title="Agregar adición" class="btn green-meadow">
                                                                                <i class="fa fa-pencil-square-o"></i>
                                                                            </button>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Valor Final del Contrato:</label>
                                                                    <input type='text' id='txt_VaFin' value="$ 0,00" class='form-control' onclick="this.select();" onblur="textm(this.value, this.id)" />

                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Valor Ejecutado del Contrato:</label>
                                                                    <div class="input-group ">
                                                                        <input type='text' id='txt_VaEjeV' disabled value="$ 0,00" class='form-control' onclick="this.select();" onblur="textm(this.value, this.id)" />
                                                                        <input type='hidden' id='txt_VaEje' value="" class='form-control' />
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="btn_new_resp" onclick="$.NewGastos('1');" title="Agregar gastos" class="btn green-meadow">
                                                                                <i class="fa fa-pencil-square-o"></i>
                                                                            </button>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class='col-md-12' id="divfpag">
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Forma de Pago:</label>
                                                                    <input type='text' id='txt_Fpago' class='form-control' />
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'><b>Fechas:</b></label>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-3' id="divdura">
                                                                <div class='form-group'>
                                                                    <div class='form-group' id="From_Dur">
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
                                                                <div class='form-group' id="From_fini">
                                                                    <label class='control-label'>Fecha de Inicio:<span class="required">* </span></label>
                                                                    <input type='text' id='txt_FIni' value="" class='form-control' readonly />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fec. de Suspensión:</label>
                                                                    <input type='text' id='txt_FSusp' value="" class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha de Reinicio:</label>
                                                                    <input type='text' id='txt_FRein' value="" class='form-control' />
                                                                </div>
                                                            </div>

                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Prorroga:</label>
                                                                        <div class="input-group">
                                                                            <input type="text" id="txt_Prorog" maxlength="3" onchange="$.CalPror();" onkeypress='return validartxtnum(event)' class="form-control">
                                                                            <span class="input-group-btn">
                                                                                <select class='form-control' id="CbTiemProrog" onchange="$.CambEstado('Prorroga');" onchange="$.valtiemPro();" name="options2">
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
                                                                    <input type='text' id='txt_FFina' value="" class='form-control' readonly />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-2'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Fecha de Recibo:</label>
                                                                    <input type='text' id='txt_FReci' value="" class='form-control' />
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12' id="divtitpro">
                                                                <div class='form-group'>
                                                                    <label class='control-label'><b>Proyecto:</b></label>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12' id="divproy">
                                                                <div class='form-group' id="From_Proyect">
                                                                    <label class='control-label'>Proyecto Asociado:<span class="required">* </span></label>
                                                                    <select class="form-control select2" id="CbProy" onchange="$.verEstadoProyecto(this.value)" name="options2">

                                                                    </select>
                                                                    <input type="hidden" value="" id="text_estadoProyecto" />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-4' id="divequi">
                                                                <label class='control-label'>% Equivalente en Proyecto:</label>
                                                                <div class="input-group ">
                                                                    <input type='text' id='txt_PorEqui' disabled value='0' class='form-control' />
                                                                    <span class="input-group-btn">
                                                                        <button type="button" id="btn_new_resp" onclick="$.UpdPorc();" title="Assignar Porcentaje en Proyecto" class="btn blue">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </span>

                                                                </div>

                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>% de Avance del Contrato:</label>
                                                                    <input type='text' id='txt_Avance' value="" onchange='$.addporc(this.id);' class='form-control' />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <div class='form-group' id="From_Estado">
                                                                    <label class='control-label'>Estado:<span class="required">* </span></label>

                                                                    <select class='form-control' onchange="$.CambEstado(this.value);" id="CbEstado" name="options2">
                                                                        <option value=" ">Select...</option>
                                                                        <option value="Revision">Revision</option>
                                                                        <option value="Ejecucion">Ejecución</option>
                                                                        <option value="Suspendido">Suspendido</option>
                                                                        <option value="Terminado">Terminado</option>
                                                                        <option value="Liquidado">Liquidado</option>
                                                                        <option value="Cancelado">Cancelado</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-2' id="div_estado">
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Estado:</label>

                                                                    <select class='form-control' id="CbEstadoProc" onchange="$.MosAlertEst(this.value)" name="options2">
                                                                        <option value="Por Verificar">Por Verificar</option>
                                                                        <option value="Verificado">Verificado</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12' id="Div_CamEst" style="display: none;">
                                                                <div class="row">
                                                                    <div class='col-md-12'>
                                                                        <div class='form-group'>
                                                                            <label class='control-label' id="TitMoti"></label>
                                                                            <textarea id="Text_Motivo" rows="2" class='form-control' style="width: 100%"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-md-10'>
                                                                        <label class='control-label' id="TitAdjArc"><span class='required'>* </span></label>
                                                                        <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                                            <input type="file" id="archEstad">
                                                                            <input type="hidden" id="Src_FileEstad" value="" />
                                                                            <input type="hidden" id="novedad" value="" />
                                                                            <input type="hidden" id="num_contr" value="" />
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-md-2" id="MostImg">
                                                                        <div class="form-group">
                                                                            <a href='' id="DocuEst " target='_blank' class="btn default btn-xs blue"><i class="fa fa-file"></i> Ver Documento</a>
                                                                        </div>
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

                                        <!--                                Galeria  -->
                                        <div class="tab-pane fade" id="tab_3">
                                            <p>
                                            <div class='portlet box blue'>
                                                <div class='portlet-title'>
                                                    <div class='caption'>
                                                        <i class='fa fa-angle-right'></i>3. Galeria
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
                                                                    <input type='text' id='txt_fechaG' value="" class='form-control' readonly />
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class='form-group'>
                                                                    <label class='control-label'>Adjuntar Imagenes<span class='required'>* </span></label>
                                                                    <form method="post" enctype='multipart/form-data' class='form' id='formulario'>
                                                                        <input type="file" id="archivos" multiple>

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

    <!-- <script src="../Js/form-components.js"></script> -->
</body>

</html>
>