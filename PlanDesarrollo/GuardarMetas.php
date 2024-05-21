<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
$flag = "s";


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO metas VALUES(null,'" . $_POST['txt_Cod'] . "','" . $_POST['txt_Desc'] . "',"
            . "'" . $_POST['txt_LinBase'] . "','" . $_POST['txt_LinBase'] . "','" . $_POST['CbTipDato'] . "','" . $_POST['CbProMet'] . "',"
            . "'" . $_POST['CbEjes'] . "','" . $_POST['CbEjesDes'] . "','" . $_POST['CbEtrategias'] . "',"
            . "'" . $_POST['CbEtrategiasDes'] . "','" . $_POST['CbProgramas'] . "','" . $_POST['CbProgramasDes'] . "',"
            . "'" . $_POST['CbResponsa'] . "','ACTIVO','" . $_POST['txt_Meta'] . "','" . $_POST['CbFuente'] . "',"
            . "'" . $_POST['CbIndice'] . "','" . $_POST['CbClasif'] . "','" . $_POST['CbDerFund'] . "')";
    $qc1 = mysqli_query($link, $consulta);
    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_meta = "";
    $sql = "SELECT MAX(id_meta) AS id FROM metas";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_meta = $fila["id"];
        }
    }


    $consulta = "INSERT INTO semaforizacion_metas VALUES(null,'" . $id_meta . "','" . $_POST['txt_AcepMax'] . "',"
            . "'" . $_POST['txt_AcepMin'] . "','" . $_POST['txt_AcepDesc'] . "','" . $_POST['txt_RiesMax'] . "',"
            . "'" . $_POST['txt_RiesMin'] . "','" . $_POST['txt_RiesDesc'] . "','" . $_POST['txt_CritMax'] . "',"
            . "'" . $_POST['txt_CritMin'] . "','" . $_POST['txt_CritDesc'] . "')";
    $qc1 = mysqli_query($link, $consulta);
    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }


    $consulta1 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='METAS'";
    mysqli_query($link, $consulta1);

    /////GUARDAR PROYECCIONES////////
    $Tam_Proy = $_POST['Long_Proy'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Proy; $i++) {
        $consulta2 = "";
        $parProy = explode("//", $_POST['idProy' . $i]);
        $consulta2 = "INSERT INTO metas_proyeccion VALUES(null,'" . $id_meta . "','" . $parProy[0] . "','" . $parProy[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE metas SET cod_meta='" . $_POST['txt_Cod'] . "',desc_meta='" . $_POST['txt_Desc'] . "',"
            . "base_meta='" . $_POST['txt_LinBase'] . "',tipdato_metas='" . $_POST['CbTipDato'] . "',prop_metas='" . $_POST['CbProMet'] . "',"
            . "ideje_metas='" . $_POST['CbEjes'] . "',des_eje_metas='" . $_POST['CbEjesDes'] . "',idcomp_metas='" . $_POST['CbEtrategias'] . "',"
            . "des_comp_metas='" . $_POST['CbEtrategiasDes'] . "',idprog_metas='" . $_POST['CbProgramas'] . "',des_prog_metas='" . $_POST['CbProgramasDes'] . "',"
            . "respo_metas='" . $_POST['CbResponsa'] . "',meta='" . $_POST['txt_Meta'] . "',fuente_metas='" . $_POST['CbFuente'] . "',"
            . "indice_metas='" . $_POST['CbIndice'] . "',clasif_metas='" . $_POST['CbClasif'] . "',derec_metas='" . $_POST['CbDerFund'] . "' WHERE id_meta='" . $_POST['id'] . "'";
    $qc1 = mysqli_query($link, $consulta);
    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    /////////ACTUALIZAR PRYECCIÓNES
    $consulta = "DELETE FROM metas_proyeccion WHERE meta='" . $_POST['id'] . "'";
    mysqli_query($link, $consulta);

    $Tam_Proy = $_POST['Long_Proy'];
    for ($i = 1; $i <= $Tam_Proy; $i++) {
        $consulta2 = "";

        $parProy = explode("//", $_POST['idProy' . $i]);
        $consulta = "INSERT INTO metas_proyeccion VALUES(null,'" . $_POST['id'] . "','" . $parProy[0] . "','" . $parProy[1] . "')";
        $qc1 = mysqli_query($link, $consulta);
        if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }

    //////ACTUALZIAR SEMAFORIZACIÓN
    $consulta = "DELETE FROM semaforizacion_metas WHERE meta='" . $_POST['id'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "INSERT INTO semaforizacion_metas VALUES(null,'" . $_POST['id'] . "','" . $_POST['txt_AcepMax'] . "',"
            . "'" . $_POST['txt_AcepMin'] . "','" . $_POST['txt_AcepDesc'] . "','" . $_POST['txt_RiesMax'] . "',"
            . "'" . $_POST['txt_RiesMin'] . "','" . $_POST['txt_RiesDesc'] . "','" . $_POST['txt_CritMax'] . "',"
            . "'" . $_POST['txt_CritMin'] . "','" . $_POST['txt_CritDesc'] . "')";
    $qc1 = mysqli_query($link, $consulta);
    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
} else {
    $consulta = "SELECT * FROM proyect_metas WHERE id_meta='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }

    $consulta1 = "UPDATE metas SET estado_metas='ELIMINADO' WHERE id_meta='" . $_POST['cod'] . "'";
    if ($flag == "s") {
        $qc = mysqli_query($link, $consulta1);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo "no";
    }
}
//echo $consulta;


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Meta " . $_POST['txt_Cod'] . "' ,'INSERCION', 'Metas.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Meta " . $_POST['id'] . "' ,'ACTUALIZACION', 'Metas.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Meta
            " . $_POST['cod'] . "' ,'ELIMINACION', 'Metas.php')";
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