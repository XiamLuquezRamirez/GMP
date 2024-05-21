<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();

$cad = "";
$cad2 = "";
$cbp = "";
$consulta = "";
$contador = 0;

$i = 0;
$j = 0;

$regmos = $_POST["nreg"];

$pag = $_POST["pag"];
$op = $_POST["pag"];
$buscar[] = 100;

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}

$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i></i> <b>Proyecto</b>"
        . "</th>"
        . "<th>"
        . "<i></i> <b>Indicador</b>"
        . "</th>"
        . "<th>"
        . "<i></i> <b>Meta</b>"
        . "</th>"
        . "<th>"
        . "<i></i> <b>Resultado</b>"
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
  CONCAT(
    proy.cod_proyect,
    ' - ',
    proy.nombre_proyect
  ) nomproy,
  ind.nomb_indi nomind,
  met.desc_meta descmet,
  mi.resulindi resind,
  mi.fecha fecmed,
  mi.id idmed,
    IFNULL(ev.id_med,'NO') planm,
  mi.responsable respon
  
FROM
  proyectos proy 
  RIGHT JOIN mediindicador mi 
    ON proy.id_proyect = mi.proy_ori 
  LEFT JOIN indicadores ind 
    ON mi.indicador = ind.id_indi 
  LEFT JOIN metas met 
    ON mi.id_meta = met.id_meta 
  LEFT JOIN evaluacionindicador ev 
    ON mi.id=ev.id_med
WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "   ind.nomb_indi  , "
                . "  ' ', "
                . "  proy.nombre_proyect, "
                . "  ' ', "
                . "  proy.cod_proyect, "
                . "  ' ', "
                . "  met.desc_meta "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND  mi.estado<>'Cumplida' AND mi.id IN 
  (SELECT 
    MAX(id) 
  FROM
    mediindicador 
  GROUP BY id_meta)
  ORDER BY mi.id LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT 
  CONCAT(
    proy.cod_proyect,
    ' - ',
    proy.nombre_proyect
  ) nomproy,
  ind.nomb_indi nomind,
  met.desc_meta descmet,
  mi.resulindi resind,
  mi.fecha fecmed,
   mi.id idmed,
   IFNULL(ev.id_med,'NO') planm,
  mi.responsable respon 
FROM
  proyectos proy 
  RIGHT JOIN mediindicador mi 
    ON proy.id_proyect = mi.proy_ori 
  LEFT JOIN indicadores ind 
    ON mi.indicador = ind.id_indi 
  LEFT JOIN metas met 
    ON mi.id_meta = met.id_meta 
  LEFT JOIN evaluacionindicador ev 
    ON mi.id=ev.id_med
WHERE mi.estado<>'Cumplida' AND mi.id IN 
  (SELECT 
    MAX(id) 
  FROM
    mediindicador 
  GROUP BY id_meta)
  ORDER BY mi.id
  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;
$resultado = mysqli_query($link, $consulta);

$arr = array();

# Intialize the array, which will 
# store the fetched data.
$proy = array(); //Proyecto
$indi = array(); //Indicador
$meta = array(); //Meta
$Resu = array(); //Resultado Indicador
$Resp = array(); //Estado Indicador
$PlaM = array(); //Estado Indicador
$IdMe = array(); //Estado Indicador


while ($row = mysqli_fetch_assoc($resultado)) {
    array_push($proy, $row['nomproy']);
    array_push($indi, $row['nomind']);
    array_push($meta, $row['descmet']);
    array_push($Resu, $row['resind']);
    array_push($Resp, $row['respon']);
    array_push($PlaM, $row['planm']);
    array_push($IdMe, $row['idmed']);

    ////Proyectos
    if (!isset($arr[$row['nomproy']])) {
        $arr[$row['nomproy']]['rowspan'] = 0;
    }
    $arr[$row['nomproy']]['printed'] = 'no';
    $arr[$row['nomproy']]['rowspan'] += 1;

    ////Indicadores
    if (!isset($arr[$row['nomind']])) {
        $arr[$row['nomind']]['rowspan'] = 0;
    }
    $arr[$row['nomind']]['printed'] = 'no';
    $arr[$row['nomind']]['rowspan'] += 1;
}



for ($i = 0; $i < sizeof($meta); $i++) {
    $empProy = $proy[$i];
    $empInd = $indi[$i];

    $cad .= "<tr class='selected'</td>";

    # If this row is not printed then print.
    # and make the printed value to "yes", so that
    # next time it will not printed.
    if ($arr[$empProy]['printed'] == 'no') {
        $cad .= "<td style='vertical-align: middle;color: #000;' rowspan='" . $arr[$empProy]['rowspan'] . "'>" . ucwords(strtolower($empProy)) . "</td>";
        $arr[$empProy]['printed'] = 'yes';
    }
    if ($arr[$empInd]['printed'] == 'no') {
        $cad .= "<td style='vertical-align: middle;color: #000;' rowspan='" . $arr[$empInd]['rowspan'] . "'>" . ucwords(strtolower($empInd)) . "</td>";
        $arr[$empInd]['printed'] = 'yes';
    }

    $cad .= "<td style='vertical-align: middle;color: #000;'>" . ucwords(strtolower($meta[$i])) . "</td>";
    $cad .= "<td style='vertical-align: middle;'>" . $Resu[$i] . "</td>";
    $cad .= "<td style='vertical-align: middle;color: #000;'>" . ucwords(strtolower($Resp[$i])) . "</td>";
    $cad .= "<td style='vertical-align:middle'>";
    if ($PlaM[$i] == "NO") {
        $cad .= "<a onclick=\"$.EvalIndiProy('" . $IdMe[$i] . "')\" title='Aplicar Plan de Mejora' class='btn default btn-xs blue'>"
                . "<i class='fa fa-check'></i> Establecer Plan de Mejora </a>";
    } else {
        $cad .= "<a onclick=\"$.EvalIndiProyEdit('" . $IdMe[$i] . "')\" title='Aplicar Plan de Mejora' class='btn default btn-xs green'>"
                . "<i class='fa fa-check'></i> Editar Plan de Mejora </a>";
    }
    $cad .= "</td>";
    $cad .= "</tr>";
}

$cad .= "</tbody>"
        . "</table>";


$consulta = "SELECT 
 count(*) conta
FROM
  proyectos proy 
  RIGHT JOIN mediindicador mi 
    ON proy.id_proyect = mi.proy_ori 
  LEFT JOIN indicadores ind 
    ON mi.indicador = ind.id_indi 
  LEFT JOIN metas met 
    ON mi.id_meta = met.id_meta 
  LEFT JOIN evaluacionindicador ev 
    ON mi.id=ev.id_med
WHERE mi.estado<>'Cumplida' AND mi.id IN 
  (SELECT 
    MAX(id) 
  FROM
    mediindicador 
  GROUP BY id_meta)";

$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador = intval($fila["conta"]);
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
    if ($pagact < $div) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . div . "' />"
                . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn blue btn-outline\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn blue btn-outline\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\" disabled  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . div . "' />"
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