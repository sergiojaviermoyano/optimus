<input type="hidden" id="oId" value="<?php echo $order['order']['oId'];?>"
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f39c12"><strong>Cobrar Presupuesto Mayorista <i class="fa fa-fw fa-truck"></i></strong></h3>
          <i id="closex" class="fa fa-fw fa-close text-red pull-right" onclick="cargarView('dash', 'accesosdirectos', '')" style="cursor: pointer"></i>
        </div><!-- /.box-header -->
        <div class="box-body">
        	<div class="row">
        		<!-- Lista de Precios y Cliente -->
        		<div class="col-xs-6">
        			<!-- Listas de Precios -->
        			<div class="row">
        				<div class="col-xs-4">
	        				<label style="margin-top: 7px">Lista de Precios</label>
		        		</div>
		        		<div class="col-xs-8">
		        			<select class="form-control" id="lpId" disabled>
						      <?php foreach ($lists as $key => $item):?>
						        <option value="<?php echo $item['lpId'];?>" data-porcent="<?php echo $item['lpMargen'];?>" <?php echo $item['lpId'] == $order['order']['lpId'] ?'selected':''?> ><?php echo $item['lpDescripcion'];?> </option>
						      <?php endforeach;?>
						    </select>
		        		</div>
        			</div><br>
        			<!-- Cliente -->
              <div class="box box-default box-solid" style="padding: 5px;">
          			<div class="row">
          				<div class="col-xs-4">
  	        				<label style="margin-top: 7px">Cliente</label>
  		        		</div>
  		        		<div class="col-xs-4">
  						      <input type="number" id="cliSearch" class="form-control" readonly>
  		        		</div>
                  <div class="col-xs-1">
                    <i class="fa fa-fw fa-search text-teal" style="margin-top: 12px"></i>
                  </div>
          			</div>
                <div class="row">
          				<div class="col-xs-4">
  	        				<label style="margin-top: 7px">Nombre y DNI: </label>
  		        		</div>
  		        		<div class="col-xs-6">
  						      <label style="margin-top: 7px;" class="text-maroon" id="lblNombre"><?php echo $final['cliNombre'].' '.$final['cliApellido'];?> </label>
  		        		</div>
                  <div class="col-xs-2">
  	        				<label style="margin-top: 7px" id="lblDocumento"><?php echo $final['cliDocumento'];?> </label>
  		        		</div>
          			</div>
                <input type="hidden" id="cliId" value="<?php echo $final['cliId'];?>">
              </div>
              <!-- Vendedor -->
              <div class="row">
        				<div class="col-xs-4">
	        				<label style="margin-top: 7px">Vendedor</label>
		        		</div>
		        		<div class="col-xs-8">
                  <select class="form-control select2" id="venId" disabled>
                    <option id="-1" selected></option>
						      <?php foreach ($vendedores as $key => $item):?>
						        <option value="<?php echo $item['id'];?>" <?php echo $item['id'] == $order['order']['venId'] ?'selected':''?>><?php echo $item['codigo'].' - '.$item['nombre'];?> </option>
						      <?php endforeach;?>
						    </select>
		        		</div>
        			</div> <br>
	        	</div>
            <!-- Total Venta -->
            <div class="col-xs-6">
              <div class="box box-success box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Total $:</h3>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="text-align: center">
                    <strong class="text-green"><h1 id="totalSale">0,00</h1></strong>
                  </div>
                  <div style="text-align: right; padding: 5px;">
                    <!--<button type="button" class="btn btn-warning" style="float: left" id="btnServicePresupuesto">Presupuesto</button>-->
                    <button type="button" class="btn btn-primary" id="btnServiceEfectivo">Efectivo</button>
                    <button type="button" class="btn btn-success" id="btnServiceBuy">Cobrar</button>
                  </div>
              </div>
            </div>
        	</div>
        	<!-- Buscador -->
          <!--
        	<div class="row">
        		<div class="col-xs-12">
        			<div class="box box-default box-solid">
			            <div class="box-header with-border">
			              <h3 class="box-title">Buscador de Artículos</h3>
			            </div>
			            <div class="box-body">
			            	<div class="row">
				                <div class="col-xs-1">
				                   <!--<button class="btn btn-block btn-warning" id="btnManualArt"><i class="fa fa-fw fa-hand-paper-o"></i></button>-->
                           <!--
				                </div>
				                <div class="col-xs-1" style="margin-top: 7px; text-align: right;">
				                    <label>Producto</label>
				                </div>
				                <div class="col-xs-5">
				                    <input type="hidden" class="form-control" id="prodId">
				                    <input type="text" class="form-control" id="lblProducto">
				                </div>
				                <div class="col-xs-2">
				                    <input type="text" class="form-control" placeholder="Cantidad" id="prodCant" value="1">
				                </div>
                        <div class="col-xs-2">
				                    <label style="margin-top: 7px" id="prodPrecio" class="pull-right">$0,00 </label>
				                </div>
				                <div class="col-xs-1">
				                  <button class="btn btn-block btn-success" id="btnAddArticles">  <i class="fa fa-fw fa-check"></i></button>
				                </div>
				            </div>
			            </div>
			        </div>
        		</div>
        	</div>
          -->
        	<!-- Detalle y Total -->
        	<div class="row">
        		<div class="col-xs-12">
        			<div class="box box-warning box-solid">
			            <div class="box-header with-border">
			              <h3 class="box-title">Detalle</h3>
			              <!-- /.box-tools -->
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
			            	<table class="table table-bordered table-hover" id="detailSale">
			            		<thead>
				            		<tr>
				            			<th style="width: 5%"></th>
				            			<th style="width: 10%">Código</th>
				            			<th>Descripción</th>
				            			<th style="width: 5%; text-align: center;">Cantidad</th>
				            			<th style="width: 10%; text-align: center;">Precio</th>
				            			<th style="width: 15%; text-align: center;">Total</th>
				            		</tr>
				            	</thead>
				            	<tbody>
                        <?php
                        //var_dump($order['detalle']);
                        foreach ($order['detalle'] as $item) {
                          echo '<tr>';
                          echo '<td></td>';
                          echo '<td>'.$item['artBarCode'].'</td>';
                          echo '<td>'.$item['artDescripcion'].'</td>';
                          echo '<td style="text-align: right">'.number_format($item['artCant'],2).'</td>';
                          echo '<td style="text-align: right">'.number_format($item['artVenta'],2).'</td>';
                          echo '<td style="text-align: right">'.number_format($item['artVenta'] * $item['artCant'], 2).'</td>';
                          echo '<td style="display: none">'.$item['artId'].'</td>';
                          echo '<td style="display: none">'.$item['artCosto'].'</td>';
                          echo '<td style="display: none">1</td>';
                          echo '<td style="display: none">'.$item['artVentaSD'].'</td>';
                          echo '</tr>';
                        }
                        ?>
								      </tbody>
			            	</table>
			            </div>
			        </div>
        		</div>
        	</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalArtManual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalActionManual"> </span> Artículo Manual</h4>
      </div>
      <div class="modal-body" id="modalBodyArtManual">
        <div class="box-body">
          <div class="row">
            <div class="col-xs-12">
              <div class="alert alert-danger alert-dismissable" id="errorManual" style="display: none">
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    Revise que todos los campos esten completos
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <label style="margin-top: 7px;">Artículo <strong style="color: #dd4b39">*</strong>: </label>
            </div>
            <div class="col-xs-8">
              <input type="text" class="form-control" maxlength="100" id="artMdescripcion" value="" >
            </div>
          </div><br>
          <div class="row">
            <div class="col-xs-3">
              <label style="margin-top: 7px;">Precio <strong style="color: #dd4b39">*</strong>: </label>
            </div>
            <div class="col-xs-8">
              <input type="text" class="form-control" id="artMprecio" value="" >
            </div>
          </div><br>
          <div class="row">
            <div class="col-xs-3">
              <label style="margin-top: 7px;">Cantidad <strong style="color: #dd4b39">*</strong>: </label>
            </div>
            <div class="col-xs-8">
              <input type="text" class="form-control" id="artMcantidad" value="" >
            </div>
          </div><br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnAddManualArt">Agregar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Medios de Pago -->
