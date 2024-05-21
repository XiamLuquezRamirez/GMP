<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

mysqli_set_charset($link, 'utf8');

if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO contratos_expres VALUES(null,'" . $_POST['CbTiplog'] . "',"
            . "'" . $_POST['DesCbTiplog'] . "','" . $_POST['txt_Cod'] . "',"
            . "'" . $_POST['txt_Nomb'] . "','" . $_POST['CbContratis'] . "','" . $_POST['CbContratisDesc'] . "',"
            . "'" . $_POST['txt_Super'] . "','" . $_POST['CbSuperDesc'] . "','" . $_POST['txt_Inter'] . "',"
            . "'" . $_POST['CbInterDesc'] . "','" . $_POST['ValCon'] . "',"
            . "'" . $_POST['ValAdic'] . "','" . $_POST['ValFin'] . "','" . $_POST['ValEje'] . "',"
            . "'" . $_POST['txt_Fpago'] . "','" . $_POST['txt_Durac'] . "','" . $_POST['txt_FIni'] . "',"
            . "'" . $_POST['txt_FSusp'] . "','" . $_POST['txt_FRein'] . "','" . $_POST['txt_Prorog'] . "',"
            . "'" . $_POST['txt_FFina'] . "','" . $_POST['txt_FReci'] . "','" . $_POST['CbProy'] . "',"
            . "'" . $_POST['CbProyDes'] . "','" . $_POST['txt_Avance'] . "','" . $_POST['CbEstado'] . "','ACTIVO')";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(id_contrato) AS id FROM contratos_expres";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Cont = $fila["id"];
        }
    }

} else if ($_POST['acc'] == "2") {

    $consulta = "UPDATE contratos_expres SET idtipolg_contrato='" . $_POST['CbTiplog'] . "',"
            . "destipolg_contrato='" . $_POST['DesCbTiplog'] . "',"
            . "obj_contrato='" . $_POST['txt_Nomb'] . "',idcontrati_contrato='" . $_POST['CbContratis'] . "',descontrati_contrato='" . $_POST['CbContratisDesc'] . "',"
            . "idsuperv_contrato='" . $_POST['txt_Super'] . "',dessuperv_contrato='" . $_POST['CbSuperDesc'] . "',idinterv_contrato='" . $_POST['txt_Inter'] . "',"
            . "desinterv_contrato='" . $_POST['CbInterDesc'] . "',vcontr_contrato='" . $_POST['ValCon'] . "',"
            . "vadic_contrato='" . $_POST['ValAdic'] . "',vfin_contrato='" . $_POST['ValFin'] . "',veje_contrato='" . $_POST['ValEje'] . "',"
            . "forpag_contrato='" . $_POST['txt_Fpago'] . "',durac_contrato='" . $_POST['txt_Durac'] . "',fini_contrato='" . $_POST['txt_FIni'] . "',"
            . "fsusp_contrato='" . $_POST['txt_FSusp'] . "',frein_contrato='" . $_POST['txt_FRein'] . "',prorg_contrato='" . $_POST['txt_Prorog'] . "',"
            . "ffin_contrato='" . $_POST['txt_FFina'] . "',frecb_contrato='" . $_POST['txt_FReci'] . "',idproy_contrato='" . $_POST['CbProy'] . "',"
            . "desproy_contrato='" . $_POST['CbProyDes'] . "',porav_contrato='" . $_POST['txt_Avance'] . "' WHERE id_contrato='" . $_POST['id'] . "'";
    
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_Cont = $_POST['id'];


  
} else {
    $id_Cont=$_POST['cod'];
    $consulta = "UPDATE contratos_expres SET estcont_contra='Eliminado' WHERE id_contrato='" . $_POST['cod'] . "' ";
     //  echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta = "DELETE FROM contrato_galeria WHERE contr_galeria='" . $_POST['cod'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }
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