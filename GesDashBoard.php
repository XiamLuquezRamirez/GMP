<?php

session_start();
include "Conectar.php";
$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');

date_default_timezone_set('America/Bogota');

$Ope = $_POST['ope'];


if ($Ope == "CargParaDashboard") {

    $myDat = new stdClass();
    $Secre = "<option value=' '>Todas...</option>";
    $Ejes = "<option value=' '>Todos...</option>";
    $Fina = "<option value=' '>Todas...</option>";
//////////////////////CONSULTAR SECRETARIAS
    $consulta = "select * from secretarias where estado_secretaria='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Secre .= "<option value='" . $fila["idsecretarias"] . "'>" . $fila["des_secretarias"] . "</option>";
        }
    }
//////////////////////CONSULTAR FUENT. FINANCI
    $consulta = "select * from fuentes where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Fina .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }
//////////////////////CONSULTAR EJES
    $consulta = "select * from ejes where ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Ejes .= "<option value='" . $fila["ID"] . "'>" . $fila["NOMBRE"] . "</option>";
        }
    }
    $myDat->Secre = $Secre;
    $myDat->Ejes = $Ejes;
    $myDat->Fina = $Fina;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($Ope == "ConsulGesProy") {

    $myDat = new stdClass();
    $RawUbiProy = array(); //Datos Ubicacion
///CONSULTAR UBICACIÓN 
    $consulta = "SELECT 
  proy.cod_proyect codproy,
  proy.nombre_proyect nproy,
  proy.dtipol_proyec tip,
  proy.dsecretar_proyect sec,
  proy.estado_proyect estad,
  ubi.lat_ubic lat,
  ubi.long_ubi logi,
  eje.NOMBRE neje,
  comp.NOMBRE ncomp,
  prog.NOMBRE nprog
  
FROM
  proyectos proy 
  INNER JOIN ubic_proyect ubi 
    ON proy.id_proyect = ubi.proyect_ubi 
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
    LEFT JOIN  presupuesto_secretarias pc
    ON proy.secretaria_proyect=pc.id_secretaria
WHERE proy.estado_proyect IN ('En Ejecucion','Ejecutado')";
    if ($_POST["CbSec"] != "") {
        $consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbEje"] != "") {
        $consulta .= "AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $consulta .= "AND IFNULL(pc.id_fuente, '') = '" . $_POST["CbFin"] . "'";
    }

    $consulta .= " GROUP BY codproy";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($filaOP = mysqli_fetch_array($resultado)) {
            $RawUbiProy[] = array(
                "lat" => $filaOP['lat'],
                "logi" => $filaOP['logi'],
                "codproy" => $filaOP['codproy'],
                "nproy" => $filaOP['nproy'],
                "tip" => $filaOP['tip'],
                "sec" => $filaOP['sec'],
                "neje" => $filaOP['neje'],
                "ncomp" => $filaOP['ncomp'],
                "nprog" => $filaOP['nprog'],
                "estad" => $filaOP['estad']
            );
        }
    }

    $myDat->RawUbiProy = $RawUbiProy;


    /////PRESUPUESTO 

    $Consulta = "SELECT SUM(valor) presu FROM presupuesto_secretarias WHERE estado='ACTIVO'";
    if ($_POST["CbSec"] != "") {
        $Consulta .= " AND IFNULL(id_secretaria, '') = '" . $_POST["CbSec"] . "'";
    }

    $resultado = mysqli_query($link, $Consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->PI = $fila['presu'];
        }
    }



///CONSULTAR VALOR PROYECTOS EN EJECUCION
    $TotProyEjecu = 0;
    $consulta = "SELECT 
 proy.id_proyect idproy
FROM
  proyectos proy 
  LEFT JOIN banco_proyec_presupuesto pres 
    ON proy.id_proyect = pres.id_proyect 
    LEFT JOIN proyect_metas proymet 
    ON proy.id_proyect = proymet.cod_proy 
  LEFT JOIN metas met 
    ON proymet.id_meta = met.id_meta 
  LEFT JOIN ejes eje 
    ON met.ideje_metas = eje.ID
       LEFT JOIN  presupuesto_secretarias pc
    ON proy.secretaria_proyect=pc.id_secretaria
