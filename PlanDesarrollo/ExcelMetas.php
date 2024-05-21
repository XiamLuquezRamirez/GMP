<?php
session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
header("Content-type: application/vnd.ms-excel");
$hoy = date("Y");
header("Content-Disposition: attachment; filename=MetasTrazadoras$hoy.xls");
?>
<meta charset="utf-8"/>
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
           overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-1wig{background-color:#efefef;font-weight:bold;text-align:left;vertical-align:top}
    .tg .tg-7fle{text-align:center;vertical-align:top;align-items: center;}
    .tg .tg-baqh{text-align:center;vertical-align:top}
    .tg .tg-0lax{font-weight:bold;text-align:center;vertical-align:top;}
</style>
<table class="tg">
    <thead>
        <tr>
            <th class="tg-7fle" colspan="3" rowspan="1"><img src="http://gmp.leeringenieria.com/Img/logo-big.png" width="150" height="50" align="top"></th>
            <th class="tg-0lax" colspan="6" rowspan="1"><h2>METAS TRAZADORAS - PLAN DE DESARROLLO - <?php echo $hoy; ?></h2></th>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>ITEMS</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>CÓDIGO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>DESCRIPCIÓN</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>UNIDAD DE MEDIDA</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>LÍNEA BASE</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>META</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>RESPONSABLES</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>FUENTE DE INFORMACIÓN</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>SUBPROGRAMA</b></td>
        </tr>
        <?php
        $total = 0;
        $x = 1;

        $sql = "SELECT cod_meta cod, desc_meta des, base_meta base,
        respo_metas resp,des_prog_metas prg, meta met, tipdato_metas tdato, fuente_metas fuent   FROM metas
        WHERE estado_metas='ACTIVO'";
        $resultado = mysqli_query($link, $sql);

        while ($data = mysqli_fetch_array($resultado)) {
            $resp = "";
            $fuent = "";
            $consulta = "SELECT * FROM dependencias WHERE iddependencias IN (" . $data["resp"] . ")";
            //  echo $consulta2;
            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $resp = $resp . $fila2["des_dependencia"] . ', ';
                }
            }
            ////////////////////////////7
            $consulta = "SELECT * FROM fuente_informacion WHERE id IN (" . $data["fuent"] . ")";
            //  echo $consulta2;
            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $fuent = $fuent . $fila2["nombre"] . ', ';
                }
            }
            ?>
            <tr>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $x; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["cod"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["des"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["tdato"]; ?></td>
                  <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["base"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["met"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo trim($resp, ', ') ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo trim($fuent, ', ') ?></td>
                    <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["prg"]; ?></td>
            </tr>
            <?php
            $x++;
        }
        ?>
    </tbody>
</table>
