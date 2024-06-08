<?php

session_start();

include "../Conectar.php";

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
$cad = "";
$cad2 = "";
$cbp = "";
$consulta = "";

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

$cad = "<table class=\"table table-bordered table-striped table-condensed table table-hover flip-content\" role=\"grid\" >"
    . "<thead>"
    . "<tr>"
    . "<th>"
    . "<i ></i> <b>Número</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Objeto del contrato</b>"
    . "</th>"
    . "<th style='width: 100px;'>"
    . "<i ></i> <b>V. Contrato</b>"
    . "</th>"
    . "<th style='width: 100px;'>"
    . "<i ></i> <b>V. Ejecutado</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Contratista</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Proyecto</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Estado</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Acci&oacute;n</b>"
    . "</th>"
    . "</tr>"
    . "</thead>"
    . "<tbody>";

$busq = $_POST["bus"];
$Proy = $_POST["Pro"];
if($Proy==" "){
 $Proy="";
}

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
  desproy_contrato
FROM
  contratos  WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
            . " num_contrato, "
            . "  ' ', "
            . " obj_contrato,"
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
    $consulta .= " AND idproy_contrato LIKE '%".$Proy."' AND id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) AND estcont_contra <> 'Eliminado'
ORDER BY id_contrato DESC  LIMIT " . $regemp . "," . $regmos;

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
  desproy_contrato
FROM
  contratos
WHERE idproy_contrato LIKE '%".$Proy."' AND id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) AND estcont_contra <> 'Eliminado'
ORDER BY id_contrato DESC  LIMIT " . $regemp . "," . $regmos;

}

$resultado = mysqli_query($link, $consulta);
$contador = 0;
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["id_contrato"];
        $proye = explode(' ',$fila["desproy_contrato"]);

        

        $cad .= "<tr>"
        . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
        line-height: 1.3em;'>"
        . $fila["num_contrato"] . " "
        . "</td>"
        . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
        line-height: 1.3em;'>"
        . $fila["obj_contrato"] . "" . ""
        . "</td>"
   
        . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
        line-height: 1.3em;'>"
        . "$ " . number_format($fila["vcontr_contrato"], 2, ",", ".") . ""
        . "</td>"
        . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
        line-height: 1.3em;'>"
        . "$ " . number_format($fila["veje_contrato"], 2, ",", ".") . ""
            . "</td>"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
            . $fila["descontrati_contrato"] . ""
            . "</td>"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
            . $proye[0]. ""
            . "</td>"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
            . $fila["estad_contrato"] . ""
            . "</td>"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
             ."<div class='opciones'>"
             . "<a href='javascript:;' class='btn default btn-xs yellow btnPolizas' data-id='" . $fila["num_contrato"] . "'>" .
             "<i class='fa fa-handshake-o'></i> Polizas"
             . "</a>";
             if ($_SESSION['GesProyMCo'] == "s") {
                if ($fila["estcont_contra"] == "Por Verificar") {
                    $cad .= "<a  onclick=\"$.editContratos('" . $cod . "')\" class='btn default btn-xs green'>" .
                        "<i class='fa fa-edit'></i> Editar Cotrato"
                        . "</a>";
                } else if ($fila["estcont_contra"] == "Verificado") {
                    $cad .= "<a  onclick=\"$.AddAvaces('" . $cod . "')\" class='btn default btn-xs purple'>" .
                        "<i class='fa fa-edit'></i> Actualizar Avances"
                        . "</a>";
                }
            }
            $cad .= "<a onclick=\"$.VerContrat('" . $fila["num_contrato"] .'/'.$cod. "')\" class='btn default btn-xs blue'>" .
                    "<i class='fa fa-search'></i> Ver Historial "
                    . "</a>";
                    if ($_SESSION['GesProyECo'] == "s") {
                        $cad .= "<a onclick=\"$.deletContr('" . $fila["num_contrato"] . "')\" class='btn default btn-xs red'>" .
                            "<i class='fa fa-trash-o'></i> Eliminar "
                            . "</a>";
                    }
            $cad .= "</div>"
            . "</td>"
            . "</tr>";
    }
}

$consulta = "SELECT count(*) conta FROM contratos WHERE idproy_contrato LIKE '%".$Proy."'"
        . " AND id_contrato IN (SELECT MAX(id_contrato) FROM contratos GROUP BY num_contrato) AND estcont_contra <> 'Eliminado'";
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

    if ($pagact <= $div) {
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
