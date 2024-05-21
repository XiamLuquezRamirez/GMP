<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");



if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfiles VALUES(null,'" . $_POST['txt_Nomb'] . "','" . $_SESSION['ses_complog'] . "')";

    //   echo $consulta;
    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(idperfil) AS id FROM ".$_SESSION['ses_BDBase'].".perfiles";
    $resulsql = mysqli_query($link,$sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_perf = $fila["id"];
        }
    }

    ///GUARDAR PERMISOS PLAN DE DESARRROLLO

    $Tam_Plan = explode(";", $_POST['Dat_Plan']);

    for ($i = 0; $i < count($Tam_Plan); $i++) {
        $consulta2 = "";
        $PaPla = explode(";", $_POST['Dat_Plan']);
        $itePar = explode("/", $PaPla[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_plan VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS PROYECTO

    $Tam_Proy = explode(";", $_POST['Dat_Proy']);

    for ($i = 0; $i < count($Tam_Proy); $i++) {
        $consulta2 = "";
        $PaProy = explode(";", $_POST['Dat_Proy']);
        $itePar = explode("/", $PaProy[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_proy VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS INFORMES

    $Tam_Inf = explode(";", $_POST['Dat_Inf']);

    for ($i = 0; $i < count($Tam_Inf); $i++) {
        $consulta2 = "";
        $PaInf = explode(";", $_POST['Dat_Inf']);
        $itePar = explode("/", $PaInf[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_inf VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS EVALUACION

    $Tam_Eva = explode(";", $_POST['Dat_Eva']);

    for ($i = 0; $i < count($Tam_Eva); $i++) {
        $consulta2 = "";
        $PaEva = explode(";", $_POST['Dat_Eva']);
        $itePar = explode("/", $PaEva[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_eval VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS PARAMETROS

    $Tam_Par = explode(";", $_POST['Dat_Par']);

    for ($i = 0; $i < count($Tam_Par); $i++) {
        $consulta2 = "";
        $PaPar = explode(";", $_POST['Dat_Par']);
        $itePar = explode("/", $PaPar[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_para VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS USUARIOS

    $Tam_Usu = explode(";", $_POST['Dat_Usu']);

    for ($i = 0; $i < count($Tam_Usu); $i++) {
        $consulta2 = "";
        $PaUsu = explode(";", $_POST['Dat_Usu']);
        $itePar = explode("/", $PaUsu[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_usu VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS AVANCES

    $Tam_Ava = explode(";", $_POST['Dat_Ava']);

    for ($i = 0; $i < count($Tam_Ava); $i++) {
        $consulta2 = "";
        $PaAva = explode(";", $_POST['Dat_Ava']);
        $itePar = explode("/", $PaAva[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_avan VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
} else if ($_POST['acc'] == "2") {

    $consulta = "UPDATE ".$_SESSION['ses_BDBase'].".perfiles SET nomperfil='" . $_POST['txt_Nomb'] . "', compania='" . $_SESSION['ses_complog'] . "'  WHERE idperfil='" . $_POST['id'] . "'";
    //echo $consulta;
    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_perf = $_POST['id'];

    ///GUARDAR PERMISOS PLAN DE DESARRROLLO


    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_plan WHERE idperf_perfil_plan='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Plan = explode(";", $_POST['Dat_Plan']);

    for ($i = 0; $i < count($Tam_Plan); $i++) {
        $consulta2 = "";
        $PaPla = explode(";", $_POST['Dat_Plan']);
        $itePar = explode("/", $PaPla[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_plan VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS PROYECTO

    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_proy WHERE idperf_perfil_proy='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Proy = explode(";", $_POST['Dat_Proy']);

    for ($i = 0; $i < count($Tam_Proy); $i++) {
        $consulta2 = "";
        $PaProy = explode(";", $_POST['Dat_Proy']);
        $itePar = explode("/", $PaProy[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_proy VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS INFORMES
    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_inf WHERE idperf_perfil_inf='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Inf = explode(";", $_POST['Dat_Inf']);

    for ($i = 0; $i < count($Tam_Inf); $i++) {
        $consulta2 = "";
        $PaInf = explode(";", $_POST['Dat_Inf']);
        $itePar = explode("/", $PaInf[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_inf VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS EVALUACION

    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_eval WHERE idperf_perfil_eval='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Eva = explode(";", $_POST['Dat_Eva']);

    for ($i = 0; $i < count($Tam_Eva); $i++) {
        $consulta2 = "";
        $PaEva = explode(";", $_POST['Dat_Eva']);
        $itePar = explode("/", $PaEva[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_eval VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS PARAMETROS
    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_para WHERE idperf_perfil_para='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Par = explode(";", $_POST['Dat_Par']);

    for ($i = 0; $i < count($Tam_Par); $i++) {
        $consulta2 = "";
        $PaPar = explode(";", $_POST['Dat_Par']);
        $itePar = explode("/", $PaPar[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_para VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
    ///GUARDAR PERMISOS USUARIOS
    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_usu WHERE idperf_perfil_usu='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Usu = explode(";", $_POST['Dat_Usu']);

    for ($i = 0; $i < count($Tam_Usu); $i++) {
        $consulta2 = "";
        $PaUsu = explode(";", $_POST['Dat_Usu']);
        $itePar = explode("/", $PaUsu[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_usu VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }


    ///GUARDAR PERMISOS AVANCES
    $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_avan WHERE idperf_perfil_ava='" . $id_perf . "'";

    $qc = mysqli_query($link,$consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    $Tam_Ava = explode(";", $_POST['Dat_Ava']);

    for ($i = 0; $i < count($Tam_Ava); $i++) {
        $consulta2 = "";
        $PaAva = explode(";", $_POST['Dat_Ava']);
        $itePar = explode("/", $PaAva[$i]);

        $consulta2 = "INSERT INTO ".$_SESSION['ses_BDBase'].".perfil_avan VALUES(null,'" . $id_perf . "','" . $itePar[0] . "','" . $itePar[1] . "','" . $itePar[2] . "','" . $itePar[3] . "','" . $itePar[4] . "')";

        $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
    }
} else {

    $flag = "s";
    $parper = explode("/", $_POST['cod']);

    $consulta = "SELECT * FROM ".$_SESSION['ses_BDBase'].".usuarios where niv_codigo='" . $parper[0] . "'";
    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }



    if ($flag == "s") {
        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfiles WHERE idperfil='" . $parper[1] . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }

        $id_perf = $parper[1];

        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_plan WHERE idperf_perfil_plan='" . $id_perf . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }

        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_proy WHERE idperf_perfil_proy='" . $id_perf . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }

        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_inf WHERE idperf_perfil_inf='" . $id_perf . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }

        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_eval WHERE idperf_perfil_eval='" . $id_perf . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }


        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_para WHERE idperf_perfil_para='" . $id_perf . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }

        $consulta = "DELETE FROM ".$_SESSION['ses_BDBase'].".perfil_usu WHERE idperf_perfil_usu='" . $id_perf . "'";

        $qc = mysqli_query($link,$consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }
    } else {
        echo "no";
    }
}


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Perfil " . $_POST['txt_Nomb'] . "' ,'INSERCION', 'contrato.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Perfil " . $_POST['txt_Nomb'] . "' ,'ACTUALIZACION', '"
            . "contrato.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Perfil
            " . $_POST['cod'] . "' ,'ELIMINACION', 'contrato.php')";
}



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