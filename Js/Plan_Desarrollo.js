$(document).ready(function() {


    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");

    $("#btn_ejes").on("click", function() {
        window.location.href = 'PlanDesarrollo/Ejes.php';
    });
    $("#btn_estrategias").on("click", function() {
        window.location.href = 'PlanDesarrollo/Estrategias.php';
    });
    $("#btn_programas").on("click", function() {
        window.location.href = 'PlanDesarrollo/Programas.php';
    });
    $("#btn_objetivos").on("click", function() {
        window.location.href = 'PlanDesarrollo/Objetivos.php';
    });

    $("#btn_volver").on("click", function() {
        window.location.href = 'Administracion.php';
    });
});