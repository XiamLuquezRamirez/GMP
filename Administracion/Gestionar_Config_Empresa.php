<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysql_query("BEGIN");


if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".companias VALUES(null,'" . $_POST['TK_TIPO_NIT'] . "','" . $_POST['TK_NIT'] . "',
           '" . $_POST['TK_RAZON_SOCIAL'] . "','" . $_POST['TK_REPRE'] . "','" . $_POST['TK_DEPA'] . "','" . $_POST['TK_MUNI'] . "','" . $_POST['TK_DIRECCION'] . "',
           '" . $_POST['TK_TELEFONO'] . "','" . $_POST['TK_FAX'] . "','" . $_POST['TK_EMAIL'] . "','" . $_POST['TK_LOG'] . "',SHA1('" . $_POST['TK_CONT'] . "'),'" . $_POST['TK_IMG'] . "','ACTIVA')";
    // echo $consulta;
    $qc = mysql_query($consulta, $link);

    if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(companias_id) AS id FROM ".$_SESSION['ses_BDBase'].".companias";
    $resulsql = mysql_query($sql, $link);
    if (mysql_num_rows($resulsql) > 0) {
        while ($fila = mysql_fetch_array($resulsql)) {
            $id_comp = $fila["id"];
        }
    }

    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".usucompa (usucompa_compania, usucompa_usuario) VALUES('" . $id_comp . "','" . $_SESSION['ses_user'] . "')";
    //echo $consulta;
    $qc = mysql_query($consulta, $link) or die("Error en consulta <br>MySQL dice: " . mysql_error());

    if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }

    /////GUARDAR LOCALIZACION////////
    $Tam_Localiza = $_POST['Long_Localiza'];

    for ($i = 1; $i <= $Tam_Localiza; $i++) {
        $consulta2 = "";
        $parLoca = explode("//", $_POST['Loca' . $i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".ubic_def_compa VALUES(null,'" . $_POST['TK_LOG'] . "','" . $parLoca[0] . "','" . $parLoca[1] . "','" . $parLoca[2] . "','" . $parLoca[3] . "','" . $parLoca[4] . "','" . $parLoca[5] . "')";
        //echo $consulta2;
        $qc2 = mysql_query($consulta2, $link);
        if (($qc2 == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
            $success = 0;
            $error = 15;
        }
    }
} else {
    if ($_POST['changPAss'] == "n") {
        $consulta = "UPDATE ".$_SESSION['ses_BDBase'].".companias SET
                            companias_nit='" . $_POST['TK_NIT'] . "',
                            companias_tid='" . $_POST['TK_TIPO_NIT'] . "',
                            companias_descripcion='" . $_POST['TK_RAZON_SOCIAL'] . "',
                            companias_rlegal='" . $_POST['TK_REPRE'] . "',
                            companias_dep='" . $_POST['TK_DEPA'] . "',
                            companias_muni='" . $_POST['TK_MUNI'] . "',
                            companias_direccion='" . $_POST['TK_DIRECCION'] . "',
                            companias_telefono1='" . $_POST['TK_TELEFONO'] . "',
                            companias_fax='" . $_POST['TK_FAX'] . "',
                            companias_email='" . $_POST['TK_EMAIL'] . "',
                            companias_img='" . $_POST['TK_IMG'] . "' where companias_login='" . $_POST['TK_LOG'] . "'";
        $qc = mysql_query($consulta, $link);
    } else {
        $consulta = "UPDATE ".$_SESSION['ses_BDBase'].".companias SET
                            companias_nit='" . $_POST['TK_NIT'] . "',
                            companias_tid='" . $_POST['TK_TIPO_NIT'] . "',
                            companias_descripcion='" . $_POST['TK_RAZON_SOCIAL'] . "',
                            companias_rlegal='" . $_POST['TK_REPRE'] . "',
                            companias_dep='" . $_POST['TK_DEPA'] . "',
                            companias_muni='" . $_POST['TK_MUNI'] . "',
                            companias_direccion='" . $_POST['TK_DIRECCION'] . "',
                            companias_telefono1='" . $_POST['TK_TELEFONO'] . "',
                            companias_fax='" . $_POST['TK_FAX'] . "',
                            companias_email='" . $_POST['TK_EMAIL'] . "',
                            companias_clave=SHA1('" . $_POST['TK_CONT'] . "'),
                            companias_img='" . $_POST['TK_IMG'] . "' where companias_login='" . $_POST['TK_LOG'] . "'";
        $qc = mysql_query($consulta, $link);
    }


    if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }

    /////GUARDAR LOCALIZACION////////
    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".ubic_def_compa WHERE compa_ubi='" . $_POST['TK_LOG'] . "'";

    $qc = mysql_query($consulta, $link);
    if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }
    $Tam_Localiza = $_POST['Long_Localiza'];

    for ($i = 1; $i <= $Tam_Localiza; $i++) {
        $consulta2 = "";
        $parLoca = explode("//", $_POST['Loca' . $i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".ubic_def_compa VALUES(null,'" . $_POST['TK_LOG'] . "','" . $parLoca[0] . "','" . $parLoca[1] . "','" . $parLoca[2] . "','" . $parLoca[3] . "','" . $parLoca[4] . "','" . $parLoca[5] . "')";
        //echo $consulta2;
        $qc2 = mysql_query($consulta2, $link);
        if (($qc2 == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
}



if ($_POST['acc'] == "1") {


    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Compañia " . $_POST['TK_NIT'] . "-" . $_POST['TK_RAZON_SOCIAL'] . "' ,'INSERCION', 'Config_Empresa.php')";
} else {

    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Compañia " . $_POST['TK_NIT'] . "-" . $_POST['TK_RAZON_SOCIAL'] . "' ,'ACTUALIZACION', 'Config_Empresa.php')";
}



$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

if ($success == 0) {
    mysql_query("ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysql_query("COMMIT");
    echo "1";
}

mysql_close();
?>