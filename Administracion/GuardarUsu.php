<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");

if ($_POST['acc']!="3") {
    $maes = $_POST['cbx_UsuMaes'];

    if ($maes == "*") {
        $maes = $_SESSION['ses_user'];
    }
}

if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".usuarios VALUES(null,'" . $_POST['txt_usuid'] . "','" . $_POST['txt_usunom'] . "','" . $_POST['cbx_sexo'] . "',
           '" . $_POST['cbx_perf'] . "','" . $_POST['txt_usuusu'] . "',sha1('" . $_POST['txt_usucon1'] . "'),'" . $_POST['cbx_estado'] . "',"
            . "'" . $_POST['txt_usuemail'] . "','" . $_POST['txt_usuTel'] . "','" . $_POST['txt_usudir'] . "','" . $_POST['txt_ncompa'] . "','" . $maes . "')";
    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".usucompa (SELECT usucompa_compania, "
            . "'" . $_POST['txt_usuusu'] . "',null FROM ".$_SESSION['ses_BDBase'].".usucompa "
            . "WHERE usucompa_usuario='" . $maes . "')";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
} else if ($_POST['acc'] == "2") {
    if ($_POST['changPAss'] == "s") {
        $consulta = "UPDATE ".$_SESSION['ses_BDBase'].".usuarios SET cue_nombres='" . $_POST['txt_usunom'] . "',cue_sexo='" . $_POST['cbx_sexo'] . "',
           niv_codigo='" . $_POST['cbx_perf'] . "',cue_alias='" . $_POST['txt_usuusu'] . "',cue_pass=sha1('" . $_POST['txt_usucon1'] . "'),cue_estado='" . $_POST['cbx_estado'] . "',"
                . "cue_correo='" . $_POST['txt_usuemail'] . "',cue_tele='" . $_POST['txt_usuTel'] . "',cue_dir='" . $_POST['txt_usudir'] . "' where cue_alias='" . $_POST['txt_usuusu'] . "'";
        // echo $consulta;
        $qc = mysqli_query($link, $consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        $consulta = "UPDATE ".$_SESSION['ses_BDBase'].".usuarios SET cue_nombres='" . $_POST['txt_usunom'] . "',cue_sexo='" . $_POST['cbx_sexo'] . "',
           niv_codigo='" . $_POST['cbx_perf'] . "',cue_alias='" . $_POST['txt_usuusu'] . "',cue_estado='" . $_POST['cbx_estado'] . "',"
                . "cue_correo='" . $_POST['txt_usuemail'] . "',cue_tele='" . $_POST['txt_usuTel'] . "',cue_dir='" . $_POST['txt_usudir'] . "' where cue_alias='" . $_POST['txt_usuusu'] . "'";
        // echo $consulta;
        $qc = mysqli_query($link, $consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    }
} else {
    $consulta = "UPDATE ".$_SESSION['ses_BDBase'].".usuarios SET cue_estado='ELIMINADO' WHERE cue_alias='" . $_POST['cod'] . "' ";
    
    // echo $consulta;
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
}




if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Usuario " . $_POST['txt_usuid'] . "-" . $_POST['txt_usunom'] . "' ,'INSERCION', 'GestionUsuario.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Usuario " . $_POST['txt_usuid'] . "-" . $_POST['txt_usunom'] . "' ,'ACTUALIZACION', 'GestionUsuario.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Usuario " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionUsuario.php')";
}



$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien";
}

mysqli_close($link);
?>