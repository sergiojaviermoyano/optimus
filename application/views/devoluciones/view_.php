<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        <p>Revise que todos los campos esten completos</p>
      </div>
	</div>
</div>

<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Orden: </label>
    </div>
	<div class="col-xs-4">
      <input type="number" class="form-control" id="oId" value="<?php echo $data['devolucion']['oId'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
    </div>
    <div class="col-xs-6">
        <button type="button" class="btn btn-success" id="btnBuscar" onclick="buscarOrden()" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>><i class="fa fa-fw fa-search"></i>Buscar</button>
    </div>
</div><hr>

<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Cliente: </label>
    </div>
	<div class="col-xs-6">
    <label style="margin-top: 7px;" id="cliente"> <?php echo $data['devolucion']['cliNombre'].' '.$data['devolucion']['cliApellido'];?></label>
    </div>
    <div class="col-xs-2">
      <label style="margin-top: 7px;">Fecha: </label>
    </div>
	<div class="col-xs-2">
    <label style="margin-top: 7px;" id="fecha"> <?php echo $data['devolucion']['fecha'];?></label>
    </div>
</div><br>
<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Observación: </label>
    </div>
	<div class="col-xs-10">
        <input type="text" class="form-control" id="devObservacion" value="<?php echo $data['devolucion']['devObservacion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
    </div>
</div><hr>

<div class="row">
    <div class="col-xs-12">
        <table id="devolucionesDet" class="table table-bordered table-hover">
            <thead>
              <tr >
                <th style="width:70%">Artículo</th>
                <th>Cantidad</th>
                <th>Devolución</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($data['devolucion']['detalle'] as $d){
                        echo '<tr>';
                        echo '<td>'.$d['artDescripcion'].'</td>';
                        echo '<td style="text-align: center">-</td>';
                        echo '<td style="text-align: right">'.$d['devdCant'].'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
var idOrden = 0;
function buscarOrden(){
    if($('#oId').val() == ''){
        return;
    }
    var orden = $('#oId').val();
    $('#devolucionesDet > tbody').html(''); 
    WaitingOpen('Buscando orden ...');
    $.ajax({
        type: 'POST',
        data: { 
                id :      orden
                },
    url: 'index.php/devolucion/getOrden', 
    success: function(result){
                    WaitingClose();
                    if(result.length == 0){
                        $("#error").find("p").html('No se encontro la orden ingresada o ya se realizo una devolución sobre la misma.');
                        $('#error').fadeIn('slow');
                        setTimeout("$('#error').fadeOut('slow');",2500);
                        idOrden = 0;
                        $('#cliente').html('');
                        $('#fecha').html('');
                    } else {
                        idOrden = orden;
                        debugger;
                        $('#cliente').html(result.order['cliNombre']+' '+result.order['cliApellido']);
                        $('#fecha').html(result.order['fecha']);
                        $.each(result.detalle,function(index,item){
                             var html = '';
                             html += '<tr><td>'+item.artDescripcion+'</td>';
                             html += '<td style="text-align: right">'+item.artCant+'</td>';
                             html += '<td ><input class="form-control" style="text-align: right" type="number" min="0" max="'+parseFloat(item.artCant)+'" value="0"></td>';
                             html += '<td style="display: none">'+item.artId+'</td></tr>';
                             $('#devolucionesDet > tbody').append(html); 
                        });
                    }
            },
    error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalBrand');
        },
        dataType: 'json'
    });
}
</script>
