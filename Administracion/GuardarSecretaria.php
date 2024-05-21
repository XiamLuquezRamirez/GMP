<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO secretarias VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['cbr'] . "','" . $_POST['cor'] . "','" . $_POST['obs'] . "','" . $_POST['url'] . "','ACTIVO','" . $_POST['col'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  secretarias SET cod_secretarias='" . $_POST['cod'] . "',des_secretarias='" . $_POST['des'] . "',"
            . "responsanble_secretarias='" . $_POST['cbr'] . "',correo_secretarias='" . $_POST['cor'] . "',"
            . "obs_secretarias='" . $_POST['obs'] . "',ico_secretarias='" . $_POST['url'] . "', color='" . $_POST['col'] . "' WHERE idsecretarias='" . $_POST['id'] . "'";
} else {
    $consulta = "SELECT * FROM proyectos WHERE secretaria_proyect='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    $consulta = "UPDATE secretarias SET estado_secretaria='ELIMINADO' WHERE idsecretarias='" . $_POST['cod'] . "' ";
}

if ($flag == "s") {
    $qc = mysqli_query($link,$consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else {
    echo $flag;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Cargos " . $_POST['cod'] . "' ,'INSERCION', 'GestionCargos.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Cargos " . $_POST['cod'] . "' ,'ACTUALIZACION', 'GestionCargos.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Cargos
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionCargos.php')";
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