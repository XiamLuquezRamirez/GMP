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
    . " #"
    . "</th>"
    . "<th>"
    . " Nombre"
    . "</th>"
    . "<th>"
    . " Descripción"
    . "</th>"
    . "<th>"
    . " Acci&oacute;n"
    . "</th>"
    . "</tr>"
    . "</thead>"
    . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);
    $consulta = "SELECT * FROM  fuentes  WHERE ";
    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
            . "  nombre, "
            . "  ' ', "
            . "  descripcion "
            . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND estado='ACTIVO' order by id DESC LIMIT " . $regemp . "," . $regmos;
} else {
    $consulta = "SELECT * FROM fuentes WHERE estado='ACTIVO' order by id DESC  LIMIT " . $regemp . "," . $regmos;
}
//echo $consulta;
$resultado = mysqli_query($link, $consulta);
$contador = 0;
$k = 1;
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $cod = $fila["id"];
        $cad .= "<tr
                    data-id='" . $fila["id"] . "'
                    data-nombre='" . $fila["nombre"] . "'
                    data-descripcion='" . $fila["descripcion"] . "'
              >"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
            . $k . " "
            . "</td>"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
            . $fila["nombre"] . " "
            . "</td>"
            . "<td class=\"highlight\" style='vertical-align: middle; font-size: x-small;
            line-height: 1.3em;'>"
            . $fila["descripcion"] . ""
            . "</td>"
            . "<td class=\"highlight\"><div class='opciones'>";
        if ($_SESSION['GesParMSec'] == "s") {
            $cad .= "<a class=\"btn default btn-xs purple btnEditar\">" .
                "<i class='fa fa-edit'></i> Editar "
                . "</a>";
        }
        $cad .= "<a class='btn default btn-xs blue btnVer'>" .
            "<i class='fa fa-search'></i> Ver "
            . "</a>";
        if ($_SESSION['GesParESec'] == "s") {
            $cad .= "<a  class='btn default btn-xs red btnEliminar'>" .
                "<i class='fa fa-trash-o'></i> Eliminar "
                . "</a>";
        }
        $cad .= "</div></td>"
            . "</tr>";
        $k++;
    }
}

$consulta = "SELECT count(*) as conta FROM fuentes WHERE estado='ACTIVO' ";
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
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
    }

    $cbp = $cbp . "<td>Pagina No: <select id='selectpag' class='bs-select form-control small clasesCombos' onchange=\"$.combopag(this.value,'../paginador_centros')\">";
    for ($j = 1; $j <= $div; $j++) {
        if ($j == $pagact) {
            $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
        } else {
            $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
        }
    }

    $cbp = $cbp . "</select></td>";
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

echo json_encode($salida);

mysqli_close($link);
