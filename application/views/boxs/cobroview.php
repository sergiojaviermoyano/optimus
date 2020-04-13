<!-- Modal -->
<div class="modal fade" id="modalCobro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalActionCobro"> </span> Medios de Pago</h4>
      </div>
      <div class="modal-body cuerpo" id="modalBodyCobro">
        <div class="row"> 
          <!-- Tipos de medios de pago -->
          <div class="col-xs-3" style="border-right: 1px solid #d2d6de;" id="divTiposMediosDePago">
            
          </div>

          <!-- Medido de pago -->
          <div class="col-xs-3" style="border-right: 1px solid #d2d6de;" id="divMediosDePago">
            
          </div>

          <!-- Importe   -->
          <div class="col-xs-3" style="border-right: 1px solid #d2d6de;" id="divValoresDePago">
            <div class="input-group" id="divImporte" style="margin-bottom: 5px;">
              <span class="input-group-addon"><i class="fa fa-fw fa-dollar text-green"></i></span>
              <input type="text" class="form-control importe" id="medImporte" style="text-align: right">
            </div>
            <div id="divAdicional">
              <div class="input-group" id="tmpDato1" style="margin-bottom: 5px;">
                <span class="input-group-addon"><i class="fa fa-fw fa-info-circle text-blue"></i></span>
                <input type="text" class="form-control" id="tmpDescripcion1" >
              </div>
              <div class="input-group" id="tmpDato2" style="margin-bottom: 5px;">
                <span class="input-group-addon"><i class="fa fa-fw fa-info-circle text-blue"></i></span>
                <input type="text" class="form-control" id="tmpDescripcion2" >
              </div>
              <div class="input-group" id="tmpDato3" style="margin-bottom: 5px;">
                <span class="input-group-addon"><i class="fa fa-fw fa-info-circle text-blue"></i></span>
                <input type="text" class="form-control" id="tmpDescripcion3" >
              </div>
            </div>
            <div id="agregarPago" class="pull-right">
              <button type="button" class="btn btn-success" id="btnAddPago">Agregar</button>
            </div>
          </div>

          <!-- Resumen -->
          <div class="col-xs-3 text-right">
            <div class="box box-success bg-gray">
              <div class="box-header with-border">
                <h3 class="box-title text-green">Total $:</h3>
              </div>
              <div class="box-body">
                <h1 class="text-green" id="importeTotalaCobrar" style="margin-top: -10px;"></h1>
              </div>
            </div>
            <!-- <h4 class="text-green" style="margin-top: -5px;"> Total $:</h4>
            <h1 class="text-green" id="importeTotalaCobrar" style="margin-top: -10px;"></h1> -->
            <div class="box box-primary bg-gray">
              <div class="box-header with-border">
                <h3 class="box-title text-blue">Sus Pagos $:</h3>
              </div>
              <div class="box-body">
                <div id="divPagosRealizados"> 
                </div>
                <hr>
                <h1 class="text-blue" id="importeTotalPagado" style="margin-top: -10px;">0.00</h1>
              </div>
            </div>
            <!-- <h4 class="text-blue"> Sus Pagos $:</h4>
            <div id="divPagosRealizados"> 
            </div>
            <hr>
            <h1 class="text-blue" id="importeTotalPagado" style="margin-top: -10px;">0.00</h1> -->
            <div class="box box-warning bg-gray">
              <div class="box-header with-border">
                <h3 class="box-title text-yellow">Descuento $:</h3>
              </div>
              <div class="box-body">
                <div class="input-group" id="divImporteDescuento" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-fw fa-dollar text-yellow"></i></span>
                  <input type="text" class="form-control descuento" id="medDescuento" style="text-align: right">
                </div>
                  <small>(shift + d)</small>
              </div>
            </div>
            <!-- <h4 class="text-yellow" style="margin-top: -5px;"> Descuento $:</h4> -->
            <div class="box box-danger bg-gray" style="display: none">
              <div class="box-header with-border">
                <h3 class="box-title text-red">Vuelto $:</h3>
              </div>
              <div class="box-body">
                <h1 class="text-red" id="importeVuelto" style="margin-top: -10px;"></h1>
              </div>
            </div>
            <!-- <h4 class="text-red" style="margin-top: -5px;"> Vuelto $:</h4>
            <h1 class="text-red" id="importeVuelto" style="margin-top: -10px;"></h1> -->
          </div>

        </div>

        <!-- Error -->
        <div class="row"> 
          <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissable" id="errorMP" style="display: none">
                  <h4><i class="icon fa fa-ban"></i> Error!</h4>
                  Revise que todos los campos esten completos
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSaveCobroModal" disabled>Cobrar</button>
      </div>
    </div>
  </div>
