<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO eval_contratista VALUES(null,'" . $_POST['Eval'] . "',"
            . "'" . $_POST['txt_fecha_Eval'] . "','" . $_POST['Reeval'] . "','" . $_POST['txt_fecha_Reval'] . "',"
            . "'" . $_POST['txt_IdCont'] . "','" . $_POST['txt_CodCont'] . "','" . $_POST['txt_fecha'] . "',"
            . "'" . $_POST['txt_Objet'] . "','" . $_POST['txt_nitcont'] . "','" . $_POST['txt_Contra'] . "',"
            . "'" . $_POST['txt_fecini'] . "','" . $_POST['txt_fecfin'] . "',"
            . "'" . $_POST['txt_Clase'] . "',"
            . "'" . $_POST['puntPsTot1'] . "','" . $_POST['puntPsTot2'] . "',"
            . "'" . $_POST['puntPsTot3'] . "','" . $_POST['text_PsTotal'] . "',"
            . "'" . $_POST['puntSaTot1'] . "','" . $_POST['puntSaTot2'] . "',"
            . "'" . $_POST['puntSaTot3'] . "','" . $_POST['text_SaTotal'] . "',"
            . "'" . $_POST['puntCaTot1'] . "','" . $_POST['puntCaTot2'] . "',"
            . "'" . $_POST['puntCaTot3'] . "','" . $_POST['text_CaTotal'] . "',"
            . "'" . $_POST['puntCcTot1'] . "','" . $_POST['puntCcTot1'] . "',"
            . "'" . $_POST['puntCcTot1'] . "','" . $_POST['text_CcTotal'] . "',"
            . "'" . $_POST['puntCoTot1'] . "','" . $_POST['puntCoTot2'] . "',"
            . "'" . $_POST['puntCoTot3'] . "','" . $_POST['text_CoTotal'] . "',"
            . "'" . $_POST['analisis_cumpli'] . "','" . $_POST['analisis_ejec'] . "',"
            . "'" . $_POST['analisis_calidad'] . "','" . $_POST['puntPsTot1Prom'] . "',"
            . "'" . $_POST['puntPsTot2Prom'] . "','" . $_POST['puntPsTot3Prom'] . "',"
            . "'" . $_POST['puntSaTot1Prom'] . "','" . $_POST['puntSaTot2Prom'] . "',"
            . "'" . $_POST['puntSaTot3Prom'] . "','" . $_POST['puntCaTot1Prom'] . "',"
            . "'" . $_POST['puntCaTot2Prom'] . "','" . $_POST['puntCaTot3Prom'] . "',"
            . "'" . $_POST['puntCcTot1Prom'] . "','" . $_POST['puntCcTot2Prom'] . "',"
            . "'" . $_POST['puntCcTot3Prom'] . "','" . $_POST['puntCoTot1Prom'] . "',"
            . "'" . $_POST['puntCoTot2Prom'] . "','" . $_POST['puntCoTot3Prom'] . "','ACTIVO', '".$_POST['PorCO']."',
             '".$_POST['PorCE']."', '".$_POST['PorCC']."')";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(id_evaluacion) AS id FROM eval_contratista WHERE estado_evaluacion='ACTIVO'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Cont = $fila["id"];
        }
    }

    ///GUARDAR Parametros 
    $consulta2 = "INSERT INTO para_calf_contratista VALUES(null,'" . $_POST['PorCO'] . "','" . $_POST['PorCE'] . "','" . $_POST['PorCC'] . "','" . $_POST['txt_IdCont'] . "')";
    //echo $consulta2;
    $qc2 = mysqli_query($link, $consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 8;
    }

    //Insert Prestacion de Servicio
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textPs1' . $i]);

        $consulta2 = "INSERT INTO resul_contprestacion VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntPs1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 11; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textPs2' . $i]);

        $consulta2 = "INSERT INTO resul_contprestacion VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntPs2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textPs3' . $i]);

        $consulta2 = "INSERT INTO resul_contprestacion VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntPs3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }

    //Insert Suminitro 
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 5; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textSa1' . $i]);

        $consulta2 = "INSERT INTO resul_contsuministro VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntSa1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 7; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textSa2' . $i]);

        $consulta2 = "INSERT INTO resul_contsuministro VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntSa2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textSa3' . $i]);

        $consulta2 = "INSERT INTO resul_contsuministro VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntSa3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Insert Contrato arrendamiento
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCa1' . $i]);

        $consulta2 = "INSERT INTO resul_contarrendam VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCa1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCa2' . $i]);

        $consulta2 = "INSERT INTO resul_contarrendam VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCa2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCa3' . $i]);

        $consulta2 = "INSERT INTO resul_contarrendam VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCa3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Insert Contrato de Consultoria
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCc1' . $i]);

        $consulta2 = "INSERT INTO resul_contconsultoria VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCc1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCc2' . $i]);

        $consulta2 = "INSERT INTO resul_contconsultoria VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCc2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 5; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCc3' . $i]);

        $consulta2 = "INSERT INTO resul_contconsultoria VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCc3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Insert Contrato de obra
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCo1' . $i]);

        $consulta2 = "INSERT INTO resul_contobra VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCo1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCo2' . $i]);

        $consulta2 = "INSERT INTO resul_contobra VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCo2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 8; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCo3' . $i]);

        $consulta2 = "INSERT INTO resul_contobra VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCo3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
} else if ($_POST['acc'] == "2") {

    $consulta = "UPDATE eval_contratista SET eval_evaluacion='" . $_POST['Eval'] . "',"
            . "feval_evaluacion='" . $_POST['txt_fecha_Eval'] . "',reeval_evaluacion='" . $_POST['Reeval'] . "',freeval_evaluacion='" . $_POST['txt_fecha_Reval'] . "',"
            . "idcont_evaluacion='" . $_POST['txt_IdCont'] . "',ncont_evaluacion='" . $_POST['txt_CodCont'] . "',fcont_evaluacion='" . $_POST['txt_fecha'] . "',"
            . "objcont_evaluacion='" . $_POST['txt_Objet'] . "',nitcont_evaluacion='" . $_POST['txt_nitcont'] . "',nomcont_evaluacion='" . $_POST['txt_Contra'] . "',"
            . "finicont_evaluacion='" . $_POST['txt_fecini'] . "',ftercont_evaluacion='" . $_POST['txt_fecfin'] . "',"
            . "clacont_evaluacion='" . $_POST['txt_Clase'] . "',"
            . "puntPsTot1='" . $_POST['puntPsTot1'] . "',puntPsTot2='" . $_POST['puntPsTot2'] . "',"
            . "puntPsTot3='" . $_POST['puntPsTot3'] . "',text_PsTotal='" . $_POST['text_PsTotal'] . "',"
            . "puntSaTot1='" . $_POST['puntSaTot1'] . "',puntSaTot2='" . $_POST['puntSaTot2'] . "',"
            . "puntSaTot3='" . $_POST['puntSaTot3'] . "',text_SaTotal='" . $_POST['text_SaTotal'] . "',"
            . "puntCaTot1='" . $_POST['puntCaTot1'] . "',puntCaTot2='" . $_POST['puntCaTot2'] . "',"
            . "puntCaTot3='" . $_POST['puntCaTot3'] . "',text_CaTotal='" . $_POST['text_CaTotal'] . "',"
            . "puntCcTot1='" . $_POST['puntCcTot1'] . "',puntCcTot1='" . $_POST['puntCcTot1'] . "',"
            . "puntCcTot1='" . $_POST['puntCcTot1'] . "',text_CcTotal='" . $_POST['text_CcTotal'] . "',"
            . "puntCoTot1='" . $_POST['puntCoTot1'] . "',puntCoTot2='" . $_POST['puntCoTot2'] . "',"
            . "puntCoTot3='" . $_POST['puntCoTot3'] . "',text_CoTotal='" . $_POST['text_CoTotal'] . "',"
            . "analisis_cumpli='" . $_POST['analisis_cumpli'] . "',analisis_ejec='" . $_POST['analisis_ejec'] . "',"
            . "analisis_calidad='" . $_POST['analisis_calidad'] . "',puntPsTot1Prom='" . $_POST['puntPsTot1Prom'] . "',"
            . "puntPsTot2Prom='" . $_POST['puntPsTot2Prom'] . "',puntPsTot3Prom='" . $_POST['puntPsTot3Prom'] . "',"
            . "puntSaTot1Prom='" . $_POST['puntSaTot1Prom'] . "',puntSaTot2Prom='" . $_POST['puntSaTot2Prom'] . "',"
            . "puntSaTot3Prom='" . $_POST['puntSaTot3Prom'] . "',puntCaTot1Prom='" . $_POST['puntCaTot1Prom'] . "',"
            . "puntCaTot2Prom='" . $_POST['puntCaTot2Prom'] . "',puntCaTot3Prom='" . $_POST['puntCaTot3Prom'] . "',"
            . "puntCcTot1Prom='" . $_POST['puntCcTot1Prom'] . "',puntCcTot2Prom='" . $_POST['puntCcTot2Prom'] . "',"
            . "puntCcTot3Prom='" . $_POST['puntCcTot3Prom'] . "',puntCoTot1Prom='" . $_POST['puntCoTot1Prom'] . "',"
            . "puntCoTot2Prom='" . $_POST['puntCoTot2Prom'] . "',puntCoTot3Prom='" . $_POST['puntCoTot3Prom'] . "',"
            . "PorCO='" . $_POST['PorCO'] . "',PorCE='" . $_POST['PorCE'] . "',PorCC='" . $_POST['PorCC'] . "',"
            . "  WHERE id_evaluacion='" . $_POST['id'] . "'";
//     echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }


    $consulta2 = "UPDATE para_calf_contratista SET PorCO='" . $_POST['PorCO'] . "',PorCE='" . $_POST['PorCE'] . "',PorCC='" . $_POST['PorCC'] . "' WHERE id_cont='" . $_POST['txt_IdCont'] . "'";
    //echo $consulta2;
    $qc2 = mysqli_query($link, $consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 8;
    }


    $id_Cont = $_POST['id'];

    $consulta = "DELETE FROM resul_contprestacion WHERE cont_resul_contprestacion='" . $id_Cont . "' AND teva_resul_contprestacion='" . $_POST['TipEvaluacion'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    //Insert Prestacion de Servicio
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textPs1' . $i]);

        $consulta2 = "INSERT INTO resul_contprestacion VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntPs1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 11; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textPs2' . $i]);

        $consulta2 = "INSERT INTO resul_contprestacion VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntPs2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textPs3' . $i]);

        $consulta2 = "INSERT INTO resul_contprestacion VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntPs3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }

    $consulta = "DELETE FROM resul_contsuministro WHERE cont_resulsuministro='" . $id_Cont . "' AND teva_resulsuministro='" . $_POST['TipEvaluacion'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 15;
    }

    //Insert Suminitro 
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 5; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textSa1' . $i]);

        $consulta2 = "INSERT INTO resul_contsuministro VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntSa1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 7; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textSa2' . $i]);

        $consulta2 = "INSERT INTO resul_contsuministro VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntSa2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textSa3' . $i]);

        $consulta2 = "INSERT INTO resul_contsuministro VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntSa3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }


    $consulta = "DELETE FROM resul_contarrendam WHERE cont_resul_contarrendam='" . $id_Cont . "' AND teva_resul_contarrendam='" . $_POST['TipEvaluacion'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 16;
    }

    //Insert Contrato arrendamiento
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCa1' . $i]);

        $consulta2 = "INSERT INTO resul_contarrendam VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCa1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCa2' . $i]);

        $consulta2 = "INSERT INTO resul_contarrendam VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCa2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 4; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCa3' . $i]);

        $consulta2 = "INSERT INTO resul_contarrendam VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCa3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }


    $consulta = "DELETE FROM resul_contconsultoria WHERE cont_resul_contconsultoria='" . $id_Cont . "' AND teva_resul_contconsultoria='" . $_POST['TipEvaluacion'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 17;
    }

    //Insert Contrato de Consultoria
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCc1' . $i]);

        $consulta2 = "INSERT INTO resul_contconsultoria VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCc1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCc2' . $i]);

        $consulta2 = "INSERT INTO resul_contconsultoria VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCc2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 5; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCc3' . $i]);

        $consulta2 = "INSERT INTO resul_contconsultoria VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCc3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }


    $consulta = "DELETE FROM resul_contobra WHERE cont_resul_contobra='" . $id_Cont . "' AND teva_resul_contobra='" . $_POST['TipEvaluacion'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 18;
    }

    //Insert Contrato de obra
    //Criterios Cumplimiento Y Oportunidad
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCo1' . $i]);

        $consulta2 = "INSERT INTO resul_contobra VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCo1' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios En La Ejecución Del Contrato
    for ($i = 1; $i < 6; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCo2' . $i]);

        $consulta2 = "INSERT INTO resul_contobra VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCo2' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    //Criterios De Calidad Del Bien O Servicio
    for ($i = 1; $i < 8; $i++) {
        $consulta2 = "";
        $PaTex = explode("-", $_POST['textCo3' . $i]);

        $consulta2 = "INSERT INTO resul_contobra VALUES(null,'" . $id_Cont . "','" . $_POST['TipEvaluacion'] . "','" . $PaTex[0] . "','" . $_POST['puntCo3' . $i] . "','" . $PaTex[1] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
} else {
    $id_Cont = $_POST['cod'];
    $consulta = "UPDATE eval_contratista SET estado_evaluacion='DELETE' WHERE id_evaluacion='" . $id_Cont . "' ";

    //   echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
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