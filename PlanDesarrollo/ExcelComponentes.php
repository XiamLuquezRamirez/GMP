<?php
session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
header("Content-type: application/vnd.ms-excel");
$hoy = date("Y");
header("Content-Disposition: attachment; filename=ProgramasPlanDesarrollo$hoy.xls");
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
            <th class="tg-7fle" colspan="1" rowspan="1"><img src="http://gmp.leeringenieria.com/Img/logo-big.png" width="150" height="50" align="top"></th>
            <th class="tg-0lax" colspan="1" rowspan="1"><h2>PROGRAMAS - PLAN DE DESARROLLO - <?php echo $hoy; ?></h2></th>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>CÓDIGO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>DESCRIPCIÓN</b></td>
        </tr>
        <?php
        $total = 0;

        $sql = "SELECT  * from componente where ESTADO='ACTIVO'";
        $resultado = mysqli_query($link, $sql);

        while ($data = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["CODIGO"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["NOMBRE"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
