<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO consecutivos VALUES(null,'" . $_POST['txt_Estr'] . "','" . $_POST['txt_Desc'] . "',"
            . "'" . $_POST['CbGrupo'] . "','" . $_POST['txt_ini'] . "','" . $_POST['txt_act'] . "',"
            . "'" . $_POST['CbVige'] . "','" . $_POST['txt_obser'] . "','" . $_POST['txt_EstrucEst'] . "','" . $_POST['Cbdigi'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  consecutivos SET estruct='" . $_POST['txt_Estr'] . "',descrip='" . $_POST['txt_Desc'] . "',"
            . "grupo='" . $_POST['CbGrupo'] . "',inicio='" . $_POST['txt_ini'] . "',actual='" . $_POST['txt_act'] . "',"
            . "vigencia='" . $_POST['CbVige'] . "',observ='" . $_POST['txt_obser'] . "',estr_fin='" . $_POST['txt_EstrucEst'] . "',digitos='" . $_POST['Cbdigi'] . "' WHERE id_conse='" . $_POST['id'] . "'";
} else {
    $consulta = "DELETE FROM  consecutivos WHERE id_conse='" . $_POST['cod'] . "' ";
}


// echo $consulta;
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Consecutivo " . $_POST['txt_Desc'] . "' ,'INSERCION', 'GesConsecutivos.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Consecutivo " . $_POST['id'] . "' ,'ACTUALIZACION', 'GesConsecutivos.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Consecutivo
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesConsecutivos.php')";
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