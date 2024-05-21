$(document).ready(function() {

//    $("#home").removeClass("start active open");
//    $("#menu_op").addClass("start active open");

    $("#btn_empre").on("click", function() {
        window.location.href = '../Datos_compania/';
    });

    $("#btn_depe").on("click", function() {
        window.location.href = '../Dependencias/';
    });
    $("#btn_resp").on("click", function() {
        window.location.href = '../Responsable/';
    });
    $("#btn_super").on("click", function() {
        window.location.href = '../Supervisores/';
    });
    $("#btn_interv").on("click", function() {
        window.location.href = '../Interventores/';
    });
    $("#btn_contr").on("click", function() {
        window.location.href = '../Contratistas/';
    });
    $("#btn_secre").on("click", function() {
        window.location.href = '../Secretarias/';
    });
    $("#btn_tipol").on("click", function() {
        window.location.href = '../Tipologia_Proyectos/';
    });
    $("#btn_tipocont").on("click", function() {
        window.location.href = '../Tipologia_Contratos/';
    });
    $("#btn_conse").on("click", function() {
        window.location.href = '../Consecutivos/';
    });


});