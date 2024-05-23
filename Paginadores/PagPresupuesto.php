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

$buscar[] = 100;

$cad = "<table class=\"table table-bordered table-striped table-hover table-condensed flip-content\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fuente de financiación"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Periodo"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Valor"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";




if (isset($_POST["bus"]) && $_POST["bus"] !== null && $_POST["bus"] !== "") {
    $busq = str_replace("+", " ", $_POST["bus"]);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT pre.id, fuent.nombre, pre.valor, pre.periodo_ini FROM
   presupuesto_total pre
  LEFT JOIN fuentes fuent ON pre.fuente = fuent.id
     WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT(fuent.nombre) LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND pre.estado='ACTIVO' order by pre.periodo_ini DESC";
} else {
    $consulta = "SELECT pre.id, fuent.nombre, pre.valor, pre.periodo_ini FROM
    presupuesto_total pre
   LEFT JOIN fuentes fuent ON pre.fuente = fuent.id
  WHERE pre.estado='ACTIVO' order by pre.periodo_ini DESC";
}

//echo $consulta;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    $vtotal=0;

    while ($fila = mysqli_fetch_array($resultado)) {

        $cod = $fila["id"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["nombre"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["periodo_ini"] . " "
                . "</td>"
                . "<td class=\"highlight\"> $ "
                . number_format($fila["valor"], 2, ",", "."). ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
        if ($_SESSION['GesParMRes'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editPresupuesto('" . $cod . "')\"  class=\"btn default btn-xs purple\">" .
                    "<i class='fa fa-edit'></i> Editar "
                    . "</a>"
                    . "</td>";
        }
        $cad .= "<td>"
                . "<a onclick=\"$.VerPresupuesto('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>";
        if ($_SESSION['GesParERes'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletPresupuesto('" . $cod . "')\" class='btn default btn-xs red'>" .
                    "<i class='fa fa-trash-o'></i> Eliminar "
                    . "</a>"
                    . "</td>";
        }
        $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";

                $vtotal+=$fila["valor"];
    }
}


$cad .= "</tbody> <tfoot>"
. "<tr>"
. "   <td colspan='2'>PRESUPUESTO TOTAL</td>"
. "   <td style='padding-left: initial;font-weight: bold;'>$ ".number_format($vtotal, 2, ",", ".")."</td>"
. "</tr>"
. "</tfoot>"
. "</table>";



$salida = new stdClass();
$salida->cad = $cad;

echo json_encode($salida);

mysqli_close($link);
?>