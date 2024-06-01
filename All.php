<?php

session_start();

include("Conectar.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$success = 1;
$error = "";
$link = conectar();

date_default_timezone_set('America/Bogota');

if ($_POST['ope'] == "CargarDatEmpresa") {

    $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".companias where companias_id='" . $_POST['cod'] . "'";

    $myDat = new stdClass();
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->companias_tid = $fila['companias_tid'];
            $myDat->companias_nit = $fila['companias_nit'];
            $myDat->companias_descripcion = $fila['companias_descripcion'];
            $myDat->companias_rlegal = $fila['companias_rlegal'];
            $myDat->companias_dep = $fila['companias_dep'];
            $myDat->companias_muni = $fila['companias_muni'];
            $myDat->companias_direccion = $fila['companias_direccion'];
            $myDat->companias_telefono1 = $fila['companias_telefono1'];
            $myDat->companias_fax = $fila['companias_fax'];
            $myDat->companias_email = $fila['companias_email'];
            $myDat->companias_login = $fila['companias_login'];
            $companias_login = $fila['companias_login'];
            $myDat->companias_img = $fila['companias_img'];
        }
    }


    /// localizacion
    $consulta = "SELECT
 dep.COD_DPTO coddep,
  CONCAT(dep.COD_DPTO,' - ',dep.NOM_DPTO) dedep,
  IFNULL(mun.COD_MUNI,'') codmun,
  IFNULL(CONCAT(mun.COD_MUNI,' - ',mun.NOM_MUNI),'') demun,
  IFNULL(corr.COD_CORREGI,'') codcorre,
  IFNULL(CONCAT(corr.COD_CORREGI,' - ',corr.NOM_CORREGI),'') decorr,
  IFNULL(bar.codigo,'') codbar,
  IFNULL(CONCAT(bar.codigo,' - ',bar.nombre),'') debar,
  ubi.lat_ubic lat, ubi.long_ubi longi
FROM
  " . $_SESSION['ses_BDBase'] . ".ubic_def_compa ubi
  LEFT JOIN " . $_SESSION['ses_BDBase'] . ".dpto dep
    ON ubi.depar_ubic = dep.COD_DPTO
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".muni mun
    ON ubi.muni_ubic=mun.COD_MUNI
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".corregi corr
    ON ubi.corr_ubic=corr.COD_CORREGI
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".barrios bar
    ON ubi.barr_ubic=bar.codigo" .
        "  WHERE compa_ubi= '" . $companias_login . "' ";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Locali = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Departamento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Municipio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Corregimiento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Barrio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contLocal = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contLocal++;
            $Tab_Locali .= "<tr class='selected' id='filaLoca" . $contLocal . "' ><td>" . $contLocal . "</td>";
            $Tab_Locali .= "<td>" . $fila["dedep"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["demun"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["decorr"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["debar"] . "</td>";
            $Tab_Locali .= "<td><input type='hidden' id='Loca" . $contLocal . "' "
                . "name='terce' value='" . $fila["coddep"] . "//" . $fila["codmun"] . "//" . $fila["codcorre"] . "//" . $fila["codbar"] . "//" . $fila["lat"] . "//" . $fila["longi"] . "' />"
                . "<a onclick=\"$.QuitarLocal('filaLoca" . $contLocal . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                . "<a onclick=\"$.VerLoca('" . $fila["lat"] . "//" . $fila["longi"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-map-marker\"></i> Mostrar</a>"
                . "</td></tr>";
        }
    }
    $Tab_Locali .= "</tbody>";
    $myDat->Tab_Locali = $Tab_Locali;
    $myDat->contLocal = $contLocal;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargUbica") {
    $myDat = new stdClass();
    /// localizacion
    $consulta = "SELECT
 dep.COD_DPTO coddep,
  CONCAT(dep.COD_DPTO,' - ',dep.NOM_DPTO) dedep,
  IFNULL(mun.COD_MUNI,'') codmun,
  IFNULL(CONCAT(mun.COD_MUNI,' - ',mun.NOM_MUNI),'') demun,
  IFNULL(corr.COD_CORREGI,'') codcorre,
  IFNULL(CONCAT(corr.COD_CORREGI,' - ',corr.NOM_CORREGI),'') decorr,
  IFNULL(bar.codigo,'') codbar,
  IFNULL(CONCAT(bar.codigo,' - ',bar.nombre),'') debar,
  ubi.lat_ubic lat, ubi.long_ubi longi
FROM
  " . $_SESSION['ses_BDBase'] . ".ubic_def_compa ubi
  LEFT JOIN " . $_SESSION['ses_BDBase'] . ".dpto dep
    ON ubi.depar_ubic = dep.COD_DPTO
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".muni mun
    ON ubi.muni_ubic=mun.COD_MUNI
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".corregi corr
    ON ubi.corr_ubic=corr.COD_CORREGI
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".barrios bar
    ON ubi.barr_ubic=bar.codigo" .
        "  WHERE compa_ubi= '" . $_SESSION['ses_complog'] . "' ";
    //echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Locali = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Departamento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Municipio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Corregimiento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Barrio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contLocal = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contLocal++;
            $Tab_Locali .= "<tr class='selected' id='filaLoca" . $contLocal . "' ><td>" . $contLocal . "</td>";
            $Tab_Locali .= "<td>" . $fila["dedep"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["demun"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["decorr"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["debar"] . "</td>";
            $Tab_Locali .= "<td><input type='hidden' id='Loca" . $contLocal . "' "
                . "name='terce' value='" . $fila["coddep"] . "//" . $fila["codmun"] . "//" . $fila["codcorre"] . "//" . $fila["codbar"] . "//" . $fila["lat"] . "//" . $fila["longi"] . "' />"
                . "<a onclick=\"$.QuitarLocal('filaLoca" . $contLocal . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                . "<a onclick=\"$.VerLoca('" . $fila["lat"] . "//" . $fila["longi"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-map-marker\"></i> Mostrar</a>"
                . "</td></tr>";
        }
    }
    $Tab_Locali .= "</tbody>";
    $myDat->Tab_Locali = $Tab_Locali;
    $myDat->contLocal = $contLocal;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargUsuarios") {
    $myDat = new stdClass();
    /// localizacion
    $consulta = "SELECT id_usuario id, cue_nombres nombre FROM " . $_SESSION['ses_BDBase'] . ".usuarios";
    //echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Usu = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre de Usuario\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contUsu = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contUsu++;
            $Tab_Usu .= "<tr class='selected' id='filaUsu" . $contUsu . "' ><td>" . $contUsu . "</td>";
            $Tab_Usu .= "<td>" . $fila["nombre"] . "</td>";
            $Tab_Usu .= "<td><input type='hidden' id='Usu" . $contUsu . "' "
                . "name='terce' value='" . $fila["id"] . "' />"
                . "<a onclick=\"$.QuitarUsu('filaUsu" . $contUsu . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Quitar</a>"
                . "</td></tr>";
        }
    }
    $Tab_Usu .= "</tbody>";
    $myDat->Tab_Usu = $Tab_Usu;
    $myDat->contUsu = $contUsu;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargPorcCont") {
    $myDat = new stdClass();
    /// localizacion

    $consulta = "select num_contrato, obj_contrato, porproy_contrato from contratos where idproy_contrato='" . $_POST['proy'] . "' group by num_contrato";
    //    echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Porc = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Contrato\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Porcentaje\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Porc' >\n";
    $port = 0;
    $ContPor = 1;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $port = $port + $fila['porproy_contrato'];
            $Tab_Porc .= "<tr class='selected' ><td title='" . $fila['obj_contrato'] . "'>" . $fila['num_contrato'] . "</td>";
            $Tab_Porc .= "<td style='text-align: right;'><div class='col-xs-3'><input type='text' name='PorCont[]' id='txt_PorEqui_" . $ContPor . "' data-id='" . $fila['num_contrato'] . "' onchange='$.updateporc(this.id);'  value='" . $fila['porproy_contrato'] . "' class='form-control'/></div><input type='hidden' id='Porc" . $ContPor . "' "
                . "name='terce' value='" . $fila['num_contrato'] . "//" . $fila["porproy_contrato"] . "' /></td>"
                . "</tr>";
            $ContPor++;
        }
    }
    if ($_POST['acc'] == 1) {
        $Tab_Porc .= "<tr class='selected' ><td >" . $_POST['Cont'] . "</td>";
        $Tab_Porc .= "<td style='text-align: right;'><div class='col-xs-3'><input type='text' id='txt_PorEqui_" . $ContPor . "' data-id='" . $_POST['Cont'] . "'  name='PorCont[]' onchange='$.updateporc(this.id);'   value='" . $_POST['porequ'] . "' class='form-control'/></div><input type='hidden' id='Porc" . $ContPor . "' "
            . "name='terce' value='' /></td>"
            . "</tr>";
    }


    $Tab_Porc .= "<tr class='selected' style='text-align: right;'><td><b>Porcentaje Total:</b></td>";
    $Tab_Porc .= "<td ><div class='col-xs-3'><label id='Porc_Tot'>" . $port . "%</label></div></td>"
        . "</tr>";



    $Tab_Porc .= "</tbody>";
    $myDat->Tab_Porc = $Tab_Porc;
    $myDat->ContPor = $ContPor;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "verfRespons") {
    $consulta = "SELECT * FROM responsables where cod_responsable='" . $_POST['cod'] . "' and estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfSuperv") {
    $consulta = "SELECT * FROM supervisores where cod_supervisores='" . $_POST['cod'] . "' and estado_supervisores='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfInterv") {
    $consulta = "SELECT * FROM interventores where cod_interventores='" . $_POST['cod'] . "' and estado_interventores='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "ValGrupo") {
    $consulta = "SELECT * FROM consecutivos where grupo='" . $_POST['grup'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfPerf") {

    $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".perfiles where nomperfil='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfProceso") {
    $consulta = "SELECT * FROM procesos where codi_proc='" . $_POST['cod'] . "' and estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "VerfProyect") {
    $consulta = "SELECT * FROM proyectos where cod_proyect='" . $_POST['cod'] . "' and estado='ACTIVO";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "VerfContrato") {
    $consulta = "SELECT * FROM contratos where num_contrato='" . $_POST['cod'] . "' AND estcont_contra<>'Eliminado';";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfTipologPtoyect") {
    $consulta = "SELECT * FROM tipologia_proyecto where cod_tipolo='" . $_POST['cod'] . "' and est_tipolo='ACTIVO'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfTipologContrat") {
    $consulta = "SELECT * FROM tipo_contratacion where CODIGO='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfEje") {
    $consulta = "SELECT * FROM ejes where CODIGO='" . $_POST['cod'] . "' and ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfEstrt") {
    $consulta = "SELECT * FROM componente where CODIGO='" . $_POST['cod'] . "' and ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfSecre") {
    $consulta = "SELECT * FROM secretarias where cod_secretarias='" . $_POST['cod'] . "' and estado_secretaria='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfProg") {
    $consulta = "SELECT * FROM programas where CODIGO='" . $_POST['cod'] . "' and ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfPolitInstit") {
    $consulta = "SELECT * FROM politicas_instit where COD_POLITICA='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfDepend") {
    $consulta = "SELECT * FROM dependencias where cod_dependencia='" . $_POST['cod'] . "' and estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "verfContratista") {
    $consulta = "SELECT * FROM contratistas where ident_contratis ='" . $_POST['cod'] . "' and estado_contratis='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "BusqEditResponsable") {

    $myDat = new stdClass();

    $consulta = "select * from responsables where id_responsable='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_responsable = $fila["cod_responsable"];
            $myDat->nom_responsable = $fila["nom_responsable"];
            $myDat->email_responsable = $fila["email_responsable"];
            $myDat->tel_responsable = $fila["tel_responsable"];
            $myDat->obs_responsable = $fila["obs_responsable"];
            $myDat->dependencia = $fila["dependencia"];
            $myDat->usuario = $fila["usuario"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEdperfil") {

    $myDat = new stdClass();

    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfiles where idperfil='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nomperfil = $fila["nomperfil"];
        }
    }

    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_plan where idperf_perfil_plan='" . $_POST["cod"] . "'";
    $perfil_plan = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_plan .= $fila["descrip_perfil_plan"] . "/" . $fila["visible_perfil_plan"] . "/" . $fila["add_perfil_plan"] . "/" . $fila["edit_perfil_plan"] . "/" . $fila["del_perfil_plan"] . ";";
        }
    }
    $myDat->perfil_plan = trim($perfil_plan, ';');


    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_proy where idperf_perfil_proy='" . $_POST["cod"] . "'";
    $perfil_proy = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_proy .= $fila["descrip_perfil_proy"] . "/" . $fila["visible_perfil_proy"] . "/" . $fila["add_perfil_proy"] . "/" . $fila["edit_perfil_proy"] . "/" . $fila["del_perfil_proy"] . ";";
        }
    }
    $myDat->perfil_proy = trim($perfil_proy, ';');


    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_eval where idperf_perfil_eval='" . $_POST["cod"] . "'";
    $perfil_eval = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_eval .= $fila["descrip_perfil_eval"] . "/" . $fila["visible_perfil_eval"] . "/" . $fila["add_perfil_eval"] . "/" . $fila["edit_perfil_eval"] . "/" . $fila["del_perfil_eval"] . ";";
        }
    }
    $myDat->perfil_eval = trim($perfil_eval, ';');


    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_inf where idperf_perfil_inf='" . $_POST["cod"] . "'";
    $perfil_inf = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_inf .= $fila["descrip_perfil_inf"] . "/" . $fila["visible_perfil_inf"] . "/" . $fila["add_perfil_inf"] . "/" . $fila["edit_perfil_inf"] . "/" . $fila["del_perfil_inf"] . ";";
        }
    }
    $myDat->perfil_inf = trim($perfil_inf, ';');


    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_para where idperf_perfil_para='" . $_POST["cod"] . "'";
    $perfil_para = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_para .= $fila["descrip_perfil_para"] . "/" . $fila["visible_perfil_para"] . "/" . $fila["add_perfil_para"] . "/" . $fila["edit_perfil_para"] . "/" . $fila["del_perfil_para"] . ";";
        }
    }
    $myDat->perfil_para = trim($perfil_para, ';');


    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_usu where idperf_perfil_usu='" . $_POST["cod"] . "'";
    $perfil_usu = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_usu .= $fila["descrip_perfil_usu"] . "/" . $fila["visible_perfil_usu"] . "/" . $fila["add_perfil_usu"] . "/" . $fila["edit_perfil_usu"] . "/" . $fila["del_perfil_usu"] . ";";
        }
    }
    $myDat->perfil_usu = trim($perfil_usu, ';');

    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".perfil_avan where idperf_perfil_ava='" . $_POST["cod"] . "'";
    $perfil_Ava = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perfil_Ava .= $fila["descrip_perfil_ava"] . "/" . $fila["visible_perfil_ava"] . "/" . $fila["add_perfil_ava"] . "/" . $fila["edit_perfil_ava"] . "/" . $fila["del_perfil_ava"] . ";";
        }
    }
    $myDat->perfil_ava = trim($perfil_Ava, ';');

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditConse") {
    $myDat = new stdClass();
    $consulta = "SELECT * FROM consecutivos where id_conse='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->estruct = $fila["estruct"];
            $myDat->descrip = $fila["descrip"];
            $myDat->grupo = $fila["grupo"];
            $myDat->inicio = $fila["inicio"];
            $myDat->actual = $fila["actual"];
            $myDat->vigencia = $fila["vigencia"];
            $myDat->observ = $fila["observ"];
            $myDat->estr_fin = $fila["estr_fin"];
            $myDat->digitos = $fila["digitos"];
        }


        $myJSONDat = json_encode($myDat);
        echo $myJSONDat;
    }
} else if ($_POST["ope"] == "ConConsecutivo") {

    $myDat = new stdClass();
    $StrAct = "";
    $est = "";
    $act = 0;
    $dig = "";
    $cons = 0;
    $vig = "";
    $flag = "n";

    $consulta = "SELECT * FROM consecutivos WHERE grupo='" . $_POST["tco"] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $est = $fila["estruct"];
            $act = $fila["inicio"];
            $cons = $fila["actual"];
            $vig = $fila["vigencia"];
            $dig = $fila["digitos"];
            $flag = "s";
        }
    }

    if ($act > $cons) {
        $cons = $act;
    }
    $cons += 1;

    if ($vig == "SI") {
        $StrAct = $est . "-" . date('Y') . "-" . sprintf("%0" . $dig . "d", $cons);
    } else {
        $StrAct = $est . "-" . sprintf("%0" . $dig . "d", $cons);
    }
    $myDat->StrAct = $StrAct;
    $myDat->cons = $cons;
    $myDat->flag = $flag;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditSuperv") {

    $myDat = new stdClass();

    $consulta = "select * from supervisores where id_supervisores='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_supervisores = $fila["cod_supervisores"];
            $myDat->nom_supervisores = $fila["nom_supervisores"];
            $myDat->correo_supervisores = $fila["correo_supervisores"];
            $myDat->telef_supervisores = $fila["telef_supervisores"];
            $myDat->obser_supervisores = $fila["obser_supervisores"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditInterv") {

    $myDat = new stdClass();

    $consulta = "select * from interventores where id_interventores='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_interventores = $fila["cod_interventores"];
            $myDat->nom_interventores = $fila["nom_interventores"];
            $myDat->correo_interventores = $fila["correo_interventores"];
            $myDat->telef_interventores = $fila["telef_interventores"];
            $myDat->obser_interventores = $fila["obser_interventores"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditSecre") {

    $myDat = new stdClass();

    $consulta = "select * from secretarias where idsecretarias='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_secretarias = $fila["cod_secretarias"];
            $myDat->des_secretarias = $fila["des_secretarias"];
            $myDat->responsanble_secretarias = $fila["responsanble_secretarias"];
            $myDat->correo_secretarias = $fila["correo_secretarias"];
            $myDat->obs_secretarias = $fila["obs_secretarias"];
            $myDat->ico_secretarias = $fila["ico_secretarias"];
            $myDat->color = $fila["color"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditProcesos") {

    $myDat = new stdClass();

    $consulta = "select * from procesos where id_proc='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->codi_proc = $fila["codi_proc"];
            $myDat->nomb_proc = $fila["nomb_proc"];
            $myDat->macropro_proc = $fila["macropro_proc"];
            $myDat->obse_proc = $fila["obse_proc"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditTipoProyecto") {

    $myDat = new stdClass();

    $consulta = "select * from tipologia_proyecto where id_tipolo='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_tipolo = $fila["cod_tipolo"];
            $myDat->des_tipolo = $fila["des_tipolo"];
            $myDat->obs_tipolo = $fila["obs_tipolo"];
            $myDat->img_tipolo = $fila["img_tipolo"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditTipoContrato") {

    $myDat = new stdClass();

    $consulta = "select * from tipo_contratacion where ID='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_tipolo = $fila["CODIGO"];
            $myDat->des_tipolo = $fila["NOMBRE"];
            $myDat->obs_tipolo = $fila["OBSERVACIONES"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BuscValMeta") {

    $myDat = new stdClass();

    $consulta = "select valor from metas_proyeccion where meta='" . $_POST["id"] . "' and anio='" . $_POST["anio"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->meta = $fila["valor"];
        }
    } else {
        $myDat->meta = "noexiste";
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsHistoMedIndi") {

    $myDat = new stdClass();
    $Tab_Indicad = "";

    $cont = 0;
    $consulta = "SELECT 
        met.id_meta idmet,
  met.desc_meta desmeta,
  mi.*
FROM
  indicadoresxmetas im 
  RIGHT JOIN mediindicador mi 
    ON im.meta = mi.id_meta 
  LEFT JOIN metas met ON mi.id_meta=met.id_meta
WHERE im.indicador='" . $_POST["id"] . "' GROUP BY idmet";
    //    echo $consulta;
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $Tab_Indicad .= "<div class='row'>"
                . " <div class='col-md-10'><h4 class='modal-titl'>" . $fila['desmeta'] . "</h4></div><input type='hidden' id='titu_met" . $fila['idmet'] . "' value='" . $fila['desmeta'] . "' class='form-control'  />"
                . " <div class='col-md-2'><div class='col-md-12' style='text-align: right'>
                                            <div class='form-group' >
                                                <label class='control-label'>&nbsp;</label>
                                                <a onclick=\"$.Graficar(" . $fila['idmet'] . ")\" class='btn green-meadow'>
                                                    <i class='fa fa-bar-chart-o'></i> Graficar
                                                </a>
                                            </div>
                                        </div></div>"
                . "</div>";

            $Tab_Indicad .= "<table class='table table-striped table-hover table-bordered' id='tab_HistIndi'><thead>";
            $Tab_Indicad .= "<td>\n" .
                "              <i ></i> Vigencia\n" .
                "          </td>\n";

            $consulta2 = "SELECT * FROM titu_variable_med WHERE idmed='" . $fila['id'] . "' GROUP BY titu_var ORDER BY id ASC";
            $resultado2 = mysqli_query($link, $consulta2);
            while ($fila2 = mysqli_fetch_array($resultado2)) {
                $Tab_Indicad .= "<td>\n" .
                    "              <i ></i>" . $fila2['titu_var'] . " \n" .
                    "          </td>\n";
            }

            $Tab_Indicad .= "<td>\n" .
                "              <i ></i> Meta\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i ></i> Indicador\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i ></i> Frecuecia Medida\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i ></i> Responsable\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i></i> Evidencias\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i></i> Estado\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i></i> Plan de Mejora\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <i></i> Indicador Despues del Plan de Mejora\n" .
                "          </td>\n" .
                "      </tr>\n" .
                "  </thead>";

            $Tab_Indicad .= "<tbody id='tb_Body_MedIndicadores'>";



            $consulta3 = "SELECT 
                            mi.*
                         FROM
                           indicadoresxmetas im 
                           RIGHT JOIN mediindicador mi 
                             ON im.meta = mi.id_meta 
                           LEFT JOIN metas met ON mi.id_meta=met.id_meta
                         WHERE im.indicador = '" . $_POST["id"] . "' AND im.meta='" . $fila['id'] . "' ORDER BY id ASC;";
            $resultado3 = mysqli_query($link, $consulta3);
            while ($fila3 = mysqli_fetch_array($resultado3)) {
                $Tab_Indicad .= "<tr class=\"selected\" id='filaIndicadores" . $cont . "' ><td>" . $fila['anio'] . "</td>";

                $consulta4 = "SELECT * FROM valor_variable_med WHERE idmed='" . $fila3['id'] . "' ORDER BY id ASC";
                $resultado4 = mysqli_query($link, $consulta4);
                while ($fila4 = mysqli_fetch_array($resultado4)) {
                    $Tab_Indicad .= "<td>" . $fila4['varlo_var'] . "</td>";
                }

                $Tab_Indicad .= "<td>" . $fila3['meta'] . "</td>";
                $resulindi = "";
                $consulta2 = "SELECT * FROM mediindicador_plan WHERE id_medi='" . $fila["id"] . "'";
                $resultado2 = mysqli_query($link, $consulta2);
                if (mysqli_num_rows($resultado2) > 0) {
                    while ($fila2 = mysqli_fetch_array($resultado2)) {
                        $resulindi = $fila2["resulindi"];
                    }
                }

                $Tab_Indicad .= "<td>" . $fila3['resulindi'] . "</td>";
                $Tab_Indicad .= "<td>" . $fila3['frecuencia'] . "</td>";
                $Tab_Indicad .= "<td>" . $fila3['responsable'] . "</td>";


                if ($fila3['evidencia'] === "") {
                    $evid = "Sin Evidencia";
                } else {
                    $parsrc = explode("*", $fila3['evidencia']);
                    $tamsrc = count($parsrc);
                    $j = 1;
                    for ($i = 0; $i < $tamsrc; $i++) {
                        $evid .= "<a href='" . $parsrc[$i] . "' target='_blank' class=\"btn default btn-xs blue\">"
                            . "<i class=\"fa fa-search\"></i> Evidencia " . $j . "</a>";
                        $j++;
                    }
                }
                $Tab_Indicad .= "<td>" . $evid . "</td>";
                $estado = $fila3["estado"];
                if ($estado == "Cumplida") {
                    $Tab_Indicad .= "<td style='color:#0DC142;'>Cumplida</td>";
                } else if ($estado == "Pendiente") {
                    $Tab_Indicad .= "<td style='color:#E73D4A;'>Pendiente</td>";
                }
                $plan_mejora = $fila3["plan_mejora"];

                if ($plan_mejora == "Si") {
                    $Tab_Indicad .= "<td><a  target='_blank' onclick=\"$.verResul('" . $fila3["id"] . "');\" class=\"btn default btn-xs blue\">Ver Plan de Mejora</a></td>";
                } else {
                    $Tab_Indicad .= "<td>" . $plan_mejora . "</td>";
                }

                $Tab_Indicad .= "<td>" . $resulindi . "</td>";

                $Tab_Indicad .= "</tr>";
            }



            $Tab_Indicad .= "</tbody></table>";

            $cont++;
        }
    }


    $Tab_Indicad .= "<tbody id='tb_Body_MedIndicadores'>";
    //    $Tab_Indicad .= "<tr class=\"selected\" id='filaIndicadores" . $contIndicad . "' ><td>" . $anio . "</td>";
    $Tab_Indicad .= "</tbody></table>";
    $myDat->CadIndi = $Tab_Indicad;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqDetalleMedIndiHist") {

    $myDat = new stdClass();
    $consulta = "SELECT
  ind.nomb_indi nombind,proy.nombre_proyect nomproy,ind.id_indi idindi,
  med.estado estmed, med.responsable resp,med.frecuencia frec,
  med.resulindi resul, ind.unid_indi uni, med.meta meta,
  med.anio anio,med.evidencia evi,med.fecha fech
FROM
  mediindicador med
  LEFT JOIN indicadores ind
  ON med.indicador = ind.id_indi
  LEFT JOIN  proyectos proy
  ON med.proy_ori=proy.id_proyect
  WHERE med.id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nombind = $fila["nombind"];
            $myDat->id_indi = $fila["idindi"];
            $myDat->nomproy = $fila["nomproy"];
            $myDat->estmed = $fila["estmed"];
            $myDat->resp = $fila["resp"];
            $myDat->frec = $fila["frec"];
            $myDat->resul = $fila["resul"];
            $myDat->uni = $fila["uni"];
            $myDat->meta = $fila["meta"];
            $myDat->anio = $fila["anio"];
            $evi = $fila["evi"];
            $myDat->fech = $fila["fech"];
        }
    }

    if ($evi === "") {
        $evid = "Sin Evidencia";
    } else {
        $parsrc = explode("*", $evi);
        $tamsrc = count($parsrc);
        $j = 1;
        for ($i = 0; $i < $tamsrc; $i++) {
            $evid .= "<a href='" . $parsrc[$i] . "' target='_blank' class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Evidencia " . $j . "</a>";
            $j++;
        }
    }

    $myDat->evid = $evid;

    $consulta = "SELECT
  act.id id,
  act.acti act,
  act.respo resp,
  act.estado esta
FROM
  evaluacionindicador ev
LEFT JOIN
actividaplaneadadas act
  ON ev.id=act.ideval
  LEFT JOIN responsables res
    ON act.respo = res.id_responsable WHERE ev.id_med='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);
    $Tab_Act = "<thead>
                <tr>
                    <td>
                        <i class='fa fa-angle-right'></i> #
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i> Actividad
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i> Responsable
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i> Estado
                    </td>
                </tr>
            </thead>"
        . "   <tbody id='tb_Body_Indicadores'>\n";

    $contACt = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contACt++;
            $Tab_Act .= "<tr class=\"selected\" id='filaAct" . $contACt . "' ><td>" . $contACt . "</td>";
            $Tab_Act .= "<td>" . $fila["act"] . "</td>";
            $Tab_Act .= "<td>" . $fila["resp"] . "</td>";
            $Tab_Act .= "<td>" . $fila["esta"] . "</td>";
        }
    }

    $Tab_Act .= "</tbody>";
    $myDat->tb_Activ = $Tab_Act;

    $consulta = "SELECT
  ind.nomb_indi nombind,proy.nombre_proyect nomproy,ind.id_indi idindi,
  med.estado estmed, med.responsable resp,med.frecuencia frec,
  med.resulindi resul, ind.unid_indi uni, med.meta meta,
  med.anio anio,med.evidencia evi,med.fecha fech
