<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysql_query("BEGIN");

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO clasificacion_proyecto VALUES(null,'" . $_POST['cod'] . "','" . $_POST['id'] . "',"
            . "'" . $_POST['des'] . "')";
} else {
    $consulta = "DELETE FROM clasificacion_proyecto WHERE id='" . $_POST['cod'] . "'";
}



//echo $consulta;
$qc = mysql_query($consulta, $link);

if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 1;
}


if ($success == 0) {
    mysql_query("ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysql_query("COMMIT");
    echo "bien";
}

mysql_close();
?>