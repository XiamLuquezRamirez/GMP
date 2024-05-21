<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
$cad = "";
$cad2 = "";
$cbp = "";
$consulta = "";
$contador = 0;

$i = 0;
$j = 0;



$regmos = $_POST["nreg"];

if (isset($_POST["pag"])) {
    $pag = $_POST["pag"];
} else {
    $pag = null;
}
$buscar[] = 100;

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}

$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i></i> <b>Código</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Descripción</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Meta</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>SubPrograma</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Acci&oacute;n</b>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["eje"];

if ($busq != "") {
    $consulta = "SELECT id_meta id, cod_meta cod, desc_meta des, meta meta,des_prog_metas prg  FROM metas WHERE"
            . " ideje_metas LIKE '" . trim($_POST["eje"]) . "%' "
            . " AND idcomp_metas LIKE '" . trim($_POST["comp"]) . "%' "
            . " AND idprog_metas LIKE '" . trim($_POST["prog"]) . "%' ";

    $consulta .= "  AND estado_metas='ACTIVO' order by des_prog_metas ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT id_meta id, cod_meta cod, desc_meta des, meta meta,des_prog_metas prg  FROM metas WHERE estado_metas='ACTIVO' order by des_prog_metas ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link, $consulta);
$contador = 0;
$respo = "";

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["id"];

        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["cod"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["des"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["meta"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["prg"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>"
                . "<td>"
                . "<a  onclick=\"$.SelMeta('" . $cod . '//' . $fila["des"] . "//" . $fila["cod"] . "//" . $fila["meta"] . "')\" class='btn default btn-xs purple'>" .
                "<i class='fa fa-check'></i> Sele.. "
                . "</a>"
                . "</td>"
                . "<td>"
                . "<a onclick=\"$.VerMeta('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>"
                . "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM metas WHERE estado_metas='ACTIVO' ";
$resultado2 = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado2) > 0) {

    while ($fila = mysqli_fetch_array($resultado2)) {
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

    if ($pagact > 1) {
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginadorMet('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginadorMet('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginadorMet('1','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginadorMet('" . $pagant . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
    }

    $cbp = $cbp . "<td>Pagina No: <select id='selectpagMet' class='bs-select form-control small' onchange=\"$.combopagMet(this.value,'../paginador_centros')\">";
    for ($j = 1; $j <= $div; $j++) {
        if ($j == $pagact) {
            $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
        } else {
            $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
        }
    }

    $cad2 = $cad2 . "</select></td>";
    if ($pagact < $div - 1) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginadorMet('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginadorMet('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginadorMet('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginadorMet('" . $div . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    }

    $cad2 = $cad2 . "</tr>"
            . "</table>";
}

$salida = new stdClass();
$salida->cad = $cad;
$salida->cad2 = $cad2;
$salida->cbp = $cbp;

echo json_encode($salida);

mysqli_close($link);
?>