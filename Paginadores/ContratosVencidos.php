<?php

session_start();

include "../Conectar.php";

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
$cad = "";
$consulta = "";

$cad = "<table class=\"table table-bordered table-striped table-condensed table table-hover flip-content\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i ></i> <b>Numero</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Objeto</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Contratista</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Fecha Vencimiento</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Acci&oacute;n</b>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";



$consulta = "SELECT 
  id_contrato idcont,
  num_contrato ncont,
  obj_contrato obj,
  descontrati_contrato contratis,
  ffin_contrato ffin
FROM
  contratos 
WHERE estad_contrato = 'Ejecucion' 
  AND DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d') 
  AND id_contrato IN 
  (SELECT 
    MAX(id_contrato) 
  FROM
    contratos 
  GROUP BY num_contrato)";



$resultado = mysqli_query($link, $consulta);
$contador = 0;
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["idcont"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["ncont"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["obj"] . "" . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["contratis"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["ffin"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";

        $cad .= "<td>"
                . "<a  onclick=\"$.JustifAtraso('" . $cod . "')\"  class='btn default btn-xs yellow'>" .
                "<i class='fa fa-edit'></i> Justificar Atraso"
                . "</a>"
                . "</td>";

        $cad .= "<td>"
                . "<a onclick=\"$.VerContrat('" . $fila["ncont"] . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver Historial "
                . "</a>"
                . "</td>";


        $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
    }
}

$cad .= "</tbody>"
        . "</table>";


$salida = new stdClass();
$salida->cad = $cad;

echo json_encode($salida);

mysqli_close($link);
