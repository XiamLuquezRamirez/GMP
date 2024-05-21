<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");
mysqli_set_charset($link,'utf8');

$baseAct = "";
$Tam_Medi = $_POST['Long_Medi'];
for ($i = 1; $i <= $Tam_Medi; $i++) {
    $consulta2 = "";

    $parmed = explode("//", $_POST['Medi' . $i]);
    $baseAct = $parmed[4];
    $consulta2 = "INSERT INTO medir_indmeta VALUES(null,'" . $_POST['txt_idmet'] . "','" . $_POST['txt_desmet'] . "',"
            . "'" . $_POST['txt_idProy'] . "','" . $_POST['txt_desProy'] . "','" . $parmed[0] . "','" . $parmed[1] . "',"
            . "'" . $parmed[2] . "','" . $parmed[3] . "','" . $parmed[4] . "','" . $parmed[5] . "','" . $parmed[6] . "')";
    //echo $consulta2;
    $qc2 = mysqli_query($link,$consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
}

$consulta = "UPDATE metas SET baseactual_metas='" . $baseAct . "'  WHERE id_meta='" . $_POST['txt_idmet'] . "'";
//echo $consulta;
$qc = mysqli_query($link,$consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
}


$consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Medicion " . $_POST['txt_idmet'] . "' ,'INSERCION', 'MedIndicadores.php')";

$qc = mysqli_query($link,$consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 4;
}

if ($success == 0) {
    mysqli_query($link,"ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link,"COMMIT");
    echo "bien";
}

mysqli_close($link);
?>