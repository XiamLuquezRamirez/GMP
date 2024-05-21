<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysql_query("BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO rubro_presupestal VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['rub'] . "','" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  rubro_presupestal SET cod_rubro='" . $_POST['cod'] . "',nom_rubro='" . $_POST['des'] . "',"
            . "monto_rubro='" . $_POST['rub'] . "',obs_rubro='" . $_POST['obs'] . "' "
            . "WHERE id_rubro='" . $_POST['id'] . "'";
} else {
    $consulta = "UPDATE rubro_presupestal SET estado='ELIMINADO' WHERE id_rubro='" . $_POST['cod'] . "' ";
}

// echo $consulta;
$qc = mysql_query($consulta, $link);

if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Rubro Presupuestal " . $_POST['des'] . "' ,'INSERCION', 'GestionRubroPresupuestal.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Rubro Presupuestal " . $_POST['iden'] . "' ,'ACTUALIZACION', 'GestionRubroPresupuestal.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Rubro Presupuestal
            " . $_POST['id'] . "' ,'ELIMINACION', 'GestionRubroPresupuestal.php')";
}

$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

if ($success == 0) {
    mysql_query("ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysql_query("COMMIT");
    echo "bien";
}

mysql_close();
?>