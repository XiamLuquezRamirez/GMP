<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
$link2 = conectar();

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
        . "<i></i> Id"
        . "</th>"
        . "<th>"
        . "<i></i> Indicador"
        . "</th>"
        . "<th>"
        . "<i></i> Proyecto"
        . "</th>"
        . "<th>"
        . "<i></i> Estado"
        . "</th>"
        . "<th>"
        . "<i></i> Acci&oacute;n"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT
  eva.id ideva, eva.id_indicador idindi, ind.nomb_indi nombind,proy.nombre_proyect nomproy, eva.estado esta,
  eva.id_indicador
FROM
  evaluacionindicador eva
  LEFT JOIN indicadores ind
  ON eva.id_indicador = ind.id_indi
  LEFT JOIN mediindicador med
  ON eva.id_med=med.id
  LEFT JOIN  proyectos proy
  ON med.proy_ori=proy.id_proyect
  WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "   ind.nomb_indi , "
                . "  ' ', "
                . "  ban.nombre_proyect "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " order by ban.nombre_proyect ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT
  eva.id ideva, eva.id_indicador idindi, ind.nomb_indi nombind,proy.nombre_proyect nomproy, eva.estado esta,
  eva.id_indicador
FROM
  evaluacionindicador eva
  LEFT JOIN indicadores ind
  ON eva.id_indicador = ind.id_indi
  LEFT JOIN mediindicador med
  ON eva.id_med=med.id
  LEFT JOIN  proyectos proy
  ON med.proy_ori=proy.id_proyect
  ORDER BY proy.nombre_proyect ASC LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link, $consulta);
$respo = "";
$cont=1;

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {


        $cod = $fila["ideva"];

        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $cont . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nombind"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomproy"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["esta"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>"
                . "<td>";

        $cad .= "<a onclick=\"$.EvalIndiProy('" . $cod . "//" . $fila["esta"]. "//" . $fila["idindi"] . "')\" title='Revidar Plan de Mejora' class='btn default btn-xs blue'>"
                . "<i class='fa fa-check'></i> Revisar Plan Mejora ";


        $cad .= "</a>"
                . "</td>"
                . "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
        $cont++;
    }
}




$consulta = "SELECT
   count(*) as conta
FROM
   evaluacionindicador eva
  LEFT JOIN indicadores ind
  ON eva.id_indicador = ind.id_indi
  LEFT JOIN mediindicador med
  ON eva.id_med=med.id
  LEFT JOIN  proyectos proy
  ON med.proy_ori=proy.id_proyect";

$resultado2 = mysqli_query($link2, $consulta);
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
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\" disabled  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
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