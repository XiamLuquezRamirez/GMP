$(document).ready(function () {
  $(".clasesCombos").selectpicker();
  $("#home").removeClass("start active open");
  $("#menu_op").addClass("start active open");
  $("#menu_op_secre").addClass("active");
  var Op_Validar = [];
  var Dat_Subfuente = [];
  var trelementoSel;
  var Op_Vali = "Ok";
  $.extend({
    Fuentes: function () {
      var datos = {
        pag: "1",
        op: "1",
        bus: "",
        rus: "n",
        nreg: $("#nreg").val(),
      };
      $.ajax({
        type: "POST",
        url: "../Paginadores/PagFuentes.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Fuen").html(data["cad"]);
          $("#bot_Fuen").html(data["cad2"]);
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
        url: "../Paginadores/PagFuentes.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Fuen").html(data["cad"]);
          $("#bot_Fuen").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    paginador: function (pag) {
      var datos = {
        pag: pag,
        bus: $("#busq_centro").val(),
        nreg: $("#nreg").val(),
      };
      $.ajax({
        type: "POST",
        url: "../Paginadores/PagFuentes.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Fuen").html(data["cad"]);
          $("#bot_Fuen").html(data["cad2"]);
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
        url: "../Paginadores/PagFuentes.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Fuen").html(data["cad"]);
          $("#bot_Fuen").html(data["cad2"]);
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
        url: "../Paginadores/PagFuentes.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Fuen").html(data["cad"]);
          $("#bot_Fuen").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
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
    Validar: function () {
      var Id = "",
        Value = "";
      Op_Vali = "Ok";
      Id = "#nombre";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Nombre").addClass("has-error");
      } else {
        $("#From_Nombre").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#descripcion";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Descripcion").addClass("has-error");
      } else {
        $("#From_Descripcion").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      let subfuentes = document.getElementsByClassName("filasSubfuentes");

      if (subfuentes.length <= 0) {
        Op_Validar.push("Fail");
        $("#From_Subfuente").addClass("has-error");
      } else {
        $("#From_Subfuente").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      for (var i = 0; i <= Op_Validar.length - 1; i++) {
        if (Op_Validar[i] == "Fail") {
          Op_Vali = "Fail";
        }
      }

      Op_Validar.splice(0, Op_Validar.length);
    },
    AddSubfuente: function () {
      var subFuente = $("#txt_Subfuente").val();
      if (subFuente == "") {
        $.Alert(
          "#msgCodPol",
          "Por Favor ingrese la subfuente...",
          "warning",
          "warning"
        );
        $("#txt_Subfuente").focus();
        return;
      }

      if ($("#opbSub").val() == "guardar") {
        let contSubfuente = $("#contSubfuentes").val();
        contSubfuente++;
        var fila =
          '<tr class="selected filasSubfuentes" id="filaSubfuente' +
          contSubfuente +
          '" >';

        fila += "<td>" + contSubfuente + "</td>";
        fila += "<td>" + subFuente + "</td>";
        fila +=
          "<td><input type='hidden' id='idSubfuente" +
          contSubfuente +
          "' name='terce' value='" +
          subFuente +
          "//' /><a data-fila='" +
          contSubfuente +
          "' data-id='' onclick='$.EditarSubfuente(this)' class='btn default btn-xs blue'><i class='fa fa-edit'></i> Editar</a><a data-fila='" +
          contSubfuente +
          "' data-id='' onclick='$.QuitarSubfuente(this)' class='btn default btn-xs red'><i class='fa fa-trash-o'></i> Quitar</a></td></tr>";
        $("#tb_Subfuente").append(fila);
        $.reordenarSubfuente();
        $("#contSubfuentes").val(contSubfuente);
      } else {
        let param = $("#idSubfuente" + trelementoSel).val().split("//");
        let idFue = param[1];

        var trId = "filaSubfuente" + trelementoSel;
        
        // Seleccionar el tr usando su ID y luego seleccionar el segundo td
        var secondTd = document.querySelector(`#${trId} td:nth-child(2)`);
      
        secondTd.textContent = subFuente;
        $("#idSubfuente"+trelementoSel).val(subFuente+"//"+idFue);
      }
      $("#txt_Subfuente").val("");
      $("#opbSub").val("guardar");
    },
    EditarSubfuente: function (element) {
      $("#opbSub").val("editar");
      trelementoSel = element.getAttribute("data-fila");
      let idSubfuente = element.getAttribute("data-id");
      let paraSubfuente = $("#idSubfuente" + trelementoSel).val().split("//");

      $("#txt_Subfuente").val(paraSubfuente[0]);
    },
    reordenarSubfuente: function () {
      var num = 1;
      $("#subFuente tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#subFuente tbody input").each(function () {
        $(this).attr("id", "idSubfuente" + num);
        num++;
      });
    },
    QuitarSubfuente: function (element) {
      let trelemento = element.getAttribute("data-fila");
      let idSubfuente = element.getAttribute("data-id");

      if (idSubfuente == "") {
        $("#filaSubfuente" + trelemento).remove();
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
    },
    Dta_Subfuentes: function () {
      $("#tb_Subfuente")
        .find(":input")
        .each(function () {
          Dat_Subfuente.push($(this).val());
        });
    },
  });
  $.Fuentes();
  $("#btn_nuevo1").on("click", function () {
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#nombre").focus();
    $("#From_Nombre").removeClass("has-error");
    $("#From_Descripcion").removeClass("has-error");
    $("#modalFuentes").modal({ backdrop: "static", keyboard: false });
    $("#btnGuardar").css("display", "inline-block");
    $("#nombre").prop("readonly", false);
    $("#descripcion").prop("readonly", false);
    $("#msgCodPol").html("");
  });

  $("#btnGuardar").on({
    click: function () {
      var id = $("#id").val();
      var opcion = "";
      $.Validar();

      if (Op_Vali === "Fail") {
        $.Alert(
          "#msgCodPol",
          "Por Favor Llene Los Campos Obligatorios...",
          "warning",
          "warning"
        );
        return;
      }

      Dat_Subfuente = [];

      $.Dta_Subfuentes();

      console.log(Dat_Subfuente);

      $("#msgCodPol").html("");
      if (id === "0") {
        opcion = "GUARDAR";
      } else {
        opcion = "MODIFICAR";
      }
      var datos = {
        nombre: $("#nombre").val(),
        descripcion: $("#descripcion").val(),
        id: id,
        opcion: opcion,
        Dat_Subfuente: Dat_Subfuente,
      };
      $.ajax({
        type: "POST",
        url: "../Administracion/GuardarFuentes.php",
        data: datos,
        success: function (data) {
          if ($.trim(data) === "bien") {
            $.Alert(
              "#msgCodPol",
              "Datos Guardados Exitosamente...",
              "success",
              "check"
            );
            $.Fuentes();
            $("#nombre").val("");
            $("#descripcion").val("");
          }
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
  });

  $("#tab_Fuen").on("click", ".btnVer", function (e) {
    e.preventDefault();
    var fila = $(this).parents("tr");
    $("#id").val(fila.data("id"));
    $("#nombre").val(fila.data("nombre"));
    $("#descripcion").val(fila.data("descripcion"));
    $("#modalFuentes").modal({ backdrop: "static", keyboard: false });
    $("#btnGuardar").css("display", "none");
    $("#nombre").prop("readonly", true);
    $("#descripcion").prop("readonly", true);
    $("#nombre,#descripcion").css("background-color", "white");
    $("#From_Nombre").removeClass("has-error");
    $("#From_Descripcion").removeClass("has-error");
    $("#msgCodPol").html("");
  });
  $("#tab_Fuen").on("click", ".btnEditar", function (e) {
    e.preventDefault();
    var fila = $(this).parents("tr");
    let idf = fila.data("id");
    $("#id").val(idf);
    $("#nombre").val(fila.data("nombre"));
    $("#descripcion").val(fila.data("descripcion"));
    $("#modalFuentes").modal({ backdrop: "static", keyboard: false });
    $("#btnGuardar").css("display", "inline-block");
    $("#nombre").prop("readonly", false);
    $("#descripcion").prop("readonly", false);
    $("#nombre,#descripcion").css("background-color", "white");
    $("#From_Nombre").removeClass("has-error");
    $("#From_Descripcion").removeClass("has-error");
    $("#msgCodPol").html("");

    //MOSTRAR SUBFUENTES

    var datos = {
      ope: "cargarSubFuentes",
      idf: idf,
    };

    $.ajax({
      async: false,
      type: "POST",
      url: "../All.php",
      data: datos,
      dataType: "JSON",
      success: function (data) {
        $("#tb_Subfuente").html(data["Tab_Subfuente"]);
        $("#contSubfuentes").val(data["contSubfuentes"]);
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });
  $("#tab_Fuen").on("click", ".btnEliminar", function (e) {
    e.preventDefault();
    var fila = $(this).parents("tr");
    if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
      opcion = "ELIMINAR";
      var datos = {
        id: fila.data("id"),
        opcion: opcion,
      };
      $.ajax({
        type: "POST",
        url: "../Administracion/GuardarFuentes.php",
        data: datos,
        success: function (data) {
          if (data === "bien") {
            $.Alert(
              "#msg2",
              "Operación Realizada Exitosamente...",
              "success",
              "check"
            );
            $.Fuentes();
          } else if (data === "nbien") {
            $.Alert(
              "#msg2",
              "Esta Fuente no se puede Eliminar",
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
  });
});
