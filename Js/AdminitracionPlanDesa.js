$(document).ready(function() {

    $("#home").removeClass("start active open");
    $("#menu_plan").addClass("start active open");

    $("#btn_ejes").on("click", function() {
        window.location.href = '../Ejes_Estrategicos/';
    });
    $("#btn_Componentes").on("click", function() {
        window.location.href = '../Programas/';
    });
    $("#btn_programas").on("click", function() {
        window.location.href = '../SubProgramas/';
    });
    $("#btn_Metas").on("click", function() {
        window.location.href = '../Metas/';
    });



});