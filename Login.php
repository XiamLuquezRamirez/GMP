<?php

session_start();
$_SESSION['ses_nombd'] = "bd_gmp";
$_SESSION['ses_BDBase'] = "bd_gmp";
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include "Conectar.php";

if (($_POST['USER'] == "") || !isset($_POST['USER'])) {
    echo "<script>location.href='login.php';</script>";
}

$link = conectar();

mysqli_query($link, "BEGIN");

$success = 1;
$usuario_ncompa = 0;
$menuopc = "";
$flag = "n";

if ($_POST['opc'] == "vercompa") {
    $con = "SELECT * FROM usuarios where cue_alias='" . $_POST['USER'] . "'
            AND cue_pass=SHA1('" . $_POST['KEY'] . "')";

    $resultado = mysqli_query($link, $con);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $usu_maestro = $fila["usu_maestro"];
            $_SESSION['ses_compa'] = "";
            $_SESSION['ses_nombre'] = $fila['cue_nombres'];
            $_SESSION['cue_foto'] = $fila['cue_foto'];
            $_SESSION['ses_user'] = $_POST['USER'];
            $_SESSION['ses_idusu'] = $fila['id_usuario'];
            $_SESSION['usu_maestro'] = $usu_maestro;
            $flag = "s";
        }
    }

    $con = "SELECT * FROM usucompa WHERE usucompa_usuario='" . $_POST['USER'] . "'";
    $resultado = mysqli_query($link, $con);
    if (mysqli_num_rows($resultado) > 0) {
        $usuario_ncompa = 1;
    }

    if ($flag == "s") {
        if ($usu_maestro != "" && $usuario_ncompa == 0) {
            echo "erro2";
        } else if ($usu_maestro == "" && $usuario_ncompa == 0) {
            $Footer = "<div class='page-footer'>
                         <div class='page-footer-inner'>
                           Copyright &copy;<script>document.write(new Date().getFullYear());</script> Leer Ingenieria S.A.S
                         </div>
                         <div class='scroll-to-top'>
                             <i class='icon-arrow-up'></i>
                         </div>
                     </div>";

            $User_Login = "<li class='dropdown dropdown-user'>
                         <a class='dropdown-toggle'>
                             <img class='img-circle' src='Img/Compa.png' alt=''/>
                             <span class='username'>
                                ---
                            </span>
                            
                         </a>
                     </li>
                     <li class='dropdown dropdown-user' >
                         <a class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                             <img class='img-circle' src='Img/Usuarios/".$_SESSION['cue_foto']." alt=''/>
                             <span class='username'>
                                " . $_SESSION['ses_nombre'] . "
                            </span>
                             <i class='fa fa-angle-left'></i>
                         </a>
                         <ul class='dropdown-menu'>
                         <li><a href='MiPerfil/'><i class='fa fa-user'></i> Mi perfil</a></li>
                         <li class='divider'></li>
                         <li><a target='_blank' href='Administracion/Manual_Usuario.pdf' id='trigger_fullscreen'><i class='fa fa-book'></i> Manual de usuario</a></li>
                         <li><a href='cerrar.php'><i class='fa fa-sign-out'></i>  Cerrar Sesi&oacute;n</a></li>
                     </ul>
                     </li>

                     <li class='dropdown dropdown-user'>
                         <a href='cerrar.php' class='dropdown-toggle'>
                             <span class='username'>
                                Cerrar Sesi&oacute;n
                            </span>
                             <i class='icon-logout'></i>
                        </a>
                     </li>";
            $User_SubLogin = "
                
                <li class='dropdown dropdown-user'>
                         <a class='dropdown-toggle'>
                             <img class='img-circle' src='../Img/Compa.png' alt=''/>
                             <span class='username'>
                                ---
                            </span>
                         </a>
                     </li>
                     <li class='dropdown dropdown-user' >
                         <a class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                             <img class='img-circle' src='../Img/Usuarios/".$_SESSION['cue_foto']."' alt=''/>
                             <span class='username'>
                                " . $_SESSION['ses_nombre'] . "
                            </span>
                             <i class='fa fa-angle-left'></i>
                         </a>
                         <ul class='dropdown-menu'>
                         <li><a href='../MiPerfil/'><i class='fa fa-user'></i> Mi perfil</a></li>
                         <li class='divider'></li>
                         <li><a target='_blank' href='../Administracion/Manual_Usuario.pdf' id='trigger_fullscreen'><i class='fa fa-book'></i> Manual de usuario</a></li>
                         <li><a href='../cerrar.php'><i class='fa fa-sign-out'></i>  Cerrar Sesi&oacute;n</a></li>
                     </ul>
                     </li>";

            $Menu_Left = "<div class='page-sidebar-wrapper'>
                <div class='page-sidebar navbar-collapse collapse'>
                    <!-- BEGIN MENU LATERAL -->
                    <ul class='page-sidebar-menu' data-keep-expanded='false' data-auto-scroll='true' data-slide-speed='200'>
                        <li class='sidebar-toggler-wrapper'>
                            <!--BEGIN SIDEBAR TOGGLER BUTTON-->
                            <div class='sidebar-toggler'>
                            </div>
                            <!--END SIDEBAR TOGGLER BUTTON-->
                        </li>

                        <form class='sidebar-search '></form>

                        <li class='start active open' id='home'>
                            <a href='Administracion.php'>
                                <i class='icon-home'></i>
                                <span class='title'>Inicio</span>
                                <span class='arrow '></span>
                            </a>
                        </li>

                         <!--//////////////////////MENU PARAMETROS GENERALES-->
                        <li class='nav-item' id='menu_op' >
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='fa fa-gears'></i>
                                <span class='title'>Parametros Generales</span>
                                <span class='arrow '></span>
                            </a>
                            <ul  class='sub-menu'>
                                <li class='nav-item'  id='menu_op_conf_emp'>
                                    <a href='Datos_compania/'>
                                        <i class='fa fa-building-o'></i>
                                        Datos De La Compañia
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class='nav-item' id='menu_user'>
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='icon-users'></i>
                                <span class='title'>Gesti&oacute;n de Usuarios</span>
                                <span class='arrow '></span>
                            </a>
                            <ul class='sub-menu'>
                                <li class='nav-item' id='menu_ges_usu'>
                                    <a href='Usuarios/'>
                                        <i class='icon-user'></i>
                                        Gestionar Usuarios
                                    </a>
                                </li>
                                <li class='nav-item' id='menu_ges_perf'>
                                    <a href='Perfiles/'>
                                        <i class='fa fa-user'></i>
                                        Gestionar Perfiles
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id='menu_logs' style='display:none;'>
                            <a href='Administracion/logs.php'>
                                <i class='icon-users'></i>
                                <span class='title'>Auditoria</span>
                                <span class='arrow '></span>
                            </a>
                        </li>

                    </ul>
                    <!-- END MENU LATERAL -->
                </div>
            </div>";
            $Menu_SubLeft = " <div class='page-sidebar-wrapper'>
                <div class='page-sidebar navbar-collapse collapse'>
                    <!-- BEGIN MENU LATERAL -->
                    <ul class='page-sidebar-menu' data-keep-expanded='false' data-auto-scroll='true' data-slide-speed='200'>
                        <li class='sidebar-toggler-wrapper'>
                            <!--BEGIN SIDEBAR TOGGLER BUTTON-->
                            <div class='sidebar-toggler'>
                            </div>
                            <!--END SIDEBAR TOGGLER BUTTON-->
                        </li>

                        <form class='sidebar-search '></form>

                        <li class='start active open' id='home'>
                            <a href='../Administracion.php'>
                                <i class='icon-home'></i>
                                <span class='title'>Inicio</span>
                                <span class='arrow '></span>
                            </a>
                        </li>
                            <li class='nav-item' id='menu_op' >
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='fa fa-gears'></i>
                                <span class='title'>Parametros Generales</span>
                                <span class='arrow '></span>
                            </a>
                            <ul class='sub-menu'>
                                <li  style='display:none;' class='nav-item'  id='menu_op_conf_emp'>
                                    <a href='../Datos_compania/'>
                                        <i class='fa fa-building-o'></i>
                                        Datos De La Compañia
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class='nav-item' id='menu_user'>
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='icon-users'></i>
                                <span class='title'>Gesti&oacute;n de Usuarios</span>
                                <span class='arrow '></span>
                            </a>
                            <ul class='sub-menu'>
                                <li class='nav-item' id='menu_ges_usu'>
                                    <a href='../Usuarios/'>
                                        <i class='icon-user'></i>
                                        Gestionar Usuarios
                                    </a>
                                </li>
                                <li  class='nav-item' id='menu_ges_perf'>
                                    <a href='../Perfiles/'>
                                        <i class='fa fa-user'></i>
                                        Gestionar Perfil
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id='menu_logs' style='display:none;'>
                            <a href='../Administracion/logs.php'>
                                <i class='icon-users'></i>
                                <span class='title'>Auditoria</span>
                                <span class='arrow '></span>
                            </a>
                        </li>
                    </ul>
                    <!-- END MENU LATERAL -->
                </div>
            </div>";

            $_SESSION['Footer'] = $Footer;
            $_SESSION['User_Login'] = $User_Login;
            $_SESSION['User_SubLogin'] = $User_SubLogin;
            $_SESSION['Menu_Left'] = $Menu_Left;
            $_SESSION['Menu_SubLeft'] = $Menu_SubLeft;
        } else {
            echo "next";
        }
    } else {
        echo "erro1";
    }
} else {
    if ($_POST["ori"] == "log") {
        $con = "SELECT usu.id_usuario idusu,
 usucom.usucompa_compania idusucom, usu.cue_alias alias, usu.cue_nombres nomb, usu.usu_maestro maes,usu.niv_codigo nivudu,
  comp.companias_login complog,comp.companias_descripcion compdesc
FROM
  usuarios AS usu
  INNER JOIN usucompa AS usucom
    ON usucom.usucompa_usuario = usu.cue_alias
  INNER JOIN companias AS comp
    ON comp.companias_id = usucom.usucompa_compania
WHERE cue_alias = '" . $_POST['USER'] . "'
  AND cue_pass = SHA1('" . $_POST['KEY'] . "')
  AND comp.companias_login = '" . $_POST['COMP'] . "'
  AND comp.companias_clave = SHA1('" . $_POST['KEYCOMP'] . "')";
    } else {
        $con = "SELECT SELECT usu.id_usuario idusu,
 usucom.usucompa_compania idusucom, usu.cue_alias alias, usu.cue_nombres nomb, usu.usu_maestro maes,usu.niv_codigo nivudu,
  comp.companias_login complog,comp.companias_descripcion compdesc
FROM
  usuarios AS usu
  INNER JOIN usucompa AS usucom
    ON usucom.usucompa_usuario = usu.cue_alias
  INNER JOIN companias AS comp
    ON comp.companias_id = usucom.usucompa_compania
WHERE comp.companias_login = '" . $_POST['COMP'] . "'
  AND comp.companias_clave = SHA1('" . $_POST['KEYCOMP'] . "')";
    }
    

    $qc = mysqli_query($link, $con);
    $num = mysqli_num_rows($qc);

    if ($num > 0) {

        $fila = mysqli_fetch_array($qc);

        $_SESSION['ses_compa'] = $fila['compdesc'];
        $_SESSION['ses_nombre'] = $fila['nomb'];
        $_SESSION['ses_user'] = $_POST['USER'];
        $_SESSION['ses_nivel'] = $fila['nivudu'];
        $_SESSION['ses_idcomp'] = $fila['idusucom'];
        $_SESSION['ses_complog'] = $fila['complog'];
        $_SESSION['ses_idusu'] = $fila['idusu'];

/////////////////////////////////////
        if ($fila['maes'] == "") {
            $_SESSION['ses_nombd'] = "gmp_" . $fila['complog'];
        } else {
            $_SESSION['ses_nombd'] = "gmp_" . $fila['complog'];
        }

        $link = conectar();

        $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_POST['USER'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Entrada satisfactoria al sistema' ,'ENTRADA', 'login.php')";

        $qc = mysqli_query($link, $consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }

        if ($success == 0) {

            mysqli_query($link, "ROLLBACK");

            $_SESSION['ses_cpb'] = "no";

            echo "1";
        } else {

            mysqli_query($link, "ROLLBACK");

/////////// CONSULTAS PERMISOS////////
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfiles WHERE nomperfil='" . $_SESSION['ses_nivel'] . "'";

            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $idperfil = $fila['idperfil'];
                }
            }

////////PERMISOS PLAN DE DESARROLLO

            $permplan = "n";
            $_SESSION['permplan'] = "n";
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_plan WHERE idperf_perfil_plan='" . $idperfil . "'";
            // echo $consulta;
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_plan'] == "Ejes") {
                        $_SESSION['GesPlaVEj'] = $fila['visible_perfil_plan'];
                        $_SESSION['GesPlaAEj'] = $fila['add_perfil_plan'];
                        $_SESSION['GesPlaMEj'] = $fila['edit_perfil_plan'];
                        $_SESSION['GesPlaEEj'] = $fila['del_perfil_plan'];
                    }
                    if ($fila['descrip_perfil_plan'] == "Componentes") {
                        $_SESSION['GesPlaVCo'] = $fila['visible_perfil_plan'];
                        $_SESSION['GesPlaACo'] = $fila['add_perfil_plan'];
                        $_SESSION['GesPlaMCo'] = $fila['edit_perfil_plan'];
                        $_SESSION['GesPlaECo'] = $fila['del_perfil_plan'];
                    }

                    if ($fila['descrip_perfil_plan'] == "Programas") {
                        $_SESSION['GesPlaVPr'] = $fila['visible_perfil_plan'];
                        $_SESSION['GesPlaAPr'] = $fila['add_perfil_plan'];
                        $_SESSION['GesPlaMPr'] = $fila['edit_perfil_plan'];
                        $_SESSION['GesPlaEPr'] = $fila['del_perfil_plan'];
                    }

                    if ($fila['descrip_perfil_plan'] == "Metas") {
                        $_SESSION['GesPlaVMe'] = $fila['visible_perfil_plan'];
                        $_SESSION['GesPlaAMe'] = $fila['add_perfil_plan'];
                        $_SESSION['GesPlaMMe'] = $fila['edit_perfil_plan'];
                        $_SESSION['GesPlaEMe'] = $fila['del_perfil_plan'];
                    }

                    if ($fila['visible_perfil_plan'] == "s") {
                        $permplan = "s";
                        $_SESSION['permplan'] = "s";
                    }
                }
            }