FROM
  mediindicador_plan med
  LEFT JOIN indicadores ind
  ON med.indicador = ind.id_indi
  LEFT JOIN  proyectos proy
  ON med.proy_ori=proy.id_proyect
  WHERE med.id_medi='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->estmedMej = $fila["estmed"];
            $myDat->respMej = $fila["resp"];
            $myDat->resulMej = $fila["resul"];
            $eviMej = $fila["evi"];
            $myDat->fechMej = $fila["fech"];
        }
    }
    $evid2 = "";
    if ($eviMej === "") {
        $evid2 = "Sin Evidencia";
    } else {
        $parsrc = explode("*", $eviMej);
        $tamsrc = count($parsrc);
        $j = 1;
        for ($i = 0; $i < $tamsrc; $i++) {
            $evid2 .= "<a href='" . $parsrc[$i] . "' target='_blank' class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Evidencia " . $j . "</a>";
            $j++;
        }
    }


    $myDat->evid2 = $evid2;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditRubro") {

    $myDat = new stdClass();

    $consulta = "select * from rubro_presupestal where id_rubro='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_rubro = $fila["cod_rubro"];
            $myDat->nom_rubro = $fila["nom_rubro"];
            $myDat->monto_rubro = $fila["monto_rubro"];
            $myDat->obs_rubro = $fila["obs_rubro"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditMet") {

    $myDat = new stdClass();

    $consulta = "select * from metas where id_meta='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $myDat->cod_meta = $fila["cod_meta"];
            $myDat->desc_meta = $fila["desc_meta"];
            $myDat->base_meta = $fila["base_meta"];
            $myDat->tipdato_metas = $fila["tipdato_metas"];
            $myDat->prop_metas = $fila["prop_metas"];
            $myDat->ideje_metas = $fila["ideje_metas"];
            $myDat->idcomp_metas = $fila["idcomp_metas"];
            $myDat->idprog_metas = $fila["idprog_metas"];
            $myDat->respo_metas = $fila["respo_metas"];
            $myDat->meta = $fila["meta"];
            $myDat->fuente_metas = $fila["fuente_metas"];
            $myDat->indice_metas = $fila["indice_metas"];
            $myDat->clasif_metas = $fila["clasif_metas"];
            $myDat->derec_metas = $fila["derec_metas"];
        }
    }


    $cont = 0;
    $CadProy = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>

    <td>
        <i class='fa fa-angle-right'></i> Año
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Valor
    </td>

    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody id='tb_Body_Proyeccion'>";

    $consulta = "select * from metas_proyeccion where meta=" . $_POST["cod"] . "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadProy .= '<tr class="selected" id="filaProyecc' . $cont . '" >';
            $CadProy .= "<td>" . $cont . "</td>";
            $CadProy .= "<td>" . $fila["anio"] . "</td>";
            $CadProy .= "<td>" . $fila["valor"] . "</td>";
            $CadProy .= "<td><input type='hidden' id='idProy" . $cont . "' name='idProy' value='" . $fila["anio"] . "//" . $fila["valor"] . "' /><a onclick=\"$.QuitarProyecc('filaProyecc" . $cont . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }
    $CadProy .= "</tbody>";

    $myDat->CadProy = $CadProy;
    $myDat->cont = $cont;

    ///////SEMAFORIZACION

    $consulta = "SELECT * FROM semaforizacion_metas where meta='" . $_POST["cod"] . "'";
    //echo $consulta;
    $unidMd = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->acepmax_indi = $fila["acepmax_indi"];
            $myDat->acepmin_indi = $fila["acepmin_indi"];
            $myDat->riemax_indi = $fila["riemax_indi"];
            $myDat->riemin_indi = $fila["riemin_indi"];
            $myDat->crimax_indi = $fila["crimax_indi"];
            $myDat->crimin_indi = $fila["crimin_indi"];
            $myDat->desacept = $fila["desacept"];
            $myDat->desriesg = $fila["desriesg"];
            $myDat->descriti = $fila["descriti"];
        }
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST['ope'] == "CargAdiciones") {

    $myDat = new stdClass();

    $CadAdicion = "";
    $cont = 0;
    $total = 0;
    $consulta = "select * from adicion_contrato where contrato='" . $_POST["cont"] . "' AND estado ='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $total += $fila["valor"];
            $CadAdicion .= '<tr class="selected" id="filaAdicion' . $cont . '" >';
            $CadAdicion .= "<td>" . $cont . "</td>";
            $CadAdicion .= "<td>" . $fila["fecha"] . "</td>";
            $CadAdicion .= "<td style='text-align: center;'>";
            if ($fila['url_documento'] == "") {
                $CadAdicion .= "Sin documento";
            } else {
                $CadAdicion .= "<a href='" . "../Proyecto/" . $fila['url_documento'] . "' target='_blank' class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i></a>";
            }

            $CadAdicion .= "</td>";
            $CadAdicion .= "<td>$ " . number_format($fila["valor"], 2, ",", ".") . "</td>";
            $CadAdicion .= "<td><input type='hidden' id='idAdicion" . $cont . "' name='idAdicion' value='" . $fila["fecha"] . "//" . $fila["valor"] . "' />
            <a onclick=\"$.EditarAdicion(" . $fila["id"] . ")\" class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-trash-o\"></i> Editar</a>
            <a onclick=\"$.QuitarAdicion(" . $fila["id"] . ")\" class=\"btn default btn-xs red\">"
                . "<i class='fa fa-trash-o'></i> Eliminar</a>
            </td></tr>";
        }
    }

    $myDat->CadAdicion = $CadAdicion;
    $myDat->total = $total;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargGastos") {

    $myDat = new stdClass();

    $CadGastos = "";
    $cont = 0;
    $total = 0;
    $consulta = "SELECT gc.id, cg.nombre, gc.fecha,gc.valor, gc.url_documento 
    FROM gastos_contrato gc
    LEFT JOIN categoria_gastos cg ON gc.categoria=cg.id
    WHERE gc.contrato = '" . $_POST["cont"] . "' AND gc.estado= 'ACTIVO'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $total += $fila["valor"];
            $CadGastos .= '<tr class="selected" id="filaGasto' . $cont . '" >';
            $CadGastos .= "<td>" . $cont . "</td>";
            $CadGastos .= "<td>" . $fila["fecha"] . "</td>";
            $CadGastos .= "<td>" . $fila["nombre"] . "</td>";
            $CadGastos .= "<td style='text-align: center;'>";
            if ($fila['url_documento'] == "") {
                $CadGastos .= "Sin documento";
            } else {
                $CadGastos .= "<a href='" . "../Proyecto/" . $fila['url_documento'] . "' target='_blank' class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i></a>";
            }

            $CadGastos .= "</td>";
            $CadGastos .= "<td>$ " . number_format($fila["valor"], 2, ",", ".") . "</td>";
            $CadGastos .= "<td>
            <a onclick=\"$.EditarGasto(" . $fila["id"] . ")\" class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-trash-o\"></i> Editar</a>
            <a onclick=\"$.QuitarGasto(" . $fila["id"] . ")\" class=\"btn default btn-xs red\">"
                . "<i class='fa fa-trash-o'></i> Eliminar</a>
            </td></tr>";
        }
    }

    $myDat->CadGastos = $CadGastos;
    $myDat->total = $total;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "editAdicion") {
    $myDat = new stdClass();
    $consulta = "SELECT * FROM adicion_contrato WHERE id = " . $_POST['idAdi'];

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fecha = $fila["fecha"];
            $myDat->valor = $fila["valor"];
            $myDat->url_documento = $fila["url_documento"];
        }
    }

    $consulta = "SELECT da.origen_financiacion,fu.nombre,da.gastos_presupuesto, da.desc_gasto, da.valor  FROM detalle_adicion da
    LEFT JOIN fuentes fu on da.origen_financiacion = fu.id
     WHERE da.adicion = " . $_POST['idAdi'];
    $resultado1 = mysqli_query($link, $consulta);
    $tabDetAddiciones = "";
    $cont = 0;
    $contTotal = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila1 = mysqli_fetch_array($resultado1)) {
            $cont++;
            $contTotal += $fila1['valor'];
            $tabDetAddiciones .= '<tr class="selected" id="filaPresup' . $cont . '">';
            $tabDetAddiciones .= '<td>' . $cont . '</td>';
            $tabDetAddiciones .= '<td>' . $fila1['nombre'] . '</td>';
            $tabDetAddiciones .= '<td>' . $fila1['gastos_presupuesto'] . ' - ' . $fila1['desc_gasto'] . '</td>';
            $tabDetAddiciones .= '<td>' . number_format($fila1['valor'], 2, ",", ".") . '</td>';
            $tabDetAddiciones .= '<td><input type="hidden" id="idDetAdicion' . $cont . '" value="' . $fila1['origen_financiacion'] . '//' . $fila1['gastos_presupuesto'] . '//' . $fila1['desc_gasto'] . '//' . $fila1['valor'] . '" /><a data-conse="filaPresup' . $cont . '" data-valor="' . $fila1['valor'] . '" onclick="$.QuitardetAdicion(this)" class="btn default btn-xs red"><i class="fa fa-trash-o"></i> Quitar</a></td>';
            $tabDetAddiciones .= '</tr>';
        }
    }

    $myDat->cont = $cont;
    $myDat->contTotal = $contTotal;
    $myDat->tabDetAddiciones = $tabDetAddiciones;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "editGasto") {
    $myDat = new stdClass();
    $consulta = "SELECT * FROM gastos_contrato WHERE id = " . $_POST['idGast'];

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fecha = $fila["fecha"];
            $myDat->categoria = $fila["categoria"];
            $myDat->descripcion = $fila["descripcion"];
            $myDat->valor = $fila["valor"];
            $myDat->url_documento = $fila["url_documento"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargHisContr") {

    $myDat = new stdClass();
    $contrato = "";
    $cont = 0;
    $consulta = "SELECT
  id_contrato,
  num_contrato,
  obj_contrato,
  vadic_contrato,
  vfin_contrato,
  veje_contrato,
  CASE WHEN fsusp_contrato='0000-00-00' THEN '' ELSE fsusp_contrato END fsusp_contrato,
  CASE WHEN frein_contrato='0000-00-00' THEN '' ELSE frein_contrato END frein_contrato,
  prorg_contrato,
  CASE WHEN ffin_contrato='0000-00-00' THEN '' ELSE ffin_contrato END ffin_contrato,
  CASE WHEN frecb_contrato='0000-00-00' THEN '' ELSE frecb_contrato END frecb_contrato,
  estad_contrato,
  porav_contrato
FROM
  contratos
WHERE num_contrato='" . $_POST['cod'] . "' ORDER BY id_contrato ASC ";
    //echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $cad = "<table  class=\"table table-bordered table-striped table-condensed flip-content\" role=\"grid\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i ></i> <b>#</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>V. Adicion</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>V. Final</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>V. Ejecutado</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Fec. Suspensión</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Fec. Reinicio</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Prorroga</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Fec. Finalización:</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Fec. Recibo:</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>% Avance</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Estado</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Acci&oacute;n</b>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";



    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    $contador = 0;
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $contador++;
            $cod = $fila["id_contrato"];
            $contrato = $fila["num_contrato"] . " - " . $fila["obj_contrato"];
            $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $contador . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . "$ " . number_format($fila["vadic_contrato"], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "$ " . number_format($fila["vfin_contrato"], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "$ " . number_format($fila["veje_contrato"], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["fsusp_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["frein_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["prorg_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["ffin_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["frecb_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<div class='progress progress-striped active'>"
                . "						<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: " . $fila['porav_contrato'] . "'>"
                . "							<span >"
                . "							" . $fila['porav_contrato'] . " Completado (success) </span>"
                . "						</div>"
                . "					</div>"
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["estad_contrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>"
                . "<td>"
                . "<a onclick=\"$.VerHistContrat('" . $cod . "')\" class='btn default btn-xs blue'>" .
                "<i class='fa fa-search'></i> Ver "
                . "</a>"
                . "</td>";
            if ($cod == $_POST['id']) {
                $cad .= "<td >"
                    . "<a   onclick=\"$.AditAvaces('" . $cod . "')\" class='btn default btn-xs purple'>" .
                    "<i class='fa fa-edit'></i> Editar"
                    . "</a>"
                    . "</td>"
                    . "<td>"
                    . "<a  onclick=\"$.deletHistContr('" . $cod . "')\" class='btn default btn-xs red'>" .
                    "<i class='fa fa-trash-o'></i> Eliminar "
                    . "</a>"
                    . "</td>";
            }


            $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
        }
    }


    $cad .= "</tbody>"
        . "</table>";


    $myDat->Cad = $cad;
    $myDat->contrato = $contrato;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargMetas") {

    $myDat = new stdClass();

    $cont = 0;
    $consulta = "SELECT
  met.id_meta id,
  met.cod_meta cod,
  met.desc_meta descr,
  met.base_meta base,
  met.des_prog_metas prog,
  promet.nom_proy nproy,
  promet.cod_proy codproy
FROM
  proyect_metas promet
  LEFT JOIN metas met
    ON promet.id_meta = met.id_meta
WHERE cod_proy='" . $_POST['cod'] . "' ";
    // echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i ></i> <b>#</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Código</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Descripción</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Base</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Programa</b>"
        . "</th>"
        . "<th>"
        . "<i ></i> <b>Acci&oacute;n</b>"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";



    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    $contador = 0;
    $nproy = "";
    $idproy = "";
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $contador++;
            $cod = $fila["id"];
            $nproy = $fila["nproy"];
            $idproy = $fila["codproy"];
            $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $contador . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["cod"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["descr"] . "" . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["base"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["prog"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<table>"
                . "<tr>";
            if ($_SESSION['GesProyAMe'] == "s") {
                $cad .= "<td>"
                    . "<a  onclick=\"$.MedirMeta('" . $cod . "')\" class='btn default btn-xs purple'>" .
                    "<i class='fa fa-edit'></i> Medir"
                    . "</a>"
                    . "</td>";
            }
            if ($_SESSION['GesProyVMe'] == "s") {
                $cad .= "<td>"
                    . "<a onclick=\"$.VerDetMeta('" . $cod . "')\" class='btn default btn-xs blue'>" .
                    "<i class='fa fa-search'></i> Ver "
                    . "</a>"
                    . "</td>";
            }
            $cad .= "</tr>"
                . "</table>"
                . "</td>"
                . "</tr>";
        }
    }


    $cad .= "</tbody>"
        . "</table>";


    $myDat->Cad = $cad;
    $myDat->nproy = $nproy;
    $myDat->idproy = $idproy;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "GrafIndicadores") {

    // $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT id,anio,meta,resulindi,frecuencia FROM mediindicador WHERE indicador='" . $_POST["id"] . "' and id_meta='" . $_POST["met"] . "'  order by anio ASC ";
    //echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $anio = $fila['anio'];
            $resulindi = $fila['resulindi'];
            $meta = $fila['meta'];
            $fre = $fila['frecuencia'];

            $consulta2 = "SELECT * FROM mediindicador_plan WHERE id_medi='" . $fila["id"] . "'";
            //    echo $consulta2;
            $resultado2 = mysqli_query($link, $consulta2);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $anio = $fila2['anio'];
                    $resulindi = $fila2['resulindi'];
                    $meta = $fila2['meta'];
                    $fre = $fila2['frecuencia'];
                }
            }

            $rawdata[] = array(
                "anio" => $anio,
                "anio2" => $anio . " " . $fre,
                "resulindi" => $resulindi,
                "meta" => $meta
            );
        }
    }
    echo json_encode($rawdata);
    //   $myDat = json_encode($rawdata);
    //    echo $myDat;
} else if ($_POST['ope'] == "SumaFecha") {

    $myDat = new stdClass();

    $fechaInicial = $_POST['fei'];
    $suma = "";
    if ($_POST['tie'] == "Dia(s)") {
        $suma = $_POST['nsu'] . " day";
    } else if ($_POST['tie'] == "Mes(es)") {
        $suma = $_POST['nsu'] . " month";
    } else if ($_POST['tie'] == "Año(s)") {
        $suma = $_POST['nsu'] . " year";
    }


    $fecha = !empty($fechaInicial) ? $fechaInicial : date('Y-m-d');
    $nuevaFecha = strtotime($suma, strtotime($fecha));
    $nuevaFecha = date('Y-m-d', $nuevaFecha);

    $myDat->nuevaFecha = $nuevaFecha;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CambioVariables") {

    //    $id = $_POST['id'];
    //    $val = $_POST['val'];

    $myDat = new stdClass();
    $Formu = "";
    $r = explode("(", $_POST['form']);
    if (isset($r[1])) {
        $r = explode(")", $r[1]);
        $myDat->Form = $r[0];
        // return $r[0];
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaDetMeta") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM metas where id_meta='" . $_POST["cod"] . "'";
    //echo $consulta;
    $unidMd = "";
    $carg = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_meta = $fila["cod_meta"];
            $myDat->desc_meta = $fila["desc_meta"];
            $myDat->base_meta = $fila["base_meta"];
            $myDat->prop_metas = $fila["prop_metas"];
            $myDat->des_eje_metas = $fila["des_eje_metas"];
            $myDat->des_comp_metas = $fila["des_comp_metas"];
            $myDat->des_prog_metas = $fila["des_prog_metas"];
            $myDat->meta = $fila["meta"];
            $resp_Meta = $fila["respo_metas"];
        }
    }


    $consulta2 = "SELECT des_dependencia FROM dependencias WHERE iddependencias IN (" . $resp_Meta . ")";
    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $carg = $carg . $fila2["des_dependencia"] . ', ';
        }
    }

    $myDat->resp_Met = trim($carg, ', ');


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsPresSecret") {

    $myDat = new stdClass();

    $consulta = "SELECT SUM(valor) psec FROM presupuesto_secretarias WHERE id_secretaria='" . $_POST["sec"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->PS = $fila["psec"];
        }
    }


    $consulta2 = "SELECT SUM(PT) totpr FROM( SELECT IFNULL(SUM(pp.total),'0') PT FROM 
    proyectos proy LEFT JOIN banco_proyec_presupuesto pp ON proy.id_proyect = pp.id_proyect
    WHERE proy.secretaria_proyect='" . $_POST["sec"] . "' AND proy.estado='ACTIVO' GROUP BY proy.cod_proyect) AS t";

    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $myDat->TPP = $fila2["totpr"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaDetMeta2") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM metas where id_meta='" . $_POST["cod"] . "'";
    //echo $consulta;
    $unidMd = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_meta = $fila["cod_meta"];
            $myDat->id_meta = $fila["id_meta"];
            $myDat->desc_meta = $fila["desc_meta"];
            $myDat->base_meta = $fila["base_meta"];
            $myDat->unimedida = $fila["tipdato_metas"];
            $myDat->baseAct_meta = $fila["baseactual_metas"];
            $myDat->prop_metas = $fila["prop_metas"];
            $myDat->des_eje_metas = $fila["des_eje_metas"];
            $myDat->des_comp_metas = $fila["des_comp_metas"];
            $myDat->des_prog_metas = $fila["des_prog_metas"];
            $resp_Meta = $fila["respo_metas"];
        }
    }

    $Contr = "<option value=' '>Seleccione...</option>";

    $consulta = "SELECT * FROM contratos WHERE idproy_contrato='" . $_POST['idp'] . "' GROUP BY num_contrato";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Contr .= "<option value='" . $fila["id_contrato"] . "'>" . $fila["num_contrato"] . " - " . $fila["obj_contrato"] . "</option>";
        }
    }

    $myDat->Contr = $Contr;
    $carg = "";
    $consulta2 = "SELECT des_dependencia FROM dependencias WHERE iddependencias IN (" . $resp_Meta . ")";

    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $carg = $carg . $fila2["des_dependencia"] . ', ';
        }
    }

    $myDat->resp_Met = trim($carg, ', ');

    $cont = 0;
    $CadMedi = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> <b>#</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Fecha</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Base</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Medicion</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Resultado</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Origen</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Acción</b>
    </td>
</tr>
</thead>
<tbody id='tb_Body_Medicion'>";

    $consulta = "select * from medir_indmeta where idmeta_indmeta=" . $_POST["cod"] . "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadMedi .= '<tr class="selected" id="filaMedi' . $cont . '" >';

            $parcont = explode("-", $fila["desc_origen"]);

            $CadMedi .= "<td>" . $cont . "</td>";
            $CadMedi .= "<td>" . $fila["fmed_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $fila["base_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $fila["med_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $fila["resul_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $parcont[0] . "</td>";

            $CadMedi .= "<td><input type='hidden' id='Medi" . $cont . "' name='idProy' value='" . $fila["fmed_indmeta"] . "//" . $fila["base_indmeta"] . "//" . $fila["tend_indmeta"] . "//" . $fila["med_indmeta"] . "//" . $fila["resul_indmeta"] . "//" . $fila["origen_indmeta"] . "//" . $fila["desc_origen"] . "' /><a onclick=\"$.QuitarMedi('filaMedi" . $cont . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $CadMedi .= "</tbody>";

    $myDat->CadMedi = $CadMedi;
    $myDat->cont = $cont;



    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "VerDetMeta") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM metas where id_meta='" . $_POST["cod"] . "'";
    //echo $consulta;
    $unidMd = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_meta = $fila["cod_meta"];
            $myDat->id_meta = $fila["id_meta"];
            $myDat->desc_meta = $fila["desc_meta"];
            $myDat->base_meta = $fila["base_meta"];
            $myDat->unimedida = $fila["tipdato_metas"];
            $myDat->baseAct_meta = $fila["baseactual_metas"];
            $myDat->prop_metas = $fila["prop_metas"];
            $myDat->des_eje_metas = $fila["des_eje_metas"];
            $myDat->des_comp_metas = $fila["des_comp_metas"];
            $myDat->des_prog_metas = $fila["des_prog_metas"];
            $resp_Meta = $fila["respo_metas"];
        }
    }


    $consulta2 = "SELECT des_dependencia FROM dependencias WHERE iddependencias IN (" . $resp_Meta . ")";
    //  echo $consulta2;
    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $carg = $carg . $fila2["des_dependencia"] . ', ';
        }
    }

    $myDat->resp_Met = trim($carg, ', ');

    $cont = 0;
    $CadMedi = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> <b>#</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Fecha</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Base</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Medicion</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Resultado</b>
    </td>
    <td>
        <i class='fa fa-angle-right'></i> <b>Origen</b>
    </td>

</tr>
</thead>
<tbody id='tb_Body_Medicion'>";

    $consulta = "select * from medir_indmeta where idmeta_indmeta=" . $_POST["cod"] . "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadMedi .= '<tr class="selected" id="filaMedi' . $cont . '" >';
            $parcont = explode("-", $fila["desc_origen"]);
            $CadMedi .= "<td>" . $cont . "</td>";
            $CadMedi .= "<td>" . $fila["fmed_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $fila["base_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $fila["med_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $fila["resul_indmeta"] . "</td>";
            $CadMedi .= "<td>" . $parcont[0] . "</td></tr>";
        }
    }
    $CadMedi .= "</tbody>";

    $myDat->CadMedi = $CadMedi;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsulProyec") {

    $myDat = new stdClass();

    $cont = 0;
    $CadProy = "<thead>
    <tr>
        <td>
            <i class='fa fa-angle-right'></i> #
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Código
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Nombre
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Tipologia
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Secretaria
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Estado
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Acción
        </td>
    </tr>
</thead>
<tbody id='tb_Body_Medicion'>";

    $consulta = "SELECT
  proy.id_proyect id,
  proy.cod_proyect cod,
  proy.nombre_proyect nomb,
  proy.dtipol_proyec tip,
  proy.dsecretar_proyect secr,
  REPLACE(proy.estado_proyect,'En Ejecucion','En Ejecución') esta
FROM
    contratos cnt
    LEFT JOIN 
    proyectos proy 
      ON cnt.idproy_contrato =  proy.id_proyect
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
  WHERE proy.estado='ACTIVO'  AND IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(proy.id_proyect, '') LIKE '" . $_POST["CbProy"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%' AND cnt.id_contrato IN
                (SELECT
                  MAX(id_contrato)
                FROM
                  contratos
                GROUP BY num_contrato)";
    //     echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadProy .= '<tr class="selected" id="filaProy' . $cont . '" >';

            $CadProy .= "<td>" . $cont . "</td>";
            $CadProy .= "<td>" . $fila["cod"] . "</td>";
            $CadProy .= "<td>" . $fila["nomb"] . "</td>";
            $CadProy .= "<td>" . $fila["tip"] . "</td>";
            $CadProy .= "<td>" . $fila["secr"] . "</td>";
            $CadProy .= "<td>" . $fila["esta"] . "</td>";
            $CadProy .= "<td><a onclick=\"$.ListGrafica('" . $fila["id"] . "')\" class=\"btn default btn-xs purple\">"
                . "<i class=\"fa fa-pie-chart\"></i> Graficar</a></td></tr>";
        }
    }
    $CadProy .= "</tbody>";

    $myDat->CadProy = $CadProy;




    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditProyecto") {

    $myDat = new stdClass();

    $consulta = "select * from  proyectos where id_proyect='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_proyect = $fila["cod_proyect"];
            $cod_proyect = $fila["cod_proyect"];
            $myDat->fcrea_proyect = $fila["fec_crea_proyect"];
            $myDat->fulmod_proyect = $fila["fulmod_proyect"];
            $myDat->nom_proyect = $fila["nombre_proyect"];
            $myDat->tipo_proyect = $fila["tipol_proyect"];
            $myDat->secretaria_proyect = $fila["secretaria_proyect"];
            $myDat->cron_proyect = $fila["cron_proyect"];
            $myDat->vigenc_proyect = $fila["vigenc_proyect"];
            $myDat->codproyasoc_proyect = $fila["codproyasoc_proyect"];
            $myDat->desproyasoc_proyect = $fila["desproyasoc_proyect"];
            $myDat->frso_proyeasoc = $fila["frso_proyeasoc"];
            $myDat->fecha_iniproyaso = $fila["fecha_iniproyaso"];
            $myDat->plazo_ejeproyeaso = $fila["plazo_ejeproyeaso"];
            $myDat->vigenc_proyeaso = $fila["vigenc_proyeaso"];
            $myDat->estado_proyeaso = $fila["estado_proyeaso"];
            $myDat->elab_proyect = $fila["elab_proyect"];
            $myDat->idenproble_proyect = $fila["idenproble_proyect"];
            $myDat->objgen_proyect = $fila["objgen_proyect"];
            $myDat->desc_proyect = $fila["desc_proyect"];
            $myDat->finiproy = $fila["finiproy"];
            $myDat->ffinproy = $fila["ffinproy"];
            $myDat->estado_proyect = $fila["estado_proyect"];
            $myDat->comp_pres = $fila["comp_pres"];
            $myDat->fcomp_pres = $fila["fcomp_pres"];
            $myDat->docucomp_pres = $fila["docucomp_pres"];
        }
    }


    ////CAUSAS
    $contCaus = 0;
    $consulta = "SELECT * FROM banco_proyec_causas WHERE id_proyect='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Causa = "<thead>\n" .
        "     <tr>\n" .
        "         <td>\n" .
        "             <i ></i> #\n" .
        "         </td>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
        "         </td>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "         </td>\n" .
        "     </tr>\n" .
        " </thead>"
        . "   <tbody >\n";


    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contCaus++;
            $Tab_Causa .= "<tr class='selected' id='filaCaus" . $contCaus . "' ><td>" . $contCaus . "</td>";
            $Tab_Causa .= "<td>" . $fila["desc"] . "</td>";
            $Tab_Causa .= "<td><input type='hidden' id='idCausa" . $contCaus . "' name='terce' value='" . $fila["desc"] . "' /><a onclick=\"$.QuitarCausa('filaCaus" . $contCaus . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Causa .= "</tbody>";


    $myDat->Tab_Causa = $Tab_Causa;
    $myDat->contCaus = $contCaus;


    ///EFECTOS
    $consulta = "SELECT * FROM banco_proyec_efectos  WHERE id_proyect='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Efectos = "<thead>\n" .
        "     <tr>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> #\n" .
        "         </td>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
        "         </td>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "         </td>\n" .
        "     </tr>\n" .
        " </thead>" . "   <tbody >\n";

    $contEfectos = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contEfectos++;
            $Tab_Efectos .= "<tr class='selected' id='filaEfect" . $contEfectos . "' ><td>" . $contEfectos . "</td>";
            $Tab_Efectos .= "<td>" . $fila["desc"] . "</td>";
            $Tab_Efectos .= "<td><input type='hidden' id='idEfect" . $contEfectos . "' name='terce' value='" . $fila["desc"] . "' /><a onclick=\"$.QuitarEfect('filaEfect" . $contEfectos . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Efectos .= "</tbody>";

    $myDat->Tab_Efectos = $Tab_Efectos;
    $myDat->contEfectos = $contEfectos;


    ///Objetivos EspecÃ­ficos
    $consulta = "SELECT * FROM banco_proyec_objespec WHERE id_proyect='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_ObjEspec = "<thead>\n" .
        "     <tr>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> #\n" .
        "         </td>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
        "         </td>\n" .
        "         <td>\n" .
        "             <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "         </td>\n" .
        "     </tr>\n" .
        " </thead>" . "   <tbody >\n";

    $contObjEspec = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contObjEspec++;
            $Tab_ObjEspec .= "<tr class='selected' id='filaObjet" . $contObjEspec . "' ><td>" . $contObjEspec . "</td>";
            $Tab_ObjEspec .= "<td>" . $fila["desc"] . "</td>";
            $Tab_ObjEspec .= "<td><input type='hidden' id='idObjet" . $contObjEspec . "' name='terce' value='" . $fila["desc"] . "' /><a onclick=\"$.QuitarObjet('filaObjet" . $contObjEspec . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_ObjEspec .= "</tbody>";

    $myDat->Tab_ObjEspec = $Tab_ObjEspec;
    $myDat->contObjEspec = $contObjEspec;


    ///productos
    $consulta = "SELECT \n" .
        "  prod.producto prod,\n" .
        "  prod.indicador ind,\n" .
        "  prod.anio anio,\n" .
        "  prod.meta met\n" .
        "FROM\n" .
        "  banco_proyec_productos prod \n" .
        "WHERE id_proyect = '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Productos = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Producto\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Indicador\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> A&ntilde;o\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Meta\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>" . "   <tbody >\n";

    $contProductos = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contProductos++;
            $Tab_Productos .= "<tr class='selected' id='filaProd" . $contProductos . "' ><td>" . $contProductos . "</td>";
            $Tab_Productos .= "<td>" . $fila["prod"] . "</td>";
            $Tab_Productos .= "<td>" . $fila["ind"] . "</td>";
            $Tab_Productos .= "<td>" . $fila["anio"] . "</td>";
            $Tab_Productos .= "<td>" . $fila["met"] . "</td>";
            $Tab_Productos .= "<td><input type='hidden' id='idProd" . $contProductos . "' name='terce' value='" . $fila["prod"] . "//" . $fila["ind"] . "//" . $fila["anio"] . "//" . $fila["met"] . "' /><a onclick=\"$.QuitarProd('filaProd" . $contProductos . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Productos .= "</tbody>";

    $myDat->Tab_Productos = $Tab_Productos;
    $myDat->contProductos = $contProductos;

    ///poblacion
    $consulta = "SELECT *  FROM banco_proyec_pobla WHERE id_proyect = '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Poblacion = "<thead>\n" .
        "                <tr>\n" .
        "                               <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> # Personas
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Genero
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Edad
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Grupo Etnico
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Fase del Proyecto
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Acción
                </td>\n" .
        "                           </tr>\n" .
        "                       </thead>" . "   <tbody >\n";

    $contPoblacion = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contPoblacion++;
            $Tab_Poblacion .= "<tr class='selected' id='filaPobla" . $contPoblacion . "' ><td>" . $contPoblacion . "</td>";
            $Tab_Poblacion .= "<td>" . $fila["personas"] . "</td>";
            $Tab_Poblacion .= "<td>" . $fila["genero"] . "</td>";
            $Tab_Poblacion .= "<td>" . $fila["edad"] . "</td>";
            $Tab_Poblacion .= "<td>" . $fila["grupoetnico"] . "</td>";
            $Tab_Poblacion .= "<td>" . $fila["fase"] . "</td>";
            $Tab_Poblacion .= "<td><input type='hidden' id='idPobla" . $contPoblacion . "' name='terce' value='" . $fila["personas"] . "//" . $fila["genero"] . "//" . $fila["edad"] . "//" . $fila["grupoetnico"] . "//" . $fila["fase"] . "' /><a onclick=\"$.QuitarProd('filaPobla" . $contPoblacion . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Poblacion .= "</tbody>";

    $myDat->Tab_Poblacion = $Tab_Poblacion;
    $myDat->contPoblacion = $contPoblacion;

    ///costos asociados
    $consulta = "SELECT \n" .
        "  cost.identifi iden,\n" .
        "  cost.nombre nom,\n" .
        "  cost.cargo car,\n" .
        "  cost.horaxsemana hor \n" .
        "FROM\n" .
        "  banco_proyec_costos cost \n" .
        "WHERE cost.id_proyect= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_CostAsoc = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Identificaci&oacute;n\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Cargo\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Horas Semanales\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody >\n";

    $contCostAsoc = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contCostAsoc++;
            $Tab_CostAsoc .= "<tr class='selected' id='filaCostAsoc" . $contCostAsoc . "' ><td>" . $contCostAsoc . "</td>";
            $Tab_CostAsoc .= "<td>" . $fila["iden"] . "</td>";
            $Tab_CostAsoc .= "<td>" . $fila["nom"] . "</td>";
            $Tab_CostAsoc .= "<td>" . $fila["car"] . "</td>";
            $Tab_CostAsoc .= "<td>" . $fila["hor"] . "</td>";
            $Tab_CostAsoc .= "<td><input type='hidden' id='idCostAsoc" . $contCostAsoc . "' name='terce' value='" . $fila["iden"] . "//" . $fila["nom"] . "//" . $fila["car"] . "//" . $fila["hor"] . "' /><a onclick=\"$.QuitarCostAsoc('filaCostAsoc" . $contCostAsoc . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_CostAsoc .= "</tbody>";
    $myDat->Tab_CostAsoc = $Tab_CostAsoc;
    $myDat->contCostAsoc = $contCostAsoc;


    /// estudios
    $consulta = "SELECT * FROM\n" .
        "  banco_proyec_estudios  \n" .
        "  WHERE id_proyect= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Estudios = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Titulo\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Autor\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Entidad\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Fecha\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Observaciones\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody >\n";

    $contEstudios = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contEstudios++;
            $Tab_Estudios .= "<tr class='selected' id='filaEstudios" . $contEstudios . "' ><td>" . $contEstudios . "</td>";
            $Tab_Estudios .= "<td>" . $fila["titulo"] . "</td>";
            $Tab_Estudios .= "<td>" . $fila["autor"] . "</td>";
            $Tab_Estudios .= "<td>" . $fila["entidad"] . "</td>";
            $Tab_Estudios .= "<td>" . $fila["fecha"] . "</td>";
            $Tab_Estudios .= "<td>" . $fila["observa"] . "</td>";
            $Tab_Estudios .= "<td><input type='hidden' id='idEstudios" . $contEstudios . "' "
                . "name='terce' value='" . $fila["titulo"] . "//" . $fila["autor"] . "//" . $fila["entidad"] . "//" . $fila["fecha"] . "//" . $fila["observa"] . "' /><a onclick=\"$.QuitarEstudios('filaEstudios" . $contEstudios . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Estudios .= "</tbody>";
    $myDat->Tab_Estudios = $Tab_Estudios;
    $myDat->contEstudios = $contEstudios;



    ///costos actividades
    $consulta = "SELECT \n"
        . "  conact.metas met,\n"
        . "  conact.actividades desact,\n"
        . "  conact.respo_activ idres,\n"
        . "  CONCAT(resp.cod_responsable,' - ',resp.nom_responsable) terc,\n"
        . "  conact.estado_activ est,\n"
        . "  conact.costo_activ cost,\n"
        . "  conact.fini_activ fini,\n"
        . "  conact.hini_activ hini,\n"
        . "  conact.ffin_activ ffin,\n"
        . "  conact.hfin_activ hfin\n"
        . "  \n"
        . "FROM\n"
        . "  banco_proyec_actividades conact \n"
        . "  LEFT JOIN responsables resp \n"
        . "    ON conact.respo_activ = resp.id_responsable \n"
        . "  where conact.id_proyecto='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);
    // echo $consulta;
    $Tab_Activ = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i ></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Meta" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Actividad" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Responsable\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Costo\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Estado\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Fec. Inicio\n" .
        "          </td>                                                                                 \n" .
        "          <td>\n" .
        "              <i ></i> H. Inicio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i></i> Fec. Final\n" .
        "          </td>                                                                                 \n" .
        "          <td>\n" .
        "              <i ></i> H. Final\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i ></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody >\n";

    $contActiv = 0;
    $totcost = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contActiv++;
            $totcost = $totcost + $fila["cost"];

            $Tab_Activ .= "<tr class=\"selected\" id='filaAct" . $contActiv . "' ><td>" . $contActiv . "</td>";
            $Tab_Activ .= "<td>" . $fila["met"] . "</td>";
            $Tab_Activ .= "<td>" . $fila["desact"] . "</td>";
            $Tab_Activ .= "<td>" . $fila["terc"] . "</td>";
            $Tab_Activ .= "<td>$ " . number_format($fila["cost"], 2, ",", ".") . "</td>";
            $Tab_Activ .= "<td>" . $fila["est"] . "</td>";
            $Tab_Activ .= "<td>" . $fila["fini"] . "</td>";
            $Tab_Activ .= "<td>" . $fila["hini"] . "</td>";
            $Tab_Activ .= "<td>" . $fila["ffin"] . "</td>";
            $Tab_Activ .= "<td>" . $fila["hfin"] . "</td>";
            $Tab_Activ .= "<td><input type='hidden' id='Acti" . $contActiv . "' name='actividades' value='" . $fila["met"] . "//" . $fila["desact"] . "//" . $fila["idres"] . "//" . $fila["cost"] . "//" . $fila["fini"] . "//" . $fila["hini"] . "//" . $fila["ffin"] . "//" . $fila["hfin"] . "//" . $fila["est"]  . "' /><a onclick=\"$.QuitarActi('filaAct" . $contActiv . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }

    $Tab_Activ .= "</tbody><tfoot>
    <tr>
        <th colspan='4' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalCostosAct' style='font-weight: bold;'>$ " . number_format($totcost, 2, ",", ".") . "</label></th>
    </tr>
  </tfoot>";
    $myDat->Tab_Activ = $Tab_Activ;
    $myDat->contActiv = $contActiv;
    $myDat->totcost = $totcost;


    ////financiacion

    $consulta = "SELECT bf.origen,fuen.nombre,bf.valor FROM banco_proyec_financiacion bf LEFT JOIN fuentes fuen ON  bf.origen = fuen.id  WHERE bf.id_proyect = '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Financia = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Origen de la Financiaci&oacute;n\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Valor\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>" . "   <tbody >\n";

    $contFinancia = 0;
    $TotFinancia = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contFinancia++;
            $valor = '$ ' . number_format($fila["valor"], 2, ",", ".");
            $TotFinancia = $TotFinancia + $fila["valor"];
            $Tab_Financia .= "<tr class='selected' id='filaFinancia" . $contFinancia . "' ><td>" . $contFinancia . "</td>";
            $Tab_Financia .= "<td>" . $fila["nombre"] . "</td>";
            $Tab_Financia .= "<td>" . $valor . "</td>";
            $Tab_Financia .= "<td><input type='hidden' id='idFinancia" . $contFinancia . "' name='terce' value='" . $fila["origen"] . "//" . $fila["valor"] . "' /><a onclick=\"$.QuitarFinancia('filaFinancia" . $contFinancia . "//" .  $fila["valor"] . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Financia .= "</tbody><tfoot>
    <tr>
        <th colspan='2' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalFinanc' style='font-weight: bold;'>$ " . number_format($TotFinancia, 2, ",", ".") . "</label></th>
    </tr>
  </tfoot>";
    $myDat->Tab_Financia = $Tab_Financia;
    $myDat->contFinancia = $contFinancia;
    $myDat->TotFinancia = $TotFinancia;


    ///presupuesto
    $consulta = "SELECT * FROM \n" .
        "  banco_proyec_presupuesto  \n" .
        "WHERE id_proyect = '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Presupuesto = "<thead>
                    <tr>
                    <th style='vertical-align: middle; text-align:center;'>#</th>
                    <th style='vertical-align: middle; text-align:left;'>Descripción</th>
                    <th style='vertical-align: middle; text-align:left;'>Valor</th>
                    <th style='vertical-align: middle; text-align:left;'>Accion</th>
                    </tr>
            </thead><tbody >\n";

    $contPresupuesto = 0;
    $TotVige = 0;
    $Total = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contPresupuesto++;
            $Total = $Total + $fila["total"];
            $Tab_Presupuesto .= "<tr class='selected' id='filaPresup" . $contPresupuesto . "' ><td>" . $contPresupuesto . "</td>";
            $Tab_Presupuesto .= "<td>" . $fila["desc"] . " - " . $fila["observacion"] . "</td>";
            $Tab_Presupuesto .= "<td>$ " . number_format($fila["total"], 2, ",", ".") . "</td>";
            $Tab_Presupuesto .= "<td><input type='hidden' id='idPresup" . $contPresupuesto . "' name='terce' value='" . $fila["desc"] . "//" . $fila["total"] . "//" . $fila["observacion"] . "' /><a onclick=\"$.QuitarPresup('filaPresup" . $contPresupuesto . "//" . $fila["total"] . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Presupuesto .= "</tbody><tfoot>
    <tr>
        <th colspan='2' style='text-align: right;'>Total Proyecto:</th>
        <th colspan='1'><label id='gtotalPresTota' style='font-weight: bold;'>$ " . number_format($Total, 2, ",", ".") . "</label></th>
    </tr>
  </tfoot>";


    $myDat->Tab_Presupuesto = $Tab_Presupuesto;
    $myDat->contPresupuesto = $contPresupuesto;
    $myDat->Total = $Total;


    ////ingresos

    $consulta = "SELECT * FROM\n" .
        "  banco_proyec_ingresos  \n" .
        "WHERE id_proyect = '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Ingresos = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Cantidad\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Valor Unidad\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Total\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody >\n";

    $contIngresos = 0;
    $total = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contIngresos++;
            $total = $fila["valor"] * $fila["cantidad"];
            $Tab_Ingresos .= "<tr class='selected' id='filaIngPres" . $contIngresos . "' ><td>" . $contIngresos . "</td>";
            $Tab_Ingresos .= "<td>" . $fila["desc"] . "</td>";
            $Tab_Ingresos .= "<td>" . $fila["cantidad"] . "</td>";
            $Tab_Ingresos .= "<td>" . number_format($fila["valor"], 2, ",", ".") . "</td>";
            $Tab_Ingresos .= "<td>$ " . $total . "</td>";
            $Tab_Ingresos .= "<td><input type='hidden' id='idIngPre" . $contIngresos . "' name='terce' value='" . $fila["desc"] . "//" . $fila["cantidad"] . "//" . $fila["valor"] . "' /><a onclick=\"$.QuitarFinancia('filaIngPres" . $contIngresos . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Tab_Ingresos .= "</tbody>";
    $myDat->Tab_Ingresos = $Tab_Ingresos;
    $myDat->contIngresos = $contIngresos;


    ////ANEXOS

    $consulta = "SELECT * FROM\n" .
        "  banco_proyec_anexos  \n" .
        "WHERE id_proyect = '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Anexos = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre Del Archivo\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody >\n";

    $contAnexos = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contAnexos++;
            $Tab_Anexos .= "<tr class='selected' id='filaAnexo" . $contAnexos . "' ><td>" . $contAnexos . "</td>";
            $Tab_Anexos .= "<td>" . $fila["desc"] . "</td>";
            $Tab_Anexos .= "<td>" . $fila["nombre_arch"] . "</td>";
            $Tab_Anexos .= "<td style='text-align: center;'><a href='" . "../Proyecto/AnexosProyecto/" . $_SESSION['ses_complog'] . "/" . $cod_proyect . "/" . $fila["src_arch"] . "' target='_blank' class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Ver</a>";
            $Tab_Anexos .= "<input type='hidden' id='idAnexo" . $contAnexos . "' name='idAnexo' value='" . $fila["desc"] . "///" . $fila["nombre_arch"] . "///" . $fila["src_arch"] . "' /><a onclick=\"$.QuitarAnexo('filaAnexo" . $contAnexos . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }
    $Tab_Anexos .= "</tbody>";
    $myDat->Tab_Anexos = $Tab_Anexos;
    $myDat->contAnexos = $contAnexos;



    /// localizacion
    $consulta = "SELECT
 dep.COD_DPTO coddep,
  CONCAT(dep.COD_DPTO,' - ',dep.NOM_DPTO) dedep,
  IFNULL(mun.COD_MUNI,'') codmun,
  IFNULL(CONCAT(mun.COD_MUNI,' - ',mun.NOM_MUNI),'') demun,
  IFNULL(corr.COD_CORREGI,'') codcorre,
  IFNULL(CONCAT(corr.COD_CORREGI,' - ',corr.NOM_CORREGI),'') decorr,
  ubi.lat_ubic lat, ubi.long_ubi longi, ubi.barr_ubic otrub
