<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>

<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Proveedor <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-4">
    <select class="form-control select2" id="prvId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
      <?php
        echo '<option value="-1"></option>';
        foreach ($data['providers'] as $p) {
          echo '<option value="'.$p['prvId'].'" '.($data['reception']['prvId'] == $p['prvId'] ? 'selected' : '').'>'.$p['prvRazonSocial'].' ('.$p['prvApellido'].' '.$p['prvNombre'].')</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
        }
      ?>
    </select>
    </div>

    <div class="col-xs-2">
      <label style="margin-top: 7px;">Comprobante : </label>
    </div>

    <div class="col-xs-3">
    <select class="form-control select2" id="tcId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
      <?php
        echo '<option value="-1"></option>';
        foreach ($data['tipe'] as $t) {
          echo '<option value="'.$t['tcId'].'" '.($data['reception']['tcId'] == $t['tcId'] ? 'selected' : '').'>'.$t['tcDescripcion'].'</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
        }
      ?>
    </select>
    </div>

</div><br>

<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Fecha :<strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-3">
      <input type="text" class="form-control" placeholder="dd-mm-aaaa" id="recFecha" value="<?php echo date_format(date_create($data['reception']['recFecha']), 'd-m-Y');?>" readonly="readonly" >
    </div>
  <div class="col-xs-2 col-xs-offset-1">
      <label style="margin-top: 7px;">Número : </label>
    </div>
  <div class="col-xs-3">
      <input type="text" class="form-control" placeholder="0000-00000000" id="tcNumero" value="<?php echo $data['reception']['tcNumero'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    </div>
</div><br>

<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Observación : </label>
    </div>
	<div class="col-xs-4">
      <input type="text" class="form-control" id="recObservacion" value="<?php echo $data['reception']['recObservacion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    </div>
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Importe : </label>
    </div>
  <div class="col-xs-3">
      <input type="text" class="form-control" id="tcImporte" value="<?php echo $data['reception']['tcImporte'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-12"><hr></div>
</div>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Producto: </label>
    </div>
  <div class="col-xs-5">
      <input type="hidden" id="idRec" value="">
      <input type="text" class="form-control" id="artIdRec" value="" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    </div>
  <div class="col-xs-2">
      <input type="number" class="form-control" id="artCantRec" value="1" min="1" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    </div>
  <div class="col-xs-1">
      <button type="button" class="btn btn-success" id="btnAddProdRec" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>><i class="fa fa-check"></i></button>
    </div>
</div><br>

<div class="row">
  <div class="col-xs-10 col-xs-offset-1" style="max-height: 230px; overflow: auto;">
    <table id="saleDetail" class="table table-bordered">
      <thead>
        <tr>
          <th width="1%"></th>
          <th width="10%">Código</th>
          <th>Descripción</th>
          <th width="10%">Cantidad</th>
        </tr>
      </thead>
      <!--
    </table>
    <table  style="height:auto; display:block; overflow: auto;" class="table table-bordered">
    -->
      <tbody>
      <?php
        foreach ($data['articles'] as $a) {
          echo '<tr>';
          echo '<td width="1%"></td>';
          echo '<td width="10%">'.$a['artBarCode'].'</td>';
          echo '<td>'.$a['artDescription'].'</td>';
          echo '<td width="10%" style="text-align: right">'.$a['recdCant'].'</td>';
          echo '<td style="display:none">'.$a['artId'].'</td>';
          echo '</tr>';
        }
      ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  var isOpenWindow = false;
  var rowY = 8000;

  $('#btnAddProdRec').click(function(){
    if(
      $('#artIdRec').val() != '' &&
      parseFloat($('#artCantRec').val()) > 0
      ) {
      WaitingOpen('Agregando producto');
      $.ajax({
            type: 'POST',
            data: {
                    id : $('#idRec').val()
                  },
            url: 'index.php/article/getArticleJson',
            success: function(result){
                          html = '<tr id="'+rowY+'">';
                          html+= '<td style="text-align: center" onclick="delete_('+rowY+')"><i class="fa fa-fw fa-close" style="color: #dd4b39"></i></td>';
                          html+= '<td>'+result.article.artBarCode+'</td>';
                          html+= '<td>'+result.article.artDescription+'</td>';
                          html+= '<td style="text-align: right">'+$('#artCantRec').val()+'</td>';
                          html+= '<td style="display: none">'+result.article.artId+'</td>'
                          html+= '</tr>';
                          rowY++;
                          $('#saleDetail > tbody').prepend(html);
                          $('#artIdRec').val('');
                          $('#artCantRec').val('1');
                          $('#artIdRec').focus();
                          WaitingClose();
                  },
            error: function(result){
                  WaitingClose();
                  ProcesarError(result.responseText, 'modalReception');
                },
                dataType: 'json'
            });
    }
  });

  $('#artIdRec').keyup(function(e){
    var code = e.which;
    if(code==13){
      e.preventDefault();
      BuscarCompleto();
    }
  });

  $('#artCantRec').keyup(function(e) {
  var code = e.which;
  if(code==13){
    if(parseFloat($('#artCantRec').val()) > 0){
      $('#btnAddProdRec').focus();
    }
  }
});

  var idSale = 0 ;
  function BuscarCompleto(){
     buscadorArticlesNoPrice($('#artIdRec').val(), $('#idRec'), $('#artIdRec'), $('#artCantRec'));
  }

  function delete_(id){
    $('#'+id).remove();
    //Calcular();
    $('#artIdRec').focus();
  }

</script>
