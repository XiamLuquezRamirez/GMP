<?php
session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
header("Content-type: application/vnd.ms-excel");
$hoy = date("Y");
header("Content-Disposition: attachment; filename=ContratosxProyectos$hoy.xls");
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
            <th class="tg-7fle" colspan="2" rowspan="1"><img src="http://gmp.leeringenieria.com/Img/logo-big.png" width="200" height="100" ></th>
            <th class="tg-0lax" colspan="6" rowspan="1"><h2>CONTRATOS POR PROYECTOS - <?php echo $hoy; ?></h2></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>ITEMS</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>PROYECTO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>CONTRATO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>INTERVENTOR</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>SUPERVISOR</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>TIPOLOGIA CONTRATO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>VALOR DEL CONTRATO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>ESTATO</b></td>
        </tr>
        <?php
        $total = 0;
        $x = 1;

        $sql = "SELECT
                CONCAT(proy.cod_proyect,' - ',proy.nombre_proyect) proy, CONCAT(cnt.num_contrato,' - ',cnt.obj_contrato) contr,
                cnt.desinterv_contrato interv, cnt.dessuperv_contrato superv,cnt.destipolg_contrato tipo, cnt.vcontr_contrato valor,cnt.estad_contrato estado
              FROM
              contratos cnt
                LEFT JOIN 
                proyectos proy 
                  ON cnt.idproy_contrato =  proy.id_proyect
                LEFT JOIN proyect_metas proymet
                  ON proy.id_proyect = proymet.cod_proy
                LEFT JOIN metas met
                  ON proymet.id_meta = met.id_meta
                LEFT JOIN ejes eje
                  ON met.ideje_metas = eje.ID
                LEFT JOIN componente comp
                  ON met.idcomp_metas = comp.ID
                LEFT JOIN programas prog
                  ON met.idprog_metas = prog.ID
                WHERE proy.estado='ACTIVO' 
                AND IFNULL(proy.secretaria_proyect, '') LIKE '" . $_REQUEST['CbSecr'] . "%'
                AND IFNULL(proy.id_proyect, '') LIKE '" . $_REQUEST['CbProy'] . "%'
                AND IFNULL(eje.ID, '') LIKE '" . $_REQUEST['CbEje'] . "%'
                AND IFNULL(comp.ID, '') LIKE '" . $_REQUEST['CbComp'] . "%'
                AND IFNULL(prog.ID, '') LIKE '" . $_REQUEST['CbProg'] . "%' 		
                  AND cnt.id_contrato IN
                (SELECT
                  MAX(id_contrato)
                FROM
                  contratos
                GROUP BY num_contrato)";
//        echo $sql;
        $resultado = mysqli_query($link, $sql);

        while ($data = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $x; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["proy"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["contr"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["interv"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["superv"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["tipo"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["valor"]; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo $data["estado"]; ?></td>
            </tr>
            <?php
            $x++;
        }
        ?>
    </tbody>
</table>
