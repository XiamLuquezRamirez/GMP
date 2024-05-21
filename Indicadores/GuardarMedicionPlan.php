<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

$estado = "";
if (intval($_POST['txt_resindiPlan']) >= intval($_POST['metaPlan'])) {
    $estado = "Cumplida";
} else if (intval($_POST['txt_resindiPlan']) < intval($_POST['metaPlan'])) {
    $estado = "Pendiente";
}

$consulta2 = "INSERT INTO mediindicador_plan VALUES(null,'" . $_POST['txt_indi'] . "','" . $_POST['AnioPlan'] . "',"
        . "'" . $_POST['txt_fecha_MediPlan'] . "','" . $_POST['FreMedmediPlan'] . "','" . $_POST['metaPlan'] . "',"
        . "'" . $_POST["txt_resindiPlan"] . "','" . $_POST['txt_Respo'] . "','" . $_POST['Src_FilePlan'] . "',"
        . "'" . $estado . "','Si','" . $_POST['txt_metaPlan'] . "','" . $_POST['id_ori'] . "','" . $_POST['txt_idMed'] . "',"
        . "'" . $_POST['txt_AnaCausPlan'] . "','" . $_POST['txt_AccPropPlan'] . "')";
//echo $consulta2;
$qc2 = mysqli_query($link, $consulta2);
if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}


$sql = "SELECT MAX(id) AS id FROM mediindicador_plan";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id = $fila["id"];
    }
}

$consulta = "UPDATE evaluacionindicador set estado='EVALUADO' WHERE id='" . $_POST['txt_idEval'] . "'";
//echo $consulta;
$qc2 = mysqli_query($link, $consulta);
if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

$ParTiVar = explode(",", $_POST['TitVar']);
$longitud = count($ParTiVar);

for ($i = 0; $i < $longitud; $i++) {
    $Consulta = "insert into titu_variable_med_plan VALUES(null,'" . $id . "','" . $ParTiVar[$i] . "')";
    
    mysqli_query($link, $Consulta);
}

$ParValVar = explode(",", $_POST['ValVar']);
$longitud = count($ParValVar);
for ($i = 0; $i < $longitud; $i++) {
    $Consulta = "insert into valor_variable_med_plan VALUES(null,'" . $id . "','" . $ParValVar[$i] . "')";
    mysqli_query($link, $Consulta);
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