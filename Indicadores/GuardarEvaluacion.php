<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO evaluacionindicador VALUES(null,'" . $_POST['txt_Med'] . "','" . $_POST['IdInd'] . "',"
            . "'" . $_POST['txt_FecTermi'] . "','POR EVALUAR')";
//echo $consulta2;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta = "UPDATE mediindicador SET plan_mejora='Si' WHERE id='" . $_POST['txt_Med'] . "'";
    $qc2 = mysqli_query($link, $consulta);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_eva = "";
    $sql = "SELECT MAX(id) AS id FROM evaluacionindicador";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_eva = $fila["id"];
        }
    }

/////GUARDAR MEDICIONES////////
    $Tam_Act = $_POST['Long_Act'];

    for ($i = 1; $i <= $Tam_Act; $i++) {
        $consulta2 = "";
        $parAct = explode("//", $_POST['Acti' . $i]);

        $consulta2 = "INSERT INTO actividaplaneadadas VALUES(null,'" . $id_eva . "','" . $parAct[0] . "',"
                . "'" . $parAct[1] . "','PENDIENTE')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }
} else {

    $consulta = "UPDATE evaluacionindicador SET fecha='" . $_POST['txt_FecTermi'] . "' WHERE id_med='" . $_POST['txt_Med'] . "'";
//echo $consulta2;
    $qc2 = mysqli_query($link, $consulta);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta = "UPDATE mediindicador SET plan_mejora='Si' WHERE id='" . $_POST['txt_Med'] . "'";
    $qc2 = mysqli_query($link, $consulta);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_eva = "";
    $sql = "SELECT MAX(id) AS id FROM evaluacionindicador";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_eva = $fila["id"];
        }
    }

/////GUARDAR MEDICIONES////////
    $Tam_Act = $_POST['Long_Act'];
// echo $Tam_Nece;

    $consulta = "DELETE FROM actividaplaneadadas WHERE ideval='" . $id_eva . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }

    for ($i = 1; $i <= $Tam_Act; $i++) {
        $consulta2 = "";
        $parAct = explode("//", $_POST['Acti' . $i]);

        $consulta2 = "INSERT INTO actividaplaneadadas VALUES(null,'" . $id_eva . "','" . $parAct[0] . "',"
                . "'" . $parAct[1] . "','PENDIENTE')";
        //echo $consulta2;
        mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }
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