<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link,'utf8');
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
$buscar[]=100;

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}

$cad = "<table class=\"table table-striped table-bordered table-hover table-advance table-hover\">"
        . "<thead>
        <tr>
            <th rowspan='2' style='vertical-align: middle; text-align:center;'>
                Num
            </th>
            <th colspan='2' style='vertical-align: middle; text-align:center;'>
                Ejes
            </th>
            <th colspan='2' style='vertical-align: middle; text-align:center;'>
                Programas
            </th>
        </tr>
        <tr>
            <th style='vertical-align: middle; text-align:center;'>
                Codigo
            </th>
            <th style='vertical-align: middle; text-align:center;'>
                Nombre
            </th>
            <th style='vertical-align: middle; text-align:center;'>
                Codigo
            </th>
            <th style='vertical-align: middle; text-align:center;'>
                Nombre
            </th>
        </tr>
    </thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT
  ej.ID idej,
  ej.CODIGO codej,
  ej.NOMBRE nomej,
  estr.ID idestr,
  estr.CODIGO codest,
  estr.NOMBRE nomestr
FROM
  ejes ej
  LEFT JOIN componente estr
    ON ej.ID = estr.ID_EJE WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  ej.CODIGO, "
                . "  ' ', "
                . "  ej.NOMBRE, "
                . "  ' ', "
                . "  estr.CODIGO, "
                . "  ' ', "
                . "  estr.NOMBRE "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND ej.ESTADO='ACTIVO' AND estr.ESTADO='ACTIVO'  order by ej.NOMBRE ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT
  ej.ID idej,
  ej.CODIGO codej,
  ej.NOMBRE nomej,
  estr.ID idestr,
  estr.CODIGO codest,
  estr.NOMBRE nomestr
FROM
  ejes ej
  LEFT JOIN componente estr
    ON ej.ID = estr.ID_EJE
    WHERE ej.ESTADO='ACTIVO' AND estr.ESTADO='ACTIVO' order by ej.NOMBRE ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link,$consulta);
$cont = 0;
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $cont++;

        $cad .= "<tr style='cursor: pointer' onclick=\"$.SelEjes('" . $fila["idej"] . "//" . $fila["codej"] . "//" . $fila["nomej"] . "//" . $fila["idestr"] . "//" . $fila["codest"] . "//" . $fila["nomestr"] . "')\">"
                . "<td class=\"highlight\">"
                . $cont . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["codej"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomej"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["codest"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomestr"] . ""
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM ejes ej
  LEFT JOIN componente estr
    ON ej.ID = estr.ID_EJE
    WHERE ej.ESTADO='ACTIVO' AND estr.ESTADO='ACTIVO' ";
$resultado2 = mysqli_query($link,$consulta);
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
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginadorVent('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginadorVent('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginadorVent('1','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginadorVent('" . $pagant . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
    }

    $cbp = $cbp . "<td>Pagina No: <select id='selectpagVent' class='bs-select form-control small' onchange=\"$.combopagVent(this.value,'../paginador_centros')\">";
    for ($j = 1; $j <= $div; $j++) {
        if ($j == $pagact) {
            $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
        } else {
            $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
        }
    }

    $cbp = $cbp . "</select></td>";
    if ($pagact < $div-1) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginadorVent('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginadorVent('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginadorVent('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginadorVent('" . $div . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
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