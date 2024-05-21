<?php

session_start();
include "Conectar.php";
$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');

if ($_REQUEST["OPCION"] == "CONSULTARTOTALES") {
    $sql = "SELECT
                SUM(IF(g.vfin_contrato > 0,
                    g.vfin_contrato,
                    g.vcontr_contrato)) AS TOTAL_PROYECTOS,
                SUM(g.veje_contrato) AS TOTAL_EJECUCION_PROYECTOS
            FROM
                (SELECT
                    MAX(id_contrato) AS id_con,
                        vfin_contrato AS vfin,
                        num_contrato AS num,
                        vcontr_contrato AS vcon
                FROM
                    contratos
                WHERE
                    estcont_contra = 'Verificado'
                GROUP BY num_contrato) AS cons
                    INNER JOIN
                contratos g ON cons.num = g.num_contrato
                    INNER JOIN
                proyectos p ON p.id_proyect = g.idproy_contrato
            WHERE
                g.id_contrato = cons.id_con
                    AND p.estado = 'ACTIVO'";
    $campo = array();
    $Op1 = "No_Existe";
    $consulta = mysqli_query($link, $sql);
    $TOTAL_PROYECTOS = 0;
    $k = 1;
    while ($resp = $consulta->fetch_assoc()) {
        $Op1 = "Existe";
        $TOTAL_PROYECTOS = $resp['TOTAL_PROYECTOS'];
        $TOTAL_EJECUCION_PROYECTOS = $resp['TOTAL_EJECUCION_PROYECTOS'];
        $k++;
    }
    $PRESUPUESTO_INICIAL = 100000000000;
    $PRESUPUESTO_DISPONIBLE = $PRESUPUESTO_INICIAL - $TOTAL_PROYECTOS;
    $PRESUPUESTO_SIN_EJECUTAR = $PRESUPUESTO_INICIAL - $TOTAL_EJECUCION_PROYECTOS;
    $campo["Op1"] = $Op1;
    $campo["tam1"] = $k - 1;
    $campo["PRESUPUESTO_INICIAL"] = number_format($PRESUPUESTO_INICIAL, 0);
    $campo["PRESUPUESTO_DISPONIBLE"] = number_format($PRESUPUESTO_DISPONIBLE, 0);
    $campo["TOTAL_PROYECTOS"] = number_format($TOTAL_PROYECTOS, 0);
    $campo["TOTAL_EJECUCION_PROYECTOS"] = number_format($TOTAL_EJECUCION_PROYECTOS, 0);
    $campo["PRESUPUESTO_SIN_EJECUTAR"] = number_format($PRESUPUESTO_SIN_EJECUTAR, 0);

    $POREJEPROYECTOS = round(($TOTAL_EJECUCION_PROYECTOS * 100) / $TOTAL_PROYECTOS, 1);
    $campo["POREJEPROYECTOS"] = $POREJEPROYECTOS;

    $POREJEPRESUPUESTAL = round(($TOTAL_PROYECTOS * 100) / $PRESUPUESTO_INICIAL, 1);
    $campo["POREJEPRESUPUESTAL"] = $POREJEPRESUPUESTAL;

    $ejes = $_REQUEST["ejes"];
    $secretaria = $_REQUEST["secretaria"];
    $vigencia = $_REQUEST["vigencia"];
    $fuentes = $_REQUEST["fuentes"];
    

    $sqlsecre = "SELECT * FROM secretarias AS s WHERE s.estado_secretaria='ACTIVO' ";
    if ($secretaria != 'TODO') {
        $sqlsecre .= " AND s.idsecretarias='" . $secretaria . "' ";
    }
    $consultasecre = mysqli_query($link, $sqlsecre);
    $ASECRE = array();
    $SECRETA = [];
    $k = 1;
    while ($resp = $consultasecre->fetch_assoc()) {
        $ASECRE["ID"][$k] = $resp['idsecretarias'];
        $ASECRE["DESC"][$k] = $resp['des_secretarias'];
        $k++;
    }

    for ($i = 1; $i <= count($ASECRE["ID"]); $i++) {
        // $sqlproye = "SELECT * FROM proyectos AS p WHERE p.secretaria_proyect='" . $ASECRE['ID'][$i] . "' AND p.estado = 'ACTIVO' ";
        $sqlproye = "SELECT
                        *
                    FROM
                        proyectos AS p
                            LEFT JOIN
                        proyect_metas AS pm ON pm.cod_proy = p.id_proyect
                            LEFT JOIN
                        metas AS m ON pm.id_meta = m.id_meta
                            INNER JOIN
                        ejes AS e ON e.ID = m.ideje_metas
                            LEFT JOIN
                        banco_proyec_financiacion AS bpf ON p.id_proyect = bpf.id_proyect
                    WHERE p.secretaria_proyect='" . $ASECRE['ID'][$i] . "'
                    AND p.estado = 'ACTIVO' AND (p.estado_proyect='Ejecutado' OR p.estado_proyect='En Ejecucion') AND m.estado_metas = 'ACTIVO' ";

        if ($ejes != 'TODO') {
            $sqlproye .= " AND e.ID='" . $ejes . "' ";
        }
        if ($fuentes != 'TODO') {
            $sqlproye .= " AND bpf.origen='" . $fuentes . "' ";
        }
        $sqlproye .= " GROUP BY p.id_proyect ";

        // echo $sqlproye;die;
        $sumareal = 0;
        $consultaproyect = mysqli_query($link, $sqlproye);
        $totalPro = 0;
        while ($resp = $consultaproyect->fetch_assoc()) {
            $sql = "SELECT
                        g.id_contrato,
                        SUM(IF(g.vfin_contrato > 0,
                            g.vfin_contrato,
                            g.vcontr_contrato)) AS TOTAL_PROYECTOS,
                        SUM(g.veje_contrato) AS TOTAL_EJECUCION_PROYECTOS,
                        REPLACE(g.porav_contrato, '%', '') PORCECONTRA,
                        g.porproy_contrato AS PORCEPROY,
                        SUM((REPLACE(g.porav_contrato, '%', '') * 100) / g.porproy_contrato) AS PORCE,
                        SUM(g.porproy_contrato) AS SUMAPORCEPROY,
                        (SUM((REPLACE(g.porav_contrato, '%', '') * 100) / g.porproy_contrato) * SUM(g.porproy_contrato) / 100) AS PORREAL
                    FROM
                        (SELECT
                            MAX(id_contrato) AS id_con,
                                vfin_contrato AS vfin,
                                num_contrato AS num,
                                vcontr_contrato AS vcon
                        FROM
                            contratos
                        WHERE
                            estcont_contra = 'Verificado'
                        GROUP BY num_contrato) AS cons
                            INNER JOIN
                        contratos g ON g.id_contrato = cons.id_con
                    WHERE
                         g.idproy_contrato='" . $resp['id_proyect'] . "'
                    GROUP BY g.num_contrato ";
            $consultalarga = mysqli_query($link, $sql);
            $p = 1;
            $suma = 0;
            while ($respu = $consultalarga->fetch_assoc()) {
                $suma = $suma + (float) $respu['PORREAL'];
            }
            $sumareal += $suma;
            $totalPro++;
        }
        if ($totalPro == 0) {
            $totalPro = 1;
        }
        $divi = $sumareal / $totalPro;
        $ASECRE["FISICO"][$i] = number_format($divi, 2);
    }
    $tamASECRE = count($ASECRE["ID"]);
    $campo["AVANCEFISICO"] = $ASECRE;
    $campo["tamASECRE"] = $k - 1;
    mysqli_close($link);
    echo json_encode($campo);
}