<div class="modal fade" id="modalMedios" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span> <i class="fa fa-fw fa-money" style="color: #00a65a;"> </i> </span> Medios de Pago</h4>
      </div>
      <div class="modal-body" id="modalBodyMedios">
          <table style="width:100%; border-collapse:separate; border-spacing:0 5px;">
            <!-- Efectivo -->
            <tr>
              <td style="width:60%; text-align: right;">Efectivo</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="efectivo" value="" ></td>
            </tr>
            <!-- Visa -->
            <tr>
              <td style="width:60%; text-align: right;">Visa</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="visa" value="" ></td>
            </tr>
            <!-- MasterCard -->
            <tr>
              <td style="width:60%; text-align: right;">MasterCard</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="mastercard" value="" ></td>
            </tr>
            <!-- Nevada -->
            <tr>
              <td style="width:60%; text-align: right;">Nevada</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="nevada" value="" ></td>
            </tr>
            <!-- Data -->
            <tr>
              <td style="width:60%; text-align: right;">Data</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="data" value="" ></td>
            </tr>
            <!-- Cuenta Corriente -->
            <tr>
              <td style="width:60%; text-align: right;">Cuenta Corriente</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="cuentacorriente" value="" ></td>
            </tr>
            <!-- Credito Argentino -->
            <tr>
              <td style="width:60%; text-align: right;">Crédito Argentino</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="creditoargentino" value="" ></td>
            </tr>
          </table>
          <hr>
          <table style="width:100%; ">
            <!-- Total -->
            <tr>
              <td style="width:60%; text-align: right; padding-top: 7px;">Total</td>
              <td style="width:1%; padding-left:5px; padding-right:5px; padding-top: 7px;">$</td>
              <td style="text-align: right;"><strong class="text-green"><h1 style="margin-top:1px; margin-buttom: 1px;" id="totalSaleMedios">0,00</h1></strong></td>
            </tr>
            <!-- Sus Pagos -->
            <tr>
              <td style="width:60%; text-align: right; padding-top: 7px;">Sus Pagos (-)</td>
              <td style="width:1%; padding-left:5px; padding-right:5px; padding-top: 7px;">$</td>
              <td style="text-align: right;"><strong class="text-blue"><h1 style="margin-top:1px; margin-buttom: 1px;" id="totalPagosMedios">0,00</h1></strong></td>
            </tr>
            <!-- Descuento -->
            <tr>
              <td style="width:60%; text-align: right;">Descuento (-)</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="descuento" value="" ></td>
            </tr>
            <!-- Saldo -->
            <tr>
              <td style="width:60%; text-align: right; padding-top: 7px;">Saldo</td>
              <td style="width:1%; padding-left:5px; padding-right:5px; padding-top: 7px;">$</td>
              <td style="text-align: right;"><strong class="text-red"><h1 style="margin-top:1px; margin-buttom: 1px;" id="totalSaldoMedios">0,00</h1></strong></td>
            </tr>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnPago">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cliente -->
