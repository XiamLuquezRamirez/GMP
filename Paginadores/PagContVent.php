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
$PorCO = "";
$PorCC = "";
$PorCE = "";
$consulta = "";
$contador = 0;

$i = 0;
$j = 0;


$consulta = "select * from para_calf_contratista";
$resultado = mysqli_query($link, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $PorCO = $fila["PorCO"];
        $PorCC = $fila["PorCC"];
        $PorCE = $fila["PorCE"];
    }
}

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

$cad = "<table class=\"table table-striped table-bordered  table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i></i> <b>Código</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Objeto</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Tipologia</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Contratista</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Acción</b>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT
  id_contrato,
  destipolg_contrato,
  num_contrato,
  obj_contrato,
  vcontr_contrato,
  veje_contrato,
  descontrati_contrato,
  estad_contrato,
  estcont_contra,
  fini_contrato,
  ffin_contrato,
  fcrea_contrato
FROM
  contratos  WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . " num_contrato, "
                . "  ' ', "
                . " obj_contrato"
                . "  ' ', "
                . " destipolg_contrato, "
                . "  ' ', "
                . " estad_contrato, "
                . "  ' ', "
                . " descontrati_contrato"
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND WHERE id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) AND estad_contrato='Terminado'
ORDER BY id_contrato ASC  LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT
  id_contrato,
  destipolg_contrato,
  num_contrato,
  obj_contrato,
  vcontr_contrato,
  veje_contrato,
  descontrati_contrato,
  estad_contrato,
  estcont_contra,
  fini_contrato,
  ffin_contrato,
  fcrea_contrato

FROM
  contratos
WHERE id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) AND estad_contrato='Terminado'
ORDER BY id_contrato asc  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link, $consulta);
$contador = 0;
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["id_contrato"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["num_contrato"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["obj_contrato"] . "" . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["destipolg_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["descontrati_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
        $cad .= "<td>"
                . "<a  onclick=\"$.SelContra('" . $cod . '//' . $fila["num_contrato"] . "//" . $fila["obj_contrato"] . "//" . $fila["destipolg_contrato"] . "//" . $fila["descontrati_contrato"] . "//" . $fila["fini_contrato"] . "//" . $fila["ffin_contrato"] . "//" . $fila["fcrea_contrato"] ."//" . $PorCO ."//" . $PorCC ."//" . $PorCE . "')\" class='btn default btn-xs purple'>" .
                "<i class='fa fa-check'></i> Sele.. "
                . "</a>"
                . "</td>"
                . "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM contratos WHERE id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) AND estad_contrato='Terminado'";
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
    if ($pagact < $div) {
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

echo json_encode($salida);

mysqli_close($link);
?>