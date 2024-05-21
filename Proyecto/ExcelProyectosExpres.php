<?php

session_start();

include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
date_default_timezone_set('America/Bogota');
$consulta = "SELECT * FROM proyectos_expres WHERE estado='ACTIVO'";

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
            ->setKeywords("Reporte de Proyectos")
            ->setCategory("Reporte excel");

    $tituloReporte = "Reporte de Proyectos";
    $titulosColumnas = array('Código ', 'Nombre ');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:B1');

// Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A3', $titulosColumnas[0])
            ->setCellValue('B3', $titulosColumnas[1]);



//Se agregan los datos de los alumnos
    $i = 4;
    while ($fila = mysqli_fetch_array($resultado)) {
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $fila['codigo'])
                ->setCellValue('B' . $i, $fila['nombre']);
        $i++;
    }
    
    

    $estiloInformacion = new PHPExcel_Style();

    $objPHPExcel->getActiveSheet()->getStyle("A3:B3")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E1E1E1')
                )
            )
    );
    
    
    $styleArray = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
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
    
    $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->applyFromArray($styleArray);


// Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Proyectos');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ReportedeEstadoProyectos.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    echo 'No hay Datos para Imprimir';
}
?>