</div>

<script>
//Inicializar control 
$("#medImporte").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
$("#medDescuento").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
$('#divImporte').hide(); 
$('#divAdicional').hide();
$('#divPagosRealizados').html('');
//variables para el modal 
var focoEnTipo = 0;
var orden;
var medios;
var ordenMedio;
var idTipoSeleccionado;
var idMedioSeleccionado;
var pagos = [];
var importeAPagar = 0;
var importeSaldoAPagar = 0;
var idOrdenSeleccionada = 0;
//Inicializar funcion
CalcularPagos();
//Abrir el modal para la cobranza.
function cobrarMedios(ordId, importe){
    idOrdenSeleccionada = ordId;
    importeAPagar = importeSaldoAPagar = importe;
    pagos = [];
    $("#medDescuento").val(0);
    $('#divTiposMediosDePago').html('');
    $("#divMediosDePago").html('');
    $('#divPagosRealizados').html('');
    $('#divAdicional').hide();
    $('#divImporte').hide();
    $('#agregarPago').hide();
    WaitingOpen();
    LoadIconAction('modalActionCobro','Add');
    $('#importeTotalaCobrar').html(parseFloat(importe).toFixed(2));
    focoEnTipo = 0;
    $.ajax({
              type: 'POST',
              data: {
                      //id : id
                    },
          url: 'index.php/box/getMedios',
          success: function(result){
                        //debugger;
                        if(result != false){
                          medios = result;
                          var html = '';
                          orden = 0;
                          result.forEach(function (e){
                            html += '<button ';
                            html += '       type="button" ';
                            html += '       class="btn btn-default btn-lg form-control input-block-level classType" ';
                            html += '       id="'+e.tmpCodigo+'" ';
                            html += '       style="padding: 6px; margin-bottom: 5px;" ';
                            html += '       value="'+orden+'">';
                            html += ' <span class="pull-left">'+e.tmpDescripción+'</span> <i class="fa fa-chevron-right pull-right"></i>';
                            html += '</button>';
                            if(orden == 0){
                              focoEnTipo = e.tmpCodigo;
                              idTipoSeleccionado = e.tmpCodigo;
                            }
                            orden++;
                          });
                          $('#divTiposMediosDePago').html(html);
                        }
                        WaitingClose()
                        CalcularPagos();
                        
                        setTimeout("$('#modalCobro').modal('show')",800);
                        setTimeout("cambiarFocoTipo('"+focoEnTipo+"')",1300);
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalCobro');
                medios = false;
              },
              dataType: 'json'
          });
}

//Funcion para setear el foco y cambiar las clases
function cambiarFocoTipo(code){
  $('.classType').removeClass("btn-primary");
  $('.classType').addClass("btn-default");
  $('#'+code).removeClass("btn-default");
  $('#'+code).addClass("btn-primary");
  $('#'+code).focus();
  $('#divImporte').hide();
  $('#divAdicional').hide();
  $('#agregarPago').hide();
}

$(document).on('click','.classType',function(event){
  var button = $(this);
  idTipoSeleccionado = button.attr('id');
  cambiarFocoTipo(button.attr('id'));
  MediosDePago(button.attr('id'));
});

