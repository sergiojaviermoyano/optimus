<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Actualizar Precios Manual</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-horizontal">

          <div class="form-group">
            <label for="subrId" class="control-label col-sm-4">Marca</label>
            <div class="col-sm-6">
              <select class="form-control" name="marcId" id="marcId">
                <option value=""></option>
                <?php foreach($brands as $key => $brand ):?>
                    <option value="<?php echo $brand['id']?>"><?php echo $brand['descripcion']?></option>
                  <?php endforeach;?>
              </select>
            </div>
          </div>

            <div class="form-group">
              <label for="rubId" class="control-label col-sm-4">Rubro</label>
              <div class="col-sm-6">
                <select class="form-control" name="rubId" id="rubId">
                  <option value=""></option>
                  <?php foreach($rubros as $key => $rubro ):?>
                    <option value="<?php echo $rubro['rubId']?>"><?php echo $rubro['rubDescripcion']?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>


          <div class="form-group">
            <label for="subrId" class="control-label col-sm-4">Sub Rubro</label>
            <div class="col-sm-6">
              <select class="form-control" name="subrId" id="subrId">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="subrId" class="control-label col-sm-4">Es Procentaje</label>
            <div class="col-sm-6">
              <label class="radio-inline">
                <input type="checkbox" name="artMarginIsPorcent" id="artMarginIsPorcent" value="1" >
              </label>
            </div>
          </div>

          <div class="form-group">
            <label for="subrId" class="control-label col-sm-4">Importe a Actualizar</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="incrementValue" id="incrementValue" value="">
            </div>
          </div>

          <!--<button type="submit" name="bt_update" id="bt_update" class="btn btn-success pull-right"> Buscar </button>-->
          <button name="bt_buscar" id="bt_buscar" class="btn btn-success pull-right"> Buscar </button>
        </div>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Artículos</h3>
        </div>

        <div class="box-body">
          <button name="bt_buscar" id="bt_update" class="btn btn-info pull-right" style="margin-bottom: 5px;"> Actualizar </button>
          <table id="articles__u" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="2%">Sel.</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>PC Actual</th>
                <th>PV Actual</th>
                <th>PC Nuevo</th>
                <th>PV Nuevo</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section><!-- /.content -->

<script type="text/javascript">
  $(function(){

    $("#incrementValue").maskMoney({allowNegative: true, thousands:'', decimal:'.'});


    $("#rubId").on('change',function(){
      var rubId=$(this).val();
      WaitingOpen('Cargando Subrubro');
        $.ajax({
              method: 'GET',
              data: { rubId : rubId},
              url: 'index.php/rubro/getSubRubro_by_rubro',
              success: function(result){
                 WaitingClose();
                 $("#subrId").empty();
                 var output ='<option value=""> Seleccione SubRubro</option>';
                 $.each(result,function(index,item){
                   output +='<option value="'+item.subrId+'"> '+item.subrDescripcion+'</option>';
                 });
                 $("#subrId").html(output);
               },
               error: function(result){
                 WaitingClose();
                 ProcesarError(result.responseText, 'modalRubro');
              },
              dataType: 'json'
          });
    });

    $('#bt_buscar').click(function(){
      if($('#incrementValue').val() != ''){
        if( $('#marcId').val() == '' &&
            $('#rubId').val() == '' &&
            $('#subrId').val() == ''
          ){
          return;
        } else {
          WaitingOpen('Buscando');
          $('#articles__u > tbody').html('');
          $.ajax({
              method: 'POST',
              data:{
                  mar: $('#marcId').val(),
                  rub: $('#rubId').val(),
                  sub: $('#subrId').val()
              },
              url: 'index.php/article/get_for_update_prices_by_rubro',
              success: function(result){
                if(result == false)
                  WaitingClose();
                else{
                        var rows = '';
                        var nuevoCosto;
                        $.each(result, function(key, obj){
                            rows += '<tr>';
                            rows += '<td style="text-align: center"><input type="checkbox" value="'+obj['artId']+'" checked></td>';
                            rows += '<td>' + obj['artBarCode'] + '</td>';
                            rows += '<td>' + (obj['artCosteIsDolar'] == 1 ? '<span class="bg-green" style="margin-right: 5px">U$D</span>': '') + obj['artDescription'] + '</td>';
                            rows += '<td style="text-align: right">' + obj['artCoste'] + '</td>';
                            rows += '<td style="text-align: right">' + parseFloat(calcula(obj['artCoste'], obj['artMarginMinoristaIsPorcent'], obj['artMarginMinorista'])).toFixed(2) + '</td>';
                            nuevoCosto = parseFloat(obj['artCoste']);
                            if($('#artMarginIsPorcent').is(":checked")){
                              nuevoCosto += nuevoCosto * (parseFloat($('#incrementValue').val()) / 100);
                            } else {
                              nuevoCosto += parseFloat($('#incrementValue').val());
                            }
                            rows += '<td style="text-align: right">' + parseFloat(nuevoCosto).toFixed(2) + '</td>';
                            rows += '<td style="text-align: right">' + parseFloat(calcula(nuevoCosto, obj['artMarginMinoristaIsPorcent'], obj['artMarginMinorista'])).toFixed(2) + '</td>';
                            rows += '</tr>';
                        });
                        $('#articles__u > tbody').html(rows);
                        WaitingClose();
                 //setTimeout("cargarView('rubro', 'upgrate', '"+$('#permission').val()+"');",1000);
                }
               },
               error: function(result){
                 WaitingClose();
                 ProcesarError(result.responseText, 'modalRubro');
              },
              dataType: 'json'
          });
        }
      }else{
        return;
      }
    });

  });

function calcula(coste, isPorcent, margin){
  if(isPorcent == true){
    return parseFloat(coste) + parseFloat(coste * (margin / 100));
  } else {
    return parseFloat(coste) + parseFloat(margin);
  }
}

$('#bt_update').click(function(){
  var detail = [];
  debugger;
      $('#articles__u > tbody > tr').each(function() {

        debugger;
        var checkbox = this.children[0].firstElementChild;
        if(checkbox.checked){
          detail.push(
                      {
                        id:     checkbox.value,
                        coste:  parseFloat(this.children[5].innerHTML).toFixed(2)
                      }
                      );
        }
      });
  if(detail.length > 0){
      WaitingOpen('Actualizando');
        $.ajax({
              method: 'POST',
              data:{
                arts: detail
              },
              url: 'index.php/article/update_prices_by_rubro',
              success: function(result){
                WaitingClose();
                setTimeout("cargarView('rubro', 'upgrate', '"+$('#permission').val()+"');",1000);
               },
               error: function(result){
                 WaitingClose();
                 ProcesarError(result.responseText, 'modalRubro');
              },
              dataType: 'json'
          });
    }else{
      return;
    }
  });

</script>
