<head>
    <meta charset="utf-8" />
    <title> <?php echo $pageTitle; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../Plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../Plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="../Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../Css/Global/css/components.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../Css/Layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../Css/Layouts/layout/css/themes/light2.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../Css/Layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="../Img/favicon.ico" />

    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css " rel="stylesheet">


    <script src="../Js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../Js/GestionPresupuesto.js" type="text/javascript"></script>
    <script src="../Js/funciones_generales.js" type="text/javascript"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js "></script>

    <style>
             /* Estilo personalizado para asegurarse de que el z-index sea alto */
        .swal2-container {
            z-index: 10052 !important;
        }

        div:where(.swal2-container).swal2-center>.swal2-popup {

            border-radius: 5px !important;
        }

        div:where(.swal2-icon).swal2-warning.swal2-icon-show {
            border-radius: 50% !important;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            border-radius: 5px !important;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel {
            border-radius: 5px !important;
        }

        
        .opciones {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
        }

        .opciones a {
            margin-bottom: 3px;
            transition: all .5s ease;
        }

        .opciones a:hover {
            transform: translateX(3px);
        }

        thead {
            background-color: #f9f9f9;
            /* Fondo del encabezado */
            position: sticky;
            /* Posición pegajosa */
            top: 0;
            /* Fijo en la parte superior */
            z-index: 1;
            /* Asegurarse de que el encabezado esté por encima del contenido */
        }
    </style>
</head>