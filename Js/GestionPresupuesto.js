$(document).ready(function () {
  $("#home").removeClass("start active open");
  $("#menu_op").addClass("start active open");
  $("#menu_op_Presupuesto").addClass("active");
  var Op_Validar = [];
  var Op_Vali = "Ok";

  $.extend({
    Presupuesto: function () {
      var datos = {
        pag: "1",
        op: "1",
        bus: "",
        rus: "n",
        nreg: $("#nreg").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagPresupuesto.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Presupuesto").html(data["cad"]);
          $("#bot_Presupuesto").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    busqDepen: function (val) {
      var datos = {
        bus: val,
        pag: "1",
        op: "1",
        nreg: $("#nreg").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagDependencia.php",
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
    paginador: function (pag) {
      var datos = {
        pag: pag,
        bus: $("#busq_centro").val(),
        nreg: $("#nreg").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagDependencia.php",
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
    combopag: function (pag) {
      var datos = {
        pag: pag,
        bus: $("#busq_centro").val(),
        nreg: $("#nreg").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagDependencia.php",
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
    combopag2: function (nre) {
      var datos = {
        nreg: nre,
        bus: $("#busq_centro").val(),
        pag: $("#selectpag").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagDependencia.php",
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
    Validar: function () {
      var Id = "",
        Value = "";
      Op_Vali = "Ok";

      Id = "#txt_Cod";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Codigo").addClass("has-error");
      } else {
        $("#From_Codigo").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#txt_Desc";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Descripcion").addClass("has-error");
      } else {
        $("#From_Descripcion").removeClass("has-error");
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
    AddBolsa: function () {
      var txt_DescBolsa = $("#txt_DescBolsa").val();
      var txt_ValBolsa = $("#txt_ValBolsa").val();

      contBolsa = $("#contBolsa").val();
      contBolsa++;

      var txt_finan = txt_ValBolsa.split(" ");

      var valPres = parseFloat(
        txt_finan[1]
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
          .replace(",", ".")
      );
      var Presupuesto = parseFloat($("#txt_PresTotalTotal").val()) + valPres;

      var fila = '<tr class="selected" id="Bolsa' + contBolsa + '" >';

      fila += "<td>" + contBolsa + "</td>";
      fila += "<td>" + txt_DescBolsa + "</td>";
      fila += "<td>" + "$ " + number_format2(valPres, 2, ",", ".") + "</td>";
      fila +=
        "<td><input type='hidden' id='idDesBolsa" +
        contBolsa +
        "' name='txt_DesBolsa[]' value='" +
        txt_DescBolsa +
        "' /><input type='hidden' id='idvalor" +
        contBolsa +
        "' name='txt_valor[]' value='" +
        valPres +
        "' /><a onclick='$.QuitarBolsa(" +
        contBolsa +
        ")' class='btn default btn-xs red'>" +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Bolsas").append(fila);

      $("#contBolsa").val(contBolsa);

      $("#txt_PresTotalTotal").val(Presupuesto);
      $("#txt_PresTotal").val("$ " + number_format2(Presupuesto, 2, ",", "."));

      $("#txt_DescBolsa").val("");
      $("#txt_ValBolsa").val("0,00");
    },

    reordenarbolsa: function () {
      var num = 1;
      $("#tb_Bolsas tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
    },

    QuitarBolsa: function (id_fila) {
      contBolsa = $("#contBolsa").val();
      contBolsa = contBolsa - 1;
      var txt_val = $("#idvalor" + id_fila).val();
      $.reordenarbolsa();
      var financi = $("#txt_PresTotalTotal").val() - txt_val;
      $("#txt_PresTotalTotal").val(financi);
      $("#txt_PresTotal").val("$ " + number_format2(financi, 2, ",", "."));
      $("#Bolsa" + id_fila).remove();
      $("#contBolsa").val(contBolsa);
    },
  });
  //======FUNCIONES========\\
  $.Presupuesto();

  //==============\\
  $("#btn_nuevo1").on("click", function () {
    $("#acc").val("1");
    $("#txt_Cod").val("");
    $("#txt_Desc").val("");
    $("#txt_obser").val("");
    $("#txt_Corre").val("");
    $("#txt_Telf").val("");

    $("#btn_nuevo2").prop("disabled", true);
    $("#btn_guardar").prop("disabled", false);

    $("#txt_Cod").prop("disabled", false);
    $("#txt_Desc").prop("disabled", false);
    $("#txt_obser").prop("disabled", false);
    $("#txt_Telf").prop("disabled", false);
    $("#txt_Corre").prop("disabled", false);

    $("#responsive").modal({ backdrop: "static", keyboard: false });
    $("#mopc").show();
  });

  $("#txt_Cod").on("change", function () {
    var datos = {
      ope: "verfDepend",
      cod: $("#txt_Cod").val(),
    };

    $.ajax({
      type: "POST",
      url: "../All.php",
      data: datos,
      success: function (data) {
        if (data === "1") {
          $("#From_Codigo").addClass("has-error");
          $.Alert(
            "#msg",
            "Este Código ya Esta Registrado...",
            "warning",
            "warning"
          );
          $("#txt_Cod").focus();
          $("#txt_Cod").val("");
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });

  $("#btn_nuevo2").on("click", function () {
    $("#acc").val("1");

    $("#txt_Cod").val("");
    $("#txt_Desc").val("");
    $("#txt_obser").val("");
    $("#txt_Telf").val("");
    $("#txt_Corre").val("");

    $("#btn_nuevo2").prop("disabled", true);
    $("#btn_guardar").prop("disabled", false);

    $("#txt_Cod").prop("disabled", false);
    $("#txt_Desc").prop("disabled", false);
    $("#txt_obser").prop("disabled", false);
    $("#txt_Telf").prop("disabled", false);
    $("#txt_Corre").prop("disabled", false);
  });

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

    var datos = {
      cod: $("#txt_Cod").val(),
      des: $("#txt_Desc").val(),
      cor: $("#txt_Corre").val(),
      tel: $("#txt_Telf").val(),
      obs: $("#txt_obser").val(),
      acc: $("#acc").val(),
      id: $("#txt_id").val(),
    };

    $.ajax({
      type: "POST",
      url: "../Administracion/GuardarDependencia.php",
      data: datos,
      success: function (data) {
        if (trimAll(data) === "bien") {
          $.Alert(
            "#msg",
            "Datos Guardados Exitosamente...",
            "success",
            "check"
          );
          $.Depend();
          $("#btn_nuevo2").prop("disabled", false);
          $("#btn_guardar").prop("disabled", true);

          $("#txt_Cod").prop("disabled", true);
          $("#txt_Desc").prop("disabled", true);
          $("#txt_Corre").prop("disabled", true);
          $("#txt_Telf").prop("disabled", true);
          $("#txt_obser").prop("disabled", true);
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });
});
///////////////////////
