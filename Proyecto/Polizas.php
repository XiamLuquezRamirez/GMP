<?php

session_start();
include "../Conectar.php";
$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');

if ($_REQUEST["OPCION"] == "GUARDAR") {
    // GUARDAR POLIZA
    $consulta = "REPLACE INTO polizas(id_contrato,num_poliza,fecha_ini,fecha_fin,anexo,estado)
        VALUES(
            '" . $_REQUEST['id_contrato'] . "','" . $_REQUEST['num_poliza'] . "','" . $_REQUEST['fecha_ini'] . "',
            '" . $_REQUEST['fecha_fin'] . "','" . $_REQUEST['anexo'] . "','Activo'
        )";

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
    // echo $consulta;
    // GUARDAR POLIZA
}
if ($_REQUEST["OPCION"] == "CONSULTAR") {
    $consulta = "SELECT * FROM polizas
        WHERE  id_contrato='" . $_REQUEST['id_contrato'] . "' AND estado='Activo' ";
    $resultado = mysqli_query($link, $consulta);
    $contrato = [];
    $TIENE = 0;
    $resp = [];
    $contador = 0;
    if (mysqli_num_rows($resultado) > 0) {
        $i = 1;
        while ($fila = mysqli_fetch_array($resultado)) {
            $contrato['id_contrato'][$i] = $fila["id_contrato"];
            $contrato['num_poliza'][$i] = $fila["num_poliza"];
            $contrato['fecha_ini'][$i] = $fila["fecha_ini"];
            $contrato['fecha_fin'][$i] = $fila["fecha_fin"];
            $contrato['anexo'][$i] = $fila["anexo"];
            $TIENE = 1;
            $contador++;
            $i++;
        }
    }
    $contrato['tam'] = $contador;
    $resp['TIENE'] = $TIENE;
    $resp['contrato'] = $contrato;
    mysqli_close($link);
    echo json_encode($resp);
}
if ($_REQUEST["OPCION"] == "CONSULTARALERTAS") {
    $campo = array();

    $MAS = 0;
    $MENOS = 0;
    $sql = "SELECT * FROM parametros_alerta";
    $consulta = mysqli_query($link, $sql);
    while ($resp = $consulta->fetch_assoc()) {
        $MAS = $resp['mas'];
        $MENOS = $resp['menos'];
    }


    $k = 1;
    $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                    c.ffin_contrato,c.estad_contrato,c.num_contrato,
                    p.fecha_ini,p.fecha_fin,SYSDATE() AS FECHAHOY,p.num_poliza,
                DATEDIFF(p.fecha_fin, p.fecha_ini) DIFERENCIADIAS,DATEDIFF(p.fecha_fin, SYSDATE()) DIFERENCIAPOLIZA
            FROM
                contratos AS c
                    INNER JOIN
                polizas AS p ON c.num_contrato = p.id_contrato
            WHERE
                estad_contrato = 'Ejecucion' 
            GROUP BY c.num_contrato";
    $consulta = mysqli_query($link, $sql);
    $RIESGOBAJO = 0;
    $RIESGOMEDIO = 0;
    $RIESGOALTO = 0;
    $porciones[] = 100;

    while ($resp = $consulta->fetch_assoc()) {
        $DIFERENCIADIAS = $resp['DIFERENCIADIAS'];
        $DIFERENCIAPOLIZA = $resp['DIFERENCIAPOLIZA'];
        $DIFERENCIA = $DIFERENCIADIAS - $DIFERENCIAPOLIZA;
        if ($DIFERENCIA < 0) {
            $DIFERENCIA = $DIFERENCIA * -1;
        }
        $porriezgo = (($DIFERENCIA * 100) / $DIFERENCIADIAS);
        $porciones = explode("%", $resp['porav_contrato']);
        $por_contrato = $porciones[0];

        $porriezgoMAS = $porriezgo + $MAS;
        $porriezgoMENOS = $porriezgo - $MENOS;
        if ($por_contrato > $porriezgoMAS) {
            $RIESGOBAJO++;
        } else {
            if ($por_contrato >= $porriezgoMENOS) {
                $RIESGOMEDIO++;
            } else {
                $RIESGOALTO++;
            }
        }
    }
    $campo["RIESGOBAJO"] = $RIESGOBAJO;
    $campo["RIESGOMEDIO"] = $RIESGOMEDIO;
    $campo["RIESGOALTO"] = $RIESGOALTO;

    // MENOR A 0 DIAS
    mysqli_close($link);
    echo json_encode($campo);
}

