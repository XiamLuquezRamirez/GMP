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

$Usuproy = array();

$consulta = "SELECT *  FROM usu_proyect WHERE usuario='" . $_SESSION['ses_idusu'] . "'";
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $Usuproy[] = $fila["proyect"];
    }
}

$finalpro = implode(",", $Usuproy);

$cad = "<table class=\"table table-striped table-bordered table-hover dataTable no-footer\" role=\"grid\" >"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i ></i> <b>Código</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Nombre</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Fecha</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Tipología</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Secretaria</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Avance</b>"
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

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT * FROM proyectos WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . " cod_proyect, "
                . "  ' ', "
                . " nombre_proyect, "
                . "  ' ', "
                . " dsecretar_proyect, "
                . "  ' ', "
                . " estado_proyect"
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND estado='ACTIVO' order by nombre_proyect ASC LIMIT " . $regemp . "," . $regmos;
} else {
    $consulta = "SELECT * FROM proyectos WHERE  estado='ACTIVO' order by nombre_proyect ASC  LIMIT " . $regemp . "," . $regmos;
//    $consulta = "SELECT * FROM proyectos WHERE id_proyect IN(".$finalpro.") AND estado='ACTIVO' order by nombre_proyect ASC  LIMIT " . $regemp . "," . $regmos;
}

$resultado = mysqli_query($link, $consulta);
$contador = 0;
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $porcPro = 0;
        $cod = $fila["id_proyect"];
        $consulta2 = "SELECT
  SUM(contr.porproy_contrato) porc
FROM
  contratos contr
  LEFT JOIN proyectos pro
    ON contr.idproy_contrato = pro.id_proyect
WHERE contr.idproy_contrato = '" . $cod . "'
  AND contr.estad_contrato = 'Terminado'
  AND id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato)";
        $EstPro = "";
        $resultado2 = mysqli_query($link, $consulta2);
        if (mysqli_num_rows($resultado2) > 0) {
            while ($fila2 = mysqli_fetch_array($resultado2)) {
                $porcPro = $fila2['porc'];
            }
        }
        if ($fila["estado_proyect"] == "En Ejecucion") {
            $EstPro = "En Ejecución";
        } else {
            $EstPro = $fila["estado_proyect"];
        }

        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["cod_proyect"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nombre_proyect"] . "" . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["fec_crea_proyect"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["dtipol_proyec"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["dsecretar_proyect"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<div class='progress progress-striped active'>"
                . "						<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: " . $porcPro . "%'>"
                . "							<span >"
                . "							" . $porcPro . "% Completado (success) </span>"
                . "						</div>"
                . "					</div>"
                . "</td>"
                . "<td class=\"highlight\">"
                . $EstPro . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
        if ($_SESSION['GesProyMPr'] == "s") {
            $cad .= "<td>"
                    . "<a  onclick=\"$.editProy('" . $cod . "')\" class='btn default btn-xs purple'>" .
                    "<i class='fa fa-edit'></i> Editar "
                    . "</a>"
                    . "</td>";
        }

        $cad .= "<td>"
                . "<a onclick=\"$.VerProy('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>";

        if ($_SESSION['GesProyEPr'] == "s") {
            $cad .= "<td>"
                    . "<a onclick=\"$.deletProy('" . $cod . "')\" class='btn default btn-xs red'>" .
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

$consulta = "SELECT count(*) as conta FROM proyectos WHERE estado='ACTIVO' ";
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
?>