//
            ////////PERMISOS PROYECTOS
            $permproy = "n";
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_proy WHERE idperf_perfil_proy='" . $idperfil . "'";
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_proy'] == "Proyectos") {
                        $_SESSION['GesProyVPr'] = $fila['visible_perfil_proy'];
                        $_SESSION['GesProyAPr'] = $fila['add_perfil_proy'];
                        $_SESSION['GesProyMPr'] = $fila['edit_perfil_proy'];
                        $_SESSION['GesProyEPr'] = $fila['del_perfil_proy'];
                    }

                    if ($fila['descrip_perfil_proy'] == "Contratos") {
                        $_SESSION['GesProyVCo'] = $fila['visible_perfil_proy'];
                        $_SESSION['GesProyACo'] = $fila['add_perfil_proy'];
                        $_SESSION['GesProyMCo'] = $fila['edit_perfil_proy'];
                        $_SESSION['GesProyECo'] = $fila['del_perfil_proy'];
                    }

                    if ($fila['descrip_perfil_proy'] == "Medir Indicador") {
                        $_SESSION['GesProyVMe'] = $fila['visible_perfil_proy'];
                        $_SESSION['GesProyAMe'] = $fila['add_perfil_proy'];
                        $_SESSION['GesProyMMe'] = $fila['edit_perfil_proy'];
                        $_SESSION['GesProyEMe'] = $fila['del_perfil_proy'];
                    }

                    if ($fila['visible_perfil_proy'] == "s") {
                        $permproy = "s";
                    }
                }
            }