$(document).on('keyup','.classType',function(event){
  var button = $(this);
  var ordenSeleccionado = parseInt(button.attr('value'));


  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13' || keycode == '39'){
       MediosDePago(button.attr('id'));
  }

  //Abajo
  if(keycode == '40'){
    if(ordenSeleccionado < orden){
      //Busco el foco para el otro boton por el value
      $("#divTiposMediosDePago").find('.classType').each(function(){
        if(parseInt($.trim($(this).attr('value')))== (ordenSeleccionado + 1)){
          cambiarFocoTipo($(this).attr('id'));
          idTipoSeleccionado = $(this).attr('id');
          ordenSeleccionado++;
          return false;
        }
      });
    }
  }

  //Arriba
  if(keycode == '38'){
    if(ordenSeleccionado > 0){
      //Busco el foco para el otro boton por el value
      $("#divTiposMediosDePago").find('.classType').each(function(){
        if(parseInt($.trim($(this).attr('value')))== (ordenSeleccionado - 1)){
          cambiarFocoTipo($(this).attr('id'));
          idTipoSeleccionado = $(this).attr('id');
          ordenSeleccionado--;
          return false;
        }
      });
    }
  }

});

function MediosDePago(id){
  medios.forEach(function (t){
    var html = '';
    if(t.tmpCodigo == id){
      ordenMedio = 0;
      t.medios.forEach(function (m){
        html += '<button ';
        html += '       type="button" ';
        html += '       class="btn btn-default btn-lg form-control input-block-level classMedio" ';
        html += '       id="'+m.medCodigo+'" ';
        html += '       style="padding: 6px; margin-bottom: 5px;" ';
        html += '       value="'+ordenMedio+'">';
        html += ' <span class="pull-left">'+m.medDescripcion+'</span> <i class="fa fa-chevron-right pull-right"></i>';
        html += '</button>';
        if(ordenMedio == 0){
          focoEnMedio = m.medCodigo;
        }
        ordenMedio++;
      });
      $('#divMediosDePago').html(html);
      cambiarFocoMedio(focoEnMedio);
    }
  });
}

function cambiarFocoMedio(code){
  $('.classMedio').removeClass("btn-primary");
  $('.classMedio').addClass("btn-default");
  $('#'+code).removeClass("btn-default");
  $('#'+code).addClass("btn-primary");
  $('#'+code).focus();
  $('#divImporte').hide();
  $('#divAdicional').hide();
  $('#agregarPago').hide();
}

$(document).on('click','.classMedio',function(event){
  var button = $(this);
  cambiarFocoMedio(button.attr('id'));
  idMedioSeleccionado = button.attr('id');
  if(importeSaldoAPagar > 0)
        $('#medImporte').val(parseFloat(importeSaldoAPagar).toFixed(2));
        else
        $('#medImporte').val(0);
  $('#divImporte').show();
  $('#divAdicional').show();
  $('#agregarPago').show();
  setTimeout("$('#medImporte').focus();",100);
  setTimeout("$('#medImporte').select();",110);
});

$(document).on('keyup','.classMedio',function(event){
  var button = $(this);
  var ordenSeleccionado = parseInt(button.attr('value'));


  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13' || keycode == '39'){
       TipoMedioDePago(button.attr('id'));
       if(importeSaldoAPagar > 0)
        $('#medImporte').val(parseFloat(importeSaldoAPagar).toFixed(2));
        else
        $('#medImporte').val(0);
       $('#divImporte').show();
       $('#divAdicional').show();
       $('#agregarPago').show();
       setTimeout("$('#medImporte').focus();",100);
       setTimeout("$('#medImporte').select();",110);
       idMedioSeleccionado = button.attr('id');
  }

  //Abajo
  if(keycode == '40'){
    if(ordenSeleccionado < ordenMedio){
      //Busco el foco para el otro boton por el value
      $("#divMediosDePago").find('.classMedio').each(function(){
        if(parseInt($.trim($(this).attr('value')))== (ordenSeleccionado + 1)){
          cambiarFocoMedio($(this).attr('id'));
          idMedioSeleccionado = $(this).attr('id');
          ordenSeleccionado++;
          return false;
        }
      });
    }
  }

  //Arriba
  if(keycode == '38'){
    if(ordenSeleccionado > 0){
      //Busco el foco para el otro boton por el value
      $("#divMediosDePago").find('.classMedio').each(function(){
        if(parseInt($.trim($(this).attr('value')))== (ordenSeleccionado - 1)){
          cambiarFocoMedio($(this).attr('id'));
          idMedioSeleccionado = $(this).attr('id');
          ordenSeleccionado--;
          return false;
        }
      });
    }
  }

  //Izquierda
  if(keycode == '37'){    
      $("#divMediosDePago").html('');
      cambiarFocoTipo(idTipoSeleccionado);
  }

});

