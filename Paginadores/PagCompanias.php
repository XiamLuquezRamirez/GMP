<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
$link2 = conectar();
mysql_set_charset('utf8');
$cad = "";
$cad2 = "";
$consulta = "";
$contador = 0;

$usu = $_SESSION['ses_user'];
$com = $_SESSION['ses_complog'];

$i = 0;
$j = 0;

$regmos = $_POST["nreg"];

$pag = $_POST["pag"];
$op = $_POST["pag"];
$buscar[100];

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}

$cad = "<table class=\"table table-striped table-bordered table-hover dataTable no-footer\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Identificación"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Nombre"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Login/Sigla"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Acción"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT * FROM ".$_SESSION['ses_BDBase'].".companias WHERE  ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  companias_nit, "
                . "  ' ', "
                . "  companias_descripcion, "
                . "  ' ', "
                . "  companias_login "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    if ($usu == "root") {
        $consulta .= " order by companias_descripcion ASC LIMIT " . $regemp . "," . $regmos;
    } else {
        $consulta .= "AND companias_login='" . $com . "' order by companias_descripcion ASC LIMIT " . $regemp . "," . $regmos;
    }
} else {

    if ($usu == "root") {
        $consulta = "SELECT * FROM ".$_SESSION['ses_BDBase'].".companias "
                . " order by companias_descripcion ASC LIMIT " . $regemp . "," . $regmos;
    } else {
        $consulta = "SELECT * FROM ".$_SESSION['ses_BDBase'].".companias WHERE companias_login='" . $com . "' "
                . " order by companias_descripcion ASC LIMIT " . $regemp . "," . $regmos;
    }
}


$resultado = mysql_query($consulta, $link);
if (mysql_num_rows($resultado) > 0) {

    while ($fila = mysql_fetch_array($resultado)) {
        $cod = "";

        $cod = $fila["companias_id"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["companias_nit"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["companias_descripcion"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["companias_login"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
        if ($_SESSION['GesParMCom'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editComp('" . $cod . "')\"  class=\"btn default btn-xs purple\">"
                    . "<i class=\"fa fa-edit\"></i> Editar</a>"
                    . "</td>";
        }
        $cad .= "<td>"
                . "<a   onclick=\"$.verComp('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Ver</a>"
                . "</td>";
        if ($_SESSION['GesParECom'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletComp('" . $cod . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Eliminar</a>"
                    . "</td>";
        }
        $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM ".$_SESSION['ses_BDBase'].".companias";
$resultado2 = mysql_query($consulta, $link2);
if (mysql_num_rows($resultado2) > 0) {

    while ($fila = mysql_fetch_array($resultado2)) {
        $contador = intval($fila["conta"]);
    }
}
$cad .= "</tbody>"
        . "</table>";

$pagant = $pagact - 1;
$pagsig = $pagact + 1;
$div = $contador / $regmos;
$mod = $contador % $regmos;
if ($mod > 0) {
    $div++;
}
if ($contador > $regmos) {
    $cad2 = "<br />"
            . "<table cellspacing=5 style=\"text-align: right;\">"
            . "<tr >";
    $cad2 = $cad2 . "<td><input type='hidden' value='" . $j . "' name='contador' id='contador' />";
    $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    if ($pagact > 1) {
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
    }
    $cbp = $cbp . "<td>Pagina No: <select id='selectpag' class='bs-select form-control small' onchange=\"$.combopag(this.value,'../paginador_centros')\">";
    for ($j = 1; $j <= $div; $j++) {
        if ($j == $pagact) {
            $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
        } else {
            $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
        }
    }
    $cad2 = $cad2 . "</select></td>";
    if ($pagact < $div) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
    }
    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . div . "' />"
            . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    $cad2 = $cad2 . "</tr>"
            . "</table>";
}

$salida = new stdClass();
$salida->cad = $cad;
$salida->cad2 = $cad2;
$salida->cbp = $cbp;

echo json_encode($salida);

mysql_close();
?>