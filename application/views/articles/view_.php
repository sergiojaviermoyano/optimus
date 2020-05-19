
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="errorArt" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
          <p>Revise que todos los campos esten completos<br></p>

      </div>
	</div>
</div>
  <div class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-4">Código <strong style="color: #dd4b39">*</strong>:  </label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="artBarCode" value="<?php echo $data['article']['artBarCode'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4">Descripción <strong style="color: #dd4b39">*</strong>:   </label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="artDescription" value="<?php echo $data['article']['artDescription'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4"> Precio Costo <strong style="color: #dd4b39">*</strong>:   </label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="artCoste" value="<?php echo $data['article']['artCoste'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
      </div>
			<?php if ($data['read'] == 'X'){ ?> <!--//if ($data['read'] == 'false'){ ?>-->
			<div class="col-sm-1" style="display:none;">
				<button class="btn btn-block btn-warning" style="width:50px; padding: 5px 0px;" onclick="sumar(21)">21%</button>
			</div>
			<div class="col-sm-1" style="display:none;">
				<button class="btn btn-block btn-success" style="width:50px; padding: 5px 0px;" onclick="sumar(10.5)">10.5%</button>
			</div>
		  <?php } ?>
			<label class="col-sm-2" style="display:none;"> Es Dolar <strong style="color: #dd4b39">*</strong>: </label>
			<div class="col-sm-1" style="display:none;">
            <input type="checkbox" id="artCosteIsDolar" style="margin-top:10px;" <?php echo($data['article']['artCosteIsDolar'] == true ? 'checked': ''); ?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >

      </div>
    </div>


    <div class="form-group" style="display:none;">
      <label class="col-sm-4"> Margen Mayorista  <strong style="color: #dd4b39">*</strong>:   </label>
      <div class="col-sm-2">
           <input type="text" class="form-control" id="artMarginMayorista" value="<?php echo $data['article']['artMarginMayorista'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
      </div>
      <label class="col-sm-4"> Es Porcentaje <strong style="color: #dd4b39">*</strong>: </label>
      <div class="col-sm-2">
            <input type="checkbox" id="artMarginMayoristaIsPorcent" style="margin-top:10px;" <?php echo($data['article']['artMarginMayoristaIsPorcent'] == true ? 'checked': ''); ?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >

      </div>
    </div>

		<div class="form-group">
			<label class="col-sm-4"> Margen  <strong style="color: #dd4b39">*</strong>:   </label>
			<div class="col-sm-2">
					 <input type="text" class="form-control" id="artMarginMinorista" value="<?php echo $data['article']['artMarginMinorista'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
			</div>
			<label class="col-sm-4"> Es Porcentaje <strong style="color: #dd4b39">*</strong>: </label>
			<div class="col-sm-2">
						<input type="checkbox" id="artMarginMinoristaIsPorcent" style="margin-top:10px;" <?php echo($data['article']['artMarginMinoristaIsPorcent'] == true ? 'checked': ''); ?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >

			</div>
		</div>

    <div class="form-group">
			<!--<label class="col-sm-4" style="display:none;"> Cotización Dolar</label>-->
      <label class="col-sm-4"> Precio Venta:  </label>
      <!-- <label class="col-sm-4"> $ <strong id="pventaMinorista" style="color: green; font-size: 20px;">0.00</strong> </label> -->
			<!--<label class="col-sm-4" style="display:none;"> Precio Venta Mayorista:  </label>-->
      <label class="col-sm-1"> $</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="pventaMinorista" value="" style="color: green; font-size: 20px; font-weight: bold;">
      </div>
    </div>

		<div class="form-group" style="display:none;">
			<div class="col-sm-4" >
        <input type="text" id="cotizacionDolar" class="form-control has-success" value="<?php echo $data['cotizacionDolar'];?>" disabled="disabled">
      </div>
			<div class="col-sm-4">
        <!--<strong id="pventaMinorista" style="color: green">0.00</strong>-->
      </div>
      <div class="col-sm-4" style="display:none;">
        <strong id="pventaMayorista">0.00</strong>
      </div>
    </div>

		<div class="form-group">
				 <label class="col-sm-4"> Marca <strong style="color: #dd4b39">*</strong></label>
				<div class="col-sm-5">
					<select class="form-control" name="marcaId" id="marcaId" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
						<option value="">Seleccionar Marca</option>
						<?php foreach ($marcas as $key => $item):?>
							<option value="<?php echo $item['id'];?>" <?php echo ($data['article']['marcaId']==$item['id'])?'selected':''?> ><?php echo $item['descripcion'];?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
    <div class="form-group">
         <label class="col-sm-4"> Rubro <strong style="color: #dd4b39">*</strong></label>
        <div class="col-sm-5">
          <select class="form-control" name="subrId" id="rubId" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
            <option value="">Seleccionar Rubro</option>
            <?php foreach ($rubros as $key => $item):?>
              <option value="<?php echo $item['rubId'];?>" <?php echo ($data['article']['rubId']==$item['rubId'])?'selected':''?> ><?php echo $item['rubDescripcion'];?></option>
            <?php endforeach;?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4"> Mínimo</label>
        <div class="col-sm-5">
          <input type="" class="form-control" id="artMinimo" name="artMinimo" value="<?php echo $data['article']['artMinimo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
        </div>
      </div>

      <div class="form-group">
      <label class="col-sm-4">Estado:   </label>
      <div class="col-sm-5">
        <select class="form-control" id="artEstado"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php
                  echo '<option value="AC" '.($data['article']['artEstado'] == 'AC' ? 'selected' : '').'>Activo</option>';
                  echo '<option value="IN" '.($data['article']['artEstado'] == 'IN' ? 'selected' : '').'>Inactivo</option>';
                  echo '<option value="SU" '.($data['article']['artEstado'] == 'SU' ? 'selected' : '').'>Suspendido</option>';
              ?>
            </select>
      </div>
    </div>


  </div>