FROM
  ubic_proyect ubi
  LEFT JOIN " . $_SESSION['ses_BDBase'] . ".dpto dep
    ON ubi.depar_ubic = dep.COD_DPTO
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".muni mun
    ON ubi.muni_ubic=mun.COD_MUNI
    LEFT JOIN " . $_SESSION['ses_BDBase'] . ".corregi corr
    ON ubi.corr_ubic=corr.COD_CORREGI" .
        "  WHERE proyect_ubi= '" . $_POST["cod"] . "' ";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Locali = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Departamento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Municipio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Corregimiento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Otra Ubicación\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contLocal = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contLocal++;
            $Tab_Locali .= "<tr class='selected' id='filaLoca" . $contLocal . "' ><td>" . $contLocal . "</td>";
            $Tab_Locali .= "<td>" . $fila["dedep"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["demun"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["decorr"] . "</td>";
            $Tab_Locali .= "<td>" . $fila["otrub"] . "</td>";
            $Tab_Locali .= "<td><input type='hidden' id='Loca" . $contLocal . "' "
                . "name='terce' value='" . $fila["coddep"] . "//" . $fila["codmun"] . "//" . $fila["codcorre"] . "//" . $fila["otrub"] . "//" . $fila["lat"] . "//" . $fila["longi"] . "' />"
                . "<a onclick=\"$.QuitarLocal('filaLoca" . $contLocal . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                . "<a onclick=\"$.VerLoca('" . $fila["lat"] . "//" . $fila["longi"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-map-marker\"></i> Mostrar</a>"
                . "</td></tr>";
        }
    }
    $Tab_Locali .= "</tbody>";
    $myDat->Tab_Locali = $Tab_Locali;
    $myDat->contLocal = $contLocal;

    //galeria de imagenes

    $consulta = "SELECT * FROM proyecto_galeria WHERE proyect_galeria= '" . $_POST["cod"] . "' ";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Img = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Imagenes de\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Fecha\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contImg = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contImg++;
            $Tab_Img .= "<tr class='selected' id='filaImg" . $contImg . "' ><td>" . $contImg . "</td>";
            $Tab_Img .= "<td>" . $fila["img_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["tip_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["fecha"] . "</td>";
            $Tab_Img .= "<td><input type='hidden' id='idImg" . $contImg . "' "
                . "name='terce' value='" . $fila["tip_galeria"] . "//" . $fila["img_galeria"] . "//" . $fila["formato_galeria"] . "//" . $fila["fecha"] . "' />"
                . "<a onclick=\"$.QuitarImg('filaImg" . $contImg . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Quitar</a>"
                . "<a onclick=\"$.VerImg('../Proyecto/GaleriaProyecto/" . $_SESSION['ses_complog'] . "/" . $cod_proyect . "/" . $fila["img_galeria"] . "*" . $fila["formato_galeria"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>"
                . "</td></tr>";
        }
    }
    $Tab_Img .= "</tbody>";
    $myDat->Tab_Img = $Tab_Img;
    $myDat->contImg = $contImg;

    ///metas

    $consulta = "SELECT * FROM proyect_metas where cod_proy='" . $_POST["cod"] . "'";
    //    echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Meta = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Código\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre de la Meta \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Meta Generada \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Meta'>\n";

    $contMeta = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contMeta++;
            $Tab_Meta .= "<tr class=\"selected\" id='filaMeta" . $contMeta . "' ><td>" . $contMeta . "</td>";
            $Tab_Meta .= "<td>" . $fila["cod_met"] . "</td>";
            $Tab_Meta .= "<td>" . $fila["desc_met"] . "</td>";
            $Tab_Meta .= "<td>" . $fila["aport_proy"] . "</td>";
            $Tab_Meta .= "<td><input type='hidden' id='idMetas" . $contMeta . "' " . "name='actividades' value='" . $fila["id_meta"] . "//" . $fila["cod_met"] . "//" . $fila["desc_met"] . "//" . $fila["aport_proy"] . "' /><a onclick=\"$.QuitarMeta('filaMeta" . $contMeta . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }

    $Tab_Meta .= "</tbody>";
    $myDat->Tab_Meta = $Tab_Meta;
    $myDat->contMeta = $contMeta;


    ///metas producto

    $consulta = "SELECT * FROM proyect_metasproducto where cod_proy='" . $_POST["cod"] . "'";
    //    echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_MetaP = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Código\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre de la Meta \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Objetivo de la Meta \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Meta Generada \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_MetaP'>\n";

    $contMetaP = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contMeta++;
            $Tab_MetaP .= "<tr class=\"selected\" id='filaMetaP" . $contMeta . "' ><td>" . $contMeta . "</td>";
            $Tab_MetaP .= "<td>" . $fila["cod_met"] . "</td>";
            $Tab_MetaP .= "<td>" . $fila["desc_met"] . "</td>";
            $Tab_MetaP .= "<td>" . $fila["met_objetivo"] . "</td>";
            $Tab_MetaP .= "<td>" . $fila["met_generada"] . "</td>";
            $Tab_MetaP .= "<td><input type='hidden' id='idMetasP" . $contMeta . "' " . "name='actividades' value='" . $fila["id_meta"] . "//" . $fila["cod_met"] . "//" . $fila["desc_met"] . "//" . $fila["met_objetivo"] . "//" . $fila["met_generada"] . "' /><a onclick=\"$.QuitarMetaP('filaMetaP" . $contMeta . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }

    $Tab_MetaP .= "</tbody>";
    $myDat->Tab_MetaP = $Tab_MetaP;
    $myDat->contMetaP = $contMetaP;


    ///usuarios

    $consulta = "SELECT upr.usuario idu, usu.cue_nombres nom FROM usu_proyect upr LEFT JOIN " . $_SESSION['ses_BDBase'] . ".usuarios usu ON upr.usuario=usu.id_usuario
WHERE upr.proyect='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Usu = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre de Usuario\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Usuarios'>\n";

    $contUsu = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contUsu++;
            $Tab_Usu .= "<tr class=\"selected\" id='filaUsu" . $contUsu . "' ><td>" . $contUsu . "</td>";
            $Tab_Usu .= "<td>" . $fila["nom"] . "</td>";
            $Tab_Usu .= "<td><input type='hidden' id='Usu" . $contUsu . "' " . "name='actividades' value='" . $fila["idu"] . "' /><a onclick=\"$.QuitarUsu('filaUsu" . $contUsu . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }

    $Tab_Usu .= "</tbody>";
    $myDat->Tab_Usu = $Tab_Usu;
    $myDat->contUsu = $contUsu;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditContrato") {

    $myDat = new stdClass();

    $consulta = "select * from  contratos where id_contrato='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->num_contrato = $fila["num_contrato"];
            $num_contrato = $fila["num_contrato"];
            $myDat->fmod_contrato = $fila["fmod_contrato"];
            $myDat->fcrea_contrato = $fila["fcrea_contrato"];
            $myDat->idtipolg_contrato = $fila["idtipolg_contrato"];
            $myDat->destipolg_contrato = $fila["destipolg_contrato"];
            $myDat->obj_contrato = $fila["obj_contrato"];
            $myDat->idcontrati_contrato = $fila["idcontrati_contrato"];
            $myDat->descontrati_contrato = $fila["descontrati_contrato"];
            $myDat->idsuperv_contrato = $fila["idsuperv_contrato"];
            $myDat->dessuperv_contrato = $fila["dessuperv_contrato"];
            $myDat->idinterv_contrato = $fila["idinterv_contrato"];
            $myDat->desinterv_contrato = $fila["desinterv_contrato"];
            $myDat->vcontr_contrato = $fila["vcontr_contrato"];
            $myDat->vadic_contrato = $fila["vadic_contrato"];
            $myDat->vfin_contrato = $fila["vfin_contrato"];
            $myDat->veje_contrato = $fila["veje_contrato"];
            $myDat->forpag_contrato = $fila["forpag_contrato"];
            $myDat->durac_contrato = $fila["durac_contrato"];
            $myDat->fini_contrato = $fila["fini_contrato"];
            $myDat->fsusp_contrato = $fila["fsusp_contrato"];
            $myDat->frein_contrato = $fila["frein_contrato"];
            $myDat->prorg_contrato = $fila["prorg_contrato"];
            $myDat->ffin_contrato = $fila["ffin_contrato"];
            $myDat->frecb_contrato = $fila["frecb_contrato"];
            $myDat->idproy_contrato = $fila["idproy_contrato"];
            $myDat->desproy_contrato = $fila["desproy_contrato"];
            $myDat->porav_contrato = $fila["porav_contrato"];
            $myDat->estad_contrato = $fila["estad_contrato"];
            $myDat->porproy_contrato = $fila["porproy_contrato"];
            $myDat->estcont_contra = $fila["estcont_contra"];
            $myDat->secop_contrato = $fila["secop_contrato"];
            $myDat->observacion = $fila["observacion"];
            $myDat->urldocumento = $fila["urldocumento"];
            $myDat->tipnovedad = $fila["tipnovedad"];
        }
    }


    $consulta = "SELECT * FROM contrato_galeria WHERE num_contrato_galeria= '" . $num_contrato . "' ";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Img = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Imagenes de\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Fecha\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contImg = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contImg++;
            $Tab_Img .= "<tr class='selected' id='filaImg" . $contImg . "' ><td>" . $contImg . "</td>";
            $Tab_Img .= "<td>" . $fila["img_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["tip_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["fecha"] . "</td>";
            $Tab_Img .= "<td><input type='hidden' id='idImg" . $contImg . "' "
                . "name='terce' value='" . $fila["tip_galeria"] . "//" . $fila["img_galeria"] . "//" . $fila["formato_galeria"] . "//" . $fila["fecha"] . "' />"
                . "<a onclick=\"$.QuitarImg('filaImg" . $contImg . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                . "<a onclick=\"$.VerImg('../Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $num_contrato . "/" . $fila["img_galeria"] . "*" . $fila["formato_galeria"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>"
                . "</td></tr>";
        }
    }
    $Tab_Img .= "</tbody>";
    $myDat->Tab_Img = $Tab_Img;
    $myDat->contImg = $contImg;


    $consulta = "SELECT 
        dep.COD_DPTO coddep, 
   CONCAT(dep.COD_DPTO,' - ',dep.NOM_DPTO) depart,
   mn.COD_MUNI codmuni,
  IFNULL( CONCAT(mn.COD_MUNI,' - ',mn.NOM_MUNI),'N/A') municip,
  corr.COD_CORREGI codcorr,
  IFNULL(CONCAT(corr.COD_CORREGI,' - ',corr.NOM_CORREGI),'N/A') correg,
  uc.barr_ubic otrub, 
  uc.lat_ubic lat, uc.long_ubi lon 
 FROM
  ubic_contratos uc 
  LEFT JOIN dpto dep 
    ON uc.depar_ubic = dep.COD_DPTO 
    LEFT JOIN muni mn 
    ON uc.muni_ubic=mn.COD_MUNI
    LEFT JOIN corregi corr
    ON uc.corr_ubic=corr.COD_CORREGI
    WHERE uc.num_contrato='" . $num_contrato . "'";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Loca = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Departamanto\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Municipio\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Corregimiento\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Otra Ubicación \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acción\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contUbi = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contUbi++;
            $Tab_Loca .= "<tr class='selected' id='filaLoca" . $contUbi . "' ><td>" . $contUbi . "</td>";
            $Tab_Loca .= "<td>" . $fila["depart"] . "</td>";
            $Tab_Loca .= "<td>" . $fila["municip"] . "</td>";
            $Tab_Loca .= "<td>" . $fila["correg"] . "</td>";
            $Tab_Loca .= "<td>" . $fila["otrub"] . "</td>";
            $Tab_Loca .= "<td><input type='hidden' id='Loca" . $contUbi . "' "
                . "name='Loca' value='" . $fila["coddep"] . "//" . $fila["codmuni"] . "//" . $fila["codcorr"] . "//" . $fila["otrub"] . "//" . $fila["lat"] . "//" . $fila["lon"] . "' />"
                . "<a onclick=\"$.QuitarLocal('filaLoca" . $contUbi . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                . "<a onclick=\"$.VerLoca('" . $fila["lat"] . "//" . $fila["lon"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-map-marker\"></i> Mostrar</a>"
                . "</td></tr>";
        }
    }
    $Tab_Loca .= "</tbody>";
    $myDat->Tab_Loca = $Tab_Loca;
    $myDat->contUbi = $contUbi;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqDetaContrato") {

    $myDat = new stdClass();

    $consulta = "select * from  contratos where id_contrato='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->num_contrato = $fila["num_contrato"];
            $num_contrato = $fila["num_contrato"];
            $myDat->fcrea_contrato = $fila["fcrea_contrato"];
            $myDat->obj_contrato = $fila["obj_contrato"];
            $myDat->descontrati_contrato = $fila["descontrati_contrato"];
            $myDat->dessuperv_contrato = $fila["dessuperv_contrato"];
            $myDat->desinterv_contrato = $fila["desinterv_contrato"];
            $myDat->durac_contrato = $fila["durac_contrato"];
            $myDat->fini_contrato = $fila["fini_contrato"];
            $myDat->ffin_contrato = $fila["ffin_contrato"];
            $myDat->desproy_contrato = $fila["desproy_contrato"];
            $myDat->porav_contrato = $fila["porav_contrato"];
        }
    }



    $Justi = "";
    $Evide = "";

    $consulta = "select * from justif_atraso_cont where contrato='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Justi = $fila["justificacion"];
            $Evide = $fila["evidencias"];
        }
    }

    $evid2 = "";
    if ($Evide === "") {
        $evid2 = "Sin Evidencia";
    } else {
        $parsrc = explode("*", $Evide);
        $tamsrc = count($parsrc);
        $j = 1;
        for ($i = 0; $i < $tamsrc; $i++) {
            $evid2 .= "<a href='" . $parsrc[$i] . "' style='padding-right:5px;' target='_blank' class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Evidencia " . $j . "</a>";
            $j++;
        }
    }

    $myDat->Justi = $Justi;
    $myDat->Evide = $Evide . '*';
    $myDat->evid2 = $evid2;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditContratoExp") {

    $myDat = new stdClass();

    $consulta = "select * from  contratos_expres where id_contrato='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->num_contrato = $fila["num_contrato"];
            $myDat->idtipolg_contrato = $fila["idtipolg_contrato"];
            $myDat->destipolg_contrato = $fila["destipolg_contrato"];
            $myDat->obj_contrato = $fila["obj_contrato"];
            $myDat->idcontrati_contrato = $fila["idcontrati_contrato"];
            $myDat->descontrati_contrato = $fila["descontrati_contrato"];
            $myDat->idsuperv_contrato = $fila["idsuperv_contrato"];
            $myDat->dessuperv_contrato = $fila["dessuperv_contrato"];
            $myDat->idinterv_contrato = $fila["idinterv_contrato"];
            $myDat->desinterv_contrato = $fila["desinterv_contrato"];
            $myDat->vcontr_contrato = $fila["vcontr_contrato"];
            $myDat->vadic_contrato = $fila["vadic_contrato"];
            $myDat->vfin_contrato = $fila["vfin_contrato"];
            $myDat->veje_contrato = $fila["veje_contrato"];
            $myDat->forpag_contrato = $fila["forpag_contrato"];
            $myDat->durac_contrato = $fila["durac_contrato"];
            $myDat->fini_contrato = $fila["fini_contrato"];
            $myDat->fsusp_contrato = $fila["fsusp_contrato"];
            $myDat->frein_contrato = $fila["frein_contrato"];
            $myDat->prorg_contrato = $fila["prorg_contrato"];
            $myDat->ffin_contrato = $fila["ffin_contrato"];
            $myDat->frecb_contrato = $fila["frecb_contrato"];
            $myDat->idproy_contrato = $fila["idproy_contrato"];
            $myDat->desproy_contrato = $fila["desproy_contrato"];
            $myDat->porav_contrato = $fila["porav_contrato"];
            $myDat->estad_contrato = $fila["estad_contrato"];
        }
    }


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditProyectExp") {

    $myDat = new stdClass();

    $consulta = "select * from  proyectos_expres where id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->codigo = $fila["codigo"];
            $myDat->nombre = $fila["nombre"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqParaEval") {

    $myDat = new stdClass();

    $consulta = "select * from  para_calf_contratista";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->PorCO = $fila["PorCO"];
            $myDat->PorCE = $fila["PorCE"];
            $myDat->PorCC = $fila["PorCC"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqInfContra") {

    $myDat = new stdClass();

    $consulta = "select * from  contratos where num_contrato='" . $_POST["cod"] . "' AND  id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato)
ORDER BY id_contrato";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->num_contrato = $fila["num_contrato"];
            $num_contrato = $fila["num_contrato"];
            $myDat->fmod_contrato = $fila["fmod_contrato"];
            $myDat->fcrea_contrato = $fila["fcrea_contrato"];
            $myDat->destipolg_contrato = $fila["destipolg_contrato"];
            $myDat->obj_contrato = $fila["obj_contrato"];
            $myDat->descontrati_contrato = $fila["descontrati_contrato"];
            $myDat->dessuperv_contrato = $fila["dessuperv_contrato"];
            $myDat->desinterv_contrato = $fila["desinterv_contrato"];
            $myDat->vcontr_contrato = $fila["vcontr_contrato"];
            $myDat->vadic_contrato = $fila["vadic_contrato"];
            $myDat->vfin_contrato = $fila["vfin_contrato"];
            $myDat->veje_contrato = $fila["veje_contrato"];
            $myDat->forpag_contrato = $fila["forpag_contrato"];
            $myDat->durac_contrato = $fila["durac_contrato"];
            $myDat->fini_contrato = $fila["fini_contrato"];
            $myDat->fsusp_contrato = $fila["fsusp_contrato"];
            $myDat->frein_contrato = $fila["frein_contrato"];
            $myDat->prorg_contrato = $fila["prorg_contrato"];
            $myDat->ffin_contrato = $fila["ffin_contrato"];
            $myDat->frecb_contrato = $fila["frecb_contrato"];
            $myDat->porav_contrato = $fila["porav_contrato"];
            $myDat->estad_contrato = $fila["estad_contrato"];
            $myDat->porproy_contrato = $fila["porproy_contrato"];
            $myDat->estcont_contra = $fila["estcont_contra"];
        }
    }


    //    $consulta = "SELECT * FROM contrato_galeria WHERE contr_galeria= '" . $_POST["cod"] . "' ";
    //
    //    $resultado1 = mysqli_query($link,$consulta);
    //
    //    $Tab_Img = " <thead>\n" .
    //            "      <tr>\n" .
    //            "          <td>\n" .
    //            "              <i class='fa fa-angle-right'></i> #\n" .
    //            "          </td>\n" .
    //            "          <td>\n" .
    //            "              <i class='fa fa-angle-right'></i> Nombre\n" .
    //            "          </td>\n" .
    //            "          <td>\n" .
    //            "              <i class='fa fa-angle-right'></i>  Imagenes de\n" .
    //            "          </td>\n" .
    //            "          <td>\n" .
    //            "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
    //            "          </td>\n" .
    //            "      </tr>\n" .
    //            "  </thead>"
    //            . "   <tbody id='tb_Body_Loca' >\n";
    //
    //    $contImg = 0;
    //    if (mysqli_num_rows($resultado1) > 0) {
    //        while ($fila = mysqli_fetch_array($resultado1)) {
    //            $contImg++;
    //            $Tab_Img .= "<tr class='selected' id='filaImg" . $contImg . "' ><td>" . $contImg . "</td>";
    //            $Tab_Img .= "<td>" . $fila["img_galeria"] . "</td>";
    //            $Tab_Img .= "<td>" . $fila["tip_galeria"] . "</td>";
    //            $Tab_Img .= "<td><input type='hidden' id='idImg" . $contImg . "' "
    //                    . "name='terce' value='" . $fila["tip_galeria"] . "//" . $fila["img_galeria"] . "//" . $fila["formato_galeria"] . "' />"
    //                    . "<a onclick=\"$.QuitarImg('filaImg" . $contLocal . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
    //                    . "<a onclick=\"$.VerImg('Galeria/" . $_SESSION['ses_complog'] . "/" . $num_contrato . "/" . $fila["img_galeria"] . "*" . $fila["formato_galeria"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>"
    //                    . "</td></tr>";
    //        }
    //    }
    //    $Tab_Img .= "</tbody>";
    //    $myDat->Tab_Img = $Tab_Img;
    //    $myDat->contImg = $contImg;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqInfProyecto") {

    $myDat = new stdClass();

    $consulta = "select * from  proyectos where cod_proyect='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_proyect = $fila["cod_proyect"];
            $id_proy = $fila["id_proyect"];
            $myDat->fec_crea_proyect = $fila["fec_crea_proyect"];
            $myDat->nombre_proyect = $fila["nombre_proyect"];
            $myDat->dtipol_proyec = $fila["dtipol_proyec"];
            $myDat->dsecretar_proyect = $fila["dsecretar_proyect"];
            $myDat->estado_proyect = $fila["estado_proyect"];
        }
    }

    ///7CONSULTAR CONTRATOS 
    $consulta = "SELECT * FROM contratos WHERE idproy_contrato= '" . $id_proy . "' GROUP BY num_contrato";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Cont = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Código\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Objeto\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Tipologia\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Contratos' >\n";

    $contCont = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contCont++;
            $Tab_Cont .= "<tr class='selected'><td>" . $contCont . "</td>";
            $Tab_Cont .= "<td>" . $fila["num_contrato"] . "</td>";
            $Tab_Cont .= "<td>" . $fila["obj_contrato"] . "</td>";
            $Tab_Cont .= "<td>" . $fila["destipolg_contrato"] . "</td>";
        }
    }
    $Tab_Cont .= "</tbody>";
    $myDat->Tab_Cont = $Tab_Cont;

    ///7CONSULTAR METAS TRAZADORAS 
    $consulta = "SELECT m.desc_meta desm, m.tipdato_metas umedi, m.base_meta base, m.meta meta FROM proyect_metas pm LEFT JOIN metas m ON pm.id_meta=m.id_meta WHERE pm.cod_proy= '" . $id_proy . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_MetaT = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Descripción Meta\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Unidad Medida\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Base\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Meta\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Contratos' >\n";

    $contCont = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contCont++;
            $Tab_MetaT .= "<tr class='selected'><td>" . $contCont . "</td>";
            $Tab_MetaT .= "<td>" . $fila["desm"] . "</td>";
            $Tab_MetaT .= "<td>" . $fila["umedi"] . "</td>";
            $Tab_MetaT .= "<td>" . $fila["base"] . "</td>";
            $Tab_MetaT .= "<td>" . $fila["meta"] . "</td>";
        }
    }
    $Tab_MetaT .= "</tbody>";
    $myDat->Tab_MetaT = $Tab_MetaT;

    ///7CONSULTAR METAS DE PRODUCTO 
    $consulta = "SELECT * FROM proyect_metasproducto WHERE cod_proy= '" . $id_proy . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_MetaP = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Descripción Meta\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Meta\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Meta Generada\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Contratos' >\n";

    $contCont = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contCont++;
            $Tab_MetaP .= "<tr class='selected'><td>" . $contCont . "</td>";
            $Tab_MetaP .= "<td>" . $fila["desc_met"] . "</td>";
            $Tab_MetaP .= "<td>" . $fila["met_objetivo"] . "</td>";
            $Tab_MetaP .= "<td>" . $fila["met_generada"] . "</td>";
        }
    }
    $Tab_MetaP .= "</tbody>";
    $myDat->Tab_MetaP = $Tab_MetaP;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditEval") {

    $myDat = new stdClass();
    $idCont = "";

    $consulta = "select * from  eval_contratista where id_evaluacion='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->eval_evaluacion = $fila["eval_evaluacion"];
            $myDat->feval_evaluacion = $fila["feval_evaluacion"];
            $myDat->reeval_evaluacion = $fila["reeval_evaluacion"];
            $myDat->freeval_evaluacion = $fila["freeval_evaluacion"];
            $myDat->idcont_evaluacion = $fila["idcont_evaluacion"];
            $idCont = $fila["idcont_evaluacion"];
            $myDat->ncont_evaluacion = $fila["ncont_evaluacion"];
            $myDat->fcont_evaluacion = $fila["fcont_evaluacion"];
            $myDat->objcont_evaluacion = $fila["objcont_evaluacion"];
            $myDat->nitcont_evaluacion = $fila["nitcont_evaluacion"];
            $myDat->nomcont_evaluacion = $fila["nomcont_evaluacion"];
            $myDat->finicont_evaluacion = $fila["finicont_evaluacion"];
            $myDat->ftercont_evaluacion = $fila["ftercont_evaluacion"];
            $myDat->clacont_evaluacion = $fila["clacont_evaluacion"];
            $myDat->puntPsTot1 = $fila["puntPsTot1"];
            $myDat->puntPsTot2 = $fila["puntPsTot2"];
            $myDat->puntPsTot3 = $fila["puntPsTot3"];
            $myDat->text_PsTotal = $fila["text_PsTotal"];
            $myDat->puntSaTot1 = $fila["puntSaTot1"];
            $myDat->puntSaTot2 = $fila["puntSaTot2"];
            $myDat->puntSaTot3 = $fila["puntSaTot3"];
            $myDat->text_SaTotal = $fila["text_SaTotal"];
            $myDat->puntCaTot1 = $fila["puntCaTot1"];
            $myDat->puntCaTot2 = $fila["puntCaTot2"];
            $myDat->puntCaTot3 = $fila["puntCaTot3"];
            $myDat->text_CaTotal = $fila["text_CaTotal"];
            $myDat->puntCcTot1 = $fila["puntCcTot1"];
            $myDat->puntCcTot2 = $fila["puntCcTot2"];
            $myDat->puntCcTot3 = $fila["puntCcTot3"];
            $myDat->text_CcTotal = $fila["text_CcTotal"];
            $myDat->puntCoTot1 = $fila["puntCoTot1"];
            $myDat->puntCoTot2 = $fila["puntCoTot2"];
            $myDat->puntCoTot3 = $fila["puntCoTot3"];

            $myDat->puntPsTot1Prom = $fila["puntPsTot1Prom"];
            $myDat->puntPsTot2Prom = $fila["puntPsTot2Prom"];
            $myDat->puntPsTot3Prom = $fila["puntPsTot3Prom"];

            $myDat->puntSaTot1Prom = $fila["puntSaTot1Prom"];
            $myDat->puntSaTot2Prom = $fila["puntSaTot3Prom"];
            $myDat->puntSaTot3Prom = $fila["puntSaTot3Prom"];

            $myDat->puntCaTot1Prom = $fila["puntCaTot1Prom"];
            $myDat->puntCaTot2Prom = $fila["puntCaTot2Prom"];
            $myDat->puntCaTot3Prom = $fila["puntCaTot3Prom"];

            $myDat->puntCcTot1Prom = $fila["puntCcTot1Prom"];
            $myDat->puntCcTot2Prom = $fila["puntCcTot2Prom"];
            $myDat->puntCcTot3Prom = $fila["puntCcTot3Prom"];

            $myDat->puntCoTot1Prom = $fila["puntCoTot1Prom"];
            $myDat->puntCoTot2Prom = $fila["puntCoTot2Prom"];
            $myDat->puntCoTot3Prom = $fila["puntCoTot3Prom"];

            $myDat->text_CoTotal = $fila["text_CoTotal"];
            $myDat->analisis_cumpli = $fila["analisis_cumpli"];
            $myDat->analisis_ejec = $fila["analisis_ejec"];
            $myDat->analisis_calidad = $fila["analisis_calidad"];
        }
    }


    $consulta = "SELECT * FROM para_calf_contratista WHERE id_cont= '" . $idCont . "' ";
    $resultado1 = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $myDat->PorCO = $fila["PorCO"];
            $myDat->PorCE = $fila["PorCE"];
            $myDat->PorCC = $fila["PorCC"];
        }
    }


    ///////CONSULTA CALIF CONT PRESTACIÓN
    $consulta = "SELECT * FROM resul_contprestacion WHERE cont_resul_contprestacion= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);
    $cont = 0;
    $resul_contPre = "";
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $cont++;
            $resul_contPre .= $fila["criterio_resul_contprestacion"] . "-" . $fila["tipocrit_resul_contprestacion"] . "//" . $fila["puntaje_resul_contprestacion"] . ";";
        }
    }
    $myDat->contPres = $cont;
    $myDat->resul_contpres = substr($resul_contPre, 0, -1);


    ////CONSULTA CALIF. CONT. SUMINISTRO
    $consulta = "SELECT * FROM resul_contsuministro WHERE cont_resulsuministro= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);
    $cont = 0;
    $resul_contSumin = "";
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $cont++;
            $resul_contSumin .= $fila["criterio_resulsuministro"] . "-" . $fila["tipocrit_resulsuministro"] . "//" . $fila["puntaje_resulsuministro"] . ";";
        }
    }
    $myDat->contSumin = $cont;
    $myDat->resul_contSumin = substr($resul_contSumin, 0, -1);


    ////CONSULTA CALIF. CONT. ARRENDAMIENTO
    $consulta = "SELECT * FROM resul_contarrendam WHERE cont_resul_contarrendam= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);
    $cont = 0;
    $resul_contArrend = "";
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $cont++;
            $resul_contArrend .= $fila["criterio_resul_contarrendam"] . "-" . $fila["tipocrit_resul_contarrendam"] . "//" . $fila["puntaje_resul_contarrendam"] . ";";
        }
    }
    $myDat->contArre = $cont;
    $myDat->resul_contArrend = substr($resul_contArrend, 0, -1);

    ////CONSULTA CALIF. CONT. CONSULTORIA
    $consulta = "SELECT * FROM resul_contconsultoria WHERE cont_resul_contconsultoria= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);
    $cont = 0;
    $resul_contConsult = "";
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $cont++;
            $resul_contConsult .= $fila["criterio_resul_contconsultoria"] . "-" . $fila["tipocrit_resul_contconsultoria"] . "//" . $fila["puntaje_resul_contconsultoria"] . ";";
        }
    }
    $myDat->contConsul = $cont;
    $myDat->resul_contConsult = substr($resul_contConsult, 0, -1);

    ////CONSULTA CALIF. CONT. OBRA
    $consulta = "SELECT * FROM resul_contobra WHERE cont_resul_contobra= '" . $_POST["cod"] . "' ";
    $resultado1 = mysqli_query($link, $consulta);
    $cont = 0;
    $resul_contObra = "";
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $cont++;
            $resul_contObra .= $fila["criterio_resul_contobra"] . "-" . $fila["tipocrit_resul_contobra"] . "//" . $fila["puntaje_resul_contobra"] . ";";
        }
    }
    $myDat->contObra = $cont;
    $myDat->resul_contObra = substr($resul_contObra, 0, -1);


    $consulta = "select * from para_calf_contratista";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->PorCO = $fila["PorCO"];
            $myDat->PorCC = $fila["PorCC"];
            $myDat->PorCE = $fila["PorCE"];
        }
    }


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargClasif") {

    $myDat = new stdClass();

    $cont = 0;
    $CadClasif = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Código
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Descripci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody>";

    $consulta = "select * from clasificacion_proyecto where tipolog=" . $_POST["tip"] . "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadClasif .= '<tr class="selected" id="filaClasif' . $cont . '" >';

            $CadClasif .= "<td>" . $cont . "</td>";
            $CadClasif .= "<td>" . $fila["cod_clasif"] . "</td>";
            $CadClasif .= "<td>" . $fila["desc"] . "</td>";
            $CadClasif .= "<td><input type='hidden' id='idClasif" . $cont . "' name='idIndi' value='" . $fila["indicador"] . "' /><a onclick=\"$.QuitarClasif('" . $fila["id"] . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $CadClasif .= "</tbody>";

    $myDat->CadClasif = $CadClasif;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqInfProcSec") {

    $myDat = new stdClass();

    $cont = 0;
    $Procesos = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Descripci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Clade de Proceso
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody>";

    $consulta = "select * from procesos where secretaria=" . $_POST["cod"] . " and estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $Cod = $fila["id"];
            $Procesos .= '<tr class="selected" id="filaClasif' . $cont . '" >';

            $Procesos .= "<td>" . $cont . "</td>";
            $Procesos .= "<td>" . $fila["descripcion"] . "</td>";
            $Procesos .= "<td>" . $fila["clase"] . "</td>";
            $Procesos .= "<td><a onclick=\"$.QuitarProceso('" . $Cod . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }
    $Procesos .= "</tbody>";

    $myDat->Procesos = $Procesos;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditDependencia") {

    $myDat = new stdClass();

    $consulta = "select * from dependencias where iddependencias='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_dependencia = $fila["cod_dependencia"];
            $myDat->des_dependencia = $fila["des_dependencia"];
            $myDat->correo_dependencia = $fila["correo_dependencia"];
            $myDat->tel_dependencia = $fila["tel_dependencia"];
            $myDat->obs_dependencia = $fila["obs_dependencia"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditPresupuesto") {

    $myDat = new stdClass();

    $consulta = "select * from presupuesto_total where id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fuente = $fila["fuente"];
            $myDat->valor = $fila["valor"];
            $myDat->fecha_recepcion = $fila["fecha_recepcion"];
            $myDat->periodo_ini = $fila["periodo_ini"];
            $myDat->periodo_fin = $fila["periodo_fin"];
            $myDat->observacion = $fila["observacion"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditfuenteInf") {

    $myDat = new stdClass();

    $consulta = "select * from fuente_informacion where id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nombre = $fila["nombre"];
            $myDat->descripcion = $fila["descripcion"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "DelImgProy") {

    mysqli_query($link, "BEGIN");

    $consulta = "DELETE FROM proyecto_galeria WHERE proyect_galeria='" . $_POST['cod'] . "' and id_galeria='" . $_POST['fil'] . "'";
    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }

    if ($success == 0) {
        mysqli_query($link, "ROLLBACK");
        echo $error;
        echo $consulta;
    } else {
        mysqli_query($link, "COMMIT");
        echo "bien";
    }
} else if ($_POST['ope'] == "DelAvanceCont") {

    mysqli_query($link, "BEGIN");

    $consulta = "DELETE FROM contratos WHERE id_contrato='" . $_POST['cod'] . "'";
    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }


    $sql = "SELECT MAX(id_contrato) AS id FROM contratos";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Cont = $fila["id"];
        }
    }

    if ($success == 0) {
        mysqli_query($link, "ROLLBACK");
        echo $error;
        echo $consulta;
    } else {
        mysqli_query($link, "COMMIT");
        echo "bien/" . $id_Cont;
    }
} else if ($_POST['ope'] == "DelImgCont") {

    mysqli_query($link, "BEGIN");

    $consulta = "DELETE FROM contrato_galeria WHERE num_contrato_galeria='" . $_POST['cod'] . "' and id_galeria='" . $_POST['fil'] . "'";
    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 20;
    }

    if ($success == 0) {
        mysqli_query($link, "ROLLBACK");
        echo $error;
        echo $consulta;
    } else {
        mysqli_query($link, "COMMIT");
        echo "bien";
    }
} else if ($_POST['ope'] == "CargaAvancesProy") {

    $myDat = new stdClass();


    //galeria de imagenes

    $consulta = "SELECT * FROM proyecto_galeria WHERE proyect_galeria= '" . $_POST["cod"] . "' ";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Img = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Imagenes de\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Fecha\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contImg = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contImg++;
            $Tab_Img .= "<tr class='selected' id='filaImg" . $contImg . "' ><td>" . $contImg . "</td>";
            $Tab_Img .= "<td>" . $fila["img_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["tip_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["fecha"] . "</td>";
            $Tab_Img .= "<td><input type='hidden' id='idImg" . $contImg . "' "
                . "name='terce' value='" . $fila["tip_galeria"] . "//" . $fila["img_galeria"] . "//" . $fila["formato_galeria"] . "//" . $fila["fecha"] . "' />"
                . "<a onclick=\"$.QuitarImg('" . $fila["id_galeria"] . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Quitar</a>"
                . "<a onclick=\"$.VerImg('../Proyecto/GaleriaProyecto/" . $_SESSION['ses_complog'] . "/" . $fila["num_proyect_galeria"] . "/" . $fila["img_galeria"] . "*" . $fila["formato_galeria"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>"
                . "</td></tr>";
        }
    }
    $Tab_Img .= "</tbody>";
    $myDat->Tab_Img = $Tab_Img;
    $myDat->contImg = $contImg;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaAvancesCont") {

    $myDat = new stdClass();


    //galeria de imagenes

    $consulta = "SELECT * FROM contrato_galeria WHERE num_contrato_galeria= '" . $_POST["cod"] . "' ";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Img = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Imagenes de\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i>  Fecha\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Loca' >\n";

    $contImg = 0;
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contImg++;
            $Tab_Img .= "<tr class='selected' id='filaImg" . $contImg . "' ><td>" . $contImg . "</td>";
            $Tab_Img .= "<td>" . $fila["img_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["tip_galeria"] . "</td>";
            $Tab_Img .= "<td>" . $fila["fecha"] . "</td>";
            $Tab_Img .= "<td><input type='hidden' id='idImg" . $contImg . "' "
                . "name='terce' value='" . $fila["tip_galeria"] . "//" . $fila["img_galeria"] . "//" . $fila["formato_galeria"] . "//" . $fila["fecha"] . "' />"
                . "<a onclick=\"$.QuitarImg('" . $fila["id_galeria"] . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Quitar</a>"
                . "<a onclick=\"$.VerImg('../Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $fila["num_contrato_galeria"] . "/" . $fila["img_galeria"] . "*" . $fila["formato_galeria"] . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-search\"></i> Ver</a>"
                . "</td></tr>";
        }
    }
    $Tab_Img .= "</tbody>";
    $myDat->Tab_Img = $Tab_Img;
    $myDat->contImg = $contImg;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditContratista") {

    $myDat = new stdClass();

    $consulta = "select * from contratistas where id_contratis='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->tper_contratis = $fila["tper_contratis"];
            $myDat->tid_contratis = $fila["tid_contratis"];
            $myDat->ident_contratis = $fila["ident_contratis"];
            $myDat->dv_contratis = $fila["dv_contratis"];
            $myDat->nom_contratis = $fila["nom_contratis"];
            $myDat->telcon_contratis = $fila["telcon_contratis"];
            $myDat->dircon_contratis = $fila["dircon_contratis"];
            $myDat->corcont_contratis = $fila["corcont_contratis"];
            $myDat->idrpr_contratis = $fila["idrpr_contratis"];
            $myDat->nomrpr_contratis = $fila["nomrpr_contratis"];
            $myDat->telrpr_contratis = $fila["telrpr_contratis"];
            $myDat->depart_contratis = $fila["depart_contratis"];
            $myDat->mun_contratis = $fila["mun_contratis"];
            $myDat->observ_contratist = $fila["observ_contratist"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsulTodo") {

    $myDat = new stdClass();
    $depend = "";
    $ejes = "<option value=' '>Seleccione...</option>";
    $respon = "";
    $estrat = "";
    $prog = "";
    $fuente = "";
    $clasif = "<option value='NO APLICA'>NO APLICA...</option>";
    $DerFund = "<option value='NO APLICA'>NO APLICA...</option>";

    //////////////////////CONSULTAR DEPENDENCIAS
    $consulta = "select * from dependencias where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $depend .= "<option value='" . $fila["iddependencias"] . "'>" . $fila["cod_dependencia"] . " - " . $fila["des_dependencia"] . "</option>";
        }
    }

    //////////////////////CONSULTAR FUENTE
    $consulta = "select * from fuente_informacion where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $fuente .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }
    /////////////////////CONSULTAR EJES
    $consulta = "select * from ejes where ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ejes .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }
    /////////////////////CONSULTAR CLASIFICACION INTEGRAL
    $consulta = "select * from clasif_integral where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $clasif .= "<option value='" . $fila["id"] . "'>" . $fila["descripcion"] . "</option>";
        }
    }
    /////////////////////CONSULTAR DERECHO FUNDAMENTAL
    $consulta = "select * from derecho_fundamental where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $DerFund .= "<option value='" . $fila["id"] . "'>" . $fila["descripcion"] . "</option>";
        }
    }

    $myDat->depend = $depend;
    $myDat->ejes = $ejes;
    $myDat->clasif = $clasif;
    $myDat->DerFund = $DerFund;
    $myDat->fuente = $fuente;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "dimensiones") {

    $myDat = new stdClass();
    $Dime = "<option value=' '>Seleccione...</option>";


    //////////////////////CONSULTAR DIMENSIONES
    $consulta = "select * from dimensiones where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Dime .= "<option value='" . $fila["id"] . "'>" . $fila["descripcion"] . "</option>";
        }
    }

    $myDat->Dime = $Dime;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsulDepend") {

    $myDat = new stdClass();
    $depend = "<option value=' '>Seleccione...</option>";


    //////////////////////CONSULTAR DEPENDENCIAS
    $consulta = "select * from dependencias where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $depend .= "<option value='" . $fila["iddependencias"] . "'>" . $fila["cod_dependencia"] . " - " . $fila["des_dependencia"] . "</option>";
        }
    }
    $myDat->depend = $depend;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenSecretaria") {
    $myDat = new stdClass();

    $consulta = "SELECT SUM(valor) totalpre FROM presupuesto_secretarias WHERE id_secretaria='" . $_POST['Secre'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->totalpre = $fila["totalpre"];
        }
    }



    $consulta = "SELECT COUNT(*) cant,estado_proyect  FROM (
