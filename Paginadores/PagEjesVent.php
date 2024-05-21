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

$i = 0;
$j = 0;


$buscar[] = 100;



$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Código"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Descripción"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT * FROM ejes WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  CODIGO, "
                . "  ' ', "
                . "  NOMBRE "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND ESTADO='ACTIVO' order by NOMBRE ASC";
} else {

    $consulta = "SELECT * FROM ejes WHERE ESTADO='ACTIVO' order by NOMBRE ASC";
}

//echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {

        $cod = $fila["ID"];
        $cad .= "<tr style='cursor: pointer' onclick=\"$.SelEjes('" . $cod . "//" . $fila["CODIGO"] . "//" . $fila["NOMBRE"] . "')\">"
                . "<td class=\"highlight\">"
                . $fila["CODIGO"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["NOMBRE"] . ""
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM ejes WHERE ESTADO='ACTIVO' ";
$resultado2 = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado2) > 0) {

    while ($fila = mysqli_fetch_array($resultado2)) {
        $contador = intval($fila["conta"]);
    }
}
$cad .= "</tbody>"
        . "</table>";



$salida = new stdClass();
$salida->cad = $cad;


echo json_encode($salida);

mysqli_close($link);
?>