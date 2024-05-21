<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");


$par = explode("/", substr($_POST["Dat_Actv"], 0, -1));
$Tam_MediInd = count($par);

$consulta = "UPDATE actividaplaneadadas set estado='PENDIENTE'";

$qc2 = mysqli_query($link, $consulta);
if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

for ($i = 0; $i < $Tam_MediInd; $i++) {

    $consulta = "UPDATE actividaplaneadadas set estado='CUMPLIDA' WHERE id='" . $par[$i] . "'";

    $qc2 = mysqli_query($link, $consulta);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
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