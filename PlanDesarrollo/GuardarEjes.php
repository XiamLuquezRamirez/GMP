<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link,'utf8');
mysqli_query($link, "BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO ejes VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "','" . $_POST['obs'] . "','" . $_POST['url'] . "','ACTIVO','" . $_POST['dime'] . "')";
    $qc1 = mysqli_query($link, $consulta);

    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }
    $consulta1 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='EJES'";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE ejes SET CODIGO='" . $_POST['cod'] . "',NOMBRE='" . $_POST['des'] . "',"
            . "OBSERVACIONES='" . $_POST['obs'] . "',IMG='" . $_POST['url'] . "',DIMENSION='" . $_POST['dime'] . "' WHERE ID='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }
    $consulta1 = "UPDATE metas SET des_eje_metas=concat('" . $_POST['cod'] . "',' - ','" . $_POST['des'] . "') WHERE ideje_metas='" . $_POST['id'] . "'";
} else {

    $consulta = "SELECT * FROM componente WHERE ID_EJE='" . $_POST['cod'] . "' and ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }

    $consulta1 = "UPDATE ejes SET ESTADO='ELIMINADO' WHERE ID='" . $_POST['cod'] . "' ";
}

if ($flag == "s") {
    $qc = mysqli_query($link, $consulta1);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else {
    echo "no";
}


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de ejes " . $_POST['cod'] . "' ,'INSERCION', 'GestionEjes.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Ejes " . $_POST['cod'] . "' ,'ACTUALIZACION', 'GestionEjes.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Ejes
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionEjes.php')";
}

$qc = mysqli_query($link, $consulta1);
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