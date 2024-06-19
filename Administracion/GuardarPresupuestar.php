<?php

session_start();
include "../Conectar.php";
$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');

if ($_REQUEST["OPCION"] == "CONSULTAR") {

    $consulta = "SELECT
                    s.idsecretarias AS IDSECRE,
                    ps.id AS IDSP,
                    f.id AS IDFUENTE,
                    f.nombre AS FUENTE,
                    sf.id AS IDSUBFUENTE,
                    sf.descripcion AS SUBFUENTE,
                    ps.valor AS VALOR,
                    ps.fecha AS FECHA,
                    ps.estado AS ESTADO
                FROM
                    secretarias AS s
                INNER JOIN
                    presupuesto_secretarias AS ps ON s.idsecretarias = ps.id_secretaria
                INNER JOIN
                    fuentes AS f ON f.id = ps.id_fuente
                INNER JOIN
                subfinanciacion AS sf ON sf.id = ps.id_subfuente
                WHERE s.idsecretarias = '" . $_REQUEST['id_secretaria'] . "' AND ps.estado = 'ACTIVO'";
    //  echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    $presupuestar = [];
    $TIENE = 0;
    $resp = [];
    $contador = 0;
    if (mysqli_num_rows($resultado) > 0) {
        $i = 1;
        while ($fila = mysqli_fetch_array($resultado)) {
            $presupuestar['IDSP'][$i] = $fila["IDSP"];
            $presupuestar['IDFUENTE'][$i] = $fila["IDFUENTE"];
            $presupuestar['FUENTE'][$i] = $fila["FUENTE"];
            $presupuestar['IDSUBFUENTE'][$i] = $fila["IDSUBFUENTE"];
            $presupuestar['SUBFUENTE'][$i] = $fila["SUBFUENTE"];
            $presupuestar['VALOR'][$i] = $fila["VALOR"];
            $presupuestar['FECHA'][$i] = $fila["FECHA"];
            $presupuestar['ESTADO'][$i] = $fila["ESTADO"];
            $presupuestar['IDSECRE'][$i] = $fila["IDSECRE"];
            $TIENE = 1;
            $contador++;
            $i++;
        }
    }
    $resp['tam'] = $contador;
    $resp['TIENE'] = $TIENE;
    $resp['presupuestar'] = $presupuestar;

    $consulta = "SELECT
                    f.nombre AS FUENTE,
                    sf.descripcion AS SUBFUENTE,
                    SUM(ps.valor) AS VALOR
                FROM
                    secretarias AS s
                INNER JOIN
                    presupuesto_secretarias AS ps ON s.idsecretarias = ps.id_secretaria
                INNER JOIN
                    fuentes AS f ON f.id = ps.id_fuente
                    INNER JOIN
                subfinanciacion AS sf ON sf.id = ps.id_subfuente
                WHERE s.idsecretarias = '" . $_REQUEST['id_secretaria'] . "' AND ps.estado = 'ACTIVO'
                GROUP BY f.id";

    $resultado = mysqli_query($link, $consulta);
    $grantotal = [];
    $TIENE2 = 0;
    $contador2 = 0;
    if (mysqli_num_rows($resultado) > 0) {
        $i = 1;
        while ($fila = mysqli_fetch_array($resultado)) {
            $grantotal['FUENTE'][$i] = $fila["FUENTE"];
            $grantotal['SUBFUENTE'][$i] = $fila["SUBFUENTE"];
            $grantotal['VALOR'][$i] = $fila["VALOR"];
            $TIENE2 = 1;
            $contador2++;
            $i++;
        }
    }
    $resp['tam2'] = $contador2;
    $resp['TIENE2'] = $TIENE2;
    $resp['grantotal'] = $grantotal;
    mysqli_close($link);
    echo json_encode($resp);
}
if ($_REQUEST["OPCION"] == "GUARDAR") {
    
    $consulta="delete from presupuesto_secretarias where id_secretaria='".$_REQUEST["txtidSec"]."'";
//    echo $consulta;
    $qc = mysqli_query($link, $consulta);
    
    foreach ($_REQUEST["txtid"] as $key => $val) {
        if ($_REQUEST["txtid"] == "0") {
            $sql = "INSERT INTO presupuesto_secretarias VALUES(
                null,'" . $_REQUEST["txtid_fuente"][$key] . "','" . $_REQUEST["txtid_secretaria"][$key] . "',
                '" . $_REQUEST["txtvalor"][$key] . "','" . $_REQUEST["txtfecha"][$key] . "','ACTIVO','" . $_REQUEST["txtid_subfuente"][$key] . "'
            )";
        } else {
            $sql = "REPLACE INTO presupuesto_secretarias VALUES(
                '" . $_REQUEST["txtid"][$key] . "','" . $_REQUEST["txtid_fuente"][$key] . "','" . $_REQUEST["txtid_secretaria"][$key] . "',
                '" . $_REQUEST["txtvalor"][$key] . "','" . $_REQUEST["txtfecha"][$key] . "','ACTIVO','" . $_REQUEST["txtid_subfuente"][$key] . "'
            )";
        }
        $qc = mysqli_query($link, $sql);
    }
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