WHERE proy.estado_proyect NOT IN (
            'Radicado',
            'Registrado',
            'No Viabilizado'
          )
AND proy.estado='ACTIVO'";
    if ($_POST["CbSec"] != "") {
        $consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbEje"] != "") {
        $consulta .= "AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $consulta .= "AND IFNULL(pc.id_fuente, '') = '" . $_POST["CbFin"] . "'";
    }
    $consulta .= " GROUP BY proy.cod_proyect";


    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Consulta = "SELECT 
            SUM(pproy.total) total
           FROM
             proyectos proy 
             LEFT JOIN banco_proyec_presupuesto pproy
             ON proy.id_proyect=pproy.id_proyect 
           WHERE  proy.id_proyect='" . $fila['idproy'] . "'
           GROUP BY proy.id_proyect";
            $resultadoVP = mysqli_query($link, $Consulta);
            if (mysqli_num_rows($resultadoVP) > 0) {
                while ($filaVP = mysqli_fetch_array($resultadoVP)) {
                    $TotProyEjecu = $TotProyEjecu + $filaVP['total'];
                }
            }
        }
    }

    $myDat->PresEjecucion = $TotProyEjecu;


    ///CONSULTAR VALOR PROYECTOS EJECUTADOS
    $TotProyEjecutado = 0;
    $consulta = "SELECT 
 proy.id_proyect idproy
FROM
  proyectos proy 
  LEFT JOIN banco_proyec_presupuesto pres 
    ON proy.id_proyect = pres.id_proyect 
    LEFT JOIN proyect_metas proymet 
    ON proy.id_proyect = proymet.cod_proy 
  LEFT JOIN metas met 
    ON proymet.id_meta = met.id_meta 
  LEFT JOIN ejes eje 
    ON met.ideje_metas = eje.ID
       LEFT JOIN  presupuesto_secretarias pc
    ON proy.secretaria_proyect=pc.id_secretaria
WHERE proy.estado_proyect = 'Ejecutado'
AND proy.estado='ACTIVO'";
    if ($_POST["CbSec"] != "") {
        $consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbEje"] != "") {
        $consulta .= "AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $consulta .= "AND IFNULL(pc.id_fuente, '') = '" . $_POST["CbFin"] . "'";
    }
    $consulta .= " GROUP BY proy.cod_proyect";


    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($filaPR = mysqli_fetch_array($resultado)) {

            $Consulta = "SELECT 
            SUM(pproy.total) total
           FROM
             proyectos proy 
             LEFT JOIN banco_proyec_presupuesto pproy
             ON proy.id_proyect=pproy.id_proyect 
           WHERE  proy.id_proyect='" . $filaPR['idproy'] . "'
           GROUP BY proy.id_proyect";
            $resultadoVP = mysqli_query($link, $Consulta);
            if (mysqli_num_rows($resultadoVP) > 0) {
                while ($filaVP = mysqli_fetch_array($resultadoVP)) {
                    $TotProyEjecutado = $TotProyEjecutado + $filaVP['total'];
                }
            }
        }
    }

    $myDat->PresEjecutado = $TotProyEjecutado;

    $Consulta = "SELECT SUM(vejec) veje FROM(