<div class="modal fade" id="modalCli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelCli"><span id="modalActionCli"> </span> Cliente</h4>
      </div>
      <div class="modal-body" id="modalBodyCli">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSaveCustomer">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<script>
//$("#artMprecio").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
//$("#artMcantidad").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
$("#prodCant").maskMoney({allowNegative: false, thousands:'', decimal:','});
$(".select2").select2();

//setTimeout("$('#venId').select2('open');",800);
$('#venId').on("select2:select", function(e) {
   $('#lblProducto').focus();
});

Calcular();

function Calcular(){
	var table = $('#detailSale > tbody> tr');
	var total = 0;
	table.each(function(r) {
	  total += parseFloat(this.children[5].textContent);
	});

	$('#totalSale').html(parseFloat(total).toFixed(2));
}

var rowY = 8000;
var pagos = [];
/*
$('#btnManualArt').click(function(){
  LoadIconAction('modalActionManual','Add');
  $('#artMdescripcion').val('');
  $('#artMprecio').val('');
  $('#artMcantidad').val('');
  $('#modalArtManual').modal('show');
});

$('#btnAddManualArt').click(function(){
  var pVenta = parseFloat($('#artMprecio').val()).toFixed(2);
  html = '<tr id="'+rowY+'">';
  html+= '<td style="text-align: center; cursor: pointer;" onclick="delete_('+rowY+')"><i class="fa fa-fw fa-close" style="color: #dd4b39"></i></td>';
  html+= '<td>-</td>';
  html+= '<td>'+$('#artMdescripcion').val()+'</td>';
  html+= '<td style="text-align: right">'+$('#artMcantidad').val()+'</td>';
  html+= '<td style="text-align: right">'+parseFloat(pVenta).toFixed(2)+'</td>';
  html+= '<td style="text-align: right">'+parseFloat(pVenta * $('#artMcantidad').val()).toFixed(2)+'</td>';
  html+= '<td style="display: none">-</td>';
  html+= '<td style="display: none">'+pVenta+'</td>';
  html+= '<td style="display: none">0</td>';
  html+= '<td style="display: none">'+pVenta+'</td>';
  html+= '</tr>';
  rowY++;
  $('#detailSale > tbody').prepend(html);
  $('#lblProducto').focus();
  Calcular();
  $('#modalArtManual').modal('hide');
});
*/
function delete_(id){
  $('#'+id).remove();
  Calcular();
  $('#lblProducto').focus();
}

