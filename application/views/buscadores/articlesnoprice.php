<!-- Modal -->
<div class="modal fade" id="buscadorArticlesNoPrice" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%"><!---->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-search" style="color: #3c8dbc"></i> Buscar Artículo</h4>
      </div>
      <div class="modal-body" id="buscadorArticlesNoPriceBody">

        <div class="row">
          <div class="col-xs-10 col-xs-offset-1"><input type="text" class="form-control" id="txtArtNoPrice" value=""></div>
          <div class="col-xs-1"><img style="display: none" id="loadingArtNoPrice" src="<?php  echo base_url();?>assets/images/loading.gif" width="35px"></div>
            <!--
            <input type="text" id="type" />
            <span id="status"></span>
            -->
        </div><br>

        <div class="row" style="max-height:350px; overflow-x: auto;" id="tableArt">
          <div class="col-xs-10 col-xs-offset-1">
            <table id="tableArtNoPriceDetail" style="max-height:340px; display: table;" class="table table-bordered" width="100%">
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
var id__, detail__, nextFocus__;
var timer_, timeout_ = 1000;
var row_ = 0, rows_ = 0;
var move_ = 0;
var minLenght_ = 0;
function buscadorArticlesNoPrice(string, id, detail, nextFocus){
  id__ = id;
  detail__ = detail;
  nextFocus__ = nextFocus;
  $('#txtArtNoPrice').val(string);
  $('#tableArtNoPriceDetail > tbody').html('');
  //$('#buscadorArticlesNoPrice').modal('show');
  setTimeout(function () { $('#txtArtNoPrice').focus(); BuscarArticleNoPrice();}, 1000);
}

function BuscarArticleNoPrice(){
  if($('#txtArtNoPrice').val().length > minLenght_){
    //Buscar
    $("#loadingArt").show();
    $('#tableArtNoPriceDetail > tbody').html('');
    row_ = 0;
    rows_ = 0;
    $.ajax({
          type: 'POST',
          data: { str: $('#txtArtNoPrice').val() },
          url: 'index.php/article/buscadorArticlesNoPrice',
          success: function(resultList){
                        if(resultList != false){
                          if(resultList.length == 1){
                              seleccionarArticleNoPrice(resultList[0].artId, resultList[0].artDescription);
                          } else {
                            $.each(resultList, function(index, result){
                                var row__ = '<tr>';
                                row__ += '<td width="1%"><i style="color: #00a65a; cursor: pointer;" class="fa fa-fw fa-check-square"';
                                row__ += 'onClick="seleccionarArticleNoPrice('+result.artId+', \''+result.artDescription+'\')"></i></td>';
                                row__ += '<td width="15%">'+result.artBarcode+'</td>';
                                row__ += '<td>'+result.artDescription+'</td>';
                                row__ += '<td>'+result.descripcion+'</td>';
                                row__ += '<td style="display: none">'+result.artId+'</td>';
                                row__ += '</tr>';
                                $('#tableArtNoPriceDetail > tbody').prepend(row__);
                                rows_++;
                            });

                            if ($('#buscadorArticlesNoPrice').data('bs.modal') && $('#buscadorArticlesNoPrice').data('bs.modal').isShown){
                              $("#loadingArtNoPrice").hide();
                              $('#txtArtNoPrice').focus();
                            }else {
                              //Cerrado
                              $("#loadingArtNoPrice").hide();
                              $('#buscadorArticlesNoPrice').modal('show');
                              setTimeout(function () { $('#txtArtNoPrice').focus();}, 1000);
                            }


                          }
                        }
                },
          error: function(result){
                $("#loadingArtNoPrice").hide();
                ProcesarError(result.responseText, 'buscadorArticlesNoPrice');
              },
              dataType: 'json'
      });
  }
}

  $('#txtArtNoPrice').keyup(function(e){
    var code = e.which;
    if(code != 40 && code != 38 && code != 13){
      if($('#txtArtNoPrice').val().length >= minLenght_){
        // Clear timer if it's set.
        if (typeof timer_ != undefined)
          clearTimeout(timer_);

        // Set status to show we're typing.
        //$("#status").html("Typing ...").css("color", "#009900");

        timer_ = setTimeout(function()
        {
          //$("#status").html("Stopped").css("color", "#990000");
          $("#loadingArtNoPrice").show();
          BuscarArticleNoPrice();
          row_ = 0;
        }, timeout_);
      }
    } else {
      var removeStyle = $("#tableArtNoPriceDetail > tbody tr:nth-child("+row_+")");
      if(code == 13){//Seleccionado
        removeStyle.css('background-color', 'white');
        seleccionarArticleNoPrice(
                          $('#tableArtNoPriceDetail tbody tr:nth-child('+row_+') td:nth-child(5)')[0].innerHTML,
                          $('#tableArtNoPriceDetail tbody tr:nth-child('+row_+') td:nth-child(3)')[0].innerHTML
                        );
      }

      if(code == 40){//abajo
        if((row_ + 1) <= rows_){
          row_++;
          if(row_ > 5){
          }
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtNoPriceDetail > tbody tr:nth-child("+row_+")");
        rowE.css('background-color', '#D8D8D8');
        //animate();
      }
      if(code == 38) {//arriba
        if(row_ >= 2){
          row_--;
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtNoPriceDetail > tbody tr:nth-child("+row_+")");
        rowE.css('background-color', '#D8D8D8');
        //animate();
      }
    }
  });

function seleccionarArticleNoPrice(id, desc){
    id__.val(id);
    detail__.val(desc);
    $('#buscadorArticlesNoPrice').modal('hide');
    setTimeout(function () { nextFocus__.focus(); nextFocus__.select()}, 800);
}

</script>
