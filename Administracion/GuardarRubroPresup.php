<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO presupuesto_total VALUES(null,'" . $_POST['fuente'] . "','" . $_POST['txt_PresTotal'] . "',"
        . "'" . $_POST['txtFecRegistro'] . "','" . trim($_POST['CbPeriodoI']) . "','" . trim($_POST['CbPeriodoF']) . "','" . $_POST['txt_obser'] . "','ACTIVO')";

    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(id) AS id FROM presupuesto_total";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_presupuesto = $fila["id"];
        }
    }

    $datSubfuente = json_decode($_POST['Dat_Subfuente'], true);

    foreach ($datSubfuente as $item) {
        $parts = explode('//', $item);


        $consulta2 = "INSERT INTO detalle_presupuesto VALUES(null,'" .  $id_presupuesto . "','" . $_POST['fuente'] . "','" . $parts[0] . "','" . $parts[1] . "','0')";

        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  presupuesto_total SET fuente='" . $_POST['fuente'] . "',valor='" . $_POST['txt_PresTotal'] . "',"
        . "observacion='" . $_POST['txt_obser'] . "',fecha_recepcion='" . trim($_POST['txtFecRegistro']) . "',periodo_ini='" . trim($_POST['CbPeriodoI']) . "',periodo_fin='" . $_POST['CbPeriodoF'] . "' "
        . "WHERE id='" . $_POST['id'] . "'";

    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }


    $datSubfuente = json_decode($_POST['Dat_Subfuente'], true);
    foreach ($datSubfuente as $item) {
        $parts = explode('//', $item);

        $consulta = "select * from detalle_presupuesto where id='".$parts[2]."'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
           $sql = "UPDATE detalle_presupuesto SET presupuesto='" . $_POST['id'] . "',fuente='" . $_POST['fuente'] . "',subfuente='" . $parts[0] . "',valor='" . $parts[1] . "' WHERE id='".$parts[2]."'";
        }else{
            $sql = "INSERT INTO detalle_presupuesto VALUES(null,'" .  $_POST['id']  . "','" . $_POST['fuente'] . "','" . $parts[0] . "','" . $parts[1] . "','0')";

        }
        $qc = mysqli_query($link, $sql);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }

} else {

    $consulta = "UPDATE presupuesto_total SET estado='ELIMINADO' WHERE id='" . $_POST['id'] . "' ";
    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }
    $consulta = "DELETE FROM detalle_presupuesto  WHERE presupuesto='" . $_POST['id'] . "' ";
    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }
}



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Rubro Presupuestal " . $_POST['fuente'] . "' ,'INSERCION', 'GestionRubroPresupuestal.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Rubro Presupuestal " . $_POST['id'] . "' ,'ACTUALIZACION', 'GestionRubroPresupuestal.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Rubro Presupuestal
            " . $_POST['id'] . "' ,'ELIMINACION', 'GestionRubroPresupuestal.php')";
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