function TipoMedioDePago(code){
  medios.forEach(function (t){
    var html = '';
    t.medios.forEach(function (m){
        if(m.medCodigo == code){
          $('#tmpDescripcion1').val('');
          if(t.tmpDescripcion1 != null){
            $('#tmpDato1').show();
            $('#tmpDescripcion1').attr('placeholder', t.tmpDescripcion1);
          } else { $('#tmpDato1').hide(); }
          $('#tmpDescripcion2').val('');
          if(t.tmpDescripcion2 != null){
            $('#tmpDato2').show();
            $('#tmpDescripcion2').attr('placeholder', t.tmpDescripcion2);
          } else { $('#tmpDato2').hide(); }
          $('#tmpDescripcion3').val('');
          if(t.tmpDescripcion3 != null){
            $('#tmpDato3').show();
            $('#tmpDescripcion3').attr('placeholder', t.tmpDescripcion3);
          } else { $('#tmpDato3').hide(); }
          return false;
        }
        
      });
  });
}

$(document).on('keyup','.importe',function(event){
  //var button = $(this);
  //var ordenSeleccionado = parseInt(button.attr('value'));


  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
      if(parseFloat($('#medImporte').val()) > 0)
        $('#btnAddPago').focus();
  }

  //Abajo
  if(keycode == '40'){
    if(parseFloat($('#medImporte').val()) > 0)
        $('#btnAddPago').focus();
  }

  //Arriba
  if(keycode == '38'){
    cambiarFocoMedio(idMedioSeleccionado);
  }

  //Izquierda
  if(keycode == '37'){    
    cambiarFocoMedio(idMedioSeleccionado);
  }

});

$('#btnAddPago').click(function(){  
  if(parseFloat($('#medImporte').val()) > 0){
    if(idMedioSeleccionado == 'EFE'){
      agregarMedio();
    } else {
      if(importeSaldoAPagar >= parseFloat($('#medImporte').val()).toFixed(2)){
        agregarMedio();
      } else{
        setTimeout("$('#medImporte').focus();",100);
        setTimeout("$('#medImporte').select();",110);
      }
    }   
  }
});

var indiceMedio = 1310;
function agregarMedio(){
  //Agregar medio de pago
  indiceMedio++;
  var html = '<div class="row" id="'+indiceMedio+'">';
  html+= '<div class="col-xs-2"> <i class="fa fa-fw fa-close text-red" style="cursor:pointer" onclick="eliminarDiv('+indiceMedio+', \''+idMedioSeleccionado+'\')"></i> </div>';
  html+= '<div class="col-xs-3"> ' + idMedioSeleccionado + ' </div>';
  html+= '<div class="col-xs-7"> $ ' + parseFloat($('#medImporte').val()).toFixed(2) + ' </div>';
  $('#divPagosRealizados').append(html);
  cambiarFocoTipo(idTipoSeleccionado);
  var object = {
    medioCode:          idMedioSeleccionado,
    medioImport:        parseFloat($('#medImporte').val()).toFixed(2),
    medioDesc1:         $('#tmpDescripcion1').val(),
    medioDesc2:         $('#tmpDescripcion2').val(),
    medioDesc3:         $('#tmpDescripcion3').val()
  };
  pagos.push(object);
  CalcularPagos();
}

