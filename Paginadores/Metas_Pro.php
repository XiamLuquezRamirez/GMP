<?php

session_start();
include "../Conectar.php";
$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');

if ($_REQUEST["OPCION"] == "CONSULTARPROGRAMAS") {
    $consulta = "SELECT * FROM componente
        WHERE  ID_EJE='" . $_REQUEST['id_eje'] . "' AND ESTADO='ACTIVO' ";
    $resultado = mysqli_query($link, $consulta);
    $programas = [];
    $TIENE = 0;
    $resp = [];
    $contador = 0;
    if (mysqli_num_rows($resultado) > 0) {
        $i = 1;
        while ($fila = mysqli_fetch_array($resultado)) {
            $programas['ID_PROGRAMA'][$i] = $fila["ID"];
            $programas['PROGRAMA'][$i] = $fila["NOMBRE"];
            $TIENE = 1;
            $contador++;
            $i++;
        }
    }
    $programas['TAM'] = $contador;
    $resp['TIENE'] = $TIENE;
    $resp['programas'] = $programas;
    mysqli_close($link);
    echo json_encode($resp);
}

if ($_REQUEST["OPCION"] == "CONSULTARSUBPROGRAMAS") {
    $consulta = "SELECT * FROM programas
        WHERE  ID_EJE='" . $_REQUEST['id_eje'] . "' AND ID_COMP='" . $_REQUEST['id_pro'] . "' AND ESTADO='ACTIVO' ";
    $resultado = mysqli_query($link, $consulta);
    $programas = [];
    $TIENE = 0;
    $resp = [];
    $contador = 0;
    if (mysqli_num_rows($resultado) > 0) {
        $i = 1;
        while ($fila = mysqli_fetch_array($resultado)) {
            $programas['ID_SUBPROGRAMA'][$i] = $fila["ID"];
            $programas['SUBPROGRAMA'][$i] = $fila["NOMBRE"];
            $TIENE = 1;
            $contador++;
            $i++;
        }
    }
    $programas['TAM'] = $contador;
    $resp['TIENE'] = $TIENE;
    $resp['programas'] = $programas;
    mysqli_close($link);
    echo json_encode($resp);
}

if ($_REQUEST["OPCION"] == "GUARDAR") {
    // GUARDAR POLIZA
    $consulta = "REPLACE INTO metas_productos
        VALUES(
            '" . $_REQUEST['id'] . "','" . $_REQUEST['descripcion'] . "','" . $_REQUEST['objetivo'] . "','" . $_REQUEST['id_secretaria'] . "',
            '" . $_REQUEST['clasificacion'] . "','ACTIVO','" . $_REQUEST['codigo'] . "','" . $_REQUEST['id_eje'] . "',
            '" . $_REQUEST['id_programa'] . "','" . $_REQUEST['id_subprograma'] . "'
        )";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }
    if ($_REQUEST["aumentar"] == "SI") {
        $consulta1 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='METAS_PRODUCTOS'";
        mysqli_query($link, $consulta1);
    }

    if ($success == 0) {
        mysqli_query($link, "ROLLBACK");
        echo $error;
        echo $consulta;
    } else {
        mysqli_query($link, "COMMIT");
        echo 1;
    }

    mysqli_close($link);
    // echo $consulta;
    // GUARDAR POLIZA
}

if ($_REQUEST['OPCION'] == "ELIMINAR") {
    $consulta = "UPDATE metas_productos SET estado='INACTIVO'
        WHERE id='" . cambiarLetra($_REQUEST['id']) . "'
    ";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }

    if ($success == 0) {
        mysqli_query($link, "ROLLBACK");
        echo $error;
        echo $consulta;
    } else {
        mysqli_query($link, "COMMIT");
        echo 1;
    }

    mysqli_close($link);
}
function cambiarLetra($string)
{
    $string = trim($string);
    $string = str_replace(
        array("#Agrave", "#Aacute", "#Acirc", "#Atilde", "#Auml"), array("Á", "Á", "Á", "Á", "Á"), $string
    );
    $string = str_replace(
        array("#Aring", "#AElig", "#Ccedil", "#Egrave", "#Eacute"), array("Å", "Æ", "Ç", "È", "É"), $string
    );
    $string = str_replace(
        array("#Ecirc", "#Euml", "#Igrave", "#Iacute", "#Icirc"), array("Ê", "Ë", "Ì", "Í", "Î"), $string
    );
    $string = str_replace(
        array("#Iuml", "#ETH", "#Ntilde", "#Ograve", "#Oacute"), array("Ï", "Ð", "Ñ", "Ò", "Ó"), $string
    );
    $string = str_replace(
        array("#Ocirc", "#Otilde", "#Ouml", "#times", "#Oslash"), array("Ô", "Õ", "Ö", "×", "Ø"), $string
    );
    $string = str_replace(
        array("#Ugrave", "#Uacute", "#Ucirc", "#Uuml", "#Yacute"), array("Ù", "Ú", "Û", "Ü", "Ý"), $string
    );
    $string = str_replace(
        array("#THORN", "#szlig", "#agrave", "#aacute", "#acirc"), array("Þ", "ß", "à", "á", "â"), $string
    );
    $string = str_replace(
        array("#atilde", "#auml", "#aring", "#aelig", "#ccedil"), array("ã", "ä", "å", "æ", "ç"), $string
    );
    $string = str_replace(
        array("#egrave", "#eacute", "#ecirc", "#euml", "#igrave"), array("è", "é", "ê", "ë", "ì"), $string
    );
    $string = str_replace(
        array("#iacute", "#icirc", "#iuml", "#eth", "#ntilde"), array("í", "î", "ï", "ð", "ñ"), $string
    );
    $string = str_replace(
        array("#ograve", "#oacute", "#ocirc", "#otilde", "#ouml"), array("ò", "ó", "ô", "õ", "ö"), $string
    );
    $string = str_replace(
        array("#divide", "#oslash", "#ugrave", "#uacute", "#ucirc"), array("÷", "ø", "ù", "ú", "û"), $string
    );
    $string = str_replace(
        array("#uuml", "#yacute", "#thorn", "#yuml", "#ucirc"), array("ü", "ý", "þ", "ÿ", "û"), $string
    );
    $string = str_replace(
        array("##37", "##96", "#deg", "##126", "#DEG"), array("%", "`", "°", "~", "°"), $string
    );
    return $string;
}
