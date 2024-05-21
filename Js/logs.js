$(document).ready(function () {
    
    $("#home").removeClass("start active open");
    $("#menu_logs").addClass("start active open");

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        logs: function () {
            var datos = {
                opc: "CargLogs",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n"
            }

            $.ajax({
                type: "POST",
                url: "PagLogs.php",
                data: datos,
                success: function (data) {
                    pdat = data.split("//");

                    $('#tab_logs').show(100).html(pdat[0]);
                    $('#botlogs').show(100).html(pdat[1]);
                    
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqlog: function (val) {
            

            var datos = {
                opc: "BusqCent",
                bus: val,
                pag:"1",
                op:"1"
                
            }

            $.ajax({
                type: "POST",
                url: "PagLogs.php",
                data: datos,
                success: function (data) {
                          pdat = data.split("//");

                    $('#tab_logs').show(100).html(pdat[0]);
                    $('#botlogs').show(100).html(pdat[1]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        buscodusu: function (val) {
            $('#txt_usu').val(val);
            regus = "n";
            if ($('#reusu').prop('checked')) {
                regus = "s";
            }

            var datos = {
                opc: "BusqCent",
                bus: $("#busq_centro").val(),
                rus: regus,
                pag:"1",
                op:"1",
                usu: $("#txt_usu").val()
                
            }

            $.ajax({
                type: "POST",
                url: "PagLogs.php",
                data: datos,
                success: function (data) {
                          pdat = data.split("//");

                    $('#tab_logs').show(100).html(pdat[0]);
                    $('#botlogs').show(100).html(pdat[1]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
       
         paginador: function (pag,servel) {
          
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val(),
                    usu: $("#txt_usu").val()
                }

                $.ajax({
                    type: "POST",
                    url: "PagLogs.php",
                    data: datos,
                    success: function (data) {
                                pdat = data.split("//");

                    $('#tab_logs').show(100).html(pdat[0]);
                    $('#botlogs').show(100).html(pdat[1]);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        },
        combopag: function (pag,servel) {
             
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val(),
                    usu: $("#txt_usu").val()
                }

                $.ajax({
                    type: "POST",
                    url: "PagLogs.php",
                    data: datos,
                    success: function (data) {
                             pdat = data.split("//");

                    $('#tab_logs').show(100).html(pdat[0]);
                    $('#botlogs').show(100).html(pdat[1]);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        }
       
       
    });
    //======FUNCIONES========\\
    
    });
    ///////////////////////
