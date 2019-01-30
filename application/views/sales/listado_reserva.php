<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Ventas Reservas</h3>
          <?php
          /*
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadCust(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          */
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="customers" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="15%">Acciones</th>
                <th>Nº Orden</th>
                <th>Pagos</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->


<?php //include("print_order_modal.php")?>
<script>
  $(function () {
    //$("#groups").DataTable();
    $('#customers').DataTable({
        'processing':true,
        'serverSide':true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "language": {
                "lengthMenu": "Ver _MENU_ filas por página",
                "zeroRecords": "No hay registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrando de un total de _MAX_ registros)",
                "sSearch": "Buscar:  ",
                "oPaginate": {
                    "sNext": "Sig.",
                    "sPrevious": "Ant."
                }
        },
        'columns':[
            {className:'text-center'},
            null,
            {className:'text-right'},
            {className:'text-right'},
            {className:'text-center'},
            {className:'text-center'},
        ],
        ajax:{
            'dataType': 'json',
            'method': 'POST',
            'url':'index.php/sale/datatable_reserva',
            'dataSrc': function(response){
                console.log(response);
                console.log(response.data);
                var output = [];
                var permission = $("#permission").val();
                $.each(response.data,function(index,item){
                    var col1,col2,colpago,coltotal,col3,col4, col5='';
                    col1='';
                    col1+='<i class="fa fa-fw fa-print"  style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" data-id="'+item.oId+'"></i>';
                    col1+='<i class="fa fa-fw fa-sticky-note-o" style="color: #00a65a; cursor: pointer; margin-left: 15px;" data-id="'+item.oId+'"></i>';
                    if(item.oEstado != 'FA')
                    col1+='<i class="fa fa-fw fa-plus"   style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="pagando('+item.oId+', '+parseFloat(item.pago).toFixed(2)+', '+parseFloat(item.total).toFixed(2)+')"></i>';

                    col2=item.oId;
                    colpago = '<a href="#" onclick="consultarPagos('+item.oId+', '+parseFloat(item.pago).toFixed(2)+', '+parseFloat(item.total).toFixed(2)+')">' + parseFloat(item.pago).toFixed(2) +'</a>';
                    coltotal = parseFloat(item.total).toFixed(2);
                    col3=item.fecha;
                    switch(item.oEstado){
                        case 'AC':{
                            col4='<small class="label pull-left bg-green">Activa</small>';
                            break;
                        }
                        case 'IN':{
                            col4='<small class="label pull-left bg-red">Inactiva</small>';
                            break;
                        }
                        case 'FA':{
                            col4='<small class="label pull-left bg-blue">Facturada</small>';
                            break;
                        }
                        default:{
                            col4='';
                            break;
                        }
                    }
                    col5= (item.oEsPresupuesto==1)?'<small class="label pull-left bg-navy" style="font-size:14px; margin-right:5px;" title="Presupuesto">P</small>':' ';
                    output.push([col1,col2,colpago,coltotal,col3,col4,col5]);
                });
                return output;
            },
            error: function(error){
                console.debug(error);
            }
        }
        /*,
        "createdRow": function ( row, data, index ) {
            if(data[4].search("small")>0){
              $(row).addClass('info');
            }
        }*/
    });
  });

  function consultarPagos(id, pagos, total){
    WaitingOpen('Cargando Pagos');
    $('#footerModal').html('');
    $('#pagos').html('$ ' + (pagos == '' ? '0.00' : parseFloat(pagos).toFixed(2)));
    $('#total').html('$ ' + (total == '' ? '0.00' : parseFloat(total).toFixed(2)));
    $('#saldo').html('$ ' + parseFloat(total - pagos).toFixed(2));
      $.ajax({
            type: 'POST',
            data: { id : id },
        url: 'index.php/box/getPagosOrden',
        success: function(result){
                      $.each(result,function(index,item){
                        var html = '<hr>';
                            html+= '<div class="row">';
                            html+=  '<div class="col-xs-2">Importe:</div><div class="col-xs-2"><b>$'+item.rcbImporte+'</b></div>';
                            html+=  '<div class="col-xs-1">Fecha:</div><div class="col-xs-3"><b>'+item.rcbFecha+'</b></div>';
                            html+=  '<div class="col-xs-2">Medio:</div><div class="col-xs-2"><b>'+item.medDescripcion+'</b><br></div>';
                            html+= '</div>';
                            $('#footerModal').append(html);
                      });
                      WaitingClose();
                      setTimeout("$('#modalHistorial').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalHistorial');
            },
            dataType: 'json'
        });
  }

  var oId = 0;
  function pagando(id, pagos, total){
    oId = id;
    //Clean medios
    $('#efectivo').val('');$('#efectivo').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#visa').val('');$('#visa').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#mastercard').val('');$('#mastercard').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#nevada').val('');$('#nevada').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#data').val('');$('#data').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#cuentacorriente').val('');$('#cuentacorriente').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    //$('#creditoargentino').val('');$('#creditoargentino').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    //$('#descuento').val('');$('#descuento').maskMoney({allowNegative: false, thousands:'.', decimal:','});
    $('#totalSaleMedios').html(parseFloat(total - pagos).toFixed(2));
    $('#modalMedios').modal('show');
    CalcularMediosDePago();
	  setTimeout("$('#efectivo').focus()",1000);
  }

  function SumarPagos(){
    var efectivo = parseFloat($('#efectivo').val() == '' ? 0 : ($('#efectivo').val().replace('.','')).replace(',','.'));
    var visa = parseFloat($('#visa').val() == '' ? 0 : ($('#visa').val().replace('.','')).replace(',','.'));
    var mastercard = parseFloat($('#mastercard').val() == '' ? 0 : ($('#mastercard').val().replace('.','')).replace(',','.'));
    var nevada = parseFloat($('#nevada').val() == '' ? 0 : ($('#nevada').val().replace('.','')).replace(',','.'));
    var data = parseFloat($('#data').val() == '' ? 0 : ($('#data').val().replace('.','')).replace(',','.'));
    //var cuentacorriente = parseFloat($('#cuentacorriente').val() == '' ? 0 : ($('#cuentacorriente').val().replace('.','')).replace(',','.'));
    //var creditoargentino = parseFloat($('#creditoargentino').val() == '' ? 0 : ($('#creditoargentino').val().replace('.','')).replace(',','.'));

    $('#totalPagosMedios').html(parseFloat(efectivo + visa + mastercard + nevada + data /*+ cuentacorriente + creditoargentino*/).toFixed(2));
  }

  function CalcularMediosDePago(){
    SumarPagos();
    var total = parseFloat($('#totalSaleMedios').html());
    var pagos = parseFloat($('#totalPagosMedios').html());
    //var descuento = parseFloat($('#descuento').val() == '' ? 0 : ($('#descuento').val().replace('.','')).replace(',','.'));

    $('#totalSaldoMedios').html(parseFloat(parseFloat(total) - parseFloat(pagos) /*- parseFloat(descuento)*/).toFixed(2));
    if(parseFloat(total - pagos) < 0 || pagos == 0 ){
      $('#btnPago').prop("disabled", true);
    } else {
      $('#btnPago').prop("disabled", false);
    }
  }

  $('.calcula').keyup(function() {
    CalcularMediosDePago();
  });

  $('#btnPago').click(function(){
    var total = parseFloat($('#totalSaleMedios').html());
    var pagos = parseFloat($('#totalPagosMedios').html());
    var saldo = total - pagos;
    //Medios de Pago-----------------------------------------
    var medios = [];
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
      /*
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
      */

    WaitingOpen('Guardando pago');
      $.ajax({
            type: 'POST',
            data: {
                    medi:     medios,
                    oId:      oId,
                    saldo:    saldo
                  },
        url: 'index.php/sale/setSalePago',
        success: function(result){
                      WaitingClose();
                      $('#modalMedios').modal('hide');
                      setTimeout("cargarView('sale', 'listado_reserva', '"+$('#permission').val()+"');",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalMedios');
            },
            dataType: 'json'
        });
  });

</script>

<!-- Modal Cliente -->
<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span> <i class="fa fa-fw fa-search" style="color: #3c8dbc"></i> Consultar</span> Pagos</h4>
      </div>
      <div class="modal-body" id="modalBodyHistorial">
        <div class="row">
          <div class="col-xs-4">Pagos</div>
          <div class="col-xs-4">Total</div>
          <div class="col-xs-4">Saldo</div>
        </div>
        <div class="row">
          <div class="col-xs-4"><h3 id="pagos" class="text-green"></h3></div>
          <div class="col-xs-4"><h3 id="total" class="text-light-blue"></h3></div>
          <div class="col-xs-4"><h3 id="saldo" class="text-red"></h3></div>
        </div>
        <div id="footerModal">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
            <!--
            <tr>
              <td style="width:60%; text-align: right;">Cuenta Corriente</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="cuentacorriente" value="" ></td>
            </tr>
            -->
            <!-- Credito Argentino -->
            <!--
            <tr>
              <td style="width:60%; text-align: right;">Crédito Argentino</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="creditoargentino" value="" ></td>
            </tr>
            -->
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
            <!--
            <tr>
              <td style="width:60%; text-align: right;">Descuento (-)</td>
              <td style="width:1%; padding-left:5px; padding-right:5px;">$</td>
              <td><input type="text" class="form-control calcula" id="descuento" value="" ></td>
            </tr>
            -->
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
