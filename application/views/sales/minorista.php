<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #00a65a"><strong>Nueva Venta <i class="fa fa-fw fa-cart-plus"></i></strong></h3>
          <i class="fa fa-fw fa-close text-red pull-right" onclick="cargarView('dash', 'accesosdirectos', '')" style="cursor: pointer"></i>
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
		        			<select class="form-control" id="lpId">
						      <?php foreach ($lists as $key => $item):?>
						        <option value="<?php echo $item['lpId'];?>" data-porcent="<?php echo $item['lpMargen'];?>" <?php echo $item['lpDefault'] == true ?'selected':''?> ><?php echo $item['lpDescripcion'];?> </option>
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
  						      <input type="number" id="cliSearch" class="form-control" >
  		        		</div>
                  <div class="col-xs-1">
                    <i class="fa fa-fw fa-search text-teal" style="margin-top: 12px; cursor: pointer;" id="buscador"></i>
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
                  <select class="form-control select2" id="venId">
                    <option id="-1" selected></option>
						      <?php foreach ($vendedores as $key => $item):?>
						        <option value="<?php echo $item['id'];?>"><?php echo $item['codigo'].' - '.$item['nombre'];?> </option>
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
                    <!-- <button type="button" class="btn btn-warning" style="float: left" id="btnServicePresupuesto">Presupuesto</button>
                    <button type="button" class="btn btn-primary" id="btnServiceEfectivo">Efectivo</button> -->
                    <button type="button" class="btn btn-success" id="btnServiceBuy">Cobrar</button>
                  </div>
              </div>
            </div>
        	</div>
        	<!-- Buscador -->
        	<div class="row">
        		<div class="col-xs-12">
        			<div class="box box-default box-solid">
			            <div class="box-header with-border">
			              <h3 class="box-title">Buscador de Artículos</h3>
			              <!-- /.box-tools -->
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body" id="divBuscador">
			            	<div class="row">
				                <div class="col-xs-1">
				                   <button class="btn btn-block btn-warning" id="btnManualArt"><i class="fa fa-fw fa-hand-paper-o"></i></button>
				                </div>
				                <div class="col-xs-1" style="margin-top: 7px; text-align: right;">
				                    <label>Producto</label>
				                </div>
				                <div class="col-xs-5">
				                    <input type="hidden" class="form-control" id="prodId">
				                    <input type="text" class="form-control" id="lblProducto">
				                </div>
				                <div class="col-xs-2">
				                    <input type="number" class="form-control" placeholder="Cantidad" id="prodCant" value="1">
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
$("#artMprecio").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
$("#artMcantidad").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
//$("#prodCant").maskMoney({allowNegative: false, thousands:'', decimal:','});
$(".select2").select2();

setTimeout("$('#venId').select2('open');",800);
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

$('#btnManualArt').click(function(){
  LoadIconAction('modalActionManual','Add');
  $('#artMdescripcion').val('');
  $('#artMprecio').val('');
  $('#artMcantidad').val('');
  $('#modalArtManual').modal('show');
  setTimeout("$('#artMdescripcion').focus();",800);
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
  setTimeout("$('#lblProducto').focus();",800);
  Calcular();
  $('#modalArtManual').modal('hide');
});

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
   buscadorArticlesPrice($('#lblProducto').val(), $('#prodId'), $('#lblProducto'), $('#prodCant'), $('#prodPrecio'));
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
          url: 'index.php/article/getArticleJson',
          success: function(result){
                        pVenta = calcularPrecioInterno(result.article).toFixed(2);
                        html = '<tr id="'+rowY+'">';
                        html+= '<td style="text-align: center; cursor: pointer;" onclick="delete_('+rowY+')"><i class="fa fa-fw fa-close" style="color: #dd4b39"></i></td>';
                        html+= '<td>'+result.article.artBarCode+'</td>';
                        html+= '<td>'+result.article.artDescription+'</td>';
                        debugger;
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
  if($('#venId').val() == 0 || $('#venId').val() == undefined || $('#venId').val() == -1)
    return false;
  var importeVenta = parseFloat($('#totalSale').html());
  if(importeVenta > 0){
    cobrarMedios(null, importeVenta);
  }
});

/****************************** Fin Cobrar Venta ******************************/

  $(function(){
    $('#lpId').on('change',function(){
      //debugger;
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

  $('#buscador').click(function(){
    buscadorClientes($('#lblNombre'),$('#lblDocumento'), $('#cliId'));
  });

  //Buscador de cliente
  function BuscarCliente(){
    if($('#cliSearch').val()) {
      //Buscar datos por dni
      WaitingOpen('Buscando Cliente');
      $.ajax({
            type: 'POST',
            data: { dni : $('#cliSearch').val() },
        url: 'index.php/customer/findCustomer',
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
                        setTimeout("$('#venId').select2('open');",800);
                      }
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalCli');
            },
            dataType: 'json'
        });
    }
}

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

// $('#btnServicePresupuesto').click(function(){
//   Cobrar_(1);
// });
</script>