//
            ////////PERMISOS INFORMES
            $perminf = "n";
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_inf WHERE idperf_perfil_inf='" . $idperfil . "'";
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_inf'] == "Informes") {
                        $_SESSION['GesInfVIn'] = $fila['visible_perfil_inf'];
                        $_SESSION['GesInfAIn'] = $fila['add_perfil_inf'];
                        $_SESSION['GesInfMIn'] = $fila['edit_perfil_inf'];
                        $_SESSION['GesInfEIn'] = $fila['del_perfil_inf'];
                    }
                    if ($fila['visible_perfil_inf'] == "s") {
                        $perminf = "s";
                    }
                }
            }
//
            ////////PERMISOS EVALUACION
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_eval WHERE idperf_perfil_eval='" . $idperfil . "'";

            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_eval'] == "Evaluacion") {
                        $_SESSION['GesEvaVEv'] = $fila['visible_perfil_eval'];
                        $_SESSION['GesEvaAEv'] = $fila['add_perfil_eval'];
                        $_SESSION['GesEvaMEv'] = $fila['edit_perfil_eval'];
                        $_SESSION['GesEvaEEv'] = $fila['del_perfil_eval'];
                    }
                }
            }

//
            ////////PERMISOS PARAMETROS GENERALES
            $permpara = "n";
            $_SESSION['permpara'] = "n";
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_para WHERE idperf_perfil_para='" . $idperfil . "'";
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_para'] == "Compania") {
                        $_SESSION['GesParVCom'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParACom'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMCom'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParECom'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Dependencias") {
                        $_SESSION['GesParVDep'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParADep'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMDep'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParEDep'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Responsables") {
                        $_SESSION['GesParVRes'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParARes'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMRes'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParERes'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Supervisores") {
                        $_SESSION['GesParVSup'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParASup'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMSup'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParESup'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Interventores") {
                        $_SESSION['GesParVInt'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParAInt'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMInt'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParEInt'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Contratistas") {
                        $_SESSION['GesParVCon'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParACon'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMCon'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParECon'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Secretarias") {
                        $_SESSION['GesParVSec'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParASec'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMSec'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParESec'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Tipologia Proyectos") {
                        $_SESSION['GesParVTPr'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParATPr'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMTPr'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParETPr'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Tipologia Contratos") {
                        $_SESSION['GesParVTCr'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParATCr'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMTCr'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParETCr'] = $fila['del_perfil_para'];
                    }

                    if ($fila['descrip_perfil_para'] == "Consecutivos") {
                        $_SESSION['GesParVCsc'] = $fila['visible_perfil_para'];
                        $_SESSION['GesParACsc'] = $fila['add_perfil_para'];
                        $_SESSION['GesParMCsc'] = $fila['edit_perfil_para'];
                        $_SESSION['GesParECsc'] = $fila['del_perfil_para'];
                    }

                    if ($fila['visible_perfil_para'] == "s") {
                        $permpara = "s";
                        $_SESSION['permpara'] = "s";
                    }
                }
            }

////////PERMISOS USUARIOS
            $permusu = "n";
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_usu WHERE idperf_perfil_usu='" . $idperfil . "'";
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_usu'] == "Usuarios") {
                        $_SESSION['GesUsuVUs'] = $fila['visible_perfil_usu'];
                        $_SESSION['GesUsuAUs'] = $fila['add_perfil_usu'];
                        $_SESSION['GesUsuMUs'] = $fila['edit_perfil_usu'];
                        $_SESSION['GesUsuEUs'] = $fila['del_perfil_usu'];
                    }

                    if ($fila['descrip_perfil_usu'] == "Perfiles") {
                        $_SESSION['GesUsuVPe'] = $fila['visible_perfil_usu'];
                        $_SESSION['GesUsuAPe'] = $fila['add_perfil_usu'];
                        $_SESSION['GesUsuMPe'] = $fila['edit_perfil_usu'];
                        $_SESSION['GesUsuEPe'] = $fila['del_perfil_usu'];
                    }

                    if ($fila['visible_perfil_usu'] == "s") {
                        $permusu = "s";
                    }
                }
            }

////////PERMISOS AVANCES
            $permava = "n";
            $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfil_avan WHERE idperf_perfil_ava='" . $idperfil . "'";
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    if ($fila['descrip_perfil_ava'] == "Avances Proyectos") {
                        $_SESSION['GesAvaVPro'] = $fila['visible_perfil_ava'];
                        $_SESSION['GesAvaAPro'] = $fila['add_perfil_ava'];
                        $_SESSION['GesAvaMPro'] = $fila['edit_perfil_ava'];
                        $_SESSION['GesAvaEPro'] = $fila['del_perfil_ava'];
                    }

                    if ($fila['descrip_perfil_ava'] == "Avances de Contratos") {
                        $_SESSION['GesAvaVCont'] = $fila['visible_perfil_ava'];
                        $_SESSION['GesAvaACont'] = $fila['add_perfil_ava'];
                        $_SESSION['GesAvaMCont'] = $fila['edit_perfil_ava'];
                        $_SESSION['GesAvaECont'] = $fila['del_perfil_ava'];
                    }
                    if ($fila['visible_perfil_ava'] == "s") {
                        $permava = "s";
                    }
                }
            }

            $Footer = "<div class='page-footer'>
                         <div class='page-footer-inner'>
                             Copyright &copy;<script>document.write(new Date().getFullYear());</script> Leer Ingenieria S.A.S
                         </div>
                         <div class='scroll-to-top'>
                             <i class='icon-arrow-up'></i>
                         </div>
                     </div>";
            $NAle = 0;
            $consulta = "SELECT num_contrato ncont, ffin_contrato ffi  FROM " . $_SESSION['ses_nombd'] . ".contratos WHERE estad_contrato='Ejecucion' AND
                DATE(ffin_contrato)  < DATE_FORMAT(DATE(NOW()),'%Y-%m-%d')   AND id_contrato IN(
                SELECT MAX(id_contrato) FROM contratos  GROUP BY num_contrato)";
            $resultado = mysqli_query($link, $consulta);
            $NAle = mysqli_num_rows($resultado);

            $User_Login = "<li class='dropdown' id='header_notification_bar'>
                           <a href='#' class='dropdown-toggle' data-toggle='dropdown'>

                               <i class='fa fa-bell'></i>
                               <span class='badge badge-warning'>" . $NAle . "</span>
                           </a>
                           <ul class='dropdown-menu extended notification'>
                               <li>
                                   <p style='padding-left:10px;'>Existen " . $NAle . " Contratos Vencidos</p>
                               </li>";

            if ($NAle > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $User_Login .= "<li >
                                   <a href='#'>
                                       <span class='label label-warning'><i class='icon-clock'></i></span>
                                       " . $fila['ncont'] . "
                                        - <span class='small italic'>Fecha de Vencimiento: " . $fila['ffi'] . "</span>
                                   </a>
                               </li>";
                }
            }

            $User_Login .= "<li style='background-color:#F6F6F6;'>
                                   <a href='Proyecto/Contratos.php?Ori=CV'>
