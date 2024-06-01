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

include "../Conectar.php";
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8" />
    <title>GMP - Gestor Monitoreo Público | Mi perfil</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="../Plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/> -->
    <link href="../Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL ../Plugins -->
    <link href="../Plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <script src="../Plugins/jquery-knob/js/jquery.knob.js"></script>
    <!--
                <link href="Plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet"/>
                <link href="Plugins/jquery-ui/jquery.ui.slider.css" rel="stylesheet"/> -->
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <style>




    </style>
    <link href="../Css/Global/css/components.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="../Css/circle.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="../Img/favicon.ico" />
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ_FNKVfd7vx76ykD4XbVjATqK5sVp8AQ&sensor=false">
    </script>

    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <style>
        .informacionGeneral {
            padding-left: 20px;
            display: flex;
        }

        .detUsu {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
        }

        .detUsu ul {
            padding-left: 10px;
        }

        .informacionGeneral div {
            margin-right: 20px;
        }
    </style>

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed page-sidebar-fixed">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="../Administracion.php">
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
        <input type="hidden" readonly name="lat" id="lat" />
        <input type="hidden" readonly name="lng" id="long" />

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
                            <a href="../MiPerfil/">Mi Perfil </a>

                        </li>
                    </ul>
                </div>

                <h3 class="page-title"> GMP - Gestor Monitoreo Público | Mi perfil
                </h3>
                <div class="tiles">
                    <div class="row-fluid profile">
                        <div class="span12">
                            <!--BEGIN TABS-->
                            <div class="tabbable tabbable-custom tabbable-full-width">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1_1" data-toggle="tab">Descripción general</a></li>
                                    <li><a href="#tab_1_2" data-toggle="tab">Información de cuenta</a></li>
                                </ul>
                                <input type="hidden" id="idUsuario" value="<?php echo $_SESSION['ses_idusu'] ?>" />
                                <div class="tab-content">
                                    <div class="tab-pane row-fluid active" id="tab_1_1">
                                        <div class="informacionGeneral">
                                            <div>
                                                <img src="../Img/Usuarios/<?php echo $_SESSION['cue_foto'] ?>" width="120" alt="" />

                                            </div>
                                            <div class="detUsu">
                                                <h4><?php echo $_SESSION['ses_nombre'] ?></h4>
                                                <ul class="unstyled inline">
                                                    <li id="infCorreo"></li>
                                                    <li id="infTelefono"></li>
                                                    <li><i class="fa fa-bank"></i> <?php echo $_SESSION['ses_compa'] ?></li>
                                                    <li id="infDireccion"></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <h3>Listado de proyectos asignados.</h3>
                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><i class="icon-briefcase"></i> proyectos</th>
                                                        <th class="hidden-phone"><i class="fa fa-sitemap"></i> Secretaria</th>
                                                        <th><i class="fa fa-exclamation"></i> Detalles</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tr_proyecto">
                                                   
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="tab-pane row-fluid profile-account" id="tab_1_2">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="span3">
                                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                        <li class="active">
                                                            <a data-toggle="tab" href="#tab_1-1">
                                                                <i class="icon-cog"></i>
                                                                Información personal
                                                            </a>
                                                            <span class="after"></span>
                                                        </li>
                                                        <li><a data-toggle="tab" href="#tab_2-2"><i class="icon-picture"></i> Change Avatar</a></li>
                                                        <li><a data-toggle="tab" href="#tab_3-3"><i class="icon-lock"></i> Change Password</a></li>
                                                        <li><a data-toggle="tab" href="#tab_4-4"><i class="icon-eye-open"></i> Privacity Settings</a></li>
                                                    </ul>
                                                </div>
                                                <div class="span9">
                                                    <div class="tab-content">
                                                        <div id="tab_1-1" class="tab-pane active">
                                                            <div style="height: auto;" id="accordion1-1" class="accordion collapse">
                                                                <form action="#">
                                                                    <label class="control-label">First Name</label>
                                                                    <input type="text" placeholder="John" class="m-wrap span8" />
                                                                    <label class="control-label">Last Name</label>
                                                                    <input type="text" placeholder="Doe" class="m-wrap span8" />
                                                                    <label class="control-label">Mobile Number</label>
                                                                    <input type="text" placeholder="+1 646 580 DEMO (6284)" class="m-wrap span8" />
                                                                    <label class="control-label">Interests</label>
                                                                    <input type="text" placeholder="Design, Web etc." class="m-wrap span8" />
                                                                    <label class="control-label">Occupation</label>
                                                                    <input type="text" placeholder="Web Developer" class="m-wrap span8" />
                                                                    <label class="control-label">Counrty</label>
                                                                    <div class="controls">
                                                                        <input type="text" class="span8 m-wrap" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source="[&quot;Alabama&quot;,&quot;Alaska&quot;,&quot;Arizona&quot;,&quot;Arkansas&quot;,&quot;US&quot;,&quot;Colorado&quot;,&quot;Connecticut&quot;,&quot;Delaware&quot;,&quot;Florida&quot;,&quot;Georgia&quot;,&quot;Hawaii&quot;,&quot;Idaho&quot;,&quot;Illinois&quot;,&quot;Indiana&quot;,&quot;Iowa&quot;,&quot;Kansas&quot;,&quot;Kentucky&quot;,&quot;Louisiana&quot;,&quot;Maine&quot;,&quot;Maryland&quot;,&quot;Massachusetts&quot;,&quot;Michigan&quot;,&quot;Minnesota&quot;,&quot;Mississippi&quot;,&quot;Missouri&quot;,&quot;Montana&quot;,&quot;Nebraska&quot;,&quot;Nevada&quot;,&quot;New Hampshire&quot;,&quot;New Jersey&quot;,&quot;New Mexico&quot;,&quot;New York&quot;,&quot;North Dakota&quot;,&quot;North Carolina&quot;,&quot;Ohio&quot;,&quot;Oklahoma&quot;,&quot;Oregon&quot;,&quot;Pennsylvania&quot;,&quot;Rhode Island&quot;,&quot;South Carolina&quot;,&quot;South Dakota&quot;,&quot;Tennessee&quot;,&quot;Texas&quot;,&quot;Utah&quot;,&quot;Vermont&quot;,&quot;Virginia&quot;,&quot;Washington&quot;,&quot;West Virginia&quot;,&quot;Wisconsin&quot;,&quot;Wyoming&quot;]" />
                                                                        <p class="help-block"><span class="muted">Start typing to auto complete!. E.g: US</span></p>
                                                                    </div>
                                                                    <label class="control-label">About</label>
                                                                    <textarea class="span8 m-wrap" rows="3"></textarea>
                                                                    <label class="control-label">Website Url</label>
                                                                    <input type="text" placeholder="http://www.mywebsite.com" class="m-wrap span8" />
                                                                    <div class="submit-btn">
                                                                        <a href="#" class="btn green">Save Changes</a>
                                                                        <a href="#" class="btn">Cancel</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="tab_2-2" class="tab-pane">
                                                            <div style="height: auto;" id="accordion2-2" class="accordion collapse">
                                                                <form action="#">
                                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                                    <br />
                                                                    <div class="controls">
                                                                        <div class="thumbnail" style="width: 291px; height: 170px;">
                                                                            <img src="http://www.placehold.it/291x170/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="space10"></div>
                                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                        <div class="input-append">
                                                                            <div class="uneditable-input">
                                                                                <i class="icon-file fileupload-exists"></i>
                                                                                <span class="fileupload-preview"></span>
                                                                            </div>
                                                                            <span class="btn btn-file">
                                                                                <span class="fileupload-new">Select file</span>
                                                                                <span class="fileupload-exists">Change</span>
                                                                                <input type="file" class="default" />
                                                                            </span>
                                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <div class="controls">
                                                                        <span class="label label-important">NOTE!</span>
                                                                        <span>You can write some information here..</span>
                                                                    </div>
                                                                    <div class="space10"></div>
                                                                    <div class="submit-btn">
                                                                        <a href="#" class="btn green">Submit</a>
                                                                        <a href="#" class="btn">Cancel</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="tab_3-3" class="tab-pane">
                                                            <div style="height: auto;" id="accordion3-3" class="accordion collapse">
                                                                <form action="#">
                                                                    <label class="control-label">Current Password</label>
                                                                    <input type="password" class="m-wrap span8" />
                                                                    <label class="control-label">New Password</label>
                                                                    <input type="password" class="m-wrap span8" />
                                                                    <label class="control-label">Re-type New Password</label>
                                                                    <input type="password" class="m-wrap span8" />
                                                                    <div class="submit-btn">
                                                                        <a href="#" class="btn green">Change Password</a>
                                                                        <a href="#" class="btn">Cancel</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="tab_4-4" class="tab-pane">
                                                            <div style="height: auto;" id="accordion4-4" class="accordion collapse">
                                                                <form action="#">
                                                                    <div class="profile-settings row-fluid">
                                                                        <div class="span9">
                                                                            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus..</p>
                                                                        </div>
                                                                        <div class="control-group span3">
                                                                            <div class="controls">
                                                                                <label class="radio">
                                                                                    <input type="radio" name="optionsRadios1" value="option1" />
                                                                                    Yes
                                                                                </label>
                                                                                <label class="radio">
                                                                                    <input type="radio" name="optionsRadios1" value="option2" checked />
                                                                                    No
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end profile-settings-->
                                                                    <div class="profile-settings row-fluid">
                                                                        <div class="span9">
                                                                            <p>Enim eiusmod high life accusamus terry richardson ad squid wolf moon</p>
                                                                        </div>
                                                                        <div class="control-group span3">
                                                                            <div class="controls">
                                                                                <label class="checkbox">
                                                                                    <input type="checkbox" value="" /> All
                                                                                </label>
                                                                                <label class="checkbox">
                                                                                    <input type="checkbox" value="" /> Friends
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end profile-settings-->
                                                                    <div class="profile-settings row-fluid">
                                                                        <div class="span9">
                                                                            <p>Pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson</p>
                                                                        </div>
                                                                        <div class="control-group span3">
                                                                            <div class="controls">
                                                                                <label class="checkbox">
                                                                                    <input type="checkbox" value="" /> Yes
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end profile-settings-->
                                                                    <div class="profile-settings row-fluid">
                                                                        <div class="span9">
                                                                            <p>Cliche reprehenderit enim eiusmod high life accusamus terry</p>
                                                                        </div>
                                                                        <div class="control-group span3">
                                                                            <div class="controls">
                                                                                <label class="checkbox">
                                                                                    <input type="checkbox" value="" /> Yes
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end profile-settings-->
                                                                    <div class="profile-settings row-fluid">
                                                                        <div class="span9">
                                                                            <p>Oiusmod high life accusamus terry richardson ad squid wolf fwopo</p>
                                                                        </div>
                                                                        <div class="control-group span3">
                                                                            <div class="controls">
                                                                                <label class="checkbox">
                                                                                    <input type="checkbox" value="" /> Yes
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end profile-settings-->
                                                                    <div class="space5"></div>
                                                                    <div class="submit-btn">
                                                                        <a href="#" class="btn green">Save Changes</a>
                                                                        <a href="#" class="btn">Cancel</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end span9-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TABS-->
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
    <!-- <script src="Plugins/jquery-knob/js/jquery.knob.js"></script>
        <script src="Plugins/ui-sliders.js"></script> -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../Css/Layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../Css/Layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

    <script src="../Js/amchart/core.js"></script>
    <script src="../Js/amchart/charts.js"></script>
    <script src="../Js/amchart/themes/animated.js"></script>
    <script src="../Js/amchart/themes/dataviz.js"></script>

    <script>
        $(document).ready(function() {

            $.extend({
                cargarDatos: function() {
                    let idUsu = $("#idUsuario").val();

                    var datos = {
                        ope: "buscarDatosUsuario",
                        idUsu: idUsu
                    };

                    $.ajax({
                        type: "POST",
                        url: "../All.php",
                        data: datos,
                        dataType: "json",
                        success: function(data) {
                            $("#infCorreo").html('<i class="fa fa fa-envelope-o"></i>'+data['cue_correo']);
                            $("#infTelefono").html('<i class="fa fa-phone"></i>'+data['cue_tele']);
                            $("#infDireccion").html('<i class="fa fa-map-signs"></i>'+data['cue_dir']);

                            $("#tr_proyecto").html(data['tr_poryectos']);
                        },
                        error: function(error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });

                }
            });

            $.cargarDatos();


        });
    </script>
</body>

</html>