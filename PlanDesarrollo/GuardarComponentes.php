<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link,'utf8');
mysqli_query($link,"BEGIN");
$flag = "s";


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO componente VALUES(null,'" . $_POST['ide'] . "','" . $_POST['cod'] . "',"
            . "'" . $_POST['des'] . "','" . $_POST['obs'] . "','" . $_POST['url'] . "','ACTIVO')";
    
     $qc1 = mysqli_query($link,$consulta);

    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }

    $consulta1 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='COMPONENTES'";
   
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE componente SET CODIGO='" . $_POST['cod'] . "',ID_EJE='" . $_POST['ide'] . "',NOMBRE='" . $_POST['des'] . "',"
            . "OBSERVACIONES='" . $_POST['obs'] . "',IMG='" . $_POST['url'] . "' WHERE ID='" . $_POST['id'] . "'";
    $qc1 = mysqli_query($link,$consulta);
    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }

    $consulta1 = "UPDATE metas SET des_comp_metas=concat('" . $_POST['cod'] . "',' - ','" . $_POST['des'] . "') WHERE idcomp_metas='" . $_POST['id'] . "'";

    
} else {
    $consulta = "SELECT * FROM programas WHERE ID_COMP='" . $_POST['cod'] . "' and ESTADO='ACTIVO'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }

    $consulta1 = "UPDATE componente SET ESTADO='ELIMINADO' WHERE ID='" . $_POST['cod'] . "' ";
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
            NOW(),'Registro de Estretegias " . $_POST['cod'] . "' ,'INSERCION', 'Estrategias.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Estretegias " . $_POST['cod'] . "' ,'ACTUALIZACION', 'Estrategias.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Estretegias
            " . $_POST['cod'] . "' ,'ELIMINACION', 'Estrategias.php')";
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