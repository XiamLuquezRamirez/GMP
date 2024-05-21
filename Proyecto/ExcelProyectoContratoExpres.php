<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
date_default_timezone_set('America/Bogota');
$consulta = "SELECT proy.nombre nproy,
  contr.destipolg_contrato,
  contr.num_contrato,
  contr.obj_contrato,
  contr.vcontr_contrato,
  contr.vadic_contrato,
  contr.vfin_contrato,
  contr.descontrati_contrato,
  contr.durac_contrato,
  DATE_FORMAT(contr.fini_contrato, '%d/%m/%Y') fini,
   CASE WHEN contr.fsusp_contrato='00-00-0000' THEN '' ELSE DATE_FORMAT(contr.fsusp_contrato, '%d/%m/%Y')  END fsusp,
  CASE WHEN contr.frein_contrato='00-00-0000' THEN '' ELSE DATE_FORMAT(contr.frein_contrato, '%d/%m/%Y') END frein,
  contr.prorg_contrato,
  DATE_FORMAT(contr.ffin_contrato, '%d/%m/%Y') ffin,
  CASE WHEN contr.frecb_contrato='00-00-0000' THEN '' ELSE DATE_FORMAT(contr.frecb_contrato, '%d/%m/%Y') END freci,
  contr.dessuperv_contrato,
  contr.desinterv_contrato,
  contr.forpag_contrato,
  contr.veje_contrato,
  contr.porav_contrato,
  contr.estad_contrato FROM contratos_expres contr LEFT  JOIN proyectos_expres proy ON contr.idproy_contrato=proy.id";

$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    if (PHP_SAPI == 'cli')
        die('Este archivo solo se puede ver desde un navegador web');

    /** Se agrega la libreria PHPExcel */
    require_once '../lib/PHPExcel.php';

// Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();

// Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
            ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modifica
            ->setTitle("Reporte Excel con PHP y MySQL")
            ->setSubject("Reporte Excel con PHP y MySQL")
            ->setDescription("Reporte de Proyectos")
            ->setKeywords("Reporte Relacion Proyecto y Contratos")
            ->setCategory("Reporte excel");

    $tituloReporte = "Reporte Relacion Proyecto y Contratos";
    $titulosColumnas = array('ITEM ', 'PROYECTO', 'TIPOLOGÍA', 'N° DE CONTRATO', 'OBJETO DEL CONTRATO', 'VALOR DEL CONTRATO', 'ADICION',
                             'VR FINAL CONTRATO', 'CONTRATISTA', 'DURACION', 'FECHA  DE INICIO', 'FECHA DE SUSPENSION', 'FECHA DE REINICIO',
                             'PRORROGAS', 'FECHA DE FINALIZACIÓN', 'FECHA DE RECIBO', 'RESPONSABLE SUPERVISOR', 'RESPONSABLE INTERVENTORIA',
                             'FORMA DE PAGO', 'VR EJECUTADO', '% DE AVANCE', 'ESTADO');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:V1');

// Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A3', $titulosColumnas[0])
            ->setCellValue('B3', $titulosColumnas[1])
            ->setCellValue('C3', $titulosColumnas[2])
            ->setCellValue('D3', $titulosColumnas[3])
            ->setCellValue('E3', $titulosColumnas[4])
            ->setCellValue('F3', $titulosColumnas[5])
            ->setCellValue('G3', $titulosColumnas[6])
            ->setCellValue('H3', $titulosColumnas[7])
            ->setCellValue('I3', $titulosColumnas[8])
            ->setCellValue('J3', $titulosColumnas[9])
            ->setCellValue('K3', $titulosColumnas[10])
            ->setCellValue('L3', $titulosColumnas[11])
            ->setCellValue('M3', $titulosColumnas[12])
            ->setCellValue('N3', $titulosColumnas[13])
            ->setCellValue('O3', $titulosColumnas[14])
            ->setCellValue('P3', $titulosColumnas[15])
            ->setCellValue('Q3', $titulosColumnas[16])
            ->setCellValue('R3', $titulosColumnas[17])
            ->setCellValue('S3', $titulosColumnas[18])
            ->setCellValue('T3', $titulosColumnas[19])
            ->setCellValue('U3', $titulosColumnas[20])
            ->setCellValue('V3', $titulosColumnas[21]);



//Se agregan los datos de los alumnos
    $i = 4;
    $j=1;
    while ($fila = mysqli_fetch_array($resultado)) {
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $j)
                ->setCellValue('B' . $i, $fila['nproy'])
                ->setCellValue('C' . $i, $fila['destipolg_contrato'])
                ->setCellValue('D' . $i, $fila['num_contrato'])
                ->setCellValue('E' . $i, $fila['obj_contrato'])
                ->setCellValue('F' . $i, "$ ".number_format($fila['vcontr_contrato'], 2, ",", "."))
                ->setCellValue('G' . $i, "$ ".number_format($fila['vadic_contrato'], 2, ",", "."))
                ->setCellValue('H' . $i, "$ ".number_format($fila['vfin_contrato'], 2, ",", "."))
                ->setCellValue('I' . $i, $fila['descontrati_contrato'])
                ->setCellValue('J' . $i, $fila['durac_contrato'])
                ->setCellValue('K' . $i, $fila['fini'])
                ->setCellValue('L' . $i, $fila['fsusp'])
                ->setCellValue('M' . $i, $fila['frein'])
                ->setCellValue('N' . $i, $fila['prorg_contrato'])
                ->setCellValue('O' . $i, $fila['ffin'])
                ->setCellValue('P' . $i, $fila['freci'])
                ->setCellValue('Q' . $i, $fila['dessuperv_contrato'])
                ->setCellValue('R' . $i, $fila['desinterv_contrato'])
                ->setCellValue('S' . $i, $fila['forpag_contrato'])
                ->setCellValue('T' . $i, "$ ".number_format($fila['veje_contrato'], 2, ",", "."))
                ->setCellValue('U' . $i, $fila['porav_contrato'])
                ->setCellValue('V' . $i, $fila['estad_contrato']);
        $i++;
        $j++;
    }
    
    $estiloInformacion = new PHPExcel_Style();

    $objPHPExcel->getActiveSheet()->getStyle("A3:V3")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("A1:V1")->getFont()->setBold(true);
    

    
    
    $styleArray = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startcolor' => array(
            'argb' => 'FFA0A0A0',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
);
    $styletitle = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
   
);
    
    $objPHPExcel->getActiveSheet()->getStyle('A3:V3')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($styletitle);



// Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Contratos');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ReportedProyectosContratos2.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    echo 'No hay Datos para Imprimir';
}
?>