$('#lblProducto').keyup(function(e){
  var code = e.which;
  if(code==13){
    e.preventDefault();
    if($('#lblProducto').val() != ''){
      $('#lblProducto').prop('disabled', true);
      BuscarCompleto();
    }
  }
});

function BuscarCompleto(){
   buscadorArticlesPriceMayorista($('#lblProducto').val(), $('#prodId'), $('#lblProducto'), $('#prodCant'), $('#prodPrecio'));
}

$('#prodCant').keyup(function(e) {
  var code = e.which;
  if(code==13){
    if(parseFloat($('#prodCant').val()) > 0){
      $('#btnAddArticles').focus();
    }
  }
});

$('#btnAddArticles').click(function(){
  AgregaraOrden();
});

function AgregaraOrden(){
    if(
    $('#prodId').val() != '' &&
    parseFloat($('#prodCant').val()) > 0
    ) {
    WaitingOpen('Agregando producto');
    $.ajax({
          type: 'POST',
          data: {
                  id : $('#prodId').val()
                },
          url: 'index.php/article/getArticleJsonMayorista',
          success: function(result){
                        pVenta = calcularPrecioInternoMayorista(result.article).toFixed(2);
                        html = '<tr id="'+rowY+'">';
                        html+= '<td style="text-align: center; cursor: pointer;" onclick="delete_('+rowY+')"><i class="fa fa-fw fa-close" style="color: #dd4b39"></i></td>';
                        html+= '<td>'+result.article.artBarCode+'</td>';
                        html+= '<td>'+result.article.artDescription+'</td>';
                        html+= '<td style="text-align: right">'+parseFloat($('#prodCant').val()).toFixed(2)+'</td>';
                        html+= '<td style="text-align: right">'+pVenta+'</td>';
                        html+= '<td style="text-align: right">'+parseFloat(pVenta * parseFloat($('#prodCant').val())).toFixed(2)+'</td>';
                        html+= '<td style="display: none">'+result.article.artId+'</td>';
                        html+= '<td style="display: none">'+(result.article.artCosteIsDolar == "1" ? result.article.artCoste * result.article.dolar : result.article.artCoste)+'</td>';
                        html+= '<td style="display: none">1</td>';
                        html+= '<td style="display: none">'+pVenta+'</td>';
                        html+= '</tr>';
                        rowY++;
                        $('#detailSale > tbody').prepend(html);
                        $('#prodId').val('');
                        $('#prodCant').val('1');
                        $('#lblProducto').val('');
                        $('#lblProducto').focus();
                        Calcular();
                        WaitingClose();
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalNo');
              },
              dataType: 'json'
          });
  }
}

/********************************* Cobrar Venta *******************************/
$('#btnServiceBuy').click(function(){
  var importeVenta = parseFloat($('#totalSale').html());
  if(importeVenta > 0){
    //Clean medios
    $('#efectivo').val('');$('#efectivo').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#visa').val('');$('#visa').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#mastercard').val('');$('#mastercard').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#nevada').val('');$('#nevada').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#data').val('');$('#data').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#cuentacorriente').val('');$('#cuentacorriente').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#creditoargentino').val('');$('#creditoargentino').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#descuento').val('');$('#descuento').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#totalSaleMedios').html(importeVenta.toFixed(2));
    $('#modalMedios').modal('show');
    CalcularMediosDePago();
	  setTimeout("$('#efectivo').focus()",1000);
  }
});

