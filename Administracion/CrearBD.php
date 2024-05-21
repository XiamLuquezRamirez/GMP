<?php

session_start();
include("../Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysql_query("BEGIN");



$nombre_bd = "smp_" . $_POST['comp'];
$nombre_bd = str_replace(" ", "", $nombre_bd);

$consulta = "DROP database IF EXISTS " . $nombre_bd;
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$consulta = "CREATE database " . $nombre_bd;
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 2;
}
$consulta = "USE " . $nombre_bd;
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 2;
}

$consulta = "CREATE TABLE `banco_proyec_actividades` (
  `id_cont_activida` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyecto` varchar(10) DEFAULT NULL COMMENT 'codigo del proyecto',
  `metas` text COMMENT 'Metas proyecto',
  `actividades` text COMMENT 'actividades',
  `respo_activ` varchar(10) DEFAULT NULL COMMENT 'responsable de la actividad',
  `costo_activ` double DEFAULT NULL COMMENT 'costo actividad',
  `fini_activ` varchar(20) DEFAULT NULL COMMENT 'fecha inicial de la actividad',
  `hini_activ` varchar(20) DEFAULT NULL COMMENT 'hora inicial actividad',
  `ffin_activ` varchar(20) DEFAULT NULL COMMENT 'fecha final actividad',
  `hfin_activ` varchar(20) DEFAULT NULL COMMENT 'hora final actividad',
  `estado_activ` varchar(30) DEFAULT NULL COMMENT 'estado de la actividad',
  PRIMARY KEY (`id_cont_activida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 3;
}

$consulta = "CREATE TABLE `banco_proyec_anexos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desc` text,
  `nombre_arch` text,
  `src_arch` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 4;
}

$consulta = "CREATE TABLE `banco_proyec_causas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desc` text COMMENT 'descripcion de la causa',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 5;
}

$consulta = "CREATE TABLE `banco_proyec_costos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `identifi` varchar(100) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `cargo` varchar(10) DEFAULT NULL,
  `horaxsemana` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 6;
}

$consulta = "CREATE TABLE `banco_proyec_efectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desc` text COMMENT 'descripcion del efecto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 7;
}

$consulta = "CREATE TABLE `banco_proyec_estudios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `titulo` varchar(200) DEFAULT NULL,
  `autor` varchar(200) DEFAULT NULL,
  `entidad` varchar(200) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `observa` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 8;
}

$consulta = "CREATE TABLE `banco_proyec_financiacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `origen` text,
  `valor` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 9;
}

$consulta = "CREATE TABLE `banco_proyec_ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desc` varchar(200) DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `valor` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 10;
}

$consulta = "CREATE TABLE `banco_proyec_objespec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desc` text COMMENT 'descripcion del efecto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 11;
}

$consulta = "CREATE TABLE `banco_proyec_pobla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `poblacion` varchar(100) DEFAULT NULL COMMENT 'poblacion objetivo',
  `anio` varchar(4) DEFAULT NULL,
  `fase` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 12;
}

$consulta = "CREATE TABLE `banco_proyec_presupuesto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desc` varchar(200) DEFAULT NULL,
  `cantidad` varchar(10) DEFAULT NULL,
  `unid_med` varchar(50) DEFAULT NULL COMMENT 'unidad de medida',
  `val_vi` double DEFAULT NULL COMMENT 'vigencia actual',
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 13;
}

$consulta = "CREATE TABLE `banco_proyec_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyect` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `producto` varchar(100) DEFAULT NULL,
  `indicador` varchar(100) DEFAULT NULL,
  `anio` varchar(4) DEFAULT NULL,
  `meta` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 14;
}

$consulta = "CREATE TABLE `barrios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `comuna` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=latin1;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 15;
}

$consulta = "CREATE TABLE `componente` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_EJE` varchar(45) DEFAULT NULL COMMENT 'id_eje',
  `CODIGO` varchar(45) DEFAULT NULL,
  `NOMBRE` text,
  `OBSERVACIONES` text,
  `ESTADO` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 16;
}

