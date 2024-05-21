<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

$flag = "s";


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO fuente_informacion VALUES(null,'" . $_POST['des'] . "','" . $_POST['obs'] . "','ACTIVO')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  fuente_informacion SET nombre='" . $_POST['des'] . "',descripcion='" . $_POST['obs'] . "' WHERE id='" . $_POST['id'] . "'";
} else {
    $consulta = "SELECT * FROM metas WHERE fuente_metas LIKE '%" . $_POST['cod'] . "%'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        $flag = "n";
    }
    $consulta = "UPDATE fuente_informacion SET estado='ELIMINADO' WHERE id='" . $_POST['cod'] . "' ";
}

//echo $consulta;

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
            NOW(),'Registro de Fuente de Información " . $_POST['des'] . "' ,'INSERCION', 'GestionFuentesInformacion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Fuente de Información " . $_POST['des'] . "' ,'ACTUALIZACION', 'GestionFuentesInformacion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Fuente de Información
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionFuentesInformacion.php')";
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