function SumarPagos(){
  var efectivo = parseFloat($('#efectivo').val() == '' ? 0 : ($('#efectivo').val().replace('.','')).replace(',','.'));
  var visa = parseFloat($('#visa').val() == '' ? 0 : ($('#visa').val().replace('.','')).replace(',','.'));
  var mastercard = parseFloat($('#mastercard').val() == '' ? 0 : ($('#mastercard').val().replace('.','')).replace(',','.'));
  var nevada = parseFloat($('#nevada').val() == '' ? 0 : ($('#nevada').val().replace('.','')).replace(',','.'));
  var data = parseFloat($('#data').val() == '' ? 0 : ($('#data').val().replace('.','')).replace(',','.'));
  var cuentacorriente = parseFloat($('#cuentacorriente').val() == '' ? 0 : ($('#cuentacorriente').val().replace('.','')).replace(',','.'));
  var creditoargentino = parseFloat($('#creditoargentino').val() == '' ? 0 : ($('#creditoargentino').val().replace('.','')).replace(',','.'));

  $('#totalPagosMedios').html(parseFloat(efectivo + visa + mastercard + nevada + data + cuentacorriente + creditoargentino).toFixed(2));
}

function CalcularMediosDePago(){
  SumarPagos();
  var total = parseFloat($('#totalSaleMedios').html());
  var pagos = parseFloat($('#totalPagosMedios').html());
  var descuento = parseFloat($('#descuento').val() == '' ? 0 : ($('#descuento').val().replace('.','')).replace(',','.'));

  $('#totalSaldoMedios').html(parseFloat(parseFloat(total) - parseFloat(pagos) - parseFloat(descuento)).toFixed(2));
  if(parseFloat(parseFloat(total - pagos).toFixed(2) - descuento) != 0){
    $('#btnPago').prop("disabled", true);
  } else {
    $('#btnPago').prop("disabled", false);
  }
}

$('.calcula').keyup(function() {
  CalcularMediosDePago();
});
/****************************** Fin Cobrar Venta ******************************/


