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
$resp = "";
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
    . "<i></i> <b>Código</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Descripcion</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>Meta</b>"
    . "</th>"
    . "<th>"
    . "<i ></i> <b>".$_SESSION['nivel3'] ."</b>"
    . "</th>"
    . "<th>"
    . "<i></i> <b>Responsable</b>"
    . "</th>"
    . "<th>"
    . "<i></i> <b>Acci&oacute;n</b>"
    . "</th>"
    . "</tr>"
    . "</thead>"
    . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);
    $consulta = "SELECT
                    mp.id AS IDMETPRO,
                    mp.codigo AS CODMET,
                    mp.descripcion AS NOMMET,
                    p.NOMBRE AS SUBPRO,
                    p.CODIGO AS CODSUB,
                    s.des_dependencia AS DEPENDENCIA,
                    mp.clasificacion AS CLAMETPRO,
                    mp.objetivo AS OBJMETPRO,
                    mp.id_secretaria AS IDDEPENDENCIA,
                    mp.id_eje AS IDEJE,
                    mp.id_programa AS IDPROGRAMA,
                    mp.id_subprograma AS IDSUBPROGRAMA
                FROM
                    metas_productos AS mp
                        INNER JOIN
                    programas AS p ON mp.id_programa = p.ID
                        INNER JOIN
                    dependencias AS s ON mp.id_secretaria = s.iddependencias WHERE ";
    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
            . "  mp.codigo, "
            . "  ' ', "
            . "  mp.descripcion, "
            . "  ' ', "
            . "  p.NOMBRE, "
            . "  ' ', "
            . "  p.CODIGO, "
            . "  ' ', "
            . "  s.des_dependencia "
            . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND mp.estado='ACTIVO' order by mp.id DESC LIMIT " . $regemp . "," . $regmos;
} else {
    $consulta = "SELECT
                    mp.id AS IDMETPRO,
                    mp.codigo AS CODMET,
                    mp.descripcion AS NOMMET,
                    p.NOMBRE AS SUBPRO,
                    p.CODIGO AS CODSUB,
                    s.des_dependencia AS DEPENDENCIA,
                    mp.clasificacion AS CLAMETPRO,
                    mp.objetivo AS OBJMETPRO,
                    mp.id_secretaria AS IDDEPENDENCIA,
                    mp.id_eje AS IDEJE,
                    mp.id_programa AS IDPROGRAMA,
                    mp.id_subprograma AS IDSUBPROGRAMA                    
                FROM
                    metas_productos AS mp
                        INNER JOIN
                    programas AS p ON mp.id_programa = p.ID
                        INNER JOIN
                    dependencias AS s ON mp.id_secretaria = s.iddependencias WHERE
                    mp.estado='ACTIVO' order by mp.id DESC  LIMIT " . $regemp . "," . $regmos;
}
// echo $consulta;
$resultado = mysqli_query($link, $consulta);
$contador = 0;
$k = 1;
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {      
        
        $consulta = "SELECT * FROM dependencias WHERE iddependencias IN (" . $fila["IDDEPENDENCIA"] . ")";
        
        $resultado2 = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado2) > 0) {
            while ($fila2 = mysqli_fetch_array($resultado2)) {
                $resp = $resp . $fila2["des_dependencia"] . ', ';
            }
        }
        
        $cad .= "<tr
                    data-id='" . $fila["IDMETPRO"] . "'
                    data-descripcion='" . $fila["NOMMET"] . "'
                    data-codigo='" . $fila["CODMET"] . "'
                    data-objetivo='" . $fila["OBJMETPRO"] . "'
                    data-id_dependencia='" . $fila["IDDEPENDENCIA"] . "'
                    data-id_eje='" . $fila["IDEJE"] . "'
                    data-id_programa='" . $fila["IDPROGRAMA"] . "'
                    data-id_subprograma='" . $fila["IDSUBPROGRAMA"] . "'
                    data-clasificacion='" . $fila["CLAMETPRO"] . "'
              >"
            . "<td class=\"highlight\">"
            . $fila["CODMET"] . " "
            . "</td>"
            . "<td class=\"highlight\">"
            . $fila["NOMMET"] . ""
            . "</td>"
            . "<td class=\"highlight\">"
            . $fila["OBJMETPRO"] . ""
            . "</td>"
            . "<td class=\"highlight\">"
            . $fila["CODSUB"] . " -- ". $fila["SUBPRO"] 
            . "</td>"
            . "<td class=\"highlight\">"
            . trim($resp, ', ') . ""
            . "</td>"
            . "<td class=\"highlight\">";
        if ($_SESSION['GesParMSec'] == "s") {
            $cad .= "<a class=\"btn default btn-xs purple btnEditar\">" .
                "<i class='fa fa-edit'></i> Editar "
                . "</a>";
        }
        if ($_SESSION['GesParESec'] == "s") {
            $cad .= "<a  class='btn default btn-xs red btnEliminar'>" .
                "<i class='fa fa-trash-o'></i> Eliminar "
                . "</a>";
        }
        $cad .= "</td>"
            . "</tr>";
        $k++;
    }
}

// $consulta = "SELECT count(*) as conta FROM fuentes WHERE estado='ACTIVO' ";
$consulta = "SELECT
                count(*) as conta
            FROM
                metas_productos AS mp
                    INNER JOIN
                programas AS p ON mp.id_programa = p.ID
                    INNER JOIN
                dependencias AS s ON mp.id_secretaria = s.iddependencias
            WHERE
                    mp.estado='ACTIVO'";
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
