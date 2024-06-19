<?php
session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
header("Content-type: application/vnd.ms-excel");
$hoy = date("Y");
header("Content-Disposition: attachment; filename=PlanDesarrollo$hoy.xls");
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
            <th class="tg-7fle" colspan="1" rowspan="3"><img src="http://gmp.leeringenieria.com/Img/logo-big.png" width="150" height="50" align="top"></th>
            <th class="tg-0lax" colspan="3" rowspan="3"><h2>PLAN DE DESARROLLO - <?php echo $hoy; ?></h2></th>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tg-1wig" style="border: #000 1px solid;"><b><?php  echo  $_SESSION['nivel1']; ?></b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b><?php  echo  $_SESSION['nivel2']; ?></b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b><?php  echo  $_SESSION['nivel3']; ?></b></td>
        </tr>
        <?php
        $total = 0;

        $sql = "SELECT
                  CONCAT(dim.codigo,' - ',dim.descripcion) dim,
                  CONCAT(ej.CODIGO,' - ',ej.NOMBRE) eje,
                  CONCAT(comp.CODIGO,' - ',comp.NOMBRE) comp,
                  CONCAT(prog.CODIGO,' - ',prog.NOMBRE) prog
                FROM
                 dimensiones dim
                 LEFT JOIN ejes ej 
                  ON dim.id=ej.DIMENSION
                  LEFT  JOIN componente comp
                  ON ej.ID=comp.ID_EJE
                  LEFT JOIN programas prog
                  ON comp.ID=prog.ID_COMP
                  WHERE  prog.ESTADO='ACTIVO'";
        $resultado = mysqli_query($link, $sql);

        while ($data = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["eje"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["comp"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["prog"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
