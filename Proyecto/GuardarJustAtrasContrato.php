<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

mysqli_set_charset($link, 'utf8');

$consulta = "REPLACE INTO justif_atraso_cont VALUES('" . $_POST['id_contrato'] . "',"
        . "'" . $_POST['txt_JustAtraso'] . "','" . $_POST['eviden'] . "','" . $_POST['num_cont'] . "')";

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
    echo "bien" ;
}

mysqli_close($link);
?>