SELECT 
    contr.veje_contrato vejec
  FROM
    proyectos proy 
    LEFT JOIN contratos contr
    ON proy.id_proyect=contr.idproy_contrato
    LEFT JOIN proyect_metas proymet 
      ON proy.id_proyect = proymet.cod_proy 
    LEFT JOIN metas met 
      ON proymet.id_meta = met.id_meta 
    LEFT JOIN ejes eje 
      ON met.ideje_metas = eje.ID 
    LEFT JOIN presupuesto_secretarias pc 
      ON proy.secretaria_proyect = pc.id_secretaria 
  WHERE proy.estado = 'ACTIVO' AND proy.estado_proyect='En Ejecucion' AND contr.estcont_contra='Verificado'";
    if ($_POST["CbSec"] != "") {
        $Consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbEje"] != "") {
        $Consulta .= "AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $Consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $Consulta .= "AND IFNULL(pc.id_fuente, '') = '" . $_POST["CbFin"] . "'";
    }
    $Consulta .= "AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos WHERE estcont_contra='Verificado'  
  GROUP BY num_contrato)
  GROUP BY contr.num_contrato) AS t";

//    echo $Consulta;

    $resultado = mysqli_query($link, $Consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($filaVE = mysqli_fetch_array($resultado)) {
            $myDat->TotContEje = $filaVE['veje'];
        }
    }


    ///////////CONSULTAR PRESUPUESTO SECRETARIA

    $Consulta = "select 
  pre.id_secretaria idsec,
  sec.des_secretarias descr,
  sum(valor) valor 
from
  presupuesto_secretarias pre 
  left join secretarias sec 
    on pre.id_secretaria = sec.idsecretarias 
    where pre.estado='ACTIVO'";
    if ($_POST["CbSec"] != "") {
        $Consulta .= " AND IFNULL(sec.idsecretarias, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $Consulta .= " AND IFNULL(YEAR(pre.fecha), '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $Consulta .= "AND IFNULL(pre.id_fuente, '') = '" . $_POST["CbFin"] . "'";
    }
    $Consulta .= " GROUP BY pre.id_secretaria";
//    echo $Consulta;
    $rawdata = array(); //creamos un array

    $resultado = mysqli_query($link, $Consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $IdSec = $fila['idsec'];
            $Desc = $fila['descr'];
            $Val = $fila['valor'];

            $consultaPRoy = "select sec,sum(totgast) tcomp from(
        select 
          proy.secretaria_proyect sec, ifnull(sum(preproy.total),0) totgast
        from
          proyectos proy
          left join  banco_proyec_presupuesto preproy
          on proy.id_proyect=preproy.id_proyect
        where proy.secretaria_proyect = '" . $IdSec . "' and proy.estado='ACTIVO'
          and estado_proyect NOT IN (
            'Radicado',
            'Registrado',
            'No Viabilizado'
          )
          group by preproy.id_proyect) t group by sec";
            $valComp = 0;
            $resultadoComp = mysqli_query($link, $consultaPRoy);
            if (mysqli_num_rows($resultadoComp) > 0) {
                while ($filaComp = mysqli_fetch_array($resultadoComp)) {
                    $valComp = $filaComp['tcomp'];
                }
            }

            $PorGat = ($valComp / $Val) * 100;

            $rawdata[] = array(
                "Desc" => $Desc,
                "Val" => $Val,
                "valComp" => $valComp,
                "PorGat" => round($PorGat, 2)
            );
        }
    }
    $myDat->PresSecret = $rawdata;



    ///////////////////ESTADO DE PROYECTOS

    $consulta = "SELECT COUNT(*) cant,estado_proyect  FROM (
SELECT 
    COUNT(cod_proyect), cod_proyect,nombre_proyect,estado_proyect
 FROM  proyectos proy
  LEFT JOIN (
    SELECT proymet.cod_proy codproy, proymet.id_meta met FROM proyect_metas proymet GROUP BY proymet.cod_proy
) t    
    ON proy.id_proyect = t.codproy 
  LEFT JOIN metas met 
    ON t.met= met.id_meta 
  LEFT JOIN ejes eje 
    ON met.ideje_metas = eje.ID
      LEFT JOIN (
    SELECT pc.id_secretaria secr, pc.id_fuente fuent FROM presupuesto_secretarias pc GROUP BY pc.id_secretaria
) s  
    ON proy.secretaria_proyect=s.secr
  LEFT JOIN secretarias sec
    ON proy.secretaria_proyect=sec.idsecretarias