if ($_REQUEST["OPCION"] == "PAGINAR2") {

    $MAS = 0;
    $MENOS = 0;
    $sql = "SELECT * FROM parametros_alerta";
    $consulta = mysqli_query($link, $sql);
    while ($resp = $consulta->fetch_assoc()) {
        $MAS = $resp['mas'];
        $MENOS = $resp['menos'];
    }

    $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                    c.ffin_contrato,c.estad_contrato,c.num_contrato,
                    p.fecha_ini,p.fecha_fin,SYSDATE() AS FECHAHOY,p.num_poliza,
                DATEDIFF(p.fecha_fin, p.fecha_ini) DIFERENCIADIAS,DATEDIFF(p.fecha_fin, SYSDATE()) DIFERENCIAPOLIZA
            FROM
                contratos AS c
                    INNER JOIN
                polizas AS p ON c.num_contrato = p.id_contrato
            WHERE
                estad_contrato = 'Ejecucion' 
            GROUP BY c.num_contrato";
    $campo = array();
    $RESPUESTA = array();

    $consulta = mysqli_query($link, $sql);
    $kA = 1;
    $kM = 1;
    $kB = 1;
    $OpA = "No_Existe";
    $OpM = "No_Existe";
    $OpB = "No_Existe";
    $RIESGOBAJO = array();
    $RIESGOMEDIO = array();
    $RIESGOALTO = array();
    $porciones = "";
    while ($resp = $consulta->fetch_assoc()) {
        $DIFERENCIADIAS = $resp['DIFERENCIADIAS'];
        $DIFERENCIAPOLIZA = $resp['DIFERENCIAPOLIZA'];
        $DIFERENCIA = $DIFERENCIADIAS - $DIFERENCIAPOLIZA;
        if ($DIFERENCIA < 0) {
            $DIFERENCIA = $DIFERENCIA * -1;
        }
        $porriezgo = (($DIFERENCIA * 100) / $DIFERENCIADIAS);
        $porciones = explode("%", $resp['porav_contrato']);
        $por_contrato = $porciones[0];

        $porriezgoMAS = $porriezgo + $MAS;
        $porriezgoMENOS = $porriezgo - $MENOS;
        if ($por_contrato > $porriezgoMAS) {
            $OpB = "Existe";
            $RIESGOBAJO["id_contrato"][$kB] = $resp['id_contrato'];
            $RIESGOBAJO["num_contrato"][$kB] = $resp['num_contrato'];
            $RIESGOBAJO["obj_contrato"][$kB] = stripslashes(utf8_decode(cambiarLetra($resp['obj_contrato'])));
            $RIESGOBAJO["fini_contrato"][$kB] = $resp['fini_contrato'];
            $RIESGOBAJO["ffin_contrato"][$kB] = $resp['ffin_contrato'];
            $RIESGOBAJO["porav_contrato"][$kB] = stripslashes(utf8_decode($resp['porav_contrato']));
            $RIESGOBAJO["estad_contrato"][$kB] = $resp['estad_contrato'];
            $RIESGOBAJO["num_poliza"][$kB] = $resp['num_poliza'];
            $RIESGOBAJO["fecha_ini"][$kB] = $resp['fecha_ini'];
            $RIESGOBAJO["fecha_fin"][$kB] = $resp['fecha_fin'];
            $kB++;
        } else {
            if ($por_contrato >= $porriezgoMENOS) {
                $OpM = "Existe";
                $RIESGOMEDIO["id_contrato"][$kM] = $resp['id_contrato'];
                $RIESGOMEDIO["num_contrato"][$kM] = $resp['num_contrato'];
                $RIESGOMEDIO["obj_contrato"][$kM] = stripslashes(utf8_decode(cambiarLetra($resp['obj_contrato'])));
                $RIESGOMEDIO["fini_contrato"][$kM] = $resp['fini_contrato'];
                $RIESGOMEDIO["ffin_contrato"][$kB] = $resp['ffin_contrato'];
                $RIESGOMEDIO["porav_contrato"][$kM] = stripslashes(utf8_decode($resp['porav_contrato']));
                $RIESGOMEDIO["estad_contrato"][$kM] = $resp['estad_contrato'];
                $RIESGOMEDIO["num_poliza"][$kM] = $resp['num_poliza'];
                $RIESGOMEDIO["fecha_ini"][$kM] = $resp['fecha_ini'];
                $RIESGOMEDIO["fecha_fin"][$kM] = $resp['fecha_fin'];
                $kM++;
            } else {
                $OpA = "Existe";
                $RIESGOALTO["id_contrato"][$kA] = $resp['id_contrato'];
                $RIESGOALTO["num_contrato"][$kA] = $resp['num_contrato'];
                $RIESGOALTO["obj_contrato"][$kA] = stripslashes(utf8_decode(cambiarLetra($resp['obj_contrato'])));
                $RIESGOALTO["fini_contrato"][$kA] = $resp['fini_contrato'];
                $RIESGOALTO["ffin_contrato"][$kB] = $resp['ffin_contrato'];
                $RIESGOALTO["porav_contrato"][$kA] = stripslashes(utf8_decode($resp['porav_contrato']));
                $RIESGOALTO["estad_contrato"][$kA] = $resp['estad_contrato'];
                $RIESGOALTO["num_poliza"][$kA] = $resp['num_poliza'];
                $RIESGOALTO["fecha_ini"][$kA] = $resp['fecha_ini'];
                $RIESGOALTO["fecha_fin"][$kA] = $resp['fecha_fin'];
                $kA++;
            }
        }
    }
    $campo["RIESGOBAJO"] = $RIESGOBAJO;
    $campo["RIESGOMEDIO"] = $RIESGOMEDIO;
    $campo["RIESGOALTO"] = $RIESGOALTO;

    $campo["tamA"] = $kA - 1;
    $campo["tamM"] = $kM - 1;
    $campo["tamB"] = $kB - 1;
    $campo["Salida"] = 1;
    $campo["OpA"] = $OpA;
    $campo["OpM"] = $OpM;
    $campo["OpB"] = $OpB;
    mysqli_close($link);
    echo json_encode($campo);
}

if ($_REQUEST["OPCION"] == "GUARDARPARAMETROSALERTA") {
    // GUARDAR POLIZA
    $consulta = "REPLACE INTO parametros_alerta(id,menos,mas)
        VALUES(
            '" . $_REQUEST['id'] . "','" . $_REQUEST['menos'] . "','" . $_REQUEST['mas'] . "'
        )";
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
    // echo $consulta;
    // GUARDAR POLIZA
}

function cambiarLetra($string) {
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