SELECT 
    COUNT(cod_proyect), cod_proyect,nombre_proyect,estado_proyect
 FROM  proyectos proy
LEFT JOIN proyect_metas proymet
    ON proy.id_proyect = proymet.cod_proy

  LEFT JOIN secretarias sec
    ON proy.secretaria_proyect=sec.idsecretarias
WHERE IFNULL(proy.secretaria_proyect, '') = '" . $_POST['Secre'] . "'
  AND proy.estado='ACTIVO'  
GROUP BY id_proyect) AS t GROUP BY estado_proyect";
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
    $myDat->rawdata = $rawdata;

    //////////////CONSULTA DE METAS TRAZADORAS    

    $consulta = "SELECT 
    proy.id_proyect idproy,  CONCAT(cod_proyect,' - ',nombre_proyect) nombre,  proy.estado_proyect estado
    FROM
     proyectos proy 
     LEFT JOIN proyect_metas pm 
       ON proy.id_proyect=pm.cod_proy 
     WHERE proy.secretaria_proyect = '" . $_POST['Secre'] . "' AND proy.estado='ACTIVO' GROUP BY idproy
     ORDER BY cod_proy";

    //   echo $consulta;
    $RawProyM = array(); //creamos un array
    $RawMet = array(); //creamos un array
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $consulta = "SELECT 
            desc_met desme
          FROM
            proyectos proy 
            RIGHT JOIN proyect_metas pm 
              ON proy.id_proyect=pm.cod_proy 
            WHERE proy.secretaria_proyect = '" . $_POST['Secre'] . "' AND proy.estado='ACTIVO' AND proy.id_proyect='" . $fila['idproy'] . "'
            ORDER BY cod_proy";
            //            echo $consulta;
            $contMet = 1;
            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($filaM = mysqli_fetch_array($resultado2)) {
                    $RawMet[] = array(
                        "desmet" => $contMet . '. ' . $filaM['desme']
                    );
                    $contMet++;
                }
            } else {
                $RawMet[] = array(
                    "desmet" => 'El proyecto no Tiene una Meta Trazadara Relacionada.'
                );
            }

            $RawProyM[] = array(
                "nombre" => $fila['nombre'],
                "estado" => $fila['estado'],
                "Metas" => $RawMet
            );
            unset($RawMet);
        }
    }
    $myDat->RawProyM = $RawProyM;

    /////////CONTRATOS POR PROYECTOS
    $totalInv = 0;

    $consulta = "SELECT 
  proy.id_proyect idproy,
  proy.cod_proyect codproy,
  proy.nombre_proyect nomb,
  proy.secretaria_proyect,
  sec.idsecretarias,
  proy.estado_proyect estado
FROM
   proyectos proy   
  LEFT JOIN secretarias sec 
    ON proy.secretaria_proyect = sec.idsecretarias 
WHERE IFNULL(proy.secretaria_proyect, '') = '" . $_POST['Secre'] . "' AND estado='ACTIVO'
GROUP BY codproy 
ORDER BY nomb DESC";
    //echo $consulta;
    $proyect = array();
    $Contrat = array();

    $resultado2 = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {

            $consulta = "SELECT 
contr.num_contrato ncont,contr.obj_contrato obj,
 contr.descontrati_contrato descontita,
 contr.estad_contrato estado,contr.vfin_contrato total
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
 LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias 
WHERE contr.estcont_contra='Verificado' AND contr.idproy_contrato='" . $fila2['idproy'] . "' 
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) GROUP BY ncont ORDER BY total DESC";

            $resultado3 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado3) > 0) {
                while ($fila3 = mysqli_fetch_array($resultado3)) {

                    $Contrat[] = array(
                        "ncont" => $fila3['ncont'],
                        "obj" => $fila3['obj'],
                        "descontita" => $fila3['descontita'],
                        "total" => "$ " . number_format($fila3["total"], 2, ",", "."),
                        "estado" => $fila3["estado"]
                    );

                    $totalInv = $totalInv + $fila3["total"];
                }
            } else {
                $Contrat[] = array(
                    "ncont" => 'No'
                );
            }

            $proyect[] = array(
                "codproy" => $fila2['codproy'],
                "nombproy" => $fila2['nomb'],
                "estado" => $fila2['estado'],
                "Contratos" => $Contrat
            );
            unset($Contrat);
        }
    }


    $myDat->proyect = $proyect;
    $myDat->totalInv = $totalInv;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenMetas") {
    $myDat = new stdClass();

    $ResumMetas = array();
    $Metas = array();

    if ($_POST['CbTipMeta'] == "Trazadora") {

        $consulta = "select 
        met.id_meta idmet,
       met.cod_meta,  
       desc_meta,
       base_meta,
       met.meta met
       from
         metas met
       where ideje_metas like '" . $_POST['CbEjes'] . "%' 
         and idcomp_metas like '" . $_POST['CbProg'] . "%'
         and idprog_metas like '" . $_POST['CbSubProg'] . "%'";
        //echo $consulta;
        $Cumpl = 0;
        $Totporc = 0;
        $porcApo = 0;
        $resultado1 = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado1) > 0) {
            while ($fila1 = mysqli_fetch_array($resultado1)) {
                $TotCumpl = 0;
                $MedMetProy = array();
                $consulta = "SELECT pm.cod_proy proy, pm.id_meta met, pm.aport_proy aport  "
                    . "FROM proyect_metas pm LEFT JOIN metas met ON pm.id_meta=met.id_meta WHERE pm.id_meta='" . $fila1['idmet'] . "'";

                $resultado2 = mysqli_query($link, $consulta);
                if (mysqli_num_rows($resultado2) > 0) {

                    while ($fila2 = mysqli_fetch_array($resultado2)) {
                        $consulta = "SELECT 
  med.*,
  proy.nombre_proyect nproy,
  sec.des_secretarias nsecr 
FROM
  mediindicador med
      LEFT JOIN proyectos proy 
      ON med.proy_ori = proy.id_proyect 
    LEFT JOIN secretarias sec 
      ON proy.secretaria_proyect = sec.idsecretarias  WHERE "
                            . "med.id_meta='" . $fila2['met'] . "' and  med.proy_ori='" . $fila2['proy'] . "' "
                            . "AND med.id=(SELECT MAX(id) FROM mediindicador where id_meta='" . $fila2['met'] . "' "
                            . "and  proy_ori='" . $fila2['proy'] . "')";
                        //                        echo $consulta;
                        $resultado3 = mysqli_query($link, $consulta);
                        if (mysqli_num_rows($resultado3) > 0) {
                            while ($fila3 = mysqli_fetch_array($resultado3)) {

                                $resulindi = $fila3['resulindi'];

                                if ($fila3['plan_mejora'] == "Si") {
                                    $consulta = "SELECT * FROM mediindicador_plan WHERE id_medi='" . $fila3['id'] . "'";
                                    $resultado4 = mysqli_query($link, $consulta);
                                    if (mysqli_num_rows($resultado4) > 0) {
                                        while ($fila4 = mysqli_fetch_array($resultado2)) {
                                            $resulindi = $fila4['resulindi'];
                                        }
                                    }
                                }

                                $metproy = $fila2['aport'];

                                ///porcentaje de aporte
                                $porcApo = ($metproy * 100) / $fila1['met']; //
                                //porcentaje cumplido meta proyecto - medicion
                                $TotporcMed = ($resulindi * 100) / $metproy; //

                                $Cumpl = (round($TotporcMed, 2) * round($porcApo, 2)) / 100;

                                $TotCumpl = $TotCumpl + $Cumpl;


                                $MedMetProy[] = array(
                                    "nproy" => $fila3['nproy'],
                                    "nsecr" => $fila3['nsecr'],
                                    "meta" => $fila3['meta'],
                                    "resulindi" => $fila3['resulindi'],
                                    "Cumpl" => $Cumpl
                                );
                            }
                        }
                    }
                }

                $ResumMetas[] = array(
                    "DesMet" => $fila1['desc_meta'],
                    "Meta" => $fila1['met'],
                    "Cumplimiento" => $TotCumpl,
                    "DetMetProy" => $MedMetProy
                );
                unset($MedMetProy);
            }
        }
    } else {
    }

    $myDat->ResumMetas = $ResumMetas;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenProyEjeCont") {
    $myDat = new stdClass();


    $cad = "";

    $consulta = "SELECT 
  secr.idsecretarias idsecr,
  secr.des_secretarias dessec
FROM
  proyectos proy 
  LEFT JOIN secretarias secr 
    ON proy.secretaria_proyect = secr.idsecretarias 
WHERE proy.estado_proyect = 'En Ejecucion' 
  AND proy.secretaria_proyect LIKE '" . $_POST['Secre'] . "%' GROUP BY idsecr";

    //    echo $consulta;

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cad .= "  <div class='col-md-12' ><h3>" . $fila['dessec'] . "</h3></div>";

            $totalpre = 0;

            $consultaP = "SELECT SUM(valor) totalpre FROM presupuesto_secretarias WHERE id_secretaria='" . $fila['idsecr'] . "'";
            $resultadoP = mysqli_query($link, $consultaP);
            if (mysqli_num_rows($resultadoP) > 0) {
                while ($filaP = mysqli_fetch_array($resultadoP)) {
                    $totalpre = $filaP["totalpre"];
                }
            }


            $consulta = "SELECT 
  proy.id_proyect idproy,
  proy.nombre_proyect nomproy,
  proy.porceEjec_proyect poravan 
FROM
  proyectos proy 
  LEFT JOIN secretarias sec 
    ON proy.secretaria_proyect = sec.idsecretarias 
WHERE proy.estado_proyect = 'En Ejecucion' AND proy.secretaria_proyect='" . $fila['idsecr'] . "'
GROUP BY idproy ";

            $totalInv = 0;
            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $Cont = "";

                    $cad .= "<div class='col-md-12 text-justify ' ><blockquote><strong><em><h5>" . $fila2['nomproy'] . "(<label style='color: green;'>" . $fila2['poravan'] . " Completado</label>)</h5></em> </strong></blockquote></div>";

                    $consulta = "SELECT 
                    contr.num_contrato numcont, contr.obj_contrato obj, 
                    conttas.nom_contratis descontita,
                    contr.estad_contrato estado,contr.vfin_contrato total,
                    contr.porav_contrato porava
                   FROM
                     contratos contr 
                     LEFT JOIN proyectos proy 
                       ON contr.idproy_contrato = proy.id_proyect 
                    LEFT JOIN secretarias sec
                     ON proy.secretaria_proyect=sec.idsecretarias
                    LEFT JOIN contratistas conttas 
                    ON contr.idcontrati_contrato=conttas.id_contratis
                   WHERE contr.estcont_contra='Verificado'
                   AND contr.idproy_contrato = '" . $fila2['idproy'] . "'
                   AND contr.id_contrato IN
                     (SELECT
                       MAX(id_contrato)
                     FROM
                       contratos
                     GROUP BY num_contrato) ORDER BY total DESC";
                    $resultado3 = mysqli_query($link, $consulta);

                    $Cont .= "<table class='table table-bordered table-hover' style='border: 1; font-size: 9px; padding-top: 10px;'>" .
                        "<thead>\n" .
                        "      <tr>\n" .
                        "          <td>\n" .
                        "              <b> Número Contrato</b>\n" .
                        "          </td>\n" .
                        "          <td>\n" .
                        "              <b> Objeto del Contrato</b>\n" .
                        "          </td>\n" .
                        "          <td>\n" .
                        "              <b> Contratista</b>\n" .
                        "          </td>\n" .
                        "          <td>\n" .
                        "              <b> Valor Contrato</b>\n" .
                        "          </td>\n" .
                        "          <td>\n" .
                        "              <b> Estado</b>\n" .
                        "          </td>\n" .
                        "          <td>\n" .
                        "              <b> % de Avance</b>\n" .
                        "          </td>\n" .
                        "      </tr>\n" .
                        "  </thead>"
                        . " <tbody >";

                    if (mysqli_num_rows($resultado3) > 0) {
                        while ($fila3 = mysqli_fetch_array($resultado3)) {

                            $Cont .= "<tr><td>" . $fila3["numcont"] . "</td>";
                            $Cont .= "<td>" . $fila3["obj"] . "</td>";
                            $Cont .= "<td>" . $fila3["descontita"] . "</td>";
                            $Cont .= "<td>" . number_format($fila3["total"], 2, ",", ".") . "</td>";

                            if ($fila3["estado"] == "Ejecucion") {
                                $Cont .= "<td style='vertical-align: middle;color:#2ED26E;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                            } else if ($fila3["estado"] == "Terminado") {
                                $Cont .= "<td style='vertical-align: middle;color:#387EFC;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                            } else if ($fila3["estado"] == "Suspendido") {
                                $Cont .= "<td style='vertical-align: middle;color:#EA4359;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                            } else if ($fila3["estado"] == "Liquidado") {
                                $Cont .= "<td style='vertical-align: middle;color:#FDC20D;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                            }

                            $Cont .= "<td>" . $fila3["porava"] . "</td></tr>";
                            $totalInv = $totalInv + $fila3["total"];
                        }
                    } else {
                        $Cont .= "<tr ><td colspan='6'>Este Proyecto no Tiene ningún Contrato Asignado</td></tr>";
                    }
                    $Cont .= " </tbody></table>";
                    $cad .= $Cont;
                }
            }
            $porcinv = ($totalInv * 100) / $totalpre;

            $cad .= "DEL PRESUPUESTO ASIGNADO DE $ " . number_format($totalpre, 2, ",", ".") . " A LA " . $fila['dessec'] . " SE HAN "
                . "GASTADO UN TOTAL DE $ " . number_format($totalInv, 2, ",", ".") . " QUE EQUIVALE A UN " . round($porcinv, 2) . "% DEL PRESUPUESTO DE LA SECRETARIA.";
        }
    } else {
        $cad .= "  <div class='col-md-12' ><h4>NO EXISTEN PROYECTOS RELACIONADOS A ESTOS PARAMETROS DE BUSQUEDA </h4></div>";
    }

    $myDat->Tab_Proyectos = $cad;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenContrxSuspAtras") {
    $myDat = new stdClass();

    $cad = "";
    //
    $consulta = "TRUNCATE TABLE aux_inf_atra_sup";
    mysqli_query($link, $consulta);

    $consulta = "SELECT * FROM (SELECT 
sec.des_secretarias dsec, sec.idsecretarias idsec
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
 LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%'  AND estad_contrato='Suspendido' 
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos    
  GROUP BY num_contrato) 
 UNION ALL
 SELECT 
sec.des_secretarias dsec, sec.idsecretarias idsec
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
 LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%' AND estad_contrato='Ejecucion'  
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
    WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')  
  GROUP BY num_contrato)) AS t GROUP BY idsec";

    $Auxse1 = "";
    $Auxtip1 = "";
    $RawCon = array(); //creamos un array
    $RawConT = array(); //creamos un array
    $is = 0;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cad .= '<b><h3>' . ucwords(strtolower($fila["dsec"])) . '</h3></b>';
            $cad .= "<div id='chartdivSecre" . $is . "' style=' width: 100%; height: 400px;' class='chart'></div>";

            $totalpre = 0;

            $consultaP = "SELECT SUM(valor) totalpre FROM presupuesto_secretarias WHERE id_secretaria='" . $fila['idsec'] . "'";

            $resultadoP = mysqli_query($link, $consultaP);
            if (mysqli_num_rows($resultadoP) > 0) {
                while ($filaP = mysqli_fetch_array($resultadoP)) {
                    $totalpre = $filaP["totalpre"];
                }
            }



            $consulta = "SELECT * FROM (SELECT 
                'SUSPENDIDOS' tipc,sec.des_secretarias dsec, sec.idsecretarias idsec
                FROM
                  contratos contr 
                  LEFT JOIN proyectos proy 
                    ON contr.idproy_contrato = proy.id_proyect 
                 LEFT JOIN secretarias sec
                  ON proy.secretaria_proyect=sec.idsecretarias
                WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%'  AND estad_contrato='Suspendido' 
                AND contr.id_contrato IN
                  (SELECT
                    MAX(id_contrato)
                  FROM
                    contratos    
                  GROUP BY num_contrato) 
                 UNION ALL
                 SELECT 
                'ATRASADOS' tipc,sec.des_secretarias dsec, sec.idsecretarias idsec
                FROM
                  contratos contr 
                  LEFT JOIN proyectos proy 
                    ON contr.idproy_contrato = proy.id_proyect 
                 LEFT JOIN secretarias sec
                  ON proy.secretaria_proyect=sec.idsecretarias
                WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%' AND estad_contrato='Ejecucion'  
                AND contr.id_contrato IN
                  (SELECT
                    MAX(id_contrato)
                  FROM
                    contratos
                    WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')  
                  GROUP BY num_contrato)) AS t WHERE idsec='" . $fila['idsec'] . "'  GROUP BY tipc";
            $resultado2 = mysqli_query($link, $consulta);
            $totalInv = 0;
            $ncontAtr = 0;
            $ncontSus = 0;


            $contAtrSup = "";
            while ($fila2 = mysqli_fetch_array($resultado2)) {
                $Cont = "";
                $cad .= '<b><h4 style="font-style: italic;">Contratos ' . ucwords(strtolower($fila2["tipc"])) . '</h4></b>';
                $consulta = "SELECT * FROM (SELECT 
                            'SUSPENDIDOS' tipc, sec.des_secretarias dsec, contr.num_contrato ncont, contr.obj_contrato obj,
                            contr.porav_contrato pava, contr.vfin_contrato valorcont, contr.observacion justi, cttas.nom_contratis contta, sec.idsecretarias idsec
                            FROM
                              contratos contr 
                              LEFT JOIN proyectos proy 
                                ON contr.idproy_contrato = proy.id_proyect 
                             LEFT JOIN secretarias sec
                              ON proy.secretaria_proyect=sec.idsecretarias
                              LEFT JOIN contratistas cttas
                              ON contr.idcontrati_contrato=cttas.id_contratis
                            WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%'  AND estad_contrato='Suspendido' 
                            AND contr.id_contrato IN
                              (SELECT
                                MAX(id_contrato)
                              FROM
                                contratos    
                              GROUP BY num_contrato) 
                             UNION ALL
                             SELECT 
                            'ATRASADOS' tipc, sec.des_secretarias dsec, contr.num_contrato ncont, contr.obj_contrato obj,
                            contr.porav_contrato pava, contr.vfin_contrato valorcont, 
                            CASE WHEN just.justificacion=NULL THEN 'SIN INFORME JUSTIFICACIÓN DE ATRASO' ELSE just.justificacion END justi, cttas.nom_contratis contta,sec.idsecretarias idsec
                            FROM
                              contratos contr 
                              LEFT JOIN proyectos proy 
                                ON contr.idproy_contrato = proy.id_proyect 
                             LEFT JOIN secretarias sec
                              ON proy.secretaria_proyect=sec.idsecretarias
                               LEFT JOIN justif_atraso_cont just ON contr.id_contrato=just.contrato
                                 LEFT JOIN contratistas cttas
                              ON contr.idcontrati_contrato=cttas.id_contratis
                            WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%' AND estad_contrato='Ejecucion'  
                            AND contr.id_contrato IN
                              (SELECT
                                MAX(id_contrato)
                              FROM
                                contratos
                                WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')  
                              GROUP BY num_contrato)) AS t WHERE idsec='" . $fila['idsec'] . "' and tipc='" . $fila2['tipc'] . "'";

                $resultado3 = mysqli_query($link, $consulta);

                $Cont .= "<table class='table table-bordered table-hover' style='border: 1; font-size: 9px; padding-top: 10px;'>" .
                    "<thead>\n" .
                    "      <tr>\n" .
                    "          <td>\n" .
                    "              <b> Número Contrato</b>\n" .
                    "          </td>\n" .
                    "          <td>\n" .
                    "              <b> Objeto del Contrato</b>\n" .
                    "          </td>\n" .
                    "          <td>\n" .
                    "              <b> Contratista</b>\n" .
                    "          </td>\n" .
                    "          <td>\n" .
                    "              <b> Valor Contrato</b>\n" .
                    "          </td>\n" .
                    "          <td>\n" .
                    "              <b> % de Avance</b>\n" .
                    "          </td>\n" .
                    "          <td>\n" .
                    "              <b> Justificación</b>\n" .
                    "          </td>\n" .
                    "      </tr>\n" .
                    "  </thead>"
                    . " <tbody >";



                while ($fila3 = mysqli_fetch_array($resultado3)) {
                    if ($fila3["tipc"] == "ATRASADOS") {
                        $ncontAtr++;
                    } else {
                        $ncontSus++;
                    }
                    $contAtrSup .= "'" . $fila3["ncont"] . "'" . ",";
                    $Cont .= "<tr><td>" . $fila3["ncont"] . "</td>";
                    $Cont .= "<td>" . $fila3["obj"] . "</td>";
                    $Cont .= "<td>" . $fila3["contta"] . "</td>";
                    $Cont .= "<td>$ " . number_format($fila3["valorcont"], 2, ",", ".") . "</td>";
                    $Cont .= "<td>" . $fila3["pava"] . "</td>";
                    $Cont .= "<td>" . $fila3["justi"] . "</td></tr>";
                    $totalInv = $totalInv + $fila3["valorcont"];
                }



                $Cont .= " </tbody></table>";
                $cad .= $Cont;
            }
            $contAtrSup = trim($contAtrSup, ',');

            $consultaCont = "SELECT 
            contr.id_contrato idcon,
              contr.num_contrato numcont,
              contr.obj_contrato obj 
            FROM
              contratos contr 
              LEFT JOIN proyectos proy 
                ON contr.idproy_contrato = proy.id_proyect 
              LEFT JOIN secretarias sec 
                ON proy.secretaria_proyect = sec.idsecretarias 
              LEFT JOIN contratistas conttas 
                ON contr.idcontrati_contrato = conttas.id_contratis 
            WHERE contr.estcont_contra = 'Verificado' AND proy.secretaria_proyect='" . $fila['idsec'] . "'

              AND contr.id_contrato IN 
              (SELECT 
                MAX(id_contrato) 
              FROM
                contratos 
                WHERE  num_contrato NOT IN (" . $contAtrSup . ")
              GROUP BY num_contrato)";

            $OtrCont = 0;

            $resultadoCont = mysqli_query($link, $consultaCont);
            $OtrCont = mysqli_num_rows($resultadoCont);

            $RawCon[] = array(
                "cant" => $OtrCont,
                "cate" => "Otros estado Contratos"
            );
            $RawCon[] = array(
                "cant" => $ncontAtr,
                "cate" => "Contratos Atrasados"
            );
            $RawCon[] = array(
                "cant" => $ncontSus,
                "cate" => "Contratos Suspendidos"
            );

            $RawConT[$is] = array(
                "estados" => $RawCon
            );



            $porcinv = ($totalInv * 100) / $totalpre;

            $cad .= "<h6 style='font-style: italic;'>LA " . $fila['dsec'] . " POSEE " . $ncontAtr . " CONTRATO ATRASADO(S) Y " . $ncontSus . " SUSPENDIDO(S) LO CUAL REPRESENTAN "
                . "EL <b>" . round($porcinv, 2) . "%</b> ($ " . number_format($totalInv, 2, ",", ".") . ") DEL PRESUPUESTO GENERAL ($ " . number_format($totalpre, 2, ",", ".") . ")</h6>";
            unset($RawCon);
            $is++;
        }
    }
    $myDat->RawCon = $RawConT;
    $myDat->Tab_Contratos = $cad;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenProyEjeCont2") {
    $myDat = new stdClass();


    $cad = "<div class='col-md-12 text-center' ><h3>INFORME GENERAL DE PROYECTOS EN EJECUCIÓN</h3></div>";

    $consulta = "SELECT 
  secr.idsecretarias idsecr,
  secr.des_secretarias dessec