<script>

$('#artMarginMinorista').keyup(function(){
  CalcularPrecio();
});
$('#artMarginMayorista').keyup(function(){
  CalcularPrecio();
});
$('#artMarginMayoristaIsPorcent').click(function() {
  CalcularPrecio();
});
$('#artMarginMinoristaIsPorcent').click(function() {
  CalcularPrecio();
});
$('#artCoste').keyup(function(){
  CalcularPrecio();
});
$('#artCosteIsDolar').click(function() {
  CalcularPrecio();
});
$('#pventaMinorista').keyup(function(){
  CalcularMargen();
});

function CalcularMargen(){
  var precioCosto         = $('#artCoste').val() == '' ? 0 : parseFloat($('#artCoste').val()).toFixed(2);
  var margenMi      			= $('#artMarginMinorista').val() == '' ? 0 : parseFloat($('#artMarginMinorista').val()).toFixed(2);
  var margenMiEsPor 			= $('#artMarginMinoristaIsPorcent').is(':checked');
  var precioVenta         = $('#pventaMinorista').val();

  if(precioCosto == 0){
    $('#artCoste').val(precioVenta);
  } else {
    var margen = 0;
    margen = precioVenta - precioCosto;
    if(margenMiEsPor){
      margen = (margen * 100) /  precioCosto;
    }
    $('#artMarginMinorista').val(margen.toFixed(2));
  }
}


function CalcularPrecio(){
  var precioCosto 				= $('#artCoste').val() == '' ? 0 : parseFloat($('#artCoste').val()).toFixed(2);
	var precioCostoEsDolar 	= $('#artCosteIsDolar').is(':checked');
	var cotizacionDolar 		= $('#cotizacionDolar').val();
  var margenMi      			= $('#artMarginMinorista').val() == '' ? 0 : parseFloat($('#artMarginMinorista').val()).toFixed(2);
  var margenMiEsPor 			= $('#artMarginMinoristaIsPorcent').is(':checked');
	var margenMa      			= $('#artMarginMayorista').val() == '' ? 0 : parseFloat($('#artMarginMayorista').val()).toFixed(2);
	var margenMaEsPor 			= $('#artMarginMayoristaIsPorcent').is(':checked');




  var pventaMinorista = 0;
	var pventaMayorista = 0;
	//Precio en Dolar
	if(precioCostoEsDolar){
		var precioCosto = precioCosto * cotizacionDolar;
	}
	//Minorista
  if(margenMiEsPor){
    var importe = (parseFloat(margenMi) / 100) * parseFloat(precioCosto);
    pventaMinorista = parseFloat(parseFloat(importe) + parseFloat(precioCosto)).toFixed(2);
  } else {
    pventaMinorista = parseFloat(parseFloat(precioCosto) + parseFloat(margenMi)).toFixed(2);
  }

	//Mayorista
	if(margenMaEsPor){
    var importe = (parseFloat(margenMa) / 100) * parseFloat(precioCosto);
    pventaMayorista = parseFloat(parseFloat(importe) + parseFloat(precioCosto)).toFixed(2);
  } else {
    pventaMayorista = parseFloat(parseFloat(precioCosto) + parseFloat(margenMa)).toFixed(2);
  }

	$('#pventaMinorista').val(pventaMinorista);
  $('#pventaMayorista').html(pventaMayorista);
}


$('#artBarCode').focusout(function() {
		if($('#artBarCode').val() != ""){
			WaitingOpen('Validando Código');
	    	$.ajax({
	          	type: 'POST',
	          	data: {
	                    id :      idArt,
	                    act:      acArt,
	                    code:     $('#artBarCode').val()
	                  },
	    		url: 'index.php/article/validateArticle',
	    		success: function(result){
	                			WaitingClose();
	                			if(result == false){
													//Esta registrado
													$("#errorArt").find("p").html('El código ingresado ya fue cargado');
										    	$('#errorArt').fadeIn('slow');
										      setTimeout("$('#errorArt').fadeOut('slow');",2000);
												}
	    					},
	    		error: function(result){
	    					WaitingClose();
	              ProcesarError(result.responseText, 'modalArticle');
	    				},
	          	dataType: 'json'
	    		});
		}
});

function sumar(porcent){
	porcent = parseFloat(porcent);
	var precioCosto = $('#artCoste').val() == '' ? 0 : parseFloat($('#artCoste').val()).toFixed(2);
	if(precioCosto > 0){
		var importe = (parseFloat(porcent) / 100) * parseFloat(precioCosto);
    importe = parseFloat(parseFloat(importe) + parseFloat(precioCosto)).toFixed(2);
		$('#artCoste').val(parseFloat(importe).toFixed(2));
		CalcularPrecio();
	}

}
</script>
