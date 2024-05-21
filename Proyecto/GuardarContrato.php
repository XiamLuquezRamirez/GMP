<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

mysqli_set_charset($link, 'utf8');

if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO contratos VALUES(null,'" . $_POST['CbTiplog'] . "',"
            . "'" . $_POST['DesCbTiplog'] . "','" . $_POST['txt_fecha'] . "','" . date('Y-m-d') . "','" . $_POST['txt_Cod'] . "',"
            . "'" . $_POST['txt_Nomb'] . "','" . $_POST['CbContratis'] . "','" . $_POST['CbContratisDesc'] . "',"
            . "'" . $_POST['txt_Super'] . "','" . $_POST['CbSuperDesc'] . "','" . $_POST['txt_Inter'] . "',"
            . "'" . $_POST['CbInterDesc'] . "','" . $_POST['ValCon'] . "',"
            . "'" . $_POST['ValAdic'] . "','" . $_POST['ValFin'] . "','" . $_POST['ValEje'] . "',"
            . "'" . $_POST['txt_Fpago'] . "','" . $_POST['txt_Durac'] . "','" . $_POST['txt_FIni'] . "',"
            . "'" . $_POST['txt_FSusp'] . "','" . $_POST['txt_FRein'] . "','" . $_POST['txt_Prorog'] . "',"
            . "'" . $_POST['txt_FFina'] . "','" . $_POST['txt_FReci'] . "','" . $_POST['CbProy'] . "',"
            . "'" . $_POST['CbProyDes'] . "','" . $_POST['txt_Avance'] . "','" . $_POST['CbEstado'] . "',"
            . "'" . $_POST['CbEstadoProc'] . "','" . $_POST['txt_PorEqui'] . "','" . $_POST['txt_Url'] . "',"
            . "'" . $_POST['Text_Motivo'] . "','" . $_POST['Src_FileEstad'] . "','" . $_POST['novedad'] . "')";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(id_contrato) AS id FROM contratos";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Cont = $fila["id"];
        }
    }


    /////GUARDAR LOCALIZACION////////
    $consulta = "DELETE FROM ubic_contratos WHERE num_contrato='" . $_POST['txt_Cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }


    /////GUARDAR LOCALIZACION////////
    $Tam_Localiza = $_POST['Long_Localiza'];

    for ($i = 1; $i <= $Tam_Localiza; $i++) {
        $consulta2 = "";
        $parLoca = explode("//", $_POST['Loca' . $i]);

        $consulta2 = "INSERT INTO ubic_contratos VALUES(null,'" . $id_Cont . "','" . $parLoca[0] . "','" . $parLoca[1] . "','" . $parLoca[2] . "','" . $parLoca[3] . "','" . $parLoca[4] . "','" . $parLoca[5] . "','" . $_POST['txt_Cod'] . "')";
        //  echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 15;
        }
    }


    /////GUARDAR LOCALIZACION////////
    $Tam_Porce = $_POST['Long_Porce'];

    for ($i = 1; $i <= $Tam_Porce; $i++) {
        $consulta2 = "";
        $ParPorc = explode("//", $_POST['Porc' . $i]);

        $consulta2 = "UPDATE CONTRATOS SET porproy_contrato='" . $ParPorc[1] . "' WHERE num_contrato='" . $ParPorc[0] . "'";
        //  echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 15;
        }
    }






    /////GUARDAR GALERIA////////

    $consulta = "DELETE FROM contrato_galeria WHERE num_contrato_galeria='" . $_POST['txt_Cod'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $carpetaOrigen = 'Galeria/';
    $carpetaDest = 'Galeria/' . $_SESSION['ses_complog'] . '/' . $_POST['txt_Cod'] . '/';
    if (!file_exists($carpetaDest)) {
        mkdir($carpetaDest, 0777, true);
    }



    ///GUARDAR IMAGENES////////
    $Tam_Img = $_POST['Long_Img'];
    for ($i = 1; $i <= $Tam_Img; $i++) {
        $consulta2 = "";
        $parimg = explode("//", $_POST['idImg' . $i]);

        $consulta2 = "INSERT INTO contrato_galeria VALUES(null,'" . $id_Cont . "','" . $parimg[0] . "','" . $parimg[1] . "','" . $_POST['txt_Cod'] . "','" . $parimg[2] . "','" . $parimg[3] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
        if (file_exists($carpetaOrigen . $parimg[1])) {

            if (file_exists($carpetaDest) || @mkdir($carpetaDest)) {

                $carpetaOrigen = $carpetaOrigen . $parimg[1];
                $carpetaDest = $carpetaDest . $parimg[1];
                chmod($carpetaOrigen, 0777);

//                mkdir($carpetaOrigen, 0644, true);
                if (!@copy($carpetaOrigen, $carpetaDest)) {
                    $errors = error_get_last();
                    echo "COPY ERROR: " . $errors['type'];
                    echo "<br />\n" . $errors['message'];
                } else {
                    chmod($carpetaDest, '0644');
                    chmod($carpetaOrigen, 0777);
                    unlink($carpetaOrigen);
                }
            }
        }
    }
} else if ($_POST['acc'] == "2") {

    $consulta = "UPDATE contratos SET idtipolg_contrato='" . $_POST['CbTiplog'] . "',"
            . "destipolg_contrato='" . $_POST['DesCbTiplog'] . "',fmod_contrato='" . date('Y-m-d'). "',"
            . "obj_contrato='" . $_POST['txt_Nomb'] . "',idcontrati_contrato='" . $_POST['CbContratis'] . "',descontrati_contrato='" . $_POST['CbContratisDesc'] . "',"
            . "idsuperv_contrato='" . $_POST['txt_Super'] . "',dessuperv_contrato='" . $_POST['CbSuperDesc'] . "',idinterv_contrato='" . $_POST['txt_Inter'] . "',"
            . "desinterv_contrato='" . $_POST['CbInterDesc'] . "',vcontr_contrato='" . $_POST['ValCon'] . "',"
            . "vadic_contrato='" . $_POST['ValAdic'] . "',vfin_contrato='" . $_POST['ValFin'] . "',veje_contrato='" . $_POST['ValEje'] . "',"
            . "forpag_contrato='" . $_POST['txt_Fpago'] . "',durac_contrato='" . $_POST['txt_Durac'] . "',fini_contrato='" . $_POST['txt_FIni'] . "',"
            . "fsusp_contrato='" . $_POST['txt_FSusp'] . "',frein_contrato='" . $_POST['txt_FRein'] . "',prorg_contrato='" . $_POST['txt_Prorog'] . "',"
            . "ffin_contrato='" . $_POST['txt_FFina'] . "',frecb_contrato='" . $_POST['txt_FReci'] . "',idproy_contrato='" . $_POST['CbProy'] . "',"
            . "desproy_contrato='" . $_POST['CbProyDes'] . "',porav_contrato='" . $_POST['txt_Avance'] . "',porproy_contrato='" . $_POST['txt_PorEqui'] . "',"
            . "estcont_contra='" . $_POST['CbEstadoProc'] . "',estad_contrato='" . $_POST['CbEstado'] . "',secop_contrato='" . $_POST['txt_Url'] . "',observacion='" . $_POST['Text_Motivo'] . "',"
            . "urldocumento='" . $_POST['Src_FileEstad'] . "',tipnovedad='" . $_POST['novedad'] . "' WHERE id_contrato='" . $_POST['id'] . "'";
//    echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_Cont = $_POST['id'];


    /////GUARDAR LOCALIZACION////////
    $consulta = "DELETE FROM ubic_contratos WHERE num_contrato='" . $_POST['txt_Cod'] . "'";
//    echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }
    $Tam_Localiza = $_POST['Long_Localiza'];

    for ($i = 1; $i <= $Tam_Localiza; $i++) {
        $consulta2 = "";
        $parLoca = explode("//", $_POST['Loca' . $i]);

        $consulta2 = "INSERT INTO ubic_contratos VALUES(null,'" . $id_Proy . "','" . $parLoca[0] . "','" . $parLoca[1] . "','" . $parLoca[2] . "','" . $parLoca[3] . "','" . $parLoca[4] . "','" . $parLoca[5] . "','" . $_POST['txt_Cod'] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }


    $Tam_Porce = $_POST['Long_Porce'];

    for ($i = 1; $i <= $Tam_Porce; $i++) {
        $consulta2 = "";
        $ParPorc = explode("//", $_POST['Porc' . $i]);

        $consulta2 = "UPDATE CONTRATOS SET porproy_contrato='" . $ParPorc[1] . "' WHERE num_contrato='" . $ParPorc[0] . "'";
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 15;
        }
    }


    /////GUARDAR GALERIA////////

    $consulta = "DELETE FROM contrato_galeria WHERE num_contrato_galeria='" . $_POST['txt_Cod'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }


    /////GUARDAR GALERIA////////

    $consulta = "DELETE FROM contrato_galeria WHERE num_contrato_galeria='" . $_POST['txt_Cod'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $carpetaOrigen = 'Galeria/';
    $carpetaDest = 'Galeria/' . $_SESSION['ses_complog'] . '/' . $_POST['txt_Cod'] . '/';
    if (!file_exists($carpetaDest)) {
        mkdir($carpetaDest, 0777, true);
    }

    ///GUARDAR IMAGENES////////
    $Tam_Img = $_POST['Long_Img'];
    for ($i = 1; $i <= $Tam_Img; $i++) {
        $consulta2 = "";
        $parimg = explode("//", $_POST['idImg' . $i]);

        $consulta2 = "INSERT INTO contrato_galeria VALUES(null,'" . $id_Cont . "','" . $parimg[0] . "','" . $parimg[1] . "','" . $_POST['txt_Cod'] . "','" . $parimg[2] . "','" . $parimg[3] . "')";
        $qc2 = mysqli_query($link, $consulta2);


        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 20;
        }

        if (file_exists($carpetaOrigen . $parimg[1])) {

            if (file_exists($carpetaDest) || @mkdir($carpetaDest)) {

                $carpetaOrigen = $carpetaOrigen . $parimg[1];
                $carpetaDest = $carpetaDest . $parimg[1];
                chmod($carpetaOrigen, 0777);

//                mkdir($carpetaOrigen, 0644, true);
                if (!@copy($carpetaOrigen, $carpetaDest)) {
                    $errors = error_get_last();
                    echo "COPY ERROR: " . $errors['type'];
                    echo "<br />\n" . $errors['message'];
                } else {
                    chmod($carpetaDest, '0644');
                    chmod($carpetaOrigen, 0777);
                    unlink($carpetaOrigen);
                }
            }
        }
    }
} else {
    $id_Cont = $_POST['cod'];
    $consulta = "select COUNT(*) conta from contratos where num_contrato='" . $_POST['cod'] . "'";
    $resultado2 = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila = mysqli_fetch_array($resultado2)) {
            $contador = intval($fila["conta"]);
        }
    }
    if ($contador == 1) {
        $consulta = "UPDATE contratos SET estcont_contra='Eliminado' WHERE num_contrato='" . $_POST['cod'] . "' ";
        //  echo $consulta;
        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo 'no';
    }



//    $consulta = "DELETE FROM contrato_galeria WHERE contr_galeria='" . $_POST['cod'] . "'";
//
//    $qc = mysqli_query($link, $consulta);
//    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
//        $success = 0;
//        $error = 14;
//    }
}


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Contrato " . $_POST['txt_Cod'] . "' ,'INSERCION', 'contrato.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Contrato " . $_POST['txt_Cod'] . "' ,'ACTUALIZACION', '"
            . "contrato.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Contrato
            " . $_POST['cod'] . "' ,'ELIMINACION', 'contrato.php')";
}



$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 4;
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien/" . $id_Cont;
}

mysqli_close($link);
?>