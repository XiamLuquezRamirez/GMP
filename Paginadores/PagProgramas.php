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
}else{
    $pag=null;
};
$buscar[]=100;

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}

$cad = "<table class=\"table table-striped table-bordered table-hover dataTable no-footer\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Código"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Descripción"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> ". $_SESSION['nivel1']
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> ". $_SESSION['nivel2']
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
  prog.ID idprog,
  prog.CODIGO codprog,
  prog.NOMBRE nomprog,
  ej.NOMBRE nomej,
  estr.NOMBRE nomestr
FROM
  programas prog
  INNER JOIN ejes ej
    ON prog.ID_EJE = ej.ID
  INNER JOIN componente estr
    ON prog.ID_COMP = estr.ID WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  prog.CODIGO, "
                . "  ' ', "
                . "  prog.NOMBRE, "
                . "  ' ', "
                . "  estr.NOMBRE, "
                . "  ' ', "
                . "  ej.NOMBRE  "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND prog.ESTADO='ACTIVO' order by  estr.NOMBRE ASC LIMIT " . $regemp . "," . $regmos;
} else {
    $consulta = "SELECT
  prog.ID idprog,
    prog.CODIGO codprog,
  prog.NOMBRE nomprog,
  ej.NOMBRE nomej,
  estr.NOMBRE nomestr
FROM
  programas prog
  INNER JOIN ejes ej
    ON prog.ID_EJE = ej.ID
  INNER JOIN componente estr
    ON prog.ID_COMP = estr.ID
    WHERE prog.ESTADO='ACTIVO' order by estr.NOMBRE ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {

        $cod = $fila["idprog"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["codprog"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomprog"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomej"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomestr"] . ""
                . "</td>"
                . "<td>"
                . "<table>"
                . "<tr>";
        if ($_SESSION['GesPlaMPr'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editProg('" . $cod . "')\" class='btn default btn-xs purple'>" .
                    "<i class='fa fa-edit'></i> Editar "
                    . "</a>"
                    . "</td>";
        }

        $cad .= "<td>"
                . "<a onclick=\"$.VerProg('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>";

        if ($_SESSION['GesPlaEPr'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletProg('" . $cod . "')\" class='btn default btn-xs red'>" .
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

$consulta = "SELECT count(*) as conta  FROM programas prog
  LEFT JOIN ejes ej
    ON prog.ID_EJE = ej.ID
  LEFT JOIN componente estr
    ON prog.ID_COMP = estr.ID
    WHERE prog.ESTADO='ACTIVO'";

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
    if ($pagact < $div-1) {
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