<span class='label label-info'><i class='fa fa-hand-o-right'></i></span>
Mostrar Contratos</a>

                               </li></ul>
                       </li>

  <li class='dropdown dropdown-user'>
                         <a href='javascript:;' class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                             <img class='img-circle' src='Img/Compa.png' alt=''/>
                             <span class='username'>
                                " . $_SESSION['ses_compa'] . "
                            </span>

                         </a>";

            $User_Login = $User_Login . "</li>
            <li class='dropdown dropdown-user' >
            <a class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                <img class='img-circle' src='Img/Usuarios/".$_SESSION['cue_foto']."' alt=''/>
                <span class='username'>
                   " . $_SESSION['ses_nombre'] . "
               </span>
                <i class='fa fa-angle-left'></i>
            </a>
            <ul class='dropdown-menu'>
               <li><a href='MiPerfil/'><i class='fa fa-user'></i> Mi perfil</a></li>
               <li class='divider'></li>
               <li><a target='_blank' href='Administracion/Manual_Usuario.pdf' id='trigger_fullscreen'><i class='fa fa-book'></i> Manual de usuario</a></li>
               <li><a href='cerrar.php'><i class='fa fa-sign-out'></i>  Cerrar Sesi&oacute;n</a></li>
           </ul>
        </li>";

            $consulta = "SELECT num_contrato ncont, ffin_contrato ffi  FROM " . $_SESSION['ses_nombd'] . ".contratos WHERE estad_contrato='Ejecucion' AND
                DATE(ffin_contrato)  < DATE_FORMAT(DATE(NOW()),'%Y-%m-%d')   AND id_contrato IN(
                SELECT MAX(id_contrato) FROM contratos  GROUP BY num_contrato)";
            $resultado = mysqli_query($link, $consulta);
            $NAle = mysqli_num_rows($resultado);

            $User_SubLogin = "
                <li class='dropdown' id='header_notification_bar'>
                           <a href='#' class='dropdown-toggle' data-toggle='dropdown'>

                               <i class='fa fa-bell'></i>
                               <span class='badge badge-warning'>" . $NAle . "</span>
                           </a>
                           <ul class='dropdown-menu extended notification'>
                               <li>
                                   <p style='padding-left:10px;'>Existen " . $NAle . " Contratos Vencidos</p>
                               </li>";

            if ($NAle > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $User_SubLogin .= "<li >
                                   <a href='#'>
                                       <span class='label label-warning'><i class='icon-clock'></i></span>
                                       " . $fila['ncont'] . "
                                        - <span class='small italic'>Fecha de Vencimiento: " . $fila['ffi'] . "</span>
                                   </a>
                               </li>";
                }
            }

            $User_SubLogin .= "<li style='background-color:#F6F6F6;'>
                                   <a href='../Proyecto/Contratos.php?Ori=CV'>
                                    <span class='label label-info'><i class='fa fa-hand-o-right'></i></span>
                                    Mostrar Contratos</a>
                               </li></ul>
                       </li>

 
 <li class='dropdown dropdown-user'>
                         <a href='javascript:;' class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                             <img class='img-circle' src='../Img/Compa.png' alt=''/>
                             <span class='username'>
                                " . $_SESSION['ses_compa'] . "
                            </span>
                           
                         </a>";

            $User_SubLogin = $User_SubLogin . "</li>
            <li class='dropdown dropdown-user' >
            <a class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                <img class='img-circle' src='../Img/Usuarios/".$_SESSION['cue_foto']."' alt=''/>
                <span class='username'>
                   " . $_SESSION['ses_nombre'] . "
               </span>
                <i class='fa fa-angle-left'></i>
            </a>
            <ul class='dropdown-menu'>
               <li><a href='../MiPerfil/'><i class='fa fa-user'></i> Mi perfil</a></li>
               <li class='divider'></li>
               <li><a target='_blank' href='../Administracion/Manual_Usuario.pdf' id='trigger_fullscreen'><i class='fa fa-book'></i> Manual de usuario</a></li>
               <li><a href='../cerrar.php'><i class='fa fa-sign-out'></i>  Cerrar Sesi&oacute;n</a></li>
           </ul>
        </li>";

            $Menu_Left = " <div class='page-sidebar-wrapper'>
                <div class='page-sidebar navbar-collapse collapse'>
                    <!-- BEGIN MENU LATERAL -->
                    <ul class='page-sidebar-menu' data-keep-expanded='false' data-auto-scroll='true' data-slide-speed='200'>
                        <form class='sidebar-search '></form>

                        <li class='start active open' id='home'>
                            <a href='Administracion.php'>
                                <i class='icon-home'></i>
                                <span class='title'>Inicio</span>
                                <span class='arrow '></span>
                            </a>
                        </li>";

