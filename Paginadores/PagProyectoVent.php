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
$cbp = "";
$consulta = "";
$contador = 0;

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

$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>

        <tr>
            <th style='vertical-align: middle; text-align:center;'>
                #
            </th>
            <th style='vertical-align: middle; text-align:center;'>
                Codigo
            </th>
            <th style='vertical-align: middle; text-align:center;'>
                Descripcion
            </th>
            <th style='vertical-align: middle; text-align:center;'>
                Tipologia
            </th>
        </tr>
    </thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT banc.id_proyect id, banc.cod_proyect cod, banc.nom_proyect nom, tip.des_tipolo destip FROM banco_proyectos banc LEFT JOIN tipologia_proyecto tip ON banc.tipo_proyect=tip.id_tipolo WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  banc.cod_proyect, "
                . "  ' ', "
                . "  banc.nom_proyect, "
                . "  ' ', "
                . "  tip.des_tipolo "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND banc.estado='ACTIVO' order by banc.nom_proyect ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT banc.id_proyect id, banc.cod_proyect cod, banc.nom_proyect nom, tip.des_tipolo destip FROM banco_proyectos banc LEFT JOIN tipologia_proyecto tip ON banc.tipo_proyect=tip.id_tipolo WHERE  banc.estado='ACTIVO' order by banc.nom_proyect ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysql_query($consulta, $link);
$cont = 0;
if (mysql_num_rows($resultado) > 0) {

    while ($fila = mysql_fetch_array($resultado)) {
        $cont++;

        $cad .= "<tr style='cursor: pointer' onclick=\"$.SelProy('" . $fila["id"] . "//" . $fila["cod"] . "//" . $fila["nom"] . "')\">"
                . "<td class=\"highlight\">"
                . $cont . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["cod"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nom"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["destip"] . ""
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM banco_proyectos where estado='ACTIVO'";
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
    $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginadorVentProyectProyect('1','PagRubroVent.php');\" style='padding: 4px 4px 4px 4px' /></td>";
    if ($pagact > 1) {
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginadorVentProyect('" . $pagant . "','PagRubroVent.php');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginadorVentProyect('" . $pagant . "','PagRubroVent.php');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
    }

    $cbp = $cbp . "<td>Pagina No: <select id='selectpagVent' class='bs-select form-control small' onchange=\"$.combopagVentProyect(this.value,'PagRubroVent.php')\">";
    for ($j = 1; $j <= $div; $j++) {
        if ($j == $pagact) {
            $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
        } else {
            $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
        }
    }

    $cad2 = $cad2 . "</select></td>";
    if ($pagact < $div) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginadorVentProyect('" . $pagsig . "','PagRubroVent.php');\" style='padding: 4px 4px 4px 4px' />";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginadorVentProyect('" . $pagsig . "','PagRubroVent.php');\" disabled style='padding: 4px 4px 4px 4px' />";
    }
    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginadorVentProyect('" . $div . "','PagRubroVent.php');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . div . "' />"
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