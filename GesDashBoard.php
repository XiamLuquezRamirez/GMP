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
  if($_POST["CbSec"] != ""){
    $Consulta = "SELECT SUM(valor) presu FROM presupuesto_secretarias WHERE id_secretaria =".$_POST["CbSec"]."  GROUP BY id_secretaria";
  }else{
    $Consulta = "SELECT SUM(valor) presu FROM presupuesto_total WHERE estado='ACTIVO'";

  }



  $resultado = mysqli_query($link, $Consulta);
  if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
      $myDat->PI = $fila['presu'];
    }
  }


  ///PRESUPUESTO CON CDP
  $TotProyPriori = 0;
  $consulta = "SELECT proy.id_proyect FROM proyectos proy 
   LEFT JOIN banco_proyec_presupuesto pres 
    ON proy.id_proyect = pres.id_proyect 
    LEFT JOIN proyect_metas proymet 
    ON proy.id_proyect = proymet.cod_proy 
  LEFT JOIN metas met 
    ON proymet.id_meta = met.id_meta 
  LEFT JOIN ejes eje 
    ON met.ideje_metas = eje.ID 
    LEFT JOIN banco_proyec_financiacion finan
    ON proy.id_proyect = finan.id_proyect
  WHERE proy.estado='ACTIVO' and comp_pres='si' and estado_proyect='En Ejecucion'";

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
    $consulta .= "AND IFNULL(finan.origen, '') = '" . $_POST["CbFin"] . "'";
  }
  $consulta .= " GROUP BY proy.id_proyect";

  $resultado = mysqli_query($link, $consulta);

  if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
      $Consulta = "SELECT 
            SUM(pproy.total) total
           FROM
             proyectos proy 
             LEFT JOIN banco_proyec_presupuesto pproy
             ON proy.id_proyect=pproy.id_proyect 
           WHERE  proy.id_proyect='" . $fila['id_proyect'] . "'
           GROUP BY proy.id_proyect";


      $resultadoVP = mysqli_query($link, $Consulta);
      if (mysqli_num_rows($resultadoVP) > 0) {
        while ($filaVP = mysqli_fetch_array($resultadoVP)) {
          $TotProyPriori = $TotProyPriori + $filaVP['total'];
        }
      }
    }
  }

  $myDat->TotProyPriori = $TotProyPriori;



  ///PROYECTOS EN EJECUCION

  $TotProyEjecucion = 0;
  $consulta = "SELECT proy.id_proyect FROM proyectos proy 
   LEFT JOIN banco_proyec_presupuesto pres 
    ON proy.id_proyect = pres.id_proyect 
    LEFT JOIN proyect_metas proymet 
    ON proy.id_proyect = proymet.cod_proy 
  LEFT JOIN metas met 
    ON proymet.id_meta = met.id_meta 
  LEFT JOIN ejes eje 
    ON met.ideje_metas = eje.ID 
    LEFT JOIN banco_proyec_financiacion finan
    ON proy.id_proyect = finan.id_proyect
  WHERE proy.estado='ACTIVO' and estado_proyect='Ejecutados'";

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
    $consulta .= "AND IFNULL(finan.origen, '') = '" . $_POST["CbFin"] . "'";
  }
  $consulta .= " GROUP BY proy.id_proyect";

  $resultado = mysqli_query($link, $consulta);

  if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
      $Consulta = "SELECT 
            SUM(pproy.total) total
           FROM
             proyectos proy 
             LEFT JOIN banco_proyec_presupuesto pproy
             ON proy.id_proyect=pproy.id_proyect 
           WHERE  proy.id_proyect='" . $fila['id_proyect'] . "'
           GROUP BY proy.id_proyect";


      $resultadoVP = mysqli_query($link, $Consulta);
      if (mysqli_num_rows($resultadoVP) > 0) {
        while ($filaVP = mysqli_fetch_array($resultadoVP)) {
          $TotProyEjecucion = $TotProyEjecucion + $filaVP['total'];
        }
      }
    }
  }

  $myDat->TotProyEjecucion = $TotProyEjecucion;



  ///CONSULTAR VALOR PROYECTOS EJECUTADOS
  $TotProyEjecutado = 0;
  $consulta = "SELECT proy.id_proyect FROM proyectos proy 
  LEFT JOIN banco_proyec_presupuesto pres 
   ON proy.id_proyect = pres.id_proyect 
   LEFT JOIN proyect_metas proymet 
   ON proy.id_proyect = proymet.cod_proy 
 LEFT JOIN metas met 
   ON proymet.id_meta = met.id_meta 
 LEFT JOIN ejes eje 
   ON met.ideje_metas = eje.ID 
   LEFT JOIN banco_proyec_financiacion finan
   ON proy.id_proyect = finan.id_proyect
 WHERE proy.estado='ACTIVO' and estado_proyect='Ejecutado'";

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
    $consulta .= "AND IFNULL(finan.origen, '') = '" . $_POST["CbFin"] . "'";
  }
  $consulta .= " GROUP BY proy.id_proyect";


  $resultado = mysqli_query($link, $consulta);
  if (mysqli_num_rows($resultado) > 0) {
    while ($filaPR = mysqli_fetch_array($resultado)) {

      $Consulta = "SELECT 
            SUM(pproy.total) total
           FROM
             proyectos proy 
             LEFT JOIN banco_proyec_presupuesto pproy
             ON proy.id_proyect=pproy.id_proyect 
           WHERE  proy.id_proyect='" . $filaPR['id_proyect'] . "'
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

  ///PRESUPUESTO GASTADO EN EJECUCION
  $Consulta = "SELECT IFNULL(SUM(vejec),0) veje FROM(
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
  WHERE proy.estado = 'ACTIVO' AND proy.estado_proyect='En Ejecucion' AND contr.estad_contrato IN ('Ejecucion','Ejecutado')";
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
    contratos WHERE estad_contrato='Ejecucion'
  GROUP BY num_contrato)
  GROUP BY contr.num_contrato) AS t";

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

