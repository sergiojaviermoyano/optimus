<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Artículos</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadArt(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="articles" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th width="10%">Stock</th>
                <th width="1%">Mi</th>
                <th width="5%">Código</th>
                <th>Descripción</th>
                <th width="5%">Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($list)) {
                  if(count($list) > 0)
                	foreach($list as $a)
      		        {
  	                echo '<tr>';
  	                echo '<td>';
                    /*
                    if (strpos($permission,'Edit') !== false) {
  	                	echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadArt('.$a['artId'].',\'Edit\')"></i>';
                    }
                    if (strpos($permission,'Del') !== false) {
  	                	echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadArt('.$a['artId'].',\'Del\')"></i>';
                    }*/
                    if (strpos($permission,'View') !== false) {
  	                	echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadArt('.$a['artId'].',\'View\')"></i>';
                    }
                    echo '</td>';
                    echo '<td>';
                    switch($a['ordenN']){
                      case 1:
                        echo '<i class="fa fa-fw fa-circle" style="color: #f56954"></i>';
                        break;
                      case 2:
                        echo '<i class="fa fa-fw fa-circle" style="color: #f39c12"></i>';
                        break;
                      case 3:
                        echo '<i class="fa fa-fw fa-circle" style="color: #00a65a"></i>';
                        break;
                      case 4:
                        echo '<i class="fa fa-fw fa-circle" style="color: #00a65a"></i>';//00c0ef
                        break;
                    }
                    echo '</td>';
                    echo '<td>'.$a['stock'].'</td>';
                    echo '<td>'.$a['artMinimo'].'</td>';
                    echo '<td style="text-align: center">'.$a['artBarCode'].'</td>';
  	                echo '<td style="text-align: left">'.$a['artDescription'].'</td>';
                    echo '<td style="text-align: center">'.($a['artEstado'] == 'AC' ? '<small class="label pull-left bg-green">Activo</small>' : ($a['artEstado'] == 'IN' ? '<small class="label pull-left bg-red">Inactivo</small>' : '<small class="label pull-left bg-yellow">Suspendido</small>')).'</td>';
  	                echo '</tr>';

      		        }

                }
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>
  $(function () {
    //$("#groups").DataTable();
    $('#articles').DataTable({
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
        }
    });
  });

  var idArt = 0;
  var acArt = '';

  function LoadArt(id_, action){
  	idArt = id_;
  	acArt = action;
  	LoadIconAction('modalAction',action);
  	WaitingOpen('Cargando Artículo');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/article/getArticle',
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyArticle").html(result.html);
                      $("#artCoste").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artMargin").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artCantidad").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      CalcularPrecio();
			                setTimeout("$('#modalArticle').modal('show')",800);
                      //$("[data-mask]").inputmask();
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalArticle');
    				},
          	dataType: 'json'
    		});
  }


  $('#btnSave').click(function(){

  	if(acArt == 'View')
  	{
  		$('#modalArticle').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#artBarCode').val() == '')
    {
      hayError = true;
    }

    if($('#artDescription').val() == '')
    {
      hayError = true;
    }

    if($('#artCoste').val() == '')
    {
      hayError = true;
    }

    if(hayError == true){
    	$('#error').fadeIn('slow');
    	return;
    }

    var detail = [];
    if($('#artTipo').val() == 'C'){
      $('#articles_ > tbody > tr').each(function() {
        var id = $(this).attr('id');
        var artId = parseInt($('#' + id +' td:nth-child(5)').html());
        var cantId = parseFloat($('#' + id +' td:nth-child(4)').html()).toFixed(2);

        var obj = [artId , cantId];
        detail.push(obj);
      });
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    	$.ajax({
          	type: 'POST',
          	data: {
                    id :      idArt,
                    act:      acArt,
                    code:     $('#artBarCode').val(),
                    pcode:    $('#artProvCode').val(),
                    name:     $('#artDescription').val(),
                    marcId:   $('#marcId').val(),
                    subr:     $('#subrId').val(),
                    status:   $('#artEstado').val(),
                    marg:     $('#artMargin').val(),
                    margP:    $('#artMarginIsPorcent').prop('checked'),
                    price:    $('#artCoste').val(),
                    max:      $('#artMaximo').val(),
                    med:      $('#artMedio').val(),
                    min:      $('#artMinimo').val(),
                    arttipe:  $('#artTipo').val(),
                    det:      detail
                  },
    		url: 'index.php/article/setArticle',
    		success: function(result){
                			WaitingClose();
                			$('#modalArticle').modal('hide');
                			setTimeout("cargarView('Article', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
              ProcesarError(result.responseText, 'modalArticle');
    				},
          	dataType: 'json'
    		});
  });

</script>

<!-- Modal -->
<div class="modal fade" id="modalArticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Artículo</h4>
      </div>
      <div class="modal-body" id="modalBodyArticle">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>