/*

function addItem(medId, tmpId, tipo){
  //Buscar si ya esta el tmpId en el array y eliminar
  pagos = pagos.filter(function( obj ) {
    return obj.tmp !== tmpId;
  });

  if(medId == -1){
    //Medio multiple (tarjeta)
    if($('#'+tmpId+'_medId').val() == -1 || $('#'+tmpId+'_importe').val() == ''){
      alert('Completa el valor');
    }else{
      var object = {
        mId:      $('#'+tmpId+'_medId').val(),
        imp:      $('#'+tmpId+'_importe').val(),
        tmp:      tmpId,
        de1:      $('#'+tmpId+'_des1').val(),
        de2:      $('#'+tmpId+'_des2').val(),
        de3:      $('#'+tmpId+'_des3').val(),
      };
      pagos.push(object);
      var div = '#'+tmpId+'_load';
      $(div).hide();
    }
  } else {
    //Medio simple (efectivo / cta cte / etc)
    if($('#'+medId+'_importe').val() == ''){
      alert('Completa el valor');
    }else{
      var object = {
        mId:      medId,
        imp:      $('#'+medId+'_importe').val(),
        tmp:      tmpId,
        de1:      null,
        de2:      null,
        de3:      null
      };
      pagos.push(object);
      var div = '#'+tmpId+'_load';
      $(div).hide();
    }
  }
  CargarImportes();
}

function CargarImportes(){
  var pag = 0;
  $.each(pagos, function(index, result){
      $('#'+result.tmp+'_total').html(parseFloat(result.imp).toFixed(2));
      pag += parseFloat(result.imp);
  });

  $('#pagos_suma').html(parseFloat(pag).toFixed(2));
}

$('#btnPago').click(function(){
  var importeAPagar = parseFloat($('#totalSale').html().replace(',',''));
  var importePagado = parseFloat($('#pagos_suma').html());

  if(importeAPagar == importePagado){
    //Barrer articulos.-
    var table = $('#detailSale > tbody> tr');
    var detalle = [];
    table.each(function(r) {
      var object = {
        artId:          parseInt(this.children[6].textContent),
        srvdCant:       parseFloat(this.children[3].textContent),
        artDescripcion: this.children[2].textContent,
        artCosto:       parseFloat(this.children[7].textContent),
        artventa:       parseFloat(this.children[4].textContent),
        artProvCode:    this.children[1].textContent,
        actualizaStock: parseInt(this.children[8].textContent)
      };

      detalle.push(object);
    });
    //------------------
    WaitingOpen('Cobrando...');
    $.ajax({
          type: 'POST',
          data: {
                  id : -1,
                  pa : pagos,
                  dt : detalle,
                  cl : $('#cliId').val()
                },
      url: 'index.php/sale/setSale',
      success: function(result){
                    WaitingClose();
                    if(result == true){
                      $('#modalMedios').modal('hide');
                      setTimeout("cargarView('dash', 'accesosdirectos', '');",800);
                    } else {
                      alert('Error');
                    }
            },
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalMedios');
          },
          dataType: 'json'
      });
  }else{
    alert('el pago no es igual');
  }
});

$('#btnServiceEfectivo').click(function(){
  var importeVenta = parseFloat($('#totalSale').html());
  if(importeVenta > 0){
    //Barrer articulos.-
    var table = $('#detailSale > tbody> tr');
    var detalle = [];
    table.each(function(r) {
      var object = {
        artId:          parseInt(this.children[6].textContent),
        srvdCant:       parseFloat(this.children[3].textContent),
        artDescripcion: this.children[2].textContent,
        artCosto:       parseFloat(this.children[7].textContent),
        artventa:       parseFloat(this.children[4].textContent),
        artProvCode:    this.children[1].textContent,
        actualizaStock: parseInt(this.children[8].textContent)
      };

      detalle.push(object);
    });
    //------------------
    WaitingOpen('Cobrando...');
    $.ajax({
          type: 'POST',
          data: {
                  id : -1,
                  dt : detalle,
                  cl : $('#cliId').val(),
                  im : importeVenta
                },
      url: 'index.php/sale/setSaleEfectivo',
      success: function(result){
                    WaitingClose();
                    if(result == true){
                      setTimeout("cargarView('dash', 'accesosdirectos', '');",800);
                    } else {
                      alert('Error');
                    }
            },
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modal__');
          },
          dataType: 'json'
      });
  }else{

  }
});

*/
  $(function(){
    $('#lpId').on('change',function(){
      var selected = $('#lpId').find('option:selected');
      var margin = parseFloat(selected.data('porcent'));

      var table = $('#detailSale > tbody> tr');
      var detalle = [];
      table.each(function(r) {

          var srvdCant=       parseFloat(this.children[3].textContent);
          var artCosto=       parseFloat(this.children[7].textContent);
          var artventa=       parseFloat(this.children[9].textContent);
          //artventa:       parseFloat(this.children[4].textContent),
          if(margin > 0){
            artventa += artventa * (margin / 100);
          }

          if(margin <0){
            margin  *= -1;
            artventa -= artventa * (margin / 100);
          }

          this.children[4].textContent = parseFloat(artventa).toFixed(2);
          this.children[5].textContent = parseFloat(parseFloat(artventa).toFixed(2) * srvdCant).toFixed(2);
      });

      Calcular();
    });


    $("#lpId").trigger("change");

  });

  $('#cliSearch').keypress(function(e){
    var code = e.which;
      if(code==13){
        BuscarCliente();
      }
  });

  //Buscador de cliente
  function BuscarCliente(){
      //Buscar datos por dni
      WaitingOpen('Buscando Cliente');
      $.ajax({
            type: 'POST',
            data: { id : <?php echo $order['order']['cliId'];?> },
        url: 'index.php/customer/findCustomerId',
        success: function(result){
                      WaitingClose();
                      if(!result){
                        $('#lblNombre').html('-');
                        $('#lblDocumento').html('-');
                        $('#cliId').val(-1);
                        CargarModalNuevoCliente($('#cliSearch').val());
                      } else {
                        $('#lblNombre').html(result.cliente.cliApellido +  ' ' + result.cliente.cliNombre);
                        $('#lblDocumento').html(result.cliente.cliDocumento);
                        $('#cliId').val(result.cliente.cliId);
                        $('#cliSearch').val('');
                        //setTimeout("$('#venId').select2('open');",800);
                      }
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalCli');
            },
            dataType: 'json'
        });

  //setTimeout("$('#modalCli').modal('show');",1000);
  function CargarModalNuevoCliente(dni){
      LoadIconAction('modalActionCli','Add');
      WaitingOpen('Espere...');
      $.ajax({
            type: 'POST',
            data: {id : -1, act: 'Add'},
            url: 'index.php/customer/getCustomer',
            success: function(result){
                    WaitingClose();
                    $("#modalBodyCli").html(result.html);
                    setTimeout("$('#modalCli').modal('show');",800);
                    setTimeout("$('#cliDocumento').val('"+dni+"');", 1000);
                    setTimeout("$('#cliNombre').focus();", 2000);
                  },
            error: function(result){
                  WaitingClose();
                  ProcesarError(result.responseText, 'modalCli');
                },
                dataType: 'json'
        });
  }
}

