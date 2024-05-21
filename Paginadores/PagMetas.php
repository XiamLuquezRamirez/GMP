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

$cad = "<table class=\"table table-bordered table-striped table-hover table-condensed flip-content\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i></i> <b>Código</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Descripción</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Base</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Meta</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Programa</b>"
        . "</th>"
        . "<th>"
        . "<i></i> <b>Responsable</b>"
        . "</th>"
        . "<th>"
        . "<i></i> <b>Acci&oacute;n</b>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT id_meta id, cod_meta cod, desc_meta des, base_meta base,
        respo_metas resp, des_prog_metas prg, meta met  FROM metas
   WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  cod_meta, "
                . "  ' ', "
                . "  desc_meta, "
                . "  ' ', "
                . "  des_prog_metas, "
                . "  ' ', "
                . "  des_comp_metas, "
                . "  ' ', "
                . "  des_eje_metas "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND estado_metas='ACTIVO' order by des_prog_metas ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT id_meta id, cod_meta cod, desc_meta des, base_meta base,
        respo_metas resp, des_prog_metas prg, meta met  FROM metas
   WHERE estado_metas='ACTIVO' order by des_prog_metas ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link, $consulta);

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $resp = "";
        $consulta = "SELECT * FROM dependencias WHERE iddependencias IN (" . $fila["resp"] . ")";
        //  echo $consulta2;
        $resultado2 = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado2) > 0) {
            while ($fila2 = mysqli_fetch_array($resultado2)) {
                $resp = $resp . $fila2["des_dependencia"] . ', ';
            }
        }
        $cod = $fila["id"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["cod"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["des"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["base"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["met"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["prg"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . trim($resp, ', ') . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
        if ($_SESSION['GesPlaMMe'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editMet('" . $cod . "')\" class='btn default btn-xs purple'>" .
                    "<i class='fa fa-edit'></i> Editar "
                    . "</a>"
                    . "</td>";
        }
        $cad .= "<td>"
                . "<a onclick=\"$.VerMet('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>";
        if ($_SESSION['GesPlaEMe'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletMet('" . $cod . "')\" class='btn default btn-xs red'>" .
                    "<i class='fa fa-trash-o'></i> Eliminar "
                    . "</a>"
                    . "</td>";
        }
        $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM metas WHERE estado_metas='ACTIVO'";
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

$blopri = "0";
$bloseg = "0";

if ($contador > $regmos) {
    $cad2 = "<br />"
            . "<table cellspacing=5 style=\"text-align: right;\">"
            . "<tr >";
    $cad2 = $cad2 . "<td><input type='hidden' value='" . $j . "' name='contador' id='contador' />";

    if ($pagact > 1) {
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
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
    if ($pagact < $div - 1) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    }

    $cad2 = $cad2 . "</tr>"
                  . "</table>";
}


$salida = new stdClass();
$salida->cad = $cad;
$salida->cad2 = $cad2;
$salida->cbp = $cbp;
$salida->Cont = $contador;

echo json_encode($salida);

mysqli_close($link);
?>