$consulta = "CREATE TABLE `consecutivos` (
  `id_conse` int(11) NOT NULL AUTO_INCREMENT,
  `estruct` varchar(20) DEFAULT NULL,
  `descrip` varchar(100) DEFAULT NULL,
  `grupo` varchar(20) DEFAULT NULL,
  `inicio` varchar(10) DEFAULT NULL,
  `actual` varchar(10) DEFAULT NULL,
  `vigencia` char(2) DEFAULT NULL,
  `observ` text,
  `estr_fin` varchar(20) DEFAULT NULL,
  `digitos` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_conse`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 17;
}

$consulta = "CREATE TABLE `contratistas` (
  `id_contratis` int(11) NOT NULL AUTO_INCREMENT,
  `tper_contratis` varchar(10) DEFAULT NULL COMMENT 'Tipo de persona',
  `tid_contratis` varchar(10) DEFAULT NULL COMMENT 'tipo de indentificacion del contratista',
  `ident_contratis` varchar(25) DEFAULT NULL COMMENT 'identificacion contratista',
  `dv_contratis` char(3) DEFAULT NULL,
  `nom_contratis` varchar(200) DEFAULT NULL COMMENT 'nombre del contratista',
  `telcon_contratis` varchar(20) DEFAULT NULL COMMENT 'telefono del contratista',
  `dircon_contratis` varchar(200) DEFAULT NULL COMMENT 'direccion del contratista',
  `corcont_contratis` varchar(50) DEFAULT NULL COMMENT 'correo del contratista',
  `idrpr_contratis` varchar(20) DEFAULT NULL COMMENT 'Identificacion Representante legal',
  `nomrpr_contratis` varchar(200) DEFAULT NULL COMMENT 'Nombre Representante legal',
  `telrpr_contratis` varchar(20) DEFAULT NULL COMMENT 'Telefono Representante legal',
  `depart_contratis` varchar(10) DEFAULT NULL COMMENT 'departamento del contratista',
  `mun_contratis` varchar(10) DEFAULT NULL COMMENT 'municipio del contratista',
  `estado_contratis` varchar(15) DEFAULT NULL,
  `observ_contratist` text,
  PRIMARY KEY (`id_contratis`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 18;
}

$consulta = "CREATE TABLE `contrato_galeria` (
  `id_galeria` int(11) NOT NULL AUTO_INCREMENT,
  `contr_galeria` varchar(10) DEFAULT NULL,
  `tip_galeria` varchar(20) DEFAULT NULL,
  `img_galeria` text,
  `num_contrato_galeria` varchar(50) DEFAULT NULL,
  `formato_galeria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_galeria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 19;
}

$consulta = "CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL AUTO_INCREMENT,
  `idtipolg_contrato` varchar(5) DEFAULT NULL COMMENT 'id tipologia del contrato',
  `destipolg_contrato` text COMMENT 'descripcion tipologia del contrato',
  `fmod_contrato` date DEFAULT NULL COMMENT 'ultima fecha de modificacion',
  `num_contrato` varchar(50) DEFAULT NULL COMMENT 'numero del contrato',
  `obj_contrato` text COMMENT 'objeto del contrato',
  `idcontrati_contrato` varchar(10) DEFAULT NULL COMMENT 'id contratista',
  `descontrati_contrato` varchar(200) DEFAULT NULL COMMENT 'nombre contratista',
  `idsuperv_contrato` varchar(10) DEFAULT NULL COMMENT 'idsupervisor responsable',
  `dessuperv_contrato` text COMMENT 'descripcion supervisor',
  `idinterv_contrato` varchar(10) DEFAULT NULL COMMENT 'idinterventor responsable',
  `desinterv_contrato` text COMMENT 'descripcion interventor',
  `vcontr_contrato` double DEFAULT NULL COMMENT 'valor del contrato',
  `vadic_contrato` double DEFAULT NULL COMMENT 'valor de adicion',
  `vfin_contrato` double DEFAULT NULL COMMENT 'valor final contrato',
  `veje_contrato` double DEFAULT NULL COMMENT 'valor ejecutado del contrato',
  `forpag_contrato` varchar(200) DEFAULT NULL COMMENT 'forma de pago contrato',
  `durac_contrato` varchar(200) DEFAULT NULL COMMENT 'duracion del contrato',
  `fini_contrato` date DEFAULT NULL COMMENT 'fecha de inicio',
  `fsusp_contrato` date DEFAULT NULL COMMENT 'fecha de suspencion',
  `frein_contrato` date DEFAULT NULL COMMENT 'fecha de reinicio',
  `prorg_contrato` varchar(100) DEFAULT NULL COMMENT 'prorroga del contrato',
  `ffin_contrato` date DEFAULT NULL COMMENT 'fecha de finalizacion del contrato',
  `frecb_contrato` date DEFAULT NULL COMMENT 'fecha recibido contrato',
  `idproy_contrato` varchar(10) DEFAULT NULL COMMENT 'id del proyecto asociado',
  `desproy_contrato` text COMMENT 'descripcion del proyecto asociado',
  `porav_contrato` varchar(4) DEFAULT NULL COMMENT 'porcentaje de avance del proyecto',
  `estad_contrato` varchar(20) DEFAULT NULL COMMENT 'Estado actual del proyecto',
  `estcont_contra` varchar(20) DEFAULT NULL COMMENT 'estado del contrato',
  `porproy_contrato` varchar(4) DEFAULT NULL COMMENT 'porcentaje en proyecto',
  PRIMARY KEY (`id_contrato`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 20;
}

