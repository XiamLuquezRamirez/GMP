<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO tipologia_proyecto VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "',"
            . "'" . $_POST['obs'] . "','ACTIVO','" . $_POST['url'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  tipologia_proyecto SET cod_tipolo='" . $_POST['cod'] . "',des_tipolo='" . $_POST['des'] . "',"
            . "obs_tipolo='" . $_POST['obs'] . "',img_tipolo='" . $_POST['url'] . "' WHERE id_tipolo='" . $_POST['id'] . "'";
} else {
   
    $consulta = "SELECT * FROM proyectos WHERE tipol_proyect='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    $consulta = "UPDATE tipologia_proyecto SET est_tipolo='ELIMINADO' WHERE id_tipolo='" . $_POST['cod'] . "' ";
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
            NOW(),'Registro de Tipología de Proyecto " . $_POST['des'] . "' ,'INSERCION', 'GestionTipologia.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Tipología de Proyecto " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionTipologia.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Tipología de Proyecto
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionTipologia.php')";
}

$qc = mysqli_query($link,$consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

$id_tip = "";
$sql = "SELECT MAX(id_tipolo) AS id FROM tipologia_proyecto";
$resulsql = mysqli_query($link,$sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_tip = $fila["id"];
    }
}

if ($success == 0) {
    mysqli_query($link,"ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link,"COMMIT");
    echo "bien-" . $id_tip;
}

mysqli_close($link);
?>