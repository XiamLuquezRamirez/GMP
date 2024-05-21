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
$flag = "n";

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

$PorCO = 0;
$PorCE = 0;
$PorCC = 0;

$consulta = "select * from para_calf_contratista";
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $PorCO = $fila["PorCO"] / 100;
        $PorCE = $fila["PorCE"] / 100;
        $PorCC = $fila["PorCC"] / 100;
    }
}


$cad = "<table class=\"table table-bordered table-striped table-hover table-condensed flip-content\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i ></i> Número"
        . "</th>"
        . "<th>"
        . "<i ></i> Objeto"
        . "</th>"
        . "<th>"
        . "<i ></i> Contratista"
        . "</th>"
        . "<th>"
        . "<i ></i> Clase Contrato"
        . "</th>"
        . "<th>"
        . "<i ></i> Evaluación"
        . "</th>"
        . "<th>"
        . "<i ></i> Calificación"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);
    $flag = "s";
    $consulta = "SELECT * FROM  eval_contratista  WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  ncont_evaluacion, "
                . "  ' ', "
                . "  objcont_evaluacion, "
                . "  ' ', "
                . "  nitcont_evaluacion, "
                . "  ' ', "
                . "  nomcont_evaluacion, "
                . "  ' ', "
                . "  clacont_evaluacion "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " ADN estado_evaluacion='ACTIVO'  AND id_evaluacion IN (SELECT MAX(id_evaluacion) FROM eval_contratista WHERE estado_evaluacion='ACTIVO') order by objcont_evaluacion ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT * FROM eval_contratista WHERE estado_evaluacion='ACTIVO' AND id_evaluacion IN (SELECT MAX(id_evaluacion) FROM eval_contratista WHERE estado_evaluacion='ACTIVO' ) order by objcont_evaluacion ASC  LIMIT " . $regemp . "," . $regmos;
}

$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
            
        
        $resul = $fila["text_PsTotal"] + $fila["text_SaTotal"] + $fila["text_CaTotal"]+ $fila["text_CcTotal"]+ $fila["text_CoTotal"];
        $por = ($resul / 5) * 100;
        $cod = $fila["id_evaluacion"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["ncont_evaluacion"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["objcont_evaluacion"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nitcont_evaluacion"] . " - " . $fila["nomcont_evaluacion"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["clacont_evaluacion"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $resul . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "  <div class='containerdiv'>"
                . "<div>"
                . " <img src='../img/stars_blank.png' alt='img'>"
                . "</div>"
                . "<div class='cornerimage' style='width:" . $por . "%;'>"
                . " <img src='../img/stars_full.png' alt=''>"
                . "  </div>"
                . "<div>"
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
        if ($_SESSION['GesEvaMEv'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editEval('" . $cod . "')\"  class=\"btn default btn-xs purple\">" .
                    "<i class='fa fa-edit'></i> Editar "
                    . "</a>"
                    . "</td>";
        }
        $cad .= "<td>"
                . "<a onclick=\"$.VerEval('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>";
        if ($_SESSION['GesEvaEEv'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletEval('" . $cod . "')\" class='btn default btn-xs red'>" .
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

$cad .= "</tbody>"
        . "</table>";

if ($flag == "n") {
    $consulta = "SELECT count(*) as conta FROM eval_contratista WHERE estado_evaluacion='ACTIVO'";
    $resultado2 = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado2) > 0) {

        while ($fila = mysqli_fetch_array($resultado2)) {
            $contador = intval($fila["conta"]);
        }
    }
}

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
    if ($pagact < $div - 1) {
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