<!-- Modal -->
<div class="modal fade" id="buscadorArticlesPrice" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 80%" ><!--style="width: 50%"-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-search" style="color: #3c8dbc"></i> Buscar Artículo</h4>
      </div>
      <div class="modal-body" id="buscadorArticlesPriceBody">

        <div class="row">
          <div class="col-xs-10 col-xs-offset-1"><input type="text" class="form-control" id="txtArtPrice" value=""></div>
          <div class="col-xs-1"><img style="display: none" id="loadingArtPrice" src="<?php  echo base_url();?>assets/images/loading.gif" width="35px"></div>
            <!--
            <input type="text" id="type" />
            <span id="status"></span>
            -->
        </div><br>

        <div class="row" style="max-height:350px; overflow-x: auto;" id="tableArtPr">
          <div class="col-xs-10 col-xs-offset-1">
            <table id="tableArtPriceDetail" style="max-height:340px; display: table;" class="table table-bordered" width="100%">
              <tbody>

              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
var id___, detail___, nextFocus___, price___;
var timer__, timeout__ = 1000;
var row__ = 0, rows__ = 0;
var move__ = 0;
var minLenght__ = 0;
function buscadorArticlesPrice(string, id, detail, nextFocus, price){
  id___ = id;
  detail___ = detail;
  nextFocus___ = nextFocus;
  price___ = price;
  $('#txtArtPrice').val(string);
  $('#tableArtPriceDetail > tbody').html('');
  //$('#buscadorArticlesPrice').modal('show');
  setTimeout(function () { $('#txtArtPrice').focus(); BuscarArticlePrice();}, 1000);
}

function BuscarArticlePrice(){
  if($('#txtArtPrice').val().length > minLenght__){
    //Buscar
    $("#loadingArtPrice").show();
    $('#tableArtPriceDetail > tbody').html('');
    row__ = 0;
    rows__ = 0;
    $.ajax({
          type: 'POST',
          data: { str: $('#txtArtPrice').val() },
          url: 'index.php/article/buscadorArticlesPrice',
          success: function(resultList){
                        if(resultList != false){
                          if(resultList.length == 1){
                              seleccionarArticlePrice(resultList[0].artId, resultList[0].artDescription, calcularPrecioInterno(resultList[0]));
                          } else {

                            $.each(resultList, function(index, result){
                                var row___ = '<tr>';
                                row___ += '<td width="1%"><i style="color: #00a65a; cursor: pointer;" class="fa fa-fw fa-check-square"';
                                row___ += 'onClick="seleccionarArticlePrice(' + result.artId + ', \'' + result.artDescription + '\', ' + calcularPrecioInterno(result) + ')"></i></td>';
                                row___ += '<td>'+result.artBarcode+'</td>';
                                row___ += '<td>'+result.artDescription+'</td>';
                                row___ += '<td style="text-align: right"> $ ' + calcularPrecioInterno(result).toFixed(2) + '</td>';
                                row___ += '<td style="display: none">'+result.artId+'</td>';
                                row___ += '<td style="text-align: right">'+(result.stock == null ? '0.00' : result.stock)+'</td>';
                                //row___ += '<td style="text-align: right; color: orange;">'+(result.reserva == null ? '0.00' : result.reserva)+'</td>';
                                row___ += '</tr>';
                                $('#tableArtPriceDetail > tbody').prepend(row___);
                                rows__++;
                            });

                            if ($('#buscadorArticlesPrice').data('bs.modal') && $('#buscadorArticlesPrice').data('bs.modal').isShown){
                              $("#loadingArtPrice").hide();
                              $('#txtArtPrice').focus();
                            }else {
                              //Cerrado
                              $("#loadingArtPrice").hide();
                              $('#buscadorArticlesPrice').modal('show');
                              setTimeout(function () { $('#txtArtPrice').focus();}, 1000);
                            }
                          }
                        } else {
                            detail___.prop('disabled', false);
                            detail___.focus();
                            $('#divBuscador').addClass('has-error');
                            setTimeout(function () { $('#divBuscador').removeClass('has-error');}, 1000);
                        }
                },
          error: function(result){
                $("#loadingArtPrice").hide();
                ProcesarError(result.responseText, 'buscadorArticlesPrice');
              },
              dataType: 'json'
      });
  }
}

$('#buscadorArticlesPrice').on('hidden.bs.modal', function() {
  $('#lblProducto').prop('disabled', false);
  $('#lblProducto').focus().select();
})

  $('#txtArtPrice').keyup(function(e){
    var code = e.which;
    if(code != 40 && code != 38 && code != 13){
      if($('#txtArtPrice').val().length >= minLenght__){
        // Clear timer if it's set.
        if (typeof timer__ != undefined)
          clearTimeout(timer__);

        // Set status to show we're typing.
        //$("#status").html("Typing ...").css("color", "#009900");

        timer__ = setTimeout(function()
        {
          //$("#status").html("Stopped").css("color", "#990000");
          $("#loadingArtPrice").show();
          BuscarArticlePrice();
          row__ = 0;
        }, timeout__);
      }
    } else {
      var removeStyle = $("#tableArtPriceDetail > tbody tr:nth-child("+row__+")");
      if(code == 13){//Seleccionado
        removeStyle.css('background-color', 'white');
        seleccionarArticlePrice(
                          $('#tableArtPriceDetail tbody tr:nth-child('+row__+') td:nth-child(5)')[0].innerHTML,
                          $('#tableArtPriceDetail tbody tr:nth-child('+row__+') td:nth-child(3)')[0].innerHTML,
                          ($('#tableArtPriceDetail tbody tr:nth-child('+row__+') td:nth-child(4)')[0].innerHTML).replace('$', '').trim()
                        );
      }

      if(code == 40){//abajo
        if((row__ + 1) <= rows__){
          row__++;
          if(row__ > 5){
          }
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtPriceDetail > tbody tr:nth-child("+row__+")");
        rowE.css('background-color', '#D8D8D8');
        //animate();
      }
      if(code == 38) {//arriba
        if(row__ >= 2){
          row__--;
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtPriceDetail > tbody tr:nth-child("+row__+")");
        rowE.css('background-color', '#D8D8D8');
        //animate();
      }
    }
  });

function seleccionarArticlePrice(id, desc, price){
    id___.val(id);
    detail___.val(desc);
    price___.html('$'+parseFloat(price).toFixed(2));
    $('#buscadorArticlesPrice').modal('hide');
    $('#lblProducto').prop('disabled', false);
    setTimeout(function () { nextFocus___.focus(); nextFocus___.select()}, 800);
}

function calcularPrecioInterno(article){
  var precioCosto 				= article['artCoste'];
	var cotizacionDolar 		= article['dolar'];
  var margenMi      			= article['artMarginMinorista'];
  var margenMiEsPor 			= article['artMarginMinoristaIsPorcent'];

  var pventaMinorista = 0;

	//Precio en Dolar
  if(article['artCosteIsDolar'] == "0")
    cotizacionDolar = 1;
	var precioCosto = precioCosto * cotizacionDolar;

  //Minorista
  if(margenMiEsPor == true || margenMiEsPor == "1"){
    var importe = (parseFloat(margenMi) / 100) * parseFloat(precioCosto);
    pventaMinorista = parseFloat(parseFloat(importe) + parseFloat(precioCosto));
  } else {
    pventaMinorista = parseFloat(parseFloat(precioCosto) + parseFloat(margenMi));
  }

	return pventaMinorista;
}

</script>