FROM
  proyectos proy 
  LEFT JOIN secretarias secr 
    ON proy.secretaria_proyect = secr.idsecretarias 
WHERE proy.estado_proyect = 'En Ejecucion' 
  AND proy.secretaria_proyect LIKE '" . $_POST['Secre'] . "%' GROUP BY idsecr";

    $RawSec = array(); //creamos un array
    $RawPro = array(1000); //creamos un array
    $RawCon = array(); //creamos un array
    $is = 0;
    $ip = 0;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $RawSec[] = array(
                "dessec" => $fila['dessec']
            );

            $totalpre = 0;

            $consultaP = "SELECT SUM(valor) totalpre FROM presupuesto_secretarias WHERE id_secretaria='" . $fila['idsecr'] . "'";
            $resultadoP = mysqli_query($link, $consultaP);
            if (mysqli_num_rows($resultadoP) > 0) {
                while ($filaP = mysqli_fetch_array($resultadoP)) {
                    $totalpre = $filaP["totalpre"];
                }
            }

            $consulta = "SELECT 
            proy.id_proyect idproy,
            proy.nombre_proyect nomproy,
            proy.porceEjec_proyect poravan 
          FROM
            proyectos proy 
            LEFT JOIN secretarias sec 
              ON proy.secretaria_proyect = sec.idsecretarias 
          WHERE proy.estado_proyect = 'En Ejecucion' AND proy.secretaria_proyect='" . $fila['idsecr'] . "'
          GROUP BY idproy ";
            //            echo $consulta;
            $totalInv = 0;
            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $Cont = "";

                    $consulta = "SELECT 
                    contr.num_contrato numcont, contr.obj_contrato obj, 
                    conttas.nom_contratis descontita,
                    contr.estad_contrato estado,contr.vfin_contrato total,
                    contr.porav_contrato porava
                   FROM
                     contratos contr 
                     LEFT JOIN proyectos proy 
                       ON contr.idproy_contrato = proy.id_proyect 
                    LEFT JOIN secretarias sec
                     ON proy.secretaria_proyect=sec.idsecretarias
                    LEFT JOIN contratistas conttas 
                    ON contr.idcontrati_contrato=conttas.id_contratis
                   WHERE contr.estcont_contra='Verificado'
                   AND contr.idproy_contrato = '" . $fila2['idproy'] . "'
                   AND contr.id_contrato IN
                     (SELECT
                       MAX(id_contrato)
                     FROM
                       contratos
                     GROUP BY num_contrato) ORDER BY total DESC";
                    $resultado3 = mysqli_query($link, $consulta);
                    if (mysqli_num_rows($resultado3) > 0) {
                        while ($fila3 = mysqli_fetch_array($resultado3)) {

                            $RawCon[] = array(
                                "numcont" => $fila3['numcont'],
                                "obj" => $fila3['obj'],
                                "descontita" => $fila3['descontita'],
                                "total" => "$ " . number_format($fila3["total"], 2, ",", "."),
                                "estado" => $fila3["estado"],
                                "porava" => $fila3["porava"]
                            );

                            $totalInv = $totalInv + $fila3["total"];
                        }
                    } else {
                        $RawCon[] = array(
                            "numcont" => "NOHAY"
                        );
                    }
                    $RawProy[$ip] = array(
                        "nomproy" => $fila2['nomproy'],
                        "poravan" => $fila2['poravan'],
                        "Contratos" => $RawCon
                    );
                    unset($RawCon);
                    $ip++;

                    $porcinv = ($totalInv * 100) / $totalpre;

                    $ResInv = "DEL PRESUPUESTO ASIGNADO DE $ " . number_format($totalpre, 2, ",", ".") . " A LA " . $fila['dessec'] . " SE HAN "
                        . "GASTADO UN TOTAL DE $ " . number_format($totalInv, 2, ",", ".") . " QUE EQUIVALE A UN " . round($porcinv, 2) . "% DEL PRESUPUESTO DE LA SECRETARIA.";


                    $RawSec[$is] = array(
                        "dessec" => $fila['dessec'],
                        "ResInv" => $ResInv,
                        "proy" => $RawProy
                    );
                }
                unset($RawProy);
                $is++;
            }
        }
    }
    $myDat->RawSec = $RawSec;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenEvalCont") {
    $myDat = new stdClass();
    $RawCtta = array(); //CONTRATISTAS
    $RawEva = array(1000); //EVALUACION
    $RawCriF = array(); //CRITERIOS FORTALEZA
    $RawCriD = array(); //CRITERIOS DEBILIDAD   
    $RawHisC = array(); //HISTORIAL DE CONTRATO 
    $RawOtEv = array(); //HISTORIAL DE CONTRATO 
    $ic = 0;
    $ie = 0;


    $consulta = "SELECT 
  ev.nitcont_evaluacion idctta, cttas.nom_contratis nomb
FROM
  contratistas cttas 
  RIGHT JOIN eval_contratista ev 
    ON ev.nitcont_evaluacion = cttas.ident_contratis
  WHERE ev.ncont_evaluacion LIKE '" . $_POST['Ncont'] . "%' GROUP BY nomb ORDER BY nomb";

    //    echo $consulta;

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $RawCtta[] = array(
                "nombCtta" => $fila['nomb']
            );

            $consulta2 = "SELECT 
            ev.id_evaluacion idev,ctr.num_contrato ncont, ctr.obj_contrato obj, ctr.vfin_contrato valor, 
            CONCAT(proy.cod_proyect,' - ',proy.nombre_proyect) nproy, sec.des_secretarias secret,
            ev.clacont_evaluacion  tip, ev.feval_evaluacion fecha,ev.freeval_evaluacion fecharev,
            ev.puntPsTot1, ev.puntPsTot2,ev.puntPsTot3,text_PsTotal,
            ev.puntSaTot1, ev.puntSaTot2, ev.puntSaTot3, ev.text_SaTotal,
            ev.puntCaTot1, ev.puntCaTot2, ev.puntCaTot3, ev.text_CaTotal,
            ev.puntCcTot1, ev.puntCcTot2, ev.puntCcTot3, ev.text_CcTotal,
            ev.puntCoTot1, ev.puntCoTot2, ev.puntCoTot3, ev.text_CoTotal,
            ev.analisis_cumpli, ev.analisis_ejec, ev.analisis_calidad,
            ev.clacont_evaluacion clasf,ev.eval_evaluacion eval,
            ev.PorCO, ev.PorCE, ev.PorCC
         FROM
           eval_contratista ev 
           LEFT JOIN contratos ctr 
             ON ev.idcont_evaluacion = ctr.id_contrato
             LEFT JOIN proyectos proy
             ON ctr.idproy_contrato=proy.id_proyect
             LEFT JOIN secretarias sec
             ON proy.secretaria_proyect=sec.idsecretarias
        WHERE ev.nitcont_evaluacion='" . $fila['idctta'] . "' and ev.ncont_evaluacion like '" . $_POST['Ncont'] . "%' AND 
          id_evaluacion IN (SELECT MAX(id_evaluacion) FROM eval_contratista WHERE estado_evaluacion='ACTIVO' AND nitcont_evaluacion = '" . $fila['idctta'] . "' AND ncont_evaluacion LIKE '" . $_POST['Ncont'] . "%')";
            //           echo $consulta2;
            $totalInv = 0;
            $IdEval = "";
            $resultado2 = mysqli_query($link, $consulta2);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $Cont = "";
                    $IdEval = $fila2['idev'];
                    $Clasf = explode(" ", $fila2['clasf']);
                    if ($Clasf[0] == "1") {
                        $consultaF = "SELECT criterio_resul_contprestacion criterio, puntaje_resul_contprestacion punt, "
                            . "tipocrit_resul_contprestacion tipcrit FROM resul_contprestacion WHERE "
                            . "cont_resul_contprestacion='" . $fila2['idev'] . "' AND puntaje_resul_contprestacion>=4";
                        $consultaD = "SELECT criterio_resul_contprestacion criterio, puntaje_resul_contprestacion punt, "
                            . "tipocrit_resul_contprestacion tipcrit FROM resul_contprestacion WHERE "
                            . "cont_resul_contprestacion='" . $fila2['idev'] . "' AND puntaje_resul_contprestacion<3";
                    } else if ($Clasf[0] == "2") {
                        $consultaF = "SELECT criterio_resulsuministro criterio, puntaje_resulsuministro punt, "
                            . "tipocrit_resulsuministro tipcrit FROM resul_contsuministro "
                            . "WHERE cont_resulsuministro='" . $fila2['idev'] . "' AND puntaje_resulsuministro>=4";
                        $consultaD = "SELECT criterio_resulsuministro criterio, puntaje_resulsuministro punt, "
                            . "tipocrit_resulsuministro tipcrit FROM resul_contsuministro "
                            . "WHERE cont_resulsuministro='" . $fila2['idev'] . "' AND puntaje_resulsuministro<3";
                    } else if ($Clasf[0] == "3") {
                        $consultaF = "SELECT criterio_resul_contarrendam criterio, puntaje_resul_contarrendam punt, "
                            . "tipocrit_resul_contarrendam tipcrit FROM resul_contarrendam WHERE "
                            . "cont_resul_contarrendam='" . $fila2['idev'] . "' AND puntaje_resul_contarrendam>=4";
                        $consultaD = "SELECT criterio_resul_contarrendam criterio, puntaje_resul_contarrendam punt, "
                            . "tipocrit_resul_contarrendam tipcrit FROM resul_contarrendam WHERE "
                            . "cont_resul_contarrendam='" . $fila2['idev'] . "' AND puntaje_resul_contarrendam<3";
                    } else if ($Clasf[0] == "4") {
                        $consultaF = "SELECT criterio_resul_contconsultoria criterio, puntaje_resul_contconsultoria punt, "
                            . "tipocrit_resul_contconsultoria tipcrit FROM resul_contconsultoria WHERE "
                            . "cont_resul_contconsultoria='" . $fila2['idev'] . "' AND puntaje_resul_contconsultoria>=4";
                        $consultaD = "SELECT criterio_resul_contconsultoria criterio, puntaje_resul_contconsultoria punt, "
                            . "tipocrit_resul_contconsultoria tipcrit FROM resul_contconsultoria WHERE "
                            . "cont_resul_contconsultoria='" . $fila2['idev'] . "' AND puntaje_resul_contconsultoria<3";
                    } else {
                        $consultaF = "SELECT criterio_resul_contobra criterio, puntaje_resul_contobra punt, "
                            . "tipocrit_resul_contobra tipcrit FROM resul_contobra WHERE "
                            . "cont_resul_contobra='" . $fila2['idev'] . "' AND puntaje_resul_contobra>=4";
                        $consultaD = "SELECT criterio_resul_contobra criterio, puntaje_resul_contobra punt, "
                            . "tipocrit_resul_contobra tipcrit FROM resul_contobra WHERE "
                            . "cont_resul_contobra='" . $fila2['idev'] . "' AND puntaje_resul_contobra<3";
                    }

                    //ALMACENAR FORTALEZAS
                    $ContF = 0;
                    $ContD = 0;

                    $resultadoF = mysqli_query($link, $consultaF);
                    while ($filaF = mysqli_fetch_array($resultadoF)) {

                        $RawCriF[] = array(
                            "criterioF" => $filaF['criterio'],
                            "puntF" => $filaF['punt'],
                            "tipcritF" => $filaF['tipcrit']
                        );
                        $ContF++;
                    }

                    $resultadoD = mysqli_query($link, $consultaD);
                    while ($filaD = mysqli_fetch_array($resultadoD)) {

                        $RawCriD[] = array(
                            "criterioD" => $filaD['criterio'],
                            "puntD" => $filaD['punt'],
                            "tipcritD" => $filaD['tipcrit']
                        );
                        $ContD++;
                    }

                    $PuntCO = "";
                    $PuntCE = "";
                    $PuntCC = "";
                    $PuntTo = "";
                    $Anali = "";

                    if ($Clasf[0] == "1") {
                        $PuntCO = $fila2['puntPsTot1'];
                        $PuntCE = $fila2['puntPsTot2'];
                        $PuntCC = $fila2['puntPsTot3'];
                        $PuntTo = $fila2['text_PsTotal'];
                    } else if ($Clasf[0] == "2") {
                        $PuntCO = $fila2['puntSaTot1'];
                        $PuntCE = $fila2['puntSaTot2'];
                        $PuntCC = $fila2['puntSaTot3'];
                        $PuntTo = $fila2['text_SaTotal'];
                    } else if ($Clasf[0] == "3") {
                        $PuntCO = $fila2['puntCaTot1'];
                        $PuntCE = $fila2['puntCaTot2'];
                        $PuntCC = $fila2['puntCaTot3'];
                        $PuntTo = $fila2['text_CaTotal'];
                    } else if ($Clasf[0] == "4") {
                        $PuntCO = $fila2['puntCcTot1'];
                        $PuntCE = $fila2['puntCcTot2'];
                        $PuntCC = $fila2['puntCcTot3'];
                        $PuntTo = $fila2['text_CcTotal'];
                    } else {
                        $PuntCO = $fila2['puntCoTot1'];
                        $PuntCE = $fila2['puntCoTot2'];
                        $PuntCC = $fila2['puntCoTot3'];
                        $PuntTo = $fila2['text_CoTotal'];
                    }
                    if ($fila2['eval'] == "si") {
                        $feval = $fila2['fecha'];
                    } else {
                        $feval = $fila2['fecharev'];
                    }

                    $RawEva[$ie] = array(
                        "ncont" => $fila2['ncont'],
                        "obj" => $fila2['obj'],
                        "valor" => "$ " . number_format($fila2['valor'], 2, ",", "."),
                        "nproy" => $fila2['nproy'],
                        "secret" => $fila2['secret'],
                        "fecha" => $feval,
                        "ContD" => $ContD,
                        "ContF" => $ContF,
                        "CritFort" => $RawCriF,
                        "CritDebi" => $RawCriD,
                        "PuntCO" => $PuntCO,
                        "PuntCE" => $PuntCE,
                        "PuntCC" => $PuntCC,
                        "PuntTo" => $PuntTo,
                        "PorCO" => $fila2['PorCO'],
                        "PorCE" => $fila2['PorCE'],
                        "PorCC" => $fila2['PorCC'],
                        "analisis_cumpli" => $fila2['analisis_cumpli'],
                        "analisis_ejec" => $fila2['analisis_ejec'],
                        "analisis_calidad" => $fila2['analisis_calidad']
                    );

                    unset($RawCriF);
                    unset($RawCriD);
                    $ie++;
                    $ContC = 0;
                    if ($_POST['Ncont'] != "") {
                        $consultaH = "SELECT  num_contrato, obj_contrato, estad_contrato FROM contratos WHERE idcontrati_contrato='" . $fila['idctta'] . "' AND  num_contrato <> '" . $_POST['Ncont'] . "' AND estcont_contra='Verificado'  AND id_contrato IN (SELECT MAX(id_contrato) FROM contratos GROUP BY num_contrato) GROUP BY num_contrato ";
                        $resultadoH = mysqli_query($link, $consultaH);
                        while ($filaH = mysqli_fetch_array($resultadoH)) {
                            $ContC++;
                            $RawHisC[] = array(
                                "num_contrato" => $filaH['num_contrato'],
                                "obj_contrato" => $filaH['obj_contrato'],
                                "estad_contrato" => $filaH['estad_contrato']
                            );
                        }
                    }



                    $RawCtta[$ic] = array(
                        "nombCtta" => $fila['nomb'],
                        "ContC" => $ContC,
                        "HisCont" => $RawHisC,
                        "Eval" => $RawEva
                    );
                }
                unset($RawEva);
                $ic++;
            }
        }
    }


    ///ALMACENAR OTRAS EVALUACIONES
    $feval = "";
    $consulta = "SELECT * FROM eval_contratista WHERE estado_evaluacion='ACTIVO' AND id_evaluacion NOT IN('" . $IdEval . "')";
    //    echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            if ($fila['eval_evaluacion'] == "si") {
                $feval = $fila['feval_evaluacion'];
            } else {
                $feval = $fila['freeval_evaluacion'];
            }

            $PuntCO = "";
            $PuntCE = "";
            $PuntCC = "";
            $PuntTo = "";
            $Anali = "";

            if ($Clasf[0] == "1") {
                $PuntCO = $fila['puntPsTot1'];
                $PuntCE = $fila['puntPsTot2'];
                $PuntCC = $fila['puntPsTot3'];
                $PuntTo = $fila['text_PsTotal'];
            } else if ($Clasf[0] == "2") {
                $PuntCO = $fila['puntSaTot1'];
                $PuntCE = $fila['puntSaTot2'];
                $PuntCC = $fila['puntSaTot3'];
                $PuntTo = $fila['text_SaTotal'];
            } else if ($Clasf[0] == "3") {
                $PuntCO = $fila['puntCaTot1'];
                $PuntCE = $fila['puntCaTot2'];
                $PuntCC = $fila['puntCaTot3'];
                $PuntTo = $fila['text_CaTotal'];
            } else if ($Clasf[0] == "4") {
                $PuntCO = $fila['puntCcTot1'];
                $PuntCE = $fila['puntCcTot2'];
                $PuntCC = $fila['puntCcTot3'];
                $PuntTo = $fila['text_CcTotal'];
            } else {
                $PuntCO = $fila['puntCoTot1'];
                $PuntCE = $fila['puntCoTot2'];
                $PuntCC = $fila['puntCoTot3'];
                $PuntTo = $fila['text_CoTotal'];
            }


            $RawOtEv[] = array(
                "freeva" => $feval,
                "PuntCO" => $PuntCO,
                "PuntCE" => $PuntCE,
                "PuntCC" => $PuntCC,
                "PuntTo" => $PuntTo
            );
        }
    }

    $myDat->RawCtta = $RawCtta;
    $myDat->RawOtEv = $RawOtEv;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenProyectos") {

    $myDat = new stdClass();
    $RawProyec = array(); //PROYECTOS
    $RawContra = array(); //CONTRATOS
    $RawEstCon = array(); //CONTRATOS

    $RawMetasT = array(); //METAS TRAZADORAS
    $RawMetasP = array(); //METAS PRODUCTO
    $RawPobObj = array(); //POBLACION OBJETIVO

    $RawMedInd = array(); //MEDICIÓN INDICADORES
    $RawMedMet = array(); //MEDICIÓN INDICADORES
    $RawMedIndResul = array(); //MEDICIÓN INDICADORES


    $ic = 0;
    $ie = 0;
    $contMed = 1;

    if ($_POST['dest'] == "html") {
        $consulta = "TRUNCATE TABLE aux_inf_gen_proy";
        mysqli_query($link, $consulta);
    }


    $consulta = "SELECT 
  proy.id_proyect idproy,
  proy.cod_proyect cproy,
  proy.nombre_proyect nproy,
  dsecretar_proyect secre,
    eje.NOMBRE neje,
  comp.NOMBRE ncomp,
  prog.NOMBRE nprog,
  tp.des_tipolo dtip,
  proy.porceEjec_proyect pava
FROM
  proyectos proy 
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
    LEFT JOIN tipologia_proyecto tp
    ON proy.tipol_proyect=tp.id_tipolo
WHERE proy.id_proyect = '" . $_POST['Proy'] . "' GROUP BY cproy";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            /////////// POBLACION OBJETIVO
            $consultaPO = "SELECT grupoetnico, genero, personas FROM banco_proyec_pobla WHERE id_proyect='" . $fila['idproy'] . "' ";
            $resultadoPO = mysqli_query($link, $consultaPO);
            if (mysqli_num_rows($resultadoPO) > 0) {
                while ($filaPO = mysqli_fetch_array($resultadoPO)) {

                    $RawPobObj[] = array(
                        "grupoetnico" => $filaPO['grupoetnico'],
                        "genero" => $filaPO['genero'],
                        "personas" => $filaPO['personas']
                    );
                }
            }
            //////////////////METAS TRAZADORAS 
            $consultaMT = "SELECT met.desc_meta dmet, met.meta meta, pm.aport_proy metproy FROM proyect_metas pm "
                . "LEFT JOIN metas met ON pm.id_meta=met.id_meta WHERE pm.cod_proy='" . $fila['idproy'] . "'";
            $resultadoMT = mysqli_query($link, $consultaMT);
            $ContMT = 0;
            if (mysqli_num_rows($resultadoMT) > 0) {
                while ($filaMT = mysqli_fetch_array($resultadoMT)) {
                    $ContMT++;
                    $RawMetasT[] = array(
                        "dmet" => $filaMT['dmet'],
                        "meta" => $filaMT['meta'],
                        "metproy" => $filaMT['metproy']
                    );
                }
            }
            //////////////////METAS DE PRODUCTO 
            $consultaMP = "SELECT mp.descripcion dmet, mp.objetivo met, pm.met_generada metproy FROM proyect_metasproducto pm "
                . "LEFT JOIN metas_productos mp ON pm.id_meta=mp.id WHERE pm.cod_proy='" . $fila['idproy'] . "'";
            $resultadoMP = mysqli_query($link, $consultaMP);
            $ContMP = 0;
            if (mysqli_num_rows($resultadoMP) > 0) {
                while ($filaMP = mysqli_fetch_array($resultadoMP)) {
                    $ContMP++;
                    $RawMetasP[] = array(
                        "dmet" => $filaMP['dmet'],
                        "meta" => $filaMP['met'],
                        "metproy" => $filaMP['metproy']
                    );
                }
            }


            ///////MEDICIÓN DE INDICADORES            
            $consultMed = "SELECT 
            ind.nomb_indi nomb,
            ind.id_indi id
           FROM
             mediindicador med 
             LEFT JOIN indicadores ind
             ON med.indicador=ind.id_indi
            WHERE proy_ori='" . $fila['idproy'] . "'
            GROUP BY indicador";
            $resultadoMed = mysqli_query($link, $consultMed);
            if (mysqli_num_rows($resultadoMed) > 0) {
                while ($filaMed = mysqli_fetch_array($resultadoMed)) {

                    $consulta = "SELECT 
                                met.id_meta id,
                                met.desc_meta desmet
                              FROM
                                mediindicador med 
                                LEFT JOIN indicadores ind
                                ON med.indicador=ind.id_indi
                                LEFT JOIN metas met
                                ON med.id_meta=met.id_meta
                               WHERE ind.id_indi='" . $filaMed['id'] . "'
                               GROUP BY met.desc_meta";
                    $resultado = mysqli_query($link, $consulta);
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($filaInd = mysqli_fetch_array($resultado)) {
                            $consultaMedI = "SELECT * FROM mediindicador med WHERE med.id_meta='" . $filaInd['id'] . "'";
                            //                            echo $consultaMedI;
                            $resultadoMedI = mysqli_query($link, $consultaMedI);
                            if (mysqli_num_rows($resultadoMedI) > 0) {
                                while ($filaMedI = mysqli_fetch_array($resultadoMedI)) {
                                    $anio = $filaMedI['anio'];
                                    $resulindi = $filaMedI['resulindi'];
                                    $meta = $filaMedI['meta'];
                                    $fre = $filaMedI['frecuencia'];

                                    $consulta2 = "SELECT * FROM mediindicador_plan WHERE id_medi='" . $filaMedI["id"] . "'";

                                    $resultado2 = mysqli_query($link, $consulta2);
                                    if (mysqli_num_rows($resultado2) > 0) {
                                        while ($fila2 = mysqli_fetch_array($resultado2)) {
                                            $anio = $fila2['anio'];
                                            $resulindi = $fila2['resulindi'];
                                            $meta = $fila2['meta'];
                                            $fre = $fila2['frecuencia'];
                                        }
                                    }

                                    $RawMedIndResul[] = array(
                                        "anio" => $anio,
                                        "anio2" => $anio . " " . $fre,
                                        "resulindi" => $resulindi,
                                        "meta" => $meta
                                    );
                                }
                            }

                            $img = "";
                            $consultaImg = "select * from aux_inf_gen_proy where id='" . $contMed . "'";
                            $resultadoImg = mysqli_query($link, $consultaImg);
                            while ($filaimg = mysqli_fetch_array($resultadoImg)) {
                                $img = $filaimg['img'];
                            }

                            $RawMedMet[] = array(
                                "nombmet" => $filaInd['desmet'],
                                "ResulInd" => $RawMedIndResul,
                                "img" => $img
                            );
                            $contMed++;
                            unset($RawMedIndResul);
                        }
                    }

                    $RawMedInd[] = array(
                        "nombInd" => $filaMed['nomb'],
                        "Metas" => $RawMedMet
                    );
                    unset($RawMedMet);
                }
            }


            //////////////////ESTADO CONTRATOS 
            $consultaEst = "SELECT 
            COUNT(*) cant,
              contr.estad_contrato estado
            FROM
              contratos contr 
              LEFT JOIN proyectos proy 
                ON contr.idproy_contrato = proy.id_proyect 
              LEFT JOIN secretarias sec 
                ON proy.secretaria_proyect = sec.idsecretarias 
              LEFT JOIN contratistas conttas 
                ON contr.idcontrati_contrato = conttas.id_contratis 
            WHERE contr.estcont_contra = 'Verificado' AND proy.id_proyect='" . $fila['idproy'] . "'
              AND contr.id_contrato IN 
              (SELECT 
                MAX(id_contrato) 
              FROM
                contratos 
              GROUP BY num_contrato) GROUP BY contr.estad_contrato ";
            $catPro = 0;
            $resultadoEst = mysqli_query($link, $consultaEst);
            if (mysqli_num_rows($resultadoEst) > 0) {
                while ($filaEst = mysqli_fetch_array($resultadoEst)) {
                    $catPro = $catPro + $filaEst['cant'];
                    $RawEstCon[] = array(
                        "cant" => $filaEst['cant'],
                        "cate" => str_replace('Ejecucion', 'Ejecución', $filaEst['estado'])
                    );
                }
            }


            /////////DATOS DE CONTRATOS
            $consultaC = "SELECT 
            contr.id_contrato idcont,
            contr.num_contrato num,
            contr.obj_contrato obj,
            conttas.nom_contratis ctta,
            contr.vcontr_contrato vcont,
            contr.vadic_contrato vadic,
            contr.vfin_contrato vfinal,
            contr.veje_contrato vejec,
            contr.porav_contrato pava,
            contr.estad_contrato estado 
            FROM
              contratos contr 
              LEFT JOIN proyectos proy 
                ON contr.idproy_contrato = proy.id_proyect 
              LEFT JOIN contratistas conttas 
                ON contr.idcontrati_contrato = conttas.id_contratis 
            WHERE contr.estcont_contra = 'Verificado' 
              AND proy.id_proyect = '" . $fila['idproy'] . "' 
              AND contr.id_contrato IN 
              (SELECT 
                MAX(id_contrato) 
              FROM
                contratos 
              GROUP BY num_contrato)";

            $resultadoC = mysqli_query($link, $consultaC);
            //            $sinImg = "Proyecto/Galeria/sin_imagen.jpg";
            $ulr = "Proyecto/Galeria/sin_imagen.jpg";
            $type = pathinfo($ulr, PATHINFO_EXTENSION);
            $data = file_get_contents($ulr);
            $NImg = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $ImgIni = $NImg;
            $ImgAva = $NImg;
            $ImgFin = $NImg;

            if (mysqli_num_rows($resultadoC) > 0) {
                while ($filaC = mysqli_fetch_array($resultadoC)) {
                    $RawFotosA = array(); //FOTOS CONTRATO
                    $RawFotosA2 = array(); //FOTOS CONTRATO



                    $consultaG = "select tip_galeria, img_galeria from contrato_galeria where num_contrato_galeria='" . $filaC['num'] . "' GROUP BY img_galeria,tip_galeria ORDER BY id_galeria";
                    $resultadoG = mysqli_query($link, $consultaG);
                    if (mysqli_num_rows($resultadoG) > 0) {
                        while ($filaG = mysqli_fetch_array($resultadoG)) {

                            if ($filaG['tip_galeria'] == "Estado Inicial") {
                                $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $filaC['num'] . "/" . $filaG['img_galeria'];
                                $type = pathinfo($ulr, PATHINFO_EXTENSION);
                                $data = file_get_contents($ulr);
                                $ImgIni = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            }

                            if ($filaG['tip_galeria'] == "Avances") {
                                $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $filaC['num'] . "/" . $filaG['img_galeria'];
                                $type = pathinfo($ulr, PATHINFO_EXTENSION);
                                $data = file_get_contents($ulr);
                                $ImgAva = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            }

                            if ($filaG['tip_galeria'] == "Estado Final") {
                                $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $filaC['num'] . "/" . $filaG['img_galeria'];
                                $type = pathinfo($ulr, PATHINFO_EXTENSION);
                                $data = file_get_contents($ulr);
                                $ImgFin = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            }

                            $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $filaC['num'] . "/" . $filaG['img_galeria'];
                            $type = pathinfo($ulr, PATHINFO_EXTENSION);
                            $data = file_get_contents($ulr);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                            $RawFotosA[] = array(
                                "tip_galeria" => $filaG['tip_galeria'],
                                "img_galeria" => $base64
                            );
                        }

                        $RawFotosA2[] = array(
                            "ImgIni" => $ImgIni,
                            "ImgAva" => $ImgAva,
                            "ImgFin" => $ImgFin
                        );
                        $ImgIni = $NImg;
                        $ImgAva = $NImg;
                        $ImgFin = $NImg;
                    }

                    $RawContra[] = array(
                        "num" => $filaC['num'],
                        "obj" => $filaC['obj'],
                        "ctta" => $filaC['ctta'],
                        "vcont" => "$ " . number_format($filaC['vcont'], 2, ",", "."),
                        "vadic" => "$ " . number_format($filaC['vadic'], 2, ",", "."),
                        "vfinal" => "$ " . number_format($filaC['vfinal'], 2, ",", "."),
                        "vejec" => "$ " . number_format($filaC['vejec'], 2, ",", "."),
                        "pava" => $filaC['pava'],
                        "estado" => $filaC['estado'],
                        "imgEC" => $RawFotosA,
                        "imgEC2" => $RawFotosA2
                    );

                    unset($RawFotosA);
                    unset($RawFotosA2);
                }
            }


            /////////DATOS PROYECTO
            $RawProyec[] = array(
                "cproy" => $fila['cproy'],
                "nproy" => $fila['nproy'],
                "secre" => $fila['secre'],
                "neje" => $fila['neje'],
                "ncomp" => $fila['ncomp'],
                "nprog" => $fila['nprog'],
                "dtipo" => $fila['dtip'],
                "pava" => $fila['pava'],
                "cantc" => $catPro,
                "ContMP" => $ContMP,
                "ContMT" => $ContMT,
                "pobj" => $RawPobObj,
                "mett" => $RawMetasT,
                "metp" => $RawMetasP,
                "contr" => $RawContra,
                "estc" => $RawEstCon,
                "MedIn" => $RawMedInd
            );
        }
    }
    $myDat->RawProyec = $RawProyec;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenContratos") {
    $myDat = new stdClass();
    $RawContra = array(); //Datos Contrato
    $RawUbiCon = array(); //Ubicacion Contrato
    $RawImg = array(); //Imagenes Contrato
    $RawConSusp = array(); //Datos Suspen
    $RawConPro = array(); //Datos Prorroga
    $RawaAtra = array(); //Datos Atrasa


    $consulta = "SELECT 
  contr.num_contrato ncont,
  contr.obj_contrato obj,
  contr.fcrea_contrato fech,
  tipcon.NOMBRE tipol,
  contr.vcontr_contrato valor,
  contr.vadic_contrato vadic,
  contr.vfin_contrato vfin,
  contr.veje_contrato veje,
  contr.estad_contrato estado,
  contr.porav_contrato pava,
  contr.durac_contrato durc,
  contr.fini_contrato fini,
  contr.fini_contrato ffin,
  contr.desproy_contrato proyec,
  cttas.nom_contratis nomctta,
  sup.nom_supervisores nomsuper,
  inter.nom_interventores nominter,
  pol.num_poliza npol,
  pol.fecha_ini finipol,
  pol.fecha_fin ffinpol,
  proy.dsecretar_proyect secr