$consulta = "CREATE TABLE `corregi` (
  `ID_CORREGI` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MUNI` varchar(25) NOT NULL,
  `COD_CORREGI` varchar(25) NOT NULL,
  `NOM_CORREGI` text NOT NULL,
  `OBSER_CORREGI` text NOT NULL,
  PRIMARY KEY (`ID_CORREGI`)
) ENGINE=InnoDB AUTO_INCREMENT=9206 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 21;
}

$consulta = "CREATE TABLE `dependencias` (
  `iddependencias` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dependencia` varchar(135) DEFAULT NULL,
  `des_dependencia` longtext,
  `correo_dependencia` varchar(100) DEFAULT NULL,
  `obs_dependencia` longtext,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iddependencias`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 22;
}

$consulta = "CREATE TABLE `ejes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(45) DEFAULT NULL,
  `NOMBRE` text,
  `OBSERVACIONES` text,
  `ESTADO` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 23;
}

$consulta = "CREATE TABLE `interventores` (
  `id_interventores` int(11) NOT NULL AUTO_INCREMENT,
  `cod_interventores` varchar(50) DEFAULT NULL,
  `nom_interventores` text,
  `correo_interventores` varchar(150) DEFAULT NULL,
  `telef_interventores` varchar(50) DEFAULT NULL,
  `obser_interventores` text,
  `estado_interventores` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_interventores`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 24;
}

$consulta = "CREATE TABLE `logs` (
  `log_codigo` int(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` varchar(100) DEFAULT NULL,
  `log_direccion` varchar(15) NOT NULL,
  `log_fecha` date NOT NULL,
  `log_hora` time NOT NULL,
  `log_accion` text NOT NULL,
  `log_tipo` varchar(100) NOT NULL,
  `log_interfaz` varchar(100) NOT NULL,
  PRIMARY KEY (`log_codigo`),
  KEY `FK_logsAccion` (`log_tipo`),
  KEY `FK_logsUsuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1900 DEFAULT CHARSET=latin1;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 25;
}

$consulta = "CREATE TABLE `medir_indmeta` (
  `id_indmeta` int(11) NOT NULL AUTO_INCREMENT,
  `idmeta_indmeta` varchar(10) DEFAULT NULL COMMENT 'id meta',
  `desmeta_indmeta` text COMMENT 'descripcion de la meta',
  `idproy_indmeta` varchar(10) DEFAULT NULL COMMENT 'id del proyecto',
  `desproy_indmeta` text COMMENT 'descripcion del proyecto',
  `fmed_indmeta` date DEFAULT NULL COMMENT 'fecha de medicion',
  `base_indmeta` varchar(20) DEFAULT NULL COMMENT 'base de la meta',
  `tend_indmeta` varchar(10) DEFAULT NULL COMMENT 'tendencia de la medicion(aumentar, disminuir, mantener)',
  `med_indmeta` varchar(20) DEFAULT NULL COMMENT 'medicion del indicador meta',
  `resul_indmeta` varchar(20) DEFAULT NULL COMMENT 'resultado de la medicion',
  `origen_indmeta` varchar(50) DEFAULT NULL COMMENT 'contrato origen',
  `desc_origen` text COMMENT 'descripcion del origen indicador',
  PRIMARY KEY (`id_indmeta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 26;
}

