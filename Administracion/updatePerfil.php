<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
$flag = "s";

$myDat = new stdClass();


    $consulta = "UPDATE  " . $_SESSION['ses_BDBase'] . ".usuarios SET cue_inden='" . $_POST['txt_identi'] . "',cue_nombres='" . $_POST['txt_usunom'] . "',"
        . "cue_sexo='" . $_POST['cbx_sexo'] . "',cue_correo='" . $_POST['txt_usuemail'] . "',"
        . "cue_tele='" . $_POST['txt_usuTel'] . "',cue_dir='" . $_POST['txt_usudir'] . "' WHERE id_usuario='" . $_POST['idusu'] . "'";
    
        $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de información de perfil de usuario " . $_POST['txt_usunom'] . "' ,'ACTUALIZACION', 'perfil.php')";


    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }




if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
    $myDat->error =  $error;
} else {
    mysqli_query($link, "COMMIT");
    $myDat->estado = "bien";
}

echo json_encode($myDat);

mysqli_close($link);
