<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link,'utf8');
date_default_timezone_set('America/Bogota');
$consulta = "SELECT
  desproy_contrato,
  destipolg_contrato,
  num_contrato,
  obj_contrato,
  vcontr_contrato,
  vadic_contrato,
  vfin_contrato,
  descontrati_contrato,
   durac_contrato,
  fini_contrato,
   CASE WHEN fsusp_contrato='0000-00-00' THEN '' ELSE fsusp_contrato END fsusp,
  CASE WHEN frein_contrato='0000-00-00' THEN '' ELSE frein_contrato END frein,
  prorg_contrato,
  ffin_contrato,
  CASE WHEN frecb_contrato='0000-00-00' THEN '' ELSE frecb_contrato END freci,
  dessuperv_contrato,
  desinterv_contrato,
  forpag_contrato,
  veje_contrato,
  porav_contrato,
  estad_contrato
FROM
  contratos
  WHERE estcont_contra='Verificado' AND id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato)";
$resultado = mysqli_query($link,$consulta);
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
            ->setDescription("Reporte de Programas")
            ->setKeywords("Reporte de Programas ")
            ->setCategory("Reporte excel");

 $tituloReporte = "Seguimiento de Contratos";
        $titulosColumnas = array('Proyecto ', 'Tipologia Contrato ', 'Número de Contrato ', 'Objeto ',
        'Valor del Contrato ', 'Adicion ', 'Vr. Final del Contrato ', 'Contratista ', 'Duracion ',
        'F. Inicio ', 'F. Suspension ', 'F. Reinicio ', 'Prorroga ', 'F. Finalización ',
        'F. Recibo ', 'Supervisor ', 'Interventor ', 'Forma de Pago ', 'Valor Ejecutado ',
        '% de Avance ', 'Estado ');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:U1');

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
            ->setCellValue('U3', $titulosColumnas[20]);



//Se agregan los datos de los alumnos
    $i = 4;
   while ($fila = mysqli_fetch_array($resultado)) {

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $fila['desproy_contrato'])
                ->setCellValue('B' . $i, $fila['destipolg_contrato'])
                ->setCellValue('C' . $i, $fila['num_contrato'])
                ->setCellValue('D' . $i, $fila['obj_contrato'])
                ->setCellValue('E' . $i, number_format($fila['vcontr_contrato'], 2, ",", "."))
                ->setCellValue('F' . $i, number_format($fila['vadic_contrato'], 2, ",", "."))
                ->setCellValue('G' . $i, number_format($fila['vfin_contrato'], 2, ",", "."))
                ->setCellValue('H' . $i, $fila['descontrati_contrato'])
                ->setCellValue('I' . $i, $fila['durac_contrato'])
                ->setCellValue('J' . $i, $fila['fini_contrato'])
                ->setCellValue('K' . $i, $fila['fsusp'])
                ->setCellValue('L' . $i, $fila['frein'])
                ->setCellValue('M' . $i, $fila['prorg_contrato'])
                ->setCellValue('N' . $i, $fila['ffin_contrato'])
                ->setCellValue('O' . $i, $fila['freci'])
                ->setCellValue('P' . $i, $fila['dessuperv_contrato'])
                ->setCellValue('Q' . $i, $fila['desinterv_contrato'])
                ->setCellValue('R' . $i, $fila['forpag_contrato'])
                ->setCellValue('S' . $i, number_format($fila['veje_contrato'], 2, ",", "."))
                ->setCellValue('T' . $i, $fila['porav_contrato'])
                ->setCellValue('U' . $i, $fila['estad_contrato']);
        $i++;
    }

    $estiloTituloReporte = array(
        'font' => array(
            'name' => 'Verdana',
            'bold' => true,
            'italic' => false,
            'strike' => false,
            'size' => 16,
            'color' => array(
                'rgb' => 'FFFFFF'
            )
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '3598dc')
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation' => 0,
            'wrap' => TRUE
        )
    );

    $estiloTituloColumnas = array(
        'font' => array(
            'name' => 'Arial',
            'bold' => true,
            'color' => array(
                'rgb' => 'FFFFFF'
            )
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 90,
            'startcolor' => array(
                'rgb' => 'b0cce0'
            ),
            'endcolor' => array(
                'argb' => '3598dc'
            )
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ));

    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
            array(
                'font' => array(
                    'name' => 'Arial',
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'FFFFFF')
                ),
                'borders' => array(
                    'left' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '000000'
                        )
                    ),
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '000000'
                        )
                    ),
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '000000'
                        )
                    ),
                    'right' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '000000'
                        )
                    )
                )
    ));

//    $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($estiloTituloReporte);
//    $objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($estiloTituloColumnas);
//    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:C" . ($i - 1));
//
//    $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setAutoSize(TRUE);
//
//    for ($i = 'A'; $i <= 'C'; $i++) {
//        $objPHPExcel->setActiveSheetIndex(0)
//                ->getColumnDimension($i)->setAutoSize(TRUE);
//    }

// Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Programas');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ReporteContratos.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    echo 'No hay Datos para Imprimir';
}
?>