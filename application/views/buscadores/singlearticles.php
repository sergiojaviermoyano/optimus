<!-- Modal -->
<div class="modal fade" id="buscadorArticlesSingles" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" ><!--style="width: 50%"-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-search" style="color: #3c8dbc"></i> Buscar Artículo</h4>
      </div>
      <div class="modal-body" id="buscadorBancosBody">

        <div class="row">
          <div class="col-xs-10 col-xs-offset-1"><input type="text" class="form-control" id="txtArt" value=""></div>
          <div class="col-xs-1"><img style="display: none" id="loadingArt" src="<?php  echo base_url();?>assets/images/loading.gif" width="35px"></div>
            <!--
            <input type="text" id="type" />
            <span id="status"></span>
            -->
        </div><br>

        <div class="row" style="max-height:350px; overflow-x: auto;" id="tableArt">
          <div class="col-xs-10 col-xs-offset-1">
            <table id="tableArtDetail" style="max-height:340px; display: table;" class="table table-bordered" width="100%">
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
var id_, detail_, nextFocus_;
var timer, timeout = 1000;
var row = 0, rows = 0;
var move = 0;
var minLenght = 0;
function buscadorArticlesSingles(string, id, detail, nextFocus){
  id_ = id;
  detail_ = detail;
  nextFocus_ = nextFocus;
  $('#txtArt').val(string);
  $('#tableArtDetail > tbody').html('');
  $('#buscadorArticlesSingles').modal('show');
  setTimeout(function () { $('#txtArt').focus(); BuscarArticleIn();}, 1000);
}

function BuscarArticleIn(){
  if($('#txtArt').val().length > minLenght){
    //Buscar 
    $("#loadingArt").show();
    $('#tableArtDetail > tbody').html('');
    row = 0;
    rows = 0;
    $.ajax({
          type: 'POST',
          data: { str: $('#txtArt').val() },
          url: 'index.php/article/buscadorArticlesSingles',
          success: function(resultList){
                        if(resultList != false){
                          $.each(resultList, function(index, result){
                              var row_ = '<tr>';
                              row_ += '<td width="1%"><i style="color: #00a65a; cursor: pointer;" class="fa fa-fw fa-check-square"';
                              row_ += 'onClick="seleccionarArticle('+result.artId+', \''+result.artDescription+'\')"></i></td>';
                              row_ += '<td>'+result.artBarcode+'</td>';
                              row_ += '<td>'+result.artDescription+'</td>';
                              row_ += '<td style="display: none">'+result.artId+'</td>';
                              row_ += '</tr>';
                              $('#tableArtDetail > tbody').prepend(row_);
                              rows++;
                          });
                          $('#txtArt').focus();
                        }
                        $("#loadingArt").hide();
                },
          error: function(result){
                $("#loadingArt").hide();
                ProcesarError(result.responseText, 'buscadorArticlesSingles');
              },
              dataType: 'json'
      });
  }
}

  $('#txtArt').keyup(function(e){
    var code = e.which;
    if(code != 40 && code != 38 && code != 13){
      if($('#txtArt').val().length >= minLenght){
        // Clear timer if it's set.
        if (typeof timer != undefined)
          clearTimeout(timer);

        // Set status to show we're typing.
        //$("#status").html("Typing ...").css("color", "#009900");
        
        
        timer = setTimeout(function()
        {
          //$("#status").html("Stopped").css("color", "#990000");
          $("#loadingArt").show();
          BuscarArticleIn();
          row = 0;
        }, timeout);
      }
    } else {
      var removeStyle = $("#tableArtDetail > tbody tr:nth-child("+row+")");
      if(code == 13){//Seleccionado
        removeStyle.css('background-color', 'white');
        seleccionarArticle(
                          $('#tableArtDetail tbody tr:nth-child('+row+') td:nth-child(4)')[0].innerHTML,
                          $('#tableArtDetail tbody tr:nth-child('+row+') td:nth-child(3)')[0].innerHTML
                        );
      }

      if(code == 40){//abajo
        if((row + 1) <= rows){
          row++;
          if(row > 5){
          }
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtDetail > tbody tr:nth-child("+row+")");
        rowE.css('background-color', '#D8D8D8');
        animate();
      } 
      if(code == 38) {//arriba
        if(row >= 2){
          row--;
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableArtDetail > tbody tr:nth-child("+row+")");
        rowE.css('background-color', '#D8D8D8');
        animate();
      }
    }
  });

function seleccionarArticle(id, desc){
    id_.val(id);
    detail_.val(desc);
    $('#buscadorArticlesSingles').modal('hide');
    setTimeout(function () { nextFocus_.focus(); }, 800);
}

</script>