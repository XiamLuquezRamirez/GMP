$(document).ready(function () {
  $("#home").removeClass("start active open");
  $("#menu_op").addClass("start active open");
  $("#menu_op_Presupuesto").addClass("active");
  var Op_Validar = [];
  var Op_Vali = "Ok";

  $("#CbPeriodoI,#CbPeriodoF").datepicker({
    autoclose: true,
    format: " yyyy",
    viewMode: "years",
    minViewMode: "years",
  });

  $("#txtFecRegistro").datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayBtn: "linked",
    todayHighlight: true,
    language: "es",
  });

  $("#CbGenero").selectpicker();

  const fechaActual = new Date();
  const anoActual = fechaActual.getFullYear();
  $.extend({
    Presupuesto: function (val) {
      var datos = {
        bus: val
      };

      console.log(datos);

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagPresupuesto.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Presupuesto").html(data["cad"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    busqPresu: function (val) {
      var datos = {
        bus: val
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagPresupuesto.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Dependencia").html(data["cad"]);
          $("#bot_Dependencia").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    editDepen: function (cod) {
      $("#acc").val("2");
      $("#btn_nuevo2").prop("disabled", true);
      $("#btn_guardar").prop("disabled", false);
      var datos = {
        ope: "BusqEditDependencia",
        cod: cod,
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#txt_Cod").val(data["cod_dependencia"]);
          $("#txt_Desc").val(data["des_dependencia"]);
          $("#txt_Corre").val(data["correo_dependencia"]);
          $("#txt_Telf").val(data["tel_dependencia"]);
          $("#txt_obser").val(data["obs_dependencia"]);
          $("#txt_id").val(cod);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#responsive").modal({ backdrop: "static", keyboard: false });
      $("#mopc").show();

      $("#txt_Cod").prop("disabled", false);
      $("#txt_Desc").prop("disabled", false);
      $("#txt_Corre").prop("disabled", false);
      $("#txt_Telf").prop("disabled", false);
      $("#txt_obser").prop("disabled", false);
    },
    VerDepen: function (cod) {
      var datos = {
        ope: "BusqEditDependencia",
        cod: cod,
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#txt_Cod").val(data["cod_dependencia"]);
          $("#txt_Desc").val(data["des_dependencia"]);
          $("#txt_Corre").val(data["correo_dependencia"]);
          $("#txt_Telf").val(data["tel_dependencia"]);
          $("#txt_obser").val(data["obs_dependencia"]);
          $("#txt_id").val(cod);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#responsive").modal({ backdrop: "static", keyboard: false });
      $("#mopc").hide();

      $("#txt_Cod").prop("disabled", false);
      $("#txt_Desc").prop("disabled", false);
      $("#txt_Corre").prop("disabled", false);
      $("#txt_obser").prop("disabled", false);
    },
    deletDepen: function (cod) {
      if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
        var datos = {
          acc: "3",
          cod: cod,
        };

        $.ajax({
          type: "POST",
          url: "../Administracion/GuardarDependencia.php",
          data: datos,
          success: function (data) {
            if (data === "bien") {
              $.Alert(
                "#msg2",
                "Operación Realizada Exitosamente...",
                "success",
                "check"
              );
              $.Depend();
            } else if (data === "nbien") {
              $.Alert(
                "#msg2",
                "Esta Dependencia no se puede Eliminar, Se encuentra relacionada a una Meta",
                "warning",
                "warning"
              );
            } else if (data === "rbien") {
              $.Alert(
                "#msg2",
                "Esta Dependencia no se puede Eliminar, Se encuentra relacionada a una Responsable",
                "warning",
                "warning"
              );
            }
          },
          error: function (error_messages) {
            alert("HA OCURRIDO UN ERROR");
          },
        });
      }
    },
   
    Validar: function () {
      var Id = "",
        Value = "";
      Op_Vali = "Ok";

      Id = "#fuente";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Fuente").addClass("has-error");
      } else {
        $("#From_Fuente").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#txt_PresTotal";
      Value = $(Id).val();
      if (Value === "$ 0,00") {
        Op_Validar.push("Fail");
        $("#formValor").addClass("has-error");
      } else {
        $("#formValor").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#txtFecRegistro";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#formFecReg").addClass("has-error");
      } else {
        $("#formFecReg").removeClass("has-error");
        Op_Validar.push("Ok");
      }
      Id = "#CbPeriodoI";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_VigenciaI").addClass("has-error");
      } else {
        $("#From_VigenciaI").removeClass("has-error");
        Op_Validar.push("Ok");
      }
      Id = "#CbPeriodoF";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_VigenciaF").addClass("has-error");
      } else {
        $("#From_VigenciaF").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      for (var i = 0; i <= Op_Validar.length - 1; i++) {
        if (Op_Validar[i] == "Fail") {
          Op_Vali = "Fail";
        }
      }

      Op_Validar.splice(0, Op_Validar.length);
    },
    Alert: function (Id_Msg, Txt_Msg, Type_Msg, ico) {
      App.alert({
        container: Id_Msg, // alerts parent container(by default placed after the page breadcrumbs)
        place: "append", // append or prepent in container [append, prepend]
        type: Type_Msg, // alert's type [success, danger, warning, info]
        message: Txt_Msg, // alert's message
        close: true, // make alert closable [true, false]
        reset: true, // close all previouse alerts first [true, false]
        focus: true, // auto scroll to the alert after shown [true, false]
        closeInSeconds: "5", // auto close after defined seconds [0, 1, 5, 10]
        icon: ico, // put icon before the message [ "" , warning, check, user]
      });
    },
    cambioFormato: function (id) {
      var numero = $("#" + id).val();
      $("#txt_PresTotal").val(numero);
      var formatoMoneda = formatCurrency(numero, "es-CO", "COP");
      $("#" + id).val(formatoMoneda);
    },
    nuevo: function (element) {
      let id = element.getAttribute("id");

      

      if (id == "btn_nuevo1") {
        $("#responsive").modal({ backdrop: "static", keyboard: false });
        $("#mopc").show();
      }

      $("#acc").val("1");
      $("#fuente").select2("val", " ");
      $("#txt_PresTotalVis").val("$ 0,00");
      $("#txtFecRegistro").val("");      
      $("#CbPeriodoI").val(anoActual);
      $("#CbPeriodoF").val(anoActual);
      $("#txt_obser").val("");
  
      $("#btn_nuevo2").prop("disabled", true);
      $("#btn_guardar").prop("disabled", false);

    },
  });
  //======FUNCIONES========\\
  $.Presupuesto();

  function formatCurrency(number, locale, currencySymbol) {
    return new Intl.NumberFormat(locale, {
      style: "currency",
      currency: currencySymbol,
      minimumFractionDigits: 2,
    }).format(number);
  }

  //BOTON GUARDAR-
  $("#btn_guardar").on("click", function () {
    $.Validar();

    if (Op_Vali === "Fail") {
      $.Alert(
        "#msg",
        "Por Favor Llene Los Campos Obligatorios...",
        "warning",
        "warning"
      );
      return;
    }

    var form = $("#formGuardarPresupuesto");
    var url = form.attr("action");
    var token = $("#token").val();
    $("#idtoken").remove();
    form.append(
      "<input type='hidden' id='idtoken' name='_token'  value='" + token + "'>"
    );
    var url = form.attr("action");
    var datos = form.serialize();

    $.ajax({
      type: "POST",
      url: url,
      data: datos,
      success: function (data) {
        if (trimAll(data) === "bien") {
          $.Alert(
            "#msg",
            "Datos Guardados Exitosamente...",
            "success",
            "check"
          );

          $("#btn_nuevo2").prop("disabled", false);
          $("#btn_guardar").prop("disabled", true);
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });
});
///////////////////////
