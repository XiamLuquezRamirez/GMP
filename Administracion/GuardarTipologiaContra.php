<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO tipo_contratacion VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  tipo_contratacion SET CODIGO='" . $_POST['cod'] . "',NOMBRE='" . $_POST['des'] . "',"
            . "OBSERVACIONES='" . $_POST['obs'] . "' WHERE ID='" . $_POST['id'] . "'";
} else {
    $consulta = "SELECT * FROM contratos WHERE idtipolg_contrato='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    $consulta = "UPDATE tipo_contratacion SET ESTADO='ELIMINADO' WHERE ID='" . $_POST['cod'] . "' ";
}

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
            NOW(),'Registro de Tipología de Contrato " . $_POST['des'] . "' ,'INSERCION', 'GestionTipologiaContrato.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Tipología de Contrato " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionTipologiaContrato.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Tipología de Contrato
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionTipologiaContrato.php')";
}

$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

$id_tip = "";
$sql = "SELECT MAX(id_tipolo) AS id FROM tipologia_proyecto";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_tip = $fila["id"];
    }
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien-" . $id_tip;
}

mysqli_close($link);
?>