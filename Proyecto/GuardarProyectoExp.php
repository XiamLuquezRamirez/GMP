<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
$id_Proy = "";

mysqli_set_charset($link, 'utf8');

if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO proyectos_expres VALUES(null,'" . $_POST['txt_CodProy'] . "',"
        . "'" . $_POST['txt_NombProy'] . "','ACTIVO')";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(id) AS id FROM proyectos_expres";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Proy = $fila["id"];
        }
    }
} else if ($_POST['acc'] == "2") {

    $consulta = "UPDATE proyectos_expres SET codigo='" . $_POST['txt_CodProy'] . "',"
        . "nombre='" . $_POST['txt_NombProy'] . "' WHERE id='" . $_POST['id'] . "'";
    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
    $id_Proy = $_POST['id'];
} else {
    $id_Cont = $_POST['cod'];
    $consulta = "UPDATE proyectos_expres SET estado='Eliminado' WHERE id='" . $_POST['cod'] . "' ";
    //  echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
    $id_Proy = $_POST['cod'];
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien/" . $id_Proy;
}

mysqli_close($link);