$consulta = "CREATE TABLE `metas` (
  `id_meta` int(11) NOT NULL AUTO_INCREMENT,
  `cod_meta` varchar(10) DEFAULT NULL,
  `desc_meta` text,
  `base_meta` varchar(20) DEFAULT NULL COMMENT 'Linea base de la meta',
  `baseactual_metas` varchar(20) DEFAULT NULL COMMENT 'base actual de la meta',
  `tipdato_metas` varchar(20) DEFAULT NULL COMMENT 'Tipo de dato(Pesos,Porcentaje,Unidad)',
  `prop_metas` varchar(20) DEFAULT NULL COMMENT 'Proposito de la meta(Aumentar, Mantener, Disminuir)',
  `ideje_metas` varchar(10) DEFAULT NULL COMMENT 'Id Eje estrategico',
  `des_eje_metas` text COMMENT 'Des Eje estrategico',
  `idcomp_metas` varchar(10) DEFAULT NULL COMMENT 'Id Componente',
  `des_comp_metas` text COMMENT 'Des Componente',
  `idprog_metas` varchar(10) DEFAULT NULL COMMENT 'Id Programa',
  `des_prog_metas` text COMMENT 'Des Programa',
  `respo_metas` varchar(10) DEFAULT NULL COMMENT 'id Dependecia Responsable de la meta',
  `estado_metas` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_meta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 27;
}

$consulta = "CREATE TABLE `programas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_EJE` varchar(45) DEFAULT NULL COMMENT 'id_estrategia',
  `ID_COMP` varchar(45) DEFAULT NULL COMMENT 'id_componente',
  `CODIGO` varchar(45) DEFAULT NULL,
  `NOMBRE` text,
  `OBSERVACIONES` text,
  `ESTADO` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 28;
}

$consulta = "CREATE TABLE `proyect_metas` (
  `id_metprot` int(11) NOT NULL AUTO_INCREMENT,
  `cod_proy` varchar(10) DEFAULT NULL COMMENT 'codigo del proyecto',
  `nom_proy` text COMMENT 'nombre del proyecto',
  `id_meta` varchar(10) DEFAULT NULL,
  `cod_met` varchar(10) DEFAULT NULL COMMENT 'codigo de la meta',
  `desc_met` text COMMENT 'descripcion de la meta',
  PRIMARY KEY (`id_metprot`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 28;
}

$consulta = "CREATE TABLE `proyecto_galeria` (
  `id_galeria` int(11) NOT NULL DEFAULT '0',
  `proyect_galeria` varchar(10) DEFAULT NULL,
  `tip_galeria` varchar(20) DEFAULT NULL,
  `img_galeria` text,
  `num_proyect_galeria` varchar(50) DEFAULT NULL,
  `formato_galeria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 29;
}

$consulta = "CREATE TABLE `proyectos` (
  `id_proyect` int(11) NOT NULL AUTO_INCREMENT,
  `cod_proyect` tinytext,
  `fec_crea_proyect` date DEFAULT NULL COMMENT 'fecha de creacion del proyecto',
  `fulmod_proyect` date DEFAULT NULL COMMENT 'fecha ultima modificacion',
  `nombre_proyect` text COMMENT 'nombre del proyecto',
  `tipol_proyect` varchar(10) DEFAULT NULL COMMENT 'id tipologia del proyecto',
  `dtipol_proyec` text COMMENT 'descripcion tipologia del proyecto',
  `secretaria_proyect` varchar(10) DEFAULT NULL COMMENT 'id secretari',
  `dsecretar_proyect` text COMMENT 'descripcion secretaria',
  `cron_proyect` varchar(20) DEFAULT NULL COMMENT 'cronologia del proyecto',
  `vigenc_proyect` varchar(4) DEFAULT NULL COMMENT 'vigencia del proyecto',
  `codproyasoc_proyect` varchar(100) DEFAULT NULL COMMENT 'codigo del proyecto asociado',
  `desproyasoc_proyect` text COMMENT 'proyecto asociado',
  `frso_proyeasoc` varchar(20) DEFAULT NULL COMMENT 'Fecha de resolucion del proyecto asociado',
  `fecha_iniproyaso` varchar(20) DEFAULT NULL COMMENT 'Fecja de inicio proyecto asociado',
  `plazo_ejeproyeaso` varchar(20) DEFAULT NULL COMMENT 'plazo ejecucuon proyecto asociado',
  `vigenc_proyeaso` varchar(100) DEFAULT NULL COMMENT 'vigencia proyecto asociado',
  `estado_proyeaso` varchar(100) DEFAULT NULL COMMENT 'estado proyecto asociado',
  `elab_proyect` varchar(200) DEFAULT NULL COMMENT 'Elaborado por',
  `idenproble_proyect` text COMMENT 'identificacion del problema',
  `objgen_proyect` text COMMENT 'objetivo genenal del proyecto',
  `desc_proyect` text COMMENT 'descripcion del proyecto',
  `estado_proyect` varchar(20) DEFAULT NULL,
  `porceEjec_proyect` varchar(4) DEFAULT NULL COMMENT 'estado actual del proyecto',
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_proyect`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 30;
}

