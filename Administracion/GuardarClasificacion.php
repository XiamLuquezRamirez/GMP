<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO clasificacion_proyecto VALUES(null,'" . $_POST['cod'] . "','" . $_POST['id'] . "',"
        . "'" . $_POST['des'] . "')";
} else {
    $consulta = "DELETE FROM clasificacion_proyecto WHERE id='" . $_POST['cod'] . "'";
}



//echo $consulta;
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
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
