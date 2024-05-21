<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

if ($_POST['acc'] == "1") {

    $Tam_MediInd = $_POST['Long_IndMedi'];
    for ($i = 1; $i <= $Tam_MediInd; $i++) {
        $consulta = "";
        $parMedInd = explode("//", $_POST['IdMedInd' . $i]);


        $estado = "";
        if (intval($parMedInd[4]) >= intval($parMedInd[3])) {
            $estado = "Cumplida";
        } else if (intval($parMedInd[4]) < intval($parMedInd[3])) {
            $estado = "Pendiente";
        }

        //2020  //  2020-10-15  //  Primer Mes  //  80 //  92.0  //  AnexosIndicadores/7bd735_ReporteContratos.xlsx // 1 // esta es una causa // esta es una propuesta//numero de personas que acuden a la justicia,numero de personas en conflictos//23,25"

        $consulta = "INSERT INTO mediindicador VALUES(null,'" . $_POST['txt_indi'] . "','" . $parMedInd[0] . "',"
                . "'" . $parMedInd[1] . "','" . $parMedInd[2] . "','" . $parMedInd[3] . "','" . $parMedInd[4] . "',"
                . "'" . $_POST['txt_Respo'] . "','" . $parMedInd[5] . "','" . $estado . "','No','" . $parMedInd[6] . "',"
                . "'" . $parMedInd[7] . "','" . $parMedInd[8] . "','" . $_POST['id_ori'] . "')";
//        echo $consulta;
        $qc2 = mysqli_query($link, $consulta);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }

        $sql = "SELECT MAX(id) AS id FROM mediindicador";
        $resulsql = mysqli_query($link, $sql);
        if (mysqli_num_rows($resulsql) > 0) {
            while ($fila = mysqli_fetch_array($resulsql)) {
                $id = $fila["id"];
            }
        }

        $ParTiVar = explode(",", $parMedInd[9]);
        $longitud = count($ParTiVar);

        for ($i = 0; $i < $longitud; $i++) {
            $Consulta = "insert into titu_variable_med VALUES(null,'" . $id . "','" . $ParTiVar[$i] . "')";
            mysqli_query($link, $Consulta);
        }

        $ParValVar = explode(",", $parMedInd[10]);
        $longitud = count($ParValVar);
        for ($i = 0; $i < $longitud; $i++) {
            $Consulta = "insert into valor_variable_med VALUES(null,'" . $id . "','" . $ParValVar[$i] . "')";
            mysqli_query($link, $Consulta);
        }
    }
} else if ($_POST['acc'] == "2") {
    
} else {
    
}


//
//if ($_POST['acc'] == "1") {
//    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
//            log_hora, log_accion, log_tipo, log_interfaz) VALUES
//            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
//            NOW(),'Registro de Medicion de indicador  " . $_POST['txt_indi'] . "' ,'INSERCION', 'MedirIndicadorProyecto.php')";
//} 
////else if ($_POST['acc'] == "2") {
////    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
////            log_hora, log_accion, log_tipo, log_interfaz) VALUES
////            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
////            NOW(),'Registro de Medicion de indicador " . $_POST['txt_indi'] . "' ,'ACTUALIZACION', 'FormatoPlanAccion.php')";
////} else {
////    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
////            log_hora, log_accion, log_tipo, log_interfaz) VALUES
////            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
////            NOW(),'Eliminacion de Plan de Acción " . $_POST['id'] . "' ,'ELIMINACION', 'FormatoPlanAccion.php')";
////};
//
//
//$qc = mysqli_query($link, $consulta);
//if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
//    $success = 0;
//    $error = 2;
//}
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