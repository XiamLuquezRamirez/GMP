<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");

$flag = "s";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO contratistas VALUES(null,'" . $_POST['CbPersona'] . "','" . $_POST['cbx_tipo_ident'] . "',"
            . "'" . $_POST['txt_ident'] . "','" . $_POST['txt_dv'] . "','" . $_POST['txt_Nomb'] . "','" . $_POST['txt_Tel'] . "',"
            . "'" . $_POST['txt_Direc'] . "','" . $_POST['txt_Correo'] . "','" . $_POST['txt_IdRepr'] . "','" . $_POST['txt_NomRepr'] . "',"
            . "'" . $_POST['txt_TelRepr'] . "','" . $_POST['CbDepa'] . "','" . $_POST['CbMun'] . "','ACTIVO',"
            . "'" . $_POST['txt_obser'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE contratistas SET tper_contratis='" . $_POST['CbPersona'] . "',"
            . "tid_contratis='" . $_POST['cbx_tipo_ident'] . "',ident_contratis='" . $_POST['txt_ident'] . "',"
            . "dv_contratis='" . $_POST['txt_dv'] . "',nom_contratis='" . $_POST['txt_Nomb'] . "',"
            . "telcon_contratis='" . $_POST['txt_Tel'] . "',dircon_contratis='" . $_POST['txt_Direc'] . "',"
            . "corcont_contratis='" . $_POST['txt_Correo'] . "',idrpr_contratis='" . $_POST['txt_IdRepr'] . "',"
            . "nomrpr_contratis='" . $_POST['txt_NomRepr'] . "',telrpr_contratis='" . $_POST['txt_TelRepr'] . "',"
            . "depart_contratis='" . $_POST['CbDepa'] . "',mun_contratis='" . $_POST['CbMun'] . "',"
            . "observ_contratist='" . $_POST['txt_obser'] . "' WHERE id_contratis='" . $_POST['id'] . "' ";
} else {
    $consulta = "SELECT * FROM contratos WHERE idcontrati_contrato='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    $consulta = "UPDATE contratistas SET estado_contratis='ELIMINADO' WHERE id_contratis='" . $_POST['cod'] . "' ";
}

if ($flag == "s") {
    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else {
    echo $flag;
}


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Contratista " . $_POST['txt_ident'] . "' ,'INSERCION', 'GestionContratistas.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Contratista " . $_POST['txt_ident'] . "' ,'ACTUALIZACION', 'GestionContratistas.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Contratista
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GestionContratistas.php')";
}

$qc = mysqli_query($link,$consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
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