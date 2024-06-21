<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query($link, "BEGIN");
mysqli_set_charset($link, 'utf8');
$flag = "s";


if ($_POST['acc'] == "1") {
    $myDat = new stdClass();

    $parFeCrea = explode("-", $_POST['txt_fecha_Cre']);
    $feCrea = $parFeCrea[2] . "-" . $parFeCrea[1] . "-" . $parFeCrea[0];

    $parFeMod = explode("-", $_POST['txt_fecMod']);
    $feModi = $parFeMod[2] . "-" . $parFeMod[1] . "-" . $parFeMod[0];

    $consulta = "INSERT INTO proyectos VALUES(null,'" . $_POST['txt_Cod'] . "','" . $feCrea . "',"
            . "'" . $feModi . "','" . $_POST['txt_Nomb'] . "','" . $_POST['CbTiplog'] . "','" . $_POST['DesCbTiplog'] . "',"
            . "'" . $_POST['CbSecre'] . "','" . $_POST['DesCbSecre'] . "','" . $_POST['CbCrono'] . "','" . $_POST['CbVige'] . "',"
            . "'" . $_POST['txt_CodProyAs'] . "','" . $_POST['txt_NombProyAs'] . "','" . $_POST['txt_FecAproProAso'] . "',"
            . "'" . $_POST['txt_Fecini'] . "','" . $_POST['txt_Plazo'] . "','" . $_POST['txt_vigenc'] . "',"
            . "'" . $_POST['txt_estaProye'] . "','" . $_POST['txt_elabo'] . "','" . $_POST['txt_IdProblema'] . "',"
            . "'" . $_POST['txt_ObjGenr'] . "','" . $_POST['txt_DesProy'] . "','" . $_POST['estado'] . "','0%','ACTIVO',"
            . "'" . $_POST['txt_FeciniProy'] . "','" . $_POST['txt_FecFinProy'] . "','" . $_POST['PreComp'] . "',"
            . "'" . $_POST['txt_fecha_ComPre'] . "','" . $_POST['Src_FileComp'] . "')";


    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta1 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='PROYECTOS'";
    $qc1 = mysqli_query($link, $consulta1);

    if (($qc1 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }

    $id_Ven = "";
    $sql = "SELECT MAX(id_proyect) AS id FROM proyectos";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Proy = $fila["id"];
        }
    }


    /////GUARDAR CAUSAS////////
    if (isset($_POST["Dat_Causas"])) {
        foreach ($_POST["Dat_Causas"] as $key => $val) {
            $consulta2 = "";
            $parCausa = explode("//", $_POST["Dat_Causas"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_causas VALUES(null,'" . $id_Proy . "','" . $parCausa[0] . "')";

            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 3;
            }
        }
    }

    /////GUARDAR EFECTOS////////

    if (isset($_POST["Dat_Efectos"])) {
        foreach ($_POST["Dat_Efectos"] as $key => $val) {
            $consulta2 = "";
            $parEfect = explode("//", $_POST["Dat_Efectos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_efectos VALUES(null,'" . $id_Proy . "','" . $parEfect[0] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 5;
            }
        }
    }

    /////GUARDAR OBJETIVOS ESPECIFICO////////

    if (isset($_POST["Dat_ObjEspec"])) {
        foreach ($_POST["Dat_ObjEspec"] as $key => $val) {
            $consulta2 = "";
            $parObjetEsp = explode("//", $_POST["Dat_ObjEspec"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_objespec VALUES(null,'" . $id_Proy . "','" . $parObjetEsp[0] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 7;
            }
        }
    }


    /////GUARDAR PRODUCTOS////////
    if (isset($_POST["Dat_Productos"])) {
        foreach ($_POST["Dat_Productos"] as $key => $val) {
            $consulta2 = "";
            $parProd = explode("//", $_POST["Dat_Productos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_productos VALUES(null,'" . $id_Proy . "','" . $parProd[0] . "','" . $parProd[1] . "','" . $parProd[2] . "','" . $parProd[3] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 9;
            }
        }
    }

    /////GUARDAR Población Objetivo////////
    if (isset($_POST["Dat_PobObjet"])) {
        foreach ($_POST["Dat_PobObjet"] as $key => $val) {
            $consulta2 = "";
            $parPobla = explode("//", $_POST["Dat_PobObjet"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_pobla VALUES(null,'" . $id_Proy . "','" . $parPobla[0] . "','" . $parPobla[1] . "','" . $parPobla[2] . "','" . $parPobla[3] . "','" . $parPobla[4] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 11;
            }
        }
    }

    /////GUARDAR COSTOS ASOCIADOS////////
    if (isset($_POST["Dat_CostAsoc"])) {
        foreach ($_POST["Dat_CostAsoc"] as $key => $val) {
            $consulta2 = "";
            $parCostos = explode("//", $_POST["Dat_CostAsoc"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_costos VALUES(null,'" . $id_Proy . "','" . $parCostos[0] . "','" . $parCostos[1] . "','" . $parCostos[2] . "','" . $parCostos[3] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 13;
            }
        }
    }


    /////GUARDAR ESTUDIOS////////
    if (isset($_POST["Dat_Estudios"])) {
        foreach ($_POST["Dat_Estudios"] as $key => $val) {
            $consulta2 = "";
            $parEstudi = explode("//", $_POST["Dat_Estudios"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_estudios VALUES(null,'" . $id_Proy . "','" . $parEstudi[0] . "','" . $parEstudi[1] . "','" . $parEstudi[2] . "','" . $parEstudi[3] . "','" . $parEstudi[4] . "')";
            //echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 15;
            }
        }
    }


    /////GUARDAR ACTIVIDADES////////
    if (isset($_POST["Dat_Actividades"])) {
        foreach ($_POST["Dat_Actividades"] as $key => $val) {
            $consulta2 = "";
            $parActiv = explode("//", $_POST["Dat_Actividades"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_actividades VALUES(null,'" . $id_Proy . "','" . $parActiv[0] . "','" . $parActiv[1] . "','" . $parActiv[2] . "'," . $parActiv[3] . ",'" . $parActiv[4] . "','" . $parActiv[5] . "','" . $parActiv[6] . "','" . $parActiv[7] . "','" . $parActiv[8] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 17;
            }
        }
    }


    /////GUARDAR FINANCIACION////////
    if (isset($_POST["Dat_Financiacion"])) {
        foreach ($_POST["Dat_Financiacion"] as $key => $val) {
            $consulta2 = "";
            $parFinan = explode("//", $_POST["Dat_Financiacion"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_financiacion VALUES(null,'" . $id_Proy . "','" . $parFinan[1] . "','" . $parFinan[2] . "'," . $parFinan[3] . ",'','" . $parFinan[0] . "')";
           
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 21;
            }
        }
    }


    /////GUARDAR PRESUPUESTO////////
    if (isset($_POST["Dat_Presupuesto"])) {
        foreach ($_POST["Dat_Presupuesto"] as $key => $val) {
            $consulta2 = "";
            $parPres = explode("//", $_POST["Dat_Presupuesto"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_presupuesto VALUES(null,'" . $id_Proy . "','" . $parPres[0] . "','" . $parPres[1] . "," . $parPres[2] . ",'')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 23;
            }
        }
    }

    /////GUARDAR INGRESOS////////
    if (isset($_POST["Dat_Ingresos"])) {
        foreach ($_POST["Dat_Ingresos"] as $key => $val) {
            $consulta2 = "";
            $parIngre = explode("//", $_POST["Dat_Ingresos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_ingresos VALUES(null,'" . $id_Proy . "','" . $parIngre[0] . "'," . $parIngre[1] . "," . $parIngre[2] . ")";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 25;
            }
        }
    }

    /////GUARDAR ANEXOS////////

    $carpetaOrigen = 'AnexosProyecto/';
    $carpetaDest = 'AnexosProyecto/' . $_SESSION['ses_complog'] . '/' . $_POST['txt_Cod'] . '/';
    if (!file_exists($carpetaDest)) {
        mkdir($carpetaDest, 0777, true);
    }

    if (isset($_POST["Dat_Anexos"])) {
        foreach ($_POST["Dat_Anexos"] as $key => $val) {
            $consulta2 = "";
            $parAnexo = explode("//", $_POST["Dat_Anexos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_anexos VALUES(null,'" . $id_Proy . "','" . $parAnexo[0] . "','" . $parAnexo[1] . "','" . $parAnexo[2] . "')";
            //   echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 27;
            }

            if (file_exists($carpetaOrigen . $parAnexo[2])) {
                if (file_exists($carpetaDest) || @mkdir($carpetaDest)) {
                    $carpetaOrigen = $carpetaOrigen . $parAnexo[2];
                    $carpetaDest = $carpetaDest . $parAnexo[2];
                    if (copy($carpetaOrigen, $carpetaDest)) {
                        unlink($carpetaOrigen);
                    }
                }
            }
        }
    }


    /////GUARDAR LOCALIZACION////////
    if (isset($_POST["Dat_Localiza"])) {
        foreach ($_POST["Dat_Localiza"] as $key => $val) {
            $consulta2 = "";
            $parLoca = explode("//", $_POST["Dat_Localiza"][$key]);

            $consulta2 = "INSERT INTO ubic_proyect VALUES(null,'" . $id_Proy . "','" . $parLoca[0] . "','" . $parLoca[1] . "','" . $parLoca[2] . "','" . $parLoca[3] . "','" . $parLoca[4] . "','" . $parLoca[5] . "')";
            //echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 8;
            }
        }
    }


    /////GUARDAR USUARIOS////////


    if (isset($_POST["Dat_Usu"])) {

        foreach ($_POST["Dat_Usu"] as $key => $val) {
            $consulta2 = "";
            $parUsu = explode("//", $_POST["Dat_Usu"][$key]);

            $consulta2 = "INSERT INTO usu_proyect VALUES(null,'" . $id_Proy . "','" . $parUsu[0] . "')";

            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 16;
            }
        }
    }


    /////GUARDAR METAS////////
    $consulta = "DELETE FROM proyect_metas WHERE cod_proy='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }
    /////GUARDAR METAS  ////////
    if (isset($_POST["Dat_Metas"])) {
        foreach ($_POST["Dat_Metas"] as $key => $val) {
            $consulta2 = "";
            $parMet = explode("//", $_POST["Dat_Metas"][$key]);


            $consulta2 = "INSERT INTO proyect_metas VALUES(null,'" . $id_Proy . "','" . $_POST['txt_Nomb'] . "','" . $parMet[0] . "','" . $parMet[1] . "','" . $parMet[2] . "','" . $parMet[3] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 10;
            }
        }
    }

    /////GUARDAR METAS PRODUCTO////////
    /////GUARDAR METAS  ////////
    if (isset($_POST["Dat_MetasP"])) {
        foreach ($_POST["Dat_MetasP"] as $key => $val) {
            $consulta2 = "";
            $parMet = explode("//", $_POST["Dat_MetasP"][$key]);

            $consulta2 = "INSERT INTO proyect_metasproducto VALUES(null,'" . $id_Proy . "','" . $_POST['txt_Nomb'] . "','" . $parMet[0] . "','" . $parMet[1] . "','" . $parMet[2] . "','" . $parMet[3] . "','" . $parMet[4] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 10;
            }
        }
    }

    ///GUARDAR IMAGENES////////

    $carpetaOrigen = 'GaleriaProyecto/';
    $carpetaDest = 'GaleriaProyecto/' . $_SESSION['ses_complog'] . '/' . $_POST['txt_Cod'] . '/';
    if (!file_exists($carpetaDest)) {
        mkdir($carpetaDest, 0777, true);
    }
    if (isset($_POST["Dat_Img"])) {
        foreach ($_POST["Dat_Img"] as $key => $val) {
            $consulta2 = "";
            $parimg = explode("//", $_POST["Dat_Img"][$key]);

            $consulta2 = "INSERT INTO proyecto_galeria VALUES(null,'" . $id_Proy . "','" . $parimg[0] . "','" . $parimg[1] . "','" . $_POST['txt_Cod'] . "','" . $parimg[2] . "','" . $parimg[3] . "')";

            $qc2 = mysqli_query($link, $consulta2);
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
    }
} else if ($_POST['acc'] == "2") {
    $myDat = new stdClass();
    $parFeCrea = explode("-", $_POST['txt_fecha_Cre']);
    $feCrea = $parFeCrea[2] . "-" . $parFeCrea[1] . "-" . $parFeCrea[0];

    $parFeMod = explode("-", $_POST['txt_fecMod']);
    $feModi = $parFeMod[2] . "-" . $parFeMod[1] . "-" . $parFeMod[0];

    $consulta = "UPDATE proyectos SET cod_proyect='" . $_POST['txt_Cod'] . "',fec_crea_proyect='" . $feCrea . "',"
            . "fulmod_proyect='" . $feModi . "',nombre_proyect='" . $_POST['txt_Nomb'] . "',tipol_proyect='" . $_POST['CbTiplog'] . "',dtipol_proyec='" . $_POST['DesCbTiplog'] . "',"
            . "secretaria_proyect='" . $_POST['CbSecre'] . "',dsecretar_proyect='" . $_POST['DesCbSecre'] . "',cron_proyect='" . $_POST['CbCrono'] . "',vigenc_proyect='" . $_POST['CbVige'] . "',"
            . "codproyasoc_proyect='" . $_POST['txt_CodProyAs'] . "',desproyasoc_proyect='" . $_POST['txt_NombProyAs'] . "',frso_proyeasoc='" . $_POST['txt_FecAproProAso'] . "',"
            . "fecha_iniproyaso='" . $_POST['txt_Fecini'] . "',plazo_ejeproyeaso='" . $_POST['txt_Plazo'] . "',vigenc_proyeaso='" . $_POST['txt_vigenc'] . "',"
            . "estado_proyeaso='" . $_POST['txt_estaProye'] . "',elab_proyect='" . $_POST['txt_elabo'] . "',idenproble_proyect='" . $_POST['txt_IdProblema'] . "',"
            . "objgen_proyect='" . $_POST['txt_ObjGenr'] . "',desc_proyect='" . $_POST['txt_DesProy'] . "',estado_proyect='" . $_POST['estado'] . "',"
            . "finiproy='" . $_POST['txt_FeciniProy'] . "',ffinproy='" . $_POST['txt_FecFinProy'] . "',comp_pres='" . $_POST['PreComp'] . "',"
            . "fcomp_pres='" . $_POST['txt_fecha_ComPre'] . "',docucomp_pres='" . $_POST['Src_FileComp'] . "' WHERE id_proyect='" . $_POST['id'] . "'";


    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_Proy = $_POST['id'];

    /////GUARDAR CAUSAS////////

    $consulta = "DELETE FROM banco_proyec_causas WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }

//          echo $_POST["Dat_Causas"];
    if (isset($_POST["Dat_Causas"])) {
        foreach ($_POST["Dat_Causas"] as $key => $val) {
            $consulta2 = "";
            $parCausa = explode("//", $_POST["Dat_Causas"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_causas VALUES(null,'" . $id_Proy . "','" . $parCausa[0] . "')";
//         echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 3;
            }
        }
    }

    /////GUARDAR EFECTOS////////

    $consulta = "DELETE FROM banco_proyec_efectos WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }



    if (isset($_POST["Dat_Efectos"])) {
        foreach ($_POST["Dat_Efectos"] as $key => $val) {
            $consulta2 = "";
            $parEfect = explode("//", $_POST["Dat_Efectos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_efectos VALUES(null,'" . $id_Proy . "','" . $parEfect[0] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 5;
            }
        }
    }

    /////GUARDAR OBJETIVOS ESPECIFICO////////

    $consulta = "DELETE FROM banco_proyec_objespec WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }
    if (isset($_POST["Dat_ObjEspec"])) {
        foreach ($_POST["Dat_ObjEspec"] as $key => $val) {
            $consulta2 = "";
            $parObjetEsp = explode("//", $_POST["Dat_ObjEspec"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_objespec VALUES(null,'" . $id_Proy . "','" . $parObjetEsp[0] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 7;
            }
        }
    }


    /////GUARDAR PRODUCTOS////////

    $consulta = "DELETE FROM banco_proyec_productos WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 8;
    }
    if (isset($_POST["Dat_Productos"])) {

        foreach ($_POST["Dat_Productos"] as $key => $val) {
            $consulta2 = "";
            $parProd = explode("//", $_POST["Dat_Productos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_productos VALUES(null,'" . $id_Proy . "','" . $parProd[0] . "','" . $parProd[1] . "','" . $parProd[2] . "','" . $parProd[3] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 9;
            }
        }
    }

    /////GUARDAR Población Objetivo////////
    $consulta = "DELETE FROM banco_proyec_pobla WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 10;
    }
    if (isset($_POST["Dat_PobObjet"])) {
        foreach ($_POST["Dat_PobObjet"] as $key => $val) {
            $consulta2 = "";
            $parPobla = explode("//", $_POST["Dat_PobObjet"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_pobla VALUES(null,'" . $id_Proy . "','" . $parPobla[0] . "','" . $parPobla[1] . "','" . $parPobla[2] . "','" . $parPobla[3] . "','" . $parPobla[4] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 11;
            }
        }
    }

    /////GUARDAR COSTOS ASOCIADOS////////
    $consulta = "DELETE FROM banco_proyec_costos WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 12;
    }
    if (isset($_POST["Dat_CostAsoc"])) {
        foreach ($_POST["Dat_CostAsoc"] as $key => $val) {
            $consulta2 = "";
            $parCostos = explode("//", $_POST["Dat_CostAsoc"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_costos VALUES(null,'" . $id_Proy . "','" . $parCostos[0] . "','" . $parCostos[1] . "','" . $parCostos[2] . "','" . $parCostos[3] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 13;
            }
        }
    }


    /////GUARDAR ESTUDIOS////////
    $consulta = "DELETE FROM banco_proyec_estudios WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }
    if (isset($_POST["Dat_Estudios"])) {
        foreach ($_POST["Dat_Estudios"] as $key => $val) {
            $consulta2 = "";
            $parEstudi = explode("//", $_POST["Dat_Estudios"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_estudios VALUES(null,'" . $id_Proy . "','" . $parEstudi[0] . "','" . $parEstudi[1] . "','" . $parEstudi[2] . "','" . $parEstudi[3] . "','" . $parEstudi[4] . "')";
            //echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 15;
            }
        }
    }


    /////GUARDAR ACTIVIDADES////////

    $consulta = "DELETE FROM banco_proyec_actividades WHERE id_proyecto='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 16;
    }
    if (isset($_POST["Dat_Actividades"])) {
        foreach ($_POST["Dat_Actividades"] as $key => $val) {
            $consulta2 = "";
            $parActiv = explode("//", $_POST["Dat_Actividades"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_actividades VALUES(null,'" . $id_Proy . "','" . $parActiv[0] . "','" . $parActiv[1] . "','" . $parActiv[2] . "'," . $parActiv[3] . ",'" . $parActiv[4] . "','" . $parActiv[5] . "','" . $parActiv[6] . "','" . $parActiv[7] . "','" . $parActiv[8] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 17;
            }
        }
    }


    /////GUARDAR FINANCIACION////////
    $consulta = "DELETE FROM banco_proyec_financiacion WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }
    if (isset($_POST["Dat_Financiacion"])) {
        foreach ($_POST["Dat_Financiacion"] as $key => $val) {
            $consulta2 = "";
            $parFinan = explode("//", $_POST["Dat_Financiacion"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_financiacion VALUES(null,'" . $id_Proy . "','" . $parFinan[1] . "','" . $parFinan[2] . "'," . $parFinan[3] . ",'" . $parFinan[4] . "','" . $parFinan[0] . "')";

            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 21;
            }
        }
    }


    /////GUARDAR PRESUPUESTO////////
    $consulta = "DELETE FROM banco_proyec_presupuesto WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 22;
    }
    if (isset($_POST["Dat_Presupuesto"])) {
        foreach ($_POST["Dat_Presupuesto"] as $key => $val) {
            $consulta2 = "";
            $parPres = explode("//", $_POST["Dat_Presupuesto"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_presupuesto VALUES(null,'" . $id_Proy . "','" . $parPres[0] . "'," . $parPres[1] . ",'" . $parPres[2] . "','')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 23;
            }
        }
    }

    /////GUARDAR INGRESOS////////
    $consulta = "DELETE FROM banco_proyec_ingresos WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 24;
    }
    if (isset($_POST["Dat_Ingresos"])) {
        foreach ($_POST["Dat_Ingresos"] as $key => $val) {
            $consulta2 = "";
            $parIngre = explode("//", $_POST["Dat_Ingresos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_ingresos VALUES(null,'" . $id_Proy . "','" . $parIngre[0] . "'," . $parIngre[1] . "," . $parIngre[2] . ")";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 25;
            }
        }
    }

    /////GUARDAR ANEXOS////////
    $consulta = "DELETE FROM banco_proyec_anexos WHERE id_proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 26;
    }


    $carpetaOrigen = 'AnexosProyecto/';
    $carpetaDest = 'AnexosProyecto/' . $_SESSION['ses_complog'] . '/' . $_POST['txt_Cod'] . '/';
    if (!file_exists($carpetaDest)) {
        mkdir($carpetaDest, 0777, true);
    }
    if (isset($_POST["Dat_Anexos"])) {
        foreach ($_POST["Dat_Anexos"] as $key => $val) {
            $consulta2 = "";
            $parAnexo = explode("//", $_POST["Dat_Anexos"][$key]);

            $consulta2 = "INSERT INTO banco_proyec_anexos VALUES(null,'" . $id_Proy . "','" . $parAnexo[0] . "','" . $parAnexo[1] . "','" . $parAnexo[2] . "')";
            //   echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 27;
            }

            if (file_exists($carpetaOrigen . $parAnexo[2])) {
                if (file_exists($carpetaDest) || @mkdir($carpetaDest)) {
                    $carpetaOrigen = $carpetaOrigen . $parAnexo[2];
                    $carpetaDest = $carpetaDest . $parAnexo[2];
                    if (copy($carpetaOrigen, $carpetaDest)) {
                        unlink($carpetaOrigen);
                    }
                }
            }
        }
    }


    /////GUARDAR LOCALIZACION////////
    $consulta = "DELETE FROM ubic_proyect WHERE proyect_ubi='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }
    if (isset($_POST["Dat_Localiza"])) {
        foreach ($_POST["Dat_Localiza"] as $key => $val) {
            $consulta2 = "";
            $parLoca = explode("//", $_POST["Dat_Localiza"][$key]);

            $consulta2 = "INSERT INTO ubic_proyect VALUES(null,'" . $id_Proy . "','" . $parLoca[0] . "','" . $parLoca[1] . "','" . $parLoca[2] . "','" . $parLoca[3] . "','" . $parLoca[4] . "','" . $parLoca[5] . "')";
            //echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 8;
            }
        }
    }


    /////GUARDAR USUARIOS////////

    $consulta = "DELETE FROM usu_proyect WHERE proyect='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }
    if (isset($_POST["Dat_Usu"])) {


        foreach ($_POST["Dat_Usu"] as $key => $val) {
            $consulta2 = "";
            $parUsu = explode("//", $_POST["Dat_Usu"][$key]);

            $consulta2 = "INSERT INTO usu_proyect VALUES(null,'" . $id_Proy . "','" . $parUsu[0] . "')";

            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 16;
            }
        }
    }


    /////GUARDAR METAS////////
    $consulta = "DELETE FROM proyect_metas WHERE cod_proy='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }
    /////GUARDAR METAS  ////////
    if (isset($_POST["Dat_Metas"])) {
        foreach ($_POST["Dat_Metas"] as $key => $val) {
            $consulta2 = "";
            $parMet = explode("//", $_POST["Dat_Metas"][$key]);


            $consulta2 = "INSERT INTO proyect_metas VALUES(null,'" . $id_Proy . "','" . $_POST['txt_Nomb'] . "','" . $parMet[0] . "','" . $parMet[1] . "','" . $parMet[2] . "','" . $parMet[3] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 10;
            }
        }
    }

    /////GUARDAR METAS PRODUCTO////////
    $consulta = "DELETE FROM proyect_metasproducto WHERE cod_proy='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }
    /////GUARDAR METAS  ////////
    if (isset($_POST["Dat_MetasP"])) {
        foreach ($_POST["Dat_MetasP"] as $key => $val) {
            $consulta2 = "";

            $parMet = explode("//", $_POST["Dat_MetasP"][$key]);

            $consulta2 = "INSERT INTO proyect_metasproducto VALUES(null,'" . $id_Proy . "','" . $_POST['txt_Nomb'] . "','" . $parMet[0] . "','" . $parMet[1] . "','" . $parMet[2] . "','" . $parMet[3] . "','" . $parMet[4] . "')";
            // echo $consulta2;
            $qc2 = mysqli_query($link, $consulta2);
            if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
                $success = 0;
                $error = 10;
            }
        }
    }

    ///GUARDAR IMAGENES////////

    $consulta = "DELETE FROM proyecto_galeria WHERE proyect_galeria='" . $id_Proy . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }

    $carpetaOrigen = 'GaleriaProyecto/';
    $carpetaDest = 'GaleriaProyecto/' . $_SESSION['ses_complog'] . '/' . $_POST['txt_Cod'] . '/';
    if (!file_exists($carpetaDest)) {
        mkdir($carpetaDest, 0777, true);
    }
    if (isset($_POST["Dat_Img"])) {
        foreach ($_POST["Dat_Img"] as $key => $val) {
            $consulta2 = "";
            $parimg = explode("//", $_POST["Dat_Img"][$key]);

            $consulta2 = "INSERT INTO proyecto_galeria VALUES(null,'" . $id_Proy . "','" . $parimg[0] . "','" . $parimg[1] . "','" . $_POST['txt_Cod'] . "','" . $parimg[2] . "','" . $parimg[3] . "')";

            $qc2 = mysqli_query($link, $consulta2);
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
    }
} else {

    $id_Proy = $_POST['cod'];
    $consulta = "SELECT * FROM contratos WHERE idproy_contrato='" . $id_Proy . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "n";
    }
    if ($flag == "s") {
        $consulta = "UPDATE proyectos SET estado='DELETE' WHERE id_proyect='" . $id_Proy . "' ";

        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo "no";
    }
}


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Proyecto " . $_POST['txt_Cod'] . "' ,'INSERCION', 'Proyectos.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Proyecto " . $_POST['txt_Cod'] . "' ,'ACTUALIZACION', 'Proyectos.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Proyecto
            " . $_POST['cod'] . "' ,'ELIMINACION', 'Proyectos.php')";
}



$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 4;
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    $myDat->Mensaje = "bien";
    $myDat->IdProy = $id_Proy;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
}

mysqli_close($link);
?>