$(document).ready(function () {
  var Order = "b.nom_proyect ASC";
  // $("#fecha").inputmask("d/m/y", {autoUnmask: true});
  $("#home").removeClass("start active open");
  $("#menu_p_proy").addClass("start active open");
  $("#menu_p_proy_ges").addClass("active");

  $("#txt_fecha_Cre, #txt_FecEst, #txt_Fecini, #txt_FecAproProAso").datepicker({
    format: "dd-mm-yyyy",
    autoclose: true,
    todayBtn: "linked",
    todayHighlight: true,
    language: "es",
  });

  $("#txt_fecha_ComPre,#txt_fecha,#txt_FeciniProy, #txt_FecFinProy").datepicker(
    {
      format: "yyyy-mm-dd",
      autoclose: true,
      todayBtn: "linked",
      todayHighlight: true,
      language: "es",
    }
  );

  $("#CbVige,#CbFase").datepicker({
    autoclose: true,
    format: " yyyy",
    viewMode: "years",
    minViewMode: "years",
  });

  $("#txt_fecha_Ini,#txt_fecha_Fin").datetimepicker({
    isRTL: App.isRTL(),
    format: "dd-mm-yyyy - HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickerPosition: App.isRTL() ? "bottom-right" : "bottom-left",
    todayBtn: true,
    language: "es",
  });

  $(
    "#CbGenero,#CbEdad,#CbGrupEtn,#txt_UnMed,#CbEstImg,#CbEstado,#Cbx_cargoCost,#CbDenom,#CbOriFinancia, #CbOriPres, #CbCrono, #CbFasesProy, #CbVigPres, #CbMetProd, #CbFaseProy, #CbEstadoAct, #CbFreMed, #CbTipInd"
  ).selectpicker();

  $("#Cbx_Indicadores").select2({
    placeholder: " -- Seleccione Un Indicador --",
    tags: true,
    width: "100%",
    tokenSeparators: [",", " "],
  });

  CKEDITOR.editorConfig = function (config) {
    config.toolbarGroups = [
      { name: "styles", groups: ["styles"] },
      { name: "clipboard", groups: ["clipboard", "undo"] },
      {
        name: "editing",
        groups: ["selection", "find", "spellchecker", "editing"],
      },
      { name: "forms", groups: ["forms"] },
      { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
      {
        name: "paragraph",
        groups: ["list", "indent", "blocks", "align", "bidi", "paragraph"],
      },
      { name: "links", groups: ["links"] },
      { name: "insert", groups: ["insert"] },
      { name: "colors", groups: ["colors"] },
      { name: "tools", groups: ["tools"] },
      { name: "document", groups: ["doctools", "mode", "document"] },
      { name: "others", groups: ["others"] },
      { name: "about", groups: ["about"] },
    ];

    config.removeButtons =
      "Source,Save,NewPage,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,Smiley,PageBreak,Iframe,ShowBlocks,About,Styles,Format";
  };

  var Datos, Op_Save, Id;
  Datos = "";
  Op_Save = "New";
  Id = " ";
  var X = 0;
  var Op_Edit = "New";
  var Id_Tr = "";
  var Dat_Table = "";
  var Order;
  //Order = " A.id_contra DESC";
  var Url = "Prorroga.jsp";
  var Op_Validar = [];
  var Vali = [];
  var Op_Vali = "Ok";
  var Op_Anx = "Fail";
  var List_Doc = [];
  var Op_Anx = "New";
  Op_Anx = "New";
  var Op_Url = "";
  var contCaus = 0;
  var contEfect = 0;
  var contObjet = 0;
  var contProd = 0;
  var contPobla = 0;
  var contCostosAsoc = 0;
  var contEstudios = 0;
  var contActivi = 0;
  var contLocalizacion = 0;
  var contIndicad = 0;
  var contFinancia = 0;
  var contPresup = 0;
  var contIngPres = 0;
  var contAnexo = 0;

  var PreTotal = 0;

  var contImg = 0;
  var Dat_Img = [];
  var Dat_Usu = [];
  var Dat_Metas = [];
  var Dat_MetasP = [];
  ///
  var Dat_Causas = [];
  var Dat_Efectos = [];
  var Dat_ObjEspec = [];
  var Dat_Productos = [];
  var Dat_PobObjet = [];
  var Dat_CostAsoc = [];
  var Dat_Estudios = [];
  var Dat_Localiza = [];
  var Dat_Actividades = [];
  var Dat_Indicadores = [];
  var Dat_Financiacion = [];
  var Dat_Presupuesto = [];
  var Dat_Anexos = [];
  var Dat_Ingresos = [];

  ///////////////////////CARGAR MUNICIPIOS:
  $.extend({
    Proyectos: function () {
      var datos = {
        opc: "CargDependencia",
        pag: "1",
        op: "1",
        bus: "",
        rus: "n",
        nreg: $("#nreg").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagProyectos.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Proyect").html(data["cad"]);
          $("#bot_Proyect").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    habilitarPresupuesto: function (val) {
      if (val == "Priorizado" || val == "En Ejecucion" || val == "Ejecutado") {
        $("#div-presupuesto").show();
      } else {
        $("#div-presupuesto").hide();
      }
    },
    busqProyect: function (val) {
      var datos = {
        opc: "BusqDepe",
        bus: val,
        pag: "1",
        op: "1",
        nreg: $("#nreg").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagProyectos.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Proyect").html(data["cad"]);
          $("#bot_Proyect").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    Hab_Editores: function () {
      CKEDITOR.replace("txt_IdProblema", {
        width: "100%",
        height: 300,
      });

      CKEDITOR.replace("txt_DesProy", {
        width: "100%",
        height: 300,
      });
    },

    busqMetas: function () {
      var eje = $("#CbEjes").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategias").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramas").val();
      if (prog === null) {
        prog = "";
      }

      var datos = {
        opc: "BusqDepe",
        eje: eje,
        comp: estr,
        prog: prog,
        pag: "1",
        op: "1",
        nreg: $("#nregVentMet").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVent.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Vent").html(data["cad"]);
          $("#bot_Vent").html(data["cad2"]);
          $("#cobpagVentMet").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    busqMetasP: function () {
      var eje = $("#CbEjesP").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategiasP").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramasP").val();
      if (prog === null) {
        prog = "";
      }

      var datos = {
        opc: "BusqDepe",
        eje: eje,
        comp: estr,
        prog: prog,
        pag: "1",
        op: "1",
        nreg: $("#nregVentMetP").val(),
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVentP.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_VentP").html(data["cad"]);
          $("#bot_VentP").html(data["cad2"]);
          $("#cobpagVentMetP").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    quitarDoc: function () {
      $("#Src_FileComp").val("");
    },
    editProy: function (cod) {
      $("#acc").val("2");
      $("#botones").show();
      $("#btn_nuevo2").prop("disabled", true);
      $("#btn_guardar").prop("disabled", false);

      for (name in CKEDITOR.instances) {
        CKEDITOR.instances[name].destroy(true);
      }

      $.Hab_Editores();

      var datos = {
        ope: "BusqEditProyecto",
        cod: cod,
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        async: false,
        success: function (data) {
          $("#txt_id").val(cod);
          $("#txt_Cod").val(data["cod_proyect"]);
          var parfecre = data["fcrea_proyect"].split("-");

          $("#txt_fecha_Cre").val(
            parfecre[2] + "-" + parfecre[1] + "-" + parfecre[0]
          );
          var parfecre = data["fulmod_proyect"].split("-");
          $("#txt_fecMod").val(
            parfecre[2] + "-" + parfecre[1] + "-" + parfecre[0]
          );
          $("#txt_Nomb").val(data["nom_proyect"]);
          $("#CbTiplog").val(data["tipo_proyect"]).change();

          $("#CbSecre").val(data["secretaria_proyect"]).change();

          $("#CbCrono").selectpicker("val", data["cron_proyect"]);

          $("#CbVige").val(data["vigenc_proyect"]);
          $("#CbEstado").selectpicker("val", data["estado_proyect"]);

          if (
            data["estado_proyect"] == "Priorizado" ||
            data["estado_proyect"] == "En Ejecucion" ||
            data["estado_proyect"] == "Ejecutado"
          ) {
            $("#div-presupuesto").show();
          } else {
            $("#div-presupuesto").hide();
          }

          $("#txt_CodProyAs").val(data["codproyasoc_proyect"]);
          $("#txt_NombProyAs").val(data["desproyasoc_proyect"]);

          $("#txt_DesProy").val(data["desc_proyect"]);
          $("#txt_FecAproProAso").val(data["frso_proyeasoc"]);
          $("#txt_Fecini").val(data["fecha_iniproyaso"]);
          $("#txt_Plazo").val(data["plazo_ejeproyeaso"]);
          $("#txt_vigenc").val(data["vigenc_proyeaso"]);
          $("#txt_estaProye").val(data["estado_proyeaso"]);

          $("#txt_estaProye").val(data["comp_pres"]);
          if (data["comp_pres"] === "si") {
            $("#sel1ComPre").prop("checked", true);
          } else {
            $("#sel1ComPre").prop("checked", false);
          }

          $("#txt_fecha_ComPre").val(data["fcomp_pres"]);
          $("#Src_FileComp").val(data["docucomp_pres"]);
          if (data["docucomp_pres"] === "" || data["docucomp_pres"] === null) {
            $("#MostDocComp").hide();
          } else {
            $("#MostDocComp").show();
          }

          $("#txt_elabo").val(data["elab_proyect"]);

          $("#txt_FeciniProy").val(data["finiproy"]);
          $("#txt_FecFinProy").val(data["ffinproy"]);

          $("#txt_IdProblema").val(data["idenproble_proyect"]);

          $("#txt_ObjGenr").val(data["objgen_proyect"]);
          $("#txt_DesProy").val(data["desc_proyect"]);

          $("#tb_Causas").html(data["Tab_Causa"]);
          $("#contCausas").val(data["contCaus"]);
          //
          $("#tb_Efect").html(data["Tab_Efectos"]);
          $("#contEfect").val(data["contEfectos"]);
          //
          $("#tb_Objet").html(data["Tab_ObjEspec"]);
          $("#contObjet").val(data["contObjEspec"]);
          //
          $("#tb_Product").html(data["Tab_Productos"]);
          $("#contProd").val(data["contProductos"]);
          //
          $("#tb_Pobla").html(data["Tab_Poblacion"]);
          $("#contPobla").val(data["contPoblacion"]);
          //
          $("#tb_CostosAsoc").html(data["Tab_CostAsoc"]);
          $("#contCostosAsoc").val(data["contCostAsoc"]);
          //
          $("#tb_Estudios").html(data["Tab_Estudios"]);
          $("#contEstudios").val(data["contEstudios"]);
          //
          $("#tb_Localiza").html(data["Tab_Locali"]);
          $("#contLocalizacion").val(data["contLocal"]);
          //
          $("#tb_Activ").html(data["Tab_Activ"]);
          $("#contActivi").val(data["contActiv"]);
          $("#txt_costActTotal").val(data["totcost"]);
          //
          $("#tb_Metas").html(data["Tab_Meta"]);
          $("#contMetas").val(data["contMeta"]);
          //
          $("#tb_MetasP").html(data["Tab_MetaP"]);
          $("#contMetasP").val(data["contMetaP"]);
          //
          $("#tb_Financia").html(data["Tab_Financia"]);
          $("#contFinancia").val(data["contFinancia"]);
          $("#txt_FinanciaTotal").val(data["TotFinancia"]);
          //
          $("#tb_Presup").html(data["Tab_Presupuesto"]);
          PreTotal = data["Total"];
          $("#gtotalPresTota").html(formatCurrency(PreTotal, "es-CO", "COP"));
          $("#contPresup").val(data["contPresupuesto"]);

          //
          $("#tb_Ingresos").html(data["Tab_Ingresos"]);
          $("#contIngPres").val(data["contIngresos"]);
          //
          $("#tb_Anexo").html(data["Tab_Anexos"]);
          $("#contAnexo").val(data["contAnexos"]);

          $("#tb_Galeria").html(data["Tab_Img"]);
          $("#contImg").val(data["contImg"]);

          $("#tb_Usuarios").html(data["Tab_Usu"]);
          $("#contUsua").val(data["contUsu"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });

      $("#tab_01").removeClass("active in");
      $("#tab_01_pp").removeClass("active in");
      $("#tab_02").addClass("active in");
      $("#tab_02_pp").addClass("active in");
      $("#atitulo")
        .show(100)
        .html(
          "<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Proyecto</a>"
        );
    },
    VerProy: function (cod) {
      // $("#btn_nuevo2").prop('disabled', true);
      $("#btn_guardar").prop("disabled", true);

      $.Hab_Editores();
      var datos = {
        ope: "BusqEditProyecto",
        cod: cod,
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#txt_id").val(cod);
          $("#txt_Cod").val(data["cod_proyect"]);
          var parfecre = data["fcrea_proyect"].split("-");

          $("#txt_fecha_Cre").val(
            parfecre[2] + "-" + parfecre[1] + "-" + parfecre[0]
          );
          var parfecre = data["fulmod_proyect"].split("-");
          $("#txt_fecMod").val(
            parfecre[2] + "-" + parfecre[1] + "-" + parfecre[0]
          );
          $("#txt_Nomb").val(data["nom_proyect"]);
          $("#CbTiplog").val(data["tipo_proyect"]).change();

          $("#CbSecre").val(data["secretaria_proyect"]).change();

          $("#CbCrono").selectpicker("val", data["cron_proyect"]);

          $("#CbVige").val(data["vigenc_proyect"]);
          $("#CbEstado").selectpicker("val", data["estado_proyect"]);

          $("#txt_CodProyAs").val(data["codproyasoc_proyect"]);
          $("#txt_NombProyAs").val(data["desproyasoc_proyect"]);

          $("#txt_DesProy").val(data["desc_proyect"]);
          $("#txt_FecAproProAso").val(data["frso_proyeasoc"]);
          $("#txt_Fecini").val(data["fecha_iniproyaso"]);
          $("#txt_Plazo").val(data["plazo_ejeproyeaso"]);
          $("#txt_vigenc").val(data["vigenc_proyeaso"]);
          $("#txt_estaProye").val(data["estado_proyeaso"]);

          $("#txt_estaProye").val(data["comp_pres"]);
          if (data["comp_pres"] === "si") {
            $("#sel1ComPre").prop("checked", true);
          } else {
            $("#sel1ComPre").prop("checked", false);
          }

          $("#txt_fecha_ComPre").val(data["fcomp_pres"]);
          $("#Src_FileComp").val(data["docucomp_pres"]);
          if (data["docucomp_pres"] === "" || data["docucomp_pres"] === null) {
            $("#MostDocComp").hide();
          } else {
            $("#MostDocComp").show();
          }

          $("#txt_elabo").val(data["elab_proyect"]);

          $("#txt_FeciniProy").val(data["finiproy"]);
          $("#txt_FecFinProy").val(data["ffinproy"]);

          $("#txt_IdProblema").val(data["idenproble_proyect"]);

          $("#txt_ObjGenr").val(data["objgen_proyect"]);
          $("#txt_DesProy").val(data["desc_proyect"]);

          $("#tb_Causas").html(data["Tab_Causa"]);
          $("#contCausas").val(data["contCaus"]);
          //
          $("#tb_Efect").html(data["Tab_Efectos"]);
          $("#contEfect").val(data["contEfectos"]);
          //
          $("#tb_Objet").html(data["Tab_ObjEspec"]);
          $("#contObjet").val(data["contObjEspec"]);
          //
          $("#tb_Product").html(data["Tab_Productos"]);
          $("#contProd").val(data["contProductos"]);
          //
          $("#tb_Pobla").html(data["Tab_Poblacion"]);
          $("#contPobla").val(data["contPoblacion"]);
          //
          $("#tb_CostosAsoc").html(data["Tab_CostAsoc"]);
          $("#contCostosAsoc").val(data["contCostAsoc"]);
          //
          $("#tb_Estudios").html(data["Tab_Estudios"]);
          $("#contEstudios").val(data["contEstudios"]);
          //
          $("#tb_Localiza").html(data["Tab_Locali"]);
          $("#contLocalizacion").val(data["contLocal"]);
          //
          $("#tb_Activ").html(data["Tab_Activ"]);
          $("#contActivi").val(data["contActiv"]);
          $("#txt_costActTotal").val(data["totcost"]);
          //
          $("#tb_Metas").html(data["Tab_Meta"]);
          $("#contMetas").val(data["contMeta"]);
          //
          $("#tb_MetasP").html(data["Tab_MetaP"]);
          $("#contMetasP").val(data["contMetaP"]);
          //
          $("#tb_Financia").html(data["Tab_Financia"]);
          $("#contFinancia").val(data["contFinancia"]);
          $("#txt_FinanciaTotal").val(data["TotFinancia"]);
          //
          $("#tb_Presup").html(data["Tab_Presupuesto"]);
          PreTotal = data["Total"];
          $("#gtotalPresTota").html(formatCurrency(PreTotal, "es-CO", "COP"));
          $("#contPresup").val(data["contPresupuesto"]);
          //
          $("#tb_Ingresos").html(data["Tab_Ingresos"]);
          $("#contIngPres").val(data["contIngresos"]);
          //
          $("#tb_Anexo").html(data["Tab_Anexos"]);
          $("#contAnexo").val(data["contAnexos"]);

          $("#tb_Galeria").html(data["Tab_Img"]);
          $("#contImg").val(data["contImg"]);

          $("#tb_Usuarios").html(data["Tab_Usu"]);
          $("#contUsua").val(data["contUsu"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });

      $("#tab_01").removeClass("active in");
      $("#tab_01_pp").removeClass("active in");
      $("#tab_02").addClass("active in");
      $("#tab_02_pp").addClass("active in");
      $("#atitulo")
        .show(100)
        .html(
          "<a href='#tab_02' data-toggle='tab' id='atitulo'> Ver Proyecto </a>"
        );
    },
    deletProy: function (cod) {
      if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
        var datos = {
          acc: "3",
          cod: cod,
        };

        $.ajax({
          type: "POST",
          url: "../Proyecto/GuardarProyecto.php",
          data: datos,
          success: function (data) {
            var pares = data.split("/");
            if (trimAll(pares[0]) === "bien") {
              $.Alert(
                "#msg2",
                "Operación Realizada Exitosamente...",
                "success",
                "check"
              );
              $.Proyectos();
            } else if (trimAll(pares[0]) === "nobien") {
              $.Alert(
                "#msg2",
                "Este Proyecto esta asociado a un Contrato, Verifique...",
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
    paginador: function (pag, servel) {
      var datos = {
        pag: pag,
        bus: $("#busq_centro").val(),
        nreg: $("#nreg").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagProyectos.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Proyect").html(data["cad"]);
          $("#bot_Proyect").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    paginadorMet: function (pag, servel) {
      var eje = $("#CbEjes").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategias").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramas").val();
      if (prog === null) {
        prog = "";
      }
      var datos = {
        pag: pag,
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        nreg: $("#nregVentMet").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVent.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Vent").html(data["cad"]);
          $("#bot_Vent").html(data["cad2"]);
          $("#cobpagVentMet").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    paginadorMetP: function (pag, servel) {
      var eje = $("#CbEjesP").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategiasP").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramasP").val();
      if (prog === null) {
        prog = "";
      }
      var datos = {
        pag: pag,
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        nreg: $("#nregVentMetP").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVentP.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_VentP").html(data["cad"]);
          $("#bot_VentP").html(data["cad2"]);
          $("#cobpagVentMetP").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    combopag: function (pag, servel) {
      var datos = {
        pag: pag,
        bus: $("#busq_centro").val(),
        nreg: $("#nreg").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagProyectos.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Proyect").html(data["cad"]);
          $("#bot_Proyect").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    combopagMet: function (pag, servel) {
      var eje = $("#CbEjes").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategias").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramas").val();
      if (prog === null) {
        prog = "";
      }
      var datos = {
        pag: pag,
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        nreg: $("#nregVentMet").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVent.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Vent").html(data["cad"]);
          $("#bot_Vent").html(data["cad2"]);
          $("#cobpagVentMet").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    combopagMet: function (pag, servel) {
      var eje = $("#CbEjesP").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategiasP").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramasP").val();
      if (prog === null) {
        prog = "";
      }
      var datos = {
        pag: pag,
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        nreg: $("#nregVentMetP").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVentP.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_VentP").html(data["cad"]);
          $("#bot_VentP").html(data["cad2"]);
          $("#cobpagVentMetP").html(data["cbp"]);
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
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagProyectos.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Proyect").html(data["cad"]);
          $("#bot_Proyect").html(data["cad2"]);
          $("#cobpag").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    combopag2VentMet: function (nre) {
      var eje = $("#CbEjes").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategias").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramas").val();
      if (prog === null) {
        prog = "";
      }
      var datos = {
        nreg: nre,
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        pag: $("#selectpagMet").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVent.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Vent").html(data["cad"]);
          $("#bot_Vent").html(data["cad2"]);
          $("#cobpagVentMet").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    combopag2VentMetP: function (nre) {
      var eje = $("#CbEjesP").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategiasP").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramasP").val();
      if (prog === null) {
        prog = "";
      }
      var datos = {
        nreg: nre,
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        pag: $("#selectpagMetP").val(),
        ord: Order,
      };

      $.ajax({
        type: "POST",
        url: "../Paginadores/PagMetVentP.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_VentP").html(data["cad"]);
          $("#bot_VentP").html(data["cad2"]);
          $("#cobpagVentMetP").html(data["cbp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    AddAct: function () {
      var txt_Metas = $("#txt_Metas").val();
      var desAct = $("#txt_Actividad").val();
      var resp = $("#CbRespoAct option:selected").text();
      var Codresp = $("#CbRespoAct").val();
      var est = $("#CbEstadoAct").val();
      var cost = $("#txt_costAct").val();
      var paini = $("#txt_fecha_Ini").val().split(" - ");
      var fini = paini[0];
      var hini = paini[1];
      var pafin = $("#txt_fecha_Fin").val().split(" - ");
      var ffin = pafin[0];
      var hfin = pafin[1];

      contActivi = $("#contActivi").val();

      contActivi++;

      if (txt_Metas === "") {
        $.Alert("#msg", "Por Favor Ingresar la Meta...", "warning", "warning");
        $("#txt_Metas").focus();
        return;
      }
      if (desAct === "") {
        $.Alert(
          "#msg",
          "Por Favor Ingresar la Actividad...",
          "warning",
          "warning"
        );
        $("#txt_Actividad").focus();
        return;
      }
      if (Codresp === " ") {
        $.Alert(
          "#msg",
          "Por Favor Ingrese el Responsable...",
          "warning",
          "warning"
        );
        $("#CbRespoAct").focus();
        return;
      }
      if (paini === "") {
        $.Alert(
          "#msg",
          "Por Favor Ingrese la Fecha de Inicio...",
          "warning",
          "warning"
        );
        $("#txt_fecha_Ini").focus();
        return;
      }
      if (pafin === "") {
        $.Alert(
          "#msg",
          "Por Favor Ingrese la Fecha Final...",
          "warning",
          "warning"
        );
        $("#txt_fecha_Fin").focus();
        return;
      }

      var fila = '<tr class="selected" id="filaAct' + contActivi + '" >';

      var txt_cost = cost.split(" ");
      costo = parseFloat(
        txt_cost[1]
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
          .replace(",", ".")
      );
      costot = parseFloat($("#txt_costActTotal").val()) + costo;

      fila += "<td>" + contActivi + "</td>";
      fila += "<td>" + txt_Metas + "</td>";
      fila += "<td>" + desAct + "</td>";
      fila += "<td>" + resp + "</td>";
      fila += "<td>" + cost + "</td>";
      fila += "<td>" + est + "</td>";
      fila += "<td>" + fini + "</td>";
      fila += "<td>" + hini + "</td>";
      fila += "<td>" + ffin + "</td>";
      fila += "<td>" + hfin + "</td>";
      fila +=
        "<td><input type='hidden' id='Acti" +
        contActivi +
        "' name='actividades' value='" +
        txt_Metas +
        "//" +
        desAct +
        "//" +
        Codresp +
        "//" +
        costo +
        "//" +
        fini +
        "//" +
        hini +
        "//" +
        ffin +
        "//" +
        hfin +
        "//" +
        est +
        "' /><a onclick=\"$.QuitarActi('filaAct" +
        contActivi +
        "//" +
        cost +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Borrar</a></td></tr>';
      $("#tb_Activ").append(fila);
      $.reordenarAct();
      $.limpiarAct();
      $("#contActivi").val(contActivi);

      $("#txt_costActTotal").val(costot);
      $("#gtotalCostosAct").html("$ " + number_format2(costot, 2, ",", "."));
    },
    AddLocalizacion: function () {
      var CodDepa = $("#CbDepa").val();
      var DesDepa = $("#CbDepa option:selected").text();
      var CodMun = $("#CbMun").val();
      var DesMun = $("#CbMun option:selected").text();
      var CodCor = $("#CbCorre").val();
      var DesCor = $("#CbCorre option:selected").text();
      var OtrUbi = $("#txt_OtraUbi").val();

      var lat = $("#lat").val();
      var long = $("#long").val();

      contLocalizacion = $("#contLocalizacion").val();

      contLocalizacion++;
      var fila = '<tr class="selected" id="filaLoca' + contLocalizacion + '" >';

      fila += "<td>" + contLocalizacion + "</td>";
      fila += "<td>" + DesDepa + "</td>";
      fila += "<td>" + DesMun + "</td>";
      fila += "<td>" + DesCor + "</td>";
      fila += "<td>" + OtrUbi + "</td>";
      fila +=
        "<td><input type='hidden' id='Loca" +
        contLocalizacion +
        "' name='Localiza' value='" +
        CodDepa +
        "//" +
        CodMun +
        "//" +
        CodCor +
        "//" +
        OtrUbi +
        "//" +
        lat +
        "//" +
        long +
        "' />\n\
<a onclick=\"$.QuitarLocal('filaLoca" +
        contLocalizacion +
        '\')" class="btn default btn-xs red"><i class="fa fa-trash-o"></i> Borrar</a>\n\
<a onclick="$.VerLoca(\'' +
        lat +
        "//" +
        long +
        '\')" class="btn default btn-xs blue"><i class="fa fa-map-marker"></i> Mostrar</a>\n\
</td></tr>';
      $("#tb_Localiza").append(fila);
      $.reordenarLocal();
      $.limpiarLoca();
      $("#contLocalizacion").val(contLocalizacion);
    },
    reordenarAct: function () {
      var num = 1;
      $("#tb_Activ tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });

      num = 1;
      $("#tb_Activ tbody input").each(function () {
        $(this).attr("id", "Acti" + num);
        num++;
      });
    },
    reordenarLocal: function () {
      var num = 1;
      $("#tb_Localiza tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });

      num = 1;
      $("#tb_Localiza tbody input").each(function () {
        $(this).attr("id", "Loca" + num);
        num++;
      });
    },
    VerLoca: function (dir) {
      parlatlog = dir.split("//");
      $("#lat").val(parlatlog[0]);
      $("#long").val(parlatlog[1]);
      initialize();
    },
    QuitarActi: function (id_fila) {
      var par_Act = id_fila.split("//");
      $("#" + par_Act[0]).remove();
      $.reordenarAct();
      contActivi = $("#contActivi").val();
      contActivi = contActivi - 1;
      $("#contActivi").val(contActivi);
      var txt_cost = par_Act[1].split(" ");

      //            alert($("#txt_costActTotal").val() + "-" + txt_cost[1]);

      costo =
        parseFloat($("#txt_costActTotal").val()) -
        parseFloat(
          txt_cost[1].replace(".", "").replace(".", "").replace(",", ".")
        );
      $("#txt_costActTotal").val(costo);
      $("#gtotalCostosAct").html("$ " + number_format2(costo, 2, ",", "."));
    },
    QuitarLocal: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarLocal();
      contLocalizacion = $("#contLocalizacion").val();
      contLocalizacion = contLocalizacion - 1;
      $("#contLocalizacion").val(contLocalizacion);
    },
    CargaTodBanProy: function () {
      var datos = {
        ope: "CargaTodProy",
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbTiplog").html(data["Tipolog"]);
          $("#CbOriFinancia").html(data["fFin"]);
          $("#CbSecre").html(data["Secre"]);
          $("#CbRespoAct").html(data["Respons"]);
          $("#CbDepa").html(data["dpto"]);
          $("#CbBarrio").html(data["barrio"]);
          $("#CbUsuarios").html(data["usuarios"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    addProy: function () {
      if ($("#perm").val() === "n") {
        $("#botones").hide();
        $.Alert(
          "#msg",
          "No Tiene permisos para Crear Proyectos",
          "warning",
          "warning"
        );
      } else {
        $.conse();
        $.CargUbica();
        $.CargUsuarios();
        $.Hab_Editores();
      }
    },
    CargUbica: function () {
      var datos = {
        ope: "CargUbica",
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tb_Localiza").html(data["Tab_Locali"]);
          $("#contLocalizacion").val(data["contLocal"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    CargUsuarios: function () {
      var datos = {
        ope: "CargUsuarios",
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tb_Usuarios").html(data["Tab_Usu"]);
          $("#contUsua").val(data["contUsu"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    conse: function () {
      var text = $("#atitulo").text();

      if (text === "Crear Proyecto") {
        var datos = {
          ope: "ConConsecutivo",
          tco: "PROYECTOS",
        };

        $.ajax({
          type: "POST",
          url: "../All.php",
          data: datos,
          dataType: "JSON",
          success: function (data) {
            if (data["flag"] === "n") {
              $("#botones").hide();
              $.Alert(
                "#msg",
                "No se Puede Realizar la Operación... No se creado un Consecutivo para los Proyectos. Verifique...",
                "warning",
                "warning"
              );
            } else {
              $("#txt_Cod").val(data["StrAct"]);
              $("#cons").val(data["cons"]);
              $("#botones").show();
            }
          },
          error: function (error_messages) {
            alert("HA OCURRIDO UN ERROR");
          },
        });
      }
    },
    BusMun: function (val) {
      initialize();
      var datos = {
        ope: "cargaMun",
        cod: val,
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbMun").html(data["mun"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#CbMun").prop("disabled", false);
      if ($("#CbDepa option:selected").text() !== "Seleccione...") {
        var adress = $("#CbDepa option:selected").text().split(" - ");
        codeAddress("COLOMBIA, " + adress[1]);
      }
    },
    BusCorr: function (val) {
      var datos = {
        ope: "BusCorr",
        cod: val,
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbCorre").html(data["corr"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });

      if ($("#CbMun option:selected").text() !== "N/A") {
        if ($("#CbMun option:selected").text() !== "Seleccione...") {
          var adressDep = $("#CbDepa option:selected").text().split(" - ");
          var adressMun = $("#CbMun option:selected").text().split(" - ");
          codeAddress("COLOMBIA, " + adressDep[1] + ", " + adressMun[1]);
        }
      }

      $("#CbCorre").prop("disabled", false);
    },
    BusUbiCor: function () {
      if ($("#CbCorre option:selected").text() !== "N/A") {
        if ($("#CbCorre option:selected").text() !== "Seleccione...") {
          var adressDep = $("#CbDepa option:selected").text().split(" - ");
          var adressMun = $("#CbMun option:selected").text().split(" - ");
          var adressCor = $("#CbCorre option:selected").text().split(" - ");
          codeAddress(
            "COLOMBIA, " +
              adressDep[1] +
              ", " +
              adressMun[1] +
              ", " +
              adressCor[1]
          );
        }

        //                if ($('#CbCorre option:selected').text() === "20001000 - VALLEDUPAR") {
        //                    $("#CbBarrio").prop('disabled', false);
        //                }
      }
    },
    BusUbiBar: function (val) {
      var adressDep = $("#CbDepa option:selected").text().split(" - ");
      var adressMun = $("#CbMun option:selected").text().split(" - ");
      var adressCor = $("#CbCorre option:selected").text().split(" - ");
      codeAddress(
        "COLOMBIA, " +
          adressDep[1] +
          ", " +
          adressMun[1] +
          ", " +
          adressCor[1] +
          ", " +
          val
      );
    },
    busAct: function () {
      var datos = {
        ope: "VentActividades",
        tac: "ETAPA PREPARATIVA",
        bus: "",
      };

      $.ajax({
        type: "POST",
        url: "../All",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Actividades").show(100).html(data["tabla_actividades"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#responsiveAct").modal();
      //  $('#mopc').hide();
    },
    NewRespon: function () {
      window.open("../Administracion/GestionResponsable.php", "_blank");
    },
    UpdateRespon: function () {
      $.CargResponsables();
    },
    CargResponsables: function (op) {
      var datos = {
        ope: "CargRespo",
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbRespoAct").html(data["resp"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    cargDatResp: function (id) {
      var datos = {
        ope: "cargDatResp",
        id: id,
      };
      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#txt_DepResp").val(data["dep"]);
          $("#txt_CorrResp").val(data["email"]);
          $("#txt_TelResp").val(data["tel"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    busqActi: function (val) {
      var datos = {
        ope: "VentActividades",
        tac: "ETAPA PREPARATIVA",
        bus: val,
      };

      $.ajax({
        type: "POST",
        url: "../All",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#tab_Actividades").show(100).html(data["tabla_actividades"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    SelActividad: function (val) {
      var par = val.split("//");
      $("#txt_id_Act").val(par[0]);
      $("#txt_cod_Act").val(par[1]);
      $("#txt_DAct").val(par[2]);
      $("#responsiveAct").modal("toggle");
    },
    limpiarLoca: function () {
      $("#lat").val("");
      $("#long").val("");
      $("#CbDepa").select2("val", " ");
      $("#CbMun").select2("val", " ");
      $("#CbCorre").select2("val", " ");
      $("#CbBarrio").select2("val", " ");
    },
    limpiarAct: function () {
      $("#txt_Metas").val("");
      $("#txt_Actividad").val("");
      $("#txt_fecha_Ini").val("");
      $("#txt_fecha_Fin").val("");
      $("#txt_costAct").val("$ 0,00");
      $("#CbRespAct").select2("val", " ");
      $("#CbEstadoAct").selectpicker("val", " ");
    },
    Load_Documentos: function () {
      var Datos = "";
      Datos += "" + "&ope=Load_Anexos";
      $.ajax({
        type: "POST",
        url: "../All",
        data: Datos,
        dataType: "json",
        success: function (data) {
          if (data["Salida"] == 1) {
            var Selec =
              "<option value=' '> -- Seleccione Un Documento -- </option>";
            $("#Cbx_Documento").html("");
            $("#Cbx_Documento").html(Selec + data["Data"]);
            $("#Cbx_Documento").select2("val", " ");
          }
          if (data["Salida"] == 2) {
            alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
            window.location.href = "../Logout";
          }
          if (data["Salida"] == 3) {
            alert("Ha Ocurrido un Error..." + JSON.stringify(data));
          }
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },
    Load_Anexos: function () {
      var Datos = "";
      Datos += "" + "&Opcion=Load_Anexos";
      $.ajax({
        type: "POST",
        url: "../Funciones_Prorroga",
        data: Datos,
        dataType: "json",
        success: function (data) {
          if (data["Salida"] == 1) {
            var Selec =
              "<option value=' '> -- Seleccione Un Documento -- </option>";
            $("#Cbx_Documento").html("");
            $("#Cbx_Documento").html(Selec + data["Data"]);
            $("#Cbx_Documento").select2("val", " ");

            $(".Cbx_Documento").html("");
            $(".Cbx_Documento").html(Selec + data["Data"]);
            $(".Cbx_Documento").select2("val", " ");
          }
          if (data["Salida"] == 2) {
            alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
            window.location.href = "../Logout";
          }
          if (data["Salida"] == 3) {
            alert("Ha Ocurrido un Error..." + JSON.stringify(data));
          }
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },

    AddGaleria: function () {
      if ($("#archivosGale").val() === "") {
        $.Alert(
          "#msg",
          "Por Favor Seleccione la Imagen a Cargar...",
          "warning"
        );
        return;
      } else if ($("#CbEstImg").val() === " ") {
        $.Alert(
          "#msg",
          "Por Favor Seleccione el destino de las Imagenes...",
          "warning"
        );
        return;
      } else {
        var archivos = document.getElementById("archivosGale"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
        var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
        //Creamos una instancia del Objeto FormDara.
        var archivos = new FormData();
        /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
                 Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
                 indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
        for (i = 0; i < archivo.length; i++) {
          archivos.append("archivosGale" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
        }

        var ruta = "../Proyecto/upload_img_proyect.php";
        $.ajax({
          url: ruta,
          type: "POST",
          data: archivos,
          contentType: false,
          processData: false,
          success: function (datos) {
            $.AddTabla(datos);
          },
        });
      }
    },
    AddTabla: function (dat) {
      var CbEstImg = $("#CbEstImg").val();
      contImg = $("#contImg").val();
      var txt_fecha = $("#txt_fecha").val();

      var Result = dat.split("//");
      for (i = 0; i < Result.length; i++) {
        contImg++;
        var fila = '<tr class="selected" id="filaImg' + contImg + '" >';
        var pararc = Result[i].split("*");
        fila += "<td>" + contImg + "</td>";
        fila += "<td>" + pararc[0] + "</td>";
        fila += "<td>" + CbEstImg + "</td>";
        fila += "<td>" + txt_fecha + "</td>";
        fila +=
          "<td><input type='hidden' id='idImg" +
          contImg +
          "' name='terce' value='" +
          CbEstImg +
          "//" +
          pararc[0] +
          "//" +
          pararc[1] +
          "//" +
          txt_fecha +
          "' />\n\
                    <a onclick=\"$.QuitarImg('filaImg" +
          contImg +
          '\')" class="btn default btn-xs red"><i class="fa fa-trash-o"></i> Quitar</a>\n\
                    <a onclick="$.VerImg(\'../Proyecto/GaleriaProyecto/' +
          pararc[0] +
          "*" +
          pararc[1] +
          '\')" class="btn default btn-xs blue"><i class="fa fa-search"></i> Ver</a>\n\
                    </td></tr>';
        $("#tb_Galeria").append(fila);
        $.reordenarImg();
        $("#contImg").val(contImg);

        $("#CbEstImg").selectpicker("val", " ");
        $("#archivosGale").val("");
        $("#vista-previa").html("");
      }
    },
    reordenarImg: function () {
      var num = 1;
      $("#tb_Galeria tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Galeria tbody input").each(function () {
        $(this).attr("id", "idImg" + num);
        num++;
      });
    },
    QuitarImg: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarImg();
      contImg = $("#contImg").val();
      contImg = contImg - 1;
      $("#contImg").val(contImg);
    },
    VerImg: function (img) {
      $("#contenedor img").attr("src", "");
      parimg = img.split("*");
      formimg = parimg[1];
      if (formimg.indexOf("/") !== -1) {
        parformimg = formimg.split("/");
        formimg = parformimg[0];
      }
      if (formimg === "image") {
        $("#contenedor img").attr("src", parimg[0]);
        $("#responsiveImg").modal();
      } else {
        window.open("../Proyecto/" + parimg[0], "_blank");
      }
    },
    UploadDoc: function () {
      var archivos = document.getElementById("archivos"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
      var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
      //Creamos una instancia del Objeto FormDara.
      var archivos = new FormData();
      /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
      for (i = 0; i < archivo.length; i++) {
        archivos.append("archivo" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
      }

      var ruta = "../Proyecto/upload.php";

      $.ajax({
        async: false,
        url: ruta,
        type: "POST",
        data: archivos,
        contentType: false,
        processData: false,
        success: function (datos) {
          var par_res = datos.split("//");
          if (par_res[0] === "Bien") {
            $("#Src_File").val(par_res[1].trim());
          } else if (par_res[0] === "Mal") {
            $.Alert(
              "#msgArch",
              "El archivo no se Puede Agregar debido al siguiente Error:"
                .par_res[1],
              "warning"
            );
          }
        },
      });
    },
    Format_Bytes: function (bytes, decimals) {
      if (bytes == 0) return "0 Byte";
      var k = 1024;
      var dm = decimals + 1 || 3;
      var sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
      var i = Math.floor(Math.log(bytes) / Math.log(k));
      return (bytes / Math.pow(k, i)).toPrecision(dm) + " " + sizes[i];
    },
    Obtener_Paginas: function () {
      var Datos = "&Opcion=Num_Pag" + "&Src_Doc=" + $("#Src_File").val();
      $.ajax({
        async: false,
        type: "POST",
        url: "../Funciones_Prorroga",
        data: Datos,
        dataType: "json",
        success: function (data) {
          if (data["Salida"] == 1) {
            Op_Cargar_Doc = "SI";
            var Selec =
              "<option value=' '> -- Seleccione Una Pagina -- </option><option value='*'> Todas </option>";
            $("#Total_Pag").val(data["Total_Pag"]);
            $("#N_Pag").html("");
            $("#N_Pag").html(Selec + data["Data"]);
            $("#N_Pag").select2("val", " ");

            $.Rename_File();
          }
          if (data["Salida"] == 2) {
            alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
            window.location.href = "../Logout";
          }
          if (data["Salida"] == 3) {
            alert("Ha Ocurrido un Error..." + JSON.stringify(data));
          }
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },
    Rename_File: function () {
      var Datos =
        "&Opcion=Rename_File" +
        "&Src_Doc=" +
        $("#Src_File").val() +
        "&New_Name_File=" +
        $("#New_Name_File").val() +
        "&Name_File=" +
        $("#Name_File").val();
      $.ajax({
        async: false,
        type: "POST",
        url: "../Funciones_Prorroga",
        data: Datos,
        dataType: "json",
        success: function (data) {
          if (data["Salida"] == 1) {
            $("#Src_File").val(data["New_Name_File"].trim());
            var Doc = {
              Name: $("#Src_File").val(),
              NPag: $("#N_Pag").html(),
            };
            List_Doc.push(Doc);
          }
          if (data["Salida"] == 2) {
            alert("Su SesiÃ³n Ha Terminado. Inicie SesiÃ³n Nuevamente..");
            window.location.href = "../Logout";
          }
          if (data["Salida"] == 3) {
            alert("Ha Ocurrido un Error..." + JSON.stringify(data));
          }
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },

    CambiarLetra: function (String) {
      var New = "";
      New = String.replace(/À/g, "#Agrave")
        .replace(/Á/g, "#Aacute")
        .replace(/Â/g, "#Acirc")
        .replace(/Ã/g, "#Atilde")
        .replace(/Ä/g, "#Auml")
        .replace(/Å/g, "#Aring")
        .replace(/Æ/g, "#AElig")
        .replace(/Ç/g, "#Ccedil")
        .replace(/È/g, "#Egrave")
        .replace(/É/g, "#Eacute")
        .replace(/Ê/g, "#Ecirc")
        .replace(/Ë/g, "#Euml")
        .replace(/Ì/g, "#Igrave")
        .replace(/Í/g, "#Iacute")
        .replace(/Î/g, "#Icirc")
        .replace(/Ï/g, "#Iuml")
        .replace(/Ð/g, "#ETH")
        .replace(/Ñ/g, "#Ntilde")
        .replace(/Ò/g, "#Ograve")
        .replace(/Ó/g, "#Oacute")
        .replace(/Ô/g, "#Ocirc")
        .replace(/Õ/g, "#Otilde")
        .replace(/Ö/g, "#Ouml")
        .replace(/×/g, "#times")
        .replace(/Ø/g, "#Oslash")
        .replace(/Ù/g, "#Ugrave")
        .replace(/Ú/g, "#Uacute")
        .replace(/Û/g, "#Ucirc")
        .replace(/Ü/g, "#Uuml")
        .replace(/Ý/g, "#Yacute")
        .replace(/Þ/g, "#THORN")
        .replace(/ß/g, "#szlig")
        .replace(/à/g, "#agrave")
        .replace(/á/g, "#aacute")
        .replace(/â/g, "#acirc")
        .replace(/ã/g, "#atilde")
        .replace(/ä/g, "#auml")
        .replace(/å/g, "#aring")
        .replace(/æ/g, "#aelig")
        .replace(/ç/g, "#ccedil")
        .replace(/è/g, "#egrave")
        .replace(/é/g, "#eacute")
        .replace(/ê/g, "#ecirc")
        .replace(/ë/g, "#euml")
        .replace(/ì/g, "#igrave")
        .replace(/í/g, "#iacute")
        .replace(/î/g, "#icirc")
        .replace(/ï/g, "#iuml")
        .replace(/ð/g, "#eth")
        .replace(/ñ/g, "#ntilde")
        .replace(/ò/g, "#ograve")
        .replace(/ó/g, "#oacute")
        .replace(/ô/g, "#ocirc")
        .replace(/õ/g, "#otilde")
        .replace(/ö/g, "#ouml")
        .replace(/÷/g, "#divide")
        .replace(/ø/g, "#oslash")
        .replace(/ù/g, "#ugrave")
        .replace(/ú/g, "#uacute")
        .replace(/û/g, "#ucirc")
        .replace(/ü/g, "#uuml")
        .replace(/ý/g, "#yacute")
        .replace(/þ/g, "#thorn")
        .replace(/ÿ/g, "#yuml")
        //                replace(/"/g, "#quot").
        .replace(/%/g, "##37")
        .replace(/`/g, "##96")
        .replace(/°/g, "#deg")
        .replace(/'/g, " ")
        .replace(/~/g, "##126");
      return New;
    },
    CambiarLetra_Doc: function (String) {
      var New = "";
      New = String.replace(/Ã€/g, "A")
        .replace(/Ã�/g, "A")
        .replace(/Ã‚/g, "A")
        .replace(/Ãƒ/g, "A")
        .replace(/Ã„/g, "A")
        .replace(/Ã…/g, "A")
        .replace(/Ã†/g, "A")
        .replace(/Ã‡/g, "C")
        .replace(/Ãˆ/g, "E")
        .replace(/Ã‰/g, "E")
        .replace(/ÃŠ/g, "E")
        .replace(/Ã‹/g, "E")
        .replace(/ÃŒ/g, "I")
        .replace(/Ã�/g, "I")
        .replace(/ÃŽ/g, "I")
        .replace(/Ã�/g, "I")
        .replace(/Ã�/g, "D")
        .replace(/Ã‘/g, "N")
        .replace(/Ã’/g, "O")
        .replace(/Ã“/g, "O")
        .replace(/Ã”/g, "O")
        .replace(/Ã•/g, "O")
        .replace(/Ã–/g, "O")
        .replace(/Ã—/g, "X")
        .replace(/Ã˜/g, "O")
        .replace(/Ã™/g, "U")
        .replace(/Ãš/g, "U")
        .replace(/Ã›/g, "U")
        .replace(/Ãœ/g, "U")
        .replace(/Ã�/g, "Y")
        .replace(/Ãž/g, "_")
        .replace(/ÃŸ/g, "_")
        .replace(/Ã /g, "a")
        .replace(/Ã¡/g, "a")
        .replace(/Ã¢/g, "a")
        .replace(/Ã£/g, "a")
        .replace(/Ã¤/g, "a")
        .replace(/Ã¥/g, "a")
        .replace(/Ã¦/g, "a")
        .replace(/Ã§/g, "c")
        .replace(/Ã¨/g, "e")
        .replace(/Ã©/g, "e")
        .replace(/Ãª/g, "e")
        .replace(/Ã«/g, "e")
        .replace(/Ã¬/g, "i")
        .replace(/Ã­/g, "i")
        .replace(/Ã®/g, "i")
        .replace(/Ã¯/g, "i")
        .replace(/Ã°/g, "_")
        .replace(/Ã±/g, "n")
        .replace(/Ã²/g, "o")
        .replace(/Ã³/g, "o")
        .replace(/Ã´/g, "o")
        .replace(/Ãµ/g, "o")
        .replace(/Ã¶/g, "o")
        .replace(/Ã·/g, "_")
        .replace(/Ã¸/g, "o")
        .replace(/Ã¹/g, "u")
        .replace(/Ãº/g, "u")
        .replace(/Ã»/g, "u")
        .replace(/Ã¼/g, "u")
        .replace(/Ã½/g, "y")
        .replace(/Ã¾/g, "_")
        .replace(/Ã¿/g, "y")
        .replace(/%/g, "_")
        .replace(/`/g, "_")
        .replace(/Â°/g, "_")
        .replace(/'/g, "_")
        .replace(/ /g, "_")
        .replace(/\//g, "_")
        .replace(/~/g, "_");
      return New;
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

    Edit: function (Id_, Op) {
      Op_Edit = Op;
      Id_Tr = Id_;
      $("#div_add").css("display", "none");
      $("#div_save").css("display", "initial");
      $("#div_del").css("display", "initial");
      if (Op == "New") {
        $("#Id_Fil_Anx").val(Id_Tr);
        Op_Anx = "Edit_New";
        $("#Cbx_Documento")
          .val($("#Fil_" + Id_Tr + " #Col_1_" + Id_Tr + " #Id_Doc").val())
          .change();
        $("#Src_File")
          .val($("#Fil_" + Id_Tr + " #Col_5_" + Id_Tr + " #Src_File").val())
          .change();
        $("#N_Pag").html("");
        for (var i = 0; i <= List_Doc.length - 1; i++) {
          if (List_Doc[i].Name === $("#Src_File").val()) {
            $("#N_Pag").html(List_Doc[i].NPag);
          }
        }
        $("#N_Pag")
          .val($("#Fil_" + Id_Tr + " #Col_4_" + Id_Tr + " #N_Pag").val())
          .change();
      }
      if (Op == "Old") {
        var datos = {
          Opcion: "Load",
          Id: Id_,
        };
        $.ajax({
          type: "POST",
          url: "../Funciones_Ejes",
          data: datos,
          dataType: "json",
          success: function (data) {
            Id = data["ID"];
            $("#txt_codigo").val(data["CODIGO"]);
            $("#txt_nombre").val(data["NOMBRE"]);
            $("#txt_obser").val(data["OBSER"]);
            $("#cbx_estado").selectpicker("val", data["ESTADO"]);
          },
          beforeSend: function () {
            $("#cargando").modal("show");
          },
          complete: function () {
            $("#cargando").modal("hide");
          },
          error: function (error_messages) {
            alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
          },
        });
      }
    },
    Eli: function (Fil, Op) {
      if (Op == "New") {
        $("#Fil_" + Fil).remove();
      }
      if (Op == "Old") {
        if (confirm("Â¿Esta Seguro De Desea Eliminar Este Registro?")) {
          var datos = {
            Op_Save: "Delete",
            Id: Fil,
          };
          $.ajax({
            type: "POST",
            url: "../Gestionar_Ejes",
            data: datos,
            dataType: "json",
            success: function (data) {
              if (data["Salida"] == 1) {
                $.Alert("#msg", "Regsitro Eliminado...", "success");
                $.Load();
              } else {
                $.Alert("#msg", "Ha Ocurrido Un Error...", "danger");
              }
            },
            error: function (error_messages) {
              alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
            },
          });
        }
      }
    },
    NewSecre: function () {
      $("#VentSecretarias").modal("show");
    },
    NewTipo: function () {
      $("#VentTipologias").modal("show");
    },
    UpdateSecre: function () {
      $.CargSecreta();
    },
    CargSecreta: function () {
      var datos = {
        ope: "CargSecre",
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbSecre").html(data["Secre"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    CargTipol: function () {
      var datos = {
        ope: "CargTipologiaProyect",
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbTiplog").html(data["Tipolog"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    AddCaus: function () {
      var causa = $("#txt_Caus").val();
      contCaus = $("#contCausas").val();
      contCaus++;
      var fila = '<tr class="selected" id="filaCaus' + contCaus + '" >';

      fila += "<td>" + contCaus + "</td>";
      fila += "<td>" + causa + "</td>";
      fila +=
        "<td><input type='hidden' id='idCausa" +
        contCaus +
        "' name='terce' value='" +
        causa +
        "' /><a onclick=\"$.QuitarCausa('filaCaus" +
        contCaus +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Subfuente").append(fila);
      $.reordenarCausas();
      $("#contCausas").val(contCaus);
      $("#txt_Caus").val("");
    },
    reordenarCausas: function () {
      var num = 1;
      $("#tb_Causas tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Causas tbody input").each(function () {
        $(this).attr("id", "idCausa" + num);
        num++;
      });
    },
    QuitarCausa: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarCausas();
      contCaus = $("#contCausas").val();
      contCaus = contCaus - 1;
      $("#contCausas").val(contCaus);
    },
    AddEfect: function () {
      var Efect = $("#txt_Efect").val();
      contEfect = $("#contEfect").val();
      contEfect++;
      var fila = '<tr class="selected" id="filaEfect' + contEfect + '" >';

      fila += "<td>" + contEfect + "</td>";
      fila += "<td>" + Efect + "</td>";
      fila +=
        "<td><input type='hidden' id='idEfect" +
        contEfect +
        "' name='terce' value='" +
        Efect +
        "' /><a onclick=\"$.QuitarEfect('filaEfect" +
        contEfect +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Efect").append(fila);
      $.reordenarEfect();
      $("#contEfect").val(contEfect);
      $("#txt_Efect").val("");
    },
    reordenarEfect: function () {
      var num = 1;
      $("#tb_Efect tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Efect tbody input").each(function () {
        $(this).attr("id", "idEfect" + num);
        num++;
      });
    },
    QuitarEfect: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarEfect();
      contEfect = $("#contEfect").val();
      contEfect = contEfect - 1;
      $("#contEfect").val(contEfect);
    },
    AddObjEspec: function () {
      var Objet = $("#txt_Obj").val();
      contObjet = $("#contObjet").val();
      contObjet++;
      var fila = '<tr class="selected" id="filaObjet' + contObjet + '" >';

      fila += "<td>" + contObjet + "</td>";
      fila += "<td>" + Objet + "</td>";
      fila +=
        "<td><input type='hidden' id='idObjet" +
        contObjet +
        "' name='terce' value='" +
        Objet +
        "' /><a onclick=\"$.QuitarObjet('filaObjet" +
        contObjet +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Objet").append(fila);
      $.reordenarObjet();
      $("#contObjet").val(contObjet);
      $("#txt_Obj").val("");
    },
    reordenarObjet: function () {
      var num = 1;
      $("#tb_Objet tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Objet tbody input").each(function () {
        $(this).attr("id", "idObjet" + num);
        num++;
      });
    },
    QuitarObjet: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarObjet();
      contObjet = $("#contObjet").val();
      contObjet = contObjet - 1;
      $("#contObjet").val(contObjet);
    },
    AddProd: function () {
      var txt_Productos = $("#txt_Productos").val();
      var txt_Indicadores = $("#txt_Indicadores").val();
      var CbMetaProd = $("#CbMetProd").val();
      var txt_MetAnio = $("#txt_MetAnio").val();
      contProd = $("#contProd").val();
      contProd++;
      var fila = '<tr class="selected" id="filaProd' + contProd + '" >';

      fila += "<td>" + contProd + "</td>";
      fila += "<td>" + txt_Productos + "</td>";
      fila += "<td>" + txt_Indicadores + "</td>";
      fila += "<td>" + CbMetaProd + "</td>";
      fila += "<td>" + txt_MetAnio + "</td>";
      fila +=
        "<td><input type='hidden' id='idProd" +
        contProd +
        "' name='terce' value='" +
        txt_Productos +
        "//" +
        txt_Indicadores +
        "//" +
        CbMetaProd +
        "//" +
        txt_MetAnio +
        "' /><a onclick=\"$.QuitarProd('filaProd" +
        contProd +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Product").append(fila);
      $.reordenarProd();
      $("#contProd").val(contProd);

      $("#txt_Productos").val("");
      $("#txt_Indicadores").val("");
      $("#txt_MetAnio").val("");
      $("#CbMetProd").selectpicker("val", " ");
    },
    AddArchivos: function () {
      var txt_DesAnex = $("#txt_DesAnex").val();
      var Src_File = $("#Src_File").val();
      var Name_File = $("#Name_File").val();

      var contAnexo = $("#contAnexo").val();
      contAnexo++;
      var fila = '<tr class="selected" id="filaAnexo' + contAnexo + '" >';

      fila += "<td>" + contAnexo + "</td>";
      fila += "<td>" + txt_DesAnex + "</td>";
      fila += "<td>" + Name_File + "</td>";
      fila +=
        "<td><a href='../Proyecto/AnexosProyecto/" +
        Src_File +
        "' target='_blank' class=\"btn default btn-xs blue\">" +
        '<i class="fa fa-search"></i> Ver</a>';
      fila +=
        "<input type='hidden' id='idAnexo" +
        contAnexo +
        "' name='idAnexo' value='" +
        txt_DesAnex +
        "///" +
        Name_File +
        "///" +
        Src_File +
        "' /><a onclick=\"$.QuitarAnexo('filaAnexo" +
        contAnexo +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';

      $("#tb_Anexo").append(fila);
      $.reordenarAnexo();
      $("#contAnexo").val(contAnexo);

      $("#txt_DesAnex").val("");
      //   $("#Src_File").val("");
      $("#Name_File").val("");
      $("#archivos").val("");
      $("#fileSize").html("");
    },
    reordenarAnexo: function () {
      var num = 1;
      $("#tb_Anexo tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Anexo tbody input").each(function () {
        $(this).attr("id", "idAnexo" + num);
        num++;
      });
    },
    QuitarAnexo: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarAnexo();
      contProd = $("#contAnexo").val();
      contProd = contProd - 1;
      $("#contAnexo").val(contProd);
    },
    reordenarProd: function () {
      var num = 1;
      $("#tb_Product tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Product tbody input").each(function () {
        $(this).attr("id", "idProd" + num);
        num++;
      });
    },
    QuitarProd: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarProd();
      contProd = $("#contProd").val();
      contProd = contProd - 1;
      $("#contProd").val(contProd);
    },
    AddPobla: function () {
      var txt_Person = $("#txt_Person").val();
      var CbGenero = $("#CbGenero").val();
      var CbEdad = $("#CbEdad").val();
      var CbGrupEtn = $("#CbGrupEtn").val();
      var CbFase = trimAll($("#CbFase").val());

      contPobla = $("#contPobla").val();
      contPobla++;
      var fila = '<tr class="selected" id="filaPobla' + contPobla + '" >';

      fila += "<td>" + contPobla + "</td>";
      fila += "<td>" + txt_Person + "</td>";
      fila += "<td>" + CbGenero + "</td>";
      fila += "<td>" + CbEdad + "</td>";
      fila += "<td>" + CbGrupEtn + "</td>";
      fila += "<td>" + CbFase + "</td>";
      fila +=
        "<td><input type='hidden' id='idPobla" +
        contPobla +
        "' name='terce' value='" +
        txt_Person +
        "//" +
        CbGenero +
        "//" +
        CbEdad +
        "//" +
        CbGrupEtn +
        "//" +
        CbFase +
        "' /><a onclick=\"$.QuitarPobla('filaPobla" +
        contPobla +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Pobla").append(fila);
      $.reordenarPobla();
      $("#contPobla").val(contPobla);

      $("#txt_Person").val("");
      $("#CbGenero").selectpicker("val", " ");
      $("#CbEdad").selectpicker("val", " ");
      $("#CbGrupEtn").selectpicker("val", " ");
    },
    reordenarPobla: function () {
      var num = 1;
      $("#tb_Pobla tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Pobla tbody input").each(function () {
        $(this).attr("id", "idPobla" + num);
        num++;
      });
    },
    QuitarPobla: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarPobla();
      contPobla = $("#contPobla").val();
      contPobla = contPobla - 1;
      $("#contPobla").val(contPobla);
    },
    AddCostAsoc: function () {
      var txt_identCost = $("#txt_identCost").val();
      var txt_nomb_Cost = $("#txt_nomb_Cost").val();
      var txt_Hr_Proy = $("#txt_Hr_Proy").val();
      var Cbx_cargoCost = $("#Cbx_cargoCost").val();
      var Cbx_IdCargoCost = $("#Cbx_cargoCost").val();

      contCostosAsoc = $("#contCostosAsoc").val();
      contCostosAsoc++;
      var fila =
        '<tr class="selected" id="filaCostAsoc' + contCostosAsoc + '" >';

      fila += "<td>" + contCostosAsoc + "</td>";
      fila += "<td>" + txt_identCost + "</td>";
      fila += "<td>" + txt_nomb_Cost + "</td>";
      fila += "<td>" + Cbx_cargoCost + "</td>";
      fila += "<td>" + txt_Hr_Proy + "</td>";
      fila +=
        "<td><input type='hidden' id='idCostAsoc" +
        contCostosAsoc +
        "' name='terce' value='" +
        txt_identCost +
        "//" +
        txt_nomb_Cost +
        "//" +
        Cbx_IdCargoCost +
        "//" +
        txt_Hr_Proy +
        "' /><a onclick=\"$.QuitarCostAsoc('filaCostAsoc" +
        contCostosAsoc +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_CostosAsoc").append(fila);
      $.reordenarCostAsoc();
      $("#contCostosAsoc").val(contCostosAsoc);

      $("#txt_identCost").val("");
      $("#txt_nomb_Cost").val("");
      $("#txt_Hr_Proy").val("");
      $("#Cbx_cargoCost").val("");
    },
    reordenarCostAsoc: function () {
      var num = 1;
      $("#tb_CostosAsoc tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_CostosAsoc tbody input").each(function () {
        $(this).attr("id", "idCostAsoc" + num);
        num++;
      });
    },
    QuitarCostAsoc: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarCostAsoc();
      contCostosAsoc = $("#contCostosAsoc").val();
      contCostosAsoc = contCostosAsoc - 1;
      $("#contCostosAsoc").val(contCostosAsoc);
    },
    AddEstudios: function () {
      var txt_TitEst = $("#txt_TitEst").val();
      var txt_AutEst = $("#txt_AutEst").val();
      var txt_EntEst = $("#txt_EntEst").val();
      var txt_FecEst = $("#txt_FecEst").val();
      var txt_ObsEst = $("#txt_ObsEst").val();

      contEstudios = $("#contEstudios").val();
      contEstudios++;
      var fila = '<tr class="selected" id="filaEstudios' + contEstudios + '" >';

      fila += "<td>" + contEstudios + "</td>";
      fila += "<td>" + txt_TitEst + "</td>";
      fila += "<td>" + txt_AutEst + "</td>";
      fila += "<td>" + txt_EntEst + "</td>";
      fila += "<td>" + txt_FecEst + "</td>";
      fila += "<td>" + txt_ObsEst + "</td>";
      fila +=
        "<td><input type='hidden' id='idEstudios" +
        contEstudios +
        "' name='terce' value='" +
        txt_TitEst +
        "//" +
        txt_AutEst +
        "//" +
        txt_EntEst +
        "//" +
        txt_FecEst +
        "//" +
        txt_ObsEst +
        "' /><a onclick=\"$.QuitarEstudios('filaEstudios" +
        contEstudios +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Estudios").append(fila);
      $.reordenarEstudios();
      $("#contEstudios").val(contEstudios);

      $("#txt_TitEst").val("");
      $("#txt_AutEst").val("");
      $("#txt_EntEst").val("");
      $("#txt_FecEst").val("");
      $("#txt_ObsEst").val("");
    },
    reordenarEstudios: function () {
      var num = 1;
      $("#tb_Estudios tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Estudios tbody input").each(function () {
        $(this).attr("id", "idEstudios" + num);
        num++;
      });
    },
    QuitarEstudios: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarEstudios();
      contEstudios = $("#contEstudios").val();
      contEstudios = contEstudios - 1;
      $("#contEstudios").val(contEstudios);
    },
    AddIndicadores: function () {
      var txt_CodIndi = $("#txt_CodIndi").val();
      var txt_DesIndi = $("#txt_DesIndi").val();

      contIndicad = $("#contIndicad").val();
      contIndicad++;
      var fila =
        '<tr class="selected" id="filaIndicadores' + contIndicad + '" >';

      fila += "<td>" + contIndicad + "</td>";
      fila += "<td>" + txt_CodIndi + "</td>";
      fila += "<td>" + txt_DesIndi + "</td>";
      fila +=
        "<td><input type='hidden' id='idIndicadores" +
        contIndicad +
        "' name='terce' value='" +
        txt_CodIndi +
        "' /><a onclick=\"$.QuitarIndicadores('filaIndicadores" +
        contIndicad +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Indicadores").append(fila);
      $.reordenarIndicadores();
      $("#contIndicad").val(contIndicad);

      $("#txt_CodIndi").val("");
      $("#txt_DesIndi").val("");
    },
    reordenarIndicadores: function () {
      var num = 1;
      $("#tb_Indicadores tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Indicadores tbody input").each(function () {
        $(this).attr("id", "idIndicadores" + num);
        num++;
      });
    },
    QuitarIndicadores: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarIndicadores();
      contIndicad = $("#contIndicad").val();
      contIndicad = contIndicad - 1;
      $("#contIndicad").val(contIndicad);
    },
    AddFinancia: function () {
      var CbOriFinancia = $("#CbOriFinancia").val();
      var textTiplog = $("#CbOriFinancia option:selected").text();
      var CbOriSubfinancia = $("#subfuente").val();
      var textSubfinancia = $("#subfuente option:selected").text();
      var txt_cosFin = $("#txt_cosFin").val();
      var txt_cosFinVi = $("#txt_cosFinVi").val();

      if (CbOriFinancia == " ") {
        $.Alert(
          "#msg",
          "Debes seleccionar el origen de la financiación del proyecto. Verifique...",
          "warning"
        );
        return;
      }

      if (CbOriSubfinancia == " ") {
        $.Alert(
          "#msg",
          "Debes seleccionar la subfuente de financiación del proyecto. Verifique...",
          "warning"
        );
        return;
      }

      if (txt_cosFinVi == "$ 0,00" || txt_cosFinVi == " ") {
        $.Alert("#msg", "Debes de ingresar el valor. Verifique...", "warning");
        return;
      }

      contFinancia = $("#contFinancia").val();
      contFinancia++;

      financi =
        parseFloat($("#txt_FinanciaTotal").val()) + parseFloat(txt_cosFin);

      var fila = '<tr class="selected" id="filaFinancia' + contFinancia + '" >';

      fila += "<td>" + contFinancia + "</td>";
      fila += "<td>" + textTiplog + "</td>";
      fila += "<td>" + textSubfinancia + "</td>";
      fila += "<td>" + txt_cosFinVi + "</td>";
      fila +=
        "<td><input type='hidden' id='idFinancia" +
        contFinancia +
        "' name='terce' value='" + CbOriFinancia + "//"  + CbOriSubfinancia + "//" + txt_cosFin + "' /><a onclick=\"$.QuitarFinancia('filaFinancia" +
        contFinancia +
        "//" +
        txt_cosFin +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Financia").append(fila);
      $.reordenarFinancia();
      $("#contFinancia").val(contFinancia);

      $("#txt_FinanciaTotal").val(financi);
      $("#gtotalFinanc").html("$ " + number_format2(financi, 2, ",", "."));

      $("#CbOriFinancia").select2("val", " ");
      $("#txt_cosFinVi").val("$ 0,00");
      $("#txt_cosFin").val("0");
    },
    reordenarFinancia: function () {
      var num = 1;
      $("#tb_Financia tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Financia tbody input").each(function () {
        $(this).attr("id", "idFinancia" + num);
        num++;
      });
    },
    QuitarFinancia: function (id_fila) {
      var txt_para = id_fila.split("//");
      $("#" + txt_para[0]).remove();

      $.reordenarFinancia();
      contFinancia = $("#contFinancia").val();
      contFinancia = contFinancia - 1;

      var financi =
        parseFloat($("#txt_FinanciaTotal").val()) - parseFloat(txt_para[1]);

      $("#txt_FinanciaTotal").val(financi);
      $("#gtotalFinanc").html(formatCurrency(financi, "es-CO", "COP"));

      $("#contFinancia").val(contFinancia);
    },
    AddPresupuesto: function () {
      var txt_DesPres = $("#CbOriPres").val();
      var txt_Observacion = $("#txt_DesPres").val();
      var txt_valPreTot = $("#txt_valPreTot").val();

      PreTotal += parseFloat(txt_valPreTot);

      if ($("#txt_valPreTot").val() === "") {
        $.Alert(
          "#msg",
          "Debe de ingresar el valor total del item agregado",
          "warning",
          "warning"
        );
        return;
      }

      contPresup = $("#contPresup").val();
      contPresup++;
      var fila = '<tr class="selected" id="filaPresup' + contPresup + '" >';

      fila += "<td>" + contPresup + "</td>";
      fila += "<td>" + txt_DesPres + " - " + txt_Observacion + "</td>";
      fila += "<td>" + formatCurrency(txt_valPreTot, "es-CO", "COP") + "</td>";
      fila +=
        "<td ><input type='hidden' id='idPresup" +
        contPresup +
        "' name='terce' value='" +
        txt_DesPres +
        "//" +
        txt_valPreTot +
        "//" +
        txt_Observacion +
        "' /><a onclick=\"$.QuitarPresup('filaPresup" +
        contPresup +
        "//" +
        txt_valPreTot +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Presup").append(fila);
      $("#gtotalPresTota").html(formatCurrency(PreTotal, "es-CO", "COP"));
      $;

      $.reordenarPresup();
      $("#contPresup").val(contPresup);

      $("#txt_DesPres").val("");
      $("#CbOriPres").selectpicker("val", "GASTOS INDIRECTOS");
      $("#txt_valPreTotVis").val("0,00");
      $("#txt_valPreTotTot").val("0");
    },
    reordenarPresup: function () {
      var num = 1;
      $("#tb_Presup tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Presup tbody input").each(function () {
        $(this).attr("id", "idPresup" + num);
        num++;
      });
    },
    cambioFormato: function (id, val) {
      var numero = $("#" + id).val();
      $("#" + val).val(numero);
      var formatoMoneda = formatCurrency(numero, "es-CO", "COP");

      $("#" + id).val(formatoMoneda);
    },
    QuitarPresup: function (id_fila) {
      var para_fila = id_fila.split("//");
      $("#" + para_fila[0]).remove();
      $.reordenarPresup();
      contPresup = $("#contPresup").val();
      contPresup = contPresup - 1;
      $("#contPresup").val(contPresup);

      PreTotal = PreTotal - parseFloat(para_fila[1]);

      $("#gtotalPresTota").html(formatCurrency(PreTotal, "es-CO", "COP"));
    },

    AddUsuarios: function () {
      var idusu = $("#CbUsuarios").val();
      var usu = $("#CbUsuarios option:selected").text();

      $("#tb_Usuarios tbody input").each(function () {
        idact = $(this).val();
        if (idact === idusu) {
          $.Alert(
            "#msg",
            "Este Usuario ya esta Asignado",
            "warning",
            "warning"
          );
          breack;
        }
      });

      if (idusu === " ") {
        $.Alert("#msg", "Debe de Seleccionar Un Usuario", "warning", "warning");
      } else {
        contUsua = $("#contUsua").val();
        contUsua++;
        var fila = '<tr class="selected" id="filaUsu' + contUsua + '" >';

        fila += "<td>" + contUsua + "</td>";
        fila += "<td>" + usu + "</td>";
        fila +=
          "<td><input type='hidden' id='Usu" +
          contUsua +
          "' name='terce' value='" +
          idusu +
          "' /><a onclick=\"$.QuitarUsu('filaUsu" +
          contUsua +
          '\')" class="btn default btn-xs red">' +
          '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
        $("#tb_Usuarios").append(fila);
        $.reordenarUsuario();
        $("#contUsua").val(contUsua);
        $("#CbUsuarios").select2("val", " ");
      }
    },
    reordenarUsuario: function () {
      var num = 1;
      $("#tb_Usuarios tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Usuarios tbody input").each(function () {
        $(this).attr("id", "Usu" + num);
        num++;
      });
    },
    QuitarUsu: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarUsuario();
      contUsu = $("#contUsua").val();
      contUsu = contUsu - 1;
      $("#contUsua").val(contUsu);
    },
    AddIngresos: function () {
      var txt_DesIngre = $("#txt_DesIngre").val();
      var txt_CantIngre = $("#txt_CantIngre").val();
      var txt_UnMedIgre = $("#txt_UnMedIgre").val();

      contIngPres = $("#contIngPres").val();
      contIngPres++;

      var pIngre = txt_UnMedIgre.split(" ");
      var vreal = pIngre[1]
        .replace(".", "")
        .replace(".", "")
        .replace(".", "")
        .replace(",", ".");
      vtotal = parseFloat(vreal) * parseInt(txt_CantIngre);

      var fila = '<tr class="selected" id="filaIngPres' + contIngPres + '" >';

      fila += "<td>" + contIngPres + "</td>";
      fila += "<td>" + txt_DesIngre + "</td>";
      fila += "<td>" + txt_CantIngre + "</td>";
      fila += "<td>" + txt_UnMedIgre + "</td>";
      fila += "<td>" + "$ " + number_format2(vtotal, 2, ",", ".") + "</td>";
      fila +=
        "<td><input type='hidden' id='idIngPre" +
        contIngPres +
        "' name='terce' value='" +
        txt_DesIngre +
        "//" +
        txt_CantIngre +
        "//" +
        vreal +
        "' /><a onclick=\"$.QuitarIngPres('filaIngPres" +
        contIngPres +
        '\')" class="btn default btn-xs red">' +
        '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
      $("#tb_Ingresos").append(fila);
      $.reordenarIngPre();
      $("#contIngPres").val(contIngPres);

      $("#txt_DesIngre").val("");
      $("#txt_CantIngre").val("");
      $("#txt_UnMedIgre").val("");
    },
    reordenarIngPre: function () {
      var num = 1;
      $("#tb_Ingresos tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Ingresos tbody input").each(function () {
        $(this).attr("id", "idIngPre" + num);
        num++;
      });
    },
    QuitarIngPres: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarIngPre();
      contIngPres = $("#contIngPres").val();
      contIngPres = contIngPres - 1;
      $("#contIngPres").val(contIngPres);
    },
    Dta_Causas: function () {
      $("#tb_Causas")
        .find(":input")
        .each(function () {
          Dat_Causas.push($(this).val());
        });
    },
    Dta_Efectos: function () {
      $("#tb_Efect")
        .find(":input")
        .each(function () {
          Dat_Efectos.push($(this).val());
        });
    },
    Dta_ObjEspec: function () {
      $("#tb_Objet")
        .find(":input")
        .each(function () {
          Dat_ObjEspec.push($(this).val());
        });
    },
    Dta_Productos: function () {
      $("#tb_Product")
        .find(":input")
        .each(function () {
          Dat_Productos.push($(this).val());
        });
    },
    Dta_PobObjet: function () {
     
      $("#tb_Pobla")
        .find(":input")
        .each(function () {
         
          Dat_PobObjet.push($(this).val());
        });
    },
    Dta_CostAsoc: function () {
      $("#tb_CostosAsoc")
        .find(":input")
        .each(function () {
          Dat_CostAsoc.push($(this).val());
        });
    },
    Dta_Estudios: function () {
      $("#tb_Estudios")
        .find(":input")
        .each(function () {
          Dat_Estudios.push($(this).val());
        });
    },
    Dta_Localizacion: function () {
      $("#tb_Localiza")
        .find(":input")
        .each(function () {
          Dat_Localiza.push($(this).val());
        });
    },
    Dta_Actividades: function () {
      $("#tb_Activ")
        .find(":input")
        .each(function () {
          Dat_Actividades.push($(this).val());
        });
    },
    Dta_Metas: function () {
      $("#tb_Metas")
        .find(":input")
        .each(function () {
          Dat_Metas.push($(this).val());
        });
    },
    Dta_MetasP: function () {
      $("#tb_MetasP")
        .find(":input")
        .each(function () {
          Dat_MetasP.push($(this).val());
        });
    },
    Dta_Img: function () {
      $("#tb_Galeria")
        .find(":input")
        .each(function () {
          Dat_Img.push($(this).val());
        });
    },
    Dta_Usu: function () {
      $("#tb_Usuarios")
        .find(":input")
        .each(function () {
          Dat_Usu.push($(this).val());
        });
    },
    Dta_Financiacion: function () {
      $("#tb_Financia")
        .find(":input")
        .each(function () {
          Dat_Financiacion.push($(this).val());
        });
    },
    Dta_Presupuesto: function () {
      $("#tb_Presup")
        .find(":input")
        .each(function () {
          Dat_Presupuesto.push($(this).val());
        });
    },
    Dta_Ingresos: function () {
      $("#tb_Ingresos")
        .find(":input")
        .each(function () {
          Dat_Ingresos.push($(this).val());
        });
    },
    Dta_Anexos: function () {
      $("#tb_Anexo")
        .find(":input")
        .each(function () {
          Dat_Anexos.push($(this).val());
        });
    },
    NewInd: function () {
      //window.location.href = "../Plan_Desarrollo/Indicadores.jsp";
      window.open("../Plan_Desarrollo/Indicadores.jsp", "_blank");
    },
    UpdInd: function () {
      var datos = {
        ope: "UpdIndicadores",
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbIndi").show(100).html(data["mun"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    ExcelProyectos: function () {
      window.open("../Proyecto/ExcelProyecto.php");
    },
    ExcelProyMetas: function () {
      window.open("../Proyecto/ExcelProyMetas.php");
    },
    ExcelProyCont: function () {
      window.open("../Proyecto/ExcelProyCont.php");
    },

    Validar: function () {
      var Id = "",
        Value = "";
      Op_Vali = "Ok";

      Id = "#txt_Cod";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_CodProyecto").addClass("has-error");
      } else {
        $("#From_CodProyecto").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#txt_Nomb";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Nombre").addClass("has-error");
      } else {
        $("#From_Nombre").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#CbTiplog";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Tipologia").addClass("has-error");
      } else {
        $("#From_Tipologia").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#CbSecre";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Secreta").addClass("has-error");
      } else {
        $("#From_Secreta").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#CbEstado";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Estado").addClass("has-error");
      } else {
        $("#From_Estado").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#CbVige";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_Vigencia").addClass("has-error");
      } else {
        $("#From_Vigencia").removeClass("has-error");
        Op_Validar.push("Ok");
      }
      Id = "#txt_FeciniProy";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_FecIni").addClass("has-error");
      } else {
        $("#From_FecIni").removeClass("has-error");
        Op_Validar.push("Ok");
      }
      Id = "#txt_FecFinProy";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_FecFin").addClass("has-error");
      } else {
        $("#From_FecFin").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      for (var i = 0; i <= Op_Validar.length - 1; i++) {
        if (Op_Validar[i] === "Fail") {
          Op_Vali = "Fail";
        }
      }

      Op_Validar.splice(0, Op_Validar.length);
    },
    SelIndi: function (par) {
      var ppar = par.split("//");

      $("#txt_CodIndi").val(ppar[0]);
      $("#txt_DesIndi").val(ppar[1]);

      $("#ventanaIndi").modal("hide");
      // $('#nestr').show();
    },
    Load_ventana: function (op) {
      if (op === "1") {
        $("#ventanaMeta").modal({ backdrop: "static", keyboard: false });
      }
      var eje = $("#CbEjes").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategias").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramas").val();
      if (prog === null) {
        prog = "";
      }

      var datos = {
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        pag: "1",
        op: "1",
        nreg: $("#nregVentMet").val(),
        ori: "Banco",
      };
      $.ajax({
        type: "POST",
        async: false,
        url: "../Paginadores/PagMetVent.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          $("#tab_Vent").html(data["cad"]);
          $("#bot_Vent").html(data["cad2"]);
          $("#cobpagVentMet").html(data["cbp"]);
        },
        beforeSend: function () {
          $("#cargando").modal("show");
        },
        complete: function () {
          $("#cargando").modal("hide");
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },
    Load_ventanaP: function (op) {
      if (op === "1") {
        $("#ventanaMetaP").modal({ backdrop: "static", keyboard: false });
      }
      var eje = $("#CbEjesP").val();
      if (eje === null) {
        eje = "";
      }
      var estr = $("#CbEtrategiasP").val();
      if (estr === null) {
        estr = "";
      }
      var prog = $("#CbProgramasP").val();
      if (prog === null) {
        prog = "";
      }

      var datos = {
        eje: trimAll(eje),
        comp: trimAll(estr),
        prog: trimAll(prog),
        pag: "1",
        op: "1",
        nreg: $("#nregVentMetP").val(),
        ori: "Banco",
      };
      $.ajax({
        type: "POST",
        async: false,
        url: "../Paginadores/PagMetVentP.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          $("#tab_VentP").html(data["cad"]);
          $("#bot_VentP").html(data["cad2"]);
          $("#cobpagVentMetP").html(data["cbp"]);
        },
        beforeSend: function () {
          $("#cargando").modal("show");
        },
        complete: function () {
          $("#cargando").modal("hide");
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },
    VerMeta: function (cod) {
      $("#ventanaDetaMeta").modal("show");

      var datos = {
        ope: "CargaDetMeta",
        cod: cod,
      };
      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          $("#CodMeta").html(data["cod_meta"]);
          $("#DesMeta").html(data["desc_meta"]);
          $("#LinBase").html(data["base_meta"]);
          $("#Prop").html(data["prop_metas"]);
          $("#Respo").html(data["resp_Met"]);
          $("#Eje").html(data["des_eje_metas"]);
          $("#Compo").html(data["des_comp_metas"]);
          $("#Prog").html(data["des_prog_metas"]);
        },
        beforeSend: function () {
          $("#cargando").modal("show");
        },
        complete: function () {
          $("#cargando").modal("hide");
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR" + JSON.stringify(error_messages));
        },
      });
    },
    AddMetas: function () {
      var txt_CodMeta = $("#txt_CodMeta").val();
      var txt_DesMeta = $("#txt_DesMeta").val();
      var txt_MetGen = $("#txt_MetGen").val();
      var txt_IdMeta = $("#txt_IdMeta").val();

      if (txt_CodMeta === "") {
        $.Alert("#msg", "Debe de Seleccionar una Meta", "warning", "warning");
      } else {
        contMetas = $("#contMetas").val();
        contMetas++;
        var fila = '<tr class="selected" id="filaMetas' + contMetas + '" >';

        fila += "<td>" + contMetas + "</td>";
        fila += "<td>" + txt_CodMeta + "</td>";
        fila += "<td>" + txt_DesMeta + "</td>";
        fila += "<td>" + txt_MetGen + "</td>";
        fila +=
          "<td><input type='hidden' id='idMetas" +
          contMetas +
          "' name='terce' value='" +
          txt_IdMeta +
          "//" +
          txt_CodMeta +
          "//" +
          txt_DesMeta +
          "//" +
          txt_MetGen +
          "' /><a onclick=\"$.QuitarMeta('filaMetas" +
          contMetas +
          '\')" class="btn default btn-xs red">' +
          '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
        $("#tb_Metas").append(fila);
        $.reordenarMetas();
        $("#contMetas").val(contMetas);

        $("#txt_CodMeta").val("");
        $("#txt_DesMeta").val("");
        $("#txt_MetaT").val("");
        $("#txt_MetGen").val("");
      }
    },
    AddMetasP: function () {
      var txt_CodMeta = $("#txt_CodMetaP").val();
      var txt_DesMeta = $("#txt_DesMetaP").val();
      var txt_IdMeta = $("#txt_IdMetaP").val();
      var txt_MetaP = $("#txt_MetaP").val();
      var txt_MetEstab = $("#txt_MetEstab").val();

      if (txt_CodMeta === "") {
        $.Alert("#msg", "Debe de Seleccionar una Meta", "warning", "warning");
      } else {
        contMetas = $("#contMetasP").val();
        contMetas++;
        var fila = '<tr class="selected" id="filaMetasP' + contMetas + '" >';

        fila += "<td>" + contMetas + "</td>";
        fila += "<td>" + txt_CodMeta + "</td>";
        fila += "<td>" + txt_DesMeta + "</td>";
        fila += "<td>" + txt_MetaP + "</td>";
        fila += "<td>" + txt_MetEstab + "</td>";
        fila +=
          "<td><input type='hidden' id='idMetasP" +
          contMetas +
          "' name='terce' value='" +
          txt_IdMeta +
          "//" +
          txt_CodMeta +
          "//" +
          txt_DesMeta +
          "//" +
          txt_MetaP +
          "//" +
          txt_MetEstab +
          "' /><a onclick=\"$.QuitarMetaP('filaMetasP" +
          contMetas +
          '\')" class="btn default btn-xs red">' +
          '<i class="fa fa-trash-o"></i> Quitar</a></td></tr>';
        $("#tb_MetasP").append(fila);
        $.reordenarMetasP();
        $("#contMetasP").val(contMetas);

        $("#txt_CodMetaP").val("");
        $("#txt_DesMetaP").val("");
        $("#txt_MetaP").val("");
        $("#txt_DesMetaP").val("");
      }
    },
    reordenarMetas: function () {
      var num = 1;
      $("#tb_Metas tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_Metas tbody input").each(function () {
        $(this).attr("id", "idMetas" + num);
        num++;
      });
    },
    reordenarMetasP: function () {
      var num = 1;
      $("#tb_MetasP tbody tr").each(function () {
        $(this).find("td").eq(0).text(num);
        num++;
      });
      num = 1;
      $("#tb_MetasP tbody input").each(function () {
        $(this).attr("id", "idMetasP" + num);
        num++;
      });
    },
    QuitarMeta: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarMetas();
      contMetas = $("#contMetas").val();
      contMetas = contMetas - 1;
      $("#contMetas").val(contMetas);
    },
    QuitarMetaP: function (id_fila) {
      $("#" + id_fila).remove();
      $.reordenarMetas();
      contMetas = $("#contMetasP").val();
      contMetas = contMetas - 1;
      $("#contMetasP").val(contMetas);
    },
    SelMeta: function (par) {
      var ppar = par.split("//");

      $("#txt_IdMeta").val(ppar[0]);
      $("#txt_DesMeta").val(ppar[1]);
      $("#txt_CodMeta").val(ppar[2]);
      $("#txt_MetaT").val(ppar[3]);

      $("#ventanaMeta").modal("hide");
      // $('#nestr').show();
    },
    SelMetaP: function (par) {
      var ppar = par.split("//");

      $("#txt_IdMetaP").val(ppar[0]);
      $("#txt_DesMetaP").val(ppar[1]);
      $("#txt_CodMetaP").val(ppar[2]);
      $("#txt_MetaP").val(ppar[3]);

      $("#ventanaMetaP").modal("hide");
      // $('#nestr').show();
    },
    ValidarS: function () {
      var Id = "",
        Value = "";
      Op_Vali = "Ok";

      Id = "#txt_CodS";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_CodigoS").addClass("has-error");
      } else {
        $("#From_CodigoS").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#txt_DescS";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_DescripcionS").addClass("has-error");
      } else {
        $("#From_DescripcionS").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      for (var i = 0; i <= Op_Validar.length - 1; i++) {
        if (Op_Validar[i] == "Fail") {
          Op_Vali = "Fail";
        }
      }

      Id = "#archivosS";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_ArchS").addClass("has-error");
      } else {
        $("#From_ArchS").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      for (var i = 0; i <= Op_Validar.length - 1; i++) {
        if (Op_Validar[i] == "Fail") {
          Op_Vali = "Fail";
        }
      }

      Op_Validar.splice(0, Op_Validar.length);
    },
    ValidarT: function () {
      var Id = "",
        Value = "";
      Op_Vali = "Ok";

      Id = "#txt_CodT";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_CodigoT").addClass("has-error");
      } else {
        $("#From_CodigoT").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      Id = "#txt_DescT";
      Value = $(Id).val();
      if (Value === "" || Value === " ") {
        Op_Validar.push("Fail");
        $("#From_DescripcionT").addClass("has-error");
      } else {
        $("#From_DescripcionT").removeClass("has-error");
        Op_Validar.push("Ok");
      }

      for (var i = 0; i <= Op_Validar.length - 1; i++) {
        if (Op_Validar[i] == "Fail") {
          Op_Vali = "Fail";
        }
      }

      Op_Validar.splice(0, Op_Validar.length);
    },
    UploadImgSec: function () {
      var archivos = document.getElementById("archivosS"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
      var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
      //Creamos una instancia del Objeto FormDara.
      var archivos = new FormData();
      /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
      for (i = 0; i < archivo.length; i++) {
        archivos.append("archivo" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
      }

      var ruta = "../Administracion/SubirImgSecre.php";

      $.ajax({
        async: false,
        url: ruta,
        type: "POST",
        data: archivos,
        contentType: false,
        processData: false,
        success: function (datos) {
          var par_res = datos.split("//");
          if (par_res[0] === "Bien") {
            $("#Src_FileS").val(par_res[1].trim());
          } else if (par_res[0] === "Mal") {
            $.Alert(
              "#msgS",
              "El archivo no se Puede Agregar debido al siguiente Error:"
                .par_res[1],
              "warning"
            );
          }
        },
        beforeSend: function () {
          $("#cargando").modal("show");
        },
        complete: function () {
          $("#cargando").modal("hide");
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },

    UploadImgTip: function () {
      var archivos = document.getElementById("archivosT"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
      var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
      //Creamos una instancia del Objeto FormDara.
      var archivos = new FormData();
      /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
      for (i = 0; i < archivo.length; i++) {
        archivos.append("archivo" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
      }

      var ruta = "../Administracion/SubirImgTipo.php";

      $.ajax({
        async: false,
        url: ruta,
        type: "POST",
        data: archivos,
        contentType: false,
        processData: false,
        success: function (datos) {
          var par_res = datos.split("//");
          if (par_res[0] === "Bien") {
            $("#Src_FileT").val(par_res[1].trim());
          } else if (par_res[0] === "Mal") {
            $.Alert(
              "#msgT",
              "El archivo no se Puede Agregar debido al siguiente Error:"
                .par_res[1],
              "warning",
              "warning"
            );
          }
        },
      });
    },
    buscaSubfinanciacion: function () {
      var datos = {
        ope: "buscarSubfuente",
        cod: $("#CbOriFinancia").val(),
      };

      $.ajax({
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          $("#subfuente").html(data["subfi"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    UploadCompPre: function () {
      var archivos = document.getElementById("archivosComp"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
      var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
      //Creamos una instancia del Objeto FormDara.
      var archivos = new FormData();
      /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
      for (i = 0; i < archivo.length; i++) {
        archivos.append("archivosComp" + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
      }
      
      var ruta = "../Proyecto/SubirDocuComp.php";

      $.ajax({
        async: false,
        url: ruta,
        type: "POST",
        data: archivos,
        contentType: false,
        processData: false,
        success: function (datos) {
          var par_res = datos.split("//");
          if (par_res[0] === "Bien") {
            $("#Src_FileComp").val(par_res[1].trim());
          } else if (par_res[0] === "Mal") {
            $.Alert(
              "#msgComp",
              "El archivo no se Puede Agregar debido al siguiente Error:"
                .par_res[1],
              "warning",
              "warning"
            );
          }
        },
      });
    },
    cargarEje: function () {
      var datos = {
        ope: "ConsulTodo",
      };

      $.ajax({
        type: "POST",
        async: false,
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbEjes").html(data["ejes"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    cargarEjeP: function () {
      var datos = {
        ope: "ConsulTodo",
      };

      $.ajax({
        type: "POST",
        async: false,
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbEjesP").html(data["ejes"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
    },
    CargEstrategia: function (cod) {
      var datos = {
        ope: "CargSelEstrategia",
        cod: cod,
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbEtrategias").html(data["estrat"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#CbEtrategias").prop("disabled", false);
      $.busqMetas();
    },
    CargEstrategiaP: function (cod) {
      var datos = {
        ope: "CargSelEstrategia",
        cod: cod,
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbEtrategiasP").html(data["estrat"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#CbEtrategiasP").prop("disabled", false);
      $.busqMetasP();
    },
    CargProgramas: function (cod) {
      var datos = {
        ope: "CargSelPrograma",
        cod: cod,
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbProgramas").html(data["program"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#CbProgramas").prop("disabled", false);
      $.busqMetas();
    },
    CargProgramasP: function (cod) {
      var datos = {
        ope: "CargSelPrograma",
        cod: cod,
      };

      $.ajax({
        async: false,
        type: "POST",
        url: "../All.php",
        data: datos,
        dataType: "JSON",
        success: function (data) {
          $("#CbProgramasP").html(data["program"]);
        },
        error: function (error_messages) {
          alert("HA OCURRIDO UN ERROR");
        },
      });
      $("#CbProgramasP").prop("disabled", false);
      $.busqMetasP();
    },
  });
  //======FUNCIONES========\\
  $.Proyectos();
  $.CargaTodBanProy();

  //    $.Load_Documentos();

  function formatCurrency(number, locale, currencySymbol) {
    return new Intl.NumberFormat(locale, {
      style: "currency",
      currency: currencySymbol,
      minimumFractionDigits: 2,
    }).format(number);
  }

  $("#archivos").on("change", function () {
    /* Limpiar vista previa */
    $("#vista-previa").html("");
    var archivos = document.getElementById("archivos").files;
    var navegador = window.URL || window.webkitURL;
    /* Recorrer los archivos */
    for (x = 0; x < archivos.length; x++) {
      /* Validar tamaño y tipo de archivo */
      var size = archivos[x].size;
      var type = archivos[x].type;
      var name = archivos[x].name;

      if (size > 20971520) {
        $.Alert(
          "#msgArch",
          "El archivo " + name + " supera el máximo permitido 20MB",
          "success"
        );
      } else {
        var Mb = $.Format_Bytes(size, 2);
        $("#fileSize").html(Mb);
        $("#Name_File").val(name);
      }
    }
  });

  $("#archivosGale").on("change", function () {
    /* Limpiar vista previa */
    $("#vista-previa").html("");
    var archivos = document.getElementById("archivosGale").files;
    var navegador = window.URL || window.webkitURL;
    /* Recorrer los archivos */
    for (x = 0; x < archivos.length; x++) {
      /* Validar tamaño y tipo de archivo */
      var size = archivos[x].size;
      var type = archivos[x].type;
      var name = archivos[x].name;

      if (size > 10485760) {
        $("#vista-previa").append(
          "<p style='color: red'>El archivo " +
            name +
            " supera el máximo permitido 10MB</p>"
        );
      } else if (
        type != "image/jpeg" &&
        type != "image/jpg" &&
        type != "image/png" &&
        type != "image/gif" &&
        type != "video/mp4" &&
        type != "video/avi" &&
        type != "video/mpg" &&
        type != "video/mpeg"
      ) {
        $("#vista-previa").append(
          "<p style='color: red'>El archivo " +
            name +
            " no es del tipo de imagen/video permitida.</p>"
        );
      } else {
        var objeto_url = navegador.createObjectURL(archivos[x]);
        $("#vista-previa").append(
          "<img src=" + objeto_url + " width='100' height='100'>&nbsp;"
        );
      }
    }
  });

  $("#btn_nuevoS").on("click", function () {
    $("#txt_CodS").val("");
    $("#txt_DescS").val("");
    $("#txt_obserS").val("");
    $("#txt_RespoS").val("");
    $("#txt_CorreS").val("");
    $("#archivosS").val("");

    $("#btn_nuevoS").prop("disabled", true);
    $("#btn_guardarS").prop("disabled", false);

    $("#txt_CodS").prop("disabled", false);
    $("#txt_DescS").prop("disabled", false);
    $("#txt_obserS").prop("disabled", false);
    $("#txt_CorreS").prop("disabled", false);
    $("#txt_RespoS").prop("disabled", false);
    $("#MostImgS").hide();
  });

  $("#btn_nuevoT").on("click", function () {
    $("#txt_CodT").val("");
    $("#txt_DescT").val("");
    $("#txt_obserT").val("");
    $("#archivosT").val("");

    $("#btn_nuevoT").prop("disabled", true);
    $("#btn_guardarT").prop("disabled", false);

    $("#txt_CodT").prop("disabled", false);
    $("#txt_DescT").prop("disabled", false);
    $("#txt_obserT").prop("disabled", false);
  });

  $("#btn_nuevo").on("click", function () {
    //tab 1
    $("#txt_fecha_Cre").val($("#txt_fecha_def").val());
    $("#txt_Nomb").val("");
    $("#CbTiplog").select2("val", " ");
    $("#CbSecre").select2("val", " ");
    $("#CbCrono").selectpicker("val", " ");
    $("#CbEstado").selectpicker("val", " ");
    $("#CbVige").val($("#CbVigeDef").val());
    $("#txt_CodProyAs").val("");
    $("#txt_NombProyAs").val("");
    $("#txt_FecAproProAso").val("");
    $("#txt_Fecini").val("");
    $("#txt_Plazo").val("");
    $("#txt_vigenc").val("");
    $("#txt_estaProye").val("");
    $("#txt_elabo").val("");
    //tab 2
    $("#txt_IdProblema").val("");

    $("#tb_Causas tbody").empty();
    $("#contCausas").val("0");
    $("#tb_Efect tbody").empty();
    $("#contEfect").val("0");
    //tab 3
    $("#txt_ObjGenr").val("");
    $("#tb_Objet tbody").empty();
    $("#contObjet").val("0");
    $("#txt_DesProy").val("");
    $("#tb_Product tbody").empty();
    $("#contProd").val("0");
    $("#tb_Pobla tbody").empty();
    $("#contPobla").val("0");
    //tab 4
    $("#tb_CostosAsoc tbody").empty();
    $("#contCostosAsoc").val("0");
    //tab 5
    $("#tb_Estudios tbody").empty();
    $("#contEstudios").val("0");
    //tab 6
    $("#tb_Localiza tbody").empty();
    $("#contLocalizacion").val("0");
    //tab 7
    $("#tb_Activ tbody").empty();
    $("#contActivi").val("0");
    $("#txt_costActTotal").val("0,00");
    //tab 8
    $("#tb_Metas tbody").empty();
    $("#contMetas").val("0");
    //tab 9
    $("#tb_Financia tbody").empty();
    $("#contFinancia").val("0");
    $("#txt_FinanciaTotal").val("0,00");
    //tab 10
    $("#tb_Presup tbody").empty();
    $("#contPresup").val("0");
    $("#txt_valPreVigTot").val("0");
    $("#txt_valPreTotTot").val("0");
    //tab 11
    $("#tb_Ingresos tbody").empty();
    $("#contIngPres").val("0");
    //tab 12
    $("#tb_Anexo tbody").empty();
    $("#contAnexo").val("0");
    //tab 13
    $("#tb_Galeria tbody").empty();
    $("#contImg").val("0");

    for (var i = 2; i <= 13; i++) {
      $("#tab_" + i).removeClass("active in");
      $("#tab_pp" + i).removeClass("active in");
    }

    $("#tab_1").addClass("active in");
    $("#tab_pp1").addClass("active in");

    $("#btn_nuevo").prop("disabled", true);
    $("#btn_guardar").prop("disabled", false);
    $("#atitulo")
      .show(100)
      .html(
        "<a href='#tab_02' data-toggle='tab' id='atitulo'>Crear Proyecto</a>"
      );
    $.conse();
    $.CargUbica();
  });

  $("#btn_volver").on("click", function () {
    window.location.href = "../Proyectos/";
  });

  $("#btn_cancelar").on("click", function () {
    if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
      $("#txt_fecha_Cre").val($("#txt_fecha_def").val());
      $("#txt_Nomb").val("");
      $("#CbTiplog").select2("val", " ");
      $("#CbSecre").select2("val", " ");
      $("#CbCrono").selectpicker("val", " ");
      $("#CbEstado").selectpicker("val", " ");
      $("#CbVige").val($("#CbVigeDef").val());
      $("#txt_CodProyAs").val("");
      $("#txt_NombProyAs").val("");
      $("#txt_FecAproProAso").val("");
      $("#txt_Fecini").val("");
      $("#txt_Plazo").val("");
      $("#txt_vigenc").val("");
      $("#txt_estaProye").val("");
      $("#txt_elabo").val("");
      //tab 2
      $("#txt_IdProblema").val("");

      $("#tb_Causas tbody").empty();
      $("#contCausas").val("0");
      $("#tb_Efect tbody").empty();
      $("#contEfect").val("0");
      //tab 3
      $("#txt_ObjGenr").val("");
      $("#tb_Objet tbody").empty();
      $("#contObjet").val("0");
      $("#txt_DesProy").val("");
      $("#tb_Product tbody").empty();
      $("#contProd").val("0");
      $("#tb_Pobla tbody").empty();
      $("#contPobla").val("0");
      //tab 4
      $("#tb_CostosAsoc tbody").empty();
      $("#contCostosAsoc").val("0");
      //tab 5
      $("#tb_Estudios tbody").empty();
      $("#contEstudios").val("0");
      //tab 6
      $("#tb_Localiza tbody").empty();
      $("#contLocalizacion").val("0");
      //tab 7
      $("#tb_Activ tbody").empty();
      $("#contActivi").val("0");
      $("#txt_costActTotal").val("0,00");
      //tab 8
      $("#tb_Metas tbody").empty();
      $("#contMetas").val("0");
      //tab 9
      $("#tb_Financia tbody").empty();
      $("#contFinancia").val("0");
      $("#txt_FinanciaTotal").val("0,00");
      //tab 10
      $("#tb_Presup tbody").empty();
      $("#contPresup").val("0");
      $("#txt_valPreVigTot").val("0");
      $("#txt_valPreTotTot").val("0");
      //tab 11
      $("#tb_Ingresos tbody").empty();
      $("#contIngPres").val("0");
      //tab 12
      $("#tb_Anexo tbody").empty();
      $("#contAnexo").val("0");
      //tab 13
      $("#tb_Galeria tbody").empty();
      $("#contImg").val("0");

      $("#tab_02").removeClass("active in");
      $("#tab_02_pp").removeClass("active in");
      $("#tab_01").addClass("active in");
      $("#tab_01_pp").addClass("active in");

      $("#btn_nuevo").prop("disabled", true);
      $("#btn_guardar").prop("disabled", false);

      $("#atitulo")
        .show(100)
        .html(
          "<a href='#tab_02' onclick='$.addProy();' data-toggle='tab' id='atitulo'>Crear Proyecto</a>"
        );
      //$.conse();
      // $.CargUbica();
    }
  });

  $("#txt_CodS").on("change", function () {
    var datos = {
      ope: "verfSecre",
      cod: $("#txt_CodS").val(),
    };

    $.ajax({
      type: "POST",
      url: "../All.php",
      data: datos,
      success: function (data) {
        if (data === "1") {
          $("#From_CodigoS").addClass("has-error");
          $.Alert(
            "#msgS",
            "Este Código ya Esta Registrado...",
            "warning",
            "warning"
          );
          $("#txt_CodS").focus();
          $("#txt_CodS").val("");
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });

  $("#txt_CodT").on("change", function () {
    var datos = {
      ope: "verfTipologPtoyect",
      cod: $("#txt_CodT").val(),
    };

    $.ajax({
      type: "POST",
      url: "../All.php",
      data: datos,
      success: function (data) {
        if (data === "1") {
          $("#From_CodigoT").addClass("has-error");
          $.Alert(
            "#msgT",
            "Este Código ya Esta Registrado...",
            "warning",
            "warning"
          );

          $("#txt_CodT").focus();
          $("#txt_CodT").val("");
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });

  $("#txt_Cod").on("change", function () {
    var datos = {
      ope: "VerfProyect",
      cod: $("#txt_Cod").val(),
    };

    $.ajax({
      type: "POST",
      url: "../All.php",
      data: datos,
      success: function (data) {
        if (data === "1") {
          $.Alert("#msg", "Este Código ya ha sido Registrado", "warning");
          $("#From_CodProyecto").addClass("has-error");
          $("#txt_Cod").focus();
          $("#txt_Cod").val("");
        } else {
          $("#From_CodProyecto").removeClass("has-error");
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });

  $("#btn_paraIndi").on("click", function () {
    $.Load_ventana("1");
  });

  $("#btn_imgComp").on("click", function () {
    window.open("../Proyecto/" + $("#Src_FileComp").val(), "_blank");
    return false;
  });

  $("#CbCumplimi").on("change", function () {
    if ($("#CbCumplimi").val() === "$") {
      $("#txt_Cumplimi").prop("disabled", false);
      $("#txt_Cumplimi").attr("onblur", "textCump(this.value, this.id)");
    } else if ($("#CbCumplimi").val() === "#") {
      $("#txt_Cumplimi").prop("disabled", false);
      $("#txt_Cumplimi").attr("onblur", "");
      $("#txt_Cumplimi").val("");
    } else {
      $("#txt_Cumplimi").prop("disabled", true);
      $("#txt_Cumplimi").attr("onblur", "#");
    }
  });

  $("#Anx_Doc").on("click", function () {
    var des = $("#txt_DesAnex").val();
    var name = $("#Name_File").val();

    if (des == " " || des == "") {
      $.Alert(
        "#msg",
        "Por Favor Ingrese una Descripción del Documento...",
        "warning",
        "warning"
      );
      $("#From_DescriDocu").addClass("has-error");
      return;
    } else {
      $("#From_DescriDocu").removeClass("has-error");
    }

    if (name == " " || name == "") {
      $.Alert(
        "#msg",
        "Por Favor Seleccione un Documento...",
        "warning",
        "warning"
      );
      $("#From_Arch").addClass("has-error");
      return;
    } else {
      $("#From_Arch").removeClass("has-error");
    }

    $.UploadDoc();
    $.AddArchivos();
  });

  $("#btn_paraMet").on("click", function () {
    $.cargarEje();
    // $("#CbEjes").val(" ").change();
    $("#CbEtrategias").html("");
    $("#CbEtrategias").prop("disabled", true);
    $("#CbProgramas").html("");
    $("#CbProgramas").prop("disabled", true);

    $.Load_ventana("1");
  });

  $("#btn_paraMetP").on("click", function () {
    $.cargarEjeP();
    // $("#CbEjes").val(" ").change();
    $("#CbEtrategias").html("");
    $("#CbEtrategias").prop("disabled", true);
    $("#CbProgramas").html("");
    $("#CbProgramas").prop("disabled", true);

    $.Load_ventanaP("1");
  });

  //GUARDAR TIPOLOGIA
  $("#btn_guardarT").on("click", function () {
    $.ValidarT();

    if (Op_Vali === "Fail") {
      $.Alert(
        "#msgT",
        "Por Favor Llene Los Campos Obligatorios...",
        "warning",
        "warning"
      );
      return;
    }
    $.UploadImgTip();
    var datos = {
      cod: $("#txt_CodT").val(),
      des: $("#txt_DescT").val(),
      obs: $("#txt_obserT").val(),
      acc: "1",
      url: $("#Src_FileT").val(),
    };

    $.ajax({
      type: "POST",
      url: "../Administracion/GuardarTipologia.php",
      data: datos,
      success: function (data) {
        var par = data.split("-");
        if (trimAll(par[0]) === "bien") {
          $.Alert(
            "#msgT",
            "Datos Guardados Exitosamente...",
            "success",
            "check"
          );
          $.CargTipol();
          $("#btn_nuevoT").prop("disabled", false);
          $("#btn_guardarT").prop("disabled", true);

          $("#txt_CodT").prop("disabled", true);
          $("#txt_DescT").prop("disabled", true);
          $("#txt_CorreT").prop("disabled", true);
          $("#txt_obserT").prop("disabled", true);
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });

  //GUARDAR SECRETARIA
  $("#btn_guardarS").on("click", function () {
    $.ValidarS();

    if (Op_Vali === "Fail") {
      $.Alert(
        "#msgS",
        "Por Favor Llene Los Campos Obligatorios...",
        "warning",
        "warning"
      );
      return;
    }

    $.UploadImgSec();

    var datos = {
      cod: $("#txt_CodS").val(),
      des: $("#txt_DescS").val(),
      cor: $("#txt_CorreS").val(),
      resp: $("#txt_RespoS").val(),
      obs: $("#txt_obserS").val(),
      url: $("#Src_FileS").val(),
      acc: "1",
    };

    $.ajax({
      type: "POST",
      url: "../Administracion/GuardarSecretaria.php",
      data: datos,
      success: function (data) {
        if (trimAll(data) === "bien") {
          $.Alert(
            "#msgS",
            "Datos Guardados Exitosamente...",
            "success",
            "check"
          );
          $.CargSecreta();
          $("#btn_nuevoS").prop("disabled", false);
          $("#btn_guardarS").prop("disabled", true);

          $("#txt_CodS").prop("disabled", true);
          $("#txt_DescS").prop("disabled", true);
          $("#txt_CorreS").prop("disabled", true);
          $("#txt_RespoS").prop("disabled", true);
          $("#txt_obserS").prop("disabled", true);
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });

  //BOTON GUARDAR PROYECTO-
  $("#btn_guardar").on("click", function () {
    $.Validar();

    if (Op_Vali === "Fail") {
      $.Alert("#msg", "Por Favor Llene Los Campos Obligatorios...", "warning");
      return;
    }
    

     Dat_Img = [];
     Dat_Usu = [];
     Dat_Metas = [];
     Dat_MetasP = [];
    ///
     Dat_Causas = [];
     Dat_Efectos = [];
     Dat_ObjEspec = [];
     Dat_Productos = [];
     Dat_PobObjet = [];
     Dat_CostAsoc = [];
     Dat_Estudios = [];
     Dat_Localiza = [];
     Dat_Actividades = [];
     Dat_Indicadores = [];
     Dat_Financiacion = [];
     Dat_Presupuesto = [];
     Dat_Anexos = [];
     Dat_Ingresos = [];

    

    /////2 identificacion
    $.Dta_Causas();
    $.Dta_Efectos();
    /////3 Descripcion
    $.Dta_ObjEspec();
    $.Dta_Productos();
    $.Dta_PobObjet();
    //5 costos asociados
    $.Dta_CostAsoc();
    //6 Estudios
    $.Dta_Estudios();
    //6 Localizacion
    $.Dta_Localizacion();
    //8 Actividades
    $.Dta_Actividades();
    //9 Indicadores
    $.Dta_Metas();
    //10 Financiacion
    $.Dta_MetasP();
    //10 Financiacion
    $.Dta_Financiacion();
    //11 Presupuesto
    $.Dta_Presupuesto();
    //12 Ingresos
    $.Dta_Ingresos();
    //13 Anexos
    $.Dta_Anexos();
    //14 galeria de imagenes
    $.Dta_Img();
    //15 Usuarios
    $.Dta_Usu();
    //Consecutivo
    $.conse();

    for (var instanceName in CKEDITOR.instances) {
      CKEDITOR.instances[instanceName].updateElement();
    }

    var PreComp = "no";
    if ($("#sel1ComPre").prop("checked")) {
      PreComp = "si";
    }

    if (
      $("#CbEstado").val() == "Priorizado" ||
      $("#CbEstado").val() == "En Ejecucion" ||
      $("#CbEstado").val() == "Ejecutado"
    ) {
      if (PreComp == "no") {
        let estado =
          $("#CbEstado").val() === "En Ejecucion"
            ? "En ejecución"
            : $("#CbEstado").val();
        $.Alert(
          "#msg",
          "Si el estado del proyecto cambia a " +
            estado +
            ", el presupuesto debe estar comprometido... Verifique en pestaña Pressupuesto",
          "warning",
          {
            duration: 9000,
          }
        );
        return;
      }
    }

    if ($("#CbEstado").val() === "En Ejecucion" && PreComp === "no") {
      $.Alert(
        "#msg",
        "El Presupuesto tiene que estar aprobado para Cambiar a estado en Ejecución. Verifique...",
        "warning"
      );
      return;
    }

    $.UploadCompPre();

    var datos = {
      txt_Cod: $("#txt_Cod").val(),
      txt_fecha_Cre: $("#txt_fecha_Cre").val(),
      txt_fecMod: $("#txt_fecMod").val(),
      txt_Nomb: $("#txt_Nomb").val(),
      CbTiplog: $("#CbTiplog").val(),
      txt_FeciniProy: $("#txt_FeciniProy").val(),
      txt_FecFinProy: $("#txt_FecFinProy").val(),
      DesCbTiplog: $("#CbTiplog option:selected").text(),
      CbSecre: $("#CbSecre").val(),
      DesCbSecre: $("#CbSecre option:selected").text(),
      CbCrono: $("#CbCrono").val(),
      txt_CodProyAs: $("#txt_CodProyAs").val(),
      txt_NombProyAs: $("#txt_NombProyAs").val(),
      txt_FecAproProAso: $("#txt_FecAproProAso").val(),
      txt_Fecini: $("#txt_Fecini").val(),
      txt_Plazo: $("#txt_Plazo").val(),
      txt_vigenc: $("#txt_vigenc").val(),
      CbVige: $("#CbVige").val(),
      txt_estaProye: $("#txt_estaProye").val(),
      txt_elabo: $("#txt_elabo").val(),
      PreComp: PreComp,
      Src_FileComp: $("#Src_FileComp").val(),
      txt_fecha_ComPre: $("#txt_fecha_ComPre").val(),
      txt_IdProblema: CKEDITOR.instances["txt_IdProblema"].getData(),
      txt_ObjGenr: $("#txt_ObjGenr").val(),
      txt_DesProy: CKEDITOR.instances["txt_DesProy"].getData(),
      acc: $("#acc").val(),
      id: $("#txt_id").val(),
      estado: $("#CbEstado").val(),
      cons: $("#cons").val(),
      Dat_Causas: Dat_Causas,
      Dat_Efectos: Dat_Efectos,
      Dat_ObjEspec: Dat_ObjEspec,
      Dat_Productos: Dat_Productos,
      Dat_PobObjet: Dat_PobObjet,
      Dat_CostAsoc: Dat_CostAsoc,
      Dat_Estudios: Dat_Estudios,
      Dat_Actividades: Dat_Actividades,
      Dat_Metas: Dat_Metas,
      Dat_MetasP: Dat_MetasP,
      Dat_Financiacion: Dat_Financiacion,
      Dat_Presupuesto: Dat_Presupuesto,
      Dat_Ingresos: Dat_Ingresos,
      Dat_Anexos: Dat_Anexos,
      Dat_Localiza: Dat_Localiza,
      Dat_Img: Dat_Img,
      Dat_Usu: Dat_Usu,
    };

    $.ajax({
      type: "POST",
      url: "../Proyecto/GuardarProyecto.php",
      data: datos,
      dataType: "JSON",
      success: function (data) {
        if (trimAll(data["Mensaje"]) === "bien") {
          $.Alert(
            "#msg",
            "Datos Guardados Exitosamente...",
            "success",
            "check"
          );
          $.Proyectos();
          $("#txt_id").val(data["IdProy"]);
          $("#btn_nuevo").prop("disabled", false);
          $("#btn_guardar").prop("disabled", true);
        }
      },
      error: function (error_messages) {
        alert("HA OCURRIDO UN ERROR");
      },
    });
  });
});

function check(e) {
  var key = document.all ? e.keyCode : e.which;
  var tecla = String.fromCharCode(key).toLowerCase();
  //        var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
  var letras = "0123456789.";
  var especiales = "8-37-39-46";

  var tecla_especial = false;
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }

  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    return false;
  }
}

function restrictInput(event) {
  const input = event.target;
  const regex = /[^0-9.,]/g;

  // Remove any invalid characters
  input.value = input.value.replace(regex, "");
}
///////////////////////
