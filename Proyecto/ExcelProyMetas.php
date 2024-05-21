<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link,'utf8');
date_default_timezone_set('America/Bogota');
$consulta = "SELECT
  proy.cod_proyect codpory,
  proy.nombre_proyect nomproy,
  proy.dsecretar_proyect dsecr,
  proy.vigenc_proyect vigproy,
  proy.estado_proyect estproy,
  CONCAT(met.cod_meta,' - ',met.desc_meta) desmet,
  met.base_meta base,
  met.baseactual_metas baseact
FROM
  proyect_metas proymet
  LEFT JOIN proyectos proy
    ON proymet.cod_proy = proy.id_proyect
    LEFT JOIN metas met
    ON proymet.id_meta=met.id_meta
    WHERE proy.estado='ACTIVO'
    ORDER BY proy.cod_proyect ASC";
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
            ->setDescription("Reporte de Proyectos por Metas")
            ->setKeywords("Reporte de Proyectos por Metas")
            ->setCategory("Reporte excel");

    $tituloReporte = "Proyectos por Metas";
    $titulosColumnas = array('Código ', 'Nombre ', 'Secretaria ', 'Vigencia ', 'Estado ', 'Meta ', 'Base Inicial ', 'Base Actual ');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:H1');

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
            ->setCellValue('H3', $titulosColumnas[7]);



//Se agregan los datos de los alumnos
    $i = 4;
    while ($fila = mysqli_fetch_array($resultado)) {

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $fila['codpory'])
                ->setCellValue('B' . $i, $fila['nomproy'])
                ->setCellValue('C' . $i, $fila['dsecr'])
                ->setCellValue('D' . $i, $fila['vigproy'])
                ->setCellValue('E' . $i, $fila['estproy'])
                ->setCellValue('F' . $i, $fila['desmet'])
                ->setCellValue('G' . $i, $fila['base'])
                ->setCellValue('H' . $i, $fila['baseact']);
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

//    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTituloReporte);
//    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloTituloColumnas);
//    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:H" . ($i - 1));
//
//    $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setAutoSize(TRUE);
//
//    for ($i = 'A'; $i <= 'H'; $i++) {
//        $objPHPExcel->setActiveSheetIndex(0)
//                ->getColumnDimension($i)->setAutoSize(TRUE);
//    }

// Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Proyectos por Metas');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ReporteProyectosMetas.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    echo 'No hay Datos para Imprimir';
}
?>