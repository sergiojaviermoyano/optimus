<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Vendedores</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadVendedor(0,\'Add\')" id="btnAdd" >Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="vendedores" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if($list != '')
                foreach($list as $l)
                {
                    echo '<tr>';
                    echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
                      echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadVendedor('.$l['id'].',\'Edit\')"></i>';
                    }
                    if (strpos($permission,'Del') !== false) {
                      echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadVendedor('.$l['id'].',\'Del\')"></i>';
                    }
                    if (strpos($permission,'View') !== false) {
                      echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadVendedor('.$l['id'].',\'View\')"></i>';
                    }
                    echo '</td>';
                    echo '<td style="text-align: right">'.$l['codigo'].'</td>';
                    echo '<td style="text-align: left">'.$l['nombre'].'</td>';
                    echo '<td style="text-align: center">';
                    switch($l['estado']){
                      case 'AC':
                        echo '<small class="label pull-left bg-green">Activo</small>';
                        break;

                      case 'IN':
                        echo '<small class="label pull-left bg-red">Inactivo</small>';
                        break;
                    }
                    echo '</td>';
                    echo '</tr>';
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
    $('#vendedores').DataTable({
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

  var idLista = 0;
  var acLista = '';

  function LoadVendedor(id_, action){
    idLista = id_;
    acLista = action;
    LoadIconAction('modalAction',action);
    WaitingOpen('Cargando vendedor');
      $.ajax({
            type: 'POST',
            data: { id : id_, act: action },
        url: 'index.php/vendedor/getVendedor',
        success: function(result){
                      WaitingClose();
                      $("#modalBodyVendedor").html(result.html);
                      setTimeout("$('#modalVendedor').modal('show')",800);
                      //$("[data-mask]").inputmask();
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalVendedor');
            },
            dataType: 'json'
        });
  }

  $('#btnSave').click(function(){
    if(acLista == 'View')
    {
      $('#modalVendedor').modal('hide');
      return;
    }

    var hayError = false;

    if($('#codigo').val() == '')
    {
      hayError = true;
    }

    if($('#nombre').val() == '')
    {
      hayError = true;
    }

    if(hayError == true){
      $('#error').fadeIn('slow');
      return;
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
      $.ajax({
            type: 'POST',
            data: {
                    id :      idLista,
                    act:      acLista,
                    code:     $('#codigo').val(),
                    name:     $('#nombre').val(),
                    status:   $('#estado').val()
                  },
        url: 'index.php/vendedor/setVendedor',
        success: function(result){
                      WaitingClose();
                      $('#modalVendedor').modal('hide');
                      setTimeout("cargarView('vendedor', 'index', '"+$('#permission').val()+"');",1000);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalVendedor');
            },
            dataType: 'json'
        });
  });
</script>


<!-- Modal -->
<div class="modal fade" id="modalVendedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Vendedor</h4>
      </div>
      <div class="modal-body" id="modalBodyVendedor">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Aceptar</button>
      </div>
    </div>
  </div>
</div>
