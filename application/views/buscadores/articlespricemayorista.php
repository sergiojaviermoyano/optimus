<!-- Modal -->
<div class="modal fade" id="buscadorArticlesPriceMayorista" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 80%" ><!--style="width: 50%"-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-search" style="color: #3c8dbc"></i> Buscar Artículo</h4>
      </div>
      <div class="modal-body" id="buscadorArticlesPriceMayoristaBody">

        <div class="row">
          <div class="col-xs-10 col-xs-offset-1"><input type="text" class="form-control" id="txtArtPriceMayorista" value=""></div>
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
var id____, detail____, nextFocus____, price____;
var timer___, timeout___ = 1000;
var row___ = 0, rows___ = 0;
var move___ = 0;
var minLenght___ = 0;
function buscadorArticlesPriceMayorista(string, id, detail, nextFocus, price){
  id____ = id;
  detail____ = detail;
  nextFocus____ = nextFocus;
  price____ = price;
  $('#txtArtPriceMayorista').val(string);
  $('#tableArtPriceDetail > tbody').html('');
  //$('#buscadorArticlesPrice').modal('show');
  setTimeout(function () { $('#txtArtPriceMayorista').focus(); BuscarArticlePriceMayorista();}, 1000);
}

function BuscarArticlePriceMayorista(){
  if($('#txtArtPriceMayorista').val().length > minLenght___){
    //Buscar
    $("#loadingArtPrice").show();
    $('#tableArtPriceDetail > tbody').html('');
    row___ = 0;
    rows___ = 0;
    $.ajax({
          type: 'POST',
          data: { str: $('#txtArtPriceMayorista').val() },
          url: 'index.php/article/buscadorArticlesPriceMayorista',
          success: function(resultList){
                        if(resultList != false){
                          if(resultList.length == 1){
                              seleccionarArticlePriceMayorista(resultList[0].artId, resultList[0].artDescription, calcularPrecioInternoMayorista(resultList[0]));
                          } else {
                            $.each(resultList, function(index, result){
                                var row____ = '<tr>';
                                row____ += '<td width="1%"><i style="color: #00a65a; cursor: pointer;" class="fa fa-fw fa-check-square"';
                                row____ += 'onClick="seleccionarArticlePriceMayorista(' + result.artId + ', \'' + result.artDescription + '\', ' + calcularPrecioInternoMayorista(result) + ')"></i></td>';
                                row____ += '<td>'+result.artBarcode+'</td>';
                                row____ += '<td>'+result.artDescription+'</td>';
                                row____ += '<td style="text-align: right"> $ ' + calcularPrecioInternoMayorista(result).toFixed(2) + '</td>';
                                row____ += '<td style="display: none">'+result.artId+'</td>';
                                row____ += '<td style="text-align: right">'+(result.stock == null ? '0.00' : result.stock)+'</td>';
                                row____ += '<td style="text-align: right; color: orange;">'+(result.reserva == null ? '0.00' : result.reserva)+'</td>';
                                row____ += '</tr>';
                                $('#tableArtPriceDetail > tbody').prepend(row____);
                                rows___++;
                            });

                            if ($('#buscadorArticlesPriceMayorista').data('bs.modal') && $('#buscadorArticlesPriceMayorista').data('bs.modal').isShown){
                              $("#loadingArtPrice").hide();
                              $('#txtArtPriceMayorista').focus();
                            }else {
                              //Cerrado
                              $("#loadingArtPrice").hide();
                              $('#buscadorArticlesPriceMayorista').modal('show');
                              setTimeout(function () { $('#txtArtPriceMayorista').focus();}, 1000);
                            }


                          }
                        }else {
                            detail____.prop('disabled', false);
                            detail____.focus();
                            $('#divBuscador').addClass('has-error');
                            setTimeout(function () { $('#divBuscador').removeClass('has-error');}, 1000);
                        }
                },
          error: function(result){
                $("#loadingArtPrice").hide();
                ProcesarError(result.responseText, 'buscadorArticlesPriceMayorista');
              },
              dataType: 'json'
      });
  }
}

$('#buscadorArticlesPriceMayorista').on('hidden.bs.modal', function() {
  $('#lblProducto').prop('disabled', false);
  $('#lblProducto').focus().select();
})

  $('#txtArtPriceMayorista').keyup(function(e){
    var code = e.which;
    if(code != 40 && code != 38 && code != 13){
      if($('#txtArtPriceMayorista').val().length >= minLenght___){
        // Clear timer if it's set.
        if (typeof timer___ != undefined)
          clearTimeout(timer___);

        // Set status to show we're typing.
        //$("#status").html("Typing ...").css("color", "#009900");

        timer___ = setTimeout(function()
        {
          //$("#status").html("Stopped").css("color", "#990000");
          $("#loadingArtPrice").show();
          BuscarArticlePriceMayorista();
          row___ = 0;
        }, timeout___);
      }
    } else {
      var removeStyle = $("#tableArtPriceDetail > tbody tr:nth-child("+row___+")");
      if(code == 13){//Seleccionado
        removeStyle.css('background-color', 'white');
        seleccionarArticlePriceMayorista(
                          $('#tableArtPriceDetail tbody tr:nth-child('+row___+') td:nth-child(5)')[0].innerHTML,
                          $('#tableArtPriceDetail tbody tr:nth-child('+row___+') td:nth-child(3)')[0].innerHTML,
                          ($('#tableArtPriceDetail tbody tr:nth-child('+row___+') td:nth-child(4)')[0].innerHTML).replace('$', '').trim()
                        );
      }

      if(code == 40){//abajo
        if((row___ + 1) <= rows___){
          row___++;
          if(row___ > 5){
          }
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtPriceDetail > tbody tr:nth-child("+row___+")");
        rowE.css('background-color', '#D8D8D8');
        //animate();
      }
      if(code == 38) {//arriba
        if(row___ >= 2){
          row___--;
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtPriceDetail > tbody tr:nth-child("+row___+")");
        rowE.css('background-color', '#D8D8D8');
        //animate();
      }
    }
  });

function seleccionarArticlePriceMayorista(id, desc, price){
    id____.val(id);
    detail____.val(desc);
    price____.html('$'+parseFloat(price).toFixed(2));
    $('#buscadorArticlesPriceMayorista').modal('hide');
    $('#lblProducto').prop('disabled', false);
    setTimeout(function () { nextFocus____.focus(); nextFocus____.select()}, 800);
}

function calcularPrecioInternoMayorista(article){
  var precioCosto 				= article['artCoste'];
	var cotizacionDolar 		= article['dolar'];
  var margenMa      			= article['artMarginMayorista'];
  var margenMaEsPor 			= article['artMarginMayoristaIsPorcent'];

  var pventaMayorista = 0;

	//Precio en Dolar
  if(article['artCosteIsDolar'] == "0")
    cotizacionDolar = 1;
	var precioCosto = precioCosto * cotizacionDolar;

  //Mayorista
  if(margenMaEsPor == true || margenMaEsPor == "1"){
    var importe = (parseFloat(margenMa) / 100) * parseFloat(precioCosto);
    pventaMayorista = parseFloat(parseFloat(importe) + parseFloat(precioCosto));
  } else {
    pventaMayorista = parseFloat(parseFloat(precioCosto) + parseFloat(margenMa));
  }

	return pventaMayorista;
}

</script>