FROM
  contratos contr 
  LEFT JOIN tipo_contratacion tipcon 
    ON contr.idtipolg_contrato = tipcon.ID 
    LEFT JOIN supervisores sup 
    ON contr.idsuperv_contrato=sup.id_supervisores
    LEFT JOIN contratistas cttas 
    ON contr.idcontrati_contrato=cttas.id_contratis
    LEFT JOIN interventores inter
    ON contr.idinterv_contrato=inter.id_interventores
    LEFT JOIN polizas pol
    ON contr.num_contrato=pol.id_contrato
    LEFT JOIN proyectos proy 
    ON contr.idproy_contrato=proy.id_proyect
    WHERE contr.id_contrato='" . $_POST['idContr'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($filaC = mysqli_fetch_array($resultado)) {

            $RawContra[] = array(
                "num" => $filaC['ncont'],
                "obj" => $filaC['obj'],
                "fech" => $filaC['fech'],
                "tipol" => $filaC['tipol'],
                "valor" => "$ " . number_format($filaC['valor'], 2, ",", "."),
                "vadic" => "$ " . number_format($filaC['vadic'], 2, ",", "."),
                "vfin" => "$ " . number_format($filaC['vfin'], 2, ",", "."),
                "veje" => "$ " . number_format($filaC['veje'], 2, ",", "."),
                "pava" => $filaC['pava'],
                "estado" => $filaC['estado'],
                "durc" => $filaC['durc'],
                "fini" => $filaC['fini'],
                "ffin" => $filaC['ffin'],
                "proyec" => $filaC['proyec'],
                "nomctta" => $filaC['nomctta'],
                "nomsuper" => $filaC['nomsuper'],
                "nominter" => $filaC['nominter'],
                "npol" => $filaC['npol'],
                "finipol" => $filaC['finipol'],
                "ffinpol" => $filaC['ffinpol'],
                "secr" => $filaC['secr'],
            );
        }
    }


    //            $sinImg = "Proyecto/Galeria/sin_imagen.jpg";
    $ulr = "Proyecto/Galeria/sin_imagen.jpg";
    $type = pathinfo($ulr, PATHINFO_EXTENSION);
    $data = file_get_contents($ulr);
    $NImg = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $ImgIni = $NImg;
    $ImgAva = $NImg;
    $ImgFin = $NImg;

    $RawFotosA = array(); //FOTOS CONTRATO
    $RawFotosA2 = array(); //FOTOS CONTRATO

    $consultaG = "select tip_galeria, img_galeria from contrato_galeria where num_contrato_galeria='" . $_POST['Contr'] . "' GROUP BY img_galeria,tip_galeria ORDER BY id_galeria";
    $resultadoG = mysqli_query($link, $consultaG);
    if (mysqli_num_rows($resultadoG) > 0) {
        while ($filaG = mysqli_fetch_array($resultadoG)) {

            if ($filaG['tip_galeria'] == "Estado Inicial") {
                $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $_POST['Contr'] . "/" . $filaG['img_galeria'];
                $type = pathinfo($ulr, PATHINFO_EXTENSION);
                $data = file_get_contents($ulr);
                $ImgIni = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            if ($filaG['tip_galeria'] == "Avances") {
                $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $_POST['Contr'] . "/" . $filaG['img_galeria'];
                $type = pathinfo($ulr, PATHINFO_EXTENSION);
                $data = file_get_contents($ulr);
                $ImgAva = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            if ($filaG['tip_galeria'] == "Estado Final") {
                $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $_POST['Contr'] . "/" . $filaG['img_galeria'];
                $type = pathinfo($ulr, PATHINFO_EXTENSION);
                $data = file_get_contents($ulr);
                $ImgFin = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            $ulr = "Proyecto/Galeria/" . $_SESSION['ses_complog'] . "/" . $_POST['Contr'] . "/" . $filaG['img_galeria'];
            $type = pathinfo($ulr, PATHINFO_EXTENSION);
            $data = file_get_contents($ulr);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $RawFotosA[] = array(
                "tip_galeria" => $filaG['tip_galeria'],
                "img_galeria" => $base64
            );
        }

        $RawFotosA2[] = array(
            "ImgIni" => $ImgIni,
            "ImgAva" => $ImgAva,
            "ImgFin" => $ImgFin
        );
    }

    ////CONSULTAR SUSPENCION CONTRATO
    $consultaS = "SELECT fsusp_contrato,frein_contrato, observacion FROM contratos WHERE num_contrato='" . $_POST['Contr'] . "' AND estad_contrato='Suspendido' GROUP BY num_contrato";
    $resultadoS = mysqli_query($link, $consultaS);
    if (mysqli_num_rows($resultadoS) > 0) {
        while ($filaS = mysqli_fetch_array($resultadoS)) {
            $RawConSusp[] = array(
                "fsusp_contrato" => $filaS['fsusp_contrato'],
                "frein" => $filaS['frein_contrato'],
                "observacion" => $filaS['observacion']
            );
        }
    }

    ///CONSULTAR PRORROGA 
    $consultaP = "SELECT 
        prorg_contrato,
        ffin_contrato,
        observacion
      FROM
        contratos 
      WHERE id_contrato IN 
        (SELECT 
          MAX(id_contrato) 
        FROM
          contratos 
          WHERE num_contrato = '" . $_POST['Contr'] . "' 
        AND prorg_contrato <> ''
        GROUP BY num_contrato)";
    //    echo $consultaP; 

    $resultadoP = mysqli_query($link, $consultaP);
    if (mysqli_num_rows($resultadoP) > 0) {
        while ($filaP = mysqli_fetch_array($resultadoP)) {
            $RawConPro[] = array(
                "prorg_contrato" => $filaP['prorg_contrato'],
                "ffin_contratoP" => $filaP['ffin_contrato'],
                "observacion" => $filaP['observacion']
            );
        }
    }

    ///CONSULTAR UBICACIÓN 
    $consultaU = "SELECT 
  dp.NOM_DPTO depart, mn.NOM_MUNI munic, corr.NOM_CORREGI correg, ubi.barr_ubic otubic
FROM
  ubic_contratos ubi 
  LEFT JOIN dpto dp 
    ON ubi.depar_ubic = dp.COD_DPTO 
    LEFT JOIN muni mn
    ON ubi.muni_ubic = mn.COD_MUNI
    LEFT JOIN corregi corr
    ON ubi.corr_ubic= corr.COD_CORREGI
WHERE num_contrato = '" . $_POST['Contr'] . "' ";
    $resultadoU = mysqli_query($link, $consultaU);
    if (mysqli_num_rows($resultadoU) > 0) {
        while ($filaU = mysqli_fetch_array($resultadoU)) {
            $RawUbiCon[] = array(
                "Ubic" => $filaU['depart'] . ', ' . $filaU['munic'] . ', ' . $filaU['correg'] . ', ' . $filaU['otubic']
            );
        }
    }


    ///COSULTA ATRASO
    $consultaA = "SELECT 
contr.num_contrato,
  CASE
    WHEN just.justificacion = NULL 
    THEN 'SIN INFORME JUSTIFICACIÓN DE ATRASO' 
    ELSE just.justificacion 
  END justi
FROM
  contratos contr 
  LEFT JOIN justif_atraso_cont just 
    ON contr.id_contrato = just.contrato 
WHERE estad_contrato = 'Ejecucion' AND contr.num_contrato='" . $_POST['Contr'] . "'
  AND contr.id_contrato IN 
  (SELECT 
    MAX(id_contrato)
  FROM
    contratos 
  WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')
  GROUP BY num_contrato)";

    $resultadoA = mysqli_query($link, $consultaA);
    if (mysqli_num_rows($resultadoA) > 0) {
        while ($filaA = mysqli_fetch_array($resultadoA)) {
            $just = "";
            if ($filaA['justi'] == NULL) {
                $just = "SIN INFORME JUSTIFICACIÓN DE ATRASO";
            } else {
                $just = $filaA['justi'];
            }
            $RawaAtra[] = array(
                "just" => $just
            );
        }
    }


    $myDat->RawContra = $RawContra;
    $myDat->RawFotosA = $RawFotosA;
    $myDat->RawFotosA2 = $RawFotosA2;
    $myDat->RawConSusp = $RawConSusp;
    $myDat->RawConPro = $RawConPro;
    $myDat->RawUbiCon = $RawUbiCon;
    $myDat->RawaAtra = $RawaAtra;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenContSuspAtra") {
    $myDat = new stdClass();

    $consulta = "SELECT * FROM (SELECT 
sec.des_secretarias dsec, sec.idsecretarias idsec
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
 LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%'  AND estad_contrato='Suspendido' 
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos    
  GROUP BY num_contrato) 
 UNION ALL
 SELECT 
sec.des_secretarias dsec, sec.idsecretarias idsec
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
 LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%' AND estad_contrato='Ejecucion'  
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
    WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')  
  GROUP BY num_contrato)) AS t GROUP BY idsec";
    $RawSec = array(); //creamos un array
    $RawEst = array(1000); //creamos un array
    $RawCon = array(); //creamos un array
    $is = 0;
    $ip = 0;
    $contSe = 1;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $RawSec[] = array(
                "dessec" => $fila['dsec']
            );

            $totalpre = 0;

            $consultaP = "SELECT SUM(valor) totalpre FROM presupuesto_secretarias WHERE id_secretaria='" . $fila['idsec'] . "'";
            $resultadoP = mysqli_query($link, $consultaP);
            if (mysqli_num_rows($resultadoP) > 0) {
                while ($filaP = mysqli_fetch_array($resultadoP)) {
                    $totalpre = $filaP["totalpre"];
                }
            }

            $consulta = "SELECT * FROM (SELECT 
                'SUSPENDIDOS' tipc,sec.des_secretarias dsec, sec.idsecretarias idsec
                FROM
                  contratos contr 
                  LEFT JOIN proyectos proy 
                    ON contr.idproy_contrato = proy.id_proyect 
                 LEFT JOIN secretarias sec
                  ON proy.secretaria_proyect=sec.idsecretarias
                WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%'  AND estad_contrato='Suspendido' 
                AND contr.id_contrato IN
                  (SELECT
                    MAX(id_contrato)
                  FROM
                    contratos    
                  GROUP BY num_contrato) 
                 UNION ALL
                 SELECT 
                'ATRASADOS' tipc,sec.des_secretarias dsec, sec.idsecretarias idsec
                FROM
                  contratos contr 
                  LEFT JOIN proyectos proy 
                    ON contr.idproy_contrato = proy.id_proyect 
                 LEFT JOIN secretarias sec
                  ON proy.secretaria_proyect=sec.idsecretarias
                WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%' AND estad_contrato='Ejecucion'  
                AND contr.id_contrato IN
                  (SELECT
                    MAX(id_contrato)
                  FROM
                    contratos
                    WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')  
                  GROUP BY num_contrato)) AS t WHERE idsec='" . $fila['idsec'] . "'  GROUP BY tipc";
            $totalInv = 0;

            $ncontAtr = 0;
            $ncontSus = 0;

            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    $Cont = "";

                    $consulta = "SELECT * FROM (SELECT 
                            'SUSPENDIDOS' tipc, sec.des_secretarias dsec, contr.num_contrato ncont, contr.obj_contrato obj,
                            contr.porav_contrato pava, contr.vfin_contrato valorcont, contr.observacion justi, cttas.nom_contratis contta, sec.idsecretarias idsec
                            FROM
                              contratos contr 
                              LEFT JOIN proyectos proy 
                                ON contr.idproy_contrato = proy.id_proyect 
                             LEFT JOIN secretarias sec
                              ON proy.secretaria_proyect=sec.idsecretarias
                              LEFT JOIN contratistas cttas
                              ON contr.idcontrati_contrato=cttas.id_contratis
                            WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%'  AND estad_contrato='Suspendido' 
                            AND contr.id_contrato IN
                              (SELECT
                                MAX(id_contrato)
                              FROM
                                contratos    
                              GROUP BY num_contrato) 
                             UNION ALL
                             SELECT 
                            'ATRASADOS' tipc, sec.des_secretarias dsec, contr.num_contrato ncont, contr.obj_contrato obj,
                            contr.porav_contrato pava, contr.vfin_contrato valorcont, 
                            CASE WHEN just.justificacion=NULL THEN 'SIN INFORME JUSTIFICACIÓN DE ATRASO' ELSE just.justificacion END justi, cttas.nom_contratis contta,sec.idsecretarias idsec
                            FROM
                              contratos contr 
                              LEFT JOIN proyectos proy 
                                ON contr.idproy_contrato = proy.id_proyect 
                             LEFT JOIN secretarias sec
                              ON proy.secretaria_proyect=sec.idsecretarias
                               LEFT JOIN justif_atraso_cont just ON contr.id_contrato=just.contrato
                                 LEFT JOIN contratistas cttas
                              ON contr.idcontrati_contrato=cttas.id_contratis
                            WHERE  IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST['Secre'] . "%' AND estad_contrato='Ejecucion'  
                            AND contr.id_contrato IN
                              (SELECT
                                MAX(id_contrato)
                              FROM
                                contratos
                                WHERE DATE(ffin_contrato) < DATE_FORMAT(DATE(NOW()), '%Y-%m-%d')  
                              GROUP BY num_contrato)) AS t WHERE idsec='" . $fila['idsec'] . "' and tipc='" . $fila2['tipc'] . "'";
                    $resultado3 = mysqli_query($link, $consulta);
                    if (mysqli_num_rows($resultado3) > 0) {
                        while ($fila3 = mysqli_fetch_array($resultado3)) {

                            if ($fila3["tipc"] == "ATRASADOS") {
                                $ncontAtr++;
                            } else {
                                $ncontSus++;
                            }

                            $RawCon[] = array(
                                "numcont" => $fila3['ncont'],
                                "obj" => $fila3['obj'],
                                "descontita" => $fila3['contta'],
                                "total" => "$ " . number_format($fila3["valorcont"], 2, ",", "."),
                                "porava" => $fila3["pava"],
                                "justi" => $fila3["justi"]
                            );

                            $totalInv = $totalInv + $fila3["valorcont"];
                        }

                        $RawEst[$ip] = array(
                            "tipc" => $fila2['tipc'],
                            "Contratos" => $RawCon
                        );
                    }
                    unset($RawCon);
                    $ip++;

                    $porcinv = ($totalInv * 100) / $totalpre;
                    $img = "";
                    $consultaImg = "select * from aux_inf_atra_sup where id='" . $contSe . "'";
                    $resultadoImg = mysqli_query($link, $consultaImg);
                    while ($filaimg = mysqli_fetch_array($resultadoImg)) {
                        $img = $filaimg['img'];
                    }

                    $ResInv = "LA " . $fila['dsec'] . " POSEE " . $ncontAtr . " CONTRATO ATRASADO(S) Y " . $ncontSus . "  SUSPENDIDO(S) LO CUAL REPRESENTAN "
                        . "EL " . round($porcinv, 2) . "%($ " . number_format($totalInv, 2, ",", ".") . ") DEL PRESUPUESTO GENERAL ($ " . number_format($totalpre, 2, ",", ".") . ")";

                    $RawSec[$is] = array(
                        "dessec" => $fila['dsec'],
                        "img" => $img,
                        "ResInv" => $ResInv,
                        "Estad" => $RawEst
                    );
                }
                $contSe++;
                unset($RawEst);
                $is++;
            }
        }
    }
    $myDat->RawSec = $RawSec;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfMapsCal") {
    $myDat = new stdClass();

    $consulta = "SELECT 
  uc.num_contrato ncont, uc.lat_ubic lat, uc.long_ubi lon 
FROM
  ubic_contratos uc 
  LEFT JOIN contratos ctto 
    ON uc.contrato_ubi = ctto.id_contrato 
    WHERE ctto.idproy_contrato LIKE '" . $_POST['Proy'] . "%'
    AND uc.depar_ubic LIKE '" . $_POST['Depart'] . "%' AND uc.muni_ubic LIKE '" . $_POST['Muni'] . "%'";
    $RawCont = array(); //creamos un array

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $RawCont[] = array(
                "ncont" => $fila['ncont'],
                "lat" => $fila['lat'],
                "lon" => $fila['lon']
            );
        }
    }
    $myDat->RawCont = $RawCont;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenContxProy") {
    $myDat = new stdClass();

    $RawProy = array(1000); //creamos un array
    $RawCon = array(); //creamos un array
    $is = 0;
    $ip = 0;

    $consulta = "SELECT 
            proy.id_proyect idproy, proy.nombre_proyect nomproy, proy.porceEjec_proyect poravan,proy.cod_proyect codproy
            FROM
              contratos contr 
              LEFT JOIN proyectos proy 
                ON contr.idproy_contrato = proy.id_proyect 
             LEFT JOIN secretarias sec
              ON proy.secretaria_proyect=sec.idsecretarias 
            WHERE proy.estado_proyect='En Ejecucion' AND contr.estcont_contra='Verificado' AND proy.secretaria_proyect LIKE '" . $_POST['Secre'] . "%'
            AND contr.id_contrato IN
              (SELECT
                MAX(id_contrato)
              FROM
                contratos
                WHERE estad_contrato='Ejecucion' OR estad_contrato='Terminado' OR estad_contrato='Supendido' 
              GROUP BY num_contrato) GROUP BY idproy";

    $totalInv = 0;
    $resultado2 = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $Cont = "";

            $consulta = "SELECT 
                    contr.num_contrato numcont, contr.obj_contrato obj, 
                    conttas.nom_contratis descontita,
                    contr.estad_contrato estado,contr.vfin_contrato total,
                    contr.porav_contrato porava
                   FROM
                     contratos contr 
                     LEFT JOIN proyectos proy 
                       ON contr.idproy_contrato = proy.id_proyect 
                    LEFT JOIN secretarias sec
                     ON proy.secretaria_proyect=sec.idsecretarias
                    LEFT JOIN contratistas conttas 
                    ON contr.idcontrati_contrato=conttas.id_contratis
                   WHERE contr.estcont_contra='Verificado'
                   AND contr.idproy_contrato = '" . $fila2['idproy'] . "'
                   AND contr.id_contrato IN
                     (SELECT
                       MAX(id_contrato)
                     FROM
                       contratos
                     GROUP BY num_contrato) ORDER BY total DESC";
            $resultado3 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado3) > 0) {
                while ($fila3 = mysqli_fetch_array($resultado3)) {

                    $RawCon[] = array(
                        "numcont" => $fila3['numcont'],
                        "obj" => $fila3['obj'],
                        "descontita" => $fila3['descontita'],
                        "total" => "$ " . number_format($fila3["total"], 2, ",", "."),
                        "estado" => $fila3["estado"],
                        "porava" => $fila3["porava"]
                    );

                    $totalInv = $totalInv + $fila3["total"];
                }

                $RawProy[$ip] = array(
                    "codproy" => $fila2['codproy'],
                    "nomproy" => $fila2['nomproy'],
                    "poravan" => $fila2['poravan'],
                    "Contratos" => $RawCon
                );
            }
            unset($RawCon);
            $ip++;
        }
    }

    $myDat->RawProy = $RawProy;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenMetas") {
    $myDat = new stdClass();

    //////////////CONSULTA DE METAS TRAZADORAS    

    $Tab_Proyectos = " <thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <b> Proyectos</b>\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <b> Decripción Meta</b>\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <b> Meta Esperada</b>\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <b> Meta Actual</b>\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <b> % Cumplimiento</b>\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody >";

    if ($_POST['TipMet'] == "Trazadora") {
        $consulta = "SELECT 
   CONCAT(proy.cod_proyect,' - ',proy.nombre_proyect) proy, mts.desc_meta desme, mts.meta mt, mts.id_meta idme
FROM
  proyectos proy 
  RIGHT JOIN proyect_metas pm 
    ON proy.id_proyect=pm.cod_proy 
    LEFT JOIN metas mts
    ON pm.id_meta=mts.id_meta
  WHERE proy.id_proyect LIKE '" . $_POST['Proy'] . "%' AND proy.estado='ACTIVO'
  ORDER BY cod_proy";
    } else {
        $consulta = "SELECT 
   CONCAT(cod_proyect,' - ',nombre_proyect) proy, desc_met desme
FROM
  proyectos proy 
  RIGHT JOIN proyect_metasproducto pm 
    ON proy.id_proyect=pm.cod_proy 
  WHERE proy.id_proyect LIKE '" . $_POST['Proy'] . "%' AND proy.estado='ACTIVO'
  ORDER BY cod_proy";
    }


    $resultado = mysqli_query($link, $consulta);
    $arr = array();

    $Proy = array(); //emp
    $Metas = array(); //sal
    $MetEs = array(); //sal
    $IdMet = array(); //sal

    while ($row = mysqli_fetch_assoc($resultado)) {
        array_push($Proy, $row['proy']);
        array_push($Metas, $row['desme']);
        array_push($MetEs, $row['mt']);
        array_push($IdMet, $row['idme']);

        ////secretarias
        if (!isset($arr[$row['proy']])) {
            $arr[$row['proy']]['rowspan'] = 0;
        }
        $arr[$row['proy']]['printed'] = 'no';
        $arr[$row['proy']]['rowspan'] += 1;
    }


    for ($i = 0; $i < sizeof($Metas); $i++) {
        $empName = $Proy[$i];
        $Tab_Proyectos .= "<tr class='selected'>";

        if ($arr[$empName]['printed'] == 'no') {
            $Tab_Proyectos .= "<td style='vertical-align: middle;color: #000;' rowspan='" . $arr[$empName]['rowspan'] . "'>" . ucwords(strtolower($empName)) . "</td>";
            $arr[$empName]['printed'] = 'yes';
        }
        $Tab_Proyectos .= "<td style='vertical-align: middle;color: #000;'>" . ucwords(strtolower($Metas[$i])) . "</td>";
        $Tab_Proyectos .= "<td style='vertical-align: middle;color: #000;'>" . $MetEs[$i] . "</td>";

        if ($_POST['TipMet'] == "Trazadora") {
            $consulta = "SELECT resulindi,meta FROM mediindicador WHERE id_meta='" . $IdMet[$i] . "' AND id=(SELECT MAX(id) FROM mediindicador)";
        } else {
            $consulta = "";
        }
        $MetAct = 0;
        $CumMet = 0;
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $MetAct = $fila['resulindi'];
                $MetE = $fila['meta'];
            }
        }

        $CumMet = ($MetAct * 100) / $MetE;
        $Tab_Proyectos .= "<td style='vertical-align: middle;color: #000;'>" . $MetAct . "</td>";
        if ($CumMet < 50) {
            $Tab_Proyectos .= "<td style='vertical-align: middle;color: #BE1623;'>" . $CumMet . "%</td>";
        } else if ($CumMet >= 50 && $CumMet <= 80) {
            $Tab_Proyectos .= "<td style='vertical-align: middle;color: #FDEA11;'>" . $CumMet . "%</td>";
        } else if ($CumMet >= 80) {
            $Tab_Proyectos .= "<td style='vertical-align: middle;color: #38A532;'>" . $CumMet . "%</td>";
        }

        $Tab_Proyectos .= "</tr>";
    }



    $Tab_Proyectos .= "</tbody>";
    $myDat->Tab_Proyectos = $Tab_Proyectos;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenPoblacion") {

    $myDat = new stdClass();
    $consulta = "SELECT 
            COUNT(*) cantp
          FROM
            proyectos proy 
            LEFT JOIN banco_proyec_pobla pobl 
              ON proy.id_proyect = pobl.id_proyect 
          WHERE IFNULL(pobl.edad, '') LIKE '" . $_POST["Edad"] . "%'
        AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST["Grupo"] . "%'
        AND IFNULL(pobl.genero, '') LIKE '" . $_POST["Genero"] . "%'
            AND proy.estado = 'ACTIVO' 
            AND proy.estado_proyect = 'En Ejecucion' 
          GROUP BY pobl.id_proyect";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cantpT = $fila["cantp"];
        }
    }
    //////////////// CONSULTAR CONTRATOS

    $consulta = "SELECT idsec,secre,presupuesto,SUM(inversion) inv, SUM(totalPers) tpers FROM( 
SELECT 
 sec.idsecretarias idsec, sec.des_secretarias secre, (SELECT SUM(ps.valor) FROM presupuesto_secretarias ps WHERE ps.id_secretaria=proy.secretaria_proyect) presupuesto, SUM(contr.vfin_contrato) inversion, pobl.personas totalPers
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
    LEFT JOIN banco_proyec_pobla pobl
  ON proy.id_proyect=pobl.id_proyect
    LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE contr.estcont_contra='Verificado'
AND IFNULL(pobl.edad, '') LIKE '" . $_POST['Edad'] . "%'
AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST['Grupo'] . "%'
AND IFNULL(pobl.genero, '') LIKE '" . $_POST['Genero'] . "%'
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
    WHERE estad_contrato='Ejecucion' OR estad_contrato='Terminado'
  GROUP BY num_contrato)
 GROUP BY pobl.id_proyect) t GROUP BY secre ";
    //    echo $consulta;
    $resultado = mysqli_query($link, $consulta);

    $RawSec = array(); //creamos un array
    $RawPro = array(1000); //creamos un array
    $RawCon = array(); //creamos un array

    $is = 0;
    $ip = 0;
    $OtrProy = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $nproy = 0;
            $RawSec[] = array(
                "dessec" => $fila['secre']
            );

            $consulta = "SELECT 
                proy.id_proyect idproy,
                proy.cod_proyect codproy,
                proy.nombre_proyect nomb
                FROM
                  contratos contr 
                  LEFT JOIN proyectos proy 
                    ON contr.idproy_contrato = proy.id_proyect 
                    LEFT JOIN banco_proyec_pobla pobl
                  ON proy.id_proyect=pobl.id_proyect
                  LEFT JOIN secretarias sec
                  ON proy.secretaria_proyect=sec.idsecretarias
                WHERE contr.estcont_contra='Verificado' AND proy.secretaria_proyect='" . $fila['idsec'] . "'
                AND IFNULL(pobl.edad, '') LIKE '" . $_POST['Edad'] . "%'
                AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST['Grupo'] . "%'
                AND IFNULL(pobl.genero, '') LIKE '" . $_POST['Genero'] . "%'
                AND contr.id_contrato IN
                  (SELECT
                    MAX(id_contrato)
                  FROM
                    contratos
                    WHERE estad_contrato='Ejecucion' OR estad_contrato='Terminado'
                  GROUP BY num_contrato) GROUP BY idproy ORDER BY nomb";


            $resultado2 = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado2) > 0) {
                while ($fila2 = mysqli_fetch_array($resultado2)) {

                    $consulta = "SELECT 
                    contr.num_contrato cod,
                    contr.obj_contrato obj, 
                     contr.estad_contrato estado,
                     contr.estad_contrato estado,
                     contr.porav_contrato pava,
                     contr.vfin_contrato total
                    FROM
                      contratos contr 
                      LEFT JOIN proyectos proy 
                        ON contr.idproy_contrato = proy.id_proyect 
                        LEFT JOIN banco_proyec_pobla pobl
                      ON proy.id_proyect=pobl.id_proyect
                      LEFT JOIN secretarias sec
                      ON proy.secretaria_proyect=sec.idsecretarias
                    WHERE contr.estcont_contra='Verificado' AND contr.idproy_contrato='" . $fila2['idproy'] . "'
               AND IFNULL(pobl.edad, '') LIKE '" . $_POST['Edad'] . "%'
                AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST['Grupo'] . "%'
                AND IFNULL(pobl.genero, '') LIKE '" . $_POST['Genero'] . "%'
                    AND contr.id_contrato IN
                      (SELECT
                        MAX(id_contrato)
                      FROM
                        contratos
                        WHERE estad_contrato='Ejecucion' OR estad_contrato='Terminado'
                      GROUP BY num_contrato)GROUP BY num_contrato ORDER BY total DESC";
                    //                    echo $consulta;
                    $resultado3 = mysqli_query($link, $consulta);
                    if (mysqli_num_rows($resultado3) > 0) {
                        while ($fila3 = mysqli_fetch_array($resultado3)) {
                            $RawCon[] = array(
                                "numcont" => $fila3['cod'],
                                "obj" => $fila3['obj'],
                                "total" => "$ " . number_format($fila3["total"], 2, ",", "."),
                                "estado" => $fila3["estado"],
                                "porava" => $fila3["pava"]
                            );
                        }
                    }

                    $nproy++;
                    $RawProy[$ip] = array(
                        "codproy" => $fila2['codproy'],
                        "nomproy" => $fila2['nomb'],
                        "Contratos" => $RawCon
                    );
                    $OtrProy .= "'" . $fila2["idproy"] . "'" . ",";

                    unset($RawCon);
                    $ip++;

                    $RawSec[$is] = array(
                        "dessec" => $fila['secre'],
                        "presupuesto" => $fila['presupuesto'],
                        "inv" => $fila['inv'],
                        "tpers" => $fila['tpers'],
                        "proy" => $RawProy,
                        "nproy" => $nproy
                    );
                }
                unset($RawProy);
                $is++;
            }
        }
    } else {
        $consulta = "SELECT 
  idsec,
  secre,
  SUM(totalPers) tpers
  
FROM
  (SELECT 
    sec.idsecretarias idsec,
    sec.des_secretarias secre,
    pobl.personas totalPers 
  FROM
  proyectos proy 
    LEFT JOIN banco_proyec_pobla pobl 
      ON proy.id_proyect = pobl.id_proyect 
    LEFT JOIN secretarias sec 
      ON proy.secretaria_proyect = sec.idsecretarias 
  WHERE  IFNULL(pobl.edad, '') LIKE '" . $_POST['Edad'] . "%'
  AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST['Grupo'] . "%'
  AND IFNULL(pobl.genero, '') LIKE '" . $_POST['Genero'] . "%'
  GROUP BY pobl.id_proyect) t 
GROUP BY secre ";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $RawSec[] = array(
                    "dessec" => $fila['secre']
                );

                $consulta = "SELECT 
                proy.id_proyect idproy,
                proy.cod_proyect codproy,
                proy.nombre_proyect nomb 
              FROM
                proyectos proy 
                LEFT JOIN banco_proyec_pobla pobl 
                  ON proy.id_proyect = pobl.id_proyect 
                LEFT JOIN secretarias sec 
                  ON proy.secretaria_proyect = sec.idsecretarias 
              WHERE proy.secretaria_proyect='" . $fila['idsec'] . "'
              AND IFNULL(pobl.edad, '') LIKE '" . $_POST['Edad'] . "%'
              AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST['Grupo'] . "%'
              AND IFNULL(pobl.genero, '') LIKE '" . $_POST['Genero'] . "%'
              GROUP BY idproy 
              ORDER BY nomb ";
                $resultado2 = mysqli_query($link, $consulta);
                if (mysqli_num_rows($resultado2) > 0) {
                    while ($fila2 = mysqli_fetch_array($resultado2)) {

                        $RawProy[] = array(
                            "codproy" => $fila2['codproy'],
                            "nomproy" => $fila2['nomb'],
                            "Contratos" => 'NO'
                        );
                    }
                }

                $RawSec[$is] = array(
                    "dessec" => $fila['secre'],
                    "tpers" => $fila['tpers'],
                    "proy" => $RawProy
                );

                unset($RawProy);
                $is++;
            }
        }
    }

    $myDat->RawSec = $RawSec;

    $RawOtrosPro = array(); //creamos un array proyectos
    $OtrProy = trim($OtrProy, ',');
    $consulta = "SELECT 
    sec.idsecretarias idsec,
    sec.des_secretarias secre,
    proy.nombre_proyect nproy,
    proy.estado_proyect estado
  FROM
    proyectos proy 
    LEFT JOIN banco_proyec_pobla pobl 
      ON proy.id_proyect = pobl.id_proyect 
    LEFT JOIN secretarias sec 
      ON proy.secretaria_proyect = sec.idsecretarias 
  WHERE IFNULL(pobl.edad, '') LIKE '" . $_POST['Edad'] . "%'
  AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST['Grupo'] . "%'
  AND IFNULL(pobl.genero, '') LIKE '" . $_POST['Genero'] . "%'     
  AND proy.id_proyect NOT IN (" . $OtrProy . ")    
  GROUP BY pobl.id_proyect";
    //  echo $consulta;
    $resultadoOP = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultadoOP) > 0) {
        while ($filaOP = mysqli_fetch_array($resultadoOP)) {

            $RawOtrosPro[] = array(
                "nproy" => $filaOP['nproy'],
                "secre" => $filaOP['secre'],
                "estado" => $filaOP['estado']
            );
        }
    }

    $myDat->RawOtrosPro = $RawOtrosPro;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InfGenPoblacion2") {

    $myDat = new stdClass();

    $consulta = "SELECT SUM(TOTAL_PROYECTOS) gtotal, COUNT(*) cantp FROM (SELECT 
  SUM(contr.vfin_contrato) AS TOTAL_PROYECTOS, COUNT(*)
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
    LEFT JOIN banco_proyec_pobla pobl
  ON proy.id_proyect=pobl.id_proyect
WHERE contr.estcont_contra='Verificado'
AND IFNULL(pobl.edad, '') LIKE '" . $_POST["Edad"] . "%'
AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST["Grupo"] . "%'
AND IFNULL(pobl.genero, '') LIKE '" . $_POST["Genero"] . "%'
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
    WHERE estad_contrato='Ejecucion' OR estad_contrato='Terminado'
  GROUP BY num_contrato) GROUP BY pobl.id_proyect) AS t";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->gtotal = $fila["gtotal"];
            $myDat->cantp = $fila["cantp"];
        }
    }

    ///////////CONSULTAR INVERSION POR SECRETARIAS

    $consulta = "SELECT secre,presupuesto,SUM(inversion) inv, SUM(totalPers) tpers FROM( 
SELECT 
  sec.des_secretarias secre, (SELECT SUM(ps.valor) FROM presupuesto_secretarias ps WHERE ps.id_secretaria=proy.secretaria_proyect) presupuesto, SUM(contr.vfin_contrato) inversion, pobl.personas totalPers
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
    LEFT JOIN banco_proyec_pobla pobl
  ON proy.id_proyect=pobl.id_proyect
    LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE contr.estcont_contra='Verificado'
