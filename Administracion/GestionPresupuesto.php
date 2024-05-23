<?php
session_start();

putenv('TZ=America/Bogota');

if (!isset($_SESSION['ses_user'])) {
    echo "<script>location.href='../index.php'</script>";
    exit();
}
if ($_SESSION['GesParVDep'] == "n") {
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
    <title> Gestión de Presupuesto | SGP Gestor Publico de Gobierno</title>
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

    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../Js/GestionPresupuesto.js" type="text/javascript"></script>
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
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
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
                            <a href="GestionPresupuesto.php">Gestión de Presupuesto </a>

                        </li>
                    </ul>
                </div>

                <h3 class="page-title"> </h3>

                <div id="responsive" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id='titformi'>Datos del Presupuesto</h4>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class='portlet-body form'>
                                <form class="form" method="post" id="formGuardarPresupuesto" action="../Administracion/GuardarRubroPresup.php">
                                    <div class='form-body'>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <input type="hidden" name="acc" id="acc">
                                            <input type="hidden" name="id" id="id">

                                            <div class='col-md-8'>
                                                <div class='form-group' id="From_Fuente">
                                                    <label class='control-label'>Fuente de financiación:</label><span class="required">* </span>
                                                    <select class='form-control select2' id="fuente" name="fuente">
                                                        <option value=''>(Seleccione)</option>
                                                        <?php
                                                        $link = conectar();
                                                        $sql = "SELECT * FROM fuentes WHERE estado='ACTIVO'";
                                                        $consulta = mysqli_query($link, $sql);
                                                        $Tipolog = "<option value=' '>Seleccione...</option>";
                                                        while ($resp = $consulta->fetch_assoc()) {
                                                            $Tipolog .= "<option value='" . $resp['id'] . "' >" . $resp['nombre'] . "</option>";
                                                        }
                                                        echo $Tipolog;
                                                        mysqli_close($link);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class='col-md-4'>
                                                <div class='form-group' id="formValor">
                                                    <label class='control-label'>Valor:<span class="required">* </span></label>
                                                    <input type='text' id='txt_PresTotalVis' name="txt_PresTotalVis" onchange="$.cambioFormato(this.id);" onclick="this.select()" value="$ 0,00" class='form-control' />
                                                    <input type='hidden' value='0' id="txt_PresTotal" name='txt_PresTotal' />
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='form-group'  id="formFecReg">
                                                    <label class='control-label'>Fecha de registro:<span class="required">* </span></label>
                                                    <input type='text' id='txtFecRegistro' name='txtFecRegistro' class='form-control' />
                                                </div>
                                            </div>


                                            <div class='col-md-4'>
                                                <div class='form-group' id="From_VigenciaI">
                                                    <label class='control-label'>Periodo nicio:<span class="required">* </span></label>
                                                    <input type='text' value="<?php echo date('Y'); ?>" id='CbPeriodoI'  name='CbPeriodoI' readonly class='form-control' />

                                                </div>
                                            </div>

                                            <div class='col-md-4'>
                                                <div class='form-group' id="From_VigenciaF">
                                                    <label class='control-label'>Periodo final:<span class="required">* </span></label>
                                                    <input type='text' value="<?php echo date('Y'); ?>" name='CbPeriodoF'  id='CbPeriodoF' readonly class='form-control' />

                                                </div>
                                            </div>

                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Observación:</label>
                                                    <textarea id="txt_obser" name="txt_obser" rows="2" class='form-control' style="width: 100%"></textarea>
                                                </div>
                                            </div>
                                            <input type='hidden' value='0' id='contBolsa' />


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="msg">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-actions right" id="mopc">
                                            <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                            <?php
                                            if ($_SESSION['GesParADep'] == "s") {
                                                echo '<button type="button" class="btn purple" disabled onclick="$.nuevo(this)" id="btn_nuevo2"><i class="fa fa-file-o"></i> Nuevo</button>';
                                            }
                                            ?>
                                            <button type="button" data-dismiss="modal" class="btn yellow-casablanca"><i class="fa fa-close"></i> Cerrar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- stackable -->

                <!-- BEGIN PAGE CONTENT-->
                <div class="portlet box blue-soft">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-angle-right"></i>Gestión de Presupuesto.
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
                                                                <input class="form-control input-small input-inline" onkeypress="$.Presupuesto(this.value);" onchange="$.Presupuesto(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                            </label>
                                                            <div style="float: right;">
                                                                <?php
                                                                if ($_SESSION['GesParADep'] == "s") {
                                                                    echo '<button type="button" class="btn purple" onclick="$.nuevo(this)"  id="btn_nuevo1"><i class="fa fa-file-o"></i> Nuevo</button>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="table-scrollable">

                                                            <div id="tab_Presupuesto" style="height: 250px;overflow: scroll;">

                                                            </div>


                                                        </div>

                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div id="msg2">
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