// guardar resultados actuales
$consulta = "INSERT INTO temp_proy1 (idproy, fcre, valtot, mes)
SELECT idproy, fcre, SUM(val) valtot, MONTH(fcre) mes FROM(
    SELECT 
        proy.id_proyect idproy, proy.fcomp_pres fcre, IFNULL(SUM(pres.total),0) val
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
    WHERE proy.comp_pres='si' AND proy.estado='ACTIVO' AND estado_proyect='En Ejecucion'";

if ($_POST["CbSec"] != "") {
    $consulta .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
}
if ($_POST["CbEje"] != "") {
    $consulta .= " AND IFNULL(eje.ID, '') = '" . $_POST["CbEje"] . "'";
}
if ($_POST["CbVig"] != "") {
    $consulta .= " AND IFNULL(proy.vigenc_proyect, '') = '" . $_POST["CbVig"] . "'";
}
if ($_POST["CbFin"] != "") {
    $consulta .= " AND IFNULL(s.fuent, '') = '" . $_POST["CbFin"] . "'";
}

$consulta .= " GROUP BY proy.id_proyect
    ORDER BY proy.fec_crea_proyect ASC) t
    GROUP BY fcre";

 

mysqli_query($link, $consulta);

$rawPCvsPG = array(); //creamos un array

// Obtener meses con gastos
$gastosQuery = "SELECT DISTINCT MONTH(gast.fecha) mes
FROM gastos_contrato gast
left join contratos contr on  gast.contrato = contr.num_contrato
left join proyectos proy on contr.idproy_contrato = proy.id_proyect
WHERE gast.estado='ACTIVO'";
if ($_POST["CbSec"] != "") {
  $gastosQuery .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
}

$resultadoGastos = mysqli_query($link, $gastosQuery);

$mesesConGastos = [];
if (mysqli_num_rows($resultadoGastos) > 0) {
    while ($filaGasto = mysqli_fetch_array($resultadoGastos)) {
        $mesesConGastos[] = $filaGasto['mes'];
    }
}

sort($mesesConGastos);

foreach ($mesesConGastos as $mes) {
    // Acumular presupuesto hasta el mes actual
    $presupuestoQuery = "SELECT SUM(valtot) as valtot FROM temp_proy1 WHERE mes <= $mes";
    $resultadoPresupuesto = mysqli_query($link, $presupuestoQuery);
    $valtot = 0;
    if (mysqli_num_rows($resultadoPresupuesto) > 0) {
        $filaPresupuesto = mysqli_fetch_array($resultadoPresupuesto);
        $valtot = $filaPresupuesto['valtot'];
    }

    $TotProyEjecutado = $valtot;

    // Obtener gastos del mes actual
    $ConsultaCE = "SELECT SUM(valor) veje  FROM gastos_contrato gast
    LEFT JOIN contratos contr ON gast.contrato = contr.num_contrato
    LEFT JOIN proyectos proy ON contr.idproy_contrato = proy.id_proyect
    WHERE gast.estado='ACTIVO' AND MONTH(gast.fecha) = ".$mes." AND contr.id_contrato IN
      (SELECT
        MAX(id_contrato)
      FROM
        contratos WHERE num_contrato = contr.num_contrato
      GROUP BY num_contrato)";
   
    if ($_POST["CbSec"] != "") {
      $ConsultaCE .= " AND IFNULL(proy.secretaria_proyect, '') = '" . $_POST["CbSec"] . "'";
    }
    $resultadoCE = mysqli_query($link, $ConsultaCE);
    $gastosMes = 0;
    if (mysqli_num_rows($resultadoCE) > 0) {
        $filaCE = mysqli_fetch_array($resultadoCE);
        $gastosMes = $filaCE['veje'];
    }

    $TotContEjecutado += $gastosMes;

    $rawPCvsPG[] = array(
        "date" => date('Y-m', mktime(0, 0, 0, $mes, 1)),
        "value" => $TotProyEjecutado,
        "value2" => $TotContEjecutado
    );
}

  $myDat->rawPCvsPG = $rawPCvsPG;

  mysqli_query($link, "TRUNCATE TABLE temp_proy1");

  $myJSONDat = json_encode($myDat);
  echo $myJSONDat;
}


mysqli_close($link);
