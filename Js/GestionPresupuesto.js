$(document).ready(function () {
  $("#home").removeClass("start active open");
  $("#menu_op").addClass("start active open");
  $("#menu_op_Presupuesto").addClass("active");
  var Op_Validar = [];
  var Op_Vali = "Ok";
  let valTotalPresupuesto = 0;
  let Dat_Subfuente = [];


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
        bus: val,
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
        bus: val,
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
    NewSubfinanciacion: function () {
      if ($("#fuente").val() == " ") {
        $.Alert(
          "#msg",
          "Debes seleccionar la fuente de financiación...",
          "warning",
          "warning"
        );
      } else {
        $("#titformisubfin").html(
          "Detalles del presupuesto - " + $("#fuente option:selected").text()
        );
        $("#responsive").modal("toggle");
        $("#responsiveSubfinanciacion").modal({
          backdrop: "static",
          keyboard: false,
        });
        $.buscarSubfuente();
      }
    },
    guardarSubfuente: function () {

      let subfuentes = document.getElementsByClassName("filasSubfuentes");
      if (subfuentes.length > 0) {
       
        $("#responsiveSubfinanciacion").modal("toggle");
        $("#responsive").modal({
          backdrop: "static",
          keyboard: false,
        });
        $("#txt_PresTotalVis").val(
          formatCurrency(valTotalPresupuesto, "es-CO", "COP")
        );
        $("#txt_PresTotal").val(valTotalPresupuesto);
      } else {
        $.Alert(
          "#msgSubfuente",
          "Debe agregar una subfuente de financiación...",
          "warning",
          "warning"
        );
      }
    },
    cerrarSubfuente: function () {
      $("#responsiveSubfinanciacion").modal("toggle");
      $("#responsive").modal({
        backdrop: "static",
        keyboard: false,
      });

      $("#subfuente").select2("val", " ");
      $("#td_subfuentes").html("");
    },
    AddSubfuentes: function () {
      var subFuente = $("#subfuente").val();
      var text_subFuente = $("#subfuente option:selected").text();
      var valorSub = $("#txt_valorSub").val();
      if (subFuente == "") {
        $.Alert(
          "#msgSubfuente",
          "Por Favor ingrese la subfuente...",
          "warning",
          "warning"
        );
        $("#txt_Subfuente").focus();
        return;
      }

      if (valorSub == "") {
        $.Alert(
          "#msgSubfuente",
          "Por Favor ingrese el valor...",
          "warning",
          "warning"
        );
        $("#txt_valorSubVis").focus();
        return;
      }

      valTotalPresupuesto += parseFloat(valorSub);

      let contSubfuente = $("#contSubfuentes").val();
      contSubfuente++;
      var fila =
        '<tr class="selected filasSubfuentes" id="filaSubfuente' +
        contSubfuente +
        '" >';

      fila += "<td>" + contSubfuente + "</td>";
      fila += "<td>" + text_subFuente + "</td>";
      fila += "<td>" + formatCurrency(valorSub, "es-CO", "COP") + "</td>";
      fila +=
        "<td><input type='hidden' id='idSubfuente" +
        contSubfuente +
        "' name='terce' value='" +
        subFuente +
        "//" +
        valorSub +
        "//' /><a data-fila='" +
        contSubfuente +
        "' data-id='' onclick='$.EditarSubfuente(this)' class='btn default btn-xs blue'><i class='fa fa-edit'></i> Editar</a><a data-fila='" +
        contSubfuente +
        "' data-id='' data-valor='" +
        valorSub +
        "' onclick='$.QuitarSubfuente(this)' class='btn default btn-xs red'><i class='fa fa-trash-o'></i> Quitar</a></td></tr>";
      $("#tb_Subfuente").append(fila);
      $.reordenarSubfuente();
      $("#contSubfuentes").val(contSubfuente);

      $("#subfuente").select2("val", " ");
      $("#txt_valorSubVis").val("$ 0,00");
      $("#txt_valorSub").val("0");
      $("#opbSub").val("guardar");
    },
    reordenarSubfuente: function () {
      var num = 1;

      // Reordenar los números de las filas
      $("#td_subfuentes tr").each(function () {
          $(this).find("td").eq(0).text(num);
          $(this).attr("id", "filaSubfuente" + num);
          $(this).find("a").each(function() {
              $(this).attr("data-fila", num);
          });
          $(this).find("input").each(function() {
              $(this).attr("id", "idSubfuente" + num);
          });
          num++;
      });
    },
    EditarSubfuente: function (element) {
      $("#opbSub").val("editar");
      trelementoSel = element.getAttribute("data-fila");
      let idSubfuente = element.getAttribute("data-id");
      let paraSubfuente = $("#idSubfuente" + trelementoSel).val().split("//");
      
      var selectElement = document.getElementById("subfuente");
      selectElement.value = paraSubfuente[0];
      var event = new Event("change", { bubbles: true });
      selectElement.dispatchEvent(event);
     
      $("#txt_valorSubVis").val(
        formatCurrency(paraSubfuente[1], "es-CO", "COP")
      );
      $("#txt_valorSub").val(paraSubfuente[1]);

      valTotalPresupuesto -= paraSubfuente[1];
      $("#filaSubfuente" + trelementoSel).remove();
      $.reordenarSubfuente();
      let contSubfuente = $("#contSubfuentes").val();
      contSubfuente = contSubfuente - 1;
      $("#contSubfuentes").val(contSubfuente);
    },
    QuitarSubfuente: function (element) {
      let trelemento = element.getAttribute("data-fila");
      let idSubfuente = element.getAttribute("data-id");
      let valor = element.getAttribute("data-valor");

      if (idSubfuente == "") {
        $("#filaSubfuente" + trelemento).remove();
        valTotalPresupuesto -= valor;
        $.reordenarSubfuente();
        let contSubfuente = $("#contSubfuentes").val();
        contSubfuente = contSubfuente - 1;
        $("#contSubfuentes").val(contSubfuente);
      } else {
        var datos = {
          ope: "eliminarSubFuente",
          idf: idSubfuente,
        };

        $.ajax({
          type: "POST",
          url: "../All.php",
          data: datos,
          success: function (data) {
            if (data == "Bien") {
              $.Alert(
                "#msgCodPol",
                "Registro eliminado correctamente",
                "success",
                "success"
              );
              $("#" + trelemento).remove();
              $.reordenarSubfuente();
              let contSubfuente = $("#contSubfuentes").val();
              contSubfuente = contSubfuente - 1;
              $("#contSubfuentes").val(contSubfuente);
            } else if (data == "Asigando") {
              $.Alert(
                "#msgCodPol",
                "La subfuente de financiación le fue cargado un presupuesto, no se puede eliminar.",
                "warning",
                "warning"
              );
            } else {
            }
          },
          error: function (error_messages) {
            alert("HA OCURRIDO UN ERROR");
          },
        });
      }
      console.log(valTotalPresupuesto);
    },
    editPresupuesto: function (cod) {
      $("#acc").val("2");
      $("#btn_nuevo2").prop("disabled", true);
      $("#btn_guardar").prop("disabled", false);

      var datos = {
        ope: "BusqEditPresupuesto",
        cod: cod,
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#fuente").select2("val", data["fuente"]);
          $("#txt_PresTotal").val(data["valor"]);
          $("#txt_PresTotalVis").val(
            formatCurrency(data["valor"], "es-CO", "COP")
          );
          $("#txtFecRegistro").val(data["fecha_recepcion"]);
          $("#CbPeriodoI").val(data["periodo_ini"]);
          $("#CbPeriodoF").val(data["periodo_fin"]);
          $("#txt_obser").val(data["observacion"]);
          $("#id").val(cod);

          ///cargar detalles

          $("#tb_Subfuente").html(data['Tab_Subfuente']);
          $("#contSubfuentes").val(data['contSubfuentes']);

          valTotalPresupuesto = data['valorTotalDet'];

        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#responsive").modal({ backdrop: "static", keyboard: false });
      $("#mopc").show();
    },
    VerPresupuesto: function (cod) {
      var datos = {
        ope: "BusqEditPresupuesto",
        cod: cod,
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#fuente").select2("val", data["fuente"]);
          $("#txt_PresTotalVis").val(
            formatCurrency(data["valor"], "es-CO", "COP")
          );
          $("#txtFecRegistro").val(data["fecha_recepcion"]);
          $("#CbPeriodoI").val(data["periodo_ini"]);
          $("#CbPeriodoF").val(data["periodo_fin"]);
          $("#txt_obser").val(data["observacion"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#responsive").modal({ backdrop: "static", keyboard: false });
      $("#mopc").hide();
    },
    deletPresupuesto: function (cod) {
      Swal.fire({
        title: "¿Estás seguro de eliminar este registro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, eliminar!",
      }).then((result) => {
        if (result.isConfirmed) {
          var datos = {
            acc: "3",
            id: cod,
          };

          $.ajax({
            type: "POST",
            url: "../Administracion/GuardarRubroPresup.php",
            data: datos,
            success: function (data) {
              if (data === "bien") {
                Swal.fire(
                  "¡Eliminado!",
                  "El registro fue eliminado exitosamente.",
                  "success"
                );
                $.Presupuesto();
              }
            },
            error: function (error_messages) {
              alert("HA OCURRIDO UN ERROR");
            },
          });
        }
      });
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
      $("#txt_valorSub").val(numero);
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
    Dta_Subfuentes: function () {
      $("#tb_Subfuente")
        .find(":input")
        .each(function () {
          Dat_Subfuente.push($(this).val());
        });
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
    form.append("<input type='hidden' id='idtoken' name='_token'  value='" + token + "'>"
    );

    Dat_Subfuente = [];
    $.Dta_Subfuentes();

    form.append("<input type='hidden' id='Dat_Subfuente' name='Dat_Subfuente' value='" + JSON.stringify(Dat_Subfuente) + "'>");
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
          $.Presupuesto();
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });
});
///////////////////////
