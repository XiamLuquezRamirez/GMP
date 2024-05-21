<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");
$flag = "s";


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO interventores VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['cor'] . "','" . $_POST['tel'] . "','" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  interventores SET cod_interventores='" . $_POST['cod'] . "',nom_interventores='" . $_POST['des'] . "',"
            . "correo_interventores='" . $_POST['cor'] . "',telef_interventores='" . $_POST['tel'] . "',"
            . "obser_interventores='" . $_POST['obs'] . "' WHERE id_interventores='" . $_POST['id'] . "'";
} else {
    $consulta = "SELECT * FROM contratos WHERE idinterv_contrato='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    $consulta = "UPDATE interventores SET estado_interventores='ELIMINADO' WHERE id_interventores='" . $_POST['cod'] . "' ";
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
            NOW(),'Registro de Interventor " . $_POST['des'] . "' ,'INSERCION', 'GestionInterventores.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Interventor " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionInterventores.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Interventor
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionInterventores.php')";
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