$consulta = "CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL AUTO_INCREMENT,
  `cod_responsable` varchar(30) DEFAULT NULL,
  `nom_responsable` text,
  `email_responsable` varchar(100) DEFAULT NULL,
  `tel_responsable` varchar(50) DEFAULT NULL,
  `obs_responsable` text,
  `dependencia` varchar(10) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_responsable`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 31;
}

$consulta = "CREATE TABLE `secretarias` (
  `idsecretarias` int(11) NOT NULL AUTO_INCREMENT,
  `cod_secretarias` varchar(135) DEFAULT NULL,
  `des_secretarias` text,
  `responsanble_secretarias` text,
  `correo_secretarias` varchar(100) DEFAULT NULL,
  `obs_secretarias` text,
  `ico_secretarias` varchar(100) DEFAULT NULL,
  `estado_secretaria` varchar(10) DEFAULT 'ACTIVO',
  PRIMARY KEY (`idsecretarias`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 32;
}

$consulta = "CREATE TABLE `supervisores` (
  `id_supervisores` int(11) NOT NULL AUTO_INCREMENT,
  `cod_supervisores` varchar(50) DEFAULT NULL,
  `nom_supervisores` text,
  `correo_supervisores` varchar(150) DEFAULT NULL,
  `telef_supervisores` varchar(50) DEFAULT NULL,
  `obser_supervisores` text,
  `estado_supervisores` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_supervisores`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 33;
}

$consulta = "CREATE TABLE `tipo_contratacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(45) DEFAULT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `OBSERVACIONES` text,
  `ESTADO` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 34;
}

$consulta = "CREATE TABLE `tipologia_proyecto` (
  `id_tipolo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_tipolo` varchar(10) DEFAULT NULL,
  `des_tipolo` varchar(100) DEFAULT NULL,
  `obs_tipolo` text,
  `est_tipolo` varchar(10) DEFAULT 'ACTIVO',
  `img_tipolo` text,
  PRIMARY KEY (`id_tipolo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 35;
}

$consulta = "CREATE TABLE `ubic_proyect` (
  `id_ubic` int(11) NOT NULL AUTO_INCREMENT,
  `proyect_ubi` varchar(10) DEFAULT NULL,
  `depar_ubic` varchar(10) DEFAULT NULL,
  `muni_ubic` varchar(10) DEFAULT NULL,
  `corr_ubic` varchar(10) DEFAULT NULL,
  `barr_ubic` varchar(10) DEFAULT NULL,
  `lat_ubic` varchar(100) DEFAULT NULL,
  `long_ubi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_ubic`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
$qc = mysql_query($consulta, $link);
if (($qc == false) || (mysql_affected_rows($link) == -1) || mysql_errno($link) != 0) {
    $success = 0;
    $error = 36;
}


if ($success == 0) {
    mysql_query("ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysql_query("COMMIT");
    echo "1";
}

mysql_close();
?>