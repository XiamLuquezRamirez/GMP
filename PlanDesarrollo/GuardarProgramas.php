<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();

mysqli_query($link,"BEGIN");
mysqli_set_charset($link,'utf8');
$flag = "s";


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO programas VALUES(null,'" . $_POST['idej'] . "','" . $_POST['ides'] . "',"
            . "'" . $_POST['cod'] . "','" . $_POST['des'] . "','" . $_POST['obs'] . "','" . $_POST['url'] . "','ACTIVO')";
    
    $qc1 = mysqli_query($link,$consulta);

    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }
    $consulta1 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='PROGRAMAS'";
    
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE programas SET CODIGO='" . $_POST['cod'] . "',ID_EJE='" . $_POST['idej'] . "',"
            . "ID_COMP='" . $_POST['ides'] . "',NOMBRE='" . $_POST['des'] . "',"
            . "OBSERVACIONES='" . $_POST['obs'] . "',IMG='" . $_POST['url'] . "' WHERE ID='" . $_POST['id'] . "'";
       $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }
    

    $consulta1 = "UPDATE metas SET des_prog_metas=concat('" . $_POST['cod'] . "',' - ','" . $_POST['des'] . "') WHERE idprog_metas='" . $_POST['id'] . "'";


} else {
    $consulta = "SELECT * FROM metas WHERE idprog_metas='" . $_POST['cod'] . "' and estado_metas='ACTIVO'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    $consulta1 = "UPDATE programas SET ESTADO='ELIMINADO' WHERE ID='" . $_POST['cod'] . "' ";
}

if ($flag == "s") {
    $qc = mysqli_query($link,$consulta1);

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
            NOW(),'Registro de Programas " . $_POST['cod'] . "' ,'INSERCION', 'Programas.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Programas " . $_POST['cod'] . "' ,'ACTUALIZACION', 'Programas.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Programas
            " . $_POST['cod'] . "' ,'ELIMINACION', 'Programas.php')";
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