AND IFNULL(pobl.edad, '') LIKE '" . $_POST["Edad"] . "%'
AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST["Grupo"] . "%'
AND IFNULL(pobl.genero, '') LIKE '" . $_POST["Genero"] . "%'
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
    WHERE estad_contrato='Ejecucion' OR estad_contrato='Terminado'
  GROUP BY num_contrato)
 GROUP BY pobl.id_proyect) t GROUP BY secre ";

    $resultado = mysqli_query($link, $consulta);
    $detSec = "";

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $rawproy[] = array(
                "Secre" => ucwords(strtolower($fila["secre"])),
                "Presu" => number_format($fila["presupuesto"], 2, ",", "."),
                "Inve" => number_format($fila["inv"], 2, ",", "."),
                "Pers" => $fila["tpers"]
            );

            //            $detSec .= '<div class="well">
            //                    <b><h4>' . $fila["secre"] . '</h4></b>
            //                    El presupuesto asignado para esta secretaria es de ' . number_format($fila["presupuesto"], 2, ",", ".") . ', con una 
            //                        inversión de ' . number_format($fila["inv"], 2, ",", ".") . ' en Proyectos, que beneficiarán a ' . $fila["tpers"] . ' Personas de
            //                        ' . $_POST["InfInv"] . ' 
            //                    </div>';
        }
    }
    $myDat->DetSec = $rawproy;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargTipologiaProyect") {

    $myDat = new stdClass();
    $Tipolog = "<option value=' '>Seleccione...</option>";
    //////////////////////CONSULTAR TIPOLOGIA
    $consulta = "select * from tipologia_proyecto";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Tipolog .= "<option value='" . $fila["id_tipolo"] . "'>" . $fila["cod_tipolo"] . " - " . $fila["des_tipolo"] . "</option>";
        }
    }
    $myDat->Tipolog = $Tipolog;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqDetalleMedIndi") {

    $myDat = new stdClass();
    $consulta = "SELECT 
  CONCAT(
    proy.cod_proyect,
    ' - ',
    proy.nombre_proyect
  ) nomproy,
  ind.nomb_indi nomind,
  ind.id_indi idind,
  met.desc_meta descmet,
  mi.resulindi resind,
  mi.fecha fecmed,
  mi.responsable responsa,
 mi.id idmed,
 mi.anio aniomed,
 mi.meta metproy,
 mi.estado estmetp,
 mi.evidencia eviden,
 mi.frecuencia frec,
  met.tipdato_metas tvari
FROM
  proyectos proy 
  RIGHT JOIN mediindicador mi 
    ON proy.id_proyect = mi.proy_ori 
  LEFT JOIN indicadores ind 
    ON mi.indicador = ind.id_indi 
  LEFT JOIN metas met 
    ON mi.id_meta = met.id_meta 
    LEFT JOIN evaluacionindicador ev 
    ON mi.id=ev.id_med
    WHERE mi.id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->idind = $fila["idind"];
            $myDat->nombind = $fila["nomind"];
            $myDat->descmet = $fila["descmet"];
            $myDat->nomproy = $fila["nomproy"];
            $myDat->resind = $fila["resind"];
            $myDat->fecmed = $fila["fecmed"];
            $myDat->responsa = $fila["responsa"];
            $myDat->aniomed = $fila["aniomed"];
            $myDat->metproy = $fila["metproy"];
            $evi = $fila["eviden"];
            $myDat->frec = $fila["frec"];
            $myDat->tvari = $fila["tvari"];
        }
    }


    if ($evi === "") {
        $evid = "Sin Evidencia";
    } else {
        $parsrc = explode("*", $evi);
        $tamsrc = count($parsrc);
        $j = 1;
        for ($i = 0; $i < $tamsrc; $i++) {
            $evid .= "<a href='" . $parsrc[$i] . "' target='_blank' class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Evidencia " . $j . "</a>";
            $j++;
        }
    }

    $myDat->evid = $evid;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqDetalleIndicadorPlan") {

    $myDat = new stdClass();

    $consulta = "SELECT id_med, id_indicador FROM evaluacionindicador WHERE id='" . $_POST["cod"] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $idmed = $fila["id_med"];
            $myDat->id_med = $fila["id_med"];
            $myDat->id_indi = $fila["id_indicador"];
            $idindi = $fila["id_indicador"];
        }
    }

    $consulta = "SELECT anio, frecuencia, meta,proy_ori ori,id_meta  FROM mediindicador WHERE id='" . $idmed . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->anio = $fila["anio"];
            $myDat->frecuencia = $fila["frecuencia"];
            $myDat->meta = $fila["meta"];
            $myDat->idorigen = $fila["ori"];
            $myDat->id_meta = $fila["id_meta"];
        }
    }


    $consulta = "SELECT
  act.id id,
  act.acti act,
  act.respo resp,
  act.estado esta
FROM
  actividaplaneadadas act
  LEFT JOIN responsables res
    ON act.respo = res.id_responsable WHERE act.ideval='" . $_POST["cod"] . "'";

    $resultado1 = mysqli_query($link, $consulta);
    $Tab_Act = "<thead>
                <tr>
                    <td>
                        <i class='fa fa-angle-right'></i> #
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i> Actividad
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i> Responsable
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i> Cumplida
                    </td>
                </tr>
            </thead>"
        . "   <tbody id='tb_Body_Indicadores'>\n";

    $contACt = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contACt++;
            $Tab_Act .= "<tr class=\"selected\" id='filaAct" . $contACt . "' ><td>" . $contACt . "</td>";
            $Tab_Act .= "<td>" . $fila["act"] . "</td>";
            $Tab_Act .= "<td>" . $fila["resp"] . "</td>";
            if ($fila["esta"] == "PENDIENTE") {
                $Tab_Act .= "<td><input type='hidden' id='Activ" . $contACt . "' name='Activ' value='" . $fila["id"] . "' /><input type='checkbox' id='sel" . $contACt . "'  class='form-control' name='sel'  value='ON' /></td></tr>";
            } else {
                $Tab_Act .= "<td><input type='hidden' id='Activ" . $contACt . "' name='Activ' value='" . $fila["id"] . "' /><input type='checkbox' checked id='sel" . $contACt . "'  class='form-control' name='sel'  value='ON' /></td></tr>";
            }
        }
    }

    $Tab_Act .= "</tbody>";


    $myDat->tb_Activ = $Tab_Act;
    $myDat->contAct = $contACt;


    $consulta = "SELECT ind.nomb_indi nom, ind.obj_indi obj, proc.descripcion nomproc, "
        . "ind.frec_indi frec, ind.relmat_indi relmat,ind.fuent_indi ori,ind.resp_indi resp, "
        . "ind.tip_indi tind "
        . "FROM indicadores ind LEFT JOIN procesos proc ON ind.proc_indi=proc.id  "
        . "where ind.id_indi='" . $_POST["idind"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nom = $fila["nom"];
            $myDat->obj = $fila["obj"];
            $myDat->nomproc = $fila["nomproc"];
            $myDat->frec = $fila["frec"];
            $myDat->tind = $fila["tind"];
            $myDat->relmat = $fila["relmat"];
            $resp = $fila["resp"];
            $orinf = $fila["ori"];
            $frec = $fila["frec"];
            $remat = $fila["relmat"];
        }
    }

    $freMedi = "";

    if ($frec == "Mensual") {
        $freMedi = "<option value='Primer Mes'>Primer Mes</option>"
            . "<option value='Segundo Mes'>Segundo Mes</option>"
            . "<option value='Tercer Mes'>Tercer Mes</option>"
            . "<option value='Cuarto Mes'>Cuarto Mes</option>"
            . "<option value='Quinto Mes'>Quinto Mes</option>"
            . "<option value='Sexto Mes'>Sexto Mes</option>"
            . "<option value='Septimo Mes'>Septimo Mes</option>"
            . "<option value='Octavo Mes'>Octavo Mes</option>"
            . "<option value='Noveno Mes'>Noveno Mes</option>"
            . "<option value='Decimo Mes'>Decimo Mes</option>"
            . "<option value='Onceavo Mes'>Onceavo Mes</option>"
            . "<option value='Doceavo Mes'>Doceavo Mes</option>";
    } else if ($frec == "Trimestral") {
        $freMedi = "<option value='Primer Trimestre'>Primer Trimestre</option>"
            . "<option value='Segundo Trimestre'>Segundo Trimestre</option>"
            . "<option value='Tercer Trimestre'>Tercer Trimestre</option>"
            . "<option value='Cuarto Trimestre'>Cuarto Trimestre</option>";
    } else if ($frec == "Semestral") {
        $freMedi = "<option value='Primer Semestre'>Primer Semestre</option>"
            . "<option value='Segundo Semestre'>Segundo Semestre</option>";
    } else if ($frec == "Anual") {
        $freMedi = "<option value='No Aplica'>No Aplica</option>";
    }

    $myDat->freMedi = $freMedi;


    $Consulta = "SELECT * FROM variaibles_indicadores WHERE indicador='" . $_POST["idind"] . "'";
    $resultado = mysqli_query($link, $Consulta);
    $rawdata = array(); //creamos un array
    //guardamos en un array multidimensional todos los datos de la consulta
    $i = 0;

    while ($row = mysqli_fetch_array($resultado)) {
        $rawdata[$i] = $row;
        $i++;
    }

    $myDat->variables = $rawdata;
    $respon = "";
    $consulta2 = "SELECT * FROM cargos WHERE id_cargo IN (" . $resp . ")";
    //  echo $consulta2;
    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $respon = $respon . $fila2["des_cargo"] . ', ';
        }
    }

    $myDat->resp = trim($respon, ', ');

    $OrInf = "";
    $consulta2 = "SELECT * FROM fuente_informacion WHERE id IN (" . $orinf . ")";

    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $OrInf = $OrInf . $fila2["nombre"] . ', ';
        }
    }

    $myDat->oinf = trim($OrInf, ', ');



    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargTipologiaCont") {

    $myDat = new stdClass();
    $Tipolog = "<option value=' '>Seleccione...</option>";
    //////////////////////CONSULTAR TIPOLOGIA
    $consulta = "select * from tipo_contratacion";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Tipolog .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }
    $myDat->Tipolog = $Tipolog;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSupervisor") {

    $myDat = new stdClass();
    $Superv = "<option value=' '>Seleccione...</option>";

    //////////////////////CONSULTAR SUPERVISOR
    $consulta = "select * from supervisores where estado_supervisores='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Superv .= "<option value='" . $fila["id_supervisores"] . "'>" . $fila["cod_supervisores"] . " - " . $fila["nom_supervisores"] . "</option>";
        }
    }

    $myDat->Superv = $Superv;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargInterventor") {

    $myDat = new stdClass();
    $Interv = "<option value=' '>Seleccione...</option>";

    //////////////////////CONSULTAR INTERVENTOR
    $consulta = "select * from interventores where estado_interventores='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Interv .= "<option value='" . $fila["id_interventores"] . "'>" . $fila["cod_interventores"] . " - " . $fila["nom_interventores"] . "</option>";
        }
    }

    $myDat->Interv = $Interv;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsTodoIndi") {

    $myDat = new stdClass();
    $fuent = "";
    $proce = "<option value=' '>Seleccione...</option>";
    $respon = "";
    $estrat = "";
    $prog = "";
    $objet = "";

    //////////////////////CONSULTAR FUENTE INFORMACIÓN
    $consulta = "select * from fuente_informacion where estado='ACTIVO'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $fuent .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }

    //////////////////////CONSULTAR PROCESOS
    $consulta = "select * from procesos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $proce .= "<option value='" . $fila["id"] . "'>" . $fila["descripcion"] . "</option>";
        }
    }

    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from responsables where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $respon .= "<option value='" . $fila["id_responsable"] . "'>" . $fila["cod_responsable"] . " - " . $fila["nom_responsable"] . "</option>";
        }
    }

    $myDat->fuent = $fuent;
    $myDat->proce = $proce;
    $myDat->respon = $respon;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsRespon") {
    $myDat = new stdClass();
    $respon = "<option value=' '>Seleccione...</option>";

    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from responsables where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $respon .= "<option value='" . $fila["id_responsable"] . "'>" . $fila["cod_responsable"] . " - " . $fila["nom_responsable"] . "</option>";
        }
    }
    $myDat->respon = $respon;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditIndicadores") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM indicadores where id_indi='" . $_POST["cod"] . "'";
    $unidMd = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_indi = $fila["cod_indi"];
            $myDat->num_indi = $fila["num_indi"];
            $myDat->nomb_indi = $fila["nomb_indi"];
            $myDat->obj_indi = $fila["obj_indi"];
            $myDat->proc_indi = $fila["proc_indi"];
            $myDat->frec_indi = $fila["frec_indi"];
            $myDat->unid_indi = $fila["unid_indi"];
            $unidMd = $fila["unid_indi"];
            $myDat->fuent_indi = $fila["fuent_indi"];
            $myDat->tip_indi = $fila["tip_indi"];
            $myDat->resp_indi = $fila["resp_indi"];
            $myDat->relmat_indi = $fila["relmat_indi"];
        }
    }


    $consulta = "SELECT ixm.*, met.desc_meta desmet,met.cod_meta cod, met.id_meta id FROM indicadoresxmetas ixm left join metas met on ixm.meta=met.id_meta "
        . " where ixm.indicador='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Meta = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Código\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre de la Meta \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Meta'>\n";

    $contMeta = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contMeta++;
            $Tab_Meta .= "<tr class=\"selected\" id='filaMeta" . $contMeta . "' ><td>" . $contMeta . "</td>";
            $Tab_Meta .= "<td>" . $fila["cod"] . "</td>";
            $Tab_Meta .= "<td>" . $fila["desmet"] . "</td>";
            $Tab_Meta .= "<td><input type='hidden' id='idMetas" . $contMeta . "' " . "name='actividades' value='" . $fila["id"] . "//" . $fila["cod"] . "//" . $fila["desmet"] . "' /><a onclick=\"$.QuitarMeta('filaMeta" . $contMeta . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Quitar</a><a onclick=\"$.VerMeta('" . $fila["id"] . "')\" class='btn default btn-xs blue'><i class='fa fa-search'></i> Ver </a></td></tr>";
        }
    }

    $Tab_Meta .= "</tbody>";
    $myDat->Tab_Meta = $Tab_Meta;
    $myDat->contMeta = $contMeta;

    $consulta = "SELECT * FROM variaibles_indicadores WHERE indicador='" . $_POST["cod"] . "'";
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Vari = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Descripción Variable \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_BodyVar'>\n";

    $contVaria = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contVaria++;
            $Tab_Vari .= "<tr class=\"selected\" id='filaVari" . $contVaria . "' ><td style='cursor:pointer;' onclick=\"$.AddVarForm('idVariable" . $contVaria . "')\">" . $contVaria . "</td>";
            $Tab_Vari .= "<td style='cursor:pointer;' onclick=\"$.AddVarForm('idVariable" . $contVaria . "')\">" . $fila["variable"] . "</td>";
            $Tab_Vari .= "<td><input type='hidden' id='idVariable" . $contVaria . "' " . "name='idVariable' value='" . $fila["variable"] . "' /><a onclick=\"$.QuitarVari('filaVari" . $contVaria . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }

    $Tab_Vari .= "</tbody>";
    $myDat->Tab_Vari = $Tab_Vari;
    $myDat->contVaria = $contVaria;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqDetalleIndicadores") {

    $myDat = new stdClass();
    $consulta = "SELECT ind.nomb_indi nom, ind.obj_indi obj, proc.descripcion nomproc, "
        . "ind.frec_indi frec, ind.relmat_indi relmat,ind.fuent_indi ori,ind.resp_indi resp, "
        . "ind.tip_indi tind "
        . "FROM indicadores ind LEFT JOIN procesos proc ON ind.proc_indi=proc.id  "
        . "where ind.id_indi='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nom = $fila["nom"];
            $myDat->obj = $fila["obj"];
            $myDat->nomproc = $fila["nomproc"];
            $myDat->frec = $fila["frec"];
            $myDat->tind = $fila["tind"];
            $myDat->relmat = $fila["relmat"];
            $resp = $fila["resp"];
            $orinf = $fila["ori"];
            $frec = $fila["frec"];
            $remat = $fila["relmat"];
        }
    }

    $freMedi = "";

    if ($frec == "Mensual") {
        $freMedi = "<option value='Primer Mes'>Primer Mes</option>"
            . "<option value='Segundo Mes'>Segundo Mes</option>"
            . "<option value='Tercer Mes'>Tercer Mes</option>"
            . "<option value='Cuarto Mes'>Cuarto Mes</option>"
            . "<option value='Quinto Mes'>Quinto Mes</option>"
            . "<option value='Sexto Mes'>Sexto Mes</option>"
            . "<option value='Septimo Mes'>Septimo Mes</option>"
            . "<option value='Octavo Mes'>Octavo Mes</option>"
            . "<option value='Noveno Mes'>Noveno Mes</option>"
            . "<option value='Decimo Mes'>Decimo Mes</option>"
            . "<option value='Onceavo Mes'>Onceavo Mes</option>"
            . "<option value='Doceavo Mes'>Doceavo Mes</option>";
    } else if ($frec == "Trimestral") {
        $freMedi = "<option value='Primer Trimestre'>Primer Trimestre</option>"
            . "<option value='Segundo Trimestre'>Segundo Trimestre</option>"
            . "<option value='Tercer Trimestre'>Tercer Trimestre</option>"
            . "<option value='Cuarto Trimestre'>Cuarto Trimestre</option>";
    } else if ($frec == "Semestral") {
        $freMedi = "<option value='Primer Semestre'>Primer Semestre</option>"
            . "<option value='Segundo Semestre'>Segundo Semestre</option>";
    } else if ($frec == "Anual") {
        $freMedi = "<option value='No Aplica'>No Aplica</option>";
    }

    $myDat->freMedi = $freMedi;


    $Consulta = "SELECT * FROM variaibles_indicadores WHERE indicador='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $Consulta);
    $rawdata = array(); //creamos un array
    //guardamos en un array multidimensional todos los datos de la consulta
    $i = 0;

    while ($row = mysqli_fetch_array($resultado)) {
        $rawdata[$i] = $row;
        $i++;
    }

    $myDat->variables = $rawdata;

    $metas = "<option value=' '>Seleccione...</option>";

    $consulta2 = "SELECT 
  met.id_meta id,
  met.cod_meta cod,
  met.desc_meta desmet,
  pm.aport_proy meta
FROM
  indicadoresxmetas ixm 
  LEFT JOIN metas met 
    ON ixm.meta = met.id_meta
    LEFT JOIN proyect_metas pm
    ON ixm.meta=pm.id_meta
WHERE ixm.indicador='" . $_POST["cod"] . "' AND pm.cod_proy='" . $_POST["proy"] . "'";
    //echo $consulta2;
    $resultado = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado)) {
            $metas .= "<option value='" . $fila2["id"] . '/' . $fila2["meta"] . "'>" . $fila2["cod"] . " - " . $fila2["desmet"] . "</option>";
        }
    }
    $myDat->metas = $metas;

    $respon = "";
    $consulta2 = "SELECT * FROM cargos WHERE id_cargo IN (" . $resp . ")";
    //  echo $consulta2;
    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $respon = $respon . $fila2["des_cargo"] . ', ';
        }
    }

    $myDat->resp = trim($respon, ', ');

    $OrInf = "";
    $consulta2 = "SELECT * FROM fuente_informacion WHERE id IN (" . $orinf . ")";
    $resultado2 = mysqli_query($link, $consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        while ($fila2 = mysqli_fetch_array($resultado2)) {
            $OrInf = $OrInf . $fila2["nombre"] . ', ';
        }
    }

    $myDat->oinf = trim($OrInf, ', ');



    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqDetalleMedIndiEdit") {

    $myDat = new stdClass();
    $consulta = "SELECT 
  CONCAT(
    proy.cod_proyect,
    ' - ',
    proy.nombre_proyect
  ) nomproy,
  ind.nomb_indi nomind,
  met.desc_meta descmet,
  mi.resulindi resind,
  mi.fecha fecmed,
  mi.responsable responsa,
 mi.id idmed,
 mi.anio aniomed,
 mi.meta metproy,
 mi.estado estmetp,
 mi.evidencia eviden,
 mi.frecuencia frec,
  met.tipdato_metas tvari
FROM
  proyectos proy 
  RIGHT JOIN mediindicador mi 
    ON proy.id_proyect = mi.proy_ori 
  LEFT JOIN indicadores ind 
    ON mi.indicador = ind.id_indi 
  LEFT JOIN metas met 
    ON mi.id_meta = met.id_meta 
    LEFT JOIN evaluacionindicador ev 
    ON mi.id=ev.id_med
    WHERE mi.id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nombind = $fila["nomind"];
            $myDat->descmet = $fila["descmet"];
            $myDat->nomproy = $fila["nomproy"];
            $myDat->resind = $fila["resind"];
            $myDat->fecmed = $fila["fecmed"];
            $myDat->responsa = $fila["responsa"];
            $myDat->aniomed = $fila["aniomed"];
            $myDat->metproy = $fila["metproy"];
            $evi = $fila["eviden"];
            $myDat->frec = $fila["frec"];
            $myDat->tvari = $fila["tvari"];
        }
    }


    if ($evi === "") {
        $evid = "Sin Evidencia";
    } else {
        $parsrc = explode("*", $evi);
        $tamsrc = count($parsrc);
        $j = 1;
        for ($i = 0; $i < $tamsrc; $i++) {
            $evid .= "<a href='" . $parsrc[$i] . "' target='_blank' class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Evidencia " . $j . "</a>";
            $j++;
        }
    }

    $myDat->evid = $evid;

    $consulta = "SELECT * FROM evaluacionindicador WHERE id_med='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fecha = $fila["fecha"];
            $idval = $fila["id"];
        }
    }

    $consulta = "SELECT
  act.id id,
  act.acti act,
  CONCAT(
    res.cod_responsable,
    '-',
    res.nom_responsable
  ) resp,
  res.id_responsable idres
FROM
  actividaplaneadadas act
  LEFT JOIN responsables res
    ON act.respo = res.id_responsable WHERE act.ideval='" . $idval . "'";
    $resultado1 = mysqli_query($link, $consulta);
    $Tab_Act = "<thead>
                <tr>
                    <td>
                        <i class='fa fa-angle-right'></i> #
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i> Actividad
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i> Responsable
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i> Acción
                    </td>
                </tr>
            </thead>"
        . "   <tbody id='tb_Body_Indicadores'>\n";

    $contACt = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contACt++;
            $Tab_Act .= "<tr class=\"selected\" id='filaAct" . $contACt . "' ><td>" . $contACt . "</td>";
            $Tab_Act .= "<td>" . $fila["act"] . "</td>";
            $Tab_Act .= "<td>" . $fila["resp"] . "</td>";
            $Tab_Act .= "<td><input type='hidden' id='Acti" . $contACt . "' " . "name='Acti' value='" . $fila["act"] . "//" . $fila["resp"] . "' /><a onclick=\"$.QuitarActi('filaAct" . $contACt . "')\" class=\"btn default btn-xs red\">" . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }

    $Tab_Act .= "</tbody>";


    $myDat->tb_Activ = $Tab_Act;
    $myDat->contAct = $contACt;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqIndicadoresProyect") {

    $myDat = new stdClass();

    $consulta = "select nombre_proyect nom from proyectos where id_proyect='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nom_politica = $fila["nom"];
        }
    }

    $cont = 0;
    $consulta = "SELECT ind.id_indi id, ind.nomb_indi nom, ind.tip_indi tipo
 FROM indicadoresxmetas  im
