<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $relMat = explode("=", $_POST['txt_RelMat']);

    $consulta = "INSERT INTO indicadores VALUES(null,'" . $_POST['txt_CodIndi'] . "','" . $_POST['txt_NumIndi'] . "',"
            . "'" . $_POST['txt_NomIndi'] . "','" . $_POST['txt_ObjIndi'] . "','" . $_POST['CbProceso'] . "','" . $_POST['CbFreMed'] . "',"
            . "'" . $_POST['CbUnida'] . "','" . $_POST['FuentDat'] . "','" . $_POST['CbTipInd'] . "','" . $_POST['Resp'] . "',"
            . "'" . $relMat[1] . "','ACTIVO')";


    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_indi = "";
    $sql = "SELECT MAX(id_indi) AS id FROM indicadores";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_indi = $fila["id"];
        }
    }

    /////GUARDAR METAS  ////////
    $Tam_Indicadores = $_POST['Long_Metas'];

    for ($i = 1; $i <= $Tam_Indicadores; $i++) {
        $consulta2 = "";
        $parMet = explode("//", $_POST['idMetas' . $i]);

        $consulta2 = "INSERT INTO indicadoresxmetas VALUES(null,'" . $id_indi . "','" . $parMet[0] . "')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 10;
        }
    }

    /////GUARDAR VARIABLES  ////////
    $Tam_Variables = $_POST['Long_Varia'];

    for ($i = 1; $i <= $Tam_Variables; $i++) {
        $consulta2 = "";
        $parVar = explode("//", $_POST['idVariable' . $i]);

        $consulta2 = "INSERT INTO variaibles_indicadores VALUES(null,'" . $id_indi . "','" . $parVar[0] . "')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 10;
        }
    }
} else if ($_POST['acc'] == "2") {
    $relMat = explode("=", $_POST['txt_RelMat']);
    $consulta = "UPDATE indicadores SET cod_indi='" . $_POST['txt_CodIndi'] . "',num_indi='" . $_POST['txt_NumIndi'] . "',"
            . "nomb_indi='" . $_POST['txt_NomIndi'] . "',obj_indi='" . $_POST['txt_ObjIndi'] . "',proc_indi='" . $_POST['CbProceso'] . "',frec_indi='" . $_POST['CbFreMed'] . "',"
            . "unid_indi='" . $_POST['CbUnida'] . "',fuent_indi='" . $_POST['FuentDat'] . "',tip_indi='" . $_POST['CbTipInd'] . "',resp_indi='" . $_POST['Resp'] . "',"
            . "relmat_indi='" . $relMat[1] . "' WHERE id_indi='" . $_POST['id'] . "'";


    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_indi = $_POST['id'];

    $consulta = "DELETE FROM indicadoresxmetas WHERE indicador='" . $id_indi . "'";

    mysqli_query($link, $consulta);

    /////GUARDAR PROYECCIONES////////
    $Tam_Proy = $_POST['Long_Metas'];


    for ($i = 1; $i <= $Tam_Proy; $i++) {
        $consulta2 = "";

        $parMet = explode("//", $_POST['idMetas' . $i]);

        $consulta2 = "INSERT INTO indicadoresxmetas VALUES(null,'" . $id_indi . "','" . $parMet[0] . "')";

        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }
    
    

    $consulta = "DELETE FROM variaibles_indicadores WHERE indicador='" . $id_indi . "'";
    mysqli_query($link, $consulta);

    /////GUARDAR VARIABLES  ////////
    $Tam_Variables = $_POST['Long_Varia'];

    for ($i = 1; $i <= $Tam_Variables; $i++) {
        $consulta2 = "";
        $parVar = explode("//", $_POST['idVariable' . $i]);

        $consulta2 = "INSERT INTO variaibles_indicadores VALUES(null,'" . $id_indi . "','" . $parVar[0] . "')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 10;
        }
    }
} else {
    $consulta = "SELECT * FROM mediindicador WHERE indicador='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado1) > 0) {
        echo "no";
    } else {
        $consulta = "UPDATE indicadores SET estado='ELIMINADO' WHERE id_indi='" . $_POST['cod'] . "'";
        mysqli_query($link, $consulta);
        $consulta = "DELETE variaibles_indicadores WHERE indicador='" . $_POST['cod'] . "' ";
        mysqli_query($link, $consulta);
    }
}



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Plan de Acción " . $_POST['txt_NomIndi'] . "' ,'INSERCION', 'FormatoPlanAccion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion  de Plan de Acción " . $_POST['txt_CodIndi'] . "' ,'ACTUALIZACION', 'FormatoPlanAccion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Plan de Acción " . $_POST['cod'] . "' ,'ELIMINACION', 'FormatoPlanAccion.php')";
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