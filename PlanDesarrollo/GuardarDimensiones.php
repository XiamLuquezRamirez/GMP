<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO dimensiones VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "','" . $_POST['obs'] . "','ACTIVO','" . $_POST['url'] . "')";
    $qc1 = mysqli_query($link, $consulta);

    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }
    $consulta = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='DIMENSIONES'";
    mysqli_query($link, $consulta);
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE dimensiones SET codigo='" . $_POST['cod'] . "',descripcion='" . $_POST['des'] . "',"
            . "observacion='" . $_POST['obs'] . "',IMG='" . $_POST['url'] . "' WHERE id='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }
} else {

    $consulta = "UPDATE dimensiones SET estado='ELIMINADO' WHERE id='" . $_POST['cod'] . "' ";
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
            NOW(),'Registro de Dimensiones " . $_POST['cod'] . "' ,'INSERCION', 'Dimensiones.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Dimensiones " . $_POST['cod'] . "' ,'ACTUALIZACION', 'Dimensiones.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Dimensiones
            " . $_POST['cod'] . "' ,'ELIMINACION', 'Dimensiones.php')";
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