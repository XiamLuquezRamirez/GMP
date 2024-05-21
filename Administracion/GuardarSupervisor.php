<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO supervisores VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['cor'] . "','" . $_POST['tel'] . "','" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  supervisores SET cod_supervisores='" . $_POST['cod'] . "',nom_supervisores='" . $_POST['des'] . "',"
            . "correo_supervisores='" . $_POST['cor'] . "',telef_supervisores='" . $_POST['tel'] . "',"
            . "obser_supervisores='" . $_POST['obs'] . "' WHERE id_supervisores='" . $_POST['id'] . "'";
} else {
    $consulta = "SELECT * FROM contratos WHERE idsuperv_contrato='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }

    $consulta = "UPDATE supervisores SET estado_supervisores='ELIMINADO' WHERE id_supervisores='" . $_POST['cod'] . "' ";
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
            NOW(),'Registro de Supervisor " . $_POST['des'] . "' ,'INSERCION', 'GestionSupervisores.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Supervisor " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionSupervisores.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Supervisor
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionSupervisores.php')";
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