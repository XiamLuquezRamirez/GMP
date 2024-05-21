$(document).ready(function () {
    $(".cajasIntervalos").on({
        keydown: function (event) {
            if (event.shiftKey) {
                event.preventDefault();
            }
            // Solo Numeros del 0 a 9 
            if (event.keyCode < 48 || event.keyCode > 57) {
                if (event.keyCode < 96 || event.keyCode > 105) {
                    if (event.keyCode != 46 && event.keyCode != 8 && event.keyCode != 37 && event.keyCode != 39) {
                        event.preventDefault();
                    }
                }
            }
        }
    });
    $(".cajasIntervalos").on({
        keyup: function () {
            if ($(this).val() < 1 || $(this).val() > 100) {
                $(this).val("");
            }
        }
    });

    $("#btnGuardar").on({
        click: function (e) {
            e.preventDefault();
            if ($("#menos").val() === "") {
                $.Alert("#msgCodPol", "Por favor digite un valor en el campo menos", "warning", 'warning');
                return false;
            }
            if ($("#mas").val() === "") {
                $.Alert("#msgCodPol", "Por favor digite un valor en el campo mas", "warning", 'warning');
                return false;
            }
            var datos = {
                id: $("#id").val(),
                menos: $("#menos").val(),
                mas: $("#mas").val(),
                OPCION: 'GUARDARPARAMETROSALERTA'
            }
            $.ajax({
                type: "POST",
                url: "../Proyecto/Polizas.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    if (data === 1) {
                        $.Alert("#msgCodPol", "Parametros guardados de manera exitosa", "success", 'success');
                    } else {
                        $.Alert("#msgCodPol", "Parametros no guardados", "warning", 'warning');
                    }
                },
                error: function (error_messages) {

                }
            });
        }
    });

    $.extend({
        Alert: function (Id_Msg, Txt_Msg, Type_Msg) {
            App.alert({
                container: Id_Msg, // alerts parent container(by default placed after the page breadcrumbs)
                place: "append", // append or prepent in container [append, prepend]
                type: Type_Msg, // alert's type [success, danger, warning, info]
                message: Txt_Msg, // alert's message
                close: true, // make alert closable [true, false]
                reset: true, // close all previouse alerts first [true, false]
                focus: true, // auto scroll to the alert after shown [true, false]
                closeInSeconds: "5", // auto close after defined seconds [0, 1, 5, 10]
                icon: "" // put icon before the message [ "" , warning, check, user]
            });
        }

    });
});