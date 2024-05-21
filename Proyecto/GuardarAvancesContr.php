<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link,"BEGIN");
mysqli_set_charset($link,'utf8');
$flag = "s";


///GUARDAR IMAGENES////////

$consulta = "SELECT MAX(id_contrato) idproy FROM contratos WHERE num_contrato='" . $_POST['idproy'] . "'";
$resultado1 = mysqli_query($link,$consulta);
while ($fila = mysqli_fetch_array($resultado1)) {
    $id_cont = $fila["idproy"];
}

$consulta = "DELETE FROM contrato_galeria WHERE num_contrato_galeria='" . $_POST['idproy'] . "'";

$qc = mysqli_query($link,$consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 20;
}
$Tam_Img = $_POST['Long_Img'];
$carpetaOrigen = 'Galeria/';
$carpetaDest = 'Galeria/' . $_SESSION['ses_complog'] . '/' . $_POST['idproy']  . '/';
//echo $carpetaDest;
if (!file_exists($carpetaDest)) {
    mkdir($carpetaDest, 0777, true);
}
for ($i = 1; $i <= $Tam_Img; $i++) {
    $consulta2 = "";
    $parimg = explode("//", $_POST['idImg' . $i]);

    $consulta2 = "INSERT INTO contrato_galeria VALUES(null,'" . $id_cont. "','" . $parimg[0] . "','" . $parimg[1] . "','" . $_POST['idproy'] . "','" . $parimg[2] . "','" . $parimg[3] . "')";
    // echo $consulta2;
    $qc2 = mysqli_query($link,$consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 8;
    }

    //echo $carpetaOrigen . $parimg[1];
    if (file_exists($carpetaOrigen . $parimg[1])) {

        if (file_exists($carpetaDest) || @mkdir($carpetaDest)) {

            $carpetaOrigen = $carpetaOrigen . $parimg[1];
            $carpetaDest = $carpetaDest . $parimg[1];
            chmod($carpetaOrigen, 0777);

//                mkdir($carpetaOrigen, 0644, true);
            if (!@copy($carpetaOrigen, $carpetaDest)) {
                $errors = error_get_last();
                echo "COPY ERROR: " . $errors['type'];
                echo "<br />\n" . $errors['message'];
            } else {
                chmod($carpetaDest, '0644');
                chmod($carpetaOrigen, 0777);
                unlink($carpetaOrigen);
            }
        }
    }
}


if ($success == 0) {
    mysqli_query($link,"ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link,"COMMIT");
    echo "bien";
}

mysqli_close($link);
?>