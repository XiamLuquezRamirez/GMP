<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>SGP Gestor Publico de Gobierno | Bienvenido</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="Css/Global/css/components.min.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="Css/Pages/Css/login-3.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="Img/favicon.ico" />

        <script src="Js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="Js/Inicio.js" type="text/javascript"></script>

    </head>
    <body class=" login" id="body1">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.php">
                <img src="Img/logo-big.png" alt="" width="350"/>
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <div class="form-group"  id="usuari">
                <h3 class="form-title">Iniciar Sesi&oacute;n</h3>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Usuario" id="txt_username" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" id="txt_key" />
                        <input  type="hidden" id="control" value="0" />
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
            </div>
            <div class="form-group" id="compania" style="display: none;">
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
                    <div id="msg2">
                    </div>
                </div>
                <div class="form-actions">
                    <!--<button type="button" id="ayuda" class="btn btn-default"><i class="fa fa-info-circle"></i></button>-->
                    <button type="submit" class="btn" id="btn_antra"> <li class="m-icon-swapleft"></li> Atras </button>
                    <button type="submit" class="btn green pull-right" id="btn_login2"> Entrar <li class="m-icon-swapright m-icon-white"></li></button>
                </div>
            </div>
            <!-- END LOGIN FORM -->
        </div>
        <!-- END LOGIN -->

        <!-- BEGIN CORE PLUGINS -->
        <script src="Plugins/jquery.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="Plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="Css/Global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
    </body>
</html>