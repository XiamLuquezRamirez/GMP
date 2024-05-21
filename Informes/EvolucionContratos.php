<?php

session_start();
include "../Conectar.php";
$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');
if ($_REQUEST["OPCION"] == "CONSULTARCONTRATOS") {
    $campo = array();
    $resultado = array();
    $k = 1;
    $busqueda = $_REQUEST["busqueda"];
    if ($busqueda != "") {
        $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                    c.ffin_contrato,c.estad_contrato
                FROM
                    contratos as c
                WHERE
                    c.estad_contrato = 'Ejecucion' AND
                    (c.num_contrato like '%" . $busqueda . "%' OR c.obj_contrato like '%" . $busqueda . "%')
                GROUP BY c.num_contrato
                ORDER BY c.num_contrato LIMIT 10 ";
    } else {
        $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                    c.ffin_contrato,c.estad_contrato
                FROM
                    contratos as c
                WHERE
                    c.estad_contrato = 'Ejecucion'
                GROUP BY c.num_contrato
                ORDER BY c.num_contrato LIMIT 10 ";
    }

    $Op = "No_Existe";
    $consulta = mysqli_query($link, $sql);
    while ($resp = $consulta->fetch_assoc()) {
        $Op = "Existe";
        $campo["id_contrato"][$k] = $resp['id_contrato'];
        $campo["num_contrato"][$k] = $resp['num_contrato'];
        $campo["obj_contrato"][$k] = stripslashes(utf8_decode(cambiarLetra($resp['obj_contrato'])));
        $campo["fini_contrato"][$k] = $resp['fini_contrato'];
        $campo["ffin_contrato"][$k] = $resp['ffin_contrato'];
        $campo["porav_contrato"][$k] = stripslashes(utf8_decode($resp['porav_contrato']));
        $campo["estad_contrato"][$k] = $resp['estad_contrato'];
        $k++;
    }
    $resultado["contrato"] = $campo;
    $resultado["Salida"] = 1;
    $resultado["Op"] = $Op;
    $resultado["tam"] = $k - 1;
    mysqli_close($link);
    echo json_encode($resultado);
}
if ($_REQUEST["OPCION"] == "CONSULTAREVOLUCIONES") {
    $campo = array();
    $resultado = array();
    $k = 1;
    $tipoInforme = $_REQUEST["tipoInforme"];
    $num_contrato = $_REQUEST["num_contrato"];
    if ($tipoInforme == "INDIVIDUAL") {
        $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                    c.ffin_contrato,c.estad_contrato,
                    c.vadic_contrato,c.vfin_contrato,c.veje_contrato,c.fsusp_contrato,c.frein_contrato,
                    c.prorg_contrato,c.frecb_contrato
                FROM
                    contratos as c
                WHERE
                    c.num_contrato = '" . $num_contrato . "' AND c.estad_contrato = 'Ejecucion'
                ORDER BY c.num_contrato ASC";
    } else {
        $cod_proyect = $_REQUEST["cod_proyect"];
        if ($cod_proyect == "TODOS") {
            $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                c.ffin_contrato,c.estad_contrato,
                c.vadic_contrato,c.vfin_contrato,c.veje_contrato,c.fsusp_contrato,c.frein_contrato,
                c.prorg_contrato,c.frecb_contrato
            FROM
                contratos as c
            WHERE
                c.estad_contrato = 'Ejecucion'
            ORDER BY c.num_contrato ASC";
        } else {
            $sql = "SELECT c.num_contrato,c.id_contrato,c.obj_contrato,c.porav_contrato,c.fini_contrato,
                c.ffin_contrato,c.estad_contrato,
                c.vadic_contrato,c.vfin_contrato,c.veje_contrato,c.fsusp_contrato,c.frein_contrato,
                c.prorg_contrato,c.frecb_contrato
            FROM
                contratos as c
            WHERE
                c.idproy_contrato = '" . $cod_proyect . "' AND c.estad_contrato = 'Ejecucion'
            ORDER BY c.num_contrato ASC";
        }
    }
    $Op = "No_Existe";
    $consulta = mysqli_query($link, $sql);
    while ($resp = $consulta->fetch_assoc()) {
        $Op = "Existe";
        $campo["id_contrato"][$k] = $resp['id_contrato'];
        $campo["num_contrato"][$k] = $resp['num_contrato'];
        $campo["obj_contrato"][$k] = stripslashes(utf8_decode(cambiarLetra($resp['obj_contrato'])));
        $campo["fini_contrato"][$k] = $resp['fini_contrato'];
        $campo["ffin_contrato"][$k] = $resp['ffin_contrato'];
        $campo["porav_contrato"][$k] = stripslashes(utf8_decode($resp['porav_contrato']));
        $campo["estad_contrato"][$k] = $resp['estad_contrato'];

        $campo["vadic_contrato"][$k] = "$ " . number_format($resp['vadic_contrato'], 2);
        $campo["vfin_contrato"][$k] = "$ " . number_format($resp['vfin_contrato'], 2);
        $campo["veje_contrato"][$k] = "$ " . number_format($resp['veje_contrato'], 2);
        $campo["fsusp_contrato"][$k] = $resp['fsusp_contrato'];
        $campo["frein_contrato"][$k] = $resp['frein_contrato'];
        $campo["prorg_contrato"][$k] = $resp['prorg_contrato'];
        $campo["frecb_contrato"][$k] = $resp['frecb_contrato'];
        $k++;
    }
    $resultado["contrato"] = $campo;
    $resultado["Salida"] = 1;
    $resultado["Op"] = $Op;
    $resultado["tam"] = $k - 1;
    mysqli_close($link);
    echo json_encode($resultado);
}
if ($_REQUEST["OPCION"] == "CONSULTARPROYECTOS") {
    $campo = array();
    $resultado = array();
    $k = 1;
    $sql = "SELECT * FROM proyectos WHERE estado='ACTIVO' ";
    $Op = "No_Existe";
    $consulta = mysqli_query($link, $sql);

    while ($resp = $consulta->fetch_assoc()) {
        $Op = "Existe";
        $campo["id_proyect"][$k] = $resp['id_proyect'];
        $campo["cod_proyect"][$k] = $resp['cod_proyect'];
        $campo["nombre_proyect"][$k] = $resp['nombre_proyect'];
        // $campo["nombre_proyect"][$k] = stripslashes(utf8_decode(cambiarLetra($resp['nombre_proyect'])));
        $k++;
    }
    $resultado["proyectos"] = $campo;
    $resultado["Salida"] = 1;
    $resultado["Op"] = $Op;
    $resultado["tam"] = $k - 1;
    mysqli_close($link);
    echo json_encode($resultado);
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
