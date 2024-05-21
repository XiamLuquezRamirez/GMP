<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");
mysqli_set_charset($link,'utf8');



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO responsables VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['cor'] . "','" . $_POST['tel'] . "','" . $_POST['obs'] . "','" . $_POST['depe'] . "','ACTIVO','" . $_POST['Usu'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  responsables SET cod_responsable='" . $_POST['cod'] . "',nom_responsable='" . $_POST['des'] . "',"
            . "email_responsable='" . $_POST['cor'] . "',tel_responsable='" . $_POST['tel'] . "',"
            . "obs_responsable='" . $_POST['obs'] . "',dependencia='" . $_POST['depe'] . "',usuario='" . $_POST['Usu'] . "' WHERE id_responsable='" . $_POST['id'] . "'";
} else {
    $consulta = "UPDATE responsables SET estado='ELIMINADO' WHERE id_responsable='" . $_POST['cod'] . "' ";
}

// echo $consulta;
$qc = mysqli_query($link,$consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Responsable " . $_POST['des'] . "' ,'INSERCION', 'GestionResponsable.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Responsable " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionResponsable.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Responsable
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionResponsable.php')";
}

$qc = mysqli_query($link,$consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

if ($success == 0) {
    mysqli_query($link,"ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link,"COMMIT");
    echo "bien";
}

mysqli_close($link);
?>