LEFT JOIN indicadores ind ON im.indicador=ind.id_indi
LEFT JOIN proyect_metas pm ON im.meta=pm.id_meta
WHERE pm.cod_proy='" . $_POST["cod"] . "'";

    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Indicad = "<thead>\n" .
        "      <tr>\n" .
        "          <td>\n" .
        "              <i></i> #\n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Nombre del Indicador \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Tipo de Indicador \n" .
        "          </td>\n" .
        "          <td>\n" .
        "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
        "          </td>\n" .
        "      </tr>\n" .
        "  </thead>"
        . "   <tbody id='tb_Body_Indicadores'>\n";

    $contIndicad = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contIndicad++;
            $Tab_Indicad .= "<tr class=\"selected\" id='filaIndicadores" . $contIndicad . "' ><td>" . $contIndicad . "</td>";
            $Tab_Indicad .= "<td>" . $fila["nom"] . "</td>";
            $Tab_Indicad .= "<td>" . $fila["tipo"] . "</td>";
            $Tab_Indicad .= "<td><input type='hidden' id='idIndicadores" . $contIndicad . "' " . "name='actividades' value='" . $fila["id"] . "' /><a onclick=\"$.MedirIndicador('" . $fila["id"] . "')\" class=\"btn default btn-xs blue\">" . "<i class=\"fa fa-check\"></i> Medir</a></td></tr>";
        }
    }

    $Tab_Indicad .= "</tbody>";

    $myDat->CadIndi = $Tab_Indicad;
    $myDat->cont = $contIndicad;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "buscarDatosUsuario") {

    $myDat = new stdClass();

    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".usuarios where id_usuario='" . $_POST["idUsu"] . "'";
   
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cue_correo = $fila["cue_correo"];
            $myDat->cue_tele = $fila["cue_tele"];
            $myDat->cue_dir = $fila["cue_dir"];
        }
    }

   
    $consulta = "SELECT id_proyect, nombre_proyect,dsecretar_proyect, CASE WHEN estado_proyect='En Ejecucion' THEN 'En Ejecución' ELSE estado_proyect END estado,(SELECT SUM(total) valor FROM banco_proyec_presupuesto WHERE id_proyect = proy.id_proyect GROUP BY id_proyect) AS valor FROM usu_proyect usu
    LEFT JOIN proyectos proy ON usu.proyect = proy.id_proyect
    WHERE usu.usuario=".$_POST["idUsu"]." AND proy.estado='ACTIVO'
    GROUP BY usu.proyect";
    $resultado1 = mysqli_query($link, $consulta);

    $tr_poryectos = '';
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $detSecre = explode(" - ", $fila['dsecretar_proyect']);
            $tr_poryectos.='  <tr>
            <td><a href="$.verProyecto('.$fila['id_proyect'].');">'.$fila['nombre_proyect'].'</a></td>
            <td class="hidden-phone">'.$detSecre[1].'</td>
            <td style="text-align: center; width:200px;">$ '.number_format($fila['valor'], 2, ",", ".").'<br><span class="label label-success label-mini">'.$fila['estado'].'</span></td>
           
        </tr>';
        }
    }    

    $myDat->tr_poryectos = $tr_poryectos;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "ConsulUsuario") {
    $myDat = new stdClass();
    $Usu = "<option value=' '>Seleccione...</option>";
    /////////////////////CONSULTAR USUARIOS
    $consulta = "select id_usuario id, cue_nombres nombre from " . $_SESSION['ses_BDBase'] . ".usuarios";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Usu .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }
    $myDat->usu = $Usu;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaTodProy") {

    $myDat = new stdClass();
    $Tipolog = "<option value=' '>Seleccione...</option>";
    $Respons = "<option value=' '>Seleccione...</option>";
    $Secre = "<option value=' '>Seleccione...</option>";
    $dpto = "<option value=' '>Seleccione...</option>";
    $usu = "<option value=' '>Seleccione...</option>";
    $fFin = "<option value=' '>Seleccione...</option>";
    $barrio = "<option value=' '>Seleccione...</option><option value='N/A'>N/A</option>";

    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from responsables where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Respons .= "<option value='" . $fila["id_responsable"] . "'>" . $fila["cod_responsable"] . " - " . $fila["nom_responsable"] . "</option>";
        }
    }

    //////////////////////CONSULTAR TIPOLOGIA
    $consulta = "select * from tipologia_proyecto where est_tipolo='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Tipolog .= "<option value='" . $fila["id_tipolo"] . "'>" . $fila["cod_tipolo"] . " - " . $fila["des_tipolo"] . "</option>";
        }
    }
    //////////////////////CONSULTAR FUENTE DE FINANCIACION
    $consulta = "select * from fuentes where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $fFin .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }
    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from secretarias where estado_secretaria='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Secre .= "<option value='" . $fila["idsecretarias"] . "'>" . $fila["cod_secretarias"] . " - " . $fila["des_secretarias"] . "</option>";
        }
    }

    /////////////////////CONSULTAR DPTO
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".dpto";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $dpto .= "<option value='" . $fila["COD_DPTO"] . "'>" . $fila["COD_DPTO"] . " - " . $fila["NOM_DPTO"] . "</option>";
        }
    }
    /////////////////////CONSULTAR BARRIOS
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".barrios";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $barrio .= "<option value='" . $fila["codigo"] . "'>" . $fila["codigo"] . " - " . $fila["nombre"] . "</option>";
        }
    }
    /////////////////////CONSULTAR USUARIOS
    $consulta = "select id_usuario id, cue_nombres nombre from " . $_SESSION['ses_BDBase'] . ".usuarios";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $usu .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }

    $myDat->Tipolog = $Tipolog;
    $myDat->fFin = $fFin;
    $myDat->Secre = $Secre;
    $myDat->dpto = $dpto;
    $myDat->barrio = $barrio;
    $myDat->Respons = $Respons;
    $myDat->usuarios = $usu;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaDatCompa") {

    $myDat = new stdClass();

    $dpto = "<option value=' '>Seleccione...</option>";
    $barrio = "<option value=' '>Seleccione...</option><option value='N/A'>N/A</option>";


    /////////////////////CONSULTAR DPTO
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".dpto";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $dpto .= "<option value='" . $fila["COD_DPTO"] . "'>" . $fila["COD_DPTO"] . " - " . $fila["NOM_DPTO"] . "</option>";
        }
    }
    /////////////////////CONSULTAR BARRIOS
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".barrios";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $barrio .= "<option value='" . $fila["codigo"] . "'>" . $fila["codigo"] . " - " . $fila["nombre"] . "</option>";
        }
    }

    $myDat->dpto = $dpto;
    $myDat->barrio = $barrio;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaTodContr") {

    $myDat = new stdClass();
    $Tipolog = "<option value=' '>Seleccione...</option>";
    $Contrat = "<option value=' '>Seleccione...</option>";
    $Proyec = "<option value=' '>Seleccione...</option>";
    $ProyecBus = "<option value=' '>Todos...</option>";
    $Superv = "<option value=' '>Seleccione...</option>";
    $Interv = "<option value=' '>Seleccione...</option>";
    $ProExp = "<option value=' '>Seleccione...</option>";
    $dpto = "<option value=' '>Seleccione...</option>";
    $fuente = "<option value=' '>Seleccione...</option>";
    $catGastos = "<option value=' '>Seleccione...</option>";

    //////////////////////CONSULTAR SUPERVISOR
    $consulta = "select * from supervisores where estado_supervisores='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Superv .= "<option value='" . $fila["id_supervisores"] . "'>" . $fila["cod_supervisores"] . " - " . $fila["nom_supervisores"] . "</option>";
        }
    }
    //////////////////////CONSULTAR INTERVENTOR
    $consulta = "select * from interventores where estado_interventores='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Interv .= "<option value='" . $fila["id_interventores"] . "'>" . $fila["cod_interventores"] . " - " . $fila["nom_interventores"] . "</option>";
        }
    }
    //////////////////////CONSULTAR TIPOLOGIA
    $consulta = "select * from tipo_contratacion where ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Tipolog .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }

    //////////////////////CONSULTAR CATEGORIA DE GASTOS
    $consulta = "select * from categoria_gastos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $catGastos .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }
    //////////////////////CONSULTAR CONTRATISTA
    $consulta = "select * from contratistas WHERE estado_contratis='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Contrat .= "<option value='" . $fila["id_contratis"] . "'>" . $fila["ident_contratis"] . " - " . $fila["nom_contratis"] . "</option>";
        }
    }

    /////////////////////CONSULTAR PROYECTOS
    $consulta = "select * from proyectos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Proyec .= "<option value='" . $fila["id_proyect"] . "'>" . $fila["cod_proyect"] . " - " . $fila["nombre_proyect"] . "</option>";
            $ProyecBus .= "<option value='" . $fila["id_proyect"] . "'>" . $fila["cod_proyect"] . " - " . $fila["nombre_proyect"] . "</option>";
        }
    }

    /////////////////////CONSULTAR PROYECTOS expres
    $consulta = "select * from proyectos_expres where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ProExp .= "<option value='" . $fila["id"] . "'>" . $fila["codigo"] . " - " . $fila["nombre"] . "</option>";
        }
    }

    /////////////////////CONSULTAR FUENTE DE FINANCIACION
    $consulta = "select * from fuentes where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $fuente .= "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
        }
    }


    /////////////////////CONSULTAR DPTO
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".dpto";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $dpto .= "<option value='" . $fila["COD_DPTO"] . "'>" . $fila["COD_DPTO"] . " - " . $fila["NOM_DPTO"] . "</option>";
        }
    }


    $myDat->Tipolog = $Tipolog;
    $myDat->Contrat = $Contrat;
    $myDat->Proyec = $Proyec;
    $myDat->ProyecBus = $ProyecBus;
    $myDat->Superv = $Superv;
    $myDat->Interv = $Interv;
    $myDat->ProExp = $ProExp;
    $myDat->fuenteFinanciacion = $fuente;
    $myDat->dpto = $dpto;
    $myDat->catGastos = $catGastos;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargaDatProyect") {

    $myDat = new stdClass();
    $ejes = "<option value=' '>Todos...</option>";
    $Secr = "<option value=' '>Todas...</option>";
    $Proyec = "<option value=' '>Todos</option>";

    /////////////////////CONSULTAR PROYECTOS
    $consulta = "select * from proyectos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Proyec .= "<option value='" . $fila["id_proyect"] . "'>" . $fila["cod_proyect"] . " - " . $fila["nombre_proyect"] . "</option>";
        }
    }

    /////////////////////CONSULTAR SECRETARIAS
    $consulta = "select * from secretarias where estado_secretaria='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Secr .= "<option value='" . $fila["idsecretarias"] . "'>" . $fila["cod_secretarias"] . " - " . $fila["des_secretarias"] . "</option>";
        }
    }
    /////////////////////CONSULTAR EJES
    $consulta = "select * from ejes where ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ejes .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }


    $myDat->ejes = $ejes;
    $myDat->Secr = $Secr;
    $myDat->Proyec = $Proyec;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "cargaMun") {

    $myDat = new stdClass();
    $mun = "<option value=' '>Seleccione...</option><option value='N/A'>N/A</option>";

    //////////////////////CONSULTAR TIPOLOGIA
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".muni where ID_DPTO='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $mun .= "<option value='" . $fila["COD_MUNI"] . "'>" . $fila["COD_MUNI"] . " - " . $fila["NOM_MUNI"] . "</option>";
        }
    }
    $myDat->mun = $mun;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "cargaDepar") {

    $myDat = new stdClass();
    $Depa = "<option value=' '>Seleccione...</option>";

    //////////////////////CONSULTAR DEPARTAMENTOS
    $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".dpto";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Depa .= "<option value='" . $fila["COD_DPTO"] . "'>" . $fila["COD_DPTO"] . " - " . $fila["NOM_DPTO"] . "</option>";
        }
    }
    $myDat->Depa = $Depa;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusCorr") {

    $myDat = new stdClass();
    $corr = "<option value=' '>Seleccione...</option><option value='N/A'>N/A</option>";

    //////////////////////CONSULTAR TIPOLOGIA
    $consulta = "select * from " . $_SESSION['ses_BDBase'] . ".corregi where ID_MUNI='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $corr .= "<option value='" . $fila["COD_CORREGI"] . "'>" . $fila["COD_CORREGI"] . " - " . $fila["NOM_CORREGI"] . "</option>";
        }
    }
    $myDat->corr = $corr;


    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSelEstrategia") {

    $myDat = new stdClass();
    $estrat = "<option value=' '>Seleccione...</option>";

    $consulta = "select * from componente where ID_EJE='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $estrat .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->estrat = $estrat;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSelEstrategiainf") {

    $myDat = new stdClass();
    $estrat = "<option value=' '>Todos...</option>";

    $consulta = "select * from componente where ID_EJE='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $estrat .= "<option value='" . $fila["ID"] . "'>" . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->estrat = $estrat;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InserImgSec") {
    $myDat = new stdClass();
    $consulta = "INSERT INTO aux_inf_atra_sup VALUES(null,'" . $_POST['img'] . "')";
    mysqli_query($link, $consulta);
    $myDat->img = $_POST['img'];
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "InserImgProy") {
    $myDat = new stdClass();
    $consulta = "INSERT INTO aux_inf_gen_proy VALUES(null,'" . $_POST['img'] . "')";
    mysqli_query($link, $consulta);
    $myDat->img = $_POST['img'];
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "UdParEval") {
    $consulta = "UPDATE para_calf_contratista SET PorCO='" . $_POST['PCCO'] . "',PorCE='" . $_POST['PCEC'] . "',PorCC='" . $_POST['PCC'] . "'";
    mysqli_query($link, $consulta);

    echo "Bien";
} else if ($_POST['ope'] == "eliminarAdicion") {
    $consulta = "UPDATE adicion_contrato SET estado='ELIMINADO' WHERE id=" . $_POST['id'];
    mysqli_query($link, $consulta);

    ///ELIMINAR ADICION AGREGADA AL PRESUPUESTO DEL PROYECTO
    $consulta = "DELETE FROM banco_proyec_presupuesto WHERE adicion='" . $_POST['id'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 14;
    }

    ///ELIMINAR ADICION AGREGADA A LA FINANCIACION DEL PROYECTO
    $consulta = "DELETE FROM banco_proyec_financiacion WHERE adicion='" . $_POST['id'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 15;
    }

    echo "Bien";
} else if ($_POST['ope'] == "eliminarGasto") {
    $consulta = "UPDATE gastos_contrato SET estado='ELIMINADO' WHERE id=" . $_POST['id'];
    mysqli_query($link, $consulta);

    echo "Bien";
} else if ($_POST['ope'] == "CargSelEstrategia2") {

    $myDat = new stdClass();
    $estrat = "<option value=' '>Todos</option>";

    $consulta = "select * from componente where ID_EJE='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $estrat .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->estrat = $estrat;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "cargaClasif") {

    $myDat = new stdClass();
    $clasif = "<option value=' '>Seleccione...</option>";

    $consulta = "select * from clasificacion_proyecto where tipolog='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $clasif .= "<option value='" . $fila["id"] . "'>" . $fila["cod_clasif"] . " - " . $fila["desc"] . "</option>";
        }
    }

    $myDat->clasif = $clasif;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSelPrograma") {

    $myDat = new stdClass();
    $program = "<option value=' '>Seleccione...</option>";

    $consulta = "select * from programas where ID_COMP='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $program .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->program = $program;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSelProgramainf") {

    $myDat = new stdClass();
    $program = "<option value=' '>Todos...</option>";

    $consulta = "select * from programas where ID_COMP='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $program .= "<option value='" . $fila["ID"] . "'>" . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->program = $program;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSelPrograma2") {

    $myDat = new stdClass();
    $program = "<option value=' '>Todos</option>";

    $consulta = "select * from programas where ID_COMP='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $program .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->program = $program;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSelObjetivos") {

    $myDat = new stdClass();
    $objet = "<option value=' '>Seleccione...</option>";

    $consulta = "select * from objetivos where ID_PRO='" . $_POST['cod'] . "' AND ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $objet .= "<option value='" . $fila["ID"] . "'>" . $fila["CODIGO"] . " - " . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->objet = $objet;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "GrafContrat") {

    // $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT num_contrato, porav_contrato FROM contratos WHERE idproy_contrato='" . $_POST["proy"] . "' AND id_contrato IN
(SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato)";
    //    echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $mcont = $fila['num_contrato'];
            $procpro = str_replace("%", "", $fila['porav_contrato']);

            $rawdata[] = array(
                "contr" => $mcont,
                "porc" => $procpro
            );
        }
        echo json_encode($rawdata);
    } else {
        echo json_encode("no");
    }

    //   $myDat = json_encode($rawdata);
    //    echo $myDat;
} else if ($_POST['ope'] == "GrafContratos") {


    $consulta = "SELECT 
   num_contrato
FROM
  contratos 
WHERE estad_contrato = '" . $_POST['Estad'] . "' 
  AND id_contrato IN 
  (SELECT 
    MAX(id_contrato) 
  FROM
    contratos 
  GROUP BY num_contrato)";


    //echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $codpro = $fila['num_contrato'];

            $rawdata[] = array(
                "Cate" => $codpro,
                "cant" => "1"
            );
        }
        echo json_encode($rawdata);
    } else {
        echo json_encode("no");
    }

    //   $myDat = json_encode($rawdata);
    //    echo $myDat;
} else if ($_POST['ope'] == "GrafProyectos") {

    if ($_POST['TipInf'] == "1") {
        $consulta = "SELECT cod_proyect FROM proyectos WHERE estado_proyect='" . $_POST["Estad"] . "' and estado='ACTIVO'";
    } else if ($_POST['TipInf'] == "2") {
        $consulta = "SELECT cod_proyect FROM proyectos p LEFT JOIN secretarias s ON p.secretaria_proyect=s.idsecretarias
                     WHERE s.des_secretarias='" . $_POST["Estad"] . "' and p.estado='ACTIVO'";
    } else if ($_POST['TipInf'] == "3") {
        $consulta = "SELECT cod_proyect FROM proyectos p LEFT JOIN proyect_metas pm ON p.id_proyect=pm.cod_proy
                     LEFT JOIN metas m ON pm.id_meta=m.id_meta
                     LEFT JOIN ejes e ON m.ideje_metas=e.ID
                     WHERE e.NOMBRE='" . $_POST["Estad"] . "' and p.estado='ACTIVO'
                     GROUP BY cod_proyect";
    }

    //echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $codpro = $fila['cod_proyect'];

            $rawdata[] = array(
                "Cate" => $codpro,
                "cant" => "1"
            );
        }
        echo json_encode($rawdata);
    } else {
        echo json_encode("no");
    }

    //   $myDat = json_encode($rawdata);
    //    echo $myDat;
} else if ($_POST['ope'] == "GrafContrat1") {

    $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT COUNT(*) cant,estado_proyect  FROM (
SELECT 
    COUNT(cod_proyect), cod_proyect,nombre_proyect,estado_proyect
 FROM  proyectos proy
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
  LEFT JOIN secretarias sec
    ON proy.secretaria_proyect=sec.idsecretarias
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'
  AND proy.estado='ACTIVO'  
GROUP BY id_proyect) AS t GROUP BY estado_proyect";

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
    echo json_encode($rawdata);
} else if ($_POST['ope'] == "GrafContrat5") {

    $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT COUNT(*) cant,estado_proyect  FROM (
SELECT 
    COUNT(cod_proyect), cod_proyect,nombre_proyect,estado_proyect
 FROM  proyectos proy
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
  LEFT JOIN secretarias sec
    ON proy.secretaria_proyect=sec.idsecretarias
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'
  AND proy.estado='ACTIVO'  
GROUP BY id_proyect) AS t GROUP BY estado_proyect";

    $consulta = "SELECT 
  sec.idsecretarias idsec,
  sec.des_secretarias nomsec
  FROM
    proyectos proy 
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
    LEFT JOIN secretarias sec 
      ON proy.secretaria_proyect = sec.idsecretarias 
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'
    AND proy.estado = 'ACTIVO' 
  GROUP BY idsec";


    $resultado = mysqli_query($link, $consulta);
    $rawSec = array(); //creamos secretarias
    $rawEst = array(); //creamos estados
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $consultaEst = "SELECT 
            COUNT(*) cant,
            estado_proyect esta
          FROM
            (SELECT 
              COUNT(cod_proyect),
              cod_proyect,
              nombre_proyect,
              estado_proyect 
            FROM
              proyectos proy 
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
              LEFT JOIN secretarias sec 
                ON proy.secretaria_proyect = sec.idsecretarias 
            WHERE proy.secretaria_proyect = '" . $fila['idsec'] . "'  AND proy.estado = 'ACTIVO' 
                  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'
            GROUP BY id_proyect) AS t 
          GROUP BY estado_proyect ";
            $resultadoEst = mysqli_query($link, $consultaEst);
            if (mysqli_num_rows($resultadoEst) > 0) {
                while ($filaEst = mysqli_fetch_array($resultadoEst)) {
                    $rawEst[] = array(
                        "Estados" => $filaEst['esta'],
                        "Cant" => $filaEst['cant']
                    );
                }
            }

            $rawSec[] = array(
                "Secretarias" => $fila['nomsec'],
                "Estados" => $rawEst
            );
            unset($rawEst);
        }
    }
    echo json_encode($rawSec);
} else if ($_POST['ope'] == "GrafContrat4") {

    $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT 
  COUNT(*) cant,
  estado 
FROM
  (SELECT 
    COUNT(contr.id_contrato),
    contr.num_contrato,
    contr.obj_contrato,
    REPLACE(contr.estad_contrato,'Ejecucion','Ejecución') estado
   
  FROM
  contratos contr LEFT JOIN 
    proyectos proy  ON contr.idproy_contrato=proy.id_proyect
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
    LEFT JOIN secretarias sec 
      ON proy.secretaria_proyect = sec.idsecretarias 
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
    AND IFNULL(contr.estad_contrato, '') LIKE '" . $_POST["CbEsta"] . "%' 
    AND contr.estcont_contra= 'Verificado' AND contr.id_contrato IN (SELECT
    MAX(id_contrato)
  FROM
    contratos   
  GROUP BY num_contrato)
  GROUP BY num_contrato) AS t 
GROUP BY estado ";

    //   echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Cate = $fila['estado'];
            $cant = $fila['cant'];

            $rawdata[] = array(
                "Cate" => $Cate,
                "cant" => $cant
            );
        }
    }
    echo json_encode($rawdata);
} else if ($_POST['ope'] == "InfGenContrxProy") {

    $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;
    $cad = "";
    $consulta = "SELECT 
proy.cod_proyect proy, COUNT(proy.cod_proyect) cant,proy.id_proyect idproy, proy.nombre_proyect nomproy
FROM
  contratos contr 
  LEFT JOIN proyectos proy 
    ON contr.idproy_contrato = proy.id_proyect 
 LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
 LEFT JOIN contratistas conttas 
 ON contr.idcontrati_contrato=conttas.id_contratis
WHERE contr.estcont_contra='Verificado'
AND IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["Secre"] . "%'
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos   
  GROUP BY num_contrato) GROUP BY proy.cod_proyect";

    //   echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Cate = $fila['proy'];
            $cant = $fila['cant'];

            $rawdata[] = array(
                "Cate" => $Cate,
                "cant" => $cant
            );
            $Cont = "";

            $cad .= "<div class='col-md-12 text-justify ' ><blockquote><strong><em><h5><b>" . $Cate . "</b><br>" . $fila['nomproy'] . "</h5></em> </strong></blockquote></div>";

            $consulta = "SELECT 
                    contr.num_contrato numcont, contr.obj_contrato obj, 
                    conttas.nom_contratis descontita,
                    contr.estad_contrato estado,contr.vfin_contrato total,
                    contr.porav_contrato porava
                   FROM
                     contratos contr 
                     LEFT JOIN proyectos proy 
                       ON contr.idproy_contrato = proy.id_proyect 
                    LEFT JOIN secretarias sec
                     ON proy.secretaria_proyect=sec.idsecretarias
                    LEFT JOIN contratistas conttas 
                    ON contr.idcontrati_contrato=conttas.id_contratis
                   WHERE contr.estcont_contra='Verificado'
                   AND contr.idproy_contrato = '" . $fila['idproy'] . "'
                   AND contr.id_contrato IN
                     (SELECT
                       MAX(id_contrato)
                     FROM
                       contratos
                      
                     GROUP BY num_contrato) ORDER BY total DESC";
            $resultado3 = mysqli_query($link, $consulta);

            $Cont .= "<table class='table table-bordered table-hover' style='border: 1; font-size: 9px; padding-top: 10px;'>" .
                "<thead>\n" .
                "      <tr>\n" .
                "          <td>\n" .
                "              <b> Número Contrato</b>\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <b> Objeto del Contrato</b>\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <b> Contratista</b>\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <b> Valor Contrato</b>\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <b> Estado</b>\n" .
                "          </td>\n" .
                "          <td>\n" .
                "              <b> % de Avance</b>\n" .
                "          </td>\n" .
                "      </tr>\n" .
                "  </thead>"
                . " <tbody >";

            if (mysqli_num_rows($resultado3) > 0) {
                while ($fila3 = mysqli_fetch_array($resultado3)) {

                    $Cont .= "<tr><td>" . $fila3["numcont"] . "</td>";
                    $Cont .= "<td>" . $fila3["obj"] . "</td>";
                    $Cont .= "<td>" . $fila3["descontita"] . "</td>";
                    $Cont .= "<td>" . number_format($fila3["total"], 2, ",", ".") . "</td>";

                    if ($fila3["estado"] == "Ejecucion") {
                        $Cont .= "<td style='vertical-align: middle;color:#2ED26E;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                    } else if ($fila3["estado"] == "Terminado") {
                        $Cont .= "<td style='vertical-align: middle;color:#387EFC;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                    } else if ($fila3["estado"] == "Suspendido") {
                        $Cont .= "<td style='vertical-align: middle;color:#EA4359;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                    } else if ($fila3["estado"] == "Liquidado") {
                        $Cont .= "<td style='vertical-align: middle;color:#FDC20D;'>" . str_replace('Ejecucion', 'Ejecución', $fila3["estado"]) . "</td>";
                    }

                    $Cont .= "<td>" . $fila3["porava"] . "</td></tr>";
                }
            }
            $Cont .= " </tbody></table>";
            $cad .= $Cont;
        }
    }

    $myDat->GrafCont = $rawdata;
    $myDat->CadCont = $cad;

    echo json_encode($myDat);
    //   $myDat = json_encode($rawdata);
    //    echo $myDat;
} else if ($_POST['ope'] == "GrafInfGenPoblacional") {

    $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT COUNT(*) cant,des_secretarias secre,secretaria_proyect idsec  FROM (
SELECT 
    COUNT(sec.des_secretarias),
   proy.secretaria_proyect,
   sec.des_secretarias    
FROM
  proyectos proy
  LEFT JOIN banco_proyec_pobla pobl
  ON proy.id_proyect=pobl.id_proyect
  LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE IFNULL(pobl.edad, '') LIKE '" . $_POST["Edad"] . "%'
AND IFNULL(pobl.grupoetnico, '') LIKE '" . $_POST["Grupo"] . "%'
AND IFNULL(pobl.genero, '') LIKE '" . $_POST["Genero"] . "%'
AND proy.estado='ACTIVO' AND proy.estado_proyect='En Ejecucion'  
GROUP BY pobl.id_proyect) t GROUP BY des_secretarias";


    $resultado = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Cate = $fila['secre'];
            $cant = $fila['cant'];

            $rawdata[] = array(
                "Cate" => $Cate,
                "cant" => $cant
            );
        }
    }
    echo json_encode($rawdata);
    //   $myDat = json_encode($rawdata);
    //    echo $myDat;
} else if ($_POST['ope'] == "GrafContrat2") {

    // $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT COUNT(*) cant,des_secretarias secre,secretaria_proyect idsec  FROM (
SELECT 
    COUNT(proy.cod_proyect),
   proy.secretaria_proyect,
   sec.des_secretarias 
FROM
  proyectos proy
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
  LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'
  AND proy.estado='ACTIVO'  
GROUP BY proy.id_proyect) AS t GROUP BY secretaria_proyect";


    $resultado1 = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $Cate = $fila['secre'];
            $ides = $fila['idsec'];
            $cant = $fila['cant'];

            $consulta = "SELECT cod_proyect FROM  proyectos proy
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
              LEFT JOIN secretarias sec
                ON proy.secretaria_proyect=sec.idsecretarias
                WHERE secretaria_proyect='" . $ides . "'"
                . "AND IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'"
                . " AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
                    AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
                    AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
                    AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'  AND proy.estado='ACTIVO'  ";
            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $proy = $fila['cod_proyect'];

                    $rawproy[] = array(
                        "Cate" => $proy,
                        "cant" => "1"
                    );
                }
            }


            $rawdata[] = array(
                "Cate" => $Cate,
                "cant" => $cant,
                "proy" => $rawproy
            );
            unset($rawproy);
        }
    }
    echo json_encode($rawdata);
    //   $myDat = json_encode($rawdata);
} else if ($_POST['ope'] == "GrafContrat3") {

    // $myDat = new stdClass();

    $Tab_Indicad = "";
    $i = 0;

    $consulta = "SELECT COUNT(*) cant,NOMBRE nomej,ID ideje FROM (
SELECT 
  COUNT(proy.cod_proyect),
  proy.cod_proyect,
  proy.nombre_proyect,
  eje.NOMBRE,
  eje.ID 
FROM
  proyectos proy
  RIGHT JOIN proyect_metas proymet
    ON proy.id_proyect = proymet.cod_proy
  LEFT JOIN metas met
    ON proymet.id_meta = met.id_meta
  LEFT JOIN ejes eje
    ON met.ideje_metas = eje.ID
  LEFT JOIN componente comp
    ON met.idcomp_metas = comp.ID
  LEFT JOIN programas prog
    ON met.idprog_metas = prog.ID
  LEFT JOIN secretarias sec
  ON proy.secretaria_proyect=sec.idsecretarias
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'  AND proy.estado='ACTIVO'  
 GROUP BY proy.id_proyect) AS t GROUP BY NOMBRE";

    $resultado1 = mysqli_query($link, $consulta);
    $rawdata = array(); //creamos un array
    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {

            $Cate = $fila['nomej'];
            $ides = $fila['ideje'];
            $cant = $fila['cant'];

            $consulta = "SELECT
                        cod_proyect
                      FROM
                        proyectos proy
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
                         LEFT JOIN secretarias sec
                     ON proy.secretaria_proyect=sec.idsecretarias
                      WHERE
                         eje.ID ='" . $ides . "' "
                . " AND IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecr"] . "%'"
                . " AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
                    AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
                    AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
                    AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEsta"] . "%'  AND proy.estado='ACTIVO'  ";

            $resultado = mysqli_query($link, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $proy = $fila['cod_proyect'];
                    $rawproy[] = array(
                        "Cate" => $proy,
                        "cant" => "1"
                    );
                }
            }

            $rawdata[] = array(
                "Cate" => $Cate,
                "cant" => $cant,
                "proy" => $rawproy
            );
            unset($rawproy);
        }
    }
    echo json_encode($rawdata);
    //   $myDat = json_encode($rawdata);
} else if ($_POST['ope'] == "BusqEditEstrateg") {

    $myDat = new stdClass();

    $consulta = "SELECT  estr.CODIGO cod, estr.NOMBRE nom, estr.`OBSERVACIONES` obsestrat,"
        . " ej.`ID` idej, ej.CODIGO codej,ej.`NOMBRE` nomej, estr.IMG img FROM componente estr LEFT JOIN ejes ej "
        . "ON estr.ID_EJE=ej.ID where estr.ID='" . $_POST["cod"] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod = $fila["cod"];
            $myDat->nom = $fila["nom"];
            $myDat->obsestrat = $fila["obsestrat"];
            $myDat->idej = $fila["idej"];
            $myDat->codej = $fila["codej"];
            $myDat->nomej = $fila["nomej"];
            $myDat->IMG = $fila["img"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusEvalCont") {

    $myDat = new stdClass();
    $Eval = "NO";
    $consulta = "SELECT id_evaluacion FROM eval_contratista WHERE ncont_evaluacion = '" . $_POST['idcon'] . "' AND nitcont_evaluacion='" . $_POST['idcont'] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $Eval = $fila["id_evaluacion"];
        }
    }
    $myDat->Eval = $Eval;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BuscInfResp") {

    $myDat = new stdClass();

    $consulta = "SELECT email_responsable email FROM responsables WHERE id_responsable='" . $_POST['id'] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->email = $fila["email"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditPrograma") {

    $myDat = new stdClass();

    $consulta = "SELECT
  prog.CODIGO codprog,
  prog.NOMBRE nomprog,
  prog.OBSERVACIONES obsprog,
  ej.ID idej,
  ej.NOMBRE nomej,
  estr.ID idestr,
  estr.CODIGO codestr,
  estr.NOMBRE nomestr,
  prog.IMG img
FROM
  programas prog
  LEFT JOIN ejes ej
    ON prog.ID_EJE = ej.ID
  LEFT JOIN componente estr
    ON prog.ID_COMP = estr.ID where prog.ID='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $myDat->codprog = $fila["codprog"];
            $myDat->nomprog = $fila["nomprog"];
            $myDat->obsprog = $fila["obsprog"];
            $myDat->idej = $fila["idej"];
            $myDat->nomej = $fila["nomej"];
            $myDat->idestr = $fila["idestr"];
            $myDat->codestr = $fila["codestr"];
            $myDat->nomestr = $fila["nomestr"];
            $myDat->IMG = $fila["img"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditObjetivos") {

    $myDat = new stdClass();

    $consulta = "SELECT
  ob.CODIGO codobj,
  ob.NOMBRE nomobj,
  ob.OBSERVACIONES obsobj,
  ej.ID idej,
  ej.NOMBRE nomej,
  est.ID idestr,
  est.NOMBRE nomestr,
  pro.ID idprog,
  pro.NOMBRE nomprog
 FROM
 objetivos ob
 INNER JOIN programas pro
 ON ob.ID_PRO=pro.ID
 INNER JOIN estrategias est
 ON ob.ID_EST=est.ID
 INNER JOIN ejes ej
 ON ob.ID_EJE=ej.ID where ob.ID='" . $_POST["cod"] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->codobj = $fila["codobj"];
            $myDat->nomobj = $fila["nomobj"];
            $myDat->obsobj = $fila["obsobj"];
            $myDat->idej = $fila["idej"];
            $myDat->nomej = $fila["nomej"];
            $myDat->idestr = $fila["idestr"];
            $myDat->nomestr = $fila["nomestr"];
            $myDat->idprog = $fila["idprog"];
            $myDat->nomprog = $fila["nomprog"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditEjes") {

    $myDat = new stdClass();

    $consulta = "select * from ejes where ID='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->CODIGO = $fila["CODIGO"];
            $myDat->NOMBRE = $fila["NOMBRE"];
            $myDat->OBSERVACION = $fila["OBSERVACIONES"];
            $myDat->IMG = $fila["IMG"];
            $myDat->DIMENSION = $fila["DIMENSION"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditDime") {

    $myDat = new stdClass();

    $consulta = "select * from dimensiones where id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->codigo = $fila["codigo"];
            $myDat->descripcion = $fila["descripcion"];
            $myDat->observacion = $fila["observacion"];
            $myDat->img = $fila["img"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "cargDatResp") {

    $myDat = new stdClass();

    $consulta = "SELECT
  dep.des_dependencia dep,
  resp.email_responsable email,
  resp.tel_responsable tel
FROM
  responsables resp
  LEFT JOIN dependencias dep
    ON resp.dependencia = dep.iddependencias where resp.id_responsable='" . $_POST["id"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->dep = $fila["dep"];
            $myDat->email = $fila["email"];
            $myDat->tel = $fila["tel"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusEstProy") {

    $myDat = new stdClass();

    $consulta = "SELECT estado_proyect,porceEjec_proyect from proyectos where id_proyect='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->estado = $fila["estado_proyect"];
            $myDat->porce = $fila["porceEjec_proyect"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSecre") {

    $myDat = new stdClass();
    $Secre = "<option value=' '>Seleccione...</option>";
    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from secretarias where estado_secretaria='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Secre .= "<option value='" . $fila["idsecretarias"] . "'>" . $fila["cod_secretarias"] . " - " . $fila["des_secretarias"] . "</option>";
        }
    }

    $myDat->Secre = $Secre;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargSecre2") {

    $myDat = new stdClass();
    $Secre = "<option value=' '>Todas...</option>";
    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from secretarias where estado_secretaria='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Secre .= "<option value='" . $fila["idsecretarias"] . "'>" . $fila["cod_secretarias"] . " - " . $fila["des_secretarias"] . "</option>";
        }
    }

    $myDat->Secre = $Secre;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargContInf") {

    $myDat = new stdClass();
    if ($_POST['inf'] == "7") {
        $Contr = "<option value=' '>Todos</option>";
        $consulta = "SELECT id_contrato,num_contrato,LEFT(obj_contrato,200) obj FROM contratos WHERE estad_contrato='Terminado' or estad_contrato='Liquidado'  GROUP BY num_contrato";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $Contr .= "<option value='" . $fila["id_contrato"] . '/' . $fila["num_contrato"] . "'>" . $fila["num_contrato"] . " - " . $fila["obj"] . "</option>";
            }
        }
    } else {
        $Contr = "<option value=' '>Seleccione...</option>";
        $consulta = "SELECT 
id_contrato,num_contrato,LEFT(obj_contrato,200) obj
FROM
  contratos contr 
WHERE contr.estcont_contra='Verificado' 
AND contr.id_contrato IN
  (SELECT
    MAX(id_contrato)
  FROM
    contratos
  GROUP BY num_contrato) GROUP BY num_contrato ORDER BY obj DESC";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $Contr .= "<option value='" . $fila["id_contrato"] . '/' . $fila["num_contrato"] . "'>" . $fila["num_contrato"] . " - " . $fila["obj"] . "</option>";
            }
        }
    }




    $myDat->Contr = $Contr;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargProy") {

    $myDat = new stdClass();
    $Proyec = "<option value=' '>Todos...</option>";
    /////////////////////CONSULTAR PROYECTOS
    $consulta = "select * from proyectos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Proyec .= "<option value='" . $fila["id_proyect"] . "'>" . $fila["cod_proyect"] . " - " . $fila["nombre_proyect"] . "</option>";
        }
    }

    $myDat->Proyec = $Proyec;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargEjes") {

    $myDat = new stdClass();
    $ejes = "<option value=' '>Sel...</option>";
    /////////////////////CONSULTAR PROYECTOS
    $consulta = "select * from ejes where ESTADO='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ejes .= "<option value='" . $fila["ID"] . "'>" . $fila["NOMBRE"] . "</option>";
        }
    }

    $myDat->ejes = $ejes;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargProytInf") {

    $myDat = new stdClass();
    $Proyec = "<option value=' '>Seleccionar Proyecto...</option>";
    /////////////////////CONSULTAR PROYECTOS
    $consulta = "select * from proyectos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Proyec .= "<option value='" . $fila["id_proyect"] . "'>" . $fila["cod_proyect"] . " - " . $fila["nombre_proyect"] . "</option>";
        }
    }

    $myDat->Proyec = $Proyec;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargMapsCal") {

    $myDat = new stdClass();
    $Proyec = "<option value=' '>Todos...</option>";
    /////////////////////CONSULTAR PROYECTOS
    $consulta = "select * from proyectos where estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Proyec .= "<option value='" . $fila["id_proyect"] . "'>" . $fila["cod_proyect"] . " - " . $fila["nombre_proyect"] . "</option>";
        }
    }

    $Depa = "<option value=' '>Seleccione...</option>";

    //////////////////////CONSULTAR DEPARTAMENTOS
    $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".dpto";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Depa .= "<option value='" . $fila["COD_DPTO"] . "'>" . $fila["COD_DPTO"] . " - " . $fila["NOM_DPTO"] . "</option>";
        }
    }
    $myDat->Depa = $Depa;

    $myDat->Proyec = $Proyec;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargContra") {

    $myDat = new stdClass();
    $Contrat = "<option value=' '>Seleccione...</option>";
    //////////////////////CONSULTAR RESPONSABLES
    $consulta = "select * from contratistas WHERE estado_contratis='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $Contrat .= "<option value='" . $fila["id_contratis"] . "'>" . $fila["ident_contratis"] . " - " . $fila["nom_contratis"] . "</option>";
        }
    }


    $myDat->Contrat = $Contrat;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "CargRespo") {

    $myDat = new stdClass();
    $resp = "<option value=' '>Seleccione...</option>";
    $consulta = "select * from responsables where estado='ACTIVO'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $resp .= "<option value='" . $fila["id_responsable"] . "'>" . $fila["cod_responsable"] . " - " . $fila["nom_responsable"] . "</option>";
        }
    }
    $myDat->resp = $resp;
    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "BusqEditOrInform") {

    $myDat = new stdClass();

    $consulta = "select * from origen_informacion where id_info='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_info = $fila["cod_info"];
            $myDat->nomb_info = $fila["nomb_info"];
            $myDat->obser_info = $fila["obser_info"];
        }
    }

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaPerfil") {
    $myDat = new stdClass();
    $perf = "";
    $consulta = "SELECT nomperfil nom FROM " . $_SESSION['ses_BDBase'] . ".perfiles";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perf .= "<option value='" . $fila["nom"] . "'>" . $fila["nom"] . "</option>";
        }
    }
    $myDat->perf = $perf;

    $usu = "";
    $consulta = "SELECT cue_alias usu FROM " . $_SESSION['ses_BDBase'] . ".usuarios";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $usu .= "<option value='" . $fila["usu"] . "'>" . $fila["usu"] . "</option>";
        }
    }
    $myDat->usu = $usu;


    echo $myJSONDat = json_encode($myDat);
} else if ($_POST["ope"] == "verfUsu") {

    $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".usuarios where cue_inden='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfOriInf") {

    $consulta = "SELECT * FROM origen_informacion where cod_info='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfMeta") {

    $consulta = "SELECT * FROM metas where cod_meta='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verAdquisi") {

    $consulta = "SELECT * FROM adquisiciones where cod_adqu='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfNomUsu") {

    $consulta = "SELECT * FROM usuarios where cue_alias='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfObje") {

    $consulta = "SELECT * FROM objetivos where CODIGO='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST['ope'] == "BusqEditUsu") {
    $outp = "";
    $consulta = "SELECT * FROM " . $_SESSION['ses_BDBase'] . ".usuarios where cue_alias='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"cue_inden":"' . $fila["cue_inden"] . '",';
            $outp .= '"cue_nombres":"' . $fila["cue_nombres"] . '",';
            $outp .= '"cue_sexo":"' . $fila["cue_sexo"] . '",';
            $outp .= '"niv_codigo":"' . $fila["niv_codigo"] . '",';
            $outp .= '"cue_alias":"' . $fila["cue_alias"] . '",';
            $outp .= '"cue_estado":"' . $fila["cue_estado"] . '",';
            $outp .= '"cue_correo":"' . $fila["cue_correo"] . '",';
            $outp .= '"cue_tele":"' . $fila["cue_tele"] . '",';
            $outp .= '"cue_dir":"' . $fila["cue_dir"] . '"}';
        }

        echo ($outp);
    }
} else if ($_POST["ope"] == "ConConsecutivo2") {

    $myDat = new stdClass();
    $StrAct = "";
    $est = "";
    $act = 0;
    $dig = "";
    $cons = 0;
    $vig = "";

    $consulta = "SELECT * FROM consecutivos WHERE grupo='" . $_POST["tco"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $est = $fila["estruct"];
            $act = $fila["actual"];
            $cons = $fila["actual"];
            $vig = $fila["vigencia"];
            $dig = $fila["digitos"];
        }
    }

    if ($act > $cons) {
        $cons = $act;
    }
    $cons += 1;

    if ($vig == "SI") {
        $StrAct = $est . "-" . date('Y') . "-" . sprintf("%0" . $dig . "d", $cons);
    } else {
        $StrAct = $est . "-" . sprintf("%0" . $dig . "d", $cons);
    }
    $myDat->StrAct = $StrAct;
    $myDat->cons = $cons;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST['ope'] == "ConMap") {

    //    $myDat = new stdClass();
    $outp = "";

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
WHERE IFNULL(proy.secretaria_proyect, '') LIKE '" . $_POST["CbSecre"] . "%'
  AND IFNULL(eje.ID, '') LIKE '" . $_POST["CbEje"] . "%'
  AND IFNULL(comp.ID, '') LIKE '" . $_POST["CbComp"] . "%'
  AND IFNULL(prog.ID, '') LIKE '" . $_POST["CbProg"] . "%'
  AND IFNULL(proy.estado_proyect, '') LIKE '" . $_POST["CbEstado"] . "%'
  AND IFNULL(proy.id_proyect,'') LIKE '" . $_POST["CbProy"] . "%'";
    //echo $consulta;
    $x = 0;
    $outp .= '{';
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            //  $myDat->lat . "_" . $x = $fila["lat"];
            $outp .= '"lat_' . $x . '":"' . $fila["lat"] . '",';
            $outp .= '"long_' . $x . '":"' . $fila["logi"] . '",';
            $outp .= '"codproy_' . $x . '":"' . $fila["codproy"] . '",';
            $outp .= '"nproy_' . $x . '":"' . $fila["nproy"] . '",';
            $outp .= '"tip_' . $x . '":"' . $fila["tip"] . '",';
            $outp .= '"sec_' . $x . '":"' . $fila["sec"] . '",';
            $outp .= '"neje_' . $x . '":"' . $fila["neje"] . '",';
            $outp .= '"ncomp_' . $x . '":"' . $fila["ncomp"] . '",';
            $outp .= '"nprog_' . $x . '":"' . $fila["nprog"] . '",';
            $outp .= '"estad_' . $x . '":"' . $fila["estad"] . '",';
            $x++;
        }
    }

    $outp .= '"Tam":"' . $x . '"}';
    echo $outp;
}

mysqli_close($link);
