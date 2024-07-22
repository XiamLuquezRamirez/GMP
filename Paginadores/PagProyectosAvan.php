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
        . "<i ></i> <b>Código</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Nombre</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Secretaria</b>"
        . "</th>"
        . "<th>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT proy.cod_proyect,proy.id_proyect,proy.nombre_proyect,proy.estado_proyect,
      ifnull((SELECT GROUP_CONCAT(DISTINCT secr.des_secretarias SEPARATOR ', ') 
   FROM banco_proyec_financiacion bff 
   LEFT JOIN secretarias secr ON secr.idsecretarias = bff.secretaria 
   WHERE bff.id_proyect = proy.id_proyect),'NO ASIGNADA') AS secre 
      FROM proyectos proy WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . " proy.cod_proyect, "
                . "  ' ', "
                . " proy.nombre_proyect"
                . "  ' ', "
                . " proy.estado_proyect"
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND proy.estado='ACTIVO' order by proy.nombre_proyect ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT  proy.cod_proyect,proy.id_proyect,proy.nombre_proyect,proy.estado_proyect,
    ifnull((SELECT GROUP_CONCAT(DISTINCT secr.des_secretarias SEPARATOR ', ') 
 FROM banco_proyec_financiacion bff 
 LEFT JOIN secretarias secr ON secr.idsecretarias = bff.secretaria 
 WHERE bff.id_proyect = proy.id_proyect),'NO ASIGNADA') AS secre  FROM proyectos proy WHERE proy.estado='ACTIVO' order by proy.nombre_proyect ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link,$consulta);
$contador = 0;
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["id_proyect"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["cod_proyect"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nombre_proyect"] . "" . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["secre"] . ""
                . "</td>"
                . "<td style='vertical-align:middle' class=\"highlight\">"
                . "<div class='opciones'>"
                . "<a onclick=\"$.AddAvann('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-plus'></i> Agregar avances"
                . "</a>"
                . "</div>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM proyectos WHERE estado='ACTIVO'";
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