<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

$flag = "s";


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO dependencias VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['cor'] . "','" . $_POST['tel'] . "','" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  dependencias SET cod_dependencia='" . $_POST['cod'] . "',des_dependencia='" . $_POST['des'] . "',"
            . "correo_dependencia='" . $_POST['cor'] . "',tel_dependencia='" . $_POST['tel'] . "',obs_dependencia='" . $_POST['obs'] . "' WHERE iddependencias='" . $_POST['id'] . "'";
} else {
    $consulta = "SELECT * FROM metas WHERE respo_metas LIKE '%" . $_POST['cod'] . "%'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        $flag = "n";
    }
    $consulta = "SELECT * FROM responsables WHERE dependencia= '" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "r";
    }

    $consulta = "UPDATE dependencias SET estado='ELIMINADO' WHERE iddependencias='" . $_POST['cod'] . "' ";
}

// echo $consulta;

if ($flag == "s") {
    $qc = mysqli_query($link, $consulta);
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
            NOW(),'Registro de Dependencia " . $_POST['des'] . "' ,'INSERCION', 'GestionDependencia.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Dependencia " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionDependencia.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Dependencia
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionDependencia.php')";
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