function CalcularPagos(){
  var totalPagos = 0;
  if(pagos.length > 0){
    pagos.forEach(function (p){
      totalPagos += parseFloat(p.medioImport);
    });
  }

  var descuento = 0;
  if( $('#medDescuento').val() != ''){
    descuento = parseFloat($('#medDescuento').val());
  }

  importeSaldoAPagar = importeAPagar - (totalPagos + descuento);
  if(importeSaldoAPagar <= 0 && importeAPagar > 0){
    $('#btnSaveCobroModal').removeAttr("disabled");
    $('#btnSaveCobroModal').focus();
  } else {
    $('#btnSaveCobroModal').attr('disabled', 'disabled');
  }

  $('#importeTotalPagado').html(totalPagos.toFixed(2));
  if(importeSaldoAPagar == (importeAPagar - descuento) || totalPagos < (importeAPagar - descuento))
    $('#importeVuelto').html('0.00');
    else
    $('#importeVuelto').html(Math.abs(importeSaldoAPagar).toFixed(2));
}

function eliminarDiv(id, idMedio){
  $('#'+id).remove();
  quitarMedio(idMedio);
}

function quitarMedio(id){
  var pagosAux = [];
  pagos.forEach(function (p){
    if(p.medioCode != id){
      pagosAux.push(p);
    }
  });

  pagos = pagosAux;
  CalcularPagos();
}

$(document).on('keyup','.cuerpo',function(event){
  if( event.which === 68 && event.shiftKey ){
         $('#medDescuento').focus();
  }
});

$(document).on('keyup','.descuento',function(event){
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    CalcularPagos();
  }
});

$('#btnSaveCobroModal').click(function(){
  debugger;
  Cobrar_(0);
});

// $('#btnServiceEfectivo').click(function(){
//   $('#efectivo').val($('#totalSale').html().replace('.',','));
//   Cobrar_(0);
// });

function Cobrar_(esPresupuesto){
  if($('#venId').val() == 0 || $('#venId').val() == undefined || $('#venId').val() == -1)
    return false;
  //Barrer Informacion
  //Id de la operación
  var opId = -1;
  //Lista de Precio y su porcentaje-----------------------
  var selected = $('#lpId').find('option:selected');
  var lp = {
            id:   $('#lpId').val(),
            por:  parseFloat(selected.data('porcent'))
          };
  //Cliente-----------------------------------------------
  var cli = {
              id: $('#cliId').val()
          };
  //Vendedor----------------------------------------------
  var ven = {
              id:  $('#venId').val()
            };
  //Detalle de la compra-----------------------------------
  var table = $('#detailSale > tbody> tr');
  var detalle = [];
  table.each(function(r) {
    var object = {
      artId:          (this.children[6].textContent == '-' ? '-' : parseInt(this.children[6].textContent)),
      cant:           parseFloat(this.children[3].textContent),
      artDescripcion: this.children[2].textContent,
      artCosto:       parseFloat(this.children[7].textContent),
      artventa:       parseFloat(this.children[4].textContent),
      artventaSD:     parseFloat(this.children[9].textContent), //Venta sin descuentos
      artCode:        this.children[1].textContent,
      actualizaStock: parseInt(this.children[8].textContent)
    };
    detalle.push(object);
  });
  //Medios de Pago-----------------------------------------
  var medios = [];
  if(esPresupuesto == 0){
    medios = pagos;
    //Descuento--------------------------------------------
    var desc = parseFloat($('#medDescuento').val() == '' ? 0 : ($('#medDescuento').val().replace('.','')).replace(',','.'));
  } else {
    var desc = 0;
  }

  WaitingOpen('Guardando venta');
    $.ajax({
          type: 'POST',
          data: {
                  lpr:      lp,
                  clie:     cli,
                  vend:     ven,
                  medi:     pagos,
                  des:      desc,
                  det:      detalle,
                  esPre:    esPresupuesto,
                  oId:      opId
                },
      url: 'index.php/sale/setSaleMinorista',
      success: function(result){
                    WaitingClose();
                    $('#modalCobro').modal('hide');
                    setTimeout("cargarView('sale', 'minorista', '');",300);
            },
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalCobro');
          },
          dataType: 'json'
      });
};
</script>