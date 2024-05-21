<?php

session_start();
include "../Conectar.php";

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");

if ($_REQUEST['opcion'] == "GUARDAR") {
    $sql = "INSERT INTO fuentes VALUES(
        null,'" . cambiarLetra($_REQUEST['nombre']) . "','" . cambiarLetra($_REQUEST['descripcion']) . "','ACTIVO'
    )";
}
if ($_REQUEST['opcion'] == "MODIFICAR") {
    $sql = "UPDATE fuentes SET
        nombre='" . cambiarLetra($_REQUEST['nombre']) . "',descripcion='" . cambiarLetra($_REQUEST['descripcion']) . "',estado='ACTIVO'
        WHERE id='" . cambiarLetra($_REQUEST['id']) . "'
    ";
}
if ($_REQUEST['opcion'] == "ELIMINAR") {
    $sql = "UPDATE fuentes SET estado='INACTIVO'
        WHERE id='" . cambiarLetra($_REQUEST['id']) . "'
    ";
}
$qc = mysqli_query($link, $sql);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
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