//                       MENU PLAN DE DESARROLLO
            if ($permplan == "s") {

                $Menu_Left .= " <li class='nav-item' id='menu_plan' >
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='fa fa-file-text-o'></i>
                                <span class='title'>Plan de Desarrollo</span>
                                <span class='arrow '></span>
                            </a>
                            <ul class='sub-menu'>";
                $Menu_Left .= " <li style='display: none;' class='nav-item' id='menu_plan_dime'>
                                    <a href='Dimensiones/'>
                                        <i class='fa fa-file-text-o'></i>
                                        Dimensiones
                                    </a>
                                </li>";

                if ($_SESSION['GesPlaVEj'] == "s") {
                    $Menu_Left .= " <li class='nav-item' id='menu_plan_ejes'>
                                    <a href='Ejes_Estrategicos/'>
                                        <i class='fa fa-file-text-o'></i>
                                        Ejes
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesPlaVCo'] == "s") {
                    $Menu_Left .= " <li class='nav-item'  id='menu_plan_Comp'>
                                    <a href='Programas/'>
                                        <i class='fa fa-file-text-o'></i>
                                      Programas
                                    </a>
                                </li>";
                }

                if ($_SESSION['GesPlaVPr'] == "s") {
                    $Menu_Left .= " <li class='nav-item' id='menu_subPrograma'>
							<a href='javascript:;' class='nav-link nav-toggle'>
							<i class='fa fa-file-text-o'></i> SubProgramas<span class='arrow'></span>
							</a>";
                    if ($_SESSION['GesPlaVMe'] == "s") {
                        $Menu_Left .= "<ul class='sub-menu'>
                                <li id='menu_GesSubPrograma'>
                                        <a href='SubProgramas/'><i class='fa fa-file-text-o'></i> Gestión SubProgramas</a>
                                </li>
                                <li id='menu_Metas'>
                                        <a href='Metas/'><i class='fa fa-file-text-o'></i> Metas Trazadoras</a>
                                </li>
                                <li id='menu_MetasProducto'>
                                                <a href='MetasProducto/'><i class='fa fa-file-text-o'></i>Metas de Producto</a>
                                </li>
                        </ul>";
                    }
                    $Menu_Left .= "</li>";
                }

                $Menu_Left .= "<li class='nav-item'  id='menu_plan_parametrizar'>
                <a href='ParametrizacionPlanDesarrollo/'>
                    <i class='fa fa-gears'></i>
                  Parametrizar
                 </a>
                </li>";

                $Menu_Left .= "</ul>
                        </li>";
            }
            if ($permproy == "s") {

                $Menu_Left .= "<li class='nav-item' id='menu_p_proy'>
					<a href='javascript:;' class='nav-link nav-toggle'>
					<i class='icon-folder'></i>
					<span class='title'>Gestión de Proyectos</span>
					<span class='arrow '></span>
					</a>
					<ul class='sub-menu'>";
                /////////////////OPCIONES PROYECTO

                if ($_SESSION['GesProyVPr'] == "s") {
                    $Menu_Left .= " <li  id='menu_p_proy_ges'>
							<a href='Proyectos/'>
							<i class='fa fa-file-text-o'></i>
							Gestión de Proyectos </a>
						</li>";
                }
                if ($_SESSION['GesProyVCo'] == "s") {
                    $Menu_Left .= "  <li  id='menu_p_Contra_ges'>
							<a href='Contratos/'>
							<i class='fa fa-file-text-o'></i>
							Gestión de Contratos</a>
						</li>";
                }
                if ($_SESSION['GesProyVMe'] == "s") {
                    $Menu_Left .= " <li class='nav-item' id='menu_p_proy_ind'>
							<a href='javascript:;' class='nav-link nav-toggle'>
							<i class='fa fa-line-chart'></i> Gestión de Indicadores <span class='arrow'></span>
							</a>
							<ul class='sub-menu'>
								<li id='menu_p_proy_ind_des'>
									<a href='Indicadores/HojaVidaIndicador.php'><i class='fa fa-file-text-o'></i>Descripción</a>
								</li>
								<li id='menu_p_proy_ind_Medi'>
										<a href='Indicadores/MedirIndicadorProyectos.php'><i class='fa fa-file-text-o'></i>Medición</a>

								</li>
								<li id='menu_p_proy_ind_Eva' >
                                                                   <a href='Indicadores/EvaluarIndicadorProyecto.php'><i class='fa fa-file-text-o'></i>Evaluación y Acciones</a>
								</li>

							</ul>
						</li>";
                }

                $Menu_Left .= " 		</ul>
				</li>";
            }
   
            //////////////AVANCES
            if ($permava == "s") {
                $Menu_Left .= " <li class='nav-item' id='menu_avances'>
					<a href='javascript:;' class='nav-link nav-toggle'>
					<i class='fa fa-cloud-upload'></i>
					<span class='title'>Gestión de Avances</span>
					<span class='arrow '></span>
					</a>
					<ul class='sub-menu'>";

                if ($_SESSION['GesAvaVPro'] == "s") {
                    $Menu_Left .= "                <li  id='menu_AvaProy'>
                                        <a href='Avance_Proyectos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Avances de Proyectos </a>
					</li>";
                }
                if ($_SESSION['GesAvaVCont'] == "s") {
                    $Menu_Left .= "                <li  id='menu_AvaCont'>
                                        <a href='Avance_Contratos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Avances de Contratos </a>
					</li>";
                }

                $Menu_Left .= "	</ul>
				</li>";
            }

            /////////////////OPCIONES INFORMES
            if ($perminf == "s") {
                $Menu_Left .= " <li class='nav-item' id='menu_reportes'>
					<a href='javascript:;' class='nav-link nav-toggle'>
					<i class='fa fa-pie-chart'></i>
					<span class='title'>Informes y Reportes</span>
					<span class='arrow '></span>
					</a>
					<ul class='sub-menu'>";

                if ($_SESSION['GesInfVIn'] == "s") {
                    $Menu_Left .= "                <li  id='menu_infproyec'>
                                        <a href='Informes_Proyectos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Informes de Proyectos </a>
					</li>";
                }
                if ($_SESSION['GesInfVIn'] == "s") {
                    $Menu_Left .= "                <li  id='menu_reporproyec'>
                                        <a href='Reportes_Proyectos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Reportes de Proyectos </a>
					</li>";
                }

                $Menu_Left .= "	</ul>
				</li>";
            }
            /////////////////OPCIONES EVALUACION CONTRATISTAS
            if ($_SESSION['GesEvaVEv'] == "s") {
                $Menu_Left .= " <li id='Menu_evalCont'>
                            <a href='Evaluacion_Contratista/'>
                                <i class='fa fa-thumbs-o-up'></i>
                                <span class='title'>Evaluación Contratista</span>
                                <span class='arrow '></span>
                            </a>
                        </li>";
            }

            if ($permpara == "s") {
                $Menu_Left .= "     <li class='nav-item' id='menu_op' >
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='fa fa-gears'></i>
                                <span class='title'>Parametros Generales</span>
                                <span class='arrow '></span>
                            </a>
                            <ul class='sub-menu'>";
                if ($_SESSION['GesParVCom'] == "s") {
                    $Menu_Left .= "<li style='display:none;' class='nav-item'  id='menu_op_conf_emp'>
                                    <a href='Datos_compania/'>
                                        <i class='fa fa-building-o'></i>
                                        Datos De La Compañia
                                    </a>
                                </li>";
                }

                if ($_SESSION['GesParVDep'] == "s") {
                    $Menu_Left .= "<li class='nav-item'  id='menu_op_Depe'>
                                    <a href='Dependencias/'>
                                        <i class='fa fa-sitemap'></i>
                                        Gestión de Dependencias
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesParVRes'] == "s") {
                    $Menu_Left .= "<li class='nav-item'  id='menu_op_responsa'>
                                    <a href='Responsables/'>
                                        <i class='fa fa-group'></i>
                                        Gestión de Responsables
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesParVSup'] == "s") {
                    $Menu_Left .= "<li class='nav-item'  id='menu_op_supervi'>
                                    <a href='Supervisores/'>
                                        <i class='fa fa-group'></i>
                                        Gestión de Supervisores
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesParVInt'] == "s") {
                    $Menu_Left .= " <li class='nav-item'  id='menu_op_intervent'>
                                    <a href='Interventores/'>
                                        <i class='fa fa-group'></i>
                                        Gestión de Interventores
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesParVCon'] == "s") {
                    $Menu_Left .= "<li class='nav-item'  id='menu_op_Contratis'>
                                    <a href='Contratistas/'>
                                        <i class='fa fa-group'></i>
                                        Gestión de Contratistas
                                    </a>
                                </li>";
                }

                if ($_SESSION['GesParVSec'] == "s") {
                    $Menu_Left .= "<li class='nav-item'  id='menu_op_secre'>
                                    <a href='Secretarias/'>
                                        <i class='fa fa-sitemap'></i>
                                        Gestión de Secretarias
                                    </a>
                                </li>";
                }

                $Menu_Left .= "<li class='nav-item' id='menu_op_fueinf'>
                                <a href='Fuentes/'>
                                    <i class='fa fa-bell'></i>
                                    Gesti&oacute;n de Fuente de Información
                                </a>
                            </li>";

                if ($_SESSION['GesParVTPr'] == "s") {
                    $Menu_Left .= " <li class='nav-item'  id='menu_op_Tipolo'>
                                    <a href='Tipologia_Proyectos/'>
                                        <i class='fa fa-cubes'></i>
                                       Tipología de Proyectos
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesParVTCr'] == "s") {
                    $Menu_Left .= "<li class='nav-item'  id='menu_op_TipoloCont'>
                                    <a href='Tipologia_Contratos/'>
                                        <i class='fa fa-cubes'></i>
                                       Tipología de Contratos
                                    </a>
                                </li>";
                }

                $Menu_Left .= "<li class='nav-item' id='menu_op_ffina'>
                                <a href='FuentesFinanciacion/'>
                                    <i class='fa fa-sitemap'></i>
                                    Gesti&oacute;n de Fuente de Financiación
                                </a>
                            </li>";

                            
                            $Menu_Left .= "<li class = 'nav-item' id = 'menu_op_Presupuesto'>
                            <a href = 'Presupuesto/'>
                            <i class = 'fa fa-usd '></i>
                            Gesti&oacute;n de Presupuesto
                            </a>
                            </li>";

                if ($_SESSION['GesParVCsc'] == "s") {
                    $Menu_Left .= "<li class='nav-item' id='menu_op_conse'>
                                            <a href='Consecutivos/'>
                                                <i class='fa fa-sort-numeric-asc'></i>
                                                 Gesti&oacute;n de Consecutivos
                                            </a>
                                        </li>";
                }

                $Menu_Left .= "<li class='nav-item' id='menu_op_conse'>
                                    <a href='Alertas/'>
                                        <i class='fa fa-bell'></i>
                                        Gesti&oacute;n de Alertas
                                    </a>
                                </li>";

                $Menu_Left .= "        </ul>
                        </li>";
            }
            if ($permusu == "s") {

                $Menu_Left .= "<li class='nav-item' id='menu_user'>
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='icon-users'></i>
                                <span class='title'>Gesti&oacute;n de Usuarios</span>
                                <span class='arrow '></span>
                            </a>";
                if ($_SESSION['GesUsuVUs'] == "s") {
                    $Menu_Left .= "    <ul class='sub-menu'>
                                <li class='nav-item' id='menu_ges_usu'>
                                    <a href='Usuarios/'>
                                        <i class='icon-user'></i>
                                        Gestionar Usuarios
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesUsuVPe'] == "s") {
                    $Menu_Left .= "<li class='nav-item' id='menu_ges_perf'>
                                    <a href='Perfiles/'>
                                        <i class='fa fa-user'></i>
                                        Gestionar Perfiles
                                    </a>
                                </li>";
                }

                $Menu_Left .= "       </ul>
                        </li>";
            }
            $Menu_Left .= "<li id='menu_logs' style='display:none;'>
                            <a href='Administracion/logs.php'>
                                <i class='icon-users'></i>
                                <span class='title'>Auditoria</span>
                                <span class='arrow '></span>
                            </a>
                        </li>

                    </ul>
                    <!-- END MENU LATERAL -->
                </div>
            </div>";
            $Menu_SubLeft = " <div class='page-sidebar-wrapper'>
                <div class='page-sidebar navbar-collapse collapse'>
                    <!-- BEGIN MENU LATERAL -->
                    <ul class='page-sidebar-menu' data-keep-expanded='false' data-auto-scroll='true' data-slide-speed='200'>

                        <form class='sidebar-search '></form>

                        <li class='start active open' id='home'>
                            <a href='../Administracion.php'>
                                <i class='icon-home'></i>
                                <span class='title'>Inicio</span>
                                <span class='arrow '></span>
                            </a>
                        </li>";

