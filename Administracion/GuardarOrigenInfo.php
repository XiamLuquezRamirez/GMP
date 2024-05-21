<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysql_query("BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO origen_informacion VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  origen_informacion SET cod_info='" . $_POST['cod'] . "',nomb_info='" . $_POST['des'] . "',"
            . "obser_info='" . $_POST['obs'] . "' WHERE id_info='" . $_POST['id'] . "'";
} else {
    $consulta = "UPDATE origen_informacion SET estado='ELIMINADO' WHERE id_info='" . $_POST['cod'] . "' ";
}

//echo $consulta;
$qc = mysql_query($consulta, $link);

if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Origen de Información " . $_POST['des'] . "' ,'INSERCION', 'GestionOrigenInformacion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Origen de Información " . $_POST['iden'] . "' ,'ACTUALIZACION', 'GestionOrigenInformacion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Origen de Información
            " . $_POST['id'] . "' ,'ELIMINACION', 'GestionOrigenInformacion.php')";
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