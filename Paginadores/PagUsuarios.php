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
$flag = "n";
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
        . "<i class=\"fa fa-angle-right\"></i> Identificación"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Nombre"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Usuario"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Nivel Usuario"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Acción"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);
    $flag = "s";
    $consulta = "SELECT * FROM ".$_SESSION['ses_BDBase'].".usuarios WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  cue_nombres, "
                . "  ' ', "
                . "  cue_alias, "
                . "  ' ', "
                . "  niv_codigo "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND cue_estado='ACTIVO' order by cue_nombres ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT * FROM ".$_SESSION['ses_BDBase'].".usuarios WHERE cue_estado='ACTIVO' order by cue_nombres ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["cue_alias"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["cue_inden"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["cue_nombres"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["cue_alias"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["niv_codigo"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                  . "<table>"
                . "<tr>";
        if ($_SESSION['GesUsuMUs'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editUsu('" . $cod . "')\"  class=\"btn default btn-xs purple\">"
                    . "<i class=\"fa fa-edit\"></i> Editar</a>"
                    . "</td>";
        }
        $cad .= "<td>"
                . "<a   onclick=\"$.verUsu('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Ver</a>"
                . "</td>";

        if ($_SESSION['GesUsuEUs'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletUsu('" . $cod . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Eliminar</a>"
                    . "</td>";
        }
        $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
    }
}

if ($flag == "n") {
    $consulta = "SELECT count(*) as conta FROM ".$_SESSION['ses_BDBase'].".usuarios WHERE cue_estado='ACTIVO' ";
    $resultado2 = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado2) > 0) {

        while ($fila = mysqli_fetch_array($resultado2)) {
            $contador = intval($fila["conta"]);
        }
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
        $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" disabled  style='padding: 4px 4px 4px 4px' /></td>";
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

    $cbp = $cbp . "</select></td>";
    if ($pagact < $div-1) {
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