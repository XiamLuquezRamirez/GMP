<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link,'utf8');
date_default_timezone_set('America/Bogota');
$consulta = "SELECT
  cod_proyect,
  nombre_proyect,
  fec_crea_proyect,
  dtipol_proyec,
  dsecretar_proyect,
  vigenc_proyect,
  estado_proyect
FROM
  proyectos
  WHERE estado='ACTIVO'";
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
            ->setDescription("Reporte de Proyectos")
            ->setKeywords("Reporte de Proyectos ")
            ->setCategory("Reporte excel");

    $tituloReporte = "Proyectos";
    $titulosColumnas = array('Código ', 'Nombre ', 'Fecha Creacion ', 'Tipologia del Proyecto ', 'Secretaria ', 'Vigencia ', 'Estado ');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:G1');

// Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A3', $titulosColumnas[0])
            ->setCellValue('B3', $titulosColumnas[1])
            ->setCellValue('C3', $titulosColumnas[2])
            ->setCellValue('D3', $titulosColumnas[3])
            ->setCellValue('E3', $titulosColumnas[4])
            ->setCellValue('F3', $titulosColumnas[5])
            ->setCellValue('G3', $titulosColumnas[6]);



//Se agregan los datos de los alumnos
    $i = 4;
    while ($fila = mysqli_fetch_array($resultado)) {

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $fila['cod_proyect'])
                ->setCellValue('B' . $i, $fila['nombre_proyect'])
                ->setCellValue('C' . $i, $fila['fec_crea_proyect'])
                ->setCellValue('D' . $i, $fila['dtipol_proyec'])
                ->setCellValue('E' . $i, $fila['dsecretar_proyect'])
                ->setCellValue('F' . $i, $fila['vigenc_proyect'])
                ->setCellValue('G' . $i, $fila['estado_proyect']);
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

//    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);
//    $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($estiloTituloColumnas);
//    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:G" . ($i - 1));
//
//    $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setAutoSize(TRUE);
//
//    for ($i = 'A'; $i <= 'G'; $i++) {
//        $objPHPExcel->setActiveSheetIndex(0)
//                ->getColumnDimension($i)->setAutoSize(TRUE);
//    }

// Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Proyectos');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ReporteProyectos.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    echo 'No hay Datos para Imprimir';
}
?>