//            <!--//////////////////////MENU PLAN DE DESARROLLO-->
            if ($permplan == "s") {
                $Menu_SubLeft .= "  <li class='nav-item' id='menu_plan' >
                            <a href='#' class='nav-link nav-toggle'>
                                <i class='fa fa-file-text-o'></i>
                                <span class='title'>Plan de Desarrollo</span>
                                <span class='arrow '></span>
                            </a>
                            <ul class='sub-menu'>";

                $Menu_SubLeft .= " <li style='display: none;' class='nav-item' id='menu_plan_dime'>
                                    <a href='../Dimensiones/'>
                                        <i class='fa fa-file-text-o'></i>
                                        Dimensiones
                                    </a>
                                </li>";

                if ($_SESSION['GesPlaVEj'] == "s") {
                    $Menu_SubLeft .= " <li class='nav-item' id='menu_plan_ejes'>
                                    <a href='../Ejes_Estrategicos/'>
                                        <i class='fa fa-file-text-o'></i>
                                        Ejes
                                    </a>
                                </li>";
                }
                if ($_SESSION['GesPlaVCo'] == "s") {
                    $Menu_SubLeft .= " <li class='nav-item'  id='menu_plan_Comp'>
                                    <a href='../Programas/'>
                                        <i class='fa fa-file-text-o'></i>
                                      Programas
                                    </a>
                                </li>";
                }

                if ($_SESSION['GesPlaVPr'] == "s") {
                    $Menu_SubLeft .= " <li class='nav-item' id='menu_subPrograma'>
							<a href='javascript:;' class='nav-link nav-toggle'>
							<i class='fa fa-file-text-o'></i> SubProgramas<span class='arrow'></span>
							</a>";
                    if ($_SESSION['GesPlaVMe'] == "s") {
                        $Menu_SubLeft .= "<ul class='sub-menu'>
                                <li id='menu_GesSubPrograma'>
                                        <a href='../SubProgramas/'><i class='fa fa-file-text-o'></i> Gestión SubProgramas</a>
                                </li>
                                <li id='menu_Metas'>
                                        <a href='../Metas/'><i class='fa fa-file-text-o'></i> Metas Trazadoras</a>
                                </li>
                                <li id='menu_MetasProducto'>
                                                <a href='../MetasProducto/'><i class='fa fa-file-text-o'></i>Metas de Producto</a>
                                </li>
                        </ul>";
                    }
                    $Menu_SubLeft .= "</li>";
                }


                $Menu_SubLeft .= "<li class='nav-item'  id='menu_plan_parametrizar'>
                <a href='../ParametrizacionPlanDesarrollo/'>
                    <i class='fa fa-gears'></i>
                  Parametrizar
                 </a>
                </li>";

                $Menu_SubLeft .= "              </ul>
                        </li>";
            }

            if ($permproy == "s") {
                $Menu_SubLeft .= "<li class='nav-item' id='menu_p_proy'>
					<a href='javascript:;' class='nav-link nav-toggle'>
					<i class='icon-folder'></i>
					<span class='title'>Gestión de Proyectos</span>
					<span class='arrow '></span>
					</a>
					<ul class='sub-menu'>";
                if ($_SESSION['GesProyVPr'] == "s") {
                    $Menu_SubLeft .= " <li  id='menu_p_proy_ges'>
							<a  href='../Proyectos/'>
							<i class='fa fa-file-text-o'></i>
							Gestión de Proyectos </a>
						</li>";
                }
                if ($_SESSION['GesProyVCo'] == "s") {
                    $Menu_SubLeft .= "  <li  id='menu_p_Contra_ges'>
							<a href='../Contratos/'>
							<i class='fa fa-file-text-o'></i>
							Gestión de Contratos</a>
						</li>";
                }
                if ($_SESSION['GesProyVMe'] == "s") {
                    $Menu_SubLeft .= "<li class='nav-item' id='menu_p_proy_ind'>
							<a href='javascript:;' class='nav-link nav-toggle'>
							<i class='fa fa-line-chart'></i> Gestión de Indicadores <span class='arrow'></span>
							</a>
							<ul class='sub-menu'>
								<li id='menu_p_proy_ind_des'>
									<a href='../Indicadores/HojaVidaIndicador.php'><i class='fa fa-file-text-o'></i>Descripción</a>
								</li>
								<li id='menu_p_proy_ind_Medi'>
										<a href='../Indicadores/MedirIndicadorProyectos.php'><i class='fa fa-file-text-o'></i>Medición</a>

								</li>
								<li id='menu_p_proy_ind_Eva'>
                                                                   <a href='../Indicadores/EvaluarIndicadorProyecto.php'><i class='fa fa-file-text-o'></i>Evaluación y Acciones</a>
								</li>

							</ul>
						</li>";
                }

                $Menu_SubLeft .= " 		</ul>
				</li>";
            }

            /////////////////OPCIONES PROYECTO RAPIDO
            //                $Menu_SubLeft .= "<li class='nav-item' id='menu_p_proyExp'>
            //                    <a href='javascript:;' class='nav-link nav-toggle'>
            //                    <i class='icon-folder'></i>
            //                    <span class='title'>Empalme Rapido</span>
            //                    <span class='arrow '></span>
            //                    </a>
            //                    <ul class='sub-menu'>";
            //
            //                if ($_SESSION['GesProyVPr'] == "s") {
            //                    $Menu_SubLeft .= " <li  id='menu_p_proy_exp'>
            //                            <a href='../ProyectosExpres/'>
            //                            <i class='fa fa-file-text-o'></i>
            //                             Proyectos y Contratos </a>
            //                        </li>";
            //                }
            //                if ($_SESSION['GesProyVCo'] == "s") {
            //                    $Menu_SubLeft .= "  <li  id='menu_p_Consul_exp'>
            //                            <a href='../ConsultasExpres/'>
            //                            <i class='fa fa-file-text-o'></i>
            //                            Consultas</a>
            //                        </li>";
            //                }
            //                 $Menu_SubLeft .= "         </ul>
            //                </li>";
            //
            //

            if ($permava == "s") {
                $Menu_SubLeft .= " <li class='nav-item' id='menu_avances'>
					<a href='javascript:;' class='nav-link nav-toggle'>
					<i class='fa fa-cloud-upload'></i>
					<span class='title'>Gestión de Avances</span>
					<span class='arrow '></span>
					</a>
					<ul class='sub-menu'>";

                if ($_SESSION['GesAvaVPro'] == "s") {
                    $Menu_SubLeft .= "                <li  id='menu_AvaProy'>
                                        <a href='../Avance_Proyectos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Avances de Proyectos </a>
					</li>";
                }
                if ($_SESSION['GesAvaVCont'] == "s") {
                    $Menu_SubLeft .= "                <li  id='menu_AvaCont'>
                                        <a href='../Avance_Contratos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Avances de Contratos </a>
					</li>";
                }

                $Menu_SubLeft .= "	</ul>
				</li>";
            }

            if ($perminf == "s") {
                $Menu_SubLeft .= "    <li class = 'nav-item' id = 'menu_informe'>
                    <a href = 'javascript:;' class = 'nav-link nav-toggle'>
                    <i class = 'fa fa-pie-chart'></i>
                    <span class = 'title'>Informes y Reportes</span>
                    <span class = 'arrow '></span>
                    </a>
                    <ul class = 'sub-menu'>";
                /////////////////OPCIONES INFORMES
                if ($_SESSION['GesInfVIn'] == "s") {
                    $Menu_SubLeft .= "                <li  id='menu_infproyec'>
                                        <a href='../Informes_Proyectos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Informes de Proyectos </a>
					</li>";
                }
                if ($_SESSION['GesInfVIn'] == "s") {
                    $Menu_SubLeft .= "                <li  id='menu_reporproyec'>
                                        <a href='../Reportes_Proyectos/'>
                                        <i class='fa fa-angle-right'></i>
                                        Reportes de Proyectos </a>
					</li>";
                }

                $Menu_SubLeft .= " </ul>
                    </li>";
            }
            /////////////////OPCIONES EVALUACION CONTRATISTAS
            if ($_SESSION['GesEvaVEv'] == "s") {
                $Menu_SubLeft .= " <li id = 'Menu_evalCont'>
                    <a href = '../Evaluacion_Contratista/'>
                    <i class = 'fa fa-thumbs-o-up'></i>
                    <span class = 'title'>Evaluación Contratista</span>
                    <span class = 'arrow '></span>
                    </a>
                    </li>";
            }

            if ($permpara == "s") {
                $Menu_SubLeft .= " <li class = 'nav-item' id = 'menu_op' >
                    <a href = '#' class = 'nav-link nav-toggle'>
                    <i class = 'fa fa-gears'></i>
                    <span class = 'title'>Parametros Generales</span>
                    <span class = 'arrow '></span>
                    </a>
                    <ul class = 'sub-menu'>";
                if ($_SESSION['GesParVCom'] == "s") {
                    $Menu_SubLeft .= "<li style='display:none;' class = 'nav-item' id = 'menu_op_conf_emp'>
                    <a href = '../Datos_compania/'>
                    <i class = 'fa fa-building-o'></i>
                    Datos De La Compañia
                    </a>
                    </li>";
                }

                if ($_SESSION['GesParVDep'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_Depe'>
                    <a href = '../Dependencias/'>
                    <i class = 'fa fa-sitemap'></i>
                    Gestión de Dependencias
                    </a>
                    </li>";
                }
                if ($_SESSION['GesParVRes'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_responsa'>
                    <a href = '../Responsables/'>
                    <i class = 'fa fa-group'></i>
                    Gestión de Responsables
                    </a>
                    </li>";
                }
                if ($_SESSION['GesParVSup'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_supervi'>
                    <a href = '../Supervisores/'>
                    <i class = 'fa fa-group'></i>
                    Gestión de Supervisores
                    </a>
                    </li>";
                }
                if ($_SESSION['GesParVInt'] == "s") {
                    $Menu_SubLeft .= " <li class = 'nav-item' id = 'menu_op_intervent'>
                    <a href = '../Interventores/'>
                    <i class = 'fa fa-group'></i>
                    Gestión de Interventores
                    </a>
                    </li>";
                }
                if ($_SESSION['GesParVCon'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_Contratis'>
                    <a href = '../Contratistas/'>
                    <i class = 'fa fa-group'></i>
                    Gestión de Contratistas
                    </a>
                    </li>";
                }

                if ($_SESSION['GesParVSec'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_secre'>
                    <a href = '../Secretarias/'>
                    <i class = 'fa fa-sitemap'></i>
                    Gestión de Secretarias
                    </a>
                    </li>";
                }

                $Menu_SubLeft .= "<li class='nav-item' id='menu_op_fueinf'>
                                <a href='../Fuentes/'>
                                    <i class='fa fa-sitemap'></i>
                                    Gesti&oacute;n de Fuente de Información
                                </a>
                            </li>";

                if ($_SESSION['GesParVTPr'] == "s") {
                    $Menu_SubLeft .= " <li class = 'nav-item' id = 'menu_op_Tipolo'>
                    <a href = '../Tipologia_Proyectos/'>
                    <i class = 'fa fa-cubes'></i>
                    Tipología de Proyectos
                    </a>
                    </li>";
                }
                if ($_SESSION['GesParVTCr'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_TipoloCont'>
                    <a href = '../Tipologia_Contratos/'>
                    <i class = 'fa fa-cubes'></i>
                    Tipología de Contratos
                    </a>
                    </li>";
                }
                $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_ffina'>
                                    <a href = '../FuentesFinanciacion/'>
                                    <i class = 'fa fa-sitemap'></i>
                                    Gesti&oacute;n de Fuentes de financiación
                                    </a>
                                    </li>";

                                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_Presupuesto'>
                                    <a href = '../Presupuesto/'>
                                    <i class = 'fa fa-usd '></i>
                                    Gesti&oacute;n de Presupuesto
                                    </a>
                                    </li>";

                if ($_SESSION['GesParVCsc'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_conse'>
                    <a href = '../Consecutivos/'>
                    <i class = 'fa fa-sort-numeric-asc'></i>
                    Gesti&oacute;n de Consecutivos
                    </a>
                    </li>";
                }

                $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_op_conse'>
                                    <a href = '../Alertas/'>
                                    <i class = 'fa fa-bell'></i>
                                    Gesti&oacute;n de Alertas
                                    </a>
                                    </li>";

                $Menu_SubLeft .= " </ul>
                    </li>";
            }
            if ($permusu == "s") {
                $Menu_SubLeft .= " <li class = 'nav-item' id = 'menu_user'>
                    <a href = '#' class = 'nav-link nav-toggle'>
                    <i class = 'icon-users'></i>
                    <span class = 'title'>Gesti&oacute;
                    n de Usuarios</span>
                    <span class = 'arrow '></span>
                    </a>";
                if ($_SESSION['GesUsuVUs'] == "s") {
                    $Menu_SubLeft .= " <ul class = 'sub-menu'>
                    <li class = 'nav-item' id = 'menu_ges_usu'>
                    <a href = '../Usuarios/'>
                    <i class = 'icon-user'></i>
                    Gestionar Usuarios
                    </a>
                    </li>";
                }
                if ($_SESSION['GesUsuVPe'] == "s") {
                    $Menu_SubLeft .= "<li class = 'nav-item' id = 'menu_ges_perf'>
                    <a href = '../Perfiles/'>
                    <i class = 'fa fa-user'></i>
                    Gestionar Perfiles
                    </a>
                    </li>";
                }

                $Menu_SubLeft .= " </ul>
                    </li>";
            }
            $Menu_SubLeft .= " <li id = 'menu_logs' style = 'display:none;'>
                    <a href = '../Administracion/logs.php'>
                    <i class = 'icon-users'></i>
                    <span class = 'title'>Auditoria</span>
                    <span class = 'arrow '></span>
                    </a>
                    </li>
                    </ul>
                    <!--END MENU LATERAL -->
                    </div>
                    </div>";

            $_SESSION['Footer'] = $Footer;
            $_SESSION['User_Login'] = $User_Login;
            $_SESSION['User_SubLogin'] = $User_SubLogin;
            $_SESSION['Menu_Left'] = $Menu_Left;
            $_SESSION['Menu_SubLeft'] = $Menu_SubLeft;
        }
    } else {

        $_SESSION['ses_user'] = null;

//echo $con;

        $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
                    log_hora, log_accion, log_tipo, log_interfaz) VALUES('" . $_POST['USER'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', CURRENT_DATE(),
                    NOW(), 'Entrada fallida al sistema', 'ENTRADA', 'login.php')";

        $qc = mysqli_query($link, $consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }

        if ($success == 0) {

            mysqli_query($link, "ROLLBACK");
        } else {

            mysqli_query($link, "COMMIT");
        }

        $_SESSION['ses_cpb'] = "no";

        echo "1";
    }
}
