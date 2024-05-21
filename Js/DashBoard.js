$(document).ready(function () {
    // UISliders.initKnowElements();
    var conGlobal = 0;
    Load();
    $(".clasesCombos").selectpicker();

    function Load() {
        var Datos = "";
        var type = "POST";
        var dataType = "json";
        Datos = {
            OPCION: "CONSULTARTOTALES",
            ejes: $("#cmbEjes").val(),
            secretaria: $("#cmbSecre").val(),
            vigencia: $("#cmbVigencia").val(),
            fuentes: $("#cmbFuentes").val()
        };
        $.ajax({
            type: type,
            url: "DashBoard.php",
            data: Datos,
            dataType: dataType,
            success: function (data) {
                if (data.tamASECRE > 1) {
                    // CALCULAR PORCENTAJES DE LOS CIRCULOS
                    // alert(data.POREJEPROYECTOS);
                    setTimeout(function () {
                        var valor1 = (Number(data.POREJEPROYECTOS) * 360) / 100;
                        var activeBorder = $("#activeBorder1");
                        conGlobal = 0;
                        ValorFinal = data.POREJEPROYECTOS;
                        llenarCirculos(ValorFinal, "#prec1", activeBorder, valor1, "#39B4CC");
                    }, 800);

                    setTimeout(function () {
                        var valor2 = (Number(data.POREJEPRESUPUESTAL) * 360) / 100;
                        var activeBorder = $("#activeBorder2");
                        conGlobal = 0;
                        ValorFinal = data.POREJEPRESUPUESTAL;
                        llenarCirculos(ValorFinal, "#prec2", activeBorder, valor2, "#1ec854");
                    }, 800);

                    setTimeout(function () {
                        var valor3 = (Number(data.POREJEPROYECTOS) * 360) / 100;
                        var activeBorder = $("#activeBorder3");
                        conGlobal = 0;
                        ValorFinal = data.POREJEPROYECTOS;
                        llenarCirculos(ValorFinal, "#prec3", activeBorder, valor3, "#c83d1e");
                    }, 800);


                    // CALCULAR PORCENTAJES DE LOS CIRCULOS
                }

                campo = "";
                $("#contenidoPresupuestos").html("");
                if (data["Op1"] === "Existe") {
                    campo += "<tr>";
                    campo += "<td style='width: 20%;text-align:center;font-weight:bold;vertical-align: middle;'>$ " + Vacio(data.PRESUPUESTO_INICIAL) + "</td>";
                    campo += "<td style='width: 20%;text-align:center;font-weight:bold;vertical-align: middle;'>$ " + Vacio(data.PRESUPUESTO_DISPONIBLE) + "</td>";
                    campo += "<td style='width: 20%;text-align:center;font-weight:bold;vertical-align: middle;'>$ " + Vacio(data.TOTAL_PROYECTOS) + "</td>";
                    campo += "<td style='width: 20%;text-align:center;font-weight:bold;vertical-align: middle;'>$ " + Vacio(data.TOTAL_EJECUCION_PROYECTOS) + "</td>";
                    campo += "<td style='width: 20%;text-align:center;font-weight:bold;vertical-align: middle;'>$ " + Vacio(data.PRESUPUESTO_SIN_EJECUTAR) + "</td>";
                    campo += "</tr>";
                    $("#contenidoPresupuestos").append(campo);
                }
                var campo = "";
                $("#contenidoSecretarias").html("");
                for (var i = 1; i <= data.tamASECRE; i++) {
                    campo = "";
                    campo += "<tr>";
                    campo += "<td style='width: 14%;text-align:center;font-weight:normal;text-align:right;'>" + i + ". " + Vacio(data.AVANCEFISICO.DESC[i]) + " </td>";
                    campo += "<td style='width: 14%;text-align:center;font-weight:normal;'>";
                    campo += "<div class='progress' style='margin-bottom:0;'>";
                    campo += "<span class='progress-value1'>" + Vacio(data.AVANCEFISICO.FISICO[i]) + "%</span>";
                    campo += "<div class='progress-bar bg-success' role='progressbar' aria-valuenow='" + Vacio(data.AVANCEFISICO.FISICO[i]) + "%' aria-valuemin='0' aria-valuemax='100' style='width: " + Vacio(data.AVANCEFISICO.FISICO[i]) + "%;'></div>";
                    campo += "</div>";
                    campo += "</td > ";
                    campo += "<td style='width: 14%;text-align:center;font-weight:normal;'>";
                    campo += "<div class='progress' style='margin-bottom:0;'>";
                    campo += "<span class='progress-value2'>" + Vacio(data.AVANCEFISICO.FISICO[i]) + "%</span>";
                    campo += "<div class='progress-bar green' role='progressbar' aria-valuenow='" + Vacio(data.AVANCEFISICO.FISICO[i]) + "%' aria-valuemin='0' aria-valuemax='100' style='width: " + Vacio(data.AVANCEFISICO.FISICO[i]) + "%;'></div>";
                    campo += "</div>";
                    campo += "</td > ";
                    campo += "</tr>";
                    $("#contenidoSecretarias").append(campo);
                }
                campo = "";
                campo += "<tr>";
                campo += "<td style='width: 14%;text-align:center;font-weight:normal;text-align:right;'> </td>";
                campo += "<td style='width: 14%;text-align:center;font-weight:normal;'>";
                campo += "<div id='bar' class='progress progress-success bold' style='background-color: #007787;color:white;margin-bottom:0;'>";
                campo += "<div class='bar' style='width: 100%;'></div>Presupuestal";
                campo += "</div>";
                campo += "</td > ";
                campo += "<td style='width: 14%;text-align:center;font-weight:normal;'>";
                campo += "<div id='bar' class='progress progress-success bold' style='background-color: #007787;color:white;margin-bottom:0;'>";
                campo += "<div class='bar' style='width: 100%;'></div>Fisico";
                campo += "</div>";
                campo += "</td > ";
                campo += "</tr>";
                $("#contenidoSecretarias").append(campo);
            },
            beforeSend: function () {
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
        $("#modalDashboar").modal("show");
    }

    $("#cmbSecre,#cmbEjes,#cmbFuentes").on({
        change: function () {
            Load();
        }
    });
    //===============FUNCION VACIO===============\\
    function Vacio(valor) {
        // alert(valor);
        if (valor === "" || valor === null || valor === undefined) {
            valor = "";
        }
        return valor;
    }
    //===============FUNCION VACIO===============\\

    function llenarCirculos(ValorFinal, caja, activeBorder, degs, tipo) {
        conGlobal++;
        if (conGlobal < 0)
            conGlobal = 0;
        if (conGlobal > degs)
            conGlobal = degs;
        prec = (100 * conGlobal) / 360;
        $(caja).html(Math.round(prec) + "%");
        if (degs > 0) {
            activeBorder.css('background-color', tipo);
            if (conGlobal <= 180) {
                activeBorder.css('background-image', 'linear-gradient(' + (90 + conGlobal) + 'deg, transparent 50%, #A2ECFB 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
                // alert(conGlobal);return;
            }
            else {
                activeBorder.css('background-image', 'linear-gradient(' + (conGlobal - 90) + 'deg, transparent 50%, ' + tipo + ' 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
            }
            setTimeout(function () {
                if (conGlobal < degs) {
                    llenarCirculos(ValorFinal, caja, activeBorder, degs, tipo);
                } else {
                    $(caja).html(ValorFinal + "%");
                    return;
                }
            }, 1);
        } else {
            $(caja).html(ValorFinal + "%");
            return;
        }
    }

});