$('#btnSaveCustomer').click(function(){

  var hayError = false;
  var error_message="";

  if($('#cliNombre').val() == '')
  {
    hayError = true;
    error_message += " * Por Favor, debe Ingresar un Nombre. <br> ";
  }

  if($('#cliApellido').val() == '')
  {
    hayError = true;
    error_message += " * Por Favor, debe Ingresar un Apellido. <br> ";
  }

  if($('#cliDocumento').val() == '')
  {
    hayError = true;
    error_message += " * Por Favor, debe Ingresar un Número de Documento. ";
  }

  if(hayError == true){
    $("#errorCust").find("p").html(error_message);
    $('#errorCust').fadeIn('slow');
    setTimeout("$('#errorCust').fadeOut('slow');",2000);
    return false;
  }

  WaitingOpen('Guardando cambios');
    $.ajax({
          type: 'POST',
          data: {
                  id : -1,
                  act: 'Add',
                  name: $('#cliNombre').val(),
                  lnam: $('#cliApellido').val(),
                  doc: $('#docId').val(),
                  dni: $('#cliDocumento').val(),
                  mail: $('#cliMail').val(),
                  dom: $('#cliDomicilio').val(),
                  tel: $('#cliTelefono').val(),
                  est: $('#cliEstado').val()
                },
      url: 'index.php/customer/setCustomer',
      success: function(result){
                    $('#modalCli').modal('hide');
                    $('#cliSearch').val($('#cliDocumento').val());
                    BuscarCliente();
            },
      error: function(result){
            WaitingClose();
            alert("error");
          },
          dataType: 'json'
      });
});

$('#btnServicePresupuesto').click(function(){
  Cobrar_(1);
});

$('#btnPago').click(function(){
  Cobrar_(0);
});

$('#btnServiceEfectivo').click(function(){
  $('#efectivo').val($('#totalSale').html().replace('.',','));
  Cobrar_(0);
});

function Cobrar_(esPresupuesto){
  //Barrer Informacion
  //Id de la operación
  var opId = $('#oId').val();
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
      artId:          (this.children[6].textContent == '' ? '-' : parseInt(this.children[6].textContent)),
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
    var med;
    //Efectivo
    if($('#efectivo').val() != ''){
      med = {
        id: 1,
        imp: parseFloat(($('#efectivo').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //Visa
    if($('#visa').val() != ''){
      med = {
        id: 2,
        imp: parseFloat(($('#visa').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //MasterCard
    if($('#mastercard').val() != ''){
      med = {
        id: 3,
        imp: parseFloat(($('#mastercard').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //Nevada
    if($('#nevada').val() != ''){
      med = {
        id: 4,
        imp: parseFloat(($('#nevada').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //Data
    if($('#data').val() != ''){
      med = {
        id: 5,
        imp: parseFloat(($('#data').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //CuentaCorriente
    if($('#cuentacorriente').val() != ''){
      med = {
        id: 7,
        imp: parseFloat(($('#cuentacorriente').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //CreditoArgentino
    if($('#creditoargentino').val() != ''){
      med = {
        id: 6,
        imp: parseFloat(($('#creditoargentino').val().replace('.','')).replace(',','.'))
      };
      medios.push(med);
    }
    //Descuento--------------------------------------------
    var desc = parseFloat($('#descuento').val() == '' ? 0 : ($('#descuento').val().replace('.','')).replace(',','.'));
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
                  medi:     medios,
                  des:      desc,
                  det:      detalle,
                  esPre:    esPresupuesto,
                  oId:      opId
                },
      url: 'index.php/sale/setSaleMayorista',
      success: function(result){
                    WaitingClose();
                    $('#modalMedios').modal('hide');
                    setTimeout("cargarView('sale', 'mayorista', '');",800);
            },
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalNo');
          },
          dataType: 'json'
      });
};
BuscarCliente();
Calcular();
</script>