WHERE proy.estado='ACTIVO'";
    if ($_POST["CbSec"] != "") {
        $consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbEje"] != "") {
        $consulta .= "AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $consulta .= "AND IFNULL(s.fuent, '') = '" . $_POST["CbFin"] . "'";
    }
    $consulta .= " GROUP BY id_proyect) AS t GROUP BY estado_proyect";
//    echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Cate = $fila['estado_proyect'];
            $cant = $fila['cant'];

            $rawdata[] = array(
                "Cate" => $Cate,
                "cant" => $cant
            );
        }
    }
    $myDat->ProyEst = $rawdata;


    ////////////////////// PRESUPUESTO COMPROMETIDO VS PRESUPUESTO GASTADO

    $TotProyEjecutado = 0;
    $TotContEjecutado = 0;
    $consulta = "SELECT idproy,fcre,SUM(val) valtot,MONTH(fcre) mes FROM(
 SELECT 
 proy.id_proyect idproy, proy.fec_crea_proyect fcre, IFNULL(SUM(pres.total),0) val
 FROM
  proyectos proy 
  LEFT JOIN banco_proyec_presupuesto pres 
    ON proy.id_proyect = pres.id_proyect 
  LEFT JOIN (
    SELECT proymet.cod_proy codproy, proymet.id_meta met FROM proyect_metas proymet GROUP BY proymet.cod_proy
    ) t    
    ON proy.id_proyect = t.codproy 
  LEFT JOIN metas met 
    ON t.met= met.id_meta 
  LEFT JOIN ejes eje 
    ON met.ideje_metas = eje.ID
      LEFT JOIN (
    SELECT pc.id_secretaria secr, pc.id_fuente fuent FROM presupuesto_secretarias pc GROUP BY pc.id_secretaria
    ) s  
    ON proy.secretaria_proyect=s.secr
    WHERE proy.estado_proyect NOT IN (
            'Radicado',
            'Registrado',
            'No Viabilizado'
          )
        AND proy.estado='ACTIVO'";
    if ($_POST["CbSec"] != "") {
        $consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    if ($_POST["CbEje"] != "") {
        $consulta .= "AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
    }
    if ($_POST["CbVig"] != "") {
        $consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
    }
    if ($_POST["CbFin"] != "") {
        $consulta .= "AND IFNULL(s.fuent, '') = '" . $_POST["CbFin"] . "'";
    }
    $consulta .= " GROUP BY proy.id_proyect 
    ORDER BY proy.fec_crea_proyect ASC) t GROUP BY fcre";


    $resultado = mysqli_query($link, $consulta);
    $rawPCvsPG = array(); //creamos un array

    if (mysqli_num_rows($resultado) > 0) {
        while ($filaPR = mysqli_fetch_array($resultado)) {
            $TotProyEjecutado = $TotProyEjecutado + $filaPR['valtot'];

            $ConsultaCE = "SELECT veje_contrato veje FROM contratos WHERE estad_contrato IN('Ejecucion','Terminado','Liquidado') AND estcont_contra='Verificado'  AND id_contrato IN 
  (SELECT 
    MAX(id_contrato) 
  FROM
    contratos WHERE MONTH(fmod_contrato)='" . $filaPR['mes'] . "'
  GROUP BY num_contrato)";

           

            $resultadoCE = mysqli_query($link, $ConsultaCE);
            if (mysqli_num_rows($resultadoCE) > 0) {
                while ($filaCE = mysqli_fetch_array($resultadoCE)) {
                    $TotContEjecutado = $TotContEjecutado + $filaCE['veje'];
                }
            }

            $rawPCvsPG[] = array(
                "date" => $filaPR['fcre'],
                "value" => $TotProyEjecutado,
                "value2" => $TotContEjecutado
            );
        }
    }
    $myDat->rawPCvsPG = $rawPCvsPG;



    